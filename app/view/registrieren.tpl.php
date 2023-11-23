<?php

?>
<div id="content_box_top">
    <p class="fett_center">
        Gerne erstellen wir auch für Sie<br /> eine Grundrissvariante in Ihren Firmenfarben.<br />
        So erhalten Ihre Exposés Ihre firmeneigene Note und<br /> Unterlagen von z.B. Bauträgern Ihr durchgängiges Unternehmensbild.
        <br /><!--Die Erstellung in Ihrem Design beträgt einmalig nur € 50,00.-->
    </p>
    <div style="clear: both;"></div>
</div>

<div id="content_box_bottom">
    <div id="form_wrapper">
        <div id="reg_border_top"></div>
        <div id="form_box">
            <div id="overlay_img"><img src="images/reg_postit.jpg" alt="" name="" /></div>
            <h3 class="box_title">REGISTRIERUNG</h3>
            <form action="do_reg" method="post">
                <?php echo $_SESSION['hinweis'] ?>
                <p class="formular_hinweise">

<?php echo $user->zeigeFehler() ?></p>
                <label class="reg_label">Anrede*</label>
                <input type="radio" id="reg_anrede_herr" name="reg_anrede" value="Herr" <?php if($_SESSION['request']['reg_anrede'] == 'Herr'){echo 'checked="checked"';} ?> /><label class="reg_label_radios" for="reg_anrede_herr">Herr</label>
                <input type="radio" id="reg_anrede_frau" name="reg_anrede" value="Frau" <?php if($_SESSION['request']['reg_anrede'] == 'Frau'){echo 'checked="checked"';} ?>/><label class="reg_label_radios" for="reg_anrede_frau">Frau</label>

                <label for="reg_nachname" class="reg_label" >Nachname*</label><input class="reg_input" type="text" name="reg_nachname" id="reg_nachname" <?php if($_SESSION['request']['reg_nachname']){ ?>value="<?php echo $_SESSION['request']['reg_nachname'] ?>"<?php } ?>/>
                <label for="reg_vorname" class="reg_label" >Vorname*</label><input class="reg_input" type="text" name="reg_vorname" id="reg_vorname" <?php if($_SESSION['request']['reg_vorname']){ ?>value="<?php echo $_SESSION['request']['reg_vorname'] ?>"<?php } ?>/>
                <label for="reg_firma" class="reg_label" >Firmenname*</label><input class="reg_input" type="text" name="reg_firma" id="reg_firma"  <?php if($_SESSION['request']['reg_firma']){ ?>value="<?php echo $_SESSION['request']['reg_firma'] ?>"<?php } ?>/>
                <label for="reg_strasse" class="reg_label" >Strasse, Nr.*</label><input class="reg_input" type="text" name="reg_strasse" id="reg_strasse"  <?php if($_SESSION['request']['reg_strasse']){ ?>value="<?php echo $_SESSION['request']['reg_strasse'] ?>"<?php } ?>/>
                <label for="reg_plz" class="reg_label" >PLZ*</label><input class="reg_input" type="text" name="reg_plz" id="reg_plz" <?php if($_SESSION['request']['reg_plz']){ ?>value="<?php echo $_SESSION['request']['reg_plz'] ?>"<?php } ?>/>
                <label for="reg_ort" class="reg_label" >Ort*</label><input class="reg_input" type="text" name="reg_ort" id="reg_ort" <?php if($_SESSION['request']['reg_ort']){ ?>value="<?php echo $_SESSION['request']['reg_ort'] ?>"<?php } ?>/>
                <label for="reg_tel" class="reg_label" >Telefon (Festnetz)*</label><input class="reg_input" type="text" name="reg_tel" id="reg_tel" <?php if($_SESSION['request']['reg_tel']){ ?>value="<?php echo $_SESSION['request']['reg_tel'] ?>"<?php } ?>/>
                <label for="reg_fax" class="reg_label" >Fax</label><input class="reg_input" type="text" name="reg_fax" id="reg_fax" <?php if($_SESSION['request']['reg_fax']){ ?>value="<?php echo $_SESSION['request']['reg_fax'] ?>"<?php } ?>/>
                <label for="reg_mobil" class="reg_label" >Mobilnummer</label><input class="reg_input" type="text" name="reg_mobil" id="reg_mobil" <?php if($_SESSION['request']['reg_mobil']){ ?>value="<?php echo $_SESSION['request']['reg_mobil'] ?>"<?php } ?>/>
                <label for="reg_email" class="reg_label" >E-Mail Adresse*</label><input class="reg_input" type="text" name="reg_email" id="reg_email" <?php if($_SESSION['request']['reg_email']){ ?>value="<?php echo $_SESSION['request']['reg_email'] ?>"<?php } ?>/>
				<p><strong>Der Rechnungsversand erfolgt an die angegebene E-Mail-Adresse.</strong></p>
                <label for="reg_pw" class="reg_label" >Kennwort*<br /> (mindestens 5 Zeichen)*</label><input class="reg_input" type="password" name="reg_pw" id="reg_pw" <?php if($_SESSION['request']['reg_pw'] == $_SESSION['request']['reg_pw_check']){ ?>value="<?php echo $_SESSION['request']['reg_pw'] ?>"<?php } ?>/>
               <br style="clear:both;"/> <label for="reg_pw_check" class="reg_label" >Kennwort wiederholen*</label><input class="reg_input" type="password" name="reg_pw_check" id="reg_pw_check" <?php if($_SESSION['request']['reg_pw'] == $_SESSION['request']['reg_pw_check']){ ?>value="<?php echo $_SESSION['request']['reg_pw_check'] ?>"<?php } ?> />
              
                <br style="clear:both;"/>
               
               <input type="checkbox" name="agb_cb" value="true" style="margin-right: 5px;" id="cb_agbs"/>
                
                <label for="cb_agbs"  class="cb_label" >
                    Ich akzeptiere die <a target="_blank" href="/agb">AGB</a> und
                    <a target="_blank" href="/datenschutz">Datenschutzrichtlinien</a> von grundriss24.de
                </label>
                <div class="spb_check">                    
                <input type="text" name="repeat_email" value=""  /> 
                </div>
                <br />
  <p class="info-text">
                          *Pflichtfelder; die hier erhobenen Daten werden von uns zur Bearbeitung Ihrer Registrierung verarbeitet. 
                          Weitere Informationen entnehmen Sie bitte folgendem Link: <a target="_blank" href="/datenschutz">https://www.grundriss24.de/datenschutz</a></p>
                    
                <input id="reg_button" type="submit" name="" value="jetzt anmelden" onmouseover="this.style.cursor='pointer'" />
				
				
            </form>
            <div style="clear: both;"></div>
        </div>

        <div id="reg_border_bottom"></div>
    </div>
</div>
