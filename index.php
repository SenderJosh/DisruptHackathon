<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sexy</title>
	
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body onload="sendToPHP();">


        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Sexy</a>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">
				<?php
					include 'monthlySum.php';
					
					$jan = $feb = $march = $april = $may = $june = $july = $aug = $sept = $oct = $nov = $dec = 0;
				?>
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Dashboard <small>Time Statistics</small>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->

                <div class="alert alert-info">
					<strong>Hours Busy</strong> by month
				</div>
				
				<form role="form" method="POST" action="updateChart.php" target="hiddenFrame" onsubmit="sendToPHP();">
					<div class="form-group">
						<label>Groups to include:</label>
						<p>
							<label class="checkbox-inline"><input type="checkbox" name="cg" id="cg" checked="false">CG</input></label>
							<label class="checkbox-inline"><input type="checkbox" name="cos" id="cos" checked="false">COS</input></label>
							<label class="checkbox-inline"><input type="checkbox" name="dcgar" id="dcgar" checked="false">DCGAR</input></label>
							<label class="checkbox-inline"><input type="checkbox" name="dcgn" id="dcgn" checked="false">DCGN</input></label>
							<label class="checkbox-inline"><input type="checkbox" name="dcgng" id="dcgng" checked="false">DCGNG</input></label>
							<label class="checkbox-inline"><input type="checkbox" name="dcgs" id="dcgs" checked="false">DCGS</input></label>
							<label class="checkbox-inline"><input type="checkbox" name="g3" id="g3" checked="false">G3</input></label>
							<label class="checkbox-inline"><button type="submit" class="btn btn-xs btn-success">Commit Changes</button></label>
						</p>
					</div>
				</form>
				
				<script type="text/javascript">
				function sendToPHP()
				{
					updateMonthSums(document.getElementById('cg').checked, document.getElementById('cos').checked, 
							document.getElementById('dcgar').checked,document.getElementById('dcgn').checked, document.getElementById('dcgng').checked,
							document.getElementById('dcgs').checked, document.getElementById('g3').checked);
				}
				
				function updateMonthSums(cg, cos, dcgar, dcgn, dcgng, dcgs, g3)
				{
					var xmlhttp = new XMLHttpRequest();
					var params = "cg=" + cg + "&cos=" + cos + "&dcgar=" + dcgar + "&dcgn=" + dcgn + "&dcgng=" + dcgng + "&dcgs=" + dcgs + "&g3=" + g3;
					xmlhttp.open("POST", "updateChart.php", true);
					
					xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					
					xmlhttp.onreadystatechange = function()
					{
						if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
						{
							var response = JSON.parse(xmlhttp.responseText);
							document.getElementById('jan').innerText = response[0];
							document.getElementById('feb').innerText = response[1];
							document.getElementById('march').innerText = response[2];
							document.getElementById('april').innerText = response[3];
							document.getElementById('may').innerText = response[4];
							document.getElementById('june').innerText = response[5];
							document.getElementById('july').innerText = response[6];
							document.getElementById('aug').innerText = response[7];
							document.getElementById('sept').innerText = response[8];
							document.getElementById('oct').innerText = response[9];
							document.getElementById('nov').innerText = response[10];
							document.getElementById('dec').innerText = response[11];
						}
					}
					xmlhttp.send(params);
				}
				</script>
				<iframe name="hiddenFrame" class="hide"></iframe>
                <!-- /.row -->
				<div class="row">
					<div class="col-lg-3 col-md-6">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<div class="row">
									
									<div class="col-xs-9 text-right">
										<div class="huge" id="jan"></div>
										<div>January</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<div class="row">
									
									<div class="col-xs-9 text-right">
										<div class="huge" id="feb"></div>
										<div>February</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<div class="row">
									
									<div class="col-xs-9 text-right">
										<div class="huge" id="march"></div>
										<div>March</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<div class="row">
									
									<div class="col-xs-9 text-right">
										<div class="huge" id="april"></div>
										<div>April</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<div class="row">
									
									<div class="col-xs-9 text-right">
										<div class="huge" id="may"></div>
										<div>May</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<div class="row">
									
									<div class="col-xs-9 text-right">
										<div class="huge" id="june"></div>
										<div>June</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<div class="row">
									
									<div class="col-xs-9 text-right">
										<div class="huge" id="july"></div>
										<div>July</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<div class="row">
									
									<div class="col-xs-9 text-right">
										<div class="huge" id="aug"></div>
										<div>August</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<div class="row">
									
									<div class="col-xs-9 text-right">
										<div class="huge" id="sept"></div>
										<div>September</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<div class="row">
									
									<div class="col-xs-9 text-right">
										<div class="huge" id="oct"></div>
										<div>October</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<div class="row">
									
									<div class="col-xs-9 text-right">
										<div class="huge" id="nov"></div>
										<div>November</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<div class="row">
									
									<div class="col-xs-9 text-right">
										<div class="huge" id="dec"></div>
										<div>December</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

				
                <!-- /.row -->
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>

</body>

</html>
