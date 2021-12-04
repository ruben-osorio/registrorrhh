<?
require("config.inc.php");
require("database.class.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();

?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es-es" lang="es-es" dir="ltr" >
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="data/css/style-ext.css" rel="stylesheet" type="text/css">
<fieldset>
<legend>Registro Permiso a Cuenta de Vacación</legend>

<form id="form1" name="form1" method="post" action="" class="form" novalidate="novalidate">
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr>
      <td><div align="left">Nombres y Apellidos:</div></td>
      <td><div class="form_row">  
        <input name="name" type="text" class="input " id="name" value="<? echo $r[name]; ?>" size="45" />
    
      </div></td>
    </tr>
    <tr>
      <td><div align="left">Unidad Organizacional de dependencia:</div></td>
      <td><div class="form_row">
        <input name="lname_1" type="text" class="input " id="lname_1" value="<? echo $r[l_name1]; ?>" size="40" />
      </div></td>
    </tr>
    <tr>
      <td><div align="left">Gestión:</div></td>
      <td><div class="form_row">
        <input name="lname_2" type="text" class="input " id="lname_2" value="<? echo $r[l_name2]; ?>" size="40" />
      </div></td>
    </tr>
     <tr>
      <td><div align="left">Dias de Vacación:</div></td>
      <td><div class="form_row">
        <input name="office" type="text" class="input " id="office" value="<? echo $r[office]; ?>" size="60" />
      </div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="right">
        <label>
        <input type="submit" class="submit" name="save" id="save" value="Guardar" />
        </label>
      </div></td>
    </tr>
  </table>
</form>
</fieldset>