<?
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$id_func=$_GET[id_func];
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
$sw=0;
$rsexe=$db->query("SELECT * FROM ".TABLE2." WHERE id_func='$id_func'");
$rexe=$db->fetch_array($rsexe);
//echo mysql_num_rows($rsexe);
if (isset($_POST[save]))
{	
	$name=strtoupper($_POST[name]);
	$l_name1=strtoupper($_POST[l_name1]);
	$l_name2=strtoupper($_POST[l_name2]);
	$ci=$_POST[ci];
	$expe=$_POST[expe];	
	$fecha_nac=$_POST[date_born];
	$fech_nac=explode("-",$_POST[date_born]);	
	$dia=$fech_nac[0];
	$mes=$fech_nac[1];
	$ano=$fech_nac[2];
	$date_born=cambia_dateN_to_dateMy_1($date_born);	
	
	$rsex=$db->query("SELECT id FROM ".TABLE4." WHERE id_func='$id_func'");
	$rex=$db->fetch_array($rsex);
	
	$fuente=$_POST[fuente];	
  	if (isset($_POST[key_form]))
  	{
		if ($_POST[key_form])
		{
			$rs=$db->query("select * from ".TABLE2." where id_func='$id_func'");						
			if ($rs)
			{
				if (strcmp("TGN",$fuente) == 0)
				{				
					$charge_=$_POST[charge_];
					$start_date=cambia_dateN_to_dateMy_1($_POST[start_date]);
					$year_=explode("-",$start_date);
										
					$rsver=$db->query("select * from ".TABLE30." where id_func='$id_func'");					
					if (mysql_num_rows($rsver)!=0)
					{
						$rsver1=$db->query("update ".TABLE30." set status='0' where id_func='$id_func'");						
					}
										
					$rs2=$db->query("insert into ".TABLE22." 
					(id_func, date_ent, status) values 
					('$id_func','$start_date','1')");
					
					$rs5=$db->query("select id_per from ".TABLE22." order by id_per desc limit 1");
					$r5=$db->fetch_array($rs5);					
					$id_permanente=$r5[id_per];
					
					$rs6=$db->query("insert into ".TABLE15." (id_per, source_fin) values ('$id_permanente','$fuente')");				
													
					$rs3=$db->query("insert into ".TABLE28."
					(id_per, charge, date_des) values
					('$id_permanente','$charge_','$start_date')");
					
					$g1_i=explode("-",$start_date);			
					$g1_f=$g1_i[0]+1;
					$g1=$g1_i[0]."-".$g1_f;	
					$db = new Database(DB_SERVER, DB_USER, DB_PASS, "ssrp");
					$db->connect();
					$rs1=$db->query("insert into ".TABLE3." (id_funcionario, gestion_1, dias_g1, gestion_2, dias_g2, observaciones)
					VALUES ('$id_func','$g1','0','','','')");
					
					$estructura = 'files/';
					$filename=ucfirst(strtolower(str_replace(' ','',$_POST[name]))).ucfirst(strtolower($_POST[l_name1])).ucfirst(strtolower($_POST[l_name2]))."_".$dia.$mes.$ano."_".$ci;				
					//mkdir($estructura.$filename, 0777, true);
					/*
					mkdir($estructura."/".$filename."/".$year_[0]."-TGN");
					mkdir($estructura."/".$filename."/".$year_[0]."-TGN/CURRICULUM_VITAE");
					mkdir($estructura."/".$filename."/".$year_[0]."-TGN/DATOS_PERSONALES");
					mkdir($estructura."/".$filename."/".$year_[0]."-TGN/DESIGNACION_MOVILIDAD");
					mkdir($estructura."/".$filename."/".$year_[0]."-TGN/ANTECEDENTES");
					mkdir($estructura."/".$filename."/".$year_[0]."-TGN/LLAMADAS_DE_ATENCION");
					mkdir($estructura."/".$filename."/".$year_[0]."-TGN/JEFE_INMEDIATO");
					mkdir($estructura."/".$filename."/".$year_[0]."-TGN/EVALUACION");
					mkdir($estructura."/".$filename."/".$year_[0]."-TGN/NECESIDAD_CAPACITACION");
					mkdir($estructura."/".$filename."/".$year_[0]."-TGN/LICENCIAS");
					mkdir($estructura."/".$filename."/".$year_[0]."-TGN/VACACIONES");
					mkdir($estructura."/".$filename."/".$year_[0]."-TGN/BAJAS_MEDICAS");
					mkdir($estructura."/".$filename."/".$year_[0]."-TGN/COMISION_CAPACITACION");
					mkdir($estructura."/".$filename."/".$year_[0]."-TGN/COMISION_TRABAJO");
					mkdir($estructura."/".$filename."/".$year_[0]."-TGN/SERVICIO_CIVIL");
					mkdir($estructura."/".$filename."/".$year_[0]."-TGN/OTROS");
					mkdir($estructura."/".$filename."/".$year_[0]."-TGN/INFORMES");
					*/
					//-------------------------permisos=1-PERMANENTE--------------------------------------------------
					$rs4=$db->query("update ".TABLE4." set permisos='1' where id_func='$id_func' ");					
					//-------------------------PERMANENTE TABLA DESHABILITAR--------------------------------------------------	
					$rs7=$db->query("update ".TABLE37." set p1='0',	p2='0',	p3='0',	p4='0',	p5='0',	p6='0',	p7='0',	p8='0',	p9='0',	p10='0' where id_func='$id_func'");		
					$msg="Se ha registrado correctamente al funcionario.";
					$swf=2;
					//-------------------------PERMANENTE TABLA DESHABILITAR--------------------------------------------------					
				}
				else
				{
					$num_cont=$_POST[num_cont];
					$charge_cont=strtoupper($_POST[charge_cont]);
					$date_start=cambia_dateN_to_dateMy_1($_POST[date_start]);
					$year=explode("-",$date_start);
					$date_end=cambia_dateN_to_dateMy_1($_POST[date_end]);	
					//			
					$rsver=$db->query("select * from ".TABLE22." where id_func='$id_func'");					
					if (mysql_num_rows($rsver)!=0)
					{
						$rsver1=$db->query("update ".TABLE22." set status='0' where id_func='$id_func'");						
					}
										
					$rs2=$db->query("insert into ".TABLE30." 
					(id_func, date_ent, date_end, status, name_con) values 
					('$id_func','$date_start','$date_end','1','$num_cont')");
					
					$rs5=$db->query("select id_con from ".TABLE30." order by id_con desc limit 1");
					$r5=$db->fetch_array($rs5);
					$id_contrato=$r5[id_con];
					
					$rs6=$db->query("insert into ".TABLE17." (id_con, source_fin) values ('$id_contrato','$fuente')");
													
					$rs3=$db->query("insert into ".TABLE31."
					(id_con, charge, date_des, num_res_con) values
					('$id_contrato','$charge_cont','$date_start','$num_cont')");	
					
					$estructura = 'files/';
					$nombres=explode(" ",$_POST[name]);
					$filename=ucfirst(strtolower($nombres[0])).ucfirst(strtolower($nombres[1])).ucfirst(strtolower($_POST[l_name1])).ucfirst(strtolower($_POST[l_name2]))."_".$dia.$mes.$ano."_".$ci;
									
					//mkdir($estructura.$filename, 0777, true);
					/*
					mkdir($estructura."/".$filename."/".$year[0]."-".$_POST[fuente]."-".$id_contrato);
					mkdir($estructura."/".$filename."/".$year[0]."-".$_POST[fuente]."-".$id_contrato."/DATOS_PERSONALES");
					mkdir($estructura."/".$filename."/".$year[0]."-".$_POST[fuente]."-".$id_contrato."/EVALUACION_INFORMES");
					mkdir($estructura."/".$filename."/".$year[0]."-".$_POST[fuente]."-".$id_contrato."/MEMORANDUMS");
					mkdir($estructura."/".$filename."/".$year[0]."-".$_POST[fuente]."-".$id_contrato."/ATRASOS");
					mkdir($estructura."/".$filename."/".$year[0]."-".$_POST[fuente]."-".$id_contrato."/COMISIONES");
					mkdir($estructura."/".$filename."/".$year[0]."-".$_POST[fuente]."-".$id_contrato."/PERMISOS_LICENCIAS");
					mkdir($estructura."/".$filename."/".$year[0]."-".$_POST[fuente]."-".$id_contrato."/OTROS");
					mkdir($estructura."/".$filename."/".$year[0]."-".$_POST[fuente]."-".$id_contrato."/NECESIDAD_CAPACITACION");			
					mkdir($estructura."/".$filename."/".$year[0]."-".$_POST[fuente]."-".$id_contrato."/IMPUESTOS");
					mkdir($estructura."/".$filename."/".$year[0]."-".$_POST[fuente]."-".$id_contrato."/CONTRATOS_Y_ADENDAS");
					mkdir($estructura."/".$filename."/".$year[0]."-".$_POST[fuente]."-".$id_contrato."/PROCESO");	
					*/
					//-------------------------permisos=2-CONSULTOR--------------------------------------------------
					$rs4=$db->query("update ".TABLE4." set permisos='2' where id_func='$id_func'");						
					//-------------------------CONSULTOR TABLA DESHABILITAR--------------------------------------------------	
					$rs7=$db->query("update ".TABLE37." set p1='0',	p2='0',	p3='0',	p4='0',	p5='0',	p6='0',	p7='0',	p8='0',	p9='0',	p10='0' where id_func='$id_func'");		
					$msg="Se ha registrado correctamente al funcionario.";
					$swf=3;
					//-------------------------CONSULTOR TABLA DESHABILITAR--------------------------------------------------												
				}	
				$sw=1;
			}
			else
			{
				$msg="Error al Registrar";
				$sw=2;
			}	
	}
	//echo "guardar form";
  }
  else
  {
	  //echo "no hace nada";
  }

}
echo '<link rel="stylesheet" type="text/css" media="screen" href="data/css/reportes.css" />';
if ($sw==1)
{
	echo '<div class="successre">'.$msg.', imprima los <strong>datos de acceso del funcionario</strong> <a href="PrintDataFun.php?type='.$swf.'&id_func='.$id_func.'" target="_blank" onClick="window.open(this.href,this.target, \'width=550, height=430\'); return false;">  AQUI </a></div>';
	exit;
}
if ($sw==2)
{
	echo '<div class="errorre">'.$msg.'</div>';
	exit;
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

<fieldset>
<legend>ALTA DE FUNCIONARIOS</legend>
<form id="form1" name="form1" method="post" action="" class="form">
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr>
      <th><div align="left">NOMBRES:</div></th>
      <td><div >      
        <input class="textarea_normal required"  name="name" type="text" id="name" size="45" value="<? echo $rexe[name]?>" />       
      </div></td>
    </tr>
    <tr>
      <th><div align="left">APELLIDO PATERNO:</div></th>
      <td><div >
        <input class="textarea_normal" name="l_name1" type="text"  id="l_name1" size="40" value="<? echo $rexe[l_name1]?>"  />
      </div></td>
    </tr>
    <tr>
      <th><div align="left">APELLIDO MATERNO:</div></th>
      <td><div >
        <input class="textarea_normal required" name="l_name2" type="text"  id="l_name2" size="40"  value="<? echo $rexe[l_name2]?>" />
      </div></td>
    </tr>
    <tr>
      <th><div align="left">CARNET DE INDENTIDAD:</div></th>
      <td><div >
        <input class="textarea_normal required number" name="ci" type="text"  id="ci" size="40" value="<? echo $rexe[ci]?>" />
      </div></td>
    </tr>
    <tr>
      <th><div align="left">EXPEDIDO:</div></th>
      <td><div >
        <select name="expe" id="expe" class="textarea_normal">
        <option value="0">-</option>
        <?
			if (isset($rexe[expe]))
			{
				switch ($rexe[expe])
				{	
					case 'LP':
						echo '<option value="LP" selected="selected">LA PAZ</option>';
					break;
					
					case 'OR':
						echo '<option value="OR" selected="selected">ORURO</option>';
					break;
					
					case 'PT':
						echo '<option value="PT" selected="selected">POTOSI</option>';
					break;
					
					case 'CBBA':
						echo '<option value="CBBA" selected="selected">COCHABAMBA</option>';
					break;
					
					case 'CH':
						echo '<option value="CH" selected="selected">CHUQUISACA</option>';
					break;
					
					case 'TJA':
						echo '<option value="TJA" selected="selected">TARIJA</option>';
					break;
					
					case 'PN':
						echo '<option value="PN" selected="selected">PANDO</option>';
					break;
					
					case 'BN':
						echo '<option value="BN" selected="selected">BENI</option>';
					break;
					
					case 'SCZ':
						echo '<option value="SCZ" selected="selected">SANTA CRUZ</option>';
					break;
				}			
			}
        ?>
          
          <option value="LP">LA PAZ</option>
          <option value="OR">ORURO</option>
          <option value="PT">POTOSI</option>
          <option value="CBBA">COCHABAMBA</option>
          <option value="CH">CHUQUISACA</option>
          <option value="TJA">TARIJA</option>
          <option value="PN">PANDO</option>
          <option value="BN">BENI</option>
          <option value="SCZ">SANTA CRUZ</option>
        </select>
      </div></td>
    </tr>
        <tr>
      <th><div align="left">FECHA NACIMIENTO:</div></th>
      <td><div >
        <input class="textarea_normal required" name="date_born" type="text"  id="date_born" size="25" value="<? echo cambia_dateMy_to_dateN($rexe[date_born])?>" />
      </div></td>
    </tr>
    <tr>
      <th><div align="left">FUENTE DE FINANCIAMIENTO:</div></th>
      <td><div >
       <select class="select_normal required" name="fuente" id="fuente" class="textarea_normal" > 
      <?
	  if (isset($_POST[fuente]))
	  {
		 echo '<option value="'.$_POST[fuente].'" selected="selected">'.$_POST[fuente].'</option>';
	  }
      ?>             
          <option value="TGN">TGN</option>
          <option value="TGN-252">TGN-252</option>
          <option value="CANASTA">CANASTA</option>
          <option value="UNICEF">UNICEF</option>
          <option value="COSUDE">COSUDE</option>
          <option value="ASDI">ASDI</option>
        </select>
      </div></td>
    </tr>
    <?
	if (isset($_POST[save]))
	{
		if ($_POST[fuente]=='TGN')
		{
			echo '<tr>
					<th><div align="left">FECHA DE INGRESO:</div></th>
					<td><div >
						<input type="text" class="datepick textarea_normal required" name="start_date" id="start_date" />
						</div>
					</td>
				</tr>
				<tr>
    			<th><div align="left">CARGO:</div></th>
    			<td><div >		
		  			<input class="textarea_normal required" type="text" name="charge_" id="charge_" size="50" /></div>
					<input type="hidden" value="1" name="key_form" id="key_form">
	  			</td>	
				</tr>';	
		}
		else
		{
			echo '<tr>
					<th><div align="left">NUMERO CONTRATO:</div></th>
					<td><div >		
						<input type="text" class="textarea_normal required" name="num_cont" id="num_cont" />	</div>
					</td>		
				</tr>
				<tr>
					<th><div align="left">CARGO:</div></th>
					<td><div >		
						<input class="textarea_normal required" name="charge_cont" type="text" id="charge_cont" size="50" />						
						</div>
					</td>		
				</tr>
				<tr>
					<th><div align="left">FECHA INICIO:</div></th>
					<td><div >
						<input type="text" class="datepick textarea_normal required" name="date_start" id="date_start" />
						</div>
				   	</td>
				</tr>
				<tr>
					<th><div align="left">FECHA FIN:</div></th>
					<td><div >		
						<input type="text" class="datepick textarea_normal required" name="date_end" id="date_end" />	
						</div>
						<input type="hidden" value="1" name="key_form" id="key_form">
					</td>		
				</tr>';
			}			
	}
    ?>   
<!--    <tr>	
      <td><div align="left">FECHA DE INGRESO:</div></td>
        <td><div align="left"><span >
          <input class="datepick textarea_normal" name="date_ent" type="text"  id="date_born2" size="25" />
        </span></div></td>
    </tr>-->
    <tr>
      <td colspan="2"><div align="right" >

        <input type="submit" class="submit" name="save" id="save" value="Guardar" />
      </div>
      </td>
    </tr>    
    
    
    
  </table>
</form>
</fieldset>
<?
$db->close();
?>
