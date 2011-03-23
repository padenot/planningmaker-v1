<?
  session_start();

  $session_db_name = $_SESSION['session_db_name'];
  $session_user_type = $_SESSION['session_user_type'];
  
  isset($_GET['id_tache']) ? $id_tache = $_GET['id_tache'] : $id_tache = "";
  
  include('connect_db.php');
  include('functions.php');
  include('classes.php');

  if ($id_tache=="")
  {
    $req_sql="SELECT MIN(id_tache) FROM taches";
    $req = mysql_query($req_sql);
    while ($data = mysql_fetch_array($req))
    {
      $id_tache=$data['MIN(id_tache)'];
    }
  }

  $req_sql="SELECT plannings.* FROM plannings WHERE plannings.id_tache='".$id_tache."' AND plannings.id_orga!='|0|' ORDER BY plannings.current_time";
  $req_plannings = mysql_query($req_sql);

  $req_sql="SELECT * FROM orgas ORDER BY first_name, last_name";
  $req_orgas = mysql_query($req_sql);

  $req_sql="SELECT * FROM taches ORDER BY titre";
  $req_taches = mysql_query($req_sql);

  $req_sql="SELECT * FROM lieux";
  $req_lieu = mysql_query($req_sql);

  // Fetch all data in an array
  while(($array_lieu[] = mysql_fetch_assoc($req_lieu)) || array_pop($array_lieu)); 

  $found=false;
  $id_tache_prev=0;
  $id_tache_next=0;
  $begin_time_tache=0;
  $end_time_tache=0;
  $plages_tache="";
  $titre_tache="";
  $descr_tache="";
  $lieu_tache="";

  $taches_array=result_taches($req_taches);
  for ($i=0;$i<count($taches_array);$i++)
  {
    if ($found==true)
    {
      $id_tache_next=$taches_array[$i]->id_tache;
      break;
    }
    if ($taches_array[$i]->id_tache==$id_tache)
    {
	  $begin_time_tache=date_en_to_number($taches_array[$i]->begin_time);
	  $end_time_tache=date_en_to_number($taches_array[$i]->end_time);
	  $plages_tache=$taches_array[$i]->plages;
          $titre_tache=$taches_array[$i]->titre;
	  $id_resp=$taches_array[$i]->id_resp;
          $descr_tache=$taches_array[$i]->consigne;
          $lieu_tache=$array_lieu[$taches_array[$i]->id_lieu]['nom_lieu'];
          $found=true;
    }
    if ($i!=0) $id_tache_prev=$taches_array[$i-1]->id_tache;
  }
?>

<HTML>

<HEAD>

<TITLE>Planning de la t&acirc;che <? print($titre_tache); ?></TITLE>
<LINK href="print.css" type="text/css" rel="stylesheet">

</HEAD>


<BODY>
<TABLE width="1%" cellspacing="0" cellpadding="3">
  <TR>
    <TD>&nbsp;</TD>
  </TR>
  <TR>
    <TD>
      <TABLE>
        <TR>

<?
  if ($id_tache_prev!="")
  {
?>

          <TD>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</TD>
          <TD nowrap>
            <A href="plannings_repartition_print.php?id_tache=<? print($id_tache_prev); ?>"><B>T&acirc;che pr&eacute;c&eacute;dente</B></A>
          </TD>

<?
  }
  if ($id_tache_next!="")
  {
?>

          <TD>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</TD>
          <TD nowrap>
            <A href="plannings_repartition_print.php?id_tache=<? print($id_tache_next); ?>"><B>T&acirc;che suivante</B></A>
          </TD>

<?
  }
?>

        </TR>
      </TABLE>
    </TD>
  </TR>
  <TR>
    <TD align="center">
      <H1><? print($titre_tache); ?></H1>
    </TD>
  </TR>
  <tr><td><h2>
  Responsable : <? $orgas_array=result_orgas($req_orgas);
  for ($m=0;$m<count($orgas_array);$m++)
        {
          if ($orgas_array[$m]->id_orga==$id_resp)
          {
 print($orgas_array[$m]->nom_orga); 

            break;
          }
        } ?></h2></td></tr>
<tr>
<td>
<h2>Lieu : <?php echo $lieu_tache; ?> </h2>
<h2>Consigne:</h2>
<pre>
<?php echo "$descr_tache"; ?>
</pre>
</td>
</tr>
  <TR>
    <TD>
      <TABLE width="1%" cellspacing="0" cellpadding="3">

<?
  $plannings_array=result_plannings($req_plannings);
  
  $current_time="";
  $current_day="";
  $last_position=0;

$list_plages=explode("|",$plages_tache);
$nb_plages=count($list_plages)-2;
for ($boucle_plage=0;$boucle_plage<$nb_plages;$boucle_plage++)
{
$begin_time_tache=list_to_begin_plage($list_plages[$boucle_plage+1]);
$begin_time_tache=$begin_time_tache.":00";
$begin_time_tache=date_fr_to_number($begin_time_tache);
$end_time_tache=list_to_end_plage($list_plages[$boucle_plage+1]);
$end_time_tache=$end_time_tache.":00";
$end_time_tache=date_fr_to_number($end_time_tache);

  if ($boucle_plage!=0)
  {
?>

      <TR>
        <TD width="1%" colspan="2" nowrap><HR width="100%" noshade></TD>
      </TR>


<?
  }
  
  for ($i=$begin_time_tache;$i<$end_time_tache;$i=$i+15)
  {
    $k=0;
    $i=test_time($i);
    if ($i>=$end_time_tache) break;
    if (substr(date_number_to_fr($i),0,10)!=$current_day)
    {
      $current_day=substr(date_number_to_fr($i),0,10);
?>

      <TR>
        <TD width="1%" colspan="2" nowrap>
          <B><? print($current_day); ?></B>
        </TD>
      </TR>

<?
    }
    if ($i!=$current_time)
    {
?>

      <TR>
        <TD valign="top" align="right" width="1%" nowrap>
          <? print(substr(date_number_to_fr($i),11,6)); ?>
        </TD>
        <TD nowrap>

<?
      $current_time=$i;
    }
	$nb_orgas=0;
    for ($j=$last_position;$j<count($plannings_array);$j++)
    {
      if (date_en_to_number($plannings_array[$j]->current_time)!=$current_time)
      {
        $last_position=$j;
        break;
      }
      $list_orgas=explode("|",$plannings_array[$j]->id_orga);
	  $nb_orgas=count($list_orgas)-2;
      for ($l=0;$l<count($list_orgas);$l++)
      {
        for ($m=0;$m<count($orgas_array);$m++)
        {
          if ($orgas_array[$m]->id_orga==$list_orgas[$l])
          {
?>

          <? print($orgas_array[$m]->nom_orga); ?>&nbsp;-

<?
            break;
          }
        }
	    if (($l!=0) && (fmod($l,5)==0)) print("<BR>");
      }
      $k++;
    }
?>

        </TD>
      </TR>

<?

  }
}
?>

      </TABLE>
    </TD>
  </TR>
</TABLE>

</BODY>
</HTML>
