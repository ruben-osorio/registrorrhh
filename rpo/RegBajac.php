<?
//BAJA PERSONAL CONTRATO
//ALP
require_once("security.php");
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();

$id_func=$_GET[id_func];
$id_con=$_GET[id_con];

$rs=$db->query("
				SELECT * FROM ".TABLE2.",".TABLE30."
				WHERE ".TABLE2.".id_func = ".TABLE30.".id_func
				AND ".TABLE2.".id_func='$id_func'
				AND ".TABLE30.".id_con = '$id_con'
				");

if ($r=$db->fetch_array($rs))
{	
	if (isset($_POST[save]))
	{
		$rs2=$db->query("update ".TABLE30." set status='0' where id_func='$id_func'");
		if ($rs2)
		{
			$date_pres=cambia_dateN_to_dateMy_1($_POST[date_pres]);
			$date_efec=cambia_dateN_to_dateMy_1($_POST[date_efec]);
			echo $date_efec;
			$rs1=$db->query("insert into ".TABLE36."(id_con, date_pres, date_efec, reasone, comment) values ('$id_con','$date_pres','$date_efec','$_POST[reason]','$_POST[comment]')");
			$rs3=$db->query("
			select id_char_con from ".TABLE31." 
			where ".TABLE31.".id_con='$id_con'
			order by id_char_con desc limit 1
			");
			$r3=$db->fetch_array($rs3);
			$rs4=$db->query("update ".TABLE31." set date_end='$date_efec' where id_char_con='$r3[id_char_con]'");

			if ($rs1)
			{
				$msg="Exito, Operación ejecutada correctamente.";
				$sw=1;	
			}
			else
			{
				$msg="Error al ejecutar la operación, intente nuevamente.";
				$sw=2;
			}			
		}				
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
			buttonImageOnly: true, changeMonth: true, changeYear: true, yearRange: '-100:+0',
		});		
	});
	</script>

<?
if ($sw==1)
{
	echo '<div class="successre">'.$msg.'</div>';
	exit;
}
if ($sw==2)
{
	echo '<div class="errorre">'.$msg.'</div>';
	exit;
}
?>

<fieldset>
<legend>Baja Consultor</legend>
<form id="form1" name="form1" method="post" action="" class="form" novalidate>
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr>
      <th><div align="left">Nombres:</div></th>
      <td><div class="form_row">  
        <input name="name" type="text" class="input " id="name" value="<? echo $r[name]; ?>" size="45" />
    
      </div></td>
    </tr>
    <tr>
      <th><div align="left">Apellido Paterno:</div></th>
      <td><div class="form_row">
        <input name="lname_1" type="text" class="input " id="lname_1" value="<? echo $r[l_name1]; ?>" size="40" />
      </div></td>
    </tr>
    <tr>
      <th><div align="left">Apellido Materno:</div></th>
      <td><div class="form_row">
        <input name="lname_2" type="text" class="input " id="lname_2" value="<? echo $r[l_name2]; ?>" size="40" />
      </div></td>
    <tr>
      <th><div align="left">Fecha Presentaci&oacute;n:</div></th>
      <td><div align="left">
        <label>
        <input type="text" name="date_pres" class="datepick" />
        </label>
      </div></td>
    </tr>
    <tr>
      <th><div align="left">Fecha Efectivizaci&oacute;n:</div></th>
      <td><div align="left">
        <label>
        <input type="text" name="date_efec" id="date_efec" class="datepick" />
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
      <td><label>
        <div align="left">
          <input type="text" name="comment" id="comment" />
        </div>
      </label></td>
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