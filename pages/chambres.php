<?php

require_once '../component/session.php';
require_once '../component/header.php';
require_once '../functions/sql.php';
require_once 'bdd.php';
?>
<!-- Style de la page chambres -->
<style>
    .content{
    width: (100% - 250px);
    margin-top: 60px;
    padding: 20px;
    /* margin-left: 250px; */
    height: 100%;
    transition: 0.5s;
    }
    .chambre{
        width: 85%;
        display: flex;
        flex-direction: row;
        align-items: center;
        border-radius: 15px;
        margin-bottom: -2%;
        padding: 3%;
        margin-left: 2%;
    }
    
    .picture{
        width: 25%;
        align-items: center;
    }
    .text{
        width: 100%;
        height: 100%;
        padding-left: 5%;
    }
    .description{
        width: 85%;
    }
    h5 {
        text-decoration: black
    }
    img{
        width: 100%;
        border-radius: 10px;
    }
    .price{
        color :linear-gradient(to right, #19B3D3, #1992d3, #196ad3);
    }
    .button{
        padding: 30%;
        border-radius: 15px;
        border: none;
        background: linear-gradient(to right, #19B3D3, #1992d3, #196ad3);
        cursor:pointer;
        color: white;
        transition: background-color 500ms ease-out;
    }
    .button:hover{
        background: linear-gradient(to right, #19B3D3, #1992d3, #196ad3);
        box-shadow: 2px 2px 12px grey;
    }
    .prix {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 20%;
    }
    #check:checked ~ .content{
        margin-left: 60px;
    }
    .capacity{
        color: lightslategrey ;
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
    @media screen and (max-width:780px){
        .content{
            margin-top: 0px;
        }
    
        .description{
            display: none;
        }
        .text{
           display: flex;
            flex-direction: column;
            align-items: flex-end;
            padding-right: 5%;
            width: 15%;
        }
        .picture{
            width: 75%;
        }
        img{
            width: 90%;
        }
        .chambre{
            width: 85%;
            margin-left: 7.5%;
            margin-right: 7.5%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            /* border-radius: 15px;
            margin-bottom: -2%;
            padding: 3%;
            margin-left: 2%; */
        }
        .text{
            display: flex;
            flex-direction: row;
            justify-content: space-around;
            align-items: center;
            width: 80%;
            margin-right: 7%;
        }
        .dropdown{
            margin-top: 40px;
        }
        .prix{
            flex-direction: row;
            justify-content: space-around;
            align-items: center;
            width: 100%;
        }
        .button{
            margin-left: -50%;
        }
    }
</style>
<?php ?>
<div class="content">

        <br><br>
        <?php
    // Requêtes de selectiond es informations des chambres
    ?>
        <?php
        if (empty($_GET['sort']) && empty($_POST['search'])){
            $chambres = getAllRoom($dbh);

        }elseif(!empty($_GET['sort']) && empty($_POST['search'])){
            if ($_GET['sort'] == 1) {
                $chambres = getAllRoom($dbh);
            }else if ($_GET['sort'] == 2){
                $chambres = getAllRoom2($dbh);
            }else if ($_GET['sort'] == 3){
                $chambres = getAllRoom3($dbh);
            }else if ($_GET['sort'] == 4){
                $chambres = getAllRoom4($dbh);
            }
            if (!empty($statement)) {
                $statement->execute(); // execute le SQL dans la base de données (MySQL / MariaDB)
                $chambres = $statement->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        // }elseif (!empty($_POST['search'])){
        //     $search = $_POST['search'];
        //     $statement = $dbh->prepare("SELECT chambres.*,tarifs.prix, libelle FROM chambres,tarifs WHERE chambres.tarif_id = tarifs.id AND chambres.id = '$search' ORDER BY tarifs.prix ASC ");
        //     $statement->execute();
        //     $chambres = $statement->fetchAll(PDO::FETCH_ASSOC);
        //     if (empty($chambres)) {
        //         $statement = $dbh->prepare('SELECT chambres.*,tarifs.prix, libelle FROM chambres,tarifs WHERE chambres.tarif_id = tarifs.id AND prix LIKE "%' . $search . '%" ORDER BY tarifs.prix ASC ');
        //         $statement->execute();
        //         $chambres = $statement->fetchAll(PDO::FETCH_ASSOC);
        //         if (empty($chambres)) {
        //             $statement = $dbh->prepare('SELECT chambres.*,tarifs.prix, libelle FROM chambres,tarifs WHERE chambres.tarif_id = tarifs.id AND exposition LIKE "%' . $search . '%" ORDER BY tarifs.prix ASC ');
        //             $statement->execute();
        //             $chambres = $statement->fetchAll(PDO::FETCH_ASSOC);
        //             if (empty($chambres)) {
        //                 $statement = $dbh->prepare('SELECT chambres.*,tarifs.prix, libelle FROM chambres,tarifs WHERE chambres.tarif_id = tarifs.id AND libelle LIKE "%' . $search . '%" ORDER BY tarifs.prix ASC ');
        //                 $statement->execute();
        //                 $chambres = $statement->fetchAll(PDO::FETCH_ASSOC);
        //                 if (empty($chambres)) {
        //                     $statement = $dbh->prepare('SELECT chambres.*,tarifs.prix, libelle FROM chambres,tarifs WHERE chambres.tarif_id = tarifs.id AND description LIKE "%' . $search . '%" ORDER BY tarifs.prix ASC ');
        //                     $statement->execute();
        //                     $chambres = $statement->fetchAll(PDO::FETCH_ASSOC);
        //                 }
        //             }
        //         }
        //     }
        // }
        ?>
    <div>
        <div class="dropdown">
            <button class="dropbtn">Trier</button>
            <div class="dropdown-content"> 
                <a href="chambres.php?sort=1">A-Z</a>
                <a href="chambres.php?sort=2">Z-A</a>
                <a href="chambres.php?sort=3">Prix croissant</a>
                <a href="chambres.php?sort=4">Prix décroissant</a>
                
            </div>
        </div>   
    </div>
    <?php //Affichage des informations récupérées pour chaque chambre
        if (!empty($chambres)):
            if(isset($_SESSION['id'])){
                $client = getClient($dbh, $_SESSION['id']);
                $type = $client['type'];
            }
            ?>
            <?php foreach ($chambres as $chambre): ?>
                <div class="chambre">
                    <div class="picture"><img src="<?php echo($chambre['image'])?>"></div>
                    <div class="text">
                        <h3><?= $lang['room']; ?>  <?php echo($chambre['id'])?></h3>
                        <p class="description"><?php echo($chambre['description'])?></p>
                        <p class="capacity"><?php echo($chambre['capacite'])?>  <?php echo $chambre['capacite'] < 2 ? $lang['aPerson']  : $lang['people'];;?></p>
                    </div>
                    <div class="prix">
                        <h2 class="price"><?php echo($chambre['prix'])?> €</h2>
                        <a href="infoChambre.php?id=<?php echo($chambre['id'])?>"><button class="button"><?php echo (isset($type) AND $type ==="admin")? $lang['see'] : $lang['book'] ?></button></a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="milieu">
                <p> Aucun résultat pour votre recherche</p>
            </div>
        <?php endif; ?>
        <br><br>
</div>

<?php
require_once '../component/footer.php';  




