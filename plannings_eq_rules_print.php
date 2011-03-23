<?
  session_start();

  include('connect_db.php');
  include('functions.php');
  include('classes.php');

  $req_sql="SELECT * FROM dates ORDER BY id_date";
  $req = mysql_query($req_sql);

  $global_begin_date="";
  $global_end_date="";

  while ($data = mysql_fetch_array($req)) 
  {
    if ($data['id_date']==1) $global_begin_date=substr($data['valeur'],0,16);
    if ($data['id_date']==2) $global_end_date=substr($data['valeur'],0,16);
  }

  $req_sql="SELECT plannings_eq.*, activites.titre, activites.consigne, activites.id_vehicule, lieux.nom_lieu FROM plannings_eq, activites, lieux WHERE plannings_eq.id_equipe LIKE '%|".$id_equipe."|%' AND plannings_eq.id_activite=activites.id_activite AND activites.id_lieu=lieux.id_lieu ORDER BY plannings_eq.current_time";
  $req_plannings_eq = mysql_query($req_sql);

  $req_sql="SELECT * FROM equipes ORDER BY nom_equipe";
  $req_equipes = mysql_query($req_sql);

  $req_sql="SELECT * FROM vehicules ORDER BY nom_vehicule";
  $req_vehicules = mysql_query($req_sql);

  $nom_equipe="";
  $found=false;
  $id_equipe_next="";
  $id_equipe_prev="";
  $equipes_array=result_equipes($req_equipes);
  for ($i=0;$i<count($equipes_array);$i++)
  {
    if ($found==true)
    {
      $id_equipe_next=$equipes_array[$i]->id_equipe;
      break;
    }
    if ($equipes_array[$i]->id_equipe==$id_equipe)
    {
      $nom_equipe=$equipes_array[$i]->nom;
      $found=true;
    }
    if ($i!=0) $id_equipe_prev=$equipes_array[$i-1]->id_equipe;
  }

  $plannings_eq_array=result_plannings_eq($req_plannings_eq);
  $vehicules_array=result_vehicules($req_vehicules);

  $begin_time_loop=date_en_to_number($plannings_eq_array[0]->current_time);
//  $begin_time_loop=substr($begin_time_loop,0,8)."0000";	//pour les editions de demi-journees

  $end_time_loop=date_en_to_number($plannings_eq_array[count($plannings_eq_array)-1]->current_time);
//  $end_time_loop=substr($end_time_loop,0,8)."2345";		//pour les editions de demi-journees

  $nb_quart=difference_quart($end_time_loop,$begin_time_loop);
  $nb_quart=round($nb_quart/4)-1;

  $largeur=substr($end_time_loop,0,8)-substr($begin_time_loop,0,8);
  $largeur=100/(($largeur+1)*2);
?>

<HTML>

<HEAD>

<TITLE>Planning de l'&eacute;quipe <? print($nom_equipe); ?></TITLE>
<LINK href="print.css" type="text/css" rel="stylesheet">

</HEAD>


<BODY>

<TABLE width="100%" cellspacing="0" cellpadding="3">
  <TR>
    <TD>&nbsp;</TD>
  </TR>
  <TR>
    <TD>
      <TABLE>
        <TR>

<?
  if ($id_equipe_prev!="")
  {
?>

          <TD>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</TD>
          <TD>
            <A href="plannings_eq_rules_print.php?id_equipe=<? print($id_equipe_prev); ?>"><B>Equipe pr&eacute;c&eacute;dente</B></A>
          </TD>

<?
  }
  if ($id_equipe_next!="")
  {
?>

          <TD>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</TD>
          <TD>
            <A href="plannings_eq_rules_print.php?id_equipe=<? print($id_equipe_next); ?>"><B>Equipe suivante</B></A>
          </TD>

<?
  }
?>

        </TR>
      </TABLE>
    </TD>
  </TR>
  <TR>
    <TD align="center">
      <H1><? print($nom_equipe); ?></H1>
    </TD>
  </TR>
  <TR>
    <TD align="right">
      <TABLE width="100%" cellspacing="0" cellpadding="3">

