<?
  isset($_GET['id_talkie']) ? $id_talkie = $_GET['id_talkie'] : $id_talkie = "";
  $req_sql="SELECT * FROM talkies WHERE id_talkie='".$id_talkie."'";
  $req = mysql_query($req_sql);
?>

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
<FORM method="POST" name="form" action="db_action.php?db_action=update_talkie">
  <TR>
    <TD colspan="3">&nbsp;</TD>
  </TR>
  <TR CLASS="talkies_top">
    <TD colspan="3">
      <B>Modification d'un talkie</B>
    </TD>
  </TR>

<?
  $talkies_array=result_talkies($req);
  for ($i=0;$i<count($talkies_array);$i++)
  {
?>

  <TR CLASS="talkies">
    <TD>&nbsp;&nbsp;&nbsp;</TD>
    <TD nowrap>
      Nom&nbsp;:&nbsp;
    </TD>
    <TD WIDTH="1%">
      <INPUT TYPE="text" NAME="nom" VALUE="<? print($talkies_array[$i]->nom); ?>" SIZE="20" MAXLENGTH="40">
      <INPUT TYPE="hidden" NAME="id_talkie" VALUE="<? print($talkies_array[$i]->id_talkie); ?>">
    </TD>
  </TR>

<?
  }
?>

  <TR CLASS="talkies">
    <TD colspan="3">&nbsp;</TD>
  </TR>
  <TR CLASS="talkies">
    <TD colspan="3" ALIGN="center">
      <INPUT TYPE="button" VALUE="Envoyer" onClick="verify()">
      <INPUT TYPE="button" VALUE="Effacer" onClick="window.location.reload()">
    </TD>
  </TR>
</FORM>
</TABLE>
