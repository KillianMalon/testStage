<?php
//require_once '../component/header.php';
require_once '../functions/sql.php';
require_once '../functions/functions.php';
require_once 'bdd.php';

if (isset($_POST['description']) && !empty($_POST['description'])) {

    $count = countChambers($dbh);
    $id = $count['0'];
    $id = (int) $id + 1;
    $capacite = $_POST['capacite'];
    $exposition = $_POST['exposition'];
    $douche = $_POST['douche'];
    $etage = $_POST['etage'];
    $prix = $_POST['prix'];
    $description = $_POST['description'];
    $img = $_POST['image'];

    addChamber($dbh, $id, $capacite, $exposition, $douche, $etage, $prix, $description, $img);
    sendMailChamber($dbh);
?>
<div class="content">
    <meta http-equiv="refresh" content="2;URL=administration.php"><p style="background-color: forestgreen; color: white; text-align: center;"><?php echo "La chambre a bien été ajoutée";?></p>
</div>
<?php
}else{
    ?>
    <div class="content">
        <meta http-equiv="refresh" content="2;URL=administration.php"><p style="background-color: darkred; color: white; text-align: center;"><?php echo "Une erreur est survenue.";?></p>
    </div>
<?php
}
?>