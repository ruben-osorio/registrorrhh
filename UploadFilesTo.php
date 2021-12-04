<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="js/scripts.js"></script>
<link href="data/css/reportes.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");

$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
$id_func=$_GET[id_func];
$rs0=$db->query("select * from ".TABLE2." WHERE id_func='$id_func'");
$r0=$db->fetch_array($rs0);

$rs1=$db->query("SELECT * 
FROM ".TABLE2.",".TABLE22.",".TABLE15." WHERE 
".TABLE2.".id_func='$id_func' AND 
".TABLE2.".id_func=".TABLE22.".id_func AND
".TABLE15.".id_per='$id_per'
");

echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
  <th scope="col">NOMBRES:</th>
  <td colspan="3"><strong>'.$r0[name].' '.$r0[l_name1].' '.$r0[l_name2].'</strong></th>
 </tr>
 <tr>
	 	<th scope="col">FUENTE</th>
	  	<th scope="col">FECHA INICIO</th>
	  	<th scope="col">OPERACIONES</th>
 </tr>';
//echo "rs1:". mysql_num_rows($rs1);
if (mysql_num_rows($rs1)!=0)
{
	while ($r1=$db->fetch_array($rs1))
	{
		echo '
		<tr>
  			<td>'.$r1[source_fin].'</td>';
		echo '<td>'.cambia_dateMy_to_dateN($r1[date_ent]).'</td>
		<td><a href="#" onclick="MM_openBrWindow(\'UploadFilesPer.php?id_per='.$r1[id_per].'&id_func='.$id_func.'\',\'uploadfiles_final\',\'scrollbars=yes,width=800,height=600\')" title="Cargar Archivos a File Personal"> <img src="data/images/upload_to_file.png"></a> </td><tr>';		
	}
}

echo '</table>';
?> 
</body>
</html>
<?

$db->close();
?>