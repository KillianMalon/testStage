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
    //récupération de toutes les réservations d'un client
    $reservationsByUsereId = reservationByUserId($dbh, $_SESSION['id']);
    $i = 0;
    //nous vérifions que le client a bien des réservations aavant de les afficher
    if(!empty($reservationsByUsereId)){
        //Ce compteur va me permettre d'indexer les tableau suivant
        $compteur = 0;
        foreach($reservationsByUsereId as $reservationByUsereId){
            $idReservation = $reservationByUsereId['idReservation'];
            //pour chaque réservation nous récupérons toutes les infos associés
            $reservations = ReservationByReservationId($dbh, $idReservation); 
            $dateStart = $reservations[0]['jour'];
            $idChambre = $reservations[0]['chambre_id'];
            $payed = $reservations[0]['paye'];
            $priceperDay = getPriceRoom($dbh, $idChambre);
            $price = $priceperDay['prix'];
            //Grâce à count je compte le nombre d'apparition de l'idReservation dans la table et j'obtiens le nombre de jours que contient la reservation
            $count = count($reservations);
            //ce count me permet d'obtenir le prix total
            $totalPrice = $price * $count;
            
            //je récupére la date d'aujourd'hui
            $todays = date("Y-m-d");
            $today = New DateTime("$todays");   
            
            //Grâce à la date d'arrivée et le nombre de jours je peux obtenir la date de départ par ajout du $count
                $jour = $dateStart;
                $reservationDateStart = new DateTime("$jour");
                $reservationDateStartFormatted = $reservationDateStart->format('Y-m-d');
                $reservationDateEnd = $reservationDateStart;
                $reservationDateEnd-> add(new DateInterval("P".$count."D"));
                $reservationDateEndFormatted = $reservationDateEnd->format('Y-m-d');
                //Grâce à la date du jour mais aussi grâce à la de départ je peux voir si une réservation est passée est en fonction de cela je met celle-ci dans un tableau différent
                if ($reservationDateEnd < $today){
                    $passed[$compteur] = array('chambre_id'=>$idChambre, 'idReservation'=>$idReservation,  'dateStart'=>$reservationDateStartFormatted, 'dateEnd'=>$reservationDateEndFormatted,'prix'=>$price, 'paye'=>$payed,'nombreDeJours'=>$count);
                }elseif ($reservationDateStart >= $today){
                    $future[$compteur] = array('chambre_id'=>$idChambre, 'idReservation'=>$idReservation,  'dateStart'=>$reservationDateStartFormatted, 'dateEnd'=>$reservationDateEndFormatted, 'prix'=>$price, 'paye'=>$payed,'nombreDeJours'=>$count);
                }
                $compteur ++;
            }  
        }
        
        //M^me principe qu'au dessus mais pour les réservtaions annulés
        $reservationsByUsereIdCancel = reservationByUserIdCancel($dbh, $_SESSION['id']);
        if(!empty($reservationsByUsereIdCancel)){
            $compteur = 0;
            foreach($reservationsByUsereIdCancel as $reservationByUsereIdCancel){
                $idReservation = $reservationByUsereIdCancel['idReservation'];
                $reservations = ReservationByReservationIdCancel($dbh, $idReservation); 
                $dateStart = $reservations[0]['jour'];
                $idChambre = $reservations[0]['chambre_id'];
                $payed = $reservations[0]['paye'];
                $priceperDay = getPriceRoom($dbh, $idChambre);
                $price = $priceperDay['prix'];
                $count = count($reservations);
                $totalPrice = $price * $count;
                    $jour = $dateStart;
                    $reservationDateStart = new DateTime("$jour");
                    $reservationDateStartFormatted = $reservationDateStart->format('Y-m-d');
                    $reservationDateEnd = $reservationDateStart;
                    $reservationDateEnd-> add(new DateInterval("P".$count."D"));
                    $reservationDateEndFormatted = $reservationDateEnd->format('Y-m-d');

                $cancel[$compteur] = array('chambre_id'=>$idChambre, 'idReservation'=>$idReservation,  'dateStart'=>$reservationDateStartFormatted, 'dateEnd'=>$reservationDateEndFormatted, 'prix'=>$price, 'paye'=>$payed,'nombreDeJours'=>$count);
                $compteur ++;
                }  
            }
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
                                    <form action="delete_reservation.php" method="post">
                                        <input type="hidden" name="IdReservation" value="<?php echo($future2['idReservation'])?>">
                                        <input type="submit" class="btn btn-danger" value="X">
                                    </form>
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

            <?php if (!empty($cancel)):?>

            <h2 class="futur">Réservations annulés</h2>
            <br>
            <table>
                <thead>
                <tr>
                    <th>Numéro chambre</th>
                    <th>Date d'arrivée</th>
                    <th>Date de départ</th>
                    <th>Chambre payé</th>
                    <th>Prix</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($cancel as $cancel2): ?>
                    <tr>
                        <td style="font-weight: bold;" class="id"><?php echo($cancel2['chambre_id'])?></td>
                        <td class="jour"><?php echo($cancel2['dateStart'])?></td>
                        <td class="jour"><?php echo($cancel2['dateEnd'])?></td>
                        <td class="paye">                           
                                <?php echo ($cancel2['paye']? '✅' : '🔴');?>      
                        </td>
                        <td><?php echo($cancel2['prix'])?> €</td>  
                    </tr>
                <?php endforeach;?>
                <tbody>
            </table>
            <br>



            <?php endif;?>

    <?php
         ?>


    
    <?php

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