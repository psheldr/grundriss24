<?
require_once __DIR__ . './../Dotenv.php';
$Conn=mysql_connect($_ENV['DB_HOST'] . ':' . $_ENV['DB_PORT'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
mysql_set_charset('utf8',$Conn);
mysql_select_db($_ENV['DB_NAME']);
?>
