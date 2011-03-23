<?
// FONCTIONS POUR LES DATES
  
  function timestamp_extract($string)
  	{
  	$tableau_donnees = array();
  	$donnees = explode(" ", $string);
  	$donnees_date = $donnees[0]; $donnees_heure = $donnees[1];
  	$date = explode("-", $donnees_date); $heure = explode(':', $donnees_heure);
  	$tableau_donnees['jour'] = $date[2];
  	$tableau_donnees['mois'] = $date[1];
  	$tableau_donnees['annee'] = $date[0];
	$tableau_donnees['heure'] = $heure[0];
  	$tableau_donnees['minutes'] = $heure[1];

  	return mktime ($tableau_donnees['heure'],$tableau_donnees['minutes'],0,$tableau_donnees['mois'],$tableau_donnees['jour'],$tableau_donnees['annee']);
  	}
  
  function date_en_to_fr($date_en)
  {
    $date_fr=substr($date_en,8,2)."-".substr($date_en,5,2)."-".substr($date_en,0,4)." ".substr($date_en,11,8);
    return $date_fr;
  }

  function date_fr_to_en($date_fr)
  {
    $date_en=substr($date_fr,6,4)."-".substr($date_fr,3,2)."-".substr($date_fr,0,2)." ".substr($date_fr,11,8);
    return $date_en;
  }

  function date_en_to_number($date_en)
  {
    $date_number=substr($date_en,0,4).substr($date_en,5,2).substr($date_en,8,2).substr($date_en,11,2).substr($date_en,14,2);
    return $date_number;
  }

  function date_fr_to_number($date_fr)
  {
    $date_number=substr($date_fr,6,4).substr($date_fr,3,2).substr($date_fr,0,2).substr($date_fr,11,2).substr($date_fr,14,2);
    return $date_number;
  }

  function date_number_to_fr($date_number)
  {
    $date_fr=substr($date_number,6,2)."-".substr($date_number,4,2)."-".substr($date_number,0,4)." ".substr($date_number,8,2).":".substr($date_number,10,2);
    return $date_fr;
  }

  function date_number_to_en($date_number)
  {
    $date_en=substr($date_number,0,4)."-".substr($date_number,4,2)."-".substr($date_number,6,2)." ".substr($date_number,8,2).":".substr($date_number,10,2);
    return $date_en;
  }

  function date_fr_with_day($date_fr)
  {
    $month=substr($date_fr,3,2);
	$day=substr($date_fr,0,2);
	$year=substr($date_fr,6,4);
    $date_with_day=date("D",mktime(0,0,0,$month,$day,$year));
    switch ($date_with_day)
    {
      case "Mon":
	  $date_with_day="Lundi";
	  break;
      case "Tue":
	  $date_with_day="Mardi";
	  break;
      case "Wed":
	  $date_with_day="Mercredi";
	  break;
      case "Thu":
	  $date_with_day="Jeudi";
	  break;
      case "Fri":
	  $date_with_day="Vendredi";
	  break;
      case "Sat":
	  $date_with_day="Samedi";
	  break;
      case "Sun":
	  $date_with_day="Dimanche";
	  break;
	}

	return $date_with_day." ".$date_fr;
  }

  function list_to_begin_plage($date_en)
  {
    $begin_plage=date_en_to_fr(substr($date_en,0,16));
	return $begin_plage;
  }

  function list_to_end_plage($date_en)
  {
    $end_plage=date_en_to_fr(substr($date_en,17,16));
	return $end_plage;
  }
  
  function list_days_between($begin_date,$end_date)
  {
    $begin_date=$begin_date." 00:00";
	$begin_date=date_fr_to_number($begin_date);
	$current_date=$begin_date;
    $end_date=$end_date." 00:00";
	$end_date=date_fr_to_number($end_date);
    $return_list=array();
	
	while ($current_date<$end_date)
	{
	  $current_date=$current_date+10000;
	  if ($current_date==$end_date) break;
	  else  $return_list[count($return_list)]=substr(date_number_to_fr($current_date),0,10);
	}
	return $return_list;
  }

  function test_time($time_to_test)
  {
    $time_tested=$time_to_test;
//manque changement de mois et d'année
    if (substr($time_to_test,8,4)=="2360") $time_tested=$time_tested+7640;
    else if (substr($time_to_test,8,2)>=24) $time_tested=$time_tested+7600;
    else if (substr($time_to_test,10,2)=="60") $time_tested=$time_tested+40;
    else if (substr($time_to_test,10,2)=="85") $time_tested=$time_tested-40;
    return $time_tested;
  }

  function ajoute_quart($date,$nb_quart)
  {
    for ($i=0;$i<$nb_quart;$i++)
    {
      $date=$date+15;
      $date=test_time($date);
    }
    return $date;
  }

  function enleve_quart($date,$nb_quart)
  {
    for ($i=0;$i<$nb_quart;$i++)
    {
      $date=$date-15;
      $date=test_time($date);
    }
    return $date;
  }

  function difference_quart($end_time,$begin_time)
  {
    $result=0;
    for ($i=$begin_time;$i<=$end_time;$i=$i+15)
    {
      $i=test_time($i);
      $result++;
    }
    return $result;
  }

  function difference($end_time,$begin_time)
  {
    $result=200201010000;
    for ($i=$begin_time;$i<=$end_time;$i=$i+15)
    {
      $i=test_time($i);
      $result=$result+15;
      $result=test_time($result);
    }
    return $result;
  }


