<?
  if ($id_equipe=="")
  {
    $req_sql="SELECT MIN(id_equipe) FROM equipes";
    $req = mysql_query($req_sql);
    while ($data = mysql_fetch_array($req))
    {
      $id_equipe=$data['MIN(id_equipe)'];
    }
  }

  $req_sql="SELECT plannings_eq.*, activites.titre, activites.consigne, activites.id_vehicule, lieux.nom_lieu, lieux.id_lieu FROM plannings_eq, activites, lieux WHERE plannings_eq.id_equipe LIKE '%|".$id_equipe."|%' AND plannings_eq.id_activite=activites.id_activite AND activites.id_lieu=lieux.id_lieu ORDER BY plannings_eq.current_time";
  $req_plannings_eq = mysql_query($req_sql);

  $req_sql="SELECT * FROM equipes ORDER BY nom_equipe";
  $req_equipes = mysql_query($req_sql);

  $req_sql="SELECT * FROM vehicules ORDER BY nom_vehicule";
  $req_vehicules = mysql_query($req_sql);

  $plannings_eq_array=result_plannings_eq($req_plannings_eq);
  $vehicules_array=result_vehicules($req_vehicules);

  $begin_time_loop=date_en_to_number($plannings_eq_array[0]->current_time);
  $begin_time_loop=substr($begin_time_loop,0,8)."0000";

  $end_time_loop=date_en_to_number($plannings_eq_array[count($plannings_eq_array)-1]->current_time);
  $end_time_loop=substr($end_time_loop,0,8)."2345";

  $largeur=substr($end_time_loop,0,8)-substr($begin_time_loop,0,8);
  $largeur=100/(($largeur+1)*2);
?>

<TABLE width="100%" cellspacing="0" cellpadding="3">
  <TR>
    <TD>&nbsp;</TD>
  </TR>
<FORM method="POST" name="form_choix" action="main.php?file=plannings_eq&action=rules">
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
          <TD>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</TD>
          <TD>
            <B><A href="<? print($file."_print.php?id_equipe=".$id_equipe); ?>" target="_blank" class="menu">Imprimer</A></B>
          </TD>
        </TR>
      </TABLE>
    </TD>
  </TR>
</FORM>
  <TR class="plannings_eq">
    <TD>
      <TABLE width="100%" cellspacing="0" cellpadding="3">

<?
  $id_activite_array=array();
  for ($i=$begin_time_loop;$i<=substr($begin_time_loop,0,8)."1145";$i=$i+15)
  {
?>


        <TR>

<?
    $i=test_time($i);
    $j=$i;
    $current_day="";
    $k=0;
    while ($j<=$end_time_loop)
    {
?>

          <TD valign="top" width="<? print($largeur); ?>%">
            <TABLE width="100%" cellspacing="0" cellpadding="3">

<?
      if ((substr($j,0,8)!=$current_day) && ($i==$begin_time_loop))
      {
        $current_day=substr($j,0,8);
?>

              <TR>
                <TD width="1%" colspan="2" align="center" nowrap>
                  <B><? print(substr(date_number_to_fr($j),0,10)); ?></B>
                </TD>
              </TR>

<?
      }
      else
      {
?>

              <TR>
                <TD width="1%" colspan="2" nowrap>&nbsp;</TD>
              </TR>

<?
      }
?>

              <TR>
                <TD width="1%" nowrap>
                  <? print(substr(date_number_to_fr($j),11,5)); ?>

<?
      $id_activite="";
      $titre="";
      $consigne="";
      $lieu="";
      $id_lieu="";
      $vehicule="";
	  $coequipiers="";
      $position=0;
      while (($plannings_eq_array[$position]->current_time<=date_number_to_en($j).":00") && ($position<count($plannings_eq_array)))
      {
        if ($plannings_eq_array[$position]->current_time==date_number_to_en($j).":00")
        {
          $id_activite=$plannings_eq_array[$position]->id_activite;
          $titre=$plannings_eq_array[$position]->titre_activite;
          $consigne=$plannings_eq_array[$position]->consigne_activite;
          $lieu=$plannings_eq_array[$position]->nom_lieu;
          $id_lieu=$plannings_eq_array[$position]->id_lieu;
          for ($l=0;$l<count($vehicules_array);$l++)
          {
            if ($vehicules_array[$l]->id_vehicule==$plannings_eq_array[$position]->id_vehicule)
            {
              $vehicule=$vehicules_array[$l]->nom;
              break;
            }
          }
          $list_equipes=explode("|",$plannings_eq_array[$position]->id_equipe);
          for ($l=0;$l<count($list_equipes);$l++)
          {
            for ($m=0;$m<count($equipes_array);$m++)
            {
              if (($equipes_array[$m]->id_equipe==$list_equipes[$l]) && ($equipes_array[$m]->id_equipe!=$id_equipe))
              {
			    if ($coequipiers!="") $coequipiers=$coequipiers.", ";
 		  	    $coequipiers=$coequipiers.$equipes_array[$m]->nom;
			    break;
			  }
		    }
		  }
		  break;
        }
        else $position++;
      }

      if (($id_activite_array[$k]==$id_activite) && ($id_activite!="")) $consigne="idem";

      if ($titre=="") $titre="Pause";
      else $titre="<A HREF=\"main.php?file=equipes&action=activite&id_activite=".$id_activite."\" CLASS=\"lien\">".$titre."</A>";

      if ($consigne=="") $consigne="rien...";
      if ($lieu!="") $lieu="<BR><U>Lieu</U>&nbsp;: <A HREF=\"main.php?file=equipes&action=lieu&id_lieu=".$id_lieu."\" CLASS=\"lien\">".$lieu."</A>";
      if ($vehicule!="") $vehicule="<BR><U>V&eacute;hicule</U>&nbsp;: ".$vehicule;
      if ($coequipiers!="") $coequipiers="<BR><U>Contre qui tu joues</U>&nbsp;: ".$coequipiers;

      $id_activite_array[$k]=$id_activite;
      $k++;
?>

                </TD>
                <TD nowrap>
                  <B><? print($titre); ?></B>
                </TD>
              </TR>
              <TR>
                <TD width="1%" colspan="2">
                  <u>R&egrave;gles</u>&nbsp;: <? print(str_replace("\r\n","<BR>",$consigne)); ?>
                  <? print($lieu); ?>
                  <? print($coequipiers); ?>
                  <? print($vehicule); ?>
                </TD>
              </TR>
            </TABLE>
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
