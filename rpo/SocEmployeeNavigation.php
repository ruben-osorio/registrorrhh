<?
require_once("security.php");
?>
<ul id="navigation"><!-- Main Navigation Begin -->				
				<li><a href="#" class="icon_users">Seguro Médico</a>
					<ul>						
                        <li><a href="?selected=AfiliacionCaja">Registro AVC-04</a></li>						                        <li><a href="?selected=PendientesAfiliacion">Pendientes Afiliacion</a></li>
                        <li><a href="?selected=BajaCaja">Baja del Seguro Médico</a></li>
                        <li><a href="?selected=PendientesDesAfiliacion">Pendientes Desafiliacion</a></li>
					</ul>
				</li>				
				<li><a href="#" class="icon_folder">AFP</a>
					<ul>
						<li><a href="?selected=AfpListas">Listado General</a></li>
					</ul>
				</li>
				<li><a href="#" class="icon_stats">Consultas</a>
                	<ul>
                    	<li><a href="?selected=AfiliadosCaja">Afiliados CNS</a></li>                        
                        <li><a href="?selected=BajaSeguroSocial">Bajas CNS</a></li>                    
                        <li><a href="?selected=VacacionesTGN">Vacaciones TGN</a></li>
 <li><a href="?selected=NominaTGN">Nómina TGN</a></li>
                        <li><a href="?selected=NominaAsdi">Nómina ASDI</a></li>
                        <li><a href="?selected=NominaCanasta">Nómina CANASTA</a></li>
                        <li><a href="?selected=NominaCosude">Nómina COSUDE</a></li>
                        <li><a href="?selected=NominaTgn-252">Nómina TGN-252</a></li>
                        <li><a href="?selected=NominaUnicef">Nómina UNICEF</a></li>
                        <li><a href="?selected=NominaBajasGral">Nómina PASIVOS</a></li>
                    </ul>
                </li>
			  <li><a href="logout.php" class="icon_logout">Salir</a></li>
			</ul>