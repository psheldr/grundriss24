<?php
class RechnungVerwaltung
{
    private $db = null;

    function __construct($db)
    {
        $this->db = $db;
    }

    function wandleArrayZuObjekt($rechnungArray)
    {
        $rechnung = new Rechnung();
        $rechnung->setId($rechnungArray['id']);
        $rechnung->setGehoertzu($rechnungArray['gehoertzu']);
        $rechnung->setGestellt($rechnungArray['gestellt']);
        $rechnung->setRechnungsnr($rechnungArray['rechnungsnr']);

        return $rechnung;
    }

    function wandleSqlZuObjekten($sql, $bedingungen = array())
    {
        $abfrage = $this->db->prepare($sql);
        $abfrage->execute($bedingungen);
        $rechnungenArray = $abfrage->fetchAll();
        $rechnungenObjekte = array();
        foreach ($rechnungenArray as $rechnungArray) {
            $rechnungenObjekte[] = $this->wandleArrayZuObjekt($rechnungArray);
        }
        return $rechnungenObjekte;
    }

    function findeAlle()
    {
        $sql = "SELECT * FROM tbl_rechnung";
        return $this->wandleSqlZuObjekten($sql);
    }

    function fuegeRechnungHinzu(Rechnung $rechnung)
    {
        $sql = "INSERT INTO tbl_rechnung (gehoertzu, gestellt, rechnungsnr)
                    VALUES (?, ?, ?)";
        $abfrage = $this->db->prepare($sql);
        $abfrage->execute(array(
                $rechnung->getGehoertzu(),
                $rechnung->getGestellt(),
                $rechnung->getRechnungsnr()

            ));
        $rechnung->setId($this->db->lastInsertId());
    }

    function findeAnhandVonId($id)
    {
        $sql = 'SELECT * FROM tbl_rechnung WHERE id=?';
        $abfrage = $this->db->prepare($sql);
        $abfrage->execute(array($id));
        $rechnungArray = $abfrage->fetch();
        return $this->wandleArrayZuObjekt($rechnungArray);
    }
    function findeAnhandVonGehoertzu($gehoertzu)
    {
        $sql = 'SELECT * FROM tbl_rechnung WHERE gehoertzu=?';
        $abfrage = $this->db->prepare($sql);
        $abfrage->execute(array($gehoertzu));
        $rechnungArray = $abfrage->fetch();
        return $this->wandleArrayZuObjekt($rechnungArray);
    }
    function findeLetzteRechnungsnr()
    {
        $sql = 'SELECT * FROM tbl_rechnung ORDER BY rechnungsnr DESC LIMIT 1';
        return $this->wandleSqlZuObjekten($sql);
    }

    function speichere(Rechnung $rechnung)
    {
        if (!$rechnung->istValide()) {
            return false;
        }
        if ($rechnung->getId()) {
            $this->aendereRechnung($rechnung);
        } else {
            $this->fuegeRechnungHinzu($rechnung);
        }
        return true;
    }

function aendereRechnung(Rechnung $rechnung) {
        $sql = "UPDATE tbl_rechnung SET gehoertzu=?, gestellt=?, rechnungsnr=? WHERE id=?";
        $abfrage = $this->db->prepare($sql);
        $daten = array(
            $rechnung->getGehoertzu(),
            $rechnung->getGestellt(),
            $rechnung->getRechnungsnr(),
            $rechnung->getId()
        );
        $abfrage->execute($daten);
        return true;
    }

    function loesche(Rechnung $rechnung)
    {
        $sql = "DELETE FROM tbl_rechnung WHERE id=?";
        $abfrage = $this->db->prepare($sql);
        $abfrage->execute(array($rechnung->getId()));
    }

    function setzeRechnungAufGestellt(Rechnung $rechnung)
    {
        $sql = "UPDATE tbl_rechnung SET gestellt=1 WHERE id=?";
        $abfrage = $this->db->prepare($sql);
        $daten = array($auftrag->getId());
        $abfrage->execute($daten);
    }
}
?>