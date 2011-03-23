<?
isset($_POST['selection']) ? $selection = $_POST['selection'] : $selection = "";
   switch ($selection) {
   case "" :
   $plus="";
   break;
    case 0 :
  $plus="AND materiels.commande='' AND materiels.reception='' AND materiels.retour='' ";
  break;
  case 1 :
  $plus="AND materiels.commande='yes' AND materiels.reception='' AND materiels.retour='' ";
  break;
   case 2 :
  $plus="AND materiels.commande='yes' AND materiels.reception='yes' AND materiels.retour='' ";
  break;
   case 3 :
  $plus="AND materiels.commande='yes' AND materiels.reception='yes' AND materiels.retour='yes' ";
  break;
  }
   $req_sql="SELECT materiels.*, l.nom_lieu, lieux_before.nom_lieu as nom_lieu_before
  FROM materiels, lieux as l, lieux as lieux_before
  WHERE materiels.id_lieu=l.id_lieu AND materiels.id_lieu_before=lieux_before.id_lieu ".$plus."ORDER BY materiels.nom_materiel";
   $req = mysql_query($req_sql);

  $req_sql="SELECT * FROM fournisseurs ORDER BY name";
  $req_fournisseurs = mysql_query($req_sql);
?>

<SCRIPT language="JavaScript">
function verif(id)
{
  if (confirm('Es-tu sûr de vouloir supprimer ce materiel ?'))
  {
    document.form_suppr.id_materiel.value=id;
	document.form_suppr.submit();
  }
}
</SCRIPT>

<TABLE WIDTH="1%" CELLSPACING="0" CELLPADDING="3">
  <TR>
    <TD colspan="8">&nbsp;</TD>
  </TR>
  <TR CLASS="taches_top">
    <TD colspan="2" nowrap> <B><A href="<? print($file."_print.php"); ?>" target="_blank" class="menu"><img src="images/print.jpg"></A></B> 
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><a href="<? print($file."_print_ass.php"); ?>" target="_blank" class="menu">Imprimer déclaration d'assurance</a></b></td><TD colspan="2" nowrap align="left"><form action="main.php?file=materiels&action=alpha" name="sel" method="post">
	  <select name="selection" onChange="submit()">
	  <option value="" <? if ($selection=="")print("selected"); ?>>voir tout</option>
	   <option value="0" <? if ($selection=="0")print("selected"); ?>>non commandé</option>
	  <option value="1" <? if ($selection=="1")print("selected"); ?>>voir commandé non reçu</option>
	  <option value="2" <? if ($selection=="2")print("selected"); ?>>voir commandé reçu</option>
	  <option value="3" <? if ($selection=="3")print("selected"); ?>>voir rendu</option></select></form></td>
	   <td align="right"> Rechercher : 
	  </td><TD colspan="3" nowrap><form action="main.php?file=materiels&action=alpha" name="rech" method="post"><input name="recherche" type="text"><input name="valid" type="submit" value="OK" onClick="valid()"></form>
	  </TD>
  </TR>
  <TR CLASS="taches_top">
    <TD COLSPAN="2" nowrap> 
      <B>Liste du materiel</B></TD>
	  
    <TD ALIGN="center"> 
      <b>Utilisation,&nbsp;Remarque</b> 
    </TD>
    <TD ALIGN="center"> 
      <b>Quantit&eacute;</b> 
    </TD>
	<TD ALIGN="center"> <B>Lieu de pr&eacute;-stockage</B> </TD>
    <TD ALIGN="center"> 
      <B>Lieu de stockage</B> 
    </TD>
    <TD ALIGN="center"> 
      <B>Fournisseur</B> 
    </TD>
    <TD ALIGN="center">
      <B>Supprimer</B>
    </TD>
  </TR>

