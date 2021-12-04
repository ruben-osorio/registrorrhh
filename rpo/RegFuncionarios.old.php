<?
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");

$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
if (isset($_POST[save]))
{	
	$rsex=$db->query("SELECT * FROM ".TABLE2." WHERE ci='$_POST[ci]'");
	$rex=$db->fetch_array($rsex);
	echo mysql_num_rows($rsex);
	if (mysql_num_rows($rsex)!=0)
	{echo "el usuario ya existe";
	exit;
	}
	
	$name=strtoupper($_POST[name]);
	$lname_1=strtoupper($_POST[lname_1]);
	$lname_2=strtoupper($_POST[lname_2]);
	$office=strtoupper($_POST[office]);
	$date_entrance=$_POST[date_entrance];
	$source=$_POST[source];	
	//name	l_name1	l_name2	l_name_es	date_entrance	fecha_ing	office	source_fin	f_status
	$date_ing=cambia_dateN_to_dateMy_1($date_entrance);	
	
	$rs=$db->query("insert into ".TABLE2." 
	(name, l_name1, l_name2, date_entrance,fecha_ing, office, source_fin, f_status) VALUES 
	('$name','$lname_1','$lname_2','$date_entrance','$date_ing','$office','$source','1')");
	if ($rs)
	{
		if (strcmp("TGN",$source) == 0)
		{			
			$g1_i=explode("/",$date_entrance);			
			$g1_f=$g1_i[2]+1;
			$g1=$g1_i[2]."-".$g1_f;
			$rs1=$db->query("select id from ".TABLE2." order by id desc limit 1");
			$r1=$db->fetch_array($rs1);
			$rs1=$db->query("insert into ".TABLE3." (id_funcionario, gestion_1, dias_g1, gestion_2, dias_g2, observaciones)
			VALUES ('$r1[id]','$g1','0','','','')");
		}
				
		$msg="Registrado Correctamente";
		$sw=1;
	}
	else
	{
		$msg="Error al Registrar";
		$sw=1;
	}	
}
if ($sw==1)
{
	echo "<div>".$msg."</div>";
}
?>



<!--<script src="data/js/jquery.js" type="text/javascript"></script>-->
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
<!--<script src="data/js/jquery-1.7.1.min.js"></script>-->
<script src="data/js/ui/jquery.ui.core.js"></script>
<script src="data/js/ui/jquery.ui.widget.js"></script>
<script src="data/js/ui/jquery.ui.datepicker.js"></script>
<script>
	$(function() {
		$( "#date_born" ).datepicker({
			showOn: "button",
			changeMonth: true,
			changeYear: true,
			yearRange: "1920:2015",
			buttonImage: "data/images/calendar.gif",
			buttonImageOnly: true
		});	
		$( "#date_entrance" ).datepicker({
			showOn: "button",
			changeMonth: true,
			changeYear: true,
			yearRange: "1920:2015",
			buttonImage: "data/images/calendar.gif",
			buttonImageOnly: true
		});		
	});
	</script>
    
<fieldset>
<legend>Registro de Funcionarios</legend>

<form id="form1" name="form1" method="post" action="" class="form" novalidate="novalidate">
<fieldset>
<legend>Datos Personales</legend>
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr>
      <td width="29%"><div align="left">Nombres:</div></td>
      <td width="71%"><div class="form_row">      
        <input class="textarea_normal required"   name="name" type="text" id="name" size="45"  />
    
      </div></td>
    </tr>
    <tr>
      <td><div align="left">Apellido Paterno:</div></td>
      <td><div class="form_row">
        <input class="textarea_normal required"  name="lname_1" type="text"  id="lname_1" size="40"  />
      </div></td>
    </tr>
    <tr>
      <td><div align="left">Apellido Materno:</div></td>
      <td><div class="form_row">
        <input class="textarea_normal required"  name="lname_2" type="text"  id="lname_2" size="40"  />
      </div></td>
    </tr>
    <tr>
      <td><div align="left">Fecha de Nacimiento:</div></td>
      <td>       <div class="form_row">
        <input name="date_born" type="text" class="textarea_normal required"  id="date_born" size="20" />      
      </div></td>
    </tr>
    <tr>
      <td><div align="left">CI:</div></td>
      <td><div align="left" class="form_row">
        <input type="text" name="ci" id="ci" class="textarea_normal required"  />
        <select name="exp" id="exp">     
          <option value="0">-</option>   
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
    </table>
    </fieldset>
    <fieldset>
<legend>Datos del Cargo</legend>
    <table width="100%" border="0" cellpadding="5" cellspacing="0">
     <tr>
      <td width="29%"><div align="left">Cargo:</div></td>
      <td width="71%"><div class="form_row">
        <input class="textarea_normal required"  name="office" type="text"  id="office" size="60" />
      </div></td>
    </tr>
    <tr>
      <td><div align="left">Fecha de Ingreso</div></td>
      <td><div class="form_row">
        <input class="textarea_normal required"  type="text" name="date_entrance" id="date_entrance" />
      </div></td>
    </tr>
    <tr>
      <td><div align="left">Fuente de Financiamiento:</div></td>
      <td><div align="left">
        <label>
        <select class="select_normal" name="source" id="source" >        
          <option value="TGN">TGN</option>
          <option value="TGN-252">TGN-252</option>
          <option value="CANASTA">CANASTA</option>
          <option value="UNICEF">UNICEF</option>
          <option value="COSUDE">COSUDE</option>
          <option value="ASDI">ASDI</option>
        </select>
        </label>
      </div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="right">
        <input type="submit" class="submit" name="save" id="save" value="Guardar" />
        
      </div></td>
    </tr>
  </table>
  </fieldset>
</form>
</fieldset>
<?
$db->close();
?>