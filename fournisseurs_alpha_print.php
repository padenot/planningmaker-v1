<?
  session_start();

  $session_db_name = $_SESSION['session_db_name'];
  $session_user_type = $_SESSION['session_user_type'];
  
  include('connect_db.php');
  include('functions.php');
  include('classes.php');
  $req_sql="SELECT * FROM fournisseurs ORDER BY name";
  $req = mysql_query($req_sql);
?>




<TABLE width="1%" cellspacing="0" cellpadding="3">
  <TR>
    <TD colspan="9">&nbsp;</TD>
  </TR>
  
  <TR bgcolor="#CCCCCC"> 
    <TD colspan="2" nowrap> <B>Liste des fournisseurs</B> </TD>
    <TD align="center" nowrap><B>E-mail</B></TD>
    <TD align="center" nowrap><B>Adresse</B></TD>
    <TD align="center" nowrap><B>T&eacute;l.</B></TD>
    <TD align="center"> <B>Nom du contact</B> </TD>
	
  </TR>
  <?
  $bgcolor="#EAEAEA";
  $fournisseurs_array=result_fournisseurs($req);
  for ($i=0;$i<count($fournisseurs_array);$i++)
  {
  if ($bgcolor=="#EAEAEA") $bgcolor="#FFFFFF";
	else $bgcolor="#EAEAEA";
?>
  <TR bgcolor="<? print($bgcolor); ?>">
<!--  <TR class="orgas"> -->
    <TD width="1%">&nbsp;&nbsp;&nbsp;</TD>
    <TD valign="top" nowrap><? print($fournisseurs_array[$i]->name); ?> 
    </TD>
    <TD align="CENTER" valign="top" nowrap> <? print($fournisseurs_array[$i]->email); ?> 
    </TD>
    <TD align="CENTER" valign="top" nowrap> <? print($fournisseurs_array[$i]->mail_adress); ?> 
    </TD>
    <TD align="CENTER" valign="top" nowrap> <? print($fournisseurs_array[$i]->phone_number); ?> 
    </TD>
    <TD align="CENTER" valign="top" nowrap> <? print($fournisseurs_array[$i]->contact);?>
    </TD>
	
  </TR>
  <?
  }
?>
</TABLE>

