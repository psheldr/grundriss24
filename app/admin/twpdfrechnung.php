<?php

/* >====O-------------------------------------------------O====>\
  |                    ##### t w p d f #####                     |
  |      Copyright (c) by progtw (Thomas Weise), 2005-2007       |
  |                     http://www.progtw.de                     |
  | Dieses Programm ist freie Software. Sie können es unter den  |
  | Bedingungen der GNU General Public License 3 (wie von der    |
  | Free Software Foundation herausgegeben) weitergeben und/oder |
  | modifizieren.                                                |
  | Eine Kopie der Lizenzbedingungen finden Sie in lizenz.txt.   |                                                 |
  \<====O-------------------------------------------------O====< */



///session_start();    ...(ab PHP4.3.3 nicht mehr nötig in Folgeskripten)
error_reporting(E_ALL);

class TwPdfRechnung extends FPDF {

    // Variablen und Arrays
    private $twArrRechnungsdaten = array();
    private $twArrRechnungspositionen = array();
    private $twArrSpaltenbreiten = array();
    private $twArrSpaltenkoepfe = array();

    /* Konstruktor ------------------------------------------------------------ */

    /**
     * Konstruktor
     * @return 
     */
    public function __construct() {

        // Konstruktor der vererbenden Klasse (FPDF) aufrufen
        parent::__construct('P', 'mm', 'A4'); // L=Querformat(Landscape), P=Hochformat(Portrait)
        // Session-Variablen aus dem aufrufenden Skript übernehmen
        $this->twArrRechnungsdaten = $_SESSION['twArrRechnungsdaten'];
        $this->twArrRechnungspositionen = $_SESSION['twArrRechnungspositionen'];

        // Einstellungen für das PDF
        $this->SetDisplayMode(100);         // wie groß wird Seite angezeigt(in %)
        $this->SetAutoPageBreak(true, 70);    // 50mm von unten erfolgt ein Seitenumbruch
        $this->AliasNbPages();                // Anzahl der Seiten berechnen ({nb}-sache)
        // Seite erzeugen
        $this->AddPage();                     // PDF starten (ruft auch Header() und Footer() auf
        // zusätzliche Sachen
        $this->twShowRechnungspositionen();   // Tabelle mit allen Rechnungspositionen
        $this->twShowLetzteSeite();           // nur auf der letzten Seite
    }

    /* Funktionen von FPDF geerbt und hier überschrieben ---------------------- */

