<?php
require_once '../component/header.php';
require_once '../functions/sql.php';
require_once 'bdd.php';

//S'il y a une page en paramètre GET, on stock ce paramètre sinon, on stock 1
if(isset($_GET['page']) && !empty($_GET['page'])){
    $currentPage = (int) strip_tags($_GET['page']);
}else{
    $currentPage = 1;
}

//On compte le nombre total de client (et on le convertit en entier)
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
$premiere = getPlanningOrder($dbh, $premier, $parpage);
?>
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
</style>
<!-- Affichage des clients -->
<div class="content">
    <div class="globalAdmin">
        <div class="adminAffichage">
        <h2><a href="./administration.php" class="viewAll"><i class="fas fa-arrow-left"></i> Retour</a> Administration Réservations <i class="fas fa-table"></i></h2>
        <div>
            <table>
                <thead>
                <tr>
                    <th>iD réservation</th>
                    <th>Numéro chambre</th>
                    <th>Date</th>
                    <th>Chambre payée</th>
                    <th>Supprimer</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($premiere as $res){
                    $id = $res['idReservation'];
                    $chid = $res['chambre_id'];
                    $jour = $res['jour'];
                    $paye = $res['paye'];
                    $cid = $res['client_id'];
                ?>
                <tr>
                        <td style="font-weight: bold;" class="idres"><?= $id ?></td>
                        <td class="id"><?= $chid ?></td>
                        <td class="jour"><?= mb_substr($jour, 0, 10) ?></td>
                        <td class="paye">
                            <form class='form' method="post" action="payeChambre.php">
                                <?php echo ($paye? '✅' : '🔴');?>
                                <?php if ($paye == '0'):?>
                                    <input type="hidden" name="idReservation" value="<?= $id ?>">
                                <?php endif;?>
                            </form>
                        </td>
                    <td><a class="delete-button" href="./removeReservation.php?id=<?= $id ?>">Supprimer</a></td>
                    </tr>
                <?php } ?>
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
                        } else {
                            echo '<a href="?page=' . $link . '">' . $link . '</a>';
                        }
                    }
                }
                ?></div>
        </div>
        </div>
    </div>
</div>