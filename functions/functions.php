<?php
//Fonction de vérification de format de date
function checkDateFormat($date){
    // match the format of the date
    if (preg_match ("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", "$date"))
    {
        return true;
    } else {
        return false;
    }
}

//Fonction de vérification de sélection des enfants (entre 0 et 10 enfants)
function checkCapacityChild($capacityEnter){
    // match the format of the date
    if (preg_match ("/^([0-9]{0,10})$/", "$capacityEnter"))
    {
        return true;
    } else {
        return false;
    }
}

//Fonction qui génère une chaine de caractère (clé) aléatoire
function generateRandomString($longueur = 35, $CharList = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
    $chaine = '';
    $max = mb_strlen($CharList, '8bit') - 1;
    for ($i = 0; $i < $longueur; ++$i) {
        $chaine .= $CharList[random_int(0, $max)];
    }
    return $chaine;