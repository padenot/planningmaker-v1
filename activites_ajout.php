<?
  $req_sql="SELECT * FROM vehicules ORDER BY nom_vehicule";
  $req_vehicules = mysql_query($req_sql);

  $req_sql="SELECT * FROM lieux ORDER BY nom_lieu";
  $req_lieux = mysql_query($req_sql);
?>

<SCRIPT language="Javascript">
<!--
function verify()
{
  var ok=1;
  if (document.form.titre.value=="")
  {
    alert("Tu dois donner un titre à l'activité");
    ok=0;
  }
  if (document.form.consigne.value=="")
  {
    alert("Tu dois donner des consignes à l'activité");
    ok=0;
  }
  if (document.form.begin_time.value=="")
  {
    alert("Tu dois donner une date de début à l'activité");
    ok=0;
  }
  else if ((document.form.begin_time.value.length!=16) || (document.form.begin_time.value.charAt(2)!="-") || (document.form.begin_time.value.charAt(5)!="-") || (document.form.begin_time.value.charAt(10)!=" ") || (document.form.begin_time.value.charAt(13)!=":"))
  {
    alert("Tu dois une date de début dans le bon format (jj-mm-aaaa hh:mm)");
    ok=0;
  }
  if (document.form.end_time.value=="")
  {
    alert("Tu dois donner une date de fin à l'activité");
    ok=0;
  }
  else if ((document.form.end_time.value.length!=16) || (document.form.end_time.value.charAt(2)!="-") || (document.form.end_time.value.charAt(5)!="-") || (document.form.end_time.value.charAt(10)!=" ") || (document.form.end_time.value.charAt(13)!=":"))
  {
    alert("Tu dois une date de fin dans le bon format (jj-mm-aaaa hh:mm)");
    ok=0;
  }
  if (document.form.duree.value=="")
  {
    alert("Tu dois donner une durée à l'activité");
    ok=0;
  }
  else if ((document.form.duree.value.length!=5) || (document.form.duree.value.charAt(2)!=":"))
  {
    alert("Tu dois une durée dans le bon format (hh:mm)");
    ok=0;
  }
  if (document.form.id_lieu[0].selected)
  {
    alert("Tu dois donner un lieu à l'activité");
    ok=0;
  }
  if (ok==1)
  {
    document.form.begin_time.value=document.form.begin_time.value+":00";
    document.form.end_time.value=document.form.end_time.value+":00";
    document.form.duree.value=document.form.duree.value+":00";
    document.form.submit();
  }
}
-->
</SCRIPT>

<TABLE WIDTH="1%" CELLSPACING="0" CELLPADDING="3">
<FORM method="POST" name="form" action="db_action.php?db_action=insert_activite">
  <TR>
    <TD colspan="3">&nbsp;</TD>
  </TR>
  <TR CLASS="activites_top">
    <TD colspan="3">
      <B>Ajout d'une activit&eacute;</B>
    </TD>
  </TR>
  <TR CLASS="activites">
    <TD>&nbsp;&nbsp;&nbsp;</TD>
    <TD nowrap>
      Titre&nbsp;:&nbsp;
    </TD>
    <TD WIDTH="1%">
      <INPUT TYPE="text" NAME="titre" SIZE="20" MAXLENGTH="40">
    </TD>
  </TR>
  <TR CLASS="activites">
    <TD>&nbsp;&nbsp;&nbsp;</TD>
    <TD VALIGN="top" nowrap>
      Consignes&nbsp;:&nbsp;
    </TD>
    <TD WIDTH="1%">
      <TEXTAREA NAME="consigne" COLS="22" ROWS="4" WRAP="virtual"></TEXTAREA>
    </TD>
  </TR>
  <TR CLASS="activites">
    <TD>&nbsp;&nbsp;&nbsp;</TD>
    <TD nowrap>
      Heure de d&eacute;but&nbsp;:&nbsp;
      <BR>(jj-mm-aaaa hh:mm)
    </TD>
    <TD WIDTH="1%">
      <INPUT TYPE="text" NAME="begin_time" VALUE="<? print(date_en_to_fr($global_begin_date)); ?>" SIZE="20" MAXLENGTH="40">
    </TD>
  </TR>
  <TR CLASS="activites">
    <TD>&nbsp;&nbsp;&nbsp;</TD>
    <TD nowrap>
      Heure de fin&nbsp;:&nbsp;
      <BR>(jj-mm-aaaa hh:mm)
    </TD>
    <TD WIDTH="1%">
      <INPUT TYPE="text" NAME="end_time" VALUE="<? print(date_en_to_fr($global_end_date)); ?>" SIZE="20" MAXLENGTH="40">
    </TD>
  </TR>
  <TR CLASS="activites">
    <TD>&nbsp;&nbsp;&nbsp;</TD>
    <TD nowrap>
      Dur&eacute;e&nbsp;:&nbsp;
      <BR>(hh:mm)
    </TD>
    <TD WIDTH="1%">
      <INPUT TYPE="text" NAME="duree" SIZE="20" MAXLENGTH="40">
    </TD>
  </TR>
  <TR CLASS="activites">
    <TD>&nbsp;&nbsp;&nbsp;</TD>
    <TD nowrap>
      V&eacute;hicule&nbsp;:&nbsp;
    </TD>
    <TD WIDTH="1%">
      <SELECT NAME="id_vehicule">
        <OPTION VALUE="0"></OPTION>

<?
  $vehicules_array=result_vehicules($req_vehicules);
  for ($i=0;$i<count($vehicules_array);$i++)
  {
?>

        <OPTION VALUE="<? print($vehicules_array[$i]->id_vehicule); ?>"><? print($vehicules_array[$i]->nom); ?></OPTION>

<?
  }
?>

      </SELECT>
    </TD>
  </TR>
  <TR CLASS="activites">
    <TD>&nbsp;&nbsp;&nbsp;</TD>
    <TD nowrap>
      Lieu&nbsp;:&nbsp;
    </TD>
    <TD WIDTH="1%">
      <SELECT NAME="id_lieu">
        <OPTION VALUE="0"></OPTION>

<?
  $lieux_array=result_lieux($req_lieux);
  for ($i=0;$i<count($lieux_array);$i++)
  {
?>

        <OPTION VALUE="<? print($lieux_array[$i]->id_lieu); ?>"><? print($lieux_array[$i]->nom); ?></OPTION>

<?
  }
?>

      </SELECT>
    </TD>
  </TR>
  <TR CLASS="activites">
    <TD colspan="3">&nbsp;</TD>
  </TR>
  <TR CLASS="activites">
    <TD colspan="3" ALIGN="center">
      <INPUT TYPE="button" VALUE="Envoyer" onClick="verify()">
      <INPUT TYPE="reset" VALUE="Effacer">
    </TD>
  </TR>
</FORM>
</TABLE>
