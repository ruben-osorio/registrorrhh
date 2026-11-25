<?php
//require("config.inc.php");
require("functions.inc.php");
require("database.class.php");
define('DB_SERVER', "localhost");
define('DB_USER', "ruben");
define('DB_PASS', "");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, 'registrorrhh');
$db->connect();


$sw=0;
if (isset($_POST['to_excel']))
{
	include("excelwriter.inc.php");  
	$excel=new ExcelWriter("VacacionesTGN.xls");
	if($excel==false) 
	{   
		echo $excel->error;
	}
	//								
	$myArr=array("AP. PATERNO","AP. MATERNO","NOMBRE(S)","FECHA INGRESO","CAS","AÑOS","MESES","DIAS","GESTION 1","DIAS 1","GESTION 2","DIAS 2", "TOTAL");
	$excel->writeLine($myArr);
	
	
	$rs=$db->query("select * from funcionario, permanente where funcionario.id_func=permanente.id_func and permanente.status='1' order by l_name1, l_name2, name asc");
	
	
	$dbhandle = mysql_connect(DB_SERVER, 'ruben', '') 
	or die("Unable to connect to MySQL");
		echo "Connected to MySQL<br>";
	
	$selectedSSRP = mysql_select_db("ssrp",$dbhandle) 
			or die("Could not select ssrp");

	while ($r=$db->fetch_array($rs))
	{	
		
	//	$rs2=$db->query("select *  from vacaciones where id_per='$r[id_per]'");
	//	$r2=$db->fetch_array($rs2);
		
		$result = mysql_query("select *  from vacaciones where id_per='$r[id_per]'");
//fetch tha data from the database
		//while ($row = mysql_fetch_array($result)) {
		//   echo "ID:".$row{'id'}." Name:".$row{'model'}." 
		//   ".$row{'year'}."<br>";
		//}
		$row = mysql_fetch_array($result);
		
		$excel->writeRow();
		$excel->writeCol($r['l_name1']);
		$excel->writeCol($r['l_name2']);
		$excel->writeCol($r['name']);
		//$rs3=$db->query("select ".."");
		$excel->writeCol(cambia_dateMy_to_dateN($r['date_ent']));
		
		
		
	/*	$db = new Database(DB_SERVER, DB_USER, DB_PASS, 'ssrp');
		$db->connect();
		
		$rs3=$db->query("select * from old_cas where id_per='$r[id_per]' order by id_old_cas desc limit 1");
		$r3=$db->fetch_array($rs3);
		*/
	//R1 INI
	$db = new Database(DB_SERVER, DB_USER, DB_PASS, "ssrp");
	$db->connect();
	
	$db_copy = new Database(DB_SERVER, DB_USER, DB_PASS, "ssrp");
	$db_copy->connect();

  	$rs3=$db->query("select * from old_cas where id_per='$r[id_per]' order by id_old_cas desc limit 1");

	$rs3_copy=$db_copy->query("select date_start, date_last, date_cas, MAX(year_rat) as year_rat, month_rat, day_rat from old_cas_copy where id_per='$r[id_per]' order by year_rat ASC limit 1");
	
	
	
 	if (mysql_num_rows($rs3)!=0)

 	{
		$r3=$db->fetch_array($rs3);
		$r3_copy = $db_copy->fetch_array($rs3_copy);

		if ( $r3['year_rat'] > $r3_copy['year_rat'] ) 
		{
			$anyos_cas = $r3['year_rat'];
			$mes_cas = $r3['month_rat'];
			$dias_cas =$r3['day_rat'];
		}
		else
		{
			$anyos_cas = $r3_copy['year_rat'];
			$mes_cas = $r3_copy['month_rat'];
			$dias_cas = $r3_copy['day_rat'];
		}
	}
	//R2 END
		
		
		if (mysql_num_rows($rs3)==1)
		{
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
	//	$excel->writeCol($r2[gestion_1]);
	
		$excel->writeCol($row['gestion_1']);
		//$excel->writeCol($r2[dias_g1]);
		$excel->writeCol($row['dias_g1']);
		//$excel->writeCol($r2[gestion_2]);
		$excel->writeCol($row['gestion_2']);
		//$excel->writeCol($r2[dias_g2]);
		$excel->writeCol($row['dias_g2']);
		
	//	$excel->writeCol($row{'observaciones'});
		$total_d=$row['dias_g1']+$row['dias_g2'];
		$excel->writeCol($total_d);
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
/*else
{    if($sw==0)
	{echo '	
	<div class="errorre">'.$msg.'</div>';
	//exit;
	}
}*/
$dbhandle = mysql_connect(DB_SERVER, 'ruben', '') ;
$selectedSSRP = mysql_select_db("registrorrhh",$dbhandle) 
			or die("Could not select registrorrhh");
$rs=$db->query("select * from ".TABLE2.", ".TABLE22." where ".TABLE2.".id_func=".TABLE22.".id_func and ".TABLE22.".status='1' order by l_name1, l_name2, name asc");

echo '<fieldset>
	<legend>Reporte General Saldo Vacaciones</legend>
	<div style="padding: 5px; ">
	<a href="VacacionesTGN.php" title="Vacaiones TGN Totales" target="new">Ver Totales</a><br />
<br />

	<form id="form1" name="form1" method="post" action="" class="form">

  <input type="submit" name="to_excel" id="save" class="submit" value="Exportar a Excel" /><br />
  
  <button class="print-link avoid-this"> Print this</button>

</form></div>
	
<div id="print-div2" class="print_div">

	<table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr class="even">    
    <th>Ap. Paterno</th>	
    <th>Ap. Materno</th>
	<th>Nombre(s)</th>
	<th>Ingreso</th>	
    <th>Gestion 1</th>
	<th>Días 1</th>
	<th>Gestion 2 </th>
	<th>Días 2</th>
	<th>Total</th>	
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
	 
	 
	 $selectedSSRP = mysql_select_db("ssrp",$dbhandle) 
	 or die("Could not select ssrp");
	 $rs2=$db->query("select *  from vacaciones where id_per='$r[id_per]'");
	 $r2=$db->fetch_array($rs2);
	 echo '<td>'.$r2['gestion_1'].'</td>';
	  if ($r2['dias_g1']==0)
	  {
	  		
		if ( $r['date_ent'] >= '2015-02-01')
			echo '<td>NUEVO</td>';
		else
			echo '<td>CERRADO</td>';
	  }
	  else
	  {
	  	echo '<td>'.$r2['dias_g1'].'</td>';
	  }
	  
	  echo '<td>'.$r2['gestion_2'].'</td>';
	  if ($r2['dias_g2']==0)
	  {
		  if ( $r['date_ent'] >= '2015-02-01')
			echo '<td>NUEVO</td>';
		else
			echo '<td>CERRADO</td>';
		
	  }
	  else
	  {
	  	echo '<td>'.$r2['dias_g2'].'</td>';
	  }
	$sumt = $r2['dias_g1'] + $r2['dias_g2'];
	if ($sumt==0)
	  {
	  	if ( $r['date_ent'] >= '2015-02-01')
			echo '<td>NUEVO</td>';
		else
			echo '<td>CERRADO</td>';	
	  }
	  else
	  {
	  	echo '<td>'.$sumt.'</td>';
	  }
	  
	 
	 
}
 echo'
 
 </div></div>
</table>

</div>

	</fieldset>
	

	
            
	
	';
//	mysql_close($dbhandle);
?>