    public function Header() {
        // unterteilt in if-Abfragen, ob es eine erste Seite oder Folgeseite(n) ist
        // für alle Seiten gilt:
        if ($this->page > 0) {
            // Farben und Schrift allgemein
            $this->SetFont('Arial', 'B', '12');     // Schrift
            $this->SetTextColor(000, 000, 102);   // Schriftfarbe
            $this->SetFillColor(210);             // Füllungsfarbe (Hintergrund)
            $this->SetDrawColor(000, 000, 102);   // Rahmenfarbe
            $this->SetLineWidth(0.4);             // Rahmenstärke   
            // Hintergrundfarbe und -rahmen des Dokumentes
            $this->SetFillColor(239);
            $this->SetLineWidth(0.6);
            ///$this->twRundeckbereich(22, 10, 179, 277, 4, 'DF');    
            // Linie oben horizontal
            ////$this->SetFillColor(210);
            ////$this->SetLineWidth(0.4);
            ////$this->twRundeckbereich(25, 16, 173, 2, 0.8, 'DF');  // (x, y, breite, höhe, radius, style(D=rahmen F=füllung)
            // Linie rechts vertikal 
            //// $this->twRundeckbereich(193, 13, 2, 270, 0.8, 'DF');
            //// $this->SetFont('Arial','B','12');      
            // Schrift Firmenbezeichnung
            /*  $this->SetTextColor(180);
              $this->SetFont('Arial','B','16');
              $this->SetXY(25, 23);                     // xy linksoben der (folgenden)Cell
              $this->Cell(124, 6, $this->twArrRechnungsdaten['firmaNameZeile01'], 0, 1, 'C');
              $this->SetFont('Arial','B','8');
              $this->SetXY(25, 30);
              $this->Cell(116, 4, $this->twArrRechnungsdaten['firmaNameZeile02'], 0, 1, 'R');
              $this->SetXY(25, 34);
              $this->Cell(119, 4, $this->twArrRechnungsdaten['firmaNameZeile03'], 0, 1, 'R');
              $this->SetFont('Arial','B','12');
              $this->SetTextColor(000, 000, 102);
             */

            $this->SetFont('Arial', 'I', '10');
            $Y = 28;
            $X = 140;
            $this->SetTextColor(000, 000, 102);
            // Adresse
            $this->SetXY($X, $Y);
            $this->Cell(36, 3, $this->twArrRechnungsdaten['firmaAnschriftZeile01'], 0, 1, '');
            $this->SetXY($X, $Y + 4);
            $this->Cell(36, 3, $this->twArrRechnungsdaten['firmaAnschriftZeile02'], 0, 1, '');
            $this->SetXY($X, $Y + 8);
            $this->Cell(36, 3, $this->twArrRechnungsdaten['firmaAnschriftZeile03'], 0, 1, '');
            $this->SetXY($X, $Y + 12);
            $this->Cell(36, 3, $this->twArrRechnungsdaten['firmaAnschriftZeile04'], 0, 1, '');
            //Tel, Fax, Mail, Web

            $this->SetXY($X, $Y + 12);
            $this->Cell(36, 3, 'Tel:    ' . $this->twArrRechnungsdaten['firmaTelefon'], 0, 1, '');
            $this->SetXY($X, $Y + 16);
            $this->Cell(36, 3, 'Fax:   ' . $this->twArrRechnungsdaten['firmaFax'], 0, 1, '');
            $this->SetXY($X, $Y + 20);
            $this->Cell(36, 3, 'Mail: ' . $this->twArrRechnungsdaten['firmaEmail'], 0, 1, '');
            $this->SetXY($X, $Y + 24);
            $this->Cell(36, 3, 'Web: ' . $this->twArrRechnungsdaten['firmaWeb'], 0, 1, '');

            // kleine Linie unter Firmenbezeichnung
            //$pdf->twRundeckbereich(113, 39, 31, 1, 0.4, 'DF');     
            // Box mit Logo
            ////$this->twRundeckbereich(149, 24, 38, 24, 3, 'DF');
            $this->Image('../images/logo.gif', 140, 20);

            //Seitenzahl (zB Seite 1 von 3)     
            $this->SetTextColor(150, 150, 150);
            $this->SetFont('Arial', '', '8');
            $this->SetXY(180, 291);
            $this->AliasNbPages();       // erstmal Anzahl der Seiten berechnen
            $this->Cell(38, 4, 'Seite ' . $this->PageNo() . ' von {nb}', 0, 1, 'C');

            // Faltzeichen (links, 1/3 und 1/2 der Seite)
            /*  $this->SetFillColor(255);
              $this->SetXY(8, 107);
              $this->Cell(6, 0, '', 1, 1, 'C');
              $this->SetXY(8, 150);
              $this->Cell(6, 0, '', 1, 1, 'C');
              $this->SetFillColor(210); */

            // RundBox (wenns letzte Seite ist->Zahlungsbedingungen, sonst Hinweis auf Folgeseite

            $this->SetFillColor(247);
            $this->SetDrawColor(000, 000, 102);
            ////$this->twRundeckbereich(24, 249, 114, 20, 2, 'DF'); 
            // RundBox zur Ausgabe der berechneten Zahlbeträge
            $this->SetTextColor(000);
            $this->SetFillColor(255);
            $this->SetLineWidth(0.8);
            ////  $this->twRundeckbereich(140, 249, 51, 20, 2, 'DF');

            $this->SetY(59);   // wenn mehrseitiges Dokument
        }

        // NUR für die erste Seite gilt:
        if ($this->page == 1) {
            // eigener Absender (kleine Schrift über der (Kunden-)Adresse)
            $this->SetFont('Arial', '', '7');
            $this->SetXY(26, 48);
            $this->Cell(73, 3, $this->twArrRechnungsdaten['firmaAnschrift'], 0, 1, '');
            $this->SetFont('Arial', '', '10');

            // Box für (Kunden-)Adresse
            $this->SetTextColor(000);
            $this->SetFillColor(255);
            //// $this->twRundeckbereich(25, 52, 75, 36, 2, 'DF');
            $this->SetXY(27, 53);
            $this->Cell(71, 6, $this->twArrRechnungsdaten['kundeAnschriftZeile01'], 0, 1, '');
            $this->SetXY(27, 58);
            $this->Cell(71, 6, $this->twArrRechnungsdaten['kundeAnschriftZeile02'], 0, 1, '');
            $this->SetXY(27, 63);
            $this->Cell(71, 6, $this->twArrRechnungsdaten['kundeAnschriftZeile03'], 0, 1, '');
            $this->SetXY(27, 68);
            $this->Cell(71, 6, $this->twArrRechnungsdaten['kundeAnschriftZeile04'], 0, 1, '');
            $this->SetXY(27, 73);
            $this->Cell(71, 6, $this->twArrRechnungsdaten['kundeAnschriftZeile05'], 0, 1, '');
            $this->SetFillColor(210);
            $this->SetTextColor(000, 000, 102);

            // Rechnungsnummer, Kundennummer, Datum
            //Rechnungsnummer
            $this->SetFont('Arial', '', '10');
            $this->SetXY(130, 73);
            $this->Cell(49, 4, 'Rechnungsnummer', 0, 1, 'L');
            $this->SetFont('Arial', 'B', '10');
            $this->SetXY(160, 73);
            $this->Cell(26, 4, $this->twArrRechnungsdaten['rechnungsnummer'], 0, 1, 'R');
            //Kundennummer
            $this->SetFont('Arial', '', '10');
            $this->SetXY(130, 78);
            $this->Cell(49, 4, 'Kundennummer', 0, 1, 'L');
            $this->SetFont('Arial', 'B', '10');
            $this->SetXY(160, 78);
            $this->Cell(26, 4, $this->twArrRechnungsdaten['kundennummer'], 0, 1, 'R');
            //Datum
            $this->SetFont('Arial', '', '10');
            $this->SetXY(130, 83);
            $this->Cell(49, 4, 'Datum', 0, 1, 'L');
            $this->SetFont('Arial', 'B', '10');
            $this->SetXY(160, 83);
            $this->Cell(26, 4, $this->twArrRechnungsdaten['rechnungsdatum'], 0, 1, 'R');

            $this->SetFont('Arial', 'B', '12');

            // Linie unter (Kunden-)Adresse
            //$this->twRundeckbereich(30, 91, 155, 1, 0.4, 'DF');
            // das Wort Rechnung
            $this->SetFont('Arial', 'B', '14');
            $this->SetXY(26, 94);
            $this->Cell(146, 8, 'Rechnung Nr. ' . $this->twArrRechnungsdaten['rechnungsnummer'], 0, 1, 'L');
            $this->SetFont('Arial', 'B', '12');

            // RundBox der Rechnungspositionen (auf erster Seite weiter unten wegen Adressfeld)
            $this->SetFillColor(255);
            //// $this->twRundeckbereich(25, 104, 165, 142, 2, 'DF');
        }

        // für ALLE Seiten AUSSER die erste Seite:    
        if ($this->page > 1) {
            // die RundBox (ab der zweiten Seite weiter oben)
            $this->SetFillColor(255);
            //// $this->twRundeckbereich(25, 56, 165, 191, 2, 'DF');
        }
    }

// ENDE Header()

