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

  $begin_time_loop=date_en_to_number($global_begin_date);
  $begin_time_loop=substr($begin_time_loop,0,8)."0000";

  $end_time_loop=date_en_to_number($global_end_date);
  $end_time_loop=substr($end_time_loop,0,8)."2345";
?>

<SCRIPT language="Javascript">
<!--
var begin_time="<? print($begin_time_loop); ?>";
var end_time="<? print($begin_time_loop); ?>";
var duree="00:15:00";
var changement=0;

function change_img()
{
  var i=0;
  for (i=0;i<document.images.length;i++)
  {
    document.images[i].src="images/blanc.gif";
  }

  var valeur=document.form_choix.id_activite[document.form_choix.id_activite.selectedIndex].value;
  duree=valeur.substring(valeur.lastIndexOf("|")+1,valeur.length-3);
  valeur=valeur.substring(0,valeur.lastIndexOf("|"));
  end_time=valeur.substring(valeur.lastIndexOf("|")+1,valeur.length-3);
  end_time=end_time.substr(0,4)+end_time.substr(5,2)+end_time.substr(8,2)+end_time.substr(11,2)+end_time.substr(14,2);
  valeur=valeur.substring(0,valeur.lastIndexOf("|"));
  begin_time=valeur.substring(valeur.lastIndexOf("|")+1,valeur.length-3);
  begin_time=begin_time.substr(0,4)+begin_time.substr(5,2)+begin_time.substr(8,2)+begin_time.substr(11,2)+begin_time.substr(14,2);

  for (i=0;i<document.images.length;i++)
  {
    var nom=document.images[i].name;
    nom=nom.substring(nom.lastIndexOf("_")+1,nom.length);
    if ((nom>=begin_time) && (nom<end_time)) document.images[i].src="images/coche.gif";
  }
}

function change_txt(nb)
{
  var heure=duree.substr(0,2);
  heure=heure*4;
  var minute=duree.substr(3,2);
  boucle=heure+minute/15;
  for (i=0;i<boucle;i++)
  {
    var source=eval("document.coche_"+nb+".src");
    if ((source.indexOf("images/coche.gif")!=-1) || (document.form_choix.id_activite.selectedIndex==0))
    {
      var valeur=document.form_choix.id_activite[document.form_choix.id_activite.selectedIndex].value;
      valeur=valeur.substring(0,valeur.indexOf("|"));
      eval("document.form_planning.id_activite_"+nb+".value=valeur");
      eval("document.form_planning.titre_"+nb+".value=document.form_choix.id_activite.options[document.form_choix.id_activite.selectedIndex].text");
      nb=nb+15;
      nb_txt=""+nb;
//manque changement de mois et d'année
      if (nb_txt.substr(8,4)=="2360") nb=nb+7640;
      else if (nb_txt.substr(8,2)>=24) nb=nb+7600;
      else if (nb_txt.substr(10,2)=="60") nb=nb+40;
    }
  }
  changement=1;
}

function confirm_record()
{
  if (changement==1)
  {
    if (confirm("Voulez-vous enregistrez les modifications avant de changer d'équipe ?"))
    {
      document.form_planning.id_equipe_new.value=document.form_choix.id_equipe.value;
      document.form_planning.submit();
    }
    else document.form_choix.submit();
  }
  else document.form_choix.submit();
}
-->
</SCRIPT>

<TABLE width="1%" cellspacing="0" cellpadding="3">
  <TR>
    <TD>&nbsp;</TD>
  </TR>
<FORM method="POST" name="form_choix" action="main.php?file=plannings_eq&action=define">
  <TR class="plannings_eq_top">
    <TD>
      <TABLE width="1%" cellspacing="0" cellpadding="3">
        <TR>
          <TD valign="top" nowrap>
            <B>Choisis une &eacute;quipe :</B>
          </TD>
          <TD valign="top" align="center">
            <SELECT name="id_equipe" onChange="confirm_record()">

<?
  $equipes_array=result_equipes($req_equipes);
  echo $id_equipe;
  for ($i=0;$i<count($equipes_array);$i++)
  {
    $is_selected="";
    if ($equipes_array[$i]->id_equipe==$id_equipe) 
    {
    	$is_selected="selected";
    }
?>

              <OPTION <? print($is_selected); ?> value="<? print($equipes_array[$i]->id_equipe); ?>"><? print($equipes_array[$i]->nom); ?></OPTION>

<?
  }
?>

            
          </SELECT></TD>
          <TD>&nbsp;&nbsp;&nbsp;</TD>
          <TD valign="top" nowrap>
            <B>Choisis une activit&eacute; :</B>
          </TD>
          <TD valign="top" align="center">
            <SELECT name="id_activite" size="10" onChange="change_img()">
              <OPTION value="0|<? print($begin_time_loop); ?>|<? print($begin_time_loop); ?>|00:15:00"></OPTION>

<?
  $activites_array=result_activites($req_activites);
  for ($i=0;$i<count($activites_array);$i++)
  {
?>

              <OPTION value="<? print($activites_array[$i]->id_activite."|".$activites_array[$i]->begin_time."|".$activites_array[$i]->end_time."|".$activites_array[$i]->duree); ?>"><? print($activites_array[$i]->titre); ?></OPTION>

<?
  }
?>

            
          </SELECT></TD>
          <TD>&nbsp;&nbsp;&nbsp;</TD>
          <TD valign="top">
            <INPUT type="button" value="Envoyer" onClick="document.form_planning.submit()">
          </TD>
          <TD valign="top">
            <INPUT type="submit" value="Effacer">
          </TD>
        </TR>
      </TABLE>
    </TD>
  </TR>
</FORM>
<FORM method="POST" name="form_planning" action="db_action.php?db_action=update_planning_eq">
  <TR class="plannings_eq">
    <TD>
      <TABLE width="1%" cellspacing="0" cellpadding="3">
<INPUT type="hidden" name="id_equipe" value="<? print($id_equipe); ?>">
<INPUT type="hidden" name="id_equipe_new" value="<? print($id_equipe); ?>">
<INPUT type="hidden" name="begin_time_loop" value="<? print($begin_time_loop); ?>">
<INPUT type="hidden" name="end_time_loop" value="<? print($end_time_loop); ?>">

<?
  $plannings_eq_array=result_plannings_eq($req_plannings_eq);
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

          <TD align="right" nowrap>

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

?>

          </TD>
          <TD align="center" width="1%">
            <INPUT type="text" name="titre_<? print($j); ?>" value="<? print($titre); ?>"  onClick="change_txt(<? print($j); ?>)">
            <INPUT type="hidden" name="id_activite_<? print($j); ?>" value="<? print($id_activite); ?>">
            <INPUT type="hidden" name="current_time_<? print($j); ?>" value="<? print(date_number_to_en($j).":00"); ?>">
          </TD>
          <TD>
            <IMG name="coche_<? print($j); ?>" src="images/blanc.gif" height="15" width="15">
          </TD>

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
</FORM>
  
</TABLE>
