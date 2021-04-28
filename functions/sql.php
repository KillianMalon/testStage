<?php

//Fonction pour obtenir les informations de tous les pays
function getCountry($dbh){
    $query = $dbh->prepare( 'SELECT * FROM pays' );
    $query->execute();
    return $query->fetchAll();
}

//Fonction pour obtenir les informations d'une chambre et son prix avec l'id de la chambre
function getRoom($dbh, $numeroChambre){
    $query = $dbh->prepare( 'SELECT chambres.*,tarifs.prix FROM chambres,tarifs WHERE chambres.tarif_id = tarifs.id AND chambres.id = ?');
    $query->execute(array($numeroChambre)); // execute le SQL dans la base de données (MySQL / MariaDB)
    return $query->fetchAll( PDO::FETCH_ASSOC );
}

//Fonction pour obtenir la capacité d'une chambre avec son id
function getCapacity($dbh, $numeroChambre){
    $query = $dbh->prepare( 'SELECT capacite FROM chambres WHERE chambres.id = ?');
    $query->execute(array($numeroChambre));
    return $query->fetchAll( PDO::FETCH_ASSOC);
}

//Fonction pour vérifier que la date de réservation est libre
function checkReservationsEmpty($dbh, $date, $id){
    $query = $dbh->prepare( "SELECT * FROM planning WHERE chambre_id = ? AND jour = ?" );
    $query->execute(array($id, $date)); // execute le SQL dans la base de données (MySQL / MariaDB)
    return $query->fetchAll( PDO::FETCH_ASSOC );
}

//Fonction pour réserver une chambre
function addReservation($dbh, $chambreId, $dateStart, $id, $idReservation){
    $query = $dbh->prepare( "INSERT INTO planning (chambre_id, jour, acompte, paye, client_id, idReservation) VALUES(?, ?, '0', '0', ?, ?)" );
    $query->execute(array($chambreId,$dateStart, $id, $idReservation));
    return $query->fetchAll();
}

//Fonction pour obtenir les informations d'un client avec son id
function getClient($dbh, $id){
    $query = $dbh->prepare( "SELECT * FROM clients WHERE id = ?" );
    $query->execute( array($id) );
    $client = $query->fetch();
    return $client;
}

//Fonction pour obtenir les informations d'un pays avec son id
function getCountrybyid($dbh, $cid){
    $query = $dbh->prepare( "SELECT * FROM pays WHERE id = ?" );
    $query->execute( array($cid) );
    $cname = $query->fetch();
    return $cname;
}
//Fonction pour mettre le premier caractère en majuscule et tous les autres en minuscule
function mbUcfirst($str, $encode = 'UTF-8'){
    $start = mb_strtoupper( mb_substr( $str, 0, 1, $encode ), $encode );
    $end = mb_strtolower( mb_substr( $str, 1, mb_strlen( $str, $encode ), $encode ), $encode );
    return $str = $start . $end;
}

//Fonction pour vérifier le mail d'un utilisateur
function mailCheck($dbh, $mail){
    $request = $dbh->prepare( 'SELECT * FROM clients WHERE mail = ?' );
    $request->execute( array($mail) );
    return $emailCount = $request->rowCount();
}

