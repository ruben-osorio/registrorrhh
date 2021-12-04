<?
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();

$rs=$db->query("SELECT ".TABLE2.".id_func, ".TABLE2.".name, ".TABLE2.".l_name1, ".TABLE2.".l_name2, ".TABLE22.".id_per, ".TABLE22.".status, ".TABLE22.".date_ent
			FROM ".TABLE2.",".TABLE22."
			WHERE ".TABLE2.".id_func = ".TABLE22.".id_func
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
	<th >Ingreso</th>
	<th >Baja</th>
	<th >Estado</th>
	<th >Acciones</th>
</tr>';
//echo mysql_num_rows($rs);
while ($r=$db->fetch_array($rs))
{
	//echo "select * from ".TABLE35." where id_per='$r[id_per]'<br>";
	$rs1=$db->query("select date_efect from ".TABLE35." where id_per='$r[id_per]'");
	if ( mysql_num_rows($rs1)==1 )
	{
		$r1=$db->fetch_array($rs1);
		
		$rs2=$db->query("select * from ".TABLE23." where id_per='$r[id_per]' and date_des like '0000-00-00'");
		if ( $r2=$db->fetch_array($rs2))
		{
			echo ' <tr>   
			<td>'.$r[l_name1].'</td>
			<td>'.$r[l_name2].'</td>
			<td>'.$r[name].'</td>
			<td>'.cambia_dateMy_to_dateN($r[date_ent]).'</td>
			<td><strong>'.cambia_dateMy_to_dateN($r1[date_efect]).'</strong></td>
			<td><img src="data/images/Bad.png"><strong>[NO DESAFILIADO]</strong></td>';
			echo '<td><a href="#" onclick="MM_openBrWindow(\'RegDatosBaja.php?id='.$r[id_func].'&id_per='.$r[id_per].'\',\'regpermiso\',\'scrollbars=yes,width=600,height=420\')" title="Registrar Datos Seguro Médico">
			<img src="data/images/del_medical.png"></a></td>';
		}
	}
}
echo "</fieldset>";
?>