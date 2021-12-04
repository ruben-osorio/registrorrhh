<?
require_once("security.php");
require("functions.inc.php");
require("config.inc.php");
require("database.class.php");

$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();

$id_func=$_GET[id];
if (isset($_GET[id]))
{	

	$rs1=$db->query("select id_per, date_ent from ".TABLE22." where id_func='$id_func' order by id_per desc limit 1");
	$r1=$db->fetch_array($rs1);
	$id_per= $r1[id_per];	
	$rs=$db->query("select * from ".TABLE2." where id_func='$id_func'");
	if ($r=$db->fetch_array($rs))
	{
		if (isset($_POST[save]))
		{
			//echo "insert into ".TABLE3."(id_per, gestion_1, dias_g1, gestion_2, dias_g2, observaciones) values
			//('$id_per','$_POST[g_1]','$_POST[dias_g1]','$_POST[g_2]','$_POST[dias_g2]','$_POST[observaciones]')";
			$rs5=$db->query("update ".TABLE3." set gestion_1='$_POST[g_1]', dias_g1='$_POST[dias_g1]', gestion_2='$_POST[g_2]', dias_g2='$_POST[dias_g2]', observaciones='$_POST[observaciones]', stored_vac='$_POST[gest_arch]'  where id_per='$id_per'");
			if ($rs5)
			{
				$sw=1;
				$msg="Actualización completada";
			}
		}
		if ($sw==1)
		{
			echo '<div class="alert success">'.$msg.'</div>';
		}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="data/css/reportes.css" rel="stylesheet" type="text/css" />
<link href="data/css/style-ext.css" rel="stylesheet" type="text/css" />
</head>

<body>
<fieldset>
<legend>Asigna nueva Gestión </legend>
<form id="form1" name="form1" method="post" action="">
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <th scope="col">Nombres</th>
    <td ><? echo $r[name]?></td>
  </tr>
  <tr>
    <th>Apellidos:</td>
    <td><? echo $r[l_name1]?> <? echo $r[l_name2]?></td>
  </tr>
  <tr>
    <th>Fecha de Ingreso:</td>
    <td><? echo cambia_dateMy_to_dateN($r1[date_ent])?></td>
  </tr>
  <tr>
  <?
  $rs2=$db->query("select charge from ".TABLE28." where id_per='$id_per'");
  $r2=$db->fetch_array($rs2);
  ?>
    <th>Cargo:</td>
    <td><? echo $r2[charge]?></td>
  </tr>
  
  <?
  	$rs3=$db->query("select * from ".TABLE24." where id_per='$id_per'");
 	if (mysql_num_rows($rs3)==0)
 	{
		echo "<tr>
		<th>CAS:</th>
    	<td>NO TIENE</td></tr>";
	}
 	else
 	{
		$r3=$db->fetch_array($rs3);
		echo "<tr>
		<th>CAS:</th>
    	<td>AÑOS: <strong>".$r3[year_rat]."</strong> MESES: <strong>".$r3[month_rat]."</strong> DIAS: <strong>".$r3[day_rat]."</strong></td></tr>";
	}
  ?>
    
  
  <tr>
  <?  
  	$rs4=$db->query("select * from ".TABLE3." where id_per='$id_per'");
  	$r4=$db->fetch_array($rs4);  
  ?>
    <th>Gestión 1:</td>
    <td><label for="g_1"></label>
      <input name="g_1" type="text" id="g_1" value="<? echo $r4[gestion_1]?>" />     
      <label for="dias_g1">Dias</label>
      <input name="dias_g1" type="text" id="dias_g1" value="<? echo $r4[dias_g1]?>" size="7" /></td>
  </tr>
  <tr>
    <th>Gestión 2:</td>
    <td><label for="g_2"></label>
      <input name="g_2" type="text" id="g_2" value="<? echo $r4[gestion_2]?>" />     
      <label for="dias_g2">Dias</label>
      <input name="dias_g2" type="text" id="dias_g2" value="<? echo $r4[dias_g2]?>" size="7" /></td>
  </tr>
  <tr>
   <th>Gestiónes Archivadas<td><label for="gest_arch"></label>
    <textarea name="gest_arch" id="gest_arch" cols="45" rows="3"><? echo $r4[stored_vac]?></textarea></td>
  </tr>
  <tr>
    <th>Observaciones:
    <td><label for="textfield2"></label>
      <textarea name="observaciones" cols="45" rows="3" id="textfield2"><? echo $r4[observaciones]?></textarea></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
      <input type="submit" name="save" id="loginbutton" value="Enviar" />
    </td>
  </tr>
</table></form>
</fieldset>
</body>
</html>
<?
	}
}
?>