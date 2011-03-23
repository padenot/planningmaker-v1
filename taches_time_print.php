<?
  session_start();

  include('connect_db.php');
  include('functions.php');
  include('classes.php');

  $current_time_next=ajoute_quart($current_time,4);
  $current_time_prev=enleve_quart($current_time,4);
  $current_time=date_number_to_en($current_time);
  $current_time2=substr($current_time,0,13).":15";
  $current_time3=substr($current_time,0,13).":30";
  $current_time4=substr($current_time,0,13).":45";

  $req_sql="SELECT * FROM orgas WHERE begin_time<='".$current_time."' AND end_time>'".$current_time."'";
  $req_orgas = mysql_query($req_sql);
  $orgas_array=result_orgas($req_orgas);
  $nb_orgas_maxi1=0;
  for ($i=0;$i<count($orgas_array);$i++)
  {
    $plages_orga=$orgas_array[$i]->plages;
    $list_plages_orga=explode("|",$plages_orga);
    sort($list_plages_orga);
    array_splice($list_plages_orga,0,2);
	
    $orga_in_plage_tache=false;
    for ($j=0;$j<count($list_plages_orga);$j++)
    {
      if ((substr($current_time,0,16)>=substr($list_plages_orga[$j],0,16)) && (substr($current_time,0,16)<substr($list_plages_orga[$j],17,16)))
      {
	    $orga_in_plage_tache=true;
	    break;
      }
    }
    if ($orga_in_plage_tache) $nb_orgas_maxi1++;
  }

  $req_sql="SELECT * FROM orgas WHERE begin_time<='".$current_time2."' AND end_time>'".$current_time2."'";
  $req_orgas = mysql_query($req_sql);
  $orgas_array=result_orgas($req_orgas);
  $nb_orgas_maxi2=0;
  for ($i=0;$i<count($orgas_array);$i++)
  {
    $plages_orga=$orgas_array[$i]->plages;
    $list_plages_orga=explode("|",$plages_orga);
    sort($list_plages_orga);
    array_splice($list_plages_orga,0,2);
	
    $orga_in_plage_tache=false;
    for ($j=0;$j<count($list_plages_orga);$j++)
    {
      if ((substr($current_time2,0,16)>=substr($list_plages_orga[$j],0,16)) && (substr($current_time2,0,16)<substr($list_plages_orga[$j],17,16)))
      {
	    $orga_in_plage_tache=true;
	    break;
      }
    }
    if ($orga_in_plage_tache) $nb_orgas_maxi2++;
  }

  $req_sql="SELECT * FROM orgas WHERE begin_time<='".$current_time3."' AND end_time>'".$current_time3."'";
  $req_orgas = mysql_query($req_sql);
  $orgas_array=result_orgas($req_orgas);
  $nb_orgas_maxi3=0;
  for ($i=0;$i<count($orgas_array);$i++)
  {
    $plages_orga=$orgas_array[$i]->plages;
    $list_plages_orga=explode("|",$plages_orga);
    sort($list_plages_orga);
    array_splice($list_plages_orga,0,2);
	
    $orga_in_plage_tache=false;
    for ($j=0;$j<count($list_plages_orga);$j++)
    {
      if ((substr($current_time3,0,16)>=substr($list_plages_orga[$j],0,16)) && (substr($current_time3,0,16)<substr($list_plages_orga[$j],17,16)))
      {
	    $orga_in_plage_tache=true;
	    break;
      }
    }
    if ($orga_in_plage_tache) $nb_orgas_maxi3++;
  }

  $req_sql="SELECT * FROM orgas WHERE begin_time<='".$current_time4."' AND end_time>'".$current_time4."'";
  $req_orgas = mysql_query($req_sql);
  $orgas_array=result_orgas($req_orgas);
  $nb_orgas_maxi4=0;
  for ($i=0;$i<count($orgas_array);$i++)
  {
    $plages_orga=$orgas_array[$i]->plages;
    $list_plages_orga=explode("|",$plages_orga);
    sort($list_plages_orga);
    array_splice($list_plages_orga,0,2);
	
    $orga_in_plage_tache=false;
    for ($j=0;$j<count($list_plages_orga);$j++)
    {
      if ((substr($current_time4,0,16)>=substr($list_plages_orga[$j],0,16)) && (substr($current_time4,0,16)<substr($list_plages_orga[$j],17,16)))
      {
	    $orga_in_plage_tache=true;
	    break;
      }
    }
    if ($orga_in_plage_tache) $nb_orgas_maxi4++;
  }

  $req_sql="SELECT * FROM orgas WHERE begin_time<='".$current_time."' AND end_time>'".$current_time4."'";
  $req_orgas = mysql_query($req_sql);
  $orgas_array=result_orgas($req_orgas);
  $nb_orgas_maxi=count($orgas_array);

  $req_sql="SELECT taches.*, lieux.nom_lieu FROM taches, lieux WHERE taches.begin_time<='".$current_time4.":00' AND taches.end_time>'".$current_time.":00' AND taches.id_lieu=lieux.id_lieu ORDER BY taches.titre, taches.id_tache";
  $req_taches = mysql_query($req_sql);

  $req_sql="SELECT plannings.* FROM plannings WHERE plannings.current_time='".$current_time.":00' AND plannings.id_orga!='|0|'";
  $req_plannings1 = mysql_query($req_sql);
  $req_sql="SELECT plannings.* FROM plannings WHERE plannings.current_time='".$current_time2.":00' AND plannings.id_orga!='|0|'";
  $req_plannings2 = mysql_query($req_sql);
  $req_sql="SELECT plannings.* FROM plannings WHERE plannings.current_time='".$current_time3.":00' AND plannings.id_orga!='|0|'";
  $req_plannings3 = mysql_query($req_sql);
  $req_sql="SELECT plannings.* FROM plannings WHERE plannings.current_time='".$current_time4.":00' AND plannings.id_orga!='|0|'";
  $req_plannings4 = mysql_query($req_sql);

  $req_sql="SELECT * FROM orgas ORDER BY first_name, last_name";
  $req_orgas = mysql_query($req_sql);

  $current_time_en=substr($current_time,0,16);
  $current_time=substr(date_en_to_fr($current_time),0,16);
  $current_time_en2=substr($current_time2,0,16);
  $current_time2=substr(date_en_to_fr($current_time2),0,16);
  $current_time_en3=substr($current_time3,0,16);
  $current_time3=substr(date_en_to_fr($current_time3),0,16);
  $current_time_en4=substr($current_time4,0,16);
  $current_time4=substr(date_en_to_fr($current_time4),0,16);
