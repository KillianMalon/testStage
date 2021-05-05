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
} 

function generatePdf($dbh, $id,$lname ,$fname, $arrival,$departure, $roomId, $nbOfDay, $total){
    require_once "../fpdf/fpdf.php";
    $roomPrice = getPriceRoom($dbh, $roomId);
    $reservationDateStart = new DateTime("$arrival");
    if (setlocale(LC_TIME, 'fr_FR') == '') {
        setlocale(LC_TIME, 'FRA');  //correction problème pour windows
        $format_jour = '%#d';
    } else {
        $format_jour = '%e';
    }
     $formattedArrival = mbUcfirst(strftime("%A $format_jour %B %Y", strtotime($arrival)));
     $formattedDeparture = mbUcfirst(strftime("%A $format_jour %B %Y", strtotime($departure)));

// Création de la class PDF


    // Activation de la classe
    $pdf = new FPDF('P', 'mm', 'A4');
    //ajout d'une page (que l'on pourra refaire au besoin)
    $pdf->AddPage();
    $pdf->SetFont('Helvetica', '', 11);
    $pdf->SetTextColor(0);

// Infos de la commande calées à gauche
    $num = utf8_decode("N°");
//sur une ligne 8mm du bord gauche et a 43mm du haut de la page
    $pdf->SetFont('Helvetica', 'B', 11);
    $pdf->Text(140, 18, "Entreprise : ");
    $pdf->SetFont('Helvetica', '', 11);
    $pdf->Text(140, 23, "Hotel Nom");
    $pdf->Text(140, 28, "22 rue je connais pas l'adresse");
    $pdf->Text(140, 33, "34 900 Montpellier, France");
    $pdf->Text(140, 38, utf8_decode("Téléphone : +33 48 99 99 99"));
    $pdf->Text(8, 48, "$num de facture : " . $id);
    $pdf->Text(8, 53, utf8_decode("Nom ") . ": ". utf8_decode($lname));
    $pdf->Text(8,58, utf8_decode("Prénom : ".$fname));
    $pdf->Text(8, 63, utf8_decode("Date de d'arrivée") . ": " . $formattedArrival);
    $pdf->Text(8, 68, utf8_decode("Date de départ") . " : " . $formattedDeparture);

// Position de l'entête à 10mm des infos (48 + 10)
    $position_entete = 73;
    if(function_exists('entete_table')){}else {
        function entete_table($position_entete, $pdf)
        {
            $pdf->SetDrawColor(183); // Couleur du fond
            $pdf->SetFillColor(221); // Couleur des filets
            $pdf->SetTextColor(0); // Couleur du texte
            $pdf->SetY($position_entete);
            //on se positionne à 8 mm du bord
            $pdf->SetX(8);
            //écrite dans une cellule de 40mm du bord
            $pdf->Cell(40, 8, 'Chambre', 1, 0, 'L', 1);
            $pdf->SetX(48); //40 + 8 et le "L" correspond à left
            $pdf->Cell(40, 8, 'Nombre de jours', 1, 0, 'L', 1);
            $pdf->SetX(88);
            $pdf->Cell(40, 8, 'Date de paiment', 1, 0, 'L', 1);
            $pdf->SetX(128);
            $pdf->Cell(40, 8, 'Prix unitaire', 1, 0, 'L', 1);
            $pdf->SetX(168);
            //le "C" correspond à center
            $pdf->Cell(40, 8, 'Prix Total', 1, 0, 'C', 1);

            $pdf->Ln(); // Retour à la ligne
        }
    }
    entete_table($position_entete, $pdf);

// Liste des détails
    $position_detail = 81; // Position à 8mm de l'entête
        $pdf->SetY($position_detail);
        $pdf->SetX(8);
        //Multicelle permet de faire une cellune qui s'aggrandit automatiquement vers le bas et qui permet donc le saut à la ligne quand la ligne est pleine
        $pdf->MultiCell(40, 8, utf8_decode("Chambre n°".$roomId), 1, 'L');
        $pdf->SetY($position_detail);
        $pdf->SetX(48);
        $pdf->MultiCell(40, 8, utf8_decode($nbOfDay), 1, 'L');
        $pdf->SetY($position_detail);
        $pdf->SetX(88);
        $pdf->MultiCell(40, 8, utf8_decode($arrival), 1, 'L');
        $pdf->SetY($position_detail);
        $pdf->SetX(128);
        $pdf->MultiCell(40, 8, utf8_decode($roomPrice['prix']."euros"), 1, 'L');
        $pdf->SetY($position_detail);
        $pdf->SetX(168);
        $pdf->MultiCell(40, 8, utf8_decode($total."euros"), 1, 'C');
        $position_detail += 8;


// Nom du fichier
    $nom = 'Facture-' . $id . '.pdf';
    $folderName = "Facture";
    if(is_dir($folderName)){
        ob_end_clean();
        //création et téléchargement du pdf
        $pdf->Output("Facture//$nom", "I");
    }else{
        mkdir($folderName);
        ob_end_clean();
        //création et téléchargement du pdf
        $pdf->Output("Facture//$nom", "I");
        ob_end_clean();
    }


        //Création et ouverture du pdf
        //$pdf->Output($nom, 'I');

}

function sendMailChamber($dbh){
    $allmails = getMailsNewsletter($dbh);
    $contenu = "Une nouvelle chambre est disponible dans notre Hotel : elle n'attend que vous !";
    $headers  = 'From: envoiedemailtest@gmail.com'. "\r\n" .
        'MIME-Version: 1.0' . "\r\n" .
        'Content-type: text/html; charset=utf-8';
    foreach ($allmails as $allmail){
        $mail = $allmail['mail'];
        mail($mail, "Newsletter Hotel", $contenu, $headers);
    }
}