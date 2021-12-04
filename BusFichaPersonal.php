<?
require_once("security.php");
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

			$rs=$db->query("
			SELECT ".TABLE2.".id_func, name, l_name1, l_name2, afp,".TABLE22.".id_per, status, source_fin
			FROM ".TABLE2.",".TABLE22.",".TABLE15."
			WHERE ".TABLE2.".id_func = ".TABLE22.".id_func
			AND	".TABLE22.".id_per = ".TABLE15.".id_per
			AND ".TABLE2.".l_name1 LIKE '%$tosearch%'
			AND ".TABLE22.".status = '1'
			");	
		break;
		
		case 'apm';
			$rs=$db->query("
			SELECT ".TABLE2.".id_func, name, l_name1, l_name2, afp,".TABLE22.".id_per, status, source_fin
			FROM ".TABLE2.",".TABLE22.",".TABLE15."
			WHERE ".TABLE2.".id_func = ".TABLE22.".id_func
			AND	".TABLE22.".id_per = ".TABLE15.".id_per
			AND ".TABLE2.".l_name2 like '%$tosearch%'
			AND ".TABLE22.".status = '1'			
			");
		break;
		
		case 'nom';
			$rs=$db->query("
			SELECT ".TABLE2.".id_func, name, l_name1, l_name2, afp,".TABLE22.".id_per, status, source_fin
			FROM ".TABLE2.",".TABLE22.",".TABLE15."
			WHERE ".TABLE2.".id_func = ".TABLE22.".id_func
			AND	".TABLE22.".id_per = ".TABLE15.".id_per
			AND ".TABLE2.".name like '%$tosearch%'
			AND ".TABLE22.".status = '1'			
			");
		break;
			case 'fte';
			$rs=$db->query("
			SELECT ".TABLE2.".id_func, name, l_name1, l_name2, afp,".TABLE22.".id_per, status, source_fin
			FROM ".TABLE2.",".TABLE22.",".TABLE15."
			WHERE ".TABLE2.".id_func = ".TABLE22.".id_func
			AND	".TABLE22.".id_per = ".TABLE15.".id_per
			AND ".TABLE15.".source_fin like '%$tosearch'
			AND ".TABLE22.".status = '1'			
			");
		break;
		
		
		
		
	}
	switch ($_POST[by])
	{
		case 'app';
/*		CONSULTORES*/
			$rs1=$db->query("
			SELECT ".TABLE2.".id_func, name, l_name1, l_name2, afp,".TABLE30.".id_con, status, source_fin
			FROM ".TABLE2.",".TABLE30.",".TABLE17."
			WHERE ".TABLE2.".id_func = ".TABLE30.".id_func
			AND	".TABLE30.".id_con = ".TABLE17.".id_con
			AND ".TABLE2.".l_name1 LIKE '%$tosearch%'
			AND ".TABLE30.".status = '1'
			");	
		break;
		case 'apm';
			$rs1=$db->query("
			SELECT ".TABLE2.".id_func, name, l_name1, l_name2, afp,".TABLE30.".id_con, status, source_fin
			FROM ".TABLE2.",".TABLE30.",".TABLE17."
			WHERE ".TABLE2.".id_func = ".TABLE30.".id_func
			AND	".TABLE30.".id_con = ".TABLE17.".id_con
			AND ".TABLE2.".l_name2 like '%$tosearch%'
			AND ".TABLE30.".status = '1'			
			");
		break;
		
		case 'nom';
			$rs1=$db->query("
			SELECT ".TABLE2.".id_func, name, l_name1, l_name2, afp,".TABLE30.".id_con, status, source_fin
			FROM ".TABLE2.",".TABLE30.",".TABLE17."
			WHERE ".TABLE2.".id_func = ".TABLE30.".id_func
			AND	".TABLE30.".id_con = ".TABLE17.".id_con
			AND ".TABLE2.".name like '%$tosearch%'
			AND ".TABLE30.".status = '1'			
			");
		break;
			case 'fte';
			$rs1=$db->query("
			SELECT ".TABLE2.".id_func, name, l_name1, l_name2, afp, ".TABLE30.".id_con, status, source_fin
			FROM ".TABLE2.",".TABLE30.",".TABLE17."
			WHERE ".TABLE2.".id_func = ".TABLE30.".id_func
			AND	".TABLE30.".id_con = ".TABLE17.".id_con
			AND ".TABLE17.".source_fin like '%$tosearch'
			AND ".TABLE30.".status = '1'			
			");
		break;

	}	

	if (mysql_num_rows($rs)!=0)
	{
		$sw=1;
	}
	if (mysql_num_rows($rs1)!=0)
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
<legend>Busqueda Funcionario - Actualizar Datos de Usuario</legend>
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
        <option value="fte">Por Fuente</option>
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
	  <td>'.$r[source_fin].'</td>';
		echo '<td>
	<a href="#" onclick="MM_openBrWindow(\'reporteper.php?id_per='.$r[id_per].'&id_func='.$r[id_func].'\',\'regpermiso\',\'scrollbars=yes,width=1050,height=600\')" title="Revisa Ficha Personal">
	<img src="data/images/fichapers.png"></a>&nbsp;
	
	<a href="#" onclick="MM_openBrWindow(\'UpdateCompleto.php?id_per='.$r[id_per].'&id_func='.$r[id_func].'\',\'regpermiso\',\'scrollbars=yes,width=1050,height=600\')" title="Revisa Ficha Personal - TGN">
	<img src="data/images/fichapersmod.png"></a>
	</td>
  </tr>';
 }
 ///CONSULTORES
  while ($r1=$db->fetch_array($rs1))
 {
 	echo ' <tr>   
    <td>'.$r1[l_name1].'</td>
    <td>'.$r1[l_name2].'</td>
	 <td>'.$r1[name].'</td>
	  <td>'.$r1[source_fin].'</td>';

echo	'<td>
	<a href="#" onclick="MM_openBrWindow(\'reportecon.php?id_con='.$r1[id_con].'&id_func='.$r1[id_func].'\',\'regpermiso\',\'scrollbars=yes,width=1050,height=500\')" title="Revisa Ficha Personal">
	<img src="data/images/fichapers.png"></a>&nbsp;
	
	<a href="#" onclick="MM_openBrWindow(\'UpdateCompletoCon.php?id_con='.$r1[id_con].'&id_func='.$r1[id_func].'\',\'regpermiso\',\'scrollbars=yes,width=1050,height=450\')" title="Modificar Ficha Personal - CONSULTOR">
	<img src="data/images/fichapersmod.png"></a>
	</td>
  </tr>';
 }
///CONSULTORES
 
 
 
 echo'
 </div></div>
</table>
	</fieldset>';

}

$db->close();
?>
</body>

</html>
