<?
require("config.inc.php");
require("database.class.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
if (isset($_POST[search]))
{
	$tosearch=strtoupper($_POST[tosearch]);
	$to_search_source_fin= $_POST[source_fin];
	$to_search_year= $_POST[year];	
	switch ($_POST[by])
	{

		case 'app';
			$rs=$db->query("
			SELECT ".TABLE2.".id_func, name, l_name1, l_name2, afp,".TABLE22.".id_per, status, source_fin
			FROM ".TABLE2.",".TABLE22.",".TABLE15."
			WHERE ".TABLE2.".id_func = ".TABLE22.".id_func
			AND	".TABLE22.".id_per = ".TABLE15.".id_per
			AND ".TABLE2.".l_name1 LIKE '%$tosearch%'

			");
			/*AND ".TABLE22.".status = '1'	*/		
			$rs1=$db->query("
			SELECT ".TABLE2.".id_func, name, l_name1, l_name2, afp,".TABLE30.".id_con, status, source_fin
			FROM ".TABLE2.",".TABLE30.",".TABLE17."
			WHERE ".TABLE2.".id_func = ".TABLE30.".id_func
			AND	".TABLE30.".id_con = ".TABLE17.".id_con
			AND ".TABLE2.".l_name1 LIKE '%$tosearch%'

			");	
/*			AND ".TABLE30.".status = '1'*/
		break;
		
		
		case 'apm';
			$rs=$db->query("
			SELECT ".TABLE2.".id_func, name, l_name1, l_name2, afp,".TABLE22.".id_per, status, source_fin
			FROM ".TABLE2.",".TABLE22.",".TABLE15."
			WHERE ".TABLE2.".id_func = ".TABLE22.".id_func
			AND	".TABLE22.".id_per = ".TABLE15.".id_per
			AND ".TABLE2.".l_name2 like '%$tosearch%'
		
			");
			/*AND ".TABLE22.".status = '1'	*/
			$rs1=$db->query("
			SELECT ".TABLE2.".id_func, name, l_name1, l_name2, afp,".TABLE30.".id_con, status, source_fin
			FROM ".TABLE2.",".TABLE30.",".TABLE17."
			WHERE ".TABLE2.".id_func = ".TABLE30.".id_func
			AND	".TABLE30.".id_con = ".TABLE17.".id_con
			AND ".TABLE2.".l_name2 like '%$tosearch%'
					
			");
			/*AND ".TABLE30.".status = '1'	*/
		break;

		case 'nom';
			$rs=$db->query("
			SELECT ".TABLE2.".id_func, name, l_name1, l_name2, afp,".TABLE22.".id_per, status, source_fin
			FROM ".TABLE2.",".TABLE22.",".TABLE15."
			WHERE ".TABLE2.".id_func = ".TABLE22.".id_func
			AND	".TABLE22.".id_per = ".TABLE15.".id_per
			AND ".TABLE2.".name like '%$tosearch%'
		
			");
			/*AND ".TABLE22.".status = '1'*/	
			$rs1=$db->query("
			SELECT ".TABLE2.".id_func, name, l_name1, l_name2, afp,".TABLE30.".id_con, status, source_fin
			FROM ".TABLE2.",".TABLE30.",".TABLE17."
			WHERE ".TABLE2.".id_func = ".TABLE30.".id_func
			AND	".TABLE30.".id_con = ".TABLE17.".id_con
			AND ".TABLE2.".name like '%$tosearch%'
			
			");
			/*AND ".TABLE30.".status = '1'*/
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

<script type="text/javascript" src="js/scripts.js"></script>
</head>
<body>
<fieldset>
<legend>Busqueda Funcionario - Carga Documentos</legend>
<div class="table">	
<form id="form1" name="form1" method="post" action="" class="form">
<table width="100%" border="0" cellpadding="5" cellspacing="0">
 <tr>
  <th scope="col">Criterio de Búsqueda</th>
  <th scope="col"></th>
 </tr>
 <tr>
  <td>
  <input class="input" type="text" name="tosearch" id="tosearch" />
      <select name="by" id="by">
        <option value="app">Por Apellido Paterno</option>
        <option value="apm">Por Apellido Materno</option>
        <option value="nom">Por Nombre</option>
      </select>
  </td>
  <td><input type="submit" class="submit" name="search"  value="Buscar" />
  </td>
 </tr> 
</table>

</form>
</div>
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
	<th >Estado</th>
    <th>Acciones</th>
  </tr>';
 while ($r=$db->fetch_array($rs))
 {	if($r[status]==0) $st='PASIVO';
 	else $st='ACTIVO'; 
 	echo ' <tr>   
      <td>'.$r[l_name1].'</td>
      <td>'.$r[l_name2].'</td>
	  <td>'.$r[name].'</td>
	  <td><strong>'.$st.'</strong></td>
	  <td><strong>'.$r[source_fin].'</strong></td>

	<td>
	<a href="#" onclick="MM_openBrWindow(\'UploadFilesTo.php?id_per='.$r[id_per].'&id_func='.$r[id_func].'\',\'uploadfiles\',\'scrollbars=yes,width=600,height=420\')" title="Cargar Archivos a File Personal"><img src="data/images/upload_.png"></a>	
	</td>	
  </tr>';
 }
  while ($r1=$db->fetch_array($rs1))
 {	if($r1[status]==0) $st='PASIVO';
	else $st='ACTIVO'; 
 	echo ' <tr>   
    <td>'.$r1[l_name1].'</td>
    <td>'.$r1[l_name2].'</td>
	 <td>'.$r1[name].'</td>
	 <td><strong>'.$st.'</strong></td>
	  <td><strong>'.$r1[source_fin].'</strong></td>

	<td>
	<a href="#" onclick="MM_openBrWindow(\'UploadFilesTo-C.php?id_per='.$r1[id_con].'&id_func='.$r1[id_func].'\',\'uploadfiles\',\'scrollbars=yes,width=600,height=420\')" title="Cargar Archivos a File Personal"><img src="data/images/upload_.png"></a>	
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
