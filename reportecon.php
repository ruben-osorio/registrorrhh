<?php
require_once("security.php");
//--------REPORTE FILE PERSONAL
//--------DATOS PERSONALES
$id_func=$_GET['id_func'];
$id_con=$_GET['id_con'];
require("config.inc.php");
require("database.class.php");
require("functions.inc.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
//-------------REVISAR SI COMPLETO TODOS SUS DATOS----------------------
	$rshab=$db->query(" 
	SELECT * FROM ".TABLE37." 
	WHERE id_func='$id_func'
	");
	$rsh=$db->fetch_array($rshab);	
	
	//Ruben
	/*
	if($rsh[p1]!=1||$rsh[p4]!=1||$rsh[p7]!=1||$rsh[p8]!=1)
	{
		echo '<link href="css/reportes.css" rel="stylesheet" type="text/css">';
		echo '<link href="data/css/style-ext.css" rel="stylesheet" type="text/css">';
		echo '<div style="position: absolute; left: 0px; top: 0px; right:0px; bottom: 0px; background: #242424 url(data/images/bg.jpg); font-family: Verdana, Geneva, sans-serif; font-size: 13px; color: #000;">
		<div style="padding-left:90px; padding-right:90px; padding-top: 50px; padding-bottom: 50px;  background:#fff; margin-right: 60px; margin-left: 60px; margin-top: 20px;border-radius: 3px;
-moz-border-radius: 3px;-webkit-border-radius: 3px">';	
		
		echo '<h2 class="errorre ">Debe completar todos los pasos para generar el reporte a imprimir !!! <br> Pasos pendientes a completar:</h2>';
		echo '<div style="display:inline-block; background:#fff; ">';
	 if($rsh[p1]==0) echo "<img src=\"data/images/menu/1.png\">";
	if($rsh[p4]==0) echo "<img src=\"data/images/menu/4.png\">";	
	 if($rsh[p7]==0) echo "<img src=\"data/images/menu/7.png\">";
	 if($rsh[p8]==0) echo "<img src=\"data/images/menu/8.png\">";
		echo "</div>";
		echo '<div align="center"><input type="button" onclick="window.close();" id="loginbutton" value="Cerrar Ventana"></div>';
	 echo "
	 </div>
	 </div>";
	 exit;
	
	}
	*/
//----------------------------------------------------------------------	

//CONSULTA PARA OBTENER TODO LOS DATOS
	$rs2=$db->query("
	SELECT * FROM ".TABLE2." 
	WHERE id_func='$id_func'
	");
	$rs3=$db->query("
	SELECT * FROM ".TABLE10." 
	WHERE id_func='$id_func'
	");
	$rs4=$db->query("
	SELECT * FROM ".TABLE8." 
	WHERE id_func='$id_func'
	");
	$rs5=$db->query("
	SELECT * FROM ".TABLE1." 
	WHERE id_func='$id_func'
	");
	$rs6=$db->query("
	SELECT * FROM ".TABLE11." 
	WHERE id_func='$id_func'
	");
	$rs7=$db->query("
	SELECT * FROM ".TABLE12." 
	WHERE id_func='$id_func'
	");
	$rs8=$db->query("
	SELECT * FROM ".TABLE13." 
	WHERE id_func='$id_func'
	");
	$rs9=$db->query("
	SELECT * FROM ".TABLE14." 
	WHERE id_func='$id_func'
	");
	//SEGURO SOCIAL
/*	$rs10=$db->query("
	SELECT * FROM ".TABLE23." 
	WHERE id_per='$id_per'
	");*/
	$rs11=$db->query("
	SELECT * FROM ".TABLE24." 
	WHERE id_func='$id_func'
	");
	$rs12=$db->query("
	SELECT * FROM ".TABLE25." 
	WHERE id_func='$id_func'
	");
	$rs13=$db->query("
	SELECT * FROM ".TABLE32." 
	WHERE id_con='$id_con'
	ORDER BY id_cons_docs desc
	");
/*ULTIMA DECLARACIÓN JURADA*/
	$rs14=$db->query("
	SELECT * FROM ".TABLE27." 
	WHERE id_func='$id_func'
	ORDER BY id_ult_decl DESC
	");
/*DATOS DEL CARGO ACTUAL QUE DESEMPEÑA*/
	$rs15=$db->query("
	SELECT * FROM ".TABLE31." 
	WHERE id_con='$id_con'
	");
/*FUENTE FINANCIAMIENTO*/
	$rs16=$db->query("
	SELECT * FROM ".TABLE17." 
	WHERE id_con='$id_con'
	");
/*CATEGORIA*/
	$rs17=$db->query("
	SELECT * FROM ".TABLE18." 
	WHERE id_con='$id_con'
	");
/*MOVILIDAD*/
	$rs18=$db->query("
	SELECT * FROM ".TABLE34." 
	WHERE id_con='$id_con'
	");
/*EVALUACIÓN*/
	$rs19=$db->query("
	SELECT * FROM ".TABLE33." 
	WHERE id_con='$id_con'
	ORDER BY id_eval_con DESC
	");
/*CAPACITACIÓN*/
	$rs20=$db->query("
	SELECT * FROM ".TABLE21." 
	WHERE id_func='$id_func' order by id_cap desc
	");
/*CONTRATO*/
	$rs21=$db->query("
	SELECT * FROM ".TABLE30." 
	WHERE id_func='$id_func'
	AND id_con='$id_con'
	");	

//----------------------
//	echo "SELECT id_func, name, l_name1, l_name2,ci,expe,date_born FROM ".TABLE2." WHERE id_func='$id_func'";
	$rex=$db->fetch_array($rs2);
	$rex1=$db->fetch_array($rs3);
	$rex4=$db->fetch_array($rs6);
	$rex5=$db->fetch_array($rs7);
	$rex6=$db->fetch_array($rs8);
//	SEGURO SOCIAL
//	$rex8=$db->fetch_array($rs10);
	$rex9=$db->fetch_array($rs11);
	$rex10=$db->fetch_array($rs12);
	$rex11=$db->fetch_array($rs13);
/*ÚLTIMA DECLARACIÓN JURADA*/	
	$rex12=$db->fetch_array($rs14);
	$rex13=$db->fetch_array($rs15);
/*FUENTE FINANCIAMIENTO*/
	$rex14=$db->fetch_array($rs16);
	$rex15=$db->fetch_array($rs17);
/*EVALUACIÓN*/
	$rex17=$db->fetch_array($rs19);
	$rex19=$db->fetch_array($rs21);

/*-------------------------*/
//	echo mysql_num_rows($rs2);
//	echo $rex[id_func];
	
//------------------------------------


	if(!$rex)
	{echo exit;
	}
  	;
	//echo "verdad";

	





?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>REPORTE PARA IMPRESIÓN</title>
<link rel="stylesheet" href="estilo.css" type="text/css" media="all">
<link rel="stylesheet" type="text/css" media="screen" href="css/screen.css" />
<link href="estilo.css" rel="stylesheet" type="text/css">
<link href="data/css/style-ext.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="data/css/ui/admincp/jquery-ui-1.8.17.custom.css">
</head>
<body>
<!--datos academicos-->
<form id="form1" name="form1" method="post" action="">
<table width="990" height="42" border="0" align="center" cellpadding="2" cellspacing="0">
	<tr>     
      <td><div align="center"><img src="data/images/logo_mini.jpg" width="180" height="55" /></div></td>
      <td></td> 
      <td width="179"><div align="center">
        <p><strong>SUBSISTEMA DE REGISTRO<br />
        FORM. SAP. REG-01        </strong>      </p>
      </div></td>
     </tr> 
     	<tr>     
      <td><div align="center"><strong>Dirección General de Asuntos Administrativos</strong></div></td>
      <td></td>
      <td>&nbsp;</td>
     </tr> 

	 
	 
	<tr>     
      <td width="171">
		<div align="center">
			<?php
			  if ( $rex[foto] =='' )
			  {
				  $imagen = "images//tmp//default.jpg";

			  }
			  else {
				  $imagen = "images//tmp//" . $rex[foto];

			  }
				   echo "<img src='". $imagen . "' width='128' height='128' align='middle'/>";
			  ?>
		</div>
	  </td>
      <td width="628"><h1 align="center">FICHA PERSONAL</h1>
        <h4><br/> 
      Este documento debe ser llenado por todos los consultores que ingresen al Ministerio de Desarrollo Productivo. El consultor con su firma acreditada la veracidad de la información registrada.</h4></td>
      <td><input type="button" name="imprimir" value="Imprimir" onclick="window.print();"></td>
     </tr> 
</table>  
<table width="990" height="42" border="0" align="center" cellpadding="2" cellspacing="0">
    <td width="986">
 	<h2>
		DATOS PERSONALES
		</h2>
    </td>
</table>  
<table id="ftab" width="990" border="0" align="center" cellpadding="2" cellspacing="0">
 <tr>
  	<td>NOMBRES:(*)</td>
  	<td>APELLIDO PATERNO:(*)</td>
    <td>APELLIDO MATERNO:(*)</td>
    <td>ESTADO CIVIL:</td>
 </tr>
 <tr>
  	<td id="ftd">
  		<? echo $rex[name];?>
   	</td>
  	<td id="ftd">
  		<? echo $rex[l_name1];?>
   	</td>
  	<td id="ftd">
  		<? echo $rex[l_name2];?>
   	</td>
  	<td id="ftd">
  		<? echo $rex[c_status];?>
    </td>
</tr>
 	<tr>
  		<td>APELLIDO CASADA(O):</td>
  		<td>NACIONALIDAD</td>
    	<td>SEXO</td>
        <td>GRUPO SANGUINEO:</td>
 	</tr>
	<tr>
      	<td id="ftd">
  		<? echo $rex[l_name_es];?>
        </td>
      	<td id="ftd">
  		<? echo $rex[nati];?>
   		</td>
		<td id="ftd">
  		<? echo $rex[sex];?>
   		</td>
		<td id="ftd">
  		<? echo $rex[g_blood];?>
   		</td>
     </tr>
    <tr>
        <td>CI:</td>
  		<td>EXP:</td>
  		<td>NUA/CUA:</td>
  		<td>AFP:</td>
 	</tr>
	<tr>
	<td id="ftd">
  		<? echo $rex[ci];?>
	</td>
	<td id="ftd">
  		<? echo $rex[expe];?>
	</td>
	<td id="ftd">
  		<? echo $rex[nua];?>
	</td>
	<td id="ftd">
  		<? echo $rex[afp];?>
	</td>
</tr>
    <tr>
        <td>FECHA NACIMIENTO:</td>
        <td>DEPARTAMENTO NACIMIENTO:</td>
  		<td>PROVINCIA NACIMIENTO:</td>
   		<td>LOCALIDAD NACIMIENTO:</td>
    </tr>
    <tr>
	<td id="ftd">
  		<? echo $rex[date_born];?>
   	</td>
	<td id="ftd">
  		<? echo $rex[p1_born];?>
   	</td>
	<td id="ftd">
  		<? echo $rex[p2_born];?>
   	</td>
	<td id="ftd">
  		<? echo $rex[p3_born];?>
   	</td>
</tr>
    <tr>
        <td>DIRECCION ZONA/CALLE/NÚMERO(Ej. Calacoto/7/1825):</td>
        <td>LUGAR DE RESIDENCIA:</td>
  		<td>EMAIL PERSONAL:</td>
   		<td>EMAIL TRABAJO:</td>
    </tr>   
    <tr>
	<td id="ftd">
  		<? echo $rex[adress];?>
   	</td>
	<td id="ftd">
  		<? echo $rex[place_res];?>
   	</td>    	
	<td id="ftd">
  		<? echo $rex[p_email];?>
   	</td>
	<td id="ftd">
  		<? echo $rex[job_email];?>
   	</td>    
</tr>
    <tr>
        <td>TELEFONO DOMICILIO:</td>
        <td>CELULAR:</td>
  		<td>TELEFONO TRABAJO:</td>
        <td>&nbsp;</td>
   	</tr>   
	<td id="ftd">
  		<? echo $rex[phone_num];?>
   	</td> 
	<td id="ftd">
  		<? echo $rex[cel_num];?>
   	</td> 
	<td id="ftd">
  		<? echo $rex[phone_job];?>
   	</td> 
	<td>
  	
   	</td> 
	<tr>
        <td>PROFESIÓN:</td>
        <td>COLEGIO PROFESIONAL:</td>
  		<td>NÚMERO DE REGISTRO PROFESIONAL:</td>
        <td>NIT:</td>
   	</tr>   
    <tr>
	<td id="ftd">
  		<? echo $rex[prof];?>
   	</td> 
	<td id="ftd">
  		<? echo $rex[col_prof];?>
   	</td> 
	<td id="ftd">
  		<? echo $rex[num_prof];?>
   	</td> 
	<td id="ftd">
  		<? echo $rex[nit]?>
   	</td>   
</tr>
    <tr>
  		<td>Nº LICENCIA CONDUCIR:</td>
        <td>CATEGORIA:</td>
 	</tr>
    
    <tr>
	<td id="ftd">
  		<? echo $rex[lic_driv]?>
   	</td> 
	<td id="ftd">
  		<? echo $rex[type_lic]?>
   	</td> 
</tr>    

    <tr>
        <td>NUMERO DE REFERENCIA 1:</td>
        <td>NUMERO DE REFERENCIA 2:</td>
    </tr>

    <tr>
        <td id="ftd">
            <? echo $rex[nro_referencia1]?>
        </td>
        <td id="ftd">
            <? echo $rex[nro_referencia2]?>
        </td>
    </tr>
	
 </table>   
 
 
 <!-- datos servicio militar -->
    <table width="990" height="42" border="0" align="center" cellpadding="2" cellspacing="0">
        <td width="986">
            <h2>
                DATOS SERVICIO MILITAR:
            </h2>
        </td>
    </table>
    <table id="ftab" width="989" border="0" align="center" cellpadding="2" cellspacing="0">
        <tr>
            <td>NUMERO DE LIBRETA:</td>
            <td>MATRICULA:</td>
            <td>AÑO:</td>
            <td>TIPO DE LIBRETA:</td>
        </tr>

        <td id="ftd">
  		<? echo $rex[nro_libreta];?>
        </td>
        <td id="ftd">
            <? echo $rex[matricula];?>
        </td>
        <td id="ftd">
            <? echo $rex[anyo];?>
        </td>
        <td id="ftd">
            <? echo $rex[tipo_libreta]?>
        </td>



    </table>
 
 <table width="990" height="42" border="0" align="center" cellpadding="2" cellspacing="0">
    <td width="986">
 	<h2>
		DATOS FAMILIARES (FAMILIARES EN PRIMER GRADO):
		</h2>
    </td>
</table>   
 <table id="ftab" width="989" border="0" align="center" cellpadding="2" cellspacing="0">   
    <tr>
        <td width="94">TIPO DE PARENTESCO:</td>
  		<td width="148">NOMBRES:</td>
    	<td width="127">APELLIDO PATERNO:</td>
        <td width="123">APELLIDO MATERNO:</td>
		<td width="60">SEXO:</td>
        <td width="118">FECHA DE NACIMIENTO:</td>
		<td width="178">LUGAR DE NACIMIENTO Y NACIONALIDAD:</td>
        <td width="107">TIPO Y NUMERO DE DOCUMENTO:</td>
    </tr>
       	<?
		while($rex2=$db->fetch_array($rs4))
	{
		//type_p, name ,l_name1, l_name2, sex, born_date, pb_nat, tn_doc 
		echo "<tr><td id=\"ftd\">"."$rex2[type_p]"."</td>";
		echo "<td id=\"ftd\">"."$rex2[name]"."</td>";
		echo "<td id=\"ftd\">"."$rex2[l_name1]"."</td>";
		echo "<td id=\"ftd\">"."$rex2[l_name2]"."</td>";
		if ($rex2[sex]=="MASCULINO" || $rex2[sex]=="Masculino" || $rex2[sex]=="masculino" || $rex2[sex]=="MALE")
		{
			echo "<td id=\"ftd\">M</td>";
		}
		else
		{
			echo "<td id=\"ftd\">F</td>";
		}
		
		
		echo "<td id=\"ftd\">"."$rex2[born_date]"."</td>";
		echo "<td id=\"ftd\">"."$rex2[pb_nat]"."</td>";
		echo "<td id=\"ftd\">"."$rex2[tn_doc]"."</td></tr>";
	}
       ?>

</table> 
 
 
 <table width="990" height="42" border="0" align="center" cellpadding="2" cellspacing="0">
    <td width="986">
 	<h2>
		DATOS ACADÉMICOS - EDUCACIÓN (BACHILLERATO):</h2>
    </td>
</table>   
 <table id="ftab" width="989" border="0" align="center" cellpadding="2" cellspacing="0">   
    <tr>
        <td width="265">ULTIMO CURSO VENCIDO:(*)</td>
  		<td width="247">COLEGIO/INSTITUCIÓN:(*)</td>
    	<td width="246">LUGAR CIUDAD/PAÍS:(*)</td>
        <td width="115">AÑO:(*)</td>
		<td width="96">TITULO:</td>
    <tr>   
    </tr>
     <tr>   
	<td id="ftd">
  		<? echo $rex[last_gra]?>
   	</td> 
    <td id="ftd">
  		<? echo $rex[cole]?>
   	</td> 
	<td id="ftd">
  		<? echo $rex[ciudad_de]?>
   	</td> 
	<td id="ftd">
  		<? echo $rex[anyo_de]?>
   	</td> 	
    
    <td id="ftd">
  		<? if($rex[title]==1)
			{echo "SI";
			}
		else echo "NO";
		 ?>
   	</td> 
</tr>
<!--datos academicos-->
<tr>
</table>
 
 <table width="990" height="42" border="0" align="center" cellpadding="2" cellspacing="0">
    <td width="986">
 	<h2>
		DATOS ACADÉMICOS - INSTRUCCIÓN ACADÉMICA (COMPETENCIA DE PERSONAL):
		</h2>
    </td>
</table>   
 <table id="ftab" width="989" border="0" align="center" cellpadding="2" cellspacing="0">   
    <tr>
        <td width="68">NIVEL:</td>
  		<td width="82">FECHA INICIO:</td>
    	<td width="71">FECHA FIN:</td>
        <td width="179">CARRERA:</td>
		<td width="190">NOMBRE INSTITUCIÓN:</td>
        <td width="70">CONCLUIDA:</td>
		<td width="128">LUGAR:</td>
        <td width="80">TÍTULO ACADÉMICO:</td>
        <td width="83">TÍTULO EN PROVISIÓN NACIONAL:</td>
    </tr>
       	<?
		while($rex3=$db->fetch_array($rs5))
	{
		//   city country acad_title revala inst_revala date_exp_a num_tit_a prov_nat_title revalp inst_revalp date_exp_p num_tit_p 
		echo "<tr><td id=\"ftd\">"."$rex3[level]"."</td>";
		echo "<td id=\"ftd\">"."$rex3[date_start]"."</td>";
		echo "<td id=\"ftd\">"."$rex3[date_end]"."</td>";
		echo "<td id=\"ftd\">"."$rex3[career_esp]"."</td>";
		echo "<td id=\"ftd\">"."$rex3[name_inst]"."</td>";
		if($rex3[end]==1) echo "<td id=\"ftd\">SI</td>";
		else echo "<td id=\"ftd\">NO</td>";
		echo "<td id=\"ftd\">"."$rex3[city]"."/"."$rex3[country]"."</td>";
		if($rex3[acad_title]==1) echo "<td id=\"ftd\">SI</td>";
		else echo "<td id=\"ftd\">NO</td>";		
		if($rex3[prov_nat_title]==1) echo "<td id=\"ftd\">SI</td>";
		else echo "<td id=\"ftd\">NO</td>";	

	}
       ?>
<!--idiomas-->
<table width="990" border="0" align="center" cellpadding="2" cellspacing="0">
<td width="582"><h2>FORMACIÓN (IDIOMAS):</h2></td>
<td width="400"><h2>FORMACIÓN (OTROS CONOCIMIENTOS):</h2></td>
</table>
<table id="ftab" width="990" border="0" align="center" cellpadding="2" cellspacing="0">
 <tr>
  	<td width="214">DESCRIPCIÓN:</td>
    <td width="101">LEE:</td>
    <td width="99">HABLA:</td>
    <td width="121">ESCRIBE:</td>
    <td width="32"></td>
    <td width="231">DESCRIPCIÓN:</td>
    <td width="164">NIVEL DE CALIFICACIÓN:</td>
 </tr>
 <tr>
<!--1-->
	<td id="ftd">
  		<? echo $rex4[descp]?>
   	</td> 
	<td id="ftd">
  		<? echo $rex4[read_l]?>
   	</td>
	<td id="ftd">
  		<? echo $rex4[speak_l]?>
   	</td>
	<td id="ftd">
  		<? echo $rex4[write_l]?>
   	</td>
	<td></td>   
	<td id="ftd">
  		<? echo $rex5[desc_o]?>
   	</td>
	<td id="ftd">
  		<? echo $rex5[level]?>
   	</td>
</tr>
<!--1-->
<!--1-->
	<td id="ftd">
  		<? echo $rex4[descp1]?>
   	</td> 
	<td id="ftd">
  		<? echo $rex4[read_l1]?>
   	</td>
	<td id="ftd">
  		<? echo $rex4[speak_l1]?>
   	</td>
	<td id="ftd">
  		<? echo $rex4[write_l1]?>
   	</td>
	<td></td>   
	<td id="ftd">
  		<? echo $rex5[desc_o1]?>
   	</td>
	<td id="ftd">
  		<? echo $rex5[level1]?>
   	</td>
</tr>
<!--1-->
<!--1-->
	<td id="ftd">
  		<? echo $rex4[descp2]?>
   	</td> 
	<td id="ftd">
  		<? echo $rex4[read_l2]?>
   	</td>
	<td id="ftd">
  		<? echo $rex4[speak_l2]?>
   	</td>
	<td id="ftd">
  		<? echo $rex4[write_l2]?>
   	</td>
	<td></td>   
	<td id="ftd">
  		<? echo $rex5[desc_o2]?>
   	</td>
	<td id="ftd">
  		<? echo $rex5[level2]?>
   	</td>
</tr>
<!--1-->
<!--1-->
	<td id="ftd">
  		<? echo $rex4[descp3]?>
   	</td> 
	<td id="ftd">
  		<? echo $rex4[read_l3]?>
   	</td>
	<td id="ftd">
  		<? echo $rex4[speak_l3]?>
   	</td>
	<td id="ftd">
  		<? echo $rex4[write_l3]?>
   	</td>
	<td></td>   
	<td id="ftd">
  		<? echo $rex5[desc_o3]?>
   	</td>
	<td id="ftd">
  		<? echo $rex5[level3]?>
   	</td>
</tr>
<!--1-->
<!--1-->
	<td id="ftd">
  		<? echo $rex4[descp4]?>
   	</td> 
	<td id="ftd">
  		<? echo $rex4[read_l4]?>
   	</td>
	<td id="ftd">
  		<? echo $rex4[speak_l4]?>
   	</td>
	<td id="ftd">
  		<? echo $rex4[write_l4]?>
   	</td>
	<td></td>   
	<td id="ftd">
  		<? echo $rex5[desc_o4]?>
   	</td>
	<td id="ftd">
  		<? echo $rex5[level4]?>
   	</td>
</tr>
<!--1-->

</table>
<!--5-->
<table width="990" border="0" align="center" cellpadding="2" cellspacing="0">
<td width="582"><h2>FORMACIÓN (DOCENCIA UNIVERSITARIA):</h2></td>
</table>
<table id="ftab" width="990" border="0" align="center" cellpadding="2" cellspacing="0">
 <tr>
 	<td>UNIVERSIDAD:</td>	
 	<td>ASIGNATURA:</td>	
 	<td>CARRERA:</td>
   	<td>DESDE FECHA:</td>
 	<td>HASTA FECHA:</td>
 </tr>
<!--1-->
<tr>
	<td id="ftd">
  		<? echo $rex6[univ]?>
   	</td>
	<td id="ftd">
  		<? echo $rex6[asign]?>
   	</td>
	<td id="ftd">
  		<? echo $rex6[career]?>
   	</td>
	<td id="ftd">
  		<? 	if($rex6[date_start]==0000-00-00) echo "-";
			else echo $rex6[date_start];
		?>
   	</td>
	<td id="ftd">
  		<? if($rex6[date_end]==0000-00-00) echo "-";
			else echo $rex6[date_end];
		?>
   	</td>
</tr>
<!--1-->
<!--1-->
<tr>
	<td id="ftd">
  		<? echo $rex6[univ1]?>
   	</td>
	<td id="ftd">
  		<? echo $rex6[asign1]?>
   	</td>
	<td id="ftd">
  		<? echo $rex6[career1]?>
   	</td>
	<td id="ftd">
  		<? 	if($rex6[date_start1]==0000-00-00) echo "-";
			else echo $rex6[date_start1];
		?>
   	</td>
	<td id="ftd">
  		<? 	if($rex6[date_end1]==0000-00-00) echo "-";
			else echo $rex6[date_end1];
		?>
   	</td>
</tr>
<!--1-->
<!--1-->
<tr>
	<td id="ftd">
  		<? echo $rex6[univ2]?>
   	</td>
	<td id="ftd">
  		<? echo $rex6[asign2]?>
   	</td>
	<td id="ftd">
  		<? echo $rex6[career2]?>
   	</td>
	<td id="ftd">
  		<? 	if($rex6[date_start2]==0000-00-00) echo "-";
			else echo $rex6[date_start2];
		?>
   	</td>
	<td id="ftd">
  		<? 	if($rex6[date_end2]==0000-00-00) echo "-";
			else echo $rex6[date_end2];
		?>
   	</td>
</tr>
<!--1-->
<!--1-->
<tr>
	<td id="ftd">
  		<? echo $rex6[univ3]?>
   	</td>
	<td id="ftd">
  		<? echo $rex6[asign3]?>
   	</td>
	<td id="ftd">
  		<? echo $rex6[career3]?>
   	</td>
	<td id="ftd">
  		<? 	if($rex6[date_start3]==0000-00-00) echo "-";
			else echo $rex6[date_start3];
		?>
   	</td>
	<td id="ftd">
  		<? 	if($rex6[date_end3]==0000-00-00) echo "-";
			else echo $rex6[date_end3];
		?>
   	</td>
</tr>
<!--1-->
<!--1-->
<tr>
	<td id="ftd">
  		<? echo $rex6[univ4]?>
   	</td>
	<td id="ftd">
  		<? echo $rex6[asign4]?>
   	</td>
	<td id="ftd">
  		<? echo $rex6[career4]?>
   	</td>
	<td id="ftd">
  		<? 	if($rex6[date_start4]==0000-00-00) echo "-";
			else echo $rex6[date_start4];
		?>
   	</td>
	<td id="ftd">
  		<? 	if($rex6[date_end4]==0000-00-00) echo "-";
			else echo $rex6[date_end4];
		?>
   	</td>
</tr>
<!--1-->
</table>
<table width="990" border="0" align="center" cellpadding="2" cellspacing="0">
<td width="582"><h2>EXPERIENCIA (LABORAL ANTERIOR FUERA DEL MINISTERIO):</h2><span>*Indicar la trayectoria laboral de trabajos anteriores comenzando por el más reciente)<br />
**Adjuntar fotocopia simple de certificado o contrato que respalde la información.
</span></td>
</table>
<table id="ftab" width="990" border="0" align="center" cellpadding="2" cellspacing="0">
 <tr>
  		<td width="116">NOMBRE DE LA INSTITUCION:</td>
  		<td width="63">TIPO:</td>
  		<td width="112">FORMA DE INGRESO:</td>
    	<td width="80">FECHA DE INGRESO:</td>
        <td width="97">LUGAR (CIUDAD/PAIS):</td>
        <td width="123">CARGOS DESEMPEÑADOS:</td>
        <td width="105">MOTIVO CAMBIO DE PUESTO:</td>
        <td width="84">DEL:</td>
        <td width="84">AL:</td>
        <td width="84">FECHA DE RETIRO:</td>
 </tr>
       	<?
		while($rex7=$db->fetch_array($rs9))
	{	//name_inst type_inst form_ent date_ent place_lab charge rea_cha date_start date_end date_ret
		echo "<tr><td id=\"ftd\">"."$rex7[name_inst]"."</td>";
		echo "<td id=\"ftd\">"."$rex7[type_inst]"."</td>";
		echo "<td id=\"ftd\">"."$rex7[form_ent]"."</td>";
		echo "<td id=\"ftd\">"."$rex7[date_ent]"."</td>";
		echo "<td id=\"ftd\">"."$rex7[place_lab]"."</td>";
		echo "<td id=\"ftd\">"."$rex7[charge]"."</td>";
		echo "<td id=\"ftd\">"."$rex7[rea_cha]"."</td>";
		echo "<td id=\"ftd\">"."$rex7[date_start]"."</td>";
		echo "<td id=\"ftd\">"."$rex7[date_end]"."</td>";
		echo "<td id=\"ftd\">"."$rex7[date_ret]"."</td></tr>";
	}
       ?> 
</table> 
<!--1-->
<!--DATOS ANTIGUEDAD-->
<table width="990" border="0" align="center" cellpadding="2" cellspacing="0">
<td><h2>DATOS DONDE SE ABONA SU SUELDO:</h2></td>
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
	<td id="ftd">
  		<? echo $rex10[bank]?>
   	</td>
	<td id="ftd">
  		<? echo $rex10[type_ac]?>
   	</td>
	<td id="ftd">
  		<? echo $rex10[num_ac]?>
   	</td>
	<td id="ftd">
  		<? echo $rex10[dist_ac]?>
   	</td>
</tr>    
</table>
</td>
</table>
<!--FECHAS DE -->
<table width="990" border="0" align="center" cellpadding="2" cellspacing="0">
<td width="564"><h2>DOCUMENTACIÓN ENTREGADA (marque la doc. entregada):</h2></td>
<td width="418"><h2>ÚLTIMAS FECHAS DE:</h2></td>
</table>
<table width="990" border="0" align="center" cellpadding="2" cellspacing="0">
<td>
<table id="ftab" width="528" border="0" align="left" cellpadding="2" cellspacing="0">
	<tr>
 		<td width="94">CURRICULUM VITAE:</td>	
		<td width="102">FOTOCOPIA C.I.:</td>	
		<td width="124">FECHA DE CADUCIDAD:</td>	
		<td width="91">FOTOCOPIA CERT. NAC.:</td>	
		<td width="95">FOTOCOPIA CERT. MAT.:</td>	
	
	<tr>	
	<td id="ftd">
  		<? echo $rex11[cv]; ?>
   	</td>
	<td id="ftd">
  		<? echo $rex11[ci];	?>
   	</td>
	<td id="ftd">
  		<? echo $rex11[date_cad_ci]?>
   	</td>
	<td id="ftd">
	<? echo $rex11[cn]; ?>
   	</td>
	<td id="ftd">
	<? echo $rex11[cm]; ?>
   	</td>
	</tr>
</table>    	        
</td>	            
<td>
<table id="ftab" width="420" border="0" align="right" cellpadding="2" cellspacing="0">
	<tr>
    
 		<td>DECLARACIÓN JURADA DE INCOMPATIBILIDAD:</td>
	</tr>

    <td id="ftd">
  		<? echo $rex12[date_di]?>
   	</td>    
    
	</tr>
</table>    	        

</td>
</table>

<!--DATOS DEL CARGO ACTUAL QUE DESEMPEÑA-->
<table width="990" border="0" align="center" cellpadding="2" cellspacing="0">
<td><h2>DATOS DEL CARGO ACTUAL QUE DESEMPEÑA:</h2></td>
</table>
<table id="ftab" width="990" border="0" align="center" cellpadding="2" cellspacing="0">
<tr> 		
        <td width="233">DIRECCION GENERAL:</td>	
		<td width="244">UNIDAD:</td>	
		<td width="247">ÁREA:</td>	
		<td width="250">JEFE INMEDIATO SUPERIOR:</td>	
</tr>
<tr> 	
    <td id="ftd">
  		<? echo $rex13[dir_g]?>
   	</td> 
    <td id="ftd">
  		<? echo $rex13[unit]?>
   	</td> 
    <td id="ftd">
  		<? echo $rex13[area]?>
   	</td> 
    <td id="ftd">
  		<? echo $rex13[boss_is]?>
   	</td> 	
</tr>
<tr> 		
        <td >JEFE SUPERIOR JERÁRQUICO:</td>	
		<td COLSPAN="2">CARGO:</td>	
	
		<td >JORNADA DE TRABAJO:</td>
 </tr>
<tr> 		
    <td id="ftd">
  		<? echo $rex13[boss_ij]?>
   	</td> 
    <td COLSPAN="2" id="ftd">
  		<? 
		echo $rex13[charge]
		//echo $rex15[cat]
		// echo $rex15[level]
		?>
   	</td> 

    <td id="ftd">
  		<? echo $rex15[jornal]?>
   	</td>        
</tr>

<tr> 		
        <td>CATEGORÍA:</td>	
		<td>NIVEL DE PUESTO:</td>	

        <td>FORMA DE RECLUTAMIENTO:</td>

        <td>SUELDO BASE:</td>
</tr>
<tr> 		
        <td id="ftd">
  			<? echo $rex15[cat]?>
   		</td>
        <td id="ftd">
  			<? echo $rex15[level]?>
   		</td>
      
        <td id="ftd">
  			<? echo $rex15[form_rec]?>
   		</td>

        <td id="ftd">
  			<? echo $rex15[sal_base]?>
   		</td>
</tr>
</table>
<!--CATEGORIA-->





<!--SOLO PARA CONTRATOS EVENTUALES CONSULTORES-->
<table width="990" border="0" align="center" >
<td><h2>SOLO PARA CONTRATOS EVENTUALES CONSULTORES:</h2></td>
</table>
<table id="ftab" width="990" border="0" align="center">
<tr> 		
        <td>INICIO DE CONTRATO:</td>	
        <td>FIN DE CONTRATO:</td>
        <td>NÚMERO DE CONTRATO:</td>
  </tr>
<tr> 		
        <td id="ftd">
  			<? echo $rex19[date_ent]?>
   		</td>
        <td id="ftd">
  			<? echo $rex19[date_end]?>
   		</td>
        <td id="ftd">
  			<? echo $rex19[name_con]?>
   		</td>                
  </tr>
</table>

<!--FUENTE FINANCIAMIENTO-->
<table width="990" border="0" align="center" >
<td><h2>FINANCIAMIENTO:</h2></td>
</table>
<table id="ftab" width="990" border="0" align="center">
<tr> 		
        <td>FUENTE DE FINANCIAMIENTO:</td>	
  </tr>
<tr> 		
        <td id="ftd">
  			<? echo $rex14[source_fin]?>
   		</td>
  </tr>
</table>

<table width="990" border="0" align="center" cellpadding="2" cellspacing="0">
<td><h2>MOVILIDAD:</h2></td>
</table>
<table id="ftab" width="990" border="0" align="center">
<tr>
 		<td width="239">CARGO EN LA INSTITUCION (EMPEZAR POR EL ACTUAL):</td>
  		<td width="152">MOTIVO DEL CAMBIO DEL CARGO:</td>
  		<td width="146">NÚMERO DE RESOLUCIÓN O MEMO:</td>
		<td width="120">DIRECCIÓN GENERAL:</td>
		<td width="56">UNIDAD:</td>
  		<td width="42">ÁREA:</td>
    	<td width="99">DE FECHA:</td>
    	<td width="100">A FECHA:</td>
;
</tr>
       	<?
		while($rex16=$db->fetch_array($rs18))	
		{	//id_old_mov id_func charge rea_chan num_res gral_dir unit area date_start date_end
		echo "<tr><td id=\"ftd\">"."$rex16[charge]"."</td>";
		echo "<td id=\"ftd\">"."$rex16[rea_chan]"."</td>";
		echo "<td id=\"ftd\">"."$rex16[num_res]"."</td>";
		echo "<td id=\"ftd\">"."$rex16[gral_dir]"."</td>";
		echo "<td id=\"ftd\">"."$rex16[unit]"."</td>";
		echo "<td id=\"ftd\">"."$rex16[area]"."</td>";
		echo "<td id=\"ftd\">"."$rex16[date_start]"."</td>";
		echo "<td id=\"ftd\">"."$rex16[date_end]"."</td></tr>";
		}
		?>
</table>
<table width="990" border="0" align="center" >
<td><h2>EVALUACIÓN:</h2></td>
</table>
<table id="ftab" width="990" border="0" align="center">
<tr> 		
        <td>FECHA DE EVALUACIÓN:</td>	
		<td>RESULTADO DE LA EVALUACIÓN:</td>	
		<td>CONSECUENCIA DE LA EVALUACIÓN:</td>	
        <td>RESPONSABLE DE LA EVALUACIÓN:</td>
        <td>TIPO DE RESPONSABLE:</td>		
</tr>
    <td id="ftd">
  		<? echo $rex17[date_eval]?>
   	</td> 	
        <td id="ftd">
  		<? echo $rex17[res_eval]?>
   	</td> 	
        <td id="ftd">
  		<? echo $rex17[cons_eval]?>
   	</td> 	
        <td id="ftd">
  		<? echo $rex17[resp_eval]?>
   	</td> 	
        <td id="ftd">
  		<? echo $rex17[type_resp]?>
   	</td> 	
</tr>    
</table>
<table width="990" border="0" align="center" >
<td><h2>FORMACIÓN (CAPACITACIÓN):</h2></td>
</table>
<table id="ftab" width="990" border="0" align="center">
    <tr> 
    
      	<td>FECHA DE INICIO:</td>
  		<td>FECHA FIN:</td>
  		<td>NOMBRE DEL EVENTO:</td>
		<td>CAPACITACIÓN:</td>
		<td>NOMBRE INSTITUCIÓN:</td>
  		<td>LUGAR (CIUDAD/PAÍS):</td>
    	<td>NÚMERO DE HORAS:</td>   
  </tr> 
       	<?
		while($rex18=$db->fetch_array($rs20))	
		{	
		//id_func,date_start, date_end, name_event, type_cap, name_inst, place, num_hrs
		echo "<tr><td id=\"ftd\">"."$rex18[date_start]"."</td>";
		echo "<td id=\"ftd\">"."$rex18[date_end]"."</td>";
		echo "<td id=\"ftd\">"."$rex18[name_event]"."</td>";
		echo "<td id=\"ftd\">"."$rex18[type_cap]"."</td>";
		echo "<td id=\"ftd\">"."$rex18[name_inst]"."</td>";
		echo "<td id=\"ftd\">"."$rex18[place]"."</td>";
		echo "<td id=\"ftd\">"."$rex18[num_hrs]"."</td></tr>";
		}
		?>    
</table><br />
<table width="990" border="0" cellspacing="0" cellpadding="5" id="ftab" align="center">
  <tr>
    <th scope="col">IMPORTANTE</th>
  </tr>
  <tr>
    <td  id="ftd">
      <ul>
        <li>El presente Formulario constituye una <strong>Declaración Jurada </strong>de la veracidad de la información y datos contenidos en el mismo.</li>
        <li> De comprobarse la falsedad de algún dato o información declarado, el Declarante será
          sujeto de sanciones según lo determinado por la normativa vigente. </li>
        <li>      Mediante la presente Declaración Jurada, el Declarante autoriza a las Autoridades competentes del Ministerio de Desarrollo Productivo y Economía Plural a verificar la información
          proporcionada.</li>
        <li>El contenido de la presente declaración es de exclusiva y única responsabilidad
          del declarante.</li>
      </ul>    </td>
  </tr>
</table>
<br />

<table border="1" cellspacing="0" cellpadding="0" align="center" id="ftab">
  <tr>
    <td colspan="2" valign="top"><p align="center"><strong>JURA LA EXACTITUD Y VERACIDAD DE LA PRESENTE    DECLARACIÓN</strong></p></td>
  </tr>
  <tr>
    <td colspan="2" valign="top"><p align="center"><strong>DATOS FUNCIONARIO <br />
      (LLENAR A MANO)</strong></p></td>
  </tr>
  <tr>
    <td width="205" height="42" id="ftd"><p>NOMBRES Y APELLIDOS:</p></td>
    <td width="689" id="ftd">&nbsp;</td>
  </tr>
  <tr>
    <td width="205" height="42" id="ftd"><p>LUGAR Y FECHA:</p></td>
    <td width="689" id="ftd">&nbsp;</td>
  </tr>
  <tr>
    <td width="205" height="135" valign="middle" id="ftd"><p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>FIRMA:</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p></td>
    <td width="689" id="ftd">&nbsp;</td>
  </tr>
  
</table>
<br>
<br>

<table border="1" cellspacing="0" cellpadding="0" align="center" id="ftab">
  
  <tr>
    <td colspan="2" valign="top"><p align="center"><strong>SELLO DE RECEPCIÓN DE RRHH</strong></p></td>
  </tr>
  <tr>
    <td width="205" height="173" valign="middle" id="ftd"><p>&nbsp;</p>
      <p>SELLO Y FECHA:</p>
    <p>&nbsp;</p></td>
    <td width="686" id="ftd">&nbsp;</td>
  </tr>
</table>


</body>
</html>