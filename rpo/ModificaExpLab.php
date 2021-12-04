<?php
require_once("security.php");
//$id_func='4';
$id_func=$_GET[id_func];
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
//-----------------------------
//ELIMINAR REGISTRO
$id_exp_lab=$_GET['id_exp_lab'];
//id_datf id_func type_p name l_name1 l_name2 sex born_date pb_nat tn_doc
if(isset($_GET['action'])&&$_GET['action']=='DELETE')
{
$rsdel=$db->query("
DELETE FROM ".TABLE14." 
	WHERE
	id_exp_lab='$id_exp_lab'
	");
}
//-----------------------------
$post_numero = count($_POST);
$con=($post_numero-1)/11;
/*while ($post = each($_POST))
{
echo $post[0] . " = " . $post[1];
}*/
if (isset($_POST[save]))
{
unset($_POST["save"]);
$on_off=1;

//echo $con;
$post_etiquetas = array_keys($_POST); // obtiene los nombres de las varibles
$post_valores= array_values($_POST);// obtiene los valores de las varibles
// crea las variables y les asigna el valor
for($i=0;$i<$post_numero-1;$i++){ 
//--------CONVIERTE MAYUSCULAS
if (stristr($post_etiquetas[$i], "date"))
{	//$post_valores[$i]="2000-10-10";
	$post_valores[$i]=$post_valores[$i];
	}
		$post_valores[$i]=strtoupper($post_valores[$i]);
}
//----------------------------------
//name_inst type_inst form_ent date_ent place_lab charge rea_cha date_start date_end date_ret
//GENERA CONSULTAS
$k=1;
$l=1;
$consulta1="";
$valores1="";
$i=0;
while ($i < $post_numero-1)
{
	if ($i%11==0)
	{
		//echo "posicion $i: ".$post_valores[$i]."<br />";
		$j=$i+1;
		$k=$i+2;
		$l=$i+3;
		$m=$i+4;
		$n=$i+5;
		$o=$i+6;
		$p=$i+7;
		$q=$i+8;
		$r=$i+9;
		$s=$i+10;
		$camp1=$post_valores[$i];
		$camp2=$post_valores[$j];
		$camp3=$post_valores[$k];
		$camp4=$post_valores[$l];
		$camp5=$post_valores[$m];
		$camp6=$post_valores[$n];
		$camp7=$post_valores[$o];
		$camp8=$post_valores[$p];
		$camp9=$post_valores[$q];
		$camp10=$post_valores[$r];
		$camp11=$post_valores[$s];
//		echo "<br />";
//		echo "insert into tablex () values ($camp1,$camp2,$camp3,$camp4,$camp5,$camp6,$camp7,$camp8)";
//		echo "<br />";
//-----------------------------------

//name_inst type_inst form_ent date_ent place_lab charge rea_cha date_start date_end date_ret
	$rs=$db->query("
	UPDATE ".TABLE14." SET
	name_inst='$camp2', type_inst='$camp3', form_ent='$camp4', date_ent='$camp5', place_lab='$camp6', charge='$camp7', rea_cha='$camp8', date_start='$camp9', date_end='$camp10', date_ret='$camp11'
	WHERE
	id_exp_lab='$camp1'");
 
	if(!$rs)
	{echo "error";
	}
//	echo "verdad";		
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
		$( ".datepick" ).datepicker({
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
<!--
stylos
-->
<link href="data/css/style-ext.css" rel="stylesheet" type="text/css">
<link href="css/reportes.css" rel="stylesheet" type="text/css">
<!--
stylos
-->
</head>
<? 
//------------------------------------
//CONSULTA PARA OBTENER DATOS ACADEMICOS
	$rsc2=$db->query("
	SELECT * FROM ".TABLE14." 
	WHERE id_func='$id_func'
	");
//------------------------------------
?>
<body>
<div id="campos">
<form id="form1" name="form1" method="post" action="">
<table width="990" height="42" border="0" align="center" cellpadding="2" cellspacing="0">
    <th width="986">
 	<h2 align="left">EXPERIENCIA LABORAL FUERA DEL MINISTERIO</h2>
    </th>
</table>   
<table width="989" border="0" align="center" cellpadding="2" cellspacing="0">   
<form action="" method="post" name="form1" class="form" id="form2">   
<? 

$c=0;
$f=1;
//name_inst type_inst form_ent date_ent place_lab charge rea_cha date_start date_end date_ret
while ($rex2=$db->fetch_array($rsc2))
	{
echo '<tr><td colspan="6"><h2>EXPERIENCIA LABORAL '.$f.'</h2></td></tr>
	<tr>	
	<input name="id_exp_lab'.$c.'" type="hidden" id="id_exp_lab"  value="'.$rex2[id_exp_lab].'"/>
	<td>
	<LABEL for="name_inst'.$c.'"><strong> NOMBRE DE LA INSTITUCION:</strong></LABEL><input name="name_inst'.$c.'" type="text" id="name_inst'.$c.'" size="30" maxlength="64"  value="'.$rex2[name_inst].'"/>
	</td>
	<td>
	<LABEL for="type_inst"><strong>TIPO:&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</strong></LABEL>
			<select name="type_inst'.$c.'" id="type_inst'.$c.'" >    
                <option value="'.$rex2[type_inst].'">'.$rex2[type_inst].'</option>			    
                <option value="PRIVADA">PRIVADA</option>
                <option value="PUBLICA">PUBLICA</option>
        	</select>
	</td>
	<td>
	<LABEL for="form_ent'.$c.'"><strong>FORMA DE INGRESO:</strong></LABEL><input name="form_ent'.$c.'" type="text" id="form_ent'.$c.'" size="30" maxlength="64"  value="'.$rex2[form_ent].'"/>
	</td>
	<td>
	<LABEL for="date_ent'.$c.'"><strong>FECHA DE INGRESO:</strong></LABEL><input name="date_ent'.$c.'" type="text" id="date_ent'.$c.'" size="30" maxlength="64"  value="'.$rex2[date_ent].'"/>
	</td>
	</tr>
	<tr>
	<td>
	<LABEL for="place_lab'.$c.'"><strong>LUGAR CIUDAD/PAIS:</strong></LABEL><input name="place_lab'.$c.'" type="text" id="place_lab'.$c.'" size="30" maxlength="64"  value="'.$rex2[place_lab].'"/>
	</td>
	<td>
	<LABEL for="charge'.$c.'"><strong>CARGO:&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</strong></LABEL><input name="charge'.$c.'" type="text" id="charge'.$c.'" size="30" value="'.$rex2[charge].'"/>
	<td>
	<LABEL for="rea_cha'.$c.'"><strong>MOTIVO DE CAMBIO DE PUESTO:</strong></LABEL><input name="rea_cha'.$c.'" type="text" id="rea_cha'.$c.'" size="30" maxlength="64"  value="'.$rex2[rea_cha].'"/>
	</td>
	<td>
	<LABEL for="date_start'.$c.'"><strong>DEL: &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</strong></LABEL><input name="date_start'.$c.'" type="text" id="date_start'.$c.'" size="30" maxlength="64"  value="'.$rex2[date_start].'"/>
	</td>
	</tr>
	<tr>	
	<td>
	<LABEL for="date_end'.$c.'"><strong>AL: &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</strong></LABEL><input name="date_end'.$c.'" type="text" id="date_end'.$c.'" size="30" maxlength="64"  value="'.$rex2[date_end].'"/>
	</td>
	<td>
	<LABEL for="date_ret'.$c.'"><strong>FECHA DE RETIRO: &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp </strong></LABEL><input name="date_ret'.$c.'" type="text" id="date_ret'.$c.'" size="30" maxlength="64"  value="'.$rex2[date_ret].'"/>
	</td>
	</tr>
	<td colspan="4">
	<div class="errorre"><a href="?id_exp_lab='.$rex2[id_exp_lab].'&&id_func='.$rex2[id_func].'&action=DELETE">BORRAR DATOS DE  EXPERIENCIA LABORAL '.$f.'</a><div>
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