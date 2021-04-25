<?php
require_once '../component/header.php';
require_once '../functions/sql.php';
require_once 'bdd.php';

if(!isset($_SESSION['id'])){
    if(isset($_GET['fname']) AND isset($_GET['lname']) AND isset($_GET['mail']) AND isset($_GET['pwd']) AND isset($_GET['address']) AND isset($_GET['pc']) AND isset($_GET['town']) AND isset($_GET['country']) AND isset($_GET['civility']) AND isset($_GET['img'])){
        $firstName = $_GET['fname'];
        $lastName = $_GET['lname'];
        $mail = $_GET['mail'];
        $password = $_GET['pwd'];
        $address = $_GET['address'];
        $postalCode = $_GET['pc'];
        $city = $_GET['town'];
        $country = $_GET['country'];
        $civility = $_GET['civility'];
        $image = $_GET['img'];
        inscription($dbh, $firstName, $lastName, $mail, $password, $address, $postalCode, $city, $country, $civility, $image);
        $user = getUserByMail($dbh, $mail);
        $_SESSION['id'] = $user['id'];
        $ok = "Votre inscription à été enregistré, bienvenue sur notre site!";
        header('Refresh: 2; URL=../index.php');
    }else{
        header("Location:../index.php");
    }
}else{
    header("Location:../index.php");
}
?>
<div class="content">
    <p style="background-color: forestgreen; color: white; text-align: center;"><?php echo isset($ok)? $ok : ""  ?></p>
</div>
