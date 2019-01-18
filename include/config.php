<?php 
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('display_errors', 1);
ini_set('error_log', 'errors.log');
ini_set("error_reporting", E_ALL);
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'localhost');
define('DB_NAME', 'opetoks_esis');
include_once ("DB.php");
$db = DB::getInstance(); 
?>