// FONCTIONS POUR LES IMAGES
  function make_img($nb)
  {
//    header("content-type: image/gif");
	$img=ImageCreate(15,15);
	
	$blanc=ImageColorAllocate($img,255,255,255);
	$noir=ImageColorAllocate($img,0,0,0);
	$start_x=15-(strlen($nb)*ImageFontWidth(5)/2);
	$start_y=15-ImageFontHeight(5)/2;
	
	ImageString($img,5,$start_x,$start_y,$nb,$noir);
	ImageGIF($img);
	ImageDestroy($img);
  }


// FONCTIONS POUR LES REQUETES
  //ajouter par pierre octobre 2004 ***************************************************************************************
  function result_fournisseurs($req)
  {
    $result_array=array();
    $i=0;
    while ($data = @mysql_fetch_array($req))
    {
      $current_fournisseur=new fournisseur($data);
      $result_array[$i]=$current_fournisseur;
      $i++;
    }
    return $result_array;
  }
  
  function result_materiels($req)
  {
    $result_array=array();
    $i=0;
    while ($data = @mysql_fetch_array($req)) 
    {
      $current_materiel=new materiel($data);
      $result_array[$i]=$current_materiel;
      $i++;
    }
    return $result_array;
  }
  
  //fin de l'ajout *********************************************************************************************************
  function result_orgas($req)
  {
    $result_array=array();
    $i=0;
    while ($data = @mysql_fetch_array($req))
    {
      $current_orga=new orga($data);
      $result_array[$i]=$current_orga;
      $i++;
    }
    return $result_array;
  }

  function result_vehicules($req)
  {
    $result_array=array();
    $i=0;
    while ($data = @mysql_fetch_array($req)) 
    {
      $current_vehicule=new vehicule($data);
      $result_array[$i]=$current_vehicule;
      $i++;
    }
    return $result_array;
  }

  function result_lieux($req)
  {
    $result_array=array();
    $i=0;
    while ($data = @mysql_fetch_array($req)) 
    {
      $current_lieu=new lieu($data);
      $result_array[$i]=$current_lieu;
      $i++;
    }
    return $result_array;
  }

  function result_talkies($req)
  {
    $result_array=array();
    $i=0;
    while ($data = @mysql_fetch_array($req)) 
    {
      $current_talkie=new talkie($data);
      $result_array[$i]=$current_talkie;
      $i++;
    }
    return $result_array;
  }

  function result_categories($req)
  {
    $result_array=array();
    $i=0;
    while ($data = @mysql_fetch_array($req)) 
    {
      $current_categorie=new categorie($data);
      $result_array[$i]=$current_categorie;
      $i++;
    }
    return $result_array;
  }

  function result_taches($req)
  {
    $result_array=array();
    $i=0;
    while ($data = @mysql_fetch_array($req)) 
    {
      $current_tache=new tache($data);
      $result_array[$i]=$current_tache;
      $i++;
    }
    return $result_array;
  }

  function result_plannings($req)
  {
    $result_array=array();
    $i=0;
    while ($data = @mysql_fetch_array($req)) 
    {
      $current_planning=new planning($data);
      $result_array[$i]=$current_planning;
      $i++;
    }
    return $result_array;
  }

  function result_equipes($req)
  {
    $result_array=array();
    $i=0;
    while ($data = @mysql_fetch_array($req)) 
    {
      $current_equipe=new equipe($data);
      $result_array[$i]=$current_equipe;
      $i++;
    }
    return $result_array;
  }

  function result_activites($req)
  {
    $result_array=array();
    $i=0;
    while ($data = @mysql_fetch_array($req)) 
    {
      $current_activite=new activite($data);
      $result_array[$i]=$current_activite;
      $i++;
    }
    return $result_array;
  }

  function result_plannings_eq($req)
  {
    $result_array=array();
    $i=0;
    while ($data = @mysql_fetch_array($req)) 
    {
      $current_planning_eq=new planning_eq($data);
      $result_array[$i]=$current_planning_eq;
      $i++;
    }
    return $result_array;
  }

  function result_users($req)
  {
    $result_array=array();
    $i=0;
    while ($data = @mysql_fetch_array($req)) 
    {
      $current_user=new user($data);
      $result_array[$i]=$current_user;
      $i++;
    }
    return $result_array;
  }
?>
