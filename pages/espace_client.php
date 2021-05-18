<?php
require_once '../component/session.php';
require_once '../component/header.php';
require_once '../functions/functions.php';
require_once '../functions/sql.php';
require_once  'bdd.php';

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
        .content{
            height: 100%;
        }
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
        <li class="liHaut"><p><?= $lang['fname']; ?> : </p></p><?= $fname ?></li>

            <li><p><?= $lang['lname']; ?> : </p></p><?= $lname ?></li>

            <li><p>Email : </p><?= $mail ?></li>

            <li><p><?= $lang['password']; ?> :</p> ********* </li>

            <li><p><?= $lang['address']; ?>  : </p><?= $address ?></li>

            <li><p><?= $lang['postalCode']; ?>  : </p><?= $pc ?></li>

            <li><p><?= $lang['town']; ?>  : </p><?= $town ?></li>

            <li><p> <?= $lang['country']; ?>  :</p><?= $country['nom_fr_fr'] ?> </li>
            <li><p><?= $lang['civility']; ?>: </p><?= $civility ?></li>
            <li><p><?= $lang['profilePicture']; ?> :</p> <?= $img ?></li>
            <a href="update.php"><button class="button"><?= $lang['edit']; ?></button> </a>
        </div>
        <br><br>
        <div>
            <form action="../languages/configurationLang.php" method="post">
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
<?php require_once '../component/footer.php';?>