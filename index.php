<?
  include('connect_db.php');

?>

<HTML>

<HEAD>
<TITLE>Planningmaker V2</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META name="Description" content="">
<META name="Keywords" content="">

<LINK href="main.css" type="text/css" rel="stylesheet">

<SCRIPT language="Javascript">
<!--
function verify()
{
  var ok=1;
  if (document.log_form.login.value=="")
  {
    alert("Tu dois entrer un login");
	ok=0;
  }
  if (document.log_form.password.value=="")
  {
    alert("Tu dois entrer un mot de passe");
	ok=0;
  }
  if (ok==1) document.log_form.submit();
}
-->
</SCRIPT>

</HEAD>

<BODY>
<CENTER><H1>-- Planningmaker &copy; V2 --</H1></CENTER>
<P>&nbsp;
<CENTER>
<FORM method="POST" name="log_form" action="login.php">
    <TABLE STYLE="background-color: grey;">
      <TR> 
        <TD colspan="3">&nbsp;</TD>
      </TR>
      <TR> 
        <TD>&nbsp;&nbsp;&nbsp;</TD>
        <TD> Login&nbsp;:&nbsp; </TD>
        <TD> 
          <INPUT type="text" name="login" value="<?php print($login); ?>" size="20" maxlength="40">
        </TD>
      </TR>
      <TR> 
        <TD>&nbsp;&nbsp;&nbsp;</TD>
        <TD> Mot de passe&nbsp;:&nbsp; </TD>
        <TD> 
          <INPUT type="password" name="password" size="20" maxlength="40">
          <INPUT type="hidden" name="file" value="menu">
        </TD>
      </TR>
      <TR> 
<?
	if($_GET["db"] == "")
	{
?>
        <TD>&nbsp;&nbsp;&nbsp;</TD>
        <TD> Base de donn&eacute;es&nbsp;:&nbsp; </TD>
        <TD> 
          <SELECT name="db_name">
            <?
  $db_list=mysql_list_dbs();
  for ($i = mysql_num_rows($db_list);$i>=0;$i--)
  {
    $db_name=mysql_db_name($db_list, $i);
	if (!(strpos($db_name,"planning")===false))
	{
?>
            <OPTION value="<? print($db_name); ?>"><? print($db_name);?></OPTION>
            <?
    }
  }
?>
          </SELECT>
        </TD>
<?
	} else {
?>
        <TD>&nbsp;&nbsp;&nbsp;</TD>
        <TD> Base de donn&eacute;es&nbsp;:&nbsp; </TD>
        <TD> <? print("planning_".$_GET["db"]); ?>	</TD>
	<td>
		<input type="hidden" name="db_name" value="<? print("planning_".$_GET["db"]); ?>">
	</td>
<?
	}
?>
      </TR>
      <?
  if ($msg!="")
  {
?>
      <TR> 
        <TD>&nbsp;&nbsp;&nbsp;</TD>
        <TD> <FONT color="#FF0000"><? print($msg); ?></FONT> </TD>
        <TD>&nbsp;</TD>
      </TR>
      <?
  }
?>
      <TR> 
        <TD>&nbsp;</TD>
        <TD>&nbsp;</TD>
        <TD>&nbsp;</TD>
      </TR>
      <TR> 
        <TD>&nbsp;&nbsp;&nbsp;</TD>
        <TD align="center"> 
          <INPUT type="button" value="Envoyer" onClick="verify()">
        </TD>
        <TD align="center"> 
          <INPUT type="reset" value="Effacer">
        </TD>
      </TR>
        <TR> 
        <TD>&nbsp;</TD>
      </TR>
    </TABLE>
</FORM>
<P>&nbsp;

<table>
	  <tr valign="bottom"><td align="center">Logiciel développé par Nicolas Depelchin.<br>Rendons lui hommage amis responsables orgas !<br/>V2 par Jérem' et Vivi qui méritent eux aussi un peu de considération allons.</td></tr>
</table>
</center>
</BODY>


</HTML>
