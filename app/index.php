<?php
session_start();
   
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
//error_reporting(0);


require_once 'cfg/config.php';
require_once 'cfg/pdo_config.php';


$action = strtolower($_GET['action']) ? strtolower($_GET['action']) : 'startseite';
$page = strtolower($_REQUEST['page']);

//$id = $_REQUEST['id'];

switch($action) {
    case 'startseite':
        break;
    case 'do_login':
        $_SESSION['login_user'] = $_REQUEST['login'];
        $password = $_REQUEST['password'];
        $einloggenderUser = $userVerwaltung->findeAnhandVonLogin($_SESSION['login_user']);
        $passwordZuLogin = $einloggenderUser->getPasswort();
        if (isset($passwordZuLogin) && $password == $passwordZuLogin) {
            $_SESSION['logged_in_userid'] = $einloggenderUser->getId();
            unset($_SESSION['login_user']);
            if ($einloggenderUser->getAktiv() == 3) {

        $_SESSION['logged_in_admin'] = $_SESSION['logged_in_userid'];
                redirect_mit_hinweis('','location:Admin');
            } else {

            //  if ($_SESSION['target']) {
            //      $target = ucfirst($_SESSION['target']);
            //      redirect_mit_hinweis('',"location:$target");
            //} else {
                redirect_mit_hinweis('','location:Auftraege');
            // }
            }
        } else {
            if ($_SESSION['target']) {
                $target = ucfirst($_SESSION['target']);
                redirect_mit_hinweis('Die Logindaten sind nicht korrekt. Bitte versuchen Sie es erneut.',"location:$target");
            } else {
                redirect_mit_hinweis('Die Logindaten sind nicht korrekt. Bitte versuchen Sie es erneut.','location:Startseite');
            }
        }
        break;
    case 'log_out':
    //unset($_SESSION['logged_in_userid']);
        
        if ($_SESSION['logged_in_admin']) {
                redirect_mit_hinweis('','location:Admin');
        } else {
            session_destroy();
        
        header('location:Startseite');
        }
        break;
    case 'auftraege':
        $gehoertzu = $_SESSION['logged_in_userid'];
        $auftraege = $auftragVerwaltung->findeAnhandVonGehoertZu($gehoertzu);
        $angebote = $auftragVerwaltung->findeAlleAktivenAngebotsAnfragenZuKunde($gehoertzu);
        $user = $userVerwaltung->findeAnhandVonId($_SESSION['logged_in_userid']);
        break;
    case 'admin':
        header('location:admin/index.php');
        break;
    case 'profil':
        if(isset($_SESSION['changing_user_daten'])) {
            $user = new User($_SESSION['changing_user_daten']);
            $user_orig = $userVerwaltung->findeAnhandVonId($_SESSION['logged_in_userid']);
        } else {
            $user = $userVerwaltung->findeAnhandVonId($_SESSION['logged_in_userid']);
            $user_orig = $userVerwaltung->findeAnhandVonId($_SESSION['logged_in_userid']);
        }

        break;
    case 'aendere_profil':
        $daten = $_REQUEST;
        if(($_REQUEST['passwort'] != '' && $_REQUEST['passwort_check'] != '') && $_REQUEST['passwort'] == $_REQUEST['passwort_check'] && $_REQUEST['pw_alt_check'] == $_REQUEST['pw_alt']) {
            $daten['passwort'] = $_REQUEST['passwort'];
            $_SESSION['hinweis'] = 'Passwort wurde geändert.<br />';
            $_SESSION['hinweis_styles_class'] = 'success';
        } else {
            if (($_REQUEST['pw_alt'] != $_REQUEST['pw_alt_check']) && !empty($_REQUEST['pw_alt_check'])) {
                $_SESSION['hinweis'] .= 'Altes Passwort falsch.<br />';
                $_SESSION['hinweis_styles_class'] = 'error';
            }
            if (empty($_REQUEST['pw_alt_check']) && $_REQUEST['passwort'] != '') {
                $_SESSION['hinweis'] .= 'Altes Passwort eingeben.<br />';
                $_SESSION['hinweis_styles_class'] = 'error';
            }
            if ($_REQUEST['passwort'] != $_REQUEST['passwort_check']) {
                $_SESSION['hinweis'] .= 'Neues Passwort stimmt nicht mit Bestätigung überein.';
                $_SESSION['hinweis_styles_class'] = 'error';
            }

            $daten['passwort'] = $_REQUEST['pw_alt'];
        }


        $changed_user = new User($daten);

        $_SESSION['changing_user_daten'] = $daten;
        if($userVerwaltung->speichere($changed_user)) {
            unset($_SESSION['changing_user']);
        }
        header('location:index.php?action=profil');
        break;
    case 'registrieren':
        $user = new User($_SESSION['anzulegender_user']);
        break;
    case 'do_reg':
        if ($_REQUEST['repeat_email'] != '') {
            redirect_mit_hinweis('Ein Fehler ist aufgetreten. Bitte versuchen Sie es erneut.', 'location:Registrieren');
			exit;
        }
        erstelle_anzulegenden_user($_REQUEST);
        $_SESSION['request'] = $_REQUEST;
        $letzteIdUser = $userVerwaltung->findeLetzteId();
        $letzteId = $letzteIdUser->getId();
		
	   
        $letzteKundennrObj_arr = $userVerwaltung->findeLetzteKundennr();
        $letzteKundennr = $letzteKundennrObj_arr[0]->getKundennr();
    $_SESSION['anzulegender_user']['id'] = $letzteId + 1;
    $_SESSION['anzulegender_user']['kundennr'] = $letzteKundennr + 1;
    $_SESSION['anzulegender_user']['kundennr'] = NULL;

        $user = new User($_SESSION['anzulegender_user']); 
     
        
        if ($_REQUEST['reg_pw'] == '') {
            redirect_mit_hinweis('Bitte geben Sie Ihr gewünschtes Passwort ein.', 'location:Registrieren');
        } elseif ($_REQUEST['reg_pw'] != $_REQUEST['reg_pw_check']) {
            redirect_mit_hinweis('Die eingegebenen Passwörter stimmen nicht überein.', 'location:Registrieren');
        } else {
            if (!$_REQUEST['agb_cb']) {
                redirect_mit_hinweis('Um sich anmelden zu können, stimmen Sie bitte unseren AGBs zu.', 'location:Registrieren');
            } else {
                if($user->istValide()) {
                    $login_to_check = $user->getLogin();
                    $user_check = $userVerwaltung->findeAnhandVonLogin($login_to_check);

                    if ($user->getLogin() == $user_check->getLogin()) {
                        redirect_mit_hinweis('Es existiert bereits ein Konto mit dieser Emailadresse. Bitte benutzen Sie eine andere Email-Adresse.', 'location:Registrieren');
                    } else {
                        
                        $userVerwaltung->fuegeUserHinzu($user);
                        $neuerUser = $userVerwaltung->findeAnhandVonId($user->getId());
                        sendeNeueRegistrierungsInfo($user);
                        sendeRegistrierungsBestätigung($user);
                        unset($_SESSION['request']);
                        if ($_SESSION['target']) {
                            $target = ucfirst($_SESSION['target']);
                            redirect_mit_hinweis('Ihre Anmeldung war erfolgreich. Sie erhalten in Kürze eine Bestätigungsemail.', "location:$target", 'erfolg');
                        } else {
                            redirect_mit_hinweis('Ihre Anmeldung war erfolgreich. Sie erhalten in Kürze eine Bestätigungsemail.', 'location:Registrieren', 'erfolg');
                        }
                    }
                } else {
                    redirect_mit_hinweis('Bitte vervollständigen Sie Ihre Eingaben.', 'location:Registrieren');
                }
            }

        }

        break;
    case 'angebot':

        if (!$_SESSION['logged_in_userid']) {
            $_SESSION['target'] = 'angebot';

            redirect_mit_hinweis('Hierzu müssen Sie eingeloggt sein.', 'location:Anmelden');

        } else {
            $user = $userVerwaltung->findeAnhandVonId($_SESSION['logged_in_userid']);
            $auftrag = new Auftrag($_SESSION['job_request']);
            if ($_SESSION['job_request']['auftragsnummer'] == '') {
                $letzteAuftragsnummer = $auftragVerwaltung->findeLetzteAuftragsnummer();
                $_SESSION['job_request']['auftragsnummer'] = $letzteAuftragsnummer->getAuftragsnummer() + 1;

                $letzteId = $auftragVerwaltung->findeLetzteId();
                $_SESSION['job_request']['id'] = $letzteId->getId() + 1;
                $_SESSION['job_request']['gehoertzu'] = $_SESSION['logged_in_userid'];
                $_SESSION['job_request']['aktiv'] = 0;
                $_SESSION['job_request']['status'] = 9;
                $auftrag = new Auftrag($_SESSION['job_request']);
                $auftragVerwaltung->fuegeAuftragHinzu($auftrag);
            }
            $dateien = $dateiVerwaltung->findeAnhandVonGehoertZuUndAktiv($_SESSION['job_request']['auftragsnummer'], 0);
            $user = $userVerwaltung->findeAnhandVonId($_SESSION['logged_in_userid']);
        }
        break;
    case 'angebot_anlegen':
        $_SESSION['job_request']['auftragsname'] = $_REQUEST['auftragsname'];
        $_SESSION['job_request']['web'] = $_REQUEST['web'];
        $_SESSION['job_request']['design'] = $_REQUEST['design'];
        $_SESSION['job_request']['holzboden'] = $_REQUEST['holzboden'];
        $_SESSION['job_request']['info'] = $_REQUEST['info'];
        $_SESSION['job_request']['bezeichnungen'] = $_REQUEST['bezeichnungen'];
        $_SESSION['job_request']['qm'] = $_REQUEST['qm'];
        $_SESSION['job_request']['ansprechpartner'] = $_REQUEST['ansprechpartner'];
        $_SESSION['job_request']['versand'] = 'Datei-Upload';
        $_SESSION['job_request']['bemerkung'] = $_REQUEST['bemerkung'];
        $_SESSION['job_request']['status'] = 9;
        if ($_SESSION['job_request']['design'] == NULL) {
            $_SESSION['job_request']['design'] = '';
        }
        $_SESSION['job_request']['datum'] = date("d.m.Y H:i:s");
        $_SESSION['job_request']['aktiv'] = 1;

        //upload
        function getExtension($str) {
            $i = strrpos($str,".");
            if (!$i) {
                return "";
            }
            $l = strlen($str) - $i;
            $ext = substr($str,$i+1,$l);
            return $ext;
        }
        if(isset($_REQUEST['upload_btn']) && $_FILES['file_upload']['name'] != '') {

            $dateiname = $_FILES['file_upload']['name'];
            $dateigroesse = sprintf("%01.2f", $_FILES['file_upload']['size'] / 1024) . " kbytes";
            $dateienVorhanden = $dateiVerwaltung->findeAnhandVonGehoertZu($_SESSION['job_request']['auftragsnummer']);
            $auftragsnummer=$_SESSION['job_request']['auftragsnummer'];
            $zaehler = count($dateienVorhanden) + 1;


            $filename = stripslashes($_FILES['file_upload']['name']);
            $extension = getExtension($filename);
            $extension = strtolower($extension);


            //move_uploaded_file($_FILES['txt_datei']['tmp_name'], "files/".$_FILES['txt_datei']['name']);
            $zieldatei = $auftragsnummer . "_" . $zaehler . '.' . $extension;

            move_uploaded_file($_FILES['file_upload']['tmp_name'], $root_path_files.$zieldatei);
            $letzterDateiEintrag = $dateiVerwaltung->findeLetzteId();
            $_SESSION['datei_request']['id'] = $letzterDateiEintrag->getId() + 1;
            $_SESSION['datei_request']['gehoertzu'] =  $auftragsnummer;
            $_SESSION['datei_request']['dateiname'] =  $_FILES['file_upload']['name'];
            $_SESSION['datei_request']['dateiname2'] =  $zieldatei;
            $_SESSION['datei_request']['dateigroesse'] =  $dateigroesse;
            $_SESSION['datei_request']['datum'] =  date("d.m.Y H:i:s");;
            $_SESSION['datei_request']['aktiv'] =  0;

            $datei = new Datei($_SESSION['datei_request']);

            $dateiVerwaltung->speichere($datei);
        }
        //upload ende
        $auftrag = new Auftrag($_SESSION['job_request']);
       
        $dateienZuJob = $dateiVerwaltung->findeAnhandVonGehoertZuUndAktiv($_SESSION['job_request']['auftragsnummer'], 0);
        if (!$dateienZuJob && !isset($_REQUEST['upload_btn'])) {
            if ($_SESSION['job_request']['versand'] == 'Datei-Upload') {
                $_SESSION['hinweis_jobs'] = 'Wenn Sie als Versandart "Datei-Upload" gewählt haben, müssen Sie mindestens eine Datei hochladen';
            } else {
                $_SESSION['hinweis_jobs'] = "";
            } 
            header('location:Angebot');
        } else {
            if($auftragVerwaltung->speichere($auftrag) && !isset($_REQUEST['upload_btn'])) {
                $jobId = $auftrag->getId();
                $auftragsnummer_toset = $auftrag->getAuftragsnummer();
                $dateiVerwaltung->setzeDateienAktiv($auftragsnummer_toset);
                $auftragErteilt = $auftragVerwaltung->findeAnhandVonId($jobId);
                $userId = $auftragErteilt->getGehoertZu();
                $kunde = $userVerwaltung->findeAnhandVonId($userId);
                sendeAngebotsAnfrage($auftragErteilt, $kunde);
                unset($_SESSION['job_request']);
                header('location:Auftraege');
            } else {
                header('location:Angebot#upload');
            }
        }
        break;
    case 'sende_kontakt':
        if ($_REQUEST['kon_anrede'] == '') {
            $_SESSION['hinweis'][] = 'Bitte geben Sie eine Anrede an.';
        }
        if ($_REQUEST['kon_nachname'] == '') {
            $_SESSION['hinweis'][] = 'Bitte geben Sie einen Nachnamen ein.';
        }
        if ($_REQUEST['kon_email'] == '' && $_REQUEST['kon_tel'] == '') {
            $_SESSION['hinweis'][] = 'Bitte geben Sie eine Emailadresse oder Telefonnummer an.';
        }
        if ($_REQUEST['kon_antwort'] == '') {
            $_SESSION['hinweis'][] = 'Bitte wählen Sie die gewünschte Art unserer Antwort.';
        }
        $_SESSION['kon_request'] = $_REQUEST;
        if ($_SESSION['hinweis']!= '') {
            header('location:Kontakt');
        } else {
            sendeKontaktAnfrage($_SESSION['kon_request']);
            redirect_mit_hinweis('Vielen Dank für Ihre Nachricht. Wir werden uns in Kürze mit Ihnen in Verbindung setzen.','location:Kontakt', 'erfolg');
            unset($_SESSION['kon_request']);
        }

        break;
    case 'remove_file':
        $file_id = $_GET['file_id'];
        $editDatei = $dateiVerwaltung->findeAnhandVonId($file_id);

        unlink($root_path_files . 'files/' . $editDatei->getDateiname2());

        $dateiVerwaltung->loesche($editDatei);
        if ($_GET['pre'] == 'angebot') {
            header('location:Angebot#upload');
        } else {
            header('location:Neuer_Auftrag#upload');
        }
        
        break;
    case 'neuer_auftrag':
        if (!$_SESSION['logged_in_userid']) {
            $_SESSION['target'] = 'neuer_auftrag';
            redirect_mit_hinweis('Hierzu müssen Sie eingeloggt sein.', 'location:Anmelden');

        } else {


            $auftrag = new Auftrag($_SESSION['job_request']);
                
            if ($_SESSION['job_request']['auftragsnummer'] == '') {
                $letzteAuftragsnummer = $auftragVerwaltung->findeLetzteAuftragsnummer();
                $_SESSION['job_request']['auftragsnummer'] = $letzteAuftragsnummer->getAuftragsnummer() + 1;

                $letzteId = $auftragVerwaltung->findeLetzteId();
                $_SESSION['job_request']['id'] = $letzteId->getId() + 1;
                $_SESSION['job_request']['gehoertzu'] = $_SESSION['logged_in_userid'];
                $_SESSION['job_request']['aktiv'] = 0;
                $auftrag = new Auftrag($_SESSION['job_request']);
                $auftragVerwaltung->fuegeAuftragHinzu($auftrag);
            }


            $dateien = $dateiVerwaltung->findeAnhandVonGehoertZuUndAktiv($_SESSION['job_request']['auftragsnummer'], 0);
            $user = $userVerwaltung->findeAnhandVonId($_SESSION['logged_in_userid']);
        }
        break;
    case 'auftrag_anlegen':
        $_SESSION['job_request']['auftragsname'] = $_REQUEST['auftragsname'];
        $_SESSION['job_request']['web'] = $_REQUEST['web'];
        $_SESSION['job_request']['design'] = $_REQUEST['design'];
        $_SESSION['job_request']['holzboden'] = $_REQUEST['holzboden'];
        $_SESSION['job_request']['info'] = $_REQUEST['info'];
        $_SESSION['job_request']['bezeichnungen'] = $_REQUEST['bezeichnungen'];
        $_SESSION['job_request']['qm'] = $_REQUEST['qm'];
        $_SESSION['job_request']['ansprechpartner'] = $_REQUEST['ansprechpartner'];
        $_SESSION['job_request']['versand'] = $_REQUEST['versand'];
        $_SESSION['job_request']['bemerkung'] = $_REQUEST['bemerkung'];
        $_SESSION['job_request']['status'] = 1;
        if ($_SESSION['job_request']['design'] == NULL) {
            $_SESSION['job_request']['design'] = '';
        }
        $_SESSION['job_request']['datum'] = date("d.m.Y H:i:s");
        $_SESSION['job_request']['aktiv'] = 1;

        //upload
        function getExtension($str) {
            $i = strrpos($str,".");
            if (!$i) {
                return "";
            }
            $l = strlen($str) - $i;
            $ext = substr($str,$i+1,$l);
            return $ext;
        }
        if(isset($_REQUEST['upload_btn']) && $_FILES['file_upload']['name'] != '') {

            $dateiname = $_FILES['file_upload']['name'];
            $dateigroesse = sprintf("%01.2f", $_FILES['file_upload']['size'] / 1024) . " kbytes";
            $dateienVorhanden = $dateiVerwaltung->findeAnhandVonGehoertZu($_SESSION['job_request']['auftragsnummer']);
            $auftragsnummer=$_SESSION['job_request']['auftragsnummer'];
            $zaehler = count($dateienVorhanden) + 1;


            $filename = stripslashes($_FILES['file_upload']['name']);
            $extension = getExtension($filename);
            $extension = strtolower($extension);


            //move_uploaded_file($_FILES['txt_datei']['tmp_name'], "files/".$_FILES['txt_datei']['name']);
            $zieldatei = $auftragsnummer . "_" . $zaehler . '.' . $extension;

            move_uploaded_file($_FILES['file_upload']['tmp_name'], $root_path_files.$zieldatei);
            $letzterDateiEintrag = $dateiVerwaltung->findeLetzteId();
            $_SESSION['datei_request']['id'] = $letzterDateiEintrag->getId() + 1;
            $_SESSION['datei_request']['gehoertzu'] =  $auftragsnummer;
            $_SESSION['datei_request']['dateiname'] =  $_FILES['file_upload']['name'];
            $_SESSION['datei_request']['dateiname2'] =  $zieldatei;
            $_SESSION['datei_request']['dateigroesse'] =  $dateigroesse;
            $_SESSION['datei_request']['datum'] =  date("d.m.Y H:i:s");;
            $_SESSION['datei_request']['aktiv'] =  0;

            $datei = new Datei($_SESSION['datei_request']);

            $dateiVerwaltung->speichere($datei);
            
        }
        //upload ende
        
        $auftrag = new Auftrag($_SESSION['job_request']);
        $dateienZuJob = $dateiVerwaltung->findeAnhandVonGehoertZuUndAktiv($_SESSION['job_request']['auftragsnummer'], 0);
      
        if ($_SESSION['job_request']['versand'] != 'Fax' && $_SESSION['job_request']['versand'] != 'Post') {

        
        if (count($dateienZuJob) == 0 && !isset($_REQUEST['upload_btn'])) {
            
            if ($_REQUEST['versand'] == 'Datei-Upload') {
                $_SESSION['hinweis_jobs'] = 'Wenn Sie als Versandart "Datei-Upload" gewählt haben, müssen Sie mindestens eine Datei hochladen';
            } else {
                $_SESSION['hinweis_jobs'] = "";
            }
            
            header('location:Neuer_Auftrag');
        } elseif($auftragVerwaltung->speichere($auftrag) && !isset($_REQUEST['upload_btn'])) {
                $jobId = $auftrag->getId();
                $auftragsnummer_toset = $auftrag->getAuftragsnummer();
                $dateiVerwaltung->setzeDateienAktiv($auftragsnummer_toset);
                $auftragErteilt = $auftragVerwaltung->findeAnhandVonId($jobId);
                $userId = $auftragErteilt->getGehoertZu();
                $kunde = $userVerwaltung->findeAnhandVonId($userId);
                sendeAuftragsBestätigung($auftragErteilt, $kunde);
                sendeNeuerAuftragInfo($auftragErteilt, $kunde);
                unset($_SESSION['job_request']);
                if ($auftrag->getVersand() == 'Fax' || $auftrag->getVersand() == 'Post') {
                    $_SESSION['fapo'] = $auftrag->getVersand();
                    $_SESSION['a'] = $auftrag->getAuftragsnummer();

                    header('location:Auftraege');
                } else {

                    header('location:Auftraege');
                }


            } else {

                header('location:Neuer_Auftrag');
            }
        }elseif($auftragVerwaltung->speichere($auftrag) && !isset($_REQUEST['upload_btn'])) {
                $jobId = $auftrag->getId();
                $auftragsnummer_toset = $auftrag->getAuftragsnummer();
                $dateiVerwaltung->setzeDateienAktiv($auftragsnummer_toset);
                $auftragErteilt = $auftragVerwaltung->findeAnhandVonId($jobId);
                $userId = $auftragErteilt->getGehoertZu();
                $kunde = $userVerwaltung->findeAnhandVonId($userId);
                sendeAuftragsBestätigung($auftragErteilt, $kunde);
                sendeNeuerAuftragInfo($auftragErteilt, $kunde);
                unset($_SESSION['job_request']);
                if ($auftrag->getVersand() == 'Fax' || $auftrag->getVersand() == 'Post') {
                    $_SESSION['fapo'] = $auftrag->getVersand();
                    $_SESSION['a'] = $auftrag->getAuftragsnummer();

                    header('location:Auftraege');
                } else {

                    header('location:Auftraege');
                }


            } else {

                header('location:Neuer_Auftrag');
            }
        
        
        break;

    case 'send_pw_new':
	

        $eingegebeneEmail = $_REQUEST['pw_email'];
        $userVorhanden = $userVerwaltung->findeAnhandVonLogin($eingegebeneEmail);
        if ($userVorhanden->getId() != NULL) {
            $_SESSION['pw_hinweis'] = 'Es wurde eine E-Mail mit Ihrem Passwort an <strong>' . $userVorhanden->getLogin() . '</strong> versandt. Bitte prüfen Sie Ihren Posteingang.';
           $_SESSION['pw_check'] = true;
           // var_dump($_SESSION['pw_hinweis']);
		   
		    function random_str(
    $length = 8,
    $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
) {
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    if ($max < 1) {
        throw new Exception('$keyspace must be at least two characters long');
    }
    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[random_int(0, $max)];
    }
    return $str;
}
$rand_pw = random_str();
$userVorhanden->setPasswort($rand_pw);
$userVerwaltung->aendereUser($userVorhanden);

           sendePasswort($userVorhanden, $rand_pw);
		   
            header('location:pw_gesendet');
        } else {
            $_SESSION['pw_hinweis'] = 'Fehler: Es liegt kein Konto mit dieser E-Mail-Adresse vor.';
            $_SESSION['pw_check'] = false;
             //var_dump($_SESSION['pw_hinweis']);
            header('location:pw_gesendet');
        }
        break;
}

require 'view/layout.tpl.php';
unset($_SESSION['hinweis']);
?>
