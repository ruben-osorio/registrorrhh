<?
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();

$rs2=$db->query("update ".TABLE2." set ci='', expe='', adress='', phone_num='', cel_num='', date_born=''");	
?>