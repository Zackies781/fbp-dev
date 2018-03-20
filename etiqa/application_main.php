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

if (isset($_GET["status"])) {
	if($_GET["status"]==4){  //Etiqa
		$sql = "SELECT A.id, A.deceased_name, A.deceased_ic, A.application_status, R.name
		FROM fbp_application A LEFT JOIN fbp_region R ON A.region_id = R.id
		WHERE A.application_status = '4' AND A.active_status = '1'
		ORDER BY A.updated_date DESC";
		$result = $conn->query($sql);
	}
}else{
	$sql = "SELECT A.id, A.deceased_name, A.deceased_ic, A.application_status, R.name
	FROM fbp_application A LEFT JOIN fbp_region R ON A.region_id = R.id
	WHERE A.application_status = '4' AND A.active_status = '1' 
	ORDER BY A.updated_date DESC";
	$result = $conn->query($sql);
}

//List all state
$sql_state = "SELECT DISTINCT id, code, name FROM fbp_state";
$result_state = $conn->query($sql_state);

//List all region
$sql_region = "SELECT DISTINCT id, code, name FROM fbp_region";
$result_region = $conn->query($sql_region);

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
<!-- DataTables CSS -->
<link href="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

<!-- DataTables Responsive CSS -->
<link href="../bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">
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
            <h1 class="page-header">Senarai Permohonan</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Senarai Permohonan Khairat Kematian
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>Kawasan</th>
                                    <th>Nama Simati</th>
                                    <th>NO. K/P</th>
                                    <th>Status</th>
                                    <th>Butiran</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if ($result->num_rows > 0) {
                                // output data of each row
                                while($row = $result->fetch_assoc()) {                                     
                                    // list according to application status
                                    if($row["application_status"]==1){	 // Drafted
                                        echo 
                                        '<tr class="odd gradeX">
                                            <td>'.$row["name"].'</td>
                                            <td><p class="text-uppercase"">'.$row["deceased_name"].'</p></td>
                                            <td>'.$row["deceased_ic"].'</td>
                                            <td>
                                                <div class="tooltip-demo">
                                                <button type="button" class="btn btn-default btn-circle"
                                                data-toggle="tooltip" data-placement="right" 
                                                title="Deraf Permohonan">
                                                <i class="fa fa-star"></i> 
                                                </button> Deraf
                                                </div>
                                            </td>
                                        </tr>';
                                    }else if($row["application_status"]==2){	//Requested
                                        echo 
                                        '<tr class="odd gradeX">
                                            <td>'.$row["name"].'</td>
                                            <td><p class="text-uppercase"">'.$row["deceased_name"].'</p></td>
                                            <td>'.$row["deceased_ic"].'</td>
                                            <td>
                                                <div class="tooltip-demo">
                                                <button type="button" class="btn btn-primary btn-circle"
                                                data-toggle="tooltip" data-placement="right" 
                                                title="Permohonan Baru">
                                                <i class="fa fa-inbox"></i> 
                                                </button> Baru
                                                </div>
                                            </td>
                                        </tr>';
                                    }else if($row["application_status"]==3){	//Verified
                                        echo 
                                        '<tr class="odd gradeX">
                                            <td>'.$row["name"].'</td>
                                            <td><p class="text-uppercase"">'.$row["deceased_name"].'</p></td>
                                            <td>'.$row["deceased_ic"].'</td>
                                            <td>
                                                <div class="tooltip-demo">
                                                <button type="button" class="btn btn-success btn-circle"
                                                data-toggle="tooltip" data-placement="right" 
                                                title="Permohonan Diterima">
                                                <i class="fa fa-pencil"></i> 
                                                </button> Diterima
                                                </div>
                                            </td>
                                        </tr>';
                                    }else if($row["application_status"]==4){	//Etiqa
                                        echo 
                                        '<tr class="odd gradeX">
                                            <td>'.$row["name"].'</td>
                                            <td><p class="text-uppercase"">'.$row["deceased_name"].'</p></td>
                                            <td>'.$row["deceased_ic"].'</td>
                                            <td>
                                                <div class="tooltip-demo">
                                                <button type="button" class="btn btn-warning btn-circle"
                                                data-toggle="tooltip" data-placement="right" 
                                                title="Proses Etiqa">
                                                <i class="fa fa-send"></i> 
                                                </button> Etiqa
                                                </div>
                                            </td>
                                            <td>
                                                <div class="tooltip-demo">
                                                <a href="application_etiqa.php?app='.$row["id"].'">
                                                <button type="button" class="btn btn-info btn-circle"
                                                data-toggle="tooltip" data-placement="right" 
                                                title="Papar Butiran">
                                                <i class="fa fa-list"></i>
                                                </button></a>
                                                </div>
                                            </td>
                                        </tr>';
                                    }else if($row["application_status"]==5){	//Completed
                                        echo 
                                        '<tr class="odd gradeX">
                                            <td>'.$row["name"].'</td>
                                            <td><p class="text-uppercase"">'.$row["deceased_name"].'</p></td>
                                            <td>'.$row["deceased_ic"].'</td>
                                            <td>
												<div class="tooltip-demo">
												<button type="button" class="btn btn-success btn-circle"
												data-toggle="tooltip" data-placement="right" 
												title="Permohonan Selesai">
												<i class="fa fa-check"></i> 
												</button> Selesai
												</div>
											</td>
                                        </tr>';
                                    }else if($row["application_status"]==0){	//Rejected
                                        echo 
                                        '<tr class="odd gradeX">
                                            <td>'.$row["name"].'</td>
                                            <td><p class="text-uppercase"">'.$row["deceased_name"].'</p></td>
                                            <td>'.$row["deceased_ic"].'</td>
                                            <td>
                                                <div class="tooltip-demo">
                                                <button type="button" class="btn btn-danger btn-circle"
                                                data-toggle="tooltip" data-placement="right" 
                                                title="Permohonan Tidak Lengkap">
                                                <i class="fa fa-exclamation"></i> 
                                                </button> Tidak Lengkap
                                                </div>
                                            </td>
                                        </tr>';
                                    }
                                }	
                            }?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
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
    <!-- DataTables JavaScript -->
    <script src="../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
    
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
                responsive: true
        });
    });
    </script>
    
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
    <script src="/FBPKhairat/dist/js/sb-admin-2.js"></script>
</body>
<!-- InstanceEnd --></html>
