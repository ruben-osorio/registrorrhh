<?
require_once("security.php");
$id_func=$_GET['id_func'];
/*while ($post = each($_POST))
{
echo $post[0] . " = " . $post[1]."<br>";
}
echo "<br>";
echo $desc_o;
echo "<br>";
*/
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
//----------HABILITAR TABLA-------------
	$rsp1=$db->query("
	SELECT p4 FROM ".TABLE37." 
	WHERE id_func='$id_func'
	");
	$rsxp1=$db->fetch_array($rsp1);
	if($rsxp1[p4]==1)
	{
	header ("Location: exito.php");	
	}
//--------------------------------------


if (isset($_POST[save]))
{ 
//echo "error";		
//Tlang_func
//descp read_l speak_l write_l 
//descp1 read_l1 speak_l1 write_l1 
//descp2 read_l2 speak_l2 write_l2 
//descp3 read_l3 speak_l3 write_l3 
//descp4 read_l4 speak_l4 write_l4 
//TABLA ot_con 
//desc_o level 
//desc_o1 level1 
//desc_o2 level2 
//desc_o3 level3 
//desc_o4 level4 
//TABLA doc_uni
//univ  asign career  date_start date_end 
//univ1 asign1 career1 date_start1 date_end1
//univ2 asign2 career2 date_start2 date_end2 
//univ3 asign3 career3 date_start3 date_end3 
//univ4 asign4 career4 date_start4 date_end4
//echo "<br>";
//echo $desc_o;
//echo "<br>";
$descp=strtoupper($_POST[descp]);
$read_l=strtoupper($_POST[read_l]);
$speak_l=strtoupper($_POST[speak_l]);
$write_l=strtoupper($_POST[write_l]);
$descp1=strtoupper($_POST[descp1]);
$read_l1=strtoupper($_POST[read_l1]);
$speak_l1=strtoupper($_POST[speak_l1]);
$write_l1=strtoupper($_POST[write_l1]);
$descp2=strtoupper($_POST[descp2]);
$read_l2=strtoupper($_POST[read_l2]);
$speak_l2=strtoupper($_POST[speak_l2]);
$write_l2=strtoupper($_POST[write_l2]);
$descp3=strtoupper($_POST[descp3]);
$read_l3=strtoupper($_POST[read_l3]);
$speak_l3=strtoupper($_POST[speak_l3]);
$write_l3=strtoupper($_POST[write_l3]);
$descp4=strtoupper($_POST[descp4]);
$read_l4=strtoupper($_POST[read_l4]);
$speak_l4=strtoupper($_POST[speak_l4]);
$write_l4=strtoupper($_POST[write_l4]);
//TABLA ot_con 

$desc_o=strtoupper($_POST[desc_o]); 

$level=strtoupper($_POST[level]); 
$desc_o1=strtoupper($_POST[desc_o1]);
$level1=strtoupper($_POST[level1]);
$desc_o2=strtoupper($_POST[desc_o2]);
$level2=strtoupper($_POST[level2]);
$desc_o3=strtoupper($_POST[desc_o3]);
$level3=strtoupper($_POST[level3]);
$desc_o4=strtoupper($_POST[desc_o4]);
$level4=strtoupper($_POST[level4]);
//TABLA doc_uni
$univ= strtoupper($_POST[univ]);
$asign=strtoupper($_POST[asign]);
$career=strtoupper($_POST[career]);
$date_start=$_POST[date_start];
$date_end=$_POST[date_end]; 
$date_start=cambia_dateN_to_dateMy_1($date_start);	
$date_end=cambia_dateN_to_dateMy_1($date_end);
$univ1= strtoupper($_POST[univ1]);
$asign1=strtoupper($_POST[asign1]);
$career1=strtoupper($_POST[career1]);
$date_start1=$_POST[date_start1];
$date_end1=$_POST[date_end1]; 
$date_start1=cambia_dateN_to_dateMy_1($date_start1);	
$date_end1=cambia_dateN_to_dateMy_1($date_end1);
$univ2= strtoupper($_POST[univ2]);
$asign2=strtoupper($_POST[asign2]);
$career2=strtoupper($_POST[career2]);
$date_start2=$_POST[date_start2];
$date_end2=$_POST[date_end2]; 
$date_start2=cambia_dateN_to_dateMy_1($date_start2);	
$date_end2=cambia_dateN_to_dateMy_1($date_end2);
$univ3= strtoupper($_POST[univ3]);
$asign3=strtoupper($_POST[asign3]);
$career3=strtoupper($_POST[career3]);
$date_start3=$_POST[date_start3];
$date_end3=$_POST[date_end3]; 
$date_start3=cambia_dateN_to_dateMy_1($date_start3);	
$date_end3=cambia_dateN_to_dateMy_1($date_end3);
$univ4= strtoupper($_POST[univ4]);
$asign4=strtoupper($_POST[asign4]);
$career4=strtoupper($_POST[career4]);
$date_start4=$_POST[date_start4];
$date_end4=$_POST[date_end4]; 
$date_start4=cambia_dateN_to_dateMy_1($date_start4);	
$date_end4=cambia_dateN_to_dateMy_1($date_end4);
$on_off=1;
//-----------------------------
//Tlang_func
//descp read_l speak_l write_l 
//descp1 read_l1 speak_l1 write_l1 
//descp2 read_l2 speak_l2 write_l2 
//descp3 read_l3 speak_l3 write_l3 
//descp4 read_l4 speak_l4 write_l4 
//TABLA ot_con 
//desc_o level 
//desc_o1 level1 
//desc_o2 level2 
//desc_o3 level3 
//desc_o4 level4 
//TABLA doc_uni
//univ  asign career  date_start date_end 
//univ1 asign1 career1 date_start1 date_end1
//univ2 asign2 career2 date_start2 date_end2 
//univ3 asign3 career3 date_start3 date_end3 
//univ4 asign4 career4 date_start4 date_end4
/*	echo "
	INSERT INTO ".TABLE11."id_func,descp, read_l, speak_l, write_l, descp1, read_l1, speak_l1, write_l1, descp2, read_l2, speak_l2, write_l2,descp3, read_l3, speak_l3, write_l3, descp4, read_l4, speak_l4, write_l4 
	VALUES 
	'$id_func','$descp', '$read_l', '$speak_l', '$write_l', '$descp1', '$read_l1', '$speak_l1', '$write_l1', '$descp2', '$read_l2', '$speak_l2', '$write_l2', '$descp3', '$read_l3', '$speak_l3', '$write_l3', '$descp4', '$read_l4', '$speak_l4', '$write_l4'
	INSERT INTO ".TABLE12." 
	(id_func, desc_o, level, desc_o1, level1,desc_o2, level2, desc_o3, level3, desc_o4, level4) VALUES 
	('$desc_o', '$level', '$desc_o1', '$level1', '$desc_o2', '$level2', '$desc_o3', '$level3', '$desc_o4', '$level4')
	INSERT INTO ".TABLE13." 
	(univ, asign, career, date_start, date_end, univ1, asign1, career1, date_start1, date_end1, univ2, asign2, career2, date_start2, date_end2, univ3, asign3, career3, date_start3, date_end3, univ4, asign4, career4, date_start4, date_end4) VALUES 
	('$univ', '$asign', '$career', '$date_start', '$date_end', '$univ1', '$asign1', '$career1', '$date_start1', '$date_end1', '$univ2', '$asign2', '$career2', '$date_start2', '$date_end2', '$univ3', '$asign3', '$career3', '$date_start3', '$date_end3', '$univ4', '$asign4', '$career4', '$date_start4', '$date_end4')
	";*/
	$rs=$db->query("
	INSERT INTO ".TABLE11." 
	(id_func, descp, read_l, speak_l, write_l, descp1, read_l1, speak_l1, write_l1, descp2, read_l2, speak_l2, write_l2,descp3, read_l3, speak_l3, write_l3, descp4, read_l4, speak_l4, write_l4)
	VALUES 
	('$id_func','$descp', '$read_l', '$speak_l', '$write_l', '$descp1', '$read_l1', '$speak_l1', '$write_l1', '$descp2', '$read_l2', '$speak_l2', '$write_l2', '$descp3', '$read_l3', '$speak_l3', '$write_l3', '$descp4', '$read_l4', '$speak_l4', '$write_l4')
	");
	$rs1=$db->query("
	INSERT INTO ".TABLE12." 
	(id_func, desc_o, level, desc_o1, level1,desc_o2, level2, desc_o3, level3, desc_o4, level4)
	VALUES 
	('$id_func','$desc_o', '$level', '$desc_o1', '$level1', '$desc_o2', '$level2', '$desc_o3', '$level3', '$desc_o4', '$level4')
	");
	 $rs2=$db->query("
	INSERT INTO ".TABLE13." 
	(id_func, univ, asign, career, date_start, date_end, univ1, asign1, career1, date_start1, date_end1, univ2, asign2, career2, date_start2, date_end2, univ3, asign3, career3, date_start3, date_end3, univ4, asign4, career4, date_start4, date_end4)
	VALUES 
	('$id_func','$univ', '$asign', '$career', '$date_start', '$date_end', '$univ1', '$asign1', '$career1', '$date_start1', '$date_end1', '$univ2', '$asign2', '$career2', '$date_start2', '$date_end2', '$univ3', '$asign3', '$career3', '$date_start3', '$date_end3', '$univ4', '$asign4', '$career4', '$date_start4', '$date_end4')
	");
	//-------------DESABILITAR TABLA------------
	$rs3=$db->query("
	UPDATE ".TABLE37." SET p4='$on_off'
	WHERE id_func='$id_func'
	");	
	header ("Location: exito.php");	
//-----------------------------------
	 
	if(!$rs)
	{echo "error";
	}
//	echo "verdad";
header ("Location: exito.php");		
}

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FORMULARIO DE REGISTRO</title>
<link href="data/css/style-ext.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" media="screen" href="css/screen.css" />
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
<script>
function probar(){
if (!(confirm('¿Esta seguro de GUARDAR esta información, ya que luego NO PODRÁ MODIFICARLA? \n\rHaga click en "CANCELAR" si desea Revisar sus Datos, si está seguro del contenido de la información que esta enviando haga click en "ACEPTAR"'))){ 
       return false; 
	   
	   } 
}
</script>

</head>

<body id="bd">


<link rel="stylesheet" href="data/css/ui/admincp/jquery-ui-1.8.17.custom.css">
<link rel="stylesheet" href="../../themes/base/jquery.ui.all.css">
<link href="estilo.css" rel="stylesheet" type="text/css" />
	<!--<script src="data/js/jquery-1.7.1.min.js"></script>-->
	<script src="data/js/ui/jquery.ui.core.js"></script>
	<script src="data/js/ui/jquery.ui.widget.js"></script>
	<script src="data/js/ui/jquery.ui.datepicker.js"></script>
	<script>
	$(function() {
		$( ".datpick" ).datepicker({
			showOn: "button",
			buttonImage: "data/images/calendar.gif",
			buttonImageOnly: true, changeMonth: true, changeYear: true, yearRange: '-100:+0',
		});
	});
	</script>
<form id="form" name="form" method="post" action="">
<table width="990" border="0" align="center" cellpadding="2" cellspacing="0">
<td width="581"><h2><img src="data/images/idi.jpg" width="580" height="50" /></h2></td>
<td width="401"><h2><img src="data/images/otcon.jpg" width="400" height="50" /></h2></td>
</table>
<table width="1005" border="0" align="center" cellpadding="2" cellspacing="0">
 <td width="567">
<table id="ftab" width="557" border="0" align="center" cellpadding="2" cellspacing="0">
 <tr>
  	<td width="226">DESCRIPCIÓN:</td>
    <td width="106">LEE:</td>
    <td width="104">HABLA:</td>
    <td width="105">ESCRIBE:</td>
 </tr>
 <tr>
  	<td>
  		<input name="descp" type="text" id="descp" size="35" maxlength="64" />
   	</td>
	<td>
	    <select name="read_l" id="read_l" >
          <option value="-">-</option>
          <option value="BUENO">BUENO</option>
          <option value="REGULAR">REGULAR</option>
          <option value="MALO">MALO</option>
    	</select>
    </td>    
   	<td>
    	<select name="speak_l" id="speak_l" >
            <option value="-">-</option>
   	  		<option value="BUENO">BUENO</option>
   	  		<option value="REGULAR">REGULAR</option>
   	  		<option value="MALO">MALO</option>
  	  </select></td>    
	<td>
        <select name="write_l" id="write_l" >
            <option value="-">-</option>
            <option value="BUENO">BUENO</option>
            <option value="REGULAR">REGULAR</option>
            <option value="MALO">MALO</option>
        </select>
    </td>     
<tr>
  	<td>
  		<input name="descp1" type="text" id="descp1" size="35" maxlength="64" />
   	</td>
	<td>
    	<select name="read_l1" id="read_l1" >
          <option value="-">-</option>
          <option value="BUENO">BUENO</option>
          <option value="REGULAR">REGULAR</option>
          <option value="MALO">MALO</option>
	    </select>
    </td>    
   	<td>
    	<select name="speak_l1" id="speak_l1" >
          <option value="-">-</option>
          <option value="BUENO">BUENO</option>
          <option value="REGULAR">REGULAR</option>
          <option value="MALO">MALO</option>
		</select>
    </td>    
	<td>
    	<select name="write_l1" id="write_l1" >
          <option value="-">-</option>
          <option value="BUENO">BUENO</option>
          <option value="REGULAR">REGULAR</option>
          <option value="MALO">MALO</option>
		</select>
    </td>     
 </tr>
 <tr>
  	<td>
  		<input name="descp2" type="text" id="descp2" size="35" maxlength="64" />
   	</td>
	<td>
    	<select name="read_l2" id="read_l2" >
          <option value="-">-</option>
          <option value="BUENO">BUENO</option>
          <option value="REGULAR">REGULAR</option>
          <option value="MALO">MALO</option>
    	</select>
    </td>    
   	<td>
    	<select name="speak_l2" id="speak_l2" >
          <option value="-">-</option>
          <option value="BUENO">BUENO</option>
          <option value="REGULAR">REGULAR</option>
          <option value="MALO">MALO</option>
		</select>
    </td>    
	<td>
    	<select name="write_l2" id="write_l2" >
          <option value="-">-</option>
          <option value="BUENO">BUENO</option>
          <option value="REGULAR">REGULAR</option>
          <option value="MALO">MALO</option>
		</select>
    </td>     
</tr> 
 <tr>
  	<td>
  		<input name="descp3" type="text" id="descp3" size="35" maxlength="64" />
   	</td>
	<td>
    	<select name="read_l3" id="read_l3" >
          <option value="-">-</option>
          <option value="BUENO">BUENO</option>
          <option value="REGULAR">REGULAR</option>
          <option value="MALO">MALO</option>
      </select></td>    
   	<td>
    	<select name="speak_l3" id="speak_l3" >
          <option value="-">-</option>
          <option value="BUENO">BUENO</option>
          <option value="REGULAR">REGULAR</option>
          <option value="MALO">MALO</option>
		</select></td>    
	<td>
    	<select name="write_l3" id="write_l3" >
          <option value="-">-</option>
          <option value="BUENO">BUENO</option>
          <option value="REGULAR">REGULAR</option>
          <option value="MALO">MALO</option>
	  </select></td>
      </tr>
  <tr>
  	<td>
  		<input name="descp4" type="text" id="descp4" size="35" maxlength="64" />
   	</td>
	<td>
    	<select name="read_l4" id="read_l4" >
          <option value="-">-</option>        
          <option value="BUENO">BUENO</option>
          <option value="REGULAR">REGULAR</option>
          <option value="MALO">MALO</option>
	    </select>
    </td>    
   	<td>
    	<select name="speak_l4" id="speak_l4" >
          <option value="-">-</option>
          <option value="BUENO">BUENO</option>
          <option value="REGULAR">REGULAR</option>
          <option value="MALO">MALO</option>
 	 	</select>
    </td>    
	<td>
    	<select name="write_l4" id="write_l4" >
          <option value="-">-</option>
          <option value="BUENO">BUENO</option>
          <option value="REGULAR">REGULAR</option>
          <option value="MALO">MALO</option>
		</select>
    </td>       
          </tr>  

</table>
</td>
<!--2-->
<td width="430">
<table id="ftab" width="428" border="0" align="center" cellpadding="2" cellspacing="0">
<tr>
    <td width="220">DESCRIPCIÓN:</td>
    <td width="200">NIVEL DE CALIFICACIÓN:</td>
</tr>
<tr>                  
    <td>
    	<input name="desc_o" type="text" id="desc_o" size="35" maxlength="64" />
    </td>
  	<td>
    	<select name="level" id="level" >
            <option value="-">-</option>
            <option value="BUENO">BUENO</option>
            <option value="REGULAR">REGULAR</option>
            <option value="MALO">MALO</option>
	  	</select>
    </td>
</tr>
<tr>
    <td>
    	<input name="desc_o1" type="text" id="desc_o1" size="35" maxlength="64" />
    </td>
  	<td>
    	<select name="level1" id="level1" >
            <option value="-">-</option>
            <option value="BUENO">BUENO</option>
            <option value="REGULAR">REGULAR</option>
            <option value="MALO">MALO</option>
	  	</select>
    </td>
</tr>
<!--2-->
<!--3-->

	<tr>
    <td>
    	<input name="desc_o2" type="text" id="desc_o2" size="35" maxlength="64" />
    </td>
  	<td>
    	<select name="level2" id="level2" >
          <option value="-">-</option>
          <option value="BUENO">BUENO</option>
          <option value="REGULAR">REGULAR</option>
          <option value="MALO">MALO</option>
	  </select></td>
</tr>
<!--3-->
<!--4-->

	<tr>
    <td>
    	<input name="desc_o3" type="text" id="desc_o3" size="35" maxlength="64" />
    </td>
  	<td>
    	<select name="level3" id="level3" >
          <option value="-">-</option>
          <option value="BUENO">BUENO</option>
          <option value="REGULAR">REGULAR</option>
          <option value="MALO">MALO</option>
	  </select>
    </td>
</tr>
<!--4-->
<!--5-->
   
	<tr>
    <td>
    	<input name="desc_o4" type="text" id="desc_o4" size="35" maxlength="64" />
    </td>
  	<td>
		<select name="level4" id="level4" >
          <option value="-">-</option>
          <option value="BUENO">BUENO</option>
          <option value="REGULAR">REGULAR</option>
          <option value="MALO">MALO</option>
	  	</select>
    </td>
</tr>
</table>
</td>
</table>
<!--5-->
<table width="990" border="0" align="center" cellpadding="2" cellspacing="0">
<td width="582"><h2><img src="data/images/docuni.jpg" width="500" height="50" /></h2></td>
</table>
<table id="ftab" width="990" border="0" align="center" cellpadding="2" cellspacing="0">
 <tr>
 	<td>UNIVERSIDAD:</td>	
 	<td>ASIGNATURA:</td>	
 	<td>CARRERA:</td>
   	<td>DESDE FECHA:</td>
 	<td>HASTA FECHA:</td>
 </tr>
 <tr>
  	<td>
  		<input name="univ" type="text" id="univ" size="25" maxlength="1000" />
   	</td>
	<td>
		<input name="asign" type="text" id="asign" size="25" maxlength="1000" />
    </td>    
   	<td>
		<input name="career" type="text" id="career" size="25" maxlength="500" />
    </td>    
   	<td>
		<input name="date_start" type="text" class="datpick" id="date_start" size="15" maxlength="64" readonly="readonly"/>
    </td> 
   	<td>
		<input name="date_end" type="text" class="datpick" id="date_end" size="15" maxlength="64" readonly="readonly"/>
    </td>     

	</tr>
<!--1-->
<tr>
  	<td>
  		<input name="univ1" type="text" id="univ1" size="25" maxlength="1000" />
   	</td>
	<td>
		<input name="asign1" type="text" id="asign1" size="25" maxlength="1000" />
    </td>    
   	<td>
		<input name="career1" type="text" id="career1" size="25" maxlength="500" />
    </td>    
   	<td>
		<input name="date_start1" type="text" class="datpick" id="date_start1" size="15" maxlength="64" readonly="readonly"/>
    </td> 
   	<td>
		<input name="date_end1" type="text" class="datpick" id="date_end1" size="15" maxlength="64" readonly="readonly"/>
    </td>     
	
</tr>
<!--1-->
<!--2-->
<tr>
  	<td>
  		<input name="univ2" type="text" id="univ2" size="25" maxlength="1000" />
   	</td>
	<td>
		<input name="asign2" type="text" id="asign2" size="25" maxlength="1000" />
    </td>    
   	<td>
		<input name="career2" type="text" id="career2" size="25" maxlength="500" />
    </td>    
   	<td>
		<input name="date_start2" type="text" class="datpick" id="date_start2" size="15" maxlength="64" readonly="readonly"/>
    </td> 
   	<td>
		<input name="date_end2" type="text" class="datpick" id="date_end2" size="15" maxlength="64" readonly="readonly"/>
    </td>     
	
</tr>
<!--2-->
<!--3-->
<tr>
  	<td>
  		<input name="univ3" type="text" id="univ3" size="25" maxlength="1000" />
   	</td>
	<td>
		<input name="asign3" type="text" id="asign3" size="25" maxlength="1000" />
    </td>    
   	<td>
		<input name="career3" type="text" id="career3" size="25" maxlength="500" />
    </td>    
   	<td>
		<input name="date_start3" type="text" class="datpick" id="date_start3" size="15" maxlength="64" readonly="readonly"/>
    </td> 
   	<td>
		<input name="date_end3" type="text" class="datpick" id="date_end3" size="15" maxlength="64" readonly="readonly"/>
    </td>     
	
</tr>
<!--3-->
<!--4-->
<tr>
  	<td>
  		<input name="univ4" type="text" id="univ4" size="25" maxlength="1000" />
   	</td>
	<td>
		<input name="asign4" type="text" id="asign4" size="25" maxlength="1000" />
    </td>    
   	<td>
		<input name="career4" type="text" id="career4" size="25" maxlength="500" />
    </td>    
   	<td>
		<input name="date_start4" type="text" class="datpick" id="date_start4" size="15" maxlength="64" readonly="readonly"/>
    </td> 
   	<td>
		<input name="date_end4" type="text" class="datpick" id="date_end4" size="15" maxlength="64" readonly="readonly"/>
    </td>     
	
    <tr>
  	<td> 		<input type="submit" class="submit" onclick="return probar()" name="save" id="loginbutton" value="Guardar" />
</td>
 	</tr>

  	
</table>
</form>
<br />
<table width="990" border="0" cellspacing="0" cellpadding="5" id="ftab" align="center" style="font-size:12px;">
  <tr>
    <th scope="col">IMPORTANTE</th>
  </tr>
  <tr>
    <td  id="ftd">
      <ul>
        <li>El presente Formulario constituye una <strong>Declaración Jurada </strong>de la veracidad de la información y datos contenidos en el mismo.</li>
        <li> De comprobarse la falsedad de algún dato o información declarado, el Declarante será
          sujeto de sanciones según lo determinado por la normativa vigente. </li>
        <li>El contenido de la presente declaración es de exclusiva y única responsabilidad
        del declarante.</li>
      </ul>    </td>
  </tr>
</table>
<?

//$db->close();
?>

</body>
</html>