<?php session_start();

if (isset($index)){
    require_once "./functions/sql.php";
    $oui = "index existe";
} else {
    require_once "../functions/sql.php";
    $oui =  "index existe pas fdp";
}
//on vérifie s'il n'y a pas $_SESSION['lang'] ou s'il est vide
if(!isset($_SESSION['lang']) && empty($_SESSION['lang'])){
    //On attribue à la session le langage de base à savoir fr
    $_SESSION['lang'] = 'fr';
}
//on vérifie si on est sur la page index (pas au même niveau que les autres)
if(isset($index)){
    //on stocke dans $url le chemin pour accèder au fichier de lang de la session
    $url = "./languages/".$_SESSION['lang'].".php";
    //on require la page en question
    require_once $url;
}else{
    $url = "../languages/".$_SESSION['lang'].".php";
    require_once $url;
}

if (isset($index)){
    require_once "./pages/bdd.php";
    $oui =  "index existe 2";
} else {
    require_once "bdd.php";
    $oui =  "index existe pas fd2p";
}
// $_SESSION['theme']="sombre";
// unset($_SESSION['theme']);
if (isset($_SESSION['id']) and !empty($_SESSION['id'])) {
    $uid = $_SESSION['id'];
    $user = getClient($dbh, $uid);
    $img = $user['image'];
    $name = $user['prenom'];
    if($user['type'] === "admin"){
        $admin = $user['type'];
    }
}
if(!empty($_POST['theme']) && $_POST['theme'] === 'black'){
    $_SESSION['theme'] = 'sombre';
    ?><meta http-equiv="refresh" content="0"><?php
}else if(!empty($_POST['theme']) && $_POST['theme'] === 'white'){
    unset($_SESSION['theme']);
    ?><meta http-equiv="refresh" content="0"><?php
    // $_SESSION['theme'] = 'clair';
}
?>