<?php 
//Libreria para pdf
include_once('tcpdf/config/lang/eng.php');
include_once('tcpdf/tcpdf.php');
class MYPDF extends TCPDF {
		// Forma la tabla del pdf
		public function ColoredTable($header,$data) {
			// Colors, line width and bold font
			$this->SetFillColor(201, 201, 201);
			$this->SetTextColor(0);
			$this->SetDrawColor(27, 27, 27);
			$this->SetLineWidth(0.1);
			$this->SetFont('', 'B',8);
			
			// Header
			$w = array(10, 70, 20, 20);
			for($i = 0; $i < count($header); $i++)
					$this->Cell($w[$i],4, $header[$i], 1, 0, 'C', 1);
					$this->Ln();
					// Color and font restoration
					$this->SetFillColor(238, 238, 238);
					$this->SetTextColor(0);
					$this->SetFont('');
					// Data
					$fill = 0;
					foreach($data as $valor=>$dato) {
						$this->Cell($w[0], 3, $dato[0], 'LR', 0, 'C', $fill);
						$this->Cell($w[1], 3, $dato[1], 'LR', 0, 'L', $fill);
						$this->Cell($w[2], 3, $dato[2], 'LR', 0, 'L', $fill);
						$this->Cell($w[3], 3, $dato[3], 'LR', 0, 'L', $fill);
						//$this->Cell($w[3], 6, number_format($row[3]), 'LR', 0, 'R', $fill);
						$this->Ln();
						$fill=!$fill;
			}
			$this->Cell(array_sum($w), 0, '', 'T');
		}
}


$nom='<div style="font-size: 11px;">
<div style="text-align: center;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><b><span style="letter-spacing: -0.15pt;">CONVENIO SUBSIDIARIO </span></b></span></span></div>
<div style="text-align: center;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><b><span style="letter-spacing: -0.15pt;">&nbsp;NOMBRE Y N&ordm; DEL ACREEDOR EXTERNO </span></b></span></span></div>
<div style="text-align: center;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><b><span style="letter-spacing: -0.15pt;">(ESTADO PLURINACIONAL DE BOLIVIA &ndash; EJECUTOR)</span></b></span></span></div>
<div style="text-align: justify;">
	&nbsp;</div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><b>&nbsp;</b><span style="letter-spacing: -0.15pt;">Conste por el presente documento, un Convenio Subsidiario celebrado entre el Estado Plurinacional de Bolivia representada por el Ministerio de Planificaci&oacute;n del Desarrollo y el Ministerio de Econom&iacute;a y Finanzas P&uacute;blicas por una parte y por la otra el EJECUTOR, al tenor de las siguientes Cl&aacute;usulas.</span></span></span></div>
<div style="text-align: justify;">
	&nbsp;</div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">&nbsp;<b>PRIMERA.- DE LAS PARTES.-</b></span></span></span></div>
<div style="text-align: justify;">
	&nbsp;</div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">&nbsp;Las partes que suscriben en el presente Convenio Subsidiario son:</span></span></span></div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;">&nbsp;1.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="letter-spacing: -0.15pt;">El Estado Plurinacional de Bolivia, representada por Noel Ricardo Aguirre Ledezma, en su condici&oacute;n de Ministro de Planificaci&oacute;n del Desarrollo y Luis Alberto Arce Catacora, en su condici&oacute;n de Ministro de Econom&iacute;a y Finanzas P&uacute;blicas designados por Decreto Presidencial N&ordm; 0001, de 8 de febrero de 2009</span>.</span></span></div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;">&nbsp;<span style="letter-spacing: -0.15pt;">1.2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; El EJECUTOR representado por XXXXXX, conforme lo acredita el XXXXXXXX N&ordm; XXXXX, de X de XXXXX de 200X.</span></span></span></div>
<div style="text-align: justify;">
	&nbsp;</div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">&nbsp;<b>SEGUNDA.- DE LAS DEFINICIONES.</b></span></span></span></div>
