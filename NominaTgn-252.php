<?
require("config.inc.php");
require("database.class.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();

if (isset($_POST[to_excel]))
{
	include("excelwriter.inc.php");  
	$excel=new ExcelWriter("NominaTGN252.xls");
	if($excel==false) {   
			echo $excel->error;
	}
	//								
	$myArr=array("AP. PATERNO","AP. MATERNO","NOMBRE(S)","FECHA INGRESO","CARGO");
	$excel->writeLine($myArr);
	
	$rs=$db->query("select l_name1, l_name2, name, date_ent, charge  
				from ".TABLE2.",".TABLE30.",".TABLE31.",".TABLE17." 
				where funcionario.id_func=contrato.id_func
				and contrato.id_con=char_con.id_con
				and fin_con.id_con=contrato.id_con
				and fin_con.source_fin='TGN-252'
				and status='1'
				order by l_name1 asc, l_name2 asc");
	while ($r=$db->fetch_array($rs))
	{		
		$excel->writeRow();
		$excel->writeCol($r[l_name1]);
		$excel->writeCol($r[l_name2]);
		$excel->writeCol($r[name]);
		$excel->writeCol($r[date_ent]);
		$excel->writeCol($r[charge]);		
	}	
	$excel->close();
	$msg= 'Los datos se han grabado con &eacute;xito. Descargue el fichero de <a href="NominaTGN252.xls">Aqui</a>';	
	$sw=1;

}
echo '<link rel="stylesheet" type="text/css" media="screen" href="data/css/reportes.css" />';

if ($sw==1)
{
	echo '<div class="successre">'.$msg.'</div>';
}
$rs=$db->query("select l_name1, l_name2, name, date_ent, charge  
				from ".TABLE2.",".TABLE30.",".TABLE31.",".TABLE17." 
				where funcionario.id_func=contrato.id_func
				and contrato.id_con=char_con.id_con
				and fin_con.id_con=contrato.id_con
				and fin_con.source_fin='TGN-252'
				and status='1'
				order by l_name1 asc, l_name2 asc");
echo '<fieldset>
	<legend>Nómina Funcionarios TGN-252</legend>
	<div style="padding: 5px; "><form id="form1" name="form1" method="post" action="" class="form">

  <input type="submit" name="to_excel" id="save" class="submit" value="Exportar a Excel" />

</form></div>
	
	<div class="table-wrap"><div class="table">	
	<table width="100%" border="0" cellpadding="5" cellspacing="0">
  <tr class="even">    
    <th width="50">Ap.Paterno</th>	
    <th width="50">Ap.Materno</th>
	<th width="50">Nombre(s)</th>
	<th width="100">Ingreso</th>
	<th width="200">Cargo</th>
</tr>';
  
while ($r=$db->fetch_array($rs))
{	echo ' <tr>   
    <td>'.$r[l_name1].'</td>
    <td>'.$r[l_name2].'</td>
	 <td>'.$r[name].'</td>
	  <td>'.$r[date_ent].'</td>
	  <td>'.$r[charge].'</td>';	  
}
 echo'
 </div></div>
</table>
	</fieldset>';
?>