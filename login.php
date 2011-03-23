<?

include ("connect_db.php");

  isset($_POST['login']) ? $login = $_POST['login'] : $login = "";
  isset($_POST['password']) ? $password = $_POST['password'] : $password = "";
  isset($_POST['file']) ? $file = $_POST['file'] : $file = "";


	// Enregistrement du nom de la base
  if (isset($_POST['db_name']))
  	{
  	 $db_name = $_POST['db_name'];
  	}
else if ($_SESSION["db_name"])
  	 $db_name = $_SESSION["db_name"];
  	 else $db_name="";

 
  if ($db_name && $login)
  {	  
  $req_sql="SELECT * FROM users_list WHERE login='".$login."'";
  $req = mysql_query($req_sql);
  $res = mysql_num_rows($req);
echo '<pre>';
  }

  if ($res==0)
  {
    $msg="Si tu n'as pas pu te logger, c'est que tu ne fais pas partie des gentils";
    $msg=$msg." organisateurs.<BR>Casse-toi alors et laisse-nous bosser !!!";
  	//  include('erreur.php');
  	header('location:index.php');
  
  }
  else
  {

  	  	
    //$req_sql='SELECT * FROM users_list WHERE login="'.$login.'"';
    $req_sql='SELECT * FROM users_list WHERE login="'.$login.'" AND password="'.$password.'"';
    $req = mysql_query($req_sql);
    $res = @mysql_num_rows($req);


    if ($res==0)
    {
      $msg="Mauvais mot de passe<BR>ou mauvaise base de données !!!";
      include('index.php');
    }
    else
    {
      $data = mysql_fetch_assoc($req); 
	$session_id_user=$data['id_user'];
	$session_user_type=$data['user_type'];
	$session_login=$data['login'];
	$session_password=$data['password'];
	$session_email=$data['email'];
	$session_is_validate=$data['is_validate'];
        $session_db_name=$db_name;

      if ($session_is_validate=="no")
      {
	    $msg="Ton login n'est plus valide, c'est que tu ne fais pas partie des gentils organisateurs qui connaissent le bon eux.";
	    $msg=$msg."<BR>Casse-toi alors et laisse-nous bosser !!!";
	    include('erreur.php');
      }
      
      
      // LOGIN & MDP VALIDES
      else
      {	
        session_start();// on démarre une session
        // On enregistre toutes les données du visiteur dans la session en cours 
        $_SESSION['session_id_user'] = $session_id_user;
        $_SESSION['session_user_type'] = $session_user_type;
        $_SESSION['session_login'] = $session_login;
        $_SESSION['session_password'] = $session_password;
        $_SESSION['session_email'] = $session_email;
        $_SESSION['session_is_validate'] = $session_is_validate;
        $_SESSION['session_db_name'] = $session_db_name;
        
        $id_session = session_id();
        setcookie ("sessionidPM", $id_session, time() + 3600*24*3*30);

	// SAIS PAS A QUOI IL SERT - A VERIFIER
        session_register("session_appli_name");


        if ($session_db_name=="planning_users")
             header('location: admin.php');
	else
            header('location: main.php?file=menu');
      }
    }
  }

  if ($db) mysql_close($db);
?> 
