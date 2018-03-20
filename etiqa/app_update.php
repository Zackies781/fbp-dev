<?php
require_once '../db_connect.php';

//Updated
If (isset ($_POST[save])){
	
	//Trim string
	$address1 = ltrim($_POST[member_address]);
	$address2 = ltrim($_POST[recipient_address]);
	
	//Upload file
	$target_dir = "../uploads/";
	$target_file = $target_dir . basename($_FILES["file_death_cert"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	
	
	
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["file_death_cert"]["tmp_name"], $target_file)) {
			echo "The file ". basename( $_FILES["file_death_cert"]["name"]). " has been uploaded.";
		} else {
			echo "Sorry, there was an error uploading your file.";
		}
	}
	
	//SQL
	$sql_update = "UPDATE fbp_application SET 
	deceased_name='$_POST[deceased_name]', 
	deceased_ic='$_POST[deceased_ic]', 
	deceased_dod='$_POST[deceased_dod]', 
	deceased_age='$_POST[deceased_age]', 
	territory_id='$_POST[territory]', 
	state_id='$_POST[state]', 
	region_id='$_POST[region]',
	project_id='$_POST[project]',
	member_name='$_POST[member_name]',
	member_ic='$_POST[member_ic]',
	member_relations='$_POST[member_relations]',
	member_address='$address1',
	member_postcode='$_POST[member_postcode]',
	member_tel_home='$_POST[member_tel_home]',
	member_tel_office='$_POST[member_tel_office]',
	member_tel_mobile='$_POST[member_tel_mobile]',
	member_fax='$_POST[member_fax]',
	recipient_name='$_POST[recipient_name]',
	recipient_address='$_POST[recipient_address]',
	recipient_postcode='$_POST[recipient_postcode]',
	recipient_tel_home='$_POST[recipient_tel_home]',
	recipient_tel_office='$_POST[recipient_tel_office]',
	recipient_tel_mobile='$_POST[recipient_tel_mobile]',
	recipient_fax='$_POST[recipient_fax]',
	file_death_cert_link='$target_file',
	file_death_cert_type='$_POST[file_death_cert_type]',
	file_death_cert_size='$_POST[file_death_cert_size]',
	application_comments='$_POST[application_comments]',
	updated_date='$_POST[current_date]',
	updated_id='$_POST[current_id]'
	WHERE id='$_POST[app_id]'";
	
	if (mysqli_query($conn, $sql_update)) {
		header("Location: home.php?success=2");
   	 	exit;
	} else {
		//echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		header("Location: home.php?fail=2");
    	exit;
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

//Verified
elseif (isset ($_POST['verify'])){
	
	//SQL
	$sql_update = "UPDATE fbp_application SET 
	verified_date='$_POST[current_date]',
	verified_id='$_POST[current_id]',
	updated_date='$_POST[current_date]',
	updated_id='$_POST[current_id]',
	application_status='3'
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

//Etiqa
elseif (isset ($_POST['etiqa'])){
	
	//SQL
	$sql_update = "UPDATE fbp_application SET 
	etiqa_date='$_POST[current_date]',
	etiqa_id='$_POST[current_id]',
	updated_date='$_POST[current_date]',
	updated_id='$_POST[current_id]',
	application_status='4'
	WHERE id='$_POST[app_id]'"; 
	
	if (mysqli_query($conn, $sql_update)) {
		header("Location: home.php?success=5");
   	 	exit;
	} else {
		//echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		header("Location: home.php?fail=3");
    	exit;
	}
}

//FBP
elseif (isset ($_POST['fbp'])){
	
	//SQL
	$sql_update = "UPDATE fbp_application SET 
	etiqa_date='$_POST[current_date]',
	etiqa_id='$_POST[current_id]',
	updated_date='$_POST[current_date]',
	updated_id='$_POST[current_id]',
	application_status='4'
	WHERE id='$_POST[app_id]'"; 
	
	if (mysqli_query($conn, $sql_update)) {
		header("Location: home.php?success=6");
   	 	exit;
	} else {
		//echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		header("Location: home.php?fail=3");
    	exit;
	}
}

//Completed
elseif (isset ($_POST['complete'])){
	
	//SQL
	$sql_update = "UPDATE fbp_application SET 
	completed_date='$_POST[current_date]',
	completed_id='$_POST[current_id]',
	updated_date='$_POST[current_date]',
	updated_id='$_POST[current_id]',
	application_status='5'
	WHERE id='$_POST[app_id]'"; 
	
	if (mysqli_query($conn, $sql_update)) {
		header("Location: home.php?success=7");
   	 	exit;
	} else {
		//echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		header("Location: home.php?fail=3");
    	exit;
	}
}

//Rejected
elseif (isset ($_POST['reject'])){
	
	//SQL
	$sql_update = "UPDATE fbp_application SET 
	application_comments='$_POST[application_comments]',
	rejected_date='$_POST[current_date]',
	rejected_id='$_POST[current_id]',
	updated_date='$_POST[current_date]',
	updated_id='$_POST[current_id]',
	application_status='0'
	WHERE id='$_POST[app_id]'"; 
	
	if (mysqli_query($conn, $sql_update)) {
		header("Location: home.php?success=8");
   	 	exit;
	} else {
		//echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		header("Location: home.php?fail=3");
    	exit;
	}
}

//Save Check 1
elseif (isset ($_POST['save_check'])){
	
	//convert date 
	$date = DateTime::createFromFormat('j-m-Y', $_POST['etiqa_date']);
	$etiqa_date = $date->format('Y-m-d'); 
	
	//SQL
	$sql_update = "UPDATE fbp_application SET 
	comp_etiqa_no='$_POST[etiqa_no]',
	comp_etiqa_date='$etiqa_date',
	comp_value='$_POST[check_value]',
	updated_date='$_POST[current_date]',
	updated_id='$_POST[current_id]'
	WHERE id='$_POST[app_id]'"; 
	
	if (mysqli_query($conn, $sql_update)) {
		header("Location: home.php?success=2");
   	 	exit;
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		//header("Location: home.php?fail=3");
    	//exit;
	}
}

//Save Check 2
elseif (isset ($_POST['save_check2'])){
	
	//convert date 
	$date = DateTime::createFromFormat('j-m-Y', $_POST['fbp_date']);
	$fbp_date = $date->format('Y-m-d');
	
	//SQL
	$sql_update = "UPDATE fbp_application SET 
	comp_fbp_no='$_POST[fbp_no]',
	comp_fbp_date='$fbp_date',
	comp_value='$_POST[check_value]',
	updated_date='$_POST[current_date]',
	updated_id='$_POST[current_id]'
	WHERE id='$_POST[app_id]'"; 
	
	if (mysqli_query($conn, $sql_update)) {
		header("Location: home.php?success=2");
   	 	exit;
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		//header("Location: home.php?fail=3");
    	//exit;
	}
}
$conn->close();
?>