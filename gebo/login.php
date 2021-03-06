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
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Registro de Personal</title>
    
        <!-- Bootstrap framework -->
            <link rel="stylesheet" href="gebo/bootstrap/css/bootstrap.min.css" />
            <link rel="stylesheet" href="gebo/bootstrap/css/bootstrap-responsive.min.css" />
        <!-- theme color-->
            <link rel="stylesheet" href="gebo/css/blue.css" />
        <!-- tooltip -->    
			<link rel="stylesheet" href="gebo/lib/qtip2/jquery.qtip.min.css" />
        <!-- main styles -->
            <link rel="stylesheet" href="gebo/css/style.css" />
    
        <!-- Favicons and the like (avoid using transparent .png) -->
            <link rel="shortcut icon" href="favicon.ico" />
            <link rel="apple-touch-icon-precomposed" href="icon.png" />
    
        <link href='http://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>
    
        <!--[if lte IE 8]>
            <script src="js/ie/html5.js"></script>
			<script src="js/ie/respond.min.js"></script>
        <![endif]-->
		
    </head>
    <body class="login_page">
    
    <div class="row-fluid">
	  <div class="span12">
							<div class="alert alert-block alert-warning fade in">
<p style="text-shadow: 1px 1px 1px black;" ><strong>IMPORTANTE!!!</strong></p>
							  <ul style="list-style:">
<li><strong>TUTORIAL/MANUAL DE USUARIO</strong> <strong>PARA CONSULTORES DEL L??NEA</strong> (para el correcto llenado de Datos en el Formulario Web de la Ficha Personal) <a href="tutorial/TutorialConsultores.pdf" target="new">AQUI</a></li>
<li>
  <strong>TUTORIAL/MANUAL DE USUARIO</strong> <strong>PARA FUNCIONARIOS CON ITEM TGN</strong> (para el correcto llenado de Datos en el Formulario Web de la Ficha Personal) <a href="tutorial/TutorialServidorTGN.pdf" target="new">AQUI</a>
</li>
<li><strong>LE RECOMENDAMOS UTILIZAR NAVEGADOR O BROWSER: <a href="http://www.mozilla.org/es-ES/firefox/new/" target="_blank">MOZILLA FIREFOX</a> O <a href="http://www.google.com/intl/es/chrome/" target="_blank">GOOGLE CHROME</a></strong>.</li>