<?
  $fournisseurs_array=result_fournisseurs($req_fournisseurs);
  $fournisseurs_array2=$fournisseurs_array;
  $fournisseurs_array3=$fournisseurs_array;
  $fournisseurs_array4=$fournisseurs_array;

  $materiels_array=result_materiels($req);
  for ($i=0;$i<count($materiels_array);$i++)
  {
  if (($recherche!="" && strstr($materiels_array[$i]->nom_materiel, $recherche)!=false) || ($recherche=="")){
  
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

  <TR valign="top"  bgcolor="<? 
  if ($materiels_array[$i]->commande=="yes" && $materiels_array[$i]->reception=="yes" && $materiels_array[$i]->retour=="yes")
  print("#66CCFF");
   if ($materiels_array[$i]->commande=="yes" && $materiels_array[$i]->reception=="yes" && $materiels_array[$i]->retour=="")
  print("#66FF66");
  if ($materiels_array[$i]->commande=="yes" && $materiels_array[$i]->reception=="" && $materiels_array[$i]->retour=="")
  print("#FFFF99");
  if ($materiels_array[$i]->commande=="" && $materiels_array[$i]->reception=="" && $materiels_array[$i]->retour=="")
  print("#FF6633"); ?>"> 
    <TD width="1%">&nbsp;&nbsp;&nbsp;</TD>
    <TD nowrap> <A HREF="main.php?file=materiels&action=modify&id_materiel=<? print($materiels_array[$i]->id_materiel); ?>" CLASS="lien"><? print($materiels_array[$i]->nom_materiel); ?></A> 
    </TD>
	<TD> 
      <? print($materiels_array[$i]->utilisation);?>
    </TD>
    <TD nowrap> 
      <? print($materiels_array[$i]->quantite);?>
    </TD>
	<td nowrap><? print($materiels_array[$i]->nom_lieu_before); ?></td>
    <TD nowrap> <? print($materiels_array[$i]->nom_lieu); ?> </TD>
    <TD nowrap> <? print($fournisseur); ?> </TD>
    <TD WIDTH="1%" ALIGN="center"> <A HREF="javascript:verif(<? print($materiels_array[$i]->id_materiel); ?>)" CLASS="lien">Go</A> 
    </TD>
  </TR>
<? }} ?>
  <TR CLASS="taches">
    <TD colspan="8"><HR width="75%"></TD>
  </TR>
<?
  
   $req_sql="SELECT materiels.*, lieux_before.nom_lieu as nom_lieu_before
  FROM materiels, lieux as lieux_before
  WHERE materiels.id_lieu='0' AND materiels.id_lieu_before=lieux_before.id_lieu ".$plus."ORDER BY materiels.nom_materiel";
  $req = mysql_query($req_sql);

  $materiels_array=result_materiels($req);
  for ($i=0;$i<count($materiels_array);$i++)
  {
   if (($recherche!="" && strstr($materiels_array[$i]->nom_materiel, $recherche)!=false) || ($recherche=="")){
    $fournisseur="";
    if ($materiels_array[$i]->id_fournisseur==0) $fournisseur="inconnu";
    else
    {
      for ($j=0;$j<count($fournisseurs_array2);$j++)
      {
        if ($fournisseurs_array2[$j]->id_fournisseur==$materiels_array[$i]->id_fournisseur)
        {
          $fournisseur=$fournisseurs_array2[$j]->name;
          break;
        }
      }
    }
?>

  <TR valign="top"  bgcolor="<? 
  if ($materiels_array[$i]->commande=="yes" && $materiels_array[$i]->reception=="yes" && $materiels_array[$i]->retour=="yes")
  print("#66CCFF");
   if ($materiels_array[$i]->commande=="yes" && $materiels_array[$i]->reception=="yes" && $materiels_array[$i]->retour=="")
  print("#66FF66");
  if ($materiels_array[$i]->commande=="yes" && $materiels_array[$i]->reception=="" && $materiels_array[$i]->retour=="")
  print("#FFFF99");
  if ($materiels_array[$i]->commande=="" && $materiels_array[$i]->reception=="" && $materiels_array[$i]->retour=="")
  print("#FF6633"); ?>"> 
    <TD width="1%">&nbsp;&nbsp;&nbsp;</TD>
    <TD nowrap> <A HREF="main.php?file=materiels&action=modify&id_materiel=<? print($materiels_array[$i]->id_materiel); ?>" CLASS="lien"><? print($materiels_array[$i]->nom_materiel); ?></A> 
    </TD>
	<TD> 
      <? print($materiels_array[$i]->utilisation);?>
    </TD>
    <TD nowrap> 
      <? print($materiels_array[$i]->quantite);?>
    </TD>
	<td nowrap><? print($materiels_array[$i]->nom_lieu_before); ?></td>
    <TD nowrap>indéfini </TD>
    <TD nowrap> <? print($fournisseur); ?> </TD>
    <TD WIDTH="1%" ALIGN="center"> <A HREF="javascript:verif(<? print($materiels_array[$i]->id_materiel); ?>)" CLASS="lien">Go</A> 
    </TD>
  </TR>

<?
  }}
?>

  <TR CLASS="taches">
    <TD colspan="8"><HR width="75%"></TD>
  </TR>
