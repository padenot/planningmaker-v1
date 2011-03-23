<?

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
  if (document.form.total_ok.value=="no")
  {
  document.form.valeur_materiel.value=document.form.valeur_materiel.value*document.form.quantite.value;}

  if (ok==1) document.form.submit();

 }

-->

</SCRIPT>



<TABLE width="1%" cellspacing="0" cellpadding="3">

  <FORM method="POST" name="form" action="db_action.php?db_action=insert_materiel">

    <TR> 

      <TD colspan="3">&nbsp;</TD>

    </TR>

    <TR class="taches_top"> 

      <TD colspan="3"> 

        <B>Ajout du materiel</B> 

      </TD>

    </TR>

    <TR class="taches"> 

      <TD>&nbsp;&nbsp;&nbsp;</TD>

      <TD nowrap> nom&nbsp;:&nbsp; </TD>

      <TD width="1%"> <INPUT type="text" name="nom_materiel" size="20" maxlength="40"> 

      </TD>

    </TR>

	<TR class="taches"> 

      <TD>&nbsp;&nbsp;&nbsp;</TD>

      <TD valign="top" nowrap> Utilisation&nbsp;:&nbsp; </TD>

      <TD width="1%"> <TEXTAREA name="utilisation" cols="18" rows="5" wrap="virtual"></TEXTAREA> 

      </TD>

    </TR>

    <TR class="taches"> 

      <TD>&nbsp;&nbsp;&nbsp;</TD>

      <TD valign="top" nowrap> Valeur&nbsp;:&nbsp; 
	  <select name="total_ok">
	  <option value="yes" selected>totale</option>
	  <option value="no">unitaire</option>
	  </select>
	  
	  
	  
	  </TD>

      <TD width="1%"> <INPUT type="text" name="valeur_materiel" size="6" maxlength="40">
        <small>(0 = matos 
        non d&eacute;clar&eacute;) </small>
      </TD>

    </TR>

    <TR class="taches"> 

      <TD>&nbsp;&nbsp;&nbsp;</TD>

      <TD nowrap> Cat&eacute;gorie&nbsp;:&nbsp; </TD>

      <TD width="1%"> <SELECT name="id_categorie">

          <OPTION value="0"></OPTION>

          <?

  $categories_array=result_categories($req_categories);

  for ($i=0;$i<count($categories_array);$i++)

  {

?>

          <OPTION value="<? print($categories_array[$i]->id_categorie); ?>"> <? print($categories_array[$i]->nom); ?> 

          </OPTION>

          <?

  }

?>

        </SELECT> </TD>

    </TR>

    <TR class="taches"> 

      <TD>&nbsp;</TD>

      <TD nowrap>Quantit&eacute;&nbsp;:&nbsp;</TD>

      <TD width="1%"> <INPUT type="text" name="quantite" value="" size="20" maxlength="40"> 

      </TD>

    </TR>

<TR class="taches"> 

      <TD>&nbsp;&nbsp;&nbsp;</TD>

      <TD nowrap> Lieu de pré-stockage&nbsp;:&nbsp; </TD>

      <TD width="1%"> <SELECT name="id_lieu_before">

          <OPTION value="0"></OPTION>

          <?

  $lieux_array=result_lieux($req_lieux);
  $lieux_array_before=$lieux_array;
  for ($i=0;$i<count($lieux_array);$i++)

  {

?>

          <OPTION value="<? print($lieux_array[$i]->id_lieu); ?>"> <? print($lieux_array[$i]->nom); ?> 

          </OPTION>

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

 

  for ($i=0;$i<count($lieux_array_before);$i++)

  {

?>

          <OPTION value="<? print($lieux_array_before[$i]->id_lieu); ?>"> <? print($lieux_array_before[$i]->nom); ?> 

          </OPTION>

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

  for ($i=0;$i<count($fournisseurs_array);$i++)

  {

?>

          <OPTION value="<? print($fournisseurs_array[$i]->id_fournisseur); ?>"> <? print($fournisseurs_array[$i]->name); ?> 

          </OPTION>

          <?

  }

?>

        </SELECT> </TD>

    </TR>

    

    <TR class="taches"> 

      <TD>&nbsp;</TD>

      <TD colspan="2" nowrap>materiel command&eacute;

<INPUT type="checkbox" name="commande" value="yes"></TD>

    </TR>

	<TR class="taches"> 

      <TD>&nbsp;</TD>

      <TD colspan="2" nowrap>materiel re&ccedil;u 

        <INPUT type="checkbox" name="reception" value="yes"></TD>

    </TR>

	<TR class="taches"> 

      <TD>&nbsp;</TD>

      <TD colspan="2" nowrap>materiel rendu 

        <INPUT type="checkbox" name="retour" value="yes"></TD>

    </TR>

    <TR class="taches"> 

      <TD colspan="3">&nbsp;</TD>

    </TR>

    <TR class="taches"> 

      <TD colspan="3" align="center"> <INPUT type="button" value="Envoyer" onClick="verify()"> 

        <INPUT type="reset" value="Effacer"> </TD>

    </TR>

  </FORM>

</TABLE>

