<?
  isset($_POST['current_time']) ? $current_time = $_POST['current_time'] : $current_time = "";
  if ($current_time=="") $current_time=$global_begin_date.":00";
  else $current_time=date_fr_to_en($current_time.":00");

  $req_sql="SELECT * FROM orgas WHERE begin_time<='".$current_time."' AND end_time>'".$current_time."'";
  $req_orgas = mysql_query($req_sql);
  $nb_orgas_maxi=0;
  $orgas_array=result_orgas($req_orgas);

  $req_sql="SELECT taches.*, lieux.nom_lieu FROM taches, lieux WHERE taches.begin_time<='".$current_time."' AND taches.end_time>'".$current_time."' AND taches.id_lieu=lieux.id_lieu ORDER BY taches.titre, taches.id_tache";
  $req_taches = mysql_query($req_sql);

  $req_sql="SELECT plannings.* FROM plannings WHERE plannings.current_time='".$current_time."' AND plannings.id_orga!='|0|'";
  $req_plannings = mysql_query($req_sql);

  $req_sql="SELECT * FROM orgas ORDER BY first_name, last_name";
  $req_orgas = mysql_query($req_sql);

  $current_time_en=substr($current_time,0,16);
  $current_time=substr(date_en_to_fr($current_time),0,16);

  for ($i=0;$i<count($orgas_array);$i++)
  {
    $plages_orga=$orgas_array[$i]->plages;
    $list_plages_orga=explode("|",$plages_orga);
    sort($list_plages_orga);
    array_splice($list_plages_orga,0,2);
	
    $orga_in_plage_tache=false;
    for ($j=0;$j<count($list_plages_orga);$j++)
    {
      if (($current_time_en>=substr($list_plages_orga[$j],0,16)) && ($current_time_en<substr($list_plages_orga[$j],17,16)))
      {
	    $orga_in_plage_tache=true;
	    break;
      }
    }
    if ($orga_in_plage_tache) $nb_orgas_maxi++;
  }
?>

<SCRIPT language="Javascript">
<!--
function verify(i)
{
 
  var ok=1;
  if (document.form.current_time.value=="")
  {
    alert("Tu dois donner une heure de recherche");
    ok=0;
  }
  else if ((document.form.current_time.value.length!=16) || (document.form.current_time.value.charAt(2)!="-") || (document.form.current_time.value.charAt(5)!="-") || (document.form.current_time.value.charAt(10)!=" ") || (document.form.current_time.value.charAt(13)!=":"))
  {
    alert("Tu dois une heure de recherche dans le bon format (jj-mm-aaaa hh:mm)");
    ok=0;
  }
  if (ok==1) document.form.submit();
}

-->
</SCRIPT>

<TABLE width="1%" cellspacing="0" cellpadding="3">
  <FORM method="POST" name="form" action="main.php?file=taches&action=time">
    <TR> 
      <TD colspan="5">&nbsp;</TD>
    </TR>
    <TR class="taches_top"> 
      <TD colspan="5" nowrap> <B><A href="<? print($file."_print.php"); ?>?current_time=<? print(date_en_to_number(date_fr_to_en(substr($current_time,0,14)."00:00"))); ?>" target="_blank" class="menu">Imprimer 
        cette heure</A> - <A href="main.php?file=taches&action=all_time" class="menu">Voir 
        toutes les heures</A></B> </TD>
    </TR>
    <TR> 
      <TD id="ok" colspan="5" nowrap> <B>Choisis une heure (jj-mm-aaaa hh:mm)</B>&nbsp;&nbsp;&nbsp; 
        <INPUT type="text" name="current_time" value="<? print($current_time); ?>" size="20" maxlength="40"> 
        <INPUT type="button" value="Go" onClick="verify(0)"> </TD>
    </TR>
    <TR class="taches_top"> 
      <TD colspan="2" nowrap> <B>Liste des t&acirc;ches</B> </TD>
      <TD align="center"> <B>Lieu</B> </TD>
      <TD align="center"> <B>Orgas</B> </TD>
      <TD align="center"> <B>Etat</B> </TD>
    </TR>
    <?
  $taches_array=result_taches($req_taches);
  $plannings_array=result_plannings($req_plannings);
  $orgas_array=result_orgas($req_orgas);
  
  $total_orgas_utiles=0;
  $total_orgas_pris=0;

  for ($i=0;$i<count($taches_array);$i++)
  {

$plages_tache=$taches_array[$i]->plages;
$list_plages_tache=explode("|",$plages_tache);
sort($list_plages_tache);
array_splice($list_plages_tache,0,2);
	
$tache_in_plage=false;
for ($j=0;$j<count($list_plages_tache);$j++)
{
  if (($current_time_en>=substr($list_plages_tache[$j],0,16)) && ($current_time_en<substr($list_plages_tache[$j],17,16)))
  {
	$tache_in_plage=true;
	break;
  }
}
if ($tache_in_plage)
{

    $nom_orgas="";
	$nb_orgas=0;
    for ($j=0;$j<count($plannings_array);$j++)
    {
      if ($plannings_array[$j]->id_tache==$taches_array[$i]->id_tache)
      {
        $list_orgas=explode("|",$plannings_array[$j]->id_orga);
        for ($k=0;$k<count($list_orgas);$k++)
        {
          for ($l=0;$l<count($orgas_array);$l++)
          {
            if ($orgas_array[$l]->id_orga==$list_orgas[$k])
            {
		      if ($nom_orgas!="") $nom_orgas=$nom_orgas."<BR>";
  		      $nom_orgas=$nom_orgas.$orgas_array[$l]->nom_orga;
			  $nb_orgas++;
              break;
            }
          }
        }
      }
    }
    if ($nom_orgas=="") $nom_orgas="personne";
	$nb_orgas_utiles=$nb_orgas_utiles+$taches_array[$i]->nb_orgas;
	$nb_orgas_pris=$nb_orgas_pris+$nb_orgas;
?>
    <TR class="taches"> 
      <TD width="1%">&nbsp;&nbsp;&nbsp;</TD>
      <TD valign="top" nowrap> <? print($taches_array[$i]->titre); ?> </TD>
      <TD align="center" valign="top" nowrap> <? print($taches_array[$i]->nom_lieu); ?> 
      </TD>
      <TD align="center" nowrap> <? print($nom_orgas); ?> </TD>
      <TD align="center" valign="top" nowrap bgcolor="<? if($nb_orgas==0 && $taches_array[$i]->nb_orgas>0){print("#FF3333");} else {if($nb_orgas<$taches_array[$i]->nb_orgas){print("#FFCC00");}}?>"> <? print($nb_orgas."/".$taches_array[$i]->nb_orgas); ?> 
      </TD>
    </TR>
    <?
}
  }
?>
    <TR class="taches"> 
      <TD colspan="3" align="right">&nbsp;</TD>
      <TD align="right">&nbsp;</TD>
      <TD align="center" valign="top" nowrap><HR></TD>
    </TR>
    <TR class="taches"> 
      <TD colspan="3" align="right">&nbsp;</TD>
      <TD align="right"><B>Total :</B></TD>
      <TD align="center" valign="top" nowrap><? print($nb_orgas_pris." (".$nb_orgas_maxi.")/".$nb_orgas_utiles); ?></TD>
    </TR>
	<input type="hidden" name="ok" value="<? print($pb); ?>">
  </FORM>
  </table>
  

