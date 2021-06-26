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
	SELECT p3 FROM ".TABLE37." 
	WHERE id_func='$id_func'
	");
	$rsxp1=$db->fetch_array($rsp1);
	if($rsxp1[p3]==1)
	{
	header ("Location: exito.php");	
	}
//--------------------------------------
$post_numero = count($_POST);
$con=($post_numero-1)/18;
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





//GENERA CONSULTAS
$k=1;
$l=1;
$consulta1="";
$valores1="";
$i=0;
while ($i < $post_numero-1)
{
	if ($i%18==0)
	{
/*		echo "posicion de $i: ".$post_valores[$i]."<br />";*/
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
		$t=$i+11;
		$u=$i+12;
		$v=$i+13;
		$w=$i+14;
		$x=$i+15;
		$y=$i+16;
		$z=$i+17;
		
		
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
		$camp12=$post_valores[$t];
		$camp13=$post_valores[$u];
		$camp14=$post_valores[$v];
		$camp15=$post_valores[$w];
		$camp16=$post_valores[$x];
		$camp17=$post_valores[$y];
		$camp18=$post_valores[$z];
//-----------------------------------
/*		echo "<br />";
		echo "insert into tablex () values ($camp1,$camp2,$camp3,$camp4,$camp5,$camp6,$camp7,$camp8,$camp9,$camp10,$camp11,$camp12,$camp13,$camp14,$camp15,$camp16,$camp17,$camp18)";
		echo "<br />";*/
//-----------------------------------

//level date_start date_end date career_esp name_inst end city country acad_title revala inst_revala date_exp_a num_tit_a prov_nat_title revalp inst_revalp date_exp_p num_tit_p 

	$rs=$db->query("
	INSERT INTO ".TABLE1." 
	(id_func,level, date_start, date_end, career_esp, name_inst, end, city, country, acad_title, revala, inst_revala, date_exp_a, num_tit_a, prov_nat_title, revalp, inst_revalp, date_exp_p, num_tit_p)
	VALUES 
('$id_func','$camp1','$camp2','$camp3','$camp4','$camp5','$camp6','$camp7','$camp8','$camp9','$camp10','$camp11','$camp12','$camp13','$camp14','$camp15','$camp16','$camp17','$camp18')");
//-------------DESABILITAR TABLA------------
	$rs2=$db->query("
	UPDATE ".TABLE37." SET p3='$on_off'
	WHERE id_func='$id_func'
	");	
header ("Location: exito.php");	
//-----------------------------------
	if(!$rs&&!$rs2)
	{exit;
	}
	//echo "verdad";		
//-----------------------------------
	}	
	$i++;
}
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

<!-- ------- -->



<script type="text/javascript">
c=0;
function agregar() {
	c=c+1;
	$(".campos").append('<div class="email'+c+'"><div id="cab">NIVEL:</div><div id="cab">FECHA INICIO:</div><div id="cab">FECHA FIN:</div><div id="cab">CARRERA (AREA DE FORMACION ESPECIALIDAD):(*)</div><div id="cab"><select name="level'+c+'" id="level'+c+'" style="width:175px;"><option value="PRE-GRADO">Pre-grado</option>                <option value="EGRESADO">Egresado</option><option value="CERTIFICACION COMPETENCIAS">Cert. Competencias</option>   <option value="TÉCNICO MEDIO">Técnico Medio</option><option value="TÉCNICO SUPERIOR">Técnico Superior</option>     <option value="BACHELLOR">Bachellor</option><option value="LICENCIATURA">Licenciatura</option><option value="Especialidad">Especialidad</option><option value="POSTGRADO">Post-grado</option><option value="MAESTRIA">Maestría</option><option value="DOCTORADO">Doctorado</option><option value="PH.D.">Ph.d.</option></select></div><div id="cab"><input name="date_start'+c+'" type="text" id="date_start'+c+'" size="25" maxlength="64" class="datpick" readonly="readonly"/></div><div id="cab"><input name="date_end'+c+'" type="text" id="date_end'+c+'" size="25" maxlength="64" class="datpick" readonly="readonly"/></div><div id="cab"><input name="career_esp'+c+'" type="text" id="career_esp'+c+'" size="35" class="required" /></div><div id="cab">NOMBRE INSTITUCIÓN: (*)</div><div id="cab">CONCLUIDA:</div><div id="cab">LUGAR (CIUDAD):</div><div id="cab">PAIS:</div><div id="cab"><input name="name_inst'+c+'" type="text" id="name_inst'+c+'" size="35" maxlength="64" class="required" /></div><div id="cab"><select name="end'+c+'" id="end'+c+'" ><option value="1">SI</option><option value="0">NO</option></select></div><div id="cab"><input name="city'+c+'" type="text" id="city'+c+'" size="35" maxlength="64" class="required" /></div><div id="cab">	<input name="country'+c+'" type="text" id="country'+c+'" size="35" maxlength="64" class="required" />	</div><div id="cabmid">TÍTULO ACÁDEMICO: (*)</div><div id="cabmid">REVALIDADO:</div><div id="cab">INSTITUCION QUE LO REVALIDA:</div><div id="cab">FECHA DE EXPEDICIÓN:</div><div id="cab">NÚMERO TÍTULO:</div><div id="cabmid"><select name="acad_title'+c+'" id="acad_title'+c+'" ><option value="0">NO</option><option value="1">SI</option></select></div><div id="cabmid"><select name="revala'+c+'" id="revala'+c+'" ><option value="1">SI</option><option value="0">NO</option></select></div><div id="cab"><input name="inst_revala'+c+'" type="text" id="inst_revala'+c+'" size="35" maxlength="64" /></div><div id="cab"><input name="date_exp'+c+'" type="text" id="date_exp'+c+'" size="25" maxlength="64" class="datpick" readonly="readonly" /></div><div id="cab"><input name="num_tit'+c+'" type="text" id="num_tit'+c+'" size="25" maxlength="64" /></div><div id="cabmid">TIT.PROV. NAL.: (*)</div><div id="cabmid">REVALIDADO:</div><div id="cab">INSTITUCION QUE LO REVALIDA:</div><div id="cab">FECHA DE EXPEDICIÓN</div><div id="cab">NÚMERO TÍTULO:</div><div id="cabmid">  		<select name="prov_nat_title'+c+'" id="prov_nat_title'+c+'" ><option value="0">NO</option><option value="1">SI</option></select></div><div id="cabmid"><select name="revalp'+c+'" id="revalp'+c+'" ><option value="1">SI</option><option value="0">NO</option></select></div>  		<div id="cab"><input name="inst_revalp'+c+'" type="text" id="inst_revalp'+c+'" size="35" maxlength="64" /></div><div id="cab"><input name="date_exp_p'+c+'" type="text" class="datpick" id="date_exp_p'+c+'" size="25" maxlength="64" readonly="readonly" /></div><div id="cab" ><input name="num_tit_p'+c+'" type="text" id="num_tit_p'+c+'" size="25" maxlength="64" class="required"/></div><div id="espa"></div><div class="btn1r"><a href="#" onClick="javascript:borrar('+c+');">BORRAR REGISTRO</a></div></div>');
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
<img src="data/images/datac.jpg" width="1032" height="50" />
<form id="form1" name="form1" method="post" action="">
  <div id="campos1" class="campos">
<!-- TABLA A REPETIR-->
  		<div id="cab">NIVEL:</div>
  		<div id="cab">FECHA INICIO:</div>
  		<div id="cab">FECHA FIN:</div>
    	<div id="cab">CARRERA (AREA DE FORMACION ESPECIALIDAD):(*)</div>
		<div id="cab">
				<select name="level" id="level" style="width:175px;">
                <option value="PRE-GRADO">Pre-grado</option>
                <option value="EGRESADO">Egresado</option>
                <option value="CERTIFICACION COMPETENCIAS">Cert. Competencias</option>
                <option value="TÉCNICO MEDIO">Técnico Medio</option>
                <option value="TÉCNICO SUPERIOR">Técnico Superior</option>
                <option value="BACHELLOR">Bachellor</option>
                <option value="LICENCIATURA">Licenciatura</option>
                <option value="Especialidad">Especialidad</option>
                <option value="POSTGRADO">Post-grado</option>
                <option value="MAESTRIA">Maestría</option>
                <option value="DOCTORADO">Doctorado</option>
                <option value="PH.D.">Ph.d.</option>
		    </select>
		</div>    
		<div id="cab">
  			<input name="date_start" type="text" class="datpick" id="date_start" size="25" maxlength="64" readonly="readonly"/>
   		</div>
  		<div id="cab">
  			<input name="date_end" type="text" class="datpick" id="date_end" size="25" maxlength="64" readonly="readonly"/>
   		</div>
  		<div id="cab">
  			<input name="career_esp" type="text" id="career_esp" size="35" class="required" />
   		</div>
		<div id="cab">NOMBRE INSTITUCIÓN: (*)</div>
  		<div id="cab">CONCLUIDA:</div>
    	<div id="cab">LUGAR (CIUDAD):</div>
    	<div id="cab">PAIS:</div>
 		<div id="cab">
          <input name="name_inst" type="text" id="name_inst" size="35" maxlength="1000" class="required" />
    	</div>
        <div id="cab">
				<select name="end" id="end" >        
        		<option value="1">SI</option>
        		<option value="0">NO</option>
        	</select>
		</div>
  		<div id="cab">
  			<input name="city" type="text" id="city" size="35" maxlength="64" class="required" />
   		</div>
  		<div id="cab">
  			<input name="country" type="text" id="country" size="35" maxlength="64" class="required" />
   		</div>
		<div id="cabmid">TÍTULO ACÁDEMICO: (*)</div>
    	<div id="cabmid">REVALIDADO:</div>
    	<div id="cab">INSTITUCION QUE LO REVALIDA:</div>
    	<div id="cab">FECHA DE EXPEDICIÓN:</div>
        <div id="cab">NÚMERO TÍTULO:</div>
 		<div id="cabmid">
      		<select name="acad_title" id="acad_title" >        
	        	<option value="0">NO</option>	
                <option value="1">SI</option>
        	</select>
    	</div>
        <div id="cabmid">
  			<select name="revala" id="revala" >        
        		<option value="1">SI</option>
        		<option value="0" selected="selected">NO</option>
        	</select>
   		</div>
  		<div id="cab">
  			<input name="inst_revala" type="text" id="inst_revala" size="35" maxlength="64" />
   		</div>
  		<div id="cab">
  			<input name="date_exp" type="text" class="datpick" id="date_exp" size="25" maxlength="64" readonly="readonly" />
   		</div>
        <div id="cab">
  			<input name="num_tit" type="text" id="num_tit" size="25" maxlength="64" />
   		</div>
	<div id="cabmid">TIT.PROV. NAL.: (*)</div>
    <div id="cabmid">REVALIDADO:</div>
    	<div id="cab">INSTITUCION QUE LO REVALIDA:</div>
    	<div id="cab">FECHA DE EXPEDICIÓN</div>
        <div id="cab">NÚMERO TÍTULO:</div>
 		<div id="cabmid">
      		<select name="prov_nat_title " id="prov_nat_title " >              
            	<option value="0">NO</option>	
                <option value="1">SI</option>
        	</select>
    	</div>
        <div id="cabmid">
  			<select name="revalp" id="revalp" >        
        		<option value="1">SI</option>
        		<option value="0" selected="selected">NO</option>
        	</select>
   		</div>
  		<div id="cab">
  			<input name="inst_revalp " type="text" id="inst_revalp " size="35" maxlength="64" />
   		</div>
  		<div id="cab">
  			<input name="date_exp_p " type="text" class="datpick" id="date_exp_p" size="25" maxlength="64" readonly="readonly" />
   		</div>
       
        <div id="cab" >
  			<input name="num_tit_p" type="text" id="num_tit_p" size="25" maxlength="64" class="required"/>
   		</div>
         <div id="espa"></div>
		<div id="cabmid" class="btn1"><a href="javascript:agregar();">Agregar Registro</a></div>
    	<input type="submit" onclick="return probar()" class="submit" name="save" id="loginbutton" value="Guardar" />
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