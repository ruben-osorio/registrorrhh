<?php
//--------REPORTE FILE PERSONAL
//--------DATOS PERSONALES
$id_func=$_GET['id_func'];
$id_per=$_GET['id_per'];
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
require("PDFcreator.class.php");
//-------------REVISAR SI COMPLETO TODOS SUS DATOS----------------------
$rshab=$db->query(" 
SELECT * FROM ".TABLE37." 
WHERE id_func='$id_func'
");
$rsh=$db->fetch_array($rshab);	
if(($rsh[p1]+$rsh[p2]+$rsh[p3]+$rsh[p4]+$rsh[p5]+$rsh[p6]+$rsh[p7]+$rsh[p8]+$rsh[p9])!=9)
{	
	//$html.= '<link href="css/reportes.css" rel="stylesheet" type="text/css">';
	//$html.= '<link href="data/css/style-ext.css" rel="stylesheet" type="text/css">';
	$html.= '<div style="position: absolute; left: 0px; top: 0px; right:0px; bottom: 0px; background: #242424 url(data/images/bg.jpg); font-family: Verdana, Geneva, sans-serif; font-size: 13px; color: #000;">
		<div style="padding-left:90px; padding-right:90px; padding-top: 50px; padding-bottom: 50px;  background:#fff; margin-right: 60px; margin-left: 60px; margin-top: 20px;border-radius: 3px;
-moz-border-radius: 3px;-webkit-border-radius: 3px">';	
		
		$html.= '<h2 class="errorre ">Debe completar todos los pasos para generar el reporte a imprimir !!! <br> Pasos pendientes a completar:</h2>';
		$html.= '<div style="display:inline-block; background:#fff; ">';
	 if($rsh[p1]==0) $html.= "<img src=\"data/images/menu/1.png\">";
	 if($rsh[p2]==0) $html.= "<img src=\"data/images/menu/2.png\">";
	 if($rsh[p3]==0) $html.= "<img src=\"data/images/menu/3.png\">";
	 if($rsh[p4]==0) $html.= "<img src=\"data/images/menu/4.png\">";
	 if($rsh[p5]==0) $html.= "<img src=\"data/images/menu/5.png\">";
	 if($rsh[p6]==0) $html.= "<img src=\"data/images/menu/6.png\">";
	 if($rsh[p7]==0) $html.= "<img src=\"data/images/menu/7.png\">";
	 if($rsh[p8]==0) $html.= "<img src=\"data/images/menu/8.png\">";
	 if($rsh[p9]==0) $html.= "<img src=\"data/images/menu/9.png\">";
		$html.= "</div>";
		$html.= '<div align="center"><input type="button" onclick="window.close();" id="loginbutton" value="Cerrar Ventana"></div>';
	 $html.= "
	 </div>
	 </div>";
	 exit;
	
	}
//----------------------------------------------------------------------
//CONSULTA PARA OBTENER TODO LOS DATOS FUNCIONARIO
	$rs2=$db->query("
	SELECT * FROM ".TABLE2." 
	WHERE id_func='$id_func'
	");
//------------DATOS EDUCACIONALES------------------	
	$rs3=$db->query("
	SELECT * FROM ".TABLE10." 
	WHERE id_func='$id_func'
	");
//------------DATOS EDUCACIONALES------------------	
	$rs4=$db->query("
	SELECT * FROM ".TABLE8." 
	WHERE id_func='$id_func'
	");
//------------USUARIO------------------	
	$rs5=$db->query("
	SELECT * FROM ".TABLE1." 
	WHERE id_func='$id_func'
	");
//------------IDIOMAS------------------	
	$rs6=$db->query("
	SELECT * FROM ".TABLE11." 
	WHERE id_func='$id_func'
	");
//------------OTROS CONOCIMIENTOS------------------		
	$rs7=$db->query("
	SELECT * FROM ".TABLE12." 
	WHERE id_func='$id_func'
	");
//------------DOCENCIA UNIVERSITARIA------------------		
	$rs8=$db->query("
	SELECT * FROM ".TABLE13." 
	WHERE id_func='$id_func'
	");
//------------EXPERIENCIA LABORAL------------------		
	$rs9=$db->query("
	SELECT * FROM ".TABLE14." 
	WHERE id_func='$id_func'
	");
//------------IDIOMAS------------------		
	$rs10=$db->query("
	SELECT * FROM ".TABLE23." 
	WHERE id_per='$id_per'
	");
	$rs11=$db->query("
	SELECT * FROM ".TABLE24." 
	WHERE id_func='$id_func'
	");
	$rs12=$db->query("
	SELECT * FROM ".TABLE25." 
	WHERE id_func='$id_func'
	");
	$rs13=$db->query("
	SELECT * FROM ".TABLE26." 
	WHERE id_per='$id_per'
	");
	$rs14=$db->query("
	SELECT * FROM ".TABLE27." 
	WHERE id_func='$id_func'
	");
	$rs15=$db->query("
	SELECT * FROM ".TABLE28." 
	WHERE id_per='$id_per'
	");
/*FUENTE FINANCIAMIENTO*/
	$rs16=$db->query("
	SELECT * FROM ".TABLE15." 
	WHERE id_per='$id_per'
	");
	$rs17=$db->query("
	SELECT * FROM ".TABLE16." 
	WHERE id_per='$id_per'
	");
/*MOVILIDAD*/
	$rs18=$db->query("
	SELECT * FROM ".TABLE19." 
	WHERE id_per='$id_per'
	");
/*EVALUACIÓN*/
	$rs19=$db->query("
	SELECT * FROM ".TABLE29." 
	WHERE id_per='$id_per'
	");
/*CAPACITACIÓN*/
	$rs20=$db->query("
	SELECT * FROM ".TABLE21." 
	WHERE id_func='$id_func'
	");

//----------------------
//	$html.= "SELECT id_func, name, l_name1, l_name2,ci,expe,date_born FROM ".TABLE2." WHERE id_func='$id_func'";
	$rex=$db->fetch_array($rs2);
	$rex1=$db->fetch_array($rs3);
	$rex4=$db->fetch_array($rs6);
	$rex5=$db->fetch_array($rs7);
	$rex6=$db->fetch_array($rs8);
	$rex8=$db->fetch_array($rs10);
	$rex9=$db->fetch_array($rs11);
	$rex10=$db->fetch_array($rs12);
	$rex11=$db->fetch_array($rs13);
	$rex12=$db->fetch_array($rs14);
	$rex13=$db->fetch_array($rs15);
/*FUENTE FINANCIAMIENTO*/
	$rex14=$db->fetch_array($rs16);
	$rex15=$db->fetch_array($rs17);
/*EVALUACIÓN*/
	$rex17=$db->fetch_array($rs19);


/*-------------------------*/
//	$html.= mysql_num_rows($rs2);
//	$html.= $rex[id_func];
	
//------------------------------------


	if(!$rex)
	{
		//$html.= exit;
	}
	//$html.= "verdad";
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
			$pdf->SetTopMargin(5);
			$pdf->SetLeftMargin(0);
			$pdf-> SetRightMargin(0);			
			$pdf->setPageOrientation(P,0,0);
				
$html .='
<table width="500" height="42" border="1" align="center" cellpadding="2" cellspacing="0">
	<tr>     
      	<td><div align="center"><img src="data/images/logo_mini.jpg" alt="" width="180" height="55" /></div></td>
      	<td></td> 
      	<td width="179"><div align="center"><strong>SUBSISTEMA DE REGISTRO</strong><br />
        	<strong>FORM. SAP. REG-01</strong>      </div>
		</td>
     </tr> 
     <tr>     
      	<td><div align="center">Dirección General de Asuntos Administrativos</div></td>
      	<td></td>
      	<td>&nbsp;</td>
    </tr> 
	<tr>     
    	<td width="179"><div align="center"><img src="data/images/foto.gif" width="120" height="120" align="middle" /></div></td>
      	<td width="179">
			<h1 align="center">FICHA PERSONAL</h1>
        	<h4>Este documento debe ser llenado por todos los funcionarios que ingresen al Ministerio de Educación. El funcionario con su firma acreditada la veracidad de la información registrada.</h4>
		</td>
      	<td>
			<input type="button" name="imprimir" value="Imprimir" onclick="window.print();">
		</td>
     </tr> 
</table> 
<table width="500" height="42" border="1" align="center" cellpadding="2" cellspacing="0">
<tr>
    <td width="500">
 	<h2>DATOS PERSONALES</h2>
    </td>
</tr>
</table> 
';

$pdf->writeHTML($html, false, 0, true, 0);
$pdf->lastPage();
$pdf->Output("test.pdf", 'F');
?>