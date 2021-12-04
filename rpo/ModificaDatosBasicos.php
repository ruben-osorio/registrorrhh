<?
require_once("security.php");
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
$id_func=$_SESSION['id_func'];
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
{ 	$c_status=$_POST[c_status];
	$l_name_es=strtoupper($_POST[l_name_es]);
	$nati=strtoupper($_POST[nati]);
	$nua=$_POST[nua];
	$afp=$_POST[afp];
	$lic_driv=$_POST[lic_driv];
	$type_lic=$_POST[type_lic];
	//echo "esta es la linea".$date_born; 
	$adress=strtoupper($_POST[adress]);
	$place_res=strtoupper($_POST[place_res]);
	$p_email=strtolower($_POST[p_email]);
	$job_email=strtolower($_POST[job_email]);
	$phone_num=$_POST[phone_num];	
	$cel_num=$_POST[cel_num];
	$phone_job=$_POST[phone_job];
//	$date_born=cambia_dateN_to_dateMy_1(date_born);	
//-----------------------------
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
	UPDATE ".TABLE2." SET l_name_es='$l_name_es', nua='$nua', afp='$afp', c_status='$c_status', p_email='$p_email', job_email='$job_email', adress='$adress', place_res='$place_res', phone_num='$phone_num', cel_num='$cel_num', phone_job='$phone_job', lic_driv='$lic_driv', type_lic='$type_lic'
WHERE id_func='$id_func'
	");
	if(!$rs)
	{echo '<div class="errorre">Ocurrio un error durante la ejecución de la consulta intentelo nuevamente</div>';
	}
	else echo '<div class="successre">Sus datos fueron modificados exitosamente¡¡¡</div>';
} 

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FORMULARIO DE REGISTRO</title>
<link href="data/css/style-ext.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" media="screen" href="css/screen.css" />
<link rel="stylesheet" href="data/css/ui/admincp/jquery-ui-1.8.17.custom.css">
<link rel="stylesheet" href="../themes/base/jquery.ui.all.css">
<link href="css/reportes.css" rel="stylesheet" type="text/css">
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
</head>

<body>
<fieldset>
<legend>MODIFICACIÓN DE DATOS PERSONALES</legend>
<form action="" method="post" name="form1" class="form" id="form1">
<table width="941" border="0" align="center" cellpadding="5" cellspacing="0" style=" margin-right:50px;">
 <tr>
  	<th width="180">ESTADO CIVIL:</th >
  	<th width="210">APELLIDO CASADA(O):</th >
    <th width="279">NUA/CUA:</th >
    <th width="235">ADMINISTRADORA FONDO DE PENSIONES</th >
 </tr>
 <tr>
  	<td class="form_row"><select name="c_status" id="c_status" class="textarea_normal" >
  	  <option value="<? echo $rex[c_status];?>"><? echo $rex[c_status];?></option>
      <option value="SOLTERA(O)">SOLTERA(O)</option>
  	  <option value="CASADA(O)">CASADA(O)</option>
  	  <option value="VIUDA(0)">VIUDA(O)</option>
  	  <option value="DIVORCIADA(O)">DIVORCIADA(O)</option>
	  </select></td>
  	<td class="form_row"><input name="l_name_es" type="text" id="l_name_es" size="30" maxlength="64" value="<? echo $rex[l_name_es];?>" class="textarea_normal"/></td>
  	<td class="form_row"><input name="nua" type="text" id="nua"  size="25" maxlength="35" class="textarea_normal" value="<? echo $rex[nua];?>"/></td>
	<td class="form_row"><select name="afp" id="afp" class="textarea_normal">
	  <option value="<? echo $rex[afp];?>"><? echo $rex[afp];?></option>
	  <option value="FUTURO">FUTURO</option>
	  <option value="PREVISIÓN">PREVISION</option>
	  </select></td>
	</tr>
 	<tr>
  		<th>Nº LICENCIA CONDUCIR:</th>
  		<th>CATEGORIA:</th>
    	<th>DIRECCION ZONA/CALLE/NÚMERO(Ej. Calacoto/7/1825):</th>
        <th>LUGAR DE RESIDENCIA:</th>
 	</tr>
	<tr>
  		<td><input name="lic_driv" type="digits" id="lic_driv"  size="25" maxlength="35" class="textarea_normal" value="<? echo $rex[lic_driv];?>"/></td>
	    <td><select name="type_lic" id="type_lic" class="textarea_normal">
	      <option value="0"><? echo $rex[type_lic];?></option>
	      <option value="P">P</option>
	      <option value="A">A</option>
	      <option value="B">B</option>
	      <option value="C">C</option>
        </select></td>
		<td><input name="adress" type="text" id="adress" size="30" maxlength="64" class="textarea_normal" value="<? echo $rex[adress];?>"/></td>
		<td><input name="place_res" type="text" id="place_res" size="30" maxlength="64" class="textarea_normal" value="<? echo $rex[place_res];?>"/></td>
    </tr>
    
    <tr>
  		<th>EMAIL PERSONAL:</td>
	    <th>EMAIL TRABAJO:</td>
		<th>TELEFONO DOMICILIO:</td>
		<th>CELULAR:</th>

	</tr>
    <tr>
        <td><input name="p_email" type="email" id="p_email" size="30" maxlength="128" value="<? echo $rex[p_email];?>" class="textarea_normal" /></td>
        <td><input name="job_email" type="email" id="job_email" size="30" maxlength="128" value="<? echo $rex[job_email];?>" class="textarea_normal" /></td>
  		<td><input name="phone_num" type="digits" id="phone_num"  size="25" maxlength="35" value="<? echo $rex[phone_num];?>" class="textarea_normal"/></td>
   		<td><input name="cel_num" type="digits" id="cel_num"  size="25" maxlength="35" value="<? echo $rex[cel_num];?>" class="textarea_normal"/></td>
    </tr>
    <tr>
        <th>TELEFONO TRABAJO:</th>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>

	</tr>
    <tr>
        <td><input name="phone_job" type="digits" id="phone_job"  size="25" maxlength="35" value="<? echo $rex[phone_job];?>" class="textarea_normal"/></td>
        <td><input type="submit" class="submit" onclick="return probar()" name="save" id="loginbutton" value="Guardar" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>

    </tr>
 </table>      
</form>
</fieldset>
<?
/*
$db->close();*/
?>

</body>
</html>