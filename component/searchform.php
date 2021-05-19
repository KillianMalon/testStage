<?php
if ($index=1){
    require_once './functions/sql.php';
    require_once './pages/bdd.php';
}
else{
    require_once '../functions/sql.php';
    require_once 'bdd.php';
}


$prices = getPrices($dbh);

$today =date("Y-m-d");

$tomorrow  = new DateTime();

$tomorrow->add(new DateInterval('P1D'));

$tomorrowFormatted = $tomorrow->format('Y-m-d');

//Formulaire de recherche de disponibilité des chambres
?>
<style>

.formulaire{
    display: flex;
    flex-direction: column;
    align-items: center;
    color: grey;
    margin-top: 50px;
}
/* form{
    border: 1px solid #c7ccd4;
    border-radius: 20px;
} */
.date, .capacity, .exposition{
    display: flex;
    flex-direction: row;
    /* justify-content: space-around; */
    text-align: left;
}
.date{
    border: 1px solid #c7ccd4;
    border-radius: 20px 20px 0px 0px;
}
.capacity{
    border-right: 1px solid #c7ccd4;
    border-left: 1px solid #c7ccd4;  
}
.exposition{
    border: 1px solid #c7ccd4;
    
}
button{
    width: 100%;
    border-radius: 0px 0px 20px 20px;
    padding: 6% ;
    border: none;
    background: linear-gradient(to right, #19B3D3, #1992d3, #196ad3);
    cursor: pointer;
    color: white;
    font-size: large;
}
button:hover{
    box-shadow: 2px 2px 12px grey;
}
.capacity2{
    display: flex;
    flex-direction: column;
}
.exposition2{
    display: flex;
    flex-direction: column;
}
.capacity2, .exposition2, .date2{
    padding: 10%;
    width: 100%;
}
label{
    margin-bottom: 5%;
}
.input{
    margin-top: 5%;
}
input, select{
    border: 1px solid #c7ccd4;
    padding: 10%;
    background-color: #ececec;
    border-radius: 10px;
    cursor: pointer;
}
.line{
    border-right: 1px solid #c7ccd4;
}
.option{
    display: flex;
    justify-content: center;
    align-items: center;
    justify-content: space-around;
    border-left: 1px solid #c7ccd4;
    border-right: 1px solid #c7ccd4;
    padding: 10%;
    
}
@media screen and (max-width: 600px){
        .formulaire{
            font-size: 1rem;
        }  
        input, select{
            border: 1px solid #c7ccd4;
            padding: 3%;
            background-color: #ececec;
            border-radius: 10px;
            cursor: pointer;
            width: 80%;
        }   
        select{
            margin-top: 3%;
        }
        .date, .capacity, .exposition{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .date2, .capacity2, .exposition2{
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        form{
            width: 85%;
        }
        .content{
            height: 100%;
            margin-bottom: 50px;
        }
        .capacity2, .exposition2, .date2{
            padding: 0%;
            padding-top: 3%;
            padding-bottom: 6%;
            width: 100%;
        }
        .line{
            border-right: none;
            border-bottom: 1px solid #c7ccd4;
        }
        label{
            margin-bottom: 0%;
        }

}

<?php if($_SESSION['theme']=="sombre"):?>
    input, select{
        background-color: #464644;
        color: #ececec;
    }
<?php endif;?>
</style>
<div class="content">
    <div class="formulaire">
        <form method="post" action="./pages/recherche.php">
            <div class="date">
                <div class="date2 line"> 
                    <label for="">Date d'arrivée</label>
                    <input class="input" value="<?php echo $today ?>" name="arrivee" type="date" placeholder="Arrivée" required pattern="^[0-9]{4}-[0-9]{2}-[0-9]{2}$">
                </div>
                <div class="date2">
                    <label for="">Date de départ</label>
                    <input class="input" value="<?php echo $tomorrowFormatted ?>"   name="depart" type="date" placeholder="Départ" required pattern="^[0-9]{4}-[0-9]{2}-[0-9]{2}$">
                </div>
            </div>
            <div class="capacity">
                <div class="capacity2 line">
                    <label for="">Adultes</label>
                    <select required name="adulte">
                        <option value="">Sélectionnez</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </div>
                <div class="capacity2">
                    <label for="">Enfants</label>
                    <select name="enfant">
                        <option value="0">Sélectionnez</option>
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </div>
            </div>

            <div class="exposition">
                <div class="exposition2 line">
                    <label for="">Exposition</label>
                    <select name="exposition">
                        <option value="0">Sélectionnez</option>
                        <option value="port">Port</option>
                        <option value="rempart">Rempart</option>
                    </select>
                    <br>

                </div>
                <div class="exposition2">
                    <label for="">Prix maximum</label>
                    <select name="prix">
                        <option value="">Sélectionnez</option>
                        <option value="0">Peu importe</option>
                        <?php
                        foreach($prices as $price){
                            $id = $price['id'];
                            $prix = $price['prix'];
                            ?>
                            <option value="<?= $id ?>"><?= $prix ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    
                </div>
                  
            </div>  
            <div class="option">    
                    <?php
                    $options = getOptions($dbh);
                    foreach ($options as $option){?>
                    <div>
                        <label><?= $option['option'] ?></label>
                        <input type="checkbox" name="options[]" value="<?= $option['id'] ?>">
                    </div>
                    <?php
                    }
                    ?>
            </div>   
            <button type="submit">Rechercher</button>
        </form>
    </div>    
</div>
<!-- <?php require_once 'cookie.php'; ?> -->
</body>
</html>