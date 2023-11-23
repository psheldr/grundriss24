<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<div id="content_box_top">
    <div id="auftraege_top">
        <h2 class="fett_orange_italic">Auftragsübersicht</h2>
        <p class="copy_12">
            <?php echo $user->getFirma() ?><br />
            <?php echo $user->getBenutzer() ?><br />
            <?php echo $user->getStrasse() ?><br />
            <?php echo $user->getPlz() ?>&nbsp;<?php echo $user->getOrt() ?>
        </p>
        <p class="copy_12">
            <?php echo $user->getTel() ?><br />
            <?php echo $user->getFax() ?>
        </p>
    </div>
</div>
<div id="content_box_bottom">
    
    <table id="auftraege_tbl" border="1">
        <tr>
            <td colspan="4">Ihre angeforderten Angebote</td>
        </tr>
        <tr>
            <th>Angebot</th>
            <th>Datum</th>
            <th>Auftragsname</th>
            <th>Status</th>
            <!--<th>Aktion</th>-->
        </tr>
        <?php foreach ($angebote as $angebot) {
            switch($angebot->getStatus()) {
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
            $auftragsNummer = $angebot->getAuftragsnummer();
            $dateien = $dateiVerwaltung->findeAnhandVonGehoertZuUndAktiv($auftragsNummer, 2);
            ?>
        <tr>
            <td><?php echo $angebot->getAuftragsnummer(); ?>
            <a class="details_btn" style="margin:0;" href="view/auftrag_details.php?id=<?php echo $angebot->getId() ?>" title="Auftrag <?php echo $angebot->getAuftragsnummer() ?>" rel="gb_page_center[400, 500]"></a>
            </td>
            <td><?php echo substr($angebot->getDatum(), 0, 10); ?></td>
            <td><?php echo $angebot->getAuftragsname() ?></td>
            <td><?php echo $status ?></td>
            <!--<td>
                <a href="index.php?action=">Auftrag erteilen</a>
            </td>-->
        </tr>
        <?php } ?>
    </table>
    
    <table id="auftraege_tbl" border="1">

        <tr>
            <td colspan="5">Ihre Aufträge</td>
        </tr>
        <tr>
            <th>Auftrag</th>
            <th>Datum</th>
            <th>Auftragsname</th>
            <th>Status</th>
            <th>Download</th>
        </tr>
        <?php foreach ($auftraege as $auftrag) {
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
            $auftragsNummer = $auftrag->getAuftragsnummer();
            $dateien = $dateiVerwaltung->findeAnhandVonGehoertZuUndAktiv($auftragsNummer, 2);
            ?>
        <tr>
            <td><?php echo $auftrag->getAuftragsnummer(); ?>
            <a class="details_btn" href="view/auftrag_details.php?id=<?php echo $auftrag->getId() ?>" title="Auftrag <?php echo $auftrag->getAuftragsnummer() ?>" rel="gb_page_center[400, 500]"></a>

            </td>
            <td><?php echo substr($auftrag->getDatum(), 0, 10); ?></td>
            <td><?php echo $auftrag->getAuftragsname() ?></td>
            <td><?php echo $status ?></td>
            <td>
                    <?php
                    foreach ($dateien as $datei) {
                        ?>
                <a href="http://wp1035944.server-he.de/www/files/<?php echo $datei->getDateiname(); ?>"><?php echo $datei->getDateiname(); ?></a><br />
                    <?php } ?>

            </td>
        </tr>
        <?php } ?>
    </table>
</div>