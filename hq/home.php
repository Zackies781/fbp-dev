<?php
ob_start();
session_start();
require_once '../db_connect.php';

//Redirect if not login
if( !isset($_SESSION['user']) ) {
	header("Location: ../index.php");
	exit;
}

//User Profile
$sql_user = "SELECT Id, user_fullname FROM fbp_user WHERE Id = '$_SESSION[user]' AND active_status = '1'";
$result_user = $conn->query($sql_user);
if ($result_user->num_rows > 0) {
	$row_user = $result_user->fetch_assoc();
}
$result_user->close();

//Draft
$sql_drafted = "SELECT Id FROM fbp_application WHERE application_status = 1 AND active_status = '1' AND drafted_id=0";
$result_drafted = $conn->query($sql_drafted);
$row_drafted = $result_drafted->num_rows;
$result_drafted->close();

//Requested
$sql_requested = "SELECT Id FROM fbp_application WHERE application_status = 2 AND active_status = '1'";
$result_requested = $conn->query($sql_requested);
$row_requested = $result_requested->num_rows;
$result_requested->close();

//Verified
$sql_verified = "SELECT Id FROM fbp_application WHERE application_status = 3 AND active_status = '1'";
$result_verified = $conn->query($sql_verified);
$row_verified = $result_verified->num_rows;
$result_verified->close();

//Etiqa
$sql_etiqa = "SELECT Id FROM fbp_application WHERE application_status = 4 AND active_status = '1'";
$result_etiqa = $conn->query($sql_etiqa);
$row_etiqa = $result_etiqa->num_rows;
$result_etiqa->close();

//FBP
$sql_fbp = "SELECT Id FROM fbp_application WHERE application_status = 5 AND active_status = '1'";
$result_fbp = $conn->query($sql_fbp);
$row_fbp = $result_fbp->num_rows;
$result_fbp->close();

//Rejected
$sql_rejected = "SELECT Id FROM fbp_application WHERE application_status = 0 AND active_status = '1'";
$result_rejected = $conn->query($sql_rejected);
$row_rejected = $result_rejected->num_rows;
$result_rejected->close();

//Completed
$sql_completed = "SELECT Id FROM fbp_application WHERE application_status = 6 AND active_status = '1'";
$result_completed = $conn->query($sql_completed);
$row_completed = $result_completed->num_rows;
$result_completed->close();

