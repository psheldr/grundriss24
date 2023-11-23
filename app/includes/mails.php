<?php


function sendeNeueRegistrierungsInfo($neuerUser) {
    global $root_path;
require_once $root_path.'/cfg/mail_config.php';
    (string)$strMessage;
    $strMessage = $strMessage .  "ANLEITUNG ZUM KONTAKTHANDLING:" . chr(13);
    $strMessage = $strMessage .  "1. Kontakt über .xml-Datei in FF anlegen" . chr(13);
    $strMessage = $strMessage .  "2. Merkmal auf 'heiß' setzen" . chr(13);
    $strMessage = $strMessage .  "3. Detailseite anlegen und so weit wie möglich ausfüllen" . chr(13);
    $strMessage = $strMessage .  "4. Kontakt kann bearbeitet werden" . chr(13);


    $strMessage = $strMessage . chr(13) . "Neuregistrierung bei grundriss24.de" . chr(13);
    $strMessage = $strMessage . chr(13) . "Name: " . $_SESSION['anrede'] . ' ' . $neuerUser->getBenutzer() . chr(13);
    $strMessage = $strMessage . chr(13) . "Firma: " . $neuerUser->getFirma();
    $strMessage = $strMessage . chr(13) . $neuerUser->getStrasse();
    $strMessage = $strMessage . chr(13) . $neuerUser->getPlz();
    $strMessage = $strMessage .  " " . $neuerUser->getOrt() . chr(13);
    $strMessage = $strMessage . chr(13) . "Telefon: " . $neuerUser->getTel();
    $strMessage = $strMessage . chr(13) . "Mobil: " . $neuerUser->getMobil();
    $strMessage = $strMessage . chr(13) . "Fax: " . $neuerUser->getFax();
    $strMessage = $strMessage . chr(13) . "E-Mail: " . $neuerUser->getLogin() . chr(13);


   $mail = new PHPMailer\PHPMailer\PHPMailer();
      $mail->isSMTP();
    $mail->SetLanguage ("de","phpmailer6/language/");

    $From = "carllouis.rueckerl@kitafino.de";

    $anhang_name = strftime('%d_%m_%Y', time()).'_grundriss_Kontakt.xml';

    require 'create_xml_attach.php';
    $FromName = 'Kundenverwaltung';
    $strMessage = utf8_decode($strMessage);
    $mail->CharSet = "utf-8";
 $mail->Host     = "wp1035944.server-he.de";
	 $mail->SMTPAuth = true;
	 $mail->Username = "wp1035944-versand";
	 $mail->Password = "multiphone";
    $mail->From = $From;
    $mail->FromName = $FromName;
    $mail->Subject = "grundriss24.de - Neuregistrierung";
    $mail->Mailer = "smtp";
    $mail->Body = $strMessage;
    $mail->IsHTML = false;
	$mail->Helo = 'grundriss24';
    $mail->AddAttachment("kontakt.xml", $anhang_name);
    $mail->AddAddress("carllouis.rueckerl@kitafino.de");
  ///  $mail->AddAddress("contact@gmediadesign.com");
   
    $mail->Send();
}

