<?    

setlocale (LC_TIME, 'fr_FR.utf8','fra'); 


isset($_GET['id_categorie']) ? $id_categorie = $_GET['id_categorie'] : $id_categorie = "";
isset($_GET['tranche']) ? $tranche = $_GET['tranche'] : $tranche = "";

isset($_GET['jour']) ? $jour = $_GET['jour'] : $jour = "";

isset($_GET['current_time']) ? $current_time = $_GET['current_time'] : $current_time = "";
$req_sql="SELECT * FROM categories ORDER BY nom_categorie";
$req_categories = mysql_query($req_sql);
//print($begin."//".$end."//");
//function pour décomposer la chaine date
function decompose($x,$t)
{	
	list($date_t,$heure_t)=explode(" ",$x,2);
        $tmp_time = explode(":",$heure_t,3);
        if(count($tmp_time) > 2)
            list($h_t,$m_t,$s_t)=$tmp_time;
        else {
            list($h_t,$m_t)=$tmp_time;
            $s_t = 0;
        }
	list($annee_t,$mois_t,$jour_t)=explode("-",$date_t,3);
	switch($t)
	{    
		case "heure":    
		return $heure_t;
		break;
		
		case "h":
		return $h_t;
		break;
		
		case "m":
		return $m_t;
	    break;
		
	    case "s":    
		return $s_t;
	    break;
		
	    case "date":    
		return $date_t;
	    break;
		
	    case "jour":    
		return $jour_t;
	    break;
		
	    case "mois":    
		return $mois_t;
		break;
		
	    case "annee":
		return $annee_t;
		break;
    } 	
}?>

<style> 
#graph {
	backgound:#fffccc;
} 

.graph{
	border:0;
	margin:0;
} 
td{border:0;
	margin:0;
} 
div, date, elt, graph, nbr {
display:block;
margin:0;
} 
.ligne {height:14px;
	font-size:10px;
	clear:both;
}
date {text-align:right;
	width:100px;
	float:left;
	height:16px;
} 
.da_ve {background:#f63;
}
.da_or {background:#fc0;
}
.da_ro {background:#6f9;width:120px;
} 
graph {float:left;
} 
elt {float:left;
} 
#g_ja{background:#f60;
} 
#g_or{background:#fc0;
} 
#g_ve{background:#0c6;
} 
.noneed{height:15px;
} 
.noneedten{height:12px;
	border-bottom:3px solid grey;
} 
.need{border-top:4px solid black;
	height:11px;
} 
.needten{border-top:4px solid black;
	border-bottom:3px solid red;
	height:8px;
} 

#g_ja,#g_or,#g_ve,.noneed,.need{
	margin-right:1px;
	}
 
#g_ja.need{height:11px;
	border-top:4px solid grey;
} 
#g_ja.needten{height:8px;
	border-top:4px solid grey;
	border-bottom:3px solid grey;
} 
nbr{width:auto;
	float:left;
	border-top:1px dotted black;
	height:15px;
}
</style>

<table cellspacing="0" cols="50" width="200">
<form action="main.php?file=orgas&action=graph">
<input type="hidden" value="orgas" name="file">
<input type="hidden" value="graph" name="action">
<tr>
<td>
<select name="tranche">
<option value="" selected>choisir la précision</option>
<option value="1">15 minutes</option><option value="2">30 minutes</option>
<option value="4">1 heure</option><option value="8">2 heures</option>
</select>
</td>
<td bgcolor="#FF6600" bordercolor="#000000" nowrap colspan="35" bordercolordark="#000000">orgas affectés sur une tache</td>
<td>&nbsp;
</td>
<td bgcolor="#FFCC00" bordercolor="#000000" nowrap colspan="50" bordercolordark="#000000">orgas affectés en rabe à certaines taches</td>
</tr>
<tr>
<td>
<select  onChange="submit()" name="jour">
<option value="" selected>choisis le jour</option>

<?
$begin_choose=$global_begin_date;
$end_choose=$global_end_date;
$a=0;
$a+=decompose($begin_choose,"jour");
$b=0;
$b+=decompose($end_choose,"jour");
for($j=$a;$j<=$b;$j++)
{ 
	$max=$b-$a;
	?>
	<option value="<? print($j); ?>">
		<? 
		print("le ".$j."/".decompose($begin_choose,"mois"));
		?>
	</option>
<? 
}
?>
<option value="">
<? print("voir les ".$max." jours"); ?>
</option>
</select>
</td>
<td bgcolor="#66FF66" bordercolor="#000000" nowrap colspan="35" bordercolordark="#000000">nombre d'orgas recrutés</td>
<td>&nbsp;</td>
<td bordercolor="#000000" nowrap colspan="50" bordercolordark="#000000">| | | | | | | | | | |  besoins en orgas des taches</td>
</tr>
</form>
<tr>
<td>&nbsp;</td>
</tr>
<tr>    
<td align="center">Horaire</td>
<?	if($id_categorie!="")
{ 
?>
	<td>vérification</td>
<?
}
?>
<td colspan="50">Orgas</td>
</tr>
</table>
<div id="graph">
<? 
if($tranche=="")
	$tranche=4;
