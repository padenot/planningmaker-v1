<?
  session_start();

  $session_db_name = $_SESSION['session_db_name'];
  $session_user_type = $_SESSION['session_user_type'];
  
  isset($_GET['id_orga']) ? $id_orga = $_GET['id_orga'] : $id_orga = "";
  isset($_GET['id_day']) ? $id_day = $_GET['id_day'] : $id_day = "";

  include('connect_db.php');
  include('functions.php');
  include('classes.php');

  $req_sql="SELECT * FROM dates ORDER BY id_date";
  $req = mysql_query($req_sql);
  $global_begin_date="";
  $global_end_date="";
  while ($data = mysql_fetch_array($req))
  {
  if ($data['id_date']==1) $global_begin_date=substr($data['valeur'],0,16);
  if ($data['id_date']==2) $global_end_date=substr($data['valeur'],0,16);
  }

  $req_sql="SELECT plannings.*, taches.titre, taches.consigne, taches.id_vehicule, taches.id_resp, taches.matos, lieux.nom_lieu FROM plannings, taches, lieux WHERE plannings.id_orga LIKE '%|".$id_orga."|%' AND plannings.id_tache=taches.id_tache AND taches.id_lieu=lieux.id_lieu ORDER BY plannings.current_time";  
  $req_plannings = mysql_query($req_sql);  
  $req_sql="SELECT * FROM orgas ORDER BY first_name, last_name";
  $req_orgas = mysql_query($req_sql);
  $req_sql="SELECT * FROM vehicules ORDER BY nom_vehicule";
  $req_vehicules = mysql_query($req_sql);
  $nom_orga="";
  $found=false;
  $id_orga_next="";
  $id_orga_prev="";
  $orgas_array=result_orgas($req_orgas);
  for ($i=0;$i<count($orgas_array);$i++)
  {
  if ($found==true)
  {
  $id_orga_next=$orgas_array[$i]->id_orga;
  break;
  }
  if ($orgas_array[$i]->id_orga==$id_orga)
  {
  $nom_orga=$orgas_array[$i]->first_name." ".$orgas_array[$i]->last_name;
  $found=true;
  }
  if ($i!=0) $id_orga_prev=$orgas_array[$i-1]->id_orga;
  }
  $plannings_array=result_plannings($req_plannings);
  $vehicules_array=result_vehicules($req_vehicules);
  $begin_time_loop=date_en_to_number($plannings_array[0]->current_time);
  if ($begin_time_loop=="") $begin_time_loop=date_en_to_number($global_begin_date);
  $begin_time_loop=substr($begin_time_loop,0,8)."0000";
  $end_time_loop=date_en_to_number($plannings_array[count($plannings_array)-1]->current_time);
  if ($end_time_loop=="") $end_time_loop=date_en_to_number($global_end_date);
  $end_time_loop=substr($end_time_loop,0,8)."2345";
  //  $begin_time_loop=substr($begin_time_loop,0,8)."0000";	
  //pour les editions de demi-journees
  //  $end_time_loop=substr($end_time_loop,0,8)."2345";		
  //pour les editions de demi-journees  
  $nb_quart=difference_quart($end_time_loop,$begin_time_loop);  
  $nb_quart=round($nb_quart/4);  
  $largeur=substr($end_time_loop,0,8)-substr($begin_time_loop,0,8);  
  $largeur=100/(($largeur+1)*2);$largeur=$largeur/2;
?><HTML><HEAD><TITLE>Planning de l'orga <? print($nom_orga); ?></TITLE><LINK href="print.css" type="text/css" rel="stylesheet"></HEAD><BODY><TABLE width="100%" cellspacing="0" cellpadding="3">  <TR>    <TD>&nbsp;</TD>  </TR><FORM method="POST" name="form_choix" action="main.php?file=plannings&action=rules">  <TR>    <TD>      <TABLE>        <TR>
<?
  if ($id_orga_prev!="")  {
?>          <TD>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</TD>          <TD>            <A href="plannings_edit_print.php?id_orga=<? print($id_orga_prev); ?>"><B>Orga pr&eacute;c&eacute;dent</B></A>          </TD><?  }  if ($id_orga_next!="")  {?>          <TD>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</TD>          <TD>            <A href="plannings_edit_print.php?id_orga=<? print($id_orga_next); ?>"><B>Orga suivant</B></A>          </TD>
<?
  }
?>        </TR>      </TABLE>    </TD>  </TR></FORM>  <TR>    <TD align="center">      <H1><? print($nom_orga); ?></H1>    </TD>  </TR>  <TR>    <TD align="right">      <TABLE width="100%" cellspacing="0" cellpadding="3">
<?
  $id_tache_array=array();
  $html_array=array();
  $current_day="";
  $j=0;
  for ($i=$begin_time_loop;$i<=$end_time_loop;$i=$i+15)  {
  $i=test_time($i);
  $k=0;
  $id_tache="";
  $current_date="";
  $titre="";
  $position=0;
  $color="#FFFFFF";
  while (($plannings_array[$position]->current_time<=date_number_to_en($i).":00") && ($position<count($plannings_array)))
  {
  if ($plannings_array[$position]->current_time==date_number_to_en($i).":00")
  {
  $id_tache=$plannings_array[$position]->id_tache;
  $titre=$plannings_array[$position]->titre_tache;
  break;
  }
  else $position++;
  }
  //    if (($id_tache_array[$k]==$id_tache) && ($id_tache!=""))    
  if ($id_tache_array[$k]==$id_tache)  
  // pour eviter les repetitions des pauses   
  {
  $current_date="";
  $titre="";
  }
  else
  {
  $html_array[$j]="<TABLE WIDTH=\"100%\" CELLSPACING=\"0\" CELLPADDING=\"3\">";
  if (substr($i,0,8)!=$current_day)
  {
  $current_day=substr($i,0,8);
  $html_array[$j]=$html_array[$j]."<TR><TD WIDTH=\"1%\" COLSPAN=\"2\" ALIGN=\"center\" nowrap><B>".substr(date_number_to_fr($i),0,10)."</B></TD></TR>";
  }
  else 
  {
  $html_array[$j]=$html_array[$j]."<TR><TD WIDTH=\"1%\" COLSPAN=\"2\" nowrap>&nbsp;</TD></TR>";
  }
  $current_date=substr(date_number_to_fr($i),11,5);
  if ($titre=="") $titre="Pause";
  if ($titre=="Pause") $color="#CCCCCC";
  $html_array[$j]=$html_array[$j]."<TR><TD BGCOLOR=\"".$color."\" WIDTH=\"1%\" nowrap>".$current_date."</TD><TD BGCOLOR=\"".$color."\" nowrap><B>".$titre."</B></TD></TR>";
  $html_array[$j]=$html_array[$j]."</TABLE>";
  $j++;
  }
  $id_tache_array[$k]=$id_tache;
  $k++;
  }
  $imax=floor(count($html_array)/4);
  if ($imax!=count($html_array)/4) $imax++;
  for ($i=0;$i<$imax;$i++)
  {
  $j=0;
?>        <TR>
<?
  while ($j<4)
  {
?>          <TD valign="top" width="<? print($largeur); ?>%">            <? print($html_array[$i+$j*$imax]); ?>          </TD>          <TD width="1%" bgcolor="#000000">&nbsp;</TD>
<?
  $j++;
  }
?>        </TR>
<?
  }
  $fin=test_time($end_time_loop+15);
?>
      </TABLE>      <B>Fin des t&acirc;ches : <? print(date_number_to_fr($fin)); ?></B>    </TD>  </TR></TABLE></BODY></HTML>