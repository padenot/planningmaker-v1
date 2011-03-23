<?
isset($_POST['id_orga']) ? $id_orga = $_POST['id_orga'] : $id_orga = "";
isset($_POST['nbr_orga']) ? $nbr_orga = $_POST['nbr_orga'] : $nbr_orga = "";
isset($_POST['list_id_orga']) ? $list_id_orga = $_POST['list_id_orga'] : $list_id_orga = "";
isset($_POST['format']) ? $format = $_POST['format'] : $format = "";
isset($_POST['list_days']) ? $list_days = $_POST['list_days'] : $list_days = "";
isset($_POST['min_time']) ? $min_time = $_POST['min_time'] : $min_time = "";
isset($_POST['max_time']) ? $max_time = $_POST['max_time'] : $max_time = "";

//echo $id_orga.$list_id_orga.$format.$list_days.$min_time.$max_time;

$req_sql="SELECT * FROM vehicules ORDER BY nom_vehicule";
$req_vehicules = mysql_query($req_sql);
$req_sql="SELECT * FROM orgas ORDER BY first_name, last_name";
$req_orgas = mysql_query($req_sql);
$orgas_array=result_orgas($req_orgas);
$vehicules_array=result_vehicules($req_vehicules);
?>
<SCRIPT language="JavaScript">
function envoi(mode){
  document.form1.mode.value=mode;
  if (mode=="visu") document.form1.submit();
  else
  {
  file_name=prompt("Nom du fichier à sauvegarder");
  if ((file_name=="") || (file_name==null) || (file_name=="null"))
  {
  file_name=prompt("Tu dois donner un nom au fichier à sauvegarder");
  if (!((file_name=="") || (file_name==null) || (file_name=="null")))
  {
  document.form1.file_name.value=document.form1.file_name.value+"/"+file_name;
  document.form1.submit();
  }	}
  else
  {
  document.form1.file_name.value=document.form1.file_name.value+"/"+file_name;
  document.form1.submit();
  }
  }
  }
</SCRIPT>
<FORM name="form1" method="post" action="view_pdf.php">
  <P>Pas d'erreur dans le fichier PDF
  <BR>
  Clique sur visualiser pour voir le r&eacute;sultat ou donne un nom de fichier     et clique sur enregistrer pour le sauver sur le serveur.
  </P>