<div style="text-align: justify;">
	&nbsp;</div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">&nbsp;A los efectos del presente Convenio Subsidiario, los siguientes t&eacute;rminos tendr&aacute;n la significaci&oacute;n que se expresa:</span></span></span></div>
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
	<tbody>
		<tr style="height: 13.8pt;">
			<td style="padding: 0cm 5.4pt; width: 115.65pt; height: 13.8pt;" valign="top" width="154">
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;">&nbsp;<span style="letter-spacing: -0.15pt;">ESTADO PLURINACIONAL DE BOLIVIA</span></span></span></div>
			</td>
			<td style="padding: 0cm 5.4pt; width: 14pt; height: 13.8pt;" valign="top" width="19">
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">:</span></span></span></div>
			</td>
			<td style="padding: 0cm 5.4pt; width: 306.35pt; height: 13.8pt;" valign="top" width="408">
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">El Estado Plurinacional de Bolivia, representado por el Ministerio de Planificaci&oacute;n del Desarrollo y el Ministerio de Econom&iacute;a y Finanzas P&uacute;blicas</span></span></span></div>
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><br />
					</span></span></div>
			</td>
		</tr>
		<tr style="height: 13.8pt;">
			<td style="padding: 0cm 5.4pt; width: 115.65pt; height: 13.8pt;" valign="top" width="154">
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">ACREEDOR EXTERNO</span></span></span></div>
			</td>
			<td style="padding: 0cm 5.4pt; width: 14pt; height: 13.8pt;" valign="top" width="19">
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">:</span></span></span></div>
			</td>
			<td style="padding: 0cm 5.4pt; width: 306.35pt; height: 13.8pt;" valign="top" width="408">
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">XXXXXXXX</span></span></span></div>
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><br />
					</span></span></div>
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><br />
					</span></span></div>
			</td>
		</tr>
		<tr style="height: 13.8pt;">
			<td style="padding: 0cm 5.4pt; width: 115.65pt; height: 13.8pt;" valign="top" width="154">
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">EJECUTOR</span></span></span></div>
			</td>
			<td style="padding: 0cm 5.4pt; width: 14pt; height: 13.8pt;" valign="top" width="19">
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">:</span></span></span></div>
			</td>
			<td style="padding: 0cm 5.4pt; width: 306.35pt; height: 13.8pt;" valign="top" width="408">
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">XXXXX</span></span></span></div>
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><br />
					</span></span></div>
			</td>
		</tr>
		<tr style="height: 13.8pt;">
			<td style="padding: 0cm 5.4pt; width: 115.65pt; height: 13.8pt;" valign="top" width="154">
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">PROYECTO</span></span></span></div>
			</td>
			<td style="padding: 0cm 5.4pt; width: 14pt; height: 13.8pt;" valign="top" width="19">
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">:</span></span></span></div>
			</td>
			<td style="padding: 0cm 5.4pt; width: 306.35pt; height: 13.8pt;" valign="top" width="408">
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">XXXXXXXXXXXXXXXXXXX</span></span></span></div>
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><br />
					</span></span></div>
			</td>
		</tr>
		<tr style="height: 13.8pt;">
			<td style="padding: 0cm 5.4pt; width: 115.65pt; height: 13.8pt;" valign="top" width="154">
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">CONVENIO</span></span></span></div>
			</td>
			<td style="padding: 0cm 5.4pt; width: 14pt; height: 13.8pt;" valign="top" width="19">
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">:</span></span></span></div>
			</td>
			<td style="padding: 0cm 5.4pt; width: 306.35pt; height: 13.8pt;" valign="top" width="408">
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;">CONVENIO DE PR&Eacute;STAMO N&ordm; XXXXX, suscrito entre el Estado Plurinacional de Bolivia y el ACREEDOR EXTERNO el XX de XXXXXX de 200X, por un monto de hasta el equivalente a XXX&nbsp;N,NNN,NNN.NN (XXXXXXXXXXXXXX 00/100 XXXXX), destinados a financiar la ejecuci&oacute;n del PROYECTO.</span></span></div>
				<div style="text-align: justify;">
					&nbsp;</div>
			</td>
		</tr>
	</tbody>
