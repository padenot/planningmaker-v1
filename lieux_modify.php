<?
  isset($_GET['id_lieu']) ? $id_lieu = $_GET['id_lieu'] : $id_lieu = ""; 

  $req_sql="SELECT * FROM lieux WHERE id_lieu='".$id_lieu."'";
  $req = mysql_query($req_sql);
?>

<SCRIPT language="Javascript">
<!--
function verify()
{
  var ok=1;
  if (document.form.nom.value=="")
  {
    alert("Tu dois donner un nom de lieu");
    ok=0;
  }
  if (ok==1) document.form.submit();
}
-->
</SCRIPT>

<TABLE WIDTH="1%" CELLSPACING="0" CELLPADDING="3">
<FORM method="POST" name="form" action="db_action.php?db_action=update_lieu">
  <TR>
    <TD colspan="3">&nbsp;</TD>
  </TR>
  <TR CLASS="lieux_top">
    <TD colspan="3">
      <B>Modification d'un lieu</B>
    </TD>
  </TR>

<?
  $lieux_array=result_lieux($req);
  for ($i=0;$i<count($lieux_array);$i++)
  {
?>

  <TR CLASS="lieux">
    <TD>&nbsp;&nbsp;&nbsp;</TD>
    <TD nowrap>
      Nom&nbsp;:&nbsp;
    </TD>
    <TD WIDTH="1%">
      <INPUT TYPE="text" NAME="nom" VALUE="<? print($lieux_array[$i]->nom); ?>" SIZE="20" MAXLENGTH="40">
      <INPUT TYPE="hidden" NAME="id_lieu" VALUE="<? print($lieux_array[$i]->id_lieu); ?>">
    </TD>
  </TR>

<?
  }
?>

  <TR CLASS="lieux">
    <TD colspan="3">&nbsp;</TD>
  </TR>
  <TR CLASS="lieux">
    <TD colspan="3" ALIGN="center">
      <INPUT TYPE="button" VALUE="Envoyer" onClick="verify()">
      <INPUT TYPE="button" VALUE="Effacer" onClick="window.location.reload()">
    </TD>
  </TR>
</FORM>
</TABLE>
