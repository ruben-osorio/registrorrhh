<?
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
$rs=$db->query("select * from ".TABLE4.",".TABLE2.",".TABLE30.",".TABLE17." where 
".TABLE4.".id_func=".TABLE2.".id_func and  
".TABLE2.".id_func=".TABLE30.".id_func and
".TABLE30.".id_con=".TABLE17.".id_con and
".TABLE30.".status=1 
order by ".TABLE2.".l_name1,".TABLE2.".l_name2,".TABLE2.".name asc  ");

echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body style="font-family:tahoma; font-size: 11px;">
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <th scope="col">';

//username	password	nombre	ap_1	ap_2	fecha_nac	permisos	id_func

while ($r=$db->fetch_array($rs))
{	
	echo '<table width="100%" border="1" cellspacing="0" cellpadding="5">
  <tr>
    <tD width="200">'.$r[ap_1].' '.$r[ap_2].'</tD>
    <td width="200">'.$r[nombre].'</td>
    <td width="100">'.$r[source_fin].'</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
</table>
';	
}
echo '</th>
  </tr>
</table>';	
?>
</body>
</html>