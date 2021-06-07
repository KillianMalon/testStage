<?php
require_once '../component/session.php';
require_once '../component/header.php';
require_once '../functions/functions.php';
require_once '../functions/sql.php';
require_once  'bdd.php';
?>

<style>
.content{
    display: flex;
    justify-content: center;
}
.contact{
    height: 70%;
    display: flex;
    flex-direction: row;
    justify-content: space-around;
    align-items: center;
    background-color: #5D5D5D;
    margin-top: 3%;
    width: 75%;
    border-radius: 15px;
}
.enveloppe{
    width: 65%;
}
.divContact{
    width:140%;
    display: flex;
    justify-content: center;
}
.divContact2{
    width:100%;
    display: flex;
    justify-content: left;
    align-items: center;
    height: 60%;
}
.contactInput{
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
.contactText{
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
.formContact{
     width: 100%;
   /* height: 100%; */
}
.submit{
    padding: 4%;
    border-radius: 30px;
    border: none;
    background: linear-gradient(to right, #19B3D3, #1992d3, #196ad3);
    color: white;
    width: 77%;
}
@media screen and (max-width: 1100px){
    .contact{
    display: flex;
    flex-direction: column;
    justify-content: space-around;
    align-items: center;
    background-color: #5D5D5D;
    margin-top: 6%;
    width: 75%;
    border-radius: 15px;
    }
    .enveloppe{
        width: 35%;
    }
    .divContact2{
        width:100%;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 60%;
    }
    .formContact{
        width: 100%;
        display: flex;
        align-items: center;
        flex-direction:column;
            /* height: 100%; */
    }   
    .contactInput, .contactText{
        margin-bottom: 0px;
    }
    .contact{
        height: 80%;
    }
}
@media screen and (max-width: 600px){
    .divContact{
        display: none;
    }
    .contact{
        height: 62%;
        margin-top: -70px;
        width: 90%;
    }
    .content{
        height: 80vh;
        display: flex;
        align-items: center;
    }
    
}



</style>
<div class="content">
    
<iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d23109.374106462023!2d3.8673648944766543!3d43.61337549657565!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sRestaurants!5e0!3m2!1sfr!2sfr!4v1622464934450!5m2!1sfr!2sfr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
</div>

<?php require_once '../component/footer.php';?>