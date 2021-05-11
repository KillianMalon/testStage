<?php
require_once '../component/header.php';
require_once '../functions/sql.php';
require_once 'bdd.php';

if (isset($_GET['id'])){
    $id = $_GET['id'];

    removeReservation($dbh, $id);
    ?>
    <meta http-equiv="refresh" content="0;URL=./administration.php">
    <?php
}
?>
<div class="content">
    <p style="background-color: forestgreen; color: white; text-align: center;"><?= $lang['reservationNumber'] ?> <?= $id ?> <?= $lang['deleteOk'] ?></p>
</div>