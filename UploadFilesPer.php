<?
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();

if ( isset($_GET[id_per]) && isset($_GET[id_func]) )
{
	$id_per=$_GET[id_per];
	$id_func=$_GET[id_func];
	$rs0=$db->query("select * from ".TABLE2." where id_func='$id_func'");
	$r0=$db->fetch_array($rs0);
	$sw=0;
	if (isset($_POST[select_dest]))
	{
		$date_born=str_replace("-","",cambia_dateMy_to_dateN($r0[date_born]));
		$ci=$r0[ci];
		$filename=ucfirst(strtolower(str_replace(' ','',$r0[name]))).ucfirst(strtolower($r0[l_name1])).ucfirst(strtolower($r0[l_name2]))."_".$date_born."_".$ci;	
		$filename;
		$rs5=$db->query("select date_ent from ".TABLE22." where id_per='$id_per'");
		$r5=$db->fetch_array($rs5);
		$year_cont=explode("-",$r5[date_ent]);
		
		$rs4=$db->query("select * from ".TABLE15." where id_per='$id_per'");
		$r4=$db->fetch_array($rs4);
		
		$location=$year_cont[0]."-".$r4[source_fin]."-".$id_per;
		$final_location="files"."/".$filename."/".$location."/".$_POST[upload_to_folder]."";		
		if (file_exists($final_location))
		{
			$sw=1;
		}
	}		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="js/scripts.js"></script>
<link href="data/css/reportes.css" rel="stylesheet" type="text/css" />
<?
	if ($sw==1)
	{
		echo '<link rel="stylesheet" href="uploadify/uploadify.css" type="text/css" />
		<script type="text/javascript" src="data/js/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="data/js/jquery.uploadify.js"></script>

		<script type="text/javascript">';
echo "$(document).ready(function() {
	$(\"#fileUpload2\").fileUpload({
		'uploader': 'uploadify/uploader.swf',
		'cancelImg': 'uploadify/cancel.png',
		'script': 'uploadify/upload_name.php',
		'folder': '".$final_location."',
		'multi': true,
		'buttonText': 'Select Files',
		'checkScript': 'uploadify/check.php',
		'fileExt': '*.jpg;*.jpeg;*.gif;*.png',
		'displayData': 'speed',
		'simUploadLimit': 2
	});	
});
</script>";
	}

?>
</head>
<body>
<?
	
	
	echo '
	<form action="" method="post" name="form1" id="form1">

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
  <th scope="col">Nombre(s) y Apellido:</th>
  <th scope="col"><strong>'.$r0[name].' '.$r0[l_name1].' '.$r0[l_name2].'</strong></th>
 </tr>
 <tr>';
 $rs1=$db->query("select * from ".TABLE22." where id_per='$id_per'");
 $r1=$db->fetch_array($rs1);
 echo '<th>Fecha Ingreso</td>
  <td>'.cambia_dateMy_to_dateN($r1[date_ent]).'</td>
 </tr>
 <tr>';
 $rs2=$db->query("select * from ".TABLE28." where id_per='$id_per'");
 $r2=$db->fetch_array($rs2);
 
 echo '
  <th>Cargo:</td>
  <td>'.$r2[charge].'</td>
 </tr>
 <tr>';
 $rs3=$db->query("select * from ".TABLE15." where id_per='$id_per'");
 $r3=$db->fetch_array($rs3);
 echo '<th>Fuente de Financiamiento:</td>
  <td>'.$r3[source_fin].'</td>
 </tr>
 <tr>
  <th>Cargar en:</td>
  <td>
 <select name="upload_to_folder" id="upload_to_folder">
   <option value="CURRICULUM_VITAE">CURRICULUM_VITAE</option>
   <option value="DATOS_PERSONALES">DATOS_PERSONALES</option>
   <option value="DESIGNACION_MOVILIDAD">DESIGNACION_MOVILIDAD</option>
   <option value="ANTECEDENTES">ANTECEDENTES</option>
   <option value="LLAMADAS_DE_ATENCION">LLAMADAS_DE_ATENCION</option>
   <option value="JEFE_INMEDIATO">JEFE_INMEDIATO</option>
   <option value="EVALUACION">EVALUACION</option>
   <option value="NECESIDAD_CAPACITACION">NECESIDAD_CAPACITACION</option>
   <option value="LICENCIAS">LICENCIAS</option>
   <option value="VACACIONES">VACACIONES</option>
   <option value="BAJAS_MEDICAS">BAJAS_MEDICAS</option>
   <option value="COMISION_CAPACITACION">COMISION_CAPACITACION</option>
   <option value="COMISION_TRABAJO">COMISION_TRABAJO</option>
   <option value="SERVICIO_CIVIL">SERVICIO_CIVIL</option>
   <option value="OTROS">OTROS</option>
   <option value="INFORMES">INFORMES</option>
 </select>
  </td>
 </tr>
 <tr>
  <td colspan="2"><input name="select_dest" id="select_dest" type="submit" value="Comenzar Carga" /></td>
 </tr>
</table>
</form>';
if ($sw==1)
{
	echo '<fieldset style="border: 1px solid #CDCDCD; padding: 8px; padding-bottom:0px; margin: 8px 0">

		<legend><strong>Cargar Archivos en: '.$_POST[upload_to_folder].'</strong></legend>
<hr width=100% size="1" color="" align="center">				
		<div id="fileUpload2">You have a problem with your javascript</div>
		<a href="javascript:$(\'#fileUpload2\').fileUploadStart()">Comenzar Carga</a> |  <a href="javascript:$(\'#fileUpload2\').fileUploadClearQueue()">Limpiar Lista de Carga</a>
    	<p></p>

    </fieldset>';
}
else
{
	echo '<div class="errorre">Error al Seleccionar la Carpeta</div>';
}
?>
</body>
</html>
<?
}
?>