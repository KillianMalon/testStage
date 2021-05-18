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


//Récupération de l'iD de la chambre en GET
if(!isset($_GET['room']) || empty($_GET['room'])){
    header('Location:../index.php');
    exit();
}
echo '<div class="content">';
$id = intval($_GET['room']);

//Récupération des informations de la chambre en fonctiond e l'iD
$rooms = getRoom($dbh, $id);

//Affichage des informations de la chambre
foreach ($rooms as $room) { 
    $capacite = $room['capacite'];
    $exposition = $room['exposition'];
    $douche = $room['douche'];
    $etage = $room['etage'];
    $tarif_id = $room['tarif_id'];
    $description = $room['description'];
    $image = $room['image'];
    $vues = $room['vues'];
    ?>
    <div class="content">
    <form method="post" action="./applyModifRoom.php">
        <div>
            <label>iD :</label>
            <input type="text" name="id" value="<?php echo isset($id)? $id: ""?>">
        </div>
        <div>
            <label><?= $lang['capacity'] ?> :</label>
            <input type="text" name="capacite" value="<?php echo isset($capacite)? $capacite: " " ?>">
        </div>
        <div>
            <label><?= $lang['exposure'] ?> :</label>
            <select name="exposition">
                <option default value="<?= $exposition ?>"><?= $exposition ?></option>
                <?php if ($exposition == "port"){
                    ?><option value="rempart">rempart</option><?php
                } else {
                    ?><option value="port">port</option><?php
                }
                ?>
            </select>
        </div>
        <div>
            <label><?= $lang['shower'] ?> :</label>
            <select name="douche">
                <option default value="<?= $douche ?>"><?php if($douche==1){echo "Oui";}else{echo "Non";} ?></option>
                <?php if ($douche == 1){
                    ?><option value="0">Non</option><?php
                } else {
                    ?><option value="1">Oui</option><?php
                }
                ?>
            </select>
        </div>
        <div>
            <label><?= $lang['floor'] ?> :</label>
            <select name="etage">
                <option default value="<?= $etage ?>"><?= $etage ?></option>
                <?php $stages = ListEtage($dbh);
                foreach ($stages as $stage){
                    $etages = $stage['etage'];
                    if ($etages != $etage){?>
                        <option value="<?= $etages ?>"><?= $etages ?></option>
                    <?php }
                }
                ?>
            </select>
        </div>
        <div>
        <label><?= $lang['price'] ?> :</label>
        <select name="prix">
            <?php
            $prixx = getPricebyid($dbh, $tarif_id);
            $prix = $prixx['prix'];
            $prices = getPrices($dbh);
            ?>
            <option default value="<?= $tarif_id ?>"><?= $prix ?> €</option>
            <?php
            foreach ($prices as $price){
                $prixd = $price['prix'];
                $tid = $price['id'];
                if ($prixd != $prix){
                    ?><option value="<?= $tid ?>"><?= $prixd ?> €</option> <?php
                }
            }
            ?>
        </select>
        </div>
        <div>
            <label><?= $lang['description'] ?> :</label>
            <input type="text" name="description" value="<?= $description ?>">
        </div>
        <div>
            <label><?= $lang['views'] ?> :</label>
            <input type="text" name="vues" value="<?= $vues ?>">
        </div>
        <div>
            <label><?= $lang['pictureLink'] ?> :</label>
            <input type="text" name="image" value="<?= $image ?>">
        </div>
        <input type="submit" value="<?= $lang['edit'] ?>">
    </form>
        <img src="<?= $image ?>">
</div>
<?php
}
 require_once '../component/footer.php';?>