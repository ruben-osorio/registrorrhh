<?
require_once("security.php");
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();

$id_func=$_GET[id_func];
$id_per=$_GET[id_per];
$rs=$db->query("
	SELECT * FROM ".TABLE2."
	WHERE funcionario.id_func='$id_func'
	");

$rs1=$db->query("
	SELECT charge, date_des, date_end FROM char_per
	WHERE id_per='$id_per'
	AND date_end='0000-00-00'
	");
	
$r=$db->fetch_array($rs);	
$r1=$db->fetch_array($rs1);			

if ($rs&& mysql_num_rows($rs1)>0)
{

}
else
{	
	echo '<link href="css/reportes.css" rel="stylesheet" type="text/css" />';
	echo '<div class="errorre"><h1>OPERACION NO PERMITIDA!!!</h1></div>';	
	exit();
}		
		

if (isset($_POST[save]))	{	
				$date_end=cambia_dateN_to_dateMy_1($_POST[date_end]);	
				$dir_g=strtoupper($_POST[dir_g]);
				$unit=strtoupper($_POST[unit]);
				$area=strtoupper($_POST[area]); 
				$boss_is=strtoupper($_POST[boss_is]); 
				$boss_ij=strtoupper($_POST[boss_ij]);  
				$charge=strtoupper($_POST[charge]);  
				$num_memo=$_POST[num_memo];  
				$date_des=cambia_dateN_to_dateMy_1($_POST[date_des]);		
				$rs3=$db->query("
				UPDATE ".TABLE28."
				SET date_end='$date_end'
				WHERE id_per='$id_per'
				AND date_end='0000-00-00'
				");		
				$rs4=$db->query("
				INSERT INTO ".TABLE28."
				(id_per,dir_g, unit, area, boss_is, boss_ij, charge, num_memo, date_des)
				VALUES				
				('$id_per','$dir_g', '$unit', '$area', '$boss_is', '$boss_ij', '$charge', '$num_memo', '$date_des')
				");		
				
//dir_g unit area boss_is boss_ij charge num_memo date_des						
				if ($rs3&&$rs4)
				{
					$msg="Datos actualizados Exitosamente!!!";
					$sw=1;
				}
				else
				{
					$msg="Hubo un Error al ejecutar la operación.";
					$sw=2;
				}					
}				
					
/*SELECT * FROM ".TABLE22." 
				WHERE	id_per='id_per' 
				AND 	id_fun='$id_func'*/


?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es-es" lang="es-es" dir="ltr" >
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="data/css/style-ext.css" rel="stylesheet" type="text/css">
<link href="css/reportes.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="data/css/ui/admincp/jquery-ui-1.8.17.custom.css">
<link rel="stylesheet" href="../../themes/base/jquery.ui.all.css">
	<script src="data/js/jquery-1.7.1.min.js"></script>
	<script src="data/js/ui/jquery.ui.core.js"></script>
	<script src="data/js/ui/jquery.ui.widget.js"></script>
	<script src="data/js/ui/jquery.ui.datepicker.js"></script>
	<link rel="stylesheet" href="../demos.css">
	<script>
	$(function() {
		$( ".datepick" ).datepicker({
			showOn: "button",
			buttonImage: "data/images/calendar.gif",
			buttonImageOnly: true
		});		
	});
	</script>

<?
if ($sw==1)
	{
		echo '<div class="successre">'.$msg.'</div>';
	}
	if ($sw==2)
	{
		echo '<div class="errorre">'.$msg.'</div>';
	}
?>

<fieldset>
<legend>Registro Movilidad de Funcionario

</legend><form id="form1" name="form1" method="post" action="" class="form" novalidate>
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr>
      <th><div align="left">Nombres:</div></th>
      <td><div class="form_row">  
       <? echo $r[name]; ?>
    
      </div></td>
    </tr>
    <tr>
      <th><div align="left">Apellido Paterno:</div></th>
      <td><div class="form_row">
       <? echo $r[l_name1]; ?>
      </div></td>
    </tr>
    <tr>
      <th><div align="left">Apellido Materno:</div></th>
      <td><div class="form_row">
       <? echo $r[l_name2]; ?>
      </div></td>
    </tr>
<tr>
      <th><div align="left">Cargo Desempeñado:</div></th>
      <td><div class="form_row">
        <? echo $r1[charge]; ?>
      </div></td>
    </tr>
 <tr>
      <th><div align="left">Fecha Designaci&oacute;n:</div></th>
      <td><div class="form_row">
       <? echo $r1[date_des]; ?>
      </div></td>
    </tr>   
      <tr>
      <th><div align="left">Fecha Finalizaci&oacute;n:</div></th>
      <td><div class="form_row">
        <input type="text" name="date_end" id="date_end" class="datepick" />
      </div></td>
    </tr>
  </table>            
</fieldset>
<fieldset>
<legend>DATOS DEL NUEVO CARGO
</legend>
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr>
      <th><div align="left">Direcci&oacute;n General:</div></th>
      <td><div class="form_row">  
        
		
		<?
		$query = "SELECT id_dg, desc_dg from direccion_gral order by desc_dg ASC";
		
		$link = mysql_connect('localhost', 'registroRRHH', 'Registro4880!');
		if (!$link) {
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db('registrorrhh');

		$res = mysql_query($query, $link);
		echo "<select name='dir_g' id='dir_g' style='width:300px'>";
		while (($row = mysql_fetch_row($res)) != null)
		{
			echo "<option value = '{$row[0]}'";
		    echo ">{$row[1]}</option>";
		}
		echo "</select>";
		mysql_close($link);
		?>
		
		
		
     </div></td>
    
      </div></td>
    </tr>
    <tr>
      <th><div align="left">Unidad:</div></th>
      <td><div class="form_row">
        <?
		$query = "SELECT id_dg, desc_uni from unidad order by desc_uni ASC";
		
		$link = mysql_connect('localhost', 'registroRRHH', 'Registro4880!');
		if (!$link) {
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db('registrorrhh');

		$res = mysql_query($query, $link); 
		echo "<select name='unidad' id='unidad' style='width:300px'>";
		while (($row = mysql_fetch_row($res)) != null)
		{
			$cad = $row[1] ;
			echo "<option value = '{$row[0]}'";
		    echo ">{$cad}</option>";
			
		}
		echo "</select>";
		mysql_close($link);
		?>
     </div></td>
    </tr>
    <tr>
      <th><div align="left">Area:</div></th>
      <td><div class="form_row">
        
         <?
		$query = "SELECT id_dg, desc_area from area order by desc_area ASC";
		
		$link = mysql_connect('localhost', 'registroRRHH', 'Registro4880!');
		if (!$link) {
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db('registrorrhh');

		$res = mysql_query($query, $link); 
		echo "<select name='area' id='area' style='width:300px'>";
		while (($row = mysql_fetch_row($res)) != null)
		{
			echo "<option value = '{$row[0]}'";
		    echo ">{$row[1]}</option>";
		}
		echo "</select>";
		mysql_close($link);
		?>
         
      </div></td>
    </tr>
<tr>
      <th><div align="left">Jefe Inmediato Superior:</div></th>
      <td><div class="form_row">
		 <input name="boss_is" type="text" class="input " id="boss_is" size="40" />
      </div></td>
    </tr>
 <tr>
      <th><div align="left">Jefe Jer&aacute;rquico Superior</div></th>
      <td><div class="form_row">
		 <input name="boss_ij" type="text" class="input " id="boss_ij" size="40" />
      </div></td>
    </tr>   
      <tr>
      <th><div align="left">Cargo:</div></th>
      <td><div class="form_row">
		 <input name="charge" type="text" class="input " id="charge" size="40" />
      </div></td>
          </tr>  
            <th><div align="left">N&uacute;mero de Resoluci&oacute;n o Memo:</div></th>
      <td><div class="form_row">
 		<input name="num_memo" type="text" class="input " id="lname_2" size="40" />	
      </div></td>
          </tr>  
       		<th><div align="left">Fecha de Inicio:</div></th>
      <td><div class="form_row">
        <input type="text" name="date_des" id="date_des" class="datepick" />
      </div></td>
    </tr>
        <tr>
      <td><div align="left"></div></td>
      <td>
        <div align="left"><label></label>
          <input type="submit" name="save" class="submit" id="loginbutton" value="Guardar" />
        </div>
      </td>
    </tr>
  </table>
</form>
</fieldset>