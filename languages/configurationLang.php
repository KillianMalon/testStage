<?php
session_start();
$langue = $_POST['lang'];
echo "le post :";
echo $langue;
echo "<br>";

if(!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'fr';
}else if (isset($langue) && $_SESSION['lang'] != $langue && !empty($langue)){
    if($langue == 'fr'){
        $_SESSION['lang'] = 'fr';
    }
    else if ($langue == 'en') {
        $_SESSION['lang'] = 'en';
    }
}
?>
<meta http-equiv="refresh" content="0;URL=../pages/espace_client.php">

