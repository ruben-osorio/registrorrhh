<?
require_once("security.php");
require ("config.inc.php");
require ("database.class.php");
include ("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
$id_func=$_GET[id];
$rs=$db->query("select nua, afp from ".TABLE2." where id_func='$id_func' and afp=''");
$r=$db->fetch_array($rs);
$c=count($r);
if (count($r)>1)
{
	if (isset($_POST[save]))	
	{	$nua=strtoupper($_POST[nua]);
		$afp=strtoupper($_POST[afp]);
		$rs1=$db->query("update ".TABLE2." set nua='$nua', afp='$afp' where id_func='$id_func'");
		//$rs1=$db->query("insert into ".TABLE9." (id_per, name_sec, num_reg, date_afil) values ('$id','$name_medical_sec','$numb_secured','$date_start_sec')");
		if ($rs1)
		{	$msg="Se ha registrado Exitosamente [$nua] [$afp]";
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
}	
else{	echo '<link href="css/reportes.css" rel="stylesheet" type="text/css">
<link href="data/css/style-ext.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" media="screen" href="data/css/screen.css" /><link href="css/reportes.css" rel="stylesheet" type="text/css">';
		echo '<div class="errorre"><h2>El funcionario ya se encuentra Registrado</h2></div>';
		exit;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/reportes.css" rel="stylesheet" type="text/css">
<link href="data/css/style-ext.css" rel="stylesheet" type="text/css">
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

<body>
<fieldset>
<legend>Registrar Datos AFP</legend>
<form id="form1" name="form1" method="post" action="">
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
      <th><div align="left">AFP:</div></th>
      <td><div align="left">
        <select name="afp" id="afp">
          <option value="PREVISION">PREVISIÓN</option>
          <option value="FUTURO">FUTURO</option>
        </select>
      </div></td>
    </tr>
    <tr>
       <th><div align="left">NUA/CUA:</div></th>
      <td><div align="left">
        <input class="required number" type="text" name="nua" id="nua" />
      </div></td>
    </tr>
    <tr>
      <td><div align="left"></div></td>
      <td><div align="left">
        <input type="submit" name="save" class="submit" id="loginbutton" value="Guardar" />
        </div></td>
    </tr>
  </table>
</form>
</fieldset>
</body>
</html>
<?

$db->close();
?>