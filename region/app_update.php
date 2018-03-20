<?php
require_once '../db_connect.php';

//remove whitespace
$deceased_name = strip_tags(trim($_POST['deceased_name']));
$recipient_name = strip_tags(trim($_POST['recipient_name']));
$member_address = strip_tags(trim($_POST['member_address']));
$recipient_address = strip_tags(trim($_POST['recipient_address']));

//uppercase
$deceased_name = strtoupper($deceased_name);
$recipient_name = strtoupper($recipient_name);
$member_address = strtoupper($member_address);
$recipient_address = strtoupper($recipient_address);

//convert date 
$date = DateTime::createFromFormat('j-m-Y', $_POST['deceased_dod']);
$deceased_dod = $date->format('Y-m-d'); 
$date = DateTime::createFromFormat('j-m-Y', $_POST['deceased_dob']);
$deceased_dob = $date->format('Y-m-d');

//file upload location
$folder = "../uploads/";

//Updated
if (isset ($_POST['save'])){
	
	//file_death_cert
	$temp = explode(".", $_FILES['file_death_cert']['name']);
	$file_name = $_POST['ref_no'].'_death_cert.'.end($temp);
	$file_loc = $_FILES['file_death_cert']['tmp_name'];
	$target_file = $folder . basename($_FILES["file_death_cert"]["name"]);
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	
	//file_deceased_ic
	$temp2 = explode(".", $_FILES['file_deceased_ic']['name']);
	$file_name2 = $_POST['ref_no'].'_deceased_ic.'.end($temp2);
	$file_loc2 = $_FILES['file_deceased_ic']['tmp_name'];
	$target_file2 = $folder . basename($_FILES["file_deceased_ic"]["name"]);
	$imageFileType2 = pathinfo($target_file2,PATHINFO_EXTENSION);
	
	//file_recipient_ic
	$temp3 = explode(".", $_FILES['file_recipient_ic']['name']);
	$file_name3 = $_POST['ref_no'].'_recipient_ic.'.end($temp3);
	$file_loc3 = $_FILES['file_recipient_ic']['tmp_name'];
	$target_file3 = $folder . basename($_FILES["file_recipient_ic"]["name"]);
	$imageFileType3 = pathinfo($target_file3,PATHINFO_EXTENSION);

	//file_recipient_cert
	$temp4 = explode(".", $_FILES['file_recipient_cert']['name']);
	$file_name4 = $_POST['ref_no'].'_recipient_cert.'.end($temp4);
	$file_loc4 = $_FILES['file_recipient_cert']['tmp_name'];
	$target_file4 = $folder . basename($_FILES["file_recipient_cert"]["name"]);
	$imageFileType4 = pathinfo($target_file4,PATHINFO_EXTENSION);
	
	// Allow certain file formats & Check file size
	if($imageFileType != "pdf" || $imageFileType2 != "pdf" || $imageFileType3 != "pdf" || $imageFileType4 != "pdf") {
		header("Location: home.php?fail=5");
		exit;
	}if ($_FILES["file_death_cert"]["size"] > 500000 || $_FILES["file_deceased_ic"]["size"] > 500000 || 
		$_FILES["file_recipient_ic"]["size"] > 500000 || $_FILES["file_recipient_cert"]["size"] > 500000) {
		header("Location: home.php?fail=6");
		exit;
	}else{
		move_uploaded_file($file_loc,$folder.$file_name);
		move_uploaded_file($file_loc2,$folder.$file_name2);
		move_uploaded_file($file_loc3,$folder.$file_name3);
		move_uploaded_file($file_loc4,$folder.$file_name4);
	}

	//SQL
	$sql_update = "UPDATE fbp_application SET 
	deceased_name='$deceased_name',
	deceased_ic='$_POST[deceased_ic]', 
	deceased_dod='$deceased_dod',
	deceased_dob='$deceased_dob',
	deceased_age='$_POST[deceased_age]', 
	deceased_diagnosis='$_POST[deceased_diagnosis]',
	member_relations='$_POST[member_relations]',
	member_address='$member_address',
	member_postcode='$_POST[member_postcode]',
	member_tel_home='$_POST[member_tel_home]',
	member_tel_office='$_POST[member_tel_office]',
	member_tel_mobile='$_POST[member_tel_mobile]',
	member_fax='$_POST[member_fax]',
	recipient_name='$recipient_name',
	recipient_address='$recipient_address',
	recipient_postcode='$_POST[recipient_postcode]',
	recipient_tel_home='$_POST[recipient_tel_home]',
	recipient_tel_office='$_POST[recipient_tel_office]',
	recipient_tel_mobile='$_POST[recipient_tel_mobile]',
	recipient_fax='$_POST[recipient_fax]',
	file_death_cert='$file_name',
	file_deceased_ic='$file_name2',
	file_recipient_ic='$file_name3',
	file_recipient_cert='$file_name4',
	updated_date='$_POST[current_date]',
	updated_id='$_POST[current_id]'
	WHERE id='$_POST[app_id]'";
	
	if (mysqli_query($conn, $sql_update)) {
		header("Location: home.php?success=2");
   	 	exit;
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		//header("Location: home.php?fail=2");
    	//exit;
	}
}

//Requested
elseif (isset ($_POST['request'])){
	
	//SQL
	$sql_update = "UPDATE fbp_application SET 
	requested_date='$_POST[current_date]',
	requested_id='$_POST[current_id]',
	updated_date='$_POST[current_date]',
	updated_id='$_POST[current_id]',
	application_status='2'
	WHERE id='$_POST[app_id]'"; 
	
	if (mysqli_query($conn, $sql_update)) {
		header("Location: home.php?success=3");
   	 	exit;
	} else {
		//echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		header("Location: home.php?fail=3");
    	exit;
	}
}

//delete
elseif (isset ($_POST['delete'])){
	
	//SQL
	$sql_update = "UPDATE fbp_application SET 
	deleted_date='$_POST[current_date]',
	deleted_id='$_POST[current_id]',
	updated_date='$_POST[current_date]',
	updated_id='$_POST[current_id]',
	active_status='0'
	WHERE id='$_POST[app_id]'"; 
	
	if (mysqli_query($conn, $sql_update)) {
		header("Location: home.php?success=4");
   	 	exit;
	} else {
		//echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		header("Location: home.php?fail=3");
    	exit;
	}
}

$conn->close();
?>