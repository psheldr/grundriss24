<?php



$kontaktXML = '<?xml version="1.0" encoding="utf-8" ?>';
$kontaktXML .= '<openimmo_feedback><sender><name>multiphone</name><openimmo_anid />';
$kontaktXML .=    '<datum>'.strftime('%d.%m.%Y',time()).'</datum>';
 $kontaktXML .=     '<makler_id /></sender><objekt><portal_unique_id />
      <portal_obj_id />
      <anbieter_id />
      <oobj_id />
      <zusatz_refnr />
      <expose_url />
      <vermarktungsart />
      <bezeichnung />
      <etage />
      <whg_nr />
      <strasse />
      <ort />
      <preis />
      <gebot />
      <wae />
      <user_defined_extend />
        <interessent>
          <int_id />';
   $kontaktXML .= '<anrede>'.$_SESSION['anrede'].'</anrede>';
         $kontaktXML .= '   <vorname>' . $_SESSION['vorname'] .'</vorname>';
         $kontaktXML .= '   <nachname>' . $_SESSION['nachname'] .'</nachname>';
          $kontaktXML .= '  <firma>'. $neuerUser->getFirma() .'</firma>';
           $kontaktXML .= ' <strasse>'. $neuerUser->getStrasse() .'</strasse>';
          $kontaktXML .= '  <postfach />';
          $kontaktXML .= '  <plz>'. $neuerUser->getPlz() .'</plz>';
         $kontaktXML .= '   <ort>'. $neuerUser->getOrt() .'</ort>';
          $kontaktXML .= '  <tel>'. $neuerUser->getTel() .'</tel>';
         $kontaktXML .= '   <fax>'. $neuerUser->getFax() .'</fax>';
         $kontaktXML .= '   <mobil>'. $neuerUser->getMobil() .'</mobil>';
         $kontaktXML .= '   <email>'. $neuerUser->getLogin() .'</email>';

      $kontaktXML .= '    <bevorzugt>TEL</bevorzugt>
          <wunsch>DETAIL</wunsch>
          <anfrage>Testnotiz</anfrage>
          <user_defined_extend>
            <feld>
              <name />
              <wert />
            </feld>
          </user_defined_extend>
          <user_defined_extend>
            <feld>
              <name />
              <wert />
            </feld>
        </user_defined_extend>
      </interessent>
    </objekt></openimmo_feedback>';



function writeData($pFile, $pData, $pMode) {

        if($pMode == "w"){
            if($file = fopen($pFile, "w+")) {


                fwrite($file, $pData);
                fclose($file);
                return TRUE;
            } else {
                return FALSE;
            }
        }elseif($pMode == "a"){
            if($file = fopen($pFile, "a")) {
               fwrite($file, $pData);
                fclose($file);
                return TRUE;
            } else {
                 return FALSE;
            }
        }
    }

if(!writeData("kontakt.xml",  $kontaktXML, "w")) { echo "Beim schreiben der Datei ist ein Fehler aufgetreten!";}



?>