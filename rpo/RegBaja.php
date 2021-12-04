<?
//REGISTRO BAJA PERMANENTE
//ALP
require_once("security.php");
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();

$id_func=$_GET[id_func];
$id_per=$_GET[id_per];

$rs=$db->query("
				SELECT * FROM ".TABLE2.",".TABLE22."
				WHERE funcionario.id_func = permanente.id_func
				AND funcionario.id_func='$id_func'
				AND permanente.id_per = '$id_per'
				");

if ($r=$db->fetch_array($rs))
{	
	if (isset($_POST[save]))
	{
		$rs2=$db->query("update ".TABLE22." set status='0' where id_func='$id_func'");
		if ($rs2)
		{
			$date_pres=cambia_dateN_to_dateMy_1($_POST[date_pres]);
			$date_efect=cambia_dateN_to_dateMy_1($_POST[date_efect]);
			echo $date_efect;
			$rs1=$db->query("insert into ".TABLE35."(id_per, date_pres, date_efect, reasone, comment) values ('$id_per','$date_pres','$date_efect','$_POST[reason]','$_POST[comment]')");
			$rs3=$db->query("
			select id_char_per from ".TABLE28." 
			where ".TABLE28.".id_per='$id_per'
			order by id_char_per desc limit 1
			");
			$r3=$db->fetch_array($rs3);
			$rs4=$db->query("update ".TABLE28." set date_end='$date_efect' where id_char_per='$r3[id_char_per]'");
			if ($rs1&&$rs3&&$rs4)
			{	
				$msg="Datos registrados Exitosamente!!!";
				$sw=1;
			}
			else
			{
				$msg="Hubo un Error al ejecutar la operación.";
				$sw=2;
			}			
		}				
	}	
}	
/*SELECT * FROM ".TABLE22." 
				WHERE	id_per='id_per' 
				AND 	id_fun='$id_func'*/

if ($sw==1)
{
	echo '<div class="successre">'.$msg.'</div>';
}
if ($sw==2)
{
	echo '<div class="errorre">'.$msg.'</div>';
}
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es-es" lang="es-es" dir="ltr" >
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="data/css/style-ext.css" rel="stylesheet" type="text/css">
<link href="css/reportes.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" type="text/css" media="screen" href="data/css/screen.css" />
<script src="data/js/jquery-1.7.1.min.js"></script>
<script src="data/js/jquery.metadata.js" type="text/javascript"></script>
<script src="data/js/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">
$.metadata.setType("attr", "validate");
$(document).ready(function() {
	$("#form1").validate();	
});
</script>

<link rel="stylesheet" href="data/css/ui/admincp/jquery-ui-1.8.17.custom.css">
<link rel="stylesheet" href="../../themes/base/jquery.ui.all.css">

	<script src="data/js/ui/jquery.ui.core.js"></script>
	<script src="data/js/ui/jquery.ui.widget.js"></script>
	<script src="data/js/ui/jquery.ui.datepicker.js"></script>
	<link rel="stylesheet" href="../demos.css">
	<script>
	$(function() {
		$( ".datepick" ).datepicker({
			showOn: "button",
			buttonImage: "data/images/calendar.gif",
			buttonImageOnly: true, changeMonth: true, changeYear: true, yearRange: '-100:+0',
		});		
	});
	</script>



<fieldset>
<legend>Baja funcionario permanente</legend>
<form id="form1" name="form1" method="post" action="" class="form" novalidate>
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr>
      <th><div align="left">Nombres:</div></th>
      <td><div class="form_row">  
        <input name="name" type="text" class="input required" id="name" value="<? echo $r[name]; ?>" size="45" />
    
      </div></td>
    </tr>
    <tr>
      <th><div align="left">Apellido Paterno:</div></th>
      <td><div class="form_row">
        <input name="lname_1" type="text" class="input required" id="lname_1" value="<? echo $r[l_name1]; ?>" size="40" />
      </div></td>
    </tr>
    <tr>
      <th><div align="left">Apellido Materno:</div></th>
      <td><div class="form_row">
        <input name="lname_2" type="text" class="input required" id="lname_2" value="<? echo $r[l_name2]; ?>" size="40" />
      </div></td>
    <tr>
      <th><div align="left">Fecha Presentaci&oacute;n:</div></th>
      <td><div align="left">
        <label>
        <input type="text" name="date_pres" class="datepick required"  />
        </label>
      </div></td>
    </tr>
    <tr>
      <th><div align="left">Fecha Efectivizaci&oacute;n:</div></th>
      <td><div align="left">
        <label>
        <input type="text" name="date_efect" id="date_efect" class="datepick required" />
        </label>
      </div></td>
    </tr>
    <tr>
      <th><div align="left">Motivo</div></th>
      <td><div align="left">
        <label>
        <select name="reason" id="reason">
          <option value="renuncia">Renuncia</option>
          <option value="agradecimiento">Agradecimiento Servicios</option>
          <option value="fincontrato">Fin Contrato</option>
          <option value="jubilacion">Jubilaci&oacute;n</option>
        </select>
        </label>
      </div></td>
    </tr>
    <tr>
      <th><div align="left">Comentario:</div></th>
      <td>
        <div align="left">
          <textarea name="comment" cols="30" rows="3" id="comment"></textarea>
        </div>
		</td>
    </tr>
    <tr>
      <td><div align="left"></div></td>
      <td>
        <div align="left"><label></label>
          <input type="submit" class"submit" name="save" id="loginbutton" value="Guardar" />
        </div>
      </td>
    </tr>
  </table>
</form>
</fieldset>