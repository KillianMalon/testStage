<?php
require_once '../component/session.php';
require_once '../component/header.php';
require_once '../functions/sql.php';
require_once '../functions/functions.php';
require_once 'bdd.php';

if(isset($_POST['send']) AND !empty($_POST['send'])){
    //je vérifie que tous les champs obligatoire soit envoyé et non vide
    if(!empty($_POST['firstName']) AND !empty($_POST['lastName']) AND !empty($_POST['mail']) AND !empty($_POST['mailVerify']) AND !empty($_POST['password']) AND
        !empty($_POST['passwordVerify']) AND !empty($_POST['address']) AND !empty($_POST['postalCode']) AND !empty($_POST['city'])){
        //je fait des vérifications sur les champs comme leur longueur, leur validité (mail, lien) etc...
        $firstName = htmlspecialchars($_POST['firstName']);
        $firstNameLength = strlen(mbUcfirst(mb_strtolower($firstName)));
        if($firstNameLength <= 256){
            $lastName = htmlspecialchars($_POST['lastName']);
            $lastNameLength = strlen(mbUcfirst(mb_strtolower($lastName)));
            if($lastNameLength <= 256){
                $mail = htmlspecialchars($_POST['mail']);
                //on vérifie s'il s'agit d'un email valide (dans la forme mais il peut ne pas exister)
                if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                    $mailCount = mailCheck($dbh, $mail);
                    if($mailCount === 0){
                        $mailVerify = htmlspecialchars($_POST['mailVerify']);
                        if($mail === $mailVerify){
                            //je hache le mot de passe
                            $password = sha1($_POST['password']);
                            $passwordVerify = sha1($_POST['passwordVerify']);
                            if($password === $passwordVerify){
                                $passwordLength = strlen($password);
                                if($passwordLength >= 7 || $passwordLength <= 30){
                                    $address = htmlspecialchars($_POST['address']);
                                    $addressLength = strlen($address);
                                    if($addressLength < 255){
                                        $postalCode = intval($_POST['postalCode']);
                                        $postalCodeLength = strlen($postalCode);
                                        if($postalCodeLength >= 3 || $postalCodeLength <=5){
                                            $city = htmlspecialchars($_POST['city']);
                                            $cityLength = strlen($city);
                                            if($cityLength <= 255){
                                                $country = intval($_POST['country']);
                                                if($country <= 241){
                                                    $civility = htmlspecialchars($_POST['civility']);
                                                    if($civility === "Monsieur" || $civility === "Madame"){
                                                        if(isset($_POST['image']) AND !empty($_POST['image'])) {
                                                            $image = "hey";
                                                        }else {
                                                            $_POST['image'] = "https://i.ibb.co/47nY0vM/default-avatar.jpg";
                                                        }
                                                        //je vérifie si l'url est valide
                                                        if (filter_var($_POST['image'], FILTER_VALIDATE_URL)) {
                                                            $extensionOk = array('.jpg', '.png', 'webp','.gif','jpeg','.psd', '.svg');
                                                            $lastCharacters = substr($_POST['image'], -4);
                                                            //j'appelle une fonction qui génère une clé aléatoire
                                                            $key = generateRandomString();
                                                            //je vérifie que la clé existe pas, si elle existe je fait une boucle tant qu'elle existe
                                                            $response = getClientByKey($dbh,$key);
                                                            while($response === 1 ){
                                                                $key = generateRandomString();
                                                                $response = getClientByKey($dbh,$key);
                                                            }
                                                            //je vérifie si l'extension type d'un fichier image est bien présente dans l'image
                                                            if(in_array($lastCharacters,$extensionOk)){
                                                                $image = $_POST['image'];
                                                                //je prépare ce qu'il faut pour l'envoie de mail
                                                                $to       = $mail;
                                                                $subject  = 'Validation de compte';
                                                                $message  = '<p>Veuillez cliquer sur le lien pour valider votre compte</p><a href="https://www.dorian-roulet.com/testStage/hotel/pages/confirmInscription.php?key='.$key.'">Valider mon compte</a>';
                                                                $headers  = 'From: envoiedemailtest@gmail.com' . "\r\n" .
                                                                    'MIME-Version: 1.0' . "\r\n" .
                                                                    'Content-type: text/html; charset=utf-8';
                                                                if(mail($to, $subject, $message, $headers)) { //si la fontion mail s'envoie sans erreur
                                                                    $msg = "Vous allez recevoir un email de confirmation, cliqué sur le lien pour confirmer votre inscription!";
                                                                    //j'enregistre l'utilisateur en base de donnée avec un statut qui sera invalide tant qu'il n'aura pas cliqué sur le lien de la page confirmInscription
                                                                    inscription($dbh, $firstName, $lastName, $mail, $password, $address, $postalCode, $city, $country, $civility, $image,$key);
                                                                }else{
                                                                    $error = "Echec de l'envoie de l'email";
                                                                }
                                                            }else{
                                                                $error = "Veuillez saisir une url d'image correcte!";
                                                            }
                                                        }else{
                                                            $error = "L'url n'est pas valide, veuillez en saisir un valide !";
                                                        }
                                                    }else{
                                                        $error = "Il ne faut pas modifier la valeur des intput (je te vois) ";
                                                    }
                                                }else{
                                                    $error = "Veuillez ne pas modifier la 'value' de notre select petit malin !!";
                                                }
                                            }else{
                                                $error = "Le nom de la ville est trop long veuillez en saisir un valide";
                                            }
                                        }else{
                                            $error = "Le code postal ne peut contenir moins de 3 chiffres ou plus de 5 chiffres !";
                                        }
                                    }else{
                                        $error = "Votre adresse est trop longue";
                                    }
                                }else{
                                    $error = "Votre mot de passe doit faire entre 7 et 30 caractères !";
                                }
                            }else{
                                $error = "Le mot de passe et sa confirmation ne correspondent pas, veuillez les ressaisir !";
                            }
                        }else{
                            $error = "Le mail et sa vérification ne correspondent pas !";
                        }
                    }else{
                        $error = "Ce mail est déjà utilisé veuillez en saisir un autre !";
                    }
                }else{
                    $error = "Votre mail est invalide, veuillez en saisir un valide!";
                }
            }else{
                $error = "Votre nom est trop long, veuillez le ressaisir !";
            }

        }else{
            $error = "Votre prénom est trop long, veuillez le ressaisir!";
        }
    }else{
        $error = "Veuillez remplir tous les champs!";
    }
}


