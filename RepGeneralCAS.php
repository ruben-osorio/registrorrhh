<?php
require("config.inc.php");
require("functions.inc.php");
require("database.class.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, "registrorrhh");
$db->connect();
$sw=0;
if (isset($_POST['to_excel']))
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
		$excel->writeCol($r['l_name1']);
		$excel->writeCol($r['l_name2']);
		$excel->writeCol($r['name']);
		//$rs3=$db->query("select ".."");
		$excel->writeCol(cambia_dateMy_to_dateN($r['date_ent']));
		
		$db = new Database(DB_SERVER, DB_USER, DB_PASS, "ssrp");
		$db->connect();
		
		//roa ini
		$db = new Database(DB_SERVER, DB_USER, DB_PASS, "ssrp");
		$db->connect();
		
		$db_copy = new Database(DB_SERVER, DB_USER, DB_PASS, "ssrp");
		$db_copy->connect();

		$rs2=$db->query("select * from old_cas where id_per='$r[id_per]' order by id_old_cas desc limit 1");
		
		$rs2_copy=$db_copy->query("select date_start, date_last, date_cas, year_rat, month_rat, day_rat from old_cas_copy where id_per='$r[id_per]' order by year_rat DESC limit 1");
		
		
		$r2=$db->fetch_array($rs2);
		$r2_copy = $db_copy->fetch_array($rs2_copy);

	
	 //fin cod cas
	 
	 
	 if (mysql_num_rows($rs2)==1)
	 {
			if ( $r2['year_rat'] > $r2_copy['year_rat'] ) 
			{
				$anyos_cas = $r2['year_rat'];
				$mes_cas = $r2['month_rat'];
				$dias_cas =$r2['day_rat'];
			}
			else
			{
				$anyos_cas = $r2_copy['year_rat'];
				$mes_cas = $r2_copy['month_rat'];
				$dias_cas = $r2_copy['day_rat'];
			}
		//roa end
		
	/* }
		
		
		$rs3=$db->query("select * from old_cas where id_per='$r[id_per]' order by id_old_cas desc limit 1");
		$r3=$db->fetch_array($rs3);
		if (mysql_num_rows($rs3)==1)
		{*/
			$excel->writeCol("SI");
			$excel->writeCol($anyos_cas);
			$excel->writeCol($mes_cas);
			$excel->writeCol($dias_cas);
			
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

$db = new Database(DB_SERVER, DB_USER, DB_PASS, "registrorrhh");
		$db->connect();
		
$rs=$db->query("select * from ".TABLE2.", ".TABLE22." where ".TABLE2.".id_func=".TABLE22.".id_func and 
".TABLE22.".status='1' order by  l_name1, l_name2, name, id_per");

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
    <td>'.$r['l_name1'].'</td>
    <td>'.$r['l_name2'].'</td>
	 <td>'.$r['name'].'</td>';	 
	 echo '<td>'.cambia_dateMy_to_dateN($r['date_ent']).'</td>';
	 
	 /*$rs3=$db->query("select * from ".TABLE24." where id_per='$r[id_per]' order by id_old_cas desc limit 1");
	 $r3=$db->fetch_array($rs3);
	 echo '<td>'.$r3[year_rat].' '.$r3[month_rat].' '.$r3[day_rat].'</td>';*/
	 
	/*$db = new Database(DB_SERVER, DB_USER, DB_PASS, "ssrp");
	$db->connect();
	 $rs2=$db->query("select * from old_cas where id_per='$r[id_per]' order by id_old_cas desc limit 1");
	 $r2=$db->fetch_array($rs2);
	 */
	 //ini cod cas
	 $db = new Database(DB_SERVER, DB_USER, DB_PASS, "ssrp");
	$db->connect();
	
	$db_copy = new Database(DB_SERVER, DB_USER, DB_PASS, "ssrp");
	$db_copy->connect();

  	$rs2=$db->query("select * from old_cas where id_per='$r[id_per]' order by year_rat desc limit 1");
	
	$rs2_copy=$db_copy->query("select date_start, date_last, date_cas, year_rat, month_rat, day_rat from old_cas_copy where id_per='$r[id_per]' order by year_rat DESC limit 1");
	
	// roa
	$db = new Database(DB_SERVER, DB_USER, DB_PASS, "ssrp");
	$db->connect();
	
	$db_copy = new Database(DB_SERVER, DB_USER, DB_PASS, "ssrp");
	$db_copy->connect();

  	$rs3=$db->query("select * from old_cas where id_per='$r[id_per]' order by year_rat desc limit 1");

	$rs3_copy=$db_copy->query("select date_start, date_last, date_cas, year_rat, month_rat, day_rat from old_cas_copy where id_per='$r[id_per]' order by year_rat DESC limit 1");
	
	
	
	$r2=$db->fetch_array($rs2);
	$r2_copy = $db_copy->fetch_array($rs2_copy);

	
	 //fin cod cas
	 
	 
	 if (mysql_num_rows($rs2)==1)
	 {
			if ( $r2['year_rat'] > $r2_copy['year_rat'] ) 
			{
				$anyos_cas = $r2['year_rat'];
				$mes_cas = $r2['month_rat'];
				$dias_cas =$r2['day_rat'];
			}
			else
			{
				$anyos_cas = $r2_copy['year_rat'];
				$mes_cas = $r2_copy['month_rat'];
				$dias_cas = $r2_copy['day_rat'];
			}
		 
		 echo '<td>SI</td>'; 
		 echo '<td>'.$anyos_cas.'</td>'; 
		 echo '<td>'.$mes_cas.'</td>'; 
		 echo '<td>'.$dias_cas.'</td>'; 
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