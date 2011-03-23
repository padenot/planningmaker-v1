<?
   isset($_POST['id_orga']) ? $id_orga = $_POST['id_orga'] : $id_orga = "";
   isset($_POST['id_day']) ? $id_day = $_POST['id_day'] : $id_day = "";
   isset($_GET['id_orga']) ? $id_orga = $_GET['id_orga'] : $id_orga = $id_orga;
   isset($_GET['id_day']) ? $id_day = $_GET['id_day'] : $id_day = $id_day;
   if ($id_orga=="")  {
   $req_sql="SELECT MIN(id_orga) FROM orgas";
   $req = mysql_query($req_sql);
   while ($data = mysql_fetch_array($req))
   {
   $id_orga=$data['MIN(id_orga)'];
   }
   }
   $req_sql="SELECT plannings.*, taches.titre FROM plannings, taches WHERE plannings.id_orga LIKE '%|".$id_orga."|%' AND plannings.id_tache=taches.id_tache ORDER BY plannings.current_time";
   $req_plannings = mysql_query($req_sql);
   $req_sql="SELECT * FROM orgas ORDER BY first_name";
   $req_orgas = mysql_query($req_sql);  $req_sql="SELECT * FROM taches ORDER BY titre";
   $req_taches = mysql_query($req_sql);
   /*  $begin_time_loop=date_en_to_number($global_begin_date);  $begin_time_loop=substr($begin_time_loop,0,8)."0000";  $end_time_loop=date_en_to_number($global_end_date);  $end_time_loop=substr($end_time_loop,0,8)."2345";*/
   $begin_time_loop="";
   $end_time_loop="";
   ?>
   <SCRIPT language="Javascript">
   <!--
var begin_time="<? print($begin_time_loop); ?>";
var end_time="<? print($begin_time_loop); ?>";
var duree="00:15:00";
var changement=0;
function change_img(){
  var i=0;
  for (i=0;i<document.images.length;i++)
  {
  document.images[i].src="images/blanc.gif";
  }
  var valeur=document.form_choix.id_tache[document.form_choix.id_tache.selectedIndex].value;
  var plages=valeur.substring(valeur.indexOf("|")+1,valeur.length-1);
  plages_array=new Array();
  i=0;
  while(plages.indexOf("|")!=-1)
  {
  plages_array[i]=plages.substring(0,plages.indexOf("|"));
  plages=plages.substring(plages.indexOf("|")+1,plages.length);
  i++;
  }
  plages_array[i]=plages;
  end_time=valeur.substring(valeur.lastIndexOf("|")+1,valeur.length-3);
  end_time=end_time.substr(0,4)+end_time.substr(5,2)+end_time.substr(8,2)+end_time.substr(11,2)+end_time.substr(14,2);
  valeur=valeur.substring(0,valeur.lastIndexOf("|"));
  begin_time=valeur.substring(valeur.lastIndexOf("|")+1,valeur.length-3);
  begin_time=begin_time.substr(0,4)+begin_time.substr(5,2)+begin_time.substr(8,2)+begin_time.substr(11,2)+begin_time.substr(14,2);
  for (i=0;i<document.images.length;i++)
  {
  var nom=document.images[i].name;
  nom=nom.substring(nom.lastIndexOf("_")+1,nom.length);
  for(j=0;j<plages_array.length;j++)
  {
  begin_time=plages_array[j];
  begin_time=begin_time.substring(0,begin_time.indexOf(","));
  begin_time=begin_time.substr(0,4)+begin_time.substr(5,2)+begin_time.substr(8,2)+begin_time.substr(11,2)+begin_time.substr(14,2);
  end_time=plages_array[j];
  end_time=end_time.substring(end_time.indexOf(",")+1,end_time.length);
  end_time=end_time.substr(0,4)+end_time.substr(5,2)+end_time.substr(8,2)+end_time.substr(11,2)+end_time.substr(14,2);
  if ((nom>=begin_time) && (nom<end_time))
  {
  document.images[i].src="images/coche.gif";
  break;
  }
  }
  }
  /*  var valeur=document.form_choix.id_tache[document.form_choix.id_tache.selectedIndex].value;  end_time=valeur.substring(valeur.lastIndexOf("|")+1,valeur.length-3);  end_time=end_time.substr(0,4)+end_time.substr(5,2)+end_time.substr(8,2)+end_time.substr(11,2)+end_time.substr(14,2);  valeur=valeur.substring(0,valeur.lastIndexOf("|"));  begin_time=valeur.substring(valeur.lastIndexOf("|")+1,valeur.length-3);  begin_time=begin_time.substr(0,4)+begin_time.substr(5,2)+begin_time.substr(8,2)+begin_time.substr(11,2)+begin_time.substr(14,2);  for (i=0;i<document.images.length;i++)  {    var nom=document.images[i].name;    nom=nom.substring(nom.lastIndexOf("_")+1,nom.length);    if ((nom>=begin_time) && (nom<end_time)) document.images[i].src="images/coche.gif";  }*/
  }
  function change_txt(nb){
  duree=document.form_choix.duree_tache[document.form_choix.duree_tache.selectedIndex].value;
  var heure=duree.substr(0,2);
  heure=heure*4;
  var minute=duree.substr(3,2);
  boucle=heure+minute/15;
  for (i=0;i<boucle;i++)
  {
  var source=eval("document.coche_"+nb+".src");
  if ((source.indexOf("images/coche.gif")!=-1) || (document.form_choix.id_tache.selectedIndex==0))
  {
  var valeur=document.form_choix.id_tache[document.form_choix.id_tache.selectedIndex].value;
  valeur=valeur.substring(0,valeur.indexOf("|"));
  eval("document.form_planning.id_tache_"+nb+".value=valeur");
  eval("document.form_planning.titre_"+nb+".value=document.form_choix.id_tache.options[document.form_choix.id_tache.selectedIndex].text");
  nb=nb+15;
  nb_txt=""+nb;//manque changement de mois et d'ann?e
      if (nb_txt.substr(8,4)=="2360") nb=nb+7640;
      else if (nb_txt.substr(8,2)>=24) nb=nb+7600;
      else if (nb_txt.substr(10,2)=="60") nb=nb+40;
	  }
	  }
	  changement=1;}
	  function confirm_record(){
	  if (changement==1)
	  {
	  if (confirm("Voulez-vous enregistrez les modifications avant de changer d'orga ?"))
	  {
      document.form_planning.id_orga_new.value=document.form_choix.id_orga.value;      document.form_planning.submit();
	  }
	  else document.form_choix.submit();
	  }
	  else document.form_choix.submit();}