</table>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;">&nbsp;<b><span style="letter-spacing: -0.15pt;">TERCERA.- DE LOS ANTECEDENTES.-</span></b></span></span></div>
<div style="text-align: justify;">
	&nbsp;</div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">&nbsp;3.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Mediante Decreto Supremo N&ordm; XXXXX de XX de XXXX de 200X se autoriz&oacute; la suscripci&oacute;n del CONVENIO con el ACREEDOR, por un monto de hasta el equivalente a </span>XXX&nbsp;N,NNN,NNN.NN (XXXXXXXXXXXXXX 00/100 XXXXX)<span style="letter-spacing: -0.15pt;">, destinados a financiar la ejecuci&oacute;n del PROYECTO.</span></span></span></div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;">&nbsp;3.2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; El Convenio de Pr&eacute;stamo N&ordm; XXXXX, suscrito entre el Estado Plurinacional de Bolivia y el ACREEDOR EXTERNO el XX de XXXXX de 200X, por un monto de hasta el equivalente a XXX&nbsp;N,NNN,NNN.NN (XXXXXXXXXXXXXX 00/100 XXXXX), destinados a financiar la ejecuci&oacute;n del PROYECTO.</span></span></div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">&nbsp;3.3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; El Honorable Congreso Nacional, mediante Ley N&ordm; XXX de XX de XXXX de 200X, aprob&oacute; el CONVENIO DE CR&Eacute;DITO por el monto de hasta </span>XXX&nbsp;N,NNN,NNN.NN (XXXXXXXXXXXXXX 00/100 XXXXX)<span style="letter-spacing: -0.15pt;">, destinado a la ejecuci&oacute;n del PROYECTO.</span></span></span></div>
<div style="margin-left: 36pt; text-align: justify; text-indent: -36pt;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">3.4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; La Addenda XXXXX, de XX de XXXXX de 2009, suscrita entre &hellip;, mediante la cual se define &hellip;. </span></span></span></div>
<div style="margin-left: 36pt; text-align: justify; text-indent: -36pt;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;">3.5&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; El Viceministerio de Inversi&oacute;n P&uacute;blica y Financiamiento Externo mediante Nota Cite: VIPFE/DGPP/XXXX-000XXX/2009 de fecha X de XXXXX de 2009, solicita al Ministerio de Econom&iacute;a y Finanzas P&uacute;blicas la elaboraci&oacute;n del respectivo Convenio Subsidiario.</span></span></div>
<div style="margin-left: 36pt; text-align: justify; text-indent: -36pt;">
	&nbsp;</div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><b><span style="letter-spacing: -0.15pt;">&nbsp;CUARTA.- DEL OBJETO.-</span></b></span></span></div>
<div style="text-align: justify;">
	&nbsp;</div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">&nbsp;El objeto del presente Convenio Subsidiario, es otorgar al EJECUTOR en calidad de Transferencia, los recursos del CONVENIO y establecer las condiciones que regir&aacute;n la utilizaci&oacute;n de dichos recursos en la ejecuci&oacute;n del PROYECTO.</span></span></span></div>
<div style="text-align: justify;">
	&nbsp;</div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><b><span style="letter-spacing: -0.15pt;">QUINTA.- DE LA TRANSFERENCIA DE RECURSOS.</span></b><span style="letter-spacing: -0.15pt;">-</span></span></span></div>
<div style="text-align: justify;">
	&nbsp;</div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">&nbsp;En cumplimiento al Decreto Supremo N&ordm; 29139 y (antecedente documental en el que figure claramente el EJECUTOR), el Estado Plurinacional de Bolivia mediante el presente CONVENIO otorga al EJECUTOR, en calidad de Transferencia, la suma de hasta </span>XXX&nbsp;N,NNN,NNN.NN (XXXXXXXXXXXXXX 00/100 XXXXX)<span style="letter-spacing: -0.15pt;">, con recursos provenientes del CONVENIO DE CR&Eacute;DITO destinados a financiar exclusivamente la ejecuci&oacute;n del PROYECTO.</span></span></span></div>
<div style="text-align: justify;">
	&nbsp;</div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">&nbsp;<b>SEXTA.- DE LOS EFECTOS DE LA TRANSFERENCIA.-</b></span></span></span></div>
