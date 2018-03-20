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
$sql_user = "SELECT Id, user_fullname, user_territory_id FROM fbp_user WHERE Id = '$_SESSION[user]' AND active_status = '1'";
$result_user = $conn->query($sql_user);
if ($result_user->num_rows > 0) {
	$row_user = $result_user->fetch_assoc();
}
$result_user->close();

//set user territory
if(isset($row_user["user_territory_id"])){
	$user_territory = $row_user["user_territory_id"];
}

if($user_territory != '0'){
	//Drafted
	$sql_drafted = "SELECT Id FROM fbp_application WHERE application_status = 1 AND active_status = '1' AND territory_id = '$user_territory'";
	$result_drafted = $conn->query($sql_drafted);
	$row_drafted = $result_drafted->num_rows;
	$result_drafted->close();
	
	//Requested
	$sql_requested = "SELECT Id FROM fbp_application WHERE application_status = 2 AND active_status = '1' AND territory_id = '$user_territory'";
	$result_requested = $conn->query($sql_requested);
	$row_requested = $result_requested->num_rows;
	$result_requested->close();
	
	//Verified
	$sql_verified = "SELECT Id FROM fbp_application WHERE application_status = 3 AND active_status = '1' AND territory_id = '$user_territory'";
	$result_verified = $conn->query($sql_verified);
	$row_verified = $result_verified->num_rows;
	$result_verified->close();
	
	//Etiqa
	$sql_etiqa = "SELECT Id FROM fbp_application WHERE application_status = 4 AND active_status = '1' AND territory_id = '$user_territory'";
	$result_etiqa = $conn->query($sql_etiqa);
	$row_etiqa = $result_etiqa->num_rows;
	$result_etiqa->close();
	
	//Completed
	$sql_completed = "SELECT Id FROM fbp_application WHERE application_status = 5 AND active_status = '1' AND territory_id = '$user_territory'";
	$result_completed = $conn->query($sql_completed);
	$row_completed = $result_completed->num_rows;
	$result_completed->close();
	
	//Rejected
	$sql_rejected = "SELECT Id FROM fbp_application WHERE application_status = 0 AND active_status = '1' AND territory_id = '$user_territory'";
	$result_rejected = $conn->query($sql_rejected);
	$row_rejected = $result_rejected->num_rows;
	$result_rejected->close();
	
	//All
	$sql_all = "SELECT Id FROM fbp_application WHERE active_status = '1' AND territory_id = '$user_territory'";
	$result_all = $conn->query($sql_all);
	$row_all = $result_all->num_rows;
	$result_all->close();
	
}else if ($user_territory == '0'){
	//Drafted
	$sql_drafted = "SELECT Id FROM fbp_application WHERE application_status = 1 AND active_status = '1'";
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
	
	//Completed
	$sql_completed = "SELECT Id FROM fbp_application WHERE application_status = 5 AND active_status = '1'";
	$result_completed = $conn->query($sql_completed);
	$row_completed = $result_completed->num_rows;
	$result_completed->close();
	
	//Rejected
	$sql_rejected = "SELECT Id FROM fbp_application WHERE application_status = 0 AND active_status = '1'";
	$result_rejected = $conn->query($sql_rejected);
	$row_rejected = $result_rejected->num_rows;
	$result_rejected->close();
	
	//All
	$sql_all = "SELECT Id FROM fbp_application WHERE active_status = '1'";
	$result_all = $conn->query($sql_all);
	$row_all = $result_all->num_rows;
	$result_all->close();
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
<style>
a.white {
    color: rgb(255,255,255);
}
a.grey {
    color: rgb(51,51,51);
}
a.green {
    color: rgb(60,118,61);
}
</style>
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
                  <strong>Berjaya!</strong> Permohonan telah dihapus.
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
                          <div class="tooltip-demo">
                              <a href="application_main.php?status=1" 
                              data-toggle="tooltip" data-placement="right" 
                              title="Papar Butiran" class="grey"><h4>Deraf Permohonan</h4></a> 
                          </div>
                      </div>
                  </div>
              </div>
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
                          <div class="tooltip-demo">
                              <a href="application_main.php?status=2" 
                              data-toggle="tooltip" data-placement="right" 
                              title="Papar Butiran" class="white"><h4>Permohonan Baru</h4></a>
                          </div>
                      </div>
                  </div>
              </div>
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
                          <div class="tooltip-demo">
                              <a href="application_main.php?status=3" 
                              data-toggle="tooltip" data-placement="right" 
                              title="Papar Butiran" class="white"><h4>Permohonan Diterima</h4></a>
                          </div>
                      </div>
                  </div>
              </div>
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
                          <div class="tooltip-demo">
                              <a href="application_main.php?status=4" 
                              data-toggle="tooltip" data-placement="right" 
                              title="Papar Butiran" class="white"><h4>Proses Etiqa</h4></a>
                          </div>
                      </div>
                  </div>
              </div>
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
                          <div class="tooltip-demo">
                              <a href="application_main.php?status=0" 
                              data-toggle="tooltip" data-placement="right" 
                              title="Papar Butiran" class="white"><h4>Permohonan Tidak Lengkap</h4></a>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <!-- Completed -->
      <div class="col-lg-4 col-md-6">
          <div class="panel panel-success">
              <div class="panel-heading">
                  <div class="row">
                      <div class="col-xs-2">
                          <i class="fa fa-check fa-5x"></i>
                      </div>
                      <div class="col-xs-10 text-right">
                          <div class="huge"><?php echo $row_completed; ?></div>
                          <div class="tooltip-demo">
                              <a href="application_main.php?status=5" 
                              data-toggle="tooltip" data-placement="right" 
                              title="Papar Butiran" class="green"><h4>Permohonan Selesai</h4></a>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- /.row -->
  <div class="row">
      <div class="col-lg-12">
          <div class="panel panel-info">
              <div class="panel-heading">
                  Soalan lazim ditanya (FAQ)
              </div>
              <!-- .panel-heading -->
              <div class="panel-body">
                  <div class="panel-group" id="accordion">
                      <div class="panel panel-warning">
                          <div class="panel-heading">
                              <h4 class="panel-title">
                                  <a data-toggle="collapse" data-parent="#accordion" 
                                  href="#collapseOne">Soalan #1</a>
                              </h4>
                          </div>
                          <div id="collapseOne" class="panel-collapse collapse">
                              <div class="panel-body">
                                  Jawapan #1
                              </div>
                          </div>
                      </div>
                      <div class="panel panel-warning">
                          <div class="panel-heading">
                              <h4 class="panel-title">
                                  <a data-toggle="collapse" data-parent="#accordion" 
                                  href="#collapseTwo">Soalan #2</a>
                              </h4>
                          </div>
                          <div id="collapseTwo" class="panel-collapse collapse">
                              <div class="panel-body">
                                  Jawapan #2
                              </div>
                          </div>
                      </div>
                      <div class="panel panel-warning">
                          <div class="panel-heading">
                              <h4 class="panel-title">
                                  <a data-toggle="collapse" data-parent="#accordion" 
                                  href="#collapseThree">Soalan #3</a>
                              </h4>
                          </div>
                          <div id="collapseThree" class="panel-collapse collapse">
                              <div class="panel-body">
                                  Jawapan #3
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <!-- .panel-body -->
              <div class="panel-footer" align="center">
                 <em>Sila hubungi <strong>Encik Zul Izdihar Akmal</strong> jika terdapat sebarang pertanyaan di talian: <strong>017-572 2773</strong> atau email ke: <strong>zulfbpsb@gmail.com</strong></em>
              </div>
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
