<?php
require_once '../component/header.php';
require_once '../functions/sql.php';
require_once 'bdd.php';

if(!isset($_GET['room']) || empty($_GET['room'])){
    header("Location: chambres.php");
    exit();
}
echo '<div class="content">';
$id = intval($_GET['room']);
$rooms = getRoom($dbh, $id);
var_dump($rooms);
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
            <label>Capacité :</label>
            <input type="text" name="capacite" value="<?php echo isset($capacite)? $capacite: " " ?>">
        </div>
        <div>
            <label>Exposition :</label>
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
            <label>Douche :</label>
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
            <label>Etage :</label>
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
        <label>Prix :</label>
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
            <label>Description :</label>
            <input type="text" name="description" value="<?= $description ?>">
        </div>
        <div>
            <label>Vues :</label>
            <input type="text" name="vues" value="<?= $vues ?>">
        </div>
        
        <input type="submit" value="Modifier">
    </form>
</div>
<img src="">
<?php
}
