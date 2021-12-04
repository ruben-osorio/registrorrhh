<?php
require_once("security.php");
//$id_func=4;
$id_func=$_GET[id_func];
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
//-----------------------------
//ELIMINAR REGISTRO
$id_cap=$_GET['id_cap'];
//id_datf id_func type_p name l_name1 l_name2 sex born_date pb_nat tn_doc
if(isset($_GET['action'])&&$_GET['action']=='DELETE')
{
$rsdel=$db->query("
DELETE FROM ".TABLE21." 
	WHERE
	id_cap='$id_cap'
	");
}
//-----------------------------
$post_numero = count($_POST);
$con=($post_numero-1)/9;
/*while ($post = each($_POST))
{
echo $post[0] . " = " . $post[1];
}*/
if (isset($_POST[save]))
{
unset($_POST["save"]);
//echo $con;
$post_etiquetas = array_keys($_POST); // obtiene los nombres de las varibles
$post_valores= array_values($_POST);// obtiene los valores de las varibles
// crea las variables y les asigna el valor
for($i=0;$i<$post_numero-1;$i++){ 
//--------CONVIERTE MAYUSCULAS
if (stristr($post_etiquetas[$i], "date"))
{	//$post_valores[$i]="2000-10-10";
	$post_valores[$i]=$post_valores[$i];
	//echo $post_valores[$i];
	}
		$post_valores[$i]=strtoupper($post_valores[$i]);
		//echo $post_valores[$i];
}
//----------------------------------
//id_cap id_func date_start date_end name_event type_cap name_inst place num_hrs TABLE21=capacitacion 
//GENERA CONSULTAS
$k=1;
$l=1;
$consulta1="";
$valores1="";
$i=0;
while ($i < $post_numero-1)
{
	if ($i%8==0)
	{
		//echo "posicion $i: ".$post_valores[$i]."<br />";
		$j=$i+1;
		$k=$i+2;
		$l=$i+3;
		$m=$i+4;
		$n=$i+5;
		$o=$i+6;
		$p=$i+7;
		$camp1=$post_valores[$i];
		$camp2=$post_valores[$j];
		$camp3=$post_valores[$k];
		$camp4=$post_valores[$l];
		$camp5=$post_valores[$m];
		$camp6=$post_valores[$n];
		$camp7=$post_valores[$o];
		$camp8=$post_valores[$p];
/*		echo "<br />";
		echo "	UPDATE".TABLE21." SET 
	date_start='$camp2', date_end='$camp3', name_event='$camp4', type_cap='$camp5', name_inst='$camp6', place='$camp7', num_hrs='$camp8'
	WHERE
	id_cap='$camp1'";
		echo "<br />";*/
//-----------------------------------

//id_cap id_func date_start date_end name_event type_cap name_inst place num_hrs TABLE21=capacitacion 
	$rs=$db->query("
	UPDATE ".TABLE21." SET 
	date_start='$camp2', date_end='$camp3', name_event='$camp4', type_cap='$camp5', name_inst='$camp6', place='$camp7', num_hrs='$camp8'
	WHERE
	id_cap='$camp1'
	");
	 
	if(!$rs)
	{echo "error";
	}
	//echo "verdad";		
//-----------------------------------
	}	
	$i++;
}
//--------CONVIERTE MAYUSCULAS--------FIN
//		//GENERA CONSULTAS		
//
///*		$valores1.= "$post_valores[$i],";
//		if($k/8==1){
//		$consulta.$l="";
//		$valores.$l="";
//		$l++;
//		}
//		$k++;
//*/
//	}
////	
//	$valores1=implode(", ", $post_valores);
//	echo $valores1;
//	for($i=0;$i<$post_numero-1;$i++){ 
//	echo("<br>POST[".$post_etiquetas[$i]."]=".$post_valores[$i]); 
//	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="estilo.css" type="text/css" media="all">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="jquery-1.4.1.min.js"></script>
<!-- FECHA -->
	<link rel="stylesheet" type="text/css" media="screen" href="css/screen.css" />
	<link href="data/css/style-ext.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="data/css/ui/admincp/jquery-ui-1.8.17.custom.css">
	<script src="data/js/jquery-1.7.1.min.js"></script>
    <!-- VALIDATE -->
    <script src="js/jquery.metadata.js" type="text/javascript"></script>
	<script src="js/jquery.validate.js" type="text/javascript"></script>
    <script type="text/javascript">
	$.metadata.setType("attr", "validate");
	$(document).ready(function() {
	$("#form1").validate();	
	});
</script>
    <!-- VALIDATE -->
    <script type="text/javascript">
	$(document).ready(function(){
    $.validator.addMethod(
    "myDateChecker",
    function(value, element) {
        // put your own logic here, this is just a (crappy) example
        return value.match(/^\d\d?\-\d\d?\-\d\d\d\d$/);
    },
    "Por favor ingrese una fecha válida."
);
    $("#myFormId").validate({
        rules: {
            date: "myDateChecker"
        }
    });
});
	
    </script>
        
    
	<script src="data/js/ui/jquery.ui.core.js"></script>
	<script src="data/js/ui/jquery.ui.widget.js"></script>
	<script src="data/js/ui/jquery.ui.datepicker.js"></script>
	<link rel="stylesheet" href="data/css/ui/demos.css" >

	<script>
	$(function() {
		$( ".datpick" ).datepicker({
			changeMonth: true,
			changeYear: true,
			showOn: "button",
			yearRange: '-100:+0',
			buttonImage: "data/images/calendar.gif",
			buttonImageOnly: true
		});
	});
</script>
<script>
function probar(){
if (!(confirm('¿Esta seguro de GUARDAR esta información, ya que luego NO PODRÁ MODIFICARLA? \n\rHaga click en "CANCELAR" si desea Revisar sus Datos, si está seguro del contenido de la información que esta enviando haga click en "ACEPTAR"'))){ 
       return false; 
	   
	   } 
}
</script>
</head>
<? 
//------------------------------------
//CONSULTA PARA OBTENER DATOS ACADEMICOS
	$rsc2=$db->query("
	SELECT * FROM ".TABLE21." 
	WHERE id_func='$id_func'
	");
//------------------------------------
?>
<!--
stylos
-->
<link href="data/css/style-ext.css" rel="stylesheet" type="text/css">
<link href="css/reportes.css" rel="stylesheet" type="text/css">
<!--
stylos
-->
<body>
<div id="campos">
<form id="form1" name="form1" method="post" action="">
<table width="990" height="42" border="0" align="center" cellpadding="2" cellspacing="0">
    <th width="986">
 	<h2 align="left">CAPACITACION</h2>
    </th>
</table>   
<table width="989" border="0" align="center" cellpadding="2" cellspacing="0">   
<form action="" method="post" name="form1" class="form" id="form2">   
<? 

$c=0;
$f=1;
//id_cap id_func date_start date_end name_event type_cap name_inst place num_hrs TABLE21=capacitacion 
while ($rex2=$db->fetch_array($rsc2))
	{
echo '<tr><td colspan="6"><H2>CAPACITACION '.$f.'</h2></td></tr>
	<tr>	
	<input name="id_cap'.$c.'" type="hidden" id="id_cap"  value="'.$rex2[id_cap].'"/>
	<td>
	<LABEL for="date_start'.$c.'"><strong> FECHA DE INICIO:</strong></LABEL><input name="date_start'.$c.'" type="text" id="date_start'.$c.'" size="30" maxlength="64"  value="'.$rex2[date_start].'"/>
	</td>
	<td>
	<LABEL for="date_end'.$c.'"><strong>FECHA FIN:</strong></LABEL><input name="date_end'.$c.'" type="text" id="date_end'.$c.'" size="30" maxlength="64"  value="'.$rex2[date_end].'"/>
	</td>
	<td>
	<LABEL for="name_event'.$c.'"><strong>NOMBRE DEL EVENTO:</strong></LABEL><input name="name_event'.$c.'" type="text" id="name_event'.$c.'" size="30" maxlength="64"  value="'.$rex2[name_event].'"/>
	</td>
	<td>
	<LABEL for="type_cap'.$c.'"><strong>CAPACITACION:</strong></LABEL>
			<select name="type_cap'.$c.'" id="type_cap'.$c.'" >    
                <option value="'.$rex2[type_cap].'">'.$rex2[type_cap].'</option>			    
                <option value="INTERNA">INTERNA</option>
                <option value="EXTERNA">EXTERNA</option>
        	</select>
	</td>
	</tr>
	<tr>
	<td>
	<LABEL for="name_inst'.$c.'"><strong>NOMBRE DE LA INSTITUCION:</strong></LABEL><input name="name_inst'.$c.'" type="text" id="name_inst'.$c.'" size="30" maxlength="64"  value="'.$rex2[name_inst].'"/>
	</td>
	<td>
	<LABEL for="place'.$c.'"><strong>LUGAR CIUDAD/PAIS:</strong></LABEL><input name="place'.$c.'" type="text" id="place'.$c.'" size="30" maxlength="64"  value="'.$rex2[place].'"/>
	<td>
	<LABEL for="num_hrs'.$c.'"><strong>NUMERO DE HORAS:</strong></LABEL><input name="num_hrs'.$c.'" type="text" id="num_hrs'.$c.'" size="30" maxlength="64"  value="'.$rex2[num_hrs].'"/>
	</td>
	</tr>
	<td colspan="4">
	<div class="errorre"><a href="?id_cap='.$rex2[id_cap].'&&id_func='.$rex2[id_func].'&action=DELETE">BORRAR DATOS DE  CAPACITACIÓN '.$f.'</a><div>
	</td>
	';
	$c++;
	$f++;
	}
?>
    <tr>
  	<td><input type="submit" class="submit" id="loginbutton" name="save" value="Guardar" /></td>
 	</tr>
</table>
</form>
</body>
</html>