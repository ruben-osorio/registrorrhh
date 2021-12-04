<?
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();

if(isset($_POST[submit]))
{
	$date_1=$_POST[date_1];
	$mes_1=$_POST[mes];
	$date_2=$_POST[date_2];
	$mes_2=$_POST[mes2];	
	$rs=$db->query("select *, day(date_ent) AS diai	from funcionario ,permanente where permanente.id_func=funcionario.id_func AND permanente.status='1'order by diai DESC" );	
	
	//$rs=$db->query("select * from funcionario ,permanente where permanente.id_func=funcionario.id_func AND permanente.status='1' order by permanente.date_ent, funcionario.l_name1 asc" );	
	
	if (mysql_num_rows($rs)!=0)
	{
		$sw=1;
	}

/*	$rs=$db->query("select * from ".TABLE2.",".TABLE22." 
	where ".TABLE22.".id_func=".TABLE2.".id_func AND 
	".TABLE22.".status='1' AND
	".TABLE22.".date_ent BETWEEN '$date1' AND '$date1'	
	order by ".TABLE2.".l_name1 asc");
	echo mysql_num_rows($rs);
*/
}
?>
<link rel="stylesheet" type="text/css" media="screen" href="data/css/screen.css" />
<link rel="stylesheet" type="text/css" media="screen" href="data/css/reportes.css" />
<script src="data/js/jquery-1.7.1.min.js"></script>
<script src="data/js/jquery.metadata.js" type="text/javascript"></script>
<script src="data/js/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">
$.metadata.setType("attr", "validate");
$(document).ready(function() {
	$("#form1").validate();	
});
</script>

<!--<link rel="stylesheet" href="data/css/ui/admincp/jquery-ui-1.8.17.custom.css">-->
<!--<link rel="stylesheet" href="../../themes/base/jquery.ui.all.css">-->
<!--<script src="data/js/jquery-1.7.1.min.js"></script>-->

<script src="data/js/ui/jquery.ui.core.js"></script>
<script src="data/js/ui/jquery.ui.widget.js"></script>
<script src="data/js/ui/jquery.ui.datepicker.js"></script>
<script>
$(function() {
	$( ".datepick" ).datepicker({
		showOn: "button",
		buttonImage: "data/images/calendar.gif",
		buttonImageOnly: true, changeMonth: true, changeYear: true, yearRange: '-100:+0',
	});
	});
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>

<form name="form1" method="post" action="" class="form">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td >Fecha Inicial</td>
  <td ><label for="date_1">Dia</label>
   <input name="date_1" type="text" class="textarea_normal required" id="date_1" size="3">
   <label for="mes">Mes</label>
   <select name="mes" id="mes">
    <option value="01">Enero</option>
    <option value="02">Febrero</option>
    <option value="03">Marzo</option>
    <option value="04">Abril</option>
    <option value="05">Mayo</option>
    <option value="06">Junio</option>
    <option value="07">Julio</option>
    <option value="08">Agosto</option>
    <option value="09">Septiembre</option>
    <option value="10">Octubre</option>
    <option value="11">Noviembre</option>
    <option value="12">Diciembre</option>
   </select></td>
  <td >Fecha Final</td>
  <td >
  	<label for="date_2">Dia</label>
   <input name="date_2" type="text" class="textarea_normal required" id="date_2" size="3">
   <label for="mes2">Mes</label>
   <select name="mes2" id="mes2">
    <option value="01">Enero</option>
    <option value="02">Febrero</option>
    <option value="03">Marzo</option>
    <option value="04">Abril</option>
    <option value="05">Mayo</option>
    <option value="06">Junio</option>
    <option value="07">Julio</option>
    <option value="08">Agosto</option>
    <option value="09">Septiembre</option>
    <option value="10">Octubre</option>
    <option value="11">Noviembre</option>
    <option value="12">Diciembre</option>
   </select></td>
   
  <td >
   <input type="submit" name="submit" id="submit" value="Obtener" class="submit"></td>
 </tr>
</table>
</form>
<?
if ($sw==1)
{
	echo '<br><table width="100%" border="0" cellspacing="0" cellpadding="0">';
	while ($r=$db->fetch_array($rs))
	{	
		$fecha_ing=explode("-",$r[date_ent]);
		$year=$fecha_ing[0];
		$mes=$fecha_ing[1];
		$dia=$fecha_ing[2];
		
		$id_per=$r[id_per];
		$id_func=$r[id_func];	
		if ($mes>=$mes_1 && $mes<=$mes_2 && $year!="2013")
		{
			echo "<tr>
			<td>".$r[id_func]."</td>
			<td>".$c."</td>
			<td>".$r[l_name1]." ".$r[l_name2]." ".$r[name]."</td>
			<td><strong>".$dia."-".$mes."-".$year."</strong></td>";
			$rs1=$db->query("select * from vacaciones where id_per='$id_per'");
			$r1=$db->fetch_array($rs1);
			echo "<td>".$r1[gestion_1].": ".$r1[dias_g1]."<br />".$r1[gestion_2].": ".$r1[dias_g2]."</td>";
			echo '<td><a href="#" onclick="MM_openBrWindow(\'AsignGestVac.php?id='.$r[id_func].'\',\'___\',\'scrollbars=yes,width=620,height=500\')" title="Asignar Nueva Gestión"><img src="data/images/add_vac.png"></a></td>';
		}
	}
	echo "</table>";
}
?>

