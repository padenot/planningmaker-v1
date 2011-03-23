<?
  isset($_GET['id_vehicule']) ? $id_vehicule = $_GET['id_vehicule'] : $id_vehicule = ""; 

  $req_sql="SELECT * FROM vehicules WHERE id_vehicule='".$id_vehicule."'";
  $req = mysql_query($req_sql);
?>

<SCRIPT language="Javascript">
<!--
function verify()
{
  var ok=1;
  if (document.form.nom.value=="")
  {
    alert("Tu dois donner un nom de véhicule");
    ok=0;
  }
  if (ok==1) document.form.submit();
}
-->
</SCRIPT>

<TABLE WIDTH="1%" CELLSPACING="0" CELLPADDING="3">
<FORM method="POST" name="form" action="db_action.php?db_action=update_vehicule">
  <TR>
    <TD colspan="3">&nbsp;</TD>
  </TR>
  <TR CLASS="vehicules_top">
    <TD colspan="3">
      <B>Modification d'un v&eacute;hicule</B>
    </TD>
  </TR>

<?
  $vehicules_array=result_vehicules($req);
  for ($i=0;$i<count($vehicules_array);$i++)
  {
?>

  <TR CLASS="vehicules">
    <TD>&nbsp;&nbsp;&nbsp;</TD>
    <TD nowrap>
      Nom&nbsp;:&nbsp;
    </TD>
    <TD WIDTH="1%">
      <INPUT TYPE="text" NAME="nom" VALUE="<? print($vehicules_array[$i]->nom); ?>" SIZE="20" MAXLENGTH="40">
      <INPUT TYPE="hidden" NAME="id_vehicule" VALUE="<? print($vehicules_array[$i]->id_vehicule); ?>">
    </TD>
  </TR>

<?
  }
?>

  <TR CLASS="vehicules">
    <TD colspan="3">&nbsp;</TD>
  </TR>
  <TR CLASS="vehicules">
    <TD colspan="3" ALIGN="center">
      <INPUT TYPE="button" VALUE="Envoyer" onClick="verify()">
      <INPUT TYPE="button" VALUE="Effacer" onClick="window.location.reload()">
    </TD>
  </TR>
</FORM>
</TABLE>
