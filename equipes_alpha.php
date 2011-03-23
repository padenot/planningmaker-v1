<?
  $req_sql="SELECT * FROM equipes ORDER BY nom_equipe";
  $req = mysql_query($req_sql);
?>

<SCRIPT language="JavaScript">
function verif(id)
{
  if (confirm('Es-tu sûr de vouloir supprimer cette équipe ?'))
  {
    document.form_suppr.id_equipe.value=id;
	document.form_suppr.submit();
  }
}
</SCRIPT>

<TABLE WIDTH="1%" CELLSPACING="0" CELLPADDING="3">
  <TR>
    <TD colspan="4">&nbsp;</TD>
  </TR>
  <TR CLASS="equipes_top">
    <TD COLSPAN="2" nowrap>
      <B>Liste des &eacute;quipes</B>
    </TD>
    <TD ALIGN="center">
      <B>Planning</B>
    </TD>
    <TD ALIGN="center">
      <B>Supprimer</B>
    </TD>
  </TR>

<?
  $equipes_array=result_equipes($req);

  for ($i=0;$i<count($equipes_array);$i++)
  {
?>

  <TR CLASS="equipes" onMouseOver="this.className='over'" onMouseOut="this.className='equipes'">
    <TD width="1%">&nbsp;&nbsp;&nbsp;</TD>
    <TD nowrap>
      <A HREF="main.php?file=equipes&action=modify&id_equipe=<? print($equipes_array[$i]->id_equipe); ?>" CLASS="lien"><? print($equipes_array[$i]->nom); ?></A>
    </TD>
    <TD ALIGN="center" WIDTH="1%">
      <A HREF="main.php?file=plannings_eq&action=edit&id_equipe=<? print($equipes_array[$i]->id_equipe); ?>" CLASS="lien">Go</A>
    </TD>
    <TD ALIGN="center" WIDTH="1%">
      <A HREF="javascript:verif(<? print($equipes_array[$i]->id_equipe); ?>)" CLASS="lien">Go</A>
    </TD>
  </TR>

<?
  }
?>

</TABLE>

<FORM name="form_suppr" action="db_action.php?db_action=delete_equipe" method="post">
<INPUT name="id_equipe" type="hidden">
</FORM>
