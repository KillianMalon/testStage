<?php
require_once '../component/session.php';
require_once '../component/header.php';
require_once '../functions/functions.php';
require_once '../functions/sql.php';
require_once  'bdd.php';

//S'il y a une page en paramètre GET, on stock ce paramètre sinon, on stock 1
if(isset($_GET['page']) && !empty($_GET['page'])){
    $currentPage = (int) strip_tags($_GET['page']);
}else{
    $currentPage = 1;
}

//On compte le nombre total de réservations (et on le convertit en entier)
$allclients = countPlanning($dbh);
$count = (int) $allclients['0'];

//On détermine le nombre de client que l'on veut voir par page
$parpage = 10;

//On détermine le numéro du premier article de la page (si page 1, premier 1 ; si page 2, premier 11 ; etc...)
$premier = ($currentPage * $parpage) - $parpage;

//On détermine le nombre total de page et on l'arrondit au supérieur (S'il y a 24,56 pages, on stock 25 pages)
$pages = ceil($count/$parpage);

//On crée un tableau qui sert à afficher, au niveau de la pagination, la 1e page, la dernière, la page actuelle et une page avant et après. Le reste est remplacé par "..."
$list = get_list_page($currentPage, $pages);

//On récupère les informations des  "20" premiers clients à partir du premier client de la page
if(empty($_GET['sort'])){
    $premiere = getPlanningOrder($dbh, $premier, $parpage);
    // var_dump($premiere);
}elseif(isset($_GET['sort'])){
    $sort = $_GET['sort'];
    if($sort==1){
        $premiere = getPlanningOrder1($dbh, $premier, $parpage);
    }elseif($sort==2){
        $premiere = getPlanningOrder2($dbh, $premier, $parpage);
    }elseif($sort==3){
        $premiere = getPlanningOrder3($dbh);
        // var_dump($premiere);
        
        foreach($premiere as $premieres){
            $idReservation = $premieres['idReservation'];
            $resultat = dateStartReservationByReservId($dbh, $idReservation);
            // var_dump($resultat);
            $dateStart = $resultat[0]['MAX(jour)'];
            $array[$idReservation] = $dateStart;

        }
        uasort($array, "orderByDate2");
        $tests = array_keys($array);
        
        $compteur2=0;
        foreach($tests as $test){
            $prem[] = array('idReservation' => $test);
            $compteur2++;
        } 
        // var_dump($prem);



    }elseif($sort==4){
        $premiere = getPlanningOrder4($dbh);
        // var_dump($premiere);
        
        foreach($premiere as $premieres){
            $idReservation = $premieres['idReservation'];
            $resultat = dateStartReservationByReservId($dbh, $idReservation);
            // var_dump($resultat);
            $dateStart = $resultat[0]['MAX(jour)'];
            $array[$idReservation] = $dateStart;

        }
        uasort($array, "orderByDate");
        $tests = array_keys($array);
        
        $compteur2=0;
        foreach($tests as $test){
            $prem[] = array('idReservation' => $test);
            $compteur2++;
        } 
        // var_dump($prem);
    }elseif($sort==5){
        $premiere = getPlanningOrder3($dbh, $premier, $parpage);
        // var_dump($premiere);
        
        foreach($premiere as $premieres){
            $idReservation = $premieres['idReservation'];
            $resultat = dateStartReservationByReservId2($dbh, $idReservation);
            // var_dump($resultat);
            $dateStart = $resultat[0]['MIN(jour)'];
            $array[$idReservation] = $dateStart;

        }
        uasort($array, "orderByDate2");
        $tests = array_keys($array);
        
        $compteur2=0;
        foreach($tests as $test){
            $prem[] = array('idReservation' => $test);
            $compteur2++;
        } 
        // var_dump($prem);
    }elseif($sort==6){
        $premiere = getPlanningOrder4($dbh);
        // var_dump($premiere);
        
        foreach($premiere as $premieres){
            $idReservation = $premieres['idReservation'];
            $resultat = dateStartReservationByReservId2($dbh, $idReservation);
            // var_dump($resultat);
            $dateStart = $resultat[0]['MIN(jour)'];
            $array[$idReservation] = $dateStart;

        }
        uasort($array, "orderByDate");
        $tests = array_keys($array);
        
        $compteur2=0;
        foreach($tests as $test){
            $prem[] = array('idReservation' => $test);
            $compteur2++;
        } 
        // var_dump($prem);
    }else{
        $premiere = getPlanningOrder($dbh, $premier, $parpage);
    }
}


