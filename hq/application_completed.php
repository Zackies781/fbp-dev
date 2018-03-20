<?php
ob_start();
session_start();
require_once '../db_connect.php';

//Redirect if not login
if( !isset($_SESSION['user']) ) {
	header("Location: ../index.php");
	exit;
}

$sql_territory = "SELECT DISTINCT id, code, name FROM fbp_territory";
$result_territory = $conn->query($sql_territory);

$sql_state = "SELECT DISTINCT id, code, name FROM fbp_state";
$result_state = $conn->query($sql_state);

$sql_region = "SELECT DISTINCT id, code, name FROM fbp_region";
$result_region = $conn->query($sql_region);

$sql_project = "SELECT DISTINCT id, code, name FROM fbp_project";
$result_project = $conn->query($sql_project);

if(isset($_GET["app"])){
	$id = $_GET["app"];
}

$sql_app = "SELECT DISTINCT * FROM fbp_application WHERE Id=$id";
$result_app = $conn->query($sql_app);
if ($result_app->num_rows > 0) {
	$row_app = $result_app->fetch_assoc();
}

//convert date 
if(isset($row_app[deceased_dod])){
	$date = DateTime::createFromFormat('Y-m-d', $row_app[deceased_dod]);
	$deceased_dod = $date->format('d-m-Y'); 
}
if(isset($row_app[deceased_dob])){
	$date = DateTime::createFromFormat('Y-m-d', $row_app[deceased_dob]);
	$deceased_dob = $date->format('d-m-Y');
}
if(isset($row_app['comp_etiqa_date'])){
	$date = DateTime::createFromFormat('Y-m-d', $row_app['comp_etiqa_date']);
	$etiqa_date = $date->format('d-m-Y'); 
}
if(isset ($row_app['comp_fbp_date'])){
	$date = DateTime::createFromFormat('Y-m-d', $row_app['comp_fbp_date']);
	$fbp_date = $date->format('d-m-Y');
}

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
            <h1 class="page-header">Borang Pengurusan Tuntutan</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <form id="claim_application" role="form-horizontal"  data-toggle="validator"  method="post" 
    action="app_update.php">
    <div class="alert alert-success" align="center">
        Status Permohonan: <strong>Permohonan Selesai</strong> 
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    Maklumat Pencarum
                </div>
                <div class="panel-body">
                <fieldset disabled>
                    <div class="row">
                        <div class="col-lg-6">   	
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" id="member_name2" name="member_name2" 
                                class="form-control" placeholder="Sila masukkan nama"
                                value="<?php echo $row_app["deceased_name"];?>">
                            </div>
                            <div class="form-group">
                                <label>No K/P</label>
                                <input type="number" id="member_ic2" name="member_ic2" 
                                class="form-control" placeholder="Sila masukkan no mykad"
                                value="<?php echo $row_app["deceased_ic"];?>">
                            </div>
                            <div class="form-group">
                                <label>Hubungan dengan simati</label>
                                <div class="radio">
                                    <label class="radio-inline">
                                        <input type="radio" name="member_relations" id="member_relations1" 
                                        value="PASANGAN" <?php if($row_app["member_relations"]=='PASANGAN'){ echo 'checked'; }?>>Pasangan
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="member_relations" id="member_relations2" 
                                        value="IBU BAPA" <?php if($row_app["member_relations"]=='IBU BAPA'){ echo 'checked'; }?>>Ibu Bapa
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="member_relations" id="member_relations3" 
                                        value="DIRI SENDIRI" <?php if($row_app["member_relations"]=='DIRI SENDIRI'){ echo 'checked'; }?>>Diri sendiri
                                    </label>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea id="member_address" name="member_address" class="form-control"
                                rows="4" placeholder="Sila masukkan alamat"><?php 
                                echo $row_app["member_address"];?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Poskod</label>
                                <input type="number" id="member_postcode" name="member_postcode" 
                                class="form-control" placeholder="Sila masukkan poskod"
                                value="<?php echo $row_app["member_postcode"];?>">
                            </div> 
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Kawasan</label>
                                <select class="form-control" id="region2" name="region2">
                                <option value="-1">Sila Pilih Kawasan</option>
                                <?php if ($result_region->num_rows > 0) {
                                    // output data of each row
                                    while($row = $result_region->fetch_assoc()) { 
                                        if($row["id"]==$row_app["region_id"]){
                                            echo '<option value="'.$row["id"].'" selected>'.$row["code"].
                                            ' - '.$row["name"].'</option>';
                                        }else{
                                            echo '<option value="'.$row["id"].'">'.$row["code"].' - 
                                            '.$row["name"].'</option>';
                                        }
                                    }	
                                }?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Projek</label>
                                <select class="form-control" id="project2" name="project2">
                                <option value="-1">Sila Pilih Projek</option>
                                <?php if ($result_project->num_rows > 0) {
                                    // output data of each row
                                    while($row = $result_project->fetch_assoc()) { 
                                        if($row["id"]==$row_app["project_id"]){
                                            echo '<option value="'.$row["id"].'" selected>'.$row["code"].
                                            ' - '.$row["name"].'</option>';
                                        }else{
                                            echo '<option value="'.$row["id"].'">'.$row["code"].' - 
                                            '.$row["name"].'</option>';
                                        }
                                    }	
                                }?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>No Telefon Rumah</label>
                                <input type="number" id="member_tel_home" name="member_tel_home" 
                                class="form-control" placeholder="Sila masukkan nombor telefon rumah"
                                value="<?php echo $row_app["member_tel_home"];?>">
                            </div>
                            <div class="form-group">
                                <label>No Telefon Pejabat</label>
                                <input type="number" id="member_tel_office" name="member_tel_office" 
                                class="form-control" placeholder="Sila masukkan nombor telefon pejabat"
                                value="<?php echo $row_app["member_tel_office"];?>">
                            </div>
                            <div class="form-group">
                                <label>No Telefon Bimbit</label>
                                <input type="number" id="member_tel_mobile" name="member_tel_mobile" 
                                class="form-control" placeholder="Sila masukkan nombor telefon bimbit"
                                value="<?php echo $row_app["member_tel_mobile"];?>">
                            </div>
                            <div class="form-group">
                                <label>No Fax</label>
                                <input type="number" id="member_fax" name="member_fax" 
                                class="form-control" placeholder="Sila masukkan nombor faksimili"
                                value="<?php echo $row_app["member_fax"];?>">
                            </div>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                    </div>
                    <!-- /.row (nested) -->
                </fieldset>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
        <div class="col-lg-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    Maklumat Simati
                </div>
                <div class="panel-body">
                <fieldset disabled>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" id="deceased_name" name="deceased_name" 
                                class="form-control" placeholder="Sila masukkan nama" 
                                value="<?php echo $row_app["deceased_name"];?>">
                            </div>
                            <div class="form-group">
                                <label>No K/P</label>
                                <input type="number" id="deceased_ic" name="deceased_ic" 
                                class="form-control" placeholder="Sila masukkan no mykad"
                                onblur="calculateAge()" value="<?php echo $row_app["deceased_ic"];?>">
                            </div>
                            <script type="text/javascript">
                                function calculateAge() {
                                    var ic = document.getElementById('deceased_ic');
                                    var age = document.getElementById('deceased_age');
                                    var dob = document.getElementById('deceased_dob');
                                    
                                    var year = ic.value.slice(0,2);
                                    var month = ic.value.slice(2,4);
                                    var day = ic.value.slice(4,6);
                                    
                                    var currentDate = new Date();
                                    var currentYear = currentDate.getFullYear();
                                    var fullYear = 19 + year;
                                    
                                    age.value = currentYear - fullYear;
                                    dob.value = day.concat('/',month,'/19',year);
                                }
                            </script>
                            <div class="form-group">
                                <label>Tarikh Mati</label>
                                <input type="text" id="deceased_dod" name="deceased_dod" 
                                class="form-control" placeholder="Sila masukkan tarikh mati"
                                value="<?php echo $deceased_dod;?>">
                            </div>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Umur</label>
                                <input type="number" id="deceased_age" name="deceased_age" 
                                class="form-control" placeholder="Umur akan dijana automatik"
                                value="<?php echo $row_app["deceased_age"];?>">
                                </div>
                                <div class="form-group">
                                <label>Tarikh Lahir</label>
                                <input type="text" id="deceased_dob" name="deceased_dob" 
                                class="form-control" placeholder="Tarikh lahir akan dijana automatik"
                                value="<?php echo $deceased_dob;?>">
                            </div>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                    </div>
                    <!-- /.row (nested) -->
                </fieldset>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
        <div class="col-lg-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    Maklumat Wakil/Penerima/Penuntut
                </div>
                <div class="panel-body">
                <fieldset disabled>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" id="recipient_name" name="recipient_name" 
                                class="form-control" placeholder="Sila masukkan nama" 
                                value="<?php echo $row_app["recipient_name"];?>">
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea id="recipient_address" name="recipient_address" 
                                class="form-control" rows="4" placeholder="Sila masukkan alamat"><?php 
								echo $row_app["recipient_address"];?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Poskod</label>
                                <input type="number" id="recipient_postcode" name="recipient_postcode" 
                                class="form-control" placeholder="Sila masukkan poskod"
                                value="<?php echo $row_app["recipient_postcode"];?>">
                            </div>       
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>No Telefon Rumah</label>
                                <input type="number" id="recipient_tel_home" name="recipient_tel_home" 
                                class="form-control" placeholder="Sila masukkan nombor telefon rumah"
                                value="<?php echo $row_app["recipient_tel_home"];?>">
                            </div>
                            <div class="form-group">
                                <label>No Telefon Pejabat</label>
                                <input type="number" id="recipient_tel_office" name="recipient_tel_office" 
                                class="form-control" placeholder="Sila masukkan nombor telefon pejabat"
                                value="<?php echo $row_app["recipient_tel_office"];?>">
                            </div>
                            <div class="form-group">
                                <label>No Telefon Bimbit</label>
                                <input type="number" id="recipient_tel_mobile" name="recipient_tel_mobile" 
                                class="form-control" placeholder="Sila masukkan nombor telefon bimbit"
                                value="<?php echo $row_app["recipient_tel_mobile"];?>">
                            </div>
                            <div class="form-group">
                                <label>No Fax</label>
                                <input type="number" id="recipient_fax" name="recipient_fax" 
                                class="form-control" placeholder="Sila masukkan nombor faksimili "
                                value="<?php echo $row_app["recipient_fax"];?>">
                            </div>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                    </div>
                    <!-- /.row (nested) -->
                </fieldset>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
        <div class="col-lg-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    Dokumen Sokongan
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <a href="../uploads/<?php echo $row_app["file_death_cert"];?>" 
                                class="btn btn-default btn-lg btn-block btn-sm" target="_blank">Cetak Sijil Kematian</a>
                            </div>
                            <div class="form-group">
                                <a href="../uploads/<?php echo $row_app["file_deceased_ic"];?>"
                                class="btn btn-default btn-lg btn-block btn-sm" target="_blank">Cetak Salinan K/P Simati</a>
                            </div>  
                            <div class="form-group">
                                <a href="print_letter.php?app=<?php echo $row_app["Id"]; ?>" 
                                class="btn btn-default btn-lg btn-block btn-sm" target="_blank">Cetak Surat Sah Peserta</a>
                            </div> 
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <a href="../uploads/<?php echo $row_app["file_recipient_ic"];?>" 
                                class="btn btn-default btn-lg btn-block btn-sm" target="_blank">Cetak Salinan K/P Wakil/Penerima/Penuntut</a>
                            </div> 
                            <div class="form-group">
                                <a href="../uploads/<?php echo $row_app["file_recipient_cert"];?>" 
                                class="btn btn-default btn-lg btn-block btn-sm" target="_blank">Cetak Sijil Nikah Wakil/Penerima/Penuntut</a>
                            </div>
                            <div class="form-group">
                                <a href="print_application.php?app=<?php echo $row_app["Id"]; ?>" 
                                class="btn btn-default btn-lg btn-block btn-sm" target="_blank">Cetak Permohonan</a>                            
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
        <div class="col-lg-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    Maklumat Cek
                </div>
                <div class="panel-body">
                <fieldset disabled>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>No Cek ETIQA</label>
                                <input type="text" id="etiqa_no" name="etiqa_no" 
                                class="form-control" placeholder="Sila masukkan nombor cek Etiqa"
                                value="<?php echo $row_app["comp_etiqa_no"];?>">
                            </div>
                            <div class="form-group">
                                <label>Tarikh Cek ETIQA</label>
                                <input type="text" id="etiqa_date" name="etiqa_date"
                                class="form-control" placeholder="Sila masukkan tarikh cek Etiqa"
                                value="<?php echo $etiqa_date;?>">
                            </div>
                            <div class="form-group">
                                <label>Jumlah Cek</label>
                                <input type="text" id="check_value" name="check_value" 
                                class="form-control" placeholder="Sila masukkan jumlah cek"
                                value="<?php echo $row_app["comp_value"];?>">
                            </div>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>No Cek FBP</label>
                                <input type="text" id="fbp_no" name="fbp_no"
                                class="form-control" placeholder="Sila masukkan nombor cek FBP"
                                value="<?php echo $row_app["comp_fbp_no"];?>">
                            </div>
                            <div class="form-group">
                                <label>Tarikh Cek FBP</label>
                                <input type="text" id="fbp_date" name="fbp_date"
                                class="form-control" placeholder="Sila masukkan tarikh cek FBP"
                                value="<?php echo $fbp_date;?>">
                            </div>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                    </div>
                    <!-- /.row (nested) -->
                </fieldset>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
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
	<script type="text/javascript">
        function calculateAge() {
            var ic = document.getElementById('deceased_ic');
            var age = document.getElementById('deceased_age');
            var dob = document.getElementById('deceased_dob');
            
            var year = ic.value.slice(0,2);
            var month = ic.value.slice(2,4);
            var day = ic.value.slice(4,6);
            
            var currentDate = new Date();
            var currentYear = currentDate.getFullYear();
            var fullYear = 19 + year;
            
            age.value = currentYear - fullYear;
            dob.value = day.concat('/',month,'/19',year);
        }
    </script>
	<!-- InstanceEndEditable -->

<!-- Custom Theme JavaScript -->
<script src="../dist/js/sb-admin-2.js"></script>
</body>
<!-- InstanceEnd --></html>
