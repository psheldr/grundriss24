<?php
class Protokoll
{
    private $id = 0;
    private $datum = '';
    private $login = '';
    private $vorgang = '';
    private $beschreibung = '';
    private $errors = array();

//Construct
    function __construct($daten = array())
    {
        if (isset($daten['id'])) {
            $this->setId($daten['id']);
        }
        if (isset($daten['datum'])) {
            $this->setDatum($daten['datum']);
        }
        if (isset($daten['login'])) {
            $this->setLogin($daten['login']);
        }
        if (isset($daten['vorgang'])) {
            $this->setVorgang($daten['vorgang']);
        }
        if (isset($daten['beschreibung'])) {
            $this->setBeschreibung($daten['beschreibung']);
        }
    }
//Ende construct

//Beginn Setter
    function setId($id)
    {
        $this->id = $id;
    }
    function setDatum($datum)
    {
        $this->datum = $datum;
    }
    function setLogin($login)
    {
        $this->login = $login;
    }
    function setVorgang($vorgang)
    {
        $this->vorgang = $vorgang;
    }
    function setBeschreibung($beschreibung)
    {
        $this->beschreibung = $beschreibung;
    }
//Ende Setter

//Beginn Getter
    function getId()
    {
        return $this->id;
    }
    function getDatum()
    {
        return $this->datum;
    }
    function getLogin()
    {
        return $this->login;
    }
    function getVorgang()
    {
        return $this->vorgang;
    }
    function getBeschreibung()
    {
        return $this->beschreibung;
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
