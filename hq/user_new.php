<?php
ob_start();
session_start();
require_once '../db_connect.php';

//Redirect if not login
if( !isset($_SESSION['user']) ) {
	header("Location: ../index.php");
	exit;
}

if(isset($_GET["uid"])){
	$id = $_GET["uid"];
}

//List all territory
$sql_territory = "SELECT DISTINCT id, code, name FROM fbp_territory ORDER BY name";
$result_territory = $conn->query($sql_territory);

//List all region
$sql_region = "SELECT DISTINCT id, code, name FROM fbp_region ORDER BY name";
$result_region = $conn->query($sql_region);
	
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
            <h1 class="page-header">Tambah Pengguna</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <form id="registration" role="form-horizontal"  data-toggle="validator"  method="post" action="user_add.php">
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
                                <label>Nama Pengguna *</label>
                                <input type="text" id="user_fullname" name="user_fullname" 
                                class="form-control" placeholder="Sila masukkan nama penuh pengguna" required> 
                            </div>
                            <div class="form-group">
                                <label>No MyKad *</label>
                                <input type="number" id="user_ic" name="user_ic" 
                                class="form-control" placeholder="Sila masukkan no MyKad pengguna" required>
                            </div>
                            <div class="form-group">
                                <label>Username *</label>
                                <input type="text" id="username" name="username" 
                                class="form-control" placeholder="Sila masukkan username pengguna" required>
                            </div>
                            <div class="form-group">
                                <label>No Telefon *</label>
                                <input type="number" id="user_tel_mobile" name="user_tel_mobile" 
                                class="form-control" placeholder="Sila masukkan no telefon pengguna" required>
                            </div>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Peringkat *</label>
                                <select class="form-control" id="user_access" name="user_access" onChange="accessSelect()">
                                    <option value="1">ADMINISTRATOR</option>
                                    <option value="2">KAWASAN</option>
                                    <option value="3">WILAYAH</option>
                                </select>
                            </div>
                       	 	<div class="form-group">
                                <label>Wilayah</label>
                                <select class="form-control" id="user_territory" name="user_territory" disabled>
                                    <option value="0">TIADA</option>
                                 	<?php if ($result_territory->num_rows > 0) {
										while($row_territory = $result_territory->fetch_assoc()) { 
											echo '<option value="'.$row_territory["id"].'">'.$row_territory["name"].'</option>';
										}
									}?>
                                </select>  
                            </div>
                            <div class="form-group">
                                <label>Kawasan</label>
                                <select class="form-control" id="user_region" name="user_region" disabled>
                               	 	<option value="0">TIADA</option>
                                    <?php if ($result_region->num_rows > 0) {
										while($row_region = $result_region->fetch_assoc()) { 
											echo '<option value="'.$row_region["id"].'">'.$row_region["name"].'</option>';
										}
									}?>
                                </select>  
                            </div>
                            <div class="form-group">
                                <label>Email *</label>
                                <input type="text" id="user_email" name="user_email" 
                                class="form-control" placeholder="Sila masukkan email pengguna" required>
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
        <button id="submit" name="submit" type="submit" class="btn btn-primary">
        <i class="fa fa-plus"></i>    Tambah  </button>
    </p>
    
     <!-- hidden data -->
    <input type="hidden" id="app_id" name="app_id" value="<?php echo $row["id"]; ?>">
    
    <!-- meta data -->
    <?php date_default_timezone_set('Asia/Kuala_Lumpur');?>
    <input type="hidden" id="current_date" name="current_date" value="<?php echo date("Y-m-d H:i:s"); ?>">
    <input type="hidden" id="current_id" name="current_id" value="<?php echo $_SESSION['user']; ?>">
    
    </form>
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
    <!-- user access select -->
    <script>
	function accessSelect () {
		var access = document.getElementById("user_access").value;
		if(access == '1') {
			document.getElementById("user_territory").disabled = true;
			document.getElementById("user_territory").value = '0';
			document.getElementById("user_region").disabled = true;
			document.getElementById("user_region").value = '0';
		}else if(access == '2') {
			document.getElementById("user_territory").disabled = false;
			document.getElementById("user_region").disabled = false;
		}else if(access == '3') {
			document.getElementById("user_territory").disabled = false;
			document.getElementById("user_region").disabled = true;
			document.getElementById("user_region").value = '0';
		}
	}
	</script>
<!-- InstanceEndEditable -->

<!-- Custom Theme JavaScript -->
<script src="../dist/js/sb-admin-2.js"></script>
</body>
<!-- InstanceEnd --></html>
