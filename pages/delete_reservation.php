<?php
require_once '../component/session.php';

require_once '../functions/sql.php';
require_once '../functions/functions.php';
require_once 'bdd.php';
if(isset($_SESSION['id'])){
    $client = getClient($dbh, $_SESSION['id']);
    if($client['type'] != "admin"){
        header("Location:../index.php");
    }
}else{
    header("Location:../index.php");
}

$resid = $_POST['IdReservation'];
$allres = getReservationbyrid($dbh, $resid);
$last = getLastiDCancel($dbh);
$lastId = $last[0];
$lastId1 = $lastId + 1;

foreach ($allres as $res){
    addReservationDel($dbh, $res['chambre_id'], $res['jour'], $res['paye'], $res['client_id'], $lastId1);
}
removeReservation($dbh, $resid);

header('Refresh: 2; URL=./reservations.php');
$msg = "Votre réservation a bien été supprimée.";
require_once '../component/header.php';
?>
<div class="content">
    <p style="background-color: forestgreen; color: white; text-align: center;"><?php echo isset($msg)? $msg : "";?></p>
</div>
<?php require_once '../component/footer.php';?>