?>

<HTML>

<HEAD>

<TITLE>Planning des orgas le <? print($current_time); ?></TITLE>
<LINK href="print.css" type="text/css" rel="stylesheet">

</HEAD>


<BODY>

<TABLE width="1%" cellspacing="0" cellpadding="3">
  <TR> 
    <TD colspan="3">&nbsp;</TD>
  </TR>
  <TR> 
    <TD colspan="3" nowrap><TABLE>
        <TR> 
          <TD>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</TD>
          <TD nowrap><B><A href="taches_time_print?current_time=<? print($current_time_prev); ?>">Heure 
            pr&eacute;c&eacute;dente</A></B></TD>
          <TD>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</TD>
          <TD nowrap><B><A href="taches_time_print?current_time=<? print($current_time_next); ?>">Heure 
            suivante</A></B></TD>
        </TR>
      </TABLE>
     </TD>
  </TR>
  <TR> 
    <TD valign="top"> 
      <TABLE width="100%" cellspacing="0" cellpadding="3">
        <TR bgcolor="#CCCCCC"> 
          <TD colspan="5"><B><? print($current_time); ?></B></TD>
        </TR>
        <TR class="taches_top"> 
          <TD colspan="2" nowrap> <B>Liste des t&acirc;ches</B> </TD>
          <TD align="center"> <B>Lieu</B> </TD>
          <TD align="center"> <B>Orgas</B> </TD>
          <TD align="center"> <B>Etat</B> </TD>
        </TR>
        <?
  $taches_array=result_taches($req_taches);
  $plannings_array=result_plannings($req_plannings1);
  $orgas_array=result_orgas($req_orgas);
  
  $total_orgas_utiles=0;
  $total_orgas_pris=0;
  $nb_orgas_pris=0;
  $nb_orgas_utiles=0;

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

    if (($taches_array[$i]->begin_time<=date_fr_to_en($current_time.":00")) && ($taches_array[$i]->end_time>date_fr_to_en($current_time.":00")))
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
        <TR> 
          <TD width="1%">&nbsp;&nbsp;&nbsp;</TD>
          <TD valign="top" nowrap> <? print($taches_array[$i]->titre); ?> </TD>
          <TD align="center" valign="top" nowrap> <? print($taches_array[$i]->nom_lieu); ?> 
          </TD>
          <TD align="center" nowrap> <? print($nom_orgas); ?> </TD>
          <TD align="center" valign="top" nowrap> <? print($nb_orgas."/".$taches_array[$i]->nb_orgas); ?> 
          </TD>
        </TR>
        <?
    }
  }
}
?>
        <TR> 
          <TD colspan="3" align="right">&nbsp;</TD>
          <TD align="right">&nbsp;</TD>
          <TD align="center" valign="top" nowrap><HR></TD>
        </TR>
        <TR class="taches"> 
          <TD colspan="3" align="right">&nbsp;</TD>
          <TD align="right" nowrap><B>Total :</B></TD>
          <TD align="center" valign="top" nowrap><? print($nb_orgas_pris." (".$nb_orgas_maxi1.")/".$nb_orgas_utiles); ?></TD>
        </TR>
      </TABLE></TD>
    <TD bgcolor="#000000">&nbsp;</TD>
    <TD valign="top"><TABLE width="100%" cellspacing="0" cellpadding="3">
        <TR bgcolor="#CCCCCC"> 
          <TD colspan="5"><B><? print($current_time3); ?></B></TD>
        </TR>
        <TR class="taches_top"> 
          <TD colspan="2" nowrap> <B>Liste des t&acirc;ches</B> </TD>
          <TD align="center"> <B>Lieu</B> </TD>
          <TD align="center"> <B>Orgas</B> </TD>
          <TD align="center"> <B>Etat</B> </TD>
        </TR>
        <?
  $plannings_array=result_plannings($req_plannings3);
  
  $total_orgas_utiles=0;
  $total_orgas_pris=0;
  $nb_orgas_pris=0;
  $nb_orgas_utiles=0;

  for ($i=0;$i<count($taches_array);$i++)
  {

$plages_tache=$taches_array[$i]->plages;
$list_plages_tache=explode("|",$plages_tache);
sort($list_plages_tache);
array_splice($list_plages_tache,0,2);
	
$tache_in_plage=false;
for ($j=0;$j<count($list_plages_tache);$j++)
{
  if (($current_time_en3>=substr($list_plages_tache[$j],0,16)) && ($current_time_en3<substr($list_plages_tache[$j],17,16)))
  {
	$tache_in_plage=true;
	break;
  }
}
if ($tache_in_plage)
{

    if (($taches_array[$i]->begin_time<=date_fr_to_en($current_time3.":00")) && ($taches_array[$i]->end_time>date_fr_to_en($current_time3.":00")))
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
        <TR> 
          <TD width="1%">&nbsp;&nbsp;&nbsp;</TD>
          <TD valign="top" nowrap> <? print($taches_array[$i]->titre); ?> </TD>
          <TD align="center" valign="top" nowrap> <? print($taches_array[$i]->nom_lieu); ?> 
          </TD>
          <TD align="center" nowrap> <? print($nom_orgas); ?> </TD>
          <TD align="center" valign="top" nowrap> <? print($nb_orgas."/".$taches_array[$i]->nb_orgas); ?> 
          </TD>
        </TR>
        <?
    }
  }
}
?>
        <TR> 
          <TD colspan="3" align="right">&nbsp;</TD>
          <TD align="right">&nbsp;</TD>
          <TD align="center" valign="top" nowrap><HR></TD>
        </TR>
        <TR class="taches"> 
          <TD colspan="3" align="right">&nbsp;</TD>
          <TD align="right" nowrap><B>Total :</B></TD>
          <TD align="center" valign="top" nowrap><? print($nb_orgas_pris." (".$nb_orgas_maxi3.")/".$nb_orgas_utiles); ?></TD>
        </TR>
      </TABLE> </TD>
  </TR>
  <TR> 
    <TD>&nbsp;</TD>
    <TD bgcolor="#000000">&nbsp;&nbsp;</TD>
    <TD>&nbsp;</TD>
  </TR>
  <TR> 
    <TD valign="top"><TABLE width="100%" cellspacing="0" cellpadding="3">
        <TR bgcolor="#CCCCCC"> 
          <TD colspan="5"><B><? print($current_time2); ?></B></TD>
        </TR>
        <TR class="taches_top"> 
          <TD colspan="2" nowrap> <B>Liste des t&acirc;ches</B> </TD>
          <TD align="center"> <B>Lieu</B> </TD>
          <TD align="center"> <B>Orgas</B> </TD>
          <TD align="center"> <B>Etat</B> </TD>
        </TR>
        <?
  $plannings_array=result_plannings($req_plannings2);
  
  $total_orgas_utiles=0;
  $total_orgas_pris=0;
  $nb_orgas_pris=0;
  $nb_orgas_utiles=0;

  for ($i=0;$i<count($taches_array);$i++)
  {

$plages_tache=$taches_array[$i]->plages;
$list_plages_tache=explode("|",$plages_tache);
sort($list_plages_tache);
array_splice($list_plages_tache,0,2);
	
$tache_in_plage=false;
for ($j=0;$j<count($list_plages_tache);$j++)
{
  if (($current_time_en2>=substr($list_plages_tache[$j],0,16)) && ($current_time_en2<substr($list_plages_tache[$j],17,16)))
  {
	$tache_in_plage=true;
	break;
  }
}
if ($tache_in_plage)
{

    if (($taches_array[$i]->begin_time<=date_fr_to_en($current_time2.":00")) && ($taches_array[$i]->end_time>date_fr_to_en($current_time2.":00")))
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
        <TR> 
          <TD width="1%">&nbsp;&nbsp;&nbsp;</TD>
          <TD valign="top" nowrap> <? print($taches_array[$i]->titre); ?> </TD>
          <TD align="center" valign="top" nowrap> <? print($taches_array[$i]->nom_lieu); ?> 
          </TD>
          <TD align="center" nowrap> <? print($nom_orgas); ?> </TD>
          <TD align="center" valign="top" nowrap> <? print($nb_orgas."/".$taches_array[$i]->nb_orgas); ?> 
          </TD>
        </TR>
        <?
    }
  }
}
?>
        <TR> 
          <TD colspan="3" align="right">&nbsp;</TD>
          <TD align="right">&nbsp;</TD>
          <TD align="center" valign="top" nowrap><HR></TD>
        </TR>
        <TR class="taches"> 
          <TD colspan="3" align="right">&nbsp;</TD>
          <TD align="right" nowrap><B>Total :</B></TD>
          <TD align="center" valign="top" nowrap><? print($nb_orgas_pris." (".$nb_orgas_maxi2.")/".$nb_orgas_utiles); ?></TD>
        </TR>
      </TABLE> 
      
    </TD>
    <TD bgcolor="#000000">&nbsp;</TD>
    <TD valign="top"> 
      <TABLE width="100%" cellspacing="0" cellpadding="3">
        <TR bgcolor="#CCCCCC"> 
          <TD colspan="5"><B><? print($current_time4); ?></B></TD>
        </TR>
        <TR class="taches_top"> 
          <TD colspan="2" nowrap> <B>Liste des t&acirc;ches</B> </TD>
          <TD align="center"> <B>Lieu</B> </TD>
          <TD align="center"> <B>Orgas</B> </TD>
          <TD align="center"> <B>Etat</B> </TD>
        </TR>
        <?
  $plannings_array=result_plannings($req_plannings4);
  
  $total_orgas_utiles=0;
  $total_orgas_pris=0;
  $nb_orgas_pris=0;
  $nb_orgas_utiles=0;

  for ($i=0;$i<count($taches_array);$i++)
  {

$plages_tache=$taches_array[$i]->plages;
$list_plages_tache=explode("|",$plages_tache);
sort($list_plages_tache);
array_splice($list_plages_tache,0,2);
	
$tache_in_plage=false;
for ($j=0;$j<count($list_plages_tache);$j++)
{
  if (($current_time_en4>=substr($list_plages_tache[$j],0,16)) && ($current_time_en4<substr($list_plages_tache[$j],17,16)))
  {
	$tache_in_plage=true;
	break;
  }
}
if ($tache_in_plage)
{

    if (($taches_array[$i]->begin_time<=date_fr_to_en($current_time4.":00")) && ($taches_array[$i]->end_time>date_fr_to_en($current_time4.":00")))
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
        <TR> 
          <TD width="1%">&nbsp;&nbsp;&nbsp;</TD>
          <TD valign="top" nowrap> <? print($taches_array[$i]->titre); ?> </TD>
          <TD align="center" valign="top" nowrap> <? print($taches_array[$i]->nom_lieu); ?> 
          </TD>
          <TD align="center" nowrap> <? print($nom_orgas); ?> </TD>
          <TD align="center" valign="top" nowrap> <? print($nb_orgas."/".$taches_array[$i]->nb_orgas); ?> 
          </TD>
        </TR>
        <?
    }
  }
}
?>
        <TR> 
          <TD colspan="3" align="right">&nbsp;</TD>
          <TD align="right">&nbsp;</TD>
          <TD align="center" valign="top" nowrap><HR></TD>
        </TR>
        <TR class="taches"> 
          <TD colspan="3" align="right">&nbsp;</TD>
          <TD align="right" nowrap><B>Total :</B></TD>
          <TD align="center" valign="top" nowrap><? print($nb_orgas_pris." (".$nb_orgas_maxi4.")/".$nb_orgas_utiles); ?></TD>
        </TR>
      </TABLE></TD>
  </TR>
</TABLE>

</BODY>
</HTML>