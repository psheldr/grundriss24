<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<?php ?>

<h2>Neuer Auftrag für <?php echo $kunde->getFirma() ?></h2>

<div class="form_box">
    <table border="1">
        <tr>
            <td class="col1"><label class="form_label" for="">Auftragsname</label></td>
            <td class="col2"><input value="" id="" type="text" class="prof_input" name="" /></td>
        </tr>
        <tr>
            <td><label class="form_label" for="">Ansprechpartner</label></td>
            <td><input value="" id="" type="text" class="prof_input" name="" /></td>
        </tr>
        <tr>
            <td>Web-Grafiken mitliefern:</td>
            <td><input type="radio" name="web" /><label for="" class="">Nein</label>
                <input type="radio" name="web" /><label for="" class="">Ja</label></td>
        </tr>
        <tr>
            <td colspan="2"><h2>Gestaltung</h2></td>
        </tr>
        <tr>
            <td>Gewünschtes Design</td>
            <td><input type="radio" name="design" /><label for="" class="">Flair</label>
                <input type="radio" name="design" /><label for="" class="">Pastell</label>
                <input type="radio" name="design" /><label for="" class="">Ambiente</label>
                <input type="radio" name="design" /><label for="" class="">DeLuxe (Aufpreis 15,- Euro)</label>
                <input type="radio" name="design" /><label for="" class="">Büro</label></td>
        </tr>
        <tr>
            <td>Optionen (ohne Aufpreis)</td>
            <td>
                <label for="" class="">Welche Räume haben Parkett/Holzboden?</label><input type="text" name="" />
                <br />
                <input type="radio" name="" class="" />
                mit Objektinfo
                <br />
                <input type="radio" name="" class="" />
      	mit Raumbezeichnungen
                <br />
                <input type="radio" name="" class="" />
                mit qm-Angaben
            </td>
        </tr>
        <tr>
            <td cospan="2">Wie findet die Übermittlung der Vorlagen statt?</td>            
        </tr>
        <tr>
            <td>Ich sende die Grundrisse per:</td>
            <td><input type="radio" class="" name="" />Datei-Upload
                <input type="radio" class="" name="" />Fax
                <input type="radio" class="" name="" />Post
            </td>
        </tr>
        <tr>
            <td>Upload
            </td>
            <td><form>
                    <input type="file" name="" />
                    <input type="submit" value="Datei hochladen" />
                </form></td>
        </tr>



    </table>
</div>