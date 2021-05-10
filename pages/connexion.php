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
            //on vérifie si l'utilisateur à bien cliqué sur le lien dans son mail !
            if($user['statut'] === 1) {
                $_SESSION['id'] = $user['id'];
                    ?>
                    <meta http-equiv="refresh" content="0;URL=../index.php">
                        <?php                   
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
    label{
        font-weight: bold;
    }
    .lien{
        display: flex;
        justify-content: center;
        flex-direction: row;
        margin-top: 2%;
    }
    .a{
        background: linear-gradient(to right, #19B3D3, #1992d3, #196ad3);
        border: none;
        color: white;
        border-radius: 15px;
        padding: 1%;
        text-decoration: none;
        font-size: small;
    }
    .decale{
        margin-right: 3%;
    }
</style>
<!-- Affichage de formulaire de connexion -->
<div class="content">
    <div class="container">
        <form class="form" action="" method="post">
            <div class="divInput oui">
                <label for="">Email</label>
                <input class="input" type="text" name="mail">
            </div>
            <div class="divInput">
                <label for="">Mot de passe</label>
                <input type="password" class="input" name="password">
            </div>

            <input type="submit" class="submit" value="Se connecter" name="send">
            <br>
            
        </form>
        
    </div>    

    <div class="lien">
        <a class="a decale" href="inscription.php">Inscrivez-vous ici</a>
        <br>
        <a class="a" href="lostPassword.php">Mot de passe oublié ? </a>
    </div>


    <?php
    //on affiche les messages d'erreur qu'il y a plus haut
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