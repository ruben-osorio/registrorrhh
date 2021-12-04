<?
include ("config.inc.php");
include ("database.class.php");

$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();

echo "select * from ".TABLE_TEMP_2." order by id asc";
$rs=$db->query("select * from ".TABLE_TEMP_2." order by id asc");
while ($r=$db->fetch_array($rs))
{
	//id	name	l_name1	l_name2	l_name_es	date_entrance	date_ends	office	source_fin	f_status
	/*$rs1=$db->query("insert into ".TABLE7." (id,nombres, ap_pat, ap_mat, cod, ci, ext, dependencia, equipo, car_ant, car_nuevo, fuente) 
	values ('$r[id]','$nombres','$ap_pat','$ap_mat','$r[cod]','$r[ci]','$r[ext]','$r[dependencia]','$r[equipo]','$r[car_anterior]','$r[car_nuevo]', '$r[fuente]') ");*/
	echo $r[car_ant];
	$new=str_replace("PROFESIONAL  III ", "ESPECIALISTA II", $r[car_ant]);
	//echo $new."<br><br>";
	$rs1=$db->query("update ".TABLE_TEMP_2." set car_ant='$new' where id='$r[id]'");
/*	echo "<pre>";
	print_r($names);
	echo "</pre>";
*/	

	
}

$db->close();
?>