// var_dump($premiere);
if(!empty($prem)){
    $premiere = $prem;
}
foreach($premiere as $premieres){
    $idReservation = $premieres['idReservation'];
    $resultat = reservationByReservId($dbh, $idReservation);
            $clientId = $resultat[0]['client_id'];            
            $dateStart = $resultat[0]['jour'];
            $idChambre = $resultat[0]['chambre_id'];
            $payed = $resultat[0]['paye'];
            $priceperDay = getPriceRoom($dbh, $idChambre);
            $price = $priceperDay['prix'];
            $count = count($resultat);
            $totalPrice = $price * $count;

            $arrayIds[] = array('idChambre'=> $idChambre , 'idReservation'=> $premieres['idReservation'], "dateDeDepart" => $dateStart, 'nombreDeJours' => $count,  'payed'=>$payed, 'prix'=>$totalPrice, 'client_id'=> $clientId);
                     
}   
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
                
                    $resultats[$compteur] = array('chambre_id'=>$arrayId['idChambre'], 'idReservation'=>$arrayId['idReservation'],  'dateStart'=>$reservationDateStartFormatted, 'dateEnd'=>$reservationDateEndFormatted, 'prix'=>$arrayId['prix'], 'paye'=>$arrayId['payed'],'nombreDeJours'=>$arrayId['nombreDeJours'], 'client_id'=>$arrayId['client_id']);
                
                $compteur ++;
            }
            
