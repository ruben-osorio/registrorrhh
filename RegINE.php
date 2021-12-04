<?
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
$id=$_SESSION['id_func'];
if (isset($_POST[save]))
{ 	

	$name=strtoupper($_POST[name]);
	$l_name1=strtoupper($_POST[l_name1]);
	$l_name2=strtoupper($_POST[l_name2]);
	
	$ci=$_POST[ci];
	$expe=$_POST[expe];
	$date_born=$_POST[date_born];
	$adress=strtoupper($_POST[adress]);
	$phone_num=$_POST[phone_num];	
	$cel_num=$_POST[cel_num];
	$date_born=cambia_dateN_to_dateMy_1($_POST[date_born]);	
	$rs2=$db->query("update ".TABLE2." set ci='$ci', expe='$expe', adress='$adress', phone_num='$phone_num', cel_num='$cel_num', date_born='$date_born' where id='$id'");		
	//	 
	if($rs2)
	{
		$msg="Sus datos han sido guardados exitosamente. GRACIAS";
		$sw=1;
	}
	else
	{
		$msg="Error, intente nuevamente.";
		$sw=1;
	}	
}

//echo $id;
$rs1=$db->query("select * from ".TABLE2." where id='$id'");
if ($r1=$db->fetch_array($rs1))
{
	if ($sw==1)
	{
		echo '<div class="warning" style="font-weight:bold; font-size:15px; padding:5px;">'.$msg.'</div>';
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FORMULARIO DE REGISTRO</title>

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
		$( "#date_born" ).datepicker({
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
<link rel="stylesheet" href="data/css/ui/admincp/jquery-ui-1.8.17.custom.css">
<link rel="stylesheet" href="../../themes/base/jquery.ui.all.css">
	<!--<script src="data/js/jquery-1.7.1.min.js"></script>-->
	<script src="data/js/ui/jquery.ui.core.js"></script>
	<script src="data/js/ui/jquery.ui.widget.js"></script>
	<script src="data/js/ui/jquery.ui.datepicker.js"></script>
	<script>
	$(function() {
		$( "#date_born" ).datepicker({
			showOn: "button",
			buttonImage: "data/images/calendar.gif",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '-100:+0'
			
		});
	});
	</script>
<fieldset>
<legend>ACTUALIZACION DE DATOS PERSONALES</legend>
<form id="form1" name="form1" method="post" action="" class="form">
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td width="22%">NOMBRES:(*)</td>
        <td width="22%">APELLIDO PATERNO:(*)</td>
        <td width="22%">APELLIDO MATERNO:(*)</td>
        <td width="16%">CI:</td>
        
      </tr>
      <tr> 
        <td><input name="name" type="text" class="textarea_normal required" id="name" value="<? echo $r1[name];?>" size="35" maxlength="64" readonly="readonly" /></td>
        <td><input name="l_name1" type="text" class="textarea_normal" id="l_name1" value="<? echo $r1[l_name1];?>" size="35" maxlength="64" readonly="readonly" /></td>
        <td><input name="l_name2" type="text" class="textarea_normal required" id="l_name2" value="<? echo $r1[l_name2];?>" size="35" maxlength="64" readonly="readonly" /></td>
        <td>
        <input name="ci" id="ci"  type="text" size="25" maxlength="10" class=" textarea_normal required number" value="<? echo $r1[ci];?>"/>
         Exp:
         <select name="expe" id="expe">
<option value="LP">LA PAZ</option>
            <option value="OR">ORURO</option>
            <option value="PT">POTOSI</option>
            <option value="CBBA">COCHABAMBA</option>
            <option value="CH">CHUQUISACA</option>
            <option value="TJA">TARIJA</option>
            <option value="PN">PANDO</option>
            <option value="BN">BENI</option>
            <option value="SCZ">SANTA CRUZ</option>
        </select></td>       
      </tr>
      <tr>
        <td valign="bottom">&nbsp;</td>
        <td valign="bottom">&nbsp;</td>
        <td valign="bottom">&nbsp;</td>
        <td valign="bottom">&nbsp;</td>
      </tr>
      <tr>
        <td valign="bottom">DIRECCION <br /></td>
        <td valign="bottom">TELEFONO DOMICILIO:</td>
        <td valign="bottom">CELULAR:</td>
        <td valign="bottom">FECHA DE NACIMIENTO</td>

      </tr>
      <tr>
        <td><p align="left">
          <input name="adress" type="text" class="textarea_normal required" id="adress" value="<? echo $r1[adress];?>" size="30" maxlength="64" />
        </p>
        <p align="left"> (Ej.  1785/Av. 14 de Septiembre/Obrajes)</p></td>
        <td><div align="left">
          <input name="phone_num" type="text" class="textarea_normal" id="phone_num" value="<? echo $r1[phone_num];?>"  size="25" maxlength="10"/>
        </div></td>
        <td><div align="left">
          <input name="cel_num" type="text" class="textarea_normal required number" id="cel_num" value="<? echo $r1[cel_num];?>"  size="25" maxlength="10"/>
        </div></td>
        <td><div align="left">
          <input name="date_born" type="text" class="textarea_normal required" id="date_born" value="<? echo cambia_dateMy_to_dateN($r1[date_born]);?> " size="20" maxlength="20" readonly="readonly"/>
        </div></td>

      </tr>
      <tr>
        <td colspan="5"><div align="right">
          <br />
          <input type="submit" class="submit" name="save" id="save" value="Guardar" />       
        </div></td>
      </tr>
    </table>
</form>
<div style="background-color:red; padding: 5px; margin-top: 5px; color: #FFF;">
<p>NOTA 1. <strong>Debe llenar la "Dirección" en el formato Numero de Casa, Calle o Avenida, Zona  o Barrio</strong>.</p>
<p>NOTA 2. <strong>Para llenar la "fecha de Nacimiento" debe hacer clic la imagen pequeña del calendario.</strong></p>
<p>NOTA 3. <strong>Si no cuenta con número de TELEFONO DOMICILIO, colocar el número cero (0) en el campo.</strong></p>
</div>
</fieldset>
<?
}
//$db->close();
?>

</body>
</html>