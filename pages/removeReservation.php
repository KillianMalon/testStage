<?php
require_once '../component/session.php';

require_once '../functions/sql.php';
require_once 'bdd.php';

if (isset($_GET['id'])){
    $id = $_GET['id'];

    removeReservation($dbh, $id);
    header('Location:administration.php');
}
require_once '../component/header.php';
?>
<div class="content">
    <p style="background-color: forestgreen; color: white; text-align: center;"><?= $lang['reservationNumber'] ?> <?= $id ?> <?= $lang['deleteOk'] ?></p>
</div>