<?php
require_once '../component/header.php';
require_once '../functions/sql.php';
require_once 'bdd.php';

$nbjour = 0;

$today = date("Y-m-d");

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

            //On transforme un string en date
            $datearrivee = new DateTime("$arrivee");
            $datedepart = new DateTime("$depart");


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


            //On compte le nombre de jours séléctionnés
            while ($datearrivee <= $datedepart){
                $nbjour++;

                $datearrivee->add(new DateInterval('P1D'));
            }

            //On effectue la requête SQL avec les tags et on la stock dans un tableau
            $tags = Search($dbh, $total, $exposition, $idprix);
            $dayoff = FreeTwo($dbh, $arrivee, $depart);
            $count = count($dayoff);
            for ($i=0; $i < count($tags); $i++){
                for ($in=0; $in < $count-1; $in++){
                    if ($tags[$i] == $dayoff[$in]){
            
                        unset($tags[$i]);
                    }
                }
            }

            //Pour chaque chambre disponible correspondant aux critères séléctionnés, on affiche :
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
                    <h3>2 dates</h3>
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
                        <input name="datestart" value="<?= $arrivee ?>">
                        <input name="dateend" value="<?= $depart ?>">
                        <input name="chambreId" value="<?= $chid ?>">
                        <input name="capacity" value="<?= $chcap ?>">
                        <input name="numberAdult" value="<?= $adulte ?>">
                        <input name="numberChild" value="<?= $enfant ?>">
                        <input name="check" value="1">
                    </div>
                    <div>
                        <input  type="submit" name="confirmReserv" value="Valider votre réservation">
                    </div>
                </form>
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
                <div>
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