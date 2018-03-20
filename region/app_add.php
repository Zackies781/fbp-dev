<?php
require_once '../db_connect.php';

//remove whitespace
$deceased_name = strip_tags(trim($_POST[deceased_name]));
$member_name = strip_tags(trim($_POST[member_name]));
$recipient_name = strip_tags(trim($_POST[recipient_name]));
$member_address = strip_tags(trim($_POST[member_address]));
$recipient_address = strip_tags(trim($_POST[recipient_address]));

//uppercase
$deceased_name = strtoupper($deceased_name);
$member_name = strtoupper($member_name);
$recipient_name = strtoupper($recipient_name);
$member_address = strtoupper($member_address);
$recipient_address = strtoupper($recipient_address);

//convert date 
$date = DateTime::createFromFormat('j-m-Y', $_POST[deceased_dod]);
$deceased_dod = $date->format('Y-m-d'); 
$date = DateTime::createFromFormat('j-m-Y', $_POST[deceased_dob]);
$deceased_dob = $date->format('Y-m-d'); 

//Generate reference no 
date_default_timezone_set('Asia/Kuala_Lumpur');
$ref_no = 'KH'. time() . rand(10*45, 100*98);

If (isset ($_POST[submit])){
	$sql_insert = "INSERT INTO fbp_application 
	(ref_no, deceased_name, deceased_ic, deceased_dod, deceased_dob, deceased_age, deceased_diagnosis,
	territory_id, state_id, region_id, project_id,
	member_name, member_ic, member_relations, member_address, member_postcode, member_tel_home, member_tel_office, 	
	member_tel_mobile, member_fax, recipient_name, recipient_address, recipient_postcode, recipient_tel_home, 
	recipient_tel_office, recipient_tel_mobile, recipient_fax,	application_status, drafted_date, drafted_id, 
	updated_date, updated_id,active_status) 
	VALUES ('$ref_no', '$deceased_name', '$_POST[deceased_ic]', 
	'$deceased_dod','$deceased_dob', '$_POST[deceased_age]', '$_POST[deceased_diagnosis]',
	'$_POST[territory]', '$_POST[state]', '$_POST[region]', 
	'$_POST[project]', '$member_name', '$_POST[member_ic]', '$_POST[member_relations]', 
	'$member_address', '$_POST[member_postcode]','$_POST[member_tel_home]', '$_POST[member_tel_office]', 
	'$_POST[member_tel_mobile]', '$_POST[member_fax]','$recipient_name', '$recipient_address', 
	'$_POST[recipient_postcode]', '$_POST[recipient_tel_home]','$_POST[recipient_tel_office]',
	'$_POST[recipient_tel_mobile]', '$_POST[recipient_fax]', '1', '$_POST[current_date]', '$_POST[current_id]',
	'$_POST[current_date]', '$_POST[current_id]', '1')";
	
	if (mysqli_query($conn, $sql_insert)) {
		header("Location: home.php?success=1");
   	 	exit;
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		//header("Location: home.php?fail=1");
    	//exit;
	}
}

$conn->close();
?>