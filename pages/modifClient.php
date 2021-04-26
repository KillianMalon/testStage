<?php
require_once '../component/header.php';
require_once '../functions/sql.php';
require_once 'bdd.php';

if(isset($_GET['client'])){
    $id = intval($_GET['client']);
    $client = getClient($dbh, $id);
    $fname = $client['prenom'];
    $lname = $client['nom'];
    $mail = $client['mail'];
    $civility = $client['civilite'];
    $img = $client['image'];
    $rank = $client['type'];
}
if(isset($_POST['modif'])){
    if(isset($_POST['fname']) and !empty($_POST['fname']) and $_POST['fname'] != $fname){
        //on sécurise firtName pour éviter les injections direct dans la base de donnée
        $firstName = htmlspecialchars($_POST['fname']);
        $firstNameLength = strlen($firstName);
        if ($firstNameLength >= 1 && $firstNameLength <= 150) {
            updateFirstName($dbh, $firstName, $id);
        } else {
            $error = "Le prénom doit faire entre 1 et 150 caractères !";
        }
    }
    if (isset($_POST['lname']) and !empty($_POST['lname']) and $_POST['lname'] != $lname) {
        $lastName = htmlspecialchars($_POST['lname']);
        $lastNameLength = strlen($lastName);
        if ($lastNameLength >= 1 && $lastNameLength <= 150) {
            updateLastName($dbh, $lastName, $id);
        } else {
            $error = "Le nom doit faire entre 1 et 150 caractères !";
        }
    }
    if(isset($_POST['img']) and !empty($_POST['img']) and $_POST['img'] != $img) {
        $image = $_POST['img'];
        //on vérifie qu'il s'agit d'une url valide avec filter_var
        if(filter_var($image, FILTER_VALIDATE_URL)){
            //on récupère les 4 derniers caractères de $lastCharacters
            $lastCharacters = substr($image, -4);
            //on stocke dans un tableau les différentes extensions
            $extensionOk = array('.jpg', '.png', 'webp','.gif','jpeg','.psd', '.svg');
            if(in_array($lastCharacters,$extensionOk)){
                updateUserPP($dbh, $image, $id);
            }
        }else{
            $error = "Veuillez saisir l'url d'une image correct !";
        }
    }
    if(isset($_POST['rank']) and !empty($_POST['rank']) and $_POST['rank'] != $rank){
        $newRank =  htmlspecialchars($_POST['rank']);
        updateRank($dbh, $newRank,$id);
    }
}
?>
<div class="content">
    <form method="post">
        <div>
            <label>Prénom :</label>
            <input type="text" name="fname" value="<?php echo isset($fname)? $fname: ""?>">
        </div>
        <div>
            <label>Nom :</label>
            <input type="text" name="lname" value="<?php echo isset($lname)? $lname: " " ?>">
        </div>
        <div>
            <h4>Mail :<?php echo isset($mail)? $mail : " " ?> </h4>
        </div>
        <div>
            <p>Civilité : <?php echo isset($civility)? $civility :" "?></p>
        </div>
        <div>
            <label>Image :</label>
            <input type="text" name="img" value="<?php echo isset($img)?$img: " " ?>">
        </div>
        <div>
            <select name="rank" id="">
                <!--je selectionne le select qui correspond vrai role de l'utilisateur-->
                <option value="admin" <?php echo $rank === "admin"? "selected" : " " ?> >Admin</option>
                <option value="client" <?php echo $rank === "client"? "selected" : " " ?>>Client</option>
            </select>
        </div>

        <input type="submit" name="modif" value="Modifier">
    </form>
    <br>
    <img style="width: 250px;height: auto;" src="<?php echo isset($img)? $img :" " ?>">
</div>
