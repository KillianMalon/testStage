<?php
require_once 'bdd.php';
require_once '../functions/functions.php';
require_once '../functions/sql.php';
if(isset($_POST['download'])) {
$idReservation = $_POST['reservationId'];
$dateStart = $_POST['dateStart'];
$dateEnd = $_POST['dateEnd'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$chambreId  = $_POST['chambre_id'];
$nombreDeJours2 = $_POST['nombreDeJours'];
$prix = $_POST['prix'];
var_dump($_POST);

generatePdf($dbh, $idReservation, $lname, $fname,$dateStart , $dateEnd, $chambreId, $nombreDeJours2, $prix);
}
?>