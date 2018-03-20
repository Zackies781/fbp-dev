<?php
require_once '../db_connect.php';

//Update profile
if (isset ($_POST[update])){

	//SQL Update
	$sql_update = "UPDATE fbp_user SET 
	user_fullname='$_POST[user_fullname]', 
	user_ic='$_POST[user_ic]',
	user_email='$_POST[user_email]',
	user_tel_mobile='$_POST[user_no_tel]',
	updated_date='$_POST[current_date]',
	updated_id='$_POST[current_id]'
	WHERE id='$_POST[app_id]'";
	
	if (mysqli_query($conn, $sql_update)) {
		header("Location: profile_main.php?success=1");
		exit;
	} else {
		header("Location: profile_main.php?fail=1");
		exit;
	}
}
//Save new password
else if (isset ($_POST[save_password])){

	$password_old = $_POST['user_password_old'];
	$password_new = $_POST['user_password_new'];
	  
	$password_old = strip_tags(trim($password_old));
	$password_new = strip_tags(trim($password_new));
	
	//SQL Select
	$sql = "SELECT * FROM fbp_user
	WHERE id ='$_POST[current_id]' AND password = MD5('$password_old')";
	$result = $conn->query($sql);
	
	if ($result->num_rows == 1) {
		//SQL Update
		$sql_update = "UPDATE fbp_user SET 
		password=MD5('$password_new'), 
		updated_date='$_POST[current_date]',
		updated_id='$_POST[current_id]'
		WHERE id='$_POST[app_id]'";
		
		if (mysqli_query($conn, $sql_update)) {
			header("Location: profile_main.php?success=2");
			exit;
		} else {
			header("Location: profile_main.php?fail=2");
			exit;
		}
	}else{
		header("Location: profile_main.php?fail=3");
		exit;
	}
}

$conn->close();
?>