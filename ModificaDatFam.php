<?
require_once("security.php");
require("functions.inc.php");
//$id_func='4';
$id_func=$_GET[id_func];

require("config.inc.php");
require("database.class.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
//-----------------------------
//ELIMINAR REGISTRO
//echo $id_datf=$_GET['id_datf'];
//id_datf id_func type_p name l_name1 l_name2 sex born_date pb_nat tn_doc

if(isset($_GET['action']) && $_GET['action']=='DELETE')
{
$id_datf=$_GET[id_datf];
echo $id_datf;
echo "
DELETE FROM ".TABLE8." 
	WHERE
	id_datf='$id_datf'
	";
$rsdel=$db->query("
DELETE FROM ".TABLE8." 
	WHERE
	id_datf='$id_datf'
	");
	/*if ($rsdel)
		header ("Location: ModificaDatFam.php?id_func=$id_func");*/	
}
//-----------------------------
$post_numero = count($_POST);
$con=($post_numero-1)/9;
if (isset($_POST[save3]))
{	unset($_POST["save3"]);

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
//GENERA CONSULTAS
$k=1;
$l=1;
$consulta1="";
$valores1="";
$i=0;
while ($i < $post_numero-1)
{
	if ($i%9==0)
	{	$j=$i+1;
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
		/*echo "<br />";
		echo "	UPDATE ".TABLE8." SET 
	type_p='$camp2', name='$camp3', l_name1='$camp4', l_name2='$camp5', sex='$camp6', born_date='$camp7', pb_nat='$camp8', tn_doc='$camp9'
	WHERE
	id_datf='$camp1'";
		echo "<br />";*/
//-----------------------------------

//id_datf id_func type_p name l_name1 l_name2 sex born_date pb_nat tn_doc
	$rs=$db->query("
UPDATE ".TABLE8." SET 
	type_p='$camp2', name='$camp3', l_name1='$camp4', l_name2='$camp5', sex='$camp6', born_date='$camp7', pb_nat='$camp8', tn_doc='$camp9'
	WHERE
	id_datf='$camp1'
	");
	 
	if(!$rs)
	{
		exit;
	}

	}	
	$i++;
}

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FORMULARIO DE REGISTRO</title>
<link href="data/css/style-ext.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" media="screen" href="css/screen.css" />
<link href="estilo.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="data/css/ui/admincp/jquery-ui-1.8.17.custom.css">
<link rel="stylesheet" href="../themes/base/jquery.ui.all.css">
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


	<!--<script src="data/js/jquery-1.7.1.min.js"></script>-->
	<script src="data/js/ui/jquery.ui.core.js"></script>
	<script src="data/js/ui/jquery.ui.widget.js"></script>
	<script src="data/js/ui/jquery.ui.datepicker.js"></script>
	<script>
	$(function() {
		$( ".datepick" ).datepicker({
			showOn: "button",
			buttonImage: "data/images/calendar.gif",
			buttonImageOnly: true, changeMonth: true, changeYear: true, yearRange: '-100:+0',
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

<body>
<? 
//------------------------------------
//CONSULTA PARA OBTENER DATOS FAMILIARES
	$rsc2=$db->query("
	SELECT * FROM ".TABLE8." 
	WHERE id_func='$id_func'
	");

//------------------------------------
?>
 <table width="990" height="42" border="0" align="center" cellpadding="2" cellspacing="0">
    <th width="986">
 	<h2 align="left">DATOS FAMILIARES</h2>
    </th>
</table>   
<table width="950" border="0" align="center" cellpadding="2" cellspacing="0">   
<form action="" method="post" name="form1" class="form" id="form2">   
<? 
//id_datf id_func type_p name l_name1 l_name2 sex born_date	pb_nat tn_doc
$c=0;
$f=1;
while ($rex2=$db->fetch_array($rsc2))
	{
echo '<tr><td colspan="4"><H2>FAMILIAR '.$f.'</H2></td></tr>
	<tr>	
	<input name="id_datf'.$c.'" type="hidden" id="id_datf"class="required" value="'.$rex2[id_datf].'"/>
	<td>
	<LABEL for="type_p'.$c.'"><strong>PARENTESCO: &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</strong></LABEL><input name="type_p'.$c.'" type="text" id="type_p" size="25" maxlength="64" class="required" value="'.$rex2[type_p].'"/>
	</td>
	<td>
	<LABEL for="name'.$c.'"><strong>NOMBRE:&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</strong></LABEL><input name="name'.$c.'" type="text" id="name" size="25" maxlength="64" class="required" value="'.$rex2[name].'"/>
	</td>
	<td>
	<LABEL for="l_name1'.$c.'"><strong>APELLIDO PATERNO:</strong></LABEL><input name="l_name1'.$c.'" type="text" id="l_name1" size="25" maxlength="64" class="required" value="'.$rex2[l_name1].'"/>
	</td>
	<td>
	<LABEL for="l_name2'.$c.'"><strong>APELLIDO MATERNO:</strong></LABEL><input name="l_name2'.$c.'" type="text" id="l_name2" size="25" maxlength="64" class="required" value="'.$rex2[l_name2].'"/>
	</td>
	</tr>
	<tr>
	<td>
	<LABEL for="sex'.$c.'"><strong>SEXO:&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</strong></LABEL><input name="sex'.$c.'" type="text" id="sex" size="25" maxlength="64" class="required" value="'.$rex2[sex].'"/>
	</td>
	<td>
	<LABEL for="born_date'.$c.'"><strong>FECHA DE NACIMIENTO:</strong></LABEL><input name="born_date'.$c.'" type="text" id="born_date" size="25" maxlength="64" class="required" value="'.$rex2[born_date].'"/>
	</td>
	<td>
	<LABEL for="pb_nat'.$c.'"><strong>LUGAR DE NACIMIENTO:</strong></LABEL><input name="pb_nat'.$c.'" type="text" id="pb_nat" size="25" maxlength="64" class="required" value="'.$rex2[pb_nat].'"/>
	</td>
	<td>
	<LABEL for="tn_doc'.$c.'"><strong>TIPO Y NÚMERO DE DOCUMENTO:</strong></LABEL><input name="tn_doc'.$c.'" type="text" id="tn_doc" size="25" maxlength="64" class="required" value="'.$rex2[tn_doc].'"/>
	</td>
	</tr>
	<td colspan="4">
	<div class="errorre"><a href="?id_datf='.$rex2[id_datf].'&&id_func='.$rex2[id_func].'&action=DELETE">BORRAR DATOS DE FAMILIAR '.$f.'</a><div>
	</td>
	';
	$c++;
	$f++;
	}
?>
    <tr>
  	<td><input type="submit" class="submit" name="save3" id="loginbutton" value="Guardar" /></td>
 	</tr>
</table>
</form>
</body>
</html>