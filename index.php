<?php
ob_start();
session_start();
require_once 'db_connect.php';
 
// it will never let you open index(login) page if session is set
if ( isset($_SESSION['user'])!="" ) {
	header("Location: hq/home.php");
	exit;
}

If( isset($_POST['btn_login']) ) { 
 
	$username = $_POST['txt_username'];
	$password = $_POST['txt_password'];
	  
	$username = strip_tags(trim($username));
	$password = strip_tags(trim($password));
	  
	//$password = hash('sha256', $upass); // password hashing using SHA256
	  
	$sql = "SELECT Id, username, password, user_access FROM fbp_user
	WHERE username='$username' AND password=MD5('$password') AND active_status='1'";
	
	$result = $conn->query($sql);
	  
	$count = $result->num_rows; // if uname/pass correct it returns must be 1 row
	  
	if( $count == 1 ) {
		$row = $result->fetch_assoc();
		$_SESSION['user'] = $row['Id'];
		
		//Redirect according to the user access level
		if($row[user_access]==1){
			header("Location: hq/home.php");
		}elseif($row[user_access]==2){
			header("Location: region/home.php");
		}elseif($row[user_access]==3){
			header("Location: territory/home.php");
		}elseif($row[user_access]==4){
			header("Location: etiqa/home.php");
		}
	}else{
		$errMSG = 1;
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>FBP - Sistem Pengurusan Insurans Takaful Peserta</title>

    <!-- Bootstrap Core CSS -->
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    <!-- Custom Tab Icon -->
    <link rel="icon" href="../images/FECLRA.png">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body background="images/crisp_paper_ruffles.png">
<br>
    <div class="container">
    	<div class="row">
            <div class="col-lg-12">
            <div class="panel panel-default">
            <div class="panel-body" align="center">
            <img src="images/logoFBPSB.jpg" class="img-responsive" width="400">
            </div>
            <div class="panel-footer" align="center">
            	<h2 align="center"><p class="text-primary">Sistem Pengurusan Insurans Takaful Peserta</p></h2>
            </div>
            </div>
            </div>
        	<!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <br>
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Sila Log Masuk</h3>
                    </div>
                    <div class="panel-body">
                         <form id="frm_login" data-toggle="validator" method="post">
                            <fieldset>
								<?php 
                                if(isset ($errMSG)){
									echo '<div class="alert alert-danger" align="center">
									Nama pengguna atau kata laluan <strong>salah!</strong>.
									</div>';
                                } ?>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Nama pengguna" name="txt_username" 
                                    type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Kata laluan" name="txt_password" 
                                    type="password" value="">
                                </div>
                                <button id="btn_login" name="btn_login" type="submit" 
                                class="btn btn-success btn-lg btn-block">Log Masuk</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

</body>

</html>