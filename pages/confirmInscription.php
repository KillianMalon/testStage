<?php
require_once '../component/header.php';
require_once '../functions/sql.php';
require_once 'bdd.php';

//Confirmation de l'inscription

if(!isset($_SESSION['id'])){
   if(isset($_GET['key']) AND !empty($_GET['key'])){
        $key = htmlspecialchars($_GET['key']);
        $response = getClientByKey($dbh, $key);
        $oma = $response;
        var_dump($oma);
        if($response === 1){
            updateStatus($dbh, $key);
            $client = getClientInformationsByKey($dbh,$key);
            $_SESSION['id'] = $client['id'];

            $ok =  $lang['confirmInscription'];
            header('Refresh: 2; URL=../index.php');

        }

    }else{
        header("Location:../index.php");
    }
}else{
        header("Location:../index.php");
    }
?>
<div class="content">
    <p style="background-color: forestgreen; color: white; text-align: center;"><?php echo isset($ok)? $ok : "";?></p>
</div>
