<?
  session_start();

  $session_login = $_SESSION['session_login'];
  $session_db_name = $_SESSION['session_db_name'];
  

  define(DISPLAY_REQ,"no");

  define(WRITE_LOG,"yes");
  define(LOGIN_LOG,$session_login);
  define(DB_NAME_LOG,$session_db_name);
  
  isset($_GET['db_action']) ? $db_action = $_GET['db_action'] : $db_action = ""; 

// FONCTIONS POUR LES DATES
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

  function date_number_to_en($date_number)
  {
    $date_en=substr($date_number,0,4)."-".substr($date_number,4,2)."-".substr($date_number,6,2)." ".substr($date_number,8,2).":".substr($date_number,10,2);
    return $date_en;
  }

  function ajout_sec($date)
  {
    $date=$date.":00";
    return $date;
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

  function test_time($time_to_test)
  {
    $time_tested=$time_to_test;
//manque changement de mois et d'ann?e
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


// FONCTIONS REQUETES
// Attention, mathieu le SGM a rajouté la fonction qui fait mourir la fonction (gné) lorsque quelque chose ne se passe pas bien :)
// C'est juste le Die.
  function send_req_sql($req_sql,$test)
  {
	write_log($req_sql,"request");
	
	if (DISPLAY_REQ=="yes") print("<BR>".$req_sql);
    if ($test=="no") $req = mysql_query($req_sql) or die ('Le SGM de service trouve que ce code est très mauvais. Enleve les apostrophes et fais un bisous à ton Trez.') ;
    else if (DISPLAY_REQ!="yes") $req = mysql_query($req_sql) or die ('Le SGM de service trouve que ce code est très mauvais. Enleve les apostrophes et fais un bisous à ton Trez.') ;
	return $req;
  }
  
// FONCTIONS LOGS
  function write_log($text,$type)
  {
    if (WRITE_LOG=="yes")
	{
      $filename="log_req/logs.txt";
      if ($type=="access") $result="\r\n".date('d-m-Y H:i')." par ".LOGIN_LOG." sur ".DB_NAME_LOG." pour ".$text."\r\n";
	  if ($type=="request") $result=$text."\r\n";

      $fp = fopen($filename,"a");
      fputs($fp,$result);
      fclose($fp);
	}
  }

// FONCTIONS AFFICHAGE
  function display_page($url)
  {
	if (DISPLAY_REQ=="yes") print("<P>REDIRECTION VERS ".$url);
    if (DISPLAY_REQ!="yes") header('location: '.$url);
  }
  

// FONCTIONS MAIL
  function envoi_mail($nom_exp,$mail_exp,$dest,$sujet,$texte,$type)
  {
    $headers="MIME-Version: 1.0\r\n"; 
    $headers=$headers."Content-type: text/".$type."; charset=iso-8859-1\r\n"; 
    $headers=$headers."From: ".$nom_exp." <".$mail_exp.">\r\n";
    $list_dest=explode(",",$dest);
	$headers_dest="";
	for ($i=0;$i<count($list_dest);$i++)
	{
	  if ($headers_dest!="") $headers_dest=$headers_dest.",";
	  $headers_dest=$headers_dest.$list_dest[$i]." <".$list_dest[$i].">";
	}
    $headers=$headers."To: ".$headers_dest."\r\n"; 
    $headers=$headers."Reply-To: ".$nom_exp." <".$mail_exp.">\r\n";
	
	if ($display_req!="oui")
	{
	  if (mail($dest,$sujet,$texte,$headers)) return true;
	  else return false;
	}
	else print("mail(".$dest.",".$sujet.",".$texte.",".$headers.")");
  }
  

  if (!(strpos($session_db_name, "planning")===FALSE))
  {
    write_log($db_action,"access");
	
	include('connect_db.php');

    $global_begin_date="";
    $global_end_date="";
    $req_select=send_req_sql("SELECT * FROM dates ORDER BY id_date","no");
    while ($data = mysql_fetch_array($req_select)) 
    {
      if ($data['id_date']==1) $global_begin_date=substr($data['valeur'],0,16);
      if ($data['id_date']==2) $global_end_date=substr($data['valeur'],0,16);
    }
	
    switch($db_action)
    {  
      case insert_fournisseur:
	  	// R?cup?ration des variables
		isset($_POST['name']) ? $name = $_POST['name'] : $name = ""; 
		isset($_POST['contact']) ? $contact = $_POST['contact'] : $contact = ""; 
		isset($_POST['email']) ? $email = $_POST['email'] : $email = ""; 
		isset($_POST['mail_adress']) ? $mail_adress = $_POST['mail_adress'] : $mail_adress = ""; 
		isset($_POST['phone_number']) ? $phone_number = $_POST['phone_number'] : $phone_number = ""; 
		isset($_POST['commentaire']) ? $commentaire = $_POST['commentaire'] : $commentaire = ""; 
		isset($_POST['fax_number']) ? $fax_number = $_POST['fax_number'] : $fax_number = ""; 
		
        if (DISPLAY_REQ=="yes") print("<BR>ON EST DANS insert_fournisseur");
        $req_insert=send_req_sql("INSERT INTO fournisseurs (name, contact, email, mail_adress, phone_number, commentaire, fax_number) VALUES ('".$name."', '".$contact."', '".$email."', '".$mail_adress."', '".$phone_number."', '".$commentaire."', '".$fax_number."')","yes");
		display_page("main.php?file=fournisseurs&action=ajout");
        break;
		
	  case insert_materiel:
		// R?cup?ration des variables
		isset($_POST['nom_materiel']) ? $nom_materiel = $_POST['nom_materiel'] : $nom_materiel = ""; 
		isset($_POST['valeur_materiel']) ? $valeur_materiel = $_POST['valeur_materiel'] : $valeur_materiel = ""; 
		isset($_POST['id_categorie']) ? $id_categorie = $_POST['id_categorie'] : $id_categorie = ""; 
		isset($_POST['quantite']) ? $quantite = $_POST['quantite'] : $quantite = ""; 
		isset($_POST['id_fournisseur']) ? $id_fournisseur = $_POST['id_fournisseur'] : $id_fournisseur = ""; 
		isset($_POST['commande']) ? $commande = $_POST['commande'] : $commande = ""; 
		isset($_POST['reception']) ? $reception = $_POST['reception'] : $reception = ""; 
		isset($_POST['id_lieu']) ? $id_lieu = $_POST['id_lieu'] : $id_lieu = ""; 
		isset($_POST['retour']) ? $retour = $_POST['retour'] : $retour = ""; 
		isset($_POST['utilisation']) ? $utilisation = $_POST['utilisation'] : $utilisation = ""; 
		isset($_POST['id_lieu_before']) ? $id_lieu_before = $_POST['id_lieu_before'] : $id_lieu_before = ""; 
		
        if (DISPLAY_REQ=="yes") print("<BR>ON EST DANS insert_materiel");
        $req_insert=send_req_sql("INSERT INTO materiels (nom_materiel, valeur_materiel, id_categorie, quantite, id_fournisseur, commande, reception, id_lieu, retour, utilisation,id_lieu_before) VALUES ('".$nom_materiel."', '".$valeur_materiel."', '".$id_categorie."', '".$quantite."', '".$id_fournisseur."', '".$commande."', '".$reception."', '".$id_lieu."', '".$retour."', '".$utilisation."', '".$id_lieu_before."')","yes");
		display_page("main.php?file=materiels&action=ajout");
        break;
		
	  case update_fournisseur:
	 	// R?cup?ration des variables
		isset($_POST['name']) ? $name = $_POST['name'] : $name = ""; 
		isset($_POST['contact']) ? $contact = $_POST['contact'] : $contact = ""; 
		isset($_POST['email']) ? $email = $_POST['email'] : $email = ""; 
		isset($_POST['mail_adress']) ? $mail_adress = $_POST['mail_adress'] : $mail_adress = ""; 
		isset($_POST['phone_number']) ? $phone_number = $_POST['phone_number'] : $phone_number = ""; 
		isset($_POST['commentaire']) ? $commentaire = $_POST['commentaire'] : $commentaire = ""; 
		isset($_POST['fax_number']) ? $fax_number = $_POST['fax_number'] : $fax_number = "";  
		isset($_POST['id_fournisseur']) ? $id_fournisseur = $_POST['id_fournisseur'] : $id_fournisseur = "";
		isset($_POST['potes']) ? $potes = $_POST['potes'] : $potes = "";
		
        if (DISPLAY_REQ=="yes") print("<BR>ON EST DANS update_fournisseur");
        $req_update=send_req_sql("UPDATE fournisseurs SET name='".$name."', contact='".$contact."', email='".$email."', mail_adress='".$mail_adress."',phone_number='".$phone_number."',commentaire='".$commentaire."',fax_number='".$fax_number."' WHERE id_fournisseur='".$id_fournisseur."'","yes");
        display_page("main.php?file=fournisseurs&action=alpha");
        break;
		
	  case update_materiel:
	  	// R?cup?ration des variables
		isset($_POST['nom_materiel']) ? $nom_materiel = $_POST['nom_materiel'] : $nom_materiel = ""; 
		isset($_POST['valeur_materiel']) ? $valeur_materiel = $_POST['valeur_materiel'] : $valeur_materiel = ""; 
		isset($_POST['id_categorie']) ? $id_categorie = $_POST['id_categorie'] : $id_categorie = ""; 
		isset($_POST['quantite']) ? $quantite = $_POST['quantite'] : $quantite = ""; 
		isset($_POST['id_fournisseur']) ? $id_fournisseur = $_POST['id_fournisseur'] : $id_fournisseur = ""; 
		isset($_POST['commande']) ? $commande = $_POST['commande'] : $commande = ""; 
		isset($_POST['reception']) ? $reception = $_POST['reception'] : $reception = ""; 
		isset($_POST['id_lieu']) ? $id_lieu = $_POST['id_lieu'] : $id_lieu = ""; 
		isset($_POST['retour']) ? $retour = $_POST['retour'] : $retour = ""; 
		isset($_POST['utilisation']) ? $utilisation = $_POST['utilisation'] : $utilisation = ""; 
		isset($_POST['id_lieu_before']) ? $id_lieu_before = $_POST['id_lieu_before'] : $id_lieu_before = "";
		isset($_POST['id_materiel']) ? $id_materiel = $_POST['id_materiel'] : $id_materiel = "";
		
        if (DISPLAY_REQ=="yes") print("<BR>ON EST DANS update_materiel");
        $req_update=send_req_sql("UPDATE materiels SET nom_materiel='".$nom_materiel."', valeur_materiel='".$valeur_materiel."', id_categorie='".$id_categorie."', quantite='".$quantite."',id_fournisseur='".$id_fournisseur."', commande='".$commande."', reception='".$reception."', id_lieu='".$id_lieu."', retour='".$retour."', utilisation='".$utilisation."', id_lieu_before='".$id_lieu_before."' WHERE id_materiel='".$id_materiel."'","yes");
        display_page("main.php?file=materiels&action=alpha");
        break;
		
	  case delete_fournisseur:
	    // R?cup?ration des variables
	  	isset($_POST['id_fournisseur']) ? $id_fournisseur = $_POST['id_fournisseur'] : $id_fournisseur = "";
		
        if (DISPLAY_REQ=="yes") print("<BR>ON EST DANS delete_categorie");

        $req_update=send_req_sql("UPDATE materiels SET id_fournisseur='0' WHERE id_fournisseur='".$id_fournisseur."'","yes");
        $req_delete=send_req_sql("DELETE FROM fournisseurs WHERE id_fournisseur='".$id_fournisseur."'","yes");
        display_page("main.php?file=fournisseurs&action=alpha");
        break;
		
	  case delete_materiel:
	    // R?cup?ration des variables
		isset($_POST['id_materiel']) ? $id_materiel = $_POST['id_materiel'] : $id_materiel = "";
	
        if (DISPLAY_REQ=="yes") print("<BR>ON EST DANS delete_categorie");
        $req_delete=send_req_sql("DELETE FROM materiels WHERE id_materiel='".$id_materiel."'","yes");
        display_page("main.php?file=materiels&action=alpha");
        break;
		//fin de l'ajout*/
			
      case insert_orga:
	    // R?cup?ration des variables
		isset($_POST['first_name']) ? $first_name = $_POST['first_name'] : $first_name = "";
		isset($_POST['last_name']) ? $last_name = $_POST['last_name'] : $last_name = "";
		isset($_POST['email']) ? $email = $_POST['email'] : $email = "";
		isset($_POST['mail_adress']) ? $mail_adress = $_POST['mail_adress'] : $mail_adress = "";
		isset($_POST['phone_number']) ? $phone_number = $_POST['phone_number'] : $phone_number = "";
		isset($_POST['begin_time']) ? $begin_time = $_POST['begin_time'] : $begin_time = "";
		isset($_POST['end_time']) ? $end_time = $_POST['end_time'] : $end_time = "";
		isset($_POST['id_categorie']) ? $id_categorie = $_POST['id_categorie'] : $id_categorie = "";
		isset($_POST['nb_plages']) ? $nb_plages = $_POST['nb_plages'] : $nb_plages = "";
		isset($_POST['ajout_plage']) ? $ajout_plage = $_POST['ajout_plage'] : $ajout_plage = "";
		isset($_POST['potes']) ? $potes = $_POST['potes'] : $potes = "";

	
		
        if (DISPLAY_REQ=="yes") print("<BR>ON EST DANS insert_orga");

        $begin_time=date_fr_to_en($begin_time);
        $end_time=date_fr_to_en($end_time);
		$plages="|";
		for ($i=0;$i<$nb_plages;$i++)
		{
		  $begin_plage="begin_plage_".$i;
		  $end_plage="end_plage_".$i;
		  isset($_POST[$begin_plage]) ? $$begin_plage = $_POST[$begin_plage] : $$begin_plage = "";
		  isset($_POST[$end_plage]) ? $$end_plage = $_POST[$end_plage] : $$end_plage = "";
		  $plages=$plages.date_fr_to_en($$begin_plage).",".date_fr_to_en($$end_plage)."|";
		}
		if ($ajout_plage=="yes") $plages=$plages.$end_time.",".$global_end_date."|";
        $begin_time=ajout_sec($begin_time);
        $end_time=ajout_sec($end_time);

        $req_insert=send_req_sql("INSERT INTO orgas (first_name, last_name, email, mail_adress, phone_number, begin_time, end_time, plages, id_categorie, potes) VALUES ('".$first_name."', '".$last_name."', '".$email."', '".$mail_adress."', '".$phone_number."', '".$begin_time."', '".$end_time."', '".$plages."', '".$id_categorie."', '".$potes."')","yes");
		if ($ajout_plage=="yes")
		{
		  $id_orga_new="";
          $req_select=send_req_sql("SELECT id_orga FROM orgas WHERE first_name='".$first_name."' AND last_name='".$last_name."' AND email='".$email."' AND mail_adress='".$mail_adress."'","no");
          while ($data = mysql_fetch_array($req_select)) 
	      {
		    $id_orga_new=$data['id_orga'];
	      }
          display_page("main.php?file=orgas&action=modify&id_orga=".$id_orga_new);
		}
		else display_page("main.php?file=orgas&action=ajout");
        break;

      case update_orga:
	    // R?cup?ration des variables
	    isset($_POST['id_categorie']) ? $id_categorie = $_POST['id_categorie'] : $id_categorie = "";
		isset($_POST['first_name']) ? $first_name = $_POST['first_name'] : $first_name = "";
		isset($_POST['last_name']) ? $last_name = $_POST['last_name'] : $last_name = "";
		isset($_POST['email']) ? $email = $_POST['email'] : $email = "";
		isset($_POST['mail_adress']) ? $mail_adress = $_POST['mail_adress'] : $mail_adress = "";
		isset($_POST['phone_number']) ? $phone_number = $_POST['phone_number'] : $phone_number = "";
		isset($_POST['begin_time']) ? $begin_time = $_POST['begin_time'] : $begin_time = "";
		isset($_POST['end_time']) ? $end_time = $_POST['end_time'] : $end_time = "";
		isset($_POST['id_orga']) ? $id_orga = $_POST['id_orga'] : $id_orga = "";
		isset($_POST['nb_plages']) ? $nb_plages = $_POST['nb_plages'] : $nb_plages = "";
		isset($_POST['ajout_plage']) ? $ajout_plage = $_POST['ajout_plage'] : $ajout_plage = "";
		isset($_POST['suppr_plage']) ? $suppr_plage = $_POST['suppr_plage'] : $suppr_plage = "";
		isset($_POST['id_suppr_plage']) ? $id_suppr_plage = $_POST['id_suppr_plage'] : $id_suppr_plage = "";
		isset($_POST['potes']) ? $potes = $_POST['potes'] : $potes = "";		
		isset($_POST['maj']) ? $maj = $_POST['maj'] : $maj = "";		
		
        if (DISPLAY_REQ=="yes") print("<BR>ON EST DANS update_orga");

		$plages="|";
		$begin_time="";
		$end_time="";
		for ($i=0;$i<$nb_plages;$i++)
		{
		  if ($id_suppr_plage!="".$i)
		  {
		    $begin_plage="begin_plage_".$i;
		    $end_plage="end_plage_".$i;
		    isset($_POST[$begin_plage]) ? $$begin_plage = $_POST[$begin_plage] : $$begin_plage = "";
		    isset($_POST[$end_plage]) ? $$end_plage = $_POST[$end_plage] : $$end_plage = "";
		    if ((date_fr_to_en($$begin_plage)<$begin_time) || ($begin_time=="")) $begin_time=date_fr_to_en($$begin_plage);
		    if ((date_fr_to_en($$end_plage)>$end_time) || ($end_time=="")) $end_time=date_fr_to_en($$end_plage);
		    $plages=$plages.date_fr_to_en($$begin_plage).",".date_fr_to_en($$end_plage)."|";
		  }
		}
		if ($ajout_plage=="yes") $plages=$plages.$end_time.",".$global_end_date."|";
		$begin_time=ajout_sec($begin_time);
		$end_time=ajout_sec($end_time);

// CLASSER LES PLAGES

        $list_plages=explode("|",$plages);
	    sort($list_plages);
    	$nb_plages=count($list_plages)-2;
	    $plages="|";
        for ($j=0;$j<$nb_plages;$j++)
	    {
	      $plages=$plages.$list_plages[$j+2]."|";
	    }

// ENLEVER PLUTOT LES 2 PREMIERS ENREGISTREMENTS DU TABLEAU

    	$nb_plages=count($list_plages)-2;
        for ($j=0;$j<$nb_plages;$j++)
	    {

        if ($j==0)
		{
		$req_select=send_req_sql("SELECT * FROM plannings WHERE id_orga LIKE '%|".$id_orga."|%' AND `current_time`<'".date_fr_to_en(list_to_begin_plage($list_plages[$j+2]).":00")."'","no");
        while ($data = mysql_fetch_array($req_select)) 
	    {
  	      $current_time_delete=$data['current_time'];
	 	  $id_tache_delete=$data['id_tache'];
		  $id_orga_delete=$data['id_orga'];
          $req_update=send_req_sql("UPDATE plannings SET id_orga='".str_replace("|".$id_orga."|","|",$id_orga_delete)."' WHERE `current_time`='".$current_time_delete."' AND id_tache='".$id_tache_delete."'","yes");

          $req_delete=send_req_sql("DELETE FROM plannings WHERE `current_time`='".$current_time_delete."' AND id_orga='|'","yes");
	    }
		}

        if ($list_plages[$j+3]!="")
		{
		$req_select=send_req_sql("SELECT * FROM plannings WHERE id_orga LIKE '%|".$id_orga."|%' AND `current_time`>='".date_fr_to_en(list_to_end_plage($list_plages[$j+2]).":00")."' AND `current_time`<'".date_fr_to_en(list_to_begin_plage($list_plages[$j+3]).":00")."'","no");
        while ($data = mysql_fetch_array($req_select)) 
	    {
  	      $current_time_delete=$data['current_time'];
	 	  $id_tache_delete=$data['id_tache'];
		  $id_orga_delete=$data['id_orga'];
          $req_update=send_req_sql("UPDATE plannings SET id_orga='".str_replace("|".$id_orga."|","|",$id_orga_delete)."' WHERE `current_time`='".$current_time_delete."' AND id_tache='".$id_tache_delete."'","yes");

          $req_delete=send_req_sql("DELETE FROM plannings WHERE `current_time`='".$current_time_delete."' AND id_orga='|'","yes");
	    }
		}

        if ($j==$nb_plages-1)
		{
		$req_select=send_req_sql("SELECT * FROM plannings WHERE id_orga LIKE '%|".$id_orga."|%' AND `current_time`>='".date_fr_to_en(list_to_end_plage($list_plages[$j+2]).":00")."' AND id_tache='".$id_tache."'","no");
        while ($data = mysql_fetch_array($req_select)) 
	    {
  	      $current_time_delete=$data['current_time'];
	 	  $id_tache_delete=$data['id_tache'];
		  $id_orga_delete=$data['id_orga'];
          $req_update=send_req_sql("UPDATE plannings SET id_orga='".str_replace("|".$id_orga."|","|",$id_orga_delete)."' WHERE `current_time`='".$current_time_delete."' AND id_tache='".$id_tache_delete."'","yes");

          $req_delete=send_req_sql("DELETE FROM plannings WHERE `current_time`='".$current_time_delete."' AND id_orga='|'","yes");
	    }
		}

//	      if ($j==0) $req_delete=send_req_sql("DELETE FROM plannings WHERE `current_time`<'".date_fr_to_en(list_to_begin_plage($list_plages[$j+2]).":00")."' AND id_tache='".$id_tache."'","yes");
//	      if ($list_plages[$j+3]!="") $req_delete=send_req_sql("DELETE FROM plannings WHERE `current_time`>='".date_fr_to_en(list_to_end_plage($list_plages[$j+2]).":00")."' AND `current_time`<'".date_fr_to_en(list_to_begin_plage($list_plages[$j+3]).":00")."' ANDid_tache='".$id_tache."'","yes");
//	      if ($j==$nb_plages-1) $req_delete=send_req_sql("DELETE FROM plannings WHERE `current_time`>='".date_fr_to_en(list_to_end_plage($list_plages[$j+2]).":00")."' AND id_tache='".$id_tache."'","yes");
	    }

        $req_update=send_req_sql("UPDATE orgas SET first_name='".$first_name."', last_name='".$last_name."', email='".$email."', id_categorie='".$id_categorie."', mail_adress='".$mail_adress."', phone_number='".$phone_number."', begin_time='".$begin_time."', end_time='".$end_time."', plages='".$plages."', potes='".$potes."' WHERE id_orga='".$id_orga."'","yes");
	
		if ($maj == 1) display_page("main.php?file=orgas&action=modify&id_orga=".$id_orga);
		else display_page("main.php?file=orgas&action=alpha");
        break;

      case delete_orga:
		// R?cup?ration des variables
		isset($_POST['id_orga']) ? $id_orga = $_POST['id_orga'] : $id_orga = "";
		
        if (DISPLAY_REQ=="yes") print("<BR>ON EST DANS delete_orga");

        $req_update=send_req_sql("UPDATE taches SET id_resp='0' WHERE id_resp='".$id_orga."'","yes");
        $req_select=send_req_sql("SELECT * FROM plannings WHERE id_orga LIKE '%|".$id_orga."|%'","no");
        while ($data = mysql_fetch_array($req_select)) 
	    {
  	      $current_time_delete=$data['current_time'];
	 	  $id_tache_delete=$data['id_tache'];
		  $id_orga_delete=$data['id_orga'];
          $req_update=send_req_sql("UPDATE plannings SET id_orga='".str_replace("|".$id_orga."|","|",$id_orga_delete)."' WHERE `current_time`='".$current_time_delete."' AND id_tache='".$id_tache_delete."'","yes");

          $req_delete=send_req_sql("DELETE FROM plannings WHERE `current_time`='".$current_time_delete."' AND id_orga='|'","yes");
	    }
        $req_delete=send_req_sql("DELETE FROM orgas WHERE id_orga='".$id_orga."'","yes");
        display_page("main.php?file=orgas&action=alpha");
        break;

      case mail_orga:
        // R?cup?ration des variables
		isset($_POST['from_name']) ? $from_name = $_POST['from_name'] : $from_name = "";
		isset($_POST['from_email']) ? $from_email = $_POST['from_email'] : $from_email = "";
		isset($_POST['list_mail']) ? $list_mail = $_POST['list_mail'] : $list_mail = "";
		isset($_POST['sujet']) ? $sujet = $_POST['sujet'] : $sujet = "";
		isset($_POST['texte']) ? $texte = $_POST['texte'] : $texte = "";
      
        if (DISPLAY_REQ=="yes") print("<BR>ON EST DANS mail_orga");

	    if (envoi_mail($from_name,$from_email,$list_mail,$sujet,$texte,"plain")) $msg_mail="ok";
		else $msg_mail="ko";
        display_page("main.php?file=orgas&action=alpha&msg_mail=".$msg_mail);
        break;

      case insert_vehicule:
		// R?cup?ration des variables
		isset($_POST['nom']) ? $nom = $_POST['nom'] : $nom = "";
		
        if (DISPLAY_REQ=="yes") print("<BR>ON EST DANS insert_vehicule");

        $req_insert=send_req_sql("INSERT INTO vehicules (nom_vehicule) VALUES ('".$nom."')","yes");
        display_page("main.php?file=vehicules&action=ajout");
        break;

      case update_vehicule:
		// R?cup?ration des variables
		isset($_POST['nom']) ? $nom = $_POST['nom'] : $nom = "";
		isset($_POST['id_vehicule']) ? $id_vehicule = $_POST['id_vehicule'] : $id_vehicule = "";
	  
        if (DISPLAY_REQ=="yes") print("<BR>ON EST DANS update_vehicule");

        $req_update=send_req_sql("UPDATE vehicules SET nom_vehicule='".$nom."' WHERE id_vehicule='".$id_vehicule."'","yes");
        display_page("main.php?file=vehicules&action=alpha");
        break;

      case delete_vehicule:
		// R?cup?ration des variables
		isset($_POST['id_vehicule']) ? $id_vehicule = $_POST['id_vehicule'] : $id_vehicule = "";
		
        if (DISPLAY_REQ=="yes") print("<BR>ON EST DANS delete_vehicule");

        $req_update=send_req_sql("UPDATE taches SET id_vehicule='0' WHERE id_vehicule='".$id_vehicule."'","yes");
        $req_update=send_req_sql("UPDATE activites SET id_vehicule='0' WHERE id_vehicule='".$id_vehicule."'","yes");
        $req_delete=send_req_sql("DELETE FROM vehicules WHERE id_vehicule='".$id_vehicule."'","yes");
        display_page("main.php?file=vehicules&action=alpha");
        break;

      case insert_lieu:
	  	// R?cup?ration des variables
		isset($_POST['nom']) ? $nom = $_POST['nom'] : $nom = ""; 
		
        if (DISPLAY_REQ=="yes") print("<BR>ON EST DANS insert_lieu");

        $req_insert=send_req_sql("INSERT INTO lieux (nom_lieu) VALUES ('".$nom."')","yes");
        display_page("main.php?file=lieux&action=ajout");
        break;

      case update_lieu:
		// R?cup?ration des variables
		isset($_POST['nom']) ? $nom = $_POST['nom'] : $nom = ""; 
		isset($_POST['id_lieu']) ? $id_lieu = $_POST['id_lieu'] : $id_lieu = ""; 
		
        if (DISPLAY_REQ=="yes") print("<BR>ON EST DANS update_lieu");

        $req_update=send_req_sql("UPDATE lieux SET nom_lieu='".$nom."' WHERE id_lieu='".$id_lieu."'","yes");
        display_page("main.php?file=lieux&action=alpha");
        break;

      case delete_lieu:
		// R?cup?ration des variables
		isset($_POST['id_lieu']) ? $id_lieu = $_POST['id_lieu'] : $id_lieu = ""; 
		
        if (DISPLAY_REQ=="yes") print("<BR>ON EST DANS delete_lieu");
		$req_update=send_req_sql("UPDATE materiels SET id_lieu='0' WHERE id_lieu='".$id_lieu."'","yes");
        $req_update=send_req_sql("UPDATE taches SET id_lieu='0' WHERE id_lieu='".$id_lieu."'","yes");
        $req_update=send_req_sql("UPDATE activites SET id_lieu='0' WHERE id_lieu='".$id_lieu."'","yes");
        $req_delete=send_req_sql("DELETE FROM lieux WHERE id_lieu='".$id_lieu."'","yes");
        display_page("main.php?file=lieux&action=alpha");
        break;

      case insert_talkie:
	  	// R?cup?ration des variables
		isset($_POST['nom']) ? $nom = $_POST['nom'] : $nom = "";
		
        if (DISPLAY_REQ=="yes") print("<BR>ON EST DANS insert_talkie");

        $req_insert=send_req_sql("INSERT INTO talkies (nom_talkie) VALUES ('".$nom."')","yes");
        display_page("main.php?file=talkies&action=ajout");
        break;

      case update_talkie:
	  	// R?cup?ration des variables
		isset($_POST['nom']) ? $nom = $_POST['nom'] : $nom = "";
		isset($_POST['id_talkie']) ? $id_talkie = $_POST['id_talkie'] : $id_talkie = "";
		
        if (DISPLAY_REQ=="yes") print("<BR>ON EST DANS update_talkie");

        $req_update=send_req_sql("UPDATE talkies SET nom_talkie='".$nom."' WHERE id_talkie='".$id_talkie."'","yes");
        display_page("main.php?file=talkies&action=alpha");
        break;

      case delete_talkie:
	  	// R?cup?ration des variables
		isset($_POST['id_talkie']) ? $id_talkie = $_POST['id_talkie'] : $id_talkie = "";
		
        if (DISPLAY_REQ=="yes") print("<BR>ON EST DANS delete_talkie");

        $req_update=send_req_sql("UPDATE taches SET id_talkie='0' WHERE id_talkie='".$id_talkie."'","yes");
        $req_update=send_req_sql("DELETE FROM talkies WHERE id_talkie='".$id_talkie."'","yes");
        display_page("main.php?file=talkies&action=alpha");
        break;

      case insert_categorie:
		// R?cup?ration des variables
		isset($_POST['nom']) ? $nom = $_POST['nom'] : $nom = "";
		isset($_POST['type']) ? $type = $_POST['type'] : $type = "";
		isset($_POST['couleur']) ? $couleur = $_POST['couleur'] : $couleur = "";
		
        if (DISPLAY_REQ=="yes") print("<BR>ON EST DANS insert_categorie");
        $req_insert=send_req_sql("INSERT INTO categories (nom_categorie, type_categorie, couleur_categorie) VALUES ('".$nom."','".$type."','".$couleur."')","yes");
        display_page("main.php?file=categories&action=ajout");
        break;

      case update_categorie:
		// R?cup?ration des variables
		isset($_POST['nom']) ? $nom = $_POST['nom'] : $nom = "";
		isset($_POST['type']) ? $type = $_POST['type'] : $type = "";
		isset($_POST['couleur']) ? $couleur = $_POST['couleur'] : $couleur = "";
		isset($_POST['id_categorie']) ? $id_categorie = $_POST['id_categorie'] : $id_categorie = "";
		
        if (DISPLAY_REQ=="yes") print("<BR>ON EST DANS update_categorie");
        $req_update=send_req_sql("UPDATE categories SET nom_categorie='".$nom."',type_categorie='".$type."',couleur_categorie='".$couleur."' WHERE id_categorie='".$id_categorie."'","yes");
        display_page("main.php?file=categories&action=alpha");
        break;

      case delete_categorie:
		// R?cup?ration des variables
		isset($_POST['id_categorie']) ? $id_categorie = $_POST['id_categorie'] : $id_categorie = "";
		
        if (DISPLAY_REQ=="yes") print("<BR>ON EST DANS delete_categorie");
        $req_update=send_req_sql("UPDATE taches SET id_categorie='0' WHERE id_categorie='".$id_categorie."'","yes");
		$req_update=send_req_sql("UPDATE materiels SET id_categorie='0' WHERE id_categorie='".$id_categorie."'","yes");
		$req_update=send_req_sql("UPDATE orgas SET id_categorie='0' WHERE id_categorie='".$id_categorie."'","yes");
        $req_delete=send_req_sql("DELETE FROM categories WHERE id_categorie='".$id_categorie."'","yes");
        display_page("main.php?file=categories&action=alpha");
        break;

      case insert_tache:
		// R?cup?ration des variables
		isset($_POST['titre']) ? $titre = $_POST['titre'] : $titre = "";
		isset($_POST['consigne']) ? $consigne = $_POST['consigne'] : $consigne = "";
		isset($_POST['id_categorie']) ? $id_categorie = $_POST['id_categorie'] : $id_categorie = "";
		isset($_POST['begin_time']) ? $begin_time = $_POST['begin_time'] : $begin_time = "";
		isset($_POST['end_time']) ? $end_time = $_POST['end_time'] : $end_time = "";
		isset($_POST['nb_orgas']) ? $nb_orgas = $_POST['nb_orgas'] : $nb_orgas = "";
		isset($_POST['id_lieu']) ? $id_lieu = $_POST['id_lieu'] : $id_lieu = "";
		isset($_POST['id_vehicule']) ? $id_vehicule = $_POST['id_vehicule'] : $id_vehicule = "";
		isset($_POST['id_resp']) ? $id_resp = $_POST['id_resp'] : $id_resp = "";
		isset($_POST['affect_resp']) ? $affect_resp = $_POST['affect_resp'] : $affect_resp = "";
		isset($_POST['id_talkie']) ? $id_talkie = $_POST['id_talkie'] : $id_talkie = "";
		isset($_POST['matos']) ? $matos = $_POST['matos'] : $matos = "";
		isset($_POST['nb_plages']) ? $nb_plages = $_POST['nb_plages'] : $nb_plages = "";
		isset($_POST['ajout_plage']) ? $ajout_plage = $_POST['ajout_plage'] : $ajout_plage = "";
		
        if (DISPLAY_REQ=="yes") print("<BR>ON EST DANS insert_tache");

        $begin_time=date_fr_to_en($begin_time);
        $end_time=date_fr_to_en($end_time);
		$plages="|";
		for ($i=0;$i<$nb_plages;$i++)
		{
		  $begin_plage="begin_plage_".$i;
		  $end_plage="end_plage_".$i;
		  isset($_POST[$begin_plage]) ? $$begin_plage = $_POST[$begin_plage] : $$begin_plage = "";
		  isset($_POST[$end_plage]) ? $$end_plage = $_POST[$end_plage] : $$end_plage = "";
		  $plages=$plages.date_fr_to_en($$begin_plage).",".date_fr_to_en($$end_plage)."|";
		}
		$end_time_temp=$end_time;
        $begin_time=ajout_sec($begin_time);
        $end_time=ajout_sec($end_time);
        $req_insert=send_req_sql("INSERT INTO taches (titre, consigne, id_categorie, begin_time, end_time, plages, nb_orgas, id_lieu, id_vehicule, id_resp, affect_resp, id_talkie, matos) VALUES ('".$titre."', '".$consigne."', '".$id_categorie."', '".$begin_time."', '".$end_time."', '".$plages."', ".$nb_orgas.", '".$id_lieu."', '".$id_vehicule."', '".$id_resp."', '".$affect_resp."', '".$id_talkie."', '".$matos."')","yes");

	    $id_tache=0;
        $req_select=send_req_sql("SELECT * FROM taches WHERE titre='".$titre."' AND consigne='".$consigne."' AND begin_time='".$begin_time."' AND end_time='".$end_time."' AND id_lieu=".$id_lieu." AND id_resp=".$id_resp,"no");
        while ($data = mysql_fetch_array($req_select)) 
	    {
          $id_tache=$data['id_tache'];
  	    }

	    if ($affect_resp=="yes")
  	    {
          $list_plages=explode("|",$plages);
          $nb_plages=count($list_plages)-2;
          for ($j=0;$j<$nb_plages;$j++)
	      {

 	        $begin_time_loop=date_en_to_number(date_fr_to_en(list_to_begin_plage($list_plages[$j+1])));
	        $end_time_loop=date_en_to_number(date_fr_to_en(list_to_end_plage($list_plages[$j+1])));
            for ($i=$begin_time_loop;$i<=enleve_quart($end_time_loop,1);$i=$i+15)
            {
              $i=test_time($i);
              $current_time=date_number_to_en($i);

              $req_select=send_req_sql("SELECT * FROM plannings WHERE id_orga LIKE '%|".$id_resp."|%' AND `current_time`='".$current_time."'","no");
              while ($data = mysql_fetch_array($req_select)) 
  	          {
	            $current_time_delete=$data['current_time'];
    	  	    $id_tache_delete=$data['id_tache'];
	    	    $id_resp_delete=$data['id_orga'];
                $req_update=send_req_sql("UPDATE plannings SET id_orga='".str_replace($id_resp."|","",$id_resp_delete)."' WHERE `current_time`='".$current_time_delete."' AND id_tache='".$id_tache_delete."'","yes");

                $req_delete=send_req_sql("DELETE FROM plannings WHERE `current_time`='".$current_time_delete."' AND id_orga='|'","yes");
	          }

              $req_select=send_req_sql("SELECT * FROM plannings WHERE `current_time`='".$current_time."' AND `id_tache`='".$id_tache."'","no");
		      if (mysql_numrows($req_select)==0) $req_insert=send_req_sql("INSERT INTO plannings (`current_time`, `id_tache`, `id_orga`) VALUES ('".$current_time."', '".$id_tache."', '|".$id_resp."|')","yes");
		      else
		      {
                while ($data = mysql_fetch_array($req_select)) 
	            {
                  $req_update=send_req_sql("UPDATE plannings SET id_orga='".$data['id_orga'].$id_resp."|' WHERE `current_time`='".$current_time."' AND id_tache='".$id_tache."'","yes");

                  $req_delete=send_req_sql("DELETE FROM plannings WHERE `current_time`='".$current_time_delete."' AND id_orga='|'","yes");
                }
		      }
            }
          }
	    }

		if ($ajout_plage=="yes")
		{
  		  if ($ajout_plage=="yes") $plages=$plages.$end_time_temp.",".$global_end_date."|";
          $req_update=send_req_sql("UPDATE taches SET plages='".$plages."' WHERE id_tache='".$id_tache."'","yes");
          display_page("main.php?file=taches&action=modify&id_tache=".$id_tache);
		}
		else display_page("main.php?file=taches&action=ajout");
        break;

      case update_tache:
		// R?cup?ration des variables
		isset($_POST['titre']) ? $titre = $_POST['titre'] : $titre = "";
		isset($_POST['consigne']) ? $consigne = $_POST['consigne'] : $consigne = "";
		isset($_POST['id_categorie']) ? $id_categorie = $_POST['id_categorie'] : $id_categorie = "";
		isset($_POST['begin_time']) ? $begin_time = $_POST['begin_time'] : $begin_time = "";
		isset($_POST['end_time']) ? $end_time = $_POST['end_time'] : $end_time = "";
		isset($_POST['nb_orgas']) ? $nb_orgas = $_POST['nb_orgas'] : $nb_orgas = "";
		isset($_POST['id_lieu']) ? $id_lieu = $_POST['id_lieu'] : $id_lieu = "";
		isset($_POST['id_vehicule']) ? $id_vehicule = $_POST['id_vehicule'] : $id_vehicule = "";
		isset($_POST['id_resp']) ? $id_resp = $_POST['id_resp'] : $id_resp = "";
		isset($_POST['affect_resp']) ? $affect_resp = $_POST['affect_resp'] : $affect_resp = "";
		isset($_POST['id_talkie']) ? $id_talkie = $_POST['id_talkie'] : $id_talkie = "";
		isset($_POST['matos']) ? $matos = $_POST['matos'] : $matos = "";
		isset($_POST['id_tache']) ? $id_tache = $_POST['id_tache'] : $id_tache = "";
		isset($_POST['nb_plages']) ? $nb_plages = $_POST['nb_plages'] : $nb_plages = "";
		isset($_POST['ajout_plage']) ? $ajout_plage = $_POST['ajout_plage'] : $ajout_plage = "";
		isset($_POST['suppr_plage']) ? $suppr_plage = $_POST['suppr_plage'] : $suppr_plage = "";
		isset($_POST['id_suppr_plage']) ? $id_suppr_plage = $_POST['id_suppr_plage'] : $id_suppr_plage = "";
		
        if (DISPLAY_REQ=="yes") print("<BR>ON EST DANS update_tache");

		$plages="|";
		$begin_time="";
		$end_time="";
		for ($i=0;$i<$nb_plages;$i++)
		{
		  if ($id_suppr_plage!="".$i)
		  {
		    $begin_plage="begin_plage_".$i;
		    $end_plage="end_plage_".$i;
		    isset($_POST[$begin_plage]) ? $$begin_plage = $_POST[$begin_plage] : $$begin_plage = "";
		    isset($_POST[$end_plage]) ? $$end_plage = $_POST[$end_plage] : $$end_plage = "";
		    if ((date_fr_to_en($$begin_plage)<$begin_time) || ($begin_time=="")) $begin_time=date_fr_to_en($$begin_plage);
		    if ((date_fr_to_en($$end_plage)>$end_time) || ($end_time=="")) $end_time=date_fr_to_en($$end_plage);
		    $plages=$plages.date_fr_to_en($$begin_plage).",".date_fr_to_en($$end_plage)."|";
		  }
		}
		if ($ajout_plage=="yes") $plages=$plages.$end_time.",".$global_end_date."|";
		$begin_time=ajout_sec($begin_time);
		$end_time=ajout_sec($end_time);

// CLASSER LES PLAGES

        $list_plages=explode("|",$plages);
	    sort($list_plages);
    	$nb_plages=count($list_plages)-2;
	    $plages="|";
        for ($j=0;$j<$nb_plages;$j++)
	    {
	      $plages=$plages.$list_plages[$j+2]."|";
	    }

// ENLEVER PLUTOT LES 2 PREMIERS ENREGISTREMENTS DU TABLEAU

    	$nb_plages=count($list_plages)-2;
        for ($j=0;$j<$nb_plages;$j++)
	    {
	      if ($j==0) $req_delete=send_req_sql("DELETE FROM plannings WHERE `current_time`<'".date_fr_to_en(list_to_begin_plage($list_plages[$j+2]).":00")."' AND id_tache='".$id_tache."'","yes");
	      if ($list_plages[$j+3]!="") $req_delete=send_req_sql("DELETE FROM plannings WHERE `current_time`>='".date_fr_to_en(list_to_end_plage($list_plages[$j+2]).":00")."' AND `current_time`<'".date_fr_to_en(list_to_begin_plage($list_plages[$j+3]).":00")."' AND id_tache='".$id_tache."'","yes");
	      if ($j==$nb_plages-1) $req_delete=send_req_sql("DELETE FROM plannings WHERE `current_time`>='".date_fr_to_en(list_to_end_plage($list_plages[$j+2]).":00")."' AND id_tache='".$id_tache."'","yes");
	    }

        $req_update=send_req_sql("UPDATE taches SET titre='".$titre."', consigne='".$consigne."', id_categorie='".$id_categorie."', begin_time='".$begin_time."', end_time='".$end_time."', plages='".$plages."', nb_orgas=".$nb_orgas.", id_lieu='".$id_lieu."', id_vehicule='".$id_vehicule."', id_resp='".$id_resp."', affect_resp='".$affect_resp."', id_talkie='".$id_talkie."', matos='".$matos."' WHERE id_tache='".$id_tache."'","yes");

	    if ($affect_resp=="yes")
  	    {
          $list_plages=explode("|",$plages);
          $nb_plages=count($list_plages)-2;
          for ($j=0;$j<$nb_plages;$j++)
	      {

 	        $begin_time_loop=date_en_to_number(date_fr_to_en(list_to_begin_plage($list_plages[$j+1])));
	        $end_time_loop=date_en_to_number(date_fr_to_en(list_to_end_plage($list_plages[$j+1])));
            for ($i=$begin_time_loop;$i<=enleve_quart($end_time_loop,1);$i=$i+15)
            {
              $i=test_time($i);
              $current_time=date_number_to_en($i).":00";

              $req_select=send_req_sql("SELECT * FROM plannings WHERE id_orga LIKE '%|".$id_resp."|%' AND `current_time`='".$current_time."'","no");
              while ($data = mysql_fetch_array($req_select)) 
	          {
	            $current_time_delete=$data['current_time'];
    		    $id_tache_delete=$data['id_tache'];
	            $id_resp_delete=$data['id_orga'];
                $req_update=send_req_sql("UPDATE plannings SET id_orga='".str_replace($id_resp."|","",$id_resp_delete)."' WHERE `current_time`='".$current_time_delete."' AND id_tache='".$id_tache_delete."'","yes");

                $req_delete=send_req_sql("DELETE FROM plannings WHERE `current_time`='".$current_time_delete."' AND id_orga='|'","yes");
	          }

              $req_select=send_req_sql("SELECT * FROM plannings WHERE `current_time`='".$current_time."' AND `id_tache`='".$id_tache."'","no");
		      if (mysql_numrows($req_select)==0) $req_insert=send_req_sql("INSERT INTO plannings (`current_time`, `id_tache`, `id_orga`) VALUES ('".$current_time."', '".$id_tache."', '|".$id_resp."|')","yes");
		      else
		      {
                while ($data = mysql_fetch_array($req_select))
	            {
                  $req_update=send_req_sql("UPDATE plannings SET id_orga='".$data['id_orga'].$id_resp."|' WHERE `current_time`='".$current_time."' AND id_tache='".$id_tache."'","yes");
                }
		      }
            }
		  }
	    }
		if (($ajout_plage=="yes") || ($suppr_plage=="yes")) display_page("main.php?file=taches&action=modify&id_tache=".$id_tache);
		else display_page("main.php?file=taches");
        break;

      case delete_tache:
		// R?cup?ration des variables
		isset($_POST['id_tache']) ? $id_tache = $_POST['id_tache'] : $id_tache = "";
		
        if (DISPLAY_REQ=="yes") print("<BR>ON EST DANS delete_tache");

        $req_delete=send_req_sql("DELETE FROM plannings WHERE id_tache='".$id_tache."'","yes");
        $req_delete=send_req_sql("DELETE FROM taches WHERE id_tache='".$id_tache."'","yes");
        display_page("main.php?file=taches&action=alpha");
        break;

      case update_planning:
		// R?cup?ration des variables
		isset($_POST['id_orga']) ? $id_orga = $_POST['id_orga'] : $id_orga = "";
		isset($_POST['begin_time_loop']) ? $begin_time_loop = $_POST['begin_time_loop'] : $begin_time_loop = "";
		isset($_POST['end_time_loop']) ? $end_time_loop = $_POST['end_time_loop'] : $end_time_loop = "";
		
		isset($_POST['id_orga_new']) ? $id_orga_new = $_POST['id_orga_new'] : $id_orga_new = "";
		isset($_POST['id_day']) ? $id_day = $_POST['id_day'] : $id_day = "";
		
        if (DISPLAY_REQ=="yes") print("<BR>ON EST DANS update_planning");

        for ($i=$begin_time_loop;$i<=$end_time_loop;$i=$i+15)
        {
          $i=test_time($i);
          $current_time="current_time_".$i;
          $titre="titre_".$i;
          $id_tache="id_tache_".$i;
		  isset($_POST[$current_time]) ? $$current_time = $_POST[$current_time] : $$current_time = "";
		  isset($_POST[$titre]) ? $$titre = $_POST[$titre] : $$titre= "";
		  isset($_POST[$id_tache]) ? $$id_tache = $_POST[$id_tache] : $$id_tache= "";

        $req_select=send_req_sql("SELECT * FROM plannings WHERE id_orga LIKE '%|".$id_orga."|%' AND `current_time`='".$$current_time."'","no");
        while ($data = mysql_fetch_array($req_select)) 
  	    {
	      $current_time_delete=$data['current_time'];
		  $id_tache_delete=$data['id_tache'];
	  	  $id_orga_delete=$data['id_orga'];
          $req_update=send_req_sql("UPDATE plannings SET id_orga='".str_replace("|".$id_orga."|","|",$id_orga_delete)."' WHERE `current_time`='".$current_time_delete."' AND id_tache='".$id_tache_delete."'","yes");
          $req_delete=send_req_sql("DELETE FROM plannings WHERE `current_time`='".$current_time_delete."' AND id_tache='".$id_tache_delete."' AND id_orga='|'","yes");
	    }

          if ($$titre!="")
          {
            $req_select=send_req_sql("SELECT * FROM plannings WHERE `current_time`='".$$current_time."' AND `id_tache`='".$$id_tache."'","no");
		    if (mysql_numrows($req_select)==0) $req_insert=send_req_sql("INSERT INTO plannings (`current_time`, `id_tache`, `id_orga`) VALUES ('".$$current_time."', '".$$id_tache."', '|".$id_orga."|')","yes");
		    else
		    {
              while ($data = mysql_fetch_array($req_select)) 
	          {
                $req_update=send_req_sql("UPDATE plannings SET id_orga='".$data['id_orga'].$id_orga."|' WHERE `current_time`='".$$current_time."' AND id_tache='".$$id_tache."'","yes");
              }
		    }
          }
        }
        $req_delete=send_req_sql("DELETE FROM plannings WHERE id_orga='|'","yes");
        display_page("main.php?file=plannings&action=define&id_orga=".$id_orga_new."&id_day=".$id_day);
        break;

      case update_planning_tache:
	  	// R?cup?ration des variables
		isset($_POST['id_tache']) ? $id_tache = $_POST['id_tache'] : $id_tache = "";
		isset($_POST['begin_time_loop']) ? $begin_time_loop = $_POST['begin_time_loop'] : $begin_time_loop = "";
		isset($_POST['end_time_loop']) ? $end_time_loop = $_POST['end_time_loop'] : $end_time_loop = "";
		
		isset($_POST['id_categorie']) ? $id_categorie = $_POST['id_categorie'] : $id_categorie = "";
		
        if (DISPLAY_REQ=="yes") print("<BR>ON EST DANS update_planning_tache");

        for ($i=$begin_time_loop;$i<=$end_time_loop;$i=$i+15)
        {
          $i=test_time($i);
		  $nb_orgas="nb_orgas_".$i;
		  isset($_POST[$nb_orgas]) ? $$nb_orgas = $_POST[$nb_orgas] : $$nb_orgas = "";
          $current_time="current_time_".$i."_".$$nb_orgas;
          $name="name_".$i."_".$$nb_orgas;
          $id_orga="id_orga_".$i."_".$$nb_orgas;
		  isset($_POST[$current_time]) ? $$current_time = $_POST[$current_time] : $$current_time = "";
		  isset($_POST[$name]) ? $$name = $_POST[$name] : $$name= "";
		  isset($_POST[$id_orga]) ? $$id_orga = $_POST[$id_orga] : $$id_orga= "";
		  
          if ($$name!="")
          {
            $list_orgas=explode("|",$$id_orga);
            for ($l=0;$l<count($list_orgas);$l++)
		    {
		      if ($list_orgas[$l]!="")
			  {
                $req_select=send_req_sql("SELECT * FROM plannings WHERE id_orga LIKE '%|".$list_orgas[$l]."|%' AND `current_time`='".$$current_time."'","no");
                while ($data = mysql_fetch_array($req_select)) 
	            {
	              $current_time_delete=$data['current_time'];
    		      $id_tache_delete=$data['id_tache'];
	    	      $id_orga_delete=$data['id_orga'];
                  $req_update=send_req_sql("UPDATE plannings SET id_orga='".str_replace("|".$list_orgas[$l]."|","|",$id_orga_delete)."' WHERE `current_time`='".$current_time_delete."' AND id_tache=".$id_tache_delete,"yes");

                  $req_delete=send_req_sql("DELETE FROM plannings WHERE `current_time`='".$current_time_delete."' AND id_orga='|'","yes");
	            }
			  }
		    }

            $req_select=send_req_sql("SELECT * FROM plannings WHERE `current_time`='".$$current_time."' AND `id_tache`='".$id_tache."'","no");
	  	    if (mysql_numrows($req_select)==0) $req_insert=send_req_sql("INSERT INTO plannings (`current_time`, `id_tache`, `id_orga`) VALUES ('".$$current_time."', '".$id_tache."', '|".$$id_orga."')","yes");
		    else
		    {
              while ($data = mysql_fetch_array($req_select)) 
	          {
                $req_update=send_req_sql("UPDATE plannings SET id_orga='".$data['id_orga'].$$id_orga."' WHERE `current_time`='".$$current_time."' AND id_tache='".$id_tache."'","yes");
              }
		    }
          }
        }
        display_page("main.php?file=plannings&action=affect&id_tache=".$id_tache."&id_categorie=".$id_categorie);
        break;

      case insert_equipe:
		// R?cup?ration des variables
		isset($_POST['nom']) ? $nom = $_POST['nom'] : $nom = ""; 
		
        if (DISPLAY_REQ=="yes") print("<BR>ON EST DANS insert_equipe");

        $req_insert=send_req_sql("INSERT INTO equipes (nom_equipe) VALUES ('".$nom."')","yes");
        display_page("main.php?file=equipes&action=ajout");
        break;

      case update_equipe:
		// R?cup?ration des variables
		isset($_POST['nom']) ? $nom = $_POST['nom'] : $nom = ""; 
		isset($_POST['id_equipe']) ? $id_equipe = $_POST['id_equipe'] : $id_equipe = ""; 
		
        if (DISPLAY_REQ=="yes") print("<BR>ON EST DANS update_equipe");

        $req_update=send_req_sql("UPDATE equipes SET nom_equipe='".$nom."' WHERE id_equipe='".$id_equipe."'","yes");
        display_page("main.php?file=equipes&action=alpha");
        break;

      case delete_equipe:
		// R?cup?ration des variables
		isset($_POST['id_equipe']) ? $id_equipe = $_POST['id_equipe'] : $id_equipe = ""; 
		
        if (DISPLAY_REQ=="yes") print("<BR>ON EST DANS delete_equipe");

        $req_select=send_req_sql("SELECT * FROM plannings_eq WHERE id_equipe LIKE '%|".$id_equipe."|%'","no");
        while ($data = mysql_fetch_array($req_select)) 
	    {
	      $current_time_delete=$data['current_time'];
		  $id_activite_delete=$data['id_activite'];
		  $id_equipe_delete=$data['id_equipe'];
          $req_update=send_req_sql("UPDATE plannings_eq SET id_equipe='".str_replace($id_equipe."|","",$id_equipe_delete)."' WHERE `current_time`='".$current_time_delete."' AND id_activite='".$id_activite_delete."'","yes");
	    }
        $req_delete=send_req_sql("DELETE FROM equipes WHERE id_equipe='".$id_equipe."'","yes");
        display_page("main.php?file=equipes&action=alpha");
        break;

      case insert_activite:
		// R?cup?ration des variables
		isset($_POST['titre']) ? $titre = $_POST['titre'] : $titre = ""; 
		isset($_POST['consigne']) ? $consigne = $_POST['consigne'] : $consigne = "";
		isset($_POST['begin_time']) ? $begin_time = $_POST['begin_time'] : $begin_time = "";
		isset($_POST['end_time']) ? $end_time = $_POST['end_time'] : $end_time = ""; 
		isset($_POST['duree']) ? $duree = $_POST['duree'] : $duree = ""; 
		isset($_POST['id_vehicule']) ? $id_vehicule = $_POST['id_vehicule'] : $id_vehicule = ""; 
		isset($_POST['id_lieu']) ? $id_lieu = $_POST['id_lieu'] : $id_lieu = ""; 
		
        if (DISPLAY_REQ=="yes") print("<BR>ON EST DANS insert_activite");
        $req_insert=send_req_sql("INSERT INTO activites (titre, consigne, begin_time, end_time, duree, id_vehicule, id_lieu) VALUES ('$titre',  '$consigne', '".date_fr_to_en($begin_time)."', '".date_fr_to_en($end_time)."', '".$duree."', '".$id_vehicule."', '".$id_lieu."')","yes");

        display_page("main.php?file=activites&action=ajout");
        break;

      case update_activite:
		// R?cup?ration des variables
		isset($_POST['titre']) ? $titre = $_POST['titre'] : $titre = ""; 
		isset($_POST['consigne']) ? $consigne = $_POST['consigne'] : $consigne = ""; 
		isset($_POST['begin_time']) ? $begin_time = $_POST['begin_time'] : $begin_time = ""; 
		isset($_POST['end_time']) ? $end_time = $_POST['end_time'] : $end_time = ""; 
		isset($_POST['duree']) ? $duree = $_POST['duree'] : $duree = ""; 
		isset($_POST['id_vehicule']) ? $id_vehicule = $_POST['id_vehicule'] : $id_vehicule = ""; 
		isset($_POST['id_lieu']) ? $id_lieu = $_POST['id_lieu'] : $id_lieu = ""; 
		isset($_POST['id_activite']) ? $id_activite = $_POST['id_activite'] : $id_activite = ""; 
		
        if (DISPLAY_REQ=="yes") print("<BR>ON EST DANS update_activite");

        $req_update=send_req_sql("UPDATE activites SET titre='".$titre."', consigne='".$consigne."', begin_time='".date_fr_to_en($begin_time)."', end_time='".date_fr_to_en($end_time)."', duree='".$duree."', id_vehicule='".$id_vehicule."', id_lieu='".$id_lieu."' WHERE id_activite='".$id_activite."'","yes");
        display_page("main.php?file=activites&action=alpha");
        break;

      case delete_activite:
		// R?cup?ration des variables
		isset($_POST['id_activite']) ? $id_activite = $_POST['id_activite'] : $id_activite = "";
		
        if (DISPLAY_REQ=="yes") print("<BR>ON EST DANS delete_activite");

        $req_delete=send_req_sql("DELETE FROM plannings_eq WHERE id_activite='".$id_activite."'","yes");
        $req_delete=send_req_sql("DELETE FROM activites WHERE id_activite='".$id_activite."'","yes");
        display_page("main.php?file=activites&action=alpha");
        break;

      case update_planning_eq:
	  	// R?cup?ration des variables
		isset($_POST['id_equipe']) ? $id_equipe = $_POST['id_equipe'] : $id_equipe = "";
		isset($_POST['begin_time_loop']) ? $begin_time_loop = $_POST['begin_time_loop'] : $begin_time_loop = "";
		isset($_POST['end_time_loop']) ? $end_time_loop = $_POST['end_time_loop'] : $end_time_loop = "";
		
		isset($_POST['id_equipe_new']) ? $id_equipe_new = $_POST['id_equipe_new'] : $id_equipe_new = "";
		
        if (DISPLAY_REQ=="yes") print("<BR>ON EST DANS update_planning_eq");

        $req_select=send_req_sql("SELECT * FROM plannings_eq WHERE id_equipe LIKE '%|".$id_equipe."|%'","no");
        while ($data = mysql_fetch_array($req_select)) 
	    {
	      $current_time_delete=$data['current_time'];
		  $id_activite_delete=$data['id_activite'];
  	  	  $id_equipe_delete=$data['id_equipe'];
          $req_update=send_req_sql("UPDATE plannings_eq SET id_equipe='".str_replace($id_equipe."|","",$id_equipe_delete)."' WHERE `current_time`='".$current_time_delete."' AND id_activite='".$id_activite_delete."'","yes");
	    }
        for ($i=$begin_time_loop;$i<=$end_time_loop;$i=$i+15)
        {
          $i=test_time($i);
          $current_time="current_time_".$i;
          $titre="titre_".$i;
          $id_activite="id_activite_".$i;
		  isset($_POST[$current_time]) ? $$current_time = $_POST[$current_time] : $$current_time = "";
		  isset($_POST[$titre]) ? $$titre = $_POST[$titre] : $$titre= "";
		  isset($_POST[$id_activite]) ? $$id_activite = $_POST[$id_activite] : $$id_activite= "";
		  
          if ($$titre!="")
          {
            $req_select=send_req_sql("SELECT * FROM plannings_eq WHERE `current_time`='".$$current_time."' AND `id_activite`='".$$id_activite."'","no");
  	  	    if (mysql_numrows($req_select)==0) $req_insert=send_req_sql("INSERT INTO plannings_eq (`current_time`, `id_activite`, `id_equipe`) VALUES ('".$$current_time."', '".$$id_activite."', '|".$id_equipe."|')","yes");
		    else
		    {
              while ($data = mysql_fetch_array($req_select)) 
	          {
                $req_update=send_req_sql("UPDATE plannings_eq SET id_equipe='".$data['id_equipe'].$id_equipe."|' WHERE `current_time`='".$$current_time."' AND id_activite='".$$id_activite."'","yes");
              }
		    }
          }
        }
        $req_delete=send_req_sql("DELETE FROM plannings_eq WHERE id_equipe='|'","yes");
        display_page("main.php?file=plannings_eq&action=define&id_equipe=".$id_equipe_new);
        break;
      
      case correct_db:		
        if (DISPLAY_REQ=="yes") print("<BR>ON EST DANS correct_db");

        $req_delete=send_req_sql("DELETE FROM plannings WHERE id_orga='' OR id_orga='||' OR id_orga='|'","yes");

        $req_select=send_req_sql("SELECT * FROM plannings WHERE id_orga LIKE '%||%'","no");
        while ($data = mysql_fetch_array($req_select)) 
	    {
	      $current_time_delete=$data['current_time'];
		  $id_tache_delete=$data['id_tache'];
  	  	  $id_orga_delete=$data['id_orga'];
          $req_update=send_req_sql("UPDATE plannings SET id_orga='".str_replace("||","|",$id_orga_delete)."' WHERE `current_time`='".$current_time_delete."' AND id_tache='".$id_tache_delete."'","yes");
	    }

        display_page("main.php?file=".$file."&action=alpha");
        break;


// MODULE ADMIN (DB & USERS)
	  //ajout? par pierre ***********************************************************************************************
	  case delete_db:
		// R?cup?ration des variables
		isset($_POST['db_name']) ? $db_name = $_POST['db_name'] : $db_name = "";
		
	    //print("<BR>ON EST DANS delete_db");
		//print("<BR>DELETE DATABASE ".$id_db);
		//trop dangereux ne d?bloquer que pour les phases de test
        $req=send_req_sql("DROP DATABASE ".$db_name,"yes");
		display_page("admin.php");
		break;
		
	  case recup_db:
		// R?cup?ration des variables
		isset($_POST['db_name']) ? $db_name = $_POST['db_name'] : $db_name = "";
		
	   // print("on est dans recup db <br>");
		//print("pour ".$db_name." depuis ".$db_recup."<br>");
		//print("orgas=".$orgas." lieux=".$lieux." fournisseurs=".$fournisseurs." materiels=".$materiels."<br><br>");
		
		if($orgas=="yes")
		{
		 //print("***"); 
		  mysql_select_db($db_recup,$db);
          $req_sql=send_req_sql("SELECT * FROM orgas ORDER BY id_orga");
		  
		  mysql_select_db($db_name,$db);
		  $req_sql2=send_req_sql("SELECT * FROM dates ORDER BY id_date");
		  $i=0;
		  while ($newdata = mysql_fetch_array($req_sql2))
		  {
			$i++;
		  	$date[$i]=($newdata['valeur']);
			//pour enlever les sec pour les plages
			$j=$i+2;
			$mal=":15:00";
			$t1=str_replace($mal,":15",$date[$i]);
			$mal=":30:00";
			$t2=str_replace($mal,":30",$t1);
			$mal=":45:00";
			$t3=str_replace($mal,":45",$t2);
			$mal=":00:00";
			$date[$j]=str_replace($mal,":00",$t3);
			}			
		  $plage="|".$date[3].",".$date[4]."|";
          while ($data = mysql_fetch_array($req_sql))
         {
             $req_insert=send_req_sql("INSERT INTO orgas (first_name, last_name, email, mail_adress, phone_number, begin_time, end_time, plages) VALUES ('".$data['first_name']."', '".$data['last_name']."', '".$data['email']."', '".$data['mail_adress']."', '".$data['phone_number']."', '".$date[1]."', '".$date[2]."', '".$plage."')","yes");
		   
			}
		  }
		  if($lieux=="yes")
		{
		  
		  mysql_select_db($db_recup,$db);
          $req_sql=send_req_sql("SELECT * FROM lieux ORDER BY id_lieu");
		  mysql_select_db($db_name,$db);
		  
          while ($data = mysql_fetch_array($req_sql))
          {
             $req_insert=send_req_sql("INSERT INTO lieux (nom_lieu) VALUES ('".$data['nom_lieu']."')","yes");
		   
			}
		  }
		  if($fournisseurs=="yes")
		{
		  
		  mysql_select_db($db_recup,$db);
          $req_sql=send_req_sql("SELECT * FROM fournisseurs ORDER BY id_fournisseur");
		  mysql_select_db($db_name,$db);
		  
          while ($data = mysql_fetch_array($req_sql))
          {
             $req_insert=send_req_sql("INSERT INTO fournisseurs (name, contact, email, mail_adress, phone_number, commentaire, fax_number) VALUES ('".$data['name']."', '".$data['contact']."', '".$data['email']."', '".$data['mail_adress']."', '".$data['phone_number']."', '".$data['commentaire']."', '".$data['fax_number']."')","yes");
		   
			}
		  }
		  if($fournisseurs=="yes")
		{
		  
		  mysql_select_db($db_recup,$db);
          $req_sql=send_req_sql("SELECT * FROM materiels ORDER BY id_materiel");
		  mysql_select_db($db_name,$db);
		  
          while ($data = mysql_fetch_array($req_sql))
          {
             $req_insert=send_req_sql("INSERT INTO materiels (nom_materiel, valeur_materiel, id_categorie, quantite, id_fournisseur, commande, reception, id_lieu, retour, utilisation) VALUES ('".$data['nom_materiel']."', '".$data['valeur_materiel']."', '".$data['id_categorie']."', '".$data['quantite']."', '".$data['id_fournisseur']."', '".$data['commande']."', '".$data['reception']."', '".$data['id_lieu']."', '".$data['retour']."', '".$data['utilisation']."')","yes");
		   
			}
		  }

		display_page('admin.php');
		
		
		break;
	  
		//fin de l'ajout *************************************************************************************************

      case insert_db:
		// R?cup?ration des variables
		isset($_POST['db_name']) ? $db_name = $_POST['db_name'] : $db_name = "";
		isset($_POST['login']) ? $login = $_POST['login'] : $login = "";
		isset($_POST['password']) ? $password = $_POST['password'] : $password = "";
		isset($_POST['email']) ? $email = $_POST['email'] : $email = "";
		
        if (DISPLAY_REQ=="yes") print("<BR>ON EST DANS insert_db");

        $req=send_req_sql("CREATE DATABASE ".$db_name,"yes");
        if (DISPLAY_REQ!="yes") mysql_select_db($db_name,$db);

        $req=send_req_sql("CREATE TABLE `activites` (`id_activite` int(11) NOT NULL auto_increment,`titre` text NOT NULL,`consigne` text NOT NULL,`begin_time` datetime NOT NULL default '0000-00-00 00:00:00',`end_time` datetime NOT NULL default '0000-00-00 00:00:00',`duree` time NOT NULL default '00:00:00',`id_lieu` int(11) NOT NULL default '0',`id_vehicule` int(11) NOT NULL default '0',PRIMARY KEY  (`id_activite`)) TYPE=MyISAM","yes");
        $req=send_req_sql("CREATE TABLE `categories` (`id_categorie` int(11) NOT NULL auto_increment,`nom_categorie` text NOT NULL,`type_categorie` text NOT NULL,`couleur_categorie` text NOT NULL,PRIMARY KEY  (`id_categorie`)) TYPE=MyISAM","yes");
        $req=send_req_sql("CREATE TABLE `dates` (`id_date` int(11) NOT NULL auto_increment,`nom` text NOT NULL,`valeur` datetime NOT NULL default '0000-00-00 00:00:00',PRIMARY KEY  (`id_date`)) TYPE=MyISAM","yes");
        $req=send_req_sql("INSERT INTO dates (nom, valeur) VALUES ('global_begin_time', '".date_fr_to_en($global_begin_time)."')","yes");
        $req=send_req_sql("INSERT INTO dates (nom, valeur) VALUES ('global_end_time', '".date_fr_to_en($global_end_time)."')","yes");
        $req=send_req_sql("CREATE TABLE `equipes` (`id_equipe` int(11) NOT NULL auto_increment,`nom_equipe` text NOT NULL,PRIMARY KEY  (`id_equipe`)) TYPE=MyISAM","yes");
        $req=send_req_sql("CREATE TABLE `lieux` (`id_lieu` int(11) NOT NULL auto_increment,`nom_lieu` text NOT NULL,PRIMARY KEY  (`id_lieu`)) TYPE=MyISAM","yes");
        $req=send_req_sql("CREATE TABLE `orgas` (`id_orga` int(11) NOT NULL auto_increment,`first_name` text NOT NULL,`last_name` text NOT NULL,`id_categorie` int(11) NOT NULL,`email` text NOT NULL,`mail_adress` text NOT NULL,`phone_number` text NOT NULL,`begin_time` datetime NOT NULL default '0000-00-00 00:00:00',`end_time` datetime NOT NULL default '0000-00-00 00:00:00',`plages` text NOT NULL,PRIMARY KEY  (`id_orga`)) TYPE=MyISAM","yes");
        $req=send_req_sql("CREATE TABLE `plannings` (`current_time` datetime NOT NULL default '0000-00-00 00:00:00',`id_tache` int(11) NOT NULL default '0',`id_orga` text NOT NULL) TYPE=MyISAM","yes");
        $req=send_req_sql("CREATE TABLE `plannings_eq` (`current_time` datetime NOT NULL default '0000-00-00 00:00:00',`id_activite` int(11) NOT NULL default '0',`id_equipe` text NOT NULL) TYPE=MyISAM","yes");
        $req=send_req_sql("CREATE TABLE `taches` (`id_tache` int(11) NOT NULL auto_increment,`titre` text NOT NULL,`consigne` text NOT NULL,`id_categorie` int(11) NOT NULL default '0',`begin_time` datetime NOT NULL default '0000-00-00 00:00:00',`end_time` datetime NOT NULL default '0000-00-00 00:00:00',`plages` text NOT NULL,`nb_orgas` int(11) NOT NULL default '0',`id_resp` int(11) NOT NULL default '0',`affect_resp` enum('yes','no') NOT NULL default 'no',`id_lieu` int(11) NOT NULL default '0',`id_vehicule` int(11) NOT NULL default '0',`id_talkie` int(11) NOT NULL default '0',`matos` text NOT NULL,PRIMARY KEY  (`id_tache`)) TYPE=MyISAM","yes");
        $req=send_req_sql("CREATE TABLE `talkies` (`id_talkie` int(11) NOT NULL auto_increment,`nom_talkie` text NOT NULL,PRIMARY KEY  (`id_talkie`)) TYPE=MyISAM","yes");
        $req=send_req_sql("CREATE TABLE `users` (`id_user` int(11) NOT NULL auto_increment,`user_type` enum('personne','admin','soft') NOT NULL default 'personne',`login` text NOT NULL,`password` text NOT NULL,`is_validate` enum('yes','no') NOT NULL default 'no',PRIMARY KEY  (`id_user`)) TYPE=MyISAM","yes");
        $req=send_req_sql("CREATE TABLE `vehicules` (`id_vehicule` int(11) NOT NULL auto_increment,`nom_vehicule` text NOT NULL,PRIMARY KEY  (`id_vehicule`)) TYPE=MyISAM","yes");
		//test en cours ajout? par pierre octobre 2004 ******************************************************************
		$req=send_req_sql("CREATE TABLE `materiels` (`id_materiel` int(11) NOT NULL auto_increment,`nom_materiel` text NOT NULL,`valeur_materiel` int(11) NOT NULL default '0',`id_categorie` int(11) NOT NULL default '0',`id_lieu` int(11) NOT NULL default '0',`quantite` int(11) NOT NULL default '0',`id_fournisseur` int(11) NOT NULL default '0',`commande` enum('yes','no') NOT NULL default 'no',`reception` enum('yes','no') NOT NULL default 'no',`retour` enum('yes','no') NOT NULL default 'no',`utilisation` text NOT NULL default '',`id_lieu_before` int(11) NOT NULL default '0',PRIMARY KEY  (`id_materiel`)) TYPE=MyISAM","yes");
       	$req=send_req_sql("CREATE TABLE `fournisseurs` (`id_fournisseur` int(11) NOT NULL auto_increment,`name` text NOT NULL,`contact` text NOT NULL,`email` text NOT NULL,`mail_adress` text NOT NULL,`phone_number` text NOT NULL,`commentaire` text NOT NULL default '', `fax_number` text NOT NULL,PRIMARY KEY  (`id_fournisseur`)) TYPE=MyISAM","yes");
		
		
        //fin de l'ajout*/************************************************************************************************

        mysql_select_db('planning_users',$db);
        $req=send_req_sql("INSERT INTO users_list (user_type, login, password, email, is_validate, db_name) VALUES ('personne', '".$login."', PASSWORD('".$password."'), '".$email."', 'yes', '".$db_name."')","yes");

        display_page("admin.php");
        break;

      case admin_db:
		// R?cup?ration des variables
		isset($_POST['db_name']) ? $db_name = $_POST['db_name'] : $db_name = "";
		isset($_POST['user_type_new']) ? $user_type_new = $_POST['user_type_new'] : $user_type_new = "";
		isset($_POST['login_new']) ? $login_new = $_POST['login_new'] : $login_new = "";
		isset($_POST['password_new']) ? $password_new = $_POST['password_new'] : $password_new = "";
		isset($_POST['email_new']) ? $email_new = $_POST['email_new'] : $email_new = "";
		isset($_POST['is_validate_new']) ? $is_validate_new = $_POST['is_validate_new'] : $is_validate_new = "";
		
        if (DISPLAY_REQ=="yes") print("<BR>ON EST DANS admin_db");

        mysql_select_db($db_name,$db);
        $req_update=send_req_sql("UPDATE dates SET valeur='".date_fr_to_en($global_begin_time)."' WHERE id_date=1","yes");
        $req_update=send_req_sql("UPDATE dates SET valeur='".date_fr_to_en($global_end_time)."' WHERE id_date=2","yes");

        mysql_select_db('planning_users',$db);
		for ($i=0;$i<$nb_users;$i++)
		{
          $id_user="id_user_".$i;
          $user_type="user_type_".$i;
          $login="login_".$i;
          $email="email_".$i;
          $is_validate="is_validate_".$i;

          $req_update=send_req_sql("UPDATE users_list SET user_type='".$$user_type."', login='".$$login."', email='".$$email."', is_validate='".$$is_validate."', db_name='".$db_name."' WHERE id_user=".$$id_user,"yes");
		}
		if ($login_new!="") $req_insert=send_req_sql("INSERT INTO users_list (user_type, login, password, email, is_validate, db_name) VALUES ('".$user_type_new."', '".$login_new."', PASSWORD('".$password_new."'), '".$email_new."', '".$is_validate_new."', '".$db_name."')","yes");
        display_page("admin_bases.php?id_db=".$id_db);
        break;

    }
    mysql_close($db);

  }
  else header('location:index.php?msg=Session expir?e');
?>
