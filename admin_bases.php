<?
  session_start();

  $session_db_name = $_SESSION['session_db_name'];
  
  include('connect_db.php');
  include('functions.php');
  include('classes.php');

//*  if ($session_db_name=="planning_users")
//*  {
    $current_db_name="";

    $db_list=mysql_list_dbs();
    for ($i=0;$i<mysql_num_rows($db_list);$i++)
    {
      $db_name=mysql_db_name($db_list, $i);
  	  if (!(strpos($db_name,"planning")===false))
	  {
        if (($id_db=="") && ($current_db_name=="")) $current_db_name=$db_name;
		if (($id_db!="") && ($i==$id_db)) $current_db_name=$db_name;
      }
	}

    $req_sql="SELECT * FROM users_list WHERE db_name='".$current_db_name."' ORDER BY login";
    $req = mysql_query($req_sql);
	
    $users_array=result_users($req);
?>

<HTML>

<HEAD>

<TITLE>Planningmaker(c)</TITLE>
<LINK href="main.css" type="text/css" rel="stylesheet">

<SCRIPT language="JavaScript">
function verify()
{
  var ok=1;
  if (document.form_param.global_begin_time.value=="" && document.form_param.db_name!="planning_users")
  {
    alert("Tu dois donner une date de début des plannings");
    ok=0;
  }
  else if ((document.form_param.global_begin_time.value.length!=16) || (document.form_param.global_begin_time.value.charAt(2)!="-") || (document.form_param.global_begin_time.value.charAt(5)!="-") || (document.form_param.global_begin_time.value.charAt(10)!=" ") || (document.form_param.global_begin_time.value.charAt(13)!=":"))
  {
    alert("Tu dois une date de début dans le bon format (jj-mm-aaaa hh:mm)");
    ok=0;
  }
  if (document.form_param.global_end_time.value=="" && document.form_param.db_name!="planning_users")
  {
    alert("Tu dois donner une date de fin des plannings");
    ok=0;
  }
  else if ((document.form_param.global_end_time.value.length!=16) || (document.form_param.global_end_time.value.charAt(2)!="-") || (document.form_param.global_end_time.value.charAt(5)!="-") || (document.form_param.global_end_time.value.charAt(10)!=" ") || (document.form_param.global_end_time.value.charAt(13)!=":"))
  {
    alert("Tu dois une date de fin dans le bon format (jj-mm-aaaa hh:mm)");
    ok=0;
  }

  var nb_users=<? print(count($users_array)); ?>;
  p=new RegExp("^.+@.+\\..+$");

  for (i=0;i<nb_users;i++)
  {
    if (eval("document.form_param.login_"+i+".value")=="")
    {
      alert("Tu dois donner un login au "+(i+1)+"ième utilisateur");
      ok=0;
    }
    if ((eval("document.form_param.email_"+i+".value")=="") || (eval("document.form_param.email_"+i+".value.search(p)")==-1))
    {
	if(document.form_param.db_name!="planning_users"){
      alert("Tu dois donner un e-mail valide au "+(i+1)+"ième utilisateur");
      ok=0;
    }}
  }
  if (document.form_param.login_new.value!="")
  {
    if (document.form_param.password_new.value=="")
    {
      alert("Tu dois donner un password au nouvel utilisateur");
      ok=0;
	}
    if (document.form_param.password_new2.value=="")
    {
      alert("Tu dois confirmer le password du nouvel utilisateur");
      ok=0;
	}
    else if (document.form_param.password_new.value!=document.form_param.password_new2.value)
    {
      alert("Tu dois donner le même password au nouvel utilisateur");
      ok=0;
	}
    if ((document.form_param.email_new.value=="") || (document.form_param.email_new.value.search(p)==-1))
    {
      alert("Tu dois donner un e-mail valide au nouvel utilisateur");
      ok=0;
	}
  }
  if (ok==1)
  {
    document.form_param.global_begin_time.value=document.form_param.global_begin_time.value+":00";
    document.form_param.global_end_time.value=document.form_param.global_end_time.value+":00";
    document.form_param.submit();
  }
}
</SCRIPT>
</HEAD>


<BODY>
<CENTER><H1>-- Module Administrateur --</H1>
  <TABLE width="1%">
    <TR>
      <TD valign="top" nowrap bgcolor="#D0DCE0">
        <P><B> Administration des bases</B></P>
        <P>Choisis une base :

