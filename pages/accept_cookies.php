<?php
setcookie('show_cookie', 1, time() + 265*24*3600, null, null, false, true);
if (isset($index)){
    require_once "./functions/sql.php";
    $oui = "index existe";
} else {
    require_once "../functions/sql.php";
    $oui =  "index existe pas fdp";
}
if (isset($index)){
    require_once "./pages/bdd.php";
    $oui =  "index existe 2";
} else {
    require_once "../pages/bdd.php";
    $oui =  "index existe pas fd2p";
}

if (isset($_SERVER['HTTP_REFERER']) AND !empty($_SERVER['HTTP_REFERER'])){

    header('Location:'.$_SERVER['HTTP_REFERER']);

}else{

    header('Location: ../index.php');

}
?>