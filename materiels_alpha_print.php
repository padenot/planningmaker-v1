<?
  session_start();

  $session_db_name = $_SESSION['session_db_name'];
  $session_user_type = $_SESSION['session_user_type'];
  
  include('connect_db.php');
  include('functions.php');
  include('classes.php');

  $req_sql="SELECT materiels.*, l.nom_lieu, lieux_before.nom_lieu as nom_lieu_before
  FROM materiels, lieux as l, lieux as lieux_before
  WHERE materiels.id_lieu=l.id_lieu AND materiels.id_lieu_before=lieux_before.id_lieu ORDER BY materiels.nom_materiel";
  $req = mysql_query($req_sql);

  $req_sql="SELECT * FROM fournisseurs ORDER BY name";
  $req_fournisseurs = mysql_query($req_sql);
?>
<HTML>

<HEAD>

<TITLE>Liste du Matériel</TITLE>
<LINK href="print.css" type="text/css" rel="stylesheet">

</HEAD>


<BODY>

<TABLE WIDTH="1%" CELLSPACING="0" CELLPADDING="3">
  <TR>
    <TD colspan="8">&nbsp;</TD>
  </TR>
  <TR bgcolor="#CCCCCC">
    <TD COLSPAN="2" nowrap> 
      <B>Liste du materiel</B></TD>
    <TD ALIGN="center"> 
      <b>Quantit&eacute;</b> 
    </TD>
	 <TD ALIGN="center">
      <B>Lieu de préstockage</B>
    </TD>
    <TD ALIGN="center"> 
      <B>Lieu de stockage</B> 
    </TD>
    <TD ALIGN="center"> 
      <B>Fournisseur</B> 
    </TD>
  </TR>

<?
  $fournisseurs_array=result_fournisseurs($req_fournisseurs);

  $materiels_array=result_materiels($req);
  
  $bgcolor="#EAEAEA";
  for ($i=0;$i<count($materiels_array);$i++)
  {
  	if ($bgcolor=="#EAEAEA") $bgcolor="#FFFFFF";
	else $bgcolor="#EAEAEA";
    $fournisseur="";
    if ($materiels_array[$i]->id_fournisseur==0) $fournisseur="personne";
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

  <TR bgcolor="<? print($bgcolor); ?>"> 
    <TD width="1%">&nbsp;&nbsp;&nbsp;</TD>
    <TD nowrap> <? print($materiels_array[$i]->nom_materiel); ?> 
    </TD>
    <TD nowrap> 
      <? print($materiels_array[$i]->quantite);?>
    </TD>
	<td nowrap><? print($materiels_array[$i]->nom_lieu_before); ?></td>
    <TD nowrap> <? print($materiels_array[$i]->nom_lieu); ?> </TD>
    <TD nowrap> <? print($fournisseur); ?> </TD>
  </TR>
<? } ?>
  <TR CLASS="taches">
    <TD colspan="8"><HR width="75%"></TD>
  </TR>
<?
  $req_sql="SELECT materiels.*, lieux_before.nom_lieu as nom_lieu_before
  FROM materiels, lieux as lieux_before
  WHERE materiels.id_lieu='0' AND materiels.id_lieu_before=lieux_before.id_lieu ORDER BY materiels.nom_materiel";
  $req = mysql_query($req_sql);

  $materiels_array=result_materiels($req);
  for ($i=0;$i<count($materiels_array);$i++)
  {
    $fournisseur="";
    if ($materiels_array[$i]->id_fournisseur==0) $fournisseur="inconnu";
    else
    {
	if ($bgcolor=="#EAEAEA") $bgcolor="#FFFFFF";
	else $bgcolor="#EAEAEA";
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

  <TR bgcolor="<? print($bgcolor); ?>"> 
    <TD width="1%">&nbsp;&nbsp;&nbsp;</TD>
    <TD nowrap> <? print($materiels_array[$i]->nom_materiel); ?> 
    </TD>
    <TD nowrap> 
      <? print($materiels_array[$i]->quantite);?>
    </TD>
	<td nowrap><? print($materiels_array[$i]->nom_lieu_before); ?></td>
    <TD nowrap>indéfini </TD>
    <TD nowrap> <? print($fournisseur); ?> </TD>
  </TR>

<?
  }
?>
<TR CLASS="taches">
    <TD colspan="8"><HR width="75%"></TD>
  </TR>
<?
  $req_sql="SELECT materiels.*, l.nom_lieu
  FROM materiels, lieux as l
  WHERE materiels.id_lieu=l.id_lieu AND materiels.id_lieu_before='0' ORDER BY materiels.nom_materiel";
  $req = mysql_query($req_sql);

  $materiels_array=result_materiels($req);
  for ($i=0;$i<count($materiels_array);$i++)
  {
    $fournisseur="";
    if ($materiels_array[$i]->id_fournisseur==0) $fournisseur="inconnu";
    else
    {
	if ($bgcolor=="#EAEAEA") $bgcolor="#FFFFFF";
	else $bgcolor="#EAEAEA";
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

  <TR bgcolor="<? print($bgcolor); ?>"> 
    <TD width="1%">&nbsp;&nbsp;&nbsp;</TD>
    <TD nowrap> <? print($materiels_array[$i]->nom_materiel); ?> 
    </TD>
    <TD nowrap> 
      <? print($materiels_array[$i]->quantite);?>
    </TD>
	<td nowrap>ind&eacute;fini</td>
    <TD nowrap><? print($materiels_array[$i]->nom_lieu); ?></TD>
    <TD nowrap> <? print($fournisseur); ?> </TD>
  </TR>

<?
  }
?>
<TR CLASS="taches">
    <TD colspan="8"><HR width="75%"></TD>
  </TR>
<?
  $req_sql="SELECT materiels.* FROM materiels
  WHERE materiels.id_lieu='0' AND materiels.id_lieu_before='0' ORDER BY materiels.nom_materiel";
  $req = mysql_query($req_sql);


  $materiels_array=result_materiels($req);
  for ($i=0;$i<count($materiels_array);$i++)
  {
    $fournisseur="";
    if ($materiels_array[$i]->id_fournisseur==0) $fournisseur="inconnu";
    else
    {
	if ($bgcolor=="#EAEAEA") $bgcolor="#FFFFFF";
	else $bgcolor="#EAEAEA";
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

  <TR bgcolor="<? print($bgcolor); ?>"> 
    <TD width="1%">&nbsp;&nbsp;&nbsp;</TD>
    <TD nowrap> <? print($materiels_array[$i]->nom_materiel); ?> 
    </TD>
    <TD nowrap> 
      <? print($materiels_array[$i]->quantite);?>
    </TD>
	<td nowrap>ind&eacute;fini</td>
    <TD nowrap>ind&eacute;fini</TD>
    <TD nowrap> <? print($fournisseur); ?> </TD>
  </TR>

<?
  }
?>
</TABLE>


</BODY>
</HTML>