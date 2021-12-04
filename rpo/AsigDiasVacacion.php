<?
require("config.inc.php");
require("functions.inc.php");
require("database.class.php");

function DiasVacacionCAS($id_func)
{
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();

//echo "select * from ".TABLE2.", ".TABLE22." WHERE ".TABLE2.".id_func=".TABLE22.".id_func and  ".TABLE22.".status='1'";

$rs=$db->query("select * from ".TABLE2.", ".TABLE22." WHERE ".TABLE2.".id_func=".TABLE22.".id_func and  ".TABLE22.".status='1' and ".TABLE22.".id_func='$id_func'");

//$rs=$db->query("select * from ".TABLE2." where  f_status='1' and id='$id_funcionario' order by l_name1 asc");
echo mysql_num_rows($rs);
//echo '<table border="1">';
while ($r=$db->fetch_array($rs))
{	
	//echo $r[l_name1]." ".$r[l_name2]." ".$r[name]." ";
	//echo "<br>select * from ".TABLE24." where id_per=$r[id_per]<br><br>";
	$rs2=$db->query("select * from ".TABLE24." where id_per='$r[id_per]'");
	echo mysql_num_rows($rs2);
	//echo '<tr>';
	//echo "<td>".$r[name]." ".$r[l_name1]." ".$r[l_name2]." </td>";
	//echo "<td>".$r[l_name1]." ".$r[l_name2]." ".$r[name]." </td>";
	//echo "<td>".cambia_dateMy_to_dateN($r[fecha_ing])." </td>";			
	if ($r2=$db->fetch_array($rs2))
	{
		//1 año y 1 dia hasta 5 años = 15
		//5 año y 1 dia hasta 10 años = 20
		//10 año y 1 dia o mas = 30
		//echo "<td> | <strong>YEAR: ".$r2[year_rat]." | MONTH: ".$r2[month_rat]." | DAYS: ".$r2[day_rat]."</strong> ||</td><td>";
		if (($r2[year_rat]>=1 && $r2[month_rat]>=0 && $r2[day_ray]>=1)
		 ||	($r2[year_rat]>=1 && $r2[month_rat]>=1 && $r2[day_ray]=0)		 
		 || ($r2[year_rat]<=4 && $r2[year_rat]<=12 && $r2[day_rat]<=31))
		{
			$asigna=15.0;
			//echo "15 dias<br />";
			
		}
		else
		{
			if (($r2[year_rat]>=5 && $r2[month_rat]>=0 && $r2[day_ray]>=1) 
			 || ($r2[year_rat]>=5 && $r2[month_rat]>=1 && $r2[day_ray]=0) 
			 || ($r2[year_rat]<=9 && $r2[year_rat]<=12 && $r2[day_rat]<=31))
			{
				$asigna=20.0;
				//echo "20 dias<br />";			
			}
			else
			{
				if (($r2[year_rat]>=10 && $r2[month_rat]>=0 && $r2[day_ray]>=0)) 
				{
					$asigna=30.0;
					//echo "30 dias<br />";					
				}				
			}			
		}
	//echo "</td> </tr>";
	}
	else
	{
		//echo "<td>-</td>";
		$asigna=15.0;
		//echo "<td>15 dias.</td>";	
	}
}
//echo "</table>";
return($asigna);
}
?>