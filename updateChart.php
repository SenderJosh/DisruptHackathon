<?php
include 'monthlySum.php';

/*
<label class="checkbox-inline"><input type="checkbox" name="cg">CG</input></label>
<label class="checkbox-inline"><input type="checkbox" name="cos">COS</input></label>
<label class="checkbox-inline"><input type="checkbox" name="dcgar">DCGAR</input></label>
<label class="checkbox-inline"><input type="checkbox" name="dcgn">DCGN</input></label>
<label class="checkbox-inline"><input type="checkbox" name="dcgng">DCGNG</input></label>
<label class="checkbox-inline"><input type="checkbox" name="dcgs">DCGS</input></label>
<label class="checkbox-inline"><input type="checkbox" name="g3">G3</input></label>
$cg = 1;
$cos = 0;
$dcgar = 0;
$dcgn = 0;
$dcgng = 0;
$dcgs = 0;
$g3 = 0;
*/

$cg = $_POST['cg'];
$cos = $_POST['cos'];
$dcgar = $_POST['dcgar'];
$dcgn = $_POST['dcgn'];
$dcgng = $_POST['dcgng'];
$dcgs = $_POST['dcgs'];
$g3 = $_POST['g3'];

$array = array('CG' => $cg, 'COS' => $cos, 'DCGAR' => $dcgar, 'DCGN' => $dcgn, 'DCGNG' => $dcgng, 'DCGS' => $dcgs, 'G3' => $g3);
$jan = $feb = $march = $april = $may = $june = $july = $aug = $sept = $oct = $nov = $dec = 0;
foreach($array as $key => $value)
{
	if($value == "true")
	{
		$jan += monthlySum("01", "2016", $key . ".json");
		$feb += monthlySum("02", "2016", $key . ".json");
		$march += monthlySum("03", "2016", $key . ".json");
		$april += monthlySum("04", "2016", $key . ".json");
		$may += monthlySum("05", "2016", $key . ".json");
		$june += monthlySum("06", "2016", $key . ".json");
		$july += monthlySum("07", "2016", $key . ".json");
		$aug += monthlySum("08", "2016", $key . ".json");
		$sept += monthlySum("09", "2016", $key . ".json");
		$oct += monthlySum("10", "2016", $key . ".json");
		$nov += monthlySum("11", "2016", $key . ".json");
		$dec += monthlySum("12", "2016", $key . ".json");
	}
}

echo json_encode(array($jan, $feb, $march, $april, $may, $june, $july, $aug, $sept, $oct, $nov, $dec));
?>