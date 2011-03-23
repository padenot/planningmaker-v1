<?
  isset($_GET['id_fournisseur']) ? $id_fournisseur = $_GET['id_fournisseur'] : $id_fournisseur = ""; 

  $req_sql="SELECT * FROM fournisseurs WHERE id_fournisseur='".$id_fournisseur."'";
  $req_fournisseurs = mysql_query($req_sql);
?>

<SCRIPT language="Javascript">
<!--
function verify()
{
  var ok=1;
  
  if (document.form.name.value=="")
  {
    alert("Tu dois donner un nom au fournisseur");
    ok=0;
  }
  if (document.form.contact.value=="")
  {
    alert("Tu dois donner un contact du fournisseur");
    ok=0;
  }
  if (document.form.email.value=="")
  {
    alert("Tu dois donner l'e-mail du fournisseur");
    ok=0;
  }
  if (document.form.mail_adress.value=="")
  {
    alert("Tu dois donner l'adresse du fournisseur");
    ok=0;
  }
  if (document.form.phone_number.value=="")
  {
    alert("Tu dois donner le numéro de téléphone du fournisseur");
    ok=0;
  }
  if (ok==1) document.form.submit();
}

-->
</SCRIPT>
<TABLE WIDTH="1%" CELLSPACING="0" CELLPADDING="3">
<form method="POST" name="form" action="db_action.php?db_action=update_fournisseur">
          <TR> 
            <TD colspan="3">&nbsp;</TD>
          </TR>
          <TR CLASS="orgas_top"> 
            <TD colspan="3"> 
              <B>Modification d'un Fournisseur</B> 
            </TD>
          </TR>
<?
  $fournisseurs_array=result_fournisseurs($req_fournisseurs);
  for ($i=0;$i<count($fournisseurs_array);$i++)
  {
?>
		  
          <TR CLASS="orgas"> 
            <TD>&nbsp;&nbsp;&nbsp;</TD>
            <TD nowrap> 
              Fournisseur 
              &nbsp;:&nbsp; 
            </TD>
            <TD WIDTH="1%"> 
              <INPUT TYPE="text" NAME="name" SIZE="20" MAXLENGTH="40" value="<? print($fournisseurs_array[$i]->name); ?>">
			  <INPUT type="hidden" name="id_fournisseur" value="<? print($fournisseurs_array[$i]->id_fournisseur); ?>">
            </TD>
          </TR>
          <TR CLASS="orgas"> 
            <TD>&nbsp;&nbsp;&nbsp;</TD>
            <TD nowrap> 
              Contact 
              &nbsp;:&nbsp; 
            </TD>
            <TD WIDTH="1%"> 
              <INPUT TYPE="text" NAME="contact" SIZE="20" MAXLENGTH="40"value="<? print($fournisseurs_array[$i]->contact); ?>"> 
            </TD>
          </TR>
		  <TR CLASS="orgas"> 
            <TD>&nbsp;&nbsp;&nbsp;</TD>
            <TD nowrap> 
              Commentaire 
              &nbsp;:&nbsp;
            </TD>
            <TD WIDTH="1%"> 
              <textarea name="commentaire" cols="18" rows="5" wrap="virtual"><? print($fournisseurs_array[$i]->commentaire); ?></textarea>
			  
            </TD>
          </TR>
          <TR CLASS="orgas"> 
            <TD>&nbsp;&nbsp;&nbsp;</TD>
            <TD nowrap>E-mail&nbsp;:&nbsp;</TD>
            <TD WIDTH="1%"> 
              <INPUT TYPE="text" NAME="email" SIZE="20" MAXLENGTH="40"value="<? print($fournisseurs_array[$i]->email); ?>"> 
            </TD>
          </TR>
          <TR CLASS="orgas"> 
            <TD>&nbsp;&nbsp;&nbsp;</TD>
            <TD nowrap>Adresse&nbsp;:&nbsp;</TD>
            <TD WIDTH="1%"> 
              <INPUT TYPE="text" NAME="mail_adress" SIZE="20" MAXLENGTH="40"value="<? print($fournisseurs_array[$i]->mail_adress); ?>"> 
            </TD>
          </TR>
          <TR CLASS="orgas"> 
            <TD>&nbsp;&nbsp;&nbsp;</TD>
            <TD nowrap>T&eacute;l&eacute;phone&nbsp;:&nbsp;</TD>
            <TD WIDTH="1%"> 
              <INPUT TYPE="text" NAME="phone_number" SIZE="20" MAXLENGTH="40"value="<? print($fournisseurs_array[$i]->phone_number); ?>"> 
            </TD>
          </TR>
		  <TR CLASS="orgas"> 
            <TD>&nbsp;&nbsp;&nbsp;</TD>
            <TD nowrap>Fax&nbsp;:&nbsp;</TD>
            <TD WIDTH="1%"> 
              <INPUT TYPE="text" NAME="fax_number" SIZE="20" MAXLENGTH="40"value="<? print($fournisseurs_array[$i]->fax_number); ?>"> 
            </TD>
          </TR>
          <TR class="orgas"> 
            <TD colspan="3" nowrap>&nbsp;</TD>
          </TR>
        

		  <?
  }
?>
          <TR CLASS="orgas"> 
            <TD colspan="3" ALIGN="center"> 
              <INPUT name="button" TYPE="button" onClick="verify()" VALUE="Envoyer">
			  <input type="button" value="Effacer" onClick="window.location.reload()">
            </TD>
          </TR>
		  </form>
		</TABLE>