function sendeRegistrierungsBestätigung($neuerUser) {
    global $root_path;
require_once $root_path.'/cfg/mail_config.php';
    (string)$strMessage;
    if($_SESSION['anrede'] == 'Herr') {
        $briefanrede = 'Sehr geehrter ';
    }
    if($_SESSION['anrede'] == 'Frau') {
        $briefanrede = 'Sehr geehrte ';
    }
    $strMessage = $strMessage .  $briefanrede . $_SESSION['anrede'] . ' ' . $_SESSION['nachname'] . ',' . chr(13);
    $strMessage = $strMessage . chr(13) . 'herzlich willkommen bei grundriss24.de. Wir freuen uns auf eine gute Zusammenarbeit.' . chr(13);

    $strMessage = $strMessage . chr(13) . "Sie haben sich am " . $neuerUser->getDatum() . ' auf grundriss24.de mit folgenden Daten registriert:' . chr(13);
    $strMessage = $strMessage . chr(13) . "Name: " . $_SESSION['anrede'] . ' ' . $neuerUser->getBenutzer() . chr(13);
    $strMessage = $strMessage . chr(13) . "Firma: " . $neuerUser->getFirma();
    $strMessage = $strMessage . chr(13) . $neuerUser->getStrasse();
    $strMessage = $strMessage . chr(13) . $neuerUser->getPlz();
    $strMessage = $strMessage .  " " . $neuerUser->getOrt() . chr(13);
    $strMessage = $strMessage . chr(13) . "Telefon: " . $neuerUser->getTel();
    $strMessage = $strMessage . chr(13) . "Mobil: " . $neuerUser->getMobil();
    $strMessage = $strMessage . chr(13) . "Fax: " . $neuerUser->getFax();
    $strMessage = $strMessage . chr(13) . "E-Mail: " . $neuerUser->getLogin() . chr(13);

    $strMessage = $strMessage . chr(13) . "Mit diesen Daten können Sie sich ab sofort auf www.grundriss24.de einloggen: ";
    $strMessage = $strMessage . chr(13) . "E-Mail: " . $neuerUser->getLogin() . chr(13);
    $strMessage = $strMessage . "Passwort: " . $neuerUser->getPasswort() . chr(13);
    $strMessage = $strMessage . chr(13) . "Sie können nun ganz bequem über unsere Internetseite Aufträge erteilen, fertige Aufträge herunterladen und jederzeit Ihre Kontaktdaten falls erforderlich aktualisieren." . chr(13);

    $strMessage = $strMessage . chr(13) . chr(13) . "Mit freundlichen Grüßen";
    $strMessage = $strMessage . chr(13) . "Ihr grundriss24.de Team" . chr(13);
    $strMessage = $strMessage . chr(13) . "grundriss24.de";
    $strMessage = $strMessage . chr(13) .  "ist ein Geschäftsbereich der";
    $strMessage = $strMessage . chr(13) . "multiphone communication center GmbH & Co. KG Allersberger Str. 185/O";
    $strMessage = $strMessage . chr(13) . "90461 Nürnberg";
    $strMessage = $strMessage . chr(13) . "Telefon 0 180 5 / 33 32 35";
    $strMessage = $strMessage . chr(13) . "Telefax 0911 / 46 20 68 62";
    $strMessage = $strMessage . chr(13) . "______________________________________________________________";
    $strMessage = $strMessage . chr(13) . "Sitz der Gesellschaft ist Nürnberg";
    $strMessage = $strMessage . chr(13) . "UST-ID: DE246148075";
    $strMessage = $strMessage . chr(13) . "Amtsgericht Nürnberg, HR-A 13949";
    $strMessage = $strMessage . chr(13) . "Persönlich haftende Gesellschafterin: multiphone Verwaltungs-GmbH Geschäftsführender Gesellschafter:";
    $strMessage = $strMessage . chr(13) . "Dipl.-Betriebswirt (FH) Jürgen Nagel";

   $mail = new PHPMailer\PHPMailer\PHPMailer();
      $mail->isSMTP();
    $mail->SetLanguage ("de","phpmailer6/language/");

    $From = "carllouis.rueckerl@kitafino.de";

    $FromName = 'grundriss24.de Service';

    $mail->CharSet = "utf-8";
     $mail->Host     = "wp1035944.server-he.de";
	 $mail->SMTPAuth = true;
	 $mail->Username = "wp1035944-versand";
	 $mail->Password = "multiphone";
    $mail->From = $From;
    $mail->FromName = $FromName;
    $mail->Subject = "Willkommen bei grundriss24.de";
    $mail->Mailer = "smtp";
    $mail->Body = $strMessage;
    $mail->IsHTML = false;

    $mail->AddAddress($neuerUser->getLogin());
   
    $mail->Send();
}

