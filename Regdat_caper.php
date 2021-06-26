<?
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
//----------HABILITAR TABLA-------------
	$rsp1=$db->query("
	SELECT p6 FROM ".TABLE37." 
	WHERE id_func='$id_func'
	");
	$rsxp1=$db->fetch_array($rsp1);
	if($rsxp1[p6]==1)
	{
	header ("Location: exito.php");	
	}
//--------------------------------------
if (isset($_POST[save]))
{ //id_eval_per id_char_per date_eval res_eval cons_eval resp_eval type_resp TABLE20: eval_per
$date_eval=cambia_dateN_to_dateMy_1($_POST[date_eval]); 
echo $date_eval;
$res_eval=$_POST[res_eval];
$cons_eval=$_POST[cons_eval]; 
$resp_eval= strtoupper($_POST[resp_eval]);
$type_resp=$_POST[type_resp]; 
//id_eval_per id_char_per date_eval res_eval cons_eval resp_eval type_resp 
	echo "
	INSERT INTO ".TABLE20."(date_eval, res_eval, cons_eval, resp_eval, type_resp)
	VALUES 
	('$date_eval', '$res_eval', '$cons_eval', '$resp_eval', '$type_resp')";
	
	$rs=$db->query("
	INSERT INTO ".TABLE20." 
	(date_eval, res_eval, cons_eval, resp_eval, type_resp)
	VALUES 
	('$date_eval', '$res_eval', '$cons_eval', '$resp_eval', '$type_resp')
	");
	if(!$rs)
	{echo "error";
	}
	echo "verdad";
	
}

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FORMULARIO DE REGISTRO</title>
<link href="css/style-ext.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="screen" href="css/screen.css" />
<script src="data/js/jquery-1.7.1.min.js"></script>
<!--<script src="js/jquery.js" type="text/javascript"></script>-->
<script src="js/jquery.metadata.js" type="text/javascript"></script>
<script src="js/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">
$.metadata.setType("attr", "validate");
$(document).ready(function() {
	$("#form1").validate();	
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
		$( ".datpick" ).datepicker({
			showOn: "button",
			buttonImage: "data/images/calendar.gif",
			buttonImageOnly: true, changeMonth: true, changeYear: true, yearRange: '-100:+0',
		});
	});
	</script>
<form id="form1" name="form1" method="post" action="">
<table width="990" border="0" align="center" cellpadding="2" cellspacing="0">
<td width="607"><h2>EVALUACIONES (Especifique la última evaluación que tuvo en la institución):</h2></td>
</table>
<table width="990" border="0" align="center" cellpadding="2" cellspacing="0">
	<tr>
  		<td width="153">FECHA DE EVALUACIÓN:</td>
    	<td width="136">RESULTADO DE LA EVALUACIÓN:</td>
    	<td width="236">CONSECUENCIA DE LA EVALUACIÓN:</td>
    	<td width="215">RESPONSABLE DE LA EVALUACIÓN (NOMBRE COMPLETO)</td>
    	<td width="230">TIPO DE RESPONSABLE</td>
	</tr>
	<tr>
  	<td>
    	<input name="date_eval" type="text" id="date_eval" size="15" maxlength="64" class="datpick"/></td>
	<td>
        <select name="res_eval" id="res_eval" >
          <option value="BUENO">BUENO</option>
          <option value="MALO">MALO</option>
          <option value="EXCELENTE">EXCELENTE</option>
          <option value="MUY BUENO">MUY BUENO</option>
          <option value="REGULAR">REGULAR</option>
        </select>
    </td>    
   	<td>
    	<select name="cons_eval" id="cons_eval" >
    	  <option value="CAPACITACIÓN">CAPACITACIÓN</option>
    	  <option value="PROMOCIÓN">PROMOCIÓN</option>
    	  <option value="CONFIRMACIÓN DE PUESTO">CONFIRMACIÓN DE PUESTO</option>
    	  <option value="RETIRO">RETIRO</option>
    	  <option value="TRANSFERENCIA">TRANSFERENCIA</option>
    	  <option value="ROTACIÓN">ROTACIÓN</option>
    	  <option value="OTROS">OTROS</option>
        </select>
    </td>    
	<td>
    	<input name="resp_eval" type="text" id="resp_eval" size="30" maxlength="64" />
    </td>        
    <td>
    	<select name="type_resp" id="type_resp" >
    	  <option value="MÁXIMA AUTORIDAD">MÁXIMA AUTORIDAD</option>
    	  <option value="INMEDIATO SUPERIOR">INMEDIATO SUPERIOR</option>
    	  <option value="UNIDAD DE PERSONAL">UNIDAD DE PERSONAL</option>
    	  <option value="OTRA INSTANCIA">OTRA INSTANCIA</option>
        </select>
    </td>
	</tr>
<!--1-->
	<td>
	<input type="submit" name="save" id="save" value="Enviar" />
    </td>
</tr>

  	
</table>
</form>

<?

//$db->close();
?>

</body>
</html>