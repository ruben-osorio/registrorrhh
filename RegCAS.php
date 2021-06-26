<?
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
$rs=$db->query("select * from ".TABLE2. " where id_func='$id_func'");
if ($r=$db->fetch_array($rs))
{	
	if (isset($_POST[save]))	
	{
		echo "guardando";
		$date_cas=cambia_dateN_to_dateMy_1($_POST[date_cas]);		
		$years=$_POST[years];
		$months=$_POST[months];
		$days=$_POST[days];	
		//id_func	
		//echo "insert into ".TABLE24."(id_per, date_cas, year_rat, month_rat, day_rat) values ('$id_per','$date_cas','$years','$months','$days')";
		$rs1=$db->query("insert into ".TABLE24."(id_per, date_cas, year_rat, month_rat, day_rat) values ('$id_per','$date_cas','$years','$months','$days')");
		/*$rs1=$db->query("insert into ".TABLE11." (id_func, date_start, date_last,date_cas, year_rat, month_rat, day_rat) values ('$id','','','$date_cas','$years','$months','$days')");	*/	
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
<link href="data/css/reportes.css" rel="stylesheet" type="text/css" />
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
		$( "#date_cas" ).datepicker({
			showOn: "button",
			changeMonth: true,
			changeYear: true,
			yearRange: "1920:2018",
			buttonImage: "data/images/calendar.gif",
			buttonImageOnly: true
		});				
		$( "#born_date" ).datepicker({
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

<body>
<fieldset>
<legend>Registrar Certificado CAS</legend>
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
  <?  	
	$rs5=$db->query("select * from ".TABLE28." where id_per='$id_per' order by id_char_per desc limit 1");
	$r5=$db->fetch_array($rs5);	
  ?>
      <td><div align="left">Cargo:</div></td>
      <td><div align="left"><strong><? echo $r5[charge]; ?></strong></div></td>
  </tr>
  <tr>
      <td><div align="left">Fecha de Ingreso:</div></td>
      <td><div align="left"><strong><? echo cambia_dateMy_to_dateN($date_ent); ?></strong></div></td>
  </tr>
  <tr>
    <td><div align="left">Fecha Certificado CAS</div></td>
    <td><label for="date_cas"></label>
      <div align="left">
        <input type="text" name="date_cas" id="date_cas" readonly="readonly" class="required"  />
      </div></td>
  </tr>  
  <tr>
    <td><div align="left">Años:</div></td>
    <td><div align="left">
      <input name="years" type="text" id="years" class="required number"/>
      </div></td>
  </tr>
  <tr>
    <td><div align="left">Meses:</div></td>
    <td><div align="left">
      <input type="text" name="months" id="months" class="required number"/>
    </div></td>
  </tr>
  <tr>
    <td><div align="left">Dias:</div></td>
    <td><div align="left">
      <input name="days" type="text" id="days"  class="required number" />
    </div></td>
  </tr>
  <tr>
    <td><div align="left"></div></td>
    <td><div align="left">
      <input type="submit" name="save" id="loginbutton" value="Guardar" />
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