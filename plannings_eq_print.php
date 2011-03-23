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
		global $nom_equipe;
		
		$this->SetFont('Arial','B',10);
		$this->Cell(170,6,$nom_equipe,0,0,'C',0);

		$this->Ln(30);
	}
}

$pdf=new PDF();
$pdf->Open('P','mm','A4');		
$pdf->SetMargins(20,20);
$pdf->SetFont('Arial','',10);
$pdf->SetAutoPageBreak(true,8);

$req_equipes=mysql_query("SELECT * FROM equipes");
$nb_equipes=mysql_num_rows($req_equipes);

for($i=0;$i<$nb_equipes;$i++)
{
	$id_equipe=mysql_result($req_equipes,$i,'id_equipe');
	$nom_equipe=mysql_result($req_equipes,$i,'nom_equipe');
	
	$pdf->AddPAge();
	
	$req_plannings=mysql_query("SELECT titre, consigne, duree, `current_time`, nom_lieu, activites.id_activite AS id_activite FROM activites, plannings_eq,lieux WHERE activites.id_activite = plannings_eq.id_activite AND id_equipe LIKE '%|$id_equipe|%' AND lieux.id_lieu = activites.id_lieu ORDER BY 'current_time'");
	
	$nb=mysql_num_rows($req_plannings);
	$j=0;
	while($j<$nb)
	{
	
		$titre=mysql_result($req_plannings,$j,'titre');
		$consigne=mysql_result($req_plannings,$j,'consigne');
		$duree=mysql_result($req_plannings,$j,'duree');
		$current_time=substr(mysql_result($req_plannings,$j,'current_time'), 11, 5);
		$nom_lieu=mysql_result($req_plannings,$j,'nom_lieu');
		$id_activite=mysql_result($req_plannings,$j,'id_activite');
		
		$j!=0 ?	$id_activite_prec=mysql_result($req_plannings,$j-1,'id_activite') : $id_activite_prec = -1;
		if($id_activite!=$id_activite_prec)
		{
			$pdf->Cell(20,6,$current_time,0,0,'L',0);
			$pdf->Cell(150,6,$titre,0,0,'L',0);
			$pdf->Ln();
			$pdf->Cell(20,6,"",0,0,'L',0);
			$pdf->MultiCell(150,6,"Consigne : ".$consigne,0,0,'L',0);
			$pdf->Ln(1);
			$pdf->Cell(20,6,"",0,0,'L',0);
			$pdf->Cell(150,6,"Lieu : ".$nom_lieu,0,0,'L',0);
			$pdf->Ln();
			$pdf->Ln();
		}
		$j++;
	}
}


$pdf->OutPut();


?>