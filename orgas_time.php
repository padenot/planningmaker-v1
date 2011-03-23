<?
  isset($_POST['current_time']) ? $current_time = $_POST['current_time'] : $current_time = "";
  if ($current_time=="") $current_time=$global_begin_date.":00";  else $current_time=date_fr_to_en($current_time.":00");  $req_sql="SELECT plannings.id_orga, taches.titre, lieux.nom_lieu FROM taches, plannings, lieux WHERE plannings.id_tache=taches.id_tache AND taches.id_lieu=lieux.id_lieu AND plannings.id_orga!='|0|' AND plannings.current_time='".$current_time."' ORDER BY plannings.id_orga";  $req_plannings = mysql_query($req_sql);  $req_sql="SELECT * FROM orgas ORDER BY first_name, last_name";  $req_orgas = mysql_query($req_sql);  $current_time_en=substr($current_time,0,16);  $current_time=substr(date_en_to_fr($current_time),0,16);?>
  <SCRIPT language="Javascript">
  <!--
  function verify(){
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
  <TABLE width="1%" cellspacing="0" cellpadding="3">  <FORM method="POST" name="form" action="main.php?file=orgas&action=time">    <TR>       <TD colspan="4">&nbsp;</TD>    </TR>    <TR class="orgas_top">      <TD colspan="4" nowrap><B><A href="main.php?file=orgas&action=all_day&current_time=<? print(substr($current_time,0,10)); ?>" class="menu">Voir         toute la journ&eacute;e</A></B></TD>    </TR>    <TR class="orgas_top">       <TD colspan="4" nowrap> <B>Choisis une heure (jj-mm-aaaa hh:mm)</B>&nbsp;&nbsp;&nbsp;         <INPUT type="text" name="current_time" value="<? print($current_time); ?>" size="20" maxlength="40">        <INPUT type="button" value="Go" onClick="verify()">      </TD>    </TR>    <TR class="orgas_top">       <TD colspan="2" nowrap> <B>Liste des orgas</B> </TD>      <TD align="center"> <B>T&acirc;ches</B> </TD>      <TD align="center"> <B>Lieu</B> </TD>    </TR>    <?  $plannings_array=result_plannings($req_plannings);  $orgas_array=result_orgas($req_orgas);  for ($i=0;$i<count($orgas_array);$i++)  {$plages_orga=$orgas_array[$i]->plages;$list_plages_orga=explode("|",$plages_orga);sort($list_plages_orga);array_splice($list_plages_orga,0,2);	$orga_in_plage_tache=false;for ($j=0;$j<count($list_plages_orga);$j++){  if (($current_time_en>=substr($list_plages_orga[$j],0,16)) && ($current_time_en<substr($list_plages_orga[$j],17,16)))  {	$orga_in_plage_tache=true;	break;  }}if ($orga_in_plage_tache){    $found=false;    $titre_tache="aucune";    $nom_lieu="aucun";    for ($j=0;$j<count($plannings_array);$j++)    {      $list_orgas=explode("|",$plannings_array[$j]->id_orga);      for ($k=0;$k<count($list_orgas);$k++)      {        if ($list_orgas[$k]==$orgas_array[$i]->id_orga)        {          $titre_tache=$plannings_array[$j]->titre_tache;          $nom_lieu=$plannings_array[$j]->nom_lieu;          $found=true;          break;        }      }      if ($found) break;    }?>    <TR class="orgas">       <TD width="1%">&nbsp;&nbsp;&nbsp;</TD>      <TD valign="top" nowrap> <A href="main.php?file=plannings&action=edit&id_orga=<? print($orgas_array[$i]->id_orga); ?>" class="lien"><? print($orgas_array[$i]->first_name." ".$orgas_array[$i]->last_name); ?></A>       </TD>      <TD align="center" valign="top" nowrap> <? print($titre_tache); ?> </TD>      <TD align="center" nowrap> <? print($nom_lieu); ?> </TD>    </TR>    <?  }}?>  </FORM></TABLE>