<?php
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

class LoginSystem
{
	var	$db_host,
		$db_name,
		$db_user,
		$db_password,
		$connection,
		$username,
		$password;
	/**
	 * Constructor
	 */
	function __construct()
	{
		require_once('config.inc.php');		
		$this->db_host = DB_SERVER;
		$this->db_name = DB_DATABASE;
		$this->db_user = DB_USER;
		$this->db_password = DB_PASS;
	}	
	function isLoggedIn()
	{
		return !empty($_SESSION['LoggedIn']);
	}
	function doLogin($username, $password)
	{
		$this->connect();
		$this->username = strtoupper($username);
		$this->password = $password;

		// Consulta preparada: evita inyección SQL en el formulario de acceso.
		$stmt = mysqli_prepare($this->connection,
			"SELECT * FROM `".TABLE4."` WHERE username = ? AND password = ? ORDER BY id ASC LIMIT 1");
		$row = null;
		if ($stmt)
		{
			$user = (string) $username;
			$pass = (string) $password;
			mysqli_stmt_bind_param($stmt, 'ss', $user, $pass);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);
			$row = $result ? mysqli_fetch_assoc($result) : null;
			mysqli_stmt_close($stmt);
		}

		if (!$row)
		{
			$this->logAccess($username, 'LOGIN_FAIL');
			$this->disconnect();
			return false;
		}

		// more secure to regenerate a new id.
		session_regenerate_id(true);

		//set session vars up
		//id	username	password	nombre	ap_1	ap_2	fecha_nac	permisos
		$_SESSION['LoggedIn'] = true;
		$_SESSION['id_func'] = $row['id_func'];
		$_SESSION['username'] = $row['username'];
		$_SESSION['nombre_user'] = $row['nombre'];
		$_SESSION['ap_1_user'] = $row['ap_1'];
		$_SESSION['ap_2_user'] = $row['ap_2'];
		$_SESSION['permisos'] = $row['permisos'];

		$this->logAccess($row['username'], 'LOGIN_OK');
		$this->disconnect();
		return true;
	}

	/**
	 * Registra el intento de acceso en logs_access.
	 */
	function logAccess($username, $action)
	{
		$stmt = mysqli_prepare($this->connection,
			"INSERT INTO `".TABLE38."` (user, ip, navigator, fecha_hora, action) VALUES (?, ?, ?, ?, ?)");
		if (!$stmt)
		{
			return;
		}
		$user = (string) $username;
		$ip = isset($_SERVER['HTTP_X_FORWARDED_FOR'])
			? trim(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0])
			: (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
		$navegador = isset($_SERVER['HTTP_USER_AGENT']) ? substr($_SERVER['HTTP_USER_AGENT'], 0, 255) : '';
		$fecha = date("Y-m-d H:i:s");
		mysqli_stmt_bind_param($stmt, 'sssss', $user, $ip, $navegador, $fecha, $action);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}
	
	/**
	 * Destroy session data/Logout.
	 */
	function logout()
	{
		unset($_SESSION['LoggedIn']);
		unset($_SESSION['userName']);
		session_destroy();
	}
	
	/**
	 * Connect to the Database
	 * 
	 * @return true/false
	 */
	function connect()
	{
		
		// mysql_connect (compat.php) usa la configuración central / variables de entorno.
		$this->connection = mysql_connect() or die("No se pudo conectar a MySQL");

		mysql_select_db($this->db_name, $this->connection) or die("No se pudo seleccionar la base de datos");
		
		// Valid connection object? everything ok?
		if($this->connection)
		{
			return true;
		}
		else return false;
	}
	
	/**
	 * Disconnect from the db
	 */
	function disconnect()
	{
		mysql_close($this->connection);
	}
	
	/**
	 * Cleans a string for input into a MySQL Database.
	 * Gets rid of unwanted characters/SQL injection etc.
	 * 
	 * @return string
	 */
	function clean($str)
	{
		// Only remove slashes if it's already been slashed by PHP
		if(get_magic_quotes_gpc())
		{
			$str = stripslashes($str);
		}
		// Let MySQL remove nasty characters.
		$str = mysql_real_escape_string($str);
		
		return $str;
	}
	
	/**
	 * create a random password
	 * 
	 * @param	int $length - length of the returned password
	 * @return	string - password
	 *
	 */
	function randomPassword($length = 8)
	{
		$pass = "";
		
		// possible password chars.
		$chars = array("a","A","b","B","c","C","d","D","e","E","f","F","g","G","h","H","i","I","j","J",
			   "k","K","l","L","m","M","n","N","o","O","p","P","q","Q","r","R","s","S","t","T",
			   "u","U","v","V","w","W","x","X","y","Y","z","Z","1","2","3","4","5","6","7","8","9");
			   
		for($i=0 ; $i < $length ; $i++)
		{
			$pass .= $chars[mt_rand(0, count($chars) -1)];
		}
		
		return $pass;
	}


	// Alias del constructor estilo PHP 4
	function LoginSystem() { return call_user_func_array(array($this, '__construct'), func_get_args()); }
}

?>