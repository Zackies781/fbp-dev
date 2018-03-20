<?php
require_once '../db_connect.php';

//remove whitespace
$user_fullname = strip_tags(trim($_POST[user_fullname]));

//uppercase
$user_fullname = strtoupper($user_fullname);


if (isset ($_POST[submit])){
	$sql_insert = "INSERT INTO fbp_user
	(username, password, user_fullname, user_ic, user_email, user_tel_mobile, user_territory_id, user_region_id, user_access,
	created_date, created_id, active_status) 
	VALUES 
	('$_POST[username]', 'asdf1234', '$user_fullname', '$_POST[user_ic]', '$_POST[user_email]', '$_POST[user_tel_mobile]', 
	'$_POST[user_territory]', '$_POST[user_region]', '$_POST[user_access]', 
	'$_POST[current_date]', '$_POST[current_id]', '1')";
	
	$sql_update = "UPDATE fbp_user SET Password = MD5('asdf1234') WHERE username = '$_POST[username]'";
	
	if (mysqli_query($conn, $sql_insert)) {
		mysqli_query($conn, $sql_update);
		header("Location: user_main.php?success=1");
  		 	exit;
	} else {
		header("Location: user_main.php?fail=1");
    	exit;
	}
}
elseif (isset ($_POST[update])){
	$sql_update = "UPDATE fbp_user SET
	user_fullname='$user_fullname', 
	user_ic='$_POST[user_ic]', 
	user_email='$_POST[user_email]', 
	user_tel_mobile='$_POST[user_tel_mobile]', 
	user_territory_id='$_POST[user_territory]', 
	user_region_id='$_POST[user_region]', 
	user_access='$_POST[user_access]',
	updated_date='$_POST[current_date]', 
	updated_id='$_POST[current_id]'
	WHERE id='$_POST[app_id]'";
	
	if (mysqli_query($conn, $sql_update)) {
		header("Location: user_main.php?success=2");
  		 	exit;
	} else {
		header("Location: user_main.php?fail=1");
    	exit;
	}
}

$conn->close();
?>