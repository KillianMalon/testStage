<?php
require_once '../component/header.php';
require_once '../functions/sql.php';
require_once 'bdd.php';

$nbjour = 0;

$today = date("Y-m-d");
?>

<style>
    .chambre{
        border: 1px solid black;
        width: 20%;
        margin-right: 3%;
        margin-bottom: 2%;
        display: flex;
        align-items: center;
        flex-direction: column;
        border-radius: 25px;
        padding: 4%;    
    }
    .client{
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        margin-top: 3%;
        width: 100%;
    }
    .form{
        margin-top: 0%;
    }
    .button{
    width: 100%;
    border-radius: 0px 0px 20px 20px;
    padding: 6% ;
    border: none;
    background: linear-gradient(to right, #19B3D3, #1992d3, #196ad3);
    cursor: pointer;
    color: white;
    font-size: large;
    }
    .button:hover{
        box-shadow: 2px 2px 12px grey;
    }
    .element{
        width: 100%;
    }
</style>



<?php
//Si la réservation dure plus d'une nuit :
if (isset($_POST['depart']) and !empty($_POST['depart'])){
    ?>
    <div class="content">
        <div class="client">
            <?php

            //Stockage des informations du $_POST
            $arrivee = $_POST['arrivee'];
            $depart = $_POST['depart'];
            $adulte = $_POST['adulte'];
            $enfant = $_POST['enfant'];
            $total = $adulte + $enfant;
            $exposition = $_POST['exposition'];
            $idprix = $_POST['prix'];
            if (isset($_POST['wi-fi']) && !empty($_POST['wi-fi']) && $_POST['wi-fi'] == 1){
                $wifi = 1;
            } else {
                $wifi = 0;
            }
            if (isset($_POST['piscine']) && !empty($_POST['piscine']) && $_POST['piscine'] == 1){
                $piscine = 1;
            } else {
                $piscine = 0;
            }

            //On transforme un string en date
            $datearrivee = new DateTime("$arrivee");
            $datedepart = new DateTime("$depart");
            $datedepart->sub(new DateInterval('P1D'));
            $depart = $datedepart->format('Y-m-d H:i:s');


            //Si la date entrée est avant aujourd'hui, ou que la date de départ est avant la date d'arrivée : afficher une erreur/
            if ($today > $datearrivee or $datedepart < $datearrivee){
                ?>
                <div>
                    <label>La date saisie n'est pas valide</label>
                    <a href="../index.php">Retour à l'Accueil</a>
                </div>
                <?php


                //Sinon
            }else{


            //On effectue la requête SQL avec les tags et on la stock dans un tableau
            $tags = Search($dbh, $total, $exposition, $idprix);
            $dayoff = FreeTwo($dbh, $arrivee, $depart);
            $count = count($dayoff);
            for ($i=0; $i < count($tags); $i++){
                for ($in=0; $in < $count; $in++){
                    if (isset($tags[$i])){
                        if ($tags[$i] == $dayoff[$in]){
                            unset($tags[$i]);
                        }
                    }
                }
            }
            $temp = array();
            $tempcount = array();
            $final = array();
            $tour = 0;
            if (isset($_POST['options']) && !empty($_POST['options'])) {
                foreach ($tags as $tag) {
                    $id = $tag['id'];
                    $alls = getRoom($dbh, $id);
                    foreach ($alls as $all) {
                        $paras = explode("|", $all['options']);
                        foreach ($paras as $para) {
                            foreach ($_POST['options'] as $option) {
                                if ($para == $option) {
                                    array_push($temp, $all['id']);
                                }
                            }
                        }
                    }
                }
                $nboption = count($_POST['options']);
                $tempcount = array_count_values($temp);
                foreach ($tags as $all) {
                    $i = $all['id'];
                    if (isset($tempcount[$i])) {
                        if ($tempcount[$i] == $nboption) {
                            array_push($final, $i);
                        }
                    }
                }
            }else{
                foreach ($tags as $tag){
                    array_push($final, $tag['id']);
                }
            }


            //Pour chaque chambre disponible correspondant aux critères séléctionnés, on affiche :
            foreach ($final as $tag){

            $id = $tag;
            $alls = getRoom($dbh, $id);

            foreach ($alls as $all){
            $chid = $all['id'];
            $chprix = $all['prix'];
            $chexp = $all['exposition'];
            $chcap = $all['capacite'];
            $chetage = $all['etage'];
            $chimage = $all['image'];
            $piscine = $all['piscine'];
            $wifi = $all['wifi'];

            ?>
            <div class="chambre">
                <?php
                if (isset($_SESSION['id']) && !empty($_SESSION['id'])){
                ?>

                <form class="form" method="post" action="confirmReservation.php">

                    <?php }else{ ?>

                    <form class="form" method="post" action="./connexion.php">

                    <?php } ?>
                    <div class="element">
                        <!-- <h3>2 dates</h3> -->
                        <div>
                            <label>Chambre numéro <?= $chid ?></label>
                        </div>
                        <div>
                            <label>Prix : <?= $chprix ?> €</label>
                        </div>
                        <div>
                            <label>Capacité : <?= $chcap ?> personnes</label>
                        </div>
                        <div>
                            <label>Exposition : <?= $chexp ?></label>
                        </div>
                        <div>
                            <label>Etage numéro <?= $chetage ?></label>
                        </div>
                        <div>
                            <?php
                            if ($wifi == 1){
                                ?> <label> Wifi </label> <?php
                            }
                            ?>
                        </div>
                        <div>
                            <?php
                            if ($piscine == 1){
                                ?> <label> Piscine </label> <?php
                            }
                            ?>
                        </div>
                        <div style="display: none">
                            <input name="datestart" value="<?= $arrivee ?>">
                            <input name="dateend" value="<?= $depart ?>">
                            <input name="chambreId" value="<?= $chid ?>">
                            <input name="capacity" value="<?= $chcap ?>">
                            <input name="numberAdult" value="<?= $adulte ?>">
                            <input name="numberChild" value="<?= $enfant ?>">
                            <input name="check" value="1">
                        </div>
                        
                    </div>  
                    <div>
                            <input class="button"  type="submit" name="confirmReserv" value="Valider votre réservation">
                        </div>
                        </form>  
            </div>    
                
                <?php
                }
                }
                }
                ?>
        </div>
    </div>
    <?php
}

//Si la réservation ne dure qu'une nuit :
else{
    ?>
    <div class="content">
    <div class="client">
    <?php

    $arrivee = $_POST['arrivee'];
    $adulte = $_POST['adulte'];
    $enfant = $_POST['enfant'];
    $total = $adulte + $enfant;
    $exposition = $_POST['exposition'];
    $idprix = $_POST['prix'];

    $datearrivee = new DateTime("$arrivee");
    $datedepart = new DateTime("$arrivee");
    $datedepart->add(new DateInterval('P1D'));
    $depart = $datedepart->format('Y-m-d');
    if ($today > $datearrivee){
        ?>
        <div>
            <label>La date saisie n'est pas valide</label>
            <a href="../index.php">Retour à l'Accueil</a>
        </div>
        <?php
    }else{

        $tags = Search($dbh, $total, $exposition, $idprix);
        $dayoff = Free($dbh, $arrivee);


        for ($i=0; $i < count($tags); $i++){
            for ($in=0; $in < count($dayoff); $in++){
                if ($tags[$i] == $dayoff[$in]){
                    unset($tags[$i]);
                }
            }
        }

        foreach ($tags as $tag){

            $id = $tag['id'];
            $alls = getRoom($dbh, $id);

            foreach ($alls as $all){
                $chid = $all['id'];
                $chprix = $all['prix'];
                $chexp = $all['exposition'];
                $chcap = $all['capacite'];
                $chetage = $all['etage'];
                if (isset($_SESSION['id']) && !empty($_SESSION['id'])){
                    ?>

                    <form method="post" action="confirmReservation.php">

                <?php }else{ ?>

                    <form method="post" action="./connexion.php">

                <?php } ?>
                <h3>1 date</h3>
                <div>
                    <label>Chambre numéro <?= $chid ?></label>
                </div>
                <div>
                    <label>Prix : <?= $chprix ?> €</label>
                </div>
                <div>
                    <label>Capacité : <?= $chcap ?> personnes</label>
                </div>
                <div>
                    <label>Exposition : <?= $chexp ?></label>
                </div>
                <div>
                    <label>Etage numéro <?= $chetage ?></label>
                </div>
                <div style="display: none">
                    <input type="date" name="datestart" value="<?= $arrivee ?>">
                    <input type="date" name="dateend" value="<?= $depart ?>">
                    <input type="text" name="chambreId" value="<?= $chid ?>">
                    <input type="text" name="capacity" value="<?= $chcap ?>">
                    <input type="text" name="numberAdult" value="<?= $adulte ?>">
                    <input type="text" name="numberChild" value="<?= $enfant ?>">
                    <input name="check" value="1">
                </div>
                <div class="divButton">
                    <button type="submit">Réserver</button>
                </div>
                </form>
                <?php
            }
        }
        ?>
        </div>
        </div>
        <?php
    }
}
?>