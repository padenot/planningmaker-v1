<?
  session_start();

  include('connect_db.php');
  include('functions.php');
  include('classes.php');

    $req_sql="UPDATE orgas SET end_time='2002-09-22 21:00:00'";
//  $req = mysql_query($req_sql);

print($req_sql."<br>");
?>