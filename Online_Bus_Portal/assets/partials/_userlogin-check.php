<?php
    session_start();

    if(!isset($_SESSION["user_loggedIn"]) || !$_SESSION["user_loggedIn"])
    {
        header("location: ../index.php");
    }

    $user_loggedIn = true;
?>



