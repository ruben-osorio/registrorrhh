<?
require_once("security.php");
require ("config.inc.php");
require ("database.class.php");
include ("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
$id_func=$_GET[id];

$rs2=$db->query("select * from ".TABLE22." where id_func='$id_func' order by id_per desc limit 1");
$r2=$db->fetch_array($rs2);
$id_per=$r2[id_per];

$date_ent=$r2[date_ent];
$rs3=$db->query("select * from ".TABLE23." where id_per='$id_per'");

//$r2=$db->fetch_array($rs2);
//echo mysql_num_rows($rs2);
//echo mysql_num_rows($rs3);
if (mysql_num_rows($rs3)==0)
{
	echo '<link href="css/reportes.css" rel="stylesheet" type="text/css" />';
	echo '<div class="errorre"><h1>OPERACION NO PERMITIDA!!!</h1></div>';	
	exit();
}
if ($r3=$db->fetch_array($rs3))
{
	if (isset($_POST[save]))	
	{		
		//
		$name_medical_sec=strtoupper($_POST[name_medical_sec]);
		$numb_secured=strtoupper($_POST[numb_secured]);
		$date_start_sec=cambia_dateN_to_dateMy_1($_POST[date_start_sec]);
		//echo "update ".TABLE23." set name_sec='$name_medical_sec',  num_reg='$numb_secured', date_afil='$date_start_sec' where id_per='$id_per'";
		$rs1=$db->query("update ".TABLE23." set name_sec='$name_medical_sec',  num_reg='$numb_secured', date_afil='$date_start_sec' where id_per='$id_per'");
		
		if ($rs1)
		{
			$msg="Datos actualizados Exitosamente!!!<br />
			[$name_medical_sec] [$numb_secured]";
			$sw=1;
		}
		else
		{
			$msg="Hubo un Error al ejecutar la operación.";
			$sw=2;
		}
	}	
	$r2=$db->fetch_array($rs2);	
	$rs=$db->query("select * from ".TABLE2." where id_func='$id_func'");
	$r=$db->fetch_array($rs);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="data/css/style-ext.css" rel="stylesheet" type="text/css" />
<link href="css/reportes.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="screen" href="data/css/screen.css" />
<script src="data/js/jquery-1.7.1.min.js"></script>
<script src="data/js/jquery.metadata.js" type="text/javascript"></script>
<script src="data/js/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">
$.metadata.setType("attr", "validate");
$(document).ready(function() {
	$("#form1").validate();	
});
</script>
<link rel="stylesheet" href="data/css/ui/admincp/jquery-ui-1.8.17.custom.css">
<link href="data/css/style-ext.css" rel="stylesheet" type="text/css" />
<!--<script src="data/js/jquery-1.7.1.min.js"></script>-->
<script src="data/js/ui/jquery.ui.core.js"></script>
<script src="data/js/ui/jquery.ui.widget.js"></script>
<script src="data/js/ui/jquery.ui.datepicker.js"></script>
<script>
	$(function() {
		$( "#date_start_sec" ).datepicker({
			showOn: "button",
			changeMonth: true,
			changeYear: true,
			yearRange: "1920:2015",
			buttonImage: "data/images/calendar.gif",
			buttonImageOnly: true
		});		
	});
	</script>

</head>
<?
if ($sw==1)
	{
		echo '<div class="successre">'.$msg.'</div>';
	}
	if ($sw==2)
	{
		echo '<div class="errorre">'.$msg.'</div>';
	}
?>
<body>
<fieldset>
<legend>Actualizar Datos Afiliación Seguro</legend>
<form class="form" id="form1" name="form1" method="post" action="">
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr>
      <th><div align="left">Nombres:</div></th>
      <td><div align="left"><strong><? echo $r[name]; ?></strong></div></td>
    </tr>
    <tr>
      <th><div align="left">Apellidos:</div></th>
      <td><div align="left"><strong><? echo $r[l_name1]." ".$r[l_name2]; ?></strong></div></td>
    </tr>
    <tr>
    <?
	$rs5=$db->query("select * from ".TABLE28." where id_per='$id_per' order by id_char_per desc limit 1");
	$r5=$db->fetch_array($rs5);	
    ?>
      <th><div align="left">Cargo:</div></th>
      <td><div align="left"><strong><? echo $r5[charge]; ?></strong></div></td>
    </tr>
    <tr>
    <?
	  $rs4=$db->query("select * from ".TABLE23." where id_per='$id_per'");
	  $r4=$db->fetch_array($rs3);
    ?>
      <th><div align="left">Fecha de Ingreso:</div></th>      
      <td><div align="left"><strong><? echo cambia_dateMy_to_dateN($date_ent); ?></strong></div></td>
    </tr>
    <tr>
     <?
	  $rs6=$db->query("select * from ".TABLE23." where id_per='$id_per'");
	  $r6=$db->fetch_array($rs6);
     ?>
      <th><div align="left">Nombre Seguro:</div></th>
      <td><div align="left">
        <label for="name_medical_sec"></label>
        <input class="required" name="name_medical_sec" type="text" id="name_medical_sec" size="45" value="<? echo $r6[name_sec];?>" />
      </div></td>
    </tr>
    <tr>
      <th><div align="left">Número Asegurado:</div></th>
      <td><div align="left">
        <label for="numb_secured"></label>
        <input name="numb_secured" type="text" class="required" id="numb_secured" value="<? echo $r6[num_reg];?>" />
      </div></td>
    </tr>
    <tr>
      <th><div align="left">Fecha Afiliación:</div></th>
      <td><div align="left">
        <label for="date_start_sec"></label>
        <input name="date_start_sec" type="text" class="required" id="date_start_sec" value="<? echo cambia_dateMy_to_dateN($r6[date_afil]);?>" readonly="readonly" />
      </div></td>
    </tr>
    <tr>
      <td><div align="left"></div></td>
      <td><div align="left">
        <input type="submit" name="save" class="submit" value="Guardar" />
      </div></td>
    </tr>
  </table>
</form>
</fieldset>
</body>
</html>
<?
}
$db->close();
?>