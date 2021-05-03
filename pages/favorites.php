<?php
require_once '../component/header.php';
require_once '../functions/sql.php';
require_once 'bdd.php';
$id = $_SESSION['id'];
$favorites = getFavoriteOfClient($dbh, $id);

foreach ($favorites as $favorite){
    $chambreId = $favorite['chambre_id'];
    $room = getRoom($dbh, $chambreId);
    $img = $room['image'];
    ?>
    <div class="content">
        <div>
            <img src="<?= $img ?>" alt="">
        </div>

    </div>
<?php
}