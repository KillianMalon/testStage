<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://i.ibb.co/KGZxRkj/hr.png">
    <title>Hotel</title>
    <?php
    //utiliser une seule page css pour plusieurs fichiers (pas au meme niveau de répertoire)
    if(isset($index) and $index = 1){
        ?>
        
        <?php require_once('./css/style.php');
    }else{
        ?>
        <?php  require_once('../css/style.php');
    }
    ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>

</head>
<body>

<input type="checkbox" id="check">
<!--header area start-->
<header>
    <label for="check">
        <i class="fas fa-bars" id="sidebar_btn"></i>
    </label>
    <div class="left_area">
        <h3>Hotel <span>Nom</span></h3>
    </div>
    <?php if (isset($_SESSION['id']) and !empty($_SESSION['id'])){ ?>
            
        
        <div class="right_area for">
            <form class="formu" action="" method='POST'>
            <?php
            if(empty($_SESSION['theme'])):?>
                <button type="submit" name="theme" value="black" class="theme"><i class="fas fa-moon"></i></button>
            <?php else:?>
                <button type="submit" name="theme" value="white" class="theme"><i class="fas fa-sun"></i></button>
            <?php endif;?>

            </form>
            
        </div>
        <div class="right_area2">
            <a href="<?php echo (isset($index)) ? "./pages/logout.php" : "logout.php" ?>" class="logout_btn"><?= $lang['logOut']; ?></a>
            <i class="fa fa-bars nav_btn" id="slider"></i>
        </div>
        
        
        
    <?php } else { ?>
        <div class="right_area1">
            <form class="formu" action="" method='POST'>
            <?php
            if(empty($_SESSION['theme'])):?>
                <button type="submit" name="theme" value="black" class="theme2"><i class="fas fa-moon"></i></button>
            <?php else:?>
                <button type="submit" name="theme" value="white" class="theme2"><i class="fas fa-sun"></i></button>
            <?php endif;?>

            </form>
        </div>
        <div class="right_area2">
            <a href="<?php echo (isset($index)) ? "./pages/inscription.php" : "inscription.php" ?>" class="logout_btn2"><?= $lang['signUp']; ?></a>
            <i class="fa fa-bars nav_btn" id="slider"></i>
        </div>
        <div class="right_area3">
            <a href="<?php echo (isset($index)) ? "./pages/connexion.php" : "connexion.php" ?>" class="logout_btn"><?= $lang['logIn']; ?></a>
        </div>
    <?php } ?>
</header>
<!--header area end-->

<!--mobile navigation bar start-->

<div class="mobile_nav">
    <div class="nav_bar">
        <img src="<?php echo isset($_SESSION['id'])? $img : "https://i.ibb.co/47nY0vM/default-avatar.jpg" ;?>" class="mobile_profile_image" alt="">
        <i class="fa fa-bars nav_btn"></i>
    </div>
    <div class="mobile_nav_items">
        <?php if (!isset($_SESSION['id'])){ ?>
            <a href="<?php echo (isset($index)) ? "index.php" : "../index.php"; ?>"><i class="fas fa-home"></i><span><?= $lang['home']; ?></span></a>
            <a href="<?php echo (isset($index)) ? "./pages/chambres.php" : "chambres.php"?>"><i class="fas fa-bed"></i><span><?= $lang['rooms']; ?></span></a>
            <a href="<?php echo (isset($index)) ? "./pages/contact.php" : "contact.php" ?>"><i class="fas fa-comment"></i><span><?= $lang['contact']; ?></span></a>
            <a href="<?php echo (isset($index)) ? "./pages/inscription.php" : "inscription.php" ?>"><i class="fas fa-sign"></i><span><?= $lang['signUp']; ?></span></a>
            <a href="<?php echo (isset($index)) ? "./pages/connexion.php" : "connexion.php" ?>"><i class="fas fa-sign-in-alt"></i><span><?= $lang['logIn']; ?></span></a>
        <?php }else{
            $nbOfFavorites = getNumberOfFavorite($dbh, $_SESSION['id']);
            ?>

            <a href="<?php echo (isset($index)) ? "index.php" : "../index.php"; ?>"><i class="fas fa-home"></i><span><?= $lang['home']; ?></span></a>
            <a href="<?php echo (isset($index)) ? "./pages/chambres.php" : "chambres.php"?>"><i class="fas fa-bed"></i><span><?= $lang['rooms']; ?></span></a>
            <a href="<?php echo (isset($index)) ? "./pages/espace_client.php" : "espace_client.php" ?>"><i class="fas fa-user"></i><span><?= $lang['myAccount']; ?></span></a>
            <a href="<?php echo (isset($index)) ? "./pages/reservations.php" : "reservations.php" ?>"><i class="fas fa-table"></i><span><?= $lang['myBookings']; ?></span></a>
            <a href="<?php echo (isset($index)) ? "./pages/favorites.php" : "favorites.php" ?>"><i class="fas fa-bookmark"></i><span><?= $lang['myFavourites']; ?> <?php echo ($nbOfFavorites > 0)? "($nbOfFavorites)":""?></span></a>
            <a href="<?php echo (isset($index)) ? "./pages/contact.php" : "contact.php" ?>"><i class="fas fa-comment"></i><span><?= $lang['contact']; ?></span></a>
            <a href="<?php echo (isset($index)) ? "./pages/logout.php" : "logout.php" ?>"><i class="fas fa-sign-out-alt"></i><span><?= $lang['logOut']; ?></span></a>
            
            <?php if(isset($admin)){ ?>
                <a href="<?php echo (isset($index)) ? "./pages/statistics.php" : "statistics.php"?>"><i class="fas fa-chart-bar"></i><span><?= $lang['statistics']; ?></span></a>
                <a href="<?php echo (isset($index)) ? "./pages/administration.php" : "administration.php"?>"><i class="fas fa-users-cog"></i><span><?= $lang['administration']; ?></span></a>
                <a href="<?php echo (isset($index)) ? "./pages/newsletter.php" : "newsletter.php"?>"><i class="fas fa-users-cog"></i><span>Newsletter</span></a>    
            <?php } ?>
        <?php } ?>
        <!--
        <a href="#"><i class="fas fa-th"></i><span>Forms</span></a>-->
    </div>
