<div id="content_box_bottom">
    <div id="form_wrapper_kontakt">
        <div id="reg_border_top"></div>
        <div id="form_box_kontakt">
            
                <p class="<?php echo $_SESSION['hinweis_styles_class']?>">
<?php echo $_SESSION['hinweis'] ?>
<?php echo $user->zeigeFehler() ?></p>
            <h3 class="box_title">IHR PROFIL</h3>
            <form method="post" action="index.php?action=aendere_profil">
                <input type="hidden" name="id" value="<?php echo $user->getId() ?>" />
                 <input type="hidden" name="pw_alt" value="<?php echo $user_orig->getPasswort() ?>" />
                 <input type="hidden" name="kundennr" value="<?php echo $user_orig->getKundennr() ?>" />

                <label class="reg_label" for="prof_name">Ihr Vor- und Zuname</label><input value="<?php echo $user->getBenutzer() ?>" id="prof_name" type="text" class="reg_input" name="benutzer" /><br />
                <label class="reg_label" for="prof_firma">Firmenname</label><input value="<?php echo $user->getFirma() ?>" id="prof_firma" type="text" class="reg_input" name="firma" /><br />
                <label class="reg_label" for="prof_strasse">Straße, Nr.</label><input value="<?php echo $user->getStrasse() ?>" id="prof_strasse" type="text" class="reg_input" name="strasse" /><br />
                <label class="reg_label" for="prof_plz">PLZ</label><input value="<?php echo $user->getPlz() ?>" id="prof_plz" type="text" class="reg_input" name="plz" /><br />
                <label class="reg_label" for="prof_ort">Ort</label><input value="<?php echo $user->getOrt() ?>" id="prof_ort" type="text" class="reg_input" name="ort" /><br />
                <label class="reg_label" for="prof_tel">Telefon (Festnetz)</label><input value="<?php echo $user->getTel() ?>" id="prof_tel" type="text" class="reg_input" name="tel" /><br />
                <label class="reg_label" for="prof_fax">Fax</label><input value="<?php echo $user->getFax() ?>" id="prof_fax" type="text" class="reg_input" name="fax" /><br />
                <label class="reg_label" for="prof_mobil">Mobilnummer</label><input value="<?php echo $user->getMobil() ?>" id="prof_mobil" type="text" class="reg_input" name="mobil" /><br />
                <label class="reg_label" for="prof_email">E-Mail</label><input value="<?php echo $user->getLogin() ?>" id="prof_email" type="text" class="reg_input" name="login" /><br />
                <hr />
                <label class="reg_label" for="prof_pw_alt">altes Kennwort</label><input  id="prof_pw_alt" type="password" class="reg_input" name="pw_alt_check" value="" /><br />
                <label class="reg_label" for="prof_pw_neu">neues Kennwort</label><input  id="prof_pw_neu" type="password" class="reg_input" name="passwort" /><br />
                <label class="reg_label" for="prof_pw_check">neues Kennwort bestätigen</label><input value="" id="prof_pw_check" type="password" class="reg_input" name="passwort_check" />
                <input id="reg_button" type="submit" name="" value="absenden" />
            </form>
            <div style="clear: both;"></div>
        </div>
        <div id="reg_border_bottom"></div>
    </div>
</div>