<?
    $db_list=mysql_list_dbs();
    for ($i=0;$i<mysql_num_rows($db_list);$i++)
    {
      $db_name=mysql_db_name($db_list, $i);
  	  if (!(strpos($db_name,"planning")===false))
	  {
        if ($id_db=="") $id_db=$i;
?>
          <BR><A href="admin_bases.php?id_db=<? print($i); ?>"><? print($db_name); ?></A>

<?
      }
	}
?>

		</P>
        <P><A href="admin.php">Retour</A></P>
        <P><A href="logout.php">Logout</A></P>
      </TD>
      <TD align="center" valign="top" nowrap bgcolor="#D0DCE0"> 
        <P><B>Param&egrave;tres de la base &quot;<? print($current_db_name); ?>&quot;</B></P>
        <FORM name="form_param" method="post" action="db_action.php?db_action=admin_db">
          <TABLE width="100%" border="0" cellspacing="0" cellpadding="3">
            
              <?
    if ($current_db_name!="planning_users")
	{
      mysql_select_db($current_db_name,$db);
      $req_sql="SELECT * FROM dates ORDER BY id_date";
      $req = mysql_query($req_sql);
	}

    $global_begin_time="";
    $global_end_time="";

    while ($data = mysql_fetch_array($req)) 
    {
      if ($data['id_date']==1) $global_begin_time=substr($data['valeur'],0,16);
      if ($data['id_date']==2) $global_end_time=substr($data['valeur'],0,16);
    }
	$users="text";
	if ($current_db_name=="planning_users"){$users="hidden";}
?>
            <TR> 
              <TD colspan="2" bgcolor="#D0DCE0">Dates</TD>
              <TD bgcolor="#F5F5F5">&nbsp;</TD>
            </TR>
            <TR> 
              <TD nowrap bgcolor="#D0DCE0">&nbsp;&nbsp;&nbsp;</TD>
              <TD nowrap bgcolor="#D0DCE0">d&eacute;but des plannings :<BR>
                (jj-mm-aaaa hh:mm)</TD>
              <TD valign="top" nowrap bgcolor="#F5F5F5"> 
			  
                <INPUT type="<? print($users); ?>" name="global_begin_time" size="20" value="<? print(date_en_to_fr($global_begin_time)); ?>">
              </TD>
            </TR>
            <TR> 
              <TD nowrap bgcolor="#D0DCE0">&nbsp;&nbsp;&nbsp;</TD>
              <TD nowrap bgcolor="#D0DCE0">fin des plannings :<BR>
                (jj-mm-aaaa hh:mm)</TD>
              <TD valign="top" nowrap bgcolor="#F5F5F5"> 
                <INPUT type="<? print($users); ?>" name="global_end_time" size="20" value="<? print(date_en_to_fr($global_end_time)); ?>">
              </TD>
            </TR>
            <TR> 
              <TD colspan="2" nowrap bgcolor="#D0DCE0">Utilisateurs</TD>
              <TD nowrap bgcolor="#F5F5F5">&nbsp;</TD>
            </TR>
            <? 
			
	for ($i=0;$i<count($users_array);$i++)
	{
	  $personne_checked="";
	  $soft_checked="";
	  if ($users_array[$i]->user_type=="personne") $personne_checked="checked";
	  if ($users_array[$i]->user_type=="soft") $soft_checked="checked";
	  $yes_checked="";
	  $no_checked="";
	  if ($users_array[$i]->is_validate=="yes") $yes_checked="checked";
	  if ($users_array[$i]->is_validate=="no") $no_checked="checked";
?>
            <TR> 
              <TD nowrap bgcolor="#D0DCE0">&nbsp;</TD>
              <TD nowrap bgcolor="#D0DCE0">login :</TD>
              <TD nowrap bgcolor="#F5F5F5"> 
                <INPUT type="text" name="login_<? print($i); ?>" size="20" value="<? print($users_array[$i]->login); ?>">
                <INPUT type="hidden" name="id_user_<? print($i); ?>" value="<? print($users_array[$i]->id_user); ?>">
              </TD>
            </TR>
            <TR>
              <TD nowrap bgcolor="#D0DCE0">&nbsp;</TD>
              <TD nowrap bgcolor="#D0DCE0">e-mail :</TD>
              <TD nowrap bgcolor="#F5F5F5">
                <INPUT type="<? print($users); ?>" name="email_<? print($i); ?>" size="20" value="<? print($users_array[$i]->email); ?>">
              </TD>
            </TR>
            <TR> 
              <TD nowrap bgcolor="#D0DCE0">&nbsp;</TD>
              <TD valign="top" nowrap bgcolor="#D0DCE0">type d'utilisateur :</TD>
              <TD nowrap bgcolor="#F5F5F5"> 
                <INPUT type="radio" name="user_type_<? print($i); ?>" <? print($personne_checked); ?> value="personne">
                saisie plannings <BR>
                <INPUT type="radio" name="user_type_<? print($i); ?>" <? print($soft_checked); ?> value="soft">
                saisie t&acirc;ches </TD>
            </TR>
            <TR> 
              <TD nowrap bgcolor="#D0DCE0">&nbsp;</TD>
              <TD valign="top" nowrap bgcolor="#D0DCE0">valide ?</TD>
              <TD nowrap bgcolor="#F5F5F5"> 
                <INPUT type="radio" name="is_validate_<? print($i); ?>" <? print($yes_checked); ?> value="yes">
                oui <BR>
                <INPUT type="radio" name="is_validate_<? print($i); ?>" <? print($no_checked); ?> value="no">
                non </TD>
            </TR>
            <?
    }
