<style>
    
    footer{
    width: (100% - 250px);
    margin-left: 250px;    
    transition: 0.5s;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    }
    .test{
        padding: 2%;
        padding-left: 10%;
        background-color: #5D5D5D ;
        width: 100%;
        text-align: left;
        display: flex;
        flex-direction: column;
    
    }
    #check:checked ~ footer{
    margin-left: 60px;
    }
    .title{
        font-size: larger;
        text-decoration: none;
        color:  white ;
        margin-bottom: 4%;
        font-weight: bold;
    }
    .lien{
        text-decoration: none;
        color:  white ;
        margin-bottom: 3%;
    }
    .lien:hover{
        color:  black ;
    }
    .mail{
        margin-top: 0px;
        color: white;
    }
    @media screen and (max-width: 780px){
        footer{
            margin-left: 0;
            margin-top: 0;
            transition: 0s;
        }
    }
    @media screen and (max-width: 515px){
        footer{
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }    
        .test{
        text-align: center;
        padding: 0%;
    
    }
}
</style>

<footer>
    <div class="test">
        <p class="title">MENTIONS LEGALES</p>
        <a class="lien" href="<?php echo (isset($index)) ? "./pages/mentionslegales.php" : "mentionslegales.php" ?>">Mentions Légales</a>
        <a class="lien" href="<?php echo (isset($index)) ? "./pages/cgv.php" : "cgv.php" ?>">C.G.V</a>
    </div>
    <div class="test">
        <p class="title">INFORMATIONS</p>
        <a class="lien" href="<?php echo (isset($index)) ? "./pages/contact.php" : "contact.php" ?>">Contact</a>
        <a class="lien" href="<?php echo (isset($index)) ? "./pages/contact.php" : "contact.php" ?>">Conditions d'utilisations</a>
        <p class="mail">contact@dorianroulet.com</p>
    </div>
    <!-- <div class="test">
        <a class="lien" href="./pages/mentionslegales.php">Mentions légales</a>
    </div> -->
</footer>