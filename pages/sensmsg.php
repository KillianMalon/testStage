<?php
require_once '../component/header.php';
require_once '../functions/sql.php';
require_once 'bdd.php';


if(isset($_POST['submit'])){ // si on a envoyé des données avec le formulaire

    if(!empty($_POST['pseudo']) AND !empty($_POST['message'])){ // si les variables ne sont pas vides

        $pseudo = ($_POST['pseudo']);
        $message = ($_POST['message']); // on sécurise nos données

// puis on entre les données en base de données :
        $insertion = $dbh->prepare('INSERT INTO messages VALUES("", :pseudo, :message)');
        $insertion->execute(array(
            'pseudo' => $pseudo,
            'message' => $message
        ));

    }
    else{
        echo "Vous avez oublié de remplir un des champs !";
    }

}

?>

