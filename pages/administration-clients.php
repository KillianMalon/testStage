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


//S'il y a une page en paramètre GET, on stock ce paramètre sinon, on stock 1
if(isset($_GET['page']) && !empty($_GET['page'])){
    $currentPage = (int) strip_tags($_GET['page']);
}else{
    $currentPage = 1;
}

//On compte le nombre total de client (et on le convertit en entier)
$allclients = countClients($dbh);
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
$premiere = getAllClients($dbh);

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
        background-color: #19B3D3;
    }
    .adminAffichage td a:hover{
        background-color: #ffffff;
        color: #19B3D3;
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
    .noresult{
        text-align: center;
        color: #ffffff;
    }
    
</style>
<?php
if(isset($_GET['search']) AND !empty($_GET['search'])){
    $search = htmlspecialchars($_GET['search']);
    $query = searchClient($dbh,$search);
    $premiere = $query->fetchAll();
    $clientCount = $query->rowCount();
    $none = 1;
        ?>
    <meta http-equiv="refresh" content="80000">
    <?php
    if($clientCount === 0){
       $none = 0;
        $message = "Pas de résultat";
    }
}
?>
<!-- Affichage des clients -->
<div class="content">
    <form action="" method="get">
        <input type="search" name="search" placeholder="Chercher un client" value="<?php echo (isset($_POST['search']) AND !empty($_POST['search']))? $_POST['search']: ""?>">
    </form>
    <div class="globalAdmin">
        <div class="adminAffichage">
        <h2><a href="./administration.php" class="viewAll"><i class="fas fa-arrow-left"></i> <?= $lang['back']?></a> <?= $lang['customerAdministration']?> <i class="fas fa-user"></i></h2>
        <div>
            <?php if(!empty($premiere)):  ?>
            <table>
            
                <thead>
                <tr>
                    <th><?= $lang['lname']?></th>
                    <th><?= $lang['fname']?></th>
                    <th>Email</th>
                    <th>Type</th>
                    <th><?= $lang['edit']?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if ((isset($_GET['search']) and !empty($_GET['search']) and isset($search) and !empty($search) and $none === 1)
                || !(isset($_GET['search']) and !empty($_GET['search']))){

                }
                $countt = 0;
                foreach ($premiere as $client){
                if ($premier <= $countt && $countt < ($currentPage*$parpage)){
                    $id = $client['id'];
                    $nom = $client['nom'];
                    $prenom = $client['prenom'];
                    $mail = $client['mail'];
                    $type = $client['type'];
                ?>
                <tr>
                    <td><?php echo isset($nom)? $nom :" " ?></td>
                    <td><?php echo isset($prenom)? $prenom :" " ?></td>
                    <td> <?php echo isset($mail)? $mail : " " ?> </td>
                    <td> <?php echo isset($type)? $type : " " ?> </td>
                    <td> <a href="modifClient.php?client=<?php echo $id ?>"><?= $lang['edit']?></a> </td>
                </tr>
                <?php }$countt++;
                } ?>

                </tbody>

            </table>
            <?php elseif((isset($search)) && empty($premiere)):  ?>
                <p class="noresult">Pas de résultat</p>

            <!-- Affichage de la pagination -->
                <?php endif;?>
<?php
// if ((isset($clientCount) && $clientCount > $parpage) ||
//     ($count > $parpage && !isset($clientCount)) ||
//     ($count > $parpage && isset($clientCount) && $clientCount > $parpage)){ ?>
            <div class="pagination">
                <?php
                foreach($list AS $link) {
                    if ($link == '...') {
                        echo $link;
                    }else {
                        if ($link == $currentPage) {
                            echo '<span>' . $link . '</span>';
                        }elseif (($link != $currentPage)&& empty($_GET['search'])) {
                            echo '<a href="?page=' . $link . '">' . $link . '</a>';
                        }elseif (($link != $currentPage)&& !empty($_GET['search'])){
                            echo '<a href="?page=' . $link .'&search='.$search. '">' . $link . '</a>';
                        }
                    }
                }
                ?></div>
        </div>
        </div>
    

    
    </div>
</div>
<?php require_once '../component/footer.php';?>