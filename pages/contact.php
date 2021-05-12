<?php
require_once '../component/session.php';
require_once '../component/header.php';
require_once '../functions/functions.php';
require_once '../functions/sql.php';
require_once  'bdd.php';
?>

<div class="content">
    <form method="post" action="send_mail.php">
        <label><?= $lang['yourMail']; ?></label>
        <input name="email" type="text">
        <br>
        <label><?= $lang['yourMessage'] ?></label>
        <textarea name="text"></textarea>
        <br>
        <input type="submit" value="<?= $lang['send'] ?>">
    </form>
</div>
