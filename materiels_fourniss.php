<?
  isset($_POST['id_fournisseur']) ? $id_fournisseur = $_POST['id_fournisseur'] : $id_fournisseur = "";
if ($id_fournisseur=="")
  {
    $req_sql="SELECT MIN(id_fournisseur) FROM fournisseurs";
    $req = mysql_query($req_sql);
    while ($data = mysql_fetch_array($req))
    {
      $id_fournisseur=$data['MIN(id_fournisseur)'];
    }
  }


  $req_sql="SELECT materiels.* FROM materiels WHERE materiels.id_fournisseur='".$id_fournisseur."' ORDER BY materiels.commande, materiels.reception, materiels.retour, materiels.nom_materiel";
  $req_materiels = mysql_query($req_sql);

  $req_sql="SELECT * FROM fournisseurs ORDER BY name";
  $req_fournisseurs = mysql_query($req_sql);
  
  $req_sql="SELECT * FROM categories ORDER BY nom_categorie";
  $req_categories = mysql_query($req_sql);
?>

<TABLE WIDTH="1%" CELLSPACING="0" CELLPADDING="3">
  <FORM method="POST" name="form" action="main.php?file=materiels&action=fourniss" >
  <TR>
    <TD colspan="6">&nbsp;</TD>
  </TR>
  <TR CLASS="taches_top">
      <TD colspan="6" nowrap> 
        <B>Choisis un fournisseur </B>&nbsp;&nbsp;&nbsp; 
        <SELECT NAME="id_fournisseur" onChange="document.form.submit()">

<?
  $fournisseurs_array=result_fournisseurs($req_fournisseurs);
  for ($i=0;$i<count($fournisseurs_array);$i++)
  {
    $is_selected="";
    if ($fournisseurs_array[$i]->id_fournisseur==$id_fournisseur) $is_selected="selected";
?>

        <OPTION <? print($is_selected); ?> VALUE="<? print($fournisseurs_array[$i]->id_fournisseur); ?>"><? print($fournisseurs_array[$i]->name); ?></OPTION>

<?
  }
?>

      </SELECT>
    </TD>
  </TR>
  <TR>
    <TD colspan="8">&nbsp;</TD>
  </TR>
  <TR CLASS="taches_top">
      <TD COLSPAN="2" nowrap> 
        <B>Liste du materiel</B> 
      </TD>
    <TD ALIGN="center"> 
      <b>Quantit&eacute;</b> 
    </TD>
    <TD ALIGN="center"> 
      <B>commandé</B> 
    </TD>
      <TD ALIGN="center"> 
        <B>re&ccedil;u</B> 
      </TD>
	  <TD ALIGN="center"> 
        <B>rendu</B> 
      </TD>
  </TR>

<?
  $materiels_array=result_materiels($req_materiels);
  for ($i=0;$i<count($materiels_array);$i++)
  {
?>

  <TR valign="top" CLASS="taches" onMouseOver="this.className='over'" onMouseOut="this.className='materiels'"> 
    <TD width="1%">&nbsp;&nbsp;&nbsp;</TD>
    <TD nowrap> <A HREF="main.php?file=materiels&action=modify&id_materiel=<? print($materiels_array[$i]->id_materiel); ?>" CLASS="lien"><? print($materiels_array[$i]->nom_materiel); ?></A>
    </TD>
    <TD nowrap> 
      <? print($materiels_array[$i]->quantite);?>
    </TD>
    <TD nowrap align="center"> <? 
	if ($materiels_array[$i]->commande=='yes')
	{?>OK<? }
	else {?>-----<? }?> </TD>
    <TD nowrap> <? 
	if ($materiels_array[$i]->reception=='yes')
	{?>OK<? }
	else {?>-----<? }?> </TD>
	<TD nowrap> <? 
	if ($materiels_array[$i]->retour=='yes')
	{?>OK<? }
	else {?>-----<? }?> </TD>
  </TR>

<?
  }
?>

  
</FORM >
</TABLE>

