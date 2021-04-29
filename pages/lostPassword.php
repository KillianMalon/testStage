<?php
require_once '../component/header.php';
require_once 'bdd.php';
require_once '../functions/sql.php';

if(isset($_POST['verify']) AND !empty($_POST['verify'])){
    if(isset($_POST['mail']) AND !empty($_POST['mail'])) {
        $mail = htmlspecialchars($_POST['mail']);
        $clientInfo = getUserByMailForVerif($dbh, $mail);
        if($clientInfo === 1){
            $clientInfo = getUserByMail($dbh,$mail);
            $mail = $clientInfo['mail'];
            $key = $clientInfo['cle'];
            $to       = $mail;
            $subject  = 'Validation de compte';
            $message  = '<p>Cliquer ici pour choisir votre nouevau mot de passe :</p><br><a href="http://localhost/testStage/hotel/pages/newPassword.php?key='.$key.'">Choisir un nouveau mot de passe</a>';
            $headers  = 'From: envoiedemailtest@gmail.com' . "\r\n" .
                'MIME-Version: 1.0' . "\r\n" .
                'Content-type: text/html; charset=utf-8';
            if(mail($to, $subject, $message, $headers)) {
                $msg = "Vous allez recevoir un email, il bous suffit de cliquer sur le lien pour changer votre mot de passe!";
            }else{
                $error = "Echec de l'envoie de l'email";
            }
        }else{
            $error = "Il n'y a pas de compte avec ce mail";
        }
    }
}
?>

<div class="content">
    <form action="" method="post">
        <label for="">Votre mail : </label>
        <input type="text" name="mail">
        <br>
        <input type="submit" name="verify" >
    </form>
    <?php
    if(isset($error) AND !empty($error)){
        echo $msg;
    }
    if(isset($msg) AND !empty($msg)){
        echo $msg;
    }
    ?>
    <div>
