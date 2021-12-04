<?
require("config.inc.php");
require("database.class.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
if (isset($_POST[search]))
{
	$tosearch=strtoupper($_POST[tosearch]);
	switch ($_POST[by])
	{
		case 'app';
			$rs=$db->query("select * from ".TABLE2." where l_name1 like '%$tosearch%'");	
		break;
		
		case 'apm';
			$rs=$db->query("select * from ".TABLE2." where l_name2 like '%$tosearch%'");
		break;

		case 'nom';
			$rs=$db->query("select * from ".TABLE2." where name like '%$tosearch%'");
		break;
	}
	
	if (mysql_num_rows($rs)!=0)
	{
		$sw=1;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<script type="text/javascript" src="js/scripts.js"></script>
</head>
<body>
<fieldset>
<legend>Busqueda Funcionario</legend>
<form id="form1" name="form1" method="post" action="" class="form">
<table width="100%" border="0" cellpadding="5" cellspacing="0">
  <tr>
    <td width="94%"><div align="right">
      Criterio de Búsqueda:
      <input class="input" type="text" name="tosearch" id="tosearch" />
      <select name="by" id="by">
        <option value="app">Por Apellido Paterno</option>
        <option value="apm">Por Apellido Materno</option>
        <option value="nom">Por Nombre</option>
      </select>
     
    </div></td>
    <td width="6%"><div align="left">
      <label>
      <input type="submit" class="submit" name="search"  value="Buscar" />
      </label>
    </div></td>
  </tr>
</table>

</form>
</fieldset>
<?
if ($sw==1)
{
	echo '<fieldset>
	<legend>Resultado de la Búsqueda</legend>
	<div class="table-wrap"><div class="table">	
	<table width="100%" border="0" cellpadding="5" cellspacing="0">
  <tr class="even">    
    <th>Apellido Paterno</th>	
    <th>Apellido Materno</th>
	<th >Nombre(s)</th>
	<th >Fuente</th>
    <th>Acciones</th>
  </tr>';
 while ($r=$db->fetch_array($rs))
 {
 	echo ' <tr>   
    <td>'.$r[l_name1].'</td>
    <td>'.$r[l_name2].'</td>
	 <td>'.$r[name].'</td>
	  <td>'.$r[source_fin].'</td>

	<td>
	<a href="#" onclick="MM_openBrWindow(\'RegPrestamoFile.php?id='.$r[id].'\',\'regpermiso\',\'scrollbars=yes,width=570,height=420\')" title="Salida File Personal"><img src="data/images/salida_fol.png"></a>
	<a href="#" onclick="MM_openBrWindow(\'RegFromVac.php?id='.$r[id].'\',\'regpermiso\',\'scrollbars=yes,width=550,height=400\')" title="Devolución File Personal"><img src="data/images/retorno_fol.png"></a>
	</td>
  </tr>';
 }
 echo'
 </div></div>
</table>
	</fieldset>';

}

$db->close();
?>
</body>

</html>
