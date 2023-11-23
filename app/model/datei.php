<?php
class Datei
{
    private $id = 0;
    private $gehoertzu = 0;
    private $dateiname = '';
    private $dateiname2 = '';
    private $dateigroesse = '';
    private $datum = '';
    private $aktiv = 0;
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
        if (isset($daten['dateiname'])) {
            $this->setDateiname($daten['dateiname']);
        }
        if (isset($daten['dateiname2'])) {
            $this->setDateiname2($daten['dateiname2']);
        }
        if (isset($daten['dateigroesse'])) {
            $this->setDateigroesse($daten['dateigroesse']);
        }
        if (isset($daten['datum'])) {
            $this->setDatum($daten['datum']);
        }
        if (isset($daten['aktiv'])) {
            $this->setAktiv($daten['aktiv']);
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
    function setDateiname($dateiname)
    {
        $this->dateiname = $dateiname;
    }
    function setDateiname2($dateiname2)
    {
        $this->dateiname2 = $dateiname2;
    }
    function setDateigroesse($dateigroesse)
    {
        $this->dateigroesse = $dateigroesse;
    }
    function setDatum($datum)
    {
        $this->datum = $datum;
    }
    function setAktiv($aktiv)
    {
        $this->aktiv = $aktiv;
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
    function getDateiname()
    {
        return $this->dateiname;
    }
    function getDateiname2()
    {
        return $this->dateiname2;
    }
    function getDateigroesse()
    {
        return $this->dateigroesse;
    }
    function getDatum()
    {
        return $this->datum;
    }
    function getAktiv()
    {
        return $this->aktiv;
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
