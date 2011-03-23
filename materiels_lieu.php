<?
  isset($_POST['id_lieu']) ? $id_lieu = $_POST['id_lieu'] : $id_lieu = "";
if ($id_lieu=="")
  {
    $req_sql="SELECT MIN(id_lieu) FROM lieux";
    $req = mysql_query($req_sql);
    while ($data = mysql_fetch_array($req))
    {
      $id_lieu=$data['MIN(id_lieu)'];
    }
  }


  $req_sql="SELECT materiels.*, lieux.nom_lieu FROM materiels, lieux WHERE materiels.id_lieu='".$id_lieu."' AND materiels.id_lieu=lieux.id_lieu ORDER BY materiels.id_categorie";
  $req_materiels = mysql_query($req_sql);

  $req_sql="SELECT * FROM fournisseurs ORDER BY name";
  $req_fournisseurs = mysql_query($req_sql);
  
  $req_sql="SELECT * FROM categories ORDER BY nom_categorie";
  $req_categories = mysql_query($req_sql);
  
  $req_sql="SELECT * FROM lieux ORDER BY nom_lieu";
  $req_lieux = mysql_query($req_sql);
?>

<TABLE WIDTH="1%" CELLSPACING="0" CELLPADDING="3">
  <FORM method="POST" name="form" action="main.php?file=materiels&action=lieu" >
  <TR>
    <TD colspan="6">&nbsp;</TD>
  </TR>
  <TR CLASS="taches_top">
    <TD colspan="6" nowrap>
      <B>Choisis un lieu de stockage</B>&nbsp;&nbsp;&nbsp;
      <SELECT NAME="id_lieu" onChange="document.form.submit()">

<?
  $lieux_array=result_lieux($req_lieux);
  for ($i=0;$i<count($lieux_array);$i++)
  {
    $is_selected="";
    if ($lieux_array[$i]->id_lieu==$id_lieu) $is_selected="selected";
?>

        <OPTION <? print($is_selected); ?> VALUE="<? print($lieux_array[$i]->id_lieu); ?>"><? print($lieux_array[$i]->nom); ?></OPTION>

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
      <B>Categorie</B> 
    </TD>
    <TD ALIGN="center"> 
      <B>Fournisseur</B> 
    </TD>
  </TR>

<?
  $fournisseurs_array=result_fournisseurs($req_fournisseurs);
  $materiels_array=result_materiels($req_materiels);
  $categories_array=result_categories($req_categories);
  
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
	  for ($j=0;$j<count($categories_array);$j++)
      {
        if ($categories_array[$j]->id_categorie==$materiels_array[$i]->id_categorie)
        {
          $categorie=$categories_array[$j]->nom;
          break;
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
    <TD nowrap> <? print($categorie); ?> </TD>
    <TD nowrap> <? print($fournisseur); ?> </TD>
  </TR>

<?
  }
?>

</FORM >
</TABLE>

