<?php
ob_start();
session_start();
require_once '../db_connect.php';

//Redirect if not login
if( !isset($_SESSION['user']) ) {
	header("Location: ../index.php");
	exit;
}

//Search myKad number
If( isset($_POST[btn_search]) ) {
	 
	$search = $_POST[txt_search];
	$search = strip_tags(trim($search));
	
	$sql_search = "SELECT Id, member_name, member_ic, state_name, region_code, project_code FROM fbp_member
	WHERE member_ic='$search'";
	
	$result_search = $conn->query($sql_search);
	  
	$count_search = $result_search->num_rows; // if correct it returns must be 1 row
	
	If( $count_search == 1 ) {
		$row_search = $result_search->fetch_assoc();		
		$errMSG = 1;
	} Else {
		$errMSG = 2;
	}
}

//List all territory
$sql_territory = "SELECT DISTINCT id, code, name FROM fbp_territory";
$result_territory = $conn->query($sql_territory);

//List all state
$sql_state = "SELECT DISTINCT id, code, name, territory_id FROM fbp_state";
$result_state = $conn->query($sql_state);

//List all region
$sql_region = "SELECT DISTINCT id, code, name FROM fbp_region";
$result_region = $conn->query($sql_region);

//List all project
$sql_project = "SELECT DISTINCT id, code, name FROM fbp_project";
$result_project = $conn->query($sql_project);


//Variables Declaration
$project_id = 0;
$region_id = 0;
$state_id = 0;
$territory_id = 0;

//territory & state
if ($result_state->num_rows > 0) {
	// output data of each row
	while($row = $result_state->fetch_assoc()) { 
		if($row["name"]==$row_search["state_name"]){
			$state_id = $row["id"];
			$territory_id = $row["territory_id"];
		}
	}	
}

//region
if ($result_region->num_rows > 0) {
	// output data of each row
	while($row = $result_region->fetch_assoc()) { 
		if($row["code"]==$row_search["region_code"]){
			$region_id = $row["id"];
			$region_code= $row["code"];
			$region_name = $row["name"];
		}
	}	
}

