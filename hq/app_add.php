<?php
require_once '../db_connect.php';

$time = time();

//remove whitespace
$address_member = strip_tags(trim($_POST[member_address]));
$address_recipient = strip_tags(trim($_POST[recipient_address]));

If (isset ($_POST[submit])){
	$sql_insert = "INSERT INTO fbp_application 
	(deceased_name, deceased_ic, deceased_dod, deceased_age, territory_id, state_id, region_id, project_id,
	member_name, member_ic, member_relations, member_address, member_postcode, member_tel_home, member_tel_office, 	
	member_tel_mobile, member_fax, recipient_name, recipient_address, recipient_postcode, recipient_tel_home, 
	recipient_tel_office, recipient_tel_mobile, recipient_fax,	application_status, drafted_date, drafted_id, 
	updated_date, updated_id,active_status) 
	VALUES ('$_POST[deceased_name]', '$_POST[deceased_ic]', 
	'$_POST[deceased_dod]', '$_POST[deceased_age]','$_POST[territory]', '$_POST[state]', '$_POST[region]', 
	'$_POST[project]', '$_POST[member_name]', '$_POST[member_ic]', '$_POST[member_relations]', 
	'$address_member', '$_POST[member_postcode]','$_POST[member_tel_home]', '$_POST[member_tel_office]', 
	'$_POST[member_tel_mobile]', '$_POST[member_fax]','$_POST[recipient_name]', '$address_recipient', 
	'$_POST[recipient_postcode]', '$_POST[recipient_tel_home]','$_POST[recipient_tel_office]',
	'$_POST[recipient_tel_mobile]', '$_POST[recipient_fax]', '1', '$_POST[drafted_date]', '$_POST[drafted_id]',
	'$_POST[updated_date]', '$_POST[updated_id]', '1')";
	
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