<?
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();

if (isset($_POST[to_excel]))
{
	include("excelwriter.inc.php");  
	$excel=new ExcelWriter("ReporteBajaCNS.xls");
	if($excel==false) {   
			echo $excel->error;
	}								
	$myArr=array("AP. PATERNO","AP. MATERNO","NOMBRE(S)","FECHA DE RETIRO","FECHA DE DESAFILIACIÓN");
	$excel->writeLine($myArr);
				
	$rs=$db->query("SELECT ".TABLE2.".id_func, ".TABLE2.".name, ".TABLE2.".l_name1, ".TABLE2.".l_name2, ".TABLE22.".id_per, ".TABLE22.".status, date_des, date_efect
			FROM ".TABLE2.",".TABLE22.",".TABLE23.",".TABLE35."
			WHERE ".TABLE2.".id_func = ".TABLE22.".id_func
			AND ".TABLE22.".id_per = ".TABLE23.".id_per
			AND ".TABLE22.".id_per = ".TABLE35.".id_per
			AND ".TABLE22.".status = '0'
			AND date_des <> '0000-00-00'");
	while ($r=$db->fetch_array($rs))
	{		
			$excel->writeRow();
			$excel->writeCol($r[l_name1]);
			$excel->writeCol($r[l_name2]);
			$excel->writeCol($r[name]);
			$excel->writeCol(cambia_dateMy_to_dateN($r[date_efect]));
			$excel->writeCol(cambia_dateMy_to_dateN($r[date_des]));			

	}	
	$excel->close();
	$msg= 'Los datos se han grabado con &eacute;xito. Descargue el fichero de <a href="ReporteBajaCNS.xls">Aqui</a>';	
	$sw=1;

}
	echo '<link rel="stylesheet" type="text/css" media="screen" href="data/css/reportes.css" />';
if ($sw==1)
	{
		echo '<div class="successre">'.$msg.'</div>';
	}
//$rs=$db->query("select * from ".TABLE2." where f_status='1' order by l_name1 asc, l_name2 asc");
			
$rs=$db->query("SELECT ".TABLE2.".id_func, ".TABLE2.".name, ".TABLE2.".l_name1, ".TABLE2.".l_name2, ".TABLE22.".id_per, ".TABLE22.".status, date_des, date_efect
			FROM ".TABLE2.",".TABLE22.",".TABLE23.",".TABLE35."
			WHERE ".TABLE2.".id_func = ".TABLE22.".id_func
			AND ".TABLE22.".id_per = ".TABLE23.".id_per
			AND ".TABLE22.".id_per = ".TABLE35.".id_per
			AND ".TABLE22.".status = '0'
			AND date_des <> '0000-00-00'
			");

echo '<script type="text/javascript" src="js/scripts.js"></script>';
echo '<fieldset>
	<legend>Funcionarios Pendientes Afiliación/Regularización</legend>
	<div style="padding: 5px; ">
	<form id="form1" name="form1" method="post" action="" class="form">
  	<input type="submit" name="to_excel" id="save" class="submit" value="Exportar a Excel" />
	</form>
	</div>';
	echo '<div class="table-wrap"><div class="table">	
	<table width="100%" border="0" cellpadding="5" cellspacing="0">
  <tr class="even">    
    <th>Ap.Paterno</th>	
    <th>Ap.Materno</th>
	<th >Nombre(s)</th>
	<th >Fecha de Retiro</th>
	<th >Fecha de Desafiliación</th>
	
</tr>';
 $c=0;
while ($r=$db->fetch_array($rs))
{
		echo ' <tr>   
    	<td width="200">'.$r[l_name1].'</td>
    	<td width="200">'.$r[l_name2].'</td>
	 	<td width="200">'.$r[name].'</td>
	  	<td width="200">'.$r[date_efect].'</td>
	  	<td width="200">'.$r[date_des].'</td>
		';	  	
		$c++;
	
	
}
 echo'
 </div></div>
</table>
	</fieldset>';
?>