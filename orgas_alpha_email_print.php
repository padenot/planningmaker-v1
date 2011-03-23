<?
  session_start();

  include('connect_db.php');
  include('functions.php');
  include('classes.php');

  $req_sql="SELECT * FROM orgas ORDER BY first_name, last_name";
  $req = mysql_query($req_sql);
?>

<HTML>

<HEAD>

<TITLE>Liste des emails des orgas</TITLE>
<LINK href="print.css" type="text/css" rel="stylesheet">

</HEAD>


<BODY>

<?
  $orgas_array=result_orgas($req);
  for ($i=0;$i<count($orgas_array);$i++)
  {
    print($orgas_array[$i]->email);
	if ($i!=count($orgas_array)-1)  print(", ");
  }
?>

</BODY>
</HTML>