//All
$sql_all = "SELECT Id FROM fbp_application WHERE active_status = '1'";
$result_all = $conn->query($sql_all);
$row_all = $result_all->num_rows;
$result_all->close();

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
            <h1 class="page-header">Utama 
                <small> - <?php echo $row_user["user_fullname"];?></small>
            </h1>
            <?php 
            if (isset($_GET["success"])) {
                if($_GET["success"]==1){
                    echo '<div class="alert alert-info" align="center">
                    <strong>Berjaya!</strong> Permohonan telah disimpan.
                    </div>';
                }else if($_GET["success"]==2){
                    echo '<div class="alert alert-success" align="center">
                    <strong>Berjaya!</strong> Permohonan telah dikemaskini.
                    </div>';
                }else if($_GET["success"]==3){
                    echo '<div class="alert alert-success" align="center">
                    <strong>Berjaya!</strong> Permohonan telah dimohon.
                    </div>';
                }else if($_GET["success"]==4){
                    echo '<div class="alert alert-success" align="center">
                    <strong>Berjaya!</strong> Permohonan telah diterima.
                    </div>';
                }
                else if($_GET["success"]==5){
                    echo '<div class="alert alert-success" align="center">
                    <strong>Berjaya!</strong> Permohonan dalam process Etiqa.
                    </div>';
                }
				else if($_GET["success"]==6){
                    echo '<div class="alert alert-success" align="center">
                    <strong>Berjaya!</strong> Permohonan dalam process Felcra Bekalan.
                    </div>';
                }
                else if($_GET["success"]==7){
                    echo '<div class="alert alert-success" align="center">
                    <strong>Berjaya!</strong> Permohonan telah diselesaikan.
                    </div>';
                }
                else if($_GET["success"]==8){
                    echo '<div class="alert alert-success" align="center">
                    <strong>Berjaya!</strong> Permohonan telah dilepaskan semula kerana tidak lengkap.
                    </div>';
                }else if($_GET["success"]==9){
                    echo '<div class="alert alert-success" align="center">
                    <strong>Berjaya!</strong> Permohonan telah dihapuskan.
                    </div>';
                }
            } else if (isset($_GET["fail"])) {
                if($_GET["fail"]>0){
                    echo '<div class="alert alert-danger" align="center">
                    <strong>Ralat!</strong> Permohonan telah gagal disimpan.
                    </div>';
                }
            }?>
            <!-- -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
    	<!-- Drafted -->
        <div class="col-lg-4 col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-2">
                            <i class="fa fa-star fa-5x"></i>
                        </div>
                        <div class="col-xs-10 text-right">
                            <div class="huge"><?php echo $row_drafted; ?></div>
                            <div><h4>Deraf Permohonon</h4></div>
                        </div>
                    </div>
                </div>
                <a href="application_main.php?status=1">
                    <div class="panel-footer">
                        <span class="pull-left">Papar Butiran</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <!-- Requested -->
        <div class="col-lg-4 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-2">
                            <i class="fa fa-inbox fa-5x"></i>
                        </div>
                        <div class="col-xs-10 text-right">
                            <div class="huge"><?php echo $row_requested; ?></div>
                            <div><h4>Permohonon Baru</h4></div>
                        </div>
                    </div>
                </div>
                <a href="application_main.php?status=2">
                    <div class="panel-footer">
                        <span class="pull-left">Papar Butiran</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <!-- Verified -->
        <div class="col-lg-4 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-2">
                            <i class="fa fa-pencil fa-5x"></i>
                        </div>
                        <div class="col-xs-10 text-right">
                            <div class="huge"><?php echo $row_verified; ?></div>
                            <div><h4>Permohonan Diterima</h4></div>
                        </div>
                    </div>
                </div>
                <a href="application_main.php?status=3">
                    <div class="panel-footer">
                        <span class="pull-left">Papar Butiran</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <!-- Etiqa -->
        <div class="col-lg-4 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-2">
                            <i class="fa fa-send fa-5x"></i>
                        </div>
                        <div class="col-xs-10 text-right">
                            <div class="huge"><?php echo $row_etiqa; ?></div>
                            <div><h4>Proses Etiqa</h4></div>
                        </div>
                    </div>
                </div>
                <a href="application_main.php?status=4">
                    <div class="panel-footer">
                        <span class="pull-left">Papar Butiran</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <!-- FBP -->
        <div class="col-lg-4 col-md-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-2">
                            <i class="fa fa-support fa-5x"></i>
                        </div>
                        <div class="col-xs-10 text-right">
                            <div class="huge"><?php echo $row_fbp; ?></div>
                            <div><h4>Proses Felcra Bekalan</h4></div>
                        </div>
                    </div>
                </div>
                <a href="application_main.php?status=5">
                    <div class="panel-footer">
                        <span class="pull-left">Papar Butiran</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <!-- Rejected -->
         <div class="col-lg-4 col-md-6">
           	<div class="panel panel-red">
             	<div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-2">
                            <i class="fa fa-exclamation fa-5x"></i>
                        </div>
                        <div class="col-xs-10 text-right">
                            <div class="huge"><?php echo $row_rejected; ?></div>
                            <div><h4>Permohonan Tidak Lengkap</h4></div>
                        </div>
                    </div>
                </div>
                <a href="application_main.php?status=0">
                    <div class="panel-footer">
                        <span class="pull-left">Papar Butiran</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <!-- Completed -->
         <div class="col-lg-4 col-md-6">
           	<div class="panel panel-success">
             	<div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-2">
                            <i class="fa fa-suitcase fa-5x"></i>
                        </div>
                        <div class="col-xs-10 text-right">
                            <div class="huge"><?php echo $row_completed; ?></div>
                            <div><h4>Permohonan Selesai</h4></div>
                        </div>
                    </div>
                </div>
                <a href="application_main.php?status=6">
                    <div class="panel-footer">
                        <span class="pull-left">Papar Butiran</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <!-- Total -->
         <div class="col-lg-4 col-md-6">
           	<div class="panel panel-success">
             	<div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-2">
                            <i class="fa fa-suitcase fa-5x"></i>
                        </div>
                        <div class="col-xs-10 text-right">
                            <div class="huge"><?php echo $row_all; ?></div>
                            <div><h4>Jumlah Permohonan</h4></div>
                        </div>
                    </div>
                </div>
                <a href="application_main.php">
                    <div class="panel-footer">
                        <span class="pull-left">Papar Butiran</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <!-- end -->
    </div>
    <!-- /.row -->
  <div class="row">
      <div class="col-lg-12">
          <div class="panel panel-info">
              <div class="panel-heading" align="center">
                  <a target="_blank" href="/FBPKhairat/manual/Manual_Pengguna.pdf"><strong>Muat turun manual pengguna</strong> <i class="fa fa-file-pdf-o fa-1x"></i>  </a>
              </div>
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

	<!-- InstanceEndEditable -->

<!-- Custom Theme JavaScript -->
<script src="../dist/js/sb-admin-2.js"></script>
</body>
<!-- InstanceEnd --></html>
