<? if ($query!=""){

print("<BR>".$query);
$req = mysql_query($query); 

}?>


<form action="main.php?file=orgas&action=bidouille" method="post"><input name="query" type="text"><input type="submit"></form>