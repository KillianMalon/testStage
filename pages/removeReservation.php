<?php
require_once '../component/header.php';
require_once '../functions/sql.php';
require_once 'bdd.php';

if (isset($_GET['id'])){
    $id = $_GET['id'];

    removeReservation($dbh, $id);

    header('Refresh: 2; URL=./administration.php');
}
?>
<div class="content">
    <p style="background-color: forestgreen; color: white; text-align: center;">La Réservation numéro <?= $id ?> a bien été supprimée !</p>
</div>