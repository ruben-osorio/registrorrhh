<?
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
$sw=0;
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
	$username= "$l_name1[0]"."$l_name2[0]"."$name[0]"."$dia"."$mes"."$ano";
	
	$date_born=cambia_dateN_to_dateMy_1($date_born);	
	
	$rsex=$db->query("SELECT id FROM ".TABLE4." WHERE username='$username'");
	$rex=$db->fetch_array($rsex);
	//echo mysql_num_rows($rsex);
	if (mysql_num_rows($rsex)!=0)
	{	
		echo "El Nombre de Usuario y funcionario ya existe, no se puede completar la operación";
		$sw=2;
		exit;
	}	
  //id id_func username password permisos type fuente
  //name, l_name1, l_name2, ci, expe TABLE2
	
	$fuente=$_POST[fuente];	
	//$date_ent=cambia_dateN_to_dateMy_1($date_ent);	
	
	//id id_func username password permisos type TABLE4
  //name, l_name1, l_name2, ci, expe, date_born TABLE2
  if (isset($_POST[key_form]))
  {
	if ($_POST[key_form])
	{
		/*echo "insert into ".TABLE2." 
		(name, l_name1, l_name2, ci, expe, date_born) 
		VALUES 
		('$name','$l_name1','$l_name2','$ci','$expe','$date_born')";*/
		//TABLA2 FUNCIONARIO
		$rs=$db->query("insert into ".TABLE2." 
		(name, l_name1, l_name2, ci, expe, date_born, estado) 
		VALUES 
		('$name','$l_name1','$l_name2','$ci','$expe','$date_born', '1')");
		if ($rs)
		{
			//echo "select id from ".TABLE2." order by id desc limit 1<br />";
						
			$rs1=$db->query("select id_func from ".TABLE2." order by id_func desc limit 1");
			$r1=$db->fetch_array($rs1);
			$id_func=$r1[id_func];			
			
			if (strcmp("TGN",$fuente) == 0)
			{
				
				$charge_=$_POST[charge_];
				$start_date=cambia_dateN_to_dateMy_1($_POST[start_date]);
				$year_=explode("-",$start_date);
				
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

                $rsX=$db->query("insert into char_per
				(id_per) values
				('$id_permanente')");
				
				$g1_i=explode("-",$start_date);			
				$g1_f=$g1_i[0]+1;
				$g1=$g1_i[0]."-".$g1_f;		

				$db = new Database(DB_SERVER, DB_USER, DB_PASS, "ssrp");
				$db->connect();
				$rs1=$db->query("insert into ".TABLE3." (id_funcionario, id_per, gestion_1, dias_g1, gestion_2, dias_g2, observaciones)
				VALUES ('$id_func','$id_permanente','$g1','0','','','')");
				
				
				$rsx=$db->query("insert into cat_per ( id_per)
				VALUES ('$id_permanente')");
				
				
				$estructura = 'files/';
				$filename=ucfirst(strtolower(str_replace(' ','',$_POST[name]))).ucfirst(strtolower($_POST[l_name1])).ucfirst(strtolower($_POST[l_name2]))."_".$dia.$mes.$ano."_".$ci;				
				mkdir($estructura.$filename, 0777, true);
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
				//-------------------------permisos=1-PERMANENTE--------------------------------------------------
				$db = new Database(DB_SERVER, DB_USER, DB_PASS, "registroRRHH");
				$db->connect();
				$rs4=$db->query("insert into ".TABLE4." (id_func, username, password, nombre, ap_1, ap_2,permisos)
				VALUES ('$id_func','$username','$ci','$name','$l_name1','$l_name2','1')");		
				//-------------------------permisos=1-PERMANENTE--------------------------------------------------				
				//-------------------------PERMANENTE TABLA DESHABILITAR--------------------------------------------------	
				$rs7=$db->query("insert into ".TABLE37." (id_func)
				VALUES ('$id_func')");		
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
								
				mkdir($estructura.$filename, 0777, true);
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
				//-------------------------permisos=2-CONSULTOR--------------------------------------------------
				$rs4=$db->query("insert into ".TABLE4." (id_func, username, password, nombre, ap_1, ap_2,permisos)
				VALUES ('$id_func','$username','$ci','$name','$l_name1','$l_name2','2')");		
				//-------------------------permisos=2-CONSULTOR--------------------------------------------------	
				//-------------------------CONSULTOR TABLA DESHABILITAR--------------------------------------------------	
				$rs7=$db->query("insert into ".TABLE37." (id_func)
				VALUES ('$id_func')");		
				$msg="Se ha registrado correctamente al funcionario.";
				$swf=3;
				//-------------------------CONSULTOR TABLA DESHABILITAR--------------------------------------------------	
				
										
			}
	
/*			$rs4=$db->query("insert into ".TABLE4." (id_func, username, password, nombre, ap_1, ap_2,permisos)
			VALUES ('$id_func','$username','$ci','$name','$l_name1','$l_name2','1')");		
			$msg="Registrado Correctamente";
*/
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
	echo '<div class="successre">'.$msg.', imprima los <strong>datos de acceso del funcionario</strong> <a href="PrintDataFun.php?type='.$swf.'&id_func='.$id_func.'" target="_blank" onClick="window.open(this.href,this.target, \'width=550, height=500\'); return false;">  AQUI </a></div>';
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
<legend>REGISTRO INICIAL DE FUNCIONARIOS</legend>
<form id="form1" name="form1" method="post" action="" class="form">
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr>
      <th><div align="left">NOMBRES:</div></th>
      <td><div >      
        <input class="textarea_normal required"  name="name" type="text" id="name" size="45" value="<? echo $name?>" />
    
      </div></td>
    </tr>
    <tr>
      <th><div align="left">APELLIDO PATERNO:</div></th>
      <td><div >
        <input class="textarea_normal" name="l_name1" type="text"  id="l_name1" size="40" value="<? echo $l_name1?>"  />
      </div></td>
    </tr>
    <tr>
      <th><div align="left">APELLIDO MATERNO:</div></th>
      <td><div >
        <input class="textarea_normal required" name="l_name2" type="text"  id="l_name2" size="40"  value="<? echo $l_name2?>" />
      </div></td>
    </tr>
    <tr>
      <th><div align="left">CARNET DE INDENTIDAD:</div></th>
      <td><div >
        <input class="textarea_normal required number" name="ci" type="text"  id="ci" size="40" value="<? echo $ci ?>" />
      </div></td>
    </tr>
    <tr>
      <th><div align="left">EXPEDIDO:</div></th>
      <td><div >
        <select name="expe" id="expe" class="textarea_normal">
        <option value="0">-</option>
        <?
			if (isset($expe))
			{
				switch ($expe)
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
        <input class="datepick textarea_normal required" name="date_born" type="text"  id="date_born" size="25" value="<? echo $_POST[date_born] ?>" />
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
          <option value="PLANTA">10</option>
		  <option value="PERSONAL EVENTUAL">PERSONAL EVENTUAL</option>
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
