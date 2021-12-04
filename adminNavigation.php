<?
require_once("security.php");
?>
<ul id="navigation"><!-- Main Navigation Begin -->		
<li><a href="index.php" >Inicio</a>
					
</li>		
				<li><a href="#" class="icon_users">Funcionarios</a>
					<ul>
						<li><a href="?selected=RegistroBasico">Registro Básico</a></li>						
                        <li><a href="?selected=FichaPersonal">Ficha Personal</a></li>
						<li><a href="?selected=FichaPersonalP">Ficha Personal Pasivos</a></li>
                        <li><a href="?selected=Baja">Baja</a></li>
                        <li><a href="?selected=Alta">Alta</a></li>
                        <li><a href="?selected=AfiliacionCaja">Afiliación Caja</a></li>
                        <li><a href="?selected=RegistroAfp">Registro AFP</a></li>
						<li><a href="?selected=Movilidad">Movilidad</a></li>
                          <li><a href="?selected=Modificar">Modificación Pass</a></li>
					</ul>
</li>

              			
				
				<li><a href="#" class="icon_stats">Consultas</a>
                	<ul>
                    	<li><a href="?selected=NominaTGN">Nómina TGN</a></li>
                        <li><a href="?selected=NominaTgn-252">Nómina TGN-252</a></li>
                        <li><a href="?selected=NominaBajasGral">Nómina PASIVOS</a></li>
                                                
                    </ul>
                </li>
			  <li><a href="logout.php" class="icon_logout">Salir</a></li>
			</ul>