//ini_set("display_errors","on");

 //récupération du nombre d'heure du planning  
$global_begin_date_graph=$global_begin_date;
$global_end_date_graph=$global_end_date;
$begin=date_en_to_fr($global_begin_date_graph);
$end=date_en_to_fr($global_end_date_graph);


$jourup=$jour+1;

if ($jour!="")
{ 
	if($jour==decompose($global_begin_date,"jour"))
	{
		$global_end_date_graph=substr($global_begin_date_graph,0,8).$jourup." 00:00:00";
	} 
	if($jour==decompose($global_end_date,"jour"))
	{ 
		$global_begin_date_graph=substr($global_end_date_graph,0,8).$jour." 00:00:00";
	} 
	if($jour!=decompose($global_begin_date,"jour") && $jour!=decompose($global_end_date,"jour"))
	{ 
		$global_begin_date_graph=substr($global_begin_date_graph,0,8).$jour." 00:00:00";
		$global_end_date_graph=substr($global_end_date_graph,0,8).$jourup." 00:00:00";
	}
 } 

include('orgas_graph_fonctions.php');

if ($current_time=="") 
	$current_time=$global_begin_date_graph.":00";
else $current_time=date_fr_to_en($current_time.":00");

// On récupère le nombre total d'orgas

$requete_nbr_total_orgas=mysql_query("SELECT first_name FROM orgas" );
$nbr_total_orgas=mysql_num_rows($requete_nbr_total_orgas);


$max_orgas = 0;
for($t=1;$t<index($global_end_date_graph,$global_begin_date_graph,$tranche);$t++)
{  
	$oki=1;
	$req_sql="SELECT * FROM orgas WHERE begin_time<='".$current_time."' AND end_time>='".$current_time."'";
	$req_orgas = mysql_query($req_sql) or die("requete de re©cup d'orga a merdÃ");
	
        $num = mysql_num_rows($req_orgas);

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
		if ($orga_in_plage_tache) 
		{
			$nb_orgas_maxi++;
			//echo("    ok");
		}
	}
	       
	//partie pour récupérer le nb d'orga affecté--------------------1  
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
	    if($nb_aff<=$nb_voulu)
		{
			$nb_orgas_affecte+=$nb_aff;
		}
		else
		{
			$nb_orgas_affecte+=$nb_voulu;
			$nb_orgas_bonus+=($nb_aff-$nb_voulu);
			if($plannings_array[$i]->id_categorie==$id_categorie)
				$oki=0;
		} 
	}         
	//partie pour récuperer le nb d'orga souhaité-------------------2  
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
		if ($tache_in_plage_tache) 
		{
			$nb_orgas_voulu+=$taches_array[$i]->nb_orgas;
			//echo("    ok");
		}
	}
	   //test   
	   $max=$nb_orgas_maxi+1;
	   
	?>
	 <div class="ligne"><date class="<? 
	 if($max<$nb_orgas_voulu)
	 {	
		print("da_ve");
	 }
	 else
	 {
		if($nb_orgas_affecte<$nb_orgas_voulu)
			print("da_or");
		else print("da_ro");
	}
	?>">
	
	<?php

	if(decompose($current_time,"h")=="00")
	{
		print('<strong>');
		print(strftime("%A", strtotime($current_time))).' ';
		print(decompose($current_time,"jour").' / '.decompose($current_time,"mois")).' ';
		print('</strong>');
	}
	
	?>
	<a href="main.php?file=taches&action=time&current_time=<? print(decompose($current_time,"jour")."-".decompose($current_time,"mois")."-".decompose($current_time,"annee")." ".decompose($current_time,"h").":".decompose($current_time,"m").":");?>"><?php
		print(decompose($current_time,"h")."h".decompose($current_time,"m"));
	?></a></date><?if($max<$nb_orgas_voulu+1)$max=$nb_orgas_voulu+1;
	for($j=1;$j<$max;$j++)
	{ 
		?>
		<graph>
		<elt id="<? 
		if($j<=$nb_orgas_affecte)
			$couleur="g_ja";
		elseif($j<=($nb_orgas_affecte+$nb_orgas_bonus))
			$couleur="g_or";
		else $couleur="g_ve";
		if($j<=$nb_orgas_maxi)
			print($couleur);
		?>" class="<?
		if (floor($j/10)==$j/10)
		{
			if($j<=$nb_orgas_voulu)
			{
				print("needten");
			}
			else
			{
				print("noneedten");
			}
		}
		else
		{	
			if($j<=$nb_orgas_voulu)
			{	
				print("need");
			}
			else
			{
				print("noneed");
			}
		}
		
		$bar_width = round(460/$nbr_total_orgas);
		
		?>" style="width: <?php echo $bar_width; ?>px;">
	</un></graph><? 
	}?>	<nbr>
	<? print("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$nb_orgas_affecte." aff + ".$nb_orgas_bonus." bonus / ".$nb_orgas_voulu." voulus  (dispo ".$nb_orgas_maxi.")");
	?>
	</nbr>
	</div>
	<?$old_nb_orgas_maxi=$nb_orgas_maxi;
	 $current_time=temps_suivant($current_time,$tranche);
}  
?>
