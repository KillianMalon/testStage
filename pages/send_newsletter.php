<?php
require_once '../component/header.php';
require_once '../functions/sql.php';
require_once 'bdd.php';

$allmails = getMailsNewsletter($dbh);

if (isset($_POST['contenu']) && !empty($_POST['contenu'])){
    $contenu = $_POST['contenu'];
}
$headers  = 'From: envoiedemailtest@gmail.com'. "\r\n" .
    'MIME-Version: 1.0' . "\r\n" .
    'Content-type: text/html; charset=utf-8';

echo '<div class="content">';
foreach ($allmails as $allmail){
    $mail = $allmail['mail'];
    mail($mail, "Newsletter Hotel", $contenu, $headers);
}
?>
<div class="content">
    <meta http-equiv="refresh" content="2;URL=newsletter.php"><p style="background-color: forestgreen; color: white; text-align: center;"><?php echo "La Newsletter a bien été envoyée.";?></p>
</div>

