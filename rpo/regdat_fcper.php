<?
/*while ($post = each($_POST))
{
echo $post[0] . " = " . $post[1]."<br>";
}
echo "<br>";
echo $desc_o;
echo "<br>";*/
$id_func=$_GET['id_func'];
$id_per=$_GET['id_per'];
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
//----------HABILITAR TABLA-------------
	$rsp1=$db->query("
	SELECT p8 FROM ".TABLE37." 
	WHERE id_func='$id_func'
	");
	$rsxp1=$db->fetch_array($rsp1);
	if($rsxp1[p8]==1)
	{
	header ("Location: exito.php");	
	}
//-----------------------------


$rx=$db->query("
SELECT id_fin_per, source_fin FROM ".TABLE22.",".TABLE15."
WHERE ".TABLE22.".id_per = '$id_per'
AND status = '1'
AND ".TABLE15.".id_per = '$id_per'
ORDER BY id_fin_per DESC LIMIT 1 
");
$rsx=$db->fetch_array($rx);
if (isset($_POST[save]))
{

//id_fin_per id_per source_fin ag_fin prog_cat org_unit dep_bud item TABLE=fin_per TABLE15
$on_off=1;
$source_fin=$_POST[source_fin];
$ag_fin=$_POST[ag_fin];
$prog_cat=strtoupper($_POST[prog_cat]);
$org_unit=strtoupper($_POST[org_unit]);
$dep_bud=strtoupper($_POST[dep_bud]);
$item=strtoupper($_POST[item]);
//id_cat_per id_char_per cat level post_car mod_ent form_rec jornal sal_base TABLA=cat_per TABLE16
$cat=$_POST[cat];
$level=$_POST[level];
$level=$_POST[level];
$post_car=$_POST[post_car];
$mod_ent=$_POST[mod_ent];
$form_rec=$_POST[form_rec];
$jornal=$_POST[jornal];
$sal_base=strtoupper($_POST[sal_base]);
//'$id_per','$date_eval', '$res_eval', '$cons_eval', '$resp_eval', '$type_resp'
$date_eval=$_POST[date_eval];
$date_eval=cambia_dateN_to_dateMy_1($date_eval);
$res_eval=strtoupper($_POST[res_eval]);
$cons_eval=strtoupper($_POST[cons_eval]);
$resp_eval=strtoupper($_POST[resp_eval]);
$type_resp=strtoupper($_POST[type_resp]);
//id_fin_per id_per source_fin ag_fin prog_cat org_unit dep_bud item TABLE=fin_per TABLE15
//id_cat_per id_char_per cat level post_car mod_ent form_rec jornal sal_base TABLA=cat_per TABLE16
/*	echo "
	INSERT INTO ".TABLE15."(id_per,source_fin, ag_fin, prog_cat, org_unit, dep_bud, item)
	VALUES 
	('$source_fin', '$ag_fin', '$prog_cat', '$org_unit', '$dep_bud', '$item')
	INSERT INTO ".TABLE16." 
	(cat, level, post_car, mod_ent, form_rec, jornal, sal_base) VALUES 
	('$cat', '$level', '$post_car', '$mod_ent', '$form_rec', '$jornal', '$sal_base')
	";*/
	$rs=$db->query("
	UPDATE ".TABLE15." SET source_fin = '$source_fin', ag_fin = '$ag_fin', prog_cat = '$prog_cat', org_unit='$org_unit', dep_bud='$dep_bud', item = '$item'
	WHERE id_fin_per= '$rsx[id_fin_per]'
	AND id_per= '$id_per'
	");
	$rs1=$db->query("
	INSERT INTO ".TABLE16." 
	(id_per,cat, level, post_car, mod_ent, form_rec, jornal, sal_base)
	VALUES 
	('$id_per','$cat', '$level', '$post_car', '$mod_ent', '$form_rec', '$jornal', '$sal_base')
	");
	$rs2=$db->query("
	INSERT INTO ".TABLE29." 
	(id_per, date_eval, res_eval, cons_eval, resp_eval, type_resp)
	VALUES 
	('$id_per','$date_eval', '$res_eval', '$cons_eval', '$resp_eval', '$type_resp')
	");
	if(!$rs)
	{exit;
	}
	//-------------DESABILITAR TABLA------------
	$rs7=$db->query("
	UPDATE ".TABLE37." SET p8='$on_off'
	WHERE id_func='$id_func'
	");	
	//----------------------------------------
	header ("Location: exito.php");		
}

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FORMULARIO DE REGISTRO</title>
<link href="data/css/style-ext.css" rel="stylesheet" type="text/css"><link rel="stylesheet" type="text/css" media="screen" href="css/screen.css" />
<link rel="stylesheet" type="text/css" media="screen" href="css/screen.css" />
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
<script>
function probar(){
if (!(confirm('¿Esta seguro de GUARDAR esta información? \n\rHaga click en "CANCELAR" si desea revisar sus datos, si está seguro del contenido de la información que esta enviando haga click en "ACEPTAR"'))){ 
       return false; 
	   
	   } 
}
</script>

</head>



<link href="estilo.css" rel="stylesheet" type="text/css" />
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
			buttonImageOnly: true, changeMonth: true, changeYear: true, yearRange: '-100:+0',
		});
	});
	</script>
<body id="bd">
<form id="form1" name="form1" method="post" action="">
<!--FINANCIAMIENTO-->
<table width="990" border="0" align="center" >
<td><h2><img src="data/images/datfin.jpg" width="700" height="50" /></h2></td>
</table>
<table width="990" border="0" align="center" >
<td>
<table id="ftab" width="200" border="0" align="left">
<tr> 		
        <td>FUENTE DE FINANCIAMIENTO:</td>	

    </tr>
<tr> 		
        <td width="165">
        <input name="source_fin" type="text" id="source_fin" size="15" value="<? echo "$rsx[source_fin]" ?>" maxlength="64" readonly="readonly"/>
        </td>	
 
	</tr>
    </td>
</table>
</table>
<!--CATEGORIA-->
<table width="990" border="0" align="center" cellpadding="2" cellspacing="0">
<td><h2><img src="data/images/datcat.jpg" width="700" height="50" /></h2></td>
</table>
<table id="ftab" width="990" border="1" bordercolor="#669999" align="center">
<tr> 		
        <td width="100" ><div align="center"><strong>CATEGORÍA:</strong></div></td>	
		<td width="361"><div align="center"><strong>NIVEL DE PUESTO:</strong></div></td>	
		<td width="64" ><div align="center"><strong>PUESTO DE CARRERA:</strong></div></td>	
        <td width="220"><div align="center"><strong>MODALIDAD INGRESO (SOLO SI ES PUESTO DE CARRERA):</strong></div></td>
        <td width="211"><div align="center"><strong>FORMA DE RECLUTAMIENTO:</strong></div></td>
</tr>
<tr> 		
        <td rowspan="2">
       	  <input name="cat" type="radio" value="SUPERIOR" />
         	SUPERIOR
        </td>	
        <td>
        	<input name="level" type="radio" value="MINISTRO" checked="CHECKED" />
        MINISTRO
      </td>	
        <td rowspan="9">
       	  <input name="post_car" type="radio" value="SI" />
     	   SI
      </td>
        <td rowspan="3">
        <input name="mod_ent" type="radio" value="ANTIGUEDAD DE 5 A 7 AÑOS" />
        POR ANTIGUEDAD DE 5 A 7 AÑOS
      </td>	
        <td rowspan="4">
        <input name="form_rec" type="radio" value="CONVOCATORA PÚBLICA EXTERNA"/>
        CONVOCATORIA PUBLICA EXTERNA
        </td>	
</tr>
<tr> 		
        <td>
        	<input name="level" type="radio" value="VICEMINISTRO"/>
        	VICEMINISTRO</td>
    </tr>
<tr>
  <td><input name="cat" type="radio" value="EJECUTIVO"/>
EJECUTIVO</td> 		
	   <td>
       		<input name="level" type="radio" value="DIRECTOR GENERAL"/>
            DIRECTOR GENERAL</td>
    </tr>
<tr>
  <td rowspan="18">
  		<input name="cat" type="radio" value="OPERATIVO" checked="checked" />
		OPERATIVO	</td> 		
	   <td>
       		<input name="level" type="radio" value="JEFE UNIDAD - ASESOR"/>
       		JEFE UNIDAD - ASESOR</td>
	   <td rowspan="3"><input name="mod_ent" type="radio" value="SERVICIO CIVIL" />
      POR SERVICIO CIVIL </td>	
    </tr>
<tr>
  	<td height="27">
  		<input name="level" type="radio" value="JEFE UNIDAD II - JEFE DE GABINETE"/>
    	JEFE UNIDAD II - JEFE DE GABINETE
  </td>
  	<td rowspan="4"><input name="form_rec" type="radio" value="CONVOCATORIA PÚBLICA INTERNA"/>
CONVOCATORIA PUBLICA INTERNA</td>
</tr>
<tr>
  <td>
  		<input name="level" type="radio" value="JEFE UNIDAD III - ESPECIALISTA I"/>
    	JEFE UNIDAD III - ESPECIALISTA I</td>
  </tr>
<tr>
  <td height="24">
  		<input name="level" type="radio" value="JEFE UNIDAD III - ESPECIALISTA II"/>
  		JEFE UNIDAD III - ESPECIALISTA II</td>
  <td rowspan="3"><input name="mod_ent" type="radio" value="CONVALIDACIÓN DE PROCESOS SELECCIÓN"/>
    POR CONVALIDACION DE PROCESOS DE SELECCIÓN </td>
  </tr>
<tr>
  <td>
  		<input name="level" type="radio" value="PROFESIONAL IV"/>
    	PROFESIONAL IV</td>
  </tr>
<tr>
  <td>
    <input name="level" type="radio" value="PROFESIONAL V"/>
    PROFESIONAL V
    </td>
  <td rowspan="4"><input name="form_rec" type="radio" value="INVITACIÓN DIRECTA"/>
INVITACIÓN DIRECTA </td>
</tr>
<tr>
  <td>
    <input name="level" type="radio" value="PROFESIONAL VI"/>
    PROFESIONAL VI</td>
  <td rowspan="12"><input name="post_car" type="radio" value="NO" checked="checked"/>
    NO </td>
  <td rowspan="3"><input name="mod_ent" type="radio" value="CAMBIO DE REGIMEN LABORAL"/>
    CAMBIO DE REGIMEN LABORAL </td>
  </tr>
<tr>
  <td><input name="level" type="radio" value="PROFESIONAL VIII - TECNICO II"/>
    PROFESIONAL VIII - TECNICO II</td>
  </tr>
<tr>
  <td><input name="level" type="radio" value="PROFESIONAL IX - TECNICO  III SECRETARIA MINISTRO"/>
    PROFESIONAL IX - TECNICO  III SECRETARIA MINISTRO</td>
  </tr>
<tr>
  <td><input name="level" type="radio" value="TECNICO IV"/> 
    TECNICO IV
</td>
  <td rowspan="3"><input name="mod_ent" type="radio" value="RECONOCIMIENTO DE CARRERA"/>
RECONOCIMIENTO DE CARRERA </td>
  <td rowspan="4"><input name="form_rec" type="radio" value="NOMBRAMIENTO DIRECTO"/>
NOMBRAMIENTO DIRECTO </td>
</tr>
<tr>
  <td><input name="level" type="radio" value="TECNICO V SECRETARIA VICEMINISTRO"/>
    TECNICO V SECRETARIA VICEMINISTRO</td>
  </tr>
<tr>
  <td><input name="level" type="radio" value="TECNICO VI SECRETARIA DIREC. GRAL. CHOFER MINISTRO"/>
    TECNICO VI SECRETARIA DIREC. GRAL. CHOFER MINISTRO</td>
  </tr>
<tr>
  <td><input name="level" type="radio" value="ADM. I SECRETARIA UNIDAD - CHOFER MINISTRO"/>
    ADM. I SECRETARIA UNIDAD - CHOFER MINISTRO</td>
  <td rowspan="3"><input name="mod_ent" type="radio" value="CONVOCATORIA PÚBLICA EXTERNA"/>
    POR CONVOCATORIA PÚBLICA EXTERNA </td>
  </tr>
<tr>
  <td><input name="level" type="radio" value="ADMINISTRATIVO II"/>
    ADMINISTRATIVO II</td>
  <td><input name="form_rec" type="radio" id="radio" value="NINGUNO" checked="checked" />
    <label for="form_rec"></label>
    NINGUNO</td>
</tr>
<tr>
  <td><input name="level" type="radio" value="ADMINISTRATIVO III"/>
    ADMINISTRATIVO III</td>
  <td><strong>JORNADA DE TRABAJO:</strong></td>
</tr>
<tr>
  <td><input name="level" type="radio" value="ADMINISTRATIVO IV"/>
    ADMINISTRATIVO IV</td>
  <td rowspan="2"><input name="mod_ent" type="radio" value="CONVOCATORIA PÚBLICA INTERNA"/>
POR CONVOCATORIA PÚBLICA INTERNA </td>
  <td><select name="jornal" id="jornal" >
    <option value="TIEMPO COMPLETO">TIEMPO COMPLETO</option>
    <option value="MEDIO TIEMPO">MEDIO TIEMPO</option>
    <option value="HORAS">HORAS</option>
  </select></td>
</tr>
<tr>
  <td><input name="level" type="radio" value="AUXILIAR I"/>
    AUXILIAR I</td>
  <td><strong>SUELDO BASE:</strong></td>
</tr>
<tr>
  <td><input name="level" type="radio" value="AUXILIAR II"/>
    AUXILIAR II</td>
  <td><input name="mod_ent" type="radio" value="NINGUNA" checked="checked"/>
NINGUNA </td>
  <td><input name="sal_base" type="text" id="sal_base" size="20" maxlength="64" class="required"/>
  </td>
</tr>
  </table>
<!--FINANCIAMIENTO-->
<table width="990" border="0" align="center" >
<td><h2><img src="data/images/datev.jpg" width="700" height="50" /></h2></td>
</table>
<table id="ftab" width="990" border="0" align="center">
<tr> 		
        <td>FECHA DE EVALUACIÓN:</td>	
		<td width="121">RESULTADO DE LA EVALUACIÓN:</td>	
		<td>CONSECUENCIA DE LA EVALUACIÓN:</td>	
        <td>RESPONSABLE DE LA EVALUACIÓN:</td>
        <td>TIPO DE RESPONSABLE:</td>		
</tr>
<tr> 		
        <td width="165">
        	<input name="date_eval" type="text" id="date_eval" size="15" maxlength="64" class="datepick" readonly="readonly"/>
            
      </td>	
        <td>
        <select name="res_eval" id="res_eval" >
        <option value="-">-</option>
   		  <option value="BUENO">BUENO</option>
   		  <option value="MALO">MALO</option>
   		  <option value="EXCELENTE">EXCELENTE</option>
   		  <option value="MUY BUENO">MUY BUENO</option>
   		  <option value="REGULAR">REGULAR</option>
   		  <option value="SUFICIENTE">SUFICIENTE</option>
   		  <option value="RATIFICACION">RATIFICACION</option>
    	</select>
    </td>	
        <td width="222">
        <select name="cons_eval" id="cons_eval" >
                <option value="-">-</option>
      		<option value="CAPACITACIÓN">CAPACITACIÓN</option>
      		<option value="PROMOCIÓN">PROMOCIÓN</option>
      		<option value="CONFIRMACIÓN DE PUESTO">CONFIRMACIÓN DE PUESTO</option>
      		<option value="RETIRO">RETIRO</option>
      		<option value="TRANSFERENCIA">TRANSFERENCIA</option>
   		  <option value="ROTACIÓN">ROTACIÓN</option>
   		  <option value="OTROS">OTROS</option>
    	</select>
        </td>

      <td width="216">
        	<input name="resp_eval" type="text" id="resp_eval" size="25" maxlength="64"/>
      </td>	
      <td width="242">
        <select name="type_resp" id="type_resp" >
                <option value="-">-</option>
      		<option value="MÁXIMA AUTORIDAD">MÁXIMA AUTORIDAD</option>
      		<option value="INMEDIATO SUPERIOR">INMEDIATO SUPERIOR</option>
      		<option value="UNIDAD DE PERSONAL">UNIDAD DE PERSONAL</option>
      		<option value="OTRA INSTANCIA">OTRA INSTANCIA</option>
    	</select>
      </td>	        

  </tr>
    <td>
  <input type="submit" class="submit" onclick="return probar()" name="save" id="loginbutton" value="Guardar" />
     </td>
</table>



</form>

<?

//$db->close();
?>

</body>
</html>