<?
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
$rs=$db->query("select * from ".TABLE37." ORDER BY id_des_hab_temp, id_func ASC");
$c=0;
while($r=$db->fetch_array($rs))
{
	$id_func=$r[id_func];
	$rs1=$db->query("select * from ".TABLE37." where id_func='$id_func'");
	if (mysql_num_rows($rs1)==2)
	{
		echo "delete from ".TABLE37." where id_des_hab_temp >= '586' and id_func='$id_func'<br>";
		//$rs2=$db->query("delete from ".TABLE37." where id_des_hab_temp >= '586' and id_func='$id_func'");
		echo "filas afectadas: ".mysql_affected_rows($rs2)."<br>";
		$c++;		
	}
}
echo "Total jODIDOS: ".$c;
?>