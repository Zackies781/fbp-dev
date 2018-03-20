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
$sql = "SELECT u.id, u.user_fullname, u.user_ic, u.user_tel_mobile, u.user_territory_id, u.user_region_id, u.user_access, u.user_email, r.name as user_region, t.name as user_territory
FROM fbp_user u
LEFT JOIN fbp_region r ON u.user_region_id = r.id
LEFT JOIN fbp_territory t ON u.user_territory_id = t.id
WHERE u.active_status = '1' AND u.id = '$_SESSION[user]'";
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
            <h1 class="page-header">Maklumat Pengguna</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <form id="update_password" role="form-horizontal"  data-toggle="validator"  method="post" 
    action="profile_update.php"  enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Butiran Pengguna
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                        	<div class="form-group" id="fullname">
                                <label>Nama Pengguna</label>
                                <input  type="text" id="user_fullname" name="user_fullname"
                                class="form-control" placeholder="Sila masukkan nama penuh pengguna" 
                                value="<?php echo $row["user_fullname"];?>" required>
                            </div>
                            <div class="form-group" id="ic">
                                <label>No MyKad</label>
                                <input  type="text" id="user_ic" name="user_ic"
                                class="form-control" placeholder="Sila masukkan no MyKad pengguna" 
                                value="<?php echo $row["user_ic"];?>" required>
                            </div>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                        <div class="col-lg-6">
                        	<div class="form-group" id="no_tel">
                                <label>No Telefon</label>
                                <input type="text" id="user_no_tel" name="user_no_tel"
                                class="form-control" placeholder="Sila masukkan no tel pengguna" 
                                value="<?php echo $row["user_tel_mobile"];?>" required>
                            </div>
                            <div class="form-group" id="email">
                                <label>Email</label>
                                <input type="text" id="user_email" name="user_email"
                                class="form-control" placeholder="Sila masukkan email pengguna" 
                                value="<?php echo $row["user_email"];?>" required>
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
        <button id="update" name="update" type="submit" class="btn btn-primary">
        <i class="fa fa-save"></i>    Simpan  </button>
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
    <script type="text/javascript" src="../datetimepicker/jquery/jquery-1.8.3.min.js" charset="UTF-8"></script>
	<script type="text/javascript" src="../datetimepicker/bootstrap/js/bootstrap.min.js"></script>
    
    <!-- User Access -->
	<script type="text/javascript">
		function userAccess(form) {
			var temp1 = form.user_access[0].checked;
			var temp2 = form.user_access[1].checked;
			var temp3 = form.user_access[2].checked;
			
			if (temp1 == true) {
			 	form.user_region.disabled = true;
				form.user_territory.disabled = true;
			} else if (temp2 == true){
				form.user_region.disabled = false;
				form.user_territory.disabled = true;
			} else if (temp3 == true){
				form.user_region.disabled = false;
				form.user_territory.disabled = false;
			}
		}
    </script>
	<!-- InstanceEndEditable -->

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
</body>
<!-- InstanceEnd --></html>