    public function Footer() {
        // RundBox unten (mit Adress-, Bankangaben usw.)	
        $this->SetFillColor(247);
        $this->SetLineWidth(0.4);
        ///// $this->twRundeckbereich(24, 271, 167, 14, 2.4, 'DF');
        $this->SetFont('Arial', 'I', '8');
        $Y = 270;
        $this->SetTextColor(000, 000, 102);
        // Adresse
        /* $this->SetXY(35, $Y);
          $this->Cell(36, 3, $this->twArrRechnungsdaten['firmaAnschriftZeile01'], 0, 1, '');
          $this->SetXY(35, $Y + 4);
          $this->Cell(36, 3, $this->twArrRechnungsdaten['firmaAnschriftZeile02'], 0, 1, '');
          $this->SetXY(35, $Y + 6);
          $this->Cell(36, 3, $this->twArrRechnungsdaten['firmaAnschriftZeile03'], 0, 1, '');
          $this->SetXY(35, $Y + 8);
          $this->Cell(36, 3, $this->twArrRechnungsdaten['firmaAnschriftZeile04'], 0, 1, '');
          //Tel, Fax, Mail, Web
          $this->SetXY(71, $Y);
          $this->Cell(36, 3, 'Tel:    ' . $this->twArrRechnungsdaten['firmaTelefon'], 0, 1, '');
          $this->SetXY(71, $Y + 4);
          $this->Cell(36, 3, 'Fax:   ' . $this->twArrRechnungsdaten['firmaFax'], 0, 1, '');
          $this->SetXY(71, $Y + 6);
          $this->Cell(36, 3, 'Mail: ' . $this->twArrRechnungsdaten['firmaEmail'], 0, 1, '');
          $this->SetXY(71, $Y + 8);
          $this->Cell(36, 3, 'Web: ' . $this->twArrRechnungsdaten['firmaWeb'], 0, 1, ''); */
        $this->SetXY(130, 245);
        $this->MultiCell(100, 4, utf8_decode($this->twArrRechnungsdaten['impressum']), 0, 1, '');
        $this->SetLineWidth(0.2);
        $this->SetDrawColor(0, 0, 102);
        $this->Line(10, $Y - 3, 200, $Y - 3);
        // Bank        
        $this->SetXY(130, $Y - 1);
        $this->MultiCell(100, 4, utf8_decode($this->twArrRechnungsdaten['impressum_zusatz']), 0, 1, '');
        $this->SetFont('Arial', 'I', '10');
        $this->SetXY(25, $Y);
        $this->Cell(24, 3, 'Bankverbindung:', 0, 1, 'R');
        $this->SetXY(50, $Y);
        $this->Cell(36, 3, $this->twArrRechnungsdaten['firmaBankName'], 0, 1, '');
        $this->SetXY(50, $Y + 5);
        $this->Cell(36, 3, 'IBAN: ' . $this->twArrRechnungsdaten['firmaBankKtonr'], 0, 1, '');
        $this->SetXY(50, $Y + 10);
        $this->Cell(36, 3, 'BIC: ' . $this->twArrRechnungsdaten['firmaBankBlz'], 0, 1, '');
        $this->SetXY(50, $Y + 15);
        $this->Cell(36, 3, $this->twArrRechnungsdaten['firmaUstidnr'], 0, 1, '');
    }

// ENDE Footer()



