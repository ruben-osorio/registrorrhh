<?
require("config.inc.php");
require("database.class.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();

if (isset($_POST[to_excel]))
{
	include("excelwriter.inc.php");  
	$excel=new ExcelWriter("ReporteGeneralBajas.xls");
	if($excel==false) {   
			echo $excel->error;
	}
	//								
	$myArr=array("AP. PATERNO","AP. MATERNO","NOMBRE(S)","ESTADO","CARGO");
	$excel->writeLine($myArr);
	
	$rs=$db->query("SELECT ".TABLE2.".id_func, name, l_name1, l_name2,".TABLE22.".id_per, status, source_fin, date_efect
			FROM ".TABLE2.",".TABLE22.",".TABLE15.",".TABLE35."
			WHERE ".TABLE2.".id_func = ".TABLE22.".id_func
			AND	".TABLE22.".id_per = ".TABLE15.".id_per
			AND	".TABLE22.".id_per = ".TABLE35.".id_per
			AND ".TABLE22.".status = '0'");
	while ($r=$db->fetch_array($rs))
	{	if($r[status]==0) $est='PASIVO';
		else $est='ACTIVO';	
		$excel->writeRow();
		$excel->writeCol($r[l_name1]);
		$excel->writeCol($r[l_name2]);
		$excel->writeCol($r[name]);
		$excel->writeCol($est);
		$excel->writeCol($r[source_fin]);		
		$excel->writeCol($r[date_efect]);		
	}	
	$rs1=$db->query("
			SELECT ".TABLE2.".id_func, name, l_name1, l_name2,".TABLE30.".id_con, status, source_fin, date_efec
			FROM ".TABLE2.",".TABLE30.",".TABLE17.",".TABLE36."
			WHERE ".TABLE2.".id_func = ".TABLE30.".id_func
			AND	".TABLE30.".id_con = ".TABLE17.".id_con
			AND	".TABLE30.".id_con = ".TABLE36.".id_con
			AND ".TABLE30.".status = '0'
			");	
		while ($r1=$db->fetch_array($rs1))
	{	if($r1[status]==0) $est='PASIVO';
		else $est='ACTIVO';		
		$excel->writeRow();
		$excel->writeCol($r1[l_name1]);
		$excel->writeCol($r1[l_name2]);
		$excel->writeCol($r1[name]);
		$excel->writeCol($est);
		$excel->writeCol($r1[source_fin]);		
		$excel->writeCol($r1[date_efec]);	
	}	
	$excel->close();
	$msg= 'Los datos se han grabado con &eacute;xito. Descargue el fichero de <a href="ReporteGeneralBajas.xls">Aqui</a>';	
	$sw=1;

}
	echo '<link rel="stylesheet" type="text/css" media="screen" href="data/css/reportes.css" />';

	if ($sw==1)
	{
		echo '<div class="successre">'.$msg.'</div>';
	}
$rs=$db->query("SELECT ".TABLE2.".id_func, name, l_name1, l_name2,".TABLE22.".id_per, status, source_fin, date_efect
			FROM ".TABLE2.",".TABLE22.",".TABLE15.",".TABLE35."
			WHERE ".TABLE2.".id_func = ".TABLE22.".id_func
			AND	".TABLE22.".id_per = ".TABLE15.".id_per
			AND	".TABLE22.".id_per = ".TABLE35.".id_per
			AND ".TABLE22.".status = '0'");
$rs1=$db->query("
			SELECT ".TABLE2.".id_func, name, l_name1, l_name2,".TABLE30.".id_con, status, source_fin, date_efec
			FROM ".TABLE2.",".TABLE30.",".TABLE17.",".TABLE36."
			WHERE ".TABLE2.".id_func = ".TABLE30.".id_func
			AND	".TABLE30.".id_con = ".TABLE17.".id_con
			AND	".TABLE30.".id_con = ".TABLE36.".id_con
			AND ".TABLE30.".status = '0'
			");	
echo '<fieldset>
	<legend>Nómina PASIVOS</legend>
	<div style="padding: 5px; "><form id="form1" name="form1" method="post" action="" class="form">

  <input type="submit" name="to_excel" id="save" class="submit" value="Exportar a Excel" />

</form></div>
	
	<div class="table-wrap"><div class="table">	
	<table width="100%" border="0" cellpadding="5" cellspacing="0">
  <tr class="even">    
    <th width="100">Ap.Paterno</th>	
    <th width="100">Ap.Materno</th>
	<th width="100">Nombre(s)</th>
	<th width="100">Estado</th>
	<th width="100">Fuente</th>
	<th width="100">Fecha de Retiro</th>	
</tr>';
  
while ($r=$db->fetch_array($rs))
{	if($r[status]==0) $est='PASIVO';
	else $est='ACTIVO';

	echo ' <tr>   
    <td>'.$r[l_name1].'</td>
    <td>'.$r[l_name2].'</td>
	<td>'.$r[name].'</td>
	<td><strong>'.$est.'</strong></td>
	<td><strong>'.$r[source_fin].'</strong></td>
	<td><strong>'.$r[date_efect].'</strong></td>';	  
	
}
while ($r1=$db->fetch_array($rs1))
{	if($r1[status]==0) $est='PASIVO';
	else $est='ACTIVO';
	echo ' <tr>   
    <td>'.$r1[l_name1].'</td>
    <td>'.$r1[l_name2].'</td>
	<td>'.$r1[name].'</td>
	<td><strong>'.$est.'</strong></td>
	<td><strong>'.$r1[source_fin].'</strong></td>
	<td><strong>'.$r1[date_efec].'</strong></td>
	';	  
}
 echo'
 </div></div>
</table>
	</fieldset>';
?>