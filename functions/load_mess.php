<?php session_start();
include '../pages/chat.php';
include '../pages/bdd.php';
include 'sql.php';

if (isset($_GET['id'])){
    $id = (int) $_GET['id'];

    $see_tchat = getLastMessage($dbh, $id);

    if (count($see_tchat) > 0){
        foreach ($see_tchat as $st){
            $date_message = date_create($st['date']);
            $date_message = date_format($date_message, 'd m Y H:i:s');
        }
    }
}