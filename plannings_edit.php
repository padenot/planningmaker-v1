<?
   isset($_POST['id_orga']) ? $id_orga = $_POST['id_orga'] : $id_orga = "";
   isset($_POST['id_day']) ? $id_day = $_POST['id_day'] : $id_day = "";
   isset($_GET['id_orga']) ? $id_orga = $_GET['id_orga'] : $id_orga = $id_orga;
   isset($_GET['id_day']) ? $id_day = $_GET['id_day'] : $id_day = $id_day;
  if ($id_orga=="")
  {
  $req_sql="SELECT MIN(id_orga) FROM orgas";
  $req = mysql_query($req_sql);
  while ($data = mysql_fetch_array($req))
  {
  $id_orga=$data['MIN(id_orga)'];
  }
  }
  $req_sql="SELECT plannings.*, taches.titre FROM plannings, taches WHERE plannings.id_orga  LIKE '%|".$id_orga."|%' AND plannings.id_tache=taches.id_tache ORDER BY plannings.current_time";
  $req_plannings = mysql_query($req_sql);
  $req_sql="SELECT * FROM orgas ORDER BY first_name, last_name";
  $req_orgas = mysql_query($req_sql);
  $req_sql="SELECT * FROM taches ORDER BY titre";
  $req_taches = mysql_query($req_sql);
  $plannings_array=result_plannings($req_plannings);/*  $begin_time_loop=date_en_to_number($plannings_array[0]->current_time);  if ($begin_time_loop=="") $begin_time_loop=date_en_to_number($global_begin_date);  $begin_time_loop=substr($begin_time_loop,0,8)."0000";  $end_time_loop=date_en_to_number($plannings_array[count($plannings_array)-1]->current_time);  if ($end_time_loop=="") $end_time_loop=date_en_to_number($global_end_date);  $end_time_loop=substr($end_time_loop,0,8)."2345";  $largeur=substr($end_time_loop,0,8)-substr($begin_time_loop,0,8);  $largeur=100/(($largeur+1)*2);*/
  ?>
  <TABLE width="1%" cellspacing="0" cellpadding="3">  <TR>    <TD>&nbsp;</TD>  </TR><FORM method="POST" name="form_choix" action="main.php?file=plannings&action=edit">  <TR class="plannings_top">    <TD>        <TABLE width="1%" cellspacing="0" cellpadding="3">          <TR>            <TD nowrap>               <TABLE width="1%" border="0" cellspacing="0" cellpadding="3">                <TR>                   <TD nowrap><B>Choisis un orga :</B></TD>                  <TD>                     <SELECT name="id_orga" onChange="submit()">                      
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
  }
  ?>
  <OPTION <? print($is_selected); ?> value="<? print($orgas_array[$i]->id_orga); ?>"><? print($orgas_array[$i]->first_name." ".$orgas_array[$i]->last_name); ?></OPTION>                      <?  }  $list_plages_orgas=explode("|",$plages_orga);?>                    </SELECT>                  </TD>                </TR>                <TR>                   <TD colspan="2">				  <P><BR>&nbsp;				  <BR>                      <B>Jours de disponibilit&eacute; :</B><BR><?
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
  if ($id_day=="")  $id_day=0;
  for ($i=0;$i<count($list_days_orga);$i++)
  {
  if ($i!=0) print(" - ");
  ?>
  <A href="main.php?file=plannings&action=edit&id_orga=<? print($id_orga); ?>&id_day=<? print($i); ?>" class="menu"><? print($list_days_orga[$i]); ?></A> <?
  if ($i==$id_day)
  {
  $begin_time_loop=date_fr_to_number($list_days_orga[$i]." 00:00:00");
  $end_time_loop=date_fr_to_number($list_days_orga[$i]." 23:45:00");
  }
  }?>
  </P>				  </TD>                </TR>              </TABLE>            </TD>            <TD valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</TD>            <TD valign="top"> <B><A href="main.php?file=plannings&action=define&id_orga=<? print($id_orga); ?>&id_day=<? print($id_day); ?>" class="menu">Modifier</A></B>             </TD>            <TD valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</TD>            <TD valign="top"> <B><A href="<? print($file."_print.php?id_orga=".$id_orga."&id_day=".$id_day); ?>" target="_blank" class="menu">Imprimer</A></B>             </TD>        </TR>      </TABLE>    </TD>  </TR></FORM>  <TR class="plannings">    <TD>      <TABLE width="100%" cellspacing="0" cellpadding="3">        
  <?
  for ($i=$begin_time_loop;$i<=substr($begin_time_loop,0,8)."0745";$i=$i+15)
  {
  ?>        <TR><?
  $i=test_time($i);
  $j=$i;
  $current_day="";
  while ($j<=$end_time_loop)
  {
  ?>
  <TD align="right" valign="bottom" width="25%" nowrap><?
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
  if (($j>=date_fr_to_number(list_to_begin_plage($list_plages_orgas[$k].":00"))) && ($j<date_fr_to_number(list_to_end_plage($list_plages_orgas[$k].":00")))) $in_plage=true;
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
  if ($titre=="") $titre="Pause";
  else $titre="<A HREF=\"main.php?file=orgas&action=tache&id_tache=".$id_tache."\" CLASS=\"lien\">".$titre."</A>";
  ?>
  </TD>          <TD valign="bottom" nowrap> <? print($titre); ?> </TD>          <TD width="1%" bgcolor="#E34121">&nbsp;</TD>
  <?
  }
  else
  {
  ?>
  </TD>          <TD valign="bottom" nowrap>INDISPONIBLE</TD>          <TD width="1%" bgcolor="#E34121">&nbsp;</TD>
  <?
  }
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
  </TD>
  </TR></TABLE>