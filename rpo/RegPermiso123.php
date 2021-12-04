<?
require("config.inc.php");
require("functions.inc.php");
require("database.class.php");

$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
$id_func=$_GET[id];
if (isset($_GET[id]))
{
	$rs=$db->query("select * from ".TABLE2." where id_func='$id_func'");
	$r=$db->fetch_array($rs);	

	$rs4=$db->query("select * from ".TABLE22." WHERE id_func='$id_func' order by id_per desc limit 1");
	$r4=$db->fetch_array($rs4);
	$id_per=$r4[id_per];
		
	if (isset($_POST[save]) || isset($_POST[save_i]))	
	{
		$p_dias=$_POST[tiempo_1]+$_POST[tiempo_2];
		//echo "pide: ".$p_dias."<br />";
		$rs1=$db->query("select dias_g1, dias_g2 from ".TABLE3." where id_per='$id_per'");
		$r1=$db->fetch_array($rs1);
		$f_dias=$r1[dias_g1]+$r1[dias_g2];
		//echo "saldo dias total ".$f_dias."<br />";
		if ($f_dias>=$p_dias)
		{
			if ($r1[dias_g1]>=$p_dias)
			{
				$saldo_g1=$r1[dias_g1]-$p_dias;
				$saldo_g2=$r1[dias_g2];
/*				echo "gestion 1: ".$saldo_g1."<br />"; //afecta solo a gestion 1
				echo "gestion 2: ".$saldo_g2;*/
			}
			else
			{
				$saldo_g1=0;				
				$nuevos_dias=$r1[dias_g1]-$p_dias;				
				$saldo_g2=$r1[dias_g2]+$nuevos_dias;
/*				echo "gestion 1: ".$saldo_g1."<br />";
				echo "gestion 2: ".$saldo_g2;	*/			
			}
			
			$rs2=$db->query("update ".TABLE3." SET dias_g1='$saldo_g1', dias_g2='$saldo_g2' where id_per='$id_per'");
			//id_user	tipo	tiempo	fecha_i	hrs_i	fecha_f	hrs_f
			$tipo=$_POST[tipo];
			
			$fecha_i=$_POST[fecha_i];
			//05-07-2012
			$fecha_ii=cambia_dateN_to_dateMy_1($_POST[fecha_i]);
			$hrs_i=$_POST[hrs_i];
			
			$fecha_f=$_POST[fecha_f];
			$fecha_ff=cambia_dateN_to_dateMy_1($_POST[fecha_f]);
			$hrs_f=$_POST[hrs_f];
			$obs=$_POST[obs];
			//id_user	tipo	tiempo	fecha_i	fecha_ii	hrs_i	fecha_f	fecha_ff	hrs_f	obs
									
			$rs3=$db->query("insert into ".TABLE5." (id_user,id_per,tipo,tiempo,fecha_i,fecha_ii,hrs_i,fecha_f,fecha_ff,hrs_f, obs) 
			values ('$id_fun','$id_per', '$tipo', '$p_dias', '$fecha_i','$fecha_ii', '$hrs_i', '$fecha_f','$fecha_ff', '$hrs_f', '$obs') ");
			
			if ($rs2)
			{
				if (isset($_POST[save]))
				{
					echo "<script>
					window.opener.location.reload();
					window.close();
					 </script>";
				}
				else
				{
					$msg="Operación Exitosa.";
					$sw=1;
				}				
			}
			else
			{
				$msg="Error al efectuar la operación.";
				$sw=1;
			}
		}
		else
		{
			$msg="Imposible completar la operación, no tiene sufucientes días vacacion a favor";
			$sw=1;
		}
	}
	if ($_POST[calculate])
	{
		$fecha_i=$_POST[fecha_i];
		$fecha_f=$_POST[fecha_f];
		$hrs_i=$_POST[hrs_i];
		$hrs_f=$_POST[hrs_f];
		
		if ($fecha_i==$fecha_f)
		{			
			switch (horasEntreHoras($hrs_i, $hrs_f))
			{
				case '04:00:00':
					$dias_to=0.5;
				break;
				
				case '10:00:00':
					$dias_to=1;
				break;
			}
		}
		else
		{			
			$dias_ba=diasEntreFechas($fecha_i, $fecha_f);
			//cambia_dateN_to_dateMy_1
			$dias_ba=$dias_ba-contarDiasFinde(cambia_dateN_to_dateMy_1($fecha_i),cambia_dateN_to_dateMy_1($fecha_f));
			if ($hrs_i==='08:30')
			{				
				switch ($hrs_f)
				{
					case '12:30':
						$dias_to=$dias_ba+0.5;
					break;
					
					case '18:30':
						$dias_to=$dias_ba+1;
					break;
				}
			}
			if ($hrs_i==='14:30')
			{
				switch ($hrs_f)
				{
					case '12:30':
						$dias_to=$dias_ba+0.5-0.5;
					break;
					
					case '18:30':
						$dias_to=$dias_ba+1-0.5;
					break;
				}
			}
		}
		//echo "total dias: ".$dias_to;		
	}
	if ($sw==1)
	{
		echo '<div class="alert success">'.$msg.'</div>';
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="data/css/style-ext.css" rel="stylesheet" type="text/css">

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

<link rel="stylesheet" href="data/css/ui/admincp/jquery-ui-1.8.17.custom.css">
<link rel="stylesheet" href="../../themes/base/jquery.ui.all.css">

	<script src="data/js/ui/jquery.ui.core.js"></script>
	<script src="data/js/ui/jquery.ui.widget.js"></script>
	<script src="data/js/ui/jquery.ui.datepicker.js"></script>
	<link rel="stylesheet" href="../demos.css">
	<script>
	$(function() {
		$( "#fecha_i" ).datepicker({
			showOn: "button",
			changeMonth: true,
			changeYear: true,
			buttonImage: "data/images/calendar.gif",
			buttonImageOnly: true
		});
		$( "#fecha_f" ).datepicker({
			showOn: "button",
			changeMonth: true,
			changeYear: true,
			buttonImage: "data/images/calendar.gif",
			buttonImageOnly: true
		});
	});
	</script>
    
</head>
<body onload = "document.form1.tiempo_1.focus()">
<fieldset>
<legend>Registrar Permiso a cuenta de Vacación</legend>
<form id="form1" name="form1" method="post" action="">
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr>
      <td><div align="left">Nombres y Apellidos:</div></td>
      <td><div align="left"><strong><? echo $r[name];?> <? echo $r[l_name1]." ".$r[l_name2];?></strong></div></td>
    </tr>
    <tr>
    <?	 
	 $rs5=$db->query("select * from ".TABLE28." where id_per='$id_per' ");
	 $r5=$db->fetch_array($rs5);
    ?>
      <td>Fecha de Ingreso:</td>
      <td><strong><? echo $r5[date_des];?></strong></td>
    </tr>
    <? 
	$rs1=$db->query("select gestion_1, dias_g1, gestion_2, dias_g2 from ".TABLE3." where id_per='$id_per'");
	$r1=$db->fetch_array($rs1);
	
	?>
    <tr>
      <td><div align="left">Gestión 1:</div></td>
      <td><div align="left"><strong><? echo $r1[gestion_1]." = ".cambia_formato_dias($r1[dias_g1]); ?> Dia(s)</strong></div></td>
    </tr>
    <tr>
      <td><div align="left">Gestión 2:</div></td>
      <td><div align="left"><strong><? echo $r1[gestion_2]." = ".cambia_formato_dias($r1[dias_g2]); ?> Dia(s)</strong></div></div></td>
    </tr>
    <tr>
      <td><div align="left">Tipo de Permiso:</div></td>
      <td><div align="left">
        <label>
        <select name="tipo" id="tipo">
          <option value="1">A cuenta de vacación</option>
          <option>Horas particulares</option>
        </select>
        </label>
      </div></td>
    </tr>
    <tr>
      <td>Desde:</td>
      <td>Fecha:         
        <input class="required" name="fecha_i" type="text" id="fecha_i" size="15" value="<? echo $_POST[fecha_i];?>" />
      Hrs:
      <label>
      <select name="hrs_i" id="hrs_i">
      	<option value="<? echo $hrs_i;?>"><? echo $hrs_i;?></option>
        <option value="08:30">08:30</option>
        <option value="14:30">14:30</option>
      </select>
      </label></td>
    </tr>
    <tr>
      <td>hasta</td>
      <td>Fecha: 
        <input class="required" name="fecha_f" type="text" id="fecha_f" size="15" value="<? echo $_POST[fecha_f];?>" />

        Hrs:
        <label>
        <select name="hrs_f" id="hrs_f">
       <option value="<? echo $hrs_f;?>"><? echo $hrs_f;?></option>
          <option value="12:30">12:30</option>
          <option value="18:30">18:30</option>
        </select>
      </label></td>
    </tr>
    <tr>
      <td><div align="left">Tiempo:</div></td>
      <td><div align="left">
        <? 
		if (is_float($dias_to)==1)
		{
			$num_dias_to=explode(".",$dias_to);
			echo '	
			<input name="tiempo_1" type="text" id="tiempo_1"  style="font-size:17px; font-weight:bold " value="'.$num_dias_to[0].'" size="7" />
        	<select name="tiempo_2" id="tiempo_2"  style="font-size:17px; font-weight:bold ">
			  <option value="0" >-</option>
			  <option value="0.5" selected="selected">1/2</option>
        	</select>';			
		}
		else
		{
			echo '	
			<input name="tiempo_1" type="text" id="tiempo_1"  style="font-size:17px; font-weight:bold" value="'.$dias_to.'" size="7" />
        	<select name="tiempo_2" id="tiempo_2"  style="font-size:17px; font-weight:bold ">
			  <option value="0" selected="selected">-</option>
			  <option value="0.5">1/2</option>
        	</select>';	
		}
		 ?>
        
        
      </div></td>
    </tr>
    <tr>
      <td><div align="left">Observaciones:</div></td>
      <td><div align="left">
        <label>
        <input name="obs" type="text" id="obs" size="45" />
        </label>
      </div></td>
    </tr>
    <tr>
      <td>
        <div align="right">
          <input type="submit" name="calculate" id="loginbutton" value="Calcular" />
      </div></td>
      <td><div align="left">
      <?
	  if (empty($dias_to))
	  {
	  	echo '<label></label>
        <input type="submit" name="save" id="save" value="Guardar y Cerrar" disabled="disabled"/>        
        <label></label>
        <input type="submit" name="save_i" id="save_i" value="Guardar y Registrar Nuevo" disabled="disabled" />';
	  }
	  else
	  {
		echo '<label></label>
        <input type="submit" name="save" id="save" value="Guardar y Cerrar" />        
        <label></label>
        <input type="submit" name="save_i" id="save_i" value="Guardar y Registrar Nuevo" />';
	  }
      ?>
      	
        
      </div></td>
    </tr>
  </table>
</form>
</fieldset>
</body>
</html>
<?
}
?>
