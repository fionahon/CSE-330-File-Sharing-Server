<?php
    
    //how to logout 
    session_start();
    $user = $_SESSION['user']; 
    session_unset();   
    session_destroy();
    header("Location: username.php");

?>