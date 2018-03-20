<?php
//DB connection
require_once '../db_connect.php';
//PDF printing
require('../fpdf/fpdf.php');

//set application id
if(isset($_GET["app"])){
	$id = $_GET["app"];
}

$sql_app = "SELECT DISTINCT * FROM fbp_application WHERE Id=$id";
$result_app = $conn->query($sql_app);
if ($result_app->num_rows > 0) {
	$row_app = $result_app->fetch_assoc();
}

$sql_region = "SELECT DISTINCT id, code, name FROM fbp_region";
$result_region = $conn->query($sql_region);

$sql_project = "SELECT DISTINCT id, code, name FROM fbp_project";
$result_project = $conn->query($sql_project);

//Get region
if ($result_region->num_rows > 0) {
	// output data of each row
	while($row = $result_region->fetch_assoc()) { 
		if($row["id"]==$row_app["region_id"]){
			$region = $row["name"];
		}
	}	
}
//Get project
if ($result_project->num_rows > 0) {
	// output data of each row
	while($row = $result_project->fetch_assoc()) { 
		if($row["id"]==$row_app["project_id"]){
			$project = $row["name"];
		}
	}	
}
//variables declaration
$member_name = $row_app["member_name"];
$member_ic = $row_app["member_ic"];

$deceased_name = $row_app["deceased_name"];
$deceased_ic = $row_app["deceased_ic"];
$deceased_relation = $row_app["member_relations"];

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
		$this->Image('../images/Logo_Felcra.png',20,6,30);
		// Arial bold 15
		$this->SetFont('Arial','BI',30);
		// Move to the right
		$this->Cell(60);
		// Title
		$this->Cell(30,20,'FELCRA Berhad',0,1);
		// Line break
		$this->Ln(5);
		// Arial bold 15
		$this->SetFont('Arial','B',11);
		// Move to the right
		$this->Cell(20);
		//Address
		$this->MultiCell(150,5,'FELCRA BERHAD HEADQUARTER, WISMA FELCRA, LOT 4780, 
		JALAN REJANG, SETAPAK JAYA, PETI SURAT 12254, 50772 KUALA LUMPUR.
		TEL : 03 - 4145 5000 | FAX : 03 - 4142 8162' ,0,'C');
		// Line
		$this->Cell(30,3,'_____________________________________________________________________________________',0,1);
	}
}

// Instanciation of inherited class
$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);

// Line break
$pdf->Ln(5);
$pdf->Cell(0,5,'FELCRA Berhad (01-111) 101/5 Klt. 5-1('.$row_app["Id"].')' ,0,1);
$pdf->Cell(0,5, $today_day.'hb '. $today_month .', '. $today_year,0,1);
$pdf->Ln(5);
$pdf->MultiCell(0,5,'Etiqa Takaful Berhad, 
Maybank Insurance Tower,
Dataran Maybank
No. 1 Jalan Maarof,
69000 Kuala Lumpur' ,0,'L');
$pdf->Ln(5);
$pdf->Cell(0,5,'Tuan,' ,0,1);
$pdf->Ln(5);
$pdf->SetFont('Times','B',12);
$pdf->MultiCell(0,5,'PENGESAHAN SEBAGAI PESERTA FELCRA BERHAD TUNTUTAN INSURANS KHAIRAT
KEMATIAN FELCRA BERHAD KAWASAN '.$region ,0,'L');
$pdf->SetFont('Times','',12);
$pdf->Ln(5);
$pdf->Cell(0,5,'Perkara di atas adalah dirujuk.' ,0,1);
$pdf->Ln(5);
$pdf->MultiCell(0,5,'2.     Bahawa saya mengesahkan nama '.$member_name.' No. Kad Pengenalan '.$member_ic.' adalah PESERTA Projek FELCRA Berhad '.$project.'.',0,'L');
$pdf->Ln(5);

if ($deceased_relation == "IBU BAPA"){ 
$pdf->MultiCell(0,5,'3.     Bahawa saya mengesahkan nama '.$deceased_name.' No. Kad Pengenalan '.$deceased_ic.' adalah ANAK kepada peserta sepertimana di atas.',0,'L');
}else if ($deceased_relation == "PASANGAN"){ 
$pdf->MultiCell(0,5,'3.     Bahawa saya mengesahkan nama '.$deceased_name.' No. Kad Pengenalan '.$deceased_ic.' adalah PASANGAN kepada peserta sepertimana di atas.',0,'L');
}

$pdf->Ln(5);
$pdf->Cell(0,5,'Sekian, untuk makluman dan tindakan tuan selanjutnya.' ,0,1);
$pdf->Ln(5);
$pdf->Cell(0,5,'Terima kasih.' ,0,1);
$pdf->Ln(5);
$pdf->SetFont('Times','BI',12);
$pdf->Cell(70);
$pdf->Cell(0,5,'"Membandarkan Luar Bandar"' ,0,1);
$pdf->Ln(10);
$pdf->SetFont('Times','',12);
$pdf->Cell(0,5,'Yang Benar,' ,0,1);
$pdf->Output();
?>