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

//state
$sql_state = "SELECT DISTINCT id, code, name FROM fbp_state";
$result_state = $conn->query($sql_state);

//region
$sql_region = "SELECT DISTINCT id, code, name FROM fbp_region";
$result_region = $conn->query($sql_region);

//project
$sql_project = "SELECT DISTINCT id, code, name FROM fbp_project";
$result_project = $conn->query($sql_project);

//Get state
if ($result_state->num_rows > 0) {
	// output data of each row
	while($row = $result_state->fetch_assoc()) { 
		if($row["id"]==$row_app["state_id"]){
			$state = $row["name"];
		}
	}	
}
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
		$this->Image('../images/Logo_Felcra.png',10,6,20);
		// Arial bold 15
		$this->SetFont('Arial','BI',12);
		// Move to the right
		$this->Cell(60);
		// Title
		$this->Cell(30,13,'BORANG PENGURUSAN TUNTUTAN',0,1);
		// Logo
		$this->Image('../images/Logo_Etiqa.png',170,10,30);
		// Arial bold 15
		$this->SetFont('Arial','',8);
		// Line break
		$this->Ln(3);
		//Note
		$this->MultiCell(190,3.5,'Nota :     
Dengan bayaran manfaat "Khairat Kematian" ini maka FELCRA Bekalan & Perkhdmatan Sdn. Bhd. dan Etiqa Takaful Berhad tidak lagi mempunyai apa-apa tanggungan ke atas tuntutan ahli/simati ini dan berhak menolak sebarang tuntutan dan mana-mana pihak yang mewakili pihak ahli/simati.' ,1,'J');
	}
}

// Instanciation of inherited class
$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();

//Line break
$pdf->Ln(5);

//Maklumat Simati
$pdf->SetFont('Times','U',10);
$pdf->Cell(10,5,'Maklumat Simati' ,0,1);

$pdf->SetFont('Times','',10);
$pdf->Cell(30,5,'Nama',0,0);
$pdf->Cell(3,5,': ',0,0);
$pdf->Cell(157,5,$row_app["deceased_name"],0,1);

$pdf->Cell(30,5,'Tarikh Lahir',0,0);
$pdf->Cell(3,5,': ',0,0);
$pdf->Cell(67,5,$row_app["deceased_dob"],0,0);

$pdf->Cell(30,5,'Umur',0,0);
$pdf->Cell(3,5,': ',0,0);
$pdf->Cell(57,5,$row_app["deceased_age"],0,1);

$pdf->Cell(30,5,'No K/P Baru',0,0);
$pdf->Cell(3,5,': ',0,0);
$pdf->Cell(67,5,$row_app["deceased_ic"],0,0);

$pdf->Cell(30,5,'No K/P Lama',0,0);
$pdf->Cell(3,5,': ',0,0);
$pdf->Cell(57,5,' ',0,1);

$pdf->Cell(30,5,'Cawangan',0,0);
$pdf->Cell(3,5,': ',0,0);
$pdf->Cell(67,5,$region,0,0);

$pdf->Cell(30,5,'Daftar ikut negeri',0,0);
$pdf->Cell(3,5,': ',0,0);
$pdf->Cell(57,5,$state,0,1);

$pdf->Cell(30,5,'Projek',0,0);
$pdf->Cell(3,5,': ',0,0);
$pdf->Cell(67,5,$project,0,0);

$pdf->Cell(30,5,'Jenis plan',0,0);
$pdf->Cell(3,5,': ',0,0);
$pdf->Cell(57,5,' ',0,1);

$pdf->Cell(30,5,'Tarikh Mati',0,0);
$pdf->Cell(3,5,': ',0,0);
$pdf->Cell(67,5,$row_app["deceased_dod"],0,0);

$pdf->Cell(30,5,'Jenis perlindungan',0,0);
$pdf->Cell(3,5,': ',0,0);
$pdf->Cell(57,5,' ',0,1);

//Line break
$pdf->Ln(5);

//Maklumat Ahli
$pdf->SetFont('Times','U',10);
$pdf->Cell(10,5,'Maklumat Ahli' ,0,1);

