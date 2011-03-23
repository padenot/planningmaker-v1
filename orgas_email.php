<?
  $req_sql="SELECT * FROM orgas ORDER BY first_name, last_name";
  $req = mysql_query($req_sql);
?>

<SCRIPT language="JavaScript">
function verif()
{
  var ok=1;
  if (document.form_mail.from_name.value=="")
  {
    alert("Tu dois donner l'expéditeur");
    ok=0;
  }
  if (document.form_mail.from_email.value=="")
  {
    alert("Tu dois donner l'e-mail de l'expéditeur");
    ok=0;
  }
  if (document.form_mail.sujet.value=="")
  {
    alert("Tu dois donner un sujet");
    ok=0;
  }
  if (document.form_mail.texte.value=="")
  {
    alert("Tu dois donner un texte");
    ok=0;
  }
  if (ok==1) document.form_mail.submit();
}
</SCRIPT>

<FORM name="form_mail" action="db_action.php?db_action=mail_orga" method="post">
  <TABLE WIDTH="1%" CELLSPACING="0" CELLPADDING="3">
    <TR> 
      <TD colspan="3">&nbsp;</TD>
    </TR>
    <TR CLASS="orgas_top"> 
      <TD colspan="3"> <B><A href="main.php?file=orgas&action=alpha" class="menu">Retour 
        à la liste des orgas</A></B> </TD>
    </TR>
    <TR CLASS="orgas_top"> 
      <TD COLSPAN="3" nowrap> <B>Envoi d'email aux orgas</B></TD>
    </TR>
    <?
  $orgas_array=result_orgas($req);
  $list_mail="";
  for ($i=0;$i<count($orgas_array);$i++)
  {
    if (ereg("^.+@.+\\..+$", $orgas_array[$i]->email))
	{
	  if ($list_mail=="") $list_mail=$orgas_array[$i]->email;
	  else $list_mail=$list_mail.",".$orgas_array[$i]->email;
	}
  }
?>
    <TR CLASS="orgas"> 
      <TD>&nbsp;</TD>
      <TD nowrap>Exp&eacute;diteur : </TD>
      <TD>
        <INPUT type="text" name="from_name" size="30">
        <INPUT type="hidden" name="from_email" value="<? print($session_email); ?>">
      </TD>
    </TR>
    <TR CLASS="orgas"> 
      <TD>&nbsp;</TD>
      <TD colspan="2" align="center" nowrap>
        <HR width="60%" noshade>
      </TD>
    </TR>
    <TR CLASS="orgas"> 
      <TD width="1%">&nbsp;&nbsp;&nbsp;</TD>
      <TD nowrap> Sujet : </TD>
      <TD> 
        <INPUT type="text" name="sujet" size="30">
      </TD>
    </TR>
    <TR CLASS="orgas"> 
      <TD width="1%">&nbsp;&nbsp;&nbsp;</TD>
      <TD valign="top" nowrap> Texte : </TD>
      <TD> 
        <TEXTAREA name="texte" cols="28" rows="10" wrap="virtual"></TEXTAREA>
      </TD>
    </TR>
    <TR CLASS="orgas"> 
      <TD align="center" colspan="3"> 
        <INPUT name="envoi" type="button" value="Envoyer" onClick="verif()">
        <INPUT name="annule" type="button" value="Annuler">
        <INPUT name="list_mail" type="hidden" value="<? print($list_mail); ?>">
      </TD>
    </TR>
  </TABLE>


</FORM>
