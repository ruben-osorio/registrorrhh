<?
include ("config.inc.php");
include ("database.class.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
$rs=$db->query("select * from ".TABLE2." order by id");
while ($r=$db->fetch_array($rs))
{
	//echo "insert into ".TABLE22." (id_func, date_ent, status) values ('$r[id]','$r[fecha_ing]','$r[f_status]')<br />";	
	$rs2=$db->query("select id_per,id_func from ".TABLE22." where id_func='$r[id]' ");
	$r2=$db->fetch_array($rs2);
	
	//if ($r2=$db->fetch_array($rs2))
	//{
		
		$id_per=$r2[id_per];
		//echo "update ".TABLE23." set id_per='$r2[id_per]'
		//where id_func='$r2[id_func]'<br />";
		$rs3=$db->query("update ".TABLE35." set id_per='$r2[id_per]'
		where id_func='$r2[id_func]'");
		//id_per, charge	date_des
		//echo "insert into ".TABLE28." (id_per, charge, date_des) 
		//values('$r2[id_per]', '$r[office]', '$r[fecha_ing]')<br />";
		//$rs1=$db->query("insert into ".TABLE28." (id_per, charge, date_des) 
		//values('$r2[id_per]', '$r[office]', '$r[fecha_ing]')");	
		//id_per	source_fin	ag_fin	prog_cat	org_unit	dep_bud	item		
		//echo "insert into ".TABLE15." (id_per, source_fin) 
		//values('$r2[id_per]', '$r[source_fin]')<br />";
		//$rs1=$db->query("insert into ".TABLE15." (id_per, source_fin) 
		//values('$r2[id_per]', '$r[source_fin]')");	
		/*//======================================================================
		$rs3=$db->query("select * from ".TABLE28." where id_per='$r2[id_per]'");
		$r3=$db->fetch_array($rs3);		
		//======================================================================
		$rs4=$db->query("select * from ".TABLE15." where id_per='$r2[id_per]'");
		$r4=$db->fetch_array($rs4);
		//======================================================================		
		echo "NOMBRE(S): ".$r[name]." "." ".$r[l_name1]." ".$r[l_name_2]."<br />";
		echo "FECHA INGRESO:".$r2[date_ent]." STATUS: ".$r2[status]."<br />";
		echo "CARGO: ".$r3[charge]."<br />";
		echo "FUENTE FIN: ".$r4[source_fin];
		echo "<br />===============================================<br />";*/
		
	//}	
}
?>