<?
  session_start();
  
  $session_db_name = $_SESSION['session_db_name'];

  include('connect_db.php');
  include('functions.php');
  include('classes.php');
  
//*  if ($session_db_name=="planning_users")
//*  {
?>

<HTML>

<HEAD>

<TITLE>Planningmaker(c)</TITLE>
<LINK href="main.css" type="text/css" rel="stylesheet">

<SCRIPT language="JavaScript">
function verify()
{
  var ok=1;
  if (document.form_base.db_name.value=="")
  {
    alert("Tu dois donner un nom à la base");
    ok=0;
  }
  if (document.form_base.global_begin_time.value=="")
  {
    alert("Tu dois donner une date de début des plannings");
    ok=0;
  }
  else if ((document.form_base.global_begin_time.value.length!=16) || (document.form_base.global_begin_time.value.charAt(2)!="-") || (document.form_base.global_begin_time.value.charAt(5)!="-") || (document.form_base.global_begin_time.value.charAt(10)!=" ") || (document.form_base.global_begin_time.value.charAt(13)!=":"))
  {
    alert("Tu dois une date de début dans le bon format (jj-mm-aaaa hh:mm)");
    ok=0;
  }
  if (document.form_base.global_end_time.value=="")
  {
    alert("Tu dois donner une date de fin des plannings");
    ok=0;
  }
  else if ((document.form_base.global_end_time.value.length!=16) || (document.form_base.global_end_time.value.charAt(2)!="-") || (document.form_base.global_end_time.value.charAt(5)!="-") || (document.form_base.global_end_time.value.charAt(10)!=" ") || (document.form_base.global_end_time.value.charAt(13)!=":"))
  {
    alert("Tu dois une date de fin dans le bon format (jj-mm-aaaa hh:mm)");
    ok=0;
  }
  if (document.form_base.login.value=="")
  {
    alert("Tu dois donner un login");
    ok=0;
  }
  if (document.form_base.password.value=="")
  {
    alert("Tu dois donner un password");
    ok=0;
  }
  if (document.form_base.password2.value=="")
  {
    alert("Tu dois confirmer le password");
    ok=0;
  }
  else if (document.form_base.password.value!=document.form_base.password2.value)
  {
    alert("Tu dois donner le même password");
    ok=0;
  }
  p=new RegExp("^.+@.+\\..+$");
  if ((document.form_base.email.value=="") || (document.form_base.email.value.search(p)==-1))
  {
    alert("Tu dois donner un e-mail valide à l'utilisateur");
    ok=0;
  }
  if (ok==1)
  {
    document.form_base.db_name.value="planning_"+document.form_base.db_name.value;
    document.form_base.global_begin_time.value=document.form_base.global_begin_time.value+":00";
    document.form_base.global_end_time.value=document.form_base.global_end_time.value+":00";
    document.form_base.submit();
  }
}
</SCRIPT>
</HEAD>


<BODY>
<CENTER><H1>-- Module Administrateur --</H1>
  <TABLE width="1%">
    <TR>
      <TD valign="top" nowrap bgcolor="#D0DCE0"> 
        <P><B>Ajout d'une base :</B><BR>
          remplis le fomulaire</P>
        <P><A href="admin.php">Retour</A></P>
        <P><A href="logout.php">Logout</A></P>
      </TD>
      <TD align="center" valign="top" nowrap bgcolor="#F5F5F5">
        <P><B>Nouvelle base de gestion des plannings</B></P>
       <FORM name="form_base" method="post" action="db_action.php?db_action=insert_db">
          <TABLE width="100%" border="0" cellspacing="0" cellpadding="3">
            <TR> 
              <TD colspan="2" nowrap bgcolor="#D0DCE0">Nom de la base : </TD>
              <TD bgcolor="#F5F5F5"> 
                <INPUT type="text" name="db_name" size="20">
              </TD>
            </TR>
            <TR> 
              <TD colspan="2" nowrap bgcolor="#D0DCE0">Date de d&eacute;but des 
                plannings :<BR>
                (jj-mm-aaaa hh:mm) </TD>
              <TD valign="top" bgcolor="#F5F5F5"> 
                <INPUT type="text" name="global_begin_time" size="20">
              </TD>
            </TR>
            <TR> 
              <TD colspan="2" nowrap bgcolor="#D0DCE0">Date de fin des plannings 
                :<BR>
                (jj-mm-aaaa hh:mm) </TD>
              <TD valign="top" bgcolor="#F5F5F5"> 
                <INPUT name="global_end_time" type="text" size="20">
              </TD>
            </TR>
            <TR> 
              <TD colspan="2" nowrap bgcolor="#D0DCE0">Utilisateur :</TD>
              <TD bgcolor="#F5F5F5">&nbsp;</TD>
            </TR>
            <TR> 
              <TD width="1%" nowrap bgcolor="#D0DCE0">&nbsp;&nbsp;&nbsp;</TD>
              <TD width="1%" nowrap bgcolor="#D0DCE0">login :</TD>
              <TD bgcolor="#F5F5F5"> 
                <INPUT type="text" name="login" size="20">
              </TD>
            </TR>
            <TR> 
              <TD width="1%" nowrap bgcolor="#D0DCE0">&nbsp;&nbsp;&nbsp;</TD>
              <TD width="1%" nowrap bgcolor="#D0DCE0">password :</TD>
              <TD bgcolor="#F5F5F5"> 
                <INPUT type="password" name="password" size="20">
              </TD>
            </TR>
            <TR> 
              <TD nowrap bgcolor="#D0DCE0">&nbsp;</TD>
              <TD nowrap bgcolor="#D0DCE0">confirmation :</TD>
              <TD bgcolor="#F5F5F5"> 
                <INPUT type="password" name="password2" size="20">
              </TD>
            </TR>
            <TR>
              <TD nowrap bgcolor="#D0DCE0">&nbsp;</TD>
              <TD nowrap bgcolor="#D0DCE0">e-mail :</TD>
              <TD bgcolor="#F5F5F5">
                <INPUT type="text" name="email" size="20">
              </TD>
            </TR>
          </TABLE>
		 
          <P>
            <INPUT type="button" name="Submit" value="Envoyer" onClick="verify()">
          </P>
          </FORM>
      </TD>
  </TR>
</TABLE>
</CENTER>
</BODY>
</HTML>

<?
//*  }
//*  else include('piratage.php');
?>
