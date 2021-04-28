<?php
require_once '../component/header.php';
require_once '../functions/sql.php';
require_once 'bdd.php';
$id = $_POST['id'];
$capacite = $_POST['capacite'];
$exposition = $_POST['exposition'];
$douche = $_POST['douche'];
$etage = $_POST['etage'];
$tarif_id = $_POST['prix'];
$description = $_POST['description'];
$image = $_POST['image'];

updateRoom($dbh, $id, $capacite, $exposition, $douche, $etage, $tarif_id, $description, $image);


$ok = "La modification a bien été sauvegardée";
header('Refresh: 2; URL=./infoChambre.php?id='.$id);
?>

<div class="content">
    <p style="background-color: forestgreen; color: white; text-align: center;"><?php echo isset($ok)? $ok : "";?></p>
</div>