//project
if ($result_project->num_rows > 0) {
	// output data of each row
	while($row = $result_project->fetch_assoc()) { 
		if($row["code"]==$row_search["project_code"]){
			$project_id = $row["id"];
			$project_code= $row["code"];
			$project_name = $row["name"];
		}
	}	
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
            <h1 class="page-header">Borang Pengurusan Tuntutan</h1>
        </div>
        <!-- /.col-lg-12 -->
        <form id="frm_search"  method="post">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                    Carian Maklumat Ahli 
                    </div>
                    <div class="panel-body">
                        <?php 
                        if(isset ($errMSG)){
                            if($errMSG==1){
                                echo '<div class="alert alert-success" align="center">
                                <strong>Berjaya!</strong> ahli ada dalam rekod.</div>';
                            }else{
                                echo '<div class="alert alert-danger" align="center">
                                <strong>Ralat!</strong> ahli tiada dalam rekod.</div>';
                            }
                        }?>
                   		<div class="form-group">
                    	<label>Tahun Caruman</label>
                    	<select class="form-control">
                    	<option value="2018" selected>2018</option>
                    	<option value="2017">2017</option>
						</select>
                      	</div>
                        <div class="form-group input-group">
                        	
                            <input type="number" id="txt_search" name="txt_search" 
                            class="form-control" placeholder="Carian no MyKad ahli"
                            value="<?php echo $_POST[txt_search]; ?>" autofocus>
                            <span class="input-group-btn">
                            <button id="btn_search" name="btn_search" class="btn btn-primary" type="submit">
                            <i class="fa fa-search"></i>
                            </button>
                            </span>
                        </div>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </form>
        <!-- /.form -->
    </div>
    <!-- /.row -->
    <?php
    if(isset ($errMSG)){
    if($errMSG==1){ ?>
    <form id="claim_application" role="form-horizontal"  data-toggle="validator"  method="post" 
    action="app_add.php">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
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
                                value="<?php echo $row_search["member_name"];?>">
                            </div>
                            <div class="form-group">
                                <label>No K/P</label>
                                <input type="number" id="member_ic2" name="member_ic2" 
                                class="form-control" placeholder="Sila masukkan no mykad"
                                value="<?php echo $row_search["member_ic"];?>">
                            </div> 
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                        <div class="col-lg-6">
                        	<div class="form-group">
                                <label>Kawasan</label>
                                <input type="text" id="region2" name="region2" 
                                class="form-control" placeholder="Sila masukkan kawasan"
                                value="<?php echo $region_code;?> - <?php echo $region_name;?>">
                            </div> 
                            <div class="form-group">
                                <label>Projek</label>
                                <input type="text" id="project2" name="project2" 
                                class="form-control" placeholder="Sila masukkan projek"
                                value="<?php echo $project_code;?> - <?php echo $project_name;?>">
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
        <!-- /.col-lg-12 --><div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Maklumat Tambahan Pencarum
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Hubungan dengan simati *</label>
                                <div class="radio">
                                    <label class="radio-inline">
                                        <input type="radio" name="member_relations" id="member_relations1" 
                                        value="PASANGAN" onChange="copyInfo(this.form)" Required>Pasangan
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="member_relations" id="member_relations2" 
                                        value="IBU BAPA" onChange="copyInfo(this.form)" Required>Ibu Bapa
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="member_relations" id="member_relations3" 
                                        value="DIRI SENDIRI" onChange="copyInfo(this.form)" Required>Diri Sendiri
                                    </label>
                                </div>
                            </div>    
                            <div class="form-group">
                                <label>Alamat *</label>
                                <textarea id="member_address" name="member_address" rows="4"
                                class="form-control" placeholder="Sila masukkan alamat"
                                onchange="copyInfo(this.form)" Required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Poskod *</label>
                                <input type="number" id="member_postcode" name="member_postcode" 
                                class="form-control" placeholder="Sila masukkan poskod"
                                onchange="copyInfo(this.form)" Required> 
                            </div>  
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>No Telefon Rumah</label>
                                <input type="number" id="member_tel_home" name="member_tel_home" 
                                class="form-control" placeholder="Sila masukkan nombor telefon rumah"
                                onchange="copyInfo(this.form)">
                            </div>
                            <div class="form-group">
                                <label>No Telefon Pejabat</label>
                                <input type="number" id="member_tel_office" name="member_tel_office" 
                                class="form-control" placeholder="Sila masukkan nombor telefon pejabat"
                                onchange="copyInfo(this.form)">
                            </div>
                            <div class="form-group">
                                <label>No Telefon Bimbit *</label>
                                <input type="number" id="member_tel_mobile" name="member_tel_mobile" 
                                class="form-control" placeholder="Sila masukkan nombor telefon bimbit"
                                onchange="copyInfo(this.form)" Required>
                            </div>
                            <div class="form-group">
                                <label>No Fax</label>
                                <input type="number" id="member_fax" name="member_fax" 
                                class="form-control" placeholder="Sila masukkan nombor faksimili"
                                onchange="copyInfo(this.form)">
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
            <div class="panel panel-default">
                <div class="panel-heading">
                    Maklumat Simati
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Nama *</label>
                                <input type="text" id="deceased_name" name="deceased_name" 
                                class="form-control" placeholder="Sila masukkan nama"  Required>
                            </div>
                            <div class="form-group">
                                <label>No K/P *</label>
                                <input type="number" id="deceased_ic" name="deceased_ic" 
                                class="form-control" placeholder="Sila masukkan no mykad" Required>
                            </div>
                            <div class="form-group">
                                <label for="dtp_input2" class="control-label">Tarikh Mati *</label>
                                <div class="input-group date form_date" data-date="" data-date-format="dd-mm-yyyy"
                                 data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                <input class="form-control" type="text" value="" id="deceased_dod" name="deceased_dod"
                                placeholder="Sila masukkan tarikh mati" Required>
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                                <input type="hidden" id="dtp_input2" value="" />
                        	</div>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Umur *</label>
                                <input type="number" id="deceased_age" name="deceased_age" 
                                class="form-control" placeholder="Sila masukkan umur" Required>
                            </div>
                         	<div class="form-group">
                             	<label for="dtp_input3" class="control-label">Tarikh Lahir *</label>
                                <div class="input-group date form_date" data-date="" data-date-format="dd-mm-yyyy"
                                 data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                <input class="form-control" type="text" value="" id="deceased_dob" name="deceased_dob"
                                placeholder="Sila masukkan tarikh lahir" Required>
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                                <input type="hidden" id="dtp_input3" value="" />
                        	</div>
                            <div class="form-group">
                                <label>Punca Kematian *</label>
                                <input type="text" id="diagnosis" name="diagnosis" 
                                class="form-control" placeholder="Sila masukkan punca kematian"  Required>
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
            <div class="panel panel-default">
                <div class="panel-heading">
                    Maklumat Wakil/Penerima/Penuntut
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Nama *</label>
                                <input type="text" id="recipient_name" name="recipient_name" 
                                class="form-control" placeholder="Sila masukkan nama" Required>
                            </div>
                            <div class="form-group">
                                <label>Alamat *</label>
                                <textarea id="recipient_address" name="recipient_address" rows="4"  
                                class="form-control" placeholder="Sila masukkan alamat" Required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Poskod *</label>
                                <input type="number" id="recipient_postcode" name="recipient_postcode" 
                                class="form-control" placeholder="Sila masukkan poskod" Required>
                            </div>       
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>No Telefon Rumah</label>
                                <input type="number" id="recipient_tel_home" name="recipient_tel_home" 
                                class="form-control" placeholder="Sila masukkan nombor telefon rumah">
                            </div>
                            <div class="form-group">
                                <label>No Telefon Pejabat</label>
                                <input type="number" id="recipient_tel_office" name="recipient_tel_office" 
                                class="form-control" placeholder="Sila masukkan nombor telefon pejabat">
                            </div>
                            <div class="form-group">
                                <label>No Telefon Bimbit *</label>
                                <input type="number" id="recipient_tel_mobile" name="recipient_tel_mobile" 
                                class="form-control" placeholder="Sila masukkan nombor telefon bimbit" Required>
                            </div>
                            <div class="form-group">
                                <label>No Fax</label>
                                <input type="number" id="recipient_fax" name="recipient_fax" 
                                class="form-control" placeholder="Sila masukkan nombor faksimili ">
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
    <p class="text-info" align="center">Sila isi semua ruang yang bertanda *</p>

	<p align="center">
    	<button id="submit" name="submit" type="submit" class="btn btn-primary">
        <i class="fa fa-save"></i>   Simpan  </button>
  	</p>

    <!-- hidden values -->
    <input type="hidden" id="member_name" name="member_name" value="<?php echo $row_search["member_name"];?>">
    <input type="hidden" id="member_ic" name="member_ic" value="<?php echo $row_search["member_ic"];?>">
    <input type="hidden" id="territory" name="territory" value="<?php echo $territory_id;?>">
    <input type="hidden" id="state" name="state" value="<?php echo $state_id;?>">
    <input type="hidden" id="region" name="region" value="<?php echo $region_id;?>">
    <input type="hidden" id="project" name="project" value="<?php echo $project_id;?>">
    
    <!-- meta data -->
    <?php date_default_timezone_set('Asia/Kuala_Lumpur');?>
    <input type="hidden" id="current_date" name="current_date" value="<?php echo date("Y-m-d H:i:s"); ?>">
    <input type="hidden" id="current_id" name="current_id" value="<?php echo $_SESSION['user']; ?>">
    </form>
	<?php } } ?>
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
	<script type="text/javascript" src="../datetimepicker/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
	<script type="text/javascript" src="../datetimepicker/js/locales/bootstrap-datetimepicker.fr.js" 
	charset="UTF-8"></script>
	<script type="text/javascript">
    $('.form_datetime').datetimepicker({
        //language:  'en',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1
    });
	$('.form_date').datetimepicker({
        language:  'en',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
    });
	$('.form_time').datetimepicker({
        language:  'en',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 1,
		minView: 0,
		maxView: 1,
		forceParse: 0
    });
	</script>
    <!-- Copy infomation -->
    <script>
	function copyInfo (form) {
	var temp1 = form.member_relations[0].checked;
	var temp2 = form.member_relations[1].checked;
	var temp3 = form.member_relations[2].checked;
	
		if (temp1 == true || temp2 == true) {
		  form.deceased_name.value = "";
		  form.deceased_ic.value = "";
		  form.deceased_age.value = "";
		  form.deceased_dob.value = "";
		  form.recipient_name.value = form.member_name.value;
		  form.recipient_address.value = form.member_address.value;
		  form.recipient_postcode.value = form.member_postcode.value;
		  form.recipient_tel_home.value = form.member_tel_home.value;
		  form.recipient_tel_office.value = form.member_tel_office.value;
		  form.recipient_tel_mobile.value = form.member_tel_mobile.value;
		  form.recipient_fax.value = form.member_fax.value;
		  
		} else if (temp3 == true){
		  form.deceased_name.value = "<?php echo $row_search["member_name"];?>";
		  form.deceased_ic.value = "<?php echo $row_search["member_ic"];?>";
		  
		  //calcuate deceased age
		  calculateAge();
		  
		  form.recipient_name.value = "";
		  form.recipient_address.value = "";
		  form.recipient_postcode.value = "";
		  form.recipient_tel_home.value = "";
		  form.recipient_tel_office.value = "";
		  form.recipient_tel_mobile.value = "";
		  form.recipient_fax.value = "";
		  
		} else if (temp1 == false && temp2 == false && temp3 == false) {
		  form.textbox.value = "";
		}
	}
	</script>
    
    <!-- Calculate age based on mycard -->
	<script type="text/javascript">
		function calculateAge() {
			var ic = document.getElementById('deceased_ic');
			var age = document.getElementById('deceased_age');
			var dob = document.getElementById('deceased_dob');
			var age2 = document.getElementById('deceased_age2');
			var dob2 = document.getElementById('deceased_dob2');
			
			var year = ic.value.slice(0,2);
			var month = ic.value.slice(2,4);
			var day = ic.value.slice(4,6);
			
			var currentDate = new Date();
			var currentYear = currentDate.getFullYear();
			
			if(year>30){
				var fullYear = 19 + year;
				dob.value = day.concat('-',month,'-19',year);
				dob2.value = day.concat('-',month,'-19',year);
			}else{
				var fullYear = 20 + year;
				dob.value = day.concat('-',month,'-20',year);
				dob2.value = day.concat('-',month,'-20',year);
			}
			
			age.value = currentYear - fullYear;
			age2.value = currentYear - fullYear;
		}
    </script>
	<!-- InstanceEndEditable -->

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
</body>
<!-- InstanceEnd --></html>
