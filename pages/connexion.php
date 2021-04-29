<?php
if(isset($_SESSION['id'])){
    header("Location:../index.php");
}
require_once '../component/header.php';
require_once '../functions/sql.php';
require_once 'bdd.php';

//Connexion au site
if(isset($_POST['send']) AND !empty($_POST['send'])){
    $mail = htmlspecialchars($_POST['mail']);
    $password = sha1($_POST['password']);
    if(!empty($mail) AND !empty($password)){

        $query = getUserByMailAndPassword($dbh, $mail, $password);
        $userExist = $query->rowCount();
        if($userExist === 1 ){
            $user = $query->fetch();
            if($user['statut'] === 1) {
                $_SESSION['id'] = $user['id'];
                header("Location:../index.php");
                exit();
            }else{
                $error = "Veuillez confirmer votre compte en cliquant sur le lien que vous avez reçu par mail";
            }
        }else{
            $error = "Le mot de passe ou l'identifiant est incorrect";
        }
    }else{
        $error = "Tous les champs doivent être rempli";
    }
}
?>

<!-- Affichage de formulaire de connexion -->
<div class="content">
    <form action="" method="post">
        <label for="">Email :</label>
        <input type="text" name="mail">
        <br>
        <label for="">Mot de passe :</label>
        <input type="password" name="password">
        <br>
        <input type="submit" value="Se connecter" name="send">
        <br>
        <a href="inscription.php">Inscrivez-vous ici</a>

        <a href="lostPassword.php"> Mot de passe oublié ? </a>
    </form>
    <?php
    if(isset($error) AND !empty($error)){
        echo $error;
    }
    if(isset($message) AND !empty($message)){
        echo $message;
    }
    ?>
</div>
</div>

</body>
</html>