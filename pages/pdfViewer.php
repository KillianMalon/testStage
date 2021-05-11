<?php
require_once '../component/header.php';
require_once 'bdd.php';
$id = $_SESSION['id'];
//le dossier sur lequel j'ai envie de travailler
$dir = "Facture";
//je stocke dans folder tous les enfants de "Facture" (dans mon cas les id des clients qui sont des noms de dossiers)

$trueDir = "Facture/".$id;
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
        width: 82%;
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
//    preg_match_all('!\d+!', $file, $matches);
    $out = preg_replace('~\D~', '', $file);
    ?>
        <div class="div">
        <p style="text-align: center"><a href="#<?= $out ?>"  ><?= $file ?></a></p>
        <embed style="margin-top: 1%" src="<?= $trueDir."/".$file ?>" width="400" height="300" type="">
        </div>
    <div class="popup" id="<?= $out ?>">
        <a href="" style="color: white; text-decoration: none;">X</a>
        <br>
        <?php $bigPdf = $trueDir."/"."Facture-$out"; ?>
        <embed src="<?= $bigPdf ?>" type="">
    </div>
            <?php
}
?>
</div>
