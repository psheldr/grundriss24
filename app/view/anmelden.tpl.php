<?php ?>
<div id="content_box_top" style="margin-left: 150px;">
    <p class="fett_orange_italic" style="margin-top: 40px;">
        LOGGEN SIE SICH FÜR DIESE AKTION BITTE EIN
    </p>
    <p class="fett_grau_italic">
        Sie sind bereits Kunde:
    </p>
    <div id="login_box_center">
     <form action="index.php?action=do_login" method="post">
        <label class="login_label" for="" style="float: left;">Email-Adresse</label>
        <input class="login_input" type="text" name="login" value="<?php if(!empty($_SESSION['login_user'])) {echo $_SESSION['login_user']; } ?>"/><br />
        <label class="login_label" for="" style="float: left;">Passwort</label>
        <input class="login_input" type="password" name="password" />  <br />
        <a id="pw_forgot_link" href="Passwort">Passwort vergessen?</a>
        <input type="submit" class="submit_btns_150" name="" value="anmelden" onmouseover="this.style.cursor='pointer'" />
    </form>
        
        </div><?php echo $_SESSION['hinweis']?>
    <p class="fett_grau_italic">
        Sie sind noch kein Kunde bei grundriss24.de?
    </p>
    <p>
        Registrieren Sie sich kostenlos und <strong>völlig unverbindlich</strong>!
    </p>
    <a href="Registrieren" style="margin-left: 50px;" class="buttons_login" id="reg_button_login">registrieren</a>
    <div style="clear: both;"></div>
</div>

<div id="content_box_bottom">

</div>