<?
$list_id_orga=explode("|",$id_orga);
sort($list_id_orga);
array_splice($list_id_orga,0,2);
for ($n=0;$n<count($list_id_orga);$n++)
{
	$id_orga=$list_id_orga[$n];
	$req_sql="SELECT plannings.*, taches.titre, taches.consigne, taches.id_vehicule, taches.id_resp, taches.matos, lieux.nom_lieu FROM plannings, taches, lieux WHERE plannings.id_orga LIKE '%|".$id_orga."|%' AND plannings.id_tache=taches.id_tache AND taches.id_lieu=lieux.id_lieu ORDER BY plannings.current_time";  $req_plannings = mysql_query($req_sql);
	$req_sql="SELECT * FROM orgas WHERE id_orga='".$id_orga."'";
	$req_current_orga = mysql_query($req_sql);
	$current_orga_array=result_orgas($req_current_orga);
	$prenom="";
	$nom="";
	$plages="";
	$begin_time_orga="";
	$end_time_orga="";
	for ($i=0;$i<count($current_orga_array);$i++)
	{
		$prenom=$current_orga_array[$i]->first_name;
		$nom=$current_orga_array[$i]->last_name;
		$begin_time_orga=$current_orga_array[$i]->begin_time;
		$end_time_orga=$current_orga_array[$i]->end_time;
		$plages=$current_orga_array[$i]->plages;
		$id=$current_orga_array[$i]->id;
		$idresp = $current_orga_array[$i]->taches.id_resp; 
	}
	$plannings_array=result_plannings($req_plannings);
	$begin_time_loop=date_en_to_number($begin_time_orga);
	if ($begin_time_loop=="") $begin_time_loop=date_en_to_number($global_begin_date);
	$end_time_loop=date_en_to_number($end_time_orga);
	if ($end_time_loop=="") $end_time_loop=date_en_to_number($global_end_date);
	$id_tache_array=array();
	$html_array=array();
	$date_array=array();
	$current_day="";
	$j=0;
	$new_day=false;
	$nb_cells=0;
	for ($i=$begin_time_loop;$i<=$end_time_loop;$i=$i+15)
	{
		$i=test_time($i);
		if (($i>=$min_time) && ($i<$max_time+10000))
		{
			$k=0;
			$id_tache="";
			$current_date="";
			$titre="";
			$consigne="";
			$lieu="";
			$vehicule="";
			$nom_resp="";
			$matos="";
			$coequipiers="";
			$position=0;
			$color="#FFFFFF";
			while (($plannings_array[$position]->current_time<=date_number_to_en($i).":00") && ($position<count($plannings_array)))
			{
				if ($plannings_array[$position]->current_time==date_number_to_en($i).":00")
				{
					$id_tache=$plannings_array[$position]->id_tache;
					$titre=$plannings_array[$position]->titre_tache;
					$consigne=$plannings_array[$position]->consigne_tache;
					$lieu=$plannings_array[$position]->nom_lieu;
					for ($l=0;$l<count($vehicules_array);$l++)
					{
						if ($vehicules_array[$l]->id_vehicule==$plannings_array[$position]->id_vehicule)
						{
							$vehicule=$vehicules_array[$l]->nom;
							break;
						}
					}
					
					if ($plannings_array[$position]->id_resp!="0")
					{
						for ($l=0;$l<count($orgas_array);$l++)
						{
							if ($orgas_array[$l]->id_orga==$plannings_array[$position]->id_resp)
							{
								$nom_resp=$orgas_array[$l]->nom_orga;
								break;
							}
						}
                    }
                    $matos=$plannings_array[$position]->matos;
                    $list_orgas=explode("|",$plannings_array[$position]->id_orga);
                    $cpt_coequipiers=0;
                    for ($l=0;$l<count($list_orgas);$l++)
                    {
                        for ($m=0;$m<count($orgas_array);$m++)
                        {
                            if (($orgas_array[$m]->id_orga==$list_orgas[$l]) && ($orgas_array[$m]->id_orga!=$id_orga))
                            {
                                if ($coequipiers!="") $coequipiers=$coequipiers.", ";
                                $cpt_coequipiers++;
                                $coequipiers=$coequipiers.$orgas_array[$m]->nom_orga;
                                break;
                            }
                        }
                    }
                    if ($cpt_coequipiers>$nbr_orga && $nbr_orga!=0) $coequipiers="... (".$cpt_coequipiers." en tout)";
                    break;
                }
                else $position++;
            }
            if ($id_tache_array[$k]==$id_tache) // pour eviter les repetitions des pauses 
            {
                $current_date="";
                $titre="";
                $consigne="";
                $lieu="";
                $vehicule="";
                $nom_resp="";
                $matos="";
                $coequipiers="";
            }
            else
            {
                if (substr($i,0,8)!=$current_day)
                {
                    if ($current_day!="")
                    {
                    $j++;
                    $new_day=true;
                    }
                    $nb_cells=0;
                    $current_day=substr($i,0,8);
                    $date_array[count($date_array)]=substr(date_number_to_fr($i),0,10);
                    $list_plages=explode("|",$plages);
                    sort($list_plages);
                    array_splice($list_plages,0,2);
                    $max_end="";
                    for ($l=0;$l<count($list_plages);$l++)
                    {
                        if (substr(list_to_begin_plage($list_plages[$l]),0,10)==substr(date_number_to_fr($i),0,10))
                        {
                            if (substr(list_to_end_plage($list_plages[$l]),0,10)==substr(date_number_to_fr($i),0,10)) $max_end=substr(list_to_end_plage($list_plages[$l]),10,6);
                            else $max_end="00:00";
                        }
                    }
                    if ($max_end=="")
                    {
                        for ($l=0;$l<count($list_plages);$l++)
                        {
                            if (substr(list_to_end_plage($list_plages[$l]),0,10)==substr(date_number_to_fr($i),0,10)) $max_end=substr(list_to_end_plage($list_plages[$l]),10,6);
                            else $max_end="00:00";
                        }
                    }
                    if ($max_end=="") $max_end="00:00";
                    $end[count($end)]=$max_end;
                }
                $nb_cells++;
                $current_date=substr(date_number_to_fr($i),11,5);
                if ($titre=="") $titre="Pause";
                if ($consigne=="") $consigne="<BR><U>R&egrave;gles :</U> rien...";
                else $consigne="<BR><U>R&egrave;gles :</U> ".$consigne;
                if ($titre=="Pause") $color="#CCCCCC";
                if ($lieu!="") $lieu="<BR><U>Lieu :</U> ".$lieu;
                if ($vehicule!="") $vehicule="<BR><U>V&eacute;hicule :</U> ".$vehicule;
                if ($nom_resp!="")
                	{
                	$nom_resp="<BR><U>Responsable :</U> ".$nom_resp;
                	$requete_portable = mysql_query('SELECT phone_number FROM orgas WHERE id_orga="'.$plannings_array[$position]->id_resp.'"');
                	$tel = @mysql_result($requete_portable, 0);
        			if ($tel) $nom_resp .= ' ('.$tel.')';
                	}
                if ($matos!="") $matos="<BR><U>Matos :</U> ".$matos;
                if ($coequipiers!="") $coequipiers="<BR><U>Avec qui tu bosses :</U> ".$coequipiers;
                if ($i!=$begin_time_loop)
                {
                    if (($current_date!="00:00") && ($new_day))
                    {
                    $html_array[$j]=$html_array[$j].$tache_prec;
                    $new_day=false;
                    }
                }
                $tache_prec="<TD>00:00 <B>".$titre."</B>".$consigne.$lieu.$nom_resp.$matos.$coequipiers.$vehicule."</TD>";
                $html_array[$j]=$html_array[$j]."<TD>".$current_date." <B>".$titre."</B>";
                $html_array[$j]=$html_array[$j].$consigne.$lieu.$nom_resp.$matos.$coequipiers.$vehicule."</TD>";
                $html_array[$j]=str_replace("\"","'",$html_array[$j]);
            }
            $id_tache_array[$k]=$id_tache;
            $k++;
        }
    }	
	for ($i=0;$i<count($html_array);$i++)
	{
		$texte=$html_array[$i];
		$texte_array=explode("<TD>",$texte);
		array_splice($texte_array,0,1);
		$texte="";
		$nb_cells=0;
		$jmax=floor(count($texte_array)/4);
		if ($jmax!=count($texte_array)/4) $jmax++;
		for ($j=0;$j<$jmax;$j++)
		{
			$k=0;
			$texte=$texte."<TR>";
			while ($k<4)
			{
				$texte=$texte."<TD>".$texte_array[$j+$k*$jmax];
				$k++;
			}
			$texte=$texte."</TR>";
		}
		$html_array[$i]=$texte;
	}
?>
<!--  <P>    <TEXTAREA name="textarea" cols="50" rows="20">	<?/*	for ($i=0;$i<count($html_array);$i++) {	print("\n\rhtml ".$i);	print("\n\r".$html_array[$i]);	}*/	?>	</TEXTAREA>  </P>-->
<INPUT type="text" name="format" value="<? print($format); ?>">
<INPUT type="text" name="nbr_orga" value="<? print($nbr_orga); ?>">
<INPUT type="hidden" name="prenom_<? print($n); ?>" value="<? print($prenom); ?>">
<INPUT type="hidden" name="nom_<? print($n); ?>" value="<? print($nom); ?>">
<INPUT type="hidden" name="nb_days_<? print($n); ?>" value="<? print(count($date_array)); ?>">
<?
	for ($i=0;$i<count($date_array);$i++)
	{
?>
<INPUT type="hidden" name="day_<? print($n); ?>_<? print($i); ?>" value="<? print(date_fr_with_day($date_array[$i])); ?>">
<INPUT type="hidden" name="planning_<? print($n); ?>_<? print($i); ?>" value="<? print($html_array[$i]); ?>">  <INPUT type="hidden" name="end_<? print($n); ?>_<? print($i); ?>" value="<? print($end[$i]); ?>">
<?
	}
}
?>
<INPUT type="hidden" name="nb_orgas" value="<? print(count($list_id_orga)); ?>">
<INPUT type="hidden" name="file_name" value="<? print($session_db_name); ?>">
<INPUT type="hidden" name="mode" value="">
<INPUT type="button" name="enregistre" value="Enregistrer" onClick="envoi('enreg')">
<INPUT type="button" name="visualise" value="Visualiser" onClick="envoi('visu')"></FORM>