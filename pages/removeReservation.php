<?php
require_once '../component/session.php';

require_once '../functions/sql.php';
require_once 'bdd.php';
if(isset($_SESSION['id'])){
    $client = getClient($dbh, $_SESSION['id']);
    if($client['type'] != "client"){
        header("Location:../index.php");
    }
}else{
    header("Location:../index.php");
}

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
<?php require_once '../component/footer.php';?>