<?php
class DateiVerwaltung
{
    private $db = null;

    function __construct($db)
    {
        $this->db = $db;
    }

    function wandleArrayZuObjekt($dateiArray)
    {
        $datei = new datei();
        $datei->setId($dateiArray['id']);
        $datei->setGehoertZu($dateiArray['gehoertzu']);
        $datei->setDateiname($dateiArray['dateiname']);
        $datei->setDateiname2($dateiArray['dateiname2']);
        $datei->setDateigroesse($dateiArray['dateigroesse']);
        $datei->setDatum($dateiArray['datum']);
        $datei->setAktiv($dateiArray['aktiv']);
        return $datei;
    }

    function wandleSqlZuObjekten($sql, $bedingungen = array())
    {
        $abfrage = $this->db->prepare($sql);
        $abfrage->execute($bedingungen);
        $dateienArray = $abfrage->fetchAll();
        $dateienObjekte = array();
        foreach ($dateienArray as $dateiArray) {
            $dateienObjekte[] = $this->wandleArrayZuObjekt($dateiArray);
        }
        return $dateienObjekte;
    }

    function findeAlle()
    {
        $sql = "SELECT * FROM tbl_dateien";
        return $this->wandleSqlZuObjekten($sql);
    }
   

    function fuegeDateiHinzu(Datei $datei)
    {
        $sql = "INSERT INTO tbl_dateien (id,gehoertzu, dateiname, dateiname2, dateigroesse, datum, aktiv)
                    VALUES (?, ?, ?, ?, ?, ?,?)";
        $abfrage = $this->db->prepare($sql);
        $abfrage->execute(array(
                $datei->getId(),
                $datei->getGehoertZu(),
                $datei->getDateiname(),
                $datei->getDateiname2(),
                $datei->getDateigroesse(),
                $datei->getDatum(),
                $datei->getAktiv()
            ));
    }

    function findeAnhandVonId($id)
    {
        $sql = 'SELECT * FROM tbl_dateien WHERE id=?';
        $abfrage = $this->db->prepare($sql);
        $abfrage->execute(array($id));
        $dateiArray = $abfrage->fetch();
        return $this->wandleArrayZuObjekt($dateiArray);
    }
    function findeLetzteId()
    {
        $sql = 'SELECT * FROM tbl_dateien ORDER BY id DESC limit 1';
        $abfrage = $this->db->prepare($sql);
        $abfrage->execute();
        $dateiArray = $abfrage->fetch();
        return $this->wandleArrayZuObjekt($dateiArray);
    }
    function findeAnhandVonGehoertZu($gehoertzu)
    {
        $sql = 'SELECT * FROM tbl_dateien WHERE gehoertzu=?';
        return $this->wandleSqlZuObjekten($sql, array($gehoertzu));
    }
    function findeAnhandVonGehoertZuUndErgebnisdatei($gehoertzu)
    {
        $sql = 'SELECT * FROM tbl_dateien WHERE gehoertzu=? AND aktiv=2 ORDER BY id ASC';
        return $this->wandleSqlZuObjekten($sql, array($gehoertzu));
    }

    function findeAnhandVonGehoertZuUndAktiv($gehoertzu, $aktiv)
    {
        $sql = 'SELECT * FROM tbl_dateien WHERE gehoertzu=? AND aktiv=? ORDER BY id ASC';
        return $this->wandleSqlZuObjekten($sql, array($gehoertzu, $aktiv));
    }

   function aendereDatei(Datei $datei)
    {
        $sql = "UPDATE tbl_dateien SET gehoertzu=?, dateiname=?, dateiname2=?, dateigroesse=?, datum=?, aktiv=? WHERE id=?";
        $abfrage = $this->db->prepare($sql);
        $daten = array(
            $datei->getGehoertZu(),
            $datei->getDateiname(),
            $datei->getDateiname2(),
            $datei->getDateigroesse(),
            $datei->getDatum(),
            $datei->getAktiv(),
            $datei->getId()
        );
        $abfrage->execute($daten);
        return true;
    }
function setzeDateienAktiv($nummer)
    {
        $sql = "UPDATE tbl_dateien SET aktiv=1 WHERE gehoertzu=?";
        $abfrage = $this->db->prepare($sql);
        $daten = array($nummer);
        $abfrage->execute($daten);
    }
    function speichere(Datei $datei)
    {
        if (!$datei->istValide()) {
            return false;
        }
        /*if ($datei->getId()) {
            $this->aendereDatei($datei);
        } else {*/
            $this->fuegeDateiHinzu($datei);
        /*}
        return true;*/
    }

    function loesche(Datei $datei)
    {
        $sql = "DELETE FROM tbl_dateien WHERE id=?";
        $abfrage = $this->db->prepare($sql);
        $abfrage->execute(array($datei->getId()));
    }
}
?>