<?php
require_once '../component/session.php';
require_once '../component/header.php';
require_once '../functions/functions.php';
require_once '../functions/sql.php';
require_once  'bdd.php';

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
<style>
    .form{
        border: 1px solid #c7c7c7;
        border-radius: 20px;
        width: 20%;
        text-align: center;
    }
    .input{
        padding: 4%;
        margin: 9%;
        margin-top: 2%;
        background-color: #ececec;
        border-radius: 10px;
        border: 1px solid #c7c7c7;
    }
    .divInput{
        display: flex;
        flex-direction: column;
        text-align: center;
    }
    .oui{
        padding-top: 5%;
    }
    .container{
        display: flex;
        justify-content: center;
    }
    .submit{
        background: linear-gradient(to right, #19B3D3, #1992d3, #196ad3);
        border: none;
        border-radius: 0px 0px 15px 15px;
        width: 100%;
        color: white;
        padding: 6%;
    }    
</style>
<div class="content">
    <div class="container">
        <form class="form" action="" method="post">
            <div class="divInput oui">
                <label for="">Votre mail : </label>
                <input class='input' type="text" name="mail">
            </div>
                <input class="submit" type="submit" name="verify" >
        </form>
    </div>    
    <?php
    if(isset($error) AND !empty($error)){
        echo $msg;
    }
    if(isset($msg) AND !empty($msg)){
        echo $msg;
    }
    ?>
<div>
<?php require_once '../component/footer.php';?>

    