function sendePasswort($user, $rand_pw = '') {
    global $root_path;
require_once $root_path.'/cfg/mail_config.php';
 (string)$strMessage;


    $strMessage = $strMessage .  'Sehr geehrter Kunde,' . chr(13);
    $strMessage = $strMessage . chr(13) . 'Sie erhalten diese E-Mail, da Sie über unsere Webseite www.grundriss24.de registriert sind und ein neues Passwort angefordert haben.' . chr(13);

    $strMessage = $strMessage . chr(13) . "Ihre Zugangsdaten lauten: " . chr(13);

    $strMessage = $strMessage . chr(13) . "E-Mail: " . $user->getLogin() . chr(13);
    $strMessage = $strMessage . "Passwort: " . $rand_pw /*$user->getPasswort()*/ . chr(13);
 
    $strMessage = $strMessage . chr(13) . chr(13) . "Mit freundlichen Grüßen";
    $strMessage = $strMessage . chr(13) . "Ihr grundriss24.de Team" . chr(13);
    $strMessage = $strMessage . chr(13) . "grundriss24.de";
    $strMessage = $strMessage . chr(13) .  "ist ein Geschäftsbereich der";
    $strMessage = $strMessage . chr(13) . "multiphone communication center GmbH & Co. KG Allersberger Str. 185/O";
    $strMessage = $strMessage . chr(13) . "90461 Nürnberg";
    $strMessage = $strMessage . chr(13) . "Telefon 0 180 5 / 33 32 35";
    $strMessage = $strMessage . chr(13) . "Telefax 0911 / 46 20 68 62";
    $strMessage = $strMessage . chr(13) . "______________________________________________________________";
    $strMessage = $strMessage . chr(13) . "Sitz der Gesellschaft ist Nürnberg";
    $strMessage = $strMessage . chr(13) . "UST-ID: DE246148075";
    $strMessage = $strMessage . chr(13) . "Amtsgericht Nürnberg, HR-A 13949";
    $strMessage = $strMessage . chr(13) . "Persönlich haftende Gesellschafterin: multiphone Verwaltungs-GmbH Geschäftsführender Gesellschafter:";
    $strMessage = $strMessage . chr(13) . "Dipl.-Betriebswirt (FH) Jürgen Nagel";

     
   $mail = new PHPMailer\PHPMailer\PHPMailer();
      $mail->isSMTP();
    $mail->SetLanguage ("de","phpmailer6/language/");

    $From = "carllouis.rueckerl@kitafino.de";

    $FromName = 'grundriss24.de Service';

    $mail->CharSet = "utf-8";
 $mail->Host     = "wp1035944.server-he.de";
	 $mail->SMTPAuth = true;
	 $mail->Username = "wp1035944-versand";
	 $mail->Password = "multiphone";
    $mail->From = $From;
    $mail->FromName = $FromName;
    $mail->Subject = "Ihr Passwort bei Grundriss24";
    $mail->Mailer = "smtp";
    $mail->Body = $strMessage;
    $mail->IsHTML = false;

    $mail->AddAddress($user->getLogin());
    $mail->AddBCC('contact@gmediadesign.com');
    $mail->Send();
}



