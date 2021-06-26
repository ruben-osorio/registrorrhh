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
FROM ".TABLE2.",".TABLE22." 
WHERE ".TABLE2.".id_func='$id_func' AND ".TABLE2.".id_func=".TABLE22.".id_func
");

$rs2=$db->query("SELECT * 
FROM ".TABLE2.",".TABLE30."
WHERE ".TABLE2.".id_func='$id_func' AND ".TABLE2.".id_func=".TABLE30.".id_func
");
echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
  <th scope="col">NOMBRES:</th>
  <td colspan="3"><strong>'.$r0[name].' '.$r0[l_name1].' '.$r0[l_name2].'</strong></th>
 </tr>
 <tr>
 <th scope="col">FUENTE</th>
  <th scope="col">FECHA INICIO</th>
  <th scope="col">FECHA FIN</th>
  <th scope="col">OPERACIONES</th>
 </tr>';
 
if (mysql_num_rows($rs1)!=0)
{
	while ($r1=$db->fetch_array($rs1))
	{
		echo '<tr>
  <td>TGN</td>
  <td></td>
  <td></td>
  <td></td>
 </tr>';
	}
	//print_r($r1);
}
if (mysql_num_rows($rs2)!=0)
{
	while ($r2=$db->fetch_array($rs2))
	{
		echo '<tr>';
		$rs3=$db->query("select * from ".TABLE17." where id_con='$r2[id_con]'");
		$r3=$db->fetch_array($rs3);
		
				
		echo '<td>'.$r3[source_fin].'</td>'	;
  		echo '<td>'.cambia_dateMy_to_dateN($r2[date_ent]).'</td>
		<td>'.cambia_dateMy_to_dateN($r2[date_end]).'</td>
		<td><a href="#" onclick="MM_openBrWindow(\'UploadFilesCon.php?id_con='.$r2[id_con].'&id_func='.$id_func.'\',\'uploadfiles_final\',\'scrollbars=yes,width=800,height=600\')" title="Cargar Archivos a File Personal"> <img src="data/images/upload_to_file.png"></a> </td>
		</tr>';		
	}
}
echo '</table>';
?> 
</body>
</html>
<?

$db->close();
?>