<?php
require_once '../component/header.php';
require_once '../functions/sql.php';
require_once 'bdd.php';
?>
<div class="content">
    <form method="post" action="confirmaddchamber.php">
        <div>
            <label><?= $lang['capacity'] ?> :</label>
            <input required type="text" name="capacite" value="">
        </div>
        <div>
            <label><?= $lang['exposure'] ?> :</label>
            <select required name="exposition">
                <option default value="rempart">rempart</option>
                <option value="port">port</option>
            </select>
        </div>
        <div>
            <label><?= $lang['shower'] ?> :</label>
            <select required name="douche">
                <option default value="0">Non</option>
                <option value="1">Oui</option>
            </select>
        </div>
        <div>
            <label><?= $lang['floor'] ?> :</label>
            <select required name="etage">
                <option default value="1">1</option>
                <?php $stages = ListEtage($dbh);
                $etage = 1;
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
            <select required name="prix">
                <?php
                $prices = getPrices($dbh);
                foreach ($prices as $price){
                    $prixd = $price['prix'];
                    $tid = $price['id'];
                    ?>
                    <option value="<?= $tid ?>"><?= $prixd ?> €</option> <?php
                }
                ?>
            </select>
        </div>
        <div>
            <label><?= $lang['description'] ?> :</label>
            <input required type="text" name="description" value="">
        </div>
        <div>
            <label><?= $lang['views'] ?> :</label>
            <input readonly type="text" name="vues" value="">
        </div>
        <div>
            <label><?= $lang['pictureLink'] ?> :</label>
            <input required type="text" name="image" value="">
        </div>
        <input type="submit" value="<?= $lang['add'] ?>">
    </form>
</div>
