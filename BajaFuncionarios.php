<?
//BAJA CONSULTOR + LINK MOVILIDAD
//ALP
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
/*		SELECT funcionario.id_func, name, l_name1, l_name2, permanente.id_per, source_fin
		FROM funcionario, permanente, fin_per
		WHERE funcionario.id_func = permanente.id_func
		AND permanente.id_per = fin_per.id_per
		AND funcionario.l_name1 =  'LEDESMA'
		AND permanente.status =  '1'
		LIMIT 0 , 30*/
			/*"select * from ".TABLE2." where l_name1 like '%$tosearch%'*/
			$rs=$db->query("
			SELECT ".TABLE2.".id_func, name, l_name1, l_name2,".TABLE22.".id_per, status, source_fin
			FROM ".TABLE2.",".TABLE22.",".TABLE15."
			WHERE ".TABLE2.".id_func = ".TABLE22.".id_func
			AND	".TABLE22.".id_per = ".TABLE15.".id_per
			AND ".TABLE2.".l_name1 LIKE '%$tosearch%'
			AND ".TABLE22.".status = '1'
			ORDER BY l_name1, l_name2 ASC
			");	
		break;
			/*select * from ".TABLE2." where l_name2 like '%$tosearch%'*/
		case 'apm';
			$rs=$db->query("
			SELECT ".TABLE2.".id_func, name, l_name1, l_name2,".TABLE22.".id_per, status, source_fin
			FROM ".TABLE2.",".TABLE22.",".TABLE15."
			WHERE ".TABLE2.".id_func = ".TABLE22.".id_func
			AND	".TABLE22.".id_per = ".TABLE15.".id_per
			AND ".TABLE2.".l_name2 like '%$tosearch%'
			AND ".TABLE22.".status = '1'	
			ORDER BY l_name1, l_name2 ASC		
			");
		break;
		/*select * from ".TABLE2." where name like '%$tosearch%'*/
		
		case 'nom';
			$rs=$db->query("
			SELECT ".TABLE2.".id_func, name, l_name1, l_name2,".TABLE22.".id_per, status, source_fin
			FROM ".TABLE2.",".TABLE22.",".TABLE15."
			WHERE ".TABLE2.".id_func = ".TABLE22.".id_func
			AND	".TABLE22.".id_per = ".TABLE15.".id_per
			AND ".TABLE2.".name like '%$tosearch%'
			AND ".TABLE22.".status = '1'
			ORDER BY l_name1, l_name2 ASC
			");
		break;
	}
	switch ($_POST[by])
	{
		case 'app';
/*		CONSULTORES*/
			/*"select * from ".TABLE2." where l_name1 like '%$tosearch%'*/
			$rs1=$db->query("
			SELECT ".TABLE2.".id_func, name, l_name1, l_name2,".TABLE30.".id_con, status, source_fin
			FROM ".TABLE2.",".TABLE30.",".TABLE17."
			WHERE ".TABLE2.".id_func = ".TABLE30.".id_func
			AND	".TABLE30.".id_con = ".TABLE17.".id_con
			AND ".TABLE2.".l_name1 LIKE '%$tosearch%'
			AND ".TABLE30.".status = '1'
			ORDER BY l_name1, l_name2 ASC
			");	
		break;
			/*select * from ".TABLE2." where l_name2 like '%$tosearch%'*/
		case 'apm';
			$rs1=$db->query("
			SELECT ".TABLE2.".id_func, name, l_name1, l_name2,".TABLE30.".id_con, status, source_fin
			FROM ".TABLE2.",".TABLE30.",".TABLE17."
			WHERE ".TABLE2.".id_func = ".TABLE30.".id_func
			AND	".TABLE30.".id_con = ".TABLE17.".id_con
			AND ".TABLE2.".l_name2 like '%$tosearch%'
			AND ".TABLE30.".status = '1'
			ORDER BY l_name1, l_name2 ASC			
			");
		break;
		/*select * from ".TABLE2." where name like '%$tosearch%'*/
		
		case 'nom';
			$rs1=$db->query("
			SELECT ".TABLE2.".id_func, name, l_name1, l_name2,".TABLE30.".id_con, status, source_fin
			FROM ".TABLE2.",".TABLE30.",".TABLE17."
			WHERE ".TABLE2.".id_func = ".TABLE30.".id_func
			AND	".TABLE30.".id_con = ".TABLE17.".id_con
			AND ".TABLE2.".name like '%$tosearch%'
			AND ".TABLE30.".status = '1'
			ORDER BY l_name1, l_name2 ASC			
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
<legend>Busqueda Funcionario</legend>
<form id="form1" name="form1" method="post" action="" class="form">
<table width="100%" border="0" cellpadding="5" cellspacing="0">
  <tr>
    <td width="94%"><div align="right">
      Criterio de B??squeda:
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
	<legend>Resultado de la B??squeda</legend>
	<div class="table-wrap"><div class="table">	
	<table width="100%" border="0" cellpadding="5" cellspacing="0">
  <tr class="even">    
    <th>Apellido Paterno</th>	
    <th>Apellido Materno</th>
	<th >Nombre(s)</th>
	<th >Fuente</th>
    <th>Estado</th>
	<th>Acciones</th>
  </tr>';
 while ($r=$db->fetch_array($rs))
 {
 	echo ' <tr>   
    <td>'.$r[l_name1].'</td>
    <td>'.$r[l_name2].'</td>
	 <td>'.$r[name].'</td>
	  <td><strong>'.$r[source_fin].'</strong></td>';
	 if ($r[status]==1) 
	 {
	 	echo '<td><strong>ACTIVO</strong></td>';
	 }
	 else
	 {
		 echo '<td><strong>PASIVO</strong></td>';
	 }
echo '	
	<td>
		<a href="#" onclick="MM_openBrWindow(\'RegBaja.php?id_func='.$r[id_func].'&id_per='.$r[id_per].'\',\'regpermiso\',\'scrollbars=yes,width=550,height=420\')" title="Baja Funcionario"><img src="data/images/down.png"></a>

	</td>	
	
	
  </tr>';
 }
 //---------------consultores
  while ($r1=$db->fetch_array($rs1))
 {
 	echo ' <tr>   
    <td>'.$r1[l_name1].'</td>
    <td>'.$r1[l_name2].'</td>
	 <td>'.$r1[name].'</td>
	  <td><strong>'.$r1[source_fin].'</strong></td>';
	 if ($r1[status]==1) 
	 {
	 	echo '<td><strong>ACTIVOC</strong></td>';
	 }
	 else
	 {
		 echo '<td><strong>PASIVOC</strong></td>';
	 }
	 //echo 

echo '	<td>
	<a href="#" onclick="MM_openBrWindow(\'RegBajac.php?id_func='.$r1[id_func].'&id_con='.$r1[id_con].'\',\'regpermiso\',\'scrollbars=yes,width=800,height=750\')" title="Baja Consultor"><img src="data/images/down.png"></a>
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
