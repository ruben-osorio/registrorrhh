<?
require("security.php");
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
$id_func=$_GET[id_func];
$id_per=$_GET[id_per];
//echo mysql_num_rows($rs);
if (isset($_POST[submit]))
{
	$cat=$_POST[cat];
	$level=$_POST[level];
	$post_car=$_POST[post_car];
	$mod_ent=$_POST[mod_ent];
	$form_rec=$_POST[form_rec];
	$jornal=$_POST[jornal];
	$sal_base=$_POST[sal_base];
	$rs1=$db->query("UPDATE ".TABLE16." SET cat='$cat',level='$level',post_car='$post_car',mod_ent='$mod_ent',form_rec='$form_rec',jornal='$jornal',sal_base='$sal_base' WHERE id_per='$id_per' ");
}

if (isset($_POST[submit2]))
{
	$date_eval=strtoupper($_POST[date_eval]);
	$res_eval=strtoupper($_POST[res_eval]);
	$cons_eval=strtoupper($_POST[cons_eval]);
	$resp_eval=strtoupper($_POST[resp_eval]);
	$type_resp=strtoupper($_POST[type_resp]);
			
	$rs3=$db->query("UPDATE ".TABLE29." SET date_eval='$date_eval', res_eval='$res_eval', cons_eval='$cons_eval', resp_eval='$resp_eval', type_resp='$type_resp' WHERE id_per='$id_per' ");
	
}

$rs=$db->query("select * from ".TABLE16." where id_per='$id_per'");
$r=$db->fetch_array($rs);

$rs2=$db->query("SELECT * FROM ".TABLE29." where id_per='$id_per'");
$r2=$db->fetch_array($rs2);

?>
<link href="data/css/reportes.css" rel="stylesheet" type="text/css" />
<link href="data/css/style-ext.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<fieldset>
<legend><strong>CATEGORIA</strong></legend>
<form id="form1" name="form1" method="post" action="">
<table id="ftab" width="471" border="0" bordercolor="#669999" align="center">
<tr>
  <th width="100" ><strong>CATEGORÍA:</strong></th>
  <td width="361"><select name="cat" id="cat">
    <?
	  //			mod_ent	form_rec	jornal	sal_base
	  echo '<option value="'.$r[cat].'" selected="selected">'.$r[cat].'</option>';
      ?>
    <option value="SUPERIOR">SUPERIOR</option>
    <option value="EJECUTIVO">EJECUTIVO</option>
    <option value="OPERATIVO">OPERATIVO</option>
  </select></td>
  </tr>
<tr>
  <th ><strong>NIVEL DE PUESTO:</strong></th>
  <td><select name="level" id="level">
    <?
	  //	level	post_car	mod_ent	form_rec	jornal	sal_base
	  echo '<option value="'.$r[level].'" selected="selected">'.$r[level].'</option>';
      ?>
    <option value="MINISTRO">MINISTRO</option>
    <option value="VICEMINISTRO">VICEMINISTRO</option>
    <option value="DIRECTOR GENERAL">DIRECTOR GENERAL</option>
    <option value="JEFE UNIDAD - ASESOR">JEFE UNIDAD - ASESOR</option>
    <option value="JEFE UNIDAD II - JEFE DE GABINETE">JEFE UNIDAD II - JEFE DE GABINETE</option>
    <option value="JEFE UNIDAD III - ESPECIALISTA I">JEFE UNIDAD III - ESPECIALISTA I</option>
    <option value="JEFE UNIDAD III - ESPECIALISTA II">JEFE UNIDAD III - ESPECIALISTA II</option>
    <option value="PROFESIONAL IV">PROFESIONAL IV</option>
    <option value="PROFESIONAL V ">PROFESIONAL V</option>
    <option value="PROFESIONAL VI">PROFESIONAL VI</option>
    <option value="PROFESIONAL VIII - TECNICO II">PROFESIONAL VIII - TECNICO II</option>
    <option value="PROFESIONAL IX - TECNICO III SECRETARIA MINISTRO">PROFESIONAL IX - TECNICO III SECRETARIA MINISTRO</option>
    <option value="TECNICO IV">TECNICO IV</option>
    <option value="TECNICO V SECRETARIA VICEMINISTRO">TECNICO V SECRETARIA VICEMINISTRO</option>
    <option value="TECNICO VI SECRETARIA DIREC. GRAL. CHOFER MINISTRO">TECNICO VI SECRETARIA DIREC. GRAL. CHOFER MINISTRO</option>
    <option value="ADM. I SECRETARIA UNIDAD - CHOFER MINISTRO">ADM. I SECRETARIA UNIDAD - CHOFER MINISTRO</option>
    <option value="ADMINISTRATIVO II">ADMINISTRATIVO II</option>
    <option value="ADMINISTRATIVO III">ADMINISTRATIVO III</option>
    <option value="ADMINISTRATIVO IV">ADMINISTRATIVO IV</option>
    <option value="AUXILIAR I">AUXILIAR I</option>
    <option value="AUXILIAR II">AUXILIAR II</option>
  </select></td>
  </tr>