    /* tw Funktionen private -------------------------------------------------- */

    /**
     * Zeigt eine Tabelle mit den Rechnungspositionen an.
     * benötigt 'twTabelleMitMultiCell'
     */
    private function twShowRechnungspositionen() {

        // Spaltenbreiten und Beschriftung der Spaltenköpfe festlegen
        $this->twSetSpaltenbreiten(array(8, 14, 99, 20, 20));
        $this->twSetSpaltenkoepfe(array('Pos', 'Menge', 'Text', 'Preis EUR', 'Gesamt EUR'));

        // Tabellenköpfe (nur mit Cell) 
        $this->SetFillColor(244);
        $this->SetTextColor(000);
        $this->SetLineWidth(.3);
        $this->SetFont('Arial', '', '9');
        $this->SetXY(27, 106);
        for ($i = 0; $i < count($this->twArrSpaltenkoepfe); $i++) {
            $this->Cell($this->twArrSpaltenbreiten[$i], 7, utf8_decode($this->twArrSpaltenkoepfe[$i]), 1, 0, 'C', 1);
        }
        $this->ln();

        // Tabellenzeilen (mit MultiCell)
        $this->SetFillColor(224, 235, 255);
        $this->SetFont('Arial', '', 10);
        $this->SetXY(27, 113);
        $i = 0;
        foreach ($this->twArrRechnungspositionen as $pos) {
            $i++;
            $this->twShowZeileMitMultiCell(array(
                $i,
                str_replace('.', ',', sprintf("%9.2f", $pos['menge'])),
                $pos['text'],
                str_replace('.', ',', sprintf("%9.2f", $pos['einzelpreis'])),
                str_replace('.', ',', sprintf("%9.2f", $pos['gesamtpreis']))
            ));
            $this->SetX(27);  // sonst gehts immer ganz links los...
        }
        $this->Cell(array_sum($this->twArrSpaltenbreiten), 0, '', 'T');  //Tabellenlinie unten
    }

