<?
  isset($_POST['id_vehicule']) ? $id_vehicule = $_POST['id_vehicule'] : $id_vehicule = "";
  if ($id_vehicule=="")  {    $req_sql="SELECT MIN(id_vehicule) FROM vehicules";    $req = mysql_query($req_sql);    while ($data = mysql_fetch_array($req))    {      $id_vehicule=$data['MIN(id_vehicule)'];    }  }  $req_sql="SELECT taches.*, lieux.nom_lieu, orgas.first_name, orgas.last_name FROM taches, lieux, orgas WHERE taches.id_vehicule='".$id_vehicule."' AND taches.id_lieu=lieux.id_lieu AND taches.id_resp=orgas.id_orga ORDER BY taches.titre";  $req_taches = mysql_query($req_sql);  $req_sql="SELECT * FROM vehicules ORDER BY nom_vehicule";  $req_vehicules = mysql_query($req_sql);?><TABLE WIDTH="1%" CELLSPACING="0" CELLPADDING="3"><FORM method="POST" name="form" action="main.php?file=taches&action=vehicule">  <TR>    <TD colspan="6">&nbsp;</TD>  </TR>  <TR CLASS="taches_top">    <TD colspan="6" nowrap>      <B>Choisis un vehicule</B>&nbsp;&nbsp;&nbsp;      <SELECT NAME="id_vehicule" onChange="document.form.submit()"><?  $vehicules_array=result_vehicules($req_vehicules);  for ($i=0;$i<count($vehicules_array);$i++)  {    $is_selected="";    if ($vehicules_array[$i]->id_vehicule==$id_vehicule) $is_selected="selected";?>        <OPTION <? print($is_selected); ?> VALUE="<? print($vehicules_array[$i]->id_vehicule); ?>"><? print($vehicules_array[$i]->nom); ?></OPTION><?  }?>      </SELECT>    </TD>  </TR>  <TR CLASS="taches_top">    <TD COLSPAN="2" nowrap>      <B>Liste des t&acirc;ches</B>    </TD>    <TD ALIGN="center">      <B>D&eacute;but</B>    </TD>    <TD ALIGN="center">      <B>Fin</B>    </TD>    <TD ALIGN="center">      <B>Lieu</B>    </TD>    <TD ALIGN="center">      <B>Responsable</B>    </TD>  </TR><?  $taches_array=result_taches($req_taches);  for ($i=0;$i<count($taches_array);$i++)  {?>  <TR CLASS="taches">      <TD width="1%">&nbsp;&nbsp;&nbsp;</TD>    <TD VALIGN="top" nowrap>      <? print($taches_array[$i]->titre); ?>    </TD>    <TD ALIGN="center" nowrap>      <? print(substr(date_en_to_fr($taches_array[$i]->begin_time),0,16)); ?>    </TD>    <TD ALIGN="center" nowrap>      <? print(substr(date_en_to_fr($taches_array[$i]->end_time),0,16)); ?>    </TD>    <TD ALIGN="center" VALIGN="top" nowrap>      <? print($taches_array[$i]->nom_lieu); ?>    </TD>    <TD ALIGN="center" VALIGN="top" nowrap>      <? print($taches_array[$i]->nom_orga); ?>    </TD>  </TR><?  }?></FORM></TABLE>