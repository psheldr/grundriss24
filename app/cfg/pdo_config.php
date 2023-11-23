<?php
require_once __DIR__ . '/../Dotenv.php';


    session_start();
    $rechner = php_uname('n');
        global $url;
        global $root_path;
        global $root_path_files;

    #$url = $_ENV['HTTP_HOST'];
    $url = isset($_ENV['HTTP_HOST']);
    $root_path = __DIR__.'/../';
    $root_path_files = __DIR__.'/../files/';

    require_once $root_path.'model/auftrag.php';
    require_once $root_path.'model/auftrag_verwaltung.php';
    require_once $root_path.'model/datei.php';
    require_once $root_path.'model/datei_verwaltung.php';
    require_once $root_path.'model/user.php';
    require_once $root_path.'model/user_verwaltung.php';
    require_once $root_path.'model/protokoll.php';
    require_once $root_path.'model/protokoll_verwaltung.php';
    require_once $root_path.'model/rechnung.php';
    require_once $root_path.'model/rechnung_verwaltung.php';
    require_once $root_path.'includes/functions.php';
    require_once $root_path.'includes/mails.php';

    $optionen = array(
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );
    $db = new PDO('mysql:host='.$_ENV['DB_HOST'].';dbname='.$_ENV['DB_NAME'].';', $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $optionen);

    $db->query('SET NAMES utf8');
    $auftragVerwaltung = new AuftragVerwaltung($db);
    $dateiVerwaltung = new DateiVerwaltung($db);
    $userVerwaltung = new UserVerwaltung($db);
    $protokollVerwaltung = new ProtokollVerwaltung($db);
    $rechnungVerwaltung = new RechnungVerwaltung($db);
?>
