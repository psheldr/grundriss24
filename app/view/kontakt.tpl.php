<?php ?>
<div id="content_box_top">
    <p class="fett_orange_italic" style="margin-top: 100px;">
        SENDEN SIE UNS EINE NACHRICHT
    </p>
    <p class="fett_grau_italic">
        Gerne beantworten wir Ihre Fragen oder nehmen Ihre Anregungen entgegen.
    </p>

<!--<img id="tel" src="images/tel.jpg" alt="" style="margin-left: 100px;;margin-top: 10px;"/>-->
    <p class="formular_hinweise">
    <?php if(is_array($_SESSION['hinweis'])) { echo '<span style="color:red;font-weight: bold;">' . implode('<br />',$_SESSION['hinweis']) . '</span>'; } else {echo $_SESSION['hinweis'];} ?></p>
    <div style="clear: both;"></div>
</div>

<div id="content_box_bottom">
    <div id="form_wrapper_kontakt">
        <div id="reg_border_top"></div>
        <div id="form_box_kontakt">
            <h3 class="box_title">KONTAKT</h3>
            <form method="post" action="index.php?action=sende_kontakt">

                <label class="reg_label">Anrede*</label>
                <input type="radio" id="reg_anrede_herr" name="kon_anrede" value="Herr" <?php if($_SESSION['kon_request']['kon_anrede'] == 'Herr') {echo 'checked="checked"';} ?> /><label class="reg_label_radios" for="reg_anrede_herr">Herr</label>
                <input type="radio" id="reg_anrede_frau" name="kon_anrede" value="Frau" <?php if($_SESSION['kon_request']['kon_anrede'] == 'Frau') {echo 'checked="checked"';} ?>/><label class="reg_label_radios" for="reg_anrede_frau">Frau</label>


                <label for="reg_vorname" class="reg_label" >Vorname</label><input value="<?php echo $_SESSION['kon_request']['kon_vorname'] ?>" class="reg_input" type="text" name="kon_vorname" id="reg_vorname"/>
                <label for="reg_nachname" class="reg_label" >Nachname*</label><input value="<?php echo $_SESSION['kon_request']['kon_nachname'] ?>" class="reg_input" type="text" name="kon_nachname" id="reg_nachname"/>
                <label for="reg_tel" class="reg_label" >Telefon (Festnetz)*</label><input value="<?php echo $_SESSION['kon_request']['kon_tel'] ?>" class="reg_input" type="text" name="kon_tel" id="reg_tel" />

                <label for="reg_email" class="reg_label" >E-Mail Adresse</label><input value="<?php echo $_SESSION['kon_request']['kon_email'] ?>" class="reg_input" type="text" name="kon_email" id="reg_email" /><br />

                <label class="reg_label">Ihre Nachricht</label>
                <textarea class="textarea" name="kon_message" cols="10" rows="3"><?php echo $_SESSION['kon_request']['kon_message'] ?></textarea>

                <input type="radio" <?php if($_SESSION['kon_request']['kon_antwort'] == 'Telefon') {echo 'checked="checked"';}?> name="kon_antwort" value="Telefon" style="margin-left: 200px; margin-right: 5px;" id="rad_rueckr"/>
                <label for="rad_rueckr"  class="cb_label">Sie wünschen einen Rückruf</label><br />

                <input type="radio" <?php if($_SESSION['kon_request']['kon_antwort'] == 'Email') {echo 'checked="checked"';}?> name="kon_antwort" value="Email" style="margin-left: 200px; margin-right: 5px;" id="rad_email"/>
                <label for="rad_email"  class="cb_label">Sie erwarten eine Antwort-Mail</label><br />

                      <p class="info-text">
                          *Pflichtfelder; die hier erhobenen Daten werden von uns zur Bearbeitung Ihrer Anfrage verarbeitet. 
                          Weitere Informationen entnehmen Sie bitte folgendem Link: <a target="_blank" href="https://www.grundriss24.de/datenschutz">https://www.grundriss24.de/datenschutz</a></p>
                    
                
                <input id="reg_button" type="submit" name="" value="absenden" onmouseover="this.style.cursor='pointer'" />
            </form>
            <div style="clear: both;"></div>
        </div>

        <div id="reg_border_bottom"></div>
    </div>
</div>