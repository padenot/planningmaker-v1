<?
  $req_sql="SELECT * FROM talkies ORDER BY nom_talkie";
  $req = mysql_query($req_sql);
?>

<SCRIPT language="JavaScript">
function verif(id)
{
  if (confirm('Es-tu sûr de vouloir supprimer ce talkie ?'))
  {
    document.form_suppr.id_talkie.value=id;
	document.form_suppr.submit();
  }
}
</SCRIPT>

<TABLE WIDTH="1%" CELLSPACING="0" CELLPADDING="3">
  <TR>
    <TD colspan="4">&nbsp;</TD>
  </TR>
  <TR CLASS="talkies_top">
    <TD colspan="4">
	  <B><A href="<? print($file."_print.php"); ?>" target="_blank" class="menu">Imprimer</A></B>
	</TD>
  </TR>
  <TR CLASS="talkies_top">
    <TD COLSPAN="2" nowrap>
      <B>Liste des talkies</B>
    </TD>
    <TD ALIGN="center">
      <B>Supprimer</B>
    </TD>
  </TR>

<?
  $talkies_array=result_talkies($req);
  for ($i=0;$i<count($talkies_array);$i++)
  {
?>

  <TR CLASS="talkies" onMouseOver="this.className='over'" onMouseOut="this.className='talkies'">
    <TD width="1%">&nbsp;&nbsp;&nbsp;</TD>
    <TD nowrap>
      <A HREF="main.php?file=talkies&action=modify&id_talkie=<? print($talkies_array[$i]->id_talkie); ?>" CLASS="lien"><? print($talkies_array[$i]->nom); ?></A>
    </TD>
    <TD ALIGN="center" WIDTH="1%">
      <A HREF="javascript:verif(<? print($talkies_array[$i]->id_talkie); ?>)" CLASS="lien">Go</A>
    </TD>
  </TR>

<?
  }
?>

</TABLE>

<FORM name="form_suppr" action="db_action.php?db_action=delete_talkie" method="post">
<INPUT name="id_talkie" type="hidden">
</FORM>
