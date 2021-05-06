<?php
require_once '../component/header.php';
require_once '../functions/sql.php';
require_once 'bdd.php';

?>
<div class="content">
    <div class="form">
        <form method="post" action="send_newsletter.php">
            <textarea name="contenu" >

            </textarea>
            <input type="submit" name="submit">
        </form>
    </div>
</div>
