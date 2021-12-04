<?
require_once("security.php");
$id_func=$_GET['id_func'];
$id_con=$_GET['id_con'];

/*while ($post = each($_POST))
{
echo $post[0] . " = " . $post[1]."<br>";
}*/
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
if (isset($_POST[save]))
{ 	
//TABLA cta_banc
//id_cta_banc id_func bank type_ac num_ac dist_ac
$bank=strtoupper($_POST[bank]); 
$type_ac=$_POST[type_ac]; 
$num_ac=$_POST[num_ac]; 
$dist_ac=strtoupper($_POST[dist_ac]);
$id_cons_docs=$_POST[id_cons_docs];

//TABLE consultor_docs
//id_perm_docs id_cont contract addendum file_pers pers_dat_incomp
//per_dat_conf cv ci date_cad_ci cn cm afp solvency
$cv=$_POST[cv]; 
$ci=$_POST[ci];  
$date_cad_ci=$_POST[date_cad_ci];

$cn=$_POST[cn];  
$cm=$_POST[cm];  
//TABLE char_con
//id_char_con
$dir_g=strtoupper($_POST[dir_g]); 
$unit=strtoupper($_POST[unit]); 
$area=strtoupper($_POST[area]); 
$boss_is=strtoupper($_POST[boss_is]); 
$boss_ij=strtoupper($_POST[boss_ij]); 
$charge=strtoupper($_POST[charge]); 
$num_res_con=strtoupper($_POST[num_res_con]);
$date_di=$_POST[date_di];

//$date_di=cambia_dateN_to_dateMy_1($date_di);
//TABLE contrato
//$date_ent $date_end $ name_con

	$date_ent=$_POST[date_ent];
	$date_end=$_POST[date_end];
	$name_con=strtoupper($_POST[name_con]);
//TABLA cta_banc
//id_cta_banc id_func bank type_ac num_ac dist_ac
	$rs1=$db->query("
	UPDATE ".TABLE25." SET
	bank='$bank', type_ac='$type_ac', num_ac='$num_ac', dist_ac='$dist_ac'
	WHERE id_cta_banc='$id_cta_banc'
	");
	
	
	
//TABLE permanente_docs
//id_perm_docs id_per memo file_pers pers_dat_incomp pers_dat_conf
//cv ci date_cad_ci cn cm afp solvency ins_fund

	$rs2=$db->query("
	UPDATE ".TABLE32." SET
	cv='$cv', ci='$ci', date_cad_ci='$date_cad_ci', cn='$cn', cm='$cm'
	WHERE id_cons_docs='$id_cons_docs'
	");
//TABLE char_con
//id_char_con id_per dir_g unit area boss_is boss_ij charge date_des num_memo
//-----------------------------
	$rs3=$db->query("
	UPDATE ".TABLE31." 
	SET
	dir_g='$dir_g', unit='$unit', area='$area', boss_is='$boss_is', boss_ij='$boss_ij', charge='$charge', num_res_con='$num_res_con'
	WHERE id_con = '$id_con'	
	");
//TABLE contrato
//id_char_con id_per dir_g unit area boss_is boss_ij charge date_des num_memo
//-----------------------------
	$rs4=$db->query("
	UPDATE ".TABLE30." 
	SET 
	date_ent='$date_ent',date_end='$date_end', name_con='$name_con' 
	WHERE id_func = '$id_func'
	AND id_con = '$id_con'	
	");
//TABLE ULTIMA DECLARACION	
	$rs5=$db->query("
	UPDATE ".TABLE27." SET
	date_di='$date_di'
	WHERE id_ult_decl='$id_ult_decl'
	");	
	
	
	
	//-------------DESABILITAR TABLA------------
//	$rs7=$db->query("
	//UPDATE ".TABLE37." SET p7='$on_off'
	//WHERE id_func='$id_func'
	//");	
//	header ("Location: exito.php");	
	//----------------------------------------	
	
//-----------------------------
	if(!$rs&&!$rs1&&!$rs2&&!$rs3&&!$rs4&&!$rs7)
	{
	exit;
	}
//	echo "verdad";
//	header ("Location: exito.php");	
}

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FORMULARIO DE REGISTRO</title>
<link href="data/css/style-ext.css" rel="stylesheet" type="text/css"><link rel="stylesheet" type="text/css" media="screen" href="css/screen.css" />

<script src="data/js/jquery-1.7.1.min.js"></script>
<!--<script src="js/jquery.js" type="text/javascript"></script>-->
<script src="js/jquery.metadata.js" type="text/javascript"></script>
<script src="js/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">
$.metadata.setType("attr", "validate");
$(document).ready(function() {
	$("#form1").validate();	
});
</script>
<link rel="stylesheet" href="data/css/ui/admincp/jquery-ui-1.8.17.custom.css">
<link rel="stylesheet" href="../../themes/base/jquery.ui.all.css">
<link href="css/reportes.css" rel="stylesheet" type="text/css">
	<!--<script src="data/js/jquery-1.7.1.min.js"></script>-->
	<script src="data/js/ui/jquery.ui.core.js"></script>
	<script src="data/js/ui/jquery.ui.widget.js"></script>
	<script src="data/js/ui/jquery.ui.datepicker.js"></script>
	<script>
	$(function() {
		$( ".datepick" ).datepicker({
			showOn: "button",
			buttonImage: "data/images/calendar.gif",
			buttonImageOnly: true, changeMonth: true, changeYear: true, yearRange: '-100:+100',
		});
	});
	</script>
<script>
function probar(){
if (!(confirm('¿Esta seguro de GUARDAR esta información, ya que luego NO PODRÁ MODIFICARLA? \n\rHaga click en "CANCELAR" si desea Revisar sus Datos, si está seguro del contenido de la información que esta enviando haga click en "ACEPTAR"'))){ 
       return false; 
	   
	   } 
}
</script>
</head>
<?
//----------------------CTA BANC
$rx3=$db->query("
SELECT * FROM ".TABLE25."
WHERE id_func = '$id_func'
");
$rsx3=$db->fetch_array($rx3);	
//-----------------------------CONTRATO--------------------------
	$rs=$db->query("
	SELECT * FROM ".TABLE30." 
	WHERE id_func = '$id_func'
	AND id_con = '$id_con'
	");
	$rex=$db->fetch_array($rs);
//-----------------------------CARGO--------------------------
	$rsa=$db->query("
	SELECT * FROM ".TABLE31." 
	WHERE id_con = '$id_con'
	");
	$rexa=$db->fetch_array($rsa);
//----------------------CONSULTOR DOCS
$rx4=$db->query("
SELECT * FROM ".TABLE30." ,".TABLE32." 
WHERE ".TABLE30.".id_con = '$id_con'
AND status = '1'
AND ".TABLE32.".id_con = '$id_con'
ORDER BY id_cons_docs DESC LIMIT 1 
");
$rsx4=$db->fetch_array($rx4);	
	//----------------------ULTIMA DECLARACION JURADA
$rx5=$db->query("
SELECT * FROM ".TABLE27."
WHERE id_func = '$id_func'
");
$rsx5=$db->fetch_array($rx5);
	
?>
<body id="bd">
<form id="form1" name="form1" method="post" action="">
<table width="990" border="0" align="center" cellpadding="2" cellspacing="0">
<!--DATOS ANTIGUEDAD-->
<table width="990" border="0" align="center" cellpadding="2" cellspacing="0">
  <th width="900"><h2 align="left">DATOS DONDE SE ABONA SU SUELDO</h2></th>
</table>
<table width="990" border="0" align="center" cellpadding="2" cellspacing="0">
  <td>
	<table id="ftab" width="400" border="0" align="left" cellpadding="2" cellspacing="0">
        <tr>
            <td width="100">BANCO:<br></td>
            <td width="100">TIPO DE CUENTA:<br></td>
            <td width="100">NÚMERO DE CUENTA:<br></td>
            <td width="10">DISTRITO EN LA QUE SE APERTURÓ:<br></td>
         </tr>
        <tr>
            <td width="204">
                	<input name="id_cta_banc" type="hidden" id="id_cta_banc" size="25" maxlength="64" value="<? echo "$rsx3[id_cta_banc]" ?>" />
    	<input name="bank" type="text" id="bank" size="25" maxlength="64" value="<? echo "$rsx3[bank]" ?>" />
            </td>
            <td width="122">
                <select name="type_ac" id="type_ac" >
           	<option value="<? echo "$rsx3[type_ac]" ?>"><? echo "$rsx3[type_ac]" ?></option>
			<option value="CTA. CTE.">CTA. CTE.</option>        
            <option value="CAJA AHORRO">CAJA AHORRO</option>
	    </select>
        
            </td>
            <td width="131">
                <input name="num_ac" type="text" id="num_ac" size="15" maxlength="64" value="<? echo "$rsx3[num_ac]" ?>" />

            </td>
            <td width="160">
                <input name="dist_ac" type="text" id="dist_ac" size="15" maxlength="64" value="<? echo "$rsx3[dist_ac]" ?>" />
            </td>
        </tr>    

	</table>
  </td>
</table>



<!--FECHAS DE -->
<table width="990" border="0" align="center" cellpadding="2" cellspacing="0">
  <th width="669"><h2 align="left">DOCUMENTACIÓN ENTREGADA</h2></th>
<th width="335"><h2 align="left">ÚLTIMAS FECHAS DE</h2></th>
</table>
<table width="990" border="0" align="center" cellpadding="2" cellspacing="0">
<td>
<table width="528" border="0" align="left" cellpadding="2" cellspacing="0">
	<tr>
 		<td width="94">CURRICULUM VITAE:</td>	
		<td width="102">FOTOCOPIA C.I.:</td>	
		<td width="124">FECHA DE CADUCIDAD:</td>	
		<td width="91">FOTOCOPIA CERT. NAC.:</td>	
		<td width="95">FOTOCOPIA CERT. MAT.:</td>	
	
	<tr>	
 		<td width="94">
			<input name="id_cons_docs" type="hidden" id="id_cons_docs" size="10" maxlength="64" value="<? echo "$rsx4[id_cons_docs]" ?>"/>
         <select name="cv" id="cv" >
           	<option value="<? echo "$rsx4[cv]" ?>"><? if($rsx4[cv]==0) echo "NO"; else echo "SI"; ?></option>
			<option value="0">NO</option>        
            <option value="1">SI</option>
	    </select>
		</td>	
		<td width="102">
			<select name="ci" id="ci" >
           	<option value="<? echo "$rsx4[ci]" ?>"><? if($rsx4[ci]==0) echo "NO"; else echo "SI"; ?></option>
			<option value="0">NO</option>        
            <option value="1">SI</option>
	    </select>
		</td>	
		<td width="124">
<input name="date_cad_ci" type="text" id="date_cad_ci" size="10" maxlength="64" value="<? echo "$rsx4[date_cad_ci]" ?>"/>
		</td>	
		<td width="91">
			<select name="cn" id="cn" >
           	<option value="<? echo "$rsx4[cn]" ?>"><? if($rsx4[cn]==0) echo "NO"; else echo "SI"; ?></option>
			<option value="0">NO</option>        
            <option value="1">SI</option>
	    </select>
		</td>	
		<td width="95">
			<select name="cm" id="cm" >
           	<option value="<? echo "$rsx4[cm]" ?>"><? if($rsx4[cm]==0) echo "NO"; else echo "SI"; ?></option>
			<option value="0">NO</option>        
            <option value="1">SI</option>
	    </select>
		</td>	
                
	</tr>
    </table>    	        
</td>	 
<td>
<table width="380" border="0" align="left" cellpadding="2" cellspacing="0">
	<tr>
  	<td>DECLARACIÓN JURADA DE INCOMPATIBILIDAD:</td>
	</tr>
		<td width="160">
        <input name="id_ult_decl" type="hidden" id="id_ult_decl" size="15" maxlength="64" value="<? echo "$rsx5[id_ult_decl]" ?>"/>        
    		<input name="date_di" type="text" id="date_di" size="15" maxlength="64" value="<? echo "$rsx5[date_di]" ?>"/>
		</td>        
    </tr>
</table>    	        
</td>	                
</table>
<!--DATOS DEL CARGO ACTUAL QUE DESEMPEÑA-->
<table width="990" border="0" align="center" cellpadding="2" cellspacing="0">
<th><h2 align="left">DATOS DEL CARGO ACTUAL QUE DESEMPEÑA</h2></th>
</table>
<table width="990" border="0" align="center" cellpadding="2" cellspacing="0">
<tr> 		
        <td width="233">DIRECCION GENERAL:</td>	
		<td width="244">UNIDAD:</td>	
		<td width="247">ÁREA:</td>	
		<td width="250">JEFE INMEDIATO SUPERIOR:</td>	
</tr>
<tr> 		
                <td width="233">
               <input name="id_char_con" type="hidden" id="id_char_con" size="15" maxlength="64" value="<? echo "$rsx2[id_char_con]" ?>"/>        
    		<input name="dir_g" type="text" id="dir_g" size="35" value="<? echo "$rexa[dir_g]" ?>"/>
                
                
        </td>	
		<td width="244">
          <input name="unit" type="text" id="unit" size="35"  value="<? echo "$rexa[unit]" ?>"/>
        
        </td>	
		<td width="247">
        <input name="area" type="text" id="area" size="35"  value="<? echo "$rexa[area]" ?>"/>
        </td>	
        <td width="250"><input name="boss_is" type="text" id="boss_is" size="30" maxlength="64" value="<? echo "$rexa[boss_is]"?>"/></td>
</tr>
<tr> 		
        <td width="233">JEFE SUPERIOR JERÁRQUICO:</td>	
		<td width="244">CARGO:</td>	
		<td width="250">Nº RESOLUCIÓN O MEMO:</td>
<tr> 		
        <td width="233">
        <input name="boss_ij" type="text" id="boss_ij" size="30" maxlength="64" value="<? echo "$rexa[boss_ij]"?>"/>
        
        </td>	
		<td width="244"><input  name="charge" cols="30" rows="2" id="charge" value="<? echo "$rexa[charge]"?>"/></td>	
		<td width="250"><input name="num_res_con" type="text" id="num_res_con" size="30" maxlength="64" value="<? echo $rexa[num_res_con];?>"  /></td>	
</tr>
</table>
<!--SOLO PARA CONTRATOS EVENTUALES/CONSULTORES-->
<table width="990" border="0" align="center" cellpadding="2" cellspacing="0">
<th><h2 align="left">SOLO PARA CONSULTORES</h2></th>
</table>
<table width="990" border="0" align="center" cellpadding="2" cellspacing="0">
  <td>
  <table width="400" border="0" align="left" cellpadding="2" cellspacing="0">
<tr> 		
        <td width="212">FECHA DE INICIO DE CONTRATO:</td>	
		<td width="250">FECHA FINAL DE CONTRATO</td>	
		<td width="191">NÚMERO DE CONTRATO</td>	
</tr>
<tr> 		
        <td width="212"><input name="date_ent" type="text" id="date_ent"  value="<? echo $rex[date_ent];?>" size="10" maxlength="64" />
        </td>	
		<td width="250"><input name="date_end" type="text" id="date_end"  value="<? echo $rex[date_end];?>" size="10" maxlength="64" /></td>	
		<td width="191"><input name="name_con" type="text" id="name_con" value="<? echo $rex[name_con];?>" size="20" maxlength="64" /></td>	
</tr>
    <tr>
  	<td>
    <input type="submit" class="submit"  name="save" id="loginbutton" value="Guardar" />
    </td>
 	</tr>
</table>
</td>
</table>
</form>
<?
//$db->close();
?>

</body>
</html>