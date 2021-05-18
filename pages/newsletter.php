<?php
require_once '../component/session.php';
require_once '../component/header.php';
require_once '../functions/functions.php';
require_once '../functions/sql.php';
require_once  'bdd.php';

?>
<!-- <div class="content">
    <div class="form">
        <form method="post" action="send_newsletter.php">
            <textarea name="contenu" >

            </textarea>
            <input type="submit" name="submit" value="<?= $lang['sendNewsletter']; ?>">
        </form>
    </div>
</div> -->

<style>
.content{
    display: flex;
    justify-content: center;
}
.newsletter{
    height: 60%;
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    background-color: #5D5D5D;
    margin-top: 6%;
    width: 75%;
    border-radius: 15px;
}
.divNewsletter{
    width:140%;
    display: flex;
    justify-content: center;
}
.divNewsletter2{
    width:100%;
    display: flex;
    justify-content: left;
    align-items: center;
    height: 60%;
}
.newsletterInput{
    padding: 3%;
    border-radius: 30px;
    border: none;
    background-color: #BEBBBB;
    margin-bottom: 4%;
    color: black;
    width: 70%;
    padding-left:3% ;
    /* padding-right: 10%; */
}
.newsletterText{
    padding: 3%;
    border-radius: 30px;
    border: none;
    background-color: #BEBBBB;
    margin-bottom: 4%;
    color: black;
    width: 70%;
    resize : none;
   height: 170px;
   padding-left:3% ;
}
input::placeholder, textarea::placeholder{
    color: black;
    font-family: sans-serif;
}
.formNewsletter{
     width: 100%;
     display: flex;
        align-items: center;
        flex-direction:column;
   /* height: 100%; */
}
.submit{
    padding: 2%;
    border-radius: 30px;
    border: none;
    background: linear-gradient(to right, #19B3D3, #1992d3, #196ad3);
    color: white;
    width: 77%;
}
@media screen and (max-width: 1100px){
    .newsletter{
    display: flex;
    flex-direction: column;
    justify-content: space-around;
    align-items: center;
    background-color: #5D5D5D;
    margin-top: 3%;
    width: 75%;
    border-radius: 15px;
    }
    .divNewsletter2{
        width:100%;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 60%;
    }
    .formNewsletter{
        width: 100%;
        display: flex;
        align-items: center;
        flex-direction:column;
            /* height: 100%; */
    }   
    .newsletterInput, .newsletterText{
        margin-bottom: 0px;
    }
    .newsletter{
        height: 80%;
    }
}
@media screen and (max-width: 600px){
    .divNewsletter{
        display: none;
    }
    .newsletter{
        height: 50%;
    }
}
</style>
<div class="content">
    
    <div class="newsletter">
        <div class="divNewsletter2">
            <form class="formNewsletter" method="post" action="send_mail.php">
            <h2>Newsletter</h2>
                <textarea class="newsletterText" name="contenu" placeholder="Message"></textarea>
                <br>
                <input class="submit" type="submit" value="<?= $lang['sendNewsletter']; ?>">
            </form>
        </div>
    </div>
</div>
<?php require_once '../component/footer.php';?>