<?php
ob_start();
session_start();
require_once '../db_connect.php';

//Redirect if not login
if( !isset($_SESSION['user']) ) {
	header("Location: ../index.php");
	exit;
}

if (isset($_GET["status"])) {
	if($_GET["status"]==1){ //Drafted
		$sql = "SELECT A.id, A.deceased_name, A.deceased_ic, A.application_status, R.name
		FROM fbp_application A LEFT JOIN fbp_region R ON A.region_id = R.id
		WHERE A.application_status = '1' AND A.active_status = '1' AND drafted_id='0'";
		$result = $conn->query($sql);
	}else if($_GET["status"]==2){ //Requested
		$sql = "SELECT A.id, A.deceased_name, A.deceased_ic, A.application_status, R.name
		FROM fbp_application A LEFT JOIN fbp_region R ON A.region_id = R.id
		WHERE A.application_status = '2' AND A.active_status = '1'";
		$result = $conn->query($sql);
	}else if($_GET["status"]==3){ //Verified
		$sql = "SELECT A.id, A.deceased_name, A.deceased_ic, A.application_status, R.name
		FROM fbp_application A LEFT JOIN fbp_region R ON A.region_id = R.id
		WHERE A.application_status = '3' AND A.active_status = '1'";
		$result = $conn->query($sql);
	}else if($_GET["status"]==4){ //Etiqa
		$sql = "SELECT A.id, A.deceased_name, A.deceased_ic, A.application_status, R.name
		FROM fbp_application A LEFT JOIN fbp_region R ON A.region_id = R.id
		WHERE A.application_status = '4' AND A.active_status = '1'";
		$result = $conn->query($sql);
	}else if($_GET["status"]==5){ //FBP
		$sql = "SELECT A.id, A.deceased_name, A.deceased_ic, A.application_status, R.name
		FROM fbp_application A LEFT JOIN fbp_region R ON A.region_id = R.id
		WHERE A.application_status = '5' AND A.active_status = '1'";
		$result = $conn->query($sql);
	}else if($_GET["status"]==6){ //Completed
		$sql = "SELECT A.id, A.deceased_name, A.deceased_ic, A.application_status, R.name
		FROM fbp_application A LEFT JOIN fbp_region R ON A.region_id = R.id
		WHERE A.application_status = '6' AND A.active_status = '1'";
		$result = $conn->query($sql);
	}else if($_GET["status"]==0){ //Rejected
		$sql = "SELECT A.id, A.deceased_name, A.deceased_ic, A.application_status, R.name
		FROM fbp_application A LEFT JOIN fbp_region R ON A.region_id = R.id
		WHERE A.application_status = '0' AND A.active_status = '1'";
		$result = $conn->query($sql);
	}
}else{
	$sql = "SELECT A.id, A.deceased_name, A.deceased_ic, A.application_status, R.name
	FROM fbp_application A LEFT JOIN fbp_region R ON A.region_id = R.id
	WHERE (A.application_status != '1' AND A.active_status = '1') 
	OR (A.application_status = '1' AND A.active_status = '1' AND drafted_id='0') 
	ORDER BY A.updated_date DESC";
	$result = $conn->query($sql);
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en"><!-- InstanceBegin template="/Templates/template_hq.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>

	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>FBP - Sistem Pengurusan Insurans Takaful Peserta</title>
    
    <!-- Bootstrap Datetime Picker CSS -->
    <link href="../datetimepicker/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="../datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    <!-- Custom Tab Icon -->
    <link rel="icon" href="../images/FECLRA.png">
    
    <!-- Custom Navbar -->
    <link href="../dist/css/custom.css" rel="stylesheet">
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

<!-- InstanceBeginEditable name="doctitle" -->
 <title>FBP - Sistem Pengurusan Insurans Takaful Peserta</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- DataTables CSS -->
<link href="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

<!-- DataTables Responsive CSS -->
<link href="../bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">
<!-- InstanceEndEditable -->
</head>

<body background="../images/crisp_paper_ruffles.png">
<div id="wrapper">
    <!-- Navigation -->
    <nav class="navbar navbar-custom navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">         
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="home.php">Sistem Pengurusan Insurans Takaful Peserta</a>
        </div>
        <!-- /.navbar-header -->
        
        <ul class="nav navbar-top-links navbar-right">
        	<li><a href="profile_main.php"><i class="fa fa-user fa-fw"></i> Profil Pengguna</a></li>
            <li><a href="../logout.php?logout"><i class="fa fa-sign-out fa-fw"></i> Log Keluar</a></li>
        </ul>
        <!-- /.navbar-top-links -->
    
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li>
                        <a href="home.php"><i class="fa fa-dashboard fa-fw"></i> Utama</a>
                    </li>
                    <li>
                        <a href="application_new.php"><i class="fa fa-file-text fa-fw"></i> Permohonan Baru</a>
                    </li>
                    <li>
                        <a href="application_main.php"><i class="fa fa-list-ul fa-fw"></i> Senarai Permohonan</a>
                    </li>
                    <li>
                        <a href="report_main.php"><i class="fa fa-bar-chart-o fa-fw"></i> Laporan</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-wrench fa-fw"></i> Tetapan<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="territory_main.php"><i class="fa fa-globe fa-fw"></i> Wilayah</a>
                            </li>
                            <li>
                                <a href="state_main.php"><i class="fa fa-globe fa-fw"></i> Negeri</a>
                            </li>
                            <li>
                                <a href="region_main.php"><i class="fa fa-globe fa-fw"></i> Kawasan</a>
                            </li>
                            <li>
                                <a href="project_main.php"><i class="fa fa-globe fa-fw"></i> Projek</a>
                            </li>
                            <li>
                                <a href="user_main.php"><i class="fa fa-users fa-fw"></i> Pengguna</a>                                
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>
    <!-- /.navbar -->
<!-- InstanceBeginEditable name="body" -->
<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Senarai Permohonan</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Senarai Permohonan Khairat Kematian
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Kawasan</th>
                                            <th>Nama Simati</th>
                                            <th>NO. K/P</th>
                                            <th>Status</th>
                                            <th>Butiran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if ($result->num_rows > 0) {
										// output data of each row
										while($row = $result->fetch_assoc()) { 
											// list according to application status
											if($row["application_status"]==1){	 // Drafted
												echo 
												'<tr class="odd gradeX">
													<td>'.$row["name"].'</td>
													<td><p class="text-uppercase"">'.$row["deceased_name"].'</p></td>
													<td>'.$row["deceased_ic"].'</td>
													<td>
														<div class="tooltip-demo">
														<button type="button" class="btn btn-default btn-circle"
														data-toggle="tooltip" data-placement="right" 
														title="Deraf Permohonan">
														<i class="fa fa-star"></i> 
														</button> Deraf
														</div>
													</td>
													<td>
														<div class="tooltip-demo">
														<a href="application_drafted.php?app='.$row["id"].'">
														<button type="button" class="btn btn-info btn-circle"
														data-toggle="tooltip" data-placement="right" 
														title="Papar Butiran">
														<i class="fa fa-list"></i>
														</button></a>
														</div>
													</td>
												</tr>';
											}else if($row["application_status"]==2){	//Requested
												echo 
												'<tr class="odd gradeX">
													<td>'.$row["name"].'</td>
													<td><p class="text-uppercase"">'.$row["deceased_name"].'</p></td>
													<td>'.$row["deceased_ic"].'</td>
													<td>
														<div class="tooltip-demo">
														<button type="button" class="btn btn-primary btn-circle"
														data-toggle="tooltip" data-placement="right" 
														title="Permohonan Baru">
														<i class="fa fa-inbox"></i> 
														</button> Baru
														</div>
													</td>
													<td>
														<div class="tooltip-demo">
														<a href="application_requested.php?app='.$row["id"].'">
														<button type="button" class="btn btn-info btn-circle"
														data-toggle="tooltip" data-placement="right" 
														title="Papar Butiran">
														<i class="fa fa-list"></i>
														</button></a>
														</div>
													</td>
												</tr>';
											}else if($row["application_status"]==3){	//Verified
												echo 
												'<tr class="odd gradeX">
													<td>'.$row["name"].'</td>
													<td><p class="text-uppercase"">'.$row["deceased_name"].'</p></td>
													<td>'.$row["deceased_ic"].'</td>
													<td>
														<div class="tooltip-demo">
														<button type="button" class="btn btn-success btn-circle"
														data-toggle="tooltip" data-placement="right" 
														title="Permohonan Diterima">
														<i class="fa fa-pencil"></i> 
														</button> Diterima
														</div>
													</td>
													<td>
														<div class="tooltip-demo">
														<a href="application_verified.php?app='.$row["id"].'">
														<button type="button" class="btn btn-info btn-circle"
														data-toggle="tooltip" data-placement="right" 
														title="Papar Butiran">
														<i class="fa fa-list"></i>
														</button></a>
														</div>
													</td>
												</tr>';
											}else if($row["application_status"]==4){	//Etiqa
												echo 
												'<tr class="odd gradeX">
													<td>'.$row["name"].'</td>
													<td><p class="text-uppercase"">'.$row["deceased_name"].'</p></td>
													<td>'.$row["deceased_ic"].'</td>
													<td>
														<div class="tooltip-demo">
														<button type="button" class="btn btn-warning btn-circle"
														data-toggle="tooltip" data-placement="right" 
														title="Proses Etiqa">
														<i class="fa fa-send"></i> 
														</button> Etiqa
														</div>
													</td>
													<td>
														<div class="tooltip-demo">
														<a href="application_etiqa.php?app='.$row["id"].'">
														<button type="button" class="btn btn-info btn-circle"
														data-toggle="tooltip" data-placement="right" 
														title="Papar Butiran">
														<i class="fa fa-list"></i>
														</button></a>
														</div>
													</td>
												</tr>';
											}else if($row["application_status"]==5){	//FBP
												echo 
												'<tr class="odd gradeX">
													<td>'.$row["name"].'</td>
													<td><p class="text-uppercase"">'.$row["deceased_name"].'</p></td>
													<td>'.$row["deceased_ic"].'</td>
													<td>
														<div class="tooltip-demo">
														<button type="button" class="btn btn-info btn-circle"
														data-toggle="tooltip" data-placement="right" 
														title="Proses Felcra Bekalan">
														<i class="fa fa-support"></i> 
														</button> FBP
														</div></td>
													<td>
														<div class="tooltip-demo">
														<a href="application_fbp.php?app='.$row["id"].'">
														<button type="button" class="btn btn-info btn-circle"
														data-toggle="tooltip" data-placement="right" 
														title="Papar Butiran">
														<i class="fa fa-list"></i>
														</button></a>
														</div>
													</td>
												</tr>';
											}else if($row["application_status"]==6){	//Completed
												echo 
												'<tr class="odd gradeX">
													<td>'.$row["name"].'</td>
													<td><p class="text-uppercase"">'.$row["deceased_name"].'</p></td>
													<td>'.$row["deceased_ic"].'</td>
													<td>
														<div class="tooltip-demo">
														<button type="button" class="btn btn-success btn-circle"
														data-toggle="tooltip" data-placement="right" 
														title="Permohonan Selesai">
														<i class="fa fa-check"></i> 
														</button> Selesai
														</div></td>
													<td>
														<div class="tooltip-demo">
														<a href="application_completed.php?app='.$row["id"].'">
														<button type="button" class="btn btn-info btn-circle"
														data-toggle="tooltip" data-placement="right" 
														title="Papar Butiran">
														<i class="fa fa-list"></i>
														</button></a>
														</div>
													</td>
												</tr>';
											}else if($row["application_status"]==0){	//Rejected
												echo 
												'<tr class="odd gradeX">
													<td>'.$row["name"].'</td>
													<td><p class="text-uppercase"">'.$row["deceased_name"].'</p></td>
													<td>'.$row["deceased_ic"].'</td>
													<td>
														<div class="tooltip-demo">
														<button type="button" class="btn btn-danger btn-circle"
														data-toggle="tooltip" data-placement="right" 
														title="Permohonan Tidak Lengkap">
														<i class="fa fa-exclamation"></i> 
														</button> Tidak Lengkap
														</div>
													</td>
													<td>
														<div class="tooltip-demo">
														<a href="application_rejected.php?app='.$row["id"].'">
														<button type="button" class="btn btn-info btn-circle"
														data-toggle="tooltip" data-placement="right" 
														title="Papar Butiran">
														<i class="fa fa-list"></i>
														</button></a>
														</div>
													</td>
												</tr>';
											}
									 	}	
									}?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
<!-- InstanceEndEditable -->
</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="../bower_components/jquery/dist/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

<!-- InstanceBeginEditable name="javascript" -->
    <!-- DataTables JavaScript -->
    <script src="../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
    
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
                responsive: true
        });
    });
    </script>
    
    <!-- Page-Level Demo Scripts - Notifications - Use for reference -->
    <script>
    // tooltip demo
    $('.tooltip-demo').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    })

    // popover demo
    $("[data-toggle=popover]")
        .popover()
    </script>
	<!-- InstanceEndEditable -->

<!-- Custom Theme JavaScript -->
<script src="../dist/js/sb-admin-2.js"></script>
</body>
<!-- InstanceEnd --></html>
