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
require_once 'bdd.php';

?>
<style>
    .content{
        display: flex;
        flex-direction: column;
        justify-content: center;
        justify-content: flex-start;
        height: 100vmax;
        
    }
    .chambre{
        width: 90%;
        display: flex;
        flex-direction: row;
        align-items: center;
        border-radius: 15px;
        margin-bottom: 4%;
        margin-left: 5%;
        /* padding: 3%; */
        
    }
    .chambre:hover{
        box-shadow: 2px 2px 12px grey;
    }
    h2{
        color: black;
        /* margin-bottom: 0rem; */
        margin-left: 2%;
    }
    a{
       color: black;
    }
    .picture{
        width: 25%;
        display: flex;
        text-align: center;
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
        margin-left: -30%;
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
    .boutton{
        padding: 11%;
        border-radius: 15px;
        margin-top: 3%;
        border: none;
        background: linear-gradient(to right, #19B3D3, #1992d3, #196ad3);
        cursor:pointer;
        color: white;
        transition: background-color 500ms ease-out;
    }
    .boutton:hover{
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
    .content{
        margin-top: 7%;
    }
    .linkRoom{
        text-decoration: none;
    }
    <?php if($_SESSION['theme']=="sombre"):?>
        .chambre, .price{
            background-color: #222;
            color: white;
        }

    <?php endif;?>    
    @media screen and (max-width:600px){
        .description{
            display: none;
        }
        .text{
           display: flex;
            flex-direction: column;
            align-items: flex-end;
            padding-right: 5%;
        }
        picture{
            width: 45%;
        }
    }
    @media screen and (max-width:780px){
        .content{
            margin-top: 100px;
            height: 100%;
            margin-left: none;
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
            display: flex;
            justify-content: center;
        }
        img{
            width: 90%;
        }
        .chambre{
            /* width: 85%;
            margin-left: 7.5%;
            margin-right: 7.5%; */
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
            /* margin-left: 5%; */
        }
        
    }
     .noFavori{
         height: 70vh;
         display: flex;
         justify-content: center;
         align-items: center;
         font-weight: 600;
         font-size: xx-large;
         width: 100%;
     }     
</style>

<?php if(!empty($_SESSION['id'])){
    $id = $_SESSION['id'];
    $clientInfos = getClient($dbh, $id);
    $numberOfFavorites = getNumberOfFavorite($dbh,$id);
    //on vérifie si le client a un favoris
    if($numberOfFavorites === 0){
        ?>
        <!-- <div class="content"> -->
            <!-- <p><?= $lang['noFavourites'] ?></p> -->
        <!-- </div> -->
            <?php
    }
    //on récupère les favoris du client
    $favorites = getFavoriteOfClient($dbh, $id);
    if(isset($_POST['delete'])){
        $idForRemove = $_POST['favoriteId'];
        removeFavorite($dbh,$idForRemove);
        ?>
        <meta http-equiv="refresh" content="0">
<?php
    }
    ?>
   <div class="content">
        <?php if($numberOfFavorites === 0): ?>
            
            
            <p class="noFavori"><?= $lang['noFavourites'] ?></p>
        <?php endif ?>    
<?php
//on cycle sur tous les favoris du client
    foreach ($favorites as $favorite){
        $favoriteId = $favorite['id'];
        $chambreId = $favorite['chambre_id'];
        $room = getRoom($dbh, $chambreId);
        $img = $room[0]['image'];
        $prix = $room[0]['prix'];
        $categorie = $room[0]['libelle'];
        $capacite = $room[0]['capacite'];

        ?>

        <a class="linkRoom" href="infochambre.php?id=<?= $chambreId ?>">
        <div class="chambre">
        
       

    
            <div class="picture"><img src="<?php echo($img)?>"></div>
            <div class="text">
                <h3><?= $lang['room'] ?> <?php echo($chambreId)?></h3>
                <p class="description"><?php echo($categorie)?></p>
                <p class="capacity"><?php echo($capacite)?>  <?php echo $capacite < 2 ? $lang['aPerson'] : $lang['people'] ;?></p>
            </div>
            <div class="prix" >
                <h2 class="price"><?php echo($prix)?> €</h2>
                <!-- <a href="infoChambre.php?id=<?php echo($chambreId)?>"><button class="boutton">Réserver</button></a> -->
                <form action="" method="post"><input type="hidden" name="favoriteId" value="<?= $favoriteId ?>">
                <button type="submit" name="delete" class="button"><?= $lang['deleteBookmark'] ?></button></form>
            </div>
        </div>
        </a>

    <?php
    }
}else{
    ?>
        <meta http-equiv="refresh" content="0;URL=connexion.php">
            <?php
    }
?>
</div>
<?php require_once '../component/footer.php';?>