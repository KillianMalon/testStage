<?php
require_once '../component/session.php';
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
    ?>
    <meta http-equiv="refresh" content="0">
        <?php
}
require_once '../component/header.php';

?>
<!-- Style de la page -->
<style>
    .content{
        height: 100%;
        }
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
        margin-top: 50px;
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
    @media screen and (max-width:780px){
        .picture{
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        img{
            width: 75%;
        }
        .favoris{
            justify-content: center;
        }
        .texte{
            /* margin-left: 0px; */
        }

    }
    @media screen and (max-width:695px){
        .commentaire{
            display: flex;
            flex-direction: column;
        }
        .titre{
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
        .centre{
            width: 100%;
        }
    }
    @media screen and (max-width:600px){
        .date, .capacity, .exposition{
            display: flex;
            flex-direction: column;
            /* justify-content: space-around; */
            text-align: left;
        }
        .date2{
            display: flex;
            flex-direction: column;
            border-top: 1px solid #cecece;
        }
        .capacity2{
            border-top: 1px solid #cecece;
        }
        .line{
            border: none;
        }
        .formulaire{
            width: 100%;
        }
        .form2{
            width: 80%;
        }
        .input, .select{
            padding: 5%;
            width: 80%;
            margin-top: auto;
        }
        .capacity2, .exposition2, .date2 {
            width: auto;
            align-items: center;
        }
        .select{
            width: 90%;
        }
    }
    <?php if($_SESSION['theme']=="sombre"):?>
            .favoriteButton{
                background-color: #222;
            }
            .input, .select{
                background-color: #464644;
                color: #ececec;
            }
            .textarea{
                background-color: #464644;
                color: white;
            }
    <?php endif;?>   
    
  
</style>

<!--============= PARTIE POUR LA MISE EN FAVORIS =======================================-->

<?php
            $chambreId = $_GET['id'];
            // on vérifie que l'utilisateur est connecté
            if(!empty($_SESSION['id'])){
                $id = $_SESSION['id'];
                //puis si l'utilisateur à bien cliqué sur le bouton de favoris
                    if(isset($_POST['addFavorite'])){
                        addFavorite($dbh, $id,$chambreId);
                        ?>               <meta http-equiv="refresh" content="0">
                    <?php 
                    }
                    //vérifie si l'utilisateur à bien cliqué sur le bouton remove qui apprait comme étant le même que l'ajout
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
<!--======================= FIN DE LA PARTIE MISE EN FAVORIS ========================================-->

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
            <!--==================== AFFICHAGE DU BOUTON DE FAVORIS ================================-->
            <div class="favoris">
                <h2 > <?= $lang['room']; ?>  <?php echo $numeroChambre;?></h2>
                <form action="" class="formFavoris" method="post">
                    <?php
                    //on vérifie que l'utilisateur est connecté
                    if(!empty($_SESSION['id'])){
                        //on vérifie qu'il a mis en favoris cette chambre
                        $result = countFavorite($dbh,$id,$chambreId);
                        if($result === 1){
                            //il s'agit du bouton qui apparait quand la chambre est en favoris (qui permet de le supprimer)
                            ?>
                            <button type="submit" name="removeFavorite" class="favoriteButton" ><i class="fas fa-bookmark" id="removeFavorite"></i></button>
                        <?php
                        }else if($result === 0){
                            //le bouton qui permet d'ajouter un favoris
                            ?>
                            <button type="submit" name="addFavorite"class="favoriteButton" ><i class="fas fa-bookmark" id="addFavorite"></i></button>
                        <?php
                        }
                    }    
                    ?>
                </form>
            </div>
            <!--==================== FIN DE L'AFFICHAGE DU BOUTON FAVORIS ================================-->

            <div class="picture">
                <img class="image" src="<?php echo($chambres['image'])?>" class="card-img-top" style="height: 100%;" alt="...">
                <div class="texte">
                        
                        <p class="card-text"><?php echo ($chambres['description']);?></p>
                        <p> <?= $lang['category']; ?> : <?php echo $chambres['libelle'];?></p>
                        <p> <?= $lang['floor']; ?> : <?php echo ($chambres['etage']);?></p>
                        <p> <?= $lang['equipment']; ?> : <?php echo ($chambres['douche']);?> douche</p>
                        <p> <?= $lang['capacity']; ?> : <?php echo ($chambres['capacite']);?></p>
                        <p> <?= $lang['exposure']; ?> : <?php echo ($chambres['exposition']);?></p>
                        <?php
                        //============PARTIE SUR LE TRAITEMENT ET LE CALCUL DE LA MOYENNE DES NOTES
                            //correspond au nombre de critère
                            $nbOfNotesPerCustomer = 5;
                            $roomId = intval($_GET['id']);
                            //je récupe le nb de note en fonction de la chambre
                            $nbTotalOfNotes = getNbOfNotes($dbh, $roomId);
                            $noteForProgressBar = array();
                            if($nbTotalOfNotes != 0){
                                //je récup toutes les informations de la table critère sur la chambre sur laquelle je suis
                            $allCriteriaAndNotes = getAllCriteriaNote($dbh, $roomId);
                            //je prépare des variable que met à 0 si elle existe pas
                            if (!isset($trueConfort)) {
                                $trueConfort = 0;
                                $trueProprete = 0;
                                $trueAccueil = 0;
                                $trueQualitePrix = 0;
                                $trueEmplacement = 0;
                            }
                            foreach ($allCriteriaAndNotes as $notes) {
                                $confort2 = $notes['confort'];
                                $proprete2 = $notes['proprete'];
                                $accueil2 = $notes['accueil'];
                                $qualitePrix2 = $notes['qualitePrix'];
                                $emplacement2 = $notes['emplacement'];
                             //pour chacun des critères de chaque chambre j'additionne les notes de chaque critères de la chambre (de tous les clients)
                                $trueConfort += $confort2;
                                $trueProprete += $proprete2;
                                $trueAccueil += $accueil2;
                                $trueQualitePrix += $qualitePrix2;
                                $trueEmplacement += $emplacement2;
                            }
                            //je divise par le nombre total de notes de la chambre
                            $trueConfort /= $nbTotalOfNotes;
                            $trueProprete /= $nbTotalOfNotes;
                            $trueAccueil /= $nbTotalOfNotes;
                            $trueQualitePrix /= $nbTotalOfNotes;
                            $trueEmplacement /= $nbTotalOfNotes;
                            //je prépare dans un tableau toutes les notes "finale" pour les utilisé pour la barre indicative pour chaque critères
                            $noteForProgressBar =array($trueConfort, $trueProprete,$trueAccueil, $trueQualitePrix, $trueEmplacement );
                            //je fais la moyenne globale en rassemblant toutes les moyennes des critères
                                $totalAverage = ($trueConfort + $trueProprete + $trueAccueil + $trueQualitePrix + $trueEmplacement) / $nbOfNotesPerCustomer;
                        }
                        ?>
                        <!--APPEL DES OUTILS NECESSAIRES à L'AFFICHAGE DES ETOILES DE LA CHAMBRE-->
                    <script src="../js/jquery.Rating.js"></script>
                    <script>
                            $(function(){
                                $('.stars').stars();
                            });
                        </script>
                    <!-- je vérifie qu'il y a au moins une note pour que s'affiche les étoiles-->
                    <?php if(isset($nbTotalOfNotes) AND $nbTotalOfNotes != 0){ ?>
                    <!--C ici que les etoiles s'affichent -->
                        <p>  Note (<?= $nbTotalOfNotes ?>) :  <span class="stars" data-rating="<?= $totalAverage ?>" data-num-stars="5" ></span></p>
                    <!--FIN DE L'AFFICHAGE-->
        <?php }else{
                    ?>
                        <p>Il n'y a pas de note pour cette chambre pour le moment</p>
            <?php
                    } ?>
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
                                                <label class='label' for="" ><?= $lang['arrivalDate']; ?></label class='label'>
                                                <input class="input" type="date" name="start" value="<?php echo $today?>" min="<?php echo $today?>" >
                                            </div>
                                            <div class="date2">
                                                <label class='label' for="start" ><?= $lang['departureDate']; ?></label class='label'>
                                                <input class="input" type="date" name="end" value="<?php echo $tomorrowFormatted?>" min="<?php echo $tomorrowFormatted?>">
                                            </div>
                                        </div>
                                        <div class="capacity">
                                            <div class="capacity2 line">
                                                <label class='label' for="start"><?= $lang['numberOfAdults']; ?></label class='label'>
                                                <select class="select"   name="numberAdult" required>
                                                    <option selected disabled value=""><?= $lang['choose']; ?> ...</option>
                                                    <?php for ($i = 1; $i <= $chambres['capacite']; $i++):?>
                                                        <option><?php echo $i ?></option>
                                                    <?php endfor;?>
                                                </select>
                                            </div>
                                            <div class="capacity2" >
                                                <label class='label' for="start"><?= $lang['numberOfChildren']; ?></label class='label'>
                                                <select class="select" name="numberChild" required>
                                                    <option selected disabled value=""><?= $lang['choose']; ?> ...</option>
                                                    <?php for ($i = 0; $i <= $chambres['capacite']; $i++):?>
                                                        <option><?php echo $i ?></option>
                                                    <?php endfor;?>
                                                </select>
                                            </div>
                                        </div>    
                                                        
                                    <div class="boutton">
                                            <input type="number" name="idChambre" hidden="hidden" value="<?php echo($chambres['id']); ?>">
                                            <input type="number" name="capacity" hidden="hidden" value="<?php echo($chambres['capacite']); ?>">
                                            <input type="submit"  class="bouton" value="<?= $lang['book']; ?>">
                                          
                                    </div>
                                </form>
                            </div>   
                            <?php  }else{ $id = intval($_GET['id']);?>
                                        <a href="modifRoom.php?room=<?php echo $id ?>"><?= $lang['edit']; ?></a>
                            <?php } ?>  
                <?php } ?>  
            </div>

        </div>

        <?php
        //============================ TRAITEMENT POST POUR NOTE DE CRITERE ==============================================>
        //je vérifie laquelle des fonctions je veux appeler (ajout ou modification de note)
        if(isset($_POST['createNote']) && !empty($_POST['createNote']) || isset($_POST['changeNote']) && !empty($_POST['changeNote'])){
            //je vérifie que tous les champs sont bien rempli
            if(!empty($_POST['confort']) && !empty($_POST['proprete']) && !empty($_POST['accueil']) && !empty($_POST['qualite/prix']) && !empty($_POST['emplacement'])){
                $confort =     intval($_POST['confort']);
                $proprete =    intval($_POST['proprete']);
                $accueil =     intval($_POST['accueil']);
                $qualitePrix = intval($_POST['qualite/prix']);
                $emplacement = intval($_POST['emplacement']);
                $idDuClient = $_SESSION['id'];
                $idDeLaChambre = $_GET['id'];
                //je veux savoir lequel des 2 de la première condition est celui qui m'interresse
                if(isset($_POST['changeNote'])){
                    updateNotesOfCriteria($dbh,$confort, $proprete,$accueil, $qualitePrix, $emplacement, $idDuClient, $idDeLaChambre);
                    ?>
                    <meta http-equiv="refresh" content="0">
                        <?php
                    }else{
                    insertCriteria($dbh,$confort,$proprete,$accueil,$qualitePrix,$emplacement,$idDuClient,$idDeLaChambre);
                }
            }else{
                $error = "Veuillez donnez une note pour chaque champs";
            }
        }
        //affichage du formulaire pour les notes des différents champs
        ?>

            <?php 
                if(!empty($_SESSION['id'])){
                    $client_id = $_SESSION['id'];
                    $chambre_id = $_GET['id'];
                    $reservations = getLastReservationRoom($dbh, $client_id, $chambre_id);
                } 
            ?>
        <div class='form'>
            <h2 class='souligne'><?= $lang['comments']?></h2>
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
            // je vérifie qu'il y a au moins 1 note
            if($nbTotalOfNotes != 0){
            ?>
                <p>Notes : </p>
            <?php
                $criteres2 = array('Confort', 'Propreté', 'Accueil','Qualité/prix','Emplacement');
                $nbOfCriteria2 = count($criteres2);
                for($i = 0; $i < $nbOfCriteria2;$i++){
            ?>
                <div class="criteria">
                    <!--J'affiche le nom de chaque critère-->
                    <label for="file"><?= $criteres2[$i] ?></label>
                    <!--j'affiche la barre de progresse, la value c la note moyenne (à tous les utilisateurs) que l'on a calculé plus haut-->
                    <progress id="file" max="5" value="<?= $noteForProgressBar[$i] ?>"></progress> <?= $noteForProgressBar[$i] ?>
                </div>
                <?php
            }
            }
                ?>
            <!-- AFFICHAGE DES CHAMPS POUR NOTER UNE CHAMBRE -->
            <form method="post">
                <?php
                if(isset($_SESSION['id'])){
                $criteres = array('confort', 'proprete', 'accueil','qualite/prix','emplacement');
                $nbOfCriteria = count($criteres);
                $clientId = $_SESSION['id'];
                $roomId = intval($_GET['id']);
                //je vérifie qu'il y a au moins une note pour le client dans cette chambre
                $nb = noteVerif($dbh, $clientId, $roomId);
                if($nb != 0){
                    $clientNotes = getNotesByClientIdAndRoomId($dbh, $clientId, $roomId);
                }
                 if(!empty($passed)){
                     if($nb === 1){
                         ?>
                         <p>Mes Notes :</p>
                             <?php
                     }else{
                         ?>
                         <p>Noter :</p>
                             <?php
                     }
                for($i = 0; $i < $nbOfCriteria; $i++){
                    $critere = $criteres[$i];
                    ?>
                    <select name="<?= $criteres[$i] ?>">
                        <option value="">Note <?= $criteres[$i] ?></option>
                        <option value="1"<?php if(isset($clientNotes)AND !empty($clientNotes)){if($critere === "qualite/prix") {$newcritere = "qualitePrix";if ($clientNotes[0][$newcritere] === 1) {echo "selected";} else {}}else{if($clientNotes[0][$critere] === 1){ echo "selected";}}}?>>1</option>
                        <option value="2"<?php if(isset($clientNotes)AND !empty($clientNotes)){if($critere === "qualite/prix") {$newcritere = "qualitePrix";if ($clientNotes[0][$newcritere] === 2) {echo "selected";} else {}}else{if($clientNotes[0][$critere] === 2){ echo "selected";}}}?>>2</option>
                        <option value="3"<?php if(isset($clientNotes)AND !empty($clientNotes)){if($critere === "qualite/prix") {$newcritere = "qualitePrix";if ($clientNotes[0][$newcritere] === 3) {echo "selected";} else {}}else{if($clientNotes[0][$critere] === 3){ echo "selected";}}}?>>3</option>
                        <option value="4"<?php if(isset($clientNotes)AND !empty($clientNotes)){if($critere === "qualite/prix") {$newcritere = "qualitePrix";if ($clientNotes[0][$newcritere] === 4) {echo "selected";} else {}}else{if($clientNotes[0][$critere] === 4){ echo "selected";}}}?>>4</option>
                        <option value="5"<?php if(isset($clientNotes)AND !empty($clientNotes)){if($critere === "qualite/prix") {$newcritere = "qualitePrix";if ($clientNotes[0][$newcritere] === 5) {echo "selected";} else {}}else{if($clientNotes[0][$critere] === 5){ echo "selected";}}}?>>5</option>
                    </select>
                    <?php
                }
                    ?>
                <input type="submit" value="<?php echo (isset($nb) AND $nb === 0) ?"Noter la chambre" : "Modifier la note" ?>" name="<?php echo (isset($nb)and $nb===0) ? "createNote": "changeNote" ?>">
            </form>
            <!-- FIN DE L'AFFICHAGE DES CHAMPS DE NOTES -->
            <?php
                 }
            }

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
                                <p><?= $lang['publishedOn']?> <?php echo $jourFormatted?></p>
                            </div>
                            <div class="centre"><p class="bold"><?php echo $commentary['contenu']?></p></div>
                            
                        </div>
                        <hr>
                    <?php endforeach;?>
                <?php else:?>
                    <br><br><br>
                <hr class=hr>
                    <div class="noCommentaire"><p class="p"><?= $lang['noComment']?></p></div>
                    <br><br><br><br>
                <?php endif;?>
        </div>
    </div>
    <br><br><br>    
<?php else: ?>
    <div class="bass">
        <p><?= $lang['noRoom']?></p>
    </div>
<?php endif;?>
<?php require_once '../component/footer.php';?>