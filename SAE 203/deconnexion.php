<?php 
    session_start(); // demarrage de la session
    session_destroy(); // on détruit la session
    header('Location: SAE203.php'); // On redirige
    die();