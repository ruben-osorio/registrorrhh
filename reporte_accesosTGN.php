<?
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
$rs=$db->query("select * from ".TABLE4.",".TABLE2.",".TABLE22.",".TABLE15." where 
".TABLE4.".id_func=".TABLE2.".id_func and  
".TABLE2.".id_func=".TABLE22.".id_func and
".TABLE22.".id_per=".TABLE15.".id_per and
".TABLE22.".status=1 
order by ".TABLE2.".l_name1,".TABLE2.".l_name2,".TABLE2.".name asc  ");

echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body style="font-family:tahoma; font-size: 11px;">
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <th scope="col">';

//username	password	nombre	ap_1	ap_2	fecha_nac	permisos	id_func

while ($r=$db->fetch_array($rs))
{	
	echo '<table width="100%" border="0" cellspacing="2" cellpadding="5" style="border: 1px dashed #000;">
      <tr>
        <th colspan="2" scope="col"><div align="left"><img src="data/images/logo_mini.jpg" width="180" height="55" /></div></th>
      </tr>
	<tr>
        <td colspan="2"><div align="left"><strong>Dirección General de Asuntos Administrativos<br />
        Unidad de Recursos Humanos y Desarrollo Organizacional<br />
        </strong></div></td>
      </tr>
      <tr>
        <td><div align="right">Apellidos: </div></td>
        <td style="border: 1px solid #000;"><div align="left">'.$r[ap_1].' '.$r[ap_2].'</div></td>
      </tr>
      <tr>
        <td><div align="right">Nombres:</div></td>
        <td style="border: 1px solid #000;"><div align="left">'.$r[nombre].'</div></td>
      </tr>
      <tr>
        <td><div align="right">Fuente Financiamiento:</div></td>
        <td style="border: 1px solid #000;"><div align="left">'.$r[source_fin].'</div></td>
      </tr>
      <tr>
        <td width="29%"><div align="right">Nombre de Usuario:</div></td>
        <td width="71%" style="border: 1px solid #000;"><div align="left"><strong>'.$r[username].'</strong></div></td>
      </tr>
      <tr>
        <td><div align="right">Contraseña:</div></td>
        <td style="border: 1px solid #000;"><div align="left"><strong>'.$r[password].'</strong></div></td>
      </tr>
      <tr>
        <td colspan="2" style="font-size:9px;"><div align="left"><strong>Nota.-</strong> Los datos proporcionados en esta hoja deben ser conservados de manera segura y privada, por favor mantengala en lugar reservado o desechela una vez memorizada la información de acceso.</div></td>
      </tr>
      <tr>
        <td colspan="2"><div align="center">
          <p><strong>La Paz Bolivia<br />
          </strong><strong>          2012</strong></p>
        </div></td>
      </tr>
    </table><br>
<br>
';	
}
echo '</th>
  </tr>
</table>';	
?>
</body>
</html>