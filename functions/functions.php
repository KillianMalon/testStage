<?php

function checkDateFormat($date){
    // match the format of the date
    if (preg_match ("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", "$date"))
    {
        return true;
    } else {
        return false;
    }
}

function checkCapacityChild($capacityEnter){
    // match the format of the date
    if (preg_match ("/^([0-9]{0,10})$/", "$capacityEnter"))
    {
        return true;
    } else {
        return false;
    }
}
function generateRandomString($longueur = 35, $CharList = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
    $chaine = '';
    $max = mb_strlen($CharList, '8bit') - 1;
    for ($i = 0; $i < $longueur; ++$i) {
        $chaine .= $CharList[random_int(0, $max)];
    }
    return $chaine;
}