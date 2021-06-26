<?
require("config.inc.php");
require("database.class.php");
require ("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();

if (isset($_POST[to_excel]))
{
	include("excelwriter.inc.php");  
	$excel=new ExcelWriter("ListaAfiliadosCaja.xls");
	if($excel==false) {   
			echo $excel->error;
	}					
	$myArr=array("AP. PATERNO","AP. MATERNO","NOMBRE(S)","FECHA INGRESO","AFILIACION","SEGURO","NUMERO SEGURO");
	$excel->writeLine($myArr);
	
	$rs=$db->query("select * from ".TABLE2.", ".TABLE22." where
		".TABLE2.".id_func=".TABLE22.".id_func
		and ".TABLE22.".status='1'
		order by ".TABLE2.".l_name1, ".TABLE2.".l_name2 asc");
	
	while ($r=$db->fetch_array($rs))
	{		
		$rs2=$db->query("select id_sec,date_afil,name_sec,num_reg from ".TABLE23." where id_per='$r[id_per]'");
		mysql_num_rows($rs2);
		$r2=$db->fetch_array($rs2);
		
		$excel->writeRow();
		$excel->writeCol($r[l_name1]);
		$excel->writeCol($r[l_name2]);
		$excel->writeCol($r[name]);
		$excel->writeCol(cambia_dateMy_to_dateN($r[date_ent]));
		
		$excel->writeCol(cambia_dateMy_to_dateN($r2[date_afil]));
		$excel->writeCol($r2[name_sec]);
		$excel->writeCol($r2[num_reg]);
	}
	$excel->close();
	$msg= 'Los datos se han grabado con &eacute;xito. Descargue el fichero de <a href="VacacionesTGN.xls">Aqui</a>';
	$sw=1;
}
echo '<link rel="stylesheet" type="text/css" media="screen" href="data/css/reportes.css">';
if ($sw==1)
{
	echo '<div class="successre">'.$msg.'</div>';

}
$rs=$db->query("select * from ".TABLE2.", ".TABLE22." where
		".TABLE2.".id_func=".TABLE22.".id_func
		and ".TABLE22.".status='1'
		order by ".TABLE2.".l_name1, ".TABLE2.".l_name2 asc ");

echo '<script type="text/javascript" src="js/scripts.js"></script>';
echo '<fieldset>
	<legend>Funcionarios Asegurados</legend>
	<div style="padding: 5px; ">
	<form id="form1" name="form1" method="post" action="" class="form">
  	<input type="submit" name="to_excel" id="save" class="submit" value="Exportar a Excel" />
	</form>
	</div>';
	//$rs3=$db->query(" select * from ".TABLE9."");	
	
	echo '<div class="table-wrap"><div class="table">	
	<table width="100%" border="0" cellpadding="5" cellspacing="0">
  <tr class="even">    
    <th>Ap.Paterno</th>	
    <th>Ap.Materno</th>
	<th >Nombre(s)</th>
	<th >F.Ingreso</th>	
	<th >Afiliacion</th>
	<th >Seguro</th>
	<th >Numero&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
</tr>';
 $c=0;
while ($r=$db->fetch_array($rs))
{
	$rs1=$db->query("select id_sec from ".TABLE23." where id_per='$r[id_per]'");
	//echo mysql_num_rows($rs1)."<br>";
	if (mysql_num_rows($rs1)!=0)
	{
		$r1=$db->fetch_array($rs1);
		echo ' <tr>   
    	<td>'.$r[l_name1].'</td>
    	<td>'.$r[l_name2].'</td>
	 	<td>'.$r[name].'</td>
	  	<td>'.cambia_dateMy_to_dateN($r[date_ent]).'</td>';
		$rs4=$db->query("select * from ".TABLE23." where id_per='$r[id_per]'");
		$r4=$db->fetch_array($rs4);
		echo '<td>'.cambia_dateMy_to_dateN($r4[date_afil]).'</td>
		<td>'.$r4[name_sec].'</td>
		<td>'.$r4[num_reg].'</td>
		';
		$c++;
	}
	
}
 echo'
 </div></div>
</table>
	</fieldset>';
?>