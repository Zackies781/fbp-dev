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

//Etiqa
$sql_etiqa = "SELECT Id FROM fbp_application WHERE application_status = 4 AND active_status = '1'";
$result_etiqa = $conn->query($sql_etiqa);
$row_etiqa = $result_etiqa->num_rows;
$result_etiqa->close();

$conn->close();
?>
<!DOCTYPE html>
<html lang="en"><!-- InstanceBegin template="/Templates/template_etiqa.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>

	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <title>FBP - Sistem Pengurusan Insurans Takaful Peserta</title>
    
    <!-- Bootstrap Datetime Picker CSS -->
    <link href="/FBPKhairat/datetimepicker/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="/FBPKhairat/datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
    
    <!-- Bootstrap Core CSS -->
    <link href="/FBPKhairat/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="/FBPKhairat/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/FBPKhairat/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/FBPKhairat/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    <!-- Custom Tab Icon -->
    <link rel="icon" href="/FBPKhairat/images/FECLRA.png">
    
    <!-- Custom Navbar -->
    <link href="/FBPKhairat/dist/css/custom.css" rel="stylesheet">

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

<body background="/FBPKhairat/images/crisp_paper_ruffles.png">
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
				<li><a href="/FBPKhairat/logout.php?logout"><i class="fa fa-sign-out fa-fw"></i> Log Keluar</a></li>
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="home.php"><i class="fa fa-dashboard fa-fw"></i> Utama</a>
                        </li>
                        <li>
                            <a href="application_main.php"><i class="fa fa fa-list-ul fa-fw"></i> Senarai Permohonan</a>
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
                              <a href="../etiqa/application_main.php?status=4" 
                              data-toggle="tooltip" data-placement="right" 
                              title="Papar Butiran" class="white"><h4>Proses Etiqa</h4></a>
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
    <script src="/FBPKhairat/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/FBPKhairat/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="/FBPKhairat/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- InstanceBeginEditable name="javascript" -->
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
    <script src="/FBPKhairat/dist/js/sb-admin-2.js"></script>
</body>
<!-- InstanceEnd --></html>
