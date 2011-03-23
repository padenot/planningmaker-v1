<?
  $req_sql="SELECT * FROM vehicules ORDER BY nom_vehicule";
  $req = mysql_query($req_sql);
?>

<SCRIPT language="JavaScript">
function verif(id)
{
  if (confirm('Es-tu sûr de vouloir supprimer ce véhicule ?'))
  {
    document.form_suppr.id_vehicule.value=id;
	document.form_suppr.submit();
  }
}
</SCRIPT>

<TABLE WIDTH="1%" CELLSPACING="0" CELLPADDING="3">
  <TR>
    <TD colspan="4">&nbsp;</TD>
  </TR>
  <TR CLASS="vehicules_top">
    <TD colspan="4"><B><A href="<? print($file."_print.php"); ?>" target="_blank" class="menu"><img src="images/print.jpg"></A></B></TD>
  </TR>
  <TR CLASS="vehicules_top">
    <TD COLSPAN="2" nowrap>
      <B>Liste des v&eacute;hicules</B>
    </TD>
    <TD ALIGN="center"> <B>Planning</B> </TD>
    <TD ALIGN="center">
      <B>Supprimer</B>
    </TD>
  </TR>

<?
  $vehicules_array=result_vehicules($req);
  for ($i=0;$i<count($vehicules_array);$i++)
  {
?>

  <TR CLASS="vehicules" onMouseOver="this.className='over'" onMouseOut="this.className='vehicules'">
    <TD width="1%">&nbsp;&nbsp;&nbsp;</TD>
    <TD nowrap>
      <A HREF="main.php?file=vehicules&action=modify&id_vehicule=<? print($vehicules_array[$i]->id_vehicule); ?>" CLASS="lien"><? print($vehicules_array[$i]->nom); ?></A>
    </TD>
    <TD ALIGN="center" WIDTH="1%">
      <A HREF="main.php?file=orgas&action=vehicule&id_vehicule=<? print($vehicules_array[$i]->id_vehicule); ?>" CLASS="lien">Go</A>
    </TD>
    <TD ALIGN="center" WIDTH="1%">
      <A HREF="javascript:verif(<? print($vehicules_array[$i]->id_vehicule); ?>)" CLASS="lien">Go</A>
    </TD>
  </TR>

<?
  }
?>

</TABLE>

<FORM name="form_suppr" action="db_action.php?db_action=delete_vehicule" method="post">
<INPUT name="id_vehicule" type="hidden">
</FORM>
