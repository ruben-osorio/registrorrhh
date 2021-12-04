<?

$sw=0;
if (isset($_POST[submit]))
{
	$name=strtoupper($_POST[name]);
	$l_name1=strtoupper($_POST[name2]);
	$l_name2=strtoupper($_POST[name3]);
	$fecha_nac=$_POST[date_born];
	$fech_nac=explode("-",$_POST[date_born]);	
	$dia=$fech_nac[0];
	$mes=$fech_nac[1];
	$ano=$fech_nac[2];
	$username= "$l_name1[0]"."$l_name2[0]"."$name[0]"."$dia"."$mes"."$ano";
	if (isset($username))
	{
		$sw=1;
	}
	
	
	//$date_born=cambia_dateN_to_dateMy_1($date_born);	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Generador de Nombres de Usuarios</title>
<link href="css/reportes.css" rel="stylesheet" type="text/css" />
<link href="js/ui/admincp/jquery-ui-1.8.17.custom.css" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.7.1.min.js"></script>
	<script src="js/ui/jquery.ui.core.js"></script>
	<script src="js/ui/jquery.ui.widget.js"></script>
	<script src="js/ui/jquery.ui.datepicker.js"></script>
	<script>
	$(function() {
		$( ".datepick" ).datepicker({
			showOn: "button",
			changeMonth: true,
			changeYear: true,
			buttonImage: "images/calendar.gif",
			buttonImageOnly: true,
			yearRange: '-100:+0',
		});		
	});
	</script>

</head>

<body>
<div style="position: absolute; left: 50%; margin-left: -350px; ">

<div><img src="images/logo_mini.jpg" width="180" height="55" /></div>
<br />

<form id="form1" name="form1" method="post" action="">
<table width="700" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <th colspan="2" scope="row">IMPORTANTE. Este generador de nombres de usuarios, le dará a conocer como se genera uno de sus datos de acceso para el Sistema de Registro de Personal. </th>
  </tr>
  <tr>
      <th colspan="2" scope="row">GENERADOR DE NOMBRES DE USUARIO</th>
      </tr>
    <tr>
      <th width="33%" scope="row">Nombre(s):</th>
      <td width="67%"><label for="name"></label>
      <input name="name" type="text" id="name" size="40" /></td>
    </tr>
    <tr>
      <th scope="row">Apellido Paterno:</th>
      <td><label for="name2"></label>
      <input name="name2" type="text" id="name2" size="30" /></td>
    </tr>
    <tr>
      <th scope="row">Apellido Materno:</th>
      <td><label for="name3"></label>
      <input name="name3" type="text" id="name3" size="30" /></td>
    </tr>
    <tr>
      <th scope="row">Fecha de Nacimiento:</th>
      <td><label for="date_born"></label>
      <input name="date_born" type="text" id="date_born" readonly="readonly" class="datepick" /></td>
    </tr>
    <tr>
      <td colspan="2" scope="row"><div align="right">
        <input type="submit" name="submit" id="submit" value="Generar" />
      </div></td>
    </tr>
</table><br />
  <? 
  if ($sw==1)
  
  echo '<div style="border: #ffe945 solid 1px; background:#fef6ba; padding: 40px;">Su Nombre de Usuario es: <strong>'.$username.'</strong></div>';?>
</form>
</div>
</body>
</html>