function sendeAuftragAbgeschlossen($auftrag, $kunde) {
    
    global $root_path;
require_once $root_path.'/cfg/mail_config.php';
    $subject = "Ihr Auftrag " . $auftrag->getAuftragsnummer() . " bei Grundriss24.de";
   $message .= "Sehr geehrte Kundin,\n";
   $message .= "sehr geehrter Kunde,\n\n";
   $message .= "Ihre gestalteten Grundrisse zu Auftragsnummer " . $auftrag->getAuftragsnummer() . " stehen für Sie auf unserer Internetseite bereit.\n";
   $message .= "Zum Download Ihrer Dateien unter http://www.grundriss24.de nutzen Sie bitte Ihren Kundenlogin.\n";
   $message .= "Vielen Dank für Ihren Auftrag.\n\n";
   $message .= "Mit freundlichen Grüßen\n";
   $message .= "Ihr Grundriss24-Team\n\n";
   $message .= "--------------------------\n";
   $message .= "Grundriss24.de\n";
   $message .= "ist ein Geschäftsbereich der\n";
   $message .= "multiphone communication center GmbH & Co. KG\n";
   $message .= "Allersberger Straße 185/O\n";
   $message .= "90461 Nürnberg\n";
   $message .= "Telefon: 0 180 5 / 33 32 35\n";
   $message .= "Telefax: 0911 / 46 20 68 62\n\n\n";
   $message .= "--------------------------\n";
   $message .= "Sitz der Gesellschaft ist Nürnberg\n";
   $message .= "Amtsgericht Nürnberg, HR-A 13949\n";
   $message .= "Persönlich haftende Gesellschafterin: multiphone Verwaltungs-GmbH\n";
   $message .= "Geschäftsführender Gesellschafter:\n";
   $message .= "Dipl.-Betriebswirt (FH) Jürgen Nagel\n";

    
   $mail = new PHPMailer\PHPMailer\PHPMailer();
      $mail->isSMTP();
    $mail->SetLanguage ("de","../phpmailer6/language/");
	 $mail->From = "carllouis.rueckerl@kitafino.de";
	 $mail->FromName = "Grundriss24";
	 $mail->Subject = $subject;
 $mail->Host     = "wp1035944.server-he.de";
	 $mail->SMTPAuth = true;
	 $mail->Username = "wp1035944-versand";
	 $mail->Password = "multiphone";
	 $mail->Mailer = "smtp";
	 $mail->IsHTML = true;
	 $mail->Body = $message;
	 $mail->AddAddress($kunde->getLogin(), $kunde->getBenutzer());
	 $mail->AddBCC('carllouis.rueckerl@kitafino.de');
 
    $mail->Send();
}

function sendeKontaktAnfrage($daten) {
    global $root_path;
require_once $root_path.'/cfg/mail_config.php';

     (string)$strMessage;
     
   $strMessage = $strMessage .  "ANLEITUNG ZUM KONTAKTHANDLING:" . chr(13);
    $strMessage = $strMessage .  "1. Kontakt über .xml-Datei in FF anlegen" . chr(13);
    $strMessage = $strMessage .  "2. Merkmal auf 'heiß' setzen" . chr(13);
    $strMessage = $strMessage .  "3. Detailseite anlegen und so weit wie möglich ausfüllen" . chr(13);
    $strMessage = $strMessage .  "4. Kontakt kann bearbeitet werden" . chr(13);

    $strMessage = $strMessage  . chr(13) . "grundriss24.de - Kontaktanfrage" . chr(13);
    
    $strMessage = $strMessage . chr(13) . "Name: " . $daten['kon_vorname'] . " " . $daten['kon_nachname'];
    $strMessage = $strMessage . chr(13) . "Telefon: " . $daten['kon_tel'];
    $strMessage = $strMessage . chr(13) . "E-Mail: " . $daten['kon_email'] . chr(13);
    $strMessage = $strMessage . chr(13) . "Nachricht: " . chr(13) . $daten['kon_message'] . chr(13);

    $strMessage = $strMessage . chr(13) . "Der Kunde wünscht Rückmeldung per " . $daten['kon_antwort'] . chr(13);
    
    

    /*require_once("phpmailer/class.phpmailer.php");
    require_once("phpmailer/class.smtp.php");*/
    
   $mail = new PHPMailer\PHPMailer\PHPMailer();
      $mail->isSMTP();
      
      
    $mail->SetLanguage ("de","phpmailer6/language/");

    $From = "carllouis.rueckerl@kitafino.de";

    $anhang_name = strftime('%d_%m_%Y', time()).'_grundriss_Kontakt.xml';

    $FromName = 'grundriss24.de Service';
 require 'create_kon_xml_attach.php';

    $strMessage = utf8_decode($strMessage);
    $mail->CharSet = "utf-8";
 $mail->Host     = "wp1035944.server-he.de";
	 $mail->SMTPAuth = true;
	 $mail->Username = "wp1035944-versand";
	 $mail->Password = "multiphone";

    if ($daten['kon_email'] != '') {
        $mail->From = $daten['kon_email'];
    } else {
        $mail->From = 'carllouis.rueckerl@kitafino.de';
    }
    $mail->FromName = $daten['kon_name'];
    $mail->Subject = "Kontaktanfrage grundriss24.de";
    $mail->Mailer = "smtp";
    $mail->Body = $strMessage;
    $mail->IsHTML = false;
	$mail->Helo = 'grundriss24';
    $mail->AddAttachment("kontakt_anfrage.xml", $anhang_name);
    $mail->AddAddress("carllouis.rueckerl@kitafino.de");
  
    $mail->Send();
   

}

