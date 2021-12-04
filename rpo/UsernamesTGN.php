<?
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
$rs=$db->query("select * from ".TABLE2.",".TABLE22." where  ".TABLE2.".id_func=".TABLE22.".id_func");
$r=$db->fetch_array($rs);

while($r=$db->fetch_array($rs))
{
	echo strtoupper($r[name]);
	echo strtoupper($r[l_name1]);
	echo strtoupper($r[l_name2]);
	strtoupper($r[date_born]);
	$fech_nac=explode("-",$r[date_born]);	
	$ano=$fech_nac[0];
	$mes=$fech_nac[1];
	$dia=$fech_nac[2];
	$r[name][0];
	$r[l_name1][0];
	$r[l_name2][0];
	$username=$r[l_name1][0].$r[l_name2][0].$r[name][0].$dia.$mes.$ano;
	$password=$r[ci];
	$id_func=$r[id_func];
	
	$rs1=$db->query("UPDATE ".TABLE4." SET username='$username', password='$password' where id_func='$id_func'");	
	
	echo "USERNAME: ".$r[l_name1][0].$r[l_name2][0].$r[name][0].$dia.$mes.$ano;
	echo "<br>CI: ".$r[ci];
	echo"<br><br>";	
}
echo "filas actualizadas".mysql_affected_rows($rs1);
?>