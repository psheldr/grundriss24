<?php
class AuftragVerwaltung
{
    private $db = null;

    function __construct($db)
    {
        $this->db = $db;
    }

    function wandleArrayZuObjekt($auftragArray)
    {
        $auftrag = new Auftrag($auftragArray);

        return $auftrag;
    }

    function wandleSqlZuObjekten($sql, $bedingungen = array())
    {
        
        $abfrage = $this->db->prepare($sql);
        $abfrage->execute($bedingungen);
        $auftraegeArray = $abfrage->fetchAll();
        $auftraegeObjekte = array();
        foreach ($auftraegeArray as $auftragArray) {
            $auftraegeObjekte[] = $this->wandleArrayZuObjekt($auftragArray);
        }
        return $auftraegeObjekte;
    }

    function findeAlle($limit = 20)
    {
        if ($limit == '') {
            $limit = 20;
        }
        $sql = "SELECT * FROM tbl_auftraege WHERE aktiv > 0 ORDER BY id DESC LIMIT $limit";
        return $this->wandleSqlZuObjekten($sql);
    }


    function findeAlleOffenen()
    {

        $sql = "SELECT * FROM tbl_auftraege WHERE aktiv = 9 AND rechnung != 1 ORDER BY auftragsnummer DESC";
        return $this->wandleSqlZuObjekten($sql);
    }

    function findeAlleAktiven()
    {
        
        $sql = "SELECT * FROM tbl_auftraege WHERE aktiv = 1 AND status!=9 ORDER BY id DESC";
        return $this->wandleSqlZuObjekten($sql);
    }

       function findeAlleAktivenAngebotsAnfragen()
    {

        $sql = "SELECT * FROM tbl_auftraege WHERE aktiv = 1 AND status = 9 ORDER BY id DESC";
        return $this->wandleSqlZuObjekten($sql);
    }

    function findeAlleMahnung3ZuKunde($gehoertzu)
    {

        $sql = "SELECT * FROM tbl_auftraege WHERE rechnung = 4 AND aktiv > 0 AND gehoertzu=? ORDER BY id DESC";
        return $this->wandleSqlZuObjekten($sql, array($gehoertzu));

    }

function findeAlleAktivenAngebotsAnfragenZuKunde($gehoertzu)
    {

        $sql = "SELECT * FROM tbl_auftraege WHERE aktiv = 1 AND status = 9 AND gehoertzu=? ORDER BY id DESC";
        return $this->wandleSqlZuObjekten($sql, array($gehoertzu));

    }
    function findeAlleErledigten($limit)
    {
        
        $sql = "SELECT * FROM tbl_auftraege WHERE aktiv = 9 ORDER BY id DESC LIMIT $limit";
        return $this->wandleSqlZuObjekten($sql);
    }

    function fuegeAuftragHinzu(Auftrag $auftrag)
    {
        $sql = "INSERT INTO tbl_auftraege (id, gehoertzu, auftragsnummer, auftragsname, web, design, holzboden, info, bezeichnungen, qm, ansprechpartner, gutscheincode, versand, bemerkung, rechnung, bearbeiter, status, abgeschlossen, datum, aktiv, anzahl, aenderungen)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $abfrage = $this->db->prepare($sql);
        $abfrage->execute(array(
                $auftrag->getId(),
                $auftrag->getGehoertZu(),
                $auftrag->getAuftragsnummer(),
                $auftrag->getAuftragsname(),
                $auftrag->getWeb(),
                $auftrag->getDesign(),
                $auftrag->getHolzboden(),
                $auftrag->getInfo(),
                $auftrag->getBezeichnungen(),
                $auftrag->getQm(),
                $auftrag->getAnsprechpartner(),
                $auftrag->getGutscheincode(),
                $auftrag->getVersand(),
                $auftrag->getBemerkung(),
                $auftrag->getRechnung(),
                $auftrag->getBearbeiter(),
                $auftrag->getStatus(),
                $auftrag->getAbgeschlossen(),
                $auftrag->getDatum(),
                $auftrag->getAktiv(),
                $auftrag->getAnzahl(),
                $auftrag->getAenderungen()
            ));
    }

    function findeAnhandVonId($id)
    {
        $sql = 'SELECT * FROM tbl_auftraege WHERE id=?';
        $abfrage = $this->db->prepare($sql);
        $abfrage->execute(array($id));
        $auftragArray = $abfrage->fetch();
        return $this->wandleArrayZuObjekt($auftragArray);
    }


    function findeLetzteId()
    {

        $sql = "SELECT * FROM tbl_auftraege ORDER BY id DESC LIMIT 1";
        $abfrage = $this->db->prepare($sql);
        $abfrage->execute();
        $auftragArray = $abfrage->fetch();
        return $this->wandleArrayZuObjekt($auftragArray);
    }
    function findeLetzteAuftragsnummer()
    {

        $sql = "SELECT * FROM tbl_auftraege ORDER BY auftragsnummer DESC LIMIT 1";
        $abfrage = $this->db->prepare($sql);
        $abfrage->execute();
        $auftragArray = $abfrage->fetch();
        return $this->wandleArrayZuObjekt($auftragArray);
    }


    function findeAlleOhneRechnungZuUser($gehoertzu)
    {
        $sql = 'SELECT * FROM tbl_auftraege WHERE gehoertzu=?  AND status = 4 AND aktiv = 9 AND rechnung = 0 ORDER BY id ASC';
        return $this->wandleSqlZuObjekten($sql, array($gehoertzu));
    }
    

