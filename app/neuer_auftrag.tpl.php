
<div id="content_box_top">
    <p class="fett_orange_italic" >Neuer Auftrag - <?php echo $_SESSION['job_request']['auftragsnummer']?></p>
    <p class="copy_12">
        <?php echo $user->getFirma() ?><br />
        <?php echo $user->getBenutzer() ?><br />
        <?php echo $user->getStrasse() ?><br />
        <?php echo $user->getPlz() ?> <?php echo $user->getOrt() ?>
    </p>
    <p class="copy_12">
        <strong>
            Eine Fertigstellung Ihrer Grundrisse innerhalb 24 Stunden kann nur gewährleistet werden, wenn
            der Auftragseingang bis spätestens 16:00 Uhr erfolgt und keine weiteren Absprachen notwendig sind.
        </strong>
    </p>
</div>

<div id="content_box_bottom">
    <p style="color: red; margin-left: 200px;">
        <?php echo $auftrag->zeigeFehler() ?><br />
        <?php echo $_SESSION['hinweis_jobs']; unset($_SESSION['hinweis_jobs']) ?>
    </p>
    <div id="form_box_auftrag">
        <form action="auftrag_anlegen" method="post" enctype="multipart/form-data" >
            <label class="reg_label" for="job_name">Auftragsname</label><input value="<?php if($_SESSION['job_request']['auftragsname'] != '') { echo $_SESSION['job_request']['auftragsname']; }?>" id="job_name" type="text" class="reg_input" name="auftragsname" /><br />
            <label class="reg_label" for="job_asp">Ansprechpartner</label><input value="<?php if($_SESSION['job_request']['ansprechpartner'] != '') { echo $_SESSION['job_request']['ansprechpartner']; }?>" id="job_asp" type="text" class="reg_input" name="ansprechpartner" />

            <span class="reg_label">Web-Grafiken mitliefern:</span>
            <input type="radio" name="web" id="job_web_nein" value="0" checked="checked" <?php if($_SESSION['job_request']['web'] == '0') { echo 'checked="checked"'; }?> /><label for="job_web_nein" class="cb_label">Nein</label>
            <input type="radio" name="web" id="job_web_ja" value="1" <?php if($_SESSION['job_request']['web'] == '1') { echo 'checked="checked"'; }?> /><label for="job_web_ja" class="cb_label">Ja</label>
            <p class="copy_12">
                Wir erstellen immer ein JPG, das zum Ausdrucken auf DIN A4-Papier optimiert ist.
                Wenn Sie zusätzlich ein JPG benötigen, welches für die Verwendung im Internet komprimiert ist,
                kreuzen Sie bitte "ja" an. (kostenlos)
            </p>
            <hr />
            <h2 class="form_headline">Gestaltung</h2>
            <span class="reg_label">Gewünschtes Design</span>
            <div class="form_float_box">
                <ul class="cb_ul">
                    <li><input <?php if($_SESSION['job_request']['design'] == 'Ambiente') { echo 'checked="checked"'; }?> type="radio" name="design" id="cb_design_1" value="Ambiente" /><label for="cb_design_1" class="cb_label">Ambiente</label></li>
                    
                    <li><input <?php if($_SESSION['job_request']['design'] == 'Caro') { echo 'checked="checked"'; }?> type="radio" name="design" id="cb_design_3" value="Caro" /><label for="cb_design_3" class="cb_label">Caro</label></li>
                    <li><input <?php if($_SESSION['job_request']['design'] == 'Deluxe') { echo 'checked="checked"'; }?> type="radio" name="design" id="cb_design_4" value="Deluxe" /><label for="cb_design_4" class="cb_label">DeLuxe (Aufpreis 15,- Euro)</label></li>
                    <li><input <?php if($_SESSION['job_request']['design'] == 'Flair') { echo 'checked="checked"'; }?> type="radio" name="design" id="cb_design_5" value="Flair" /><label for="cb_design_5" class="cb_label">Flair</label></li>
                    <li><input <?php if($_SESSION['job_request']['design'] == 'Fresh') { echo 'checked="checked"'; }?>type="radio" name="design" id="cb_design_6" value="Fresh" /><label for="cb_design_6" class="cb_label">Fresh</label></li>
                    <li><input <?php if($_SESSION['job_request']['design'] == 'Legere') { echo 'checked="checked"'; }?> type="radio" name="design" id="cb_design_7" value="Legere" /><label for="cb_design_7" class="cb_label">Legere</label></li>
                    <li><input <?php if($_SESSION['job_request']['design'] == 'Pastell') { echo 'checked="checked"'; }?> type="radio" name="design" id="cb_design_8" value="Pastell" /><label for="cb_design_8" class="cb_label">Pastell</label></li>
                    <li><input <?php if($_SESSION['job_request']['design'] == 'Verde') { echo 'checked="checked"'; }?> type="radio" name="design" id="cb_design_9" value="Verde" /><label for="cb_design_9" class="cb_label">Verde</label></li>
                    <li><input <?php if($_SESSION['job_request']['design'] == 'Gewerbe') { echo 'checked="checked"'; }?> type="radio" name="design" id="cb_design_2" value="Gewerbe" /><label for="cb_design_2" class="cb_label">Gewerbe (Aufpreis 15,- Euro)</label></li>
                </ul>
            </div>
            <div style="clear: both;"></div>
            <hr />
            <h2 class="form_headline">Optionen (ohne Aufpreis)</h2>
            <label for="job_boden" class="reg_label">Welche Räume haben Parkett/Holzboden?</label><input value="<?php if($_SESSION['job_request']['holzboden'] != '') { echo $_SESSION['job_request']['holzboden']; }?>" type="text" class="reg_input" id="job_boden" name="holzboden" />
