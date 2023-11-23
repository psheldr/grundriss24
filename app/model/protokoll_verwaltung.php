<?php
class ProtokollVerwaltung
{
    private $db = null;

    function __construct($db)
    {
        $this->db = $db;
    }

    function wandleArrayZuObjekt($protokollArray)
    {
        $protokoll = new protokoll();
        $protokoll->setId($dateiArray['id']);
        $protokoll->setDatum($dateiArray['datum']);
        $protokoll->setLogin($dateiArray['login']);
        $protokoll->setVorgang($dateiArray['vorgang']);
        $protokoll->setBeschreibung($dateiArray['beschreibung']);
        return $protokoll;
    }

    function wandleSqlZuObjekten($sql, $bedingungen = array())
    {
        $abfrage = $this->db->prepare($sql);
        $abfrage->execute($bedingungen);
        $protokolleArray = $abfrage->fetchAll();
        $protokolleObjekte = array();
        foreach ($protokolleArray as $protokollArray) {
            $protokolleObjekte[] = $this->wandleArrayZuObjekt($protokollArray);
        }
        return $protokolleObjekte;
    }

    function findeAlle()
    {
        $sql = "SELECT * FROM tbl_protokoll";
        return $this->wandleSqlZuObjekten($sql);
    }

    function fuegeProtokollHinzu(Protokoll $protokoll)
    {
        $sql = "INSERT INTO tbl_protokoll (datum, login, vorgang, beschreibung)
                    VALUES (?, ?, ?, ?)";
        $abfrage = $this->db->prepare($sql);
        $abfrage->execute(array(
                $protokoll->getDatum(),
                $protokoll->getLogin(),
                $protokoll->getVorgang(),
                $protokoll->getBeschreibung()
            ));
        $protokoll->setId($this->db->lastInsertId());
    }

    function findeAnhandVonId($id)
    {
        $sql = 'SELECT * FROM tbl_protokoll WHERE id=?';
        $abfrage = $this->db->prepare($sql);
        $abfrage->execute(array($id));
        $protokollArray = $abfrage->fetch();
        return $this->wandleArrayZuObjekt($protokollArray);
    }
    function findeAnhandVonLogin($login)
    {
        $sql = 'SELECT * FROM tbl_protokoll WHERE login=?';
        return $this->wandleSqlZuObjekten($sql, array($login));
    }

    function speichere(Protokoll $protokoll)
    {
        if (!$protokoll->istValide()) {
            return false;
        }
        if ($protokoll->getId()) {
            $this->aendereProtokoll($protokoll);
        } else {
            $this->fuegeProtokollHinzu($protokoll);
        }
        return true;
    }

    function loesche(Protokoll $protokoll)
    {
        $sql = "DELETE FROM tbl_protokoll WHERE id=?";
        $abfrage = $this->db->prepare($sql);
        $abfrage->execute(array($protokoll->getId()));
    }
}
?>