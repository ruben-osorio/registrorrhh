<?
require_once("security.php");
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();

$id_func=$_GET[id_func];
$id_con=$_GET[id_con];
				$rs=$db->query("
				SELECT * FROM ".TABLE2."
				WHERE funcionario.id_func='$id_func'
				");
				$rs1=$db->query("
				SELECT charge, date_des, date_end FROM ".TABLE31."
				WHERE id_con='$id_con'
				AND date_end='0000-00-00'
				");
$r=$db->fetch_array($rs);	
$r1=$db->fetch_array($rs1);			
				if ($rs&& mysql_num_rows($rs1)>0)
				{
					
				}
				else
				{
					exit;
				}		
		

if (isset($_POST[save]))	{	
				$date_end=cambia_dateN_to_dateMy_1($_POST[date_end]);	
				$dir_g=strtoupper($_POST[dir_g]);
				$unit=strtoupper($_POST[unit]);
				$area=strtoupper($_POST[area]); 
				$boss_is=strtoupper($_POST[boss_is]); 
				$boss_ij=strtoupper($_POST[boss_ij]);  
				$charge=strtoupper($_POST[charge]);  
				$num_res_con=$_POST[num_res_con];  
				$date_des=cambia_dateN_to_dateMy_1($_POST[date_des]);		
				$rs3=$db->query("
				UPDATE ".TABLE31."
				SET date_end='$date_end'
				WHERE id_con='$id_con'
				AND date_end='0000-00-00'
				");		
				$rs4=$db->query("
				INSERT INTO ".TABLE31."
				(id_con,dir_g, unit, area, boss_is, boss_ij, charge, num_res_con, date_des)
				VALUES				
				('$id_con','$dir_g', '$unit', '$area', '$boss_is', '$boss_ij', '$charge', '$num_res_con', '$date_des')
				");		
				
//dir_g unit area boss_is boss_ij charge num_memo date_des						
				if ($rs3&&$rs4)
				{
					echo '<div class="successre">Los datos fueron registrados exitosamente¡¡¡</div>';
				}
				else
				{
					echo '<div class="errorre">El funcionario no esta activo</div>';
				}					
}				
					
/*SELECT * FROM ".TABLE22." 
				WHERE	id_per='id_per' 
				AND 	id_fun='$id_func'*/


?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es-es" lang="es-es" dir="ltr" >
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="data/css/style-ext.css" rel="stylesheet" type="text/css">
<link href="css/reportes.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="data/css/ui/admincp/jquery-ui-1.8.17.custom.css">
<link rel="stylesheet" href="../../themes/base/jquery.ui.all.css">
	<script src="data/js/jquery-1.7.1.min.js"></script>
	<script src="data/js/ui/jquery.ui.core.js"></script>
	<script src="data/js/ui/jquery.ui.widget.js"></script>
	<script src="data/js/ui/jquery.ui.datepicker.js"></script>
	<link rel="stylesheet" href="../demos.css">
	<script>
	$(function() {
		$( ".datepick" ).datepicker({
			showOn: "button",
			buttonImage: "data/images/calendar.gif",
			buttonImageOnly: true
		});		
	});
	</script>



<fieldset>
<legend>Registro Movilidad de Funcionario

</legend><form id="form1" name="form1" method="post" action="" class="form" novalidate>
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr>
      <th><div align="left">Nombres:</div></th>
      <td><div class="form_row">  
       <? echo $r[name]; ?>
    
      </div></td>
    </tr>
    <tr>
      <th><div align="left">Apellido Paterno:</div></th>
      <td><div class="form_row">
       <? echo $r[l_name1]; ?>
      </div></td>
    </tr>
    <tr>
      <th><div align="left">Apellido Materno:</div></th>
      <td><div class="form_row">
       <? echo $r[l_name2]; ?>
      </div></td>
    </tr>
<tr>
      <th><div align="left">Cargo Desempeñado:</div></th>
      <td><div class="form_row">
        <? echo $r1[charge]; ?>
      </div></td>
    </tr>
 <tr>
      <th><div align="left">Fecha Designaci&oacute;n:</div></th>
      <td><div class="form_row">
       <? echo $r1[date_des]; ?>
      </div></td>
    </tr>   
      <tr>
      <th><div align="left">Fecha Finalizaci&oacute;n:</div></th>
      <td><div class="form_row">
        <input type="text" name="date_end" id="date_end" class="datepick" />
      </div></td>
    </tr>
  </table>
</fieldset>
<fieldset>
<legend>Datos del nuevo cargo
</legend>
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr>
      <th><div align="left">Direcci&oacute;n General:</div></th>
      <td><div class="form_row">  
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
		<option value="EQUIPO DE  AUDITORIA II">EQUIPO DE AUDITORIA II</option>
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
		<option value="EQUIPO DE DOTACION  DE PERSONAl Y PLANILLAS">EQUIPO DE DOTACION DE PERSONAl Y PLANILLAS</option>
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
		<option value="N/A">N/A</option>
        </select> 

      </div></td>
    
      </div></td>
    </tr>
    <tr>
      <th><div align="left">Unidad:</div></th>
      <td><div class="form_row">
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
		<option value="EQUIPO DE  AUDITORIA II">EQUIPO DE AUDITORIA II</option>
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
		<option value="EQUIPO DE DOTACION  DE PERSONAl Y PLANILLAS">EQUIPO DE DOTACION DE PERSONAl Y PLANILLAS</option>
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
		<option value="N/A">N/A</option>
        </select> 

      </div></td>
    </tr>
    <tr>
      <th><div align="left">Area:</div></th>
      <td><div class="form_row">
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
		<option value="EQUIPO DE  AUDITORIA II">EQUIPO DE AUDITORIA II</option>
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
		<option value="EQUIPO DE DOTACION  DE PERSONAl Y PLANILLAS">EQUIPO DE DOTACION DE PERSONAl Y PLANILLAS</option>
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
		<option value="N/A">N/A</option>
        </select> 
         
         
         
         
         
      </div></td>
    </tr>
<tr>
      <th><div align="left">Jefe Inmediato Superior:</div></th>
      <td><div class="form_row">
		 <input name="boss_is" type="text" class="input " id="boss_is" size="40" />
      </div></td>
    </tr>
 <tr>
      <th><div align="left">Jefe Jer&aacute;rquico Superior</div></th>
      <td><div class="form_row">
		 <input name="boss_ij" type="text" class="input " id="boss_ij" size="40" />
      </div></td>
    </tr>   
      <tr>
      <th><div align="left">Cargo:</div></th>
      <td><div class="form_row">
		 <input name="charge" type="text" class="input " id="charge" size="40" />
      </div></td>
          </tr>  
            <th><div align="left">N&uacute;mero de Resoluci&oacute;n o Memo:</div></th>
      <td><div class="form_row">
 		<input name="num_res_con" type="text" class="input " id="num_res_con" size="40" />	
      </div></td>
          </tr>  
       		<th><div align="left">Fecha de Inicio:</div></th>
      <td><div class="form_row">
        <input type="text" name="date_des" id="date_des" class="datepick" />
      </div></td>
    </tr>
     <tr>
      <td>
        <div align="left"><label></label>
          <input type="submit" name="save" id="save" value="Guardar" />
        </div>
      </td>
    </tr>
  </table>
</form>
</fieldset>