  <div class="login_border_top"></div>
<div class="inner_login_box">
 
    <form action="index.php?action=do_login" method="post">
        <label style="float: right; margin-right: 30px; color: #5D5869;margin-bottom: 5px;">Kundenlogin</label>
        <input class="login_input" type="text" name="login" value="<?php if(!empty($_SESSION['login_user'])) {echo $_SESSION['login_user']; } ?>"/>
        <label class="login_label" for="">E-Mail-Adresse</label>
        <input class="login_input" type="password" name="password" />
        <label class="login_label" for="">Passwort</label>
        <a id="pw_forgot_link" href="Passwort">Passwort vergessen?</a>
        <input type="submit" class="submit_btns_150" name="" value="anmelden"  onmouseover="this.style.cursor='pointer'" />
    </form>
    <div class="meldung">
        <?php if($_SESSION['hinweis'] != '' && $action != 'kontakt') { ?>
        <?php echo $_SESSION['hinweis'];?>
            <?php } ?>
    </div>

</div>
  <div class="login_border_bottom"></div>
  
  <div class="login_border_top"></div>
  <div class="inner_login_box">
      <a href="Registrieren" class="buttons_login" id="reg_button_login">registrieren</a>
  </div>
  <div class="login_border_bottom"></div>
<?php if ($action == 'anmelden') { ?>
  <?php } else { ?>
  <div class="login_border_top"></div>
  <div class="inner_login_box">
      <a href="Angebot" class="buttons_login" id="ang_button_login">Angebot anfordern</a>
  </div>
  <div class="login_border_bottom"></div>

 <?php } ?>