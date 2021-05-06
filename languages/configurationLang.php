<?php
$langue = $_POST['lang'];
if(isset($_SESSION['lang'])){
    if(!empty($_SESSION['lang']) && $_SESSION['lang'] =! $langue){
        if($langue === 'fr'){
            echo "hey";
            $_SESSION['lang'] = 'fr';
        }
        if($langue === 'en'){
            $_SESSION['lang'] = 'en';
        }
    }
}else{
    $_SESSION['lang'] == 'fr';
}
?>
<meta http-equiv="refresh" content="0">

