<?php
require_once("security.php");
//$id_func=1;
$id_func=$_GET[id_func];
$id_con=$_GET[id_con];

require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
//-----------------------------
//ELIMINAR REGISTRO
$id_old_mov=$_GET['id_old_mov'];
//id_datf id_func type_p name l_name1 l_name2 sex born_date pb_nat tn_doc
if(isset($_GET['action'])&&$_GET['action']=='DELETE')
{
	
$rsdel=$db->query("
DELETE FROM ".TABLE34." 
	WHERE
	id_old_movc='$id_old_mov'
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
//	echo $post_valores[$i];
	}
		$post_valores[$i]=strtoupper($post_valores[$i]);
//		echo $post_valores[$i];
}
//----------------------------------
//id_old_mov id_func charge rea_chan num_res gral_dir unit area date_start date_end TABLE: old_mov
//GENERA CONSULTAS
$k=1;
$l=1;
$consulta1="";
$valores1="";
$i=0;
while ($i < $post_numero-1)
{
	if ($i%9==0)
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
		$camp1=$post_valores[$i];
		$camp2=$post_valores[$j];
		$camp3=$post_valores[$k];
		$camp4=$post_valores[$l];
		$camp5=$post_valores[$m];
		$camp6=$post_valores[$n];
		$camp7=$post_valores[$o];
		$camp8=$post_valores[$p];
		$camp9=$post_valores[$q];
/*		echo "<br />";
		echo "insert into tablex () values ($camp1,$camp2,$camp3,$camp4,$camp5,$camp6,$camp7,$camp8)";
		echo "<br />";*/
//-----------------------------------

//id_old_mov id_func charge rea_chan num_res gral_dir unit area date_start date_end TABLE: old_mov
	$rs=$db->query("
	UPDATE ".TABLE34." SET
	charge='$camp2', rea_chan='$camp3', num_res='$camp4', gral_dir='$camp5', unit='$camp6', area='$camp7', date_start='$camp8', date_end='$camp9'
	WHERE
	id_old_movc='$camp1'
	");
	 
	if(!$rs)
	{exit;
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
    <link href="estilo.css" rel="stylesheet" type="text/css">
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
	SELECT * FROM ".TABLE34." 
	WHERE id_con='$id_con'
	");
//------------------------------------
?>
<body>
<div id="campos">
<form id="form1" name="form1" method="post" action="">
<table width="990" height="42" border="0" align="center" cellpadding="2" cellspacing="0">
    <th width="986">
 	<h2 align="left">DATOS MOVILIDAD</h2>
    </th>
</table>   
<table width="989" border="0" align="center" cellpadding="2" cellspacing="0">   
<form action="" method="post" name="form1" class="form" id="form2">   
<? 
$c=0;
$f=1;
//id_old_mov id_func charge rea_chan num_res gral_dir unit area date_start date_end TABLE: old_mov
while ($rex2=$db->fetch_array($rsc2))
	{
echo '
<tr><td colspan="4"><H2>MOVILIDAD '.$f.'</h2></td></tr>
	<tr>	
	<input name="id_old_movc'.$c.'" type="hidden" id="id_old_movc"  value="'.$rex2[id_old_movc].'"/>
	<td>
	<LABEL for="charge'.$c.'"><strong> CARGO EN LA INSTITUCION:</strong></LABEL><input name="charge'.$c.'" type="text" id="charge'.$c.'" size="30" maxlength="64"  value="'.$rex2[charge].'"/>
	</td>
	<td>
	<LABEL for="rea_chan'.$c.'"><strong>MOTIVO CAMBIO DE PUESTO:</strong></LABEL><input name="rea_chan'.$c.'" type="text" id="rea_chan'.$c.'" size="30" maxlength="64"  value="'.$rex2[rea_chan].'"/>
	</td>
	<td>
	<LABEL for="num_res'.$c.'"><strong>NÚMERO DE RESOLUCIÓN O MEMO:</strong></LABEL><input name="num_res'.$c.'" type="text" id="num_res'.$c.'" size="30" maxlength="64"  value="'.$rex2[num_res].'"/>
	</td>
	<td>
	<LABEL for="gral_dir'.$c.'"><strong>DIRECCIÓN GENERAL:</strong></LABEL><input name="gral_dir'.$c.'" type="text" id="gral_dir'.$c.'" size="30" maxlength="64"  value="'.$rex2[gral_dir].'"/>
	</td>
	</tr>
	<tr>
	<td>
	<LABEL for="unit'.$c.'"><strong>UNIDAD: &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</strong></LABEL><input name="unit'.$c.'" type="text" id="unit'.$c.'" size="30" maxlength="64"  value="'.$rex2[unit].'"/>
	</td>
	<td>
	<LABEL for="area'.$c.'"><strong>AREA:  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp </strong></LABEL><input name="area'.$c.'" type="text" id="area'.$c.'" size="30" maxlength="64"  value="'.$rex2[area].'"/>
	<td>
	<LABEL for="date_start'.$c.'"><strong>DE FECHA:</strong></LABEL><input name="date_start'.$c.'" type="text" id="date_start'.$c.'" size="30" maxlength="64"  value="'.$rex2[date_start].'"/>
	</td>
		<td>
	<LABEL for="date_end'.$c.'"><strong>A FECHA:  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp </strong></LABEL><input name="date_end'.$c.'" type="text" id="date_end'.$c.'" size="30" maxlength="64"  value="'.$rex2[date_end].'"/>
	</td>
	</tr>
	<td colspan="4">
	<div class="errorre"><a href="?id_old_mov='.$rex2[id_old_movc].'&&id_per='.$rex2[id_con].'&action=DELETE">BORRAR DATOS DE MOVILIDAD '.$f.'</a><div>
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