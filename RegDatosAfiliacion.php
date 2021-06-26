<?
require_once("security.php");
require ("config.inc.php");
require ("database.class.php");
include ("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
$id_func=$_GET[id];
$rs=$db->query("select id_per from funcionario ,permanente where funcionario.id_func='$id_func' and permanente.id_func='$id_func'");
$r=$db->fetch_array($rs);
$id_per=$r[id_per];

$rs3=$db->query("select id_sec from soc_secu where id_per='$r[id_per]'");
if (mysql_num_rows($rs3)==1 )
{
	echo '<link href="css/reportes.css" rel="stylesheet" type="text/css" />';
	echo '<div class="errorre">OPERACION NO PERMITIDA!!!</div>';	
	exit();
}
$rs=$db->query("select * from funcionario, permanente where funcionario.id_func='$id_func' and permanente.id_func='$id_func'");

if ($r=$db->fetch_array($rs))
{
	if (isset($_POST[save]))	
	{
		//
		$name_medical_sec=strtoupper($_POST[name_medical_sec]);
		$numb_secured=strtoupper($_POST[numb_secured]);
		$date_start_sec=cambia_dateN_to_dateMy_1($_POST[date_start_sec]);
		$rs1=$db->query("insert into soc_secu (id_per, name_sec, num_reg, date_afil) values ('$id_per','$name_medical_sec','$numb_secured','$date_start_sec')");
		if ($rs1)
		{
			$msg="Exito, Operación ejecutada correctamente.";
			$sw=1;
		}
		else
		{
			$msg="Error al ejecutar la operación, intente nuevamente.";
			$sw=2;
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="data/css/style-ext.css" rel="stylesheet" type="text/css" />
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
<link href="css/reportes.css" rel="stylesheet" type="text/css" />
<script src="data/js/ui/jquery.ui.core.js"></script>
<script src="data/js/ui/jquery.ui.widget.js"></script>
<script src="data/js/ui/jquery.ui.datepicker.js"></script>
<script>
	$(function() {
		$( "#date_start_sec" ).datepicker({
			showOn: "button",
			changeMonth: true,
			changeYear: true,
			yearRange: "1920:2018",
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
		exit;
	}
	if ($sw==2)
	{
		echo '<div class="errorre">'.$msg.'</div>';
		exit;
	}
?>
<body>
<fieldset>
<legend>Registrar Datos Afiliación Seguro</legend>
<form id="form1" name="form1" method="post" action="">
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
		$rs2=$db->query("select level from cat_per where id_per='$r[id_per]'");
		$r2=$db->fetch_array($rs2);
    ?>
      <th><div align="left">Cargo:</div></th>
      <td><div align="left"><strong><? echo $r2[level]; ?></strong></div></td>
    </tr>
    <tr>
      <th><div align="left">Fecha de Ingreso:</div></th>
      <td><div align="left"><strong><? echo cambia_dateMy_to_dateN($r[date_ent]); ?></strong></div></td>
    </tr>
    <tr>
      <th><div align="left">Nombre Seguro:</div></th>
      <td><div align="left">
        <label for="name_medical_sec"></label>
        <input class="required" name="name_medical_sec" type="text" id="name_medical_sec" size="45" value="CAJA NACIONAL DE SALUD" />
      </div></td>
    </tr>
    <tr>
      <th><div align="left">Número Asegurado:</div></th>
      <td><div align="left">
        <label for="numb_secured"></label>
        <input class="required" type="text" name="numb_secured" id="numb_secured" />
      </div></td>
    </tr>
    <tr>
      <th><div align="left">Fecha Afiliación:</div></th>
      <td><div align="left">
        <label for="date_start_sec"></label>
        <input name="date_start_sec" type="text" class="required" id="date_start_sec" readonly="readonly" />
      </div></td>
    </tr>
    <tr>
      <td><div align="left"></div></td>
      <td><div align="left">
        <input type="submit" name="save" id="save" value="Guardar" />
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