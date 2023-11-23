<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<div id="content_box_top">
    <div id="auftraege_top">
        <h2 class="fett_orange_italic">Passwort vergessen?</h2>
        <p class="copy_12" <?php if (!$_SESSION['pw_check']) { ?> style="color: red;" <?php } else { ?>style="color: green;"<?php }?>>
            <?php echo $_SESSION['pw_hinweis']; unset($_SESSION['pw_hinweis']);  ?>
        </p>
        <?php if (!$_SESSION['pw_check']) { ?>
         <p class="copy_12">
            Bitte geben Sie Ihre E-Mail-Adresse an, mit welcher Sie bei uns registriert sind. Sie erhalten dann eine E-Mail an die entsprechende Adresse.
             </p>
        <p class="copy_12">
        <form method="post" action="index.php?action=send_pw_new">
            <input type="text" class="reg_input" name="pw_email" /><br />
            <input type="submit" id="reg_button" value="absenden" style="float: left;" />
            </form>
        </p>
        <?php } unset($_SESSION['pw_check']); ?>
    </div>
</div>
<div id="content_box_bottom">


</div>