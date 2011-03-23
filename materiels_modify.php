<?
  isset($_GET['id_materiel']) ? $id_materiel = $_GET['id_materiel'] : $id_materiel = ""; 

  $req_sql="SELECT * FROM materiels WHERE id_materiel='".$id_materiel."'";

  $req_materiels = mysql_query($req_sql);



  $req_sql="SELECT * FROM categories ORDER BY nom_categorie";

  $req_categories = mysql_query($req_sql);



  $req_sql="SELECT * FROM lieux ORDER BY nom_lieu";

  $req_lieux = mysql_query($req_sql);



  $req_sql="SELECT * FROM fournisseurs ORDER BY name";

  $req_fournisseurs = mysql_query($req_sql);

?>



<SCRIPT language="Javascript">

<!--

function verify()

{

  var ok=1;

  

  if (document.form.nom_materiel.value=="")

  {

    alert("Tu dois donner un nom au materiel");

    ok=0;

  }

  if (document.form.valeur_materiel.value=="")

  {

    alert("Tu dois donner une valeur au materiel");

    ok=0;

  }

  if ((document.form.quantite.value=="") || (isNaN(document.form.quantite.value)))

  {

    alert("Tu dois donner une quantité");

    ok=0;

  }

  if (document.form.id_fournisseur[0].selected)

  {

    alert("Tu dois donner un fournisseur au materiel");

    ok=0;

  }

  if (ok==1) document.form.submit();

 }

-->

</SCRIPT>



<TABLE width="1%" cellspacing="0" cellpadding="3">

  <FORM method="POST" name="form" action="db_action.php?db_action=update_materiel">

    <TR> 

      <TD colspan="3">&nbsp;</TD>

    </TR>

    <TR class="taches_top"> 

      <TD colspan="3"> 

        <B>Modification 

        du materiel</B> 

      </TD>

    </TR>

	          