?>
<style>
.div label{
    margin-left: 1%;
}
    .contentInscription{
  width: (100% - 250px);
  margin-top: 60px;
  padding: 20px;
  margin-left: 250px;
  height: 88vh;
  transition: 0.5s;
}
.div{
    display: flex;
    align-items: flex-start;
}
#check:checked ~ .contentInscription{
  margin-left: 60px;
}
/* form{
  margin-top:50px;
} */
.divInfos{
  margin-left: 7.5%;
  width: 85%;
  display: flex;
  flex-direction:row;
  justify-content: center;
}
.divInfos div{
  width: 40%;
  display: flex;
  flex-direction:column;
  margin-right: 2%;
  margin-left: 2%;
}
/* .divInfos div div label{
  float: left;
  margin-left: -10px;
} */
.divInfos div input[type="text"]{
  height: 25px;
  border:none;
  outline-style:none;
  border-bottom: 1px solid #1992d3;
  background-color: #ececec;
}
.divInfos2{
  display: flex;
  flex-direction: column;
  align-items:center ;
  width: 85%;
  margin-left: 7.5%;
  margin-bottom: 2%;
}
.divInfos2 div {
  width: 86%;
}
.divInfos2 div label{
  float: left;
  margin-left: 1%;
}
.divInfos2 input{
height: 25px;
width: 84%;
margin-right: 2%;
margin-left: 2%;
float: right;
border:none;
outline-style:none;
border-bottom: 1px solid #1992d3;
background-color: #ececec;
}
.divInfos2 select{
  height:30px;
  width: 85%;
  margin-right: 2%;
  margin-left: 2%;
  border:none;
  outline-style:none;
  border-bottom: 1px solid #1992d3;
  background-color: #ececec;
  margin-top: 2%;
}
.divInfos3{
  width: 84%;
  margin-left: 7.5%;
  display: flex;
  justify-content: center;
}
.divInfos3 input[type="submit"]{
  margin-right: 7%;
  background-color: #1992d3;
  color: white;
  border-radius: 5px;
  border: none;
  padding: 10px;
}
.divInfos3 input[type="submit"]:hover{
  background-color:#0B87A6;
  cursor: pointer;
}

.inscriptionH1{
  display: flex;
  justify-content: center;
}
.errorMessageInscription{
  display: flex;
  justify-content: center;
}