// ?>
<!-- Feuilles de style de la page -->
<style>
    /* Style de la page Administration.php*/
    .globalAdmin{
        margin-left: 1%;
        width: 98%;
        display: flex;
        flex-wrap: wrap;
    }
    .adminAffichage{
        width: 100%;
        height: 100%;
        margin-right: 1.25%;
        margin-left: 1.25%;
        margin-top: 2%;
        background-color: #2f323a;
        padding-bottom: 1%;
    }
    .adminAffichage h2{
        text-align: center;
        color: white;
        width: 96%;
        margin-left: 2%;
        border-bottom: 1px solid white;
    }
    .adminAffichage h2 a{
        float: left;
        text-decoration: none;
        color: white;
        font-size:14px;
    }
    .adminAffichage h2 a:hover{
        color: #19B3D3;
    }
    .adminAffichage table{
        margin-left:1%;
        width: 98%;
        color: white;
    }
    .adminAffichage td{
        text-align: center;
        padding: 5px;
        padding-bottom: 8px ;
    }
    .adminAffichage td a{
        color: white;
        text-decoration: none;
        padding: 4px;
        border-radius: 5px;
        background-color: #ff4747;
    }
    .adminAffichage td a:hover{
        background-color: #ffffff;
        color: #ff4747;
    }
    .pagination{
        text-align: center;
        margin-top: 1%;
    }
    .pagination a{
        color: white;
        text-decoration: none;
        padding: 7px;
        border-radius: 5px;
        background-color: #19B3D3;
        margin-right: 1%;
    }
    .pagination a:hover{
        background-color: #ffffff;
        color: #19B3D3;
    }
    .pagination span{

    }
    .pagination span{
        text-decoration: none;
        padding: 7px;
        border-radius: 5px;
        margin-right: 1%;
        color: #19B3D3;
        background-color: #ffffff;
    }
    .dropbtn {
        background-color: #19B3D3;
        color: white;
        padding: 16px;
        font-size: 16px;
        border: none;
        cursor: pointer;
        border-radius: 15px;
    }

    /* The container <div> - needed to position the dropdown content */
    .dropdown {
        position: relative;
        display: inline-block;
        margin-left: 2%;
    }

    /* Dropdown Content (Hidden by Default) */
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: none;
        backdrop-filter: blur(10px);
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
        border-radius: 20px;
    }

    /* Links inside the dropdown */
    .dropdown-content a {
        color: white;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        border-radius: 20px;
    }

    /* Change color of dropdown links on hover */
    .dropdown-content a:hover {background-color: #19B3D3}

    /* Show the dropdown menu on hover */
    .dropdown:hover .dropdown-content {
        display: block; 
    }

    /* Change the background color of the dropdown button when the dropdown content is shown */
    .dropdown:hover .dropbtn {
        background-color: #3e8e41;
    }  
</style>
<!-- Affichage des clients -->
<div class="content">
    <div>
    <div class="dropdown">
        <button class="dropbtn">Trier</button>
        <div class="dropdown-content">
            <a href="administration-reservations.php?sort=1">ID croissant</a>
            <a href="administration-reservations.php?sort=2">ID décroissant</a>
            <a href="administration-reservations.php?sort=3">Date de départ croissante</a>
            <a href="administration-reservations.php?sort=4">Date de départ décroissant</a>
            <a href="administration-reservations.php?sort=5">Date d'arrivée croissante</a>
            <a href="administration-reservations.php?sort=6">Date d'arrivée décroissante</a>
            
        </div>
    </div>   
    </div>
    <div class="globalAdmin">
        <div class="adminAffichage">
        <h2><a href="./administration.php" class="viewAll"><i class="fas fa-arrow-left"></i> <?= $lang['back']?></a> <?= $lang['bookingsAdministration']?> <i class="fas fa-table"></i></h2>
        <div>
            <table>
                <thead>
                <tr>
                    <th>iD <?= $lang['booking']?></th>
                    <th><?= $lang['roomNumber']?></th>
                    <th><?= $lang['arrivalDate']?></th>
                    <th><?= $lang['departureDate']?></th>
                    <th><?= $lang['paidRoom']?></th>
                    <th><?= $lang['delete']?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $countt = 0;
                foreach ($resultats as $res){
                    if ($premier <= $countt && $countt < ($currentPage*$parpage)){

                    $id = $res['idReservation'];
                    $chid = $res['chambre_id'];
                    $dateStart = $res['dateStart'];
                    $dateEnd = $res['dateEnd'];
                    $paye = $res['paye'];
                    $cid = $res['client_id'];
                ?>
                <tr>
                        <td style="font-weight: bold;" class="idres"><?= $id ?></td>
                        <td class="id"><?= $chid ?></td>
                        <td class="jour"><?= mb_substr($dateStart, 0, 10) ?></td>
                        <td class="jour"><?= mb_substr($dateEnd, 0, 10) ?></td>
                        <td class="paye">
                            <form class='form' method="post" action="payeChambre.php">
                                <?php echo ($paye? '✅' : '🔴');?>
                                <?php if ($paye == '0'):?>
                                    <input type="hidden" name="idReservation" value="<?= $id ?>">
                                <?php endif;?>
                            </form>
                        </td>
                    <td><a class="delete-button" href="./removeReservation.php?id=<?= $id ?>"><?= $lang['delete']?></a></td>
                    </tr>
                <?php }
                    $countt++;
                } ?>
                </tbody>
            </table>

            <!-- Affichage de la pagination -->
            <div class="pagination">
            
                <?php
                foreach($list AS $link) {
                    if ($link == '...')
                        echo $link;
                    else {
                        if ($link == $currentPage) {
                            echo '<span>' . $link . '</span>';
                        }elseif (($link != $currentPage)&& empty($_GET['sort'])) {
                            echo '<a href="?page=' . $link . '">' . $link . '</a>';
                        }elseif (($link != $currentPage)&& !empty($_GET['sort'])){
                            echo '<a href="?page=' . $link .'&sort='.$sort. '">' . $link . '</a>';
                        }
                    }
                }
                ?></div>
        </div>
        </div>
    </div>
</div>