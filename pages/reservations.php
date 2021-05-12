<?php
require_once '../component/session.php';
require_once '../component/header.php';
require_once '../functions/sql.php';
require_once '../functions/functions.php';
require_once 'bdd.php';

$compteur = 0;
if (isset($_SESSION['id'])){
    echo '<div class="content">';
    $uid = $_SESSION['id'];
    $client = getClient($dbh, $uid);
    $lname = $client['nom'];
    $fname = $client['prenom'];
    // $count = countReservations($dbh, $uid);
    $rlists = getReservations($dbh, $uid);
    $i = 0;
    if(!empty($rlists)){
        
        $reservationsByUsereId = reservationByUserId($dbh, $_SESSION['id']);
        foreach($reservationsByUsereId as $reservationByUsereId){
            $idReservation = $reservationByUsereId['idReservation'];
        
            $nombre = 0;
            $reservations = ReservationByReservationId($dbh, $idReservation); 

            $dateStart = $reservations[0]['jour'];
            $idChambre = $reservations[0]['chambre_id'];
            $payed = $reservations[0]['paye'];
            $priceperDay = getPriceRoom($dbh, $idChambre);
            $price = $priceperDay['prix'];
            $count = count($reservations);
            $totalPrice = $price * $count;

            $arrayIds[] = array('idChambre'=> $idChambre , 'idReservation'=> $reservationByUsereId['idReservation'], "dateDeDepart" => $dateStart, 'nombreDeJours' => $count,  'payed'=>$payed, 'prix'=>$totalPrice);
            
        }


        // foreach ($arrayIds as $arrayId){ var_dump($arrayId);

                
            $todays = date("Y-m-d");
            $today = New DateTime("$todays");   
            $compteur = 0;
            foreach ($arrayIds as $arrayId){
                $jour = $arrayId['dateDeDepart'];
                $reservationDateStart = new DateTime("$jour");
                $reservationDateStartFormatted = $reservationDateStart->format('Y-m-d');
                $reservationDateEnd = $reservationDateStart;
                $reservationDateEnd-> add(new DateInterval("P$arrayId[nombreDeJours]D"));
                $reservationDateEndFormatted = $reservationDateEnd->format('Y-m-d');
                if ($reservationDateEnd < $today){
                    $passed[$compteur] = array('chambre_id'=>$arrayId['idChambre'], 'idReservation'=>$arrayId['idReservation'],  'dateStart'=>$reservationDateStartFormatted, 'dateEnd'=>$reservationDateEndFormatted,'prix'=>$arrayId['prix'], 'paye'=>$arrayId['payed'],'nombreDeJours'=>$arrayId['nombreDeJours']);
                }elseif ($reservationDateStart >= $today){
                    $future[$compteur] = array('chambre_id'=>$arrayId['idChambre'], 'idReservation'=>$arrayId['idReservation'],  'dateStart'=>$reservationDateStartFormatted, 'dateEnd'=>$reservationDateEndFormatted, 'prix'=>$arrayId['prix'], 'paye'=>$arrayId['payed'],'nombreDeJours'=>$arrayId['nombreDeJours']);
                }
                $compteur ++;
            }
            if (!empty($future)):?>
                <h2 class="futur">Réservations en cours/à venir <a href="pdfViewer.php">Voir la galerie de vos PDF</a></h2>
                <br>
                <table>
                    <thead>
                        <tr>
                            <th>Numéro chambre</th>
                            <th>Date d'arrivée</th>
                            <th>Date de départ</th>
                            <th>Chambre payée</th>
                            <th>Télécharger la facture</th>
                            <th>Mail de la facture</th>
                            <th>Supprimer</th>
                            <th>Prix</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($future as $future2): ?>
                            <tr>
                                <td style="font-weight: bold;" class="id"><?php echo($future2['chambre_id'])?></td>
                                <td class="jour"><?php echo($future2['dateStart'])?></td>
                                <td class="jour"><?php echo($future2['dateEnd'])?></td>
                                
                                <td class="paye">  
                                    <form class='form' method="post" action="payeChambre.php">                         
                                        <?php echo ($future2['paye']? '✅' : '🔴');?>
                                        <?php if ($future2['paye'] == '0'):?>
                                            <input type="hidden" name="idReservation" value="<?php echo($future2['idReservation'])?>">
                                            <input type="submit" class="btn btn-info" value="Payer">
                                            <input type="hidden" name="dateStart" value="<?php echo $future2['dateStart'] ?>">
                                            <input type="hidden" name="dateEnd" value="<?php echo $future2['dateEnd'] ?>">
                                            <input type="hidden" name="chambre_id" value="<?php echo $future2['chambre_id'] ?>">
                                            <input type="hidden" name="nombreDeJours" value="<?php echo $future2['nombreDeJours'] ?>">
                                            <input type="hidden" name="prix" value="<?php echo $future2['prix'] ?>">
                                            <input type="hidden" name="lname" value="<?php echo $lname ?>">
                                            <input type="hidden" name="fname" value="<?php echo $fname ?>">
                                        <?php endif;?>     
                                    </form> 
                                </td>
                                <td>
                                    <?php
                                    $idReservation = $future2['idReservation'];

                                    if($future2['paye'] === 1){ ?>
                                    <form action="Facture/<?=$_SESSION['id']?>/Facture-<?= $idReservation ?>.pdf" method="post">
                                        <input type="submit" name="download" value="Télécharger"></form>
                                        <?php }else{ echo 'Payez la réservation'; }?>
                                </td>
                                <td>
                                    <!--Le from pointe vers sendPdf.php-->
                                    <form action="sendPdf.php" method="post">
                                        <!--Je passe de manière caché pour l'utilisateur les données qui me seront nécessaires pour le traitement  -->
                                        <input type="hidden" name="idReservation" value="<?= $future2['idReservation'] ?>">
                                        <input type="hidden" name="dateStart" value="<?= $future2['dateStart']; ?>">
                                        <input type="hidden" name="prix" value="<?php echo $future2['prix'] ?>">
                                        <input type="submit" name="sendMail" value="Pdf par mail">
                                    </form>
                                </td>
                                <td>
                                    <button>X</button>
                                    <!-- <form action="" method="post">
                                        <input type="hidden" name="chambreId" value="<?php echo($future2['chambre_id'])?>">
                                        <input type="hidden" name="day" value="<?php echo($future2['jour'])?>">
                                        <input type="hidden" name="clientId" value="<?php echo($_SESSION['id'])?>">
                                        <input type="submit" class="btn btn-danger" value="X">
                                    </form> -->
                                </td> 
                                <td><?php echo($future2['prix'])?> €</td>
                            </tr>

                        <?php
                        endforeach;?>
                    
                    <tbody>
                </table>
                <br>
            <?php endif;?>

            <?php if (!empty($passed)):?>

                <h2 class="futur">Réservations passées</h2>
                <br>
                <table>
                    <thead>
                    <tr>
                        <th>Numéro chambre</th>
                        <th>Date d'arrivée</th>
                        <th>Date de départ</th>
                        <th>Chambre payé</th>
                        <th>Télécharger la facture</th>
                        <th>Supprimer</th>
                        <th>Prix</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($passed as $passed2): ?>
                        <tr>
                            <td style="font-weight: bold;" class="id"><?php echo($passed2['chambre_id'])?></td>
                            <td class="jour"><?php echo($passed2['dateStart'])?></td>
                            <td class="jour"><?php echo($passed2['dateEnd'])?></td>
                            <td class="paye">                           
                                    <?php echo ($passed2['paye']? '✅' : '🔴');?>      
                            </td>
                            <td>
                                <?php echo ($passed2['paye']? '<form action=""method="get"><input type="submit" name="download" id=""></form>' : 'Indisponible');?>
                            </td>
                            <td>
                                Pas disponible
                            </td>
                            <td><?php echo($passed2['prix'])?> €</td>  
                        </tr>
                    <?php endforeach;?>
                    <tbody>
                </table>
                <br>



            <?php endif;?>

    <?php
        } ?>


    
    <?php
}
        echo "</div>";

    ?>
    <style>

    table{
        width: 80%;
        margin-left: 10%;
        border: 1px solid black;
        border-collapse: collapse;
    }
    td, th{
        text-align: center;
        border: 1px solid black;
        padding-top : 2%;
        padding-bottom : 2%;
    }
    .futur{
        text-decoration: underline;
        font-style: italic;
        margin-left: 10%;
    }
    .futur a{
        color: blue;
        font-size: 15px;
        text-decoration: none;
    }
    .form{
        margin : 0px
    }
    @media screen and (max-width : 900px){
        table{
            font-size: 0.5rem;
        }
        
    }
    @media screen and (max-width : 500px){
        table{
            font-size: 0.4rem;
        }
        
    }
    <?php if($_SESSION['theme']=="sombre"):?>
  
    td, th{
        border: 1px solid grey;
    }

    <?php endif;?>
    </style>