<?php
require_once '../component/session.php';
require_once '../component/header.php';
require_once '../functions/sql.php';
require_once 'bdd.php';
//on récupère l'ensemble des chambres
$rooms = getAllRoom($dbh);
foreach ($rooms as $room){
    $id = $room['id'];
    $tarifid = $room['tarif_id'];
    //on récupère le prix de la chambre
    $prix = getPricebyid($dbh, $tarifid);
    ?>
<!---AFFICHAGE DES CHAMBRES-->
<div class="content">
    <div class="client">
        <form>
            <div>
                <label>Chambre numéro</label>
                <input name="id" value="<?= $id ?>">
            </div>
            <div>
                <label>Prix</label>
                <select name="price">
                    <!--On affiche le prix de la chambre comme étant celui par défaut-->
                    <option default value="<?php echo $tarifid; ?>"><?php echo $prix; ?> €</option>
                    <?php
                    //on récupère tous les prix
                    $allPrices = getPrices($dbh);
                    foreach ($allPrices as $prices){
                        $pid = $prices['id'];
                        $pprice = $prices['prix'];
                        //si le prix par défaut est différent du prix sur lequel on cycle alors on rentre
                        if ($pprice != $prix){
                            ?>
                            <option value="<?= $pid ?>"><?= $pprice ?> €</option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
        </form>
    </div>
</div>

<?php
}
?>