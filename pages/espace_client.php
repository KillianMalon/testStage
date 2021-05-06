<?php
require_once '../component/header.php';
require_once '../functions/sql.php';
require_once 'bdd.php';

if(!isset($_SESSION['lang']) || empty($_SESSION['lang'])){
    $_SESSION['lang'] = 'fr';
}
var_dump($_SESSION);
$url = "../languages/".$_SESSION['lang'].".php";
require_once $url;
//Récupération des informations d'un client en focntion de son iD (stockée en SESSION)
if (isset($_SESSION['id'])){
    $id = $_SESSION['id'];
    $clientinfo = getClient($dbh, $id);

    //Stockage des informations dudit client
    $fname = $clientinfo['prenom'];
    $lname = $clientinfo['nom'];
    $mail = $clientinfo['mail'];
    $pwd = $clientinfo['password'];
    $address = $clientinfo['adresse'];
    $pc = $clientinfo['codePostal'];
    $town = $clientinfo['ville'];
    $cid = $clientinfo['pays_id'];
    $img = $clientinfo['image'];
    $country = getCountrybyid($dbh, $cid);
    $civility = $clientinfo['civilite'];


    ?>
    <style>
        li{
            list-style:  none;
            border: 1px solid #B5B2B2;
            padding: 2%;
            border-bottom: none;
        }
        p{
            font-weight: bold;
        }
        .client{
            margin-top: 3%;
            width: 60%;
            margin-left: 20%;
            display: flex;
            justify-content: center;
            flex-direction: column;
        }
        .button{
        padding: 2%;
        border-radius: 0px 0px 15px 15px;
        border: none;
        background: linear-gradient(to right, #19B3D3, #1992d3, #196ad3);
        cursor:pointer;
        color: white;
        transition: background-color 500ms ease-out;
        width: 100%;
        }
        .button:hover{
            background: linear-gradient(to right, #19B3D3, #1992d3, #196ad3);
            box-shadow: 2px 2px 12px grey;
        }
        .divButton{
            margin-top: 3%;
            margin-bottom: 3%;
        }
        .liHaut{
            border-radius: 15px 15px 0px 0px;
        }
    </style>
    <!-- Affichage des informations du client -->
    <div class="content">
        <div class="client">
            <!-- <img class="mobile_profile_image" style="width: 100px; margin-right: 30px;" src="<?= $img ?>"> -->
            <!-- le "=" a la place de "php" remplace le "php" et un "echo" -->
            <li class="liHaut"><p>Prénom : </p></p><?= $fname ?></li>

            <li><p>Nom : </p></p><?= $lname ?></li>

            <li><p>Mail : </p><?= $mail ?></li>

            <li><p>Mot de passe :</p> ********* </li>

            <li><p>Adresse : </p><?= $address ?></li>

            <li><p>Code Postal : </p><?= $pc ?></li>

            <li><p>Ville : </p><?= $town ?></li>

            <li><p> Pays :</p><?= $country['nom_fr_fr'] ?> </li>
            <li><p>Civilité : </p><?= $civility ?></li>
            <li><p>Image :</p> <?= $img ?></li>
            <a href="update.php"><button class="button">Modifier</button> </a>
        </div>
        <br><br>
        <div>
            <form action="configurationLang.php" method="post">
                <button type="submit" <?php if(isset($_SESSION['lang']) AND $_SESSION['lang'] === 'fr'){?> disabled="disabled" <?php }else{ ""; } ?> name="lang" value="fr"><?php echo isset($_SESSION['lang']) ? $lang['lang_fr']: ""; ?></button>
                <button type="submit" <?php if(isset($_SESSION['lang']) AND $_SESSION['lang'] === 'en'){?> disabled="disabled" <?php }else{ ""; } ?> name="lang" value="en"><?php echo isset($_SESSION['lang']) ? $lang['lang_en']: ""; ?></button>
            </form>
        </div>
        <br>
    </div>
        <br>
<!--    </div>-->
<!--    </div>-->

    </body>
    </html>

    <?php
}
?>