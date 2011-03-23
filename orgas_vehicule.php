<?
  isset($_POST['id_vehicule']) ? $id_vehicule = $_POST['id_vehicule'] : $id_vehicule = "";
  if ($id_vehicule=="")  {
      $req_sql="SELECT MIN(id_vehicule) FROM vehicules";
      $req = mysql_query($req_sql);
      while ($data = mysql_fetch_array($req))
      {
          $id_vehicule=$data['MIN(id_vehicule)'];
      }
  }

$req_sql = "SELECT taches.titre, lieux.nom_lieu, orgas.id_orga, taches.begin_time, taches.end_time, orgas.first_name, orgas.last_name
FROM taches, lieux, vehicules, orgas
WHERE taches.id_vehicule=vehicules.id_vehicule
AND taches.id_resp=orgas.id_orga
AND taches.id_vehicule='".$id_vehicule."'
AND taches.id_lieu=lieux.id_lieu
ORDER BY taches.begin_time, taches.titre";

  $req_plannings = mysql_query($req_sql);
  $req_sql="SELECT * FROM orgas ORDER BY first_name, last_name";
  $req_orgas = mysql_query($req_sql);
  $req_sql="SELECT * FROM vehicules ORDER BY nom_vehicule";
  $req_vehicules = mysql_query($req_sql);
  ?>

  <TABLE width="1%" cellspacing="0" cellpadding="3">
  <FORM method="POST" name="form" action="main.php?file=orgas&action=vehicule">
  <TR>
    <TD colspan="5">&nbsp;</TD>
  </TR>
  <TR class="orgas_top">
    <TD colspan="5" nowrap>      <B>Choisis un v&eacute;hicule</B>&nbsp;&nbsp;&nbsp;
    <SELECT name="id_vehicule" onChange="document.form.submit()">
    <?
    $vehicules_array=result_vehicules($req_vehicules);
    for ($i=0;$i<count($vehicules_array);$i++)
    {
        $is_selected="";
        if ($vehicules_array[$i]->id_vehicule==$id_vehicule) $is_selected="selected";
    ?>
    <OPTION <? print($is_selected); ?> value="<? print($vehicules_array[$i]->id_vehicule); ?>"><? print($vehicules_array[$i]->nom); ?>
    </OPTION><?
}
?>
</SELECT>
</TD>
</TR>
<TR class="orgas_top">

<TD colspan="2" nowrap>      <B>Orgas Resp</B>    </TD>
<TD align="center">      <B>Heures début</B>    </TD>
<TD align="center">      <B>Heures fin</B>    </TD>
<TD align="center">      <B>T&acirc;ches</B>    </TD>
<TD align="center">      <B>Lieux</B>    </TD>
</TR>
<?

while($plannings_array = mysql_fetch_array($req_plannings))
{

?>
<TR class="orgas">
 <TD width="1%">&nbsp;&nbsp;&nbsp;</TD>
 <TD valign="top" nowrap>      <A href="main.php?file=plannings&action=edit&id_orga=<? print($plannings_array['id_orga']); ?>" class="lien">
 <? print($plannings_array['first_name'].' '.$plannings_array['last_name']); ?></A>    </TD>
 <TD align="center" nowrap>      <? print(substr(date_en_to_fr($plannings_array['begin_time']),0,16)); ?>    </TD>
 <TD align="center" nowrap>      <? print(substr(date_en_to_fr($plannings_array['end_time']),0,16)); ?>    </TD>
 <TD align="center" valign="top" nowrap>      <? print($plannings_array['titre']); ?>    </TD>
 <TD align="center" valign="top" nowrap>      <? print($plannings_array['nom_lieu']); ?>    </TD>
 </TR>
 <?

}
?>
</FORM>
</TABLE>