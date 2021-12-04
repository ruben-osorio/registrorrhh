<script type="text/javascript" src="js/scripts.js"></script>
<?
require("config.inc.php");
require("database.class.php");
require ("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
//EXCELLLL
if (isset($_POST[to_excel]))
{
	include("excelwriter.inc.php");  
	$excel=new ExcelWriter("FuncionariosBaja.xls");
	if($excel==false) {   
			echo $excel->error;
	}					
//CABECERA
//Ap.Paterno Ap.Materno Nombre(s)Fuente financiamiento Cargo F.fin de servicio Motivo de salida

	$myArr=array("AP. PATERNO","AP. MATERNO","NOMBRE(S)","FUENTE DE FINANCIAMIENTO","FECHA FIN SERVICIO","MOTIVO SALIDA");
	$excel->writeLine($myArr);
//-------------------------------
$rs1=$db->query("
SELECT  l_name1,l_name2,name, source_fin, date_efect, reasone
FROM ".TABLE2.",".TABLE22.",".TABLE15.",".TABLE35." 
WHERE
funcionario.id_func=permanente.id_func
AND status =  '0'
AND permanente.id_per=fin_per.id_per
AND permanente.id_per=baja.id_per
");
//--------------------CONSULTA CONTRATO
$rs4=$db->query("
SELECT l_name1,l_name2,name, source_fin, date_efec, reasone
FROM ".TABLE2.",".TABLE30.",".TABLE17.",".TABLE36." 
WHERE
funcionario.id_func=contrato.id_func
AND f_status =  '0'
AND contrato.id_con=fin_con.id_con
AND contrato.id_con=baja_con.id_con 
");	
	
//------------------------------	
//l_name1,l_name2,name, source_fin, charge, date_efect, reasone
	while ($r1=$db->fetch_array($rs1))
	{		$excel->writeRow();
			$excel->writeCol($r1[l_name1]);
			$excel->writeCol($r1[l_name2]);
			$excel->writeCol($r1[name]);
			$excel->writeCol($r1[source_fin]);
			$excel->writeCol(cambia_dateMy_to_dateN($r1[date_efect]));
			$excel->writeCol($r1[reasone]);
	}
//------------------------------	
//l_name1,l_name2,name, source_fin, charge, date_efect, reasone
	while ($r4=$db->fetch_array($rs4))
	{		$excel->writeRow();
			$excel->writeCol($r4[l_name1]);
			$excel->writeCol($r4[l_name2]);
			$excel->writeCol($r4[name]);
			$excel->writeCol($r4[source_fin]);
			$excel->writeCol(cambia_dateMy_to_dateN($r4[date_efec]));
			$excel->writeCol($r4[reasone]);
	}	
	
	
	$excel->close();
	echo "Los datos se han grabado con &eacute;xito.";
}
//phpsssssssssssss
/*SELECT l_name1, l_name2, name, charge, source_fin, date_efect,reasone
FROM funcionario, permanente, char_per, fin_per, baja
WHERE funcionario.id_func = permanente.id_func
AND STATUS =  '0'
AND permanente.id_per=char_per.id_per
AND permanente.id_per=fin_per.id_per
AND permanente.id_per=baja.id_per*/
//--------------------CONSULTA PERMANENTE
$rs=$db->query("
SELECT  funcionario.id_func, l_name1,l_name2,name,permanente.id_per,source_fin, date_efect, reasone
FROM ".TABLE2.",".TABLE22.",".TABLE15.",".TABLE35." 
WHERE
funcionario.id_func=permanente.id_func
AND status =  '0'
AND permanente.id_per=fin_per.id_per
AND permanente.id_per=baja.id_per
");
//AND permanente.id_per=char_per.id_per".TABLE28."
//--------------------CONSULTA CONTRATO
$rs2=$db->query("
SELECT funcionario.id_func, l_name1,l_name2,name,contrato.id_con,source_fin, date_efec, reasone
FROM ".TABLE2.",".TABLE30.",".TABLE17.",".TABLE36." 
WHERE
funcionario.id_func=contrato.id_func
AND f_status =  '0'
AND contrato.id_con=fin_con.id_con
AND contrato.id_con=baja_con.id_con 
");

/*AND contrato.id_con=char_con.id_con ".TABLE31.",*/




//---------------------MUESTRA CONTENIDO
echo '<script type="text/javascript" src="js/scripts.js"></script>';
echo '<fieldset>
	<legend>FUNCIONARIOS PASIVOS</legend>
	<div style="padding: 5px; ">
	<form id="form1" name="form1" method="post" action="" class="form">
  	<input type="submit" name="to_excel" id="save" class="submit" value="Exportar a Excel" />
	</form>
	</div>';
//--------------------------
	echo '<div class="table-wrap"><div class="table">	
	<table width="100%" border="0" cellpadding="5" cellspacing="0">
  <tr class="even">    
    <th>Ap.Paterno</th>	
    <th>Ap.Materno</th>
	<th >Nombre(s)</th>
	<th >Fuente financiamiento</th>		
	<th >F.fin de servicio</th>
	<th >Motivo de salida</th>
	<th >Detalles&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
</tr>';
 $c=0;
while ($r=$db->fetch_array($rs))
//l_name1,l_name2,name, source_fin, charge, date_efect, reasone
{echo " <tr>   
    	<td>".$r[l_name1]."</td>
    	<td>".$r[l_name2]."</td>
	 	<td>".$r[name]."</td>
		<td>".$r[source_fin]."</td>
		<td>".cambia_dateMy_to_dateN($r[date_efect])."</td>
		<td>".$r[reasone]."</td>	
			<td>
	<a href=\"#\" onclick=\"MM_openBrWindow('DetPas.php?id_func=".$r[id_func]."&id_per=".$r[id_per]."','regpermiso','scrollbars=yes,width=600,height=420')\" title=\"Detalles Funcionario Pasivo\"><img src=\"data/images/modify.png\"></a>
	</td>
		</tr>			
		";
	
}
while ($r2=$db->fetch_array($rs2))
//l_name1,l_name2,name, source_fin, charge, date_efect, reasone
{echo " <tr>   
    	<td>".$r2[l_name1]."</td>
    	<td>".$r2[l_name2]."</td>
	 	<td>".$r2[name]."</td>
		<td>".$r2[source_fin]."</td>
		<td>".cambia_dateMy_to_dateN($r2[date_efec])."</td>
		<td>".$r2[reasone]."</td>	
					<td>
	<a href=\"#\" onclick=\"MM_openBrWindow('DetPasc.php?id_func=".$r2[id_func]."&id_con=".$r2[id_con]."','regpermiso','scrollbars=yes,width=600,height=420')\" title=\"Detalles Funcionario Pasivo\"><img src=\"data/images/modify.png\"></a>
	</td>
		</tr>			
		";
}
 echo'
 </div></div>
</table>
	</fieldset>';
?>