<footer>
<?php
if (isset($_COOKIE['show_cookie']) && !empty($_COOKIE['show_cookie'])){
    if ($_COOKIE['show_cookie'] == false){
    ?>
        <div class="cookie-alert">
            En poursuivant votre navigation sur ce site, vous acceptez l'utilisation de cookies pour vous proposer des contenus et services adaptés à vos centres d'intérêt.<br /><a href="./functions/accept_cookies.php">OK</a>
        </div>
<?php
    }
} else {
    ?>
    <div class="cookie-alert">
        En poursuivant votre navigation sur ce site, vous acceptez l'utilisation de cookies pour vous proposer des contenus et services adaptés à vos centres d'intérêt.<br /><a href="./functions/accept_cookies.php">OK</a>
    </div>
    <?php
}
?>
</footer>