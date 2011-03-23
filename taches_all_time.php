<?

  $req_sql="SELECT taches.*, lieux.nom_lieu FROM taches, lieux WHERE taches.id_lieu=lieux.id_lieu ORDER BY taches.begin_time, taches.id_tache";
  $req_taches = mysql_query($req_sql);

  $req_sql="SELECT * FROM plannings ORDER BY id_tache, current_time";
  $req_plannings = mysql_query($req_sql);

  isset($_GET['display_ok']) ? $display_ok = $_GET['display_ok'] : $display_ok = "yes";  
?>

<SCRIPT language="Javascript">
<!--
function verify()
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
    <TD colspan="5" nowrap>
      <B>Choisis une heure (jj-mm-aaaa hh:mm)</B>&nbsp;&nbsp;&nbsp;
      <INPUT type="text" name="current_time" value="<? print($current_time); ?>" size="20" maxlength="40">
      <INPUT type="button" value="Go" onClick="verify()">
      </TD>
  </TR>
  <TR class="taches_top">

<?
  if ($display_ok=="yes")
  {
?>
      <TD colspan="5" nowrap> <A href="main.php?file=taches&action=all_time&display_ok=no" class="menu">Afficher 
        les t&acirc;ches incompl&egrave;tes</A></TD>

<?
  }
  else
  {
?>
      <TD colspan="5" nowrap> <A href="main.php?file=taches&action=all_time&display_ok=yes" class="menu">Afficher 
        toutes les t&acirc;ches</A></TD>

<?
  }
?>

  </TR>
  <TR class="taches_top">
    <TD colspan="2" nowrap>
      <B>Liste des t&acirc;ches</B>
    </TD>
    <TD align="center">
      <B>Heure</B>
    </TD>
    <TD align="center">
      <B>Lieu</B>
    </TD>
    <TD align="center">
      <B>Etat</B>
    </TD>
  </TR>

<?
  $taches_array=result_taches($req_taches);
  $plannings_array=result_plannings($req_plannings);

  for ($i=0;$i<count($taches_array);$i++)
  {
    $begin_time_tache=date_en_to_number($taches_array[$i]->begin_time);
    $end_time_tache=date_en_to_number($taches_array[$i]->end_time);
    for ($j=$begin_time_tache;$j<$end_time_tache;$j=$j+15)
    {
	  $trouve="non";
      $j=test_time($j);
      if ($j>=$end_time_tache) break;
      $current_time=date_number_to_fr($j);

$current_time_en=substr(date_number_to_en($j),0,16);
$plages_tache=$taches_array[$i]->plages;
$list_plages_tache=explode("|",$plages_tache);
sort($list_plages_tache);
array_splice($list_plages_tache,0,2);
	
$tache_in_plage=false;
for ($k=0;$k<count($list_plages_tache);$k++)
{
  if (($current_time_en>=substr($list_plages_tache[$k],0,16)) && ($current_time_en<substr($list_plages_tache[$k],17,16)))
  {
	$tache_in_plage=true;
	break;
  }
}
if ($tache_in_plage)
{

      for ($k=0;$k<count($plannings_array);$k++)
      {
        $nb_orgas=0;
        if (($plannings_array[$k]->id_tache==$taches_array[$i]->id_tache) && (date_en_to_fr($plannings_array[$k]->current_time)==$current_time.":00"))
        {
          $list_orgas=explode("|",$plannings_array[$k]->id_orga);
          for ($l=0;$l<count($list_orgas);$l++)
          {
		    $nb_orgas++;
          }
		  $nb_orgas=$nb_orgas-2;
		  if (($display_ok=="yes") || (($display_ok=="no") && ($nb_orgas!=$taches_array[$i]->nb_orgas)))
		  {
?>

  <TR class="taches">
      <TD width="1%">&nbsp;&nbsp;&nbsp;</TD>
    <TD valign="top" nowrap>
      <A href="main.php?file=plannings&action=affect&id_tache=<? print($taches_array[$i]->id_tache); ?>" class="lien"><? print($taches_array[$i]->titre); ?></A>
    </TD>
    <TD align="center" valign="top" nowrap>
      <? print($current_time); ?>
    </TD>
    <TD align="center" nowrap>
      <? print($taches_array[$i]->nom_lieu); ?>
    </TD>
    <TD align="center" valign="top" nowrap>
      <? print($nb_orgas."/".$taches_array[$i]->nb_orgas); ?>
    </TD>
  </TR>

<?
          }
		  $trouve="oui";
          break;
        }
	  }
	  if ($trouve=="non")
	  {
?>

  <TR class="taches">
      <TD width="1%">&nbsp;&nbsp;&nbsp;</TD>
    <TD valign="top" nowrap>
      <A href="main.php?file=plannings&action=affect&id_tache=<? print($taches_array[$i]->id_tache); ?>" class="lien"><? print($taches_array[$i]->titre); ?></A>
    </TD>
    <TD align="center" valign="top" nowrap>
      <? print($current_time); ?>
    </TD>
    <TD align="center" nowrap>
      <? print($taches_array[$i]->nom_lieu); ?>
    </TD>
    <TD align="center" valign="top" nowrap>
      <? print("0/".$taches_array[$i]->nb_orgas); ?>
    </TD>
  </TR>

<?
	  }
}
    }
  }
?>

</FORM>
</TABLE>
