<? $req_sql="SELECT * FROM categories ORDER BY nom_categorie";
  $req_categories = mysql_query($req_sql); 
  
  //print($begin."//".$end."//");
//function pour d�composer la chaine date
function decompose($x,$t){
	list($date_t,$heure_t)=split(" ",$x,2);
	list($h_t,$m_t,$s_t)=split(":",$heure_t,3);
	list($annee_t,$mois_t,$jour_t)=split("-",$date_t,3);
	switch($t){
		case "heure":
			return $heure_t;break;
		case "h":
			return $h_t;break;
		case "m":
			return $m_t;break;
		case "s":
			return $s_t;break;
		case "date":
			return $date_t;break;
		case "jour":
			return $jour_t;break;
		case "mois":
			return $mois_t;break;
		case "annee":
			return $annee_t;break;
}}
			

  
 ?> 
  
<table cellspacing="0" cols="50" width="200">
<form action="main.php?file=orgas&action=graph">
<input type="hidden" value="orgas" name="file">
<input type="hidden" value="graph" name="action">
<tr><td>
<select name="tranche">
<option value="" selected>choisir la pr�cision</option>
<option value="1">15 minutes</option>
<option value="2">30 minutes</option>
<option value="4">1 heure</option>
<option value="8">2 heures</option>
</select></td>
<td bgcolor="#FF6600" bordercolor="#000000" nowrap colspan="35" bordercolordark="#000000">orgas affect�s sur une tache</td>
<td>&nbsp;</td><td bgcolor="#FFCC00" bordercolor="#000000" nowrap colspan="50" bordercolordark="#000000">orgas affect�s en rabe � certaines taches</td>
</tr><tr><td><select  onChange="submit()" name="jour">
<option value="" selected>choisis le jour</option>
<?
$begin_choose=$global_begin_date;
$end_choose=$global_end_date;
$a=0;$a+=decompose($begin_choose,"jour");
$b=0;$b+=decompose($end_choose,"jour");

for($j=$a;$j<=$b;$j++){
 $max=$b-$a;
?>
<option value="<? print($j); ?>"><? print("le ".$j."/".decompose($begin_choose,"mois")); ?></option>
<? } ?>
<option value=""><? print("voir les ".$max." jours"); ?></option>
</select>
</td>
<td bgcolor="#66FF66" bordercolor="#000000" nowrap colspan="35" bordercolordark="#000000">nombre d'orgas recrut�s</td>
<td>&nbsp;</td><td bordercolor="#000000" nowrap colspan="50" bordercolordark="#000000">| | | | | | | | | | |  besoins en orgas des taches</td></tr></form>
<tr><td>&nbsp;</td></tr>
<tr>
    <td align="center">Horaire</td><?
	if($id_categorie!=""){ ?>
<td>v�rification</td>
<? } ?>
	<td colspan="50">Orgas</td>
  </tr>
<?
if($tranche=="")$tranche=4;
ini_set("display_errors","on");
//r�cup�ration du nombre d'heure du planning 
$global_begin_date_graph=$global_begin_date;
$global_end_date_graph=$global_end_date;
$begin=date_en_to_fr($global_begin_date_graph);
$end=date_en_to_fr($global_end_date_graph);
$jourup=$jour+1;
if ($jour!=""){
if($jour==decompose($global_begin_date,"jour")){$global_end_date_graph=substr($global_begin_date_graph,0,8).$jourup." 00:00:00";}
if($jour==decompose($global_end_date,"jour")){$global_begin_date_graph=substr($global_end_date_graph,0,8).$jour." 00:00:00";}
if($jour!=decompose($global_begin_date,"jour") && $jour!=decompose($global_end_date,"jour")){
$global_begin_date_graph=substr($global_begin_date_graph,0,8).$jour." 00:00:00";
$global_end_date_graph=substr($global_end_date_graph,0,8).$jourup." 00:00:00";}
}
//fonction pour trouver l'�cart de temps entre deux date a et b , t et le temps de ref en quart d'heure
function index($a,$b,$t){
	$heure_a=decompose($a,"h");
	$heure_b=decompose($b,"h");
	$jour_a=decompose($a,"jour");
	$jour_b=decompose($b,"jour");
	//je ne g�re pas le changement de mois et d'ann�e, tant pis !!! (� d�velopper plus tard)
	$nb=0;
	$nb+=(($heure_a-$heure_b)*4/$t);
	$nb+=(($jour_a-$jour_b)*24*4/$t);
	return $nb+1;
}

//r�cuperation du nombre d'orgas pour chaques plages

//initialisation
//test
//echo("gggg".index($end,$begin,$tranche)."ppp");

//fonction pour avancer d'une heure
function temps_suivant($h,$t){
	$heure_h=decompose($h,"h");
	$jour_h=decompose($h,"jour");
	$minute_h=decompose($h,"m");
	$annee_h=decompose($h,"annee");
	$mois_h=decompose($h,"mois");
	//je ne g�re pas le changement de mois et d'ann�e, tant pis !!! (� d�velopper plus tard)
	$minute_h+=(15*$t);
	while($minute_h>46){$heure_h++;$minute_h-=60;}
	while($heure_h>=24){$heure_h-=24;$jour_h++;}
	if($minute_h<10)$minute_h="0".$minute_h;
	if($heure_h<10 && $minute_h=="00")$heure_h="0".$heure_h;
	
	return $annee_h."-".$mois_h."-".$jour_h." ".$heure_h.":".$minute_h.":00";
	}


