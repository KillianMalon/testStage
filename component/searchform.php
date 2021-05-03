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


//Formulaire de recherche de disponibilité des chambres
?>
<style>

.formulaire{
    display: flex;
    flex-direction: column;
    align-items: center;
    color: grey;
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
    border-bottom: none;
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
</style>
<div class="content">
    <div class="formulaire">
        <form method="post" action="./pages/recherche.php">
            <div class="date">
                <div class="date2 line"> 
                    <label for="">Date d'aarivée</label>
                    <input class="input" name="arrivee" type="date" placeholder="Arrivée" required pattern="^[0-9]{4}-[0-9]{2}-[0-9]{2}$">
                </div>
                <div class="date2">
                    <label for="">Date de départ</label>
                    <input class="input" name="depart" type="date" placeholder="Départ" pattern="^[0-9]{4}-[0-9]{2}-[0-9]{2}$">
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
            <button type="submit">Rechercher</button>
        </form>
    </div>    
</div>

</body>
</html>