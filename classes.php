<?

//ajouté par pierre octobre 2004***************************************************************************************

 class fournisseur

  {

    var $id_fournisseur;

    var $name;

    var $contact;

    var $email;

    var $mail_adress;

    var $phone_number;
	
	var $commentaire;
	var $fax_number;





    function fournisseur($data)

    {

      $this->id_fournisseur=$data['id_fournisseur'];

      $this->name=$data['name'];

      $this->contact=$data['contact'];

      $this->email=$data['email'];

      $this->mail_adress=$data['mail_adress'];
	  $this->fax_number=$data['fax_number'];
      $this->phone_number=$data['phone_number'];
	  $this->commentaire=$data['commentaire'];

    }

  }

  class materiel

  {

    var $id_materiel;

    var $nom_materiel;

    var $valeur_materiel;

    var $id_categorie;

    var $quantite;

    var $id_fournisseur;

    var $commande;

    var $reception;

	var $id_lieu_before;

    var $id_lieu;

    var $retour;

	var $utilisation;



    function materiel($data)

    {

      $this->id_materiel=$data['id_materiel'];

      $this->nom_materiel=$data['nom_materiel'];

      $this->valeur_materiel=$data['valeur_materiel'];

      $this->id_categorie=$data['id_categorie'];

      $this->quantite=$data['quantite'];

      $this->id_fournisseur=$data['id_fournisseur'];

      $this->commande=$data['commande'];

      $this->reception=$data['reception'];

	  $this->id_lieu_before=$data['id_lieu_before'];

      $this->id_lieu=$data['id_lieu'];

      $this->retour=$data['retour'];

	  $this->utilisation=$data['utilisation'];

	  

      $this->nom_lieu=$data['nom_lieu'];
	  $this->nom_lieu_before=$data['nom_lieu_before'];

    }

  }

  //fin de l'ajout ***************************************************************************************

  class orga

  {

    var $id_orga;

    var $first_name;

    var $last_name;

    var $email;

    var $mail_adress;

    var $phone_number;

    var $begin_time;

    var $end_time;

    var $plages;
	
	var $id_categorie;

    var $departement;

    var $potes;
	
    var $celib;

    var $permis;


    function orga($data)

    {

      $this->id_orga=$data['id_orga'];

      $this->first_name=$data['first_name'];

      $this->last_name=$data['last_name'];

      $this->email=$data['email'];

      $this->mail_adress=$data['mail_adress'];

      $this->phone_number=$data['phone_number'];

      $this->begin_time=$data['begin_time'];

      $this->end_time=$data['end_time'];

      $this->plages=$data['plages'];

	  $this->id_categorie=$data['id_categorie'];

      $this->nom_orga=$data['first_name']." ".$data['last_name'];

      $this->titre=$data['titre'];

      $this->nom_lieu=$data['nom_lieu'];

      $this->current_time=$data['current_time'];
	  
      $this->departement=$data['departement'];
      
      $this->potes=$data['potes'];

      $this->celib=$data['celib'];

      $this->permis=$data['permis'];

    }

  }



  class vehicule

  {

    var $id_vehicule;

    var $nom;



    function vehicule($data)

    {

      $this->id_vehicule=$data['id_vehicule'];

      $this->nom=$data['nom_vehicule'];



      $this->current_time=$data['MIN(plannings_eq.current_time)'];

      $this->titre=$data['titre'];

      $this->id_equipe=$data['id_equipe'];

      $this->nom_equipe=$data['nom_equipe'];

      $this->id_orga=$data['id_orga'];

      $this->nom_orga=$data['first_name']." ".$data['last_name'];

      $this->nom_lieu=$data['nom_lieu'];

      $this->begin_time=$data['begin_time'];

      $this->end_time=$data['end_time'];

    }

  }



  class lieu

  {

    var $id_lieu;

    var $nom;



    function lieu($data)

    {

      $this->id_lieu=$data['id_lieu'];

      $this->nom=$data['nom_lieu'];



      $this->current_time=$data['MIN(plannings_eq.current_time)'];

      $this->titre=$data['titre'];

      $this->id_equipe=$data['id_equipe'];

      $this->nom_equipe=$data['nom_equipe'];

      $this->id_orga=$data['id_orga'];

      $this->nom_orga=$data['first_name']." ".$data['last_name'];

      $this->begin_time=$data['begin_time'];

      $this->end_time=$data['end_time'];

    }

  }



  class talkie

  {

    var $id_talkie;

    var $nom;



    function talkie($data)

    {

      $this->id_talkie=$data['id_talkie'];

      $this->nom=$data['nom_talkie'];



      $this->current_time=$data['MIN(plannings_eq.current_time)'];

      $this->titre=$data['titre'];

      $this->id_orga=$data['id_orga'];

      $this->nom_orga=$data['first_name']." ".$data['last_name'];

      $this->nom_lieu=$data['nom_lieu'];

      $this->begin_time=$data['begin_time'];

      $this->end_time=$data['end_time'];

    }

  }



  class categorie

  {

    var $id_categorie;

    var $nom;
	
	var $type;
	
	var $couleur;



    function categorie($data)

    {

      $this->id_categorie=$data['id_categorie'];

      $this->nom=$data['nom_categorie'];
	  
	  $this->type=$data['type_categorie'];

	  $this->couleur=$data['couleur_categorie'];

    }

  }



  class tache

  {

    var $id_tache;

    var $titre;

    var $consigne;

    var $id_categorie;

    var $begin_time;

    var $end_time;

    var $id_lieu;

    var $id_vehicule;

    var $id_resp;

    var $affect_resp;

    var $id_talkie;

    var $matos;

	var $plages;
	var $nb_orgas;



    function tache($data)

    {

      $this->id_tache=$data['id_tache'];

      $this->titre=$data['titre'];

      $this->consigne=$data['consigne'];

      $this->id_categorie=$data['id_categorie'];

      $this->begin_time=$data['begin_time'];

      $this->end_time=$data['end_time'];

      $this->nb_orgas=$data['nb_orgas'];

      $this->id_lieu=$data['id_lieu'];

      $this->id_vehicule=$data['id_vehicule'];

      $this->id_resp=$data['id_resp'];

      $this->affect_resp=$data['affect_resp'];

      $this->id_talkie=$data['id_talkie'];

      $this->matos=$data['matos'];

      $this->plages=$data['plages'];



      $this->nom_lieu=$data['nom_lieu'];

      $this->nom_vehicule=$data['nom_vehicule'];

      $this->id_orga=$data['id_orga'];

      $this->first_name=$data['first_name'];

      $this->last_name=$data['last_name'];

      $this->nom_orga=$data['first_name']." ".$data['last_name'];

      $this->current_time=$data['current_time'];

    }

  }



  class planning

  {

    var $current_time;

    var $id_tache;

    var $id_orga;

	var $nb_orgas;

    function planning($data)

    {

      $this->current_time=$data['current_time'];

      $this->id_tache=$data['id_tache'];

      $this->id_orga=$data['id_orga'];

	 $this->nb_orgas=$data['nb_orgas'];

      $this->titre_tache=$data['titre'];		// pour les requetes de definition de plannings

      $this->consigne_tache=$data['consigne'];

      $this->first_name=$data['first_name'];

      $this->last_name=$data['last_name'];

      $this->nom_lieu=$data['nom_lieu'];

      $this->id_lieu=$data['id_lieu'];

      $this->id_vehicule=$data['id_vehicule'];

      $this->id_resp=$data['id_resp'];

      $this->matos=$data['matos'];

    }

  }



  class equipe

  {

    var $id_equipe;

    var $nom;



    function equipe($data)

    {

      $this->id_equipe=$data['id_equipe'];

      $this->nom=$data['nom_equipe'];



      $this->titre=$data['titre'];

      $this->nom_lieu=$data['nom_lieu'];

      $this->current_time=$data['current_time'];

    }

  }



  class activite

  {

    var $id_activite;

    var $titre;

    var $consigne;

    var $begin_time;

    var $end_time;

    var $duree;

    var $id_lieu;

    var $id_vehicule;



    function activite($data)

    {

      $this->id_activite=$data['id_activite'];

      $this->titre=$data['titre'];

      $this->consigne=$data['consigne'];

      $this->begin_time=$data['begin_time'];

      $this->end_time=$data['end_time'];

      $this->duree=$data['duree'];

      $this->id_lieu=$data['id_lieu'];

      $this->id_vehicule=$data['id_vehicule'];



      $this->nom_lieu=$data['nom_lieu'];

      $this->nom_vehicule=$data['nom_vehicule'];

      $this->nom_equipe=$data['nom_equipe'];

      $this->current_time=$data['current_time'];

    }

  }



  class planning_eq

  {

    var $current_time;

    var $id_activite;

    var $id_equipe;



    function planning_eq($data)

    {

      $this->current_time=$data['current_time'];

      $this->id_activite=$data['id_activite'];

      $this->id_equipe=$data['id_equipe'];



      $this->titre_activite=$data['titre'];		// pour les requetes de definition de plannings

      $this->consigne_activite=$data['consigne'];

      $this->nom_equipe=$data['nom_equipe'];

      $this->nom_lieu=$data['nom_lieu'];

      $this->id_lieu=$data['id_lieu'];

      $this->id_vehicule=$data['id_vehicule'];

    }

  }



  class user

  {

    var $id_user;

    var $user_type;

    var $login;

    var $password;

    var $email;

    var $is_validate;

    var $db_name;



    function user($data)

    {

      $this->id_user=$data['id_user'];

      $this->user_type=$data['user_type'];

      $this->login=$data['login'];

      $this->password=$data['password'];

      $this->email=$data['email'];

      $this->is_validate=$data['is_validate'];

      $this->db_name=$data['db_name'];

    }

  }



?>

