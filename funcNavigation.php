<?
require_once("security.php");
$id_func=$_SESSION['id_func'];

$mysqli = new mysqli("localhost", "registro", "Roacorp", "registrorrhh");
 

$sql = "SELECT id_per FROM permanente WHERE id_func = " . $id_func;

if ($res = $mysqli->query($sql)) 
{
    if ($res->num_rows > 0) {
		$rows = $res->fetch_assoc();
		$perm = $rows['id_per'];
        $res->free();
    }
    else {
        echo "No matching records are found.";
    }
}
else {
	
	$perm = 0;
    echo "ERROR: Could not able to execute $sql. "
                                             .$mysqli->error;
}
$mysqli->close();


//echo $r1[id_per];	

//echo "verdad";
?>


<script type="text/javascript" src="js/scripts.js"></script>
<ul id="navigation"><!-- Main Navigation Begin -->				
				<li><a href="?selected=FullRegister" class="icon_users">Click Aquí, Registro Ficha Personal</a>
		
				</li>
			
                <li><a href="#" class="icon_email">Vacaciones</a>
					<ul>
						<li><a href="#" onclick="MM_openBrWindow('RepIndivFormVac.php?id=<? echo $id_func ?>','regpermiso','scrollbars=yes,width=650,height=420')" title="Reporte Individual">Saldo vacaciones</a>	
</li>
					</ul>
				</li>
			  <li><a href="logout.php" class="icon_logout">Salir</a></li>
			</ul>