    function findeAlleOhneRechnungZuUser2($gehoertzu)
    {
        $sql = 'SELECT * FROM tbl_auftraege a, tbl_rechnung r  WHERE a.id = r.gehoertzu AND a.gehoertzu=?  AND a.status = 4 AND a.aktiv = 9 AND r.rechnungsnr= 0 AND r.gestellt = 0 ORDER BY a.id';
        return $this->wandleSqlZuObjekten($sql, array($gehoertzu));
    }
	
    function findeAnhandVonGehoertZu($gehoertzu)
    {
        $sql = 'SELECT * FROM tbl_auftraege WHERE gehoertzu=? AND (aktiv = 9 OR aktiv = 1) AND status!=9 ORDER BY id DESC';
        return $this->wandleSqlZuObjekten($sql, array($gehoertzu));
    }

    function findeAnhandVonStichwortsuche($suchBegriff)
    {
        $suchBegriff = '%'.$suchBegriff.'%';
        $sql = "SELECT * FROM tbl_auftraege WHERE auftragsnummer LIKE ? OR auftragsname LIKE ? ORDER by id DESC";
        return $this->wandleSqlZuObjekten($sql, array($suchBegriff, $suchBegriff));
    }

    function speichere(Auftrag $auftrag)
    {
        if (!$auftrag->istValide()) {
            return false;
        }
        if ($auftrag->getId()) {
            $this->aendereAuftrag($auftrag);
        } else {
            $this->fuegeAuftragHinzu($auftrag);
        }
        return true;
    }

   
     function loesche(Auftrag $auftrag)
    {
        $sql = "UPDATE tbl_auftraege SET aktiv=0 WHERE id=?";
        $abfrage = $this->db->prepare($sql);
        $daten = array($auftrag->getId());
        $abfrage->execute($daten);
    }

    function aendereAuftrag(Auftrag $auftrag)
    {
        $sql = "UPDATE tbl_auftraege SET gehoertzu=?, auftragsnummer=?, auftragsname=?, web=?, design=?, holzboden=?, info=?, bezeichnungen=?, qm=?, ansprechpartner=?, gutscheincode=?, versand=?, Bemerkung=?, rechnung=?, bearbeiter=?, status=?, abgeschlossen=?, datum=?, aktiv=?, anzahl=?, aenderungen=? WHERE id=?";
        $abfrage = $this->db->prepare($sql);
        $daten = array(
            $auftrag->getGehoertZu(),
            $auftrag->getAuftragsnummer(),
            $auftrag->getAuftragsname(),
            $auftrag->getWeb(),
            $auftrag->getDesign(),
            $auftrag->getHolzboden(),
            $auftrag->getInfo(),
            $auftrag->getBezeichnungen(),
            $auftrag->getQm(),
            $auftrag->getAnsprechpartner(),
            $auftrag->getGutscheincode(),
            $auftrag->getVersand(),
            $auftrag->getBemerkung(),
            $auftrag->getRechnung(),
            $auftrag->getBearbeiter(),
            $auftrag->getStatus(),
            $auftrag->getAbgeschlossen(),
            $auftrag->getDatum(),
            $auftrag->getAktiv(),
            $auftrag->getAnzahl(),
            $auftrag->getAenderungen(),
            $auftrag->getId()
        );
        $abfrage->execute($daten);
        return true;
    }


    function aktiviereAuftrag(Auftrag $auftrag)
    {
        $sql = "UPDATE tbl_auftraege SET aktiv=1, status=1 WHERE id=?";
        $abfrage = $this->db->prepare($sql);
        $daten = array($auftrag->getId());
        $abfrage->execute($daten);
    }
     function erzeugeAuftragAusAngebot(Auftrag $auftrag)
    {
        $sql = "UPDATE tbl_auftraege SET aktiv=1, status=1 WHERE id=?";
        $abfrage = $this->db->prepare($sql);
        $daten = array($auftrag->getId());
        $abfrage->execute($daten);
    }

     function speichereBearbeiter(Auftrag $auftrag, $bearbeiter)
    {
        $sql = "UPDATE tbl_auftraege SET bearbeiter=? WHERE id=?";
        $abfrage = $this->db->prepare($sql);
        $daten = array($bearbeiter, $auftrag->getId());
        $abfrage->execute($daten);
    }
    
     function speichereAnzahl(Auftrag $auftrag, $anzahl)
    {
        $sql = "UPDATE tbl_auftraege SET anzahl=? WHERE id=?";
        $abfrage = $this->db->prepare($sql);
        $daten = array($anzahl, $auftrag->getId());
        $abfrage->execute($daten);
    }
     function speichereAenderungen(Auftrag $auftrag, $aenderungen)
    {
        $sql = "UPDATE tbl_auftraege SET aenderungen=? WHERE id=?";
        $abfrage = $this->db->prepare($sql);
        $daten = array($aenderungen, $auftrag->getId());
        $abfrage->execute($daten);
    }

    function finishAuftrag(Auftrag $auftrag)
    {
        $zeitstempel = date("d.m.Y H:i:s");
        $sql = "UPDATE tbl_auftraege SET aktiv=9, status=4, abgeschlossen='$zeitstempel' WHERE id=?";
        $abfrage = $this->db->prepare($sql);
        $daten = array($auftrag->getId());
        $abfrage->execute($daten);
    }

     function aendereRechnungsStatus(Auftrag $auftrag, $rechnung)
    {
        $sql = "UPDATE tbl_auftraege SET rechnung=? WHERE id=?";
        $abfrage = $this->db->prepare($sql);
        $daten = array($rechnung, $auftrag->getId());
        $abfrage->execute($daten);
    }
}
?>