<?php
require_once '../component/header.php';
require_once '../functions/sql.php';
require_once 'bdd.php';

$compteur = 0;
if (isset($_SESSION['id'])){
    echo '<div class="content">';
    $uid = $_SESSION['id'];
    $count = countReservations($dbh, $uid);
    $rlists = getReservations($dbh, $uid);
    $i = 0;
    
    $reservationsByUsereId = reservationByUserId($dbh, $_SESSION['id']);
    

    foreach($reservationsByUsereId as $reservationByUsereId){
        $idReservation = $reservationByUsereId['idReservation'];
    
        $nombre = 0;
        $reservations = ReservationByReservationId($dbh, $idReservation); 

        $dateStart = $reservations[0]['jour'];
        $idChambre = $reservations[0]['chambre_id'];
        $acompte = $reservations[0]['acompte'];
        $payed = $reservations[0]['paye'];
        $priceperDay = gePriceRoom($dbh, $idChambre);
        $price = $priceperDay['prix'];
        $count = count($reservations);
        $totalPrice = $price * $count;

        $arrayIds[] = array('idChambre'=> $idChambre , 'idRservation'=> $reservationByUsereId['idReservation'], "date_de_départ" => $dateStart, 'nombre_de_jours' => $count, 'acompte'=> $acompte, 'payed'=>$payed, 'prix'=>$totalPrice);
        foreach ($reservations as $reservations){
            $nombre ++;
        }
    }


    

    foreach ($arrayIds as $arrayId){ var_dump($arrayId);?>
        <!-- <div class="">
                    <label>Chambre numéro</label>
                    <input readonly type="text" value="<?= $arrayId ?>">
                </div>
                <div class="">
                    <label>Date</label>
                    <input readonly type="date" value="<?= $day ?>">
                </div>
                <div class="">
                    <label>Acompte</label>
                    <input readonly type="text" value="<?php if ($acompte==1){echo "Il y a un acompte";}else{ echo "Il n'y a pas d'acompte";} ?>">
                </div>
                <div class="">
                    <label>Paiement</label>
                    <input readonly type="text" value="<?php if ($payed==1){echo "Chambre payée";}else{ echo "Chambre non payée";} ?>">
        </div> -->
        
        

    <?php } ?>


    <?php
}
        echo "</div>";

    ?>