<SCRIPT language="Javascript">
<!--
function verify()
{
  var ok=1;
  if (document.form.nom.value=="")
  {
    alert("Tu dois donner un nom d'équipe");
    ok=0;
  }
  if (ok==1) document.form.submit();
}
-->
</SCRIPT>

<TABLE width="1%" cellspacing="0" cellpadding="3">
<FORM method="POST" name="form" action="db_action.php?db_action=insert_equipe">
  <TR>
    <TD colspan="3">&nbsp;</TD>
  </TR>
  <TR class="equipes_top">
    <TD colspan="3">
      <B>Ajout d'une &eacute;quipe</B>
    </TD>
  </TR>
  <TR class="equipes">
    <TD>&nbsp;&nbsp;&nbsp;</TD>
    <TD nowrap>
      Nom&nbsp;:&nbsp;
    </TD>
    <TD width="1%">
      <INPUT type="text" name="nom" size="20" maxlength="40">
    </TD>
  </TR>
  <TR class="equipes">
    <TD colspan="3">&nbsp;</TD>
  </TR>
  <TR class="equipes">
    <TD colspan="3" align="center">
      <INPUT type="button" value="Envoyer" onClick="verify()">
      <INPUT type="reset" value="Effacer">
    </TD>
  </TR>
</FORM>
</TABLE>