    /**
     * Wird bei mehreren Seiten nur auf der letzten Seite angezeigtzeigt.
     * Zeigt Zahlungsbedingungen und Zahlbetrag (im Footer) an.
     */
    private function twShowLetzteSeite() {

        $anzahl_positionen = count($this->twArrRechnungspositionen);
        $rechnungs_positionen_chunked = array_chunk($this->twArrRechnungspositionen, 7);
        $anzahl_pos_letzte_seite = count($rechnungs_positionen_chunked[count($rechnungs_positionen_chunked)-1]);
        if ($anzahl_positionen > 7) {
            $calc_Y = 63 + $anzahl_pos_letzte_seite * 15;
        } else {
            $calc_Y = 115 + $anzahl_pos_letzte_seite * 17;
        }
        define('EURO', chr(128));
        // Zahlungsbedingungen
        $this->SetFont('Arial', 'I', '9');
        $this->SetXY(26, $calc_Y);
        $this->SetAutoPageBreak(true, 10);    // Seitenumbruch weiter runter
        $this->MultiCell(110, 3.2, $this->twArrRechnungsdaten['zahlungsbedingungen'], 0, 'L', 0);

        // Zahlbeträge
        //Endbetrag (brutto)
        $this->SetFont('Arial', '', '10');
        $this->SetXY(141, $calc_Y);
        $this->Cell(24, 5, 'Nettobetrag:', 0, 1, 'R');
        $this->SetXY(169, $calc_Y);
        $this->Cell(21, 5, str_replace('.', ',', sprintf("%9.2f " . EURO, $this->twArrRechnungsdaten['rechnungsbetragNetto'])), 0, 1, 'R');
        //Steuer
        $this->SetFont('Arial', '', '10');
        $this->SetXY(141, $calc_Y + 6);
        $this->Cell(24, 5, 'zzgl. 19% MwSt:', 0, 1, 'R');
        $this->SetXY(169, $calc_Y + 6);
        $strWegenKlammer = str_replace('.', ',', sprintf("%9.2f", $this->twArrRechnungsdaten['rechnungsbetragSteuer'])) . " " . EURO;
        $this->Cell(21, 5, $strWegenKlammer, 0, 1, 'R');
        //Endbetrag
        $this->SetFont('Arial', 'B', '12');
        $this->SetXY(141, $calc_Y + 12);
        $strWegenKlammer = "Gesamtbetrag:" . str_replace('.', ',', sprintf("%9.2f", $this->twArrRechnungsdaten['rechnungsbetragBrutto'])) . " " . EURO;
        $this->Cell(49, 5, $strWegenKlammer, 0, 1, 'R');

        $this->SetFont('Arial', 'B', '12');
        $this->SetTextColor(000, 000, 102);
    }

    /* twRundeckbereich START ------------------------------------------------- */

    private function twRundeckbereich($x, $y, $w, $h, $r, $style = '') {
        $twRund = 4 / 3 * (sqrt(2) - 1);
        $k = $this->k;
        $hp = $this->h;
        $this->_out(sprintf('%.2f %.2f m', ($x + $r) * $k, ($hp - $y) * $k));
        // rechts oben
        $xc = $x + $w - $r;
        $yc = $y + $r;
        $this->_out(sprintf('%.2f %.2f l', $xc * $k, ($hp - $y) * $k)); // Line
        $this->twRundeck($xc + $r * $twRund, $yc - $r, $xc + $r, $yc - $r * $twRund, $xc + $r, $yc); // Kurve
        // rechts unten
        $xc = $x + $w - $r;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2f %.2f l', ($x + $w) * $k, ($hp - $yc) * $k));  // Line
        $this->twRundeck($xc + $r, $yc + $r * $twRund, $xc + $r * $twRund, $yc + $r, $xc, $yc + $r); // Kurve
        // links unten
        $xc = $x + $r;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2f %.2f l', $xc * $k, ($hp - ($y + $h)) * $k));  // Line
        $this->twRundeck($xc - $r * $twRund, $yc + $r, $xc - $r, $yc + $r * $twRund, $xc - $r, $yc); // Kurve
        // links oben
        $xc = $x + $r;
        $yc = $y + $r;
        $this->_out(sprintf('%.2f %.2f l', ($x) * $k, ($hp - $yc) * $k));  // Line
        $this->twRundeck($xc - $r, $yc - $r * $twRund, $xc - $r * $twRund, $yc - $r, $xc, $yc - $r); // Kurve

        if ($style == 'F')
            $op = 'f';
        elseif ($style == 'FD' or $style == 'DF')
            $op = 'B';
        else {
            $op = 'S';
        }
        $this->_out($op);
    }

