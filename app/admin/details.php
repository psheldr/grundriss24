<?php
require_once 'cfg/config.php';
require_once '../cfg/pdo_config.php';

$auftragId = $_GET['a'];
$auftrag = $auftragVerwaltung->findeAnhandVonId($auftragId);
$gehoertzuId = $auftrag->getGehoertZu();
$kunde = $userVerwaltung->findeAnhandVonId($gehoertzuId);

$auftragNr = $auftrag->getAuftragsnummer();
$dateien = $dateiVerwaltung->findeAnhandVonGehoertZuUndErgebnisdatei($auftragNr);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Auftragdetails</title>
        <meta name="description" content="" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="language" content="de" />
        <meta name="robots" content="index,follow" />
        <meta name="audience" content="alle" />
        <meta name="page-topic" content="Dienstleistungen" />
        <meta name="revisit-after" content="5 days" />
        <link rel="stylesheet" type="text/css" href="css/details.css" media="screen, print" />
        <script language="JavaScript" type="text/JavaScript">
            function displayWindow(url, width, height)
            {
                var Win = window.open(url,"MeinFenster",'top=80,left=80,width=' + width + ',height=' + height + ',resizable=0,scrollbars=yes,menubar=no,status=no');
            }
            function closeWindow()
            {
                opener.location.href = 'index.php';
                self.close();
            }
        </script>
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
                <td>Erteilt am:</td>
                <td><?php echo $auftrag->getDatum() ?></td>
            </tr>
            <tr>
                <td>Kunde:</td>
                <td><?php echo $kunde->getFirma() ?></td>
            </tr>
            <tr>
                <td>Ansprechpartner:</td>
                <td><?php
                if($auftrag->getAnsprechpartner() == '') {
                    echo $kunde->getBenutzer();
                } else {
                    echo $auftrag->getAnsprechpartner();
                }

                ?></td>
            </tr>

            <tr>
                <td>Adresse:</td>
                <td><?php echo $kunde->getStrasse() . '<br /> ' . $kunde->getPlz() . ' ' . $kunde->getOrt() ?></td>
            </tr>
            <tr>
                <td>Tel./Fax/Mobil:</td>
                <td>
                    <?php if($kunde->getTel() != '') { echo 'Tel: ' . $kunde->getTel(); } ?>
                    <?php if( $kunde->getFax() != '') { echo '<br />Fax: ' . $kunde->getFax(); } ?>
                    <?php if( $kunde->getMobil() != '') { echo '<br />Mobil: ' . $kunde->getMobil(); } ?>
                </td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><?php echo $kunde->getLogin() ?></td>
            </tr>
            <tr>
                <td>Status:</td>
                <td><?php
                    switch ($auftrag->getStatus()) {
                        case '1':
                            $status = 'In Bearbeitung';
                            break;
                        case '4':
                            $status = 'Abgeschlossen';
                            break;
                        case '9':
                            $status = 'Angebotsanfrage';
                            break;
                    }
                    echo $status;
                    ?></td>
            </tr>
            <tr>
                <td>Design:</td>
                <td><?php echo $auftrag->getDesign();
                ?></td>
            </tr>
             <tr>
                <td>Holzboden:</td>
                <td><?php echo $auftrag->getHolzboden();
                ?></td>
            </tr>
            <tr>
                <td>Sonstiges:</td>
                <td>
                   <?php if ($auftrag->getInfo() == 1) { ?>
        Mit Objektinformationen<br />
    <?php }
    if ($auftrag->getBezeichnungen() == 1) { ?>
        Mit Raumbezeichnungen<br />
    <?php }
    if ($auftrag->getQm() == 1) { ?>
        Mit Quadratmeterangaben
    <?php } ?>
                </td>
            </tr>
            <tr>
                <td>Web-Grafiken:</td>
                <td>
                    <?php
                    switch($auftrag->getWeb()) {
                        case '1':
                            $web = 'Ja';
                            break;
                        case '0':
                            $web = 'Nein';
                            break;
                    }
                    echo $web;
                    ?>
                </td>
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
    </body>
</html>