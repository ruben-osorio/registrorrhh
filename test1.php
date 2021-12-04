<?
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
$id=$_SESSION['id_func'];
/*if (isset($_POST[save]))
{ 	

	$name=strtoupper($_POST[name]);
	$l_name1=strtoupper($_POST[l_name1]);
	$l_name2=strtoupper($_POST[l_name2]);
	
	$ci=$_POST[ci];
	$expe=$_POST[expe];
	$date_born=$_POST[date_born];
	$adress=strtoupper($_POST[adress]);
	$phone_num=$_POST[phone_num];	
	$cel_num=$_POST[cel_num];
	$date_born=cambia_dateN_to_dateMy_1($_POST[date_born]);	
	$rs2=$db->query("update ".TABLE2." set ci='$ci', expe='$expe', adress='$adress', phone_num='$phone_num', cel_num='$cel_num', date_born='$date_born' where id='$id'");		
	//	 
	if($rs2)
	{
		$msg="Operación Exitosa.";
		$sw=1;
	}
	else
	{
		$msg="Error, intente nuevamente.";
		$sw=1;
	}	
}*/

//echo $id;
$rs1=$db->query("select * from ".TABLE1." ");
mysql_query("SET NAMES 'utf8'");
while ($r1=$db->fetch_array($rs1))
{
//	echo $r1[id].$r1[username]."<br>";
	echo $r1[id]." - username 1: ".$r1[username];
	echo " - pass 1: ".$r1[password];
	echo "<br><br>";
	/*echo " - username 1: ".str_replace(' ','',$r1[username]);
	echo " - username 1: ".str_replace(' ','',$r1[username]);
	echo " - username 2: ".utf8_decode($r1[username]);
	echo "<br>";
	echo "password: ".str_replace(' ','', $r1[password]);
	echo "password: ". utf8_decode($r1[password]);
	echo "<br>";*/
}
?>