<?
  session_start();

  $session_db_name = $_SESSION['session_db_name'];
  $session_user_type = $_SESSION['session_user_type'];
  
  include('connect_db.php');
  include('functions.php');
  include('classes.php');

  $req_sql="SELECT * FROM lieux ORDER BY nom_lieu";
  $req = mysql_query($req_sql);
?>
<HTML><HEAD><TITLE>Liste des lieux</TITLE><LINK href="print.css" type="text/css" rel="stylesheet"></HEAD><BODY><TABLE WIDTH="1%" CELLSPACING="0" CELLPADDING="3">  <TR>    <TD colspan="3">&nbsp;</TD>  </TR>  <TR bgcolor="#CCCCCC">    <TD COLSPAN="2" nowrap>      <B>Liste des lieux</B>    </TD>  </TR>
<?
  $lieux_array=result_lieux($req);
  $bgcolor="#EAEAEA";
  for ($i=0;$i<count($lieux_array);$i++)
  {
  if ($bgcolor=="#EAEAEA") $bgcolor="#FFFFFF";
  else $bgcolor="#EAEAEA";
?>
<TR bgcolor="<? print($bgcolor); ?>">
    <TD width="1%">&nbsp;&nbsp;&nbsp;</TD>
    <TD nowrap>
    <? print($lieux_array[$i]->nom); ?>
    </TD>
    </TR>
<?
  }
?>
</TABLE></BODY></HTML>