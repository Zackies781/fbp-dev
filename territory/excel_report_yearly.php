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

if($user_territory != '0'){
	$sql = "SELECT a.member_name, a.member_ic, a.member_relations, a.deceased_name, a.deceased_ic, a.deceased_dob,
	a.deceased_age, a.deceased_dod, a.recipient_name, a.comp_value, a.comp_etiqa_no, a.comp_etiqa_date, a.comp_fbp_no, a.comp_fbp_date,
	a.requested_date, a.verified_date, a.etiqa_date, a.completed_date, a.application_status, t.name AS territory_name, s.name AS state_name, 
	r.name AS region_name, p.name AS project_name
	FROM fbp_application a 
	LEFT JOIN fbp_territory t ON a.territory_id = t.id 
	LEFT JOIN fbp_state s ON a.state_id = s.id 
	LEFT JOIN fbp_region r ON a.region_id = r.id 
	LEFT JOIN fbp_project p ON a.project_id = p.id 
	WHERE a.active_status = '1' AND a.application_status !='1' AND a.territory_id = '$user_territory'
	ORDER BY a.updated_date DESC";
}else if ($user_territory == '0'){	
	$sql = "SELECT a.member_name, a.member_ic, a.member_relations, a.deceased_name, a.deceased_ic, a.deceased_dob,
	a.deceased_age, a.deceased_dod, a.recipient_name, a.comp_value, a.comp_etiqa_no, a.comp_etiqa_date, a.comp_fbp_no, a.comp_fbp_date,
	a.requested_date, a.verified_date, a.etiqa_date, a.completed_date, a.application_status, t.name AS territory_name, s.name AS state_name, 
	r.name AS region_name, p.name AS project_name
	FROM fbp_application a 
	LEFT JOIN fbp_territory t ON a.territory_id = t.id 
	LEFT JOIN fbp_state s ON a.state_id = s.id 
	LEFT JOIN fbp_region r ON a.region_id = r.id 
	LEFT JOIN fbp_project p ON a.project_id = p.id 
	WHERE a.active_status = '1' AND a.application_status !='1'
	ORDER BY a.updated_date DESC";
}

$result = $conn->query($sql);
$conn->close();

/** Error reporting */
error_reporting(E_ALL);
date_default_timezone_set('Asia/Kuala_Lumpur');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once '../PHPExcel/Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'BIL')
            ->setCellValue('B1', 'WILAYAH')
            ->setCellValue('C1', 'NEGERI')
            ->setCellValue('D1', 'KAWASAN')
			->setCellValue('E1', 'PROJEK')
			->setCellValue('F1', 'NAMA PENCARUM')
			->setCellValue('G1', 'NO MYKAD PENCARUM')
			->setCellValue('H1', 'HUBUNGAN')
			->setCellValue('I1', 'NAMA SIMATI')
			->setCellValue('J1', 'NO MYKAD SIMATI')
			->setCellValue('K1', 'TARIKH LAHIR SIMATI')
			->setCellValue('L1', 'UMUR SIMATI')
			->setCellValue('M1', 'TARIKH MATI SIMATI')
			->setCellValue('N1', 'NAMA PENERIMA')
			->setCellValue('O1', 'JUMLAH CEK')
			->setCellValue('P1', 'NO CEK ETIQA')
			->setCellValue('Q1', 'TARIKH CEK ETIQA')
			->setCellValue('R1', 'NO CEK FBP')
			->setCellValue('S1', 'TARIKH CEK FBP')
			->setCellValue('T1', 'TARIKH PERMOHONAN')
			->setCellValue('U1', 'TARIKH TERIMA PERMOHONAN')
			->setCellValue('V1', 'TARIKH HANTAR KE ETIQA')
			->setCellValue('W1', 'TARIKH SELESAI')
			->setCellValue('X1', 'STATUS PERMOHONAN');

// Repeat data from database
$i = 2; //default starting	
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $i-1);
		$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $row["territory_name"]);
		$objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $row["state_name"]);
		$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $row["region_name"]);
		$objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $row["project_name"]);
		$objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $row["member_name"]);
		$objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $row["member_ic"]);
		$objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $row["member_relations"]);
		$objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $row["deceased_name"]);
		$objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $row["deceased_ic"]);
		$objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $row["deceased_dob"]);
		$objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $row["deceased_age"]);
		$objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $row["deceased_dod"]);
		$objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $row["recipient_name"]);
		$objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $row["comp_value"]);
		$objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $row["comp_etiqa_no"]);
		$objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, $row["comp_etiqa_date"]);
		$objPHPExcel->getActiveSheet()->setCellValue('R' . $i, $row["comp_fbp_no"]);
		$objPHPExcel->getActiveSheet()->setCellValue('S' . $i, $row["comp_fbp_date"]);
		$objPHPExcel->getActiveSheet()->setCellValue('T' . $i, $row["requested_date"]);
		$objPHPExcel->getActiveSheet()->setCellValue('U' . $i, $row["verified_date"]);
		$objPHPExcel->getActiveSheet()->setCellValue('V' . $i, $row["etiqa_date"]);
		$objPHPExcel->getActiveSheet()->setCellValue('W' . $i, $row["completed_date"]);
		if($row["application_status"]=='2'){
			$objPHPExcel->getActiveSheet()->setCellValue('X' . $i, "BARU");
		}elseif($row["application_status"]=='3'){
			$objPHPExcel->getActiveSheet()->setCellValue('X' . $i, "DITERIMA");
		}elseif($row["application_status"]=='4'){
			$objPHPExcel->getActiveSheet()->setCellValue('X' . $i, "PROSES ETIQA");
		}elseif($row["application_status"]=='5'){
			$objPHPExcel->getActiveSheet()->setCellValue('X' . $i, "SELESAI");
		}elseif($row["application_status"]=='0'){
			$objPHPExcel->getActiveSheet()->setCellValue('X' . $i, "TIDAK LENGKAP");
		}
		$i++;
	}
}

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Laporan Bulanan');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Laporan_Khairat.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
?>