<?
  
  $req_sql="SELECT materiels.*, l.nom_lieu
  FROM materiels, lieux as l
  WHERE materiels.id_lieu=l.id_lieu AND materiels.id_lieu_before='0' ".$plus."ORDER BY materiels.nom_materiel";
  $req = mysql_query($req_sql);

  $materiels_array=result_materiels($req);
  for ($i=0;$i<count($materiels_array);$i++)
  {
   if (($recherche!="" && strstr($materiels_array[$i]->nom_materiel, $recherche)!=false) || ($recherche=="")){
    $fournisseur="";
    if ($materiels_array[$i]->id_fournisseur==0) $fournisseur="inconnu";
    else
    {
      for ($j=0;$j<count($fournisseurs_array3);$j++)
      {
        if ($fournisseurs_array3[$j]->id_fournisseur==$materiels_array[$i]->id_fournisseur)
        {
          $fournisseur=$fournisseurs_array3[$j]->name;
          break;
        }
      }
    }
?>

  <TR valign="top"   bgcolor="<? 
  if ($materiels_array[$i]->commande=="yes" && $materiels_array[$i]->reception=="yes" && $materiels_array[$i]->retour=="yes")
  print("#66CCFF");
   if ($materiels_array[$i]->commande=="yes" && $materiels_array[$i]->reception=="yes" && $materiels_array[$i]->retour=="")
  print("#66FF66");
  if ($materiels_array[$i]->commande=="yes" && $materiels_array[$i]->reception=="" && $materiels_array[$i]->retour=="")
  print("#FFFF99");
  if ($materiels_array[$i]->commande=="" && $materiels_array[$i]->reception=="" && $materiels_array[$i]->retour=="")
  print("#FF6633"); ?>"> 
    <TD width="1%">&nbsp;&nbsp;&nbsp;</TD>
    <TD nowrap> <A HREF="main.php?file=materiels&action=modify&id_materiel=<? print($materiels_array[$i]->id_materiel); ?>" CLASS="lien"><? print($materiels_array[$i]->nom_materiel); ?></A> 
    </TD>
	<TD> 
      <? print($materiels_array[$i]->utilisation);?>
    </TD>
    <TD nowrap> 
      <? print($materiels_array[$i]->quantite);?>
    </TD>
	<td nowrap>ind&eacute;fini</td>
    <TD nowrap> <? print($materiels_array[$i]->nom_lieu); ?></TD>
    <TD nowrap> <? print($fournisseur); ?> </TD>
    <TD WIDTH="1%" ALIGN="center"> <A HREF="javascript:verif(<? print($materiels_array[$i]->id_materiel); ?>)" CLASS="lien">Go</A> 
    </TD>
  </TR>

<?
  }}
?>


  <TR CLASS="taches">
    <TD colspan="8"><HR width="75%"></TD>
  </TR>
<?
  $req_sql="SELECT materiels.* FROM materiels
  WHERE materiels.id_lieu='0' AND materiels.id_lieu_before='0' ".$plus."ORDER BY materiels.nom_materiel";
  $req = mysql_query($req_sql);


  $materiels_array=result_materiels($req);
  for ($i=0;$i<count($materiels_array);$i++)
  {
   if (($recherche!="" && strstr($materiels_array[$i]->nom_materiel, $recherche)!=false) || ($recherche=="")){
    $fournisseur="";
    if ($materiels_array[$i]->id_fournisseur==0) $fournisseur="inconnu";
    else
    {
      for ($j=0;$j<count($fournisseurs_array4);$j++)
      {
        if ($fournisseurs_array4[$j]->id_fournisseur==$materiels_array[$i]->id_fournisseur)
        {
          $fournisseur=$fournisseurs_array4[$j]->name;
          break;
        }
      }
    }
?>

  <TR valign="top"  bgcolor="<? 
  if ($materiels_array[$i]->commande=="yes" && $materiels_array[$i]->reception=="yes" && $materiels_array[$i]->retour=="yes")
  print("#66CCFF");
   if ($materiels_array[$i]->commande=="yes" && $materiels_array[$i]->reception=="yes" && $materiels_array[$i]->retour=="")
  print("#66FF66");
  if ($materiels_array[$i]->commande=="yes" && $materiels_array[$i]->reception=="" && $materiels_array[$i]->retour=="")
  print("#FFFF99");
  if ($materiels_array[$i]->commande=="" && $materiels_array[$i]->reception=="" && $materiels_array[$i]->retour=="")
  print("#FF6633"); ?>"> 
    <TD width="1%">&nbsp;&nbsp;&nbsp;</TD>
    <TD nowrap> <A HREF="main.php?file=materiels&action=modify&id_materiel=<? print($materiels_array[$i]->id_materiel); ?>" CLASS="lien"><? print($materiels_array[$i]->nom_materiel); ?></A> 
    </TD>
	<TD> 
      <? print($materiels_array[$i]->utilisation);?>
    </TD>
    <TD nowrap> 
      <? print($materiels_array[$i]->quantite);?>
    </TD>
	<td nowrap>ind&eacute;fini</td>
    <TD nowrap>indéfini </TD>
    <TD nowrap> <? print($fournisseur); ?> </TD>
    <TD WIDTH="1%" ALIGN="center"> <A HREF="javascript:verif(<? print($materiels_array[$i]->id_materiel); ?>)" CLASS="lien">Go</A> 
    </TD>
  </TR>

<?
  }}
?>


</TABLE>

<FORM name="form_suppr" action="db_action.php?db_action=delete_materiel" method="post">
<INPUT name="id_materiel" type="hidden">
</FORM>
