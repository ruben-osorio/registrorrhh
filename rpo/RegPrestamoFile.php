<?
require("functions.inc.php");
require("config.inc.php");
require("database.class.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
$id_fun=$_GET[id];
if (isset($_GET[id]))
{
	if (isset($_POST[submit]))
	{
		$date_out=cambia_dateN_to_dateMy($_POST[date_out]);
		$obs=$_POST[obs];
		$rs1=$db->query("insert into ".TABLE6." (id_funcionario, fecha_salida, observaciones) values ('$id_fun','$date_out','$obs')");
		if ($rs1)
		{
			$sw=1;
			$msg="Se ha registrado satisfactoriamente";
		}
		else
		{
			$sw=1;
			$msg="Error al intentar registrar";
		}
	}
	if ($sw==1)
	{
		echo '<div class="alert success">'.$msg.'</div>';
	}
	$rs=$db->query("select * from ".TABLE2." where id='$id_fun' ");
	$r=$db->fetch_array($rs);
	
?>
<link href="data/css/style-ext.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="data/css/ui/admincp/jquery-ui-1.8.17.custom.css">
<link rel="stylesheet" href="../../themes/base/jquery.ui.all.css">
	<script src="data/js/jquery-1.7.1.min.js"></script>
	<script src="data/js/ui/jquery.ui.core.js"></script>
	<script src="data/js/ui/jquery.ui.widget.js"></script>
	<script src="data/js/ui/jquery.ui.datepicker.js"></script>
	<link rel="stylesheet" href="../demos.css">
	<script>
	$(function() {
		$( "#date_out" ).datepicker({
			showOn: "button",
			buttonImage: "data/images/calendar.gif",
			buttonImageOnly: true
		});		
	});
	</script>

<fieldset>
<legend>Registrar Prestamo File Personal</legend>
<form id="form1" name="form1" method="post" action="">
  <table width="100%" border="0" cellpadding="5">
    <tr>
      <td><div align="left">Nombres y Apellidos:</div></td>
      <td><div align="left"><strong><? echo $r[name]." ".$r[l_name1]." ".$r[l_name2]; ?></strong></div></td>
    </tr>
    <tr>
      <td><div align="left">Cargo:</div></td>
      <td><div align="left"><strong><? echo $r[office]; ?></strong></div></td>
    </tr>
    <tr>
      <td><div align="left">Fecha Pr&eacute;stamo:</div></td>
      <td><label>
        <div align="left">
          <input name="date_out" type="text" id="date_out" size="10" />
        </div>
      </label></td>
    </tr>
    <tr>
      <td><div align="left">Observaciones:</div></td>
      <td><label>
        <div align="left">
          <textarea name="obs" id="obs" cols="30" rows="3"></textarea>
        </div>
      </label></td>
    </tr>
    <tr>
      <td><div align="left"></div></td>
      <td><div align="left">
        <label>
        <input type="submit" name="submit" id="submit" value="Registrar Pr&eacute;stamo" />
        </label>
      </div></td>
    </tr>
  </table>
</form>
</fieldset>
<?
}
?>
