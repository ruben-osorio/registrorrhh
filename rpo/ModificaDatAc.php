<?php
require_once("security.php");
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();

//$id_func='4';
$id_func=$_GET[id_func];
//-----------------------------
//ELIMINAR REGISTRO
$id_dat=$_GET['id_dat'];
//id_datf id_func type_p name l_name1 l_name2 sex born_date pb_nat tn_doc
if(isset($_GET['action'])&&$_GET['action']=='DELETE')
{
	$rsdel=$db->query("
	DELETE FROM ".TABLE1." 
	WHERE
		id_dat='$id_dat'
	");
	if ($rsdel)
		header ("Location: ModificaDatAc.php?id_func=$id_func");
}
//-----------------------------
$post_numero = count($_POST);
$con=($post_numero-1)/19;
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
	if ($i%19==0)
	{
	/*	echo "posicion de $i: ".$post_valores[$i]."<br/>";*/
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
		$a=$i+18;
		
		
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
		$camp19=$post_valores[$a];
//-----------------------------------
/*		echo "<br />";
		echo "	UPDATE ".TABLE1." SET
	level='$camp2', date_start='$camp3', date_end='$camp4', career_esp='$camp5', name_inst='$camp6', end='$camp7', city='$camp8', country='$camp9', acad_title='$camp10', revala='$camp11', inst_revala='$camp12', date_exp_a='$camp13', num_tit_a='$camp14', prov_nat_title='$camp15', revalp='$camp16', inst_revalp='$camp17', date_exp_p='$camp18', num_tit_p='$camp19
	WHERE
	id_dat='$camp1'";
		echo "<br />";*/
//-----------------------------------

//level date_start date_end date career_esp name_inst end city country acad_title revala inst_revala date_exp_a num_tit_a prov_nat_title revalp inst_revalp date_exp_p num_tit_p 

	$rs=$db->query("
	UPDATE ".TABLE1." SET
	level='$camp2', date_start='$camp3', date_end='$camp4', career_esp='$camp5', name_inst='$camp6', end='$camp7', city='$camp8', country='$camp9', acad_title='$camp10', revala='$camp11', inst_revala='$camp12', date_exp_a='$camp13', num_tit_a='$camp14', prov_nat_title='$camp15', revalp='$camp16', inst_revalp='$camp17', date_exp_p='$camp18', num_tit_p='$camp19'
	WHERE
	id_dat='$camp1'
	");
	if(!$rs)
	{exit;
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
<link href="data/css/style-ext.css" rel="stylesheet" type="text/css">
<link href="css/reportes.css" rel="stylesheet" type="text/css">
</head>
<? 
//------------------------------------
//CONSULTA PARA OBTENER DATOS ACADEMICOS
	$rsc2=$db->query("
	SELECT * FROM ".TABLE1." 
	WHERE id_func='$id_func'
	");
//------------------------------------
?>
<body>
<div id="campos">
<form id="form1" name="form1" method="post" action="">
<table width="990" height="42" border="0" align="center" cellpadding="2" cellspacing="0">
    <td width="986">
 	<h2>DATOS ACADEMICOS</h2>
    </td>
</table>   
<table width="989" border="0" align="center" cellpadding="2" cellspacing="0">   
<form action="" method="post" name="form1" class="form" id="form2">   
<? 
$c=0;
$f=1;
//level date_start date_end career_esp name_inst end city country acad_title revala inst_revala date_exp_a num_tit_a prov_nat_title revalp inst_revalp date_exp_p num_tit_p
while ($rex2=$db->fetch_array($rsc2))
	{
echo '<tr><th colspan="6"><h2>TITULO ACADEMICO '.$f.'</h2></th></tr>
	<tr>	
	<input name="id_dat'.$c.'" type="hidden" id="id_dat"  value="'.$rex2[id_dat].'"/>
	<td>
	<LABEL for="name"><strong>NIVEL:&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</strong></LABEL>
			<select name="level'.$c.'" id="level'.$c.'" >    
                <option value="'.$rex2[level].'">'.$rex2[level].'</option>			    
                <option value="PRE-GRADO">Pre-grado</option>
                <option value="EGRESADO">Egresado</option>
                <option value="TÉCNICO MEDIO">Técnico Medio</option>
                <option value="TÉCNICO SUPERIOR">Técnico Superior</option>
                <option value="LICENCIATURA">Licenciatura</option>
                <option value="Especialidad">Especialidad</option>
                <option value="POSTGRADO">Post-grado</option>
                <option value="MAESTRIA">Maestría</option>
                <option value="DOCTORADO">Doctorado</option>
        	</select>
	
	</td>
	<td>
	<LABEL for="date_start'.$c.'"><strong>FECHA DE INCIO:</strong></LABEL><input name="date_start'.$c.'" type="text" id="date_start'.$c.'" size="25" maxlength="64"  value="'.$rex2[date_start].'"/>
	</td>
	<td>
	<LABEL for="date_end'.$c.'"><strong>FECHA FINAL:&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</strong></LABEL><input name="date_end'.$c.'" type="text" id="date_end'.$c.'" size="25" maxlength="64"  value="'.$rex2[date_end].'"/>
	</td>
	<td>
	<LABEL for="career_esp'.$c.'"><strong>CARRERA:&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</strong></LABEL><input name="career_esp'.$c.'" type="text" id="career_esp'.$c.'" size="25" maxlength="64"  value="'.$rex2[career_esp].'"/>
	</td>
	</tr>
	<tr>
	<td>
	<LABEL for="name_inst'.$c.'"><strong>NOMBRE INSTITUCION:</strong></LABEL><input name="name_inst'.$c.'" type="text" id="name_inst'.$c.'" size="25" maxlength="64"  value="'.$rex2[name_inst].'"/>
	</td>
	<td>
	<LABEL for="end'.$c.'"><strong>CONCLUIDA:&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</strong></LABEL>
			<select name="end'.$c.'" id="end'.$c.'" >        
        		<option value="'.$rex2[end].'">';
				if($rex2[end]==0) 
				echo 'NO'; 
				else echo 'SI';
								
				echo '</option>
				<option value="1">SI</option>
        		<option value="0">NO</option>
        	</select>
	</td>
	<td>
	<LABEL for="city'.$c.'"><strong>LUGAR: &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</strong></LABEL><input name="city'.$c.'" type="text" id="city'.$c.'" size="25" maxlength="64"  value="'.$rex2[city].'"/>
	</td>
	<td>
	<LABEL for="country'.$c.'"><strong>PAIS DE ESTUDIO:&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</strong></LABEL><input name="country'.$c.'" type="text" id="country'.$c.'" size="25" maxlength="64"  value="'.$rex2[country].'"/>
	</td>
	</tr>
	<tr>	
	<td>
	<LABEL for="acad_title'.$c.'"><strong>TITULO ACADEMICO: &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</strong></LABEL>
				<select name="acad_title'.$c.'" id="acad_title'.$c.'" >        
        		<option value="'.$rex2[acad_title].'">';
				if($rex2[acad_title]==0) 
				echo 'NO'; 
				else echo 'SI';
								
				echo '</option>
				<option value="1">SI</option>
        		<option value="0">NO</option>
        	</select>	
	</td>
	<td>
	<LABEL for="revala'.$c.'"><strong>REVALIDADO:&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</strong></LABEL>
			<select name="revala'.$c.'" id="revala'.$c.'" >        
        		<option value="'.$rex2[revala].'">';
				if($rex2[revala]==0) 
				echo 'NO'; 
				else echo 'SI';
								
				echo '</option>
				<option value="1">SI</option>
        		<option value="0">NO</option>
        	</select>	
	</td>
	<td>
	<LABEL for="inst_revala'.$c.'"><strong>INSTITUCION QUE REVALIDA:</strong></LABEL><input name="inst_revala'.$c.'" type="text" id="inst_revala'.$c.'" size="25" maxlength="64"  value="'.$rex2[inst_revala].'"/>
	
	</td>
	<td>
	<LABEL for="date_exp_a'.$c.'"><strong>FECHA DE EXPEDICION:</strong></LABEL><input name="date_exp_a'.$c.'" type="text" id="date_exp_a'.$c.'" size="25" maxlength="64"  value="'.$rex2[date_exp_a].'"/>
	</td>
	</tr>
	<tr>
	<td>
	<LABEL for="num_tit_a'.$c.'"><strong>NUMERO DE TITULO:</strong></LABEL><input name="num_tit_a'.$c.'" type="text" id="num_tit_a'.$c.'" size="25" maxlength="64"  value="'.$rex2[num_tit_a].'"/>
	</td>
	<td>
	<LABEL for="prov_nat_title'.$c.'"><strong>TITULO EN PROVISION NACIONAL:</strong></LABEL>
			<select name="prov_nat_title'.$c.'" id="prov_nat_title'.$c.'" >        
        		<option value="'.$rex2[prov_nat_title].'">';
				if($rex2[prov_nat_title]==0) 
				echo 'NO'; 
				else echo 'SI';
								
				echo '</option>
				<option value="1">SI</option>
        		<option value="0">NO</option>
        	</select>	
	
	
	</td>
	<td>
	<LABEL for="revalp'.$c.'"><strong>REVALIDADO:&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</strong></LABEL>
			<select name="revalp'.$c.'" id="revalp'.$c.'" >        
        		<option value="'.$rex2[revalp].'">';
				if($rex2[revalp]==0) 
				echo 'NO'; 
				else echo 'SI';
								
				echo '</option>
				<option value="1">SI</option>
        		<option value="0">NO</option>
        	</select>	
	</td>
	<td>
	<LABEL for="inst_revalp'.$c.'"><strong>INSTITUCION QUE LO REVALIDA:</strong></LABEL><input name="inst_revalp'.$c.'" type="text" id="inst_revalp'.$c.'" size="25" maxlength="64" value="'.$rex2[inst_revalp].'"/>
	</td>
	</tr>	
	
	
	<tr>	
	<td>
	<LABEL for="date_exp_p'.$c.'"><strong>FECHA DE EXPEDICION:</strong></LABEL><input name="date_exp_p'.$c.'" type="text" id="date_exp_p'.$c.'" size="25" maxlength="64" value="'.$rex2[date_exp_p].'"/> 
	</td>
	<td>
	<LABEL for="num_tit_p'.$c.'"><strong>NUMERO DE TITULO:</strong></LABEL><input name="num_tit_p'.$c.'" type="text" id="num_tit_p'.$c.'" size="25" maxlength="64" value="'.$rex2[num_tit_p].'"/>
	</td>
	</tr>
	<td colspan="4">
	<div class="errorre"><a href="?id_dat='.$rex2[id_dat].'&&id_func='.$rex2[id_func].'&action=DELETE">BORRAR DATOS ACADÉMICOS '.$f.'</a><div>
	</td>
	';
	$c++;
	$f++;
	}
?>
    <tr>
  	<td>
    <input type="submit" class="submit" name="save" id="loginbutton" value="Guardar" />
    
    
    
    
    </td>
 	</tr>
</table>
</form>
</body>
</html>