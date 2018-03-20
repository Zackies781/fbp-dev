<?php
ob_start();
session_start();
require_once '../db_connect.php';

//Redirect if not login
if( !isset($_SESSION['user']) ) {
	header("Location: ../index.php");
	exit;
}

if(isset($_GET["user"])){
	$id = $_GET["user"];
}

//User Profile
$sql = "SELECT u.id, u.user_fullname, u.user_ic, u.user_tel_mobile, u.user_territory_id, u.user_region_id, u.user_access, u.user_email, r.name as user_region, t.name as user_territory
FROM fbp_user u
LEFT JOIN fbp_region r ON u.user_region_id = r.id
LEFT JOIN fbp_territory t ON u.user_territory_id = t.id
WHERE u.active_status = '1' AND u.id = '$id'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
}

//List all territory
$sql_territory = "SELECT id, code, name
FROM fbp_territory 
WHERE active_status = '1'
ORDER BY name ASC";
$result_territory = $conn->query($sql_territory);

//List all region
$sql_region = "SELECT r.id, r.code, r.name, s.name as state_name, t.name as territory_name
FROM fbp_region r 
LEFT JOIN fbp_state s ON r.state_name LIKE CONCAT('%',s.name,'%')
LEFT JOIN fbp_territory t ON s.territory_id = t.id
ORDER BY r.name ASC";
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
            <h1 class="page-header">Kemaskini Maklumat Pengguna</h1>
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
                                <label>Nama Penuh Pengguna *</label>
                                <input type="text" id="user_fullname" name="user_fullname" 
                                class="form-control" placeholder="Sila masukkan nama penuh pengguna"
                                value="<?php echo $row["user_fullname"];?>" required> 
                            </div>
                            <div class="form-group">
                                <label>No MyKad *</label>
                                <input type="number" id="user_ic" name="user_ic" 
                                class="form-control" placeholder="Sila masukkan no MyKad pengguna"
                                value="<?php echo $row["user_ic"];?>" required>
                            </div>
                            <div class="form-group">
                                <label>No Telefon *</label>
                                <input type="number" id="user_tel_mobile" name="user_tel_mobile" 
                                class="form-control" placeholder="Sila masukkan no telefon pengguna"
                                value="<?php echo $row["user_tel_mobile"];?>" required>
                            </div>
                            <div class="form-group">
                                <label>Email *</label>
                                <input type="text" id="user_email" name="user_email" 
                                class="form-control" placeholder="Sila masukkan email pengguna"
                                value="<?php echo $row["user_email"];?>" required>
                            </div>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Peringkat *</label>
                                <select class="form-control" id="user_access" name="user_access" onChange="accessSelect()">
                               		<?php if($row["user_access"]=="1"){ ?>
                                    	<option selected value="1">ADMINISTRATOR</option>
                                    <?php } else {?>
                                    	<option value="1">ADMINISTRATOR</option>
                                    <?php } ?>
                                    <?php if($row["user_access"]=="2"){ ?>
                                    	<option selected value="2">KAWASAN</option>
                                    <?php } else {?>
                                    	<option value="2">KAWASAN</option>
                                    <?php } ?>
                                    <?php if($row["user_access"]=="3"){ ?>
                                    	<option selected value="3">WILAYAH</option>
                                   	<?php } else {?>
                                    	<option value="3">WILAYAH</option>
                                    <?php } ?>
                                </select>
                            </div>
                       	 	<div class="form-group">
                                <label>Wilayah</label>
                                <select class="form-control" id="user_territory" name="user_territory" disabled>
                                    <option value="0">TIADA</option>
                                 	<?php if ($result_territory->num_rows > 0) {
										while($row_territory = $result_territory->fetch_assoc()) { 
											if($row["user_territory_id"]==$row_territory["id"]){
												echo '<option selected value="'.$row_territory["id"].'">'.$row_territory["name"].'</option>';
											}else{
												echo '<option value="'.$row_territory["id"].'">'.$row_territory["name"].'</option>';
											}
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
											if($row["user_region_id"]==$row_region["id"]){
												echo '<option selected value="'.$row_region["id"].'">'.$row_region["name"].'</option>';
											}else{
												echo '<option value="'.$row_region["id"].'">'.$row_region["name"].'</option>';
											}
										}
									}?>
                                </select>  
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
        <a href="user_main.php" class="btn btn-success"><i class="fa fa-arrow-left"></i> Kembali</a>
        <button id="update" name="update" type="submit" class="btn btn-primary">
        <i class="fa fa-pencil"></i>    Kemaskini  </button>
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
