<SCRIPT language="Javascript">
<!--
function verify()
{
  var ok=1;
  if (document.form.nom.value=="")
  {
    alert("Tu dois donner un nom de talkie");
    ok=0;
  }
  if (ok==1) document.form.submit();
}
-->
</SCRIPT>

<TABLE WIDTH="1%" CELLSPACING="0" CELLPADDING="3">
<FORM method="POST" name="form" action="db_action.php?db_action=insert_talkie">
  <TR>
    <TD colspan="3">&nbsp;</TD>
  </TR>
  <TR CLASS="talkies_top">
    <TD colspan="3">
      <B>Ajout d'un talkie</B>
    </TD>
  </TR>
  <TR CLASS="talkies">
    <TD>&nbsp;&nbsp;&nbsp;</TD>
    <TD nowrap>
      Nom&nbsp;:&nbsp;
    </TD>
    <TD WIDTH="1%">
      <INPUT TYPE="text" NAME="nom" SIZE="20" MAXLENGTH="40">
    </TD>
  </TR>
  <TR CLASS="talkies">
    <TD colspan="3">&nbsp;</TD>
  </TR>
  <TR CLASS="talkies">
    <TD colspan="3" ALIGN="center">
      <INPUT TYPE="button" VALUE="Envoyer" onClick="verify()">
      <INPUT TYPE="reset" VALUE="Effacer">
    </TD>
  </TR>
</FORM>
</TABLE>
