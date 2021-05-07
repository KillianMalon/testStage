<?php

//Déconnexion et suppression de la SESSION
session_start();
unset($_SESSION['id']);
// session_unset();
// session_destroy();
header("Location: ../index.php");
die();
