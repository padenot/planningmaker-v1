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
    alert("Tu dois donner l'e-mail d u fournisseur");
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
<FORM method="POST" name="form" action="db_action.php?db_action=insert_fournisseur">
<TABLE width="1%" border="0" cellspacing="0" cellpadding="0">
  <TR>
    <TD>
      <TABLE WIDTH="1%" CELLSPACING="0" CELLPADDING="3">
          <TR> 
            <TD colspan="3">&nbsp;</TD>
          </TR>
          <TR CLASS="orgas_top"> 
            <TD colspan="3"> 
              <B>Ajout 
              d'un Fournisseur</B> 
            </TD>
          </TR>
          <TR CLASS="orgas"> 
            <TD>&nbsp;&nbsp;&nbsp;</TD>
            <TD nowrap> 
              Fournisseur 
              &nbsp;:&nbsp; 
            </TD>
            <TD WIDTH="1%"> 
              <INPUT TYPE="text" NAME="name" SIZE="20" MAXLENGTH="40"> 
            </TD>
          </TR>
          <TR CLASS="orgas"> 
            <TD>&nbsp;&nbsp;&nbsp;</TD>
            <TD VALIGN="top" nowrap> 
              Contact 
              &nbsp;:&nbsp; 
            </TD>
            <TD WIDTH="1%"> 
              <INPUT TYPE="text" NAME="contact" SIZE="20" MAXLENGTH="40"> 
            </TD>
          </TR>
		  <TR CLASS="orgas"> 
            <TD>&nbsp;&nbsp;&nbsp;</TD>
            <TD VALIGN="top" nowrap> 
              Commentaire 
              &nbsp;:&nbsp; 
            </TD>
            <TD WIDTH="1%"> 
              <textarea NAME="commentaire" cols="18" rows="5" wrap="virtual"> </textarea>
            </TD>
          </TR>
          <TR CLASS="orgas"> 
            <TD>&nbsp;&nbsp;&nbsp;</TD>
            <TD nowrap>E-mail&nbsp;:&nbsp;</TD>
            <TD WIDTH="1%"> 
              <INPUT TYPE="text" NAME="email" SIZE="20" MAXLENGTH="40"> 
            </TD>
          </TR>
          <TR CLASS="orgas"> 
            <TD>&nbsp;&nbsp;&nbsp;</TD>
            <TD nowrap>Adresse&nbsp;:&nbsp;</TD>
            <TD WIDTH="1%"> 
              <INPUT TYPE="text" NAME="mail_adress" SIZE="20" MAXLENGTH="40"> 
            </TD>
          </TR>
          <TR CLASS="orgas"> 
            <TD>&nbsp;&nbsp;&nbsp;</TD>
            <TD nowrap>T&eacute;l&eacute;phone&nbsp;:&nbsp;</TD>
            <TD WIDTH="1%"> 
              <INPUT TYPE="text" NAME="phone_number" SIZE="20" MAXLENGTH="40"> 
            </TD>
          </TR>
          <TR class="orgas"> 
			<TD>&nbsp;&nbsp;&nbsp;</TD>
            <TD nowrap>Fax&nbsp;:&nbsp;</TD>
            <TD WIDTH="1%"> 
              <INPUT TYPE="text" NAME="fax_number" SIZE="20" MAXLENGTH="40"> 
            </TD>
          </TR>
        </TABLE>
    </TD>
  </TR>
  <TR>
    <TD>
      <TABLE WIDTH="100%" CELLSPACING="0" CELLPADDING="3">
          <TR CLASS="orgas"> 
            <TD colspan="3">&nbsp;</TD>
          </TR>
          <TR CLASS="orgas"> 
            <TD colspan="3" ALIGN="center"> 
              <INPUT name="button" TYPE="button" onClick="verify()" VALUE="Envoyer">
              <INPUT name="reset" TYPE="reset" VALUE="Effacer">
            </TD>
          </TR>
		</TABLE>
	</TD>
  </TR>
</TABLE>
</FORM>
