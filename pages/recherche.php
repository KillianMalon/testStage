<?php
require_once '../component/session.php';
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

            //On transforme un string en datetime
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
            //on cycle sur toutes les chambres qui correspondent au premier critère (pas les checkbox)
            for ($i=0; $i < count($tags); $i++){
                //on cycle sur les id de toutes pour lesquelles il y a eu une réservation ce(s) jours la
                for ($in=0; $in < $count; $in++){
                    if (isset($tags[$i])){
                        //on vérifie si l'id est dans le tableau des chambres indisponibles
                        if ($tags[$i] == $dayoff[$in]){
                            //on supprime l'id de la chambre de tags
                            unset($tags[$i]);
                        }
                    }
                }
            }
            $temp = array();
            $tempcount = array();
            $final = array();
            $tour = 0;
            //on vérifie si une option à été selectionné
            if (isset($_POST['options']) && !empty($_POST['options'])) {
                //on cycle sur tous les tags précédemment récupéré
                foreach ($tags as $tag) {
                    $id = $tag['id'];
                    //on récupère toutes les chambres
                    $alls = getRoom($dbh, $id);
                    //on cycle sur ces chambres
                    foreach ($alls as $all) {
                        //on récupère toutes les options (si y en a)
                        $paras = explode("|", $all['options']);
                        //on cycle sur les options de la chambre
                        foreach ($paras as $para) {
                            //on cycle sur les options selectionnées par l'utilisateur
                            foreach ($_POST['options'] as $option) {
                                //on vérifie si elle est dans les options de la chambre
                                if ($para == $option) {
                                    //si elle y est on ajoute l'id de la chambre dans le tableau temp
                                    array_push($temp, $all['id']);
                                }
                            }
                        }
                    }
                }
                //on compte le nombre d'options sélectionnées par l'utilisateur
                $nboption = count($_POST['options']);
                //on compte le nombre de fois que chaque id de chambre apparait dans le tableau $temp
                $tempcount = array_count_values($temp);
                //on cycle sur le tableau ou il y a l'id des chambres qui respectent les premiers critères
                foreach ($tags as $all) {
                    $i = $all['id'];
                    //si il y a l'id de la chambre dans tempcount
                    if (isset($tempcount[$i])) {
                        //on vérifie sur l'id de la chambre apparait bien "$nboption" de fois
                        if ($tempcount[$i] == $nboption) {
                            //on ajoute au tableau $final l'id de la chambre
                            array_push($final, $i);
                        }
                    }
                }
            }else{
                //on stocke chaque $tags dans un tableau qui s'appelle final
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
            $allopt = explode("|", $all['options']);

            ?>
            <div class="chambre">
                <?php
                if (isset($_SESSION['id']) && !empty($_SESSION['id'])){
                ?>

                <form class="form" method="post" action="confirmReservation.php">

                    <?php }else{ ?>

                    <form class="form" method="post" action="./connexion.php">

                    <?php } ?>
                    
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
                        <?php
                        foreach ($allopt as $oneopt){
                            $opt = getOptionsbyid($dbh, $oneopt);
                            foreach ($opt as $opts){
                                ?><label> <?= $opts['option'] ?> </label><br><?php
                            }
                        }
                        ?>
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
        //on récupère toutes les chambres indisponible le jour en question
        $dayoff = Free($dbh, $arrivee);
        //on cyle sur le nombre de tags
        for ($i=0; $i < count($tags); $i++){
            //on cycle sur le nombre de chambre indisponible ce jour la
            for ($in=0; $in < count($dayoff); $in++){
                //si l'id de tags est dans le tableau indisponible on supprime l'id de la chambre de la liste de tag
                if ($tags[$i] == $dayoff[$in]){
                    unset($tags[$i]);
                }
            }
        }
//on cycle sur tous les tags qui correspondent aux critères
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