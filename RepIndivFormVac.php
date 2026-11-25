<?php
require_once("security.php");
require("functions.inc.php");
require("config.inc.php");
require("database.class.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, "ssrp");
$db->connect();
$id_func=$_GET['id'];

	$dbhandle = mysql_connect(DB_SERVER, 'ruben', '') 
	or die("Unable to connect to MySQL");
	
	
	$selected = mysql_select_db("registrorrhh",$dbhandle) 
			or die("Could not select registrorrhh");

			
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
		
		$rs3=$db->query("select * from ".TABLE24." where id_per='$r[id_per]' order by id_old_cas desc limit 1");
		$r3=$db->fetch_array($rs3);
		if (mysql_num_rows($rs3)==1)
		{
			$excel->writeCol("SI");
			$excel->writeCol($r3['year_rat']);
			$excel->writeCol($r3['month_rat']);
			$excel->writeCol($r3['day_rat']);
			
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

if (isset($_GET['id'])) 
{	
	//$rs1=$db->query("select id_per, date_ent from permanente where id_func='$id_func' order by id_per desc limit 1");
	//$r1=$db->fetch_array($rs1);
	
	$result = mysql_query("select id_per, date_ent from permanente where id_func='$id_func' order by id_per desc limit 1")
	or die(mysql_error());  

	$row = mysql_fetch_array( $result );

	$id_per= $row['id_per'];
	$fecha_entrada= $row['date_ent'];
	//$r1[id_per];	
	//$rs=$db->query("select * from funcionario where id_func='$id_func'");
	
	$result = mysql_query("select * from funcionario where id_func='$id_func'")
	or die(mysql_error());  

	//$row = mysql_fetch_array( $result );
	if ($row1 = mysql_fetch_array( $result ))
	
	//if ($r=$db->fetch_array($rs))
	{
		/*if (isset($_POST[save]))
		{
			//echo "insert into ".TABLE3."(id_per, gestion_1, dias_g1, gestion_2, dias_g2, observaciones) values
			//('$id_per','$_POST[g_1]','$_POST[dias_g1]','$_POST[g_2]','$_POST[dias_g2]','$_POST[observaciones]')";
			$rs5=$db->query("update ".TABLE3." set gestion_1='$_POST[g_1]', dias_g1='$_POST[dias_g1]', gestion_2='$_POST[g_2]', dias_g2='$_POST[dias_g2]', observaciones='$_POST[observaciones]'  where id_per='$id_per'");
			if ($rs5)
			{
				$sw=1;
				$msg="Actualización completada";
			}
		}*/
		if ($sw==1)
		{
			echo '<div class="alert success">'.$msg.'</div>';
		}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="imagetoolbar" content="no" />



<link href="css/corep.css" rel="stylesheet" media="screen" type="text/css" />
<link href="css/corep.css" rel="stylesheet" media="print" type="text/css" />

</head>

<body>

<div id="content">
<fieldset>
<legend>Reporte de Vacación
  </legend>


<form id="form1" name="form1" method="post" action=""  class="form">
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <th scope="col">Nombres</th>
    <td ><?php echo $row1['name']?></td>
	
  </tr>
  <tr>
    <th>Apellidos:</td>
    <td><?php echo $row1['l_name1']?> <?php echo $row1['l_name2']?></td>
  </tr>
  <tr>
    <th>Fecha de Ingreso:</td>
    <td><?php echo cambia_dateMy_to_dateN( $fecha_entrada )?></td>
  </tr>
  <tr>
  <?php
  $db = new Database(DB_SERVER, DB_USER, DB_PASS, "registrorrhh");
	$db->connect();
  $rs2=$db->query("select charge from char_per where id_per='$id_per'");
  $r2=$db->fetch_array($rs2);
  ?>
    <th>Cargo:</td>
    <td><?php echo $r2['charge']?></td>
  </tr>
  
<?php
	$db = new Database(DB_SERVER, DB_USER, DB_PASS, "ssrp");
	$db->connect();
	
	$db_copy = new Database(DB_SERVER, DB_USER, DB_PASS, "ssrp");
	$db_copy->connect();

  	$rs3=$db->query("select * from old_cas where id_per='$id_per' ORDER BY year_rat DESC , month_rat DESC LIMIT 1");

	//$rs3_copy=$db_copy->query("select date_start, date_last, date_cas, year_rat, month_rat, day_rat from old_cas_copy where id_per='$id_per' order by year_rat DESC limit 1");
	
	
	
 	if (mysql_num_rows($rs3)==0)
 	{
		echo "<tr>
		<th>CAS:</th>
    	<td>NO TIENE</td></tr>";
	}
 	else
 	{
		$r3=$db->fetch_array($rs3);
	//	$r3_copy = $db_copy->fetch_array($rs3_copy);
		//echo "estos son los dos datos : old_cas = " . $r3[year_rat]  . " y old_cas copy = " . $r3_copy[year_rat] . "\n";
	//	if ( $r3[year_rat] > $r3_copy[year_rat] )
	//	{
			$anyos_cas = $r3['year_rat'];
			$mes_cas = $r3['month_rat'];
			$dias_cas =$r3['day_rat'];
	/*	}
		else
		{
			$anyos_cas = $r3_copy[year_rat];
			$mes_cas = $r3_copy[month_rat];
			$dias_cas = $r3_copy[day_rat];
		}
	*/
		echo "<tr>
		<th>CAS:</th>
    	<td><strong>".$anyos_cas ."</strong> AÑO(S) , <strong>".$mes_cas ."</strong> MES(ES) ,  <strong>".$dias_cas."</strong> DIA(S)</td></tr>";
	}
  ?>  
  
  <tr>
  <?php  

  	$rs4=$db->query("select * from vacaciones where id_per='$id_per'");
  	$r4=$db->fetch_array($rs4);  
  ?>
    <th>Gestión 1:</td>
    <td><?php echo $r4['gestion_1']?> Dia(s): <strong><?php echo $r4['dias_g1']?></strong>
  </tr>
  <tr>
    <th>Gestión 2:</td>
    <td><?php echo $r4['gestion_2']?> Dia(s): <strong><?php echo $r4['dias_g2']?></strong></td>
  </tr>
  <tr>
    <td colspan="2">
  

    </td>
  </tr>
  
  
</table></form>
</fieldset>

	</div>
	
	<script src="js/jquery-1.6.2.min.js"></script>
	<script src="js/jquery.PrintArea.js_4.js"></script>
	<script src="js/core.js"></script>
</body>
</html>
<?php
	}
	mysql_close($dbhandle);
}
?>