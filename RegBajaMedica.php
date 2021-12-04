<?
require ("config.inc.php");
require ("database.class.php");
include ("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
$id=$_GET[id];
/*$rs2=$db->query("select * from ".TABLE9." where id_per='$id'");
if (mysql_num_rows($rs2)==1)
{
	exit();
}*/
$rs=$db->query("select * from ".TABLE2. " where id='$id'");
if ($r=$db->fetch_array($rs))
{
	if (isset($_POST[save]))	
	{
		//leave_from  leave_to total risk
		$leave_from=cambia_dateN_to_dateMy_1($_POST[leave_from]);
		$leave_to=cambia_dateN_to_dateMy_1($_POST[leave_to]);
		$total=$_POST[total];
		$risk=$_POST[risk];	
		
		$rs1=$db->query("insert into ".TABLE10." (id_per, risk, leave_from, leave_to, total_days) values ('$id','$risk','$leave_from','$leave_to',$total)");
		if ($rs1)
		{
			$msg="Se ha registrado Exitosamente.";
			$sw=1;
		}
		else
		{
			$msg="Error al ejecutar la consulta intente nuevamente";
			$sw=1;
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
<!--<script src="data/js/jquery-1.7.1.min.js"></script>-->
<script src="data/js/ui/jquery.ui.core.js"></script>
<script src="data/js/ui/jquery.ui.widget.js"></script>
<script src="data/js/ui/jquery.ui.datepicker.js"></script>
<script>
	$(function() {
		$( "#leave_from" ).datepicker({
			showOn: "button",
			changeMonth: true,
			changeYear: true,
			yearRange: "1920:2015",
			buttonImage: "data/images/calendar.gif",
			buttonImageOnly: true
		});	
		$( "#leave_to" ).datepicker({
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

<body>
<fieldset>
<legend>Registrar Datos Baja Médica</legend>
<form id="form1" name="form1" method="post" action="">
<table width="100%" border="0" cellpadding="5" cellspacing="0">
  <tr>
    <td><div align="left">Nombre(s):</div></td>
    <td><div align="left"><strong><? echo $r[name]; ?></strong></div></td>
  </tr>
  <tr>
    <td><div align="left">Apellidos:</div></td>
    <td><div align="left"><strong><? echo $r[l_name1]." ".$r[l_name2]; ?></strong></div></td>
  </tr>
  <tr>
      <td><div align="left">Cargo:</div></td>
      <td><div align="left"><strong><? echo $r[office]; ?></strong></div></td>
  </tr>
  <tr>
      <td><div align="left">Fecha de Ingreso:</div></td>
      <td><div align="left"><strong><? echo cambia_dateMy_to_dateN($r[fecha_ing]); ?></strong></div></td>
  </tr>
  <?
  $rs3=$db->query("select name_sec, num_reg from ".TABLE9." where id_per='$id'");
  $r3=$db->fetch_array($rs3);
  ?>
  <tr>
    <td><div align="left">Numero Asegurado:</div></td>
    <td><div align="left"><strong><? echo $r3[num_reg]; ?></strong></div></td>
  </tr>
  <tr>
    <td><div align="left">Nombre de Seguro</div></td>
    <td><div align="left"><strong><? echo $r3[name_sec]; ?></strong></div></td>
  </tr>
  <tr>
    <td><div align="left">Riesgo</div></td>
    <td><div align="left">
      <label for="risk">Profesional</label><input type="radio" name="risk" id="radio" value="PROFESIONAL" />
      <label for="risk">Enfermedad</label><input name="risk" type="radio" id="radio2" value="ENFERMEDAD" checked="checked" />
      <label for="risk">Maternidad</label><input type="radio" name="risk" id="radio3" value="MATERNIDAD" />

    </div></td>
  </tr>
  <tr>
    <td><div align="left">Desde:</div></td>
    <td><div align="left">
      <input name="leave_from" type="text" id="leave_from" class="required" readonly="readonly"/>
    </div></td>
  </tr>
  <tr>
    <td><div align="left">Hasta:</div></td>
    <td><div align="left">
      <input type="text" name="leave_to" id="leave_to" class="required" readonly="readonly" />
    </div></td>
  </tr>
  <tr>
    <td><div align="left">Dias Incapacidad:</div></td>
    <td><div align="left">
      <input name="total" type="text" id="total" size="35"  class="required number" />
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