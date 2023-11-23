<?php
class Rechnung
{
    private $id = 0;
    private $gehoertzu = 0;
    private $gestellt = 0;
    private $rechnungsnr = 0;
    private $errors = array();

//Construct
    function __construct($daten = array())
    {
        if (isset($daten['id'])) {
            $this->setId($daten['id']);
        }
        if (isset($daten['gehoertzu'])) {
            $this->setGehoertzu($daten['gehoertzu']);
        }
        if (isset($daten['gestellt'])) {
            $this->setGestellt($daten['gestellt']);
        }
        if (isset($daten['rechnungsnr'])) {
            $this->setRechnungsnr($daten['rechnungsnr']);
        }
    }
//Ende construct

//Beginn Setter
    function setId($id)
    {
        $this->id = $id;
    }
    function setGehoertzu($gehoertzu)
    {
        $this->gehoertzu = $gehoertzu;
    }
    function setGestellt($gestellt)
    {
        $this->gestellt = $gestellt;
    }
    function setRechnungsnr($rechnungsnr)
    {
        $this->rechnungsnr = $rechnungsnr;
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
    function getGestellt()
    {
        return $this->gestellt;
    }
    function getRechnungsnr()
    {
        return $this->rechnungsnr;
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
