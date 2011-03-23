<SCRIPT language="Javascript">
<!--
function verify()
{
  var ok=1;
  if (document.form.first_name.value=="")
  {
    alert("Tu dois donner un prénom à l'orga");
    ok=0;
  }
  if (document.form.last_name.value=="")
  {
    alert("Tu dois donner un nom à l'orga");
    ok=0;
  }
  if (document.form.email.value=="")
  {
    alert("Tu dois donner l'e-mail de l'orga");
    ok=0;
  }
  if (document.form.mail_adress.value=="")
  {
    alert("Tu dois donner l'adresse de l'orga");
    ok=0;
  }
  if (document.form.phone_number.value=="")
  {
    alert("Tu dois donner le numéro de téléphone de l'orga");
    ok=0;
  }
  if (document.form.begin_time.value=="")
  {
    alert("Tu dois donner une date de début à l'orga");
    ok=0;
  }
  else if ((document.form.begin_time.value.length!=16) || (document.form.begin_time.value.charAt(2)!="-") || (document.form.begin_time.value.charAt(5)!="-") || (document.form.begin_time.value.charAt(10)!=" ") || (document.form.begin_time.value.charAt(13)!=":"))
  {
    alert("Tu dois une date de début dans le bon format (jj-mm-aaaa hh:mm)");
    ok=0;
  }
  if (document.form.end_time.value=="")
  {
    alert("Tu dois donner une date de fin à l'orga");
    ok=0;
  }
  else if ((document.form.end_time.value.length!=16) || (document.form.end_time.value.charAt(2)!="-") || (document.form.end_time.value.charAt(5)!="-") || (document.form.end_time.value.charAt(10)!=" ") || (document.form.end_time.value.charAt(13)!=":"))
  {
    alert("Tu dois une date de fin dans le bon format (jj-mm-aaaa hh:mm)");
    ok=0;
  }
  if (ok==1)
  {
    document.form.begin_time.value=document.form.begin_time.value+":00";
    document.form.end_time.value=document.form.end_time.value+":00";
    document.form.plages.value="|"+document.form.begin_time.value+":00"+","+document.form.end_time.value+":00"+"|";
    document.form.submit();
  }
}
-->
</SCRIPT>

<TABLE WIDTH="1%" CELLSPACING="0" CELLPADDING="3">
  <FORM method="POST" name="form" action="db_action.php?db_action=insert_orga">
    <TR> 
      <TD colspan="3">&nbsp;</TD>
    </TR>
    <TR CLASS="orgas_top"> 
      <TD colspan="3"> <B>Ajout d'un orga</B> </TD>
    </TR>
    <TR CLASS="orgas"> 
      <TD>&nbsp;&nbsp;&nbsp;</TD>
      <TD nowrap> Pr&eacute;nom&nbsp;:&nbsp; </TD>
      <TD WIDTH="1%"> 
        <INPUT TYPE="text" NAME="first_name" SIZE="20" MAXLENGTH="40">
      </TD>
    </TR>
    <TR CLASS="orgas"> 
      <TD>&nbsp;&nbsp;&nbsp;</TD>
      <TD VALIGN="top" nowrap> Nom&nbsp;:&nbsp; </TD>
      <TD WIDTH="1%"> 
        <INPUT TYPE="text" NAME="last_name" SIZE="20" MAXLENGTH="40">
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
    <TR CLASS="orgas"> 
      <TD>&nbsp;&nbsp;&nbsp;</TD>
      <TD nowrap> Heure de d&eacute;but&nbsp;:&nbsp; <BR>
        (jj-mm-aaaa hh:mm) </TD>
      <TD WIDTH="1%"> 
        <INPUT TYPE="text" NAME="begin_time" VALUE="<? print(date_en_to_fr($global_begin_date)); ?>" SIZE="20" MAXLENGTH="40">
      </TD>
    </TR>
    <TR CLASS="orgas"> 
      <TD>&nbsp;&nbsp;&nbsp;</TD>
      <TD nowrap> Heure de fin&nbsp;:&nbsp; <BR>
        (jj-mm-aaaa hh:mm) </TD>
      <TD WIDTH="1%" nowrap> 
        <INPUT TYPE="text" NAME="end_time" VALUE="<? print(date_en_to_fr($global_end_date)); ?>" SIZE="20" MAXLENGTH="40">
        <A href="javascript:ajout_plage()">+</A> 
        <INPUT TYPE="hidden" NAME="plages" VALUE="" SIZE="20" MAXLENGTH="40">
      </TD>
    </TR>
    <TR CLASS="orgas"> 
      <TD colspan="3">&nbsp;</TD>
    </TR>
    <TR CLASS="orgas"> 
      <TD colspan="3" ALIGN="center"> 
        <INPUT TYPE="button" VALUE="Envoyer" onClick="verify()">
        <INPUT TYPE="reset" VALUE="Effacer">
      </TD>
    </TR>
  </FORM>
</TABLE>