//import direct de taches_time.php

  if ($current_time=="") $current_time=$global_begin_date_graph.":00";
  else $current_time=date_fr_to_en($current_time.":00");
  for($t=1;$t<index($global_end_date_graph,$global_begin_date_graph,$tranche);$t++){
  //echo("<br>current time = ".$current_time); 
$oki=1;
  $req_sql="SELECT * FROM orgas WHERE begin_time<='".$current_time."' AND end_time>'".$current_time."'";
  $req_orgas = mysql_query($req_sql);
  $orgas_array=result_orgas($req_orgas);
  
 //compte le nb d'orgas
 $nb_orgas_maxi=0;
 for ($i=0;$i<count($orgas_array);$i++)
  {
    $plages_orga=$orgas_array[$i]->plages;
    $list_plages_orga=explode("|",$plages_orga);
    sort($list_plages_orga);
    array_splice($list_plages_orga,0,2);
	//echo("<br>");
    $orga_in_plage_tache=false;
    for ($j=0;$j<count($list_plages_orga);$j++)
    {
	//echo($list_plages_orga[$j]);
      if (($current_time>=substr($list_plages_orga[$j],0,16)) && ($current_time<substr($list_plages_orga[$j],17,16)))
      {
	    $orga_in_plage_tache=true;
	    break;
      }
    }
    if ($orga_in_plage_tache) {$nb_orgas_maxi++;//echo("    ok");
	}
  }
  
  
  
//partie pour r�cup�rer le nb d'orga affect�--------------------1
 $req_sql="SELECT * FROM plannings,taches WHERE plannings.current_time='".$current_time."' AND taches.id_tache=plannings.id_tache";
  $req_plannings = mysql_query($req_sql); 
  $plannings_array=result_plannings($req_plannings);
 $nb_orgas_affecte=0;
 $nb_orgas_bonus=0;
 for ($i=0;$i<count($plannings_array);$i++)
  {
    $orgas_planning=$plannings_array[$i]->id_orga;
	$tache_planning=$plannings_array[$i]->nb_orgas;
    $list_orga_planning=explode("|",$orgas_planning);
    sort($list_orga_planning);
    array_splice($list_orga_planning,0,2);
	$nb_aff=count($list_orga_planning);
	$nb_voulu=$tache_planning;
	//print("<br>".count($list_orga_tache)."-->"); 
   if($nb_aff<=$nb_voulu){
   		$nb_orgas_affecte+=$nb_aff;
		
		}
		else{$nb_orgas_affecte+=$nb_voulu;
		$nb_orgas_bonus+=($nb_aff-$nb_voulu);
		if($plannings_array[$i]->id_categorie==$id_categorie)$oki=0;
		}
  }
  
  
  
  
//partie pour r�cuperer le nb d'orga souhait�-------------------2
 $req_sql="SELECT * FROM taches WHERE taches.begin_time<='".$current_time."' AND taches.end_time>'".$current_time."'";
 $req_taches = mysql_query($req_sql); 
 $taches_array=result_taches($req_taches);
 $nb_orgas_voulu=0;
 for ($i=0;$i<count($taches_array);$i++)
  {
     $plages_tache=$taches_array[$i]->plages;
    $list_plages_tache=explode("|",$plages_tache);
    sort($list_plages_tache);
    array_splice($list_plages_tache,0,2);
	//echo("<br>");
    $tache_in_plage_tache=false;
    for ($j=0;$j<count($list_plages_tache);$j++)
    {
	//echo($list_plages_orga[$j]);
      if (($current_time>=substr($list_plages_tache[$j],0,16)) && ($current_time<substr($list_plages_tache[$j],17,16)))
      {
	    $tache_in_plage_tache=true;
	    break;
      }
    }
    if ($tache_in_plage_tache) {$nb_orgas_voulu+=$taches_array[$i]->nb_orgas;//echo("    ok");
	}
  }
  //test
  $max=$nb_orgas_maxi+1;
?>
  <tr><td nowrap align="right" bgcolor="<? 
  if($max<$nb_orgas_voulu){print("#FF6633");}else{if($nb_orgas_affecte<$nb_orgas_voulu)print("#FFCC00");else print("#66FF99");}?>
  "><font size="-4"><a href="main.php?file=taches&action=time&current_time=<? 
  print(decompose($current_time,"jour")."-".decompose($current_time,"mois")."-".decompose($current_time,"annee")." ".decompose($current_time,"h").":".decompose($current_time,"m").":");  
  ?>"><?  	if(decompose($current_time,"h")=="00")  		{print($current_time);}	else 		{print(decompose($current_time,"h").":".decompose($current_time,"m"));} ?></a></font></td><?

if($id_categorie!=""){ ?>
<td bgcolor="<? if($oki==1){print("#33FF00");}else{print("#FF0000");} ?>"></td>
<? } 

if($max<$nb_orgas_voulu+1)$max=$nb_orgas_voulu+1;
for($j=1;$j<$max;$j++){ 
?><td bgcolor="<? if($j<=$nb_orgas_affecte)$couleur="#FF6600";elseif($j<=($nb_orgas_affecte+$nb_orgas_bonus))$couleur="#FFCC00";else $couleur="#00CC66";
if($j<=$nb_orgas_maxi)print($couleur); ?>"><font size="-4"><?
if($j<=$nb_orgas_voulu)
{print("|");}
else{print("&nbsp;");}?>
</font></td><? }?>
	<td colspan="60" nowrap><font size="-4"><? print("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$nb_orgas_affecte."+".$nb_orgas_bonus."/".$nb_orgas_voulu."   (disp ".$nb_orgas_maxi.")");?></font></td>
</tr>
<?
$old_nb_orgas_maxi=$nb_orgas_maxi; 
$current_time=temps_suivant($current_time,$tranche);
}
  


?>
</table>