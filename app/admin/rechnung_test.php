<?php

/* >====O-------------------------------------------------O====>\
  |                    ##### t w p d f #####                     |
  |      Copyright (c) by progtw (Thomas Weise), 2005-2007       |
  |                     http://www.progtw.de                     |
  | Dieses Programm ist freie Software. Sie können es unter den  |
  | Bedingungen der GNU General Public License 3 (wie von der    |
  | Free Software Foundation herausgegeben) weitergeben und/oder |
  | modifizieren.                                                |
  | Eine Kopie der Lizenzbedingungen finden Sie in lizenz.txt.   |                                                 |
  \<====O-------------------------------------------------O====< */



/* ACHTUNG: darf kein einziges Leerzeichen vor phpstart sein, wegen header !!! */
session_start();
error_reporting(E_ALL);

// FPDF-Zeugs und die spezielle TwPdf-Klasse includen
define("FPDF_FONTPATH", "../fpdf/font/");
include_once('../fpdf/fpdf.php');
include_once("twpdfrechnung.php");


/*
echo '<pre>';
var_dump($user, $jobs);
echo '</pre>';
exit;*/


// die Rechnungspositionen
$arrPos = array();
$index_count = 0;
$rechnungsbetrag = 0;
foreach ($jobs as $job) {

    if ($job->getDesign() == 'Deluxe' || $job->getDesign() == 'Gewerbe') {
        $preis = 39;
    } else {
        $preis = 24;
    }

    if ($job->getAnzahl() > 0) {
        $arrPos[$index_count]['menge'] = $job->getAnzahl();
        $arrPos[$index_count]['text'] = "Grundrissgestaltung\n"
                /*. "Auftragsnummer: " . $job->getAuftragsnummer() . "\n"
                . "Auftragsbezeichnung: " . $job->getAuftragsname() . "\n"*/
                . "Auftrag: " . $job->getAuftragsnummer() ." - \"". $job->getAuftragsname(). "\" - ".$job->getDesign()."\n"
                . "Leistungsdatum: " . substr($job->getAbgeschlossen(), 0, 10) . "\n";
        $arrPos[$index_count]['einzelpreis'] = $preis;
        $arrPos[$index_count]['gesamtpreis'] = $arrPos[$index_count]['menge'] * $arrPos[$index_count]['einzelpreis'];
        $rechnungsbetrag += $arrPos[$index_count]['gesamtpreis'];
        $index_count++;
    }
    if ($job->getAenderungen() > 0) {
        $arrPos[$index_count]['menge'] = $job->getAenderungen();
        $arrPos[$index_count]['text'] = utf8_decode("Änderung\n"
                . "Auftrag: " . $job->getAuftragsnummer() ." - \"". $job->getAuftragsname(). "\"\n"
                . "Leistungsdatum: " . substr($job->getAbgeschlossen(), 0, 10) . "\n");
        $arrPos[$index_count]['einzelpreis'] = 10.00;
        $arrPos[$index_count]['gesamtpreis'] = $arrPos[$index_count]['menge'] * $arrPos[$index_count]['einzelpreis'];
        $rechnungsbetrag += $arrPos[$index_count]['gesamtpreis'];
        $index_count++;
    }
}



// Kunden- und Firmendaten, Zahlungsbedingungen
$arrDat = array();
$arrDat['rechnungsnummer'] = $rechnungsnummer;
$arrDat['kundennummer'] = $user->getKundennr();
$arrDat['rechnungsdatum'] = date('d').'.'.date('m').'.'.date('Y');

$arrDat['kundeAnschriftZeile01'] = utf8_decode($user->getFirma());
$arrDat['kundeAnschriftZeile02'] = utf8_decode($user->getBenutzer());
$arrDat['kundeAnschriftZeile03'] = utf8_decode($user->getStrasse());
$arrDat['kundeAnschriftZeile04'] = $user->getPlz() . ' '. utf8_decode($user->getOrt());
$arrDat['kundeAnschriftZeile05'] = "";

$arrDat['firmaNameZeile01'] = "Ihr Firmenname111";
$arrDat['firmaNameZeile02'] = "Ihr Firmenname 22";
$arrDat['firmaNameZeile03'] = "Ihr Firmenname 333";
$arrDat['firmaNameZeile04'] = "";
$arrDat['firmaNameZeile05'] = "";
$arrDat['firmaAnschriftZeile01'] = "";
$arrDat['firmaAnschriftZeile02'] = "Allersberger Str. 185/O";
$arrDat['firmaAnschriftZeile03'] = "90461 ".utf8_decode("Nürnberg");
$arrDat['firmaAnschriftZeile04'] = '';
$arrDat['firmaAnschriftZeile05'] = "";
$arrDat['firmaAnschrift'] = utf8_decode("Grundriss24.de, Allersberger Str. 185/O, 90461 Nürnberg");
$arrDat['firmaTelefon'] = "01805 / 33 32 35";
$arrDat['firmaFax'] = "01805 / 33 32 31";
$arrDat['firmaEmail'] = "support@grundriss24.de";
$arrDat['firmaWeb'] = "www.grundriss24.de";
$arrDat['firmaBankName'] = utf8_decode("Sparkasse Mittelfranken Süd");
$arrDat['firmaBankKtonr'] = "DE48 7645 0000 0221 2583 20";
$arrDat['firmaBankBlz'] = "BYLADEM1SRS";
$arrDat['firmaUstidnr'] = "Steuernr. 169/55007";
$arrDat['zahlungsbedingungen'] = "Zahlbar innerhalb 2 Tagen ohne Abzug";

$arrDat['impressum'] = "Grundriss24.de ist ein Geschäftsbereich der\n"
        . "multiphone communication center GmbH & Co.KG\n"
        . "Amtsgericht Nürnberg, HR-A 13949\n"
        . "Steuernr.: 169/55007\n"
        . "Finanzamt Nürnberg Süd\n";

$arrDat['impressum_zusatz'] =
         "Komplementärgesellschaft:\n"
        . "multiphone Verwaltungs-GmbH\n"
        . "Amtsgericht Nürnberg HR-B 20156\n"
        . "Geschäftsführer:\n"
        . "Dipl.Betriebswirt (FH) Jürgen Nagel";


// Berechnungen (mit exclusive MwSt.)
$brutto = $steuer = $netto = 0.0;
foreach ($arrPos as $pos) {
    $netto += $pos['gesamtpreis'];
}
$steuer = $netto * 0.19;
$brutto = $netto * 1.19;

$arrDat['rechnungsbetragNetto'] = $netto;
$arrDat['rechnungsbetragSteuer'] = $steuer;
$arrDat['rechnungsbetragBrutto'] = $brutto;



// alles in die Session rein
$_SESSION['twArrRechnungsdaten'] = $arrDat;
$_SESSION['twArrRechnungspositionen'] = $arrPos;



// pdf erzeugen
$twpdf = new TwPdfRechnung();

// pdf ausgeben (im Browser oder in Datei schreiben)
$twpdf->Output();   // Ausgabe (wenn in Datei schreiben, dateiname in Klammer)
// ACHTUNG: in der aufgerufenen Klasse darf kein Leerzeichen hinter phpende sein!!!
?>