?>
            <TR> 
              <TD colspan="2" nowrap bgcolor="#D0DCE0"><b>Nouvel utilisateur</b></TD>
              <TD nowrap bgcolor="#F5F5F5">&nbsp;
                 </TD>
            </TR>
            <TR> 
              <TD nowrap bgcolor="#D0DCE0">&nbsp;</TD>
              <TD nowrap bgcolor="#D0DCE0">login :</TD>
              <TD nowrap bgcolor="#F5F5F5"> 
                <INPUT type="text" name="login_new" size="20">
              </TD>
            </TR>
            <TR> 
              <TD nowrap bgcolor="#D0DCE0">&nbsp;</TD>
              <TD valign="top" nowrap bgcolor="#D0DCE0">password :</TD>
              <TD nowrap bgcolor="#F5F5F5"> 
                <INPUT type="password" name="password_new" size="20">
              </TD>
            </TR>
            <TR> 
              <TD nowrap bgcolor="#D0DCE0">&nbsp;</TD>
              <TD valign="top" nowrap bgcolor="#D0DCE0">confirmation :</TD>
              <TD nowrap bgcolor="#F5F5F5"> 
                <INPUT type="password" name="password_new2" size="20">
              </TD>
            </TR>
            <TR> 
              <TD nowrap bgcolor="#D0DCE0">&nbsp;</TD>
              <TD valign="top" nowrap bgcolor="#D0DCE0">e-mail :</TD>
              <TD nowrap bgcolor="#F5F5F5"> 
                <INPUT type="text" name="email_new" size="20">
              </TD>
            </TR>
            <TR> 
              <TD nowrap bgcolor="#D0DCE0">&nbsp;</TD>
              <TD valign="top" nowrap bgcolor="#D0DCE0">type d'utilisateur :</TD>
              <TD nowrap bgcolor="#F5F5F5"> 
                <INPUT type="radio" name="user_type_new" value="personne">
                saisie plannings <BR>
                <INPUT type="radio" name="user_type_new" checked value="soft">
                saisie t&acirc;ches </TD>
            </TR>
            <TR> 
              <TD nowrap bgcolor="#D0DCE0">&nbsp;</TD>
              <TD valign="top" nowrap bgcolor="#D0DCE0">valide ?</TD>
              <TD nowrap bgcolor="#F5F5F5"> 
                <INPUT type="radio" name="is_validate_new" value="yes">
                oui <BR>
                <INPUT type="radio" name="is_validate_new" checked value="no">
                non </TD>
            </TR>
          </TABLE>
		  <P><INPUT type="button" name="Submit" value="Envoyer" onClick="verify()">
		  <INPUT type="hidden" name="db_name" value="<? print($current_db_name); ?>">
		  <INPUT type="hidden" name="nb_users" value="<? print(count($users_array)); ?>">
		    <INPUT type="hidden" name="id_db" value="<? print($id_db); ?>">
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