<div style="text-align: justify;">
	&nbsp;</div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">&nbsp;Por el presente Convenio Subsidiario, el Estado Plurinacional de Bolivia otorga al EJECUTOR las facultades necesarias para la administraci&oacute;n de los recursos transferidos, que le fueron inicialmente concedidos por el ACREEDOR EXTERNO, para que en estricta sujeci&oacute;n a los t&eacute;rminos y condiciones del CONVENIO, lleve a cabo la ejecuci&oacute;n del PROYECTO.</span></span></span></div>
<div style="text-align: justify;">
	&nbsp;</div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;">&nbsp;<b>S&Eacute;PTIMA.- <span style="letter-spacing: -0.15pt;">DE LOS DESEMBOLSOS.-</span></b></span></span></div>
<div style="text-align: justify;">
	&nbsp;</div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">&nbsp;Los desembolsos se efectuar&aacute;n de acuerdo con los t&eacute;rminos, procedimientos y plazos establecidos en el CONVENIO, a los que debe sujetarse el EJECUTOR.</span></span></span></div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">&nbsp;El EJECUTOR se compromete a informar al Estado Plurinacional de Bolivia sobre el estado de desembolsos efectuados por el ACREEDOR EXTERNO a su favor.</span></span></span></div>
<div style="text-align: justify;">
	&nbsp;</div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;">&nbsp;<b><span style="letter-spacing: -0.15pt;">OCTAVA.-</span></b><span style="letter-spacing: -0.15pt;"> <b>DE LA LIBRETA.-</b></span></span></span></div>
<div style="text-align: justify;">
	&nbsp;</div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">&nbsp;En cumplimiento a lo dispuesto en el Decreto Supremo N&ordm; 29236 de 22 de agosto de 2007, e</span><span style="letter-spacing: -0.15pt;">l </span><span style="letter-spacing: -0.15pt;">EJECUTOR </span><span style="letter-spacing: -0.15pt;">gestionar&aacute; y aperturar&aacute; a trav&eacute;s de la Direcci&oacute;n General de Contabilidad Fiscal del Viceministerio de Presupuesto y Contabilidad Fiscal, dependiente del Ministerio de Econom&iacute;a y Finanzas P&uacute;blicas, en la Cuenta &Uacute;nica del Tesoro en Moneda Extranjera, una Libreta para los recursos provenientes del </span><span style="letter-spacing: -0.15pt;">CONVENIO, bajo los t&eacute;rminos y condiciones satisfactorias para el ACREEDOR EXTERNO.</span></span></span></div>
<div style="text-align: justify;">
	&nbsp;</div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><b><span style="letter-spacing: -0.15pt;">&nbsp;NOVENA.- </span></b><b>DE LA EJECUCION DEL PROYECTO.</b>-</span></span></div>
<div style="text-align: justify;">
	&nbsp;</div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;">&nbsp;El <span style="letter-spacing: -0.15pt;">EJECUTOR </span>se compromete a cumplir los objetivos del PROYECTO y a dar estricto cumplimiento a las determinaciones del CONVENIO, as&iacute; como las del presente Convenio Subsidiario, y a desempe&ntilde;ar sus obligaciones con la debida diligencia y eficiencia, de conformidad con las normas y pr&aacute;cticas adecuadas en materia administrativa, t&eacute;cnica, econ&oacute;mica, ambiental, social y financiera, adoptando las medidas necesarias que aseguren la canalizaci&oacute;n de los recursos &uacute;nica y exclusivamente a la ejecuci&oacute;n del PROYECTO.</span></span></div>
<div style="text-align: justify;">
	&nbsp;</div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;">&nbsp;<span style="letter-spacing: -0.15pt;">Asimismo, el EJECUTOR utilizar&aacute; los recursos transferidos en la forma y para los fines especificados en el CONVENIO, en resguardo de los intereses del Estado Plurinacional de Bolivia.</span></span></span></div>
<div style="text-align: justify;">
	&nbsp;</div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;">&nbsp;<b><span style="letter-spacing: -0.15pt;">D&Eacute;CIMA.- DE LOS REGISTROS, INSPECCIONES E INFORMES.-</span></b></span></span></div>
