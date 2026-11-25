<?php
define('DB_SERVER', "localhost");
define('DB_USER', "ruben");
define('DB_PASS', "");

define('DB_DATABASE', "registrorrhh");// BASE DE DATOS CONSOLIDADA

require("database.class.php");

//$db = new Database(DB_SERVER, DB_USER, DB_PASS, "ssrp");
//$db->connect();

$dbp = new Database(DB_SERVER, DB_USER, DB_PASS, "registrorrhh");
$dbp->connect();


if (isset($_POST['search']))
{

	$tosearch=strtoupper($_POST['tosearch']);
	switch ($_POST['by'])
	{
		case 'app';
			$rs=$dbp->query("
			(select * from funcionario, permanente, baja
			where l_name1 like '%$tosearch%'
			and funcionario.id_func = permanente.id_func
			and permanente.status='0'
			and (baja.id_per = permanente.id_per )
			)
			");		
		break;
		
		case 'apm';
			$rs=$dbp->query("
			select * from funcionario, permanente, baja 
			where l_name2 like '%$tosearch%'
			and funcionario.id_func=permanente.id_func
			and permanente.status='0'
			and baja.id_per = permanente.id_per
			");
		break;

		case 'nom';
			$rs=$dbp->query("
			select * from funcionario, permanente, baja 
			where name like '%$tosearch%'
			and funcionario.id_func=permanente.id_func
			and permanente.status='0'
			and baja.id_per = permanente.id_per
			");
		break;
		
		default:
				$rs=$dbp->query("
			select * from funcionario, permanente, baja 
			where  funcionario.id_func=permanente.id_func
			and permanente.status='0'
			and baja.id_per = permanente.id_per
			");
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

<script type="text/javascript" src="js/scripts.js"></script>
</head>
<body>
<fieldset>
<legend>Busqueda Funcionario - Reporte Individual Pasivos Form. 10-01 Vacación </legend>
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
<?php
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
 while ($r=$dbp->fetch_all_array($rs))
 {
 	echo ' <tr>   
    <td>'.$r['id_func'].' - '.$r['l_name1'].'</td>
    <td>'.$r['l_name2'].'</td>
	 <td>'.$r['name'].'</td>
	  <td><strong>TGN</strong></td>

	<td>
	<a href="#" onclick="MM_openBrWindow(\'RepIndivFormVacP.php?id='.$r['id_func'].'\',\'regpermiso\',\'scrollbars=yes,width=650,height=420\')" title="Reporte Individual"><img src="data/images/report_calendar.png"></a>	
	</td>	
  </tr>';
 }
 echo'
 </div></div>
</table>
	</fieldset>';

}

//$db->close();
$dbp->close();
?>
</body>

</html>
