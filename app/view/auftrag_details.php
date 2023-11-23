<?php
require_once '../cfg/config_lightboxes.php';
require_once '../cfg/pdo_config.php';
$id = $_GET['id'];
$auftrag = $auftragVerwaltung->findeAnhandVonId($id);
$gehoertzuId = $auftrag->getGehoertZu();
$kunde = $userVerwaltung->findeAnhandVonId($gehoertzuId);
$auftragNr = $auftrag->getAuftragsnummer();
$dateien = $dateiVerwaltung->findeAnhandVonGehoertZuUndAktiv($auftragNr, 1);
$fertigeDateien = $dateiVerwaltung->findeAnhandVonGehoertZuUndErgebnisdatei($auftragNr);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>grundriss24.de - farbige Grundrisse, m&ouml;blierte Grundrisse, optimierte Grundrisse, gestaltete Grundrisse, attraktive Grundrisse<</title>
        <meta name="description" content="Der Service für Immobilienmakler: Wir verwandeln Ihre Vorlagen in verkaufsfördernde und attraktive Grundrisse." />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="../css/details.css" media="screen, print" />
    </head>
    <body>
    <h2>Auftragdetails</h2>
<table border="0" id="details_tbl">
    <tr>
        <td class="col_1_details">Auftragsnummer:</td>
        <td class="col_2_details"> <?php echo $auftrag->getAuftragsnummer() ?></td>
    </tr>
    <tr>
        <td>Auftragsname:</td>
        <td><?php echo $auftrag->getAuftragsname() ?></td>
    </tr>
    <tr>
        <td>Kunde:</td>
        <td><?php echo $kunde->getFirma() ?></td>
    </tr>
    <tr>
        <td>Ansprechpartner:</td>
        <td><?php echo $auftrag->getAnsprechpartner()?></td>
    </tr>
    <tr>
        <td>Status:</td>
        <td><?php
        switch($auftrag->getStatus()) {
                case '4':
                    $status = 'Abgeschlossen';
                    break;
                case '1':
                    $status = 'in Bearbeitung';
                    break;
                case '9':
                    $status = 'Angebot wird erstellt';
                    break;
            }
        echo $status ?></td>
    </tr>
    <tr>
        <td>Design:</td>
        <td><?php echo $auftrag->getDesign() ?></td>
    </tr>
    <tr>
        <td>Web-Grafiken:</td>
        <td><?php
         switch($auftrag->getWeb()) {
                case '1':
                    $web = 'Ja';
                    break;
                case '0':
                    $web = 'Nein';
                    break;
            }
            echo $web ?></td>
    </tr>
    <tr>
        <td>Übermittelt am:</td>
        <td> <?php echo $auftrag->getDatum() ?></td>
    </tr>
    <tr>
        <td>Abgeschlossen am: </td>
        <td><?php echo $auftrag->getAbgeschlossen() ?></td>
    </tr>
    <tr>
        <td>Übermittlungsart:</td>
        <td><?php echo $auftrag->getVersand() ?></td>
    </tr>
    <tr>
        <td>Übermittelte Dateien:</td>
        <td>
            <?php foreach($dateien as $datei) { ?>

                <?php echo $datei->getDateiname(). ' ('.$datei->getDateigroesse().')' ?><br />
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td>Bemerkung:</td>
        <td><?php echo $auftrag->getBemerkung() ?></td>
    </tr>
</table>
    <div>
        <?php foreach ($fertigeDateien as $fertigeDatei) { ?>
        <img class="thumbnail" width="150px" src="<?php $root_path_files?><?php echo $fertigeDatei->getDateiname() ?>" />
        <?php } ?>
    </div>
    </body>
</html>