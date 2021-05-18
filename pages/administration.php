<?php
require_once '../component/session.php';
if(isset($_SESSION['id'])){
    $client = getClient($dbh, $_SESSION['id']);
    if($client['type'] != "admin"){
        header("Location:../index.php");
    }
}else{
    header("Location:../index.php");
}
require_once '../component/header.php';
require_once '../functions/sql.php';
require_once 'bdd.php';
?>
<style>
    /* Style de la page Administration.php*/
    .globalAdmin{
        margin-left: 1%;
        width: 98%;
        display: flex;
        flex-wrap: wrap;
    }
    .adminAffichage{
        width: 47%;
        margin-right: 1.25%;
        margin-left: 1.25%;
        margin-top: 2%;
        background-color: #2f323a;
    }
    .adminAffichage h2{
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
        background-color: #19B3D3;
    }
    .adminAffichage td a:hover{
        background-color: #ffffff;
        color: #19B3D3;
    }
    .buton-submit{
        color: white;
        text-decoration: none;
        padding: 4px;
        border-radius: 5px;
        background-color: #19B3D3;
        margin-bottom: 5%;
        width: 30%;
    }
    .buton-submit:hover{
        background-color: #ffffff;
        color: #19B3D3;
    }
</style>
<!-- AFFICHAGE ADMIN CLIENT -->
<div class="content">
   <div class="globalAdmin">
        <div class="adminAffichage"">
            <h2><?= $lang['customerAdministration'] ?> <i class="fas fa-user"></i> <a href="./administration-clients.php" class="viewAll"> <?= $lang['seeAll'] ?> <i class="fas fa-arrow-right"></i></a></h2>
            <div>

               <table>
                   <thead>
                       <tr>
                           <th><?= $lang['lname'] ?></th>
                           <th>Email</th>
                           <th>Type</th>
                           <th><?= $lang['edit'] ?></th>
                       </tr>
                   </thead>
                   <tbody>
                   <?php
                   //on récupère les 10 derniers utilisateurs qui se sont inscrit sur le site
                        $clients = getLastUsers($dbh);
                        foreach($clients as $client){
                            $id = $client['id'];
                            $lname = $client['nom'];
                            $mail = $client['mail'];
                            $type = $client['type'];
                   ?>
                        <tr>
                            <td><?php echo isset($lname)? $lname :" " ?></td>
                            <td> <?php echo isset($mail)? $mail : " " ?> </td>
                            <td> <?php echo isset($type)? $type : " " ?> </td>
                            <td> <a href="modifClient.php?client=<?php echo $id ?>"><?= $lang['edit'] ?></a> </td>
                        </tr>

                   <?php } ?>
                   </tbody>

               </table>
            </div>
        </div>
    <!--AFFICHAGE ADMIN RESERVATION-->
        <div class="adminAffichage">
            <h2><?= $lang['bookingsAdministration'] ?> <i class="fas fa-table"></i> <a href="./administration-reservations.php" class="viewAll"> <?= $lang['seeAll'] ?> <i class="fas fa-arrow-right"></i></a></h2>
            <div>

                <table>
                    <thead>
                    <tr>
                        <th>iD <?= $lang['booking'] ?></th>
                        <th><?= $lang['day'] ?></th>
                        <th> <?= $lang['roomNumber'] ?></th>
                        <th> <?= $lang['edit'] ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $rooms = getLastReservations($dbh);
                    foreach($rooms as $room){
                        $id = $room['idReservation'];
                        $jour = $room['jour'];
                        $chid = $room['chambre_id'];
                        ?>
                        <tr>
                            <td><?php echo isset($id)? $id :" " ?></td>
                            <td> <?php echo isset($jour)? $jour : " " ?> </td>
                            <td> <?php echo isset($chid)? $chid : " " ?> </td>
                            <td> <a href="modifReservation.php?reservation=<?php echo $id ?>"><?= $lang['edit'] ?></a> </td>
                        </tr>

                    <?php } ?>
                    </tbody>

                </table>
            </div>
        </div>
    <!--AFFICHAGE AJOUT DE CHAMBRE-->

    <div class="adminAffichage"><h2><?= $lang['addARoom'] ?></h2>
        <form name="addchambre" style="text-align: center" method="post" action="addchambre.php">
            <input class="buton-submit" name="submit" type="submit" value="<?= $lang['add'] ?>">
        </form>
    </div>
   </div>
</div>
<?php require_once '../component/footer.php';?>