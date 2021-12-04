<?
require_once("security.php");
$id_func=$_SESSION['id_func'];

?>
<script type="text/javascript" src="js/scripts.js"></script>
<ul id="navigation"><!-- Main Navigation Begin -->				
				<li><a href="#" class="icon_users">Datos Personales</a>
					<ul>
						<li><a href="?selected=FullRegister">Registro Completo</a></li>                        
					</ul>
				</li>
                <li><a href="#" class="icon_email">Vacaciones</a>
					<ul>
						<li><a href="#" onclick="MM_openBrWindow('RepIndivFormVac.php?id=<? echo $id_func ?>','regpermiso','scrollbars=yes,width=650,height=420')" title="Reporte Individual">Saldo vacaciones</a>	
</li>
					</ul>
				</li>
			  <li><a href="logout.php" class="icon_logout">Salir</a></li>
			</ul>