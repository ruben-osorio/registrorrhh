<?
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
$rs=$db->query("SELECT * FROM ".TABLE4." ORDER BY id_func");
while ($r=$db->fetch_array($rs))
{
	$id_func=$r[id_func];
	echo $r[nombre].$r[ap_1]."<br>";
	echo "insert into ".TABLE37."(id_func) values ($id_func)";
	//$rs1=$db->query("insert into ".TABLE37."(id_func) values ($id_func)");
}
?>