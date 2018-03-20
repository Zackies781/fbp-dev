<?php
    if (isset($_POST['yearly'])) {
        # yearly-button was clicked
		header("Location: excel_report_yearly.php");
    	exit;
    }
    elseif (isset($_POST['etiqa'])) {
        # etiqa-button was clicked
		header("Location: excel_report_etiqa.php");
    	exit;
    }
?>