<tr>
  <th ><strong>PUESTO DE CARRERA:</strong></th>
  <td><select name="post_car" id="post_car">
    <?
	  //	level	post_car	mod_ent	form_rec	jornal	sal_base
	  echo '<option value="'.$r[post_car].'" selected="selected">'.$r[post_car].'</option>';
      ?>
    <option value="SI">SI</option>
    <option value="NO">NO</option>
  </select></td>
  </tr>
<tr>
  <th ><strong>MODALIDAD INGRESO (SOLO SI ES PUESTO DE CARRERA):</strong></th>
  <td><select name="mod_ent" id="mod_ent">
    <?
	  	echo '<option value="'.$r[mod_ent].'" selected="selected">'.$r[mod_ent].'</option>';
      	?>
    <option value="POR ANTIGUEDAD DE 5 A 7 AÑOS">POR ANTIGUEDAD DE 5 A 7 AÑOS</option>
    <option value="POR SERVICIO CIVIL">POR SERVICIO CIVIL</option>
    <option value="POR CONVALIDACION DE PROCESOS DE SELECCIÓN">POR CONVALIDACION DE PROCESOS DE SELECCIÓN</option>
    <option value="CAMBIO DE REGIMEN LABORAL">CAMBIO DE REGIMEN LABORAL</option>
    <option value="RECONOCIMIENTO DE CARRERA">RECONOCIMIENTO DE CARRERA</option>
    <option value="POR CONVOCATORIA PÚBLICA EXTERNA">POR CONVOCATORIA PÚBLICA EXTERNA</option>
    <option value="POR CONVOCATORIA PÚBLICA INTERNA">POR CONVOCATORIA PÚBLICA INTERNA</option>
    <option value="NINGUNA">NINGUNA</option>
  </select></td>
  </tr>
<tr>
  <th ><strong>FORMA DE RECLUTAMIENTO:</strong></th>
  <td><select name="form_rec" id="form_rec">
    <?
	  //	level	post_car	mod_ent		jornal	
	  echo '<option value="'.$r[form_rec].'" selected="selected">'.$r[form_rec].'</option>';
      	?>
    <option value="CONVOCATORIA PUBLICA EXTERNA ">CONVOCATORIA PUBLICA EXTERNA </option>
    <option value="CONVOCATORIA PUBLICA INTERNA">CONVOCATORIA PUBLICA INTERNA</option>
    <option value="INVITACION DIRECTA">INVITACION DIRECTA</option>
    <option value="NOMBRAMIENTO DIRECTO">NOMBRAMIENTO DIRECTO</option>
    <option value="NINGUNO">NINGUNO</option>
  </select></td>
  </tr>
