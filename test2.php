<?
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
//$rs=$db->query("select id,fecha_ing,l_name1,l_name2,name from ".TABLE2." order by l_name1");
//echo "select * from ".TABLE2.",".TABLE22." where ".TABLE22.".id_func=".TABLE2.".id_func AND ".TABLE22.".status='1' order by ".TABLE2.".l_name1 asc";
$rs=$db->query("select * from ".TABLE2.",".TABLE22." where ".TABLE22.".id_func=".TABLE2.".id_func AND ".TABLE22.".status='1' order by ".TABLE2.".l_name1 asc");
$f=0;
echo "<br>total filas: ".mysql_num_rows($rs)."<br>";

/*while ($r=$db->fetch_array($rs))
{
echo "<pre>";
print_r($r);
echo "</pre>";
}
*///echo mysql_num_rows($rs);
while ($r=$db->fetch_array($rs))
{
	//echo $r[id_func]."[".$r[date_ent]."]<br />";
	//echo "<pre>"; print_r($r); echo "</pre>";

	$fecha_ingreso=explode("-",$r[date_ent]);
	$mes_ingreso=$fecha_ingreso[1];
	$dia_ingreso=$fecha_ingreso[2];
	$aaaa_ingreso=$fecha_ingreso[0];	
	$fecha_inicio="2012-06-01";	
	$c=1;
	$id_per=$r[id_per];
	while ($c <= 120)
	{
		$fecha_inicio= date("Y-m-d", strtotime("$fecha_inicio + 1 days"));
		$fecha_inicio_comp=explode("-",$fecha_inicio);
		$mes_comp=$fecha_inicio_comp[1];
		$dia_comp=$fecha_inicio_comp[2];
		if ($mes_ingreso===$mes_comp AND $dia_ingreso===$dia_comp AND $aaaa_ingreso!='2012')
		{
			echo "<strong>[$r[id]] $r[l_name1] $r[l_name2] $r[name] </strong><br />
			fecha ingreso: ".$r[date_ent]."<br />
			fecha nueva  : 2012-".$mes_ingreso."-".$dia_ingreso;
			$rs1=$db->query("select * from ".TABLE3." where id_per='$id_per'");
			//$rs1=$db->query("select * from ".TABLE3." where id_funcionario='$r[id]'");
			$r1=$db->fetch_array($rs1);
			echo "<br />Gestion 1: ".$r1[gestion_1]." - ".$r1[dias_g1]."<br />Gestion 2: ".$r1[gestion_2]." - ".$r1[dias_g2];
			echo "<br />=================<br />";
			$f++;
		}
	$c++;
	}
}
echo "total: ".$f;
?>