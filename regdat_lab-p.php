<?
$id_func=$_GET['id_func'];
$id_per=$_GET['id_per'];
/*while ($post = each($_POST))
{
echo $post[0] . " = " . $post[1]."<br>";
}*/
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
//----------HABILITAR TABLA-------------
	$rsp1=$db->query("
	SELECT p7 FROM ".TABLE37." 
	WHERE id_func='$id_func'
	");
	$rsxp1=$db->fetch_array($rsp1);
	if($rsxp1[p7]==1)
	{
	header ("Location: exito.php");	
	}
//-----------------------------
//-------------------------SOC_SECU
$rx=$db->query("
SELECT id_sec, name_sec, num_reg FROM ".TABLE22.",".TABLE23."
WHERE ".TABLE22.".id_per = '$id_per'
AND status = '1'
AND ".TABLE23.".id_per = '$id_per'
ORDER BY id_sec DESC LIMIT 1 
");
$rsx=$db->fetch_array($rx);
//----------------------OLD CAS
$rx1=$db->query("
SELECT id_old_cas, date_cas, year_rat, month_rat, day_rat FROM ".TABLE22.",".TABLE24."
WHERE ".TABLE22.".id_per = '$id_per'
AND status = '1'
AND ".TABLE24.".id_per = '$id_per'
ORDER BY id_old_cas DESC LIMIT 1 
");
$rsx1=$db->fetch_array($rx1);
//----------------------CHAR PER
$rx2=$db->query("
SELECT id_char_per, charge, date_des FROM ".TABLE22.",".TABLE28."
WHERE ".TABLE22.".id_per = '$id_per'
AND status = '1'
AND ".TABLE28.".id_per = '$id_per'
ORDER BY id_char_per DESC LIMIT 1 
");
$rsx2=$db->fetch_array($rx2);

if (isset($_POST[save]))
{ 	
//TABLA soc_secu
//id_sec id_per name_sec num_reg date_afil type_sec date_des
$on_off=1;
$name_sec=strtoupper($_POST[name_sec]);
$num_reg=strtoupper($_POST[num_reg]);
$type_sec=$_POST[type_sec];
//TABLA old_cas
//id_old_cas id_func date_start date_last year_rat month_rat day_rat
$date_start=$_POST[date_start];
$date_last=$_POST[date_last];
$date_start=cambia_dateN_to_dateMy_1($date_start);	
$date_last=cambia_dateN_to_dateMy_1($date_last);	 
$year_rat=$_POST[year_rat];
$month_rat=$_POST[moth_rat];
$day_rat=$_POST[day_rat];
//TABLA cta_banc
//id_cta_banc id_func bank type_ac num_ac dist_ac
$bank=strtoupper($_POST[bank]); 
$type_ac=$_POST[type_ac]; 
$num_ac=$_POST[num_ac]; 
$dist_ac=strtoupper($_POST[dist_ac]);
//TABLE permanente_docs
//id_perm_docs id_per memo file_pers pers_dat_incomp pers_dat_conf
//cv ci date_cad_ci cn cm afp solvency ins_fund
$cv=$_POST[cv]; 
$ci=$_POST[ci];  
$date_cad_ci=$_POST[date_cad_ci];
$date_cad_ci=cambia_dateN_to_dateMy_1($date_cad_ci);	 
$cn=$_POST[cn];  
$cm=$_POST[cm];  
//TABLE ult_decl
//id_ult_decl id_per date_dbr date_di
$date_dbr=$_POST[date_dbr];
$date_dbr=cambia_dateN_to_dateMy_1($date_dbr);	 
$date_di=$_POST[date_di];
$date_di=cambia_dateN_to_dateMy_1($date_di);
//TABLE char_per
//id_char_per id_per dir_g unit area boss_is boss_ij charge date_des num_memo
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
	$rs=$db->query("
	UPDATE ".TABLE23." SET
	type_sec='$type_sec'
	WHERE id_sec='$rsx[id_sec]'
	");
//TABLA old_cas
//id_old_cas id_func date_start date_last year_rat month_rat day_rat
	$rs1=$db->query("
	UPDATE ".TABLE24." SET
	date_start='$date_start'
	WHERE id_old_cas='$rsx1[id_old_cas]'
	");
//TABLA cta_banc
//id_cta_banc id_func bank type_ac num_ac dist_ac
	$rs2=$db->query("
	INSERT INTO ".TABLE25." 
	(id_func, bank, type_ac, num_ac, dist_ac)
	VALUES 
	('$id_func','$bank','$type_ac','$num_ac','$dist_ac')
	");
//TABLE permanente_docs
//id_perm_docs id_per memo file_pers pers_dat_incomp pers_dat_conf
//cv ci date_cad_ci cn cm afp solvency ins_fund
	$rs3=$db->query("
	INSERT INTO ".TABLE26." 
	(id_per,cv, ci, date_cad_ci, cn, cm)
	VALUES 
	('$id_per','$cv','$ci','$date_cad_ci','$cn','$cm')
	");
//TABLE ult_decl
//id_ult_decl id_per date_dbr date_di
	$rs4=$db->query("
	INSERT INTO ".TABLE27." 
	(id_func, date_dbr, date_di)
	VALUES 
	('$id_func','$date_dbr','$date_di')
	");
//TABLE char_per
//id_char_per id_per dir_g unit area boss_is boss_ij charge date_des num_memo
//-----------------------------
	$rs5=$db->query("
	UPDATE ".TABLE28." SET
	dir_g='$dir_g', unit='$unit', area='$area', boss_is='$boss_is', boss_ij='$boss_ij', charge='$charge', date_des='$date_des', num_memo='$num_memo'
	WHERE id_per='$id_per'
	");
	//-------------DESABILITAR TABLA------------
	$rs7=$db->query("
	UPDATE ".TABLE37." SET p7='$on_off'
	WHERE id_func='$id_func'
	");	
	header ("Location: exito.php");	
	//----------------------------------------
	if(!$rs&&!$rs1&&!$rs2&&!$rs3&&!$rs4&&!$rs7)
	{
	exit;
	}
//	echo "verdad";
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

<body id="bd">
<form id="form1" name="form1" method="post" action="">
<table width="990" border="0" align="center" cellpadding="2" cellspacing="0">
<td width="607"><h2><img src="data/images/datlab.jpg" width="500" height="50" /></h2></td>
</table>
<table id="ftab" width="990" border="0" align="center" cellpadding="2" cellspacing="0">
 <tr>
  	<td width="261">SEGURO MEDICO:</td>
    <td width="200">NUMERO DE SEGURO:</td>
    <td width="517">TIPO DE SEGURO:</td>
 </tr>
 <tr>
  	<td>
  		<input name="name_sec" type="text" id="name_sec" size="35" value="<? echo "$rsx[name_sec]" ?>" maxlength="64"  readonly="readonly"/>
   	</td>
	<td>
       <input name="num_reg" type="text" id="num_reg" size="25" value="<? echo "$rsx[num_reg]" ?>" maxlength="64"  readonly="readonly" />
    </td>    
   	<td>
        <select name="type_sec" id="type_sec" >
          <option value="TITULAR">TITULAR</option>
          <option value="BENEFICIARIO">BENEFICIARIO</option>
        </select>
    </td>    

<!--1-->
</table>
<!--DATOS ANTIGUEDAD-->
<table width="990" border="0" align="center" cellpadding="2" cellspacing="0">
<td width="382"><h2><img src="data/images/datant.jpg" width="400" height="50" /></h2></td>
<td width="600"><h2><img src="data/images/datab.jpg" width="500" height="50" /></h2></td>
</table>

<table width="990" border="0" align="center" cellpadding="2" cellspacing="0">
<td>
<table id="ftab" width="375" border="0" align="left" cellpadding="2" cellspacing="0">
    <tr>
        <td width="107">FECHA INICIO <br/>DE CALIFICACIÓN:</td>
        <td width="105">ULTIMA FECHA<br/>
        DE CALIFICACIÓN:</td>
        <td width="149">CALIFICACIÓN EN: <br>&nbsp;&nbsp;AÑOS&nbsp;&nbsp;&nbsp;MESES&nbsp;&nbsp;&nbsp;DÍAS</td>
     </tr>
	 <tr>
        <td width="107">
            <input name="date_start" type="text" id="date_start" size="7" maxlength="64" class="datepick" readonly="readonly"/>
        </td>
        <td width="105">
            <input name="date_last" type="text" id="date_last" size="7" maxlength="64" value="<? echo "$rsx1[date_cas]" ?>"readonly="readonly" />
        </td>
        <td width="149">
           <input name="year_rat" type="text" id="year_rat" size="1" maxlength="64" value="<? echo "$rsx1[year_rat]" ?>" readonly="readonly" />
           <input name="month_rat" type="text" id="month_rat" size="1" maxlength="64" value="<? echo "$rsx1[month_rat]" ?>" readonly="readonly" />
           <input name="day_rat" type="text" id="day_rat" size="1" maxlength="64" value="<? echo "$rsx1[day_rat]" ?>" readonly="readonly" />
       
        </td>    
	</tr>
</table>
</td>    
<!--/*    <td width="39"></td>*/-->
<td>
<table id="ftab" width="400" border="0" align="right" cellpadding="2" cellspacing="0">
<tr>
    <td width="100">BANCO:<br></td>
    <td width="100">TIPO DE CUENTA:<br></td>
    <td width="100">NÚMERO DE CUENTA:<br></td>
    <td width="10">DISTRITO EN LA QUE SE APERTURÓ:<br></td>
 </tr>
<tr>
	<td width="204">
    	<input name="bank" type="text" id="bank" size="25" maxlength="64" class="required" />
	</td>
	<td width="122">
    	<select name="type_ac" id="type_ac" >
          <option value="CTA. CTE.">CTA. CTE.</option>
          <option value="CAJA AHORRO">CAJA AHORRO</option>
	    </select>

	</td>
	<td width="131">
    	<input name="num_ac" type="text" id="num_ac" size="15" maxlength="64" class="required" />
	</td>
	<td width="160">
    	<input name="dist_ac" type="text" id="dist_ac" size="15" maxlength="64" class="required" />
	</td>
</tr>    
</table>
</td>
</table>




<!--FECHAS DE -->
<table width="990" border="0" align="center" cellpadding="2" cellspacing="0">
<td width="564"><h2><img src="data/images/docen.jpg" width="500" height="50" /></h2></td>
<td width="418"><h2><img src="data/images/ulfe.jpg" width="400" height="50" /></h2></td>
</table>
<table width="990" border="0" align="center" cellpadding="2" cellspacing="0">
<td>
<table id="ftab" width="528" border="0" align="left" cellpadding="2" cellspacing="0">
	<tr>
 		<td width="94">CURRICULUM VITAE:</td>	
		<td width="102">FOTOCOPIA C.I.:</td>	
		<td width="124">FECHA DE CADUCIDAD:</td>	
		<td width="91">FOTOCOPIA CERT. NAC.:</td>	
		<td width="95">FOTOCOPIA CERT. MAT.:</td>	
	
	<tr>	
 		<td width="94">
			<input name="cv" type="radio" value="0" checked="checked" />
			NO
	        <input name="cv" type="radio" value="1" />SI
		</td>	
		<td width="102">
			<input name="ci" type="radio" value="0" checked="checked" />
			NO
	        <input name="ci" type="radio" value="1" />SI
		</td>	
		<td width="124">
    		<input name="date_cad_ci" type="text" class="datepick required" id="date_cad_ci" value="00-00-0000" size="10" maxlength="64" />
		</td>	
		<td width="91">
			<input name="cn" type="radio" value="0" checked="checked" />
			NO
	        <input name="cn" type="radio" value="1" />SI
		</td>	
		<td width="95">
			<input name="cm" type="radio" value="0" checked="checked" />
			NO
	      	<input name="cm" type="radio" value="1" />SI
		</td>	        
	</tr>
</table>    	        
</td>	            
<td>
<table id="ftab" width="420" border="0" align="right" cellpadding="2" cellspacing="0">
	<tr>
    	<td>DECLARACIÓN JURADA DE BIENES Y RENTAS:</td>	
 		<td>DECLARACIÓN JURADA DE INCOMPATIBILIDAD:</td>
	</tr>
    	<td width="160">
    		<input name="date_dbr" type="text" id="date_dbr" size="15" maxlength="64" class="datepick"/>
		</td>
		<td width="160">
    		<input name="date_di" type="text" id="date_di" size="15" maxlength="64" class="datepick"/>
		</td>        
    </tr>
</table>    	        
</td>	            
</table>
</table>

<!--DATOS DEL CARGO ACTUAL QUE DESEMPEÑA-->
<table width="990" border="0" align="center" cellpadding="2" cellspacing="0">
<td><h2><img src="data/images/datcar.jpg" width="700" height="50" /></h2></td>
</table>
<table id="ftab" width="990" border="0" align="center" cellpadding="2" cellspacing="0">
<tr> 		
        <td width="233">DIRECCION GENERAL:</td>	
		<td width="244">UNIDAD:</td>	
		<td width="247">ÁREA:</td>	
		<td width="250">JEFE INMEDIATO SUPERIOR:</td>	
</tr>
<tr> 		
        <td width="233">
        <select name="dir_g" id="dir_g" style="width:200px">
		<option value="ACCESO Y PERMANENCIA (INFRAESTRUCTURA)">ACCESO Y PERMANENCIA (INFRAESTRUCTURA)</option>
		<option value="APACITACION Y EVALUACION DEL DESEMPEÑO">CAPACITACION Y EVALUACION DEL DESEMPEÑO</option>
		<option value="COORDINACION PLURINACIONAL PARA EL DESARROLLO DE LENGUAS PARA LA EDUCACION">COORDINACION PLURINACIONAL PARA EL DESARROLLO DE LENGUAS PARA LA EDUCACION</option>
		<option value="CORRESPONDENCIA DESPACHO">CORRESPONDENCIA DESPACHO</option>
		<option value="CORRESPONDENCIA EXTERNO SALIENTE">CORRESPONDENCIA EXTERNO SALIENTE</option>
		<option value="DESPACHO DE EDUCACION">DESPACHO DE EDUCACION</option>
		<option value="DESPACHO MINISTRO MEMORANDO">DESPACHO MINISTRO MEMORANDO</option>
		<option value="DIRECCION GENERAL DE ASUNTOS ADMINISTRATIVOS">DIRECCION GENERAL DE ASUNTOS ADMINISTRATIVOS</option>
		<option value="DIRECCION GENERAL DE ASUNTOS JURIDICOS">DIRECCION GENERAL DE ASUNTOS JURIDICOS</option>
		<option value="DIRECCION GENERAL DE CIENCIA Y TECNOLOGIA">DIRECCION GENERAL DE CIENCIA Y TECNOLOGIA</option>
		<option value="DIRECCION GENERAL DE EDUCACION DE ADULTOS">DIRECCION GENERAL DE EDUCACION DE ADULTOS</option>
		<option value="DIRECCION GENERAL DE EDUCACION ESPECIAL">DIRECCION GENERAL DE EDUCACION ESPECIAL</option>
		<option value="DIRECCION GENERAL DE EDUCACION PRIMARIA">DIRECCION GENERAL DE EDUCACION PRIMARIA</option>
		<option value="DIRECCION GENERAL DE EDUCACION SECUNDARIA">DIRECCION GENERAL DE EDUCACION SECUNDARIA</option>
		<option value="DIRECCION GENERAL DE EDUCACION SUPERIOR TECNICA, TECNOLOGICA, LINGUISTICA Y ARTISTICA">DIRECCION GENERAL DE EDUCACION SUPERIOR TECNICA, TECNOLOGICA, LINGUISTICA Y ARTISTICA</option>
		<option value="DIRECCION GENERAL DE EDUCACION SUPERIOR UNIVERSITARIA">DIRECCION GENERAL DE EDUCACION SUPERIOR UNIVERSITARIA</option>
		<option value="DIRECCION GENERAL DE FORMACION DE MAESTROS">DIRECCION GENERAL DE FORMACION DE MAESTROS</option>
		<option value="DIRECCION GENERAL DE PLANIFICACION">DIRECCION GENERAL DE PLANIFICACION</option>
		<option value="DIRECCION GENERAL DE POST ALFABETIZACION">DIRECCION GENERAL DE POST ALFABETIZACION</option>
		<option value="DIRECCION GENERAL DE TECNOLOGIA DE LA INFORMACION Y COMUNICACION">DIRECCION GENERAL DE TECNOLOGIA DE LA INFORMACION Y COMUNICACION</option>
		<option value="EQUIPO ARMONIA CON LA NATURALEZA Y JUSTICIA SOCIAL">EQUIPO ARMONIA CON LA NATURALEZA Y JUSTICIA SOCIAL</option>
		<option value="EQUIPO BONO JUANCITO PINTO">EQUIPO BONO JUANCITO PINTO</option>
		<option value="EQUIPO DE  AUDITORIA II">EQUIPO DE  AUDITORIA II</option>
		<option value="EQUIPO DE ACREDITACION UNIVERSITARIA">EQUIPO DE ACREDITACION UNIVERSITARIA</option>
	<option value="EQUIPO DE ADMINISTRACION DE BIENES Y SERVICIOS GENERALES">EQUIPO DE ADMINISTRACION DE BIENES Y SERVICIOS GENERALES</option>
		<option value="EQUIPO DE ADMINISTRACION DE PLANILLAS">EQUIPO DE ADMINISTRACION DE PLANILLAS</option>
		<option value="EQUIPO DE ANALISIS E INVESTIGACION SECTORIAL INDICADORES Y ANALISIS EDUCATIVO">EQUIPO DE ANALISIS E INVESTIGACION SECTORIAL INDICADORES Y ANALISIS EDUCATIVO</option>
		<option value="EQUIPO DE AUDITORIA I">EQUIPO DE AUDITORIA I</option>
		<option value="EQUIPO DE BIENESTAR SOCIAL">EQUIPO DE BIENESTAR SOCIAL</option>
		<option value="EQUIPO DE CONTABILIDAD">EQUIPO DE CONTABILIDAD</option>
		<option value="EQUIPO DE CONTRATACIONES DE BIENES Y SERVICIOS">EQUIPO DE CONTRATACIONES DE BIENES Y SERVICIOS</option>
		<option value="EQUIPO DE DESARROLLO ORGANIZACIONAL">EQUIPO DE DESARROLLO ORGANIZACIONAL</option>
		<option value="EQUIPO DE DISTRIBUCION DE BIENES EDUCATIVOS">EQUIPO DE DISTRIBUCION DE BIENES EDUCATIVOS</option>
		<option value="EQUIPO DE DOTACION  DE PERSONAl Y PLANILLAS">EQUIPO DE DOTACION  DE PERSONAl Y PLANILLAS</option>
		<option value="EQUIPO DE EDUCACION ESPECIAL ">EQUIPO DE EDUCACION ESPECIAL </option>
		<option value="EQUIPO DE EVALUACION CURRICULAR ACADEMICA E INFRAESTRUCTURA">EQUIPO DE EVALUACION CURRICULAR ACADEMICA E INFRAESTRUCTURA</option>
		<option value="EQUIPO DE FORMACION ARTISTICA">EQUIPO DE FORMACION ARTISTICA</option>
		<option value="EQUIPO DE FORMACION BASICA (GESTION INSTITUCIONAL)">EQUIPO DE FORMACION BASICA (GESTION INSTITUCIONAL)</option>
		<option value="EQUIPO DE FORMACION CONTINUA Y POSTGRADUAL">EQUIPO DE FORMACION CONTINUA Y POSTGRADUAL</option>
		<option value="EQUIPO DE FORMACION INICIAL">EQUIPO DE FORMACION INICIAL</option>
		<option value="EQUIPO DE GENERO GENERACIONAL Y SOCIAL">EQUIPO DE GENERO GENERACIONAL Y SOCIAL</option>
		<option value="EQUIPO DE GESTION CURRICULAR">EQUIPO DE GESTION CURRICULAR</option>
		<option value="EQUIPO DE GESTION DOCENTE Y DESARROLLO INSTITUCIONAL">EQUIPO DE GESTION DOCENTE Y DESARROLLO INSTITUCIONAL</option>
		<option value="EQUIPO DE GESTION INSTITUCIONAL DGEA">EQUIPO DE GESTION INSTITUCIONAL DGEA</option>
		<option value="EQUIPO DE GESTION INSTITUCIONAL SEP">EQUIPO DE GESTION INSTITUCIONAL SEP</option>
		<option value="EQUIPO DE GESTION Y DESARROLLO CURRICULAR">EQUIPO DE GESTION Y DESARROLLO CURRICULAR</option>
		<option value="EQUIPO DE INFORMACION EDUCATIVA">EQUIPO DE INFORMACION EDUCATIVA</option>
		<option value="EQUIPO DE INFRAESTRUCTURA">EQUIPO DE INFRAESTRUCTURA</option>
		<option value="EQUIPO DE MEMORIA INSTITUCIONAL">EQUIPO DE MEMORIA INSTITUCIONAL</option>
		<option value="EQUIPO DE NUEVAS TECNOLOGIAS DE INFORMACION Y COMUNICACION NTICS">EQUIPO DE NUEVAS TECNOLOGIAS DE INFORMACION Y COMUNICACION NTICS</option>
		<option value="EQUIPO DE PLANIFICACION OPERATIVA Y SEGUIMIENTO">EQUIPO DE PLANIFICACION OPERATIVA Y SEGUIMIENTO</option>
		<option value="EQUIPO DE PRESUPUESTOS">EQUIPO DE PRESUPUESTOS</option>
		<option value="EQUIPO DE RELACIONES INTERNACIONALES">EQUIPO DE RELACIONES INTERNACIONALES</option>
		<option value="EQUIPO DE SISTEMAS Y PROCESO DE DATOS">EQUIPO DE SISTEMAS Y PROCESO DE DATOS</option>
		<option value="EQUIPO DE TESORERIA">EQUIPO DE TESORERIA</option>
		<option value="EQUIPO DE UNIVERSIDADES INDIGENAS BOLIVIANAS (UNIBOL)">EQUIPO DE UNIVERSIDADES INDIGENAS BOLIVIANAS (UNIBOL)</option>
		<option value="EQUIPO EDUCACION INTRA INTERCULTURALIDAD PLURILINGUE ">EQUIPO EDUCACION INTRA INTERCULTURALIDAD PLURILINGUE </option>
		<option value="EQUIPO GESTION CURRICULAR INICIAL">EQUIPO GESTION CURRICULAR INICIAL</option>
		<option value="EQUIPO GESTION CURRICULAR PRIMARIA">EQUIPO GESTION CURRICULAR PRIMARIA</option>
		<option value="EQUIPO REGISTRO DOCENTE ADMINISTRATIVO">EQUIPO REGISTRO DOCENTE ADMINISTRATIVO</option>
		<option value="EQUIPO SISTEMA PLURINACIONAL DE CERTIFICACION DE COMPETENCIAS SPCC">EQUIPO SISTEMA PLURINACIONAL DE CERTIFICACION DE COMPETENCIAS SPCC</option>
		<option value="FORMACION Y CAPACITACION">FORMACION Y CAPACITACION</option>
		<option value="35" title="INSTITUTO DE INVESTIGACIONES PEDAGOGICAS PLURINACIONALES">INSTITUTO DE INVESTIGACIONES PEDAGOGICAS PLURINACIONALES</option>
		<option value="JEFATURA DE GABINETE">JEFATURA DE GABINETE</option>
		<option value="OBSERVATORIO PLURINACIONAL DE LA CALIDAD EDUCATIVA">OBSERVATORIO PLURINACIONAL DE LA CALIDAD EDUCATIVA</option>
		<option value="PORTAL EDUCATIVO">PORTAL EDUCATIVO</option>
		<option value="PROYECTOS EDUCATIVOS (PROME-INFRAESTRUCTURA)">PROYECTOS EDUCATIVOS (PROME-INFRAESTRUCTURA)</option>
		<option value="REGISTRO Y CONTROL DE PERSONAL">REGISTRO Y CONTROL DE PERSONAL</option>
		<option value="SOPORTE TECNICO A USUARIOS">SOPORTE TECNICO A USUARIOS</option>
		<option value="TELECENTROS EDUCATIVOS COMUNITARIO">TELECENTROS EDUCATIVOS COMUNITARIO</option>
		<option value="UNIDAD ADMINISTRATIVA">UNIDAD ADMINISTRATIVA</option>
		<option value="UNIDAD DE ANALISIS JURIDICO">UNIDAD DE ANALISIS JURIDICO</option>
		<option value="UNIDAD DE AUDITORIA INTERNA">UNIDAD DE AUDITORIA INTERNA</option>
		<option value="UNIDAD DE COMUNICACION SOCIAL">UNIDAD DE COMUNICACION SOCIAL</option>
		<option value="UNIDAD DE GESTION DE PERSONAL DEL SEP">UNIDAD DE GESTION DE PERSONAL DEL SEP</option>
		<option value="UNIDAD DE GESTION JURIDICA">UNIDAD DE GESTION JURIDICA</option>
		<option value="UNIDAD DE POLITICAS DE INTRACULTURALIDAD, INTERCULTURALIDAD Y PLURILINGUISMO">UNIDAD DE POLITICAS DE INTRACULTURALIDAD, INTERCULTURALIDAD Y PLURILINGUISMO</option>
		<option value="UNIDAD DE RRHH Y DESARROLLO ORGANIZACIONAL">UNIDAD DE RRHH Y DESARROLLO ORGANIZACIONAL</option>
		<option value="UNIDAD DE TITULOS PROFESIONALES">UNIDAD DE TITULOS PROFESIONALES</option>
		<option value="UNIDAD DE TRANSPARENCIA">UNIDAD DE TRANSPARENCIA</option>
		<option value="UNIDAD DE UNIVERSIDADES ">UNIDAD DE UNIVERSIDADES </option>
		<option value="UNIDAD FINANCIERA">UNIDAD FINANCIERA</option>
		<option value="VICEMINISTERIO DE CIENCIA Y TECNOLOGIA">VICEMINISTERIO DE CIENCIA Y TECNOLOGIA</option>
		<option value="VICEMINISTERIO DE EDUCACION ALTERNATIVA Y ESPECIAL">VICEMINISTERIO DE EDUCACION ALTERNATIVA Y ESPECIAL</option>
		<option value="VICEMINISTERIO DE EDUCACION REGULAR">VICEMINISTERIO DE EDUCACION REGULAR</option>
		<option value="VICEMINISTERIO DE EDUCACION SUPERIOR DE FORMACION PROFESIONAL">VICEMINISTERIO DE EDUCACION SUPERIOR DE FORMACION PROFESIONAL</option>
</select> 
        </td>	
		<td width="244">
        <select name="unit" id="unit" style="width:200px">
		<option value="ACCESO Y PERMANENCIA (INFRAESTRUCTURA)">ACCESO Y PERMANENCIA (INFRAESTRUCTURA)</option>
		<option value="APACITACION Y EVALUACION DEL DESEMPEÑO">CAPACITACION Y EVALUACION DEL DESEMPEÑO</option>
		<option value="COORDINACION PLURINACIONAL PARA EL DESARROLLO DE LENGUAS PARA LA EDUCACION">COORDINACION PLURINACIONAL PARA EL DESARROLLO DE LENGUAS PARA LA EDUCACION</option>
		<option value="CORRESPONDENCIA DESPACHO">CORRESPONDENCIA DESPACHO</option>
		<option value="CORRESPONDENCIA EXTERNO SALIENTE">CORRESPONDENCIA EXTERNO SALIENTE</option>
		<option value="DESPACHO DE EDUCACION">DESPACHO DE EDUCACION</option>
		<option value="DESPACHO MINISTRO MEMORANDO">DESPACHO MINISTRO MEMORANDO</option>
		<option value="DIRECCION GENERAL DE ASUNTOS ADMINISTRATIVOS">DIRECCION GENERAL DE ASUNTOS ADMINISTRATIVOS</option>
		<option value="DIRECCION GENERAL DE ASUNTOS JURIDICOS">DIRECCION GENERAL DE ASUNTOS JURIDICOS</option>
		<option value="DIRECCION GENERAL DE CIENCIA Y TECNOLOGIA">DIRECCION GENERAL DE CIENCIA Y TECNOLOGIA</option>
		<option value="DIRECCION GENERAL DE EDUCACION DE ADULTOS">DIRECCION GENERAL DE EDUCACION DE ADULTOS</option>
		<option value="DIRECCION GENERAL DE EDUCACION ESPECIAL">DIRECCION GENERAL DE EDUCACION ESPECIAL</option>
		<option value="DIRECCION GENERAL DE EDUCACION PRIMARIA">DIRECCION GENERAL DE EDUCACION PRIMARIA</option>
		<option value="DIRECCION GENERAL DE EDUCACION SECUNDARIA">DIRECCION GENERAL DE EDUCACION SECUNDARIA</option>
		<option value="DIRECCION GENERAL DE EDUCACION SUPERIOR TECNICA, TECNOLOGICA, LINGUISTICA Y ARTISTICA">DIRECCION GENERAL DE EDUCACION SUPERIOR TECNICA, TECNOLOGICA, LINGUISTICA Y ARTISTICA</option>
		<option value="DIRECCION GENERAL DE EDUCACION SUPERIOR UNIVERSITARIA">DIRECCION GENERAL DE EDUCACION SUPERIOR UNIVERSITARIA</option>
		<option value="DIRECCION GENERAL DE FORMACION DE MAESTROS">DIRECCION GENERAL DE FORMACION DE MAESTROS</option>
		<option value="DIRECCION GENERAL DE PLANIFICACION">DIRECCION GENERAL DE PLANIFICACION</option>
		<option value="DIRECCION GENERAL DE POST ALFABETIZACION">DIRECCION GENERAL DE POST ALFABETIZACION</option>
		<option value="DIRECCION GENERAL DE TECNOLOGIA DE LA INFORMACION Y COMUNICACION">DIRECCION GENERAL DE TECNOLOGIA DE LA INFORMACION Y COMUNICACION</option>
		<option value="EQUIPO ARMONIA CON LA NATURALEZA Y JUSTICIA SOCIAL">EQUIPO ARMONIA CON LA NATURALEZA Y JUSTICIA SOCIAL</option>
		<option value="EQUIPO BONO JUANCITO PINTO">EQUIPO BONO JUANCITO PINTO</option>
		<option value="EQUIPO DE  AUDITORIA II">EQUIPO DE  AUDITORIA II</option>
		<option value="EQUIPO DE ACREDITACION UNIVERSITARIA">EQUIPO DE ACREDITACION UNIVERSITARIA</option>
	<option value="EQUIPO DE ADMINISTRACION DE BIENES Y SERVICIOS GENERALES">EQUIPO DE ADMINISTRACION DE BIENES Y SERVICIOS GENERALES</option>
		<option value="EQUIPO DE ADMINISTRACION DE PLANILLAS">EQUIPO DE ADMINISTRACION DE PLANILLAS</option>
		<option value="EQUIPO DE ANALISIS E INVESTIGACION SECTORIAL INDICADORES Y ANALISIS EDUCATIVO">EQUIPO DE ANALISIS E INVESTIGACION SECTORIAL INDICADORES Y ANALISIS EDUCATIVO</option>
		<option value="EQUIPO DE AUDITORIA I">EQUIPO DE AUDITORIA I</option>
		<option value="EQUIPO DE BIENESTAR SOCIAL">EQUIPO DE BIENESTAR SOCIAL</option>
		<option value="EQUIPO DE CONTABILIDAD">EQUIPO DE CONTABILIDAD</option>
		<option value="EQUIPO DE CONTRATACIONES DE BIENES Y SERVICIOS">EQUIPO DE CONTRATACIONES DE BIENES Y SERVICIOS</option>
		<option value="EQUIPO DE DESARROLLO ORGANIZACIONAL">EQUIPO DE DESARROLLO ORGANIZACIONAL</option>
		<option value="EQUIPO DE DISTRIBUCION DE BIENES EDUCATIVOS">EQUIPO DE DISTRIBUCION DE BIENES EDUCATIVOS</option>
		<option value="EQUIPO DE DOTACION  DE PERSONAl Y PLANILLAS">EQUIPO DE DOTACION  DE PERSONAl Y PLANILLAS</option>
		<option value="EQUIPO DE EDUCACION ESPECIAL ">EQUIPO DE EDUCACION ESPECIAL </option>
		<option value="EQUIPO DE EVALUACION CURRICULAR ACADEMICA E INFRAESTRUCTURA">EQUIPO DE EVALUACION CURRICULAR ACADEMICA E INFRAESTRUCTURA</option>
		<option value="EQUIPO DE FORMACION ARTISTICA">EQUIPO DE FORMACION ARTISTICA</option>
		<option value="EQUIPO DE FORMACION BASICA (GESTION INSTITUCIONAL)">EQUIPO DE FORMACION BASICA (GESTION INSTITUCIONAL)</option>
		<option value="EQUIPO DE FORMACION CONTINUA Y POSTGRADUAL">EQUIPO DE FORMACION CONTINUA Y POSTGRADUAL</option>
		<option value="EQUIPO DE FORMACION INICIAL">EQUIPO DE FORMACION INICIAL</option>
		<option value="EQUIPO DE GENERO GENERACIONAL Y SOCIAL">EQUIPO DE GENERO GENERACIONAL Y SOCIAL</option>
		<option value="EQUIPO DE GESTION CURRICULAR">EQUIPO DE GESTION CURRICULAR</option>
		<option value="EQUIPO DE GESTION DOCENTE Y DESARROLLO INSTITUCIONAL">EQUIPO DE GESTION DOCENTE Y DESARROLLO INSTITUCIONAL</option>
		<option value="EQUIPO DE GESTION INSTITUCIONAL DGEA">EQUIPO DE GESTION INSTITUCIONAL DGEA</option>
		<option value="EQUIPO DE GESTION INSTITUCIONAL SEP">EQUIPO DE GESTION INSTITUCIONAL SEP</option>
		<option value="EQUIPO DE GESTION Y DESARROLLO CURRICULAR">EQUIPO DE GESTION Y DESARROLLO CURRICULAR</option>
		<option value="EQUIPO DE INFORMACION EDUCATIVA">EQUIPO DE INFORMACION EDUCATIVA</option>
		<option value="EQUIPO DE INFRAESTRUCTURA">EQUIPO DE INFRAESTRUCTURA</option>
		<option value="EQUIPO DE MEMORIA INSTITUCIONAL">EQUIPO DE MEMORIA INSTITUCIONAL</option>
		<option value="EQUIPO DE NUEVAS TECNOLOGIAS DE INFORMACION Y COMUNICACION NTICS">EQUIPO DE NUEVAS TECNOLOGIAS DE INFORMACION Y COMUNICACION NTICS</option>
		<option value="EQUIPO DE PLANIFICACION OPERATIVA Y SEGUIMIENTO">EQUIPO DE PLANIFICACION OPERATIVA Y SEGUIMIENTO</option>
		<option value="EQUIPO DE PRESUPUESTOS">EQUIPO DE PRESUPUESTOS</option>
		<option value="EQUIPO DE RELACIONES INTERNACIONALES">EQUIPO DE RELACIONES INTERNACIONALES</option>
		<option value="EQUIPO DE SISTEMAS Y PROCESO DE DATOS">EQUIPO DE SISTEMAS Y PROCESO DE DATOS</option>
		<option value="EQUIPO DE TESORERIA">EQUIPO DE TESORERIA</option>
		<option value="EQUIPO DE UNIVERSIDADES INDIGENAS BOLIVIANAS (UNIBOL)">EQUIPO DE UNIVERSIDADES INDIGENAS BOLIVIANAS (UNIBOL)</option>
		<option value="EQUIPO EDUCACION INTRA INTERCULTURALIDAD PLURILINGUE ">EQUIPO EDUCACION INTRA INTERCULTURALIDAD PLURILINGUE </option>
		<option value="EQUIPO GESTION CURRICULAR INICIAL">EQUIPO GESTION CURRICULAR INICIAL</option>
		<option value="EQUIPO GESTION CURRICULAR PRIMARIA">EQUIPO GESTION CURRICULAR PRIMARIA</option>
		<option value="EQUIPO REGISTRO DOCENTE ADMINISTRATIVO">EQUIPO REGISTRO DOCENTE ADMINISTRATIVO</option>
		<option value="EQUIPO SISTEMA PLURINACIONAL DE CERTIFICACION DE COMPETENCIAS SPCC">EQUIPO SISTEMA PLURINACIONAL DE CERTIFICACION DE COMPETENCIAS SPCC</option>
		<option value="FORMACION Y CAPACITACION">FORMACION Y CAPACITACION</option>
		<option value="35" title="INSTITUTO DE INVESTIGACIONES PEDAGOGICAS PLURINACIONALES">INSTITUTO DE INVESTIGACIONES PEDAGOGICAS PLURINACIONALES</option>
		<option value="JEFATURA DE GABINETE">JEFATURA DE GABINETE</option>
		<option value="OBSERVATORIO PLURINACIONAL DE LA CALIDAD EDUCATIVA">OBSERVATORIO PLURINACIONAL DE LA CALIDAD EDUCATIVA</option>
		<option value="PORTAL EDUCATIVO">PORTAL EDUCATIVO</option>
		<option value="PROYECTOS EDUCATIVOS (PROME-INFRAESTRUCTURA)">PROYECTOS EDUCATIVOS (PROME-INFRAESTRUCTURA)</option>
		<option value="REGISTRO Y CONTROL DE PERSONAL">REGISTRO Y CONTROL DE PERSONAL</option>
		<option value="SOPORTE TECNICO A USUARIOS">SOPORTE TECNICO A USUARIOS</option>
		<option value="TELECENTROS EDUCATIVOS COMUNITARIO">TELECENTROS EDUCATIVOS COMUNITARIO</option>
		<option value="UNIDAD ADMINISTRATIVA">UNIDAD ADMINISTRATIVA</option>
		<option value="UNIDAD DE ANALISIS JURIDICO">UNIDAD DE ANALISIS JURIDICO</option>
		<option value="UNIDAD DE AUDITORIA INTERNA">UNIDAD DE AUDITORIA INTERNA</option>
		<option value="UNIDAD DE COMUNICACION SOCIAL">UNIDAD DE COMUNICACION SOCIAL</option>
		<option value="UNIDAD DE GESTION DE PERSONAL DEL SEP">UNIDAD DE GESTION DE PERSONAL DEL SEP</option>
		<option value="UNIDAD DE GESTION JURIDICA">UNIDAD DE GESTION JURIDICA</option>
		<option value="UNIDAD DE POLITICAS DE INTRACULTURALIDAD, INTERCULTURALIDAD Y PLURILINGUISMO">UNIDAD DE POLITICAS DE INTRACULTURALIDAD, INTERCULTURALIDAD Y PLURILINGUISMO</option>
		<option value="UNIDAD DE RRHH Y DESARROLLO ORGANIZACIONAL">UNIDAD DE RRHH Y DESARROLLO ORGANIZACIONAL</option>
		<option value="UNIDAD DE TITULOS PROFESIONALES">UNIDAD DE TITULOS PROFESIONALES</option>
		<option value="UNIDAD DE TRANSPARENCIA">UNIDAD DE TRANSPARENCIA</option>
		<option value="UNIDAD DE UNIVERSIDADES ">UNIDAD DE UNIVERSIDADES </option>
		<option value="UNIDAD FINANCIERA">UNIDAD FINANCIERA</option>
		<option value="VICEMINISTERIO DE CIENCIA Y TECNOLOGIA">VICEMINISTERIO DE CIENCIA Y TECNOLOGIA</option>
		<option value="VICEMINISTERIO DE EDUCACION ALTERNATIVA Y ESPECIAL">VICEMINISTERIO DE EDUCACION ALTERNATIVA Y ESPECIAL</option>
		<option value="VICEMINISTERIO DE EDUCACION REGULAR">VICEMINISTERIO DE EDUCACION REGULAR</option>
		<option value="VICEMINISTERIO DE EDUCACION SUPERIOR DE FORMACION PROFESIONAL">VICEMINISTERIO DE EDUCACION SUPERIOR DE FORMACION PROFESIONAL</option>
</select>
        </td>	
		<td width="247">
        <select name="area" id="area" style="width:200px">
		<option value="ACCESO Y PERMANENCIA (INFRAESTRUCTURA)">ACCESO Y PERMANENCIA (INFRAESTRUCTURA)</option>
		<option value="APACITACION Y EVALUACION DEL DESEMPEÑO">CAPACITACION Y EVALUACION DEL DESEMPEÑO</option>
		<option value="COORDINACION PLURINACIONAL PARA EL DESARROLLO DE LENGUAS PARA LA EDUCACION">COORDINACION PLURINACIONAL PARA EL DESARROLLO DE LENGUAS PARA LA EDUCACION</option>
		<option value="CORRESPONDENCIA DESPACHO">CORRESPONDENCIA DESPACHO</option>
		<option value="CORRESPONDENCIA EXTERNO SALIENTE">CORRESPONDENCIA EXTERNO SALIENTE</option>
		<option value="DESPACHO DE EDUCACION">DESPACHO DE EDUCACION</option>
		<option value="DESPACHO MINISTRO MEMORANDO">DESPACHO MINISTRO MEMORANDO</option>
		<option value="DIRECCION GENERAL DE ASUNTOS ADMINISTRATIVOS">DIRECCION GENERAL DE ASUNTOS ADMINISTRATIVOS</option>
		<option value="DIRECCION GENERAL DE ASUNTOS JURIDICOS">DIRECCION GENERAL DE ASUNTOS JURIDICOS</option>
		<option value="DIRECCION GENERAL DE CIENCIA Y TECNOLOGIA">DIRECCION GENERAL DE CIENCIA Y TECNOLOGIA</option>
		<option value="DIRECCION GENERAL DE EDUCACION DE ADULTOS">DIRECCION GENERAL DE EDUCACION DE ADULTOS</option>
		<option value="DIRECCION GENERAL DE EDUCACION ESPECIAL">DIRECCION GENERAL DE EDUCACION ESPECIAL</option>
		<option value="DIRECCION GENERAL DE EDUCACION PRIMARIA">DIRECCION GENERAL DE EDUCACION PRIMARIA</option>
		<option value="DIRECCION GENERAL DE EDUCACION SECUNDARIA">DIRECCION GENERAL DE EDUCACION SECUNDARIA</option>
		<option value="DIRECCION GENERAL DE EDUCACION SUPERIOR TECNICA, TECNOLOGICA, LINGUISTICA Y ARTISTICA">DIRECCION GENERAL DE EDUCACION SUPERIOR TECNICA, TECNOLOGICA, LINGUISTICA Y ARTISTICA</option>
		<option value="DIRECCION GENERAL DE EDUCACION SUPERIOR UNIVERSITARIA">DIRECCION GENERAL DE EDUCACION SUPERIOR UNIVERSITARIA</option>
		<option value="DIRECCION GENERAL DE FORMACION DE MAESTROS">DIRECCION GENERAL DE FORMACION DE MAESTROS</option>
		<option value="DIRECCION GENERAL DE PLANIFICACION">DIRECCION GENERAL DE PLANIFICACION</option>
		<option value="DIRECCION GENERAL DE POST ALFABETIZACION">DIRECCION GENERAL DE POST ALFABETIZACION</option>
		<option value="DIRECCION GENERAL DE TECNOLOGIA DE LA INFORMACION Y COMUNICACION">DIRECCION GENERAL DE TECNOLOGIA DE LA INFORMACION Y COMUNICACION</option>
		<option value="EQUIPO ARMONIA CON LA NATURALEZA Y JUSTICIA SOCIAL">EQUIPO ARMONIA CON LA NATURALEZA Y JUSTICIA SOCIAL</option>
		<option value="EQUIPO BONO JUANCITO PINTO">EQUIPO BONO JUANCITO PINTO</option>
		<option value="EQUIPO DE  AUDITORIA II">EQUIPO DE  AUDITORIA II</option>
		<option value="EQUIPO DE ACREDITACION UNIVERSITARIA">EQUIPO DE ACREDITACION UNIVERSITARIA</option>
	<option value="EQUIPO DE ADMINISTRACION DE BIENES Y SERVICIOS GENERALES">EQUIPO DE ADMINISTRACION DE BIENES Y SERVICIOS GENERALES</option>
		<option value="EQUIPO DE ADMINISTRACION DE PLANILLAS">EQUIPO DE ADMINISTRACION DE PLANILLAS</option>
		<option value="EQUIPO DE ANALISIS E INVESTIGACION SECTORIAL INDICADORES Y ANALISIS EDUCATIVO">EQUIPO DE ANALISIS E INVESTIGACION SECTORIAL INDICADORES Y ANALISIS EDUCATIVO</option>
		<option value="EQUIPO DE AUDITORIA I">EQUIPO DE AUDITORIA I</option>
		<option value="EQUIPO DE BIENESTAR SOCIAL">EQUIPO DE BIENESTAR SOCIAL</option>
		<option value="EQUIPO DE CONTABILIDAD">EQUIPO DE CONTABILIDAD</option>
		<option value="EQUIPO DE CONTRATACIONES DE BIENES Y SERVICIOS">EQUIPO DE CONTRATACIONES DE BIENES Y SERVICIOS</option>
		<option value="EQUIPO DE DESARROLLO ORGANIZACIONAL">EQUIPO DE DESARROLLO ORGANIZACIONAL</option>
		<option value="EQUIPO DE DISTRIBUCION DE BIENES EDUCATIVOS">EQUIPO DE DISTRIBUCION DE BIENES EDUCATIVOS</option>
		<option value="EQUIPO DE DOTACION  DE PERSONAl Y PLANILLAS">EQUIPO DE DOTACION  DE PERSONAl Y PLANILLAS</option>
		<option value="EQUIPO DE EDUCACION ESPECIAL ">EQUIPO DE EDUCACION ESPECIAL </option>
		<option value="EQUIPO DE EVALUACION CURRICULAR ACADEMICA E INFRAESTRUCTURA">EQUIPO DE EVALUACION CURRICULAR ACADEMICA E INFRAESTRUCTURA</option>
		<option value="EQUIPO DE FORMACION ARTISTICA">EQUIPO DE FORMACION ARTISTICA</option>
		<option value="EQUIPO DE FORMACION BASICA (GESTION INSTITUCIONAL)">EQUIPO DE FORMACION BASICA (GESTION INSTITUCIONAL)</option>
		<option value="EQUIPO DE FORMACION CONTINUA Y POSTGRADUAL">EQUIPO DE FORMACION CONTINUA Y POSTGRADUAL</option>
		<option value="EQUIPO DE FORMACION INICIAL">EQUIPO DE FORMACION INICIAL</option>
		<option value="EQUIPO DE GENERO GENERACIONAL Y SOCIAL">EQUIPO DE GENERO GENERACIONAL Y SOCIAL</option>
		<option value="EQUIPO DE GESTION CURRICULAR">EQUIPO DE GESTION CURRICULAR</option>
		<option value="EQUIPO DE GESTION DOCENTE Y DESARROLLO INSTITUCIONAL">EQUIPO DE GESTION DOCENTE Y DESARROLLO INSTITUCIONAL</option>
		<option value="EQUIPO DE GESTION INSTITUCIONAL DGEA">EQUIPO DE GESTION INSTITUCIONAL DGEA</option>
		<option value="EQUIPO DE GESTION INSTITUCIONAL SEP">EQUIPO DE GESTION INSTITUCIONAL SEP</option>
		<option value="EQUIPO DE GESTION Y DESARROLLO CURRICULAR">EQUIPO DE GESTION Y DESARROLLO CURRICULAR</option>
		<option value="EQUIPO DE INFORMACION EDUCATIVA">EQUIPO DE INFORMACION EDUCATIVA</option>
		<option value="EQUIPO DE INFRAESTRUCTURA">EQUIPO DE INFRAESTRUCTURA</option>
		<option value="EQUIPO DE MEMORIA INSTITUCIONAL">EQUIPO DE MEMORIA INSTITUCIONAL</option>
		<option value="EQUIPO DE NUEVAS TECNOLOGIAS DE INFORMACION Y COMUNICACION NTICS">EQUIPO DE NUEVAS TECNOLOGIAS DE INFORMACION Y COMUNICACION NTICS</option>
		<option value="EQUIPO DE PLANIFICACION OPERATIVA Y SEGUIMIENTO">EQUIPO DE PLANIFICACION OPERATIVA Y SEGUIMIENTO</option>
		<option value="EQUIPO DE PRESUPUESTOS">EQUIPO DE PRESUPUESTOS</option>
		<option value="EQUIPO DE RELACIONES INTERNACIONALES">EQUIPO DE RELACIONES INTERNACIONALES</option>
		<option value="EQUIPO DE SISTEMAS Y PROCESO DE DATOS">EQUIPO DE SISTEMAS Y PROCESO DE DATOS</option>
		<option value="EQUIPO DE TESORERIA">EQUIPO DE TESORERIA</option>
		<option value="EQUIPO DE UNIVERSIDADES INDIGENAS BOLIVIANAS (UNIBOL)">EQUIPO DE UNIVERSIDADES INDIGENAS BOLIVIANAS (UNIBOL)</option>
		<option value="EQUIPO EDUCACION INTRA INTERCULTURALIDAD PLURILINGUE ">EQUIPO EDUCACION INTRA INTERCULTURALIDAD PLURILINGUE </option>
		<option value="EQUIPO GESTION CURRICULAR INICIAL">EQUIPO GESTION CURRICULAR INICIAL</option>
		<option value="EQUIPO GESTION CURRICULAR PRIMARIA">EQUIPO GESTION CURRICULAR PRIMARIA</option>
		<option value="EQUIPO REGISTRO DOCENTE ADMINISTRATIVO">EQUIPO REGISTRO DOCENTE ADMINISTRATIVO</option>
		<option value="EQUIPO SISTEMA PLURINACIONAL DE CERTIFICACION DE COMPETENCIAS SPCC">EQUIPO SISTEMA PLURINACIONAL DE CERTIFICACION DE COMPETENCIAS SPCC</option>
		<option value="FORMACION Y CAPACITACION">FORMACION Y CAPACITACION</option>
		<option value="35" title="INSTITUTO DE INVESTIGACIONES PEDAGOGICAS PLURINACIONALES">INSTITUTO DE INVESTIGACIONES PEDAGOGICAS PLURINACIONALES</option>
		<option value="JEFATURA DE GABINETE">JEFATURA DE GABINETE</option>
		<option value="OBSERVATORIO PLURINACIONAL DE LA CALIDAD EDUCATIVA">OBSERVATORIO PLURINACIONAL DE LA CALIDAD EDUCATIVA</option>
		<option value="PORTAL EDUCATIVO">PORTAL EDUCATIVO</option>
		<option value="PROYECTOS EDUCATIVOS (PROME-INFRAESTRUCTURA)">PROYECTOS EDUCATIVOS (PROME-INFRAESTRUCTURA)</option>
		<option value="REGISTRO Y CONTROL DE PERSONAL">REGISTRO Y CONTROL DE PERSONAL</option>
		<option value="SOPORTE TECNICO A USUARIOS">SOPORTE TECNICO A USUARIOS</option>
		<option value="TELECENTROS EDUCATIVOS COMUNITARIO">TELECENTROS EDUCATIVOS COMUNITARIO</option>
		<option value="UNIDAD ADMINISTRATIVA">UNIDAD ADMINISTRATIVA</option>
		<option value="UNIDAD DE ANALISIS JURIDICO">UNIDAD DE ANALISIS JURIDICO</option>
		<option value="UNIDAD DE AUDITORIA INTERNA">UNIDAD DE AUDITORIA INTERNA</option>
		<option value="UNIDAD DE COMUNICACION SOCIAL">UNIDAD DE COMUNICACION SOCIAL</option>
		<option value="UNIDAD DE GESTION DE PERSONAL DEL SEP">UNIDAD DE GESTION DE PERSONAL DEL SEP</option>
		<option value="UNIDAD DE GESTION JURIDICA">UNIDAD DE GESTION JURIDICA</option>
		<option value="UNIDAD DE POLITICAS DE INTRACULTURALIDAD, INTERCULTURALIDAD Y PLURILINGUISMO">UNIDAD DE POLITICAS DE INTRACULTURALIDAD, INTERCULTURALIDAD Y PLURILINGUISMO</option>
		<option value="UNIDAD DE RRHH Y DESARROLLO ORGANIZACIONAL">UNIDAD DE RRHH Y DESARROLLO ORGANIZACIONAL</option>
		<option value="UNIDAD DE TITULOS PROFESIONALES">UNIDAD DE TITULOS PROFESIONALES</option>
		<option value="UNIDAD DE TRANSPARENCIA">UNIDAD DE TRANSPARENCIA</option>
		<option value="UNIDAD DE UNIVERSIDADES ">UNIDAD DE UNIVERSIDADES </option>
		<option value="UNIDAD FINANCIERA">UNIDAD FINANCIERA</option>
		<option value="VICEMINISTERIO DE CIENCIA Y TECNOLOGIA">VICEMINISTERIO DE CIENCIA Y TECNOLOGIA</option>
		<option value="VICEMINISTERIO DE EDUCACION ALTERNATIVA Y ESPECIAL">VICEMINISTERIO DE EDUCACION ALTERNATIVA Y ESPECIAL</option>
		<option value="VICEMINISTERIO DE EDUCACION REGULAR">VICEMINISTERIO DE EDUCACION REGULAR</option>
		<option value="VICEMINISTERIO DE EDUCACION SUPERIOR DE FORMACION PROFESIONAL">VICEMINISTERIO DE EDUCACION SUPERIOR DE FORMACION PROFESIONAL</option>
</select>
        </td>	
		<td width="250"><input name="boss_is" type="text" id="boss_is" size="30" maxlength="64" class="required" /></td>	
</tr>
<tr> 		
        <td width="233">JEFE SUPERIOR JERÁRQUICO:</td>	
		<td width="244">CARGO:</td>	
		<td width="247">FECHA DE INGRESO:</td>	
		<td width="250">Nº RESOLUCIÓN O MEMO:</td>
<tr> 		
        <td width="233"><input name="boss_ij" type="text" id="boss_ij" size="30" maxlength="64" class="required" /></td>	
		<td width="244"><textarea name="charge" cols="30" rows="2" readonly="readonly" id="charge"><? echo "$rsx2[charge]"?></textarea></td>	
		<td width="247"><input name="date_des" type="text" id="date_des" size="10" maxlength="64" value="<? echo "$rsx2[date_des]" ?>" readonly="readonly"/></td>	
		<td width="250"><input name="num_memo" type="text" id="num_memo" size="30" maxlength="64" /></td>	
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