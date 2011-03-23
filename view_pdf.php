<?
isset($_POST['format']) ? $format = $_POST['format'] : $format = "";
isset($_POST['nbr_orga']) ? $nbr_orga = $_POST['nbr_orga'] : $nbr_orga = "";
isset($_POST['nb_orgas']) ? $nb_orgas = $_POST['nb_orgas'] : $nb_orgas = "";
isset($_POST['file_name']) ? $file_name = $_POST['file_name'] : $file_name = "";
isset($_POST['mode']) ? $mode = $_POST['mode'] : $mode = "";

//echo $format.$nbr_orga.$file_name.$mode;

  define('FPDF_FONTPATH','fpdf151/font/');
  require('fpdf151/fpdf.php');
  if($format=="a3")
  {
	$pdf=new FPDF('P','mm','A3');
  }
  else
  {
	$pdf=new FPDF('L','mm','A4');
  }
  
  $pdf->Open();
  $pdf->SetMargins(0.8,0.8);
  $pdf->SetAutoPageBreak(true,0.8);
  for ($n=0;$n<$nb_orgas;$n++)
  {
	$prenom="prenom_".$n;
	$nom="nom_".$n;
	$nb_days="nb_days_".$n;
  
	isset($_POST[$prenom]) ? $$prenom = $_POST[$prenom] : $$prenom = "";
	isset($_POST[$nom]) ? $$nom = $_POST[$nom] : $$nom = "";
	isset($_POST[$nb_days]) ? $$nb_days = $_POST[$nb_days] : $$nb_days = "";
	
	for ($i=0;$i<$$nb_days;$i++)
	{
		$tache=false;
		$current_day="day_".$n."_".$i;
		$planning_day="planning_".$n."_".$i;
		$end="end_".$n."_".$i;
		isset($_POST[$current_day]) ? $$current_day = $_POST[$current_day] : $$current_day = "";
		isset($_POST[$planning_day]) ? $$planning_day = $_POST[$planning_day] : $$planning_day = "";
		isset($_POST[$end]) ? $$end = $_POST[$end] : $$end = "";
		$header=array();
		$data=array();
		//print("<table>".$$planning_day."</table><p><p><p>"); 
		$rows=explode("<TR>",$$planning_day);
		array_splice($rows,0,1);
		
		for ($j=0;$j<count($rows);$j++)
		{
			$rows[$j]=str_replace("</TR>","",$rows[$j]);
			//print("<p>---->".$current_day." / rows ".$j." : <p>"); 
			$cells=explode("<TD>",$rows[$j]);
			array_splice($cells,0,1);
			for ($k=0;$k<count($cells);$k++)
			{
				//print("<p><--".$k."--><br>".$cells[$k]);
				$cells[$k]=str_replace("</TD>","",$cells[$k]);
				$cells[$k]=str_replace("<BR>","\n",$cells[$k]);
				$cells[$k]=str_replace("<U>","§",$cells[$k]);
				$cells[$k]=str_replace("</U>","§",$cells[$k]);
				$cells[$k]=str_replace("<B>","|",$cells[$k]);
				$cells[$k]=str_replace("</B>","|",$cells[$k]);
				$cells[$k]=str_replace("\\'","'",$cells[$k]);
				if ((((!(strpos($cells[$k],"|Pause|")===false)) || ($cells[$k]==""))) && ($tache==false)) $tache=false;
				else $tache=true;
			}
			$data[$j]=$cells;
		}
		if ($tache)
		{
			$pdf->AddPage();
			$pdf->SetFont('Arial','B',14);
			$pdf->Cell(0,10,str_replace("\\'","'",$$prenom).' '.str_replace("\\'","'",$$nom).' - '.$$current_day,0,0,'C');
			$pdf->SetFont('Arial','',7);
			$pdf->FancyTable($header,$data,'LR');
			$pdf->SetFont('Arial','B',7);
			$pdf->SetY($pdf->GetHmax());
			$pdf->Cell(0,8,'Fin des tâches à '.$$end,0,1,'R');
		}
	}
}

if ($mode=="visu") $pdf->Output();
else
{
	if (strpos($file_name, ".pdf")===FALSE) $file_name=$file_name.".pdf";
	$pdf->Output(substr($_SERVER['SCRIPT_FILENAME'],0,strpos($_SERVER['SCRIPT_FILENAME'],"view_pdf.php"))."pdf_files/".$file_name);
	header('location: main.php?file=plannings&action=print');
}
?>