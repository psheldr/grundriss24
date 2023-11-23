<h2>Auftragsverwaltung</h2>
<a href="index.php?action=log_out">ausloggen</a>
<?php if (count($angebotsAnfragen) > 0) { ?>
    <h3>Aktuelle Angebotsanfragen</h3>
    <table border="1" class="liste_tbl_angebot">
        <tr>
            <th class="col_1">Auftrag</th>
            <th class="col_2">Auftragsname</th>
            <th class="col_3">Datum</th>
            <th class="col_4">Kunde</th>
            <th class="col_5">Dateien</th>
            <th class="col_6">Bearbeiter</th>
            <th class="col_7">Hochladen</th>
            <th class="col_8">Bearbeiten</th>
        </tr>
        <?php
        foreach ($angebotsAnfragen as $angebotsAnfrage) {
            $userId = $angebotsAnfrage->getGehoertZu();
            $auftragsNummer = $angebotsAnfrage->getAuftragsnummer();
            $user = $userVerwaltung->findeAnhandVonId($userId);
            $dateien = $dateiVerwaltung->findeAnhandVonGehoertZuUndAktiv($auftragsNummer, 2);
            $vorlageDateien = $dateiVerwaltung->findeAnhandVonGehoertZuUndAktiv($auftragsNummer, 1)
            ?>
            <tr>
                <td class="col_1"><?php echo $angebotsAnfrage->getAuftragsnummer() ?><br />
                    
                    <a href="javascript:displayWindow('details.php?&a=<? echo $angebotsAnfrage->getId(); ?>','400','550')"><img src="images/buttons/info.gif" border=0 ></a>
                </td>
                <td class="col_2"><?php echo $angebotsAnfrage->getAuftragsname() ?></td>
                <td class="col_3"><?php echo $angebotsAnfrage->getDatum() ?></td>
                <td class="col_4"><span class="text_blau"><?php echo $user->getFirma() ?></span><br /><span class="text_grau"><?php echo $user->getBenutzer() ?></span></td>
                <td class="col_5">
                    <table class="inner_tbl" border="0">
                        <tr>
                            <td>Kundenvorlage:<br />
                                <?php
                                foreach ($vorlageDateien as $vorlageDatei) {
                                    ?>
                                    <a href="http://wp1035944.server-he.de/www/files/<?php echo $vorlageDatei->getDateiname2(); ?>"><?php echo $vorlageDatei->getDateiname2(); ?></a><a href="index.php?action=loesche_datei_vorlage&id=<?php echo $vorlageDatei->getId() ?>" class="loeschkreuz"><img src="images/buttons/loeschkreuz.gif" /></a>,
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="col_6">
                    <form action="index.php?action=speichere_bearbeiter&id=<?php echo $angebotsAnfrage->getId() ?>" method="post">
                        <input class="fett_input" type="text" name="bearbeiter" value="<?php echo $angebotsAnfrage->getBearbeiter() ?>" /><br />
                        <input type="submit" class="input_submits" value="speichern" />
                    </form>
                </td>
                <td class="col_7">           
                </td>
                <td class="col_8">
                    <a onclick="return confirm('Angebotsanfrage <?php echo $angebotsAnfrage->getAuftragsnummer() ?> in einen Auftrag konvertieren?')" href="index.php?action=erzeuge_auftrag&id=<?php echo $angebotsAnfrage->getId() ?>">zu Auftrag konvertieren</a><br />
                    <a onclick="return confirm('Angebotsanfrage <?php echo $angebotsAnfrage->getAuftragsnummer() ?> löschen?')" href="index.php?action=loesche_auftrag&id=<?php echo $angebotsAnfrage->getId() ?>">Löschen</a>
                </td>
            </tr>
        <?php } ?>
    </table>
<?php } ?>


<h3>Aktuelle Aufträge</h3>
<a href="index.php?action=waehle_kunde">neuen Auftrag anlegen</a>

<?php if (count($auftraegeAktiv) > 0) { ?>
    <table border="1" class="liste_tbl">
        <tr>
            <th class="col_1">Auftrag</th>
            <th class="col_2">Auftragsname</th>
            <th class="col_3">Datum</th>
            <th class="col_4">Kunde</th>
            <th class="col_5">Dateien</th>
            <th class="col_6">Bearbeiter + Anzahl</th>
            <th class="col_7">Hochladen</th>
            <th class="col_8">Bearbeiten</th>
        </tr>
        <?php
        foreach ($auftraegeAktiv as $auftragAktiv) {
            $userId = $auftragAktiv->getGehoertZu();
            $auftragsNummer = $auftragAktiv->getAuftragsnummer();
            $user = $userVerwaltung->findeAnhandVonId($userId);
            $gestoppt = $auftragVerwaltung->findeAlleMahnung3ZuKunde($userId);
            $dateien = $dateiVerwaltung->findeAnhandVonGehoertZuUndAktiv($auftragsNummer, 2);
            $vorlageDateien = $dateiVerwaltung->findeAnhandVonGehoertZuUndAktiv($auftragsNummer, 1)
            ?>
            <tr <?php if (count($gestoppt) > 0) { ?>class="auftragsstop" <?php } ?>>
                <td class="col_1"><?php echo $auftragAktiv->getAuftragsnummer() ?><br />
                    <a href="javascript:displayWindow('details.php?&a=<? echo $auftragAktiv->getId(); ?>','400','550')"><img src="images/buttons/info.gif" border=0 ></a>
                </td>
                <td class="col_2"><?php echo $auftragAktiv->getAuftragsname() ?></td>
                <td class="col_3"><?php echo $auftragAktiv->getDatum() ?></td>
                <td class="col_4">
                    <?php if (count($gestoppt) > 0) { ?>
                        <strong>BENUTZER GESPERRT:</strong>
                        <?php echo $user->getFirma() ?><br /><?php echo $user->getBenutzer() ?>
                    <?php } else { ?>
                        <span class="text_blau"><?php echo $user->getFirma() ?></span><br /><span class="text_grau"><?php echo $user->getBenutzer() ?></span>
                    <?php } ?>

                </td>

                <td class="col_5">
                    <table class="inner_tbl" border="0">
                        <tr>
                            <td>Kundenvorlage:<br />
                                <?php
                                foreach ($vorlageDateien as $vorlageDatei) {
                                    ?>
                                    <a href="http://wp1035944.server-he.de/www/files/<?php echo $vorlageDatei->getDateiname2(); ?>"><?php echo $vorlageDatei->getDateiname2(); ?></a><a href="index.php?action=loesche_datei_vorlage&id=<?php echo $vorlageDatei->getId() ?>" class="loeschkreuz"><img src="images/buttons/loeschkreuz.gif" /></a>,
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Bearbeitet:<br />
                                <?php
                                foreach ($dateien as $datei) {
                                    ?>
                                    <a href="http://wp1035944.server-he.de/www/files/<?php echo $datei->getDateiname(); ?>"><?php echo $datei->getDateiname(); ?></a><a href="index.php?action=loesche_datei&id=<?php echo $datei->getId() ?>" class="loeschkreuz"><img src="images/buttons/loeschkreuz.gif" /></a>,
                                <?php } ?>
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="col_6">
                    <form action="index.php?action=speichere_bearbeiter&id=<?php echo $auftragAktiv->getId() ?>" method="post">
                        <p>
                            Bearbeiter:
                            <input class="fett_input" type="text" name="bearbeiter" value="<?php echo $auftragAktiv->getBearbeiter() ?>" />
                        </p>
                        <p>
                            Anzahl abzurechnen:<br />
                            <input class="fett_input" style='width: 50px;' type="text" name="anzahl" value="<?php echo $auftragAktiv->getAnzahl() ?>" />
                            <?php
                            if ($auftragAktiv->getDesign() == 'Deluxe' || $auftragAktiv->getDesign() == 'Gewerbe') {
                                $preis = 39;
                            } else {
                                $preis = 24;
                            }

                            echo ' x € ' . $preis . ' (' . $auftragAktiv->getDesign() . ')'
                            ?>

                        </p>

                        <input type="submit" class="input_submits" value="speichern" />

                    </form>
                </td>

                <td class="col_7">
                    <form name="<? echo $auftragAktiv->getAuftragsnummer(); ?>" action="index.php?action=upload_datei&u=<? echo $auftragAktiv->getAuftragsnummer() ?>" enctype="multipart/form-data" method="post">
                        Vorlagen hochladen:
                        <input type="file"  name="txt_datei2" />
                        <input type="submit" class="input_submits" name="btndatei2" value="Hochladen" /><br />
                        Ergebnis-Dateien hochladen:
                        <input type="file"  name="txt_datei" />
                        <input type="submit" class="input_submits" name="btndatei" value="Hochladen" />
                    </form>
                </td>
                <td class="col_8">

                    <a onclick="return confirm('Auftrag <?php echo $auftragAktiv->getAuftragsnummer() ?> abschließen und eine E-Mail an den Kunden versenden?')" class="confirm" href="index.php?action=finish_auftrag&id=<?php echo $auftragAktiv->getId() ?>">Abschließen</a>
                    <a onclick="return confirm('Auftrag <?php echo $auftragAktiv->getAuftragsnummer() ?> löschen?')" href="index.php?action=loesche_auftrag&id=<?php echo $auftragAktiv->getId() ?>">Löschen</a>
                </td>
            </tr>

        <?php } ?>
    </table>
<?php } else { ?>
    <p>Es liegen keine offenen Aufträge vor.</p>
<?php } ?>

<h3>Abgeschlossene Aufträge</h3>
<div id="suche_box">
    <p>Aufträge suchen:</p>
    <div class="such_box_sub">
        <form method="post" action="index.php?action=zeige_liste">
            <input class="search_inputs" type="text" name="search_job" /><br />
            <input class="search_btns" type="submit" value="nach Auftragsnummer oder Auftragsname" />
        </form>
    </div>
    <div class="such_box_sub">
        <form method="post" action="index.php?action=zeige_liste">
            <input class="search_inputs" type="text" name="search_by_user" /><br />
            <input class="search_btns" type="submit" value="nach Firma oder Ansprechpartner" />
        </form>
    </div>
    <div class="clear_box"></div>
</div>
<p>Aufträge anzeigen:</p>
<a href="index.php?action=zeige_liste&limit=10" <?php
if ($limit == '10') {
    echo 'class="fett_txt"';
}
?>>10</a>
<a href="index.php?action=zeige_liste&limit=25" <?php
if ($limit == '25') {
    echo 'class="fett_txt"';
}
?>>25</a>
<a href="index.php?action=zeige_liste&limit=50" <?php
if ($limit == '50') {
    echo 'class="fett_txt"';
}
?>>50</a>
<a href="index.php?action=zeige_liste&limit=100" <?php
if ($limit == '100') {
    echo 'class="fett_txt"';
}
?>>100</a>
<a href="index.php?action=zeige_liste&limit=99999" <?php
if ($limit == '99999') {
    echo 'class="fett_txt"';
}
?>>alle</a>
&nbsp;&nbsp;&nbsp;
<a href="index.php?action=zeige_liste&what=offene" <?php
if ($what == 'offene') {
    echo 'class="fett_txt"';
}
?>>nur offene Anzeigen</a>
   <?php if (isset($_POST['search_by_user'])) { ?>
       <?php
       if (count($userGefunden) > 1) {
           echo '<p>Es gab mehrere Treffer auf Ihre Suchanfrage. Bitte wählen Sie den gewünschten Kunden:</p>';
       } elseif (count($userGefunden) == 0) {
           echo '<p>Für Ihre Suchanfrage konnte kein Treffer erzielt werden.</p>';
       }
       foreach ($userGefunden as $user) {
           ?>
        <a href="index.php?action=zeige_liste&user=<?php echo $user->getId() ?>"><?php echo $user->getFirma() ?>, <?php echo $user->getBenutzer() ?></a><br />
        <?php
    }
} else {
    ?>
    <table border="1" class="liste_tbl">
        <tr>
            <th class="col_1">Auftrag</th>
            <th class="col_2">Auftragsname</th>
            <th class="col_3">Kunde</th>
            <th class="col_4">Dateien</th>
            <th class="col_5">Angelegt</th>
            <th class="col_6">Beendet</th>
            <th class="col_7">RG</th>
            <th class="col_8">Status</th>
            <th class="col_10">Abzurechnen</th>
            <th class="col_9">RG gestellt</th>
        </tr>
        <?php
        foreach ($auftraegeErledigt as $auftrag) {
            $userId = $auftrag->getGehoertZu();
            $auftragsNummer = $auftrag->getAuftragsnummer();
            $user = $userVerwaltung->findeAnhandVonId($userId);

            $gestoppt = $auftragVerwaltung->findeAlleMahnung3ZuKunde($userId);
            $dateien = $dateiVerwaltung->findeAnhandVonGehoertZuUndAktiv($auftragsNummer, 2);
            $vorlageDateien = $dateiVerwaltung->findeAnhandVonGehoertZuUndAktiv($auftragsNummer, 1)
            ?>
            <tr <?php if (count($gestoppt) > 0) { ?>class="auftragsstop" <?php } ?>>
                <td class="col_1"><?php echo $auftrag->getAuftragsnummer() ?><br />
                    <a href="javascript:displayWindow('details.php?&a=<? echo $auftrag->getId(); ?>','400','550')"><img src="images/buttons/info.gif" border=0></a>
                </td>
                <td class="col_2"><?php echo $auftrag->getAuftragsname() ?></td>
                <td class="col_3">
                    <?php if (count($gestoppt) > 0) { ?>
                        <strong>BENUTZER GESPERRT:</strong>
                        <?php echo $user->getFirma() ?><br /><?php echo $user->getBenutzer() ?>
                    <?php } else { ?>
                        <span class="text_blau"><?php echo $user->getFirma() ?></span><br /><span class="text_grau"><?php echo $user->getBenutzer() ?></span>
                    <?php } ?>

                </td>
                <td class="col_4_1">
                    <table class="inner_tbl" border="0">
                        <tr>
                            <td>Kundenvorlage:<br />
                                <?php
                                foreach ($vorlageDateien as $vorlageDatei) {
                                    ?>
                                    <a href="http://wp1035944.server-he.de/www/files/<?php echo $vorlageDatei->getDateiname2(); ?>"><?php echo $vorlageDatei->getDateiname2(); ?></a>,
                                <?php } ?>
                            </td>

                        </tr>
                        <tr>
                            <td>Bearbeitet:<br />
                                <?php
                                foreach ($dateien as $datei) {
                                    ?>
                                    <a href="http://wp1035944.server-he.de/www/files/<?php echo $datei->getDateiname(); ?>"><?php echo $datei->getDateiname(); ?></a>,
                                <?php } ?>
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="col_5">
                    <?php echo $auftrag->getDatum() ?>
                </td>
                <td class="col_6">

                    <?php echo $auftrag->getAbgeschlossen() ?>
                </td>
                <td class="col_7">
                    <a <?php
                    if ($auftrag->getRechnung() == 0) {
                        echo 'class="rechnung_aktiv" id="rng_offen"';
                    } else {
                        echo 'class="rechnung_inaktiv"';
                    }
                    ?> href="index.php?action=aendere_rechnung&rechnung_set=0&id=<?php echo $auftrag->getId() ?>">ausstehend</a>
                    <a <?php
                    if ($auftrag->getRechnung() == 1) {
                        echo 'class="rechnung_aktiv" id="rng_bezahlt"';
                    } else {
                        echo 'class="rechnung_inaktiv"';
                    }
                    ?> href="index.php?action=aendere_rechnung&rechnung_set=1&id=<?php echo $auftrag->getId() ?>">bezahlt</a>
                    <a <?php
                    if ($auftrag->getRechnung() == 2) {
                        echo 'class="rechnung_aktiv" id="rng_m1"';
                    } else {
                        echo 'class="rechnung_inaktiv"';
                    }
                    ?> href="index.php?action=aendere_rechnung&rechnung_set=2&id=<?php echo $auftrag->getId() ?>">1. Mahnung</a>
                    <a <?php
                    if ($auftrag->getRechnung() == 3) {
                        echo 'class="rechnung_aktiv" id="rng_m2"';
                    } else {
                        echo 'class="rechnung_inaktiv"';
                    }
                    ?> href="index.php?action=aendere_rechnung&rechnung_set=3&id=<?php echo $auftrag->getId() ?>">2. Mahnung</a>
                    <a <?php
                    if ($auftrag->getRechnung() == 4) {
                        echo 'class="rechnung_aktiv" id="rng_m3"';
                    } else {
                        echo 'class="rechnung_inaktiv"';
                    }
                    ?> href="index.php?action=aendere_rechnung&rechnung_set=4&id=<?php echo $auftrag->getId() ?>">STOP</a>
                </td>
                <td class="col_8">
                    <a onclick="return confirm('Soll der Status von Auftrag <?php echo $auftrag->getAuftragsnummer() ?> wieder auf aktiv/in Bearbeitung gesetzt werden?')" href="index.php?action=aktiviere_auftrag&id=<?php echo $auftrag->getId() ?>">Aktiv?</a>
                    <a onclick="return confirm('Auftrag <?php echo $auftrag->getAuftragsnummer() ?> löschen?')" href="index.php?action=loesche_auftrag&id=<?php echo $auftrag->getId() ?>">Löschen</a>
                </td>
                <td class="col_10">
                    <?php
                    if ($auftrag->getDesign() == 'Deluxe' || $auftrag->getDesign() == 'Gewerbe') {
                        $preis = 39;
                    } else {
                        $preis = 24;
                    }

                    echo '<strong style="font-size: 16px;">' . $auftrag->getAnzahl() . ' x € ' . $preis . '</strong> (' . $auftrag->getDesign() . ')';
					
					if ($user->getId() == 53) {
						echo '<br /><strong style="font-size: 13px;color: red;">10% RABATT</strong>';
					}
					
                    if ($auftrag->getAenderungen() > 0) {
                        echo '<br /><strong style="font-size: 16px;">' . $auftrag->getAenderungen() . ' x € 10</strong> (Änderung)';
                    }
                    ?>
                    <hr />

                    <form action="index.php?action=speichere_anzahl&id=<?php echo $auftrag->getId() ?>" method="post">
                        <p>
                            Anzahl:<br />
                            <input class="fett_input" style='width: 30px;' type="text" name="anzahl" value="<?php echo $auftrag->getAnzahl() ?>" />
                            <input type="submit"  class="input_submits" value="speichern" />
                        </p>
                    </form>

                    <form action="index.php?action=speichere_aenderungen&id=<?php echo $auftrag->getId() ?>" method="post">
                        <p>
                            Änderungen zu je € 10:<br />
							<?php if($user->getId() == 0) { ?>
							Keine Änderungen für Kern in RE stellen
		<?php } else { ?>
                            <input class="fett_input" style='width: 30px;' type="text" name="aenderungen" value="<?php echo $auftrag->getAenderungen() ?>" />
                            <input type="submit"  class="input_submits" value="speichern" />
		<?php } ?>
                        </p>
                    </form>

                </td>
                <td>
                    (db-id: <?php echo $auftrag->getId() ?> )
                    <?php if ($user->getKundennr()) {
                        $rechnung = $rechnungVerwaltung->findeAnhandVonGehoertzu($auftrag->getId()); ?>     
                    
                            <a class="reload_page" target="_blank" href="index.php?action=pdf_rechnung&job_id=<?php echo $auftrag->getId() ?>&user_id=<?php echo $user->getId() ?>">Rechnungs PDF</a> 
                            <br />an <strong><?php echo $user->getLogin() ?></strong><br />
                            <?php if ($rechnung->getRechnungsnr()) { ?>
                            RE-Nr: <?php echo $rechnung->getRechnungsnr() ?><br />
                            <?php } ?>
                            Kundennummer:
                            <?php echo $user->getKundennr() ?>   <br /> 
						<?php	if ($user->getId() == 53) {
						echo '<p style="font-size: 13px;color: red;border: 2px solid red; padding: 2px;"><strong>10% RABATT</strong></p><br />';
					} ?>
                        <?php
                        ?>         
                        <?php if ($rechnung->getGestellt() == NULL || $rechnung->getGestellt() == 0) { ?>
                            <a href="index.php?action=setze_rechnung<?php if ($rechnung->getId() != '') { ?>&id=<?php
                                echo $rechnung->getId();
                            }
                            ?>&aid=<?php echo $auftrag->getId() ?>&set=1"><img src="images/rech_nein.gif" /></a>

                        <?php } elseif ($rechnung->getGestellt() == 1) { ?>
                            <a href="index.php?action=setze_rechnung&id=<?php echo $rechnung->getId() ?>&aid=<?php echo $auftrag->getId() ?>&set=0"><img src="images/rech_ja.gif" /></a>
                        <?php } ?>
                    <?php } else { ?>
                            <strong style=''>Es muss eine Kundennr. vergeben werden.</strong>
                    <form action="index.php?action=speichere_kundennr&uid=<?php echo $user->getId() ?>" method="post">
                        <p>
                            Kundennummer:<br />
                            <?php echo $user->getKundennr() ?>
                            <input class="fett_input" style='width: 100px;' type="text" name="kundennr" value="<?php echo $user->getKundennr() ?>" />
                            <input type="submit"  class="input_submits" value="speichern" />
                        </p>
                    </form>
<?php } ?>
                    <a name="<?php echo $auftrag->getId() ?>"></a>


                </td>
            </tr>

        <?php } ?>
    </table>
<?php } ?>