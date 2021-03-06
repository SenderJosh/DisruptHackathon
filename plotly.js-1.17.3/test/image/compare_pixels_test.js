var fs = require('fs');

var common = require('../../tasks/util/common');
var getMockList = require('./assets/get_mock_list');
var getRequestOpts = require('./assets/get_image_request_options');
var getImagePaths = require('./assets/get_image_paths');

// packages inside the image server docker
var test = require('tape');
var request = require('request');
var gm = require('gm');

// pixel comparison tolerance
var TOLERANCE = 1e-6;

// wait time between each test batch
var BATCH_WAIT = 500;

// number of tests in each test batch
var BATCH_SIZE = 5;

// wait time between each test in test queue
var QUEUE_WAIT = 10;

/**
 *  Image pixel comparison test script.
 *
 *  Called by `tasks/test_image.sh in `npm run test-image`.
 *
 *  CLI arguments:
 *
 *  1. 'pattern' : glob determining which mock(s) are to be tested
 *  2. --queue : if sent, the image will be run in queue instead of in batch.
 *      Makes the test run significantly longer, but is recommended on weak hardware.
 *
 *  Examples:
 *
 *  Run all tests in batch:
 *
 *      npm run test-image
 *
 *  Run the 'contour_nolines' test:
 *
 *      npm run test-image -- contour_nolines
 *
 *  Run all gl3d image test in queue:
 *
 *      npm run test-image -- gl3d_* --queue
 */

var pattern = process.argv[2];
var mockList = getMockList(pattern);
var isInQueue = (process.argv[3] === '--queue');

if(mockList.length === 0) {
    throw new Error('No mocks found with pattern ' + pattern);
}

// filter out untestable mocks if no pattern is specified
if(!pattern) {
    console.log('Filtering out untestable mocks\n');
    mockList = mockList.filter(untestableFilter);
}

// main
if(isInQueue) {
    runInQueue(mockList);
}
else {
    runInBatch(mockList);
}

/* Test cases:
 *
 * - font-wishlist
 * - all gl2d
 * - all mapbox
 *
 * don't behave consistently from run-to-run and/or
 * machine-to-machine; skip over them for now.
 *
 */
function untestableFilter(mockName) {
    return !(
        mockName === 'font-wishlist' ||
        mockName.indexOf('gl2d_') !== -1 ||
        mockName.indexOf('mapbox_') !== -1
    );
}

function runInBatch(mockList) {
    var running = 0;

    // remove mapbox mocks if circle ci

    test('testing mocks in batch', function(t) {
        t.plan(mockList.length);

        for(var i = 0; i < mockList.length; i++) {
            run(mockList[i], t);
        }
    });

    function run(mockName, t) {
        if(running >= BATCH_SIZE) {
            setTimeout(function() {
                run(mockName, t);
            }, BATCH_WAIT);
            return;
        }
        running++;

        // throttle the number of tests running concurrently

        comparePixels(mockName, function(isEqual, mockName) {
            running--;
            t.ok(isEqual, mockName + ' should be pixel perfect');
        });
    }
}

function runInQueue(mockList) {
    var index = 0;

    test('testing mocks in queue', function(t) {
        t.plan(mockList.length);

        run(mockList[index], t);
    });

    function run(mockName, t) {
        comparePixels(mockName, function(isEqual, mockName) {
            t.ok(isEqual, mockName + ' should be pixel perfect');

            index++;
            if(index < mockList.length) {
                setTimeout(function() {
                    run(mockList[index], t);
                }, QUEUE_WAIT);
            }
        });
    }
}

function comparePixels(mockName, cb) {
    var requestOpts = getRequestOpts({ mockName: mockName }),
        imagePaths = getImagePaths(mockName),
        saveImageStream = fs.createWriteStream(imagePaths.test);

    function checkImage() {

        // baseline image must be generated first
        if(!common.doesFileExist(imagePaths.baseline)) {
            var err = new Error('baseline image not found');
            return onEqualityCheck(err, false);
        }

        /*
         * N.B. The non-zero tolerance was added in
         * https://github.com/plotly/plotly.js/pull/243
         * where some legend mocks started generating different png outputs
         * on `npm run test-image` and `npm run test-image -- mock.json`.
         *
         * Note that the svg outputs for the problematic mocks were the same
         * and playing around with the batch size and timeout durations
         * did not seem to affect the results.
         *
         * With the above tolerance individual `npm run test-image` and
         * `npm run test-image -- mock.json` give the same result.
         *
         * Further investigation is needed.
         */

        var gmOpts = {
            file: imagePaths.diff,
            highlightColor: 'purple',
            tolerance: TOLERANCE
        };

        gm.compare(
            imagePaths.test,
            imagePaths.baseline,
            gmOpts,
            onEqualityCheck
        );
    }

    function onEqualityCheck(err, isEqual) {
        if(err) {
            common.touch(imagePaths.diff);
            return console.error(err, mockName);
        }
        if(isEqual) {
            fs.unlinkSync(imagePaths.diff);
        }

        cb(isEqual, mockName);
    }

    request(requestOpts)
        .pipe(saveImageStream)
        .on('close', checkImage);
}
