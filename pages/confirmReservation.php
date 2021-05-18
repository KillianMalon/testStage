<?php
require_once '../component/session.php';
require '../functions/functions.php';
require_once '../functions/sql.php';
require_once  'bdd.php';
if(isset($_SESSION['id'])){
    $client = getClient($dbh, $_SESSION['id']);
    if($client['type'] != "client"){
        header("Location:../index.php");
    }
}else{
    header("Location:../index.php");
}
//Si on a des informations en SESSION, on les stock en local
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


//Sinon, si on a des informations en POST, on les stock en local
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
        ?>
        <!-- <meta http-equiv="refresh" content="0;URL=./reservations.php"> -->
        <?php
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
require_once '../component/header.php';
?>


<style>
    .content{
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        font-size: 1rem;
    }
    .submit{
        padding: 8%;
        border-radius: 30px;
        border: none;
        background: linear-gradient(to right, #19B3D3, #1992d3, #196ad3);
        color: white;
        width: 77%;
    }
    .formu{
        width: 50%;
        display: flex;
        justify-content: center;
    }
</style>
<!-- Affichage de la demande de confirmation de réservation -->
    <div class="content">
        <p><?= $lang['ConfirmReservation']; ?></p>
        <form class="formu" method="post" action="">
            <input type="text" name="chambreId" value="<?php echo $chambreId ?>" hidden="hidden">
            <input type="text" name="start" value="<?php echo $start?>" hidden="hidden">
            <input type="text" name="end" value="<?php echo $end ?>" hidden="hidden">
            <input type="text" name="numberAdult" value="<?php echo $numberAdult?>" hidden="hidden">
            <input type="text" name="numberChild" value="<?php echo $numberChild ?>" hidden="hidden">
            <input type="text" name="idReservation" value="<?php echo $idReservation?>" hidden="hidden">
            <input  type="submit" id="decale" class="submit" name="confirmReserv" value="<?= $lang['ValidateYourBooking'] ?>">
        </form>
    </div>
    <?php



    ?>
<?php require_once '../component/footer.php';?>