function sendeAuftragsBestätigung($auftrag, $kunde) {
    global $root_path;
require_once $root_path.'/cfg/mail_config.php';
    (string)$strMessage;
    if($auftrag->getWeb() == 1) {
        $web = 'Ja';
    } else {
        $web = 'Nein';
    }
    
    $strMessage = $strMessage . $kunde->getBenutzer() . ', vielen Dank für Ihren Auftrag bei grundriss24.de.' . chr(13);

    $strMessage = $strMessage . chr(13) . "Folgender Auftrag wurde von Ihnen am " . $auftrag->getDatum() . ' bei uns in Auftrag gegeben:' . chr(13);
    $strMessage = $strMessage . chr(13) . "Auftragsnummer: " . $auftrag->getAuftragsnummer() . chr(13);
    $strMessage = $strMessage . chr(13) . "Auftragsname: " . $auftrag->getAuftragsname();
    $strMessage = $strMessage . chr(13) . "Design: " . $auftrag->getDesign();
    $strMessage = $strMessage . chr(13) . "Web-Grafiken: " . $web;
    $strMessage = $strMessage . chr(13) . "Holzboden: " . $auftrag->getHolzboden();

    $strMessage = $strMessage . chr(13) . "Zusätzliche Angaben:";
    if ($auftrag->getInfo() == 1) {
        $strMessage = $strMessage . chr(13) . "Mit Objektinformationen";
    }
    if ($auftrag->getBezeichnungen() == 1) {
        $strMessage = $strMessage . chr(13) . "Mit Raumbezeichnungen";
    }
    if ($auftrag->getQm() == 1) {
        $strMessage = $strMessage . chr(13) . "Mit Quadratmeterangaben";
    }
    $strMessage = $strMessage . chr(13) . "Versand der Vorlagen: " . $auftrag->getVersand();
$strMessage = $strMessage . chr(13) . "Bemerkungen: " . $auftrag->getBemerkung();

$strMessage = $strMessage . chr(13) . chr(13) . "Sobald Ihr Auftrag fertiggestellt ist, erhalten Sie eine Mitteilung per E-Mail und können dann die Grundrisse in Ihrem Kundenbereich auf www.grundriss24.de herunterladen.";

    $strMessage = $strMessage . chr(13) . chr(13) . "Mit freundlichen Grüßen";
    $strMessage = $strMessage . chr(13) . "Ihr grundriss24.de Team" . chr(13);
    $strMessage = $strMessage . chr(13) . "grundriss24.de";
    $strMessage = $strMessage . chr(13) .  "ist ein Geschäftsbereich der";
    $strMessage = $strMessage . chr(13) . "multiphone communication center GmbH & Co. KG Allersberger Str. 185/O";
    $strMessage = $strMessage . chr(13) . "90461 Nürnberg";
    $strMessage = $strMessage . chr(13) . "Telefon 0 180 5 / 33 32 35";
    $strMessage = $strMessage . chr(13) . "Telefax 0911 / 46 20 68 62";
    $strMessage = $strMessage . chr(13) . "______________________________________________________________";
    $strMessage = $strMessage . chr(13) . "Sitz der Gesellschaft ist Nürnberg";
    $strMessage = $strMessage . chr(13) . "UST-ID: DE246148075";
    $strMessage = $strMessage . chr(13) . "Amtsgericht Nürnberg, HR-A 13949";
    $strMessage = $strMessage . chr(13) . "Persönlich haftende Gesellschafterin: multiphone Verwaltungs-GmbH Geschäftsführender Gesellschafter:";
    $strMessage = $strMessage . chr(13) . "Dipl.-Betriebswirt (FH) Jürgen Nagel";


   $mail = new PHPMailer\PHPMailer\PHPMailer();
      $mail->isSMTP();
    $mail->SetLanguage ("de","phpmailer6/language/");

    $From = "carllouis.rueckerl@kitafino.de";

 

    $FromName = 'grundriss24.de Service';

    $mail->CharSet = "utf-8";
 $mail->Host     = "wp1035944.server-he.de";
	 $mail->SMTPAuth = true;
	 $mail->Username = "wp1035944-versand";
	 $mail->Password = "multiphone";
    $mail->From = $From;
    $mail->FromName = $FromName;
    $mail->Subject = "Auftragsbestätigung grundriss24.de";
    $mail->Mailer = "smtp";
    $mail->Body = $strMessage;
    $mail->IsHTML = false;

   
    $mail->AddAddress($kunde->getLogin());
    $mail->Send();
}

