<?php
ob_start();
session_start();
require_once '../db_connect.php';

//Redirect if not login
if( !isset($_SESSION['user']) ) {
	header("Location: ../index.php");
	exit;
}

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
            ->setCellValue('A1', 'NO')
            ->setCellValue('B1', 'CLIENT/ PARTICIPANT STATE/ PLACE')
            ->setCellValue('C1', 'CERTIFICATE NO/ CONTRACT HOLDER NO')
            ->setCellValue('D1', 'TAKAFUL PLAN/ PRODUCT')
			->setCellValue('E1', 'TITLE NAME')
			->setCellValue('F1', 'PARTICIPANT/CLIENT NAME')
			->setCellValue('G1', 'PARTICIPANT/CLIENT I/C NO')
			->setCellValue('H1', 'DECEASED\'S NAME')
			->setCellValue('I1', 'DECEASED\'S I/C NO')
			->setCellValue('J1', 'DECEASED\'S AGE')
			->setCellValue('K1', 'DATE OF DEATH/ DATE OF EVENT')
			->setCellValue('L1', 'TYPE OF CLAIM')
			->setCellValue('M1', 'AMOUNT')
			->setCellValue('N1', 'CAUSE OF CLAIM/ DIAGNOSIS')
			->setCellValue('O1', 'RELATIONSHIP');

// Repeat data from database
$i = 2; //default starting	
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $i-1);
		$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $row["region_name"]);
		$objPHPExcel->getActiveSheet()->setCellValue('C' . $i, 'TGKW000365');
		$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, 'KHAIRAT');
		$objPHPExcel->getActiveSheet()->setCellValue('E' . $i, 'EN');
		$objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $row["member_name"]);
		$objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $row["member_ic"]);
		$objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $row["deceased_name"]);
		$objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $row["deceased_ic"]);
		$objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $row["deceased_age"]);
		$objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $row["deceased_dod"]);
		$objPHPExcel->getActiveSheet()->setCellValue('L' . $i, 'Natural Death');
		$objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $row["comp_value"]);
		$objPHPExcel->getActiveSheet()->setCellValue('N' . $i, "");
		
		if($row["member_relations"]=='DIRI SENDIRI'){
			$objPHPExcel->getActiveSheet()->setCellValue('O' . $i, 'AHLI');
		}else if($row["member_relations"]=='PASANGAN'){
			$objPHPExcel->getActiveSheet()->setCellValue('O' . $i, 'PASANGAN');
		}else{
			$objPHPExcel->getActiveSheet()->setCellValue('O' . $i, 'ANAK');
		}
		
	
		$i++;
	}
}

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Laporan Etiqa');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Laporan_Etiqa.xls"');
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