    private function twRundeck($x1, $y1, $x2, $y2, $x3, $y3) {
        // Cubic Bézier Kurve (für Rechteck mit Runden Ecken)
        $h = $this->h;
        $this->_out(sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ', $x1 * $this->k, ($h - $y1) * $this->k, $x2 * $this->k, ($h - $y2) * $this->k, $x3 * $this->k, ($h - $y3) * $this->k));
    }

    /* twRundeckbereich END --------------------------------------------------- */






    /* twTabelleMitMultiCell START ------------------------------------------- */

    /// Tabelle mit MultiCell (siehe: www.fpdf.de/downloads/addons/3/)  
    /// private $twArrSpaltenbreiten; (...oben schon deklariert)
    /// private $twArrSpaltenkoepfe;  (...oben schon deklariert)

    private function twSetSpaltenbreiten($arrSpaltenbreiten) {
        $this->twArrSpaltenbreiten = $arrSpaltenbreiten;
    }

    private function twSetSpaltenkoepfe($arrSpaltenkoepfe) {
        $this->twArrSpaltenkoepfe = $arrSpaltenkoepfe;
    }

    private function twShowZeileMitMultiCell($arrSpalten) {
        $anzSpalten = count($arrSpalten);
        $anzZeilen = 0;   // ... ändert sich
        $zeilenhoehe = 5;   // hier die Zeilenhöhe setzen!
        $hoeheGesamt = 0;   // ... ändert sich
        $spaltenbreite = 0;   // ... ändert sich

        for ($i = 0; $i < $anzSpalten; $i++) {
            $anzZeilen = max($anzZeilen, $this->twHoleAnzahlZeilen($this->twArrSpaltenbreiten[$i], $arrSpalten[$i]));
        }

        $hoeheGesamt = $zeilenhoehe * $anzZeilen;   // für Gesamthöhe aller Zeilen    
        $this->twCheckSeitenumbruch($hoeheGesamt);  // Seitenumbruch, falls nötig
        //zeichnet die Zellen einer Zeile
        for ($i = 0; $i < $anzSpalten; $i++) {
            $spaltenbreite = $this->twArrSpaltenbreiten[$i];  // Spaltenbreite holen
            $x = $this->GetX();                   // aktuelle Position holen (x)
            $y = $this->GetY();                   // aktuelle Position holen (y)
            // den Rahmen und die Inhalte zeichnen
            $this->Rect($x, $y, $spaltenbreite, $hoeheGesamt);
            if ($i == 2) {
                $this->MultiCell($spaltenbreite, $zeilenhoehe, $arrSpalten[$i], 0, 'L');
            } else {
                $this->MultiCell($spaltenbreite, $zeilenhoehe, $arrSpalten[$i], 0, 'R');
            }
            $this->SetXY($x + $spaltenbreite, $y);  // Position (rechts von MultiCell) setzen
        }
        $this->Ln($hoeheGesamt);                //nächste Zeile
    }

    private function twCheckSeitenumbruch($hoehe) {
        // bei Bedarf eine neue Seite erzeugen und Hinweis auf Folgeseite
        if ($this->GetY() + $hoehe > $this->PageBreakTrigger) {
            // Hinweis auf Folgeseite   
            $this->SetXY(20, 230);
            $text01 = "Fortsetzung der Rechnung auf der nächsten Seite";
            $this->SetAutoPageBreak(false);       // Seitenumbruch kurz raus
            $this->MultiCell(110, 3.2, utf8_decode($text01), 0, 'C', 0);
            $this->SetAutoPageBreak(true, 50);    // Seitenumbruch wieder rein  
            // neue Seite
            $this->AddPage($this->CurOrientation);
            $this->SetX(27);
        }
    }

    private function twHoleAnzahlZeilen($breite, $txt) {
        // berechnet die Anzahl der Zeilen der MultiCell bei einer Breite ($breite)
        $cw = &$this->CurrentFont['cw'];
        if ($breite == 0) {
            $breite = $this->w - $this->rMargin - $this->x;
        }
        $wmax = ($breite - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n") {
            $nb--;
        }
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ') {
                $sep = $i;
            }
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) {
                        $i++;
                    }
                } else {
                    $i = $sep + 1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else {
                $i++;
            }
        }
        return $nl;
    }

    /* twTabelleMitMultiCell END --------------------------------------------- */
}

// ENDE der Klasse PDF
/* ACHTUNG: darf kein einziges Leerzeichen hinter '?>' sein (wegen header) !!! */
?>