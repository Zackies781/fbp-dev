<?php
ob_start();
session_start();
require_once '../db_connect.php';

//Redirect if not login
if( !isset($_SESSION['user']) ) {
	header("Location: ../index.php");
	exit;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en"><!-- InstanceBegin template="/Templates/template_region.dwt.php" codeOutsideHTMLIsLocked="false" -->
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
                            <a href="application_main.php"><i class="fa fa fa-list-ul fa-fw"></i> Senarai Permohonan</a>
                        </li>
                        <li>
                            <a href="report_main.php"><i class="fa fa-bar-chart-o fa-fw"></i> Laporan</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

<!-- InstanceBeginEditable name="body" -->
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
        	<h1 class="page-header">Laporan</h1>
        </div>
    	<!-- /.col-lg-12 -->
    </div>
	<!-- /.row -->
    <form id="frm_report" method="post" action="">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                	Cetak Laporan
                </div>
                <div class="panel-body">
                        <a class="btn-group pull-right  col-lg-12" href="excel_report_yearly.php">
                            <button type="button" class="btn btn-success btn-lg btn-block">
                                <i class="fa fa-file-excel-o fa-fw"></i> Cetak ke Excel
                            </button>
                        </a>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    </form>
    <!-- /.form -->
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
