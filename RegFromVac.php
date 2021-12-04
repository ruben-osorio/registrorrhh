<?
require("functions.inc.php");
require("config.inc.php");
require("database.class.php");
require("PDFcreator.class.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
$id_func=$_GET[id];
if (isset($_GET[id]))
{
	$rs=$db->query("select * from ".TABLE2." where id_func='$id_func'");
	$r=$db->fetch_array($rs);
	$rs7=$db->query("select * from ".TABLE22." where id_func='$id_func' order by id_per desc limit 1");
	$r7=$db->fetch_array($rs7);
	$id_per=$r7[id_per];
	
	if (isset($_POST[calculate]))		
	{
		$tiempo_1=$_POST[tiempo_1];
		$tiempo_2=$_POST[tiempo_2];
		$fecha_desde_1=cambia_dateN_to_dateMy_1($_POST[fecha_desde]);
		$fecha_hasta_1=cambia_dateN_to_dateMy_1($_POST[fecha_hasta]);
		
		$fecha_retorno=$_POST[fecha_retorno];
		
		$date_parts1=explode("-", $fecha_desde_1);
		$date_parts2=explode("-", $fecha_hasta_1);
		
		$start_date=gregoriantojd($date_parts1[1], $date_parts1[2], $date_parts1[0]);
		$end_date=gregoriantojd($date_parts2[1], $date_parts2[2], $date_parts2[0]);
		$dias_total=($end_date - $start_date)+1;
		$c=0;
		while ($date_parts1[2]<=$date_parts2[2])
		{
			if ( (date("w",mktime(0, 0, 0, $date_parts1[1], $date_parts1[2], $date_parts1[0]))==0) || 
			(date("w",mktime(0, 0, 0, $date_parts1[1], $date_parts1[2], $date_parts1[0]))==6) )
			{
				$c++;	
			}
			$date_parts1[2]=$date_parts1[2]+1;
			
		}
		$total_final=$dias_total-$c;
		echo "total dias fin de semana: ".$c;		
	}
	if (isset($_POST[submit]))
	{		
		$p_dias=$_POST[tiempo_1]+$_POST[tiempo_2];
		$fecha_s=$_POST[fecha_s];		
		
		//echo "<br />select dias_g1, dias_g2 from ".TABLE3." where id_funcionario='$id_fun'";
		$rs1=$db->query("select gestion_1, dias_g1, gestion_2,dias_g2 from ".TABLE3." where id_per='$id_per'");
		$r1=$db->fetch_array($rs1);
		$f_dias=$r1[dias_g1]+$r1[dias_g2];
		//echo "saldo dias total ".$f_dias."<br />";
		if ($f_dias>=$p_dias)
		{
			if ($r1[dias_g1]>=$p_dias)
			{
				$saldo_g1=$r1[dias_g1]-$p_dias;
				$saldo_g2=$r1[dias_g2];
				/*echo "gestion 1: ".$saldo_g1."<br />"; //afecta solo a gestion 1
				echo "gestion 2: ".$saldo_g2;*/
				$gestion_used=$r1[gestion_1];
			}
			else
			{
				$saldo_g1=0;				
				$nuevos_dias=$r1[dias_g1]-$p_dias;				
				$saldo_g2=$r1[dias_g2]+$nuevos_dias;
				$gestion_used=$r1[gestion_1]."; ".$r1[gestion_2];
/*				echo "gestion 1: ".$saldo_g1."<br />";
				echo "gestion 2: ".$saldo_g2;	*/			
			}					
			//echo "<br />update ".TABLE3." SET dias_g1='$saldo_g1', dias_g2='$saldo_g2' where id_funcionario='$id_fun'";	
			$rs2=$db->query("update ".TABLE3." SET dias_g1='$saldo_g1', dias_g2='$saldo_g2' where id_per='$id_per'");
			//id_user	tipo	tiempo	fecha_i	hrs_i	fecha_f	hrs_f
			$tipo=2;
			
			$fecha_desde=cambia_dateN_to_dateMy_1($_POST[fecha_desde]);
			$fecha_hasta=cambia_dateN_to_dateMy_1($_POST[fecha_hasta]);			
			$obs=$_POST[obs];
			//id_user	tipo	tiempo	fecha_ii	hrs_i	fecha_ff	hrs_f	obs

			$rs3=$db->query("insert into ".TABLE5." (id_per, tipo, tiempo, fecha_ii, hrs_i, fecha_ff, hrs_f, obs) 
			values ('$id_per', '2', '$p_dias', '$fecha_desde', '', '$fecha_hasta', '', '$obs') ");
			
			/*start-pdf*/
			
			$pdf = new PDF6(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			//$pdf->SetMargins(PDF_MARGIN_LEFT, 20);
			$pdf->SetMargins(PDF_MARGIN_LEFT, 0);
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM+5); //margen inferior del el pie 
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			$pdf->setLanguageArray($l);
			$pdf->setPageFormat(OFICIO,P);
			$sistema  = 'ssrp';
			$pdf->setCabecera2($cabecera);
			
			//$pdf->setPie2($pie);
			$pdf->AddPage();
			$pdf->SetFont('helvetica', '', 11);
			$pdf->SetTopMargin(205);
			$pdf->SetLeftMargin(0);
			$pdf-> SetRightMargin(0);
			
			$pdf->setPageOrientation(P,0,0);
			$rs4=$db->query("select date_ent from ".TABLE22." where id_per='$id_per'");
			$r4=$db->fetch_array($rs4);
			$fecha_ingreso=explode("-",$r4[date_ent]);
			
			
			$html = '<table width="100%" cellspacing="0" cellpadding="5" border="0">
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '.$fecha_ingreso[2].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			'.$fecha_ingreso[1].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$fecha_ingreso[0].'</td>
			  </tr>
			  <tr>
				<td><br />
			<br />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-'.$_POST[tiempo_1].'-&nbsp;&nbsp;('.strtoupper($_POST[lit_num]).')</td>
				<td>&nbsp;</td>
				<td><br /><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$gestion_used.'</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$_POST[fecha_retorno].'</td>
			  </tr>
			  <tr  >
				<td colspan="3"><br /><br /><br /><br /><div align="center">'.date("d",time()).'
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.date("m",time()).'
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.date("Y",time()).'
			</div></td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>';
				$rs6=$db->query("select gestion_1, dias_g1, gestion_2, dias_g2 from ".TABLE3." where id_per='$id_per'");
				$r6=$db->fetch_array($rs6);
				
				if ($r6[dias_g1]!=0)
				{
					$html.='<td><br /><br /><br /><br /><br /><br /><br />GESTION '.$r6[gestion_1].': '.cambia_formato_dias($r6[dias_g1]).' DIA(S)<br />GESTION '.$r6[gestion_2].': '.cambia_formato_dias($r6[dias_g2]).' DIA(S)</td>';	
				}
				else
				{
					if ($r6[dias_g2]!=0)
					{
						$html.='<td><br /><br /><br /><br /><br /><br /><br />GESTION '.$r6[gestion_1].': CERRADO<br />GESTION '.$r6[gestion_2].': '.cambia_formato_dias($r6[dias_g2]).' DIA(S)</td>';
					}
					else
					{
						$html.='<td><br /><br /><br /><br /><br /><br /><br />GESTION '.$r6[gestion_1].': CERRADO<br />GESTION '.$r6[gestion_2].': CERRAD0</td>';
					}
						
				}	
											
			  $html.='</tr>
			  <tr><td colspan="3" ><FONT FACE="arial" SIZE="5" COLOR="black"><br />'.$r[name].' '.$r[l_name1].' '.$r[l_name2].' ['.base64_encode($r[name].' '.$r[l_name1].' '.$r[l_name2]).']</font></td></tr>
			</table>
							   ';        
				   
				   
			$pdf->writeHTML($html, false, 0, true, 0);
			$pdf->lastPage();
			$rs5=$db->query("select id from ".TABLE5." where id_user='$id_fun' order by id desc limit 1");
			$r5=$db->fetch_array($rs5);			
			$nombre_archivo="FormVac-".$id_func."-".$id_per."-0".$r5[id]."-".ucfirst(strtolower($r[name])).ucfirst(strtolower($r[l_name1])).ucfirst(strtolower($r[l_name2]));
			$pdf->Output("/FormsVac/".$nombre_archivo.".pdf", 'F');
			/*end-pdf*/
			
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
		//echo '<a href="#">Generar</a>';
		
	}
	if ($sw==1)
	{
		echo '<div class="alert success">'.$msg.', Descargar Formulario para Impresión <a href="FormsVac/'.$nombre_archivo.'.pdf" target="_new">AQUI</a></div>';
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
		$( "#fecha_desde" ).datepicker({
			showOn: "button",
			changeMonth: true,
			changeYear: true,
			buttonImage: "data/images/calendar.gif",
			buttonImageOnly: true
		});
		$( "#fecha_hasta" ).datepicker({
			showOn: "button",
			changeMonth: true,
			changeYear: true,
			buttonImage: "data/images/calendar.gif",
			buttonImageOnly: true
		});
		$( "#fecha_retorno" ).datepicker({
			showOn: "button",
			changeMonth: true,
			changeYear: true,
			buttonImage: "data/images/calendar.gif",
			buttonImageOnly: true
		});		
	});
	</script>
</head>
<link href="data/css/style-ext.css" rel="stylesheet" type="text/css">

<body onload = "document.form1.tiempo_1.focus()">
<fieldset>
<legend>Registrar Formulario de Vacación</legend>

<form id="form1" name="form1" method="post" action="">
  <table width="100%" border="0" cellpadding="5">
      <tr>
      <td><div align="left">Nombres y Apellidos:</div></td>
      <td><div align="left"><strong><? echo $r[name];?> <? echo $r[l_name1]." ".$r[l_name2];?></strong></div></td>
    </tr>
    <tr>
      <td><div align="left">Fecha de Ingreso:</div></td>
      <?
		
      ?>
      <td><div align="left"><strong><? echo cambia_dateMy_to_dateN($r7[date_ent]);?></strong></div></td>
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
      <td><div align="left">Dias:</div></td>
      <td>
        <div align="left"> 
        <?
		if (isset($_POST[calculate]))
		{
			echo '<input name="tiempo_1" type="text" id="tiempo_1" value="'.$total_final.'" size="7" style="font-size:17px; font-weight:bold"/>';
		}
		else
		{
			echo '<input name="tiempo_1" type="text" id="tiempo_1" value="0" size="7" style="font-size:17px; font-weight:bold"/>';
		}
        ?>       
        
       
        
        <select name="tiempo_2" id="tiempo_2" style="font-size:17px; font-weight:bold">
          <option value="0" selected="selected">-</option>
          <option value="0.5">1/2</option>
        </select>
          </div>      </td>
    </tr>
    <tr>
      <td><div align="left">Dias Literal:</div></td>
      <td><div align="left">
          <input type="text" name="lit_num" id="lit_num" />
      </div></td>
    </tr>
    <tr>
      <td><div align="left">Desde:</div></td>
      <td>
        <div align="left">
        <?
		if (isset($_POST[calculate]))
		{
			echo '<input type="text" name="fecha_desde" id="fecha_desde" class="required" value="'.$_POST[fecha_desde].'" />';
		}
		else
		{
			echo '<input type="text" name="fecha_desde" id="fecha_desde" class="required" />';
		}
        ?>
          
          </div>
		</td>
    </tr>
        <tr>
      <td><div align="left">Hasta:</div></td>
      <td><div align="left">
        <?
		if (isset($_POST[calculate]))
		{
			echo '
			<input type="text" name="fecha_hasta" id="fecha_hasta" class="required" value="'.$_POST[fecha_hasta].'"/>';
		}
		else
		{
			echo '<input type="text" name="fecha_hasta" id="fecha_hasta" class="required"/>';
		}
		
        ?>
        
      </div></td>
    </tr>
        <tr>
          <td><div align="left">Fecha de Retorno:</div></td>
          <td><div align="left">
            
            <input type="text" name="fecha_retorno" id="fecha_retorno" />
          </div></td>
        </tr>
    <tr>
      <td>&nbsp;</td>
      <td><div align="left">
        
        <?
		if (isset($_POST[calculate]))
		{
			echo '<input type="submit" name="submit" id="submit" value="Guardar" />';
		}
		else
		{
			echo '<input type="submit" name="submit" id="submit" value="Guardar" disabled="disabled" />';
		}
        ?> 
        
        
        <input type="submit" name="calculate" id="calculate" value="CALCULAR" />
      </div></td>
    </tr>
  </table>
</form>
</fieldset>
</body>
<?
}
?>