<br /><br />
<hr />
<h2 class="form_headline">Parkett/Holzboden (ohne Aufpreis)</h2>
            <input type="checkbox"  value="1" id="job_objektinfo" style="float: left;margin: 0px 10px 30px 0px" name="info" <?php if($_SESSION['job_request']['info'] == '1') { echo 'checked="checked"'; }?> />
            <label for="job_objektinfo" class="cb_label" class="cb_label_breit">mit Objektinfo: Text, der als Über- oder Unterschrift mit auf die Zeichnung soll.
                (z.B. Objektname/Strasse, Stockwerk, qm Gesamtstockwerk) Bitte schreiben Sie die Objektinfo
                ggfs. in "Bemerkungen" oder mit auf die Vorlage.</label><br /><br />

            <input type="checkbox" class="cb_label" value="1" id="job_raumbezeichnungen" name="bezeichnungen" class="cb_label_breit" style="float: left;margin: 0px 10px 20px 0px" <?php if($_SESSION['job_request']['bezeichnungen'] == '1') { echo 'checked="checked"'; }?> />
            <label for="job_raumbezeichnungen" class="cb_label">mit Raumbezeichnungen: auf dem Grundriss vermerkte Bezeichnungen werden auch
                im gestalteten Grundriss eingetragen. (z.B.: Schlafen, Wohnen, Küche)</label><br /><br />

            <input type="checkbox" class="cb_label" value="1" id="job_qm" name="qm" class="cb_label_breit" style="float: left;margin: 0px 10px 30px 0px" <?php if($_SESSION['job_request']['qm'] == '1') { echo 'checked="checked"'; }?> />
            <label for="job_qm" class="cb_label"> mit qm-Angaben: auf dem Grundriss vermerkte qm Angaben zu den einzelnen Räumen werden auch im gestalteten Grundriss eingetragen.</label>

            <hr />
            <h2 class="form_headline">Wie findet die Übermittlung der Vorlagen statt?</h2>
            <span class="reg_label">Ich sende die Grundrisse per:</span>
            <input type="radio" class="" value="Datei-Upload" name="versand" id="cb_transfer_1" checked="checked" <?php if($_SESSION['job_request']['versand'] == 'Datei-Upload') { echo 'checked="checked"'; }?> /><label for="cb_transfer_1" class="cb_label">Datei-Upload</label>
            <input type="radio" class="" value="Fax" name="versand" id="cb_transfer_2" <?php if($_SESSION['job_request']['versand'] == 'Fax') { echo 'checked="checked"'; }?> /><label for="cb_transfer_2" class="cb_label">Fax</label>
            <input type="radio" class="" value="Post" name="versand" id="cb_transfer_3" <?php if($_SESSION['job_request']['versand'] == 'Post') { echo 'checked="checked"'; }?> /><label for="cb_transfer_3" class="cb_label">Post</label>
            <p class="copy_12">Falls Sie uns Ihre Unterlagen per Fax oder Post zusenden, erscheint nach "Auftrag absenden" ein Deckblatt zum Ausdrucken.
                Bitte schicken Sie dieses Deckblatt bei Ihrem Fax/Brief mit, damit wir Ihre Unterlagen zuordnen können.</p>
            <hr />
            


            <?php

            ?>

            <div style="clear: both;"></div><a name="upload"></a>

              <h2 class="form_headline">Upload</h2>
            <p class="copy_12">
                Sie können beliebig viele Grundrisse (je 24 Euro zzgl. MwSt) in einem Auftrag übermitteln.
                Wählen Sie Ihre zu bearbeitenden Dateien mit "Durchsuchen" aus, und klicken Sie anschließend auf "hochladen", damit die Datei in untenstehender Liste erscheint.
                Das "Hochladen" der einzelnen Dateien kann je nach Größe der Datei und Geschwindigkeit Ihrer Internetverbindung etwas dauern.
            </p>
            <input style="clear: both;" type="file" id="file_upload" name="file_upload"  />
            <?php
            foreach($dateien as $datei) { ?>

            <p class="uploaded_data"><?php echo $datei->getDateiname() ?> <a class="btn_delete" href="index.php?action=remove_file&file_id=<?php echo $datei->getId(); ?>"></a></p>
            <?php }
            ?>
            <!--<a name="test" href="javascript:$('#file_upload').uploadifyUpload();" id="btn_upload_now"></a><br />-->
           
            <input style="clear: both;" type="submit" value="" id="btn_upload_now" name="upload_btn" onclick="javascript: showLoader()" />
            <a href="" name="upload"></a>
            <div id="loader" style="width: 300px; padding: 10px;position:absolute; bottom: 50px; left: 50%;margin-left: -200px; display: none;border: 1px solid #bbb; background: #fff;  ">
           <img style="display: block;margin-left: auto; margin-right: auto;" src="images/load_ani.gif" alt="" />
           <p class="copy">Datei wird hochgeladen. Dies kann je nach Größe der Datei und Geschwindigkeit Ihrer Internetverbindung einige Momente dauern.</p>
            </div>

            
            <hr />
            <label class="reg_label" style="width: 120px;">Bemerkung</label>
            
            <textarea name="bemerkung" cols="37" rows="5" ><?php if(isset($_SESSION['job_request']['bemerkung']  )) { echo $_SESSION['job_request']['bemerkung']; }?></textarea>
            <hr />
            <input type="submit" value="" id="send_job"/>
        </form>

     
          
    </div>
</div>