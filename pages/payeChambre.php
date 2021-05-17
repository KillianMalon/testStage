<?php
require_once '../component/session.php';

require_once '../functions/sql.php';
require_once '../functions/functions.php';
require_once 'bdd.php';
//on met les valeurs de post de la page réservations dans des variables pour s'en servir dans le formulaire plus bas
if(isset($_POST['dateStart'])) {
    $dateStart = $_POST['dateStart'];
    $dateEnd = $_POST['dateEnd'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $chambreId = $_POST['chambre_id'];
    $nombreDeJours2 = $_POST['nombreDeJours'];
    $prix = $_POST['prix'];
}
//on vérifie s'il y a on récupère bien un id de la page réservation
if (!empty($_POST['idReservation'])) {
    $reservationId = $_POST['idReservation'];
//on vérifie qu'on récupère bien l'id sur cette page
}elseif (!empty($_POST['reservationId'])){
    $idReservation= $_POST['reservationId'];
    $dateStart = $_POST['dateStart'];
    $dateEnd = $_POST['dateEnd'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $chambreId = $_POST['chambre_id'];
    $nombreDeJours2 = $_POST['nombreDeJours'];
    $prix = $_POST['prix'];
    $auto = 1;
    $clientId = $_SESSION['id'];
    payedReservation($dbh, $idReservation);
    $auro = 1;
    generatePdf($dbh, $idReservation, $lname, $fname,$dateStart , $dateEnd, $chambreId, $nombreDeJours2, $prix,$auto, $clientId);
    header('Location:./reservations.php');
}else{
    ?>
    <meta http-equiv="refresh" content="0;URL=./reservations.php">
    <?php
}
require_once '../component/header.php';
?>
<div class='content'>
    <form method="post" action="">
        <input type="hidden" name="reservationId" value="<?php echo $reservationId?>" hidden="hidden">
        <input type="hidden" name="dateStart" value="<?php echo $dateStart ?>">
        <input type="hidden" name="dateEnd" value="<?php echo $dateEnd ?>">
        <input type="hidden" name="chambre_id" value="<?php echo $chambreId ?>">
        <input type="hidden" name="nombreDeJours" value="<?php echo $nombreDeJours2 ?>">
        <input type="hidden" name="prix" value="<?php echo $prix ?>">
        <input type="hidden" name="lname" value="<?php echo $lname ?>">
        <input type="hidden" name="fname" value="<?php echo $fname ?>">
        <input  type="submit" id="decale" class="btn btn-primary taille"  value="<?= $lang['paidBooking'] ?>">

    </form>
</div>
<?php require_once '../component/footer.php';?>