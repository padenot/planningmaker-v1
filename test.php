<?php
$session_db_name='planning_wei06';
$db = mysql_connect('127.0.0.1', 'planning', 'planningPHP');  
mysql_select_db($session_db_name,$db);

define('FPDF_FONTPATH','../fpdf151/font/');
require('../fpdf151/fpdf.php');

class PDF extends FPDF
{
	function Header()
	{
		global $head;
		
		$this->Cell(20,6,"titre",1,0,'C',0);

		$this->Ln();
	}
}

$pdf=new PDF();
$pdf->Open('P','mm','A4');		
$pdf->SetMargins(5,10);
$pdf->SetFont('Arial','',8);
$pdf->SetAutoPageBreak(true,8);

$pdf->AddPage();
$pdf->Cell(40,6,"test",1,0,'L',0);


$pdf->OutPut();


?>