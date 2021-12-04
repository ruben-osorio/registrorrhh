<?

require_once("security.php");
require ("config.inc.php");
require ("database.class.php");
require ("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
$id_func=$_GET[id];

$rs=$db->query("select id_per from ".TABLE2.",".TABLE22." where ".TABLE2.".id_func=".TABLE22.".id_func and ".TABLE22.".status='0' and ".TABLE22.".id_func='$id_func'");
$r=$db->fetch_array($rs);
$id_per=$r[id_per];

$rs2=$db->query("select * from ".TABLE35." where id_per='$id_per'");
//echo mysql_num_rows($rs2);
	
if (mysql_num_rows($rs)==0)
{
	echo "<h1>OPERACION NO PERMITIDA</h1>";
}
if (mysql_num_rows($rs2)==0)
{
	echo "<h1>NO SE PUEDE COMPLETAR LA OPERACION, FUNCIONARIO SIGUE TRABAJANDO.</h1>";
}

$rs10=$db->query("select * from ".TABLE2.",".TABLE22." where ".TABLE2.".id_func=".TABLE22.".id_func and ".TABLE22.".status='0' and ".TABLE22.".id_func='$id_func'");

$rs20=$db->query("select * from ".TABLE35." where id_per='$id_per'");
/*echo mysql_num_rows($rs);
echo mysql_num_rows($rs2);*/
if (($r10=$db->fetch_array($rs10)) && ($r20=$db->fetch_array($rs20)))
{
	
	//print_r($r10);
	//print_r($r20);
	//print_r($r2);
	$id_per=$r10[id_per];	 
	if (isset($_POST[save]))	
	{
		//
		$cause_b=strtoupper($_POST[cause_b]);
		$date_down=date("Y-m-d",time());
		$date_des=cambia_dateN_to_dateMy_1($_POST[date_des]);		
		$rs5=$db->query("update ".TABLE23." set date_des='$date_des', cause='$_POST[cause_b]' where id_per='$id_per'");
		/*$rs1=$db->query("update ".TABLE9." set date_des='$date_down',cause='$cause_b' where id_per='$id'");*/
		if ($rs5)
			{
				$msg="Exito, Operación ejecutada correctamente.";
				$sw=1;	
			}
			else
			{
				$msg="Error al ejecutar la operación, intente nuevamente.";
				$sw=2;
			}	
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="data/css/style-ext.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="screen" href="data/css/screen.css" />
<script src="data/js/jquery-1.7.1.min.js"></script>
<script src="data/js/jquery.metadata.js" type="text/javascript"></script>
<script src="data/js/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">
$.metadata.setType("attr", "validate");
$(document).ready(function() {
	$("#form1").validate();	
});
</script>
<link rel="stylesheet" href="data/css/ui/admincp/jquery-ui-1.8.17.custom.css">
<link href="data/css/style-ext.css" rel="stylesheet" type="text/css" />
<link href="data/css/reportes.css" rel="stylesheet" type="text/css" />
<!--<script src="data/js/jquery-1.7.1.min.js"></script>-->
<script src="data/js/ui/jquery.ui.core.js"></script>
<script src="data/js/ui/jquery.ui.widget.js"></script>
<script src="data/js/ui/jquery.ui.datepicker.js"></script>
<script>
	$(function() {
		$( ".date_pick" ).datepicker({
			showOn: "button",
			changeMonth: true,
			changeYear: true,
			yearRange: "1920:2015",
			buttonImage: "data/images/calendar.gif",
			buttonImageOnly: true
		});		
	});
	</script>

</head>
<?
if ($sw==1)
{
	echo '<div class="successre">'.$msg.'</div>';
	exit;
}
if ($sw==2)
{
	echo '<div class="errorre">'.$msg.'</div>';
	exit;
}
?>
<body>
<fieldset>
<legend>Registrar Datos Desafiliación Seguro</legend>
<form id="form1" name="form1" method="post" action="">
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr>
      <th width="46%"><div align="left">Nombres:</div></td>
      <td width="54%"><div align="left"><strong><? echo $r10[name]; ?></strong></div></td>
    </tr>
    <tr>
      <th><div align="left">Apellidos:</div></td>
      <td><div align="left"><strong><? echo $r10[l_name1]." ".$r10[l_name2]; ?></strong></div></td>
    </tr>
    <tr>
      <th><div align="left">Cargo:</div></td>
      <?	  
	  $rs4=$db->query("select * from ".TABLE28." where id_per='$id_per'");
	  $r4=$db->fetch_array($rs4);
	  ?>
      <td><div align="left"><strong><? echo $r4[charge]; ?></strong></div></td>
    </tr>
    <tr>
      <th><div align="left">Fecha de Ingreso:</div></td>
      <td><div align="left"><strong><? echo cambia_dateMy_to_dateN($r10[date_ent]); ?></strong></div></td>
    </tr>
    <?
	$rs3=$db->query("select * from ".TABLE23." where id_per='$id_per'");
	$r3=$db->fetch_array($rs3);
    ?>
    <tr>
      <th><div align="left">Nombre Seguro:</div></td>
      <td><div align="left">        
        <? echo $r3[name_sec]; ?>
      </div></td>
    </tr>
    <tr>
      <th><div align="left">Número Asegurado:</div></td>
      <td><div align="left"><? echo $r3[num_reg]; ?></div></td>
    </tr>
    <tr>
      <th><div align="left">Fecha Afiliación:</div></td>
      <td><div align="left"><? echo cambia_dateMy_to_dateN($r3[date_afil]); ?>
      </div></td>
    </tr>
    <tr>
      <th><div align="left">Fecha de Baja en el Trabajo:</div></td>
      <?
	  
	  //id_func	id_per	date_pres	date_efet	reasone	comment	  	   	
	  $rs20=$db->query("select * from ".TABLE35." where id_per='$id_per'");
	  $r20=$db->fetch_array($rs20);	  	  
      ?>
      <td><div align="left">
        <input type="text" name="date_desac" id="date_desac" value="<? echo cambia_dateMy_to_dateN($r20[date_efect]);?>" readonly="readonly" />
        </div></td>
    </tr>
    <tr>    
    <th><div align="left">Fecha de Baja del Seguro Social:</div></td>
      <td><div align="left">
        <input type="text" name="date_des" id="date_des" class="date_pick"/>
        </div></td>
     </tr>
    
    <tr>
      <th><div align="left">Motivo de la Baja:</div></td>
      <td><div align="left"> 
       <label for="textfield"></label>
       <input name="cause_b" type="text" id="cause_b" value="<? echo strtoupper($r20[reasone]);?>" readonly="readonly"/>   
     </div></td>
    </tr>
    <tr>
      <td><div align="left"></div></td>
      <td><div align="left">
        <input type="submit" name="save" id="save" value="Efectivizar Baja" />
      </div></td>
    </tr>
  </table>
</form>
</fieldset>
</body>
<?
}
$db->close();
?>