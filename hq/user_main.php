<?php
ob_start();
session_start();
require_once '../db_connect.php';

//Redirect if not login
if( !isset($_SESSION['user']) ) {
	header("Location: ../index.php");
	exit;
}

//List all user
$sql = "SELECT id, user_fullname, user_ic, user_access
FROM fbp_user 
WHERE active_status = '1'
ORDER BY user_fullname ASC";
$result = $conn->query($sql);
	
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
            <h1 class="page-header">Pengguna</h1>
            <?php 
            if (isset($_GET["success"])) {
                if($_GET["success"]==1){
                    echo '<div class="alert alert-info" align="center">
                    <strong>Berjaya!</strong> Pengguna baru telah ditambah.
                    </div>';
                }
				if($_GET["success"]==2){
                    echo '<div class="alert alert-info" align="center">
                    <strong>Berjaya!</strong> Pengguna berjaya dikemaskini.
                    </div>';
                }
            } else if (isset($_GET["fail"])) {
                if($_GET["fail"]>0){
                    echo '<div class="alert alert-danger" align="center">
                    <strong>Ralat!</strong> Maklumat pengguna telah gagal disimpan.
                    </div>';
                }
            }?>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Senarai Pengguna
                    <div class="btn-group pull-right">
                        <button type="button" class="btn btn-default btn-xs" onClick="location.href='user_new.php';">
                            <i class="fa fa-plus fa-fw"></i> Tambah Pengguna
                        </button>
                    </div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>Name Pengguna</th>
                                    <th>No MyKad</th>
                                    <th>Peringkat</th>
                                    <th>Butiran</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if ($result->num_rows > 0) {
						  		// output data of each row
								while($row = $result->fetch_assoc()) { 
									// list according to user access
									if($row["user_access"]==1){	 // Admin
										echo 
										'<tr class="odd gradeX">
											<td><p class="text-uppercase"">'.$row["user_fullname"].'</p></td>
											<td><p class="text-uppercase"">'.$row["user_ic"].'</p></td>
											<td>ADMIN</td>
											<td>
												<div class="tooltip-demo">
												<a href="user_detail.php?uid='.$row["id"].'">
												<button type="button" class="btn btn-info btn-circle"
												data-toggle="tooltip" data-placement="right" 
												title="Papar Butiran">
												<i class="fa fa-list"></i>
												</button></a>
												</div>
											</td>
										</tr>';
									}else if($row["user_access"]==2){	 // Region
										echo 
										'<tr class="odd gradeX">
											<td><p class="text-uppercase"">'.$row["user_fullname"].'</p></td>
											<td><p class="text-uppercase"">'.$row["user_ic"].'</p></td>
											<td>KAWASAN</td>
											<td>
												<div class="tooltip-demo">
												<a href="user_detail.php?uid='.$row["id"].'">
												<button type="button" class="btn btn-info btn-circle"
												data-toggle="tooltip" data-placement="right" 
												title="Papar Butiran">
												<i class="fa fa-list"></i>
												</button></a>
												</div>
											</td>
										</tr>';
									}else if($row["user_access"]==3){	 // Territory
										echo 
										'<tr class="odd gradeX">
											<td><p class="text-uppercase"">'.$row["user_fullname"].'</p></td>
											<td><p class="text-uppercase"">'.$row["user_ic"].'</p></td>
											<td>WILAYAH</td>
											<td>
												<div class="tooltip-demo">
												<a href="user_detail.php?uid='.$row["id"].'">
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
