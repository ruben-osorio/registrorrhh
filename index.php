<?
require_once("security.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Bienvenido: <? echo $_SESSION['ap_1_user']." ".$_SESSION['ap_2_user'].", ".$_SESSION['nombre_user']."[".$sour."]"; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />-->
<link href="data/images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
<meta content="900" http-equiv="REFRESH"></meta>
<script type="text/javascript" src="data/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="data/js/ui/jquery-ui-1.8.17.custom.min.js"></script>
<script type="text/javascript" src="data/js/jquery.corner.js"></script>
<script type="text/javascript" src="data/js/jquery.validate.js"></script>
<script type="text/javascript" src="data/js/css_browser_selector.js"></script>
<script type="text/javascript" src="data/js/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="data/js/plugins/jqplot.highlighter.min.js"></script>
<script type="text/javascript" src="data/js/plugins/jqplot.cursor.min.js"></script>
<script type="text/javascript" src="data/js/plugins/jqplot.dateAxisRenderer.min.js"></script>
<!--<script type="text/javascript" src="data/js/plugins/jqplot.pieRenderer.min.js"></script>
<script type="text/javascript" src="data/js/plugins/jqplot.barRenderer.min.js"></script>-->
<script type="text/javascript" src="data/js/editor/jquery.cleditor.min.js"></script>
<script type="text/javascript" src="data/js/calendar/fullcalendar.min.js"></script>
<script type="text/javascript" src="data/js/jquery.multiselect.min.js"></script>
<script type="text/javascript" src="data/js/tooltip/jquery.tipsy.js"></script>
<!--<script type="text/javascript" src="data/js/validation/jquery.validationEngine.js"></script>
<script type="text/javascript" src="data/js/validation/languages/jquery.validationEngine-en.js"></script>-->
<script type="text/javascript" src="data/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="data/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="data/js/fancybox/jquery.easing-1.4.pack.js"></script>

<link rel="stylesheet" href="data/css/reset.css" type="text/css" />
<link rel="stylesheet" href="data/css/grid.css" type="text/css" />
<link rel="stylesheet" href="data/css/style.css" type="text/css" />
<link rel="stylesheet" href="data/js/plugins.css" type="text/css" />


    <link rel="stylesheet" href="data/bootstrap335/css/bootstrap.min.css">
    <link rel="stylesheet" href="data/bootstrap335/css/bootstrap-theme.min.css">

    <script type="text/javascript" src="data/js/jquery-2.1.3.min.js"></script>
    <script type="text/javascript" src="data/bootstrap335/js/bootstrap.min.js"></script>




</head>
<body onload="document.getElementById('tosearch').focus()">


</br>
    <div style=" margin-left: 50px; background-image: url(data/images/logo_min_desarrollo_productivo2.png); width:254px; height:60px;">
</div>
        </br>

<div style=" margin-left:60px; margin-right:60px; top:0px;  background-color:#f8f8f8; border:1px solid #ddd; border-radius:4px; "   >




	<div id="main" class="container_12">
    
   
    
		<div id="header">
         
         <div  >

<h3 class="heading " style="color:#222533;  font-size:15px; margin-bottom:0px; font-weight: bold; "> SISTEMA DE REGISTRO</h3>
<h3 class="heading " style="color:#c00;  font-size:15px; margin-top:0px;font-weight: bold;"> DIRECCIÓN DE TALENTO HUMANO<br>
GESTIÓN 2021 </h3>

         </div>
         
         
         
			
			<div class="grid_4 push_5">				
			</div>
		</div>
		<div class="clear"></div>
		<div id="userbar">
			<div id="profile">
				
				<div id="profileinfo">
					<h3 id="username" style="color:#ffffff"><? echo $_SESSION['username'];?></h3>                    
					<span id="subline" style="color:#ffffff;"><? echo $_SESSION['ap_1_user']." ".$_SESSION['ap_2_user']." ".$_SESSION['nombre_user']; ?></span>                    
					<div class="clear"></div>
					<a href="#" class="profilebutton">Perfil</a>
					<a href="logout.php" class="profilebutton">Salir</a>
				</div>
			</div>
            <? 
				switch($_SESSION['permisos'])
				{
					//require_once("")
					case '0':
						require_once("adminNavigation.php");
					break;					
					
					case '1':
						require_once("funcNavigation.php");
					break;
					
					case '2':
						require_once("funcConsNavigation.php");
					break;
					
					case '3':
						require_once("SocEmployeeNavigation.php");
					break;
					
					case '4':
						require_once("controlNavigation.php");
					break;				
				}
			?>

		</div>
		<div class="clear"></div>
		<!--<div class="error grid_12"><h3>Different notification messages - .error, .warning, .success, .inforamtion </h3><a href="#" class="hide_btn">&nbsp;</a></div>--><!-- Notification -->
		<div id="body">
			<div class="block big" style="  border:1px solid #ddd; border-radius: 4px;" ><!-- Block Begin -->
				<div class="titlebar">
					<h3 style="color:#fff">Sistema de Registro de Personal</h3>
					<a href="#" class="toggle">&nbsp;</a>
				</div>
              <div class="block_cont"  >			
                <?
			switch($_SESSION['permisos'])
				{
				//require_once("")
				case '0':				
				if((is_string ($_GET[selected])) && (isset ($_GET[selected]))) 
				{					
					switch ( $_GET[selected] )
					{						
						case 'FichaPersonal':							
							require_once("BusFichaPersonal.php");
						break;
						
						case 'FichaPersonalP':							
							require_once("BusFichaPersonalP.php");
						break;
						
						case 'RegistroBasico':							
							require_once("RegFuncionarios.php");
						break;
						
						case 'Modificar':
							require_once("BusFunModUser.php");
						break;
						
						case 'Baja':
							require_once("BajaFuncionarios.php");
						break;

						case 'Alta':
							require_once("AltaFuncionarios.php");
						break;
						
						case 'RegistroAfp':
							require_once("BusFunAAfp.php");
						break;
						
						case 'Movilidad':
							require_once("BusMovilidad.php");
						break;							
						
						case 'RegistrarPermiso':
							require_once("BusFunPermisos.php");
						break;		
																				
						case 'VacacionesTGN':
							require_once("VacacionesTGN.php");
						break;	

						case 'AsignVacaciones':
							//require_once("verGestionCumplida.php");
							require_once("verGestCumplida.php");
						break;	

						case 'CAS':
							require_once("busCAS.php");
						break;
						
						case 'AfiliacionCaja':							
							require_once("BusFunACaja.php");
						break;
						
						case 'RegistrarBajaMedica':
							require_once("BusBajaMedica.php");
						break;	
						
						case 'CargarDocumentos':
							require_once("BusCargaDocumentos.php");
						break;
						
						case 'ModificarSaldoVac':
							require_once("BusModSaldoVac.php");
						break;	
						
						case 'RepIndividualSaldo':
							require_once("BusRepIndivSaldo.php");
						break;	

						case 'RepFormVac':
							require_once("BusRepFormVac.php");
						break;	
						
						case 'RepIndividualCAS':
							require_once("BusRepIndividualCAS.php");
						break;	

						case 'RepGeneralCAS':
							require_once("RepGeneralCAS.php");
						break;	

						case 'NominaBajasGral':
							require_once("RepAltaFuncionarios.php");
						break;		
						
						case 'NominaTGN':
							require_once("NominaTGN.php");
						break;
						
						case 'NominaAsdi':
							require_once("NominaAsdi.php");
						break;
						
						case 'NominaCanasta':
							require_once("NominaCanasta.php");
						break;
						
						case 'NominaCosude':
							require_once("NominaCosude.php");
						break;
						
						case 'NominaTgn-252':
							require_once("NominaTgn-252.php");
						break;			
						
						case 'NominaUnicef':
							require_once("NominaUnicef.php");
						break;	
									
						case 'RegistrarPrestamo':
							require_once("BusFunPrestamoFile.php");
						break;		
												
						default:							
							require_once("Home.php");							
						break;						
					}					
				}				
				else
				{
					require_once("Home.php");
				}
				case '3':				
				if((is_string ($_GET[selected])) && (isset ($_GET[selected]))) 
				{
					switch ( $_GET[selected] )
					{
						case 'AfiliacionCaja':							
							require_once("BusFunACaja.php");
						break;
						
						case 'BajaCaja':							
							require_once("BusFunBajaCaja.php");
						break;
						
						case 'AfpListas':							
							require_once("AfpListas.php");
						break;
						
						case 'PendientesAfiliacion':							
							require_once("PendientesAfiliacion.php");
						break;
						
						case 'BajaSeguroSocial':							
							require_once("ReporteBajasCNS.php");
						break;
						
						case 'AfiliadosCaja':							
							require_once("AfiliadosCaja.php");
						break;
												
						case 'PendientesDesAfiliacion':							
							require_once("PendientesDesAfiliacion.php");
						break;
						
						case 'VacacionesTGN':
							require_once("VacacionesTGN.php");
						break;
						
						case 'NominaBajasGral':
							require_once("RepAltaFuncionarios.php");
						break;		
						
						case 'NominaTGN':
							require_once("NominaTGN.php");
						break;
						
						case 'NominaAsdi':
							require_once("NominaAsdi.php");
						break;
						
						case 'NominaCanasta':
							require_once("NominaCanasta.php");
						break;
						
						case 'NominaCosude':
							require_once("NominaCosude.php");
						break;
						
						case 'NominaTgn-252':
							require_once("NominaTgn-252.php");
						break;			
						
						case 'NominaUnicef':
							require_once("NominaUnicef.php");
						break;	
	
						
															
					}
				}
				{
					//require_once("HomeSocial.php");
				}
				break;
				
				case '1':
					if((is_string ($_GET[selected])) && (isset ($_GET[selected]))) 
					{
						switch ( $_GET[selected] )
						{
							case 'FullRegister':
							require_once("RegistroCompleto.php");
							break;		
	
							case 'ModRegister':
							require_once("ModificaDatosBasicos.php");
							break;		
							
							default:							
								//require_once("HomeFunc.php");							
							break;				
						}
					}
					else
					{
						//require_once("HomeFunc.php");
					}
				break;
				
				case '2':
					if((is_string ($_GET[selected])) && (isset ($_GET[selected]))) 
					{
						switch ( $_GET[selected] )
						{
							case 'FullRegisterc':
							require_once("RegistroCompleto-C.php");
							break;		
							
							default:							
								//require_once("HomeFunc.php");							
							break;		
							case 'ModRegister':
							require_once("ModificaDatosBasicos.php");
							break;		
							
							default:							
								//require_once("HomeFunc.php");							
							break;	
											
						}
					}
					else
					{
						//require_once("HomeFunc.php");
					}
				break;
				case '4':
					if((is_string ($_GET[selected])) && (isset ($_GET[selected]))) 
					{
						switch ( $_GET[selected] )
						{
							case 'RegistroBasico':							
								require_once("RegFuncionarios.php");
							break;	
							
							case 'Baja':
							require_once("BajaFuncionarios.php");
							break;
							
							case 'Movilidad':
							require_once("BusMovilidad.php");
							break;	
							
							case 'RepFormVac':
							require_once("BusRepFormVac.php");
							break;
							
							case 'RepIndividualSaldo':
							require_once("BusRepIndivSaldo.php");
							break;
							
							case 'VacacionesTGN':
							require_once("VacacionesTGN.php");
							break;
							
							case 'NominaTGN':
							require_once("NominaTGN.php");
							break;
							
							default:							
								//require_once("HomeFunc.php");							
							break;						
						}
					}
					else
					{
						//require_once("HomeFunc.php");
					}				
				break;					
				}
                ?>               
				</div>
			</div>
	</div>  
    
    
</div>

<!-- cuadro informacion-->
<div id="main" class="container_12" style="padding-left:4px; padding-top:0px;">

	<div style="  border:1px solid #ddd; border-radius: 4px; padding:15px; width:960px; background:#FFFFFF; color:#000;" >
 	<p>Sea <strong>CUIDADOSO</strong> al llenar los datos en cada formulario, ya que estos <strong>NO PODRÁN SER MODIFICADOS</strong></p>
    <p>Los <strong>SIGUIENTES PASOS QUEDARÁN ABIERTOS </strong>aún cuando usted haya <strong>REGISTRADO Y GUARDADO DATOS</strong>.
    <ul >
        <li><strong>REGISTRO DE DATOS FAMILIARES</strong></li>
        <li><strong>REGISTRO DE DATOS ACADEMICOS</strong></li>
        <li><strong>EXPERIENCIA </strong></li>
        <li><strong>CAPACITACION </strong></li>
        <li><strong>MOVILIDAD</strong></li>
  </ul></p>          
</div>

</div>
<!-- fin cuadro informacion-->
</body>

</html>