<div style="text-align: justify;">
	&nbsp;</div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">&nbsp;El EJECUTOR llevar&aacute; registros y cuentas separadas y, suministrar&aacute; al Estado Plurinacional de Bolivia y al ACREEDOR EXTERNO cuando as&iacute; se requiera, informes, estados financieros y reportes de auditoria, de conformidad con las determinaciones disposiciones del CONVENIO.&nbsp;</span></span></span></div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">En caso de aprobarse, por parte del Gobierno Central, modificaciones a disposiciones legales y reglamentos b&aacute;sicos que afecten en forma adversa a la consecuci&oacute;n de los objetivos del PROYECTO o tan pronto el EJECUTOR tenga conocimiento de circunstancias que dificulten la ejecuci&oacute;n de las obligaciones o la consecuci&oacute;n de los fines del CONVENIO, deber&aacute; proporcionar un informe detallado sobre las modificaciones y/o circunstancias y su posible impacto adverso o desfavorable a la ejecuci&oacute;n del PROYECTO.&nbsp;</span></span></span></div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;">El EJECUTOR permitir&aacute; al Estado Plurinacional de Bolivia y al ACREEDOR EXTERNO inspecciones a los registros, estados de cuenta, informes y todo lo que se considere necesario por el Estado Plurinacional de Bolivia y el ACREEDOR EXTERNO.</span></span></div>
<div style="text-align: justify;">
	&nbsp;</div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><b>D&Eacute;CIMA PRIMERA.-</b> <b><span style="letter-spacing: -0.15pt;">DE LOS GASTOS.- </span></b></span></span></div>
<div style="text-align: justify;">
	&nbsp;</div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">&nbsp;Todo gasto, impuesto, seguro o gravamen, que se derive del presente </span>Convenio Subsidiario<span style="letter-spacing: -0.15pt;">, estar&aacute; a cargo de</span>l <span style="letter-spacing: -0.15pt;">EJECUTOR.</span></span></span></div>
<div style="text-align: justify;">
	&nbsp;</div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><b><span style="letter-spacing: -0.15pt;">D&Eacute;CIMA SEGUNDA.- DE LAS GARANTIAS.-</span></b></span></span></div>
<div style="text-align: justify;">
	&nbsp;</div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">&nbsp;El EJECUTOR, garantiza al Estado Plurinacional de Bolivia el fiel y estricto cumplimiento del presente Convenio Subsidiario, con todas sus cuentas que mantiene en el Banco Central de Bolivia y otros Bancos del Sistema Financiero, otorgando autorizaci&oacute;n incondicional e irrevocable al Estado Plurinacional de Bolivia para que, en caso necesario<span style="color: red;">,</span> a trav&eacute;s del Banco Central de Bolivia se debite de las mismas los importes que correspondan, en el marco del presente Convenio Subsidiario.</span></span></span></div>
<div style="text-align: justify;">
	&nbsp;</div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><b><span style="letter-spacing: -0.15pt;">D&Eacute;CIMA TERCERA.- DE LAS OBLIGACIONES DEL ESTADO PLURINACIONAL DE BOLIVIA Y DEL EJECUTOR.-</span></b></span></span></div>
<div style="text-align: justify;">
	&nbsp;</div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">&nbsp;El Estado Plurinacional de Bolivia y el EJECUTOR se comprometen a actuar con diligencia en la gesti&oacute;n y autorizaci&oacute;n de todos los tr&aacute;mites que fuesen necesarios para la ejecuci&oacute;n del PROYECTO, financiado con recursos del CONVENIO. </span></span></span></div>
<div style="text-align: justify;">
	&nbsp;</div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><b>D<span style="letter-spacing: -0.15pt;">&Eacute;</span>CIMA CUARTA.- <span style="letter-spacing: -0.15pt;">DE LA CANCELACI&Oacute;N, SUSPENSI&Oacute;N Y/O MODIFICACIONES</span></b>.-</span></span></div>
