<?
  if(isset($_COOKIE[session_name()]))
  {
    session_start();   // To be able to use session_destroy
    session_unset();
    session_destroy(); // To delete the old session file
    unset($_COOKIE[session_name()]);
    setcookie ("sessionidPM", '', time() -3600);
  }

  header('location: index.php') ;
?>