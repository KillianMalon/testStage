<?php
require_once '../component/session.php';
require_once '../component/header.php';
require_once '../functions/functions.php';
require_once '../functions/sql.php';
require_once  'bdd.php';

if (isset($_POST['email']) && !empty($_POST{'email'}) && isset($_POST['text']) && !empty($_POST['text'])){
    $mail = $_POST['email'];
    $text = $_POST['text'];

    $to = $mail;
    $subject  = 'Contact';
    $headers  = 'From: '. $mail . "\r\n" .
        'MIME-Version: 1.0' . "\r\n" .
        'Content-type: text/html; charset=utf-8';
    mail('envoiedemailtest@gmail.com', $subject, $text, $headers);
    if(mail('nathan.caruelle@epsi.fr', $subject, $text, $headers)) {
        mail($to, $subject, 'Votre message a bien été envoyé. Le voici : ' . $text, $headers);
        $msg = "Votre mail a bien été envoyé !";
        ;
    }else{
        $error = "Email sending failed";
    }
}
header('Refresh: 2; URL=../index.php');
?>
<div class="content">
    <p style="background-color: forestgreen; color: white; text-align: center;"><?php echo isset($msg)? $msg : "";?></p>
</div>
