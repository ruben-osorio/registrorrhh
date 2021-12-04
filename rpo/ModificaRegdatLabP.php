<?
$id_func=$_GET['id_func'];
$id_per=$_GET['id_per'];
/*$id_func='2';
$id_per='2';*/
/*while ($post = each($_POST))
{
echo $post[0] . " = " . $post[1]."<br>";
}*/
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
if (isset($_POST[save]))
{ 	
//TABLA soc_secu
//id_sec id_per name_sec num_reg date_afil type_sec date_des
$id_sec=strtoupper($_POST[id_sec]);
$name_sec=strtoupper($_POST[name_sec]);
$num_reg=strtoupper($_POST[num_reg]);
$type_sec=$_POST[type_sec];
//TABLA old_cas
//id_old_cas id_func date_start date_last year_rat month_rat day_rat
$id_old_cas=$_POST[id_old_cas];
$date_start=$_POST[date_start];
$date_last=$_POST[date_last];
$year_rat=$_POST[year_rat];
$month_rat=$_POST[month_rat];
$day_rat=$_POST[day_rat];
//TABLA cta_banc
//id_cta_banc id_func bank type_ac num_ac dist_ac
$id_cta_banc=strtoupper($_POST[id_cta_banc]);
$bank=strtoupper($_POST[bank]); 
$type_ac=$_POST[type_ac]; 
$num_ac=$_POST[num_ac]; 
$dist_ac=strtoupper($_POST[dist_ac]);
//TABLE permanente_docs
//id_perm_docs id_per memo file_pers pers_dat_incomp pers_dat_conf
//cv ci date_cad_ci cn cm afp solvency ins_fund
$id_perm_docs=$_POST[id_perm_docs];
$cv=$_POST[cv]; 
$ci=$_POST[ci];  
$date_cad_ci=$_POST[date_cad_ci];
$cn=$_POST[cn];  
$cm=$_POST[cm];  
//TABLE ult_decl
//id_ult_decl id_per date_dbr date_di
$id_ult_decl=$_POST[id_ult_decl];
$date_dbr=$_POST[date_dbr];
$date_di=$_POST[date_di];
//TABLE char_per
//id_char_per id_per dir_g unit area boss_is boss_ij charge date_des num_memo
$id_char_per=strtoupper($_POST[id_char_per]);
$dir_g=strtoupper($_POST[dir_g]); 
$unit=strtoupper($_POST[unit]); 
$area=strtoupper($_POST[area]); 
$boss_is=strtoupper($_POST[boss_is]); 
$boss_ij=strtoupper($_POST[boss_ij]); 
$charge=strtoupper($_POST[charge]); 
$date_des=$_POST[date_des];
$num_memo=strtoupper($_POST[num_memo]);
//-----------------------------
//TABLA soc_secu
//id_sec id_per name_sec num_reg date_afil type_sec date_des

/*	echo "	UPDATE ".TABLE23." SET
	name_sec='$name_sec', num_reg='$num_reg',type_sec='$type_sec'
	WHERE id_sec='$id_sec' </br>
";*/
	$rs=$db->query("
	UPDATE ".TABLE23." SET
	name_sec='$name_sec', num_reg='$num_reg', type_sec='$type_sec'
	WHERE id_sec='$id_sec'
	");
//TABLA old_cas
//id_old_cas id_func date_start date_last year_rat month_rat day_rat
/*echo "UPDATE ".TABLE24." SET
	date_start='$date_start', date_last='$date_last', year_rat='$year_rat', month_rat='$month_rat', day_rat='$day_rat'
	WHERE id_old_cas='$id_old_cas'</br>";*/
	$rs1=$db->query("
	UPDATE ".TABLE24." SET
	date_start='$date_start', date_last='$date_last', year_rat='$year_rat', month_rat='$month_rat', day_rat='$day_rat'
	WHERE id_old_cas='$id_old_cas'
	");
//TABLA cta_banc
//id_cta_banc id_func bank type_ac num_ac dist_ac
/*	echo "UPDATE ".TABLE25." SET
	bank='$bank', type_ac='$type_ac', num_ac='$num_ac', dist_ac='$dist_ac'
	WHERE id_cta_banc='$id_cta_banc' </br>";*/
	$rs2=$db->query("
	UPDATE ".TABLE25." SET
	bank='$bank', type_ac='$type_ac', num_ac='$num_ac', dist_ac='$dist_ac'
	WHERE id_cta_banc='$id_cta_banc'
	");
//TABLE permanente_docs
//id_perm_docs id_per memo file_pers pers_dat_incomp pers_dat_conf
//cv ci date_cad_ci cn cm afp solvency ins_fund
/*	echo "UPDATE ".TABLE26." SET
	cv='$id_per', ci='$ci', date_cad_ci='$date_cad_ci', cn='$cn', cm='$cm'
	WHERE id_perm_docs='$id_perm_docs' </br>";*/
	$rs3=$db->query("
	UPDATE ".TABLE26." SET
	cv='$cv', ci='$ci', date_cad_ci='$date_cad_ci', cn='$cn', cm='$cm'
	WHERE id_perm_docs='$id_perm_docs'
	");
//TABLE ult_decl
//id_ult_decl id_per date_dbr date_di
/*	echo "UPDATE ".TABLE27." SET
	date_dbr='$date_dbr', date_di='$date_di'
	WHERE id_ult_decl='$id_ult_decl'</br>";*/
	$rs4=$db->query("
	UPDATE ".TABLE27." SET
	date_dbr='$date_dbr', date_di='$date_di'
	WHERE id_ult_decl='$id_ult_decl'
	");
//TABLE char_per
//id_char_per id_per dir_g unit area boss_is boss_ij charge date_des num_memo
//-----------------------------
/*	echo "	UPDATE ".TABLE28." SET
	dir_g='$dir_g', unit='$unit', area='$area', boss_is='$boss_is', boss_ij='$boss_ij', charge='$charge', date_des='$date_des', num_memo='$num_memo'
	WHERE id_per='$id_per' </br>";*/
	$rs5=$db->query("
	UPDATE ".TABLE28." SET
	dir_g='$dir_g', unit='$unit', area='$area', boss_is='$boss_is', boss_ij='$boss_ij', charge='$charge', date_des='$date_des', num_memo='$num_memo'
	WHERE id_per='$id_per'
	");

	if(!$rs&&!$rs1&&!$rs2&&!$rs3&&!$rs4&&!$rs5)
	{
	exit;
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
<link href="css/reportes.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="data/css/ui/admincp/jquery-ui-1.8.17.custom.css">
<link rel="stylesheet" href="../../themes/base/jquery.ui.all.css">
	<!--<script src="data/js/jquery-1.7.1.min.js"></script>-->
	<script src="data/js/ui/jquery.ui.core.js"></script>
	<script src="data/js/ui/jquery.ui.widget.js"></script>
	<script src="data/js/ui/jquery.ui.datepicker.js"></script>
	<script>
	$(function() {
		$( ".datepick" ).datepicker({
			showOn: "button",
			buttonImage: "data/images/calendar.gif",
			buttonImageOnly: true, changeMonth: true, changeYear: true, yearRange: '-100:+100',
		});
	});
	</script>
<script>
function probar(){
if (!(confirm('¿Esta seguro de GUARDAR esta información? \n\rHaga click en "CANCELAR" si desea revisar sus datos, si está seguro del contenido de la información que esta enviando haga click en "ACEPTAR"'))){ 
       return false; 
	   
	   } 
}
</script>
</head>
<? 
//-------------------------SOC_SECU
$rx=$db->query("
SELECT * FROM ".TABLE22.",".TABLE23."
WHERE ".TABLE22.".id_per = '$id_per'
AND status = '1'
AND ".TABLE23.".id_per = '$id_per'
ORDER BY id_sec DESC LIMIT 1 
");
$rsx=$db->fetch_array($rx);
//----------------------OLD CAS
$rx1=$db->query("
SELECT * FROM ".TABLE22.",".TABLE24."
WHERE ".TABLE22.".id_per = '$id_per'
AND status = '1'
AND ".TABLE24.".id_func = '$id_func'
ORDER BY id_old_cas DESC LIMIT 1 
");
$rsx1=$db->fetch_array($rx1);
//----------------------CHAR PER
$rx2=$db->query("
SELECT * FROM ".TABLE22.",".TABLE28."
WHERE ".TABLE22.".id_per = '$id_per'
AND status = '1'
AND ".TABLE28.".id_per = '$id_per'
ORDER BY id_char_per DESC LIMIT 1 
");
$rsx2=$db->fetch_array($rx2);
//----------------------CTA BANC
$rx3=$db->query("
SELECT * FROM ".TABLE25."
WHERE id_func = '$id_func'
");
$rsx3=$db->fetch_array($rx3);
//----------------------PERMANENTE DOCS
$rx4=$db->query("
SELECT * FROM ".TABLE22." ,".TABLE26." 
WHERE ".TABLE22.".id_per = '$id_per'
AND status = '1'
AND ".TABLE26.".id_per = '$id_per'
ORDER BY id_perm_docs DESC LIMIT 1 
");
$rsx4=$db->fetch_array($rx4);
//----------------------ULTIMA DECLARACION JURADA
$rx5=$db->query("
SELECT * FROM ".TABLE27."
WHERE id_func = '$id_func'
");
$rsx5=$db->fetch_array($rx5);

?>
<body>
<form id="form1" name="form1" method="post" action="">
<table width="990" border="0" align="center" cellpadding="2" cellspacing="0">
<th width="607"><h2 align="left">DATOS LABORALES</h2></th>
</table>
<table width="990" border="0" align="center" cellpadding="2" cellspacing="0">
 <tr>
  	<td width="261">SEGURO MEDICO:</td>
    <td width="200">NUMERO DE SEGURO:</td>
    <td width="517">TIPO DE SEGURO:</td>
 </tr>
 <tr>
  	<td>
  		<input name="id_sec" type="hidden" id="id_sec" size="35" value="<? echo "$rsx[id_sec]" ?>" maxlength="64"/>    
  		<input name="name_sec" type="text" id="name_sec" size="35" value="<? echo "$rsx[name_sec]" ?>" maxlength="64"/>
   	</td>
	<td>
       <input name="num_reg" type="text" id="num_reg" size="25" value="<? echo "$rsx[num_reg]" ?>" maxlength="64"/>
    </td>    
   	<td>
        <select name="type_sec" id="type_sec" >
          <option value="<? echo "$rsx[type_sec]"?>"><? echo "$rsx[type_sec]"?></option>
          <option value="TITULAR">TITULAR</option>
          <option value="BENEFICIARIO">BENEFICIARIO</option>
        </select>
    </td>    

<!--1-->
</table>
<!--DATOS ANTIGUEDAD-->
<table width="990" border="0" align="center" cellpadding="2" cellspacing="0">
<th width="376"><h2 align="left">DATOS DE ANTIGUEDAD</h2></th>
<th width="628"><h2 align="left">DATOS DONDE SE ABONA SU SUELDO</h2></th>
</table>

<table width="990" border="0" align="center" cellpadding="2" cellspacing="0">
<td>
<table width="375" border="0" align="left" cellpadding="2" cellspacing="0">
    <tr>
        <td width="107">FECHA INICIO <br/>DE CALIFICACIÓN:</td>
        <td width="105">ULTIMA FECHA<br/>
        DE CALIFICACIÓN:</td>
        <td width="149">CALIFICACIÓN EN: <br>&nbsp;&nbsp;AÑOS&nbsp;&nbsp;&nbsp;MESES&nbsp;&nbsp;&nbsp;DÍAS</td>
     </tr>
	 <tr>
        <td width="107">
            <input name="id_old_cas" type="hidden" id="id_old_cas" size="7" maxlength="64" value="<? echo "$rsx1[id_old_cas]" ?>"/>
            <input name="date_start" type="text" id="date_start" size="7" maxlength="64" value="<? echo "$rsx1[date_start]" ?>"/>
        </td>
        <td width="105">
            <input name="date_last" type="text" id="date_last" size="7" maxlength="64" value="<? echo "$rsx1[date_last]" ?>"/>
        </td>
        <td width="149">
           <input name="year_rat" type="text" id="year_rat" size="1" maxlength="64" value="<? echo "$rsx1[year_rat]" ?>"/>
           <input name="month_rat" type="text" id="month_rat" size="1" maxlength="64" value="<? echo "$rsx1[month_rat]" ?>"/>
           <input name="day_rat" type="text" id="day_rat" size="1" maxlength="64" value="<? echo "$rsx1[day_rat]" ?>"/>
       
        </td>    
	</tr>
</table>
</td>    
<!--/*    <td width="39"></td>*/-->
<td>
<table  width="400" border="0" align="right" cellpadding="2" cellspacing="0">
<tr>
    <td width="100">BANCO:<br></td>
    <td width="100">TIPO DE CUENTA:<br></td>
    <td width="100">NÚMERO DE CUENTA:<br></td>
    <td width="10">DISTRITO EN LA QUE SE APERTURÓ:<br></td>
 </tr>
<tr>
	<td width="204">
    	<input name="id_cta_banc" type="hidden" id="id_cta_banc" size="25" maxlength="64" value="<? echo "$rsx3[id_cta_banc]" ?>" />
    	<input name="bank" type="text" id="bank" size="25" maxlength="64" value="<? echo "$rsx3[bank]" ?>" />
	</td>
	<td width="122">
    	<select name="type_ac" id="type_ac" >
           	<option value="<? echo "$rsx3[type_ac]" ?>"><? echo "$rsx3[type_ac]" ?></option>
			<option value="CTA. CTE.">CTA. CTE.</option>        
            <option value="CAJA AHORRO">CAJA AHORRO</option>
	    </select>

	</td>
	<td width="131">
    	<input name="num_ac" type="text" id="num_ac" size="15" maxlength="64" value="<? echo "$rsx3[num_ac]" ?>" />
	</td>
	<td width="160">
    	<input name="dist_ac" type="text" id="dist_ac" size="15" maxlength="64" value="<? echo "$rsx3[dist_ac]" ?>" />
	</td>
</tr>    
</table>
</td>
</table>




<!--FECHAS DE -->
<table width="990" border="0" align="center" cellpadding="2" cellspacing="0">
<th width="508"><h2 align="left">DOCUMENTACION ENTREGADA:</h2></th>
<th width="496"><h2 align="left">ULTIMAS FECHAS DE:</h2></th>
</table>
<table width="990" border="0" align="center" cellpadding="2" cellspacing="0">
<td>
<table width="528" border="0" align="left" cellpadding="2" cellspacing="0">
	<tr>
 		<td width="94">CURRICULUM VITAE:</td>	
		<td width="102">FOTOCOPIA C.I.:</td>	
		<td width="124">FECHA DE CADUCIDAD:</td>	
		<td width="91">FOTOCOPIA CERT. NAC.:</td>	
		<td width="95">FOTOCOPIA CERT. MAT.:</td>	
	
	<tr>	
 		<td width="94">
   		<input name="id_perm_docs" type="hidden" id="id_perm_docs" size="10" maxlength="64" value="<? echo "$rsx4[id_perm_docs]" ?>"/>
         <select name="cv" id="cv" >
           	<option value="<? echo "$rsx4[cv]" ?>"><? if($rsx4[cv]==0) echo "NO"; else echo "SI"; ?></option>
			<option value="0">NO</option>        
            <option value="1">SI</option>
	    </select>
		</td>	
		<td width="102">
         <select name="ci" id="ci" >
           	<option value="<? echo "$rsx4[ci]" ?>"><? if($rsx4[ci]==0) echo "NO"; else echo "SI"; ?></option>
			<option value="0">NO</option>        
            <option value="1">SI</option>
	    </select>
		</td>	
		<td width="124">
    		<input name="date_cad_ci" type="text" id="date_cad_ci" size="10" maxlength="64" value="<? echo "$rsx4[date_cad_ci]" ?>"/>
		</td>	
		<td width="91">
         <select name="cn" id="cn" >
           	<option value="<? echo "$rsx4[cn]" ?>"><? if($rsx4[cn]==0) echo "NO"; else echo "SI"; ?></option>
			<option value="0">NO</option>        
            <option value="1">SI</option>
	    </select>
		</td>	
		<td width="95">
         <select name="cm" id="cm" >
           	<option value="<? echo "$rsx4[cm]" ?>"><? if($rsx4[cm]==0) echo "NO"; else echo "SI"; ?></option>
			<option value="0">NO</option>        
            <option value="1">SI</option>
	    </select>		
        </td>	        
	</tr>
</table>    	        
</td>	            
<td>
<table  width="420" border="0" align="right" cellpadding="2" cellspacing="0">
	<tr>
    	<td>DECLARACIÓN JURADA DE BIENES Y RENTAS:</td>	
 		<td>DECLARACIÓN JURADA DE INCOMPATIBILIDAD:</td>
	</tr>
    	<td width="160">
    		<input name="id_ult_decl" type="hidden" id="id_ult_decl" size="15" maxlength="64" value="<? echo "$rsx5[id_ult_decl]" ?>"/>
    		<input name="date_dbr" type="text" id="date_dbr" size="15" maxlength="64" value="<? echo "$rsx5[date_dbr]" ?>"/>
		</td>
		<td width="160">
    		<input name="date_di" type="text" id="date_di" size="15" maxlength="64" value="<? echo "$rsx5[date_di]" ?>"/>
		</td>        
    </tr>
</table>    	        
</td>	            
</table>
</table>

<!--DATOS DEL CARGO ACTUAL QUE DESEMPEÑA-->
<table width="990" border="0" align="center" cellpadding="2" cellspacing="0">
<th><h2 align="left">DATOS DEL CARGO ACTUAL QUE DESEMPEÑA</h2></th>
</table>
<table width="990" border="0" align="center" cellpadding="2" cellspacing="0">
<tr> 		
        <td width="233">DIRECCION GENERAL:</td>	
		<td width="244">UNIDAD:</td>	
		<td width="247">ÁREA:</td>	
		<td width="250">JEFE INMEDIATO SUPERIOR:</td>	
</tr>
<tr> 		
        <td width="233">
    		<input name="id_char_per" type="hidden" id="id_char_per" size="15" maxlength="64" value="<? echo "$rsx2[id_char_per]" ?>"/>        
    		<input name="dir_g" type="text" id="dir_g" size="35" value="<? echo "$rsx2[dir_g]" ?>"/>
        </td>	
		<td width="244">
            <input name="unit" type="text" id="unit" size="35"  value="<? echo "$rsx2[unit]" ?>"/>
        </td>	
		<td width="247">
            <input name="area" type="text" id="area" size="35"  value="<? echo "$rsx2[area]" ?>"/>
        </td>	
		<td width="250"><input name="boss_is" type="text" id="boss_is" size="30" maxlength="64" value="<? echo "$rsx2[boss_is]"?>"/>
        </td>	
</tr>
<tr> 		
        <td width="233">JEFE SUPERIOR JERÁRQUICO:</td>	
		<td width="244">CARGO:</td>	
		<td width="247">FECHA DE INGRESO:</td>	
		<td width="250">Nº RESOLUCIÓN O MEMO:</td>
<tr> 		
        <td width="233"><input name="boss_ij" type="text" id="boss_ij" size="30" maxlength="64" value="<? echo "$rsx2[boss_ij]"?>"/></td>	
		<td width="244"><input  name="charge" cols="30" rows="2" id="charge" value="<? echo "$rsx2[charge]"?>"/></td>	
		<td width="247"><input name="date_des" type="text" id="date_des" size="10" maxlength="64" value="<? echo "$rsx2[date_des]" ?>"/> </td>	
		<td width="250"><input name="num_memo" type="text" id="num_memo" size="30" maxlength="64" value="<? echo "$rsx2[num_memo]" ?>"/></td>	
</tr>
  	<td width="165">
    <input type="submit" class="submit" onclick="return probar()" name="save" id="loginbutton" value="Guardar" />
    </td>
</table>
<!--SOLO PARA CONTRATOS EVENTUALES/CONSULTORES-->
<?

//$db->close();
?>

</body>
</html>