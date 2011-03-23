<?
  session_start();

  $session_db_name = $_SESSION['session_db_name'];
  $session_user_type = $_SESSION['session_user_type'];
  
  include('connect_db.php');
  include('functions.php');
  include('classes.php');

  $req_sql="SELECT materiels.* FROM materiels WHERE valeur_materiel>'0' ORDER BY materiels.id_fournisseur";
  $req = mysql_query($req_sql);

  $req_sql="SELECT * FROM fournisseurs ORDER BY name";
  $req_fournisseurs = mysql_query($req_sql);
?>
<HTML>

<HEAD>

<TITLE>Liste du Matériel pour déclaration d'assurance</TITLE>
<LINK href="print.css" type="text/css" rel="stylesheet">

</HEAD>


<BODY>

<TABLE WIDTH="1%" CELLSPACING="0" CELLPADDING="3">
  <TR> 
    <TD colspan="8">&nbsp;</TD>
  </TR>
  <TR bgcolor="#CCCCCC"> 
    <TD COLSPAN="2" nowrap> <B>Liste du materiel</B></TD>
    <TD ALIGN="center"> <b>Quantit&eacute;</b> </TD>
    <TD ALIGN="center"> <B>Valeur unitaire</B></TD>
    <TD ALIGN="center"> <b>Valeur totale</b></TD>
    <TD ALIGN="center"> <B>Fournisseur</B> </TD>
  </TR>
  <?
  $valeur_totale=0;
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
    <TD nowrap> <? print($materiels_array[$i]->nom_materiel); ?> </TD>
    <TD nowrap> <? print($materiels_array[$i]->quantite);?> </TD>
    <td nowrap><? $valeur=$materiels_array[$i]->valeur_materiel/$materiels_array[$i]->quantite;
	print($valeur); ?></td>
    <TD nowrap> <? print($materiels_array[$i]->valeur_materiel);
	$valeur_totale=$valeur_totale+$materiels_array[$i]->valeur_materiel; ?> </TD>
    <TD nowrap> <? print($fournisseur); ?> </TD>
  </TR>
  <? } ?>
  <TR CLASS="taches">
    <TD colspan="8"><HR width="75%"></TD>
  </TR>
 <tr><td></td><td></td><td></td>
 <td align="right">Total déclaré</td>
 <td><? print($valeur_totale); ?></td></tr> 
 
</TABLE>



</BODY>
</HTML>