-->
</SCRIPT>
<TABLE width="1%" cellspacing="0" cellpadding="3">
  <TR>
  <TD>&nbsp;</TD>
  </TR><FORM method="POST" name="form_choix" action="main.php?file=plannings&action=define">
  <TR class="plannings_top">
  <TD>
  <TABLE width="1%" cellspacing="0" cellpadding="3">
  <TR>
  <TD valign="top" align="center" nowrap>
  <TABLE width="1%" border="0" cellspacing="0" cellpadding="3">
  <TR>
  <TD nowrap><B>Choisis un orga :</B></TD>
  <TD>
  <SELECT name="id_orga" onChange="confirm_record()">
  <?
  $begin_time_orga="";
  $end_time_orga="";
  $plages_orga="";
  $orgas_array=result_orgas($req_orgas);
  for ($i=0;$i<count($orgas_array);$i++)
  {
  $is_selected="";
  if ($orgas_array[$i]->id_orga==$id_orga)
  {
  $is_selected="selected";
  $begin_time_orga=date_en_to_number($orgas_array[$i]->begin_time);
  $end_time_orga=date_en_to_number($orgas_array[$i]->end_time);
  $plages_orga=$orgas_array[$i]->plages;
  }?>
  <OPTION <? print($is_selected); ?> value="<? print($orgas_array[$i]->id_orga); ?>"><? print($orgas_array[$i]->first_name." ".$orgas_array[$i]->last_name); ?></OPTION>
  <?
  }
  $list_plages_orgas=explode("|",$plages_orga);?>
  </SELECT>
  </TD>
  </TR>
  <TR>
  <TD colspan="2">
  <P>&nbsp;</P><P><BR>&nbsp;
  <BR>
  <B>Jours de disponibilit&eacute; :</B><BR>
  <?
  $list_days_orga=array();
  $current_day_orga="";
  for ($i=0;$i<count($list_plages_orgas);$i++)
  {
  if ($list_plages_orgas[$i]!="")
  {
  if (substr(list_to_begin_plage($list_plages_orgas[$i]),0,10)!=$current_day_orga)
  {
  $current_day_orga=substr(list_to_begin_plage($list_plages_orgas[$i]),0,10);
  $list_days_orga[count($list_days_orga)]=$current_day_orga;
  }
  if (substr(list_to_end_plage($list_plages_orgas[$i]),0,10)!=$current_day_orga)
  {
  $list_days=list_days_between($current_day_orga,substr(list_to_end_plage($list_plages_orgas[$i]),0,10));
  for($j=0;$j<count($list_days);$j++)
  {
  $current_day_orga=$list_days[$j];
  $list_days_orga[count($list_days_orga)]=$current_day_orga;
  }
  $current_day_orga=substr(list_to_end_plage($list_plages_orgas[$i]),0,10);
  $list_days_orga[count($list_days_orga)]=$current_day_orga;
  }
  }
  }
  $begin_time_loop=$begin_time_orga;
  $begin_time_loop=substr($begin_time_loop,0,8)."0000";
  $end_time_loop=$begin_time_orga;
  $end_time_loop=substr($end_time_loop,0,8)."2345";
  if ($id_day=="") $id_day=0;
  $current_day="";
  for ($i=0;$i<count($list_days_orga);$i++)
  {
  if ($i!=0) print(" - ");
  ?>
  <A href="main.php?file=plannings&action=define&id_orga=<? print($id_orga); ?>&id_day=<? print($i); ?>" class="menu"><? print($list_days_orga[$i]); ?></A>
  <?
  if ($i==$id_day)
  {
  $begin_time_loop=date_fr_to_number($list_days_orga[$i]." 00:00:00");
  $end_time_loop=date_fr_to_number($list_days_orga[$i]." 23:45:00");
  $current_day=$list_days_orga[$i];
  }
  }
  ?>
  </P>
  </TD>
  </TR>
  </TABLE>
  </TD>
  <TD>&nbsp;&nbsp;&nbsp;</TD>
  <TD valign="top" nowrap>
  <B>Choisis une t&acirc;che :</B> 
  </TD>
  <TD valign="top" align="center"> 
  <SELECT name="id_tache" size="10" onChange="change_img()">
  <OPTION value="0|<? print($begin_time_loop); ?>|<? print($begin_time_loop); ?>"></OPTION>
  <?
  $taches_array=result_taches($req_taches);
  for ($i=0;$i<count($taches_array);$i++)
  {
  $plages_tache=$taches_array[$i]->plages;
  $list_plages_tache=explode("|",$plages_tache);
  $list_days_tache=array();
  for ($j=0;$j<count($list_plages_tache);$j++)
  {
  if ($list_plages_tache[$j]!="")
  {
  $list_days_tache[count($list_days_tache)]=substr(list_to_begin_plage($list_plages_tache[$j]),0,10);
  $list_days=list_days_between(substr(list_to_begin_plage($list_plages_tache[$j]),0,10),substr(list_to_end_plage($list_plages_tache[$j]),0,10));
  for($k=0;$k<count($list_days);$k++)
  {
  $list_days_tache[count($list_days_tache)]=$list_days[$k];
  }
  $list_days_tache[count($list_days_tache)]=substr(list_to_end_plage($list_plages_tache[$j]),0,10);
  }
  }
  if (in_array($current_day,$list_days_tache))
  {
  ?>
  <OPTION value="<? print($taches_array[$i]->id_tache.$taches_array[$i]->plages); ?>"><? print($taches_array[$i]->titre); ?></OPTION>
  <?
  }
  }
  ?>
  </SELECT></TD>
  <TD>&nbsp;&nbsp;&nbsp;</TD>
  <TD valign="top" nowrap>
  <B>Choisis une dur&eacute;e :</B>
  </TD>
  <TD valign="top" align="center">
  <SELECT name="duree_tache" size="10">
  <OPTION value="00:15:00" selected>0h15</OPTION>
  <OPTION value="00:30:00">0h30</OPTION>
  <OPTION value="00:45:00">0h45</OPTION>
  <OPTION value="01:00:00">1h00</OPTION>
  <OPTION value="01:15:00">1h15</OPTION>
  <OPTION value="01:30:00">1h30</OPTION>
  <OPTION value="01:45:00">1h45</OPTION>
  <OPTION value="02:00:00">2h00</OPTION>
  </SELECT></TD>
  <TD>&nbsp;&nbsp;&nbsp;</TD>
  <TD valign="top"> 
  <INPUT type="button" value="Envoyer" onClick="document.form_planning.submit()">
  </TD>
  <TD valign="top">
  <INPUT type="submit" value="Effacer"> 
  </TD>
  </TR>
  </TABLE>
  </TD>
  </TR></FORM>
  <FORM method="POST" name="form_planning" action="db_action.php?db_action=update_planning">
  <TR class="plannings">
  <TD>
  <TABLE width="1%" cellspacing="0" cellpadding="3"><INPUT type="hidden" name="id_orga" value="<? print($id_orga); ?>"><INPUT type="hidden" name="id_orga_new" value="<? print($id_orga); ?>"><INPUT type="hidden" name="id_day" value="<? print($id_day); ?>"><INPUT type="hidden" name="begin_time_loop" value="<? print($begin_time_loop); ?>"><INPUT type="hidden" name="end_time_loop" value="<? print($end_time_loop); ?>">
  <?
  $plannings_array=result_plannings($req_plannings);
  for ($i=$begin_time_loop;$i<=substr($begin_time_loop,0,8)."0745";$i=$i+15)
  {
  ?>
  <TR>
  <?
  $i=test_time($i);
  $j=$i;
  $current_day="";
  while ($j<=$end_time_loop)
  {
  ?>
  <TD align="right" nowrap>
  <?
  if ((substr($j,0,8)!=$current_day) && ($i==$begin_time_loop))
  {
  $current_day=substr($j,0,8);
  print("<B>".substr(date_number_to_fr($j),0,10)."</B><BR>".substr(date_number_to_fr($j),11,5));
  }
  else print(substr(date_number_to_fr($j),11,5));
  $titre="";
  $id_tache="";
  $position=0;
  $in_plage=false;
  for ($k=0;$k<count($list_plages_orgas);$k++)
  {
  if ($list_plages_orgas[$k]!="")
  {
  if (($j>=date_fr_to_number(list_to_begin_plage($list_plages_orgas[$k].":00"))) && ($j<date_fr_to_number(list_to_end_plage($list_plages_orgas[$k].":00"))))
  $in_plage=true;
  }
  }
  if ($in_plage)
  {
  while (($plannings_array[$position]->current_time<=date_number_to_en($j).":00") && ($position<count($plannings_array)))
  {
  if ($plannings_array[$position]->current_time==date_number_to_en($j).":00")
  {
  $titre=$plannings_array[$position]->titre_tache;
  $id_tache=$plannings_array[$position]->id_tache;
  break;
  }
  else $position++;
  }
  ?>
  </TD>
  <TD align="center" width="1%"> 
  <INPUT type="text" name="titre_<? print($j); ?>" value="<? print($titre); ?>" onClick="change_txt(<? print($j); ?>)">
  <INPUT type="hidden" name="id_tache_<? print($j); ?>" value="<? print($id_tache); ?>"> 
  <INPUT type="hidden" name="current_time_<? print($j); ?>" value="<? print(date_number_to_en($j).":00"); ?>">
  </TD>
  <?
  }
  else
  {
  ?>
  </TD>
  <TD align="center" width="1%">
  <INPUT type="hidden" name="titre_<? print($j); ?>" value="">INDISPONIBLE
  </TD>
  <?
  }
  ?>
  <TD>
  <IMG name="coche_<? print($j); ?>" src="images/blanc.gif" height="15" width="15">
  </TD>
  <?
  $j=$j+800;
  //POUR LES 1/3 journees
  //      $j=$j+1200;
  //POUR LES 1/2 journees      $j=test_time($j);
  }
  ?>
  </TR>
  <?
  }
  ?>
  </TABLE>
  </TD></FORM>
  </TABLE>