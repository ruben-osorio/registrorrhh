<?
session_start(); 
require_once('LoginSystem.class.php');	

if(isset($_POST['loginbutton']))
{
	if((!$_POST['Username']) || (!$_POST['Password']))		
	{
		// display error message
		header('location: login.php?msg=1');// show error
		exit;
	}
	$loginSystem = new LoginSystem();
	if($loginSystem->doLogin($_POST['Username'],$_POST['Password']))
	{
		header('location: index.php');
	}
	else
	{
		header('location: login.php?msg=2');
		exit;
	}
}
	
	/**
	 * show Error messages
	 *
	 */
	function showMessage()
	{
		if(is_numeric($_GET['msg']))
		{
			switch($_GET['msg'])
			{
				case 1: 
					echo  '
					<div id="msg_login">
				<img src="data/images/ImgCritical_32.png">
				<div id="msg">Por favor, rellene los campos username y password.</div>
				</div>';
				break;
				
				case 2: 
				echo  '
					<div id="msg_login">
					<img src="data/images/ImgCritical_32.png">
					<div id="msg">	Datos de ingreso incorrectos.</div>
					</div>';
				break;
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Sub-Sistema de Registro de Personal - URRHHyDO Ministerio de Educación</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="data/images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
<script type="text/javascript" src="data/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="data/js/jquery.corner.js"></script>
<script type="text/javascript" src="data/js/jquery.validate.js"></script>
<script type="text/javascript" src="data/js/css_browser_selector.js"></script>
<script type="text/javascript" src="data/js/js.js"></script>
<link rel="stylesheet" href="data/css/reset.css" type="text/css" />
<link rel="stylesheet" href="data/css/grid.css" type="text/css" />
<link rel="stylesheet" href="data/css/style.css" type="text/css" />
<script>
function cerrar() {
div = document.getElementById('flotante');
div.style.display='none';
}
</script>
</head>
<body>
<!--<div id="logo_minedu"></div>-->
	<div id="loginbox">
    <div id="logo"></div>		
		<div id="loginform">
			<form name="login" action="" method="post">
				<div id="username_field">
				  <input type="input" name="Username" id="Username" placeholder="Nombre de Usuario" class="required" value="" />
				</div>
			  <div id="password_field"><input type="password" name="Password" id="Password" placeholder="Contraseña" class="required" value="" /></div>
				<div id="buttonline">
					<input type="submit" id="loginbutton" name="loginbutton" class="float_left width_4" value="Ingresar" />									
                    <div style="float: right; position:relative; width:100px; height:36px; background-image:url(data/images/mini_logo.png);"></div>
                </div>
			</form>            
		</div>
        <?
		showMessage();
        ?>
        <!--<div style="background-color:red; padding:5px; color: #FFF; font-size:14px; border-radius:3px;  
-moz-border-radius:3px; -webkit-border-radius:3px; margin-top:10px; font-weight:bold;">
<li>Formulario habilitado solamente para funcionarios con fuente de financiamiento TGN.</li>
<li>Apellidos o nombres con "ñ" utilizar n. (ej. Juan Siñani - nombre de usuario "juansinani" )</li>
</div>-->
	</div>
    
    <div style="width: 600px; height: 100%; margin: auto; background:#defcb3; color:#000; padding:10px; -webkit-border-radius: 10px;  -moz-border-radius: 10px;  border-radius: 10px; position:relative; margin-top:10px;" id="flotante">
<p style="text-shadow: 1px 1px 1px black;" ><strong>IMPORTANTE!!!</strong></p>
<ul style="list-style:">
  <li><strong>GENERADOR DE NOMBRES DE USUARIO</strong> <em>(SOLO SIRVE DE DEMOSTRACION) </em><a href="generador">AQUI</a></li>
<li><strong>TUTORIAL/MANUAL DE USUARIO</strong> <strong>PARA CONSULTORES DEL LÍNEA</strong> (para el correcto llenado de Datos en el Formulario Web de la Ficha Personal) <a href="tutorial/TutorialConsultores.pdf" target="new">AQUI</a></li>
<li>
  <strong>TUTORIAL/MANUAL DE USUARIO</strong> <strong>PARA FUNCIONARIOS CON ITEM TGN</strong> (para el correcto llenado de Datos en el Formulario Web de la Ficha Personal) <a href="tutorial/TutorialServidorTGN.pdf" target="new">AQUI</a>
</li>
<li><strong>DEBE UTILIZAR COMO NAVEGADOR WEB: <a href="http://www.mozilla.org/es-ES/firefox/new/" target="_blank">MOZILLA FIREFOX</a> O <a href="http://www.google.com/intl/es/chrome/" target="_blank">GOOGLE CHROME</a></strong>.</li>

</ul>
<p>Recuerde que es una DECLARACIÓN JURADA y para que le sea  mas facil y seguro el completar el formulario, debe tener a mano toda la información requerida a llenar en el formulario de la Ficha Personal.</p>
</ul>
<p>
<div style=" margin-top:10px; float:right; position:relative; "><a href="javascript:cerrar();" style="color:#FFF; font-weight:bold; text-decoration:none;"> Cerrar Mensaje <img src="data/images/close.png"></a> </div>
</p>
</div>
</body>
</html>