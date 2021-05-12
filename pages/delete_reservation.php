<?php
require_once '../component/session.php';

require_once '../functions/sql.php';
require_once '../functions/functions.php';
require_once 'bdd.php';

$resid = $_POST['IdReservation'];
$allres = getReservationbyrid($dbh, $resid);
foreach ($allres as $res){
    addReservationDel($dbh, $res['chambre_id'], $res['jour'], $res['client_id'], $resid);
}
removeReservation($dbh, $resid);

header('Refresh: 2; URL=./reservations.php');
$msg = "Votre réservation a bien été supprimée.";
require_once '../component/header.php';
?>
<div class="content">
    <p style="background-color: forestgreen; color: white; text-align: center;"><?php echo isset($msg)? $msg : "";?></p>
</div>
