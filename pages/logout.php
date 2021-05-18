<?php
if(isset($_SESSION['id'])){
    $client = getClient($dbh, $_SESSION['id']);
    if($client['type'] != "client"){
        header("Location:../index.php");
    }
}else{
    header("Location:../index.php");
}
//Déconnexion et suppression de la SESSION
session_start();
unset($_SESSION['id']);
// session_unset();
// session_destroy();
header("Location: ../index.php");
die();
