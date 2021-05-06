<?php
require_once '../component/header.php';
require_once '../functions/sql.php';
require_once 'bdd.php';
?>
<style>
    .chambre{
        width: 85%;
        display: flex;
        flex-direction: row;
        align-items: center;
        border-radius: 15px;
        margin-bottom: 4%;
        /* padding: 3%; */
        margin-left: 2%;
    }
    .chambre:hover{
        box-shadow: 2px 2px 12px grey;
    }
    h2{
        color: black;
        margin-bottom: 0rem;
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
        padding: 5%;
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
    .boutton{
        padding: 15%;
        border-radius: 15px;
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
</style>

<?php if(!empty($_SESSION['id'])){
    $id = $_SESSION['id'];
    $clientInfos = getClient($dbh, $id);
    $numberOfFavorites = getNumberOfFavorite($dbh,$id);
    if($numberOfFavorites === 0){
        ?>
        <div class="content">
            <p>Vous n'avez aucun favoris pour le moment</p>
        </div>
            <?php
    }
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
       
<?php
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
                <h3>Chambre <?php echo($chambreId)?></h3>
                <p class="description"><?php echo($categorie)?></p>
                <p class="capacity"><?php echo($capacite)?>  <?php echo $capacite < 2 ? 'personne' : 'personnes' ;?></p>
            </div>
            <div class="prix" >
                <h2 class="price"><?php echo($prix)?> €</h2>
                <!-- <a href="infoChambre.php?id=<?php echo($chambreId)?>"><button class="boutton">Réserver</button></a> -->
                <form action="" method="post"><input type="hidden" name="favoriteId" value="<?= $favoriteId ?>"><button type="submit" name="delete" class="button">Supprimer le favori</button></form>
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