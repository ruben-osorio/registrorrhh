<?
require_once("security.php");
require("functions.inc.php");
$id_func=$_GET[id_func];
require("config.inc.php");
require("database.class.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();

if (isset($_POST[save1]))
{ 	$name=strtoupper($_POST[name]);
	$l_name1=strtoupper($_POST[l_name1]);
	$l_name2=strtoupper($_POST[l_name2]);
	$c_status=$_POST[c_status];
	$l_name_es=strtoupper($_POST[l_name_es]);
	$nati=strtoupper($_POST[nati]);
	$expe=$_POST[expe];
	$nua=$_POST[nua];
	$afp=$_POST[afp];
	$sex=$_POST[sex];
	$g_blood=strtoupper($_POST[g_blood]);
	$lic_driv=$_POST[lic_driv];
	$type_lic=$_POST[type_lic];
	$date_born=$_POST[date_born];
	$p1_born=strtoupper($_POST[p1_born]);	
	$p2_born=strtoupper($_POST[p2_born]);	
	$p3_born=strtoupper($_POST[p3_born]);	
	$adress=strtoupper($_POST[adress]);
	$place_res=strtoupper($_POST[place_res]);
	$p_email=strtolower($_POST[p_email]);
	$job_email=strtolower($_POST[job_email]);
	$phone_num=$_POST[phone_num];	
	$cel_num=$_POST[cel_num];
	$phone_job=$_POST[phone_job];
	$prof=strtoupper($_POST[prof]);
	$col_prof=strtoupper($_POST[col_prof]);
	$num_prof=strtoupper($_POST[num_prof]); 
	$nit=$_POST[nit];
	$last_gra=strtoupper($_POST[last_gra]);
	$cole=strtoupper($_POST[cole]);
	$city_c=strtoupper($_POST[city_c]);
	$year_end=strtoupper($_POST[year_end]);
	$title=strtoupper($_POST[title]);
	
	//name l_name1 l_name2 c_status l_name_es
	//nati expe nua afp sex g_blood lic_driv
	//type_lic date_born p1_born p2_born p3_born
	//adress place_res p_email job_email phone_num
	//cel_num phone_job prof col_prof num_prof nit
		
	
	$rs=$db->query("
	UPDATE ".TABLE2." set name='$name',l_name1='$l_name1',l_name2='$l_name2',l_name_es='$l_name_es', nati='$nati', nua='$nua', afp='$afp', expe='$expe', c_status='$c_status', sex='$sex',	g_blood='$g_blood', p_email='$p_email', job_email='$job_email', adress='$adress', place_res='$place_res', phone_num='$phone_num', cel_num='$cel_num', phone_job='$phone_job',p1_born='$p1_born', p2_born='$p2_born', p3_born='$p3_born',date_born='$date_born', lic_driv='$lic_driv', type_lic='$type_lic', prof='$prof', col_prof= '$col_prof', num_prof='$num_prof', nit='$nit'
WHERE id_func='$id_func'
	");
	if(!$rs)
	{exit;
	}

}
//-----------------------------
if (isset($_POST[save2]))
{	//last_gra cole city_c year_end title 
	$rs1=$db->query("
	UPDATE ".TABLE10." SET  last_gra='$last_gra', cole='$cole', city_c='$city_c', year_end='$year_end', title='$title'
	WHERE id_func='$id_func'
	");
	if(!$rs1)
	{exit;
	}
}
//-----------------------------
$post_numero = count($_POST);
echo $post_numero;
$con=($post_numero-1)/8;
if (isset($_POST[save3]))
{	unset($_POST["save3"]);
	$on_off=1;
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
		echo "insert into tablex () values ($camp1,$camp2,$camp3,$camp4,$camp5,$camp6,$camp7,$camp8)";
		echo "<br />";*/
//-----------------------------------

//id_datf id_func type_p name l_name1 l_name2 sex born_date pb_nat tn_doc
	$rs=$db->query("
	INSERT INTO ".TABLE8." 
	(id_func,type_p, name, l_name1, l_name2, sex, born_date, pb_nat, tn_doc)
	VALUES 
	('$id_func','$camp1','$camp2','$camp3','$camp4','$camp5','$camp6','$camp7','$camp8')");
	 
	if(!$rs)
	{
		exit;
	}

	}	
	$i++;
}

}


//-----------------------------
//CONSULTA PARA OBTENER TODO LOS DATOS FUNCIONARIOS
	$rsc=$db->query("
	SELECT * FROM ".TABLE2." 
	WHERE id_func='$id_func'
	");
	$rex=$db->fetch_array($rsc);
//------------------------------------
//CONSULTA PARA OBTENER DATOS EDUCACIONALES
	$rsc1=$db->query("
	SELECT * FROM ".TABLE10." 
	WHERE id_func='$id_func'
	");
	$rex1=$db->fetch_array($rsc1);
//------------------------------------
//------------------------------------
//CONSULTA PARA OBTENER DATOS FAMILIARES
	$rsc2=$db->query("
	SELECT * FROM ".TABLE8." 
	WHERE id_func='$id_func'
	");

//------------------------------------





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

</head>

<body>
<fieldset>
<label><h2>DATOS PERSONALES</h2></label>
<form action="" method="post" name="form1" class="form" id="form1">
<table width="990" height="42" border="0" align="center" cellpadding="2" cellspacing="0">
    <td width="986">
 	
    </td>
</table>  
<table width="990" border="0" align="center" cellpadding="2" cellspacing="0">
 <tr>
  	<td>NOMBRES:(*)</td>
  	<td>APELLIDO PATERNO:(*)</td>
    <td>APELLIDO MATERNO:(*)</td>
    <td>ESTADO CIVIL:</td>
 </tr>
 <tr>
  	<td>
        <input name="name" type="text" id="name" size="35" maxlength="64" value="<? echo $rex[name];?>"/>
   	</td>
  	<td>
        <input name="l_name1" type="text" id="l_name1" size="35" maxlength="64" value="<? echo $rex[l_name1];?>"/>
   	</td>
  	<td>
        <input name="l_name2" type="text" id="l_name2" size="35" maxlength="64" value="<? echo $rex[l_name2];?>"/>

   	</td>
	<td>
        <select name="c_status" id="c_status" >        
        	<option value="<? echo $rex[c_status];?>"><? echo $rex[c_status];?></option>
            <option value="SOLTERA(O)">SOLTERA(O)</option>
        	<option value="CASADA(O)">CASADA(O)</option>
        	<option value="VIUDA(0)">VIUDA(O)</option>
        	<option value="DIVORCIADA(O)">DIVORCIADA(O)</option>
        </select>
    </td>
	</tr>
 	<tr>
  		<td>APELLIDO CASADA(O):</td>
  		<td>NACIONALIDAD</td>
    	<td>SEXO</td>
        <td>GRUPO SANGUINEO:</td>
 	</tr>
	<tr>
  		<td>
  			<input name="l_name_es" type="text" id="l_name_es" size="35" maxlength="64" value="<? echo $rex[l_name_es];?>"/>
   		</td>
	    <td>
  			<input name="nati" type="text" id="nati" size="35" maxlength="64" class="required" value="<? echo $rex[nati];?>"/>
   		</td>
		<td><select name="sex" id="sex" >

        <option value="<? echo $rex[sex];?>"><? echo $rex[sex];?></option>
		  <option value="M">MASCULINO</option>
		  <option value="F">FEMENINO</option>
	    </select></td>
		<td><input name="g_blood" type="text" id="g_blood" size="25" maxlength="64" class="required" value="<? echo $rex[g_blood];?>"/></td>
    </tr>
    <tr>
  		<td>NUA/CUA:</td>
  		<td>ADMINISTRADORA FONDO DE PENSIONES</td>
 	</tr>
	<tr>	
        <td>
   			<input name="nua" type="text" id="nua"  size="25" maxlength="35" class="required number " value="<? echo $rex[nua];?>"/></td>
		<td>
        	<select name="afp" id="afp">     
            <option value="<? echo $rex[afp];?>"><? echo $rex[afp];?></option>           	<option value="FUTURO">FUTURO</option>
        	<option value="PREVISIÓN">PREVISION</option>
        	</select>
    	</td>	
    </tr>
    <tr>
  		<td>CI:</td>
  		<td>EXP:</td>
   		<td>Nº LICENCIA CONDUCIR:</td>
        <td>CATEGORIA:</td>
 	</tr>
    
    <tr>
  		<td>
        <input name="nua" type="text" id="nua"  size="25" maxlength="35" class="required number " value="<? echo $rex[nua];?>"/>
        </td>
	    <td><select name="expe" id="expe">
	      <option value="<? echo $rex[expe];?>"><? echo $rex[expe];?></option>
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
		<td>
   			<input name="lic_driv" type="digits" id="lic_driv"  size="25" maxlength="35" value="<? echo $rex[lic_driv];?>" />
   		</td>
		<td>
        	<select name="type_lic" id="type_lic" >        
            <option value="<? echo $rex[lic_driv];?>"><? echo $rex[lic_driv];?></option>
			<option value="0">-</option>	
        	<option value="P">P</option>
        	<option value="A">A</option>
        	<option value="B">B</option>
        	<option value="C">C</option>
        	</select>
    	</td>

	</tr>
    <tr>
        <td>FECHA NACIMIENTO:</td>
        <td>DEPARTAMENTO NACIMIENTO:</td>
  		<td>PROVINCIA NACIMIENTO:</td>
   		<td>LOCALIDAD NACIMIENTO:</td>
    </tr>
    <tr>
        <td>
        <input name="date_born" type="text" id="date_born" size="30" maxlength="64" value="<? echo $rex[date_born];?>" class="required" />
  		</td>
	    <td>
  			<input name="p1_born" type="text" id="p1_born" size="30" maxlength="64" class="required" value="<? echo $rex[p1_born];?>"/>
       	</td>
	    <td>
  			<input name="p2_born" type="text" id="p2_born" size="30" maxlength="64" class="required" value="<? echo $rex[p2_born];?>"/>
       	</td>
	    <td>
  			<input name="p3_born" type="text" id="p3_born" size="30" maxlength="64" class="required" value="<? echo $rex[p3_born];?>"/>
       	</td>
	</tr>
    <tr>
        <td>DIRECCION ZONA/CALLE/NÚMERO(Ej. Calacoto/7/1825):</td>
        <td>LUGAR DE RESIDENCIA:</td>
  		<td>EMAIL PERSONAL:</td>
   		<td>EMAIL TRABAJO:</td>
    </tr>   
    <tr>
    	<td>
  			<input name="adress" type="text" id="adress" size="30" maxlength="64" class="required" value="<? echo $rex[adress];?>"/>
       	</td>  
 	    <td>
  			<input name="place_res" type="text" id="place_res" size="30" maxlength="64" class="required" value="<? echo $rex[place_res];?>"/>
       	</td>  
        <td>   
    	    <input name="p_email" type="email" id="p_email" size="30" maxlength="128" class="required" value="<? echo $rex[p_email];?>"/>
        </td>  
        <td>   
        	<input name="job_email" type="email" id="job_email" size="30" maxlength="128" class="required" value="<? echo $rex[job_email];?>"/>
        </td>  
    </tr>
    <tr>
        <td>TELEFONO DOMICILIO:</td>
        <td>CELULAR:</td>
  		<td>TELEFONO TRABAJO:</td>
        <td>&nbsp;</td>
   	</tr>   
    <tr>
		<td>
   			<input name="phone_num" type="digits" id="phone_num"  size="25" maxlength="35" value="<? echo $rex[phone_num];?>"/>
		</td>
		<td>
   			<input name="cel_num" type="digits" id="cel_num"  size="25" maxlength="35" value="<? echo $rex[cel_num];?>" class="required"/>
		</td>    
		<td>
   			<input name="phone_job" type="digits" id="phone_job"  size="25" maxlength="35" value="<? echo $rex[phone_job];?>"/>
		</td>    
    	 <td>&nbsp;</td>
    </tr>
    <tr>
        <td>PROFESIÓN:</td>
        <td>COLEGIO PROFESIONAL:</td>
  		<td>NÚMERO DE REGISTRO PROFESIONAL:</td>
        <td>NIT:</td>
   	</tr>   
    <tr>
  
		<td>
   			<input name="prof" type="text" id="prof"  size="35" maxlength="35"value="<? echo $rex[prof];?>"/>
		</td>
		<td>
   			<input name="col_prof" type="text" id="col_prof"  size="30" maxlength="35" value="<? echo $rex[col_prof];?>"/>
		</td>    
		<td>
   			<input name="num_prof" type="text" id="num_prof"  size="25" maxlength="35" value="<? echo $rex[num_prof];?>"/>
		</td>    
		<td>
   			<input name="nit" type="text" id="nit"  size="25" maxlength="35"value="<? echo $rex[nit];?>"/>
		</td>
  	  </tr>
      <tr>
      <td><input type="submit" class="submit" onclick="return probar()" name="save1" value="Guardar" /></td> 
      </tr>
 </table>      
<!--datos academicos-->
 <table width="990" height="42" border="0" align="center" cellpadding="2" cellspacing="0">
    <td width="986">
 	<h2>DATOS EDUCACIONALES</h2>
    </td>
</table>   
 <table width="989" border="0" align="center" cellpadding="2" cellspacing="0">   
    <tr>
        <td width="265">ULTIMO CURSO VENCIDO:(*)</td>
  		<td width="247">COLEGIO/INSTITUCIÓN:(*)</td>
    	<td width="246">LUGAR CIUDAD/PAÍS:(*)</td>
        <td width="115">AÑO:(*)</td>
		<td width="96">TITULO:</td>
    <tr>   
    </tr>
     <tr>   
        <td>
        <input name="last_gra" type="text" id="last_gra" size="35" maxlength="64" class="required" value="<? echo $rex1[last_gra];?>"/>
        </td>
        <td>
        <input name="cole" type="text" id="cole" size="35" maxlength="64" class="required" value="<? echo $rex1[cole];?>"/>
        </td>
        <td>
        <input name="city_c" type="text" id="city_c" size="30" maxlength="64" class="required" value="<? echo $rex1[city_c];?>"/>
        </td>
        <td>
        <input name="year_end" type="text" id="year_end" size="10" maxlength="64" class="required" value="<? echo $rex1[year_end];?>"/>
        </td>
         <td>
				<select name="title" id="title">
                <option value="<? echo $rex[title];?>"><? echo $rex[title];?></option>
                <option value="0">NO</option>
                <option value="1">SI</option>
                </select>
		</td> 
    </tr>
<!--datos academicos-->
    <tr>
  	<td><input type="submit" class="submit" onclick="return probar()" name="save2" value="Guardar" /></td>
 	</tr>
</table>
</form>
</fieldset>

<table width="989" border="0" align="center" cellpadding="2" cellspacing="0">   
 <form action="" method="post" name="form1" class="form" id="form2">   
<? 
//id_datf id_func type_p name l_name1 l_name2 sex born_date	pb_nat tn_doc
$c=0;
while ($rex2=$db->fetch_array($rsc2))
	{
echo '<tr>	
	<td>
	<input name="id_datf'.$c.'" type="text" id="id_datf" size="10" maxlength="64" class="required" value="'.$rex2[id_datf].'"/>
	</td>
	<td>
	<input name="name'.$c.'" type="text" id="name" size="10" maxlength="64" class="required" value="'.$rex2[name].'"/>
	</td>
	<td>
	<input name="l_name1'.$c.'" type="text" id="l_name1" size="10" maxlength="64" class="required" value="'.$rex2[l_name1].'"/>
	</td>
	<td>
	<input name="l_name2'.$c.'" type="text" id="l_name2" size="10" maxlength="64" class="required" value="'.$rex2[l_name2].'"/>
	</td>
	</tr>
	<tr>
	<td>
	<input name="sex'.$c.'" type="text" id="sex" size="10" maxlength="64" class="required" value="'.$rex2[sex].'"/>
	</td>
	<td>
	<input name="born_date'.$c.'" type="text" id="born_date" size="10" maxlength="64" class="required" value="'.$rex2[born_date].'"/>
	</td>
	<td>
	<input name="pb_nat'.$c.'" type="text" id="pb_nat" size="10" maxlength="64" class="required" value="'.$rex2[pb_nat].'"/>
	</td>
	<td>
	<input name="tn_doc'.$c.'" type="text" id="tn_doc" size="10" maxlength="64" class="required" value="'.$rex2[tn_doc].'"/>
	</td>
	</tr>';
	$c++;
	}
?>
    <tr>
  	<td><input type="submit" class="submit" onclick="return probar()" name="save3" value="Guardar" /></td>
 	</tr>
</table>
</form>


</body>
</html>