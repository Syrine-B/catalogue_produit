<?php
//Date: 13/12/23
//Auteur: Syrine Benali

    session_start();

    // Suppression des variables de session et de la session
    $_SESSION = array();
    session_destroy();

    // Suppression des cookies de connexion automatique
    setcookie('login', '');
    setcookie('pass_hache', '');
    header("Location: login.php");
?>