//Fonction pour effectuer une inscription
function inscription($dbh, $firstName, $lastName, $mail, $password, $address, $postalCode, $city, $country, $civility, $image,$key){
    $sql = $dbh->prepare( "INSERT INTO clients (civilite, nom, prenom, adresse, codePostal, ville, pays_id, mail, password, image, cle, statut ) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
    $sql->execute( array($civility, $lastName , $firstName, $address, $postalCode, $city, $country, $mail, $password, $image, $key, 0));
}

//Fonction pour obtenir les informations d'un utilisateur en fonction de son mail
function getUserByMail($dbh, $mail)
{
    $query = $dbh->prepare( 'SELECT * FROM clients WHERE mail = ?' );
    $query->execute( array($mail) );
    return $user = $query->fetch();
}

//Fonction pour rechercher dans la base de données si l'adresse mail n'existe pas déjà
function getUserByMailForVerif($dbh, $mail){
    $query = $dbh->prepare('SELECT * FROM clients WHERE mail = ?');
    $query->execute(array($mail));
    return $user = $query->rowCount();
}

//Fonction pour obtenir les informations d'un utilisateur en fonction de son mail et de son mot de passe
function getUserByMailAndPassword($dbh, $mail, $password)
{
    $query = $dbh->prepare( 'SELECT * FROM clients WHERE mail = ? and password = ?' );
    $query->execute( array($mail, $password) );
    return $query;
}

//Fonction pour obtenir les réservations d'un utilisateur en fonction de son id
function getReservations($dbh, $uid)
{
    $query = $dbh->prepare( 'SELECT * FROM planning WHERE client_id = ?' );
    $query->execute( array($uid) );
    $rlist = $query->fetchAll();
    return $rlist;
}

//Fonction pour obtenir le nombre de réservations d'un utilisateur en fonction de son id
function countReservations($dbh, $uid)
{
    $query = $dbh->prepare( 'SELECT COUNT(*) FROM planning WHERE client_id = ?' );
    $query->execute( array($uid) );
    return $count = $query->fetch();
}

//Fonction pour obtenir la grille des clients
function getAllClients($dbh)
{
    $query = $dbh->prepare( 'SELECT * FROM clients' );
    $query->execute();
    return $allclients = $query->fetchAll();
}

//Fonction pour obtenir la grille des chambres
function getAllRoom($dbh){
    $query = $dbh->prepare( 'SELECT chambres.*,tarifs.prix FROM chambres,tarifs WHERE chambres.tarif_id = tarifs.id ORDER BY id ASC ');
    $query->execute();
    return $query ->fetchAll( PDO::FETCH_ASSOC );
}

//Fonction pour obtenir la valeur d'un prix en fonction de son id
function getPricebyid($dbh, $tid)
{
    $query = $dbh->prepare( 'SELECT prix FROM tarifs WHERE id = ?' );
    $query->execute( array($tid) );
    return $tarif = $query->fetch();
}

//Fonction pour obtenir toute la grille de prix
function getPrices($dbh)
{
    $query = $dbh->prepare( 'SELECT * FROM tarifs' );
    $query->execute();
    return $tarifs = $query->fetchAll();
}

//Modification du compte utilisateur
function updateFirstName($dbh, $firstName, $id){
    $insertFname = $dbh->prepare('UPDATE clients SET prenom = ? WHERE id = ?');
    $insertFname ->execute(array($firstName, $id));
}
function updateLastName($dbh, $lastName, $id){
    $insertLname = $dbh->prepare('UPDATE clients SET nom = ? WHERE id = ?');
    $insertLname ->execute(array($lastName, $id));
}
function updatePassword($dbh, $password, $id){
    $insertPassword = $dbh->prepare('UPDATE clients SET password = ? WHERE id = ?');
    $insertPassword ->execute(array($password, $id));
}
function updateMail($dbh, $mailModif, $id){
    $insertMail = $dbh->prepare('UPDATE clients SET mail = ? WHERE id = ?');
    $insertMail ->execute(array($mailModif, $id));
}
function updateAddress($dbh,$addressModif, $id){
    $insertAddress = $dbh->prepare('UPDATE clients SET adresse = ? WHERE id = ?');
    $insertAddress ->execute(array($addressModif, $id));
}
function updatePostalCode($dbh, $pcModif, $id){
    $insertPC = $dbh->prepare('UPDATE clients SET codePostal = ? WHERE id = ?');
    $insertPC ->execute(array($pcModif, $id));
}
function updateCity($dbh, $city, $id){
    $insertTown = $dbh->prepare('UPDATE clients SET ville = ? WHERE id = ?');
    $insertTown ->execute(array($city, $id));
}
function updateCountry($dbh, $countryModif, $id){
    $insertCountry = $dbh->prepare('UPDATE clients SET pays_id = ? WHERE id = ?');
    $insertCountry ->execute(array($countryModif, $id));
}
function updateCivility($dbh, $civilityModif, $id){
    $insertCountry = $dbh->prepare('UPDATE clients SET civilite = ? WHERE id = ?');
    $insertCountry ->execute(array($civilityModif, $id));
}
function updateUserPP($dbh, $image, $id){
    $insertPP = $dbh->prepare('UPDATE clients SET image = ? WHERE id = ?');
    $insertPP ->execute(array($image, $id));
}
function getLastUsers($dbh){
    $query = $dbh->prepare('SELECT * FROM clients ORDER BY id DESC LIMIT 10');
    $query -> execute();
    return $clients = $query->fetchAll();
}
function getLastRooms($dbh){
    $query = $dbh -> prepare('SELECT * FROM chambres ORDER BY id DESC LIMIT 10');
    $query -> execute();
    return $rooms = $query->fetchAll();
}
function updateStatus($dbh, $key){
    $updateStatus = $dbh->prepare('UPDATE clients SET statut = ? WHERE cle = ?');
    $updateStatus ->execute(array(1, $key));
}
function updateRank($dbh, $rank, $id){
    $upateClientRank = $dbh->prepare('UPDATE clients SET type = ? WHERE id = ?');
    $upateClientRank -> execute(array($rank, $id));
}
//Fonction de recherche multi-tag
function Search($dbh, $total, $exposition, $idprix){
    $type = "SELECT id FROM chambres WHERE capacite >= ?";
    if ($idprix == 0) {
        if ($exposition == 0) {
            $query = $dbh->prepare( "$type" );
            $query->execute( array($total) );
            return $final = $query->fetchAll();
        } else {
            $query = $dbh->prepare( "$type" . " AND c.exposition = ?" );
            $query->execute( array($total, $exposition) );
            return $final = $query->fetchAll();
        }
    } else {
        if ($exposition == 0) {
            $query = $dbh->prepare( "$type" . " AND c.tarif_id = ?" );
            $query->execute( array($total, $idprix) );
            return $final = $query->fetchAll();
        } else {
            $query = $dbh->prepare( "$type" . " AND c.exposition = ? AND c.tarif_id = ?" );
            $query->execute( array($total, $exposition, $idprix) );
            return $final = $query->fetchAll();
        }
    }
}
//Fonction de recherche multi-tag avec seulement une date de début (1 jour)
function Free($dbh, $day){
    $query = $dbh->prepare('SELECT c.id FROM chambres c LEFT JOIN planning p ON c.id = p.chambre_id WHERE p.jour = ?');
    $query->execute(array($day));
    return $notfree = $query->fetchAll();
}

//Fonction de recherche multi-tag avec seulement une date de début et une date de fin (+1 jour)
function FreeTwo($dbh, $day, $dday){
    $query = $dbh->prepare( 'SELECT DISTINCT c.id FROM chambres c LEFT JOIN planning p ON c.id = p.chambre_id WHERE p.jour BETWEEN CONVERT(?, DATETIME) AND CONVERT(?, DATETIME)' );
    $query->execute( array($day, $dday) );
    return $notfree = $query->fetchAll();
}
function getClientByKey($dbh, $key){
    $query = $dbh->prepare('SELECT * FROM clients WHERE cle = ?');
    $query->execute(array($key));
    return $response = $query->rowCount();
}

function getClientInformationsByKey($dbh, $key){
    $query = $dbh->prepare('SELECT * FROM clients WHERE cle = ?');
    $query->execute(array($key));
    return $response = $query->fetch();
}

function AddOneView($dbh, $id){
    $query = $dbh->prepare('UPDATE chambres SET vues = vues+1 WHERE id = ?');
    $query->execute(array($id));
}

function getAllViews($dbh){
    $query = $dbh->prepare('SELECT vues FROM chambres');
    $query->execute();
    return $all = $query->fetchAll();
}
function ListEtage($dbh){
    $query = $dbh->prepare('SELECT DISTINCT etage FROM chambres');
    $query->execute();
    return $etages = $query->fetchAll();
}
function getLastReservationId($dbh){
    $query = $dbh->prepare('SELECT * FROM planning ORDER BY idReservation DESC LIMIT 1');
    $query->execute();
    return $last = $query->fetch();
}


function reservationByUserId($dbh, $id){
    $query = $dbh->prepare("SELECT DISTINCT idReservation FROM planning WHERE client_id = ?");
    $query->execute(array($id));
    return $last = $query->fetchAll();
}

function ReservationByReservationId($dbh, $idReservation){
    $query = $dbh->prepare("SELECT * FROM planning WHERE idReservation = ?");
    $query->execute(array($idReservation));
    return $last = $query->fetchAll();
}

function gePriceRoom($dbh, $idChambre){
    $query = $dbh->prepare("SELECT tarifs.prix FROM chambres,tarifs WHERE chambres.tarif_id = tarifs.id AND chambres.id = ? ");
    $query->execute(array($idChambre));
    return $price = $query->fetch();
}

function AddOneGlobalView($dbh, $month){
    $query = $dbh->prepare('UPDATE vues SET vuesTotale = vuesTotale+1 WHERE mois = ?');
    $query->execute(array($month));
}
function getAllMonth($dbh){
    $query = $dbh->prepare('SELECT * FROM vues');
    $query -> execute();
    return $informations = $query->fetchAll();
}
function insertOneMonth($dbh,$trueDate){
    $insert = $dbh->prepare('INSERT INTO vues (mois, vuesTotale) VALUES (?,1) ');
    $insert->execute(array($trueDate));
}

function updateRoom($dbh, $id, $cap, $exposition, $douche, $etage, $tarif_id, $description, $image){
    $query = $dbh->prepare('UPDATE chambres SET id = ?, capacite = ?, exposition = ?, douche = ?, etage = ?, tarif_id = ?, description = ?, image = ? WHERE id = ?');
    $query->execute(array($id, $cap, $exposition, $douche, $etage, $tarif_id, $description, $image, $id));
}

function countCountry($dbh){
    $query = $dbh->prepare('SELECT COUNT(*) FROM pays');
    $query->execute();
    return $end = $query->fetch();
}

function testpage($dbh, $premier, $parpage){
    $query = $dbh->prepare('SELECT * FROM pays ORDER BY id DESC LIMIT ?, ?');
    $query->execute(array($premier, $parpage));
    return $toto = $query->fetchAll();
}
function get_list_page($page, $nb_page, $nb = 2)
{
    $list_page = array();
    for ($i=1;$i <= $nb_page;$i++)
    {
        if (($i < $nb) OR ($i > $nb_page - 1) OR (($i < $page + $nb) AND ($i > $page -$nb)))
            $list_page[] = $i;
        else
        {
            if ($i >= $nb AND $i <= $page - $nb)
                $i = $page - $nb;
            elseif ($i >= $page + $nb AND $i <= $nb_page - $nb)
                $i = $nb_page - $nb;
            $list_page[] = '...';
        }
    }
    return $list_page;
}
