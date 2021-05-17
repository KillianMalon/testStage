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

//On détermine le nombre de réservations que l'on veut voir par page
$parpage = 10;

//On détermine le numéro du premier article de la page (si page 1, premier 1 ; si page 2, premier 11 ; etc...)
$premier = ($currentPage * $parpage) - $parpage;

//On détermine le nombre total de page et on l'arrondit au supérieur (S'il y a 24,56 pages, on stock 25 pages)
$pages = ceil($count/$parpage);

//On crée un tableau qui sert à afficher, au niveau de la pagination, la 1e page, la dernière, la page actuelle et une page avant et après. Le reste est remplacé par "..."
$list = get_list_page($currentPage, $pages);

//On récupère les informations des  "20" premiers réservations à partir de la première réservation de la page
if(empty($_GET['sort'])){
    $premiere = getPlanningOrder($dbh, $premier, $parpage);
}elseif(isset($_GET['sort'])){
    $sort = $_GET['sort'];
    if($sort==1){
        $premiere = getPlanningOrder1($dbh, $premier, $parpage);
    }elseif($sort==2){
        $premiere = getPlanningOrder2($dbh, $premier, $parpage);
    }elseif($sort==3){
        $premiere = getPlanningOrder3($dbh);
        
        foreach($premiere as $premieres){
            $idReservation = $premieres['idReservation'];
            //Grâce à lid de chaque réservation on va chercher ici la plus grande date, soit la date de départ grâce à MAX en sql
            $resultat = dateStartReservationByReservId($dbh, $idReservation);
            $dateStart = $resultat[0]['MAX(jour)'];
            //On construit un tableau avec ses dates et avec comme index l'id de la réservation
            $array[$idReservation] = $dateStart;

        }
        //je trie mon tableau par date grâce à uasort qui permet de trier sans reindexer le tableau et donc de conserver les idReservation couplé à OrderByDate
        uasort($array, "orderByDate2");
        //je récupére les clés du tableau qui sont les idRéservation
        $tests = array_keys($array);
        $compteur2=0;
        //Avec le tableau trier je récupére uniquement les id de Réseravtion qui seront dans l'ordre où je veux les afficher
        foreach($tests as $test){
            $prem[] = array('idReservation' => $test);
            $compteur2++;
        } 



    }elseif($sort==4){
        $premiere = getPlanningOrder4($dbh);
        
        foreach($premiere as $premieres){
            $idReservation = $premieres['idReservation'];
            $resultat = dateStartReservationByReservId($dbh, $idReservation);
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
    }elseif($sort==5){
        $premiere = getPlanningOrder3($dbh);
        
        foreach($premiere as $premieres){
            $idReservation = $premieres['idReservation'];
            $resultat = dateStartReservationByReservId2($dbh, $idReservation);
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
    }elseif($sort==6){
        $premiere = getPlanningOrder4($dbh);
        
        foreach($premiere as $premieres){
            $idReservation = $premieres['idReservation'];
            $resultat = dateStartReservationByReservId2($dbh, $idReservation);
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
    }elseif($sort==7){       
        $premiere = getPlanningOrder5($dbh, $premier, $parpage);
    }elseif($sort==8){       
        $premiere = getPlanningOrder6($dbh, $premier, $parpage);
    }else{
        $premiere = getPlanningOrder($dbh, $premier, $parpage);
    }
}


if(!empty($prem)){
    //$prem est le tableau obtenu suite au trie avec les dates je le met donc dans $premiere car celui-ci est utilisée pour le reste du traitement
    $premiere = $prem;
} 
    //Ce compteur va me permettre d'indexer les tableau suivant
    $compteur = 0;
foreach($premiere as $premieres){
    $idReservation = $premieres['idReservation'];
    //Grâce aux idReservation je récupére toutes les infos liées à celle-ci
    $resultat = reservationByReservId($dbh, $idReservation);
    $clientId = $resultat[0]['client_id'];            
    $dateStart = $resultat[0]['jour'];
    $idChambre = $resultat[0]['chambre_id'];
    $payed = $resultat[0]['paye'];
    $priceperDay = getPriceRoom($dbh, $idChambre);
    $price = $priceperDay['prix'];
    //Grâce à count je compte le nombre d'apparition de l'idReservation dans la table et j'obtiens le nombre de jours que contient la reservation
    $count = count($resultat);
    //ce count me permet d'obtenir le prix total
    $totalPrice = $price * $count;
    //Grâce à la date d'arrivée et le nombre de jours je peux obtenir la date de départ par ajout du $count
    $jour = $dateStart;
    $reservationDateStart = new DateTime("$jour");
    $reservationDateStartFormatted = $reservationDateStart->format('Y-m-d');
    $reservationDateEnd = $reservationDateStart;
    $reservationDateEnd-> add(new DateInterval('P'.$count.'D'));
    $reservationDateEndFormatted = $reservationDateEnd->format('Y-m-d');
    //Une fois les dates récupérées je les convertis en string pout les renter dans le tableau dans le format souhaité
    //ce tableau rescence toutes les réservations pour les afficher
    $resultats[$compteur] = array('chambre_id'=>$idChambre, 'idReservation'=>$premieres['idReservation'],  'dateStart'=>$reservationDateStartFormatted, 'dateEnd'=>$reservationDateEndFormatted, 'prix'=>$totalPrice, 'paye'=>$payed,'nombreDeJours'=>$count, 'client_id'=>$clientId);
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
    <?php if(empty($_SESSION['theme'])):?>
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: black;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            border-radius: 20px;
        }
    <?php else: ?>
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
        
    <?php endif; ?>    
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
        <!-- Ici ce sont les filtres nous n'avons pas de formulaire pour passer le sort dans l'URL nous le simulont en rechargeant la page et en le mettant à la fin comme s'il avait été passé en GET -->
            <a href="administration-reservations.php?sort=1">ID croissant</a>
            <a href="administration-reservations.php?sort=2">ID décroissant</a>
            <a href="administration-reservations.php?sort=3">Date de départ croissante</a>
            <a href="administration-reservations.php?sort=4">Date de départ décroissant</a>
            <a href="administration-reservations.php?sort=5">Date d'arrivée croissante</a>
            <a href="administration-reservations.php?sort=6">Date d'arrivée décroissante</a>
            <a href="administration-reservations.php?sort=7">ID chambre croissante</a>
            <a href="administration-reservations.php?sort=8">ID chambre décroissante</a>
            
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
                if(!empty($_GET['sort']) && ($_GET['sort'] > 2 && $_GET['sort'] < 7)){
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
                <?php }else{ 
                    foreach ($resultats as $res){
                        
                        
                        
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
                            //Ici nous allons penser à la pagination et au tri pour cela nous devons passer en GET le numéro de la page ainsi que le trie 
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
<?php require_once '../component/footer.php';?>