<?php

require_once '../component/header.php';
require '../functions/functions.php';
require_once '../functions/sql.php';
require_once  'bdd.php';

if (!empty($_SESSION['start']) && !empty($_SESSION['end']) &&  !empty($_SESSION['chambreId'])  &&  !empty($_SESSION['numberAdult'])  && isset($_SESSION['numberChild'])) {
    $end = $_SESSION['end'];
    $start = $_SESSION['start'];
    $chambreId = $_SESSION['chambreId'];
    $numberAdult = $_SESSION['numberAdult'];
    $numberChild = $_SESSION['numberChild'];
    unset($_SESSION['start']);
    unset($_SESSION['end']);
    unset($_SESSION['chambreId']);
    unset($_SESSION['numberAdult']);
    unset($_SESSION['numberChild']);

    $searchIdRservation = getLastReservationId($dbh);
    $idReservationInArray = $searchIdRservation['idReservation'];
    $idReservation = $idReservationInArray + 1;



}elseif (!empty($_POST['start']) && !empty($_POST['end']) &&  !empty($_POST['chambreId']) &&  !empty($_POST['numberAdult'])  &&  isset($_POST['numberChild'])){

    $startPost = $_POST['start'];
    $endPost = $_POST['end'];
    $numberAdult = $_POST['numberAdult'];
    $numberChild = $_POST['numberChild'];
    $idReserv = $_POST['idReservation'];
    $startDateTime = new DateTime("$startPost");
    $endDateTime = new DateTime("$endPost");

    
    while ($startDateTime < $endDateTime) {
        $chambreId =  $_POST['chambreId'];
        $id = $_SESSION['id'];
        $dateStartFormatted = $startDateTime->format('Y-m-d H:i:s');
        $dateEndFormatted = $endDateTime->format('Y-m-d H:i:s');
        addReservation($dbh, $chambreId, $dateStartFormatted, $id, $idReserv);
        $startDateTime->add(new DateInterval('P1D'));
        header('Location:./reservations.php');
    }
    

}else if (!empty($_POST['datestart']) && !empty($_POST['dateend']) &&  !empty($_POST['chambreId']) &&  !empty($_POST['numberAdult'])  &&  isset($_POST['numberChild'])){
    
    
    $start = $_POST['datestart'];
    $end = $_POST['dateend'];
    $chambreId = $_POST['chambreId'];
    $numberAdult = $_POST['numberAdult'];
    $numberChild = $_POST['numberChild'];
    $searchIdRservation = getLastReservationId($dbh);
    $idReservationInArray = $searchIdRservation['idReservation'];
    $idReservation = $idReservationInArray + 1;

}elseif(isset($_POST['check']) && $_POST['check'] == 1  ){

    $end = $_POST['dateend'];
    $start = $_POST['datestart'];
    $chambreId = $_POST['chambreId'];
    $numberAdult = $_POST['numberAdult'];
    $numberChild = $_POST['numberChild'];

    }else{
    unset($_SESSION['start']);
    unset($_SESSION['end']);
    unset($_SESSION['chambreId']);
    unset($_SESSION['numberAdult']);
    unset($_SESSION['numberChild']);
    header('Location:../index.php');
}

?>



<main>
    <div class="content">
        <p>Confirmez votre chambre en appuyant sur le bouton</p>
        <form method="post" action="">
            <input type="text" name="chambreId" value="<?php echo $chambreId ?>" hidden="hidden">
            <input type="text" name="start" value="<?php echo $start?>" hidden="hidden">
            <input type="text" name="end" value="<?php echo $end ?>" hidden="hidden">
            <input type="text" name="numberAdult" value="<?php echo $numberAdult?>" hidden="hidden">
            <input type="text" name="numberChild" value="<?php echo $numberChild ?>" hidden="hidden">
            <input type="text" name="idReservation" value="<?php echo $idReservation?>" hidden="hidden">
            <input  type="submit" id="decale" class="btn btn-primary taille" name="confirmReserv" value="Valider votre réservation">
        </form>
    </div>
    <?php



    ?>


