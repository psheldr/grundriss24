<?php
class User
{
    private $id = 0;
    private $benutzer = '';
    private $login = '';
    private $passwort = '';
    private $firma = '';
    private $strasse = '';
    private $plz = '';
    private $ort = '';
    private $tel = '';
    private $fax = '';
    private $mobil = '';
    private $datum = '';
    private $aktiv = 0;
    private $kundennr = 0;
    private $errors = array();

    function __construct($daten = array())
    {
        if (isset($daten['id'])) {
            $this->setId($daten['id']);
        }
        if (isset($daten['benutzer'])) {
            $this->setBenutzer($daten['benutzer']);
        }
        if (isset($daten['login'])) {
            $this->setLogin($daten['login']);
        }
        if (isset($daten['passwort'])) {
            $this->setPasswort($daten['passwort']);
        }
        if (isset($daten['firma'])) {
            $this->setFirma($daten['firma']);
        }
        if (isset($daten['strasse'])) {
            $this->setStrasse($daten['strasse']);
        }
        if (isset($daten['plz'])) {
            $this->setPlz($daten['plz']);
        }
        if (isset($daten['ort'])) {
            $this->setOrt($daten['ort']);
        }
        if (isset($daten['tel'])) {
            $this->setTel($daten['tel']);
        }
        if (isset($daten['fax'])) {
            $this->setFax($daten['fax']);
        }
        if (isset($daten['mobil'])) {
            $this->setMobil($daten['mobil']);
        }
        if (isset($daten['datum'])) {
            $this->setDatum($daten['datum']);
        }
        if (isset($daten['aktiv'])) {
            $this->setAktiv($daten['aktiv']);
        }
        if (isset($daten['kundennr'])) {
            $this->setKundennr($daten['kundennr']);
        }
    }


// Anfang Setter
    function setId($id)
    {
        $this->id = $id;
    }
    function setBenutzer($benutzer)
    {
        if (empty($benutzer)) {
            $this->errors[] = 'Bitte geben Sie einen Namen an.';
        }
        $this->benutzer = $benutzer;
    }
    function setLogin($login)
    {
        if (empty($login)) {
            $this->errors[] = 'Bitte geben Sie eine Email-Adresse an.';
        }
        $this->login = $login;
    }
    function setPasswort($passwort)
    {
        /*
        if (empty($passwort)) {
            $this->errors[] = 'Bitte geben Sie Ihr gewünschtes Passwort ein.';
        }*/
        $this->passwort = $passwort;
    }
    function setFirma($firma)
    {
        if (empty($firma)) {
            $this->errors[] = 'Bitte geben Sie einen Firmennamen an.';
        }
        $this->firma = $firma;
    }
    function setStrasse($strasse)
    {
        if (empty($strasse)) {
            $this->errors[] = 'Bitte vervollständigen Sie Ihre Adresse: Strasse/Nr. fehlt';
        }
        $this->strasse = $strasse;
    }
    function setPlz($plz)
    {
        if (empty($plz)) {
            $this->errors[] = 'Bitte vervollständigen Sie Ihre Adresse: Postleitzahl fehlt';
        }
        $this->plz = $plz;
    }
    function setOrt($ort)
    {
        if (empty($ort)) {
            $this->errors[] = 'Bitte vervollständigen Sie Ihre Adresse: Ort fehlt';
        }
        $this->ort = $ort;
    }
    function setTel($tel)
    {
        if (empty($tel)) {
            $this->errors[] = 'Bitte hinterlegen Sie eine Telefonnummer.';
        }
        $this->tel = $tel;
    }
    function setFax($fax)
    {
        $this->fax = $fax;
    }
    function setMobil($mobil)
    {
        $this->mobil = $mobil;
    }
    function setDatum($datum)
    {
        $this->datum = $datum;
    }
    function setAktiv($aktiv)
    {
        $this->aktiv = $aktiv;
    }
    function setKundennr($kundennr)
    {
        $this->kundennr = $kundennr;
    }
// Ende Setter

// Anfang Getter
    function getId()
    {
        return $this->id;
    }
    function getBenutzer()
    {
        return $this->benutzer;
    }
    function getLogin()
    {
        return $this->login;
    }
    function getPasswort()
    {
        return $this->passwort;
    }
    function getFirma()
    {
        return $this->firma;
    }
    function getStrasse()
    {
        return $this->strasse;
    }
    function getPlz()
    {
        return $this->plz;
    }
    function getOrt()
    {
        return $this->ort;
    }
    function getTel()
    {
        return $this->tel;
    }
    function getFax()
    {
        return $this->fax;
    }
    function getMobil()
    {
        return $this->mobil;
    }
    function getDatum()
    {
        return $this->datum;
    }
    function getAktiv()
    {
        return $this->aktiv;
    }
    function getKundennr()
    {
        return $this->kundennr;
    }
// Ende Getter

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
