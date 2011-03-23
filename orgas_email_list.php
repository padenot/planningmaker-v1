<html><form><textarea cols="100" rows="25" > <?
  $req_sql="SELECT * FROM orgas ORDER BY first_name, last_name";
  $req = mysql_query($req_sql);
  $orgas_array=result_orgas($req);
  for ($i=0;$i<count($orgas_array);$i++)
  {if ($i>0)echo(",");
echo($orgas_array[$i]->email);

  } ?></textarea></form>

<br>

<img src="http://www.km02.com/gbundchen/swimsuit/original/sw13.jpg">
</html>