$pdf->SetFont('Times','',10);
$pdf->Cell(30,5,'Nama',0,0);
$pdf->Cell(3,5,': ',0,0);
$pdf->Cell(157,5,$row_app["member_name"],0,1);

$pdf->Cell(30,5,'No K/P Baru',0,0);
$pdf->Cell(3,5,': ',0,0);
$pdf->Cell(67,5,$row_app["member_ic"],0,0);

$pdf->Cell(30,5,'Hubungan',0,0);
$pdf->Cell(3,5,': ',0,0);
$pdf->Cell(57,5,$row_app["member_relations"],0,1);

$pdf->Cell(30,5,'Tel. Rumah',0,0);
$pdf->Cell(3,5,': ',0,0);
$pdf->Cell(67,5,$row_app["member_tel_home"],0,0);

$pdf->Cell(30,5,'Tel. Pejabat',0,0);
$pdf->Cell(3,5,': ',0,0);
$pdf->Cell(57,5,$row_app["member_tel_office"],0,1);

$pdf->Cell(30,5,'Tel. Bimbit',0,0);
$pdf->Cell(3,5,': ',0,0);
$pdf->Cell(67,5,$row_app["member_tel_mobile"],0,0);

$pdf->Cell(30,5,'Faksimili',0,0);
$pdf->Cell(3,5,': ',0,0);
$pdf->Cell(57,5,$row_app["member_fax"],0,1);

$pdf->Cell(30,5,'Alamat',0,0);
$pdf->Cell(3,5,': ',0,0);
$pdf->MultiCell(67,5,$row_app["member_address"],0,'L');

$pdf->Cell(30,5,'Poskod',0,0);
$pdf->Cell(3,5,': ',0,0);
$pdf->Cell(67,5,$row_app["member_postcode"],0,1);

//Line break
$pdf->Ln(5);

//Manfaat Khairat
$pdf->SetFont('Times','U',10);
$pdf->Cell(10,5,'Manfaat Khairat Kematian' ,0,1);
$pdf->SetFont('Times','',10);
$pdf->Cell(130,5,'Catatan' ,'TLR',0);
$pdf->Cell(60,5,'Tandatangan :' ,'TLR',1);
$pdf->Cell(130,5,'Bayaran dibuat kepada :' ,'LR',0);
$pdf->Cell(60,5,' ' ,'LR',1);
$pdf->Cell(130,5,'No Cek :' ,'LR',0);
$pdf->Cell(60,5,' ' ,'LR',1);
$pdf->Cell(130,5,'Keahlian :   Ya/Tidak' ,'LR',0);
$pdf->Cell(60,5,' ' ,'LR',1);
$pdf->Cell(130,5,'Caruman :   Ya/Tidak' ,'LR',0);
$pdf->Cell(60,5,' ' ,'BLR',1);
$pdf->Cell(100,5,'Jumlah tuntutan yang dibayar' ,'BL',0);
$pdf->Cell(30,5,'RM_____________' ,'BR',0);
$pdf->Cell(60,5,'Tarikh' ,'BLR',1);


//Line break
$pdf->Ln(5);

//Maklumat wakil
$pdf->SetFont('Times','U',10);
$pdf->Cell(10,5,'Maklumat wakil/penerima/penuntut' ,0,1);

$pdf->SetFont('Times','',10);
$pdf->Cell(30,5,'Nama',0,0);
$pdf->Cell(3,5,' ',0,0);
$pdf->Cell(157,5,': '.$row_app["recipient_name"],0,1);

$pdf->Cell(30,5,'Tel. Rumah',0,0);
$pdf->Cell(3,5,' ',0,0);
$pdf->Cell(67,5,': '.$row_app["member_tel_home"],0,0);

$pdf->Cell(30,5,'Tel. Pejabat',0,0);
$pdf->Cell(3,5,' ',0,0);
$pdf->Cell(57,5,': '.$row_app["member_tel_office"],0,1);

$pdf->Cell(30,5,'Tel. Bimbit',0,0);
$pdf->Cell(3,5,' ',0,0);
$pdf->Cell(67,5,': '.$row_app["member_tel_mobile"],0,0);

