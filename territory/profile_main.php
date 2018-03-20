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
$sql = "SELECT u.id, u.user_fullname, u.user_ic, u.username, u.password, u.user_tel_mobile, u.user_territory_id, u.user_region_id, u.user_access, u.user_email, r.name as user_region, t.name as user_territory
FROM fbp_user u
LEFT JOIN fbp_region r ON u.user_region_id = r.id
LEFT JOIN fbp_territory t ON u.user_territory_id = t.id
WHERE u.active_status = '1' AND u.id = '$_SESSION[user]'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
}
	
$conn->close();
?>
<!DOCTYPE html>
<html lang="en"><!-- InstanceBegin template="/Templates/template_territory.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>

	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <title>FBP - Sistem Pengurusan Insurans Takaful Peserta</title>
    
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
                            <a href="application_main.php"><i class="fa fa fa-list-ul fa-fw"></i>Senarai Permohonan</a>
                        </li>
                        <li>
                            <a href="report_main.php"><i class="fa fa-bar-chart-o fa-fw"></i>Laporan</a>
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
            <h1 class="page-header">Profil Pengguna</h1>
            <?php 
            if (isset($_GET["success"])) {
                if($_GET["success"]==1){
                    echo '<div class="alert alert-success" align="center">
                    <strong>Berjaya!</strong> Profil telah disimpan.
                    </div>';
                }else if($_GET["success"]==2){
                    echo '<div class="alert alert-success" align="center">
                    <strong>Berjaya!</strong> Katalaluan baru telah disimpan.
                    </div>';
                }
			}else if (isset($_GET["fail"])) {
                if($_GET["fail"]==1){
                     echo '<div class="alert alert-danger" align="center">
                    <strong>Ralat!</strong> Profil gagal disimpan.
                    </div>';
                }else if($_GET["fail"]==2){
                     echo '<div class="alert alert-danger" align="center">
                    <strong>Ralat!</strong> Katalaluan baru gagal disimpan.
                    </div>';
                }else if($_GET["fail"]==3){
                     echo '<div class="alert alert-danger" align="center">
                    <strong>Ralat!</strong> Katalaluan lama salah.
                    </div>';
                }
			}
			?>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Butiran Pengguna
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                        	<div class="form-group">
                                <label>Nama Pengguna</label>
                                <p class="form-control-static"><?php echo $row["user_fullname"];?></p>
                            </div>
                            <div class="form-group">
                                <label>No MyKad</label>
                                <p class="form-control-static"><?php echo $row["user_ic"];?></p>
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <p class="form-control-static"><?php echo $row["username"];?></p>
                            </div>
                            <div class="form-group">
                                <label>No Telefon</label>
                                <p class="form-control-static"><?php echo $row["user_tel_mobile"];?></p>
                            </div>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Peringkat</label>
                                <?php if ($row["user_access"]=='1'){?>
                                	<p class="form-control-static"> ADMINISTRATOR</p>
								<?php } else if($row["user_access"]=='3'){?>
                                	<p class="form-control-static"> WILAYAH</p>
								<?php } else if ($row["user_access"]=='2'){?>
                                	<p class="form-control-static"> KAWASAN</p>
								<?php } ?>
                            </div>
                       	 	<div class="form-group">
                                <label>Wilayah</label>
                                <?php if ($row["user_access"]=='1'){?>
                                	<p class="form-control-static"> FELCRA BEKALAN & PERKHIDMATAN</p>
								<?php } else {?>
                                	<p class="form-control-static"><?php echo $row["user_territory"];?></p>
								<?php } ?>
                                
                            </div>
                            <?php if ($row["user_access"]=='2'){?>
                                <div class="form-group">
                                    <label>Kawasan</label>
                                    <p class="form-control-static"><?php echo $row["user_region"];?></p>
                                </div>
                            <?php } ?>
                            <div class="form-group">
                                <label>Email</label>
                                <p class="form-control-static"><?php echo $row["user_email"];?></p>
                            </div>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    
    <p align="center">
        <button id="update" name="update" type="submit" class="btn btn-success"  onclick="location.href='profile_password.php'">
        <i class="fa fa-refresh"></i>    Tukar Kata Laluan  </button>
        <button id="update" name="update" type="submit" class="btn btn-primary"  onclick="location.href='profile_detail.php'">
        <i class="fa fa-pencil"></i>    Kemaskini Maklumat </button>
    </p>
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
    <script type="text/javascript" src="../datetimepicker/jquery/jquery-1.8.3.min.js" charset="UTF-8"></script>
	<script type="text/javascript" src="../datetimepicker/bootstrap/js/bootstrap.min.js"></script>
	<!-- InstanceEndEditable -->

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
</body>
<!-- InstanceEnd --></html>
