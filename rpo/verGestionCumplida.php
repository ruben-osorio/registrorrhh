<?
require("config.inc.php");
require("AsigDiasVacacion.php");
//require("database.class.php");
//require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
$sw=0;

$rs=$db->query("select * from ".TABLE2.",".TABLE22." where ".TABLE22.".id_func=".TABLE2.".id_func AND ".TABLE22.".status='1' order by ".TABLE2.".l_name1 asc");
$c=1;

if ($_POST[submit])
{
	$sw=1;
}
echo '<div class="table-wrap"><div class="table-wrap">
	<div class="table">	
		<table width="100%" border="0" cellpadding="5" cellspacing="0">';
while ($r=$db->fetch_array($rs))
{
	$fecha_ing=explode("-",$r[date_ent]);
	$year=$fecha_ing[0];
	$mes=$fecha_ing[1];
	$dia=$fecha_ing[2];
	$id_per=$r[id_per];
	$id_func=$r[id_func];
	
	if ($mes>="09" && $mes<="11" && $year!="2012")
	{
		echo "<tr>
			<td>".$r[id_func]."</td>
			<td>".$c."</td>
			<td>".$r[l_name1]." ".$r[l_name2]." ".$r[name]."</td>
			<td><strong>".$dia."-".$mes."-".$year."</strong></td>";
		//echo "select * from ".TABLE3." where id_funcionario='$r[id]'<br />";
		$rs1=$db->query("select * from ".TABLE3." where id_per='$id_per'");
		$r1=$db->fetch_array($rs1);
		echo "<td>".$r1[gestion_1].": ".$r1[dias_g1]."<br />".$r1[gestion_2].": ".$r1[dias_g2]."</td>";
		//if (($r1[gestion_1]=="2011-2012" && $r1[dias_g1]==0)||($r1[gestion_2]=="2011-2012" && $r1[dias_g2]==0))
		if (($r1[gestion_1]=="2010-2011" && $r1[gestion_2]==""))
		{
			echo "<td>No tiene gestion 2012</td>";
			//echo "update ".TABLE3." set $r1[gestion_1]='15.0' where id_funcionario='$r[id]'<br />";
			//$rs2=$db->query( "update ".TABLE3." set dias_g1='15.0' where id_funcionario='$r[id]'");			
		}
		//if (($r1[gestion_1]=="2009-2010")||($r1[gestion_2]=="2010-2011"))
		if (($r1[gestion_1]=="2010-2011")&&($r1[gestion_2]==""))
		{
			echo "<td>No tiene gestion 2012</td>";
			echo "<td>CORRESPONDE: ".DiasVacacionCAS($r[id])."</td>";
			echo "<td>GESTION A ARCHIVAR: ".$r1[gestion_1]." (".$r1[dias_g1].")<br />";
			$new_days_g2=DiasVacacionCAS($id_func);
			$to_store_g=$r1[gestion_1];
			$to_store_days_g=$r1[dias_g1];
			
			$new_g1=$r1[gestion_2];
			$new_days_g1=$r1[dias_g2];			
			echo "<br />G1: ".$new_g1." ";
			echo "(".$new_days_g1.")<br />";
			if ($sw==1)
			{
				//echo "update ".TABLE3." set gestion_1='$new_g1', dias_g1='$new_days_g1', gestion_2='2011-2012', dias_g2='$new_days_g2', stored_vac='$to_store_g-$to_store_days_g'  where id_funcionario='$r[id]' ";			
				//echo "update ".TABLE3." set gestion_2='2011-2012', dias_g2='$new_days_g2' where id_per='$id_per' ";
				//*******echo "update ".TABLE3." set gestion_1='$new_g1', dias_g1='$new_days_g1', gestion_2='2011-2012', dias_g2='$new_days_g2', stored_vac='$to_store_g-$to_store_days_g'  where id_per='$id_per'";

				//-------- consulta que actualiza nueva gestion ganada---------////////
				$rsAUX=$db->query("update ".TABLE3." set gestion_2='2011-2012', dias_g2='$new_days_g2' where id_per='$r[id_per]' ");
				//-------- consulta que actualiza nueva gestion ganada---------////////
				
				//-------- consulta que actualiza nueva gestión ganada y archiva la anterior---------////////
				//$rsAUX=$db->query("update ".TABLE3." set gestion_1='$new_g1', dias_g1='$new_days_g1', gestion_2='2011-2012', dias_g2='$new_days_g2', stored_vac='$to_store_g-$to_store_days_g;' where id_per='$id_per'");
				//-------- consulta que actualiza nueva gestión ganada y archiva la anterior---------////////
				
			//echo "update ".TABLE3." set $r1[gestion_1]='15.0' where id_funcionario='$r[id]'<br />";
			//$rs2=$db->query( "update ".TABLE3." set dias_g1='15.0' where id_funcionario='$r[id]'");
			
			}
			
			echo "</td>";						
		}		
		echo "<td><input type='checkbox'></td>";
		$c++;
		echo "</tr>";
	}	
}
echo "</table></div></div></div>";
?>
<form name="form1" method="post" action="" class="form">
  <input type="submit" name="submit" id="submit" value="Enviar" class="submit">
</form>