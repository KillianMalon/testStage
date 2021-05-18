<?php
session_start();
require_once 'bdd.php';
require_once '../functions/sql.php';
if(isset($_SESSION['id'])){
  $client = getClient($dbh, $_SESSION['id']);
  if($client['type'] != "client"){
      header("Location:../index.php");
  }
}else{
  header("Location:../index.php");
}


if(!isset($_POST['sendMail']) || empty($_POST['idReservation']) || !isset($_SESSION['id'])){
    ?>
    <meta http-equiv="refresh" content="0;URL=./reservations.php">
    <?php
}
$id = $_SESSION['id'];
$client = getClient($dbh,$id);
$name = $client['nom'];
$idReservation = $_POST['idReservation'];
$dateStart = $_POST['dateStart'];
$price = $_POST['prix'];
$date = date_create($dateStart);
$dateStart = date_format($date, 'd-m-Y');
$hour = date("H");
if($hour > 18 && $hour < 24){
    $hello ="Bonsoir";
}else{
    $hello = "Bonjour";
}
$mail = $client['mail']; // Déclaration de l'adresse de destination.
if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui présentent des bogues.
{
    $passage_ligne = "\r\n";
}
else
{
    $passage_ligne = "\n";
}
//=====Déclaration des messages au format texte et au format HTML.
$message_txt = "Mr/Mme $name";
$message_html = '<div
      style="display: flex;flex-direction: column;">
      <div style="background: rgb(32, 32, 32); color: white">
        <h2 style="text-align: center; padding: 10px">
          Hotel <span style="color: #1992d3">Nom</span>
        </h2>
      </div>
      <div
        style="color: white;background: linear-gradient(to right, #19b3d3, #1992d3, #196ad3);width: 100%;">
        <img
          style="width: 100%; object-fit: cover; height: 500px"
          src="https://cdn.styleblueprint.com/wp-content/uploads/2015/12/SB-ATL-ZookHome-9-e1538165814448.jpg"
          alt=""
        />
        <p style="margin-left: 1%">
          '.$hello.',<br/>
          Numéro de facture :'.$idReservation.'<br />
          <br />
          Nous vous informons que votre facture du '.$dateStart.' d\'un montant de ' .$price.'euros 
          est disponible en pièce jointe.
          <br />
          Nous vous remercions de nous avoir choisis et nous espérons que cette
          chambre vous plaira !
          <br />
          <br />
          En vous souhaitant un agréable séjour, <br />
          Bien Cordialement,
          <br />
          L\'équipe de l\'Hotel <span style="color: black"> Nom</span>
        </p>
      </div>
    </div>';
//==========
//=====Lecture et mise en forme de la pièce jointe.
$facture = "../pages/Facture/$id/facture-$idReservation.pdf";
$fichier   = fopen("$facture", "r");
$attachement = fread($fichier, filesize("$facture"));
$attachement = chunk_split(base64_encode($attachement));
fclose($fichier);
//==========
//=====Création de la boundary.
$boundary = "-----=".md5(rand());
$boundary_alt = "-----=".md5(rand());
//==========
//=====Définition du sujet.
$sujet = "Facture n°$idReservation";
//=========
//=====Création du header de l'e-mail.
$header = "From: \"HotelNom\"<envoiedemailtest@gmail.com>".$passage_ligne;
$header.= "Reply-to: \"$id\" <florianfournier150@gmail.com>".$passage_ligne;
$header.= "MIME-Version: 1.0".$passage_ligne;
$header.= "Content-Type: multipart/mixed;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
//==========
//=====Création du message.
$message = $passage_ligne."--".$boundary.$passage_ligne;
$message.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary_alt\"".$passage_ligne;
$message.= $passage_ligne."--".$boundary_alt.$passage_ligne;
//=====Ajout du message au format texte.
$message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_txt.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary_alt.$passage_ligne;
//=====Ajout du message au format HTML.
$message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_html.$passage_ligne;
//==========
//=====On ferme la boundary alternative.
$message.= $passage_ligne."--".$boundary_alt."--".$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary.$passage_ligne;
//image/jpeg pour image
//=====Ajout de la pièce jointe.
$fileName = "Facture-$idReservation.pdf";
$message.= "Content-Type: text/plain; name=\"$fileName\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: base64".$passage_ligne;
$message.= "Content-Disposition: attachment; filename=\"$fileName\"".$passage_ligne;
$message.= $passage_ligne.$attachement.$passage_ligne.$passage_ligne;
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
//==========
//=====Envoi de l'e-mail.
mail($mail,$sujet,$message,$header);
?>
<p style="color: white;" text-align: center;color: white; height: 100vh"> Vous avez bien reçu un mail sur : <?= $mail ?>  </p>
<meta http-equiv="refresh" content="10;URL=./reservations.php">
<div class="background">
    <iframe width="100%" height="100%" src="https://www.youtube.com/embed/EGohSsaCJOU?autoplay=1"  title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</div>

<style>
    .background{
        position: fixed;
        width: 100%;
        height: 100%;
        overflow: hidden;
        top:0;
        left: 0;
        z-index: 1000;
    }
    p{
        position: absolute;
        width: 100%;
        min-height: 100%;
        z-index: 1001;
        background-color: rgba(0,0,0,0.7);
        text-align: center;
        font-size: 25px ;
        font-weight:300;
        color: white;
    }
</style>