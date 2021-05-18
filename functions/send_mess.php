<!-- Chat inutile pour le moment-->

<?php session_start();
include '../pages/chat.php';
include '../pages/bdd.php';
include 'sql.php';

if (isset($_SESSION['id'])){

    $mess = htmlspecialchars(trim($_GET['message']));

    if (isset($mess) && !empty($mess)){
        $verif_user = verifUser($dbh, $_SESSION['id']);

        if (isset($verif_user)){
            $date_message = date('Y-m-d H:i:s');
            addMessage($dbh, $_SESSION['id'], $mess, $date_message);
            $lastID = getLastiD($dbh, $_SESSION['id']);

            $date_message = date_create($date_message);
            $date_message = date_format($date_message, 'd m Y à H:i:s');
            ?>
            <div>
                <span id="<?= $lastID ?>">
                    <?= nl2br($mess) ?>
                </span>
                <div>Par <?= $verif_user ?>, le <?= $date_message ?></div>
            </div>

<script>
    document.getElementById('msg').scrollTop = document.getElementById('msg').scrollHeight;
</script>
            <?php
        }
    }
}
?>