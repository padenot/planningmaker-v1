<?php
require('../fpdf.php');

$pdf=new FPDF();
$pdf->Open();
$pdf->AddPage();
$pdf->AddFont('Calligrapher','','calligra.php');
$pdf->SetFont('Calligrapher','',35);
$pdf->Cell(0,10,'Changez de police avec FPDF !');
$pdf->Output();
?>
