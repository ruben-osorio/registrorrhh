<?
require_once("security.php");
?>
<ul id="navigation"><!-- Main Navigation Begin -->				
				<li><a href="#" class="icon_users">FUNCIONARIOS</a>
					<ul>
						<li><a href="?selected=RegistroBasico">Registro Básico</a></li>						
                        <li><a href="?selected=Baja">Baja</a></li>
                         <li><a href="?selected=Movilidad">Movilidad</a></li>
					</ul>
</li>
                <li><a href="#" class="icon_email">Vacaciones</a>
	                <ul>
                        <li><a href="?selected=RepFormVac">Reporte Form. 10-01</a></li>
                        <li><a href="?selected=RepIndividualSaldo">Reporte Indiv. Saldo</a></li>
                        <li><a href="?selected=VacacionesTGN">Reporte General Saldo</a></li>						
					</ul>
                </li>				          				
				<li><a href="#" class="icon_stats">Consultas</a>
                	<ul>
                    	
                        <li><a href="?selected=NominaTGN">Nómina TGN</a></li>
                    </ul>
                </li>
			  <li><a href="logout.php" class="icon_logout">Salir</a></li>
			</ul>