</ul>
<p class="f_req">Recuerde que es una DECLARACI??N JURADA y para que le sea  mas facil y seguro el completar el formulario, debe tener a mano toda la informaci??n requerida a llenar en el formulario de la Ficha Personal.</p>
</ul>
<p>
	    </div>
						</div>
						
					</div>
    
    
		<div class="login_box">
			
            <form name="login" id="login_form" action="" method="post">
				<div class="top_b"> Ingrese sus datos</div>    
				<div class="alert alert-info alert-login">
					Si olvid?? sus datos comun??quese con el interno 215
				</div>
				<div class="cnt_b">
					<div class="formRow">
						<div class="input-prepend">
							<span class="add-on"><i class="icon-user"></i></span><input type="text" id="username" name="username" placeholder="Nombre de Usuario" value="" />
						</div>
					</div>
					<div class="formRow">
						<div class="input-prepend">
							<span class="add-on"><i class="icon-lock"></i></span><input type="password" id="password" name="password" placeholder="Password/Contrase??a" value="" />
						</div>
					</div>
					
				</div>
				<div class="btm_b clearfix">
                <img src="../data/images/logo_mini.jpg">
                <button class="btn btn-inverse pull-right" type="submit" id="loginbutton" name="loginbutton">Sign In</button>					
			  </div>  
			</form>
			
			<form action="dashboard.html" method="post" id="pass_form" style="display:none">
				<div class="top_b">Can't sign in?</div>    
					<div class="alert alert-info alert-login">
					Please enter your email address. You will receive a link to create a new password via email.
				</div>
				<div class="cnt_b">
					<div class="formRow clearfix">
						<div class="input-prepend">
							<span class="add-on">@</span><input type="text" placeholder="Your email address" />
						</div>
					</div>
				</div>
				<div class="btm_b tac">
					<button class="btn btn-inverse" type="submit">Request New Password</button>
				</div>  
			</form>
			
			<form action="dashboard.html" method="post" id="reg_form" style="display:none">
				<div class="top_b">Sign up to Gebo Admin</div>
				<div class="alert alert-login">
					By filling in the form bellow and clicking the "Sign Up" button, you accept and agree to <a data-toggle="modal" href="#terms">Terms of Service</a>.
				</div>
				<div id="terms" class="modal hide fade" style="display:none">
					<div class="modal-header">
						<a class="close" data-dismiss="modal">??</a>
						<h3>Terms and Conditions</h3>
					</div>
					<div class="modal-body">
						<p>
							Nulla sollicitudin pulvinar enim, vitae mattis velit venenatis vel. Nullam dapibus est quis lacus tristique consectetur. Morbi posuere vestibulum neque, quis dictum odio facilisis placerat. Sed vel diam ultricies tortor egestas vulputate. Aliquam lobortis felis at ligula elementum volutpat. Ut accumsan sollicitudin neque vitae bibendum. Suspendisse id ullamcorper tellus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vestibulum at augue lorem, at sagittis dolor. Curabitur lobortis justo ut urna gravida scelerisque. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aliquam vitae ligula elit.
							Pellentesque tincidunt mollis erat ac iaculis. Morbi odio quam, suscipit at sagittis eget, commodo ut justo. Vestibulum auctor nibh id diam placerat dapibus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Suspendisse vel nunc sed tellus rhoncus consectetur nec quis nunc. Donec ultricies aliquam turpis in rhoncus. Maecenas convallis lorem ut nisl posuere tristique. Suspendisse auctor nibh in velit hendrerit rhoncus. Fusce at libero velit. Integer eleifend sem a orci blandit id condimentum ipsum vehicula. Quisque vehicula erat non diam pellentesque sed volutpat purus congue. Duis feugiat, nisl in scelerisque congue, odio ipsum cursus erat, sit amet blandit risus enim quis ante. Pellentesque sollicitudin consectetur risus, sed rutrum ipsum vulputate id. Sed sed blandit sem. Integer eleifend pretium metus, id mattis lorem tincidunt vitae. Donec aliquam lorem eu odio facilisis eu tempus augue volutpat.
						</p>
					</div>
					<div class="modal-footer">
						<a data-dismiss="modal" class="btn" href="#">Close</a>
					</div>
				</div>
				<div class="cnt_b">
					
					<div class="formRow">
						<div class="input-prepend">
							<span class="add-on"><i class="icon-user"></i></span><input type="text" placeholder="Username" />
						</div>
					</div>
					<div class="formRow">
						<div class="input-prepend">
							<span class="add-on"><i class="icon-lock"></i></span><input type="text" placeholder="Password" />
						</div>
					</div>
					<div class="formRow">
						<div class="input-prepend">
							<span class="add-on">@</span><input type="text" placeholder="Your email address" />
						</div>
						<small>The e-mail address is not made public and will only be used if you wish to receive a new password.</small>
					</div>
					 
				</div>
				<div class="btm_b tac">
					<button class="btn btn-inverse" type="submit">Sign Up</button>
				</div>  
			</form>
			
		</div>
		
		<div class="links_b links_btm clearfix">
			<span class="linkform"><a href="#pass_form">Forgot password?</a></span>
			<span class="linkform" style="display:none">Never mind, <a href="#login_form">send me back to the sign-in screen</a></span>
		</div>  
        
        <script src="gebo/js/jquery.min.js"></script>
        <script src="gebo/js/jquery.actual.min.js"></script>
        <script src="gebo/lib/validation/jquery.validate.min.js"></script>
		<script src="gebo/bootstrap/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function(){
                
				//* boxes animation
				form_wrapper = $('.login_box');
                $('.linkform a,.link_reg a').on('click',function(e){
					var target	= $(this).attr('href'),
						target_height = $(target).actual('height');
					$(form_wrapper).css({
						'height'		: form_wrapper.height()
					});	
					$(form_wrapper.find('form:visible')).fadeOut(400,function(){
						form_wrapper.stop().animate({
                            height	: target_height
                        },500,function(){
                            $(target).fadeIn(400);
                            $('.links_btm .linkform').toggle();
							$(form_wrapper).css({
								'height'		: ''
							});	
                        });
					});
					e.preventDefault();
				});
				
				//* validation
				$('#login_form').validate({
					onkeyup: false,
					errorClass: 'error',
					validClass: 'valid',
					rules: {
						username: { required: true, minlength: 3 },
						password: { required: true, minlength: 3 }
					},
					highlight: function(element) {
						$(element).closest('div').addClass("f_error");
					},
					unhighlight: function(element) {
						$(element).closest('div').removeClass("f_error");
					},
					errorPlacement: function(error, element) {
						$(element).closest('div').append(error);
					}
				});
            });
        </script>
    </body>
</html>
