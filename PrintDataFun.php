<?
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();

$id_func=$_GET[id_func];

if ( isset($_GET[id_func])&& isset($_GET[type]) )
{
	switch ($_GET[type])
	{
		case '2';		
		
			$rs=$db->query('select * from '.TABLE4.','.TABLE2.','.TABLE22.','.TABLE15.' where
			'.TABLE4.'.id_func= '.$id_func.' and   
			'.TABLE4.'.id_func= '.TABLE2.'.id_func and  
			'.TABLE2.'.id_func='.TABLE22.'.id_func and
			'.TABLE22.'.id_per='.TABLE15.'.id_per and
			'.TABLE22.'.status=1 			
			order by '.TABLE2.'.l_name1,'.TABLE2.'.l_name2,'.TABLE2.'.name desc limit 1  ');
			
		break;
		
		case '3';		
			$rs=$db->query('select * from '.TABLE4.','.TABLE2.','.TABLE30.','.TABLE17.' where		 
			'.TABLE4.'.id_func= '.$id_func.' and   
			'.TABLE4.'.id_func='.TABLE2.'.id_func and  			 
			'.TABLE2.'.id_func='.TABLE30.'.id_func and
			'.TABLE30.'.id_con='.TABLE17.'.id_con and
			'.TABLE30.'.status=1 
			order by '.TABLE2.'.l_name1,'.TABLE2.'.l_name2,'.TABLE2.'.name desc limit 1  ');
		break;
	}	
	$r=$db->fetch_array($rs);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Imprimir Datos de Acceso a Funcionario</title>
</head>
<script type="text/javascript">
    var button = document.getElementById('show_button')
    button.addEventListener('click',hideshow,false);

    function hideshow() {
        document.getElementById('hidden-div').style.display = 'block'; 
        this.style.display = 'none'
    }   
</script>

<body style="font-family:tahoma; font-size: 11px;">
<?
	if (!empty($r))
	{
		echo '<table width="100%" border="0" cellspacing="2" cellpadding="5" style="border: 1px dashed #000;">
      <tr>
        <th colspan="2" scope="col"><div align="left"><img src="data/images/logo_mini.jpg" width="180" height="55" /></div></th>
      </tr>
	<tr>
        <td colspan="2"><div align="left">
          <p><strong>Dirección General de Asuntos Administrativos<br />
          Unidad de Recursos Humanos</strong></p>
<strong>Página de Registro : http://192.168.20.5/registro<br>
        <br />
        </strong>        </div></td>
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
          <p><strong>Ministerio de Desarrollo Productivo<br />
          </strong><strong>          La Paz - Bolivia 2018</strong></p>
        </div></td>
      </tr>
    </table>
	 <div align="center"> <input id="show_button" type="button" name="imprimir" value="Imprimir" onclick="window.print();"></div>
	 ';
	}
?>

</body>
</html>