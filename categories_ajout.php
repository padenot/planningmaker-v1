<SCRIPT language="Javascript">
<!--
function verify()
{
  var ok=1;
  if (document.form.nom.value=="")
  {
    alert("Tu dois donner un nom de catégorie");
    ok=0;
  }
    if (document.form.type.selected=="")
  {
    alert("Tu dois donner un nom de véhicule");
    ok=0;
  }
  if (document.form.couleur.selected=="")
  {
    alert("Tu dois donner un nom de véhicule");
    ok=0;
  }
  if (ok==1) document.form.submit();
}
-->
</SCRIPT>
<style>
#block{
display:block;
float:left;
width:25px;
height:25px;
border:1px solid black;
}
input {
float:left;
}</style>

<TABLE WIDTH="1%" CELLSPACING="0" CELLPADDING="3">
<FORM method="POST" name="form" action="db_action.php?db_action=insert_categorie">
  <TR>
    <TD colspan="3">&nbsp;</TD>
  </TR>
  <TR CLASS="categories_top">
      <TD colspan="3"> <B>Ajout d'une cat&eacute;gorie</B></TD>
  </TR>
  <TR CLASS="categories">
    <TD>&nbsp;&nbsp;&nbsp;</TD>
    <TD nowrap>
      Nom&nbsp;:&nbsp;
    </TD>
    <TD WIDTH="1%">
      <INPUT TYPE="text" NAME="nom" SIZE="20" MAXLENGTH="40">
    </TD>
  </TR>
  <TR CLASS="categories">
    <TD>&nbsp;&nbsp;&nbsp;</TD>
    <TD nowrap>
      Type&nbsp;:&nbsp;
    </TD>
    <TD WIDTH="1%">
      <INPUT TYPE="radio" NAME="type" value="orga">Orgas<br>
	  	  <INPUT TYPE="radio" NAME="type" value="tache" checked>tâches<br>
	  <INPUT TYPE="radio" NAME="type" value="materiel">
        mat&eacute;riels </TD>
  </TR>
  <TR CLASS="categories">
    <TD>&nbsp;&nbsp;&nbsp;</TD>
    <TD nowrap>
      Couleur&nbsp;:&nbsp;
    </TD>
    <TD WIDTH="1%">
      <div id="block" class="blanc"><INPUT TYPE="radio" NAME="couleur" value="blanc" checked></div>
	  <div id="block" class="orange"><INPUT TYPE="radio" NAME="couleur" value="orange"></div>
	  <div id="block" class="orangeclaire"><INPUT TYPE="radio" NAME="couleur" value="orangeclaire"></div>
	  <div id="block" class="rose"><INPUT TYPE="radio" NAME="couleur" value="rose"></div>
	  <div id="block" class="vert"><INPUT TYPE="radio" NAME="couleur" value="vert"></div>
	  <div id="block" class="bleu"><INPUT TYPE="radio" NAME="couleur" value="bleu"></div>
	  <div id="block" class="bleuclaire"><INPUT TYPE="radio" NAME="couleur" value="bleuclaire"></div>
	  <div id="block" class="violet"><INPUT TYPE="radio" NAME="couleur" value="violet"></div>
	  <div id="block" class="rouge"><INPUT TYPE="radio" NAME="couleur" value="rouge"></div>
    </TD>
  </TR>
  <TR CLASS="categories">
    <TD colspan="3">&nbsp;</TD>
  </TR>
  <TR CLASS="categories">
    <TD colspan="3" ALIGN="center">
      <INPUT TYPE="button" VALUE="Envoyer" onClick="verify()">
      <INPUT TYPE="reset" VALUE="Effacer">
    </TD>
  </TR>
</FORM>
</TABLE>
