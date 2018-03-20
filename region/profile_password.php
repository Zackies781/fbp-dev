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
$sql = "SELECT id, username, password
FROM fbp_user
WHERE active_status = '1' AND id = '$_SESSION[user]'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
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
                            <div class="form-group">
                                <label>Username</label>
                                <p class="form-control-static"><?php echo $row["username"];?></p>
                            </div>
                            <div class="form-group">
                                <label>Katalaluan Lama</label>
                                <input type="password" id="user_password_old" name="user_password_old"  
                                class="form-control" placeholder="Sila masukkan password lama pengguna" required>
                            </div>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                        <div class="col-lg-6">
                             <div class="form-group">
                                <label>Katalaluan Baru</label>
                                <input type="password" id="user_password_new" name="user_password_new" 
                                class="form-control" placeholder="Sila masukkan password baru pengguna"
                                onKeyUp="PasswordLength();" required>
                            </div>
                            <p id="CheckPasswordLength" class="text-danger"></p>
                            <div class="form-group">
                                <label>Ulang Katalaluan Baru</label>
                                <input  type="password" id="user_password_repeat" name="user_password_repeat" 
                                class="form-control" placeholder="Sila masukkan semula password baru pengguna"
                                onKeyUp="PasswordMatch();" required>
                            </div>
                            <p id="CheckPasswordMatch" class="text-danger"></p>
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
        <button id="save_password" name="save_password" type="submit" class="btn btn-success" disabled>
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
    
    <!-- Check new password -->
	<script type="text/javascript">
		function PasswordLength() {
			var password = $("#user_password_new").val();
		
			if (password.length < 6){
				$("#CheckPasswordLength").html("Katalaluan mesti sekurang-kurangnya 6 karakter!");
				document.getElementById("save_password").disabled = true;
			}else{
				$("#CheckPasswordLength").html("");
				document.getElementById("save_password").disabled = false;
			}
		}
		function PasswordMatch() {
			var password = $("#user_password_new").val();
			var confirmPassword = $("#user_password_repeat").val();
		
			if (password != confirmPassword){
				$("#CheckPasswordMatch").html("Katalaluan tidak sama!");
				document.getElementById("save_password").disabled = true;
			}else{
				$("#CheckPasswordMatch").html("");
				document.getElementById("save_password").disabled = false;
			}
		}
    </script>
	<!-- InstanceEndEditable -->

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
</body>
<!-- InstanceEnd --></html>
