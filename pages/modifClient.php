<?php
require_once '../component/session.php';
if(isset($_SESSION['id'])){
    $client = getClient($dbh, $_SESSION['id']);
    if($client['type'] != "admin"){
        header("Location:../index.php");
    }
}else{
    header("Location:../index.php");
}

require_once '../component/header.php';
require_once '../functions/functions.php';
require_once '../functions/sql.php';
require_once  'bdd.php';

//Si les informations sont bien envoyées en GET, on les stock en local
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

//Si les informations sont bien envoyées en POST, on les stock en local
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
<!-- Affichage des informations du client -->
<div class="content">
    <form method="post">
        <div>
            <label><?= $lang['fname']; ?> :</label>
            <input type="text" name="fname" value="<?php echo isset($fname)? $fname: ""?>">
        </div>
        <div>
            <label><?= $lang['lname']; ?> :</label>
            <input type="text" name="lname" value="<?php echo isset($lname)? $lname: " " ?>">
        </div>
        <div>
            <h4>Email :<?php echo isset($mail)? $mail : " " ?> </h4>
        </div>
        <div>
            <p><?= $lang['civility']; ?> : <?php echo isset($civility)? $civility :" "?></p>
        </div>
        <div>
            <label><?= $lang['profilePicture']; ?> :</label>
            <input type="text" name="img" value="<?php echo isset($img)?$img: " " ?>">
        </div>
        <div>
            <select name="rank" id="">
                <!--je selectionne le select qui correspond vrai role de l'utilisateur-->
                <option value="admin" <?php echo $rank === "admin"? "selected" : " " ?> >Admin</option>
                <option value="client" <?php echo $rank === "client"? "selected" : " " ?>><?= $lang['client']; ?></option>
            </select>
        </div>

        <input type="submit" name="modif" value="<?= $lang['edit']; ?>">
    </form>
    <br>
    <img style="width: 250px;height: auto;" src="<?php echo isset($img)? $img :" " ?>">
</div>
<?php require_once '../component/footer.php';?>