<?

  $materiels_array=result_materiels($req_materiels);

  for ($i=0;$i<count($materiels_array);$i++)

  {

?>

    <TR class="taches"> 

      <TD>&nbsp;&nbsp;&nbsp;</TD>

      <TD nowrap> nom&nbsp;:&nbsp; </TD>

      <TD width="1%"> 

	  <INPUT type="text" name="nom_materiel" value="<? print($materiels_array[$i]->nom_materiel); ?>" size="20" maxlength="40">

	  <INPUT type="hidden" name="id_materiel" value="<? print($materiels_array[$i]->id_materiel); ?>"> 

      </TD>

    </TR>

	<TR class="taches"> 

      <TD>&nbsp;&nbsp;&nbsp;</TD>

      <TD valign="top" nowrap> Utilisation&nbsp;:&nbsp; </TD>

      <TD width="1%"> <TEXTAREA name="utilisation" cols="18" rows="5" wrap="virtual"><? print($materiels_array[$i]->utilisation); ?></TEXTAREA> 

      </TD>

    </TR>

    <TR class="taches"> 

      <TD>&nbsp;&nbsp;&nbsp;</TD>

      <TD valign="top" nowrap> Valeur&nbsp;totale :&nbsp; </TD>

      <TD width="1%"> <INPUT type="text" name="valeur_materiel" size="20" maxlength="40"value="<? print($materiels_array[$i]->valeur_materiel); ?>"> 

      </TD>

    </TR>

    <TR class="taches"> 

      <TD>&nbsp;&nbsp;&nbsp;</TD>

      <TD nowrap> Cat&eacute;gorie&nbsp;:&nbsp; </TD>

      <TD width="1%"> <SELECT name="id_categorie">

          <OPTION value="0"></OPTION>

          <?

    $categories_array=result_categories($req_categories);

    for ($j=0;$j<count($categories_array);$j++)

    {

      $is_selected="";

      if ($categories_array[$j]->id_categorie==$materiels_array[$i]->id_categorie) $is_selected="selected";

?>

          <OPTION <? print($is_selected); ?> value="<? print($categories_array[$j]->id_categorie); ?>"> 

          <? print($categories_array[$j]->nom); ?> </OPTION>

          <?

    }

?>

        </SELECT> </TD>

    </TR>

    <TR class="taches"> 

      <TD>&nbsp;</TD>

      <TD nowrap>Quantit&eacute;&nbsp;:&nbsp;</TD>

      <TD width="1%"> <INPUT type="text" name="quantite" size="20" maxlength="40" value="<? print($materiels_array[$i]->quantite); ?>"> 

      </TD>

    </TR><TR class="taches"> 

      <TD>&nbsp;&nbsp;&nbsp;</TD>

      <TD nowrap> Lieu de pré-stockage&nbsp;:&nbsp; </TD>

      <TD width="1%"> <SELECT name="id_lieu_before">

          <OPTION value="0"></OPTION>

          <?

    $lieux_array=result_lieux($req_lieux);
	$lieux_array_before=$lieux_array;

    for ($j=0;$j<count($lieux_array);$j++)

    {

      $is_selected="";

      if ($lieux_array[$j]->id_lieu==$materiels_array[$i]->id_lieu_before) $is_selected="selected";

?>

          <OPTION <? print($is_selected); ?> value="<? print($lieux_array[$j]->id_lieu); ?>"> 

          <? print($lieux_array[$j]->nom); ?> </OPTION>

          <?

    }

?>

        </SELECT> </TD>



    </TR>

    <TR class="taches"> 

      <TD>&nbsp;&nbsp;&nbsp;</TD>

      <TD nowrap> Lieu de stockage&nbsp;:&nbsp; </TD>

      <TD width="1%"> <SELECT name="id_lieu">

          <OPTION value="0"></OPTION>

          <?

   

    for ($j=0;$j<count($lieux_array_before);$j++)

    {

      $is_selected="";

      if ($lieux_array_before[$j]->id_lieu==$materiels_array[$i]->id_lieu) $is_selected="selected";

?>

          <OPTION <? print($is_selected); ?> value="<? print($lieux_array_before[$j]->id_lieu); ?>"> 

          <? print($lieux_array_before[$j]->nom); ?> </OPTION>

          <?

    }

?>

        </SELECT> </TD>



    </TR>

    <TR class="taches"> 

      <TD>&nbsp;&nbsp;&nbsp;</TD>

      <TD nowrap> Fournisseur&nbsp;:&nbsp; </TD>

      <TD width="1%"> <SELECT name="id_fournisseur">

          <OPTION value="0"></OPTION>

          <?

  $fournisseurs_array=result_fournisseurs($req_fournisseurs);

  for ($j=0;$j<count($fournisseurs_array);$j++)

  {

  	  $is_selected="";

	  if($fournisseurs_array[$j]->id_fournisseur==$materiels_array[$i]->id_fournisseur) $is_selected="selected";

?>

          <OPTION <? print($is_selected); ?> value="<? print($fournisseurs_array[$j]->id_fournisseur); ?>"> 

		  <? print($fournisseurs_array[$j]->name); ?> </OPTION>

          <?

  }

    $commande_checked="";

	if ($materiels_array[$i]->commande=="yes") $commande_checked="checked";

	$reception_checked="";

	if ($materiels_array[$i]->reception=="yes") $reception_checked="checked";

	$retour_checked="";

	if ($materiels_array[$i]->retour=="yes") $retour_checked="checked";

  

?>

        </SELECT> </TD>

    </TR>

    

    <TR class="taches"> 

      <TD>&nbsp;</TD>

      <TD colspan="2" nowrap>materiel command&eacute;

<INPUT type="checkbox" name="commande" <? print($commande_checked) ?> value="yes"></TD>

    </TR>

	<TR class="taches"> 

      <TD>&nbsp;</TD>

      <TD colspan="2" nowrap>materiel re&ccedil;u 

        <INPUT type="checkbox" name="reception" <? print($reception_checked) ?> value="yes"></TD>

    </TR>

	<TR class="taches"> 

      <TD>&nbsp;</TD>

      <TD colspan="2" nowrap>materiel rendu 

        <INPUT type="checkbox" name="retour" <? print($retour_checked) ?> value="yes"></TD>

    </TR>

    <TR class="taches"> 

      <TD colspan="3">&nbsp;</TD>

    </TR>

		  <?

  }

?>

    <TR class="taches"> 

      <TD colspan="3" align="center"> <INPUT type="button" value="Envoyer" onClick="verify()"> 

        <input type="button" value="Effacer" onClick="window.location.reload()"> </TD>

    </TR>

  </FORM>

</TABLE>

