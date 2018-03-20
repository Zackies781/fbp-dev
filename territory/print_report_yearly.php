<?php
//DB connection
require_once '../db_connect.php';
//PDF printing
require('../fpdf/fpdf.php');

//application
$sql_app = "SELECT DISTINCT * FROM fbp_application WHERE ACTIVE_STATUS='1'";
$result_app = $conn->query($sql_app);

//region
$sql_region = "SELECT DISTINCT id, code, name FROM fbp_region";
$result_region = $conn->query($sql_region);

//Get region
if ($result_region->num_rows > 0) {
	// output data of each row
	while($row = $result_region->fetch_assoc()) { 
		if($row["id"]==$row_app["region_id"]){
			$region = $row["name"];
		}
	}	
}

//set time zone
date_default_timezone_set('Asia/Kuala_Lumpur');
//get current date
$today_day = date("d");
$today_month = date("M");
$today_year = date("Y");

class PDF extends FPDF
{
	// Page header
	function Header()
	{
		// Logo
		$this->Image('../images/Logo_Felcra.png',10,6,20);
		// Arial bold 15
		$this->SetFont('Arial','BI',12);
		// Move to the right
		$this->Cell(80);
		// Title
		$this->Cell(10,13,'LAPORAN TAHUNAN INSURAN TAKAFUL PESERTA',0,1);
		// Logo
		$this->Image('../images/Logo_Etiqa.png',260,10,30);
		// Arial bold 15
		$this->SetFont('Arial','',8);
		// Line break
		$this->Ln(3);
	}
}

// Instanciation of inherited class
$pdf = new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();

//Line break
$pdf->Ln(5);

//Table Header
$pdf->SetFont('Times','',10);
$pdf->Cell(10,5,'BIL' ,'TBLR',0);
$pdf->Cell(40,5,'KAWASAN' ,'TBLR',0);
$pdf->Cell(70,5,'NAMA AHLI' ,'TBLR',0);
$pdf->Cell(25,5,'NO MYKAD' ,'TBLR',0);
$pdf->Cell(70,5,'NAMA SIMATI' ,'TBLR',0);
$pdf->Cell(25,5,'NO MYKAD' ,'TBLR',0);
$pdf->Cell(35,5,'STATUS' ,'TBLR',1);

//Data
$i = 1; //default starting	
if ($result_app->num_rows > 0) {
	// output data of each row
	while($row_app = $result_app->fetch_assoc()) { 

	$pdf->Cell(10,5, $i,'TBLR',0);
	$pdf->Cell(40,5, '','TBLR',0);
	$pdf->Cell(70,5, $row_app["member_name"],'TBLR',0);
	$pdf->Cell(25,5, $row_app["member_ic"],'TBLR',0);
	$pdf->Cell(70,5, $row_app["deceased_name"],'TBLR',0);
	$pdf->Cell(25,5, $row_app["deceased_ic"],'TBLR',0);
	if($row["application_status"]==1){ $pdf->Cell(35,5, 'DERAF','TBLR',1);}
	elseif($row["application_status"]==2){ $pdf->Cell(35,5, 'BARU','TBLR',1);}
	elseif($row["application_status"]==3){ $pdf->Cell(35,5, 'DITERIMA','TBLR',1);}
	elseif($row["application_status"]==4){ $pdf->Cell(35,5, 'ETIQA','TBLR',1);}
	elseif($row["application_status"]==5){ $pdf->Cell(35,5, 'SELESAI','TBLR',1);}
	elseif($row["application_status"]==0){ $pdf->Cell(35,5, 'TIDAK LENGKAP','TBLR',1);}
	
	$i++;
	}
}
$pdf->Output();
?>