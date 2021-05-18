<?php
require_once '../component/session.php';
require_once '../component/header.php';
require_once '../functions/sql.php';
require_once 'bdd.php';
if(isset($_SESSION['id'])){
    $client = getClient($dbh, $_SESSION['id']);
    if($client['type'] != "admin"){
        header("Location:../index.php");
    }
}else{
    header("Location:../index.php");
}
//Récupération des informations des clients
$clients = getAllClients($dbh);

//Stockage des informations de chaque client
foreach ($clients as $client){
    $id = $client['id'];
    $civilite = $client['civilite'];
    $nom = $client['nom'];
    $prenom = $client['prenom'];
    $adresse = $client['adresse'];
    $cp = $client['codePostal'];
    $ville = $client['ville'];
    $paysid = $client['pays_id'];
    $mail = $client['mail'];
    $pwd = $client['password'];
    $type = $client['type'];
    $image = $client['image'];
    $pays = getCountrybyid($dbh, $paysid);
    ?>
    <!-- Affichage desdites informations -->
    <div class="content">
        <div class="client">
            <img class="mobile_profile_image" style="width: 100px; margin-right: 30px;" src="<?= $image ?>">
            <form method="post" action="">
                <div>
                    <label>iD</label>
                    <input name="id" type="text" value="<?= $id ?>">
                </div>
                <div>
                    <label><?= $lang['civility'] ?></label>
                    <select name="type" id="">
                        <option default value="<?php if($civilite == '1'){ echo '1';} elseif ($civilite == '2'){ echo '2';} ?>"><?php if($civilite == '1'){ echo 'Monsieur';} elseif ($civilite == '2'){ echo 'Madame';} ?></option>
                        <option value="<?php if($civilite == '1'){ echo '2';} elseif ($civilite == '2'){ echo '1';} ?>"><?php if($civilite == '1'){ echo 'Madame';} elseif ($civilite == '2'){ echo 'Monsieur';} ?></option>
                    </select>
                </div>
                <div>
                    <label><?= $lang['fname'] ?></label>
                    <input name="fname" type="text" value="<?= $prenom ?>">
                </div>
                <div>
                    <label><?= $lang['lname'] ?></label>
                    <input name="lname" type="text" value="<?= $nom ?>">
                </div>
                <div>
                    <label>Email</label>
                    <input name="mail" type="email" value="<?= $mail ?>">
                </div>
                <div>
                    <label><?= $lang['password'] ?></label>
                    <input name="pwd" type="password" value="<?= $pwd ?>">
                </div>
                <div>
                    <label><?= $lang['address'] ?></label>
                    <input name="address" type="text" value="<?= $adresse ?>">
                </div>
                <div>
                    <label><?= $lang['postalCode'] ?></label>
                    <input name="PC" type="text" value="<?= $cp ?>">
                </div>
                <div>
                    <label><?= $lang['town'] ?></label>
                    <input name="town" type="text" value="<?= $ville ?>">
                </div>
                <div>
                    <label><?= $lang['country'] ?></label>
                    <select name="civility" id="">
                        <!--Affiche pays du client-->
                        <option default value="<?php echo $paysid?>"><?php echo $pays['nom_fr_fr'] ?></option>
                        <?php
                        $allCountry = getCountry($dbh);
                        foreach($allCountry as $country){
                            $countryId = $country['id'];
                            $countryName = $country['nom_fr_fr'];
                            //on affiche tous les pays qui ne sont pas celui du client
                            if($countryId != $cid){
                                ?>
                                <option value="<?php echo $countryId?>"><?php echo $countryName; ?></option>

                                <?php
                            }
                        }
                        ?>
                    </select>
                    <div>
                        <label>Type</label>
                        <select name="type" id="">
                            <!--On vérifie le type d'utilisatateur et on lui affiche le bon role -->
                            <option default value="<?php if($type == 'client'){ echo 'client';} elseif ($type == 'admin'){ echo 'admin';} ?>"><?php if($type == 'client'){ echo 'Client';} elseif ($type == 'admin'){ echo 'Admin';} ?></option>
                            <!--On vérifie le type d'utilisatateur et on propose le role inverse en non selected -->
                            <option value="<?php if($type == 'client'){ echo 'admin';} elseif ($type == 'admin'){ echo 'client';} ?>"><?php if($type == 'client'){ echo 'Admin';} elseif ($type == 'admin'){ echo 'Client';} ?></option>
                        </select>
                    </div>
                    <br>
                    <button type="submit"><?= $lang['edit'] ?></button>
                </div>
            </form>
        </div>
    </div>

    </body>
    </html>

<?php
}
?>
<?php require_once '../component/footer.php';?>