<?php

session_start();

$session_db_name = $_SESSION['session_db_name'];
$session_user_type = $_SESSION['session_user_type'];  



if (!$session_db_name || !$session_user_type)
{
    var_dump($session_db_name);
    var_dump($session_user_type);
    header('location:login.php');
}

?>
