<?
require("config.inc.php");
require("functions.inc.php");
require("database.class.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
$sw=0;
if (isset($_POST[to_excel]))
{
	include("excelwriter.inc.php");  
	$excel=new ExcelWriter("ReporteGeneralCAS.xls");
	if($excel==false) 
	{   
		echo $excel->error;
	}
	//								
	$myArr=array("AP. PATERNO","AP. MATERNO","NOMBRE(S)","FECHA INGRESO","CAS","AÑOS","MESES","DIAS");
	$excel->writeLine($myArr);
	
	$rs=$db->query("select * from ".TABLE2.", ".TABLE22." where ".TABLE2.".id_func=".TABLE22.".id_func and ".TABLE22.".status='1' order by l_name1, l_name2, name asc");
	while ($r=$db->fetch_array($rs))
	{		
		$excel->writeRow();
		$excel->writeCol($r[l_name1]);
		$excel->writeCol($r[l_name2]);
		$excel->writeCol($r[name]);
		//$rs3=$db->query("select ".."");
		$excel->writeCol(cambia_dateMy_to_dateN($r[date_ent]));
		
		$rs3=$db->query("select * from ".TABLE24." where id_per='$r[id_per]' order by id_old_cas desc limit 1");
		$r3=$db->fetch_array($rs3);
		if (mysql_num_rows($rs3)==1)
		{
			$excel->writeCol("SI");
			$excel->writeCol($r3[year_rat]);
			$excel->writeCol($r3[month_rat]);
			$excel->writeCol($r3[day_rat]);
			
		}
		else
		{
			$excel->writeCol("NO");
			$excel->writeCol("-");
			$excel->writeCol("-");
			$excel->writeCol("-");
		}	
		$excel->writeCol($total_d);
	}
	$excel->close();	
	$msg= 'Los datos se han grabado con &eacute;xito. Descargue el fichero de <a href="ReporteGeneralCAS.xls">Aqui</a>';	
	$sw=1;

}
echo '<link rel="stylesheet" type="text/css" media="screen" href="data/css/reportes.css" />';

if ($sw==1)
{
	echo '<div class="successre">'.$msg.'</div>';
}

$rs=$db->query("select * from ".TABLE2.", ".TABLE22." where ".TABLE2.".id_func=".TABLE22.".id_func and 
".TABLE22.".status='1' order by id_per, l_name1, l_name2, name");

echo '<fieldset>
	<legend>Reporte General CAS</legend>
	<div style="padding: 5px; "><form id="form1" name="form1" method="post" action="" class="form">

  <input type="submit" name="to_excel" id="save" class="submit" value="Exportar a Excel" />

</form></div>
	
	<div class="table-wrap"><div class="table">	
	<table width="100%" border="0" cellpadding="5" cellspacing="0">
  <tr class="even">    
    <th width="10%">Ap. Paterno</th>	
    <th width="10%">Ap. Materno</th>
	<th width="10%">Nombre(s)</th>
	<th width="10%">Ingreso</th>
	<th width="10%">CAS</th>	
    <th width="10%">AÑOS</th>
	<th width="10%">MESES</th>
	<th width="10%">DIAS</th>
  </tr>';
  
while ($r=$db->fetch_array($rs))
{
	echo ' <tr>   
    <td>'.$r[l_name1].'</td>
    <td>'.$r[l_name2].'</td>
	 <td>'.$r[name].'</td>';	 
	 echo '<td>'.cambia_dateMy_to_dateN($r[date_ent]).'</td>';
	 
	 /*$rs3=$db->query("select * from ".TABLE24." where id_per='$r[id_per]' order by id_old_cas desc limit 1");
	 $r3=$db->fetch_array($rs3);
	 echo '<td>'.$r3[year_rat].' '.$r3[month_rat].' '.$r3[day_rat].'</td>';*/
	 
	 $rs2=$db->query("select *  from ".TABLE24." where id_per='$r[id_per]'");
	 $r2=$db->fetch_array($rs2);
	 if (mysql_num_rows($rs2)==1)
	 {
		 echo '<td>SI</td>'; 
		 echo '<td>'.$r2[year_rat].'</td>'; 
		 echo '<td>'.$r2[month_rat].'</td>'; 
		 echo '<td>'.$r2[day_rat].'</td>'; 
	 }	  
	 else
	 {
		  echo '<td>NO</td>'; 
		  echo '<td>-</td>'; 
		 echo '<td>-</td>'; 
		 echo '<td>-</td>'; 
	 }
	 echo "</tr>";
}
 echo'
 </div></div>
</table>
	</fieldset>';
?>