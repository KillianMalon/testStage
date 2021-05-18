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
require_once 'bdd.php';
$reservation = getReservations($dbh, $_SESSION['id']);
if($reservation === 0){
    header('Location:reservations.php');
}
$dir2 = "Facture/".$_SESSION['id'];

if(!file_exists($dir2)){
    //TODO afficher un message avant
header("Location:./reservations.php");
}
if(sizeof(scandir($dir2)) <= 2){
    header("Location:./reservations.php");
}
require_once '../component/header.php';
$id = $_SESSION['id'];
//le dossier sur lequel j'ai envie de travailler
$dir = "Facture";
//je stocke dans folder tous les enfants de "Facture" (dans mon cas les id des clients qui sont des noms de dossiers)
$trueDir = "Facture/".$id;
//scandir liste le contenu d'un dossier et array_slice permet de retirer les "." et ".." qui permettent à scandir de tout récup
$files = array_slice(scandir($trueDir), 2);
?>
<style>
    .content{
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
    }
    .div:hover {
        background-color: #3e3e3e;
        color: #19B3D3;
    }
    .div a{
        color: white;
        text-decoration:none;
    }
    .div a:hover{
        color: #1992d3;
    }
    .popup{
        margin-top: -2px;
        display: none;
        position: fixed;
        width: 83%;
        background: rgba(0,0,0,0.7);
    }
    .popup:target{
        display: table;
    }
    .popup embed{
        padding-bottom: 5%;
        width: 80%;
        margin-left: 10%;
        height: 85vh;
    }
</style>
<div class="content">

    <?php
    foreach ($files as $file){
        //je récupère que les nombres dans la chaine de caractères $file
        $out = preg_replace('~\D~', '', $file);
        ?>
        <div class="div">
            <!--"a" qui target la popup et qui permet donc de l'afficher-->
            <p style="text-align: center"><a href="#<?= $out ?>"  ><?= $file ?></a></p>
            <embed style="margin-top: 1%" src="<?= $trueDir."/".$file ?>" width="400" height="300" type="">
        </div>
        <!--POPUP qui s'affiche au click du "a" au dessus -->
        <div class="popup" id="<?= $out ?>">
            <a href="" style="color: white; text-decoration: none;">X</a>
            <br>
            <!--Fabrication manuelle du chemin pour accèder au pdf-->
            <?php $bigPdf = $trueDir."/"."Facture-$out"; ?>
            <embed src="<?= $bigPdf ?>" type="">
        </div>
        <?php
    }
    ?>
</div>