<?
  $id_activite_array=array();
  $html_array=array();
  $current_day="";
  $j=0;

  for ($i=$begin_time_loop;$i<=$end_time_loop;$i=$i+15)
  {
    $i=test_time($i);
    $k=0;

    $id_activite="";
    $current_date="";
    $titre="";
    $consigne="";
    $lieu="";
	$coequipiers="";
    $vehicule="";
    $position=0;
    $color="#FFFFFF";
    while (($plannings_eq_array[$position]->current_time<=date_number_to_en($i).":00") && ($position<count($plannings_eq_array)))
    {
      if ($plannings_eq_array[$position]->current_time==date_number_to_en($i).":00")
      {
        $id_activite=$plannings_eq_array[$position]->id_activite;
        $titre=$plannings_eq_array[$position]->titre_activite;
        $consigne=$plannings_eq_array[$position]->consigne_activite;
        $lieu=$plannings_eq_array[$position]->nom_lieu;
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

    if (($id_activite_array[$k]==$id_activite) && ($id_activite!=""))
    {
      $current_date="";
      $titre="";
      $consigne="";
      $lieu="";
      $vehicule="";
	  $coequipiers="";
    }
    else
    {
      $html_array[$j]="<TABLE WIDTH=\"100%\" CELLSPACING=\"0\" CELLPADDING=\"3\">";
      if (substr($i,0,8)!=$current_day)
      {
        $current_day=substr($i,0,8);
        $html_array[$j]=$html_array[$j]."<TR><TD WIDTH=\"1%\" COLSPAN=\"2\" ALIGN=\"center\" nowrap><B>".substr(date_number_to_fr($i),0,10)."</B></TD></TR>";
      }
      else
      {
        $html_array[$j]=$html_array[$j]."<TR><TD WIDTH=\"1%\" COLSPAN=\"2\" nowrap>&nbsp;</TD></TR>";
      }

      $current_date=substr(date_number_to_fr($i),11,5);
      if ($titre=="") $titre="Pause";
      if ($consigne=="") $consigne="<U>R&egrave;gles :</U> rien...";
      else $consigne="<U>R&egrave;gles :</U> ".$consigne;
      if ($titre=="Pause") $color="#CCCCCC";
      if ($lieu!="") $lieu="<BR><U>Lieu :</U> ".$lieu;
	  if ($coequipiers!="") $coequipiers="<BR><U>Contre qui tu joues :</U> ".$coequipiers;
      if ($vehicule!="") $vehicule="<BR><U>V&eacute;hicule :</U> ".$vehicule;

      $html_array[$j]=$html_array[$j]."<TR><TD BGCOLOR=\"".$color."\" WIDTH=\"1%\" nowrap>".$current_date."</TD><TD BGCOLOR=\"".$color."\" nowrap><B>".$titre."</B></TD></TR>";
      
  	  if($_SESSION["session_login"]=="cowei" && $_SESSION["session_db_name"]=="planning_wei2004") {
	  	//WEI 2004 : otage des coéquipier
			//Manger ou Baignade
			if($id_activite==13 || $id_activite==23){
		    	$html_array[$j]=$html_array[$j]."<TR><TD BGCOLOR=\"".$color."\" WIDTH=\"1%\" COLSPAN=\"2\">".str_replace("\r\n","<BR>",$consigne).$lieu.$vehicule."</TD></TR>";
			} else {
		    	$html_array[$j]=$html_array[$j]."<TR><TD BGCOLOR=\"".$color."\" WIDTH=\"1%\" COLSPAN=\"2\">".str_replace("\r\n","<BR>",$consigne).$lieu.$coequipiers.$vehicule."</TD></TR>";	  
			}
	  } else {
		  $html_array[$j]=$html_array[$j]."<TR><TD BGCOLOR=\"".$color."\" WIDTH=\"1%\" COLSPAN=\"2\">".str_replace("\r\n","<BR>",$consigne).$lieu.$coequipiers.$vehicule."</TD></TR>";	  
	  }
      $html_array[$j]=$html_array[$j]."</TABLE>";

      $j++;
    }

    $id_activite_array[$k]=$id_activite;
    $k++;
  }

  $imax=floor(count($html_array)/4);
  if ($imax!=count($html_array)/4) $imax++;
  for ($i=0;$i<$imax;$i++)
  {
    $j=0;
?>


        <TR>

<?
    while ($j<4)
    {
?>

          <TD valign="top" width="<? print($largeur); ?>%">
            <? print($html_array[$i+$j*$imax]); ?>
          </TD>
          <TD width="1%" bgcolor="#000000">&nbsp;</TD>

<?
      $j++;
    }
?>

        </TR>

<?
  }
  $fin=test_time($end_time_loop+15);
?>

      </TABLE>
      <B>Fin des activit&eacute;s : <? print(date_number_to_fr($fin)); ?></B>
    </TD>
  </TR>
</TABLE>

</BODY>
</HTML>