input[type="checkbox"].demo3 {
    display: none;
}
input[type="checkbox"].demo3 +label:hover{
    cursor: pointer;
}
input[type="checkbox"].demo3 + label::before {
    font-family: "Font Awesome 5 Free";
    content: '\f070';
    font-size: 1.2em;
    margin-right: 0.3rem;
}
input[type="checkbox"].demo3:checked + label::before {
    content:'\f06e';
}
.passwordGeneratorButton{
    background-color: #ececec;
    border: none;
    
}
.content{
    height:  100%;
}
.send{
    background: linear-gradient(to right, #19B3D3, #1992d3, #196ad3);
}
.generator{
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 2%;
    justify-content: space-around;

}
@media screen and (max-width: 780px){
    .content{
        margin-left: 0px;
    }
}
@media screen and (max-width:490px){
    .divInfos{
        margin-left: 7.5%;
        width: 85%;
        display: flex;
        flex-direction:column;
        justify-content: center;
    }
    .divInfos input{
        width: 84%;
    }
    .divInfos2 input{
        width: 93%;
    }
    .divInfos2 div{
        width: 93%;
    }
    .divInfos2 select{
        width: 93%;
    }
    .divInfos div{
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
}
<?php if($_SESSION['theme']=="sombre"):?>
    .divInfos2 input{
      background-color: #222;
      color: white;
    }
    .divInfos2 select{
        background-color: #222;
        color: white;
    }
    .inscriptionH1 {
        font-size: 10px;
        margin-top: 10%;
    }
  <?php endif; ?>
</style>

<div class="content">
    <div class="inscriptionH1">
        <h1>Formulaire d'inscription</h1>
    </div>
    <form action="" method="post">
        <p style="color:green;text-align: center;">
            <?php
            if(isset($msg) AND !empty($msg)){
                echo $msg;
            }
            ?>
        </p>
        <!-- <div class="divInfos"> -->
            <div class="divInfos2">
                <div >
                    <label for="" >Nom* :</label>
                </div>
                <!--Le code php permet de réinscrire dans le champ ce que l'utilisateur à rentré dans le post si il y a eu un message d'erreur ce qui lui évite de tout re-rentrer-->
                <input type="text" name="lastName" value="<?php echo (!empty($_POST['lastName']))? $_POST['lastName'] : "" ?>">
            </div>
            
            <div class="divInfos2"> 
                <div >
                    <label for="">Prénom* :</label>
                </div>
                <input type="text" name="firstName" value="<?php echo (!empty($_POST['firstName']))? $_POST['firstName'] : "" ?>">
            </div>
        <!-- </div> -->
        

        <div class="divInfos2">
            <div>
                <label for="">Adresse email :*</label>
            </div>
            <input type="mail" name="mail" value="<?php echo (!empty($_POST['mail']))? $_POST['mail'] : "" ?>">
        </div>
        
        <div class="divInfos2">
            <div>
                <label for="">Confirmer Adresse email :*</label>
            </div>
            <input type="mail" name="mailVerify">
        </div>


        

        <div class="divInfos2">
            <div>
                <label for="">Mot de passe :*</label>
            </div>
            <input type="password" name="password" id="myInput">
            <?php
            $ok = 0;
            ?>
            <div class="generator">
                <input type="checkbox" class="demo3" onclick="displayPassword()" id="demo3">
                <label for="demo3"></label>
            
            <i class="fas fa-random" id="btn" onclick="getPassword();"></i>
            </div>
        </div>
        
        <div class="divInfos2">
            <div>
                <label for="">Confirmer mot de passe :*</label>
            </div>
            <input type="password" name="passwordVerify">
        </div>
        

        <div class="divInfos2">
            <div>
                <label for="">Adresse :*</label>
            </div>
            <input type="text" name="address" value="<?php echo (!empty($_POST['address']))? $_POST['address'] : "" ?>">
        </div>
        
        <div class="divInfos2">
            <div>
                <label for="">Code postal :*</label>
            </div>
            <input type="number" name="postalCode" value="<?php echo (!empty($_POST['postalCode']))? $_POST['postalCode'] : "" ?>">
        </div>

        

        <div class="divInfos2">
            <div>
                <label for="">Ville :*</label>
            </div>
            <input type="text" name="city" value="<?php echo (!empty($_POST['city']))? $_POST['city'] : "" ?>">
        </div>
        
        <div class="divInfos2">
            <div>
                <label for=""> Photo de profil :</label>
            </div>
            <input type="url" name="image" value="<?php echo (!empty($_POST['image']))? $_POST['image'] : "" ?>">
        </div>
        

        <div class="divInfos2">
            <div>
                <label for="">Pays :*</label>
            </div>
            <select name="country">
                <option value="">Pays</option>
                <?php
                $allCountry = getCountry($dbh);
                foreach($allCountry as $country){
                    $countryId = $country['id'];
                    $countryName = $country['nom_fr_fr'];
                    ?>
                    <option value="<?php echo $countryId?>"><?php echo $countryName; ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
        
        <div class="divInfos2">
            <div>
                <label for="">Civilité :*</label>
            </div>
            <select name="civility" id="">
                <option value="Monsieur" default>Monsieur</option>
                <option value="Madame">Madame</option>
            </select>
        </div>
        
        <div class="errorMessageInscription">
            <p style="color:red;">
                <?php
                if(isset($error) AND !empty($error)){
                    echo $error;
                }
                ?>
            </p>
        </div>
        <!-- <a href="connexion.php">Connectez-vous ici</a> -->
        
        <div class="divInfos3">
            <input type="submit" name="send" class="send" value="S'inscrire">
        </div>
    </form>
    
</div>

<script>
    function displayPassword() {
        var x = document.getElementById("myInput");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>

<script type="text/javascript">
    function getPassword(){
        var chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        var passwordLength = 15;
        var password = "";
        for (var i=0; i<passwordLength;i++){
            var randomNumber = Math.floor(Math.random()*chars.length);
            password+=chars.substring(randomNumber,randomNumber+1);
        }
        document.getElementById("myInput").value = password
    }
</script>
<?php require_once '../component/footer.php';?>
</body>
</html>