<?
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();

if (isset($_POST[to_excel]))
{
	include("excelwriter.inc.php");  
	$excel=new ExcelWriter("ListaPendientesCAJA.xls");
	if($excel==false) {   
			echo $excel->error;
	}								
	$myArr=array("AP. PATERNO","AP. MATERNO","NOMBRE(S)","FECHA INGRESO","ESTADO");
	$excel->writeLine($myArr);
				
	$rs=$db->query("SELECT ".TABLE2.".id_func, ".TABLE2.".name, ".TABLE2.".l_name1, ".TABLE2.".l_name2, ".TABLE22.".id_per, ".TABLE22.".status, ".TABLE22.".date_ent
			FROM ".TABLE2.",".TABLE22."
			WHERE ".TABLE2.".id_func = ".TABLE22.".id_func
			AND ".TABLE22.".status = '1'");
	while ($r=$db->fetch_array($rs))
	{		
		$rs2=$db->query("select id_sec from ".TABLE23." where id_per='$r[id_per]'");
		if (mysql_num_rows($rs2)==0)
		{
			$r2=$db->fetch_array($rs2);
			
			$excel->writeRow();
			$excel->writeCol($r[l_name1]);
			$excel->writeCol($r[l_name2]);
			$excel->writeCol($r[name]);
			$excel->writeCol(cambia_dateMy_to_dateN($r[date_ent]));
			$excel->writeCol("NO EXISTEN DATOS DE AFILIACION");			
		}
	}	
	$excel->close();
	echo "Los datos se han grabado con &eacute;xito.";
}


//$rs=$db->query("select * from ".TABLE2." where f_status='1' order by l_name1 asc, l_name2 asc");
			
$rs=$db->query("SELECT ".TABLE2.".id_func, ".TABLE2.".name, ".TABLE2.".l_name1, ".TABLE2.".l_name2, ".TABLE22.".id_per, ".TABLE22.".status, date_ent
			FROM ".TABLE2.",".TABLE22."
			WHERE ".TABLE2.".id_func = ".TABLE22.".id_func
			AND ".TABLE22.".status = '1'");

echo '<script type="text/javascript" src="js/scripts.js"></script>';
echo '<fieldset>
	<legend>Funcionarios Pendientes Afiliación/Regularización</legend>
	<div style="padding: 5px; ">
	<form id="form1" name="form1" method="post" action="" class="form">
  	<input type="submit" name="to_excel" id="save" class="submit" value="Exportar a Excel" />
	</form>
	</div>';
	$rs3=$db->query("select * from ".TABLE23."");	
	$total_pendientes=mysql_num_rows($rs)-mysql_num_rows($rs3);
	
	echo '<div class="red_alert"><strong>TOTAL NO AFILIADOS:'.$total_pendientes.'</strong> </div>';
	echo '<div class="table-wrap"><div class="table">	
	<table width="100%" border="0" cellpadding="5" cellspacing="0">
  <tr class="even">    
    <th>Ap.Paterno</th>	
    <th>Ap.Materno</th>
	<th >Nombre(s)</th>
	<th >Ingreso</th>
	<th >Estado</th>
	<th >Acciones</th>
</tr>';
 $c=0;
while ($r=$db->fetch_array($rs))
{
	//echo "select id_sec from ".TABLE23." where id_per='$r[id_per]'";
	$rs1=$db->query("select id_sec from ".TABLE23." where id_per='$r[id_per]'");
	//echo mysql_num_rows($rs1)."<br>";
	if (mysql_num_rows($rs1)==0)
	{
		$r1=$db->fetch_array($rs1);
		echo ' <tr>   
    	<td>'.$r[l_name1].'</td>
    	<td>'.$r[l_name2].'</td>
	 	<td>'.$r[name].'</td>
	  	<td>'.$r[date_ent].'</td>
		<td><img src="data/images/Bad.png"><strong>[NO AFILIADO]</strong></td>';
	  	echo '<td><a href="#" onclick="MM_openBrWindow(\'RegDatosAfiliacion.php?id='.$r[id_func].'\',\'regpermiso\',\'scrollbars=yes,width=600,height=420\')" title="Registrar Datos Seguro Médico"><img src="data/images/add_medical.png"></a></td>';
		$c++;
	}
	
}
 echo'
 </div></div>
</table>
	</fieldset>';
?>