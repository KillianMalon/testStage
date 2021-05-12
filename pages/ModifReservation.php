<?php
require_once '../component/session.php';
require_once '../component/header.php';
require_once '../functions/sql.php';
require_once 'bdd.php';


if (isset($_GET['reservation'])){
echo "<div class='content'>";
    $id = $_GET['reservation'];
    //on récupère toutes les lignes qui correspondent à l'id de réservation
    $list = getReservationbyrid($dbh, $id);
    //on compte le nombre de ligne ou il y a l'id de réservation
    $count = countReservationbyid($dbh, $id);
?>
    <div class="adminAffichage">
        <table>
            <tr>
                <td> <?= $lang['bookingDuration'] ?> : <?= $count['0'] ?> <?= $lang['days'] ?></td>
                <td><a href="./removeReservation.php?id=<?= $id ?>"><?= $lang['delete']?></a></td>
            </tr>
        </table>
    </div>
<?php
    foreach ($list as $res){
        $chid = $res['chambre_id'];
        $jour = $res['jour'];
        $paye = $res['paye'];
        $cid = $res['client_id'];
        ?>
        <div class="adminAffichage">
        <table>
                    <thead>
                        <tr>
                            <th>iD <?= $lang['booking'] ?></th>
                            <th><?= $lang['roomNumber'] ?></th>
                            <th>Date</th>
                            <th><?= $lang['paidRoom'] ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="font-weight: bold;" class="idres"><?= $id ?></td>
                        <td class="id"><?= $chid ?></td>
                        <td class="jour"><?= mb_substr($jour, 0, 10) ?></td>

                        <td class="paye">
                            <form class='form' method="post" action="payeChambre.php">
                                <?php echo ($paye? '✅' : '🔴');?>
                                <?php if ($paye == '0'):?>
                                    <input type="hidden" name="idReservation" value="<?= $id ?>">
                                    <input type="submit" class="btn btn-info" value="<?= $lang['paidReservation'] ?>">
                                <?php endif;?>
                            </form>
                        </td>
                    </tr>
                    </tbody>
        </table>
        </div>
<?php
    }
}
?>
<style>
    /* Style de la page Administration.php*/
    .adminAffichage{
        width: 47%;
        margin-right: 1.25%;
        margin-left: 1.25%;
        margin-top: 2%;
        background-color: #2f323a;
    }
    .adminAffichage h2{
        display: flex;
        flex-wrap: wrap;
        text-align: center;
        color: white;
        width: 96%;
        margin-left: 2%;
        border-bottom: 1px solid white;
    }
    .adminAffichage h2 a{
        float: right;
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
</style>
