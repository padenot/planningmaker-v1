<?
  if (isset($_POST['id_equipe']))
  {
    $id_equipe=$_POST['id_equipe'];
  }
  if ($id_equipe=="")
  {
    $req_sql="SELECT MIN(id_equipe) FROM equipes";
    $req = mysql_query($req_sql);
    while ($data = mysql_fetch_array($req))
    {
      $id_equipe=$data['MIN(id_equipe)'];
    }
  }

  $req_sql="SELECT plannings_eq.*, activites.titre FROM plannings_eq, activites WHERE plannings_eq.id_equipe LIKE '%|".$id_equipe."|%' AND plannings_eq.id_activite=activites.id_activite ORDER BY plannings_eq.current_time";
  $req_plannings_eq = mysql_query($req_sql);

  $req_sql="SELECT * FROM equipes ORDER BY nom_equipe";
  $req_equipes = mysql_query($req_sql);

  $req_sql="SELECT * FROM activites ORDER BY titre";
  $req_activites = mysql_query($req_sql);

  $plannings_eq_array=result_plannings_eq($req_plannings_eq);

  $begin_time_loop=date_en_to_number($plannings_eq_array[0]->current_time);
  $begin_time_loop=substr($begin_time_loop,0,8)."0000";

  $end_time_loop=date_en_to_number($plannings_eq_array[count($plannings_eq_array)-1]->current_time);
  $end_time_loop=substr($end_time_loop,0,8)."2345";

  $largeur=substr($end_time_loop,0,8)-substr($begin_time_loop,0,8);
  $largeur=100/(($largeur+1)*2);
?>

<TABLE width="1%" cellspacing="0" cellpadding="3">
  <TR>
    <TD>&nbsp;</TD>
  </TR>
<FORM method="POST" name="form_choix" action="main.php?file=plannings_eq&action=edit">
  <TR class="plannings_eq_top">
    <TD>
      <TABLE width="1%" cellspacing="0" cellpadding="3">
        <TR>
          <TD nowrap>
            <B>Choisis une &eacute;quipe :</B>
          </TD>
          <TD align="center">
            <SELECT name="id_equipe" onChange="submit()">

<?
  $equipes_array=result_equipes($req_equipes);
  for ($i=0;$i<count($equipes_array);$i++)
  {
    $is_selected="";
    if ($equipes_array[$i]->id_equipe==$id_equipe) $is_selected="selected";
?>

              <OPTION <? print($is_selected); ?> value="<? print($equipes_array[$i]->id_equipe); ?>"><? print($equipes_array[$i]->nom); ?></OPTION>

<?
  }
?>

            
          </SELECT></TD>
          <TD>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</TD>
          <TD nowrap>
            <A href="main.php?file=plannings_eq&action=define&id_equipe=<? print($id_equipe); ?>" class="menu"><B>Modifier</B></A>
          </TD>
        </TR>
      </TABLE>
    </TD>
  </TR>
</FORM>
  <TR class="plannings_eq">
    <TD>
      <TABLE width="1%" cellspacing="0" cellpadding="3">

<?
  for ($i=$begin_time_loop;$i<=substr($begin_time_loop,0,8)."1145";$i=$i+15)
  {
?>


        <TR>

<?
    $i=test_time($i);
    $j=$i;
    $current_day="";
    while ($j<=$end_time_loop)
    {
?>

          <TD align="right" valign="bottom" width="<? print($largeur); ?>%" nowrap>

<?
      if ((substr($j,0,8)!=$current_day) && ($i==$begin_time_loop))
      {
        $current_day=substr($j,0,8);
        print("<B>".substr(date_number_to_fr($j),0,10)."</B><BR>".substr(date_number_to_fr($j),11,5));
      }
      else print(substr(date_number_to_fr($j),11,5));

      $titre="";
      $id_activite="";
      $position=0;
      while (($plannings_eq_array[$position]->current_time<=date_number_to_en($j).":00") && ($position<count($plannings_eq_array)))
      {
        if ($plannings_eq_array[$position]->current_time==date_number_to_en($j).":00")
        {
          $titre=$plannings_eq_array[$position]->titre_activite;
          $id_activite=$plannings_eq_array[$position]->id_activite;
          break;
        }
        else $position++;
      }
      if ($titre=="") $titre="Pause";
      else $titre="<A HREF=\"main.php?file=equipes&action=activite&id_activite=".$id_activite."\" CLASS=\"lien\">".$titre."</A>";

?>

          </TD>
          <TD valign="bottom" width="1%" nowrap>
            <? print($titre); ?>
          </TD>
          <TD bgcolor="#AF65A1">&nbsp;</TD>

<?
      $j=$j+1200;
      $j=test_time($j);
    }
?>

        </TR>

<?
  }
?>

      </TABLE>
    </TD>
  </TR>
</TABLE>
