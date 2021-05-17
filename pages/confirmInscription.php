<?php
require_once '../component/session.php';
require_once '../component/header.php';
require_once '../functions/functions.php';
require_once '../functions/sql.php';
require_once  'bdd.php';

//Confirmation de l'inscription
if(!isset($_SESSION['id'])){
    //je vérifie que dans le get il y est bien la clé générée sur la page inscription
   if(isset($_GET['key']) AND !empty($_GET['key'])){
        $key = htmlspecialchars($_GET['key']);
        $response = getClientByKey($dbh, $key);
        // je vérifie que la clé est 1 fois en base de donnée
        if($response === 1){
            //je valide le statut de l'utilisateur
            updateStatus($dbh, $key);
            $client = getClientInformationsByKey($dbh,$key);
            //je le connecte
            $_SESSION['id'] = $client['id'];
            $ok =  $lang['confirmInscription'];
           ?>
            <meta http-equiv="refresh" content="0;URL=../index.php">
            <?php
        }   
    }else{
        ?>
       <meta http-equiv="refresh" content="0;URL=../index.php">
<?php
    }
}else{
    ?>
    <meta http-equiv="refresh" content="0;URL=../index.php">
<?php
    }
?>
<div class="content">
    <p style="background-color: forestgreen; color: white; text-align: center;"><?php echo isset($ok)? $ok : "";?></p>
</div>
<?php require_once '../component/footer.php';?>