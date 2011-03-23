<?
  $req_sql="SELECT * FROM lieux ORDER BY nom_lieu";
  $req = mysql_query($req_sql);
?>

<SCRIPT language="JavaScript">
function verif(id)
{
  if (confirm('Es-tu sûr de vouloir supprimer ce lieu ?'))
  {
    document.form_suppr.id_lieu.value=id;
	document.form_suppr.submit();
  }
}
</SCRIPT>

<TABLE WIDTH="1%" CELLSPACING="0" CELLPADDING="3">
  <TR>
    <TD colspan="4">&nbsp;</TD>
  </TR>
  <TR CLASS="lieux_top">
    <TD colspan="4"><B><A href="<? print($file."_print.php"); ?>" target="_blank" class="menu"><img src="images/print.jpg"></A></B></TD>
  </TR>
  <TR CLASS="lieux_top">
    <TD COLSPAN="2" nowrap>
      <B>Liste des lieux</B>
    </TD>
    <TD ALIGN="center"> <B>Planning</B> </TD>
    <TD ALIGN="center">
      <B>Supprimer</B>
    </TD>
  </TR>

<?
  $lieux_array=result_lieux($req);
  for ($i=0;$i<count($lieux_array);$i++)
  {
?>

  <TR CLASS="lieux" onMouseOver="this.className='over'" onMouseOut="this.className='lieux'">
    <TD width="1%">&nbsp;&nbsp;&nbsp;</TD>
    <TD nowrap>
      <A HREF="main.php?file=lieux&action=modify&id_lieu=<? print($lieux_array[$i]->id_lieu); ?>" CLASS="lien"><? print($lieux_array[$i]->nom); ?></A>
    </TD>
    <TD ALIGN="center" WIDTH="1%">
      <A HREF="main.php?file=orgas&action=lieu&id_lieu=<? print($lieux_array[$i]->id_lieu); ?>" CLASS="lien">Go</A>
    </TD>
    <TD ALIGN="center" WIDTH="1%">
	<? if ($session_user_type!="soft")
    {?>
      <A HREF="javascript:verif(<? print($lieux_array[$i]->id_lieu); ?>)" CLASS="lien">Go</A> <? } ?>
    </TD>
  </TR>

<?
  }
?>

</TABLE>

<FORM name="form_suppr" action="db_action.php?db_action=delete_lieu" method="post">
<INPUT name="id_lieu" type="hidden">
</FORM>
