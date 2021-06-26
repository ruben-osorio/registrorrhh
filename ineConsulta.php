<?
require ("config.inc.php");
require ("database.class.php");
include ("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
$id=$_GET[id];
$rs=$db->query("select * from  ".TABLE2." where f_status='1' order by l_name1 asc");
$c=0;
while ($r=$db->fetch_array($rs))
{
	$nombre=explode(" ",$r[name]);
	$username=strtolower($nombre[0].$r[l_name1]);
	$password=strtolower($nombre[0]);
	if(empty($r[l_name1]))
	{
		$username=strtolower($nombre[0].$r[l_name2]);
		echo "username: ".$username."<br />";
		echo "password: ".$password."<br /><br />";			

	}

	$rs1=$db->query("insert into ".TABLE1."(username, password, nombre, ap_1, ap_2,permisos,id_func) values ('$username','$password','$r[name]','$r[l_name1]','$r[l_name2]','1','$r[id]')");

	if ($rs)
	{
		$c++;
	}
/*	echo "username: ".$username."<br />";
	echo "password: ".$password."<br /><br />";*/
}
echo "registrados $c";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
</body>
</html>