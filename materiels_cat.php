<?
  isset($_POST['id_categorie']) ? $id_categorie = $_POST['id_categorie'] : $id_categorie = "";
if ($id_categorie=="")
  {
    $req_sql="SELECT MIN(id_categorie) FROM categories";
    $req = mysql_query($req_sql);
    while ($data = mysql_fetch_array($req))
    {
      $id_categorie=$data['MIN(id_categorie)'];
    }
  }


  $req_sql="SELECT materiels.* FROM materiels WHERE materiels.id_categorie='".$id_categorie."' ORDER BY materiels.nom_materiel";
  $req_materiels = mysql_query($req_sql);

  $req_sql="SELECT * FROM fournisseurs ORDER BY name";
  $req_fournisseurs = mysql_query($req_sql);
  
  $req_sql="SELECT * FROM categories ORDER BY nom_categorie";
  $req_categories = mysql_query($req_sql);
?>

<TABLE WIDTH="1%" CELLSPACING="0" CELLPADDING="3">
  <FORM method="POST" name="form" action="main.php?file=materiels&action=cat" >
  <TR>
    <TD colspan="6">&nbsp;</TD>
  </TR>
  <TR CLASS="taches_top">
    <TD colspan="6" nowrap>
      <B>Choisis une cat&eacute;gorie</B>&nbsp;&nbsp;&nbsp;
      <SELECT NAME="id_categorie" onChange="document.form.submit()">

<?
  $categories_array=result_categories($req_categories);
  for ($i=0;$i<count($categories_array);$i++)
  {
    $is_selected="";
    if ($categories_array[$i]->id_categorie==$id_categorie) $is_selected="selected";
?>

        <OPTION <? print($is_selected); ?> VALUE="<? print($categories_array[$i]->id_categorie); ?>"><? print($categories_array[$i]->nom); ?></OPTION>

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
        <B>Liste du materiel</B></TD>
    <TD ALIGN="center"> 
      <b>Quantit&eacute;</b> 
    </TD>
    <TD ALIGN="center"> 
      <B>Fournisseur</B> 
    </TD>
  </TR>

<?
  $fournisseurs_array=result_fournisseurs($req_fournisseurs);

  $materiels_array=result_materiels($req_materiels);
  for ($i=0;$i<count($materiels_array);$i++)
  {
    $fournisseur="";
    if ($materiels_array[$i]->id_fournisseur==0) $fournisseur="inconnu";
    else
    {
      for ($j=0;$j<count($fournisseurs_array);$j++)
      {
        if ($fournisseurs_array[$j]->id_fournisseur==$materiels_array[$i]->id_fournisseur)
        {
          $fournisseur=$fournisseurs_array[$j]->name;
          break;
        }
      }
    }
?>

  <TR valign="top" CLASS="taches" onMouseOver="this.className='over'" onMouseOut="this.className='materiels'"> 
    <TD width="1%">&nbsp;&nbsp;&nbsp;</TD>
    <TD nowrap> <? print($materiels_array[$i]->nom_materiel); ?> 
    </TD>
    <TD nowrap> 
      <? print($materiels_array[$i]->quantite);?>
    </TD>
    <TD nowrap> <? print($fournisseur); ?> </TD>
  </TR>

<?
  }
?>
  
</FORM >
</TABLE>

