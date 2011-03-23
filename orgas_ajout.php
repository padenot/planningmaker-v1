<SCRIPT language="Javascript">
<!--


function verify()
{
  var ok=1;
  var nb_plages=document.form.nb_plages.value;

  if (document.form.id_categorie.checked=="")
  {
    alert("Tu dois donner une catégorie à l'orga");
    ok=0;
  }
  if (document.form.first_name.value=="")
  {
    alert("Tu dois donner un prénom à l'orga");
    ok=0;
  }
 

  if(document.form.surname.value!="")
  {
    document.form.first_name.value=document.form.first_name.value+" ("+document.form.surname.value+")";	
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
  
  if (document.form.phone_number.value=="")
  {
    alert("Tu dois donner le numéro de téléphone de l'orga");
    ok=0;
  }
  for (i=0;i<nb_plages;i++)
  {
	var current_begin_time=eval("document.form.begin_plage_"+i+".value");
	var current_end_time=eval("document.form.end_plage_"+i+".value");
    if (current_begin_time=="")
    {
      alert("Tu dois donner une date de début à l'orga");
      ok=0;
    }
    else if ((current_begin_time.length!=16) || (current_begin_time.charAt(2)!="-") || (current_begin_time.charAt(5)!="-") || (current_begin_time.charAt(10)!=" ") || (current_begin_time.charAt(13)!=":"))
    {
      alert("Tu dois une date de début dans le bon format (jj-mm-aaaa hh:mm)");
      ok=0;
    }
    if (current_end_time=="")
    {
      alert("Tu dois donner une date de fin à l'orga");
      ok=0;
    }
    else if ((current_end_time.length!=16) || (current_end_time.charAt(2)!="-") || (current_end_time.charAt(5)!="-") || (current_end_time.charAt(10)!=" ") || (current_end_time.charAt(13)!=":"))
    {
      alert("Tu dois une date de fin dans le bon format (jj-mm-aaaa hh:mm)");
      ok=0;
    }
  }
  if (ok==1)
  {
    for (i=0;i<nb_plages;i++)
    {
      var current_begin_time=eval("document.form.begin_plage_"+i+".value");
      var current_end_time=eval("document.form.end_plage_"+i+".value");
      if (i==0) document.form.begin_time.value=current_begin_time;
      if (i==(nb_plages-1)) document.form.end_time.value=current_end_time;
      document.form.submit();
    }
  }
}

function ajout_plage()
{
  document.form.ajout_plage.value="yes";
  verify();
}
function mailinsa()
{
  document.form.email.value=traitemail(document.form.first_name.value)+"."+traitemail(document.form.last_name.value)+"@insa-lyon.fr";
  }
function traitemail(str)
{
str=str.replace(/" "/g,"-");
str=str.replace(/"é"/g,"e");
str=str.replace(/"è"/g,"e");
str=str.replace(/"à"/g,"a");
 return (str);
  }
 
-->
</SCRIPT>
<style>
#block {
float:left;
padding:3px;
}
</style>
<FORM method="POST" name="form" action="db_action.php?db_action=insert_orga">
<TABLE width="1%" border="0" cellspacing="0" cellpadding="0">
  <TR>
    <TD>
      <TABLE WIDTH="1%" CELLSPACING="0" CELLPADDING="3">
          <TR> 
            <TD colspan="3">&nbsp;</TD>
          </TR>
          <TR CLASS="orgas_top"> 
            <TD colspan="3"> <B>Ajout d'un orga</B> </TD>
          </TR>
		  <TR CLASS="orgas"> 
            <TD>&nbsp;&nbsp;&nbsp;</TD>
            <TD nowrap> Catégorie&nbsp;:&nbsp; </TD>
            <TD WIDTH="1%"> 
              <?   $req_sql="SELECT * FROM categories WHERE type_categorie='orga' ORDER BY nom_categorie ";
  					$req = mysql_query($req_sql);
					$categories_array=result_categories($req);
 					for ($i=0;$i<count($categories_array);$i++)
  					{ ?>
					<div id="block" class="<? print($categories_array[$i]->couleur); ?>"><input type="radio" name="id_categorie" value="<? print($categories_array[$i]->id_categorie); ?>"><? print($categories_array[$i]->nom); ?></div>
					<? } ?>
					
            </TD>
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
            <TD nowrap> surnom&nbsp;:&nbsp; </TD>
            <TD WIDTH="1%"> 
              <INPUT TYPE="text" NAME="surname" SIZE="20" MAXLENGTH="40">
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
            <TD nowrap>E-mail INSA&nbsp;:&nbsp;
			<input type="button" value="->" onClick="mailinsa()">
			&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;ou&nbsp;:&nbsp;
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
              (jj-mm-aaaa hh:mm) - plage 1 </TD>
            <TD WIDTH="1%"> 
              <INPUT TYPE="text" NAME="begin_plage_0" VALUE="<? print(date_en_to_fr($global_begin_date)); ?>" SIZE="20" MAXLENGTH="40">
            </TD>
          </TR>
          <TR CLASS="orgas"> 
            <TD>&nbsp;&nbsp;&nbsp;</TD>
            <TD nowrap> Heure de fin&nbsp;:&nbsp; <BR>
              (jj-mm-aaaa hh:mm) - plage 1 </TD>
            <TD WIDTH="1%" nowrap> 
              <INPUT TYPE="text" NAME="end_plage_0" VALUE="<? print(date_en_to_fr($global_end_date)); ?>" SIZE="20" MAXLENGTH="40">
            </TD>
          </TR>
	    <TR class="orgas">
		  <TD colspan="3" nowrap>
		    <A href="javascript:ajout_plage()">Ajouter une plage horaire</A>
            <INPUT TYPE="hidden" NAME="begin_time" VALUE="">
            <INPUT TYPE="hidden" NAME="end_time" VALUE="">
            <INPUT TYPE="hidden" NAME="ajout_plage" VALUE="">
            <INPUT TYPE="hidden" NAME="nb_plages" VALUE="1">
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
              <INPUT TYPE="button"  VALUE="Envoyer" onClick="verify()">
              <INPUT name="reset" TYPE="reset" VALUE="Effacer">
            </TD>
          </TR>
		</TABLE>
	</TD>
  </TR>
</TABLE>
</FORM>
