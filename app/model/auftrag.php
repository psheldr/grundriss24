<?php
class Auftrag
{
    private $id = 0;
    private $gehoertzu = 0;
    private $auftragsnummer = 0;
    private $auftragsname = '';
    private $web = 0;
    private $design = '';
    private $holzboden = '';
    private $info = 0;
    private $bezeichnungen = 0;
    private $qm = 0;
    private $ansprechpartner = '';
    private $gutscheincode = '';
    private $versand = '';
    private $bemerkung = '';
    private $rechnung = 0;
    private $bearbeiter = '';
    private $status = 0;
    private $abgeschlossen = '';
    private $datum = '';
    private $aktiv = 0;
    private $anzahl = 0;
    private $aenderungen = 0;
    private $errors = array();

// Construct
    function __construct($daten = array())
    {
        if (isset($daten['id'])) {
            $this->setId($daten['id']);
        }
        if (isset($daten['gehoertzu'])) {
            $this->setGehoertZu($daten['gehoertzu']);
        }
        if (isset($daten['auftragsnummer'])) {
            $this->setAuftragsnummer($daten['auftragsnummer']);
        }
        if (isset($daten['auftragsname'])) {
            $this->setAuftragsname($daten['auftragsname']);
        }
        if (isset($daten['web'])) {
            $this->setWeb($daten['web']);
        }
        if (isset($daten['design'])) {
            $this->setDesign($daten['design']);
        }
        if (isset($daten['holzboden'])) {
            $this->setHolzboden($daten['holzboden']);
        }
        if (isset($daten['info'])) {
            $this->setInfo($daten['info']);
        }
        if (isset($daten['bezeichnungen'])) {
            $this->setBezeichnungen($daten['bezeichnungen']);
        }
        if (isset($daten['qm'])) {
            $this->setQm($daten['qm']);
        }
        if (isset($daten['ansprechpartner'])) {
            $this->setAnsprechpartner($daten['ansprechpartner']);
        }
        if (isset($daten['gutscheincode'])) {
            $this->setGutscheincode($daten['gutscheincode']);
        }
        if (isset($daten['versand'])) {
            $this->setVersand($daten['versand']);
        }
        if (isset($daten['bemerkung'])) {
            $this->setBemerkung($daten['bemerkung']);
        }
        if (isset($daten['rechnung'])) {
            $this->setRechnung($daten['rechnung']);
        }
        if (isset($daten['bearbetier'])) {
            $this->setBearbeiter($daten['bearbetier']);
        }
        if (isset($daten['status'])) {
            $this->setStatus($daten['status']);
        }
        if (isset($daten['abgeschlossen'])) {
            $this->setAbgeschlossen($daten['abgeschlossen']);
        }
        if (isset($daten['datum'])) {
            $this->setDatum($daten['datum']);
        }
        if (isset($daten['aktiv'])) {
            $this->setAktiv($daten['aktiv']);
        }
        if (isset($daten['anzahl'])) {
            $this->setAnzahl($daten['anzahl']);
        }
        if (isset($daten['aenderungen'])) {
            $this->setAnzahl($daten['aenderungen']);
        }
    }
//Ende construct

//Beginn Setter
    function setId($id)
    {
        $this->id = $id;
    }
    function setGehoertZu($gehoertzu)
    {
        $this->gehoertzu = $gehoertzu;
    }
    function setAuftragsnummer($auftragsnummer)
    {
        $this->auftragsnummer = $auftragsnummer;
    }
    function setAuftragsname($auftragsname)
    {
        if (empty($auftragsname)) {
            $this->errors[] = 'Bitte geben Sie einen Namen an!';
        }
        $this->auftragsname = $auftragsname;
    }
    function setWeb($web)
    {
        $this->web = $web;
    }
    function setDesign($design)
    {
        
        if (!$design) {
            $this->errors[] = 'Bitte wählen Sie ein Design!';
        }
        $this->design = $design;
    }
    function setHolzboden($holzboden)
    {
        $this->holzboden = $holzboden;
    }
    function setInfo($info)
    {
        $this->info = $info;
    }
    function setBezeichnungen($bezeichnungen)
    {
        $this->bezeichnungen = $bezeichnungen;
    }
    function setQm($qm)
    {
        $this->qm = $qm;
    }
    function setAnsprechpartner($ansprechpartner)
    {
        $this->ansprechpartner = $ansprechpartner;
    }
    function setGutscheincode($gutscheincode)
    {
        $this->gutscheincode = $gutscheincode;
    }
    function setVersand($versand)
    {
        
        $this->versand = $versand;
    }
    function setBemerkung($bemerkung)
    {
        $this->bemerkung = $bemerkung;
    }
    function setRechnung($rechnung)
    {
        $this->rechnung = $rechnung;
    }
    function setBearbeiter($bearbeiter)
    {
        $this->bearbeiter = $bearbeiter;
    }
    function setStatus($status)
    {
        $this->status = $status;
    }
    function setAbgeschlossen($abgeschlossen)
    {
        $this->abgeschlossen = $abgeschlossen;
    }
    function setDatum($datum)
    {
        $this->datum = $datum;
    }
    function setAktiv($aktiv)
    {
        $this->aktiv = $aktiv;
    }
    function setAnzahl($anzahl)
    {
        $this->anzahl = $anzahl;
    }
    function setAenderungen($aenderungen)
    {
        $this->aenderungen = $aenderungen;
    }
//Ende Setter

//Beginn Getter
    function getId()
    {
        return $this->id;
    }
    function getGehoertZu()
    {
        return $this->gehoertzu;
    }
    function getAuftragsnummer()
    {
        return $this->auftragsnummer;
    }
    function getAuftragsname()
    {
        return $this->auftragsname;
    }
    function getWeb()
    {
        return $this->web;
    }
    function getDesign()
    {
        return $this->design;
    }
    function getHolzboden()
    {
        return $this->holzboden;
    }
    function getInfo()
    {
        return $this->info;
    }
    function getBezeichnungen()
    {
        return $this->bezeichnungen;
    }
    function getQm()
    {
        return $this->qm;
    }
    function getAnsprechpartner()
    {
        return $this->ansprechpartner;
    }
    function getGutscheincode()
    {
        return $this->gutscheincode;
    }
    function getVersand()
    {
        return $this->versand;
    }
    function getBemerkung()
    {
        return $this->bemerkung;
    }
    function getRechnung()
    {
        return $this->rechnung;
    }
    function getBearbeiter()
    {
        return $this->bearbeiter;
    }
    function getStatus()
    {
        return $this->status;
    }
    function getAbgeschlossen()
    {
        return $this->abgeschlossen;
    }
    function getDatum()
    {
        return $this->datum;
    }
    function getAktiv()
    {
        return $this->aktiv;
    }
    function getAnzahl()
    {
        return $this->anzahl;
    }
    function getAenderungen()
    {
        return $this->aenderungen;
    }
//Ende Getter



//Error Check
    function istValide()
    {
        return empty($this->errors);
    }
    function zeigeFehler()
    {
        return implode('<br />', $this->errors);
    }
}
?>
