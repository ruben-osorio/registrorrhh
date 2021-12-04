<?
require_once("security.php");
?>
<ul id="navigation"><!-- Main Navigation Begin -->				
				<li><a href="#" class="icon_users">Funcionarios</a>
					<ul>
						<li><a href="?selected=RegistroBasico">Registro Básico</a></li>						
                        <li><a href="?selected=FichaPersonal">Ficha Personal</a></li>
                        <li><a href="?selected=Baja">Baja</a></li>
                        <li><a href="?selected=Alta">Alta</a></li>
                        <li><a href="?selected=AfiliacionCaja">Afiliación Caja</a></li>
                        <li><a href="?selected=RegistroAfp">Registro AFP</a></li>
                         <li><a href="?selected=Movilidad">Movilidad</a></li>
                          <li><a href="?selected=Modificar">Modificación Pass</a></li>
					</ul>
</li>
                <li><a href="#" class="icon_folder_out">AÑOS SERVICIO</a>
                	<ul>
                    	<li><a href="?selected=CAS">Registro CAS</a></li>
                        <li><a href="?selected=RepIndividualCAS">Reporte Indiv. CAS</a></li>
                        <li><a href="?selected=RepGeneralCAS">Reporte General CAS</a></li>                        
                    </ul>
                </li>
                <li><a href="#" class="icon_email">Vacaciones</a>
	                <ul>
						<li><a href="?selected=ModificarSaldoVac">Modificar Saldo</a></li>
                        <li><a href="?selected=RegistrarPermiso">Permiso a Cuenta Vacación</a></li>
                        <li><a href="?selected=RepFormVac">Reporte Formularios</a></li>
                        <li><a href="?selected=RepIndividualSaldo">Reporte Indiv. Saldo</a></li>
                        <li><a href="?selected=VacacionesTGN">Reporte General Saldo</a></li>
                        <li><a href="?selected=AsignVacaciones">Asignar Vacaciones</a></li>						
					</ul>
                </li>				
				<li><a href="#" class="icon_folder">Documentos</a>
					<ul>
						<li><a href="?selected=CargarDocumentos">Cargar</a></li>
						<li><a href="files/index.php" onclick="window.open(this.href, 1, 'scrollbars=yes, fullscreen=yes'); return false;">Explorador de Files (A)</a></li>
					</ul>
				</li>
				<li><a href="#" class="icon_stats">Consultas</a>
                	<ul>
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