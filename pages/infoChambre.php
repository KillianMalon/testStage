<?php
require_once '../component/header.php';
require_once '../functions/functions.php';
require_once '../functions/sql.php';
require_once  'bdd.php';

//Si le formulaire a bien été envoyé, on stock les informations en local
if(!empty($_POST['start']) && !empty($_POST['end']) && !empty($_POST['idChambre']) && !empty($_POST['capacity']) && !empty($_POST['numberAdult']) && isset($_POST['numberChild'])){

    $start = $_POST['start'];
    $end = $_POST['end'];
    $capacity = $_POST['capacity'];

    $trueStartDate = checkDateFormat($start);
    $trueEndDate = checkDateFormat($end);

    $numberAdult = intval($_POST['numberAdult']);
    $numberChild = checkCapacityChild($_POST['numberChild']);



    if ($trueStartDate == 1 && $trueEndDate == 1 && !empty($numberAdult) && !empty($numberChild)){
        if (!empty($_GET['id'])) {
            $numeroChambre = $_GET["id"];
            $capacite2 = getCapacity($dbh, $numeroChambre);
            if (!empty($capacite2)) {
                $capacite3 = $capacite2[0];
            }
        }
        $capacite = $numberAdult + $numberChild;
        if ($capacite <= $capacite3['capacite']) {
            $dateStart = new DateTime("$start");
            $dateEnd = new DateTime("$end");
            $dateStartFormatted = $dateStart->format('Y-m-d H:i:s');
            $dateEndFormatted = $dateEnd->format('Y-m-d H:i:s');
            if ($dateStart < $dateEnd) {
                $diff = $dateStart->diff($dateEnd);
                $diffFormatted = $diff->format('%M');

                if ($diffFormatted < 1) {

                    while ($dateStart < $dateEnd) {
                        $id = $_GET['id'];
                        $reservationsCheck = checkReservationsEmpty($dbh, $dateStartFormatted, $id);
                        if (!empty($reservationsCheck)) {
                            $arrayCheck = array($reservationsCheck[0]['jour']);
                        }
                        $dateStart->add(new DateInterval('P1D'));
                    }
                    if (empty($arrayCheck)) {
                        $_SESSION['chambreId'] = $_GET['id'];
                        $_SESSION['start'] = $dateStartFormatted;
                        $_SESSION['end'] = $dateEndFormatted;
                        $_SESSION['numberAdult'] = $numberAdult;
                        $_SESSION['numberChild'] = $numberChild;
                        if (!empty($_SESSION['start']) && !empty($_SESSION['end']) &&  !empty($_SESSION['chambreId'])  &&  !empty($_SESSION['numberAdult']) && isset($_SESSION['numberChild'])) {
                        header('Location:./confirmReservation.php');
                        }
                    }
                }
            }
        }
    }
}
if(!empty($_POST['textarea'])){
    $id = $_SESSION['id'];
    $idChambre = $_GET['id'];

    $today2 = new DateTime();
    $today2Formatted = $today2->format('Y-m-d H:i:s');
    $contenu = $_POST['textarea'];
    addCommentary($dbh, $id, $idChambre, $contenu, $today2Formatted);
    
}
?>
<!-- Style de la page -->
<style>
    .form2{
        box-shadow: 1px 1px 12px #555;
        border-radius: 20px;
    }
    .h5{
        text-decoration: underline;
    }
    .container{
    display: flex;
    flex-direction: column;
    justify-content: center;
    width: 90%;
    margin-left: 5%;
    }
    img{
    width: 45%;
    }
    .souligne{
        text-decoration : underline;
        margin-top: 5%;
    }
    .textarea{
       background-color: #ececec;
       border-bottom: none;
       border-radius: 10px 10px 0px 0px;
    }
    .form{
        width : 90%;
        margin-left: 5%;
    }
    textarea{
        resize : none;
    }
    .text{
        display: flex;
        justify-content: center;
    }
    .texte{
        margin-left: 10%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: left;
    }
    .titre{
        display: flex;
        flex-direction: column;
    }
    .decale2{
        margin-right: 1%;
    }
    .commentaire{
        display: flex;
        flex-direction: row;
        width: 100%;
    }
    .centre{
        text-align: center;
        width: 75%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .bold{
        font-size: larger;
    }
    .button{
        padding: 4%;
        border-radius: 15px;
        border: none;
        background: linear-gradient(to right, #19B3D3, #1992d3, #196ad3);
        cursor:pointer;
        color: white;
        transition: background-color 500ms ease-out;
        box-shadow: 0px 0px 0px;
    }
    .button:hover{
        box-shadow: 1px 1px 12px #555;
        /*box-shadow: 2px 2px 12px grey;*/
    }
    .reserver{
        width: 100%;
    }
    .image{
        border-radius: 13px;
    }
    .formulaire{
    display: flex;
    flex-direction: column;
    align-items: center;
    color: grey;
    }
    .date, .capacity, .exposition{
        display: flex;
        flex-direction: row;
        /* justify-content: space-around; */
        text-align: left;
    }
    .date{
        border: 1px solid #c7ccd4;
        border-radius: 20px 20px 0px 0px;
    }
    .capacity{
        border-right: 1px solid #c7ccd4;
        border-left: 1px solid #c7ccd4;  
    }
    .exposition{
        border: 1px solid #c7ccd4;
        border-bottom: none;
    }
    .capacity2{
        display: flex;
        flex-direction: column;
    }
    .exposition2{
        display: flex;
        flex-direction: column;
    }
    .capacity2, .exposition2, .date2{
        padding: 7%;
        width: 100%;
    }
    .label{
        margin-bottom: 5%;
    }
    .input{
        margin-top: 5%;
    }
    .input, .select{
        border: 1px solid #c7ccd4;
        padding: 10%;
        background-color: #ececec;
        border-radius: 10px;
        cursor: pointer;
    }
    .line{
        border-right: 1px solid #c7ccd4;
    }
    .bouton{
    width: 100%;
    border-radius: 0px 0px 20px 20px;
    border: none;
    background: linear-gradient(to right, #19B3D3, #1992d3, #196ad3);
    cursor: pointer;
    color: white;
    font-size: large;
    padding: 5%;    
    }
    .bouton:hover{
        box-shadow: 2px 2px 12px grey;
    }
    .picture{
        display: flex;
        flex-direction: row;
        
    }
    .favoriteButton{
    background-color: #ececec;
    border: none;
    }
    #addFavorite{
    font-size: 25px;
    cursor: pointer;
    color: white;
    }
    #addFavorite {
    color: #a1a1a1;

    }
    #removeFavorite{
    color: red;
    font-size: 25px;
    color: #9c47fc;
    display: block;
    background: -webkit-linear-gradient(#19B3D3, #1992d3, #196ad3);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    cursor: pointer;
    }
    .formFavoris{
        margin-top: 0%;
        display: flex;
        align-items: center;
    }
    .favoris{
        display: flex;
        flex-direction: row;
    }
    .submit{
        cursor: pointer;
        padding: 1%;
        border: none;
        color: #ececec;
        border-radius: 0px 0px 10px 10px;
        background: linear-gradient(to right, #19B3D3, #1992d3, #196ad3);
    }
    .commentary{
        width: 90%;
        margin-left: 5%;
    }
    .formCommentary{
        display: flex;
        flex-direction: column;
    }
    .p{
        text-align: center;
        font-weight: bold;
        font-size: x-large;
    }
</style>

<!-- PARTIE POUR LA MISE EN FAVORIS-->

<?php
            $chambreId = $_GET['id'];
            if(!empty($_SESSION['id'])){
                $id = $_SESSION['id'];
                    if(isset($_POST['addFavorite'])){
                        addFavorite($dbh, $id,$chambreId);
                        ?>
                        <meta http-equiv="refresh" content="0">
                    <?php 
                    }
                    if(isset($_POST['removeFavorite'])){
                        $favoriteInformation = getFavorite($dbh,$id,$chambreId);
                        $favoriteId = $favoriteInformation['id'];
                        removeFavorite($dbh, $favoriteId);
                    ?>
                        <meta http-equiv="refresh" content="0">
                    <?php
                    }
                ?>
                
            <?php } ?>      
<!-- FIN DE LA PARTIE MISE EN FAVORIS--> 

<?php
//Récupération des informations d'une chaambre s'il y a un GET avec un id de chambre
if (!empty($_GET['id'])) {
    $numeroChambre = $_GET["id"];

    AddOneView($dbh, $numeroChambre);
    $todayYearAndMonth = date("y-m");
    $allMonth = getAllMonth($dbh);
    $trueDate = date("y-m-01");
    $no = 0;
    $ok =0;
    foreach($allMonth as $month){
        $date = $month['mois'];
        $yearAndMonth = substr($date,2,-3);
        if($yearAndMonth === $todayYearAndMonth){
            AddOneGlobalView($dbh,$trueDate);
            $ok = 1;
        }else{
            $no = 1;
        }
    }
if($no === 1 AND $ok === 0){
    insertOneMonth($dbh,$trueDate);
}
    $chambre = getRoom($dbh, $numeroChambre);
    if (!empty($chambre)) {
        $chambres = $chambre[0];
    
    }
}
?>
<?php
$today =date("Y-m-d");

$tomorrow  = new DateTime();

$tomorrow->add(new DateInterval('P1D'));

$tomorrowFormatted = $tomorrow->format('Y-m-d');

if(!empty($_SESSION['id'])){
    $client_id = $_SESSION['id'];
    $chambre_id = $_GET['id'];

    $reservationByUserIdAndRoomId = reservationByUserIdAndRoomId($dbh, $client_id, $chambre_id);



foreach($reservationByUserIdAndRoomId as $reservationByUserIdAndRoomIds){
    $idReservation = $reservationByUserIdAndRoomIds['idReservation'];
    $nombre = 0;
    $reservations = ReservationByReservationId($dbh, $idReservation); 
    $dateStart = $reservations[0]['jour'];
    $idChambre = $reservations[0]['chambre_id'];
    $payed = $reservations[0]['paye'];
    $priceperDay = getPriceRoom($dbh, $idChambre);
    $price = $priceperDay['prix'];
    $count = count($reservations);
    $totalPrice = $price * $count;
    $arrayIds[] = array('idChambre'=> $idChambre , 'idReservation'=> $reservationByUserIdAndRoomIds['idReservation'], "dateDeDepart" => $dateStart, 'nombreDeJours' => $count,  'payed'=>$payed, 'prix'=>$totalPrice);
}
$todays = date("Y-m-d");
            $today3 = New DateTime("$todays");   
            $compteur = 0;
            if(!empty($arrayIds)){
                foreach ($arrayIds as $arrayId){
                    $jour = $arrayId['dateDeDepart'];
                    $reservationDateStart = new DateTime("$jour");
                    $reservationDateStartFormatted = $reservationDateStart->format('Y-m-d');
                    $reservationDateEnd = $reservationDateStart;
                    $reservationDateEnd-> add(new DateInterval("P$arrayId[nombreDeJours]D"));
                    $reservationDateEndFormatted = $reservationDateEnd->format('Y-m-d');
                    if ($reservationDateEnd < $today3){
                        $passed[$compteur] = array('chambre_id'=>$arrayId['idChambre'], 'idReservation'=>$arrayId['idReservation'],  'dateStart'=>$reservationDateStartFormatted, 'dateEnd'=>$reservationDateEndFormatted,'prix'=>$arrayId['prix'], 'paye'=>$arrayId['payed'],'nombreDeJours'=>$arrayId['nombreDeJours']);
                    }
                    $compteur ++;
                }
            }    
} 


?>

<?php if (!empty($chambres)):?>
    <div class="content">
        <br><br>
        <!-- Affichage de ces informations -->   
            
        <div class="container">
            <div class="favoris">
                <h2 >Chambre <?php echo $numeroChambre;?></h2>
                <form action="" class="formFavoris" method="post">
                    <?php
                    if(!empty($_SESSION['id'])){
                        $result = countFavorite($dbh,$id,$chambreId);
                        if($result === 1){
                            ?>
                            <button type="submit" name="removeFavorite" class="favoriteButton" ><i class="fas fa-bookmark" id="removeFavorite"></i></button>
                        <?php
                        }else if($result === 0){
                            ?>
                            <button type="submit" name="addFavorite"class="favoriteButton" ><i class="fas fa-bookmark" id="addFavorite"></i></button>
                        <?php
                        }
                    }    
                    ?>
                </form>
            </div>    
            <div class="picture">
                <img class="image" src="<?php echo($chambres['image'])?>" class="card-img-top" style="height: 100%;" alt="...">
                <div class="texte">
                        
                        <p class="card-text"><?php echo ($chambres['description']);?></p>
                        <p>Catégorie : <?php echo $chambres['libelle'];?></p>
                        <p>Etage : <?php echo ($chambres['etage']);?></p>
                        <p>Equipement : <?php echo ($chambres['douche']);?> douche</p>
                        <p>Capacité : <?php echo ($chambres['capacite']);?></p>
                        <p>Exposition : <?php echo ($chambres['exposition']);?></p>
                        <h4><?php echo ($chambres['prix']);?>€</h4>

                        <?php if(!empty($_POST['start']) && !empty($_POST['end'])) {
                            if (!empty($diffFormatted)&&$diffFormatted >= 1){
                                echo "<br><strong><h5 class='h5'>Veuillez rensiegner une durée de séjour d'un mois maximum</h5></strong>";
                            }elseif (!isset($diffFormatted)){
                                echo "<br><strong><h5 class='h5'>Veuillez rensiegner une date de départ supérieur à la date d'arrivée</h5></strong>";
                            }elseif (!empty($arrayCheck)){
                                echo "<br><strong><h5 class='h5'>Une date ou toutes les dates sélectionnés sont déja réservées</h5></strong>";
                            }
                        }?>
                    </div>    
                    <br>
            </div>
            <div class="text">
                    

                <?php if(isset($_SESSION['id'])){
                            $user = getClient($dbh, $_SESSION['id']);
                            $isAdmin = $user['type'];
                            if($isAdmin != "admin"){ ?>
                            <div class="formulaire">
                                <form class="form2" method="post" >
                                        <div class="date">
                                            <div class="date2 line">
                                                <label class='label' for="" >Date d'arrivée</label class='label'>
                                                <input class="input" type="date" name="start" value="<?php echo $today?>" min="<?php echo $today?>" >
                                            </div>
                                            <div class="date2">
                                                <label class='label' for="start" >Date de départ</label class='label'>
                                                <input class="input" type="date" name="end" value="<?php echo $tomorrowFormatted?>" min="<?php echo $tomorrowFormatted?>">
                                            </div>
                                        </div>


                                        <div class="capacity">
                                            <div class="capacity2 line">
                                                <label class='label' for="start">Nombres d'adultes</label class='label'>
                                                <select class="select"   name="numberAdult" required>
                                                    <option selected disabled value="">Choisir ...</option>
                                                    <?php for ($i = 1; $i <= $chambres['capacite']; $i++):?>
                                                        <option><?php echo $i ?></option>
                                                    <?php endfor;?>
                                                </select>
                                            </div>
                                            <div class="capacity2" >
                                                <label class='label' for="start">Nombres d'enfants</label class='label'>
                                                <select class="select" name="numberChild" required>
                                                    <option selected disabled value="">Choisir ...</option>
                                                    <?php for ($i = 0; $i <= $chambres['capacite']; $i++):?>
                                                        <option><?php echo $i ?></option>
                                                    <?php endfor;?>
                                                </select>
                                            </div>
                                        </div>    
                                    
                                    <div class="boutton">
                                            <input type="number" name="idChambre" hidden="hidden" value="<?php echo($chambres['id']); ?>">
                                            <input type="number" name="capacity" hidden="hidden" value="<?php echo($chambres['capacite']); ?>">
                                            <input type="submit"  class="bouton" value="Réserver">
                                        <?php  }else{ $id = intval($_GET['id']);?>
                                                        <a href="modifRoom.php?room=<?php echo $id ?>">Modifier</a>
                                        <?php } ?>   
                                    </div>
                                </form>
                            </div>    
                <?php } ?>  
            </div>  
            
        </div>
            <?php 
                if(!empty($_SESSION['id'])){
                    $client_id = $_SESSION['id'];
                    $chambre_id = $_GET['id'];
                    $reservations = getLastReservationRoom($dbh, $client_id, $chambre_id);
                } 
            ?>
        <div class='form'>
            <h2 class='souligne'>Commentaires</h2>
            <?php if(!empty($passed)){
                
                $search = $passed[0];
                $idClient = $_SESSION['id'];
                $idRoom2 = $search['chambre_id'];

                $getSearch = getSearchIfClientPostCommentary($dbh,$idClient, $idRoom2);
                if(empty($getSearch)){?>  
                 
                    <form class="formCommentary" action="" method="POST">
                        <label for=""></label class='label'>
                        <textarea name="textarea" class='textarea' id="" cols="30" rows="10" placeholder='Ajoutez votre commentaire'></textarea>
                        <input type="submit" class="submit" value="Ajouter votre commentaire">
                    </form>

            <?php }
        
            }?>
        
        
        </div>
        <div class="commentary">

            <?php 
            
                $idRoom = $_GET['id'];
                $commentarys = getRoomCommentary($dbh, $idRoom);
                if(!empty($commentarys)): ?>
                <br><br><br>
                <hr class=hr>
                    <?php foreach ($commentarys as $commentary):?>   
                        <?php $jour = new DateTime("$commentary[date]");
                            $jourFormatted = $jour->format('d-m-Y');
                        ?>
                        <div class="commentaire">
                           
                            <div class="titre">
                                <h4 class="decale2"><?php echo $commentary['prenom']." ".$commentary['nom']?></h4>
                                <p>Publiée le <?php echo $jourFormatted?></p>
                            </div>
                            <div class="centre"><p class="bold"><?php echo $commentary['contenu']?></p></div>
                            
                        </div>
                        <hr>
                    <?php endforeach;?>
                <?php else:?>
                    <br><br><br>
                <hr class=hr>
                    <div class="noCommentaire"><p class="p">Aucun commentaire pour le moment</p></div>
                    <br><br><br><br>
                <?php endif;?>
        </div>
    </div>
    <br><br><br>    
<?php else: ?>
    <div class="bass">
        <p> Aucune chambre trouvée</p>
    </div>
<?php endif;?>