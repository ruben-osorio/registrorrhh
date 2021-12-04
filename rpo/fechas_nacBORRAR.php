<?
require("config.inc.php");
require("database.class.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
$rs=$db->query("select * from ".TABLEX." order by id");
while ($r=$db->fetch_array($rs))
{
	$id_funcionario=$r[id];
	$nueva_fecha=$r[date_born];
	//echo "update ".TABLE2." set date_born='$nueva_fecha' where id='$id_funcionario'<br>";
	$rs1=$db->query("update ".TABLE2." set date_born='$nueva_fecha' where id='$id_funcionario'");
	
}
?>