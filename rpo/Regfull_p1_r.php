<?
require_once("security.php");
require("functions.inc.php");
$id_func=$_GET['id_func'];
require("config.inc.php");
require("database.class.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();

//----------HABILITAR TABLA-------------
	$rsp1=$db->query("
	SELECT * FROM ".TABLE37." 
	WHERE id_func='$id_func'
	");
	$rsxp1=$db->fetch_array($rsp1);
	if($rsxp1[p1]==1)
	{
	header ("Location: exito.php");	
	}
//-----------------------------
//CONSULTA PARA OBTENER TODO LOS DATOS
	$rs2=$db->query("
	SELECT * FROM ".TABLE2." 
	WHERE id_func='$id_func'
	");
//	echo "SELECT id_func, name, l_name1, l_name2,ci,expe,date_born FROM ".TABLE2." WHERE id_func='$id_func'";
	$rex=$db->fetch_array($rs2);
//	echo mysql_num_rows($rs2);
//	echo $rex[id_func];
	
//------------------------------------

if (isset($_POST[save]))
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
	//echo "esta es la linea".$date_born; 
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
//	$date_born=cambia_dateN_to_dateMy_1(date_born);	
	$prof=strtoupper($_POST[prof]);
	$col_prof=strtoupper($_POST[col_prof]);
	$num_prof=strtoupper($_POST[num_prof]); 
	$nit=$_POST[nit];
//-----------------------------
	$on_off=1;
//id_dat id_func last_gra cole city_c year title
	$last_gra=strtoupper($_POST[last_gra]);
	$cole=strtoupper($_POST[cole]);
	$city_c=strtoupper($_POST[city_c]);
	$year_end=strtoupper($_POST[year_end]);
	$title=strtoupper($_POST[title]);
//id_dat id_func last_gra cole city_c year title

//-----------------------------
	//name l_name1 l_name2 c_status l_name_es nati ci exp nua afp	sex	g_blood	lic_driv type_lic date_born
	//p1_born p2_born p3_born adress place_res p_email job_email phone_num cel_num phone_job date_born
  	//prof col_prof num_prof nit
	
	//name	l_name1	l_name2	l_name_es	nati	ci	nua	afp	expe	c_status	sex	g_blood	p_email	job_email	adress	place_res								 	//phone_num	cel_num	phone_job p1_born p2_born p3_born date_born lic_driv type_lic
  	//prof col_prof num_prof nit
//	echo "
//	INSERT INTO ".TABLE2." name, l_name1, l_name2 l_name_es,  nati, ci, nua, afp, expe, c_status, sex,	g_blood, p_email, job_email,  
//	 adress, place_res,  phone_num, cel_num, phone_job,p1_born, p2_born, p3_born, date_born,lic_driv, type_lic, prof, col_prof, 					num_prof, nit
//	VALUES 
//	'$name', '$l_name1', '$l_name2', '$l_name_es', '$nati', '$ci', '$nua', '$afp', '$expe', '$c_status', '$sex', '$g_blood', 		 						'$p_email', '$job_email', '$adress', '$place_res',  '$phone_num', '$cel_num', '$phone_job', '$p1_born', '$p2_born', '$p3_born',  		 	'$date_born','$lic_driv', '$type_lic', '$prof', '$col_prof', '$num_prof, '$nit'
//	INSERT INTO ".TABLE10." 
//	(last_gra, cole, city_c, year, title) VALUES 
//	('$last_gra','$cole','$city_c','$year','$title')
//	";
//echo "<br>".$date_born;
//EXAMPLE UPDATE funcionario set name='Roberto' WHERE id_func='1'
	$rs=$db->query("
	UPDATE ".TABLE2." set l_name_es='$l_name_es', nati='$nati', nua='$nua', afp='$afp', expe='$expe', c_status='$c_status', sex='$sex',	g_blood='$g_blood', p_email='$p_email', job_email='$job_email', adress='$adress', place_res='$place_res', phone_num='$phone_num', cel_num='$cel_num', phone_job='$phone_job',p1_born='$p1_born', p2_born='$p2_born', p3_born='$p3_born', lic_driv='$lic_driv', type_lic='$type_lic', prof='$prof', col_prof= '$col_prof', num_prof='$num_prof', nit='$nit'
WHERE id_func='$id_func'
	");
	$rs1=$db->query("
	INSERT INTO ".TABLE10." 
	(id_func,last_gra, cole, city_c, year_end, title, on_off)
	VALUES 
	('$id_func','$last_gra','$cole','$city_c','$year_end','$title','$on_off')
	");
	$rs2=$db->query("
	UPDATE ".TABLE37." SET p1='$on_off'
	WHERE id_func='$id_func'
	");	
	if(!$rs&&!$rs1&&!$rs2)
	{exit;
	}
    header ("Location: exito.php");
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

</head>

<body id="bd">
<form action="" method="post" name="form1" class="form" id="form1">
<table width="990" height="42" border="0" align="center" cellpadding="2" cellspacing="0">
    <td width="986">
 	<h2><img src="data/images/datper.jpg" width="700" height="50" /></h2>
    </td>
</table>  
<table id="ftab" width="990" border="0" align="center" cellpadding="2" cellspacing="0">
 <tr>
  	<td>NOMBRES:(*)</td>
  	<td>APELLIDO PATERNO:(*)</td>
    <td>APELLIDO MATERNO:(*)</td>
    <td>ESTADO CIVIL:</td>
 </tr>
 <tr>
  	<td>
  		<strong><? echo $rex[name];?></strong>
   	</td>
  	<td>
  		<strong><? echo $rex[l_name1];?></strong>
   	</td>
  	<td>
  		<strong><? echo $rex[l_name2];?></strong>
   	</td>
	<td>
        <select name="c_status" id="c_status" >        
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
  			<input name="l_name_es" type="text" id="l_name_es" size="35" maxlength="64" />
   		</td>
	    <td>
  			<input name="nati" type="text" id="nati" size="35" maxlength="64" class="required" />
   		</td>
		<td><select name="sex" id="sex" >
		  <option value="M">MASCULINO</option>
		  <option value="F">FEMENINO</option>
		  <option value="O">OTRO</option>
      </select></td>
		<td><input name="g_blood" type="text" id="g_blood" size="25" maxlength="64" class="required" /></td>
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
            <option value="<? echo $rex[afp];?>"><? echo $rex[afp];?></option>   
        	<option value="FUTURO">FUTURO</option>
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
        <strong><? echo $rex[ci];?></strong>
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
   			<input name="lic_driv" type="digits" id="lic_driv"  size="25" maxlength="35"  />
   		</td>
		<td>
        	<select name="type_lic" id="type_lic" >        
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
  		<strong><? echo $rex[date_born];?></strong>
   		</td>
	    <td>
  			<input name="p1_born" type="text" id="p1_born" size="30" maxlength="64" class="required" />
       	</td>
	    <td>
  			<input name="p2_born" type="text" id="p2_born" size="30" maxlength="64" class="required" />
       	</td>
	    <td>
  			<input name="p3_born" type="text" id="p3_born" size="30" maxlength="64" class="required" />
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
  			<input name="place_res" type="text" id="place_res" size="30" maxlength="64" class="required" />
       	</td>  
        <td>   
    	    <input name="p_email" type="email" id="p_email" size="30" maxlength="128" class="required" />
        </td>  
        <td>   
        	<input name="job_email" type="email" id="job_email" size="30" maxlength="128" class="required" />
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
   			<input name="phone_job" type="digits" id="phone_job"  size="25" maxlength="35"/>
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
   			<input name="prof" type="text" id="prof"  size="35" maxlength="35"/>
		</td>
		<td>
   			<input name="col_prof" type="text" id="col_prof"  size="30" maxlength="35"/>
		</td>    
		<td>
   			<input name="num_prof" type="text" id="num_prof"  size="25" maxlength="35"/>
		</td>    
		<td>
   			<input name="nit" type="text" id="nit"  size="25" maxlength="35"/>
		</td>   
    </tr>
 </table>      
<!--datos academicos-->
 <table width="990" height="42" border="0" align="center" cellpadding="2" cellspacing="0">
    <td width="986">
 	<h2><img src="data/images/datba.jpg" width="980" height="50" /></h2>
    </td>
</table>   
 <table id="ftab" width="989" border="0" align="center" cellpadding="2" cellspacing="0">   
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
        <input name="last_gra" type="text" id="last_gra" size="35" maxlength="64" class="required"/>
        </td>
        <td>
        <input name="cole" type="text" id="cole" size="35" maxlength="64" class="required"/>
        </td>
        <td>
        <input name="city_c" type="text" id="city_c" size="30" maxlength="64" class="required"/>
        </td>
        <td>
        <input name="year_end" type="text" id="year_end" size="10" maxlength="64" class="required"/>
        </td>
         <td>
				<select name="title" id="title">
                <option value="0">NO</option>
                <option value="1">SI</option>
                </select>
		</td> 
    </tr>
	</tr>
<!--datos academicos-->
    <tr>
  	<td><input type="submit" class="submit" onclick="return probar()" name="save" id="loginbutton" value="Guardar" /></td>
 	</tr>
  	<td colspan="2">(*) Campo Requerido.</td>
</table>
</form>
<br />
<table width="990" border="0" cellspacing="0" cellpadding="5" id="ftab" align="center">
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

<?

//$db->close();
?>

</body>
</html>