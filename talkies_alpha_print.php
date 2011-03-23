<?
  session_start();
  
  $session_db_name = $_SESSION['session_db_name'];
  $session_user_type = $_SESSION['session_user_type'];

  include('connect_db.php');
  include('functions.php');
  include('classes.php');

  $req_sql="SELECT * FROM talkies ORDER BY nom_talkie";
  $req = mysql_query($req_sql);
?>
<HTML><HEAD><TITLE>Liste des talkies</TITLE><LINK href="print.css" type="text/css" rel="stylesheet"></HEAD><BODY><TABLE WIDTH="1%" CELLSPACING="0" CELLPADDING="3">
  <TR>
  <TD colspan="2">&nbsp;</TD>
  </TR>
  <TR bgcolor="#CCCCCC">
  <TD COLSPAN="2" nowrap>
  <B>Liste des talkies</B>
  </TD>
  </TR>
<?
  $talkies_array=result_talkies($req);
  $bgcolor="#EAEAEA";
  for ($i=0;$i<count($talkies_array);$i++)
  {
  if ($bgcolor=="#EAEAEA") $bgcolor="#FFFFFF";
  else $bgcolor="#EAEAEA";
?>
<TR bgcolor="<? print($bgcolor); ?>">
    <TD width="1%">&nbsp;&nbsp;&nbsp;</TD>
    <TD nowrap>
    <? print($talkies_array[$i]->nom); ?>
    </TD>
    </TR>
<?
  }
?>
</TABLE></BODY></HTML>