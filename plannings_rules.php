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
  $req_sql="SELECT plannings.*, taches.titre, taches.consigne, taches.id_vehicule, taches.id_resp, taches.matos, lieux.nom_lieu, lieux.id_lieu FROM plannings, taches, lieux WHERE plannings.id_orga LIKE '%|".$id_orga."|%' AND plannings.id_tache=taches.id_tache AND taches.id_lieu=lieux.id_lieu ORDER BY plannings.current_time";
  $req_plannings = mysql_query($req_sql);
  $req_sql="SELECT * FROM orgas ORDER BY first_name, last_name";
  $req_orgas = mysql_query($req_sql);
  $req_sql="SELECT * FROM orgas ORDER BY first_name, last_name";
  $req_resp = mysql_query($req_sql);
  $req_sql="SELECT * FROM vehicules ORDER BY nom_vehicule";
  $req_vehicules = mysql_query($req_sql);
  $plannings_array=result_plannings($req_plannings);
  $vehicules_array=result_vehicules($req_vehicules);
  $resp_array=result_orgas($req_resp);
  /*  $begin_time_loop=date_en_to_number($plannings_array[0]->current_time);  if ($begin_time_loop=="") $begin_time_loop=date_en_to_number($global_begin_date);  $begin_time_loop=substr($begin_time_loop,0,8)."0000";  $end_time_loop=date_en_to_number($plannings_array[count($plannings_array)-1]->current_time);  if ($end_time_loop=="") $end_time_loop=date_en_to_number($global_end_date);  $end_time_loop=substr($end_time_loop,0,8)."2345";  $largeur=substr($end_time_loop,0,8)-substr($begin_time_loop,0,8);  $largeur=100/(($largeur+1)*2);*/
  ?><TABLE width="100%" cellspacing="0" cellpadding="3">  <TR>    <TD>&nbsp;</TD>  </TR><FORM method="POST" name="form_choix" action="main.php?file=plannings&action=rules">  <TR class="plannings_top">    <TD>        <TABLE width="1%" cellspacing="0" cellpadding="3">          <TR>            <TD nowrap>               <TABLE width="1%" cellspacing="0" cellpadding="3">                <TR>                   <TD nowrap><B>Choisis un orga :</B></TD>                  <TD>                     <SELECT name="id_orga" onChange="submit()">                      
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
  <OPTION <? print($is_selected); ?> value="<? print($orgas_array[$i]->id_orga); ?>"><? print($orgas_array[$i]->first_name." ".$orgas_array[$i]->last_name); ?></OPTION>
  <?
  }
  $list_plages_orgas=explode("|",$plages_orga);
  ?>
  </SELECT>                  </TD>                </TR>                <TR>                   <TD colspan="2">				  <P><BR>&nbsp;				  <BR>                      <B>Jours de disponibilit&eacute; :</B><BR>
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
  for ($i=0;$i<count($list_days_orga);$i++)
  {
  if ($i!=0) print(" - ");
  ?>
  <A href="main.php?file=plannings&action=rules&id_orga=<? print($id_orga); ?>&id_day=<? print($i); ?>" class="menu"><? print($list_days_orga[$i]); ?></A> 
  <?
  if ($i==$id_day)
  {
  $begin_time_loop=date_fr_to_number($list_days_orga[$i]." 00:00:00");
  $end_time_loop=date_fr_to_number($list_days_orga[$i]." 23:45:00");
  }
  }
  ?>
  </P>				  </TD>                </TR>              </TABLE>                          </TD>          <TD>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</TD>            <TD valign="top"> <B><A href="main.php?file=plannings&action=define&id_orga=<? print($id_orga); ?>&id_day=<? print($id_day); ?>" class="menu">Modifier</A></B>             </TD>            <TD valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</TD>            <TD valign="top"> <B><A href="<? print($file."_print.php?id_orga=".$id_orga."&id_day=".$id_day); ?>" target="_blank" class="menu">Imprimer</A></B>             </TD>        </TR>      </TABLE>    </TD>  </TR></FORM>  <TR class="plannings">    <TD>      <TABLE width="100%" cellspacing="0" cellpadding="3"><?  $id_tache_array=array();  for ($i=$begin_time_loop;$i<=substr($begin_time_loop,0,8)."0745";$i=$i+15)  {?>        <TR><?    $i=test_time($i);    $j=$i;    $current_day="";    $k=0;    while ($j<=$end_time_loop)    {?>          <TD valign="top" width="25%">            <TABLE width="100%" cellspacing="0" cellpadding="3"><?      if ((substr($j,0,8)!=$current_day) && ($i==$begin_time_loop))      {        $current_day=substr($j,0,8);?>              <TR>                <TD colspan="2" align="center" nowrap> <B><? print(substr(date_number_to_fr($j),0,10)); ?></B>                 </TD>              </TR><?      }      else      {?>              <TR>                <TD colspan="2" nowrap>&nbsp;</TD>              </TR><?      }?>              <TR>                <TD width="25%" nowrap> <? print(substr(date_number_to_fr($j),11,5)); ?>                   <?
  $id_tache="";
  $titre="";
  $consigne="";
  $lieu="";
  $id_lieu=""; 
  $vehicule="";
  $coequipiers="";
  $nom_resp="";
  $matos="";
  $position=0;
  while (($plannings_array[$position]->current_time<=date_number_to_en($j).":00") && ($position<count($plannings_array)))
  {
  if ($plannings_array[$position]->current_time==date_number_to_en($j).":00")
  {
  $id_tache=$plannings_array[$position]->id_tache;
  $titre=$plannings_array[$position]->titre_tache;
  $consigne=$plannings_array[$position]->consigne_tache;
  $lieu=$plannings_array[$position]->nom_lieu;
  $id_lieu=$plannings_array[$position]->id_lieu; 
  for ($l=0;$l<count($vehicules_array);$l++)
  {
  if ($vehicules_array[$l]->id_vehicule==$plannings_array[$position]->id_vehicule)
  {
  $vehicule=$vehicules_array[$l]->nom;
  break;
  }
  }
  for ($l=0;$l<count($orgas_array);$l++)
  {
  if ($orgas_array[$l]->id_orga==$plannings_array[$position]->id_resp)
  {
  $nom_resp=$orgas_array[$l]->nom_orga;
  break;
  }
  }
  $matos=$plannings_array[$position]->matos; 
  $list_orgas=explode("|",$plannings_array[$position]->id_orga);
  for ($l=0;$l<count($list_orgas);$l++)
  {
  for ($m=0;$m<count($orgas_array);$m++)
  {
  if (($orgas_array[$m]->id_orga==$list_orgas[$l]) && ($orgas_array[$m]->id_orga!=$id_orga))
  {
  if ($coequipiers!="") $coequipiers=$coequipiers.", ";
  $coequipiers=$coequipiers.$orgas_array[$m]->nom_orga;
  break;
  }
  }
  }
  break;
  }
  else $position++;
  }
  if (($id_tache_array[$k]==$id_tache) && ($id_tache!="")) $consigne="idem";
  if ($titre=="") $titre="Pause";
  else $titre="<A HREF=\"main.php?file=orgas&action=tache&id_tache=".$id_tache."\" CLASS=\"lien\">".$titre."</A>";
  if ($consigne=="") $consigne="rien...";
  if ($lieu!="") $lieu="<BR><U>Lieu</U>&nbsp;: <A HREF=\"main.php?file=orgas&action=lieu&id_lieu=".$id_lieu."\" CLASS=\"lien\">".$lieu."</A>";
  if ($vehicule!="") $vehicule="<BR><U>V&eacute;hicule</U>&nbsp;: ".$vehicule;
  if ($nom_resp!="") $nom_resp="<BR><U>Responsable</U>&nbsp;: ".$nom_resp;
  if ($matos!="") $matos="<BR><U>Matos</U>&nbsp;: ".$matos;
  if ($coequipiers!="") $coequipiers="<BR><U>Avec qui tu bosses</U>&nbsp;: ".$coequipiers;
  $id_tache_array[$k]=$id_tache;
  $k++;
  ?>
  </TD>
  <TD nowrap>                  <B><? print($titre); ?></B>                </TD>              </TR>              <TR>                <TD colspan="2"> <u>R&egrave;gles</u>&nbsp;: <? print(nl2br($consigne)); ?>                   <? print($lieu); ?> <? print($nom_resp); ?> <? print($matos); ?>                   <? print($coequipiers); ?> <? print($vehicule); ?> </TD>              </TR>            </TABLE>          </TD>          <TD width="1%" bgcolor="#E34121">&nbsp;</TD>
  <?
  $j=$j+800;
  //POUR LES 1/3 journees
  //      $j=$j+1200;
  //POUR LES 1/2 journees      $j=test_time($j);
  }
  ?>        </TR>
  <?
  }
  ?>
  </TABLE>
  </TD>
  </TR></TABLE>