<SCRIPT language="JavaScript">
function verif(id)
{
  if (confirm('Es-tu sûr de vouloir supprimer cette catégorie ?'))
  {
    document.form_suppr.id_categorie.value=id;
	document.form_suppr.submit();
  }
}
</SCRIPT>
<?
  $req_sql="SELECT DISTINCT type_categorie FROM categories";
  $req = mysql_query($req_sql);
  $type_categories_array=result_categories($req);
  for ($j=0;$j<count($type_categories_array);$j++)
  {

  $req_sql="SELECT * FROM categories WHERE type_categorie='".$type_categories_array[$j]->type."' ORDER BY nom_categorie ";
  $req = mysql_query($req_sql);
?>





<TABLE WIDTH="1%" CELLSPACING="0" CELLPADDING="3">
  <TR>
    <TD colspan="4">&nbsp;</TD>
  </TR>
  <TR CLASS="categories_top">
    <TD COLSPAN="2" nowrap> <B>Liste des cat&eacute;gories <? print($type_categories_array[$j]->type); ?></B> </TD>
    <TD ALIGN="center">
      <B>Supprimer</B>
    </TD>
  </TR>
<?
  $categories_array=result_categories($req);
  for ($i=0;$i<count($categories_array);$i++)
  {
  
?>



  <TR CLASS="categories" onMouseOver="this.className='over'" onMouseOut="this.className='categories'">
    <TD width="1%">&nbsp;&nbsp;&nbsp;</TD>
    <TD nowrap class="<? print($categories_array[$i]->couleur); ?>">
      <A HREF="main.php?file=categories&action=modify&id_categorie=<? print($categories_array[$i]->id_categorie); ?>" CLASS="lien"><? print($categories_array[$i]->nom); ?></A>
    </TD>
    <TD ALIGN="center" WIDTH="1%">
	<? if ($session_user_type!="soft")
    {?>
      <A HREF="javascript:verif(<? print($categories_array[$i]->id_categorie); ?>)" CLASS="lien">Go</A><? } ?>
    </TD>
  </TR>

<?
}
?>

</TABLE>

<? } ?>



<FORM name="form_suppr" action="db_action.php?db_action=delete_categorie" method="post">
<INPUT name="id_categorie" type="hidden">
</FORM>