$pdf->Cell(30,5,'Faksimili',0,0);
$pdf->Cell(3,5,' ',0,0);
$pdf->Cell(57,5,': '.$row_app["member_fax"],0,1);

$pdf->Cell(30,5,'Alamat',0,0);
$pdf->Cell(3,5,' ',0,0);
$pdf->MultiCell(67,5,': '.$row_app["recipient_address"],0,'L');

$pdf->Cell(30,5,'Poskod',0,0);
$pdf->Cell(3,5,' ',0,0);
$pdf->Cell(67,5,': '.$row_app["recipient_postcode"],0,1);

//Line break
$pdf->Ln(5);

//Perakuan penerimaan
$pdf->SetFont('Times','U',10);
$pdf->Cell(10,5,'Perakuan Penerimaan Bayaran "Khairat Kematian"' ,0,1);
$pdf->SetFont('Times','',10);
$pdf->Cell(130,5,'Saya dengan ini mengaku telah menerima bayaran "Khairat Kematian" dari FELCRA' ,'TLR',0);
$pdf->Cell(60,5,'Tandatangan :' ,'TLR',1);
$pdf->Cell(130,5,'Bekalan Berhad/Etiqa dengan jumlah seperti yang tertera di bawah.' ,'LR',0);
$pdf->Cell(60,5,' ' ,'BLR',1);
$pdf->Cell(100,5,' ' ,'BL',0);
$pdf->Cell(30,5,'RM_____________' ,'BR',0);
$pdf->Cell(60,5,'Tarikh' ,'BLR',1);

//Kegunaan pejabat
$pdf->SetFont('Times','U',10);
$pdf->Cell(10,5,'Untuk kegunaan pejabat',0,1);
$pdf->SetFont('Times','',10);
$pdf->Cell(10,5,'' ,1,0);
$pdf->Cell(50,5,'Permit Pengebumian',0,0);
$pdf->Cell(10,5,'No :',0,0);
$pdf->Cell(10,5,' ',1,0);
$pdf->Cell(10,5,' ',1,0);
$pdf->Cell(10,5,' ',1,0);
$pdf->Cell(10,5,' ',1,0);
$pdf->Cell(10,5,' ',0,0);
$pdf->Cell(70,5,'Catatan :','TLR',1);
$pdf->Cell(10,5,' ' ,1,0);
$pdf->Cell(110,5,'Sijil kematian atau',0,0);
$pdf->Cell(70,5,' ','LR',1);
$pdf->Cell(10,5,' ' ,1,0);
$pdf->Cell(110,5,'Laporan polis',0,0);
$pdf->Cell(70,5,' ','BLR',1);


//Line break
$pdf->Ln(5);

$pdf->Cell(60,5,'Disemak Oleh :',1,0);
$pdf->Cell(60,5,'Disahkan Oleh :',1,0);
$pdf->Cell(70,5,'Dibayar Ganti Oleh :',1,1);

//Line break
$pdf->Ln(5);

$pdf->Cell(100,5,'Pengesahan Bayaran Etiqa ke FBP Sdn Bhd :',0,1);

$pdf->Cell(20,5,'No Cek :',0,0);
$pdf->Cell(10,5,' ',1,0);
$pdf->Cell(10,5,' ',1,0);
$pdf->Cell(10,5,' ',1,0);
$pdf->Cell(10,5,' ',1,0);
$pdf->Cell(10,5,' ',1,0);
$pdf->Cell(10,5,' ',1,0);
$pdf->Cell(10,5,' ',1,0);
$pdf->Cell(10,5,' ',0,0);
$pdf->Cell(20,5,'Tarikh Cek :',0,0);
$pdf->Cell(10,5,' ',1,0);
$pdf->Cell(10,5,' ',1,0);
$pdf->Cell(10,5,' ',1,0);
$pdf->Cell(10,5,' ',1,0);
$pdf->Cell(10,5,' ',1,0);
$pdf->Cell(10,5,' ',1,1);

$pdf->Output();
?>