function sendeNeuerAuftragInfo($auftrag, $kunde) {
    global $root_path;
require_once $root_path.'/cfg/mail_config.php';
  $strMessage = $strMessage . "Auftragsnummer: " . $auftrag->getAuftragsnummer();
    $strMessage = $strMessage . chr(13) . "Auftragsname: " . $auftrag->getAuftragsname();
    $strMessage = $strMessage . chr(13) . "Kunde: " . $kunde->getFirma() . ', ' . $kunde->getBenutzer();
    $strMessage = $strMessage . chr(13) . "Straße: " . $kunde->getStrasse();
    $strMessage = $strMessage . chr(13) . "PLZ/Ort: " . $kunde->getPlz() . ' ' . $kunde->getOrt();
    $strMessage = $strMessage . chr(13) . "Telefon: " . $kunde->getTel() . ', ' . $kunde->getMobil();
    $strMessage = $strMessage . chr(13) . "E-Mail: " . $kunde->getLogin();
    $strMessage = $strMessage . chr(13) . "Web-Grafiken: " . $web;
    $strMessage = $strMessage . chr(13) . "Design: " . $auftrag->getDesign();
    $strMessage = $strMessage . chr(13) . "Holzboden: " . $auftrag->getHolzboden();

    $strMessage = $strMessage . chr(13) . "Zusätzliche Angaben:";
    if ($auftrag->getInfo() == 1) {
        $strMessage = $strMessage . chr(13) . "Mit Objektinformationen";
    }
    if ($auftrag->getBezeichnungen() == 1) {
        $strMessage = $strMessage . chr(13) . "Mit Raumbezeichnungen";
    }
    if ($auftrag->getQm() == 1) {
        $strMessage = $strMessage . chr(13) . "Mit Quadratmeterangaben";
    }
    $strMessage = $strMessage . chr(13) . "Versand der Vorlagen: " . $auftrag->getVersand();
$strMessage = $strMessage . chr(13) . "Bemerkungen: " . $auftrag->getBemerkung();


   $mail = new PHPMailer\PHPMailer\PHPMailer();
      $mail->isSMTP();
      
    $mail->SetLanguage ("de","phpmailer6/language/");

    $From = "carllouis.rueckerl@kitafino.de";



    $FromName = 'grundriss24.de Service';

    $mail->CharSet = "utf-8";
 $mail->Host     = "wp1035944.server-he.de";
	 $mail->SMTPAuth = true;
	 $mail->Username = "wp1035944-versand";
	 $mail->Password = "multiphone";
    $mail->From = $From;
    $mail->FromName = $FromName;
    $mail->Subject = "Neuer Auftrag grundriss24.de";
    $mail->Mailer = "smtp";
    $mail->Body = $strMessage;
    $mail->IsHTML = false;
	$mail->Helo = 'grundriss24';
   // $mail->AddAddress("carllouis.rueckerl@kitafino.de");
   $mail->AddAddress("glaesser@kitafino.de");
    $mail->AddBCC("carllouis.rueckerl@kitafino.de");
    $mail->Send();

}
function sendeAngebotsAnfrage($auftrag, $kunde) {
    global $root_path;
require_once $root_path.'/cfg/mail_config.php';
    (string)$strMessage;

    $strMessage = $strMessage .'Neue Angebots-Anfrage:' . chr(13);
    $strMessage = $strMessage . 'Firma:' . $kunde->getFirma()  . chr(13);
    $strMessage = $strMessage . 'Benutzer: ' . $kunde->getBenutzer() . chr(13);

    $strMessage = $strMessage . chr(13) . "Eingegangen am " . $auftrag->getDatum() . chr(13);
    $strMessage = $strMessage . chr(13) . "Vergebene Auftragsnummer: " . $auftrag->getAuftragsnummer() . chr(13);
    $strMessage = $strMessage . chr(13) . "Design: " . $auftrag->getDesign();


$strMessage = $strMessage . chr(13) . "Bemerkungen: " . $auftrag->getBemerkung();


    $strMessage = $strMessage . chr(13) . chr(13) . "Mit freundlichen Grüßen";
    $strMessage = $strMessage . chr(13) . "Ihr grundriss24.de Team" . chr(13);
    $strMessage = $strMessage . chr(13) . "grundriss24.de";
    $strMessage = $strMessage . chr(13) .  "ist ein Geschäftsbereich der";
    $strMessage = $strMessage . chr(13) . "multiphone communication center GmbH & Co. KG Allersberger Str. 185/O";
    $strMessage = $strMessage . chr(13) . "90461 Nürnberg";
    $strMessage = $strMessage . chr(13) . "Telefon 0 180 5 / 33 32 35";
    $strMessage = $strMessage . chr(13) . "Telefax 0911 / 46 20 68 62";
    $strMessage = $strMessage . chr(13) . "______________________________________________________________";
    $strMessage = $strMessage . chr(13) . "Sitz der Gesellschaft ist Nürnberg";
    $strMessage = $strMessage . chr(13) . "UST-ID: DE246148075";
    $strMessage = $strMessage . chr(13) . "Amtsgericht Nürnberg, HR-A 13949";
    $strMessage = $strMessage . chr(13) . "Persönlich haftende Gesellschafterin: multiphone Verwaltungs-GmbH Geschäftsführender Gesellschafter:";
    $strMessage = $strMessage . chr(13) . "Dipl.-Betriebswirt (FH) Jürgen Nagel";

 
   $mail = new PHPMailer\PHPMailer\PHPMailer();
      $mail->isSMTP();    
    $mail->SetLanguage ("de","phpmailer6/language/");

    $From = $kunde->getLogin();
$From = "carllouis.rueckerl@kitafino.de";


    $FromName = $kunde->getBenutzer();

    $mail->CharSet = "utf-8";
 $mail->Host     = "wp1035944.server-he.de";
	 $mail->SMTPAuth = true;
	 $mail->Username = "wp1035944-versand";
	 $mail->Password = "multiphone";
    $mail->From = $From;
    $mail->FromName = $FromName;
    $mail->Subject = "Angebotsanfrage grundriss24.de";
    $mail->Mailer = "smtp";
    $mail->Body = $strMessage;
    $mail->IsHTML = false;
	$mail->Helo = 'grundriss24';

    $mail->AddAddress("carllouis.rueckerl@kitafino.de");
  
    $mail->Send();
}
?>
