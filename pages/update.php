<?php
require_once '../component/session.php';
require_once '../functions/sql.php';
require_once 'bdd.php';
//Récupération des informations d'un client en focntion de son iD (stockée en SESSION)
if (isset($_SESSION['id'])){
    $id = $_SESSION['id'];
    $clientinfo = getClient($dbh, $id);
    $fname = $clientinfo['prenom'];
    $lname = $clientinfo['nom'];
    $mail = $clientinfo['mail'];
    $pwd = $clientinfo['password'];
    $address = $clientinfo['adresse'];
    $pc = $clientinfo['codePostal'];
    $town = $clientinfo['ville'];
    $cid = $clientinfo['pays_id'];
    $img = $clientinfo['image'];
    $civility = $clientinfo['civilite'];
    $country = getCountrybyid($dbh, $cid);
    //on entre que si y a un clique sur le bouton du formulaire
    if(isset($_POST['formModifications'])) {
        //========================= CONDITION QUI PERMET DE MODIFIER QUE CE QUI EST MODIFIER PAR L'UTILISATEUR
        //on vérifie que la variable n'est pas vide, qu'elle existe puis on vérifie qu'elle est différente de celle de base, si elle ne l'est pas
        //on ne rentre pas dans la condition
        if (isset($_POST['fname']) and !empty($_POST['fname']) and $_POST['fname'] != $fname) {
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
        if (isset($_POST['pwd']) and !empty($_POST['pwd']) and isset($_POST['pwd2']) and !empty($_POST['pwd2'])) {
            $passwordLength = strlen($_POST['pwd']);
            if ($passwordLength >= 7 && $passwordLength <= 25) {
                $password = sha1($_POST['pwd']);
                $passwordVerif = sha1($_POST['pwd2']);
                if ($password === $passwordVerif) {
                    updatePassword($dbh, $password, $id);
                } else {
                    $error = "Le mot de passe et sa confirmation ne correspondent pas, veuillez les ressaisir";
                }
            } else {
                $error = "Le mot de passe doit faire entre 7 et 25 caractères";
            }
        }
        if (isset($_POST['mail']) and !empty($_POST['mail']) and $_POST['mail'] != $mail) {
            $mailModif = htmlspecialchars($_POST['mail']);
            if (filter_var($mailModif, FILTER_VALIDATE_EMAIL)) {
                $nbMailUser = getUserByMailForVerif($dbh, $mailModif);
                if ($nbMailUser === 0) {
                    updateMail($dbh, $mailModif, $id);
                }else{
                    $error = "Un  autre utilisateur utilise déjà ce mail, veuillez en saisir un autre !";
                }
            }else{
                $error = "Le mail est invalide !";
            }
        }
        if(isset($_POST['address']) and !empty($_POST['address']) and $_POST['address'] != $address){
            $addressModif = htmlspecialchars($_POST['address']);
            $addressLength = strlen($addressModif);
            if($addressLength >= 7 && $addressLength <= 255){
                updateAddress($dbh, $addressModif,$id);
            }else{
                $error = "L'adresse doit faire entre 7 et 255 caractères !";
            }
        }
        if(isset($_POST['pc']) and !empty($_POST['pc']) and $_POST['pc'] != $pc) {
            $pcModif = intval($_POST['pc']);
            $pcModifLength = strlen($pcModif);
            if($pcModifLength >=3 && $pcModifLength <= 5){
                updatePostalCode($dbh, $pcModif, $id);
            }else{
                $error = "Veuillez saisir un code postal valide!";
            }
        }
        if(isset($_POST['town']) and !empty($_POST['town']) and $_POST['town'] != $town) {
            $city = htmlspecialchars($_POST['town']);
            $cityLength = strlen($city);
            if($cityLength >= 2 && $cityLength <= 255){
                updateCity($dbh, $city, $id);
            }else{
                $error = "Le nom de la ville doit contenir entre 2 et 255 caractères ! ";
            }
        }
        if(isset($_POST['country']) and !empty($_POST['country']) and $_POST['country'] != $country) {
            $countryModif = intval($_POST['country']);
            $countryModifLength = strlen($countryModif);
            if($countryModifLength >= 1 && $countryModifLength <= 255){
                updateCountry($dbh, $countryModif, $id);
            }else{
                $error = "Pays invalide !";
            }
        }
        if(isset($_POST['civility']) and !empty($_POST['civility']) and $_POST['civility'] != $civility) {
            $civilityModif = htmlspecialchars($_POST['civility']);
            $civilityModifLength = strlen($civilityModif);
            if($civilityModifLength === 8 || $civilityModifLength === 6){
                updateCivility($dbh, $civilityModif, $id);
            }else{
                $error = "Petit malin, c'est pas bien de modif le select";
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
        header('Location:./espace_client.php');
        
        }
        require_once '../component/header.php';
    ?>
    <style>
        .form1{
            border: 1px solid #c7c7c7;
            width: 40%;
            border-radius: 20px;
            margin-top: 50px;
        }
        .client{
            display: flex;
            justify-content: center;
        }
        .divForm{
            display: flex;
            flex-direction: column;
            margin-bottom: 3%;
            margin: 5%;
        }

        .input{
            padding: 2%;
            border-radius: 20px;
            border: 1px solid #c7c7c7;
            background-color: #ececec;
        }
        .select{
            padding: 2%;
            border-radius: 20px;
            border: 1px solid #c7c7c7;
            background-color: #ececec;
        }
        .label{
            font-weight: bold;
            margin-bottom: 1%;
        }
        .submit{
        background: linear-gradient(to right, #19B3D3, #1992d3, #196ad3);
        border: none;
        border-radius: 0px 0px 15px 15px;
        width: 100%;
        color: white;
        padding: 4%;
    }
    <?php if($_SESSION['theme']=="sombre"):?>

        .favoriteButton{
            background-color: #222;
        }
        .input, .select{
            background-color: #464644;
            color: #ececec;
        }
    <?php endif;?>
    </style>
    <div class="content">
        <div class="client">
            <form class="form1" method="post">
                <div class="divForm">
                    <label class="label"><?= $lang['fname']; ?> </label>
                    <input class="input" name="fname" type="text" value="<?= $fname ?>">
                </div>
                <div class="divForm">
                    <label class="label"><?= $lang['lname']; ?> </label>
                    <input class="input" name="lname" type="text" value="<?= $lname ?>">
                </div>
                <div class="divForm">
                    <label class="label">Email</label>
                    <input class="input" name="mail" type="email" value="<?= $mail ?>">
                </div>
                <div class="divForm">
                    <label class="label"><?= $lang['password']; ?> </label>
                    <input class="input" name="pwd" type="password" value="">
                </div>
                <div class="divForm">
                    <label class="label"><?= $lang['confirmPassword']; ?> </label>
                    <input class="input" name="pwd2" type="password">
                </div>
                <div class="divForm">
                    <label class="label"><?= $lang['address']; ?> </label>
                    <input class="input" name="address" type="text" value="<?= $address ?>">
                </div>
                <div class="divForm">
                    <label class="label"><?= $lang['postalCode']; ?> </label>
                    <input class="input" name="pc" type="text" value="<?= $pc ?>">
                </div>
                <div class="divForm">
                    <label class="label"><?= $lang['town']; ?> </label>
                    <input class="input" name="town" type="text" value="<?= $town ?>">
                </div>
                <div class="divForm">
                    <label class="label"><?= $lang['profilePicture']; ?>  :</label>
                    <input class="input" name="img" type="link" value="<?= $img ?>">
                </div>
                <div class="divForm">
                    <label class="label"><?= $lang['country']; ?> </label>
                    <select class="select" name="country" id="">
                        <!--On affiche le pays du client comme étant la selection par défaut-->
                        <option default value="<?php echo $cid?>"><?php echo $country['nom_fr_fr'] ?></option>
                        <?php
                        // récupération de tous les pays
                        $allCountry = getCountry($dbh);
                        foreach($allCountry as $country) {
                            $countryId = $country['id'];
                            $countryName = $country['nom_fr_fr'];
                            //on vérifie que le pays de l'utilisateur est différent du pays sur lequel on cycle (depuis la table ou il y a tous les payus)
                            if($countryId != $cid){
                                ?>
                                <option value="<?php echo $countryId?>"><?php echo $countryName; ?></option>

                                <?php
                            }
                        }
                        ?>
                        </select>
                </div>
                <div class="divForm">
                <label class="label"><?= $lang['civility']; ?> </label>
                    <select class="select" name="civility">
                        <option <?php if($civility === "Monsieur"){ echo "selected";}else{ " "; } ?>>Monsieur</option>
                        <option <?php if($civility === "Madame"){ echo "selected";}else{ " "; } ?>>Madame</option>
                    </select>

                </div>
                <br>
                <div>
                    <input class="submit" type="submit" name="formModifications"  value="<?= $lang['edit']; ?> ">
                </div>
            </form>
        </div>
        <br><br>
    </div>

            <?php } ?>
            <?php require_once '../component/footer.php';?>