</div>
<!--mobile navigation bar end-->
<!--sidebar start-->
<div class="sidebar">
    <div class="profile_info">
        <img src="<?php echo isset($_SESSION['id'])? $img : "https://i.ibb.co/47nY0vM/default-avatar.jpg"; ?>" class="profile_image" alt="">
        <?php if(isset($_SESSION['id'])){ ?>
            <h4><?= $name ?></h4>
        <?php } ?>
    </div>
    <?php if (!isset($_SESSION['id'])){ ?>
        <a href="<?php echo (isset($index)) ? "index.php" : "../index.php"; ?>"><i class="fas fa-home"></i><span><?= $lang['home']; ?></span></a>
        <a href="<?php echo (isset($index)) ? "./pages/chambres.php" : "chambres.php"?>"><i class="fas fa-bed"></i><span><?= $lang['rooms']; ?></span></a>
        <a href="<?php echo (isset($index)) ? "./pages/contact.php" : "contact.php" ?>"><i class="fas fa-comment"></i><span><?= $lang['contact']; ?></span></a>
    <?php }else{ ?>
        <a href="<?php echo (isset($index)) ? "index.php" : "../index.php"; ?>"><i class="fas fa-home"></i><span><?= $lang['home']; ?></span></a>
        <a href="<?php echo (isset($index)) ? "./pages/chambres.php" : "chambres.php"?>"><i class="fas fa-bed"></i><span><?= $lang['rooms']; ?></span></a>
        <a href="<?php echo (isset($index)) ? "./pages/espace_client.php" : "espace_client.php" ?>"><i class="fas fa-user"></i><span><?= $lang['myAccount']; ?></span></a>
        <a href="<?php echo (isset($index)) ? "./pages/reservations.php" : "reservations.php" ?>"><i class="fas fa-table"></i><span><?= $lang['myBookings']; ?></span></a>
        <a href="<?php echo (isset($index)) ? "./pages/favorites.php" : "favorites.php" ?>"><i class="fas fa-bookmark"></i><span><?= $lang['myFavourites']; ?> <?php echo ($nbOfFavorites > 0)? "($nbOfFavorites)":""?></span></a>
        <a href="<?php echo (isset($index)) ? "./pages/contact.php" : "contact.php" ?>"><i class="fas fa-comment"></i><span><?= $lang['contact']; ?></span></a>
        <?php if(isset($admin)){ ?>
            <a href="<?php echo (isset($index)) ? "./pages/statistics.php" : "statistics.php"?>"><i class="fas fa-chart-bar"></i><span><?= $lang['statistics']; ?></span></a>
            <a href="<?php echo (isset($index)) ? "./pages/administration.php" : "administration.php"?>"><i class="fas fa-users-cog"></i><span><?= $lang['administration']; ?></span></a>
            <a href="<?php echo (isset($index)) ? "./pages/newsletter.php" : "newsletter.php"?>"><i class="fas fa-users-cog"></i><span>Newsletter</span></a>
            <?php
        }
    }
    ?>
    <!--
    <a href="#"><i class="fas fa-th"></i><span>Forms</span></a>-->
</div>
<!--sidebar end-->
<script type="text/javascript">
    $(document).ready(function(){
        $('.nav_btn').click(function(){
            $('.mobile_nav_items').toggleClass('active');
        });
    });
</script>
