<?php
require_once '../component/session.php';
if(isset($_SESSION['id'])){
    $client = getClient($dbh, $_SESSION['id']);
    if($client['type'] != "client"){
        header("Location:../index.php");
    }
}else{
    header("Location:../index.php");
}
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
        $compteurRes = 0;
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
                    $passed[$compteurRes] = array('chambre_id'=>$idChambre, 'idReservation'=>$idReservation,  'dateStart'=>$reservationDateStartFormatted, 'dateEnd'=>$reservationDateEndFormatted,'prix'=>$price, 'paye'=>$payed,'nombreDeJours'=>$count);
                }elseif ($reservationDateStart >= $today){
                    $future[$compteurRes] = array('chambre_id'=>$idChambre, 'idReservation'=>$idReservation,  'dateStart'=>$reservationDateStartFormatted, 'dateEnd'=>$reservationDateEndFormatted, 'prix'=>$price, 'paye'=>$payed,'nombreDeJours'=>$count);
                }
                $compteurRes ++;
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
                <h2 class="titre">Réservations en cours/à venir </h2>
                <a class="pdf" href="pdfViewer.php">Voir la galerie de vos PDF</a>
                <br>
                <br>
                <table>
                    <thead>
                        <tr>
                            <th class="futureTh">Numéro chambre</th>
                            <th class="futureTh">Date d'arrivée</th>
                            <th class="futureTh">Date de départ</th>
                            <th class="futureTh">Paiement</th>
                            <th class="futureTh">Télécharger</th>
                            <th class="futureTh">Mail facture</th>
                            <th class="futureTh">Prix</th>
                            <th class="futureTh">Supprimer</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($future as $future2): ?>
                            <tr>
                                <td class="futureTd" style="font-weight: bold;" class="id"><?php echo($future2['chambre_id'])?></td>
                                <td class="jour futureTd"><?php echo($future2['dateStart'])?></td>
                                <td class="jour futureTd"><?php echo($future2['dateEnd'])?></td>
                                
                                <td class="paye futureTd">  
                                    <form class='form' method="post" action="payeChambre.php">  
                                        <div>                    
                                            <?php echo ($future2['paye']? '✅' : '🔴');?>
                                        </div> 
                                        <br>
                                        <div>     
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
                                        </div>       
                                    </form> 
                                </td>
                                <td class="futureTd">
                                    <?php
                                    $idReservation = $future2['idReservation'];

                                    if($future2['paye'] == 1){ ?>
                                    <form action="Facture/<?=$_SESSION['id']?>/Facture-<?= $idReservation ?>.pdf" method="post">
                                    <button class="button" type="submit"><i class="fas fa-download"></i></button></form>
                                        <?php }else{ echo 'Payez la réservation'; }?>
                                </td>
                                <td class="futureTd">
                                    <?php if ($future2['paye'] == 1):?>
                                        <!--Le from pointe vers sendPdf.php-->
                                        <form action="sendPdf.php" method="post">
                                            <!--Je passe de manière caché pour l'utilisateur les données qui me seront nécessaires pour le traitement  -->
                                            <input type="hidden" name="idReservation" value="<?= $future2['idReservation'] ?>">
                                            <input type="hidden" name="dateStart" value="<?= $future2['dateStart']; ?>">
                                            <input type="hidden" name="prix" value="<?php echo $future2['prix'] ?>">
                                            <button class="button2" type="submit"><i class="fas fa-envelope"></i></button>
                                        </form>
                                    <?php else: ?>
                                        Payez la réservation
                                    <?php endif;?>       
                                </td>
                                <td class="futureTd"><?php echo($future2['prix'])?> €</td>
                                <td class="futureTd">
                                    <form action="delete_reservation.php" method="post">
                                        <input type="hidden" name="IdReservation" value="<?php echo($future2['idReservation'])?>">
                                        <button class="delete" type="submit">X</button>
                                    </form>
                                </td> 
                                
                            </tr>

                        <?php
                        endforeach;?>
                    
                    <tbody>
                </table>
                <br>    
                <div class="essai">
                <?php foreach ($future as $future2): ?>
                        <div class="responsive">
                            <div class="responsive2">
                                <p><span class="bold"> Numéro chambre</span> : <span><?php echo($future2['chambre_id']) ?></span></p>
                                <p><span class="bold">Date d'arrvivée</span> : <span><?php echo($future2['dateStart']) ?></span></p>
                                <p><span class="bold">Date de départ</span> : <span><?php echo($future2['dateEnd']) ?></span></p>
                                <p><form class='form' method="post" action="payeChambre.php">                         
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
                                                </form></p>
                                <div class="load">
                                    <?php
                                                $idReservation = $future2['idReservation'];

                                                if($future2['paye'] == 1){ ?>
                                                        <form class="test2" action="Facture/<?=$_SESSION['id']?>/Facture-<?= $idReservation ?>.pdf" method="post">
                                                        <button class="button" type="submit"><i class="fas fa-download"></i></button></form>
                                                <?php }else{ echo '<div class="center">Indisponible</div>'; }?>
                                                <?php if($future2['paye'] == 1){ ?>
                                                    <form class="test2" action="sendPdf.php" method="post">
                                                        <!--Je passe de manière caché pour l'utilisateur les données qui me seront nécessaires pour le traitement  -->
                                                        <input type="hidden" name="idReservation" value="<?= $future2['idReservation'] ?>">
                                                        <input type="hidden" name="dateStart" value="<?= $future2['dateStart']; ?>">
                                                        <input type="hidden" name="prix" value="<?php echo $future2['prix'] ?>">
                                                        <button class="button2" type="submit"><i class="fas fa-envelope"></i></button>
                                                    </form>
                                                <?php }else{ echo '<div class="center">Indisponible</div>'; }?>    

                                </div>    
                                <p><span class="bold">Prix</span> : <span><?php echo($future2['prix']) ?> €</span></p>
                            </div> 
                        </div>
                    <?php endforeach;?>    
                </div>        
            <?php endif;?>

            <?php if (!empty($passed)):?>

                <h2 class="titre">Réservations passées</h2>
                <br>
                <table>
                    <thead>
                    <tr>
                        <th class="passedTh">Numéro chambre</th>
                        <th class="passedTh">Date d'arrivée</th>
                        <th class="passedTh">Date de départ</th>
                        <th class="passedTh">Paiement</th>
                        <th class="passedTh">Télécharger</th>
                        <th class="passedTh">Supprimer</th>
                        <th class="passedTh">Prix</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($passed as $passed2): ?>
                        <tr>
                            <td class="passedTd" style="font-weight: bold;" class="id"><?php echo($passed2['chambre_id'])?></td>
                            <td class="jour passedTd"><?php echo($passed2['dateStart'])?></td>
                            <td class="jour passedTd"><?php echo($passed2['dateEnd'])?></td>
                            <td class="paye passedTd">                           
                                    <?php echo ($passed2['paye']? '✅' : '🔴');?>      
                            </td>
                            <td class="passedTd">
                                <?php
                            $idReservation = $passed2['idReservation'];

                                if($passed2['paye'] == 1){ ?>
                                <form action="Facture/<?=$_SESSION['id']?>/Facture-<?= $idReservation ?>.pdf" method="post">
                                <button class="button" type="submit"><i class="fas fa-download"></i></button></form>
                                    <?php }else{ echo 'Indisponible'; }?>
                            </td>
                            <td class="passedTd">
                                Pas disponible
                            </td>
                            <td class="passedTd"><?php echo($passed2['prix'])?> €</td>  
                        </tr>
                    <?php endforeach;?>
                    <tbody>
                </table>
                <br>
                <div class="essai">
                    <?php foreach ($passed as $passed2): ?>
                        <div class="responsive">
                        <div class="responsive2">
                            <p><span class="bold"> Numéro chambre</span> : <span><?php echo($passed2['chambre_id']) ?></span></p>
                            <p><span class="bold">Date d'arrvivée</span> : <span><?php echo($passed2['dateStart']) ?></span></p>
                            <p><span class="bold">Date de départ</span> : <span><?php echo($passed2['dateEnd']) ?></span></p>
                            <p><span class="bold">Payée</span> : <span><?php echo ($passed2['paye']? '✅' : '🔴');?></span>   </p>
                            <p><span class="bold">Prix</span> : <span><?php echo($passed2['prix']) ?> €</span></p>
                        </div> 
                </div>
                <?php endforeach;?>    
                </div> 



            <?php endif;?>

            <?php if (!empty($cancel)):?>

            <h2 class="titre">Réservations annulés</h2>
            <br>
            <table>
                <thead>
                <tr>
                    <th class="canceledTh">Numéro chambre</th>
                    <th class="canceledTh">Date d'arrivée</th>
                    <th class="canceledTh">Date de départ</th>
                    <th class="canceledTh">Paiement</th>
                    <th class="canceledTh">Prix</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($cancel as $cancel2): ?>
                    <tr>
                        <td class="canceledTD" style="font-weight: bold;" class="id"><?php echo($cancel2['chambre_id'])?></td>
                        <td class="jour canceledTD"><?php echo($cancel2['dateStart'])?></td>
                        <td class="jour canceledTD"><?php echo($cancel2['dateEnd'])?></td>
                        <td class="paye canceledTD">                           
                                <?php echo ($cancel2['paye']? '✅' : '🔴');?>      
                        </td>
                        <td class="canceledTD"><?php echo($cancel2['prix'])?> €</td>  
                    </tr>
                <?php endforeach;?>
                <tbody>
            </table>
            <br>

            <div class="essai">
                    <?php foreach ($cancel as $cancel2): ?>
                        <div class="responsive">
                            <div class="responsive2">
                                <p><span class="bold"> Numéro chambre</span> : <span><?php echo($cancel2['chambre_id']) ?></span></p>
                                <p><span class="bold">Date d'arrvivée</span> : <span><?php echo($cancel2['dateStart']) ?></span></p>
                                <p><span class="bold">Date de départ</span> : <span><?php echo($cancel2['dateEnd']) ?></span></p>
                                <p><span class="bold">Payée</span> : <span><?php echo ($cancel2['paye']? '✅' : '🔴');?></span>   </p>
                                <p><span class="bold">Prix</span> : <span><?php echo($cancel2['prix']) ?> €</span></p>
                            </div> 
                        </div>
                        <?php endforeach;?>    
                </div> 


            <?php endif;?>

    <?php
         ?>


    
    <?php

        echo "</div>";

    ?>
    <?php require_once '../component/footer.php';?>
    <style>
    .btn{
        border: none;
        border-radius: 15px;
        background: linear-gradient(to right, #19B3D3, #1992d3, #196ad3);
        color: white;
        padding: 10%;
        cursor: pointer;
    }
    <?php
    
    if(($compteur+$compteurRes)>4): ?>
    .content{
        height: 100%;
    }
    
    <?php endif; ?>
    .content{
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    table{
        width: 90%;
        border: 1px solid black;
        border-collapse: collapse;
    }
    .futureTd, .futureTh{
        width: 11%;
    }
    td, th{
        text-align: center;
        border: 1px solid black;
        padding-top : 2%;
        padding-bottom : 2%;
        
    }
    .titre{
        text-decoration: underline;
        font-style: italic;
        width: 90%;
    }
    .pdf{
        color: black;
        font-size: 15px;
        text-decoration: none;
        width: 90%;
        margin-bottom: 2%;
    }
    .form{
        margin : 0px
    }
    .button{
        background: linear-gradient(to right, #19B3D3, #1992d3, #196ad3);
        border: none;
        border-radius: 8px;
        padding: 4%;
        color: white;
        cursor: pointer;
    }
    .button2{
        background: linear-gradient(to right, #19B3D3, #1992d3, #196ad3);
        border: none;
        border-radius: 8px;
        padding: 5%;
        color: white;
        cursor: pointer;
    }
    .delete{
        background: linear-gradient(to right, red, #C20808);
        border: none;
        border-radius: 10px;
        padding: 8%;
        color: white;
        cursor: pointer;
    }
    @media screen and (max-width : 780px){
        .content{
           margin-top: 60px; 
           margin-bottom: 60px; 
        }
    }
    @media screen and (max-width : 1100px){
        table{
            display: none;
        }
        .essai{
            width: 80%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .btn{
        border: none;
        border-radius: 15px;
        background: linear-gradient(to right, #19B3D3, #1992d3, #196ad3);
        color: white;
        padding: 3%;
        }
        .responsive{
            width: 100%;
            display: flex;
            justify-content: center;
            margin-bottom: 8%;
        }
        .responsive2{
            /* background-color: white; */
            width: 100%;
            text-align: center;
            border: 1px solid;
            border-radius: 20px;
            padding: 5%;
        }
        .bold{
            font-weight: 700;
        }
        .load{
            display: flex;
            flex-direction: row;
            justify-content: space-around;
            align-items: center;
        }
        .test2{
            height: 100%;
            background-color: none;
            width: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .center{
            display: flex;
            justify-content: center;
            width: 50%;
        }
        .pdf{
            margin: 0px;
        }
    }
    @media screen and (min-width : 1100px){
        .responsive{
            display: none;
        }
        
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
        .button2{
            padding: 4%;
        }
        
    }
    <?php if($_SESSION['theme']=="sombre"):?>
  
    td, th{
        border: 1px solid grey;
    }
    .pdf{
        color: white;
    }

    <?php endif;?>
    </style>