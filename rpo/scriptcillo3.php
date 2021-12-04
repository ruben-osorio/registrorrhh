<?
include ("config.inc.php");
include ("database.class.php");
include ("functions.inc.php");

$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();

echo "select * from ".TABLE5." order by id asc";
$rs=$db->query("select * from ".TABLE5." order by id asc");
while ($r=$db->fetch_array($rs))
{
	//id	id_user	tipo	tiempo	fecha_i	fecha_ii	hrs_i	fecha_f	fecha_ff	hrs_f	obs
	$new_i=cambia_dateN_to_dateMy($r[fecha_i]);	
	$new_f=cambia_dateN_to_dateMy($r[fecha_f]);	
	$rs1=$db->query("update ".TABLE5." set fecha_ii='$new_i', fecha_ff='$new_f' where id='$r[id]'");
}

$db->close();
?>