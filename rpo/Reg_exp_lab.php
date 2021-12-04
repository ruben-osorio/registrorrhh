<?php
require_once("security.php");
$id_func=$_GET['id_func'];
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
//----------HABILITAR TABLA-------------
	$rsp1=$db->query("
	SELECT p5 FROM ".TABLE37." 
	WHERE id_func='$id_func'
	");
	$rsxp1=$db->fetch_array($rsp1);
	if($rsxp1[p5]==1)
	{
	header ("Location: exito.php");	
	}
//--------------------------------------
$post_numero = count($_POST);
$con=($post_numero-1)/10;
/*while ($post = each($_POST))
{
echo $post[0] . " = " . $post[1];
}*/
if (isset($_POST[save]))
{
unset($_POST["save"]);
$on_off=0;

//echo $con;
$post_etiquetas = array_keys($_POST); // obtiene los nombres de las varibles
$post_valores= array_values($_POST);// obtiene los valores de las varibles
// crea las variables y les asigna el valor
for($i=0;$i<$post_numero-1;$i++){ 
//--------CONVIERTE MAYUSCULAS
if (stristr($post_etiquetas[$i], "date"))
{	//$post_valores[$i]="2000-10-10";
	$post_valores[$i]=cambia_dateN_to_dateMy_1($post_valores[$i]);
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
	if ($i%10==0)
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
//		echo "<br />";
//		echo "insert into tablex () values ($camp1,$camp2,$camp3,$camp4,$camp5,$camp6,$camp7,$camp8)";
//		echo "<br />";
//-----------------------------------

//name_inst type_inst form_ent date_ent place_lab charge rea_cha date_start date_end date_ret
	$rs=$db->query("
	INSERT INTO ".TABLE14." 
	(id_func,name_inst, type_inst, form_ent, date_ent, place_lab, charge, rea_cha, date_start, date_end, date_ret)
	VALUES 
	('$id_func','$camp1','$camp2','$camp3','$camp4','$camp5','$camp6','$camp7','$camp8','$camp9','$camp10')");
	 
	if(!$rs)
	{echo "error";
	}
//	echo "verdad";		
//-----------------------------------
	}	
	$i++;
}
	//-------------DESABILITAR TABLA------------
	$rs2=$db->query("
	UPDATE ".TABLE37." SET p5='$on_off'
	WHERE id_func='$id_func'
	");	
//-----------------------------------
header ("Location: exito.php");	
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

<!-- 



-->



<script type="text/javascript">
c=0;
function agregar() {
	c=c+1;
	$(".campos").append('<div class="email'+c+'" style = "display: inline-block; margin-left: auto; margin-right: auto; width: 1033px ; "><div id="cab">NOMBRE DE LA INSTITUCION:</div><div id="cab">TIPO:</div><div id="cab">FORMA DE INGRESO:</div><div id="cab">FECHA DE INGRESO:</div><div id="cab"><input name="name_inst'+c+'" type="text" id="name_inst'+c+'" size="30" maxlength="1000" class="required" /></div><div id="cab"><select name="type_inst'+c+'" id="type_inst'+c+'"><option value="PRIVADA">PRIVADA</option><option value="PÚBLICA">PÚBLICA</option></select></div><div id="cab"><input name="form_ent'+c+'" type="text" id="form_ent'+c+'" size="30" maxlength="64" class="required"/></div><div id="cab"><input name="date_ent'+c+'" type="text" id="date_ent'+c+'" size="15" maxlength="64" class="datepick" readonly="readonly"/></div><div id="cab">LUGAR (CIUDAD/PAIS):</div><div id="cab">CARGOS DESEMPEÑADOS:</div><div id="cab">MOTIVO CAMBIO DE PUESTO:</div><div id="cab"></div><div id="cab"><input name="place_lab'+c+'" type="text" id="place_lab'+c+'" size="25" maxlength="64" class="required"/></div><div id="cab"><input name="charge'+c+'" type="text" id="charge'+c+'" size="20" maxlength="1000" class="required"/></div><div id="cab"><input name="rea_cha'+c+'" type="text" id="rea_cha'+c+'" size="20" maxlength="64" class="required"/></div><div id="cab"></div><div id="cab">DEL :</div><div id="cab">AL:</div><div id="cab">FECHA DE RETIRO:</div><div id="cab"></div><div id="cab"><input name="date_start'+c+'" type="text" id="date_start'+c+'" size="15" maxlength="64" class="datepick" readonly="readonly"/></div><div id="cab"><input name="date_end'+c+'" type="text" id="date_end'+c+'" size="15" maxlength="64" class="datepick" readonly="readonly"/></div><div id="cab"><input name="date_ret'+c+'" type="text" id="date_ret'+c+'" size="15" maxlength="64" class="datepick" readonly="readonly"/></div><div id="espa"></div><div id="cabmid" class="btn1r"><a href="#" onclick="javascript:borrar('+c+');">BORRAR REGISTRO</a></div></div>');
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
	
}
function borrar(cual) {
	$("div.email"+cual).remove();
	return false;
}
	
</script>
<script>
function probar(){
if (!(confirm('¿Esta seguro de GUARDAR esta información, ya que luego NO PODRÁ MODIFICARLA? \n\rHaga click en "CANCELAR" si desea Revisar sus Datos, si está seguro del contenido de la información que esta enviando haga click en "ACEPTAR"'))){ 
       return false; 
	   
	   } 
}
</script>
<script>
function cerrar() {
div = document.getElementById('flotante');
div.style.display='none';
}
</script>
</head>

<body id="bd">
<div id="campos" style="margin-left:70px;">
<img src="data/images/explabf.jpg" width="1032" height="50" /><br />

<form id="form1" name="form1" method="post" action="" class="form">
  <div id="campos1" class="campos">
<!-- TABLA A REPETIR-->
  		<div id="cab">NOMBRE DE LA INSTITUCION:</div>
  		<div id="cab">TIPO:</div>
  		<div id="cab">FORMA DE INGRESO:</div>
    	<div id="cab">FECHA DE INGRESO:</div>
      	<div id="cab">
  			<input name="name_inst " type="text" id="name_inst " size="30" maxlength="1000" class="required" />
   		</div>
  		<div id="cab">
  			<select name="type_inst" id="type_inst" >        
        	<option value="PRIVADA">PRIVADA</option>
        	<option value="PUBLICA">PUBLICA</option>
            </select>
   		</div>
  		<div id="cab">
  			<input name="form_ent " type="text" id="form_ent" size="30" maxlength="64" class="required"/>
   		</div>
  		<div id="cab">
  			<input name="date_ent " type="text" class="datepick" id="date_ent" size="15" maxlength="64" readonly="readonly"/>
   		</div>
		<div id="cab">LUGAR (CIUDAD/PAIS):</div>
        <div id="cab">CARGO DESEMPEÑADOS:</div>
        <div id="cab">MOTIVO CAMBIO DE PUESTO:</div>
  		<div id="cab"></div>
    	
    	<div id="cab">
  			<input name="place_lab" type="text" id="place_lab" size="25" maxlength="64" class="required"/>
   		</div>
        
        <div id="cab">
  			<input name="charge" type="text" id="charge" size="20" maxlength="1000" class="required"/>
   		</div>	
        <div id="cab">
  			<input name="rea_cha" type="text" id="rea_cha" size="20" maxlength="64" class="required"/>
   		</div>	
        
 		<div id="cab"></div>
		<div id="cab">DEL :</div>
        <div id="cab">AL:</div>
        <div id="cab">FECHA DE RETIRO:</div>
        <div id="cab"></div>
         <div id="cab">
           <input name="date_start" type="text" class="datepick" id="date_start" size="15" maxlength="64" readonly="readonly"/>
         </div>
         <div id="cab">
           <input name="date_end" type="text" class="datepick" id="date_end" size="15" maxlength="64" readonly="readonly"/>
         </div>
        <div id="cab">
          <input name="date_ret" type="text" class="datepick" id="date_ret" size="15" maxlength="64" readonly="readonly"/>
		</div>
		<div id="espa"></div>
        <DIV style="clear:both;">
  		<div id="cabmid" class="btn1"><a href="javascript:agregar();">Agregar Registro</a></div>
 		<input type="submit" class="submit" onclick="return probar()" name="save" id="loginbutton" value="Guardar" />
		</DIV>
    <!-- FIN -->
</div>
</form><br />
<div style=" background: #9F6; border: 1px #0F0 solid; padding: 5px; width:600px; position: relative;left: 50%;margin-left: -300px; margin-bottom:10px; font-size:13px;" id="flotante"> EN ESTA VENTANA UD. PUEDE LLENAR DATOS PARA 2 REGISTROS Y GUARDARLOS, SI TIENE MAS DATOS PARA LLENAR PUEDE VOLVER A ABRIR ESTA VENTANA Y CONTINUAR REGISTRANDO. <strong><br />
ESTA VENTANA QUEDARÁ SIEMPRE ABIERTA PARA QUE PUEDA REGISTRAR MAS DATOS</strong> 
<div style=" margin-top:10px; float:right; position:relative; "><a href="javascript:cerrar();" style="color:#FFF; font-weight:bold; text-decoration:none;"> Cerrar Mensaje <img src="data/images/close.png"></a> </div>
</div>
<table width="990" border="0" cellspacing="0" cellpadding="5" id="ftab" align="center" style="font-size:12px;">
  <tr>
    <th scope="col">IMPORTANTE</th>
  </tr>
  <tr>
    <td  id="ftd">
      <ul>
        <li>El presente Formulario constituye una <strong>Declaración Jurada </strong>de la veracidad de la información y datos contenidos en el mismo.</li>
        <li> De comprobarse la falsedad de algún dato o información declarado, el Declarante será
          sujeto de sanciones según lo determinado por la normativa vigente. </li>
        <li>El contenido de la presente declaración es de exclusiva y única responsabilidad
        del declarante.</li>
      </ul>    </td>
  </tr>
</table>

</body>
</html>