<?
include ("config.inc.php");
include ("database.class.php");

$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();

echo "select * from ".TABLE2." order by id asc";
$rs=$db->query("select * from ".TABLE2." order by id asc");
while ($r=$db->fetch_array($rs))
{
	//id	name	l_name1	l_name2	l_name_es	date_entrance	date_ends	office	source_fin	f_status
	/*
	dia [0] => 10
    mes [1] => 10
    año [2] => 1991
	*/
	$date_temp=explode("/", $r[date_entrance]);
	$new_date=$date_temp[2]."-".$date_temp[1]."-".$date_temp[0];
	$rs1=$db->query("update ".TABLE2." set fecha_ing='$new_date' where id='$r[id]'");
	

}

$db->close();
?>