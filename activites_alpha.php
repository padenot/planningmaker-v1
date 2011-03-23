<?
  $req_sql="SELECT activites.*, lieux.nom_lieu FROM activites,lieux WHERE activites.id_lieu=lieux.id_lieu ORDER BY activites.titre";
  $req = mysql_query($req_sql);
?>

<SCRIPT language="JavaScript">
function verif(id)
{
  if (confirm('Es-tu sûr de vouloir supprimer cette activité ?'))
  {
    document.form_suppr.id_activite.value=id;
	document.form_suppr.submit();
  }
}
</SCRIPT>

<TABLE WIDTH="1%" CELLSPACING="0" CELLPADDING="3">
  <TR>
    <TD colspan="8">&nbsp;</TD>
  </TR>
  <TR CLASS="activites_top">
    <TD COLSPAN="2" nowrap>
      <B>Liste des activit&eacute;s</B>
    </TD>
    <TD ALIGN="center">
      <B>D&eacute;but</B>
    </TD>
    <TD ALIGN="center">
      <B>Fin</B>
    </TD>
    <TD ALIGN="center">
      <B>Dur&eacute;e</B>
    </TD>
    <TD ALIGN="center">
      <B>Lieu</B>
    </TD>
    <TD ALIGN="center">
      <B>Planning</B>
    </TD>
    <TD ALIGN="center">
      <B>Supprimer</B>
    </TD>
  </TR>

<?
  $activites_array=result_activites($req);
  for ($i=0;$i<count($activites_array);$i++)
  {
?>

  <TR CLASS="activites" onMouseOver="this.className='over'" onMouseOut="this.className='activites'">
    <TD width="1%">&nbsp;&nbsp;&nbsp;</TD>
    <TD nowrap>
      <A HREF="main.php?file=activites&action=modify&id_activite=<? print($activites_array[$i]->id_activite); ?>" CLASS="lien"><? print($activites_array[$i]->titre); ?></A>
    </TD>
    <TD ALIGN="center" nowrap>
      <? print(substr(date_en_to_fr($activites_array[$i]->begin_time),0,16)); ?>
    </TD>
    <TD ALIGN="center" nowrap>
      <? print(substr(date_en_to_fr($activites_array[$i]->end_time),0,16)); ?>
    </TD>
    <TD ALIGN="center" nowrap>
      <? print(substr($activites_array[$i]->duree,0,5)); ?>
    </TD>
    <TD ALIGN="center" nowrap>
      <? print($activites_array[$i]->nom_lieu); ?>
    </TD>
    <TD ALIGN="center" WIDTH="1%">
      <A HREF="main.php?file=equipes&action=activite&id_activite=<? print($activites_array[$i]->id_activite); ?>" CLASS="lien">Go</A>
    </TD>
    <TD ALIGN="center" WIDTH="1%">
      <A HREF="javascript:verif(<? print($activites_array[$i]->id_activite); ?>)" CLASS="lien">Go</A>
    </TD>
  </TR>

<?
  }

  $req_sql="SELECT activites.* FROM activites WHERE activites.id_lieu='0' ORDER BY activites.titre";
  $req = mysql_query($req_sql);

  $activites_array=result_activites($req);
  for ($i=0;$i<count($activites_array);$i++)
  {
    if ($i==0)
	{
?>

  <TR CLASS="activites">
    <TD colspan="8"><HR width="75%"></TD>
  </TR>

<?
    }
?>

  <TR CLASS="activites" onMouseOver="this.className='over'" onMouseOut="this.className='activites'">
    <TD width="1%">&nbsp;&nbsp;&nbsp;</TD>
    <TD nowrap>
      <A HREF="main.php?file=activites&action=modify&id_activite=<? print($activites_array[$i]->id_activite); ?>" CLASS="lien"><? print($activites_array[$i]->titre); ?></A>
    </TD>
    <TD ALIGN="center" nowrap>
      <? print(substr(date_en_to_fr($activites_array[$i]->begin_time),0,16)); ?>
    </TD>
    <TD ALIGN="center" nowrap>
      <? print(substr(date_en_to_fr($activites_array[$i]->end_time),0,16)); ?>
    </TD>
    <TD ALIGN="center" nowrap>
      <? print(substr($activites_array[$i]->duree,0,5)); ?>
    </TD>
    <TD ALIGN="center" nowrap>
      A d&eacute;finir
    </TD>
    <TD ALIGN="center" WIDTH="1%">
      <A HREF="main.php?file=equipes&action=activite&id_activite=<? print($activites_array[$i]->id_activite); ?>" CLASS="lien">Go</A>
    </TD>
    <TD ALIGN="center" WIDTH="1%">
      <A HREF="javascript:verif(<? print($activites_array[$i]->id_activite); ?>)" CLASS="lien">Go</A>
    </TD>
  </TR>

<?
  }
?>

</TABLE>

<FORM name="form_suppr" action="db_action.php?db_action=delete_activite" method="post">
<INPUT name="id_activite" type="hidden">
</FORM>
