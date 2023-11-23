<?php
class UserVerwaltung {
    private $db = null;

    function __construct($db) {
        $this->db = $db;
    }

    function wandleArrayZuObjekt($userArray) {
        $user = new User();
        $user->setId($userArray['id']);
        $user->setBenutzer($userArray['benutzer']);
        $user->setLogin($userArray['login']);
        $user->setPasswort($userArray['passwort']);
        $user->setFirma($userArray['firma']);
        $user->setStrasse($userArray['strasse']);
        $user->setPlz($userArray['plz']);
        $user->setOrt($userArray['ort']);
        $user->setTel($userArray['tel']);
        $user->setFax($userArray['fax']);
        $user->setMobil($userArray['mobil']);
        $user->setDatum($userArray['datum']);
        $user->setAktiv($userArray['aktiv']);
        $user->setKundennr($userArray['kundennr']);
        return $user;
    }


    function wandleSqlZuObjekten($sql, $bedingungen = array()) {
        $abfrage = $this->db->prepare($sql);
        $abfrage->execute($bedingungen);
        $usersArray = $abfrage->fetchAll();
        $userObjekte = array();
        foreach ($usersArray as $userArray) {
            $userObjekte[] = $this->wandleArrayZuObjekt($userArray);
        }
        return $userObjekte;
    }

    function findeAnhandVonId($id) {
        $sql = 'SELECT * FROM tbl_user WHERE id=?';
        $abfrage = $this->db->prepare($sql);
        $abfrage->execute(array($id));
        $userArray = $abfrage->fetch();
        return $this->wandleArrayZuObjekt($userArray);
    }

function findeLetzteId() {
        $sql = "SELECT * FROM tbl_user ORDER BY id DESC LIMIT 1";
        $abfrage = $this->db->prepare($sql);
        $abfrage->execute();
        $userArray = $abfrage->fetch();
        return $this->wandleArrayZuObjekt($userArray);
    }
function findeLetzteKundennr() {
        $sql = "SELECT * FROM tbl_user ORDER BY kundennr DESC LIMIT 1";
        return $this->wandleSqlZuObjekten($sql);
    }
    function findeAlle() {
        $sql = 'SELECT * FROM tbl_user WHERE aktiv = 1 order by firma asc';
       
        return $this->wandleSqlZuObjekten($sql);
    }

    function findeAnhandVonLogin($login) {
        $sql = 'SELECT * FROM tbl_user WHERE login=?';
        $abfrage = $this->db->prepare($sql);
        $abfrage->execute(array($login));
        $userArray = $abfrage->fetch();
        return $this->wandleArrayZuObjekt($userArray);
    }

    function findeAnhandVonStichwortsuche($suchBegriff) {
        $suchBegriff = '%'.$suchBegriff.'%';
        $sql = "SELECT * FROM tbl_user WHERE benutzer LIKE ? OR firma LIKE ?";
        return $this->wandleSqlZuObjekten($sql, array($suchBegriff, $suchBegriff));
    }

    function pruefeLoginDaten($loginInput, $passwortInput) {
        $user = $this->findeAnhandVonLogin($loginInput);
        $userLogin = $user->getLogin();
        $userPasswort = $user->getPasswort();
        if (empty($loginInput) || empty($passwortInput)) {
            return false;
        }
        if ($loginInput === $userLogin && $passwortInput === $userPasswort) {
            return true;
        }
        return false;
    }


    function fuegeUserHinzu(User $user) {
        $sql = "INSERT INTO tbl_user (id, benutzer, login, passwort, firma, strasse, plz, ort, tel, fax, mobil, datum, aktiv, kundennr)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $abfrage = $this->db->prepare($sql);
        $abfrage->execute(array(
            $user->getId(),
            $user->getBenutzer(),
            $user->getLogin(),
            $user->getPasswort(),
            $user->getFirma(),
            $user->getStrasse(),
            $user->getPlz(),
            $user->getOrt(),
            $user->getTel(),
            $user->getFax(),
            $user->getMobil(),
            $user->getDatum(),
            $user->getAktiv(),
            $user->getKundennr()
        ));
    }
    function aendereUser(user $user) {
        $sql = "UPDATE tbl_user SET benutzer=?, login=?, passwort=?, firma=?, strasse=?, plz=?, ort=?, tel=?, fax=?, mobil=?, datum=?, aktiv=?, kundennr=? WHERE id=?";
        $abfrage = $this->db->prepare($sql);
        $daten = array(
            $user->getBenutzer(),
            $user->getLogin(),
            $user->getPasswort(),
            $user->getFirma(),
            $user->getStrasse(),
            $user->getPlz(),
            $user->getOrt(),
            $user->getTel(),
            $user->getFax(),
            $user->getMobil(),
            $user->getDatum(),
            $user->getAktiv(),
            $user->getKundennr(),
            $user->getId()
        );
        $abfrage->execute($daten);
        return true;
    }
    function speichere(User $user) {
        if (!$user->istValide()) {
            return false;
        }
        
        if ($user->getId()) {
            $this->aendereUser($user);
        } else {
            $this->fuegeUserHinzu($user);
        }
        return true;
    }
}
?>