<div style="text-align: justify;">
	&nbsp;</div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">&nbsp;El Estado Plurinacional de Bolivia y el EJECUTOR, dejan establecido que el presente Convenio Subsidiario s&oacute;lo puede ser cancelado, suspendido y/o modificado previa autorizaci&oacute;n del EJECUTOR EXTERNO.</span></span></span></div>
<div style="text-align: justify;">
	&nbsp;</div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><b><span style="letter-spacing: -0.15pt;">D&Eacute;CIMA QUINTA.-</span></b><b>DE LA COMPLEMENTACION.-</b></span></span></div>
<div style="text-align: justify;">
	&nbsp;</div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">El presente Convenio Subsidiario complementa las estipulaciones del CONVENIO destinado a la ejecuci&oacute;n del PROYECTO y de ninguna manera limita las responsabilidades del Estado Plurinacional de Bolivia con el EJECUTOR EXTERNO.</span></span></span></div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><br />
	</span></span></div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;">&nbsp;<b><span style="letter-spacing: -0.15pt;">D&Eacute;CIMA SEXTA.- DE LAS COMUNICACIONES.</span></b><span style="letter-spacing: -0.15pt;">-</span></span></span></div>
<div style="text-align: justify;">
	&nbsp;</div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">&nbsp;Todo aviso, solicitud, comunicaci&oacute;n o notificaci&oacute;n que cualquiera de las partes efect&uacute;e en relaci&oacute;n con el presente Convenio Subsidiario o el&nbsp; CONVENIO, debe ser por escrito y se considerar&aacute; realizado desde el momento en que la correspondencia se entregue al destinatario en las direcciones que se indican a continuaci&oacute;n:</span></span></span></div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><br />
	</span></span></div>
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
	<tbody>
		<tr style="height: 13.8pt;">
			<td style="padding: 0cm 5.4pt; width: 116.2pt; height: 13.8pt;" valign="top" width="155">
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;">&nbsp;<span style="letter-spacing: -0.15pt;">ESTADO PLURINACIONAL DE BOLIVIA</span></span></span></div>
			</td>
			<td style="padding: 0cm 5.4pt; width: 14.2pt; height: 13.8pt;" valign="top" width="19">
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">:</span></span></span></div>
			</td>
			<td style="padding: 0cm 5.4pt; width: 305.6pt; height: 13.8pt;" valign="top" width="407">
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">Ministerio de Planificaci&oacute;n del Desarrollo</span></span></span></div>
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">Viceministerio de Inversi&oacute;n P&uacute;blica y Financiamiento Externo</span></span></span></div>
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">Edificio Centro de Comunicaciones La Paz, Piso 11</span></span></span></div>
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">Av. Mariscal Santa Cruz</span></span></span></div>
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">Tel&eacute;fono N&ordm; 2392890</span></span></span></div>
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">Telefax N&ordm; 2392891</span></span></span></div>
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">La Paz, Bolivia</span></span></span></div>
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span></div>
			</td>
		</tr>
		<tr style="height: 13.8pt;">
			<td style="padding: 0cm 5.4pt; width: 116.2pt; height: 13.8pt;" valign="top" width="155">
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><br />
					</span></span></div>
			</td>
			<td style="padding: 0cm 5.4pt; width: 14.2pt; height: 13.8pt;" valign="top" width="19">
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><br />
					</span></span></div>
			</td>
			<td style="padding: 0cm 5.4pt; width: 305.6pt; height: 13.8pt;" valign="top" width="407">
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">Ministerio de Econom&iacute;a y Finanzas P&uacute;blicas </span></span></span></div>
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">Viceministerio del Tesoro y Cr&eacute;dito P&uacute;blico </span></span></span></div>
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">Calle Bol&iacute;var No. 688</span></span></span></div>
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">Tel&eacute;fono N&ordm; 2201391 </span></span></span></div>
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">Telefax N&ordm; 2203551</span></span></span></div>
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">La Paz, Bol&iacute;via</span></span></span></div>
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><br />
					</span></span></div>
			</td>
		</tr>
		<tr style="height: 13.8pt;">
			<td style="padding: 0cm 5.4pt; width: 116.2pt; height: 13.8pt;" valign="top" width="155">
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;">EJECUTOR</span></span></div>
			</td>
			<td style="padding: 0cm 5.4pt; width: 14.2pt; height: 13.8pt;" valign="top" width="19">
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">:</span></span></span></div>
			</td>
			<td style="padding: 0cm 5.4pt; width: 305.6pt; height: 13.8pt;" valign="top" width="407">
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;">XXXXXXXX</span></span></div>
				<div style="margin-left: 119.05pt; text-align: justify; text-indent: -119.05pt;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;">Av. XXXXX N&ordm;XXXX</span></span></div>
				<div style="text-align: justify; page-break-after: avoid;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">Tel&eacute;fono: 2XXXXXX </span></span></span></div>
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">Fax: 2XXXXXX</span></span></span></div>
				<div style="text-align: justify;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">Casilla N&ordm;: XXXX</span></span></span></div>
				<div style="margin-left: 180pt; text-align: justify; text-indent: -180pt;">
					<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">La Paz, Bolivia</span></span></span></div>
			</td>
		</tr>
	</tbody>

