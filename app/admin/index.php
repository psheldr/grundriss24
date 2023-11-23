<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

session_start();
require_once 'cfg/config.php';
require_once '../cfg/pdo_config.php';
$action = $_REQUEST['action'] ? $_REQUEST['action'] : 'zeige_liste';

$user = $userVerwaltung->findeAnhandVonId($_SESSION['logged_in_admin']);
if ($user->getAktiv() != 3) {
    header("$url/Startseite");
}
$id = $_REQUEST['id'];
switch ($action) {
    case 'pdf_rechnung':
        $letzte_rechnungsnummer_arr = $rechnungVerwaltung->findeLetzteRechnungsnr();
        $letzte_re_nr = $letzte_rechnungsnummer_arr[0]->getRechnungsnr();

        $user_id = $_REQUEST['user_id'];
        $user = $userVerwaltung->findeAnhandVonId($user_id);
       // $jobs = $auftragVerwaltung->findeAlleOhneRechnungZuUser($user_id);
        $jobs = $auftragVerwaltung->findeAlleOhneRechnungZuUser2($user_id);
        
        var_dump($jobs);exit;
        foreach ($jobs as $job) {
            $rechnung_zu_job = $rechnungVerwaltung->findeAnhandVonGehoertzu($job->getId());
            if (!$rechnung_zu_job->getId()) {
                $rechnung_zu_job = new Rechnung();
                $rechnung_zu_job->setGehoertzu($job->getId());
                $rechnung_zu_job->setGestellt(0);
                $rechnungVerwaltung->speichere($rechnung_zu_job);
            }
            if (!$rechnung_zu_job->getRechnungsnr()) {
                $rechnungsnummer = $letzte_re_nr + 1;
                $rechnung_zu_job->setRechnungsnr($rechnungsnummer);
                $rechnungVerwaltung->speichere($rechnung_zu_job);
            } else {
                $rechnungsnummer = $rechnung_zu_job->getRechnungsnr();
                
            }
        }
        require_once 'rechnung_test.php';

        exit;
        $auftrag_id = $_REQUEST['job_id'];
        $user_id = $_REQUEST['user_id'];

        require('../fpdf/fpdf.php');
        $y = 30;
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->setY($y);
        $pdf->setX(150);
        $pdf->Image('../images/logo.gif');
        $pdf->SetFont('Arial', '', 12);
        $pdf->setY($y + 10);
        $pdf->setX(150);
        $pdf->Cell(40, 10, 'Allersberger Str. 185/O');
        $pdf->setY($y + 10);
        $pdf->Cell(40, 10, 'Hello World!');
        $pdf->Cell(40, 10, 'Hello World!');
        $pdf->Output();
        break;
    case 'speichere_kundennr':
        $user_id = $_REQUEST['uid'];
        $user = $userVerwaltung->findeAnhandVonId($user_id);
        $kundennr = $_REQUEST['kundennr'];
        $user->setKundennr($kundennr);
        $userVerwaltung->aendereUser($user);
        header('location:index.php?action=zeige_liste');
        break;
    case 'log_out':
        unset($_SESSION['logged_in_userid']);
        unset($_SESSION['logged_in_admin']);
        header("location:$url/Startseite");
        break;
    case 'zeige_liste':
        $auftraegeAktiv = $auftragVerwaltung->findeAlleAktiven();
        $angebotsAnfragen = $auftragVerwaltung->findeAlleAktivenAngebotsAnfragen();

        if (isset($_GET['what']) == 'offene') {
            $auftraegeErledigt = $auftragVerwaltung->findeAlleOffenen();
            $what = 'offene';
        } else {
            if (isset($_POST['search_job'])) {
                $suchBegriff = $_POST['search_job'];
                $auftraegeErledigt = $auftragVerwaltung->findeAnhandVonStichwortsuche($suchBegriff);
            } elseif (isset($_POST['search_by_user'])) {
                $suchBegriff = $_POST['search_by_user'];
                $userGefunden = $userVerwaltung->findeAnhandVonStichwortsuche($suchBegriff);
                if (count($userGefunden) == 1) {
                    $id = $userGefunden[0]->getId();
                    header("location:index.php?action=zeige_liste&user=$id");
                }
                //$auftraegeErledigt = $auftragVerwaltung->findeAnhandVonGehoertZu($gehoertzu);
            } elseif (isset($_GET['user'])) {
                $gehoertzu = $_GET['user'];
                $auftraegeErledigt = $auftragVerwaltung->findeAnhandVonGehoertZu($gehoertzu);
            } else {
                if (isset($_GET['limit'])) {
                    $limit = $_GET['limit'];
                    $auftraegeErledigt = $auftragVerwaltung->findeAlleErledigten($limit);
                } else {
                    $limit = 20;
                    $auftraegeErledigt = $auftragVerwaltung->findeAlleErledigten($limit);
                }
            }
        }


        break;
    case 'aktiviere_auftrag':
        $aktiviereAuftrag = $auftragVerwaltung->findeAnhandVonId($id);
        $auftragVerwaltung->aktiviereAuftrag($aktiviereAuftrag);
        header('location:index.php?action=zeige_liste');
        break;
    case 'loesche_auftrag':
        $zuloeschenderAuftrag = $auftragVerwaltung->findeAnhandVonId($id);
        $auftragVerwaltung->loesche($zuloeschenderAuftrag);
        header('location:index.php?action=zeige_liste');
        break;
    case 'finish_auftrag':
        $finishAuftrag = $auftragVerwaltung->findeAnhandVonId($id);
        $auftragVerwaltung->finishAuftrag($finishAuftrag);
        $kunde = $userVerwaltung->findeAnhandVonId($finishAuftrag->getGehoertZu());
        sendeAuftragAbgeschlossen($finishAuftrag, $kunde);
        header('location:index.php?action=zeige_liste');
        break;
    case 'erzeuge_auftrag':
        $erzeugeAuftrag = $auftragVerwaltung->findeAnhandVonId($id);
        $auftragVerwaltung->erzeugeAuftragAusAngebot($erzeugeAuftrag);
        header('location:index.php?action=zeige_liste');
        break;
    case 'speichere_bearbeiter':
        $auftrag = $auftragVerwaltung->findeAnhandVonId($id);
        $bearbeiter = $_REQUEST['bearbeiter'];
        $auftragVerwaltung->speichereBearbeiter($auftrag, $bearbeiter);
        $anzahl = $_REQUEST['anzahl'];
        $auftragVerwaltung->speichereAnzahl($auftrag, $anzahl);
        header('location:index.php?action=zeige_liste');
        break;
    case 'speichere_anzahl':
        $auftrag = $auftragVerwaltung->findeAnhandVonId($id);
        $anzahl = $_REQUEST['anzahl'];
        $auftragVerwaltung->speichereAnzahl($auftrag, $anzahl);
        header('location:index.php?action=zeige_liste');
        break;
    case 'speichere_aenderungen':
        $auftrag = $auftragVerwaltung->findeAnhandVonId($id);
        $aenderungen = $_REQUEST['aenderungen'];
        $auftragVerwaltung->speichereAenderungen($auftrag, $aenderungen);
        header('location:index.php?action=zeige_liste');
        break;
    case 'aendere_rechnung':
        $auftrag = $auftragVerwaltung->findeAnhandVonId($id);
        $rechnung = $_GET['rechnung_set'];
        $auftragVerwaltung->aendereRechnungsStatus($auftrag, $rechnung);
        header('location:index.php?action=zeige_liste');
        break;
    case 'waehle_kunde':

        break;
    case 'suche_kunden':
        $suchBegriff = $_REQUEST['search_user'];
        $kunden = $userVerwaltung->findeAnhandVonStichwortsuche($suchBegriff);
        $action = 'waehle_kunde';
        break;
    case 'auftrag_als_kunde':
        $kunde = $userVerwaltung->findeAnhandVonId($id);
        $_SESSION['logged_in_userid'] = $_GET['id'];
        header('location:../index.php?action=neuer_auftrag');
        break;
    case 'upload_datei':
        if (isset($_POST['btndatei2'])) {
            if ($_FILES['txt_datei2']['tmp_name']) {
                $dateiname = $_FILES['txt_datei2']['name'];
                move_uploaded_file($_FILES['txt_datei2']['tmp_name'], $root_path_files . $_FILES['txt_datei2']['name']);
                $dateigroesse = sprintf("%01.2f", $_FILES['txt_datei2']['size'] / 1024) . " kbytes";
                $auftragsnummer = $_GET['u'];
                include "opendb.php";
                $select = "select id from tbl_dateien order by id desc";
                $RS = mysqli_query($Conn, $select);
                if (mysqli_num_rows($RS) == 0) {
                    $id = 1;
                } else {
                    $row = mysqli_fetch_object($RS);
                    $id = $row->id + 1;
                }
                $zeitstempel = date("d.m.Y H:i:s");
                $select = "insert into tbl_dateien (id,gehoertzu,dateiname,dateiname2,dateigroesse,datum,aktiv) values ($id,$auftragsnummer,'$dateiname','$dateiname','$dateigroesse','$zeitstempel',1)";
                $RS = mysqli_query($Conn,$select);
                header('location:index.php?action=zeige_liste');
            } else {

                header('location:index.php?action=zeige_liste');
            }
        }

        if (isset($_POST['btndatei'])) {
            if ($_FILES['txt_datei']['tmp_name']) {
                $dateiname = $_FILES['txt_datei']['name'];
                move_uploaded_file($_FILES['txt_datei']['tmp_name'], $root_path_files . $_FILES['txt_datei']['name']);
                $dateigroesse = sprintf("%01.2f", $_FILES['txt_datei']['size'] / 1024) . " kbytes";
                $auftragsnummer = $_GET['u'];
                include "opendb.php";
                $select = "select id from tbl_dateien order by id desc";
                $RS = mysqli_query($Conn,$select);
                if (mysqli_num_rows($RS) == 0) {
                    $id = 1;
                } else {
                    $row = mysqli_fetch_object($RS);
                    $id = $row->id + 1;
                }
                $zeitstempel = date("d.m.Y H:i:s");

                $select = "insert into tbl_dateien (id,gehoertzu,dateiname,dateigroesse,datum,aktiv) values ($id,$auftragsnummer,'$dateiname','$dateigroesse','$zeitstempel',2)";
                $RS = mysqli_query($Conn,$select);
                header('location:index.php?action=zeige_liste');
            } else {
                header('location:index.php?action=zeige_liste');
            }
        }
        break;
    case 'loesche_datei_vorlage':
        $datei_id = $_GET['id'];
        $datei_to_del = $dateiVerwaltung->findeAnhandVonId($datei_id);
        unlink($root_path_files . $datei_to_del->getDateiname2());
        $dateiVerwaltung->loesche($datei_to_del);
        header('location:index.php?action=zeige_liste');
        break;
    case 'loesche_datei':
        $datei_id = $_GET['id'];
        $datei_to_del = $dateiVerwaltung->findeAnhandVonId($datei_id);
        unlink($root_path_files . $datei_to_del->getDateiname());
        $dateiVerwaltung->loesche($datei_to_del);
        header('location:index.php?action=zeige_liste');
        break;
    case 'setze_rechnung':
        $daten['id'] = $_GET['id'];
        $daten['gehoertzu'] = $_GET['aid'];
        $daten['gehoertzu'] = $_GET['aid'];
        $daten['gestellt'] = $_GET['set'];
        $anker = $daten['gehoertzu'];
        $rechnung = new Rechnung($daten);
        $rechnungVerwaltung->speichere($rechnung);
		$auftrag = $auftragVerwaltung->findeAnhandVonId($_GET['aid']);
		//$auftrag->setRechnung($_GET['set']);
		$auftragVerwaltung->speichere($auftrag);
        header("location:index.php?action=zeige_liste#$anker");
        break;
}
require 'view/layout.tpl.php';
?>