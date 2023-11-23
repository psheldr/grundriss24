<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<div id="content_box_top">
    <div id="auftraege_top">
        <h2 class="fett_orange_italic">Passwort vergessen?</h2>
        <p class="copy_12">
            Bitte geben Sie Ihre E-Mail-Adresse an, mit welcher Sie bei uns registriert sind. Sie erhalten dann eine E-Mail mit einem neuen Passwort an die entsprechende, bei uns hinterlegte Adresse.
        </p>
        <p class="copy_12">
        <form method="post" action="index.php?action=send_pw_new">
            <input type="text" class="reg_input" name="pw_email" /><br />
            <input type="submit" id="reg_button" value="absenden" style="float: left;" onmouseover="this.style.cursor='pointer'" />
            </form>
        </p>
    </div>
</div>
<div id="content_box_bottom">


</div>