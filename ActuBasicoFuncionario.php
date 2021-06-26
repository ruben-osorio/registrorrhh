<?
require_once("security.php");

require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
$id_func=$_GET[id_func];
if (isset($_POST[save]))
{	$username=$_POST[username];
	$password=$_POST[password];
	//name	l_name1	l_name2	date_entrance	office	source_fin	f_status
	$rs=$db->query("update ".TABLE4." set username='$username',	password='$password' where id_func='$id_func'");
	if ($rs)
	{	echo "<script>
		window.opener.location.reload();
		window.close();
		 </script>";
	}
}

$rs=$db->query("select * from ".TABLE4." where id_func='$id_func'");
$r=$db->fetch_array($rs);

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
		$( "#date_entrance" ).datepicker({
			showOn: "button",
			buttonImage: "data/images/calendar.gif",
			buttonImageOnly: true
		});		
	});
	</script>



<fieldset>
<legend>Modificación Contraseña de Usuario</legend><form id="form1" name="form1" method="post" action="" class="form" novalidate="novalidate">
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr>
      <th><div align="left">Nombre de Usuario:</div></th>
      <td><div class="form_row">  
        <input name="username" type="text" class="input " id="username" value="<? echo $r[username]; ?>" size="45" />
    	  </div></td>
    </tr>
    <tr>
      <th><div align="left">Contraseña:</div></th>
      <td><div class="form_row">
        <input name="passold" type="text" class="input " id="passold" value="<? echo $r[password]; ?>" size="40" />
      </div></td>
    </tr>
        <tr>
      <th><div align="left">Nueva Contraseña:</div></th>
      <td><div class="form_row">
        <input name="password" type="text" class="input " id="password" size="40" />
      </div></td>
    </tr>

      <td colspan="2"><div align="right">
        <label>
        <input type="submit" class="submit" name="save" id="save" value="Guardar" />
        </label>
      </div></td>
    </tr>
  </table>
</form>
</fieldset>