<tr>
  <th ><strong>JORNADA DE TRABAJO:</strong></th>
  <td><select name="jornal" id="jornal" >
    <?
	  echo '<option value="'.$r[jornal].'" selected="selected">'.$r[jornal].'</option>';
      	?>
    <option value="TIEMPO COMPLETO">TIEMPO COMPLETO</option>
    <option value="MEDIO TIEMPO">MEDIO TIEMPO</option>
    <option value="HORAS">HORAS</option>
  </select></td>
  </tr>
<tr>
  <th ><strong>SUELDO BASE:</strong></th>
  <td><input name="sal_base" type="text" id="sal_base" size="20" maxlength="64" value="<? echo $r[sal_base]; ?>" /></td>
  </tr>
<tr>
  
  <td colspan="1"><input type="submit" name="submit" id="loginbutton" value="Guardar" /></td>
  </tr>
</table>
</form>
</fieldset><br />

<form id="form2" name="form2" method="post" action="">
<fieldset>
<legend><strong>EVALUACION</strong></legend>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th scope="row">FECHA DE EVALUACIÓN:</th>
    <?
	//				
    ?>
    <td><input name="date_eval" type="text" id="date_eval" size="15" maxlength="64" value="<? echo $r2[date_eval];?>"/></td>
  </tr>
  <tr>
    <th scope="row">RESULTADO DE LA EVALUACIÓN:</th>
    <td><select name="res_eval" id="res_eval" >
      <? echo '<option value="'.$r2[res_eval].'" selected="selected">'.$r2[res_eval].'</option>'; ?>
      <option value="BUENO">BUENO</option>
      <option value="MALO">MALO</option>
      <option value="EXCELENTE">EXCELENTE</option>
      <option value="MUY BUENO">MUY BUENO</option>
      <option value="REGULAR">REGULAR</option>
      <option value="SUFICIENTE">SUFICIENTE</option>
      <option value="RATIFICACION">RATIFICACION</option>
    </select></td>
  </tr>
  <tr>
    <th scope="row">CONSECUENCIA DE LA EVALUACIÓN:</th>
    <td><select name="cons_eval" id="cons_eval" >
     <? echo '<option value="'.$r2[cons_eval].'" selected="selected">'.$r2[cons_eval].'</option>'; ?>
      <option value="CAPACITACIÓN">CAPACITACIÓN</option>
      <option value="PROMOCIÓN">PROMOCIÓN</option>
      <option value="CONFIRMACIÓN DE PUESTO">CONFIRMACIÓN DE PUESTO</option>
      <option value="RETIRO">RETIRO</option>
      <option value="TRANSFERENCIA">TRANSFERENCIA</option>
      <option value="ROTACIÓN">ROTACIÓN</option>
      <option value="OTROS">OTROS</option>
    </select></td>
  </tr>
  <tr>
    <th scope="row">RESPONSABLE DE LA EVALUACIÓN:</th>
    <td><input name="resp_eval" type="text" id="resp_eval" size="25" maxlength="64" value="<? echo $r2[resp_eval]; ?>"/></td>
  </tr>
  <tr>
    <th scope="row">TIPO DE RESPONSABLE:</th>
    <td><select name="type_resp" id="type_resp" >
       <? echo '<option value="'.$r2[type_resp].'" selected="selected">'.$r2[type_resp].'</option>'; ?>
      <option value="MÁXIMA AUTORIDAD">MÁXIMA AUTORIDAD</option>
      <option value="INMEDIATO SUPERIOR">INMEDIATO SUPERIOR</option>
      <option value="UNIDAD DE PERSONAL">UNIDAD DE PERSONAL</option>
      <option value="OTRA INSTANCIA">OTRA INSTANCIA</option>
    </select></td>
  </tr>
  <tr>
    
    <td colspan="1"><input type="submit" name="submit2" id="loginbutton" value="Guardar" /></td>
  </tr>
</table>
</fieldset>
</form>