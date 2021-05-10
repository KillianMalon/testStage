<?php
require_once '../component/header.php';
require_once 'bdd.php';
require_once '../functions/sql.php';
if(isset($_GET['key']) AND !empty($_GET['key'])){
    $key = htmlspecialchars($_GET['key']);
    $ok = getClientByKey($dbh,$key);
    $msg = "";
    //si la clé est valide
    if($ok === 1){
        if(isset($_POST['send'])){
            if(isset($_POST['pwd']) AND !empty($_POST['pwd']) AND isset($_POST['pwdV']) AND !empty($_POST['pwdV'])){
                $passwordLength = strlen($_POST['pwd']);
                if($passwordLength >= 7 && $passwordLength <= 30){
                    $pwd = sha1($_POST['pwd']);
                    $pwdV = sha1($_POST['pwdV']);
                    if($pwd === $pwdV){
                        $infos = getClientInformationsByKey($dbh, $key);
                        $id = $infos['id'];
                        updatePassword($dbh,$pwd,$id);
                        $_SESSION['id'] = $id;
                        $msg = "Votre nouveau mot de passe à été enregistré";
                        ?>
                            <meta http-equiv="refresh" content="0;URL=../index.php">
                            <?php
                    }else{
                        $error = "Le mot de passe et sa confirmation ne correspondent pas !";
                    }
                }else{
                    $error = "Le mot de passe doit faire entre 7 et 30 caractères !";
                }
            }else {
                $error = "Tous les champs doivent être remplis !";
            }
        }
        ?>
            <div class="content">
                <form action="" method="post">
                    <label for="">Nouveau Mot de passe</label>
                    <input type="password" name="pwd"minlength="7" maxlength="30" required>
                    <br>
                    <label>Confirmer le nouveau mot de passe</label>
                    <input type="password" name="pwdV" minlength="7" maxlength="30" required>
                    <br>
                    <input type="submit" name="send">
                    <br>
                    <?php
                    if(isset($error) AND !empty($error)){
                        echo $error;
                    }
                    if(isset($msg) AND !empty($msg)){
                        echo $msg;
                    }
                    ?>
                </form>

            </div>
<?php
    }else{
        header("Refresh:2; URL= ../index.php");
    }
}else{
    header("Refresh:2; URL= ../index.php");
}