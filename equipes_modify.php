<?
  isset($_GET['id_equipe']) ? $id_equipe = $_GET['id_equipe'] : $id_equipe = ""; 

  $req_sql="SELECT * FROM equipes WHERE id_equipe='".$id_equipe."'";
  $req = mysql_query($req_sql);
?>

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

<TABLE WIDTH="1%" CELLSPACING="0" CELLPADDING="3">
<FORM method="POST" name="form" action="db_action.php?db_action=update_equipe">
  <TR>
    <TD colspan="3">&nbsp;</TD>
  </TR>
  <TR CLASS="equipes_top">
    <TD colspan="3">
      <B>Modification d'une &eacute;quipe</B>
    </TD>
  </TR>

<?
  $equipes_array=result_equipes($req);

  for ($i=0;$i<count($equipes_array);$i++)
  {
?>

  <TR CLASS="equipes">
    <TD>&nbsp;&nbsp;&nbsp;</TD>
    <TD nowrap>
      Nom&nbsp;:&nbsp;
    </TD>
    <TD WIDTH="1%">
      <INPUT TYPE="text" NAME="nom" VALUE="<? print($equipes_array[$i]->nom); ?>" SIZE="20" MAXLENGTH="40">
      <INPUT TYPE="hidden" NAME="id_equipe" VALUE="<? print($equipes_array[$i]->id_equipe); ?>">
    </TD>
  </TR>

<?
  }
?>

  <TR CLASS="equipes">
    <TD colspan="3">&nbsp;</TD>
  </TR>
  <TR CLASS="equipes">
    <TD colspan="3" ALIGN="center">
      <INPUT TYPE="button" VALUE="Envoyer" onClick="verify()">
      <INPUT TYPE="button" VALUE="Effacer" onClick="window.location.reload()">
    </TD>
  </TR>
</FORM>
</TABLE>