</table>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><b>&nbsp;</b></span></span></div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><b>D<span style="letter-spacing: -0.15pt;">&Eacute;</span>CIMA S&Eacute;PTIMA.- <span style="letter-spacing: -0.15pt;">DE LA VIGENCIA DEL CONVENIO SUBSIDIARIO.-</span></b></span></span></div>
<div style="text-align: justify;">
	&nbsp;</div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">&nbsp;El presente </span><span style="letter-spacing: -0.15pt;">Convenio Subsidiario </span><span style="letter-spacing: -0.15pt;">entrar&aacute; en vigencia a partir de la fecha de suscripci&oacute;n y se considerar&aacute; terminado tan pronto la ejecuci&oacute;n del PROYECTO haya concluido a satisfacci&oacute;n del Estado Plurinacional de Bolivia y el ACREEDOR EXTERNO.</span></span></span></div>
<div style="text-align: justify;">
	&nbsp;</div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><b>&nbsp;</b><b><span style="letter-spacing: -0.15pt;">D&Eacute;CIMA OCTAVA.- DE LA ACEPTACION.<span style="font-weight: normal;">-</span></span></b></span></span></div>
<div style="text-align: justify;">
	&nbsp;</div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">&nbsp;El Estado Plurinacional de Bolivia</span><span style="letter-spacing: -0.15pt;">, representado por los Ministros de Planificaci&oacute;n del Desarrollo, Noel Ricardo Aguirre Ledezma y de Econom&iacute;a y Finanzas P&uacute;blicas, Luis Alberto Arce Catacora, por una parte </span><span style="letter-spacing: -0.15pt;">y por la otra el XXXXXXXX, representado por XXXXXXXXXX declaran su absoluta conformidad y aceptaci&oacute;n con todas y cada una de las cl&aacute;usulas precedentes, oblig&aacute;ndose a su fiel y estricto cumplimiento.</span></span></span></div>
<div style="text-align: justify;">
	&nbsp;</div>
<div style="text-align: justify;">
	&nbsp;</div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><span style="letter-spacing: -0.15pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; La Paz,&nbsp; </span></span></span></div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;"><br />
	</span></span></div>
<div style="text-align: justify;">
	<span style="font-family: arial,helvetica,sans-serif;"><span style="font-size: 16px;">&nbsp; <br />
	</span></span></div>
</div>'; 


// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); 

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 006');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 

//set some language-dependent strings
$pdf->setLanguageArray($l); 

// ---------------------------------------------------------

//Adicionar
/*
 $pdf->AddFont('vera','I');
 // is equivalent to:
 $pdf->AddFont('vera','I','vera.php');
*/
//--fin de adicionar

// set font
//$pdf->SetFont('vera', '', 50);

// add a page
$pdf->AddPage();


// output the HTML content
//$nom = '<b style="font-size:50px;font-family:Century Gothic, sans-serif;">Hola Mundo como estan</b>';

$nom = '<p font-family:"Century Gothic">Hola amigos</p>
';

$pdf->writeHTML($nom, true, 0, true, 0);

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------
//Close and output PDF document
$pdf->Output('example_006.pdf', 'I');
?>
