<?
include ("config.inc.php");
include ("database.class.php");

$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
echo "select * from ".TABLE_TEMP." order by id asc";
$rs=$db->query("select * from ".TABLE_TEMP." order by id asc");
while ($r=$db->fetch_array($rs))
{
	/*
	[0] => SOLIZ
    [1] => LOZA
    [2] => HERNAN
    [3] => ROGELIO
	*/
	$names=explode(" ",$r[nombres]);
	
	$ap_pat=$names[0];
	$ap_mat=$names[1];
	$nombres=$names[2]." ".$names[3];
	//cod	ci	ext	dependencia	equipo	car_anterior	car_nuevo	fuente
	$rs1=$db->query("insert into ".TABLE_TEMP_2." (id,nombres, ap_pat, ap_mat, cod, ci, ext, dependencia, equipo, car_ant, car_nuevo, fuente) 
	values ('$r[id]','$nombres','$ap_pat','$ap_mat','$r[cod]','$r[ci]','$r[ext]','$r[dependencia]','$r[equipo]','$r[car_anterior]','$r[car_nuevo]', '$r[fuente]') ");
/*	echo "<pre>";
	print_r($names);
	echo "</pre>";
*/	

	
}

$db->close();
?>