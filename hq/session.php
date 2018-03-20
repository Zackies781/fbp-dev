<?php
ob_start();
session_start();
require_once '../db_connect.php';

//Redirect if not login
if( !isset($_SESSION['user']) ) {
	header("Location: ../index.php");
	exit;
	
}else{

	//User Profile
//	$sql_user = "SELECT Id, user_fullname, user_access FROM fbp_user WHERE Id = '$_SESSION[user]' AND active_status = '1'";
//	$result_user = $conn->query($sql_user);
//	
//	$count = $result_user->num_rows; // if uname/pass correct it returns must be 1 row
//	
//	if( $count == 1 ) {
//		$row = $result_user->fetch_assoc();
//		
//		//Redirect according to the user access level
//		if($row[user_access]==1){
//			header("Location: home.php");
//		}else{
//			header("Location: ../index.php");
//		}
//	}else{
//		$errMSG = 1;
//	}
}
$conn->close();
?>
