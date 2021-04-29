<?php
require_once '../component/header.php';
require_once '../functions/sql.php';
require_once 'bdd.php';


if (!empty($_POST['idReservation'])) {
    $reservationId = $_POST['idReservation'];
    
}elseif (!empty($_POST['reservationId'])){
    $idReservation= $_POST['reservationId'];
    payedReservation($dbh, $idReservation);
    header('Location:./reservations.php');
}else{
    header('Location:./reservations.php');
}
?>
<div class='content'>
    <form method="post" action="">
        <input type="hidden" name="reservationId" value="<?php echo $reservationId?>" hidden="hidden">
        <input  type="submit" id="decale" class="btn btn-primary taille"  value="Payer réservation">
    </form>
</div>