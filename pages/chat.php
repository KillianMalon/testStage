<?php
require_once '../component/header.php';
require_once '../functions/sql.php';
require_once 'bdd.php';

if (isset($_SESSION['id']) && !empty($_SESSION['id'])){

    $see_tchat = getAllMessages($dbh);
}
?>
<div class="content">
    <div class="chat">
        <?php
        foreach ($see_tchat as $st) {
            $date_message = date_create($st['date']);
            $date_message = date_format($date_message, 'd M Y à H:i:s');
            $id = $st['id_auteur'];
            $client = getClient($dbh, $id);
            $pseudo = $client['nom'];

            $clients = getClient($dbh, $id);
            $pseudo = $clients['prenom'];

            if ($st['id_auteur'] === $_SESSION['id']){
                ?>
                <div style="background-color: #0B87A6">
                    <span id="<?= $st['id'] ?>">
                        <?= nl2br($st['message']) ?>
                    </span>
                    <div style="font-size: 10px; text-align: right; color: #3e3e3e">Par <?= $pseudo ?>, le <?= $date_message ?></div>
                </div>
                <?php
            }else{
                ?>
                <div style="background-color: #cccccc">
                    <span id="<?= $st['id'] ?>">
                        <?= nl2br($st['message']) ?>
                    </span>
                    <div style="font-size: 10px; text-align: right; color: #3e3e3e">Par <?= $pseudo ?>, le <?= $date_message ?></div>
                </div>
                <?php
            }
        }
        ?>
        <div id="message_recept"></div>

        <div class="post">
            <form method="post">
                <textarea class="autoExpand" name="text" id="message" rows="1" data-min-rows="1"></textarea>

                <input id="envoi" type="submit">
            </form>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">

    document.getElementById('msg').scrollTop = document.getElementById('msg').scrollHeight;

    $('envoi').click(function (e){
        e.preventDefault();

        var message = encodeURIComponent($('#message').val());

        message = message.trim();

        if (message != ""){
            $.ajax({
                url : 'localhost/testStage/hotel/function/send_mess.php?message=' + message,
                type : 'GET',
                dataType : "html",
                success : function (data){
                    $("#message_recept").append(data);
                }
            });
        }
    });

    setInterval("load_mess()", 1000);

    function load_mess(){
        var lastID = $('#msg span:last').attr('id');

        if (lastID > 0){
            $.ajax({
                url : 'localhost/testStage/hotel/function/load_mess.php?id=' + lastID,
                type : 'GET',
                dataType: "html",
                success : function(data){
                    $("#message_recept").append(data);
                },
                error : function (){

                }
            });
        }
    };


</script>



</body>
</html>
