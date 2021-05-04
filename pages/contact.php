<?php
require_once '../component/header.php';
require_once '../functions/functions.php';
require_once '../functions/sql.php';
require_once  'bdd.php';
?>

<div class="content">
    <form method="post" action="send_mail.php">
        <label>Votre Mail</label>
        <input name="email" type="text">
        <br>
        <label>Votre message</label>
        <textarea name="text"></textarea>
        <br>
        <input type="submit" value="Envoyer">
    </form>
</div>
