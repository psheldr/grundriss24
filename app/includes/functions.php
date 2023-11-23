<?php

function redirect_mit_hinweis($hinweis, $location, $typ = '') {
    if ($typ == '') {
        $typ = 'fehler';
    }
    if ($typ == 'fehler') {
        $_SESSION['hinweis'] = '<p class="error_message">' . $hinweis . '</p>';
    }
    if ($typ == 'erfolg') {
    $_SESSION['hinweis'] = '<p class="success_message">' . $hinweis . '</p>';
    }
    header($location);
}

function erstelle_anzulegenden_user($daten) {
    if ($daten['reg_nachname'] != '') {
        $_SESSION['anzulegender_user']['benutzer'] = $daten['reg_vorname'] . ' ' . $daten['reg_nachname'];
    } else {
        $_SESSION['anzulegender_user']['benutzer'] = '';
    }
    
    $_SESSION['vorname'] = $daten['reg_vorname'];
    $_SESSION['nachname'] = $daten['reg_nachname'];
    $_SESSION['anrede'] = $daten['reg_anrede'];
    $_SESSION['anzulegender_user']['login'] = $daten['reg_email'];
    $_SESSION['anzulegender_user']['passwort'] = $daten['reg_pw'];
    $_SESSION['anzulegender_user']['firma'] = $daten['reg_firma'];
    $_SESSION['anzulegender_user']['strasse'] = $daten['reg_strasse'];
    $_SESSION['anzulegender_user']['plz'] = $daten['reg_plz'];
    $_SESSION['anzulegender_user']['ort'] = $daten['reg_ort'];
    $_SESSION['anzulegender_user']['tel'] = $daten['reg_tel'];
    $_SESSION['anzulegender_user']['fax'] = $daten['reg_fax'];
    $_SESSION['anzulegender_user']['mobil'] = $daten['reg_mobil'];
    $_SESSION['anzulegender_user']['datum'] = date("d.m.Y H:i:s");;
    $_SESSION['anzulegender_user']['aktiv'] = 1;
    
    return $_SESSION['anzulegender_user'];
}

?>
