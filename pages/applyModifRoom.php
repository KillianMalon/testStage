<?php
require_once '../component/header.php';
require_once '../functions/sql.php';
require_once 'bdd.php';

//Stockage des informations du POST
$id = $_POST['id'];
$capacite = $_POST['capacite'];
$exposition = $_POST['exposition'];
$douche = $_POST['douche'];
$etage = $_POST['etage'];
$tarif_id = $_POST['prix'];
$description = $_POST['description'];
$image = $_POST['image'];

//Mise à jour des informations de la chambre en bdd
updateRoom($dbh, $id, $capacite, $exposition, $douche, $etage, $tarif_id, $description, $image);

//Envoi de confirmation de mise à jour
$ok = "La modification a bien été sauvegardée";

//Redirection automatique (au bout de 2 secondes)
header('Refresh: 2; URL=./infoChambre.php?id='.$id);
?>
<!-- Affichage de la confirmation -->
<div class="content">
    <p style="background-color: forestgreen; color: white; text-align: center;"><?php echo isset($ok)? $ok : "";?></p>
</div>