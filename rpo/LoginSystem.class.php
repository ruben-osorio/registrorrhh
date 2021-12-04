<?php 
session_start();

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
	function LoginSystem()
	{
		require_once('config.inc.php');		
		$this->db_host = DB_SERVER;
		$this->db_name = DB_DATABASE;
		$this->db_user = DB_USER;
		$this->db_password = DB_PASS;
	}	
	function isLoggedIn()
	{
		if($_SESSION['LoggedIn'])
		{
			return true;
		}
		else return false;
	}	
	function doLogin($username, $password)
	{
		$this->connect();		
		$this->username = strtoupper($username);
		$this->password = $password;		
		// check db for user and pass here.		
/*		$sql = sprintf("SELECT * FROM ".TABLE1." WHERE username = '$this->clean($this->username)' 
		and password = '$this->clean($this->password)'");*/
					
		$result = mysql_query("select * from ".TABLE4." where 
		".TABLE4.".username='$username' and 
		".TABLE4.".password='$password'	order by id ASC limit 1	
		", $this->connection);
		
		
		// If no user/password combo exists return false
		if(mysql_affected_rows($this->connection) != 1)
		{
			$IP=$_SERVER[REMOTE_ADDR];
			$FECHA=date("Y-m-d H:s",time());
			$NAVEGADOR=$_SERVER['HTTP_USER_AGENT'];
			$result1=mysql_query("INSERT INTO ".TABLE38."(user, ip, navigator, fecha_hora, action) values ('$username','$IP','$NAVEGADOR','$FECHA', 'LOGIN_FAIL')",$this->connection);
			$this->disconnect();
			return false;						
		}
		else // matching login ok
		{
			$row = mysql_fetch_array($result);
			// more secure to regenerate a new id.
			session_regenerate_id();
			
			//set session vars up
			//id	username	password	nombre	ap_1	ap_2	fecha_nac	permisos
			
			$_SESSION['LoggedIn'] = true;			
			$_SESSION['id_func'] = $row[id_func];
			$_SESSION['username'] = $row[username];
			$_SESSION['nombre_user'] = $row[nombre];
			$_SESSION['ap_1_user'] = $row[ap_1];
			$_SESSION['ap_2_user'] = $row[ap_2];
			$_SESSION['permisos'] = $row[permisos];
			
			$IP=$_SERVER[REMOTE_ADDR];
			$FECHA=date("Y-m-d H:s",time());
			$NAVEGADOR=$_SERVER['HTTP_USER_AGENT'];
			$result1=mysql_query("INSERT INTO ".TABLE38."(user, ip, navigator, fecha_hora, action) values ('$row[username]','$IP','$NAVEGADOR','$FECHA', 'LOGIN_OK')",$this->connection);
			
			//FECHA ACTUAL
			/*$actual_date=date ("Y-m-d",time());
			$result1 = mysql_query( 'select rang_start,rang_end  from '.TABLE37.' where id_func='.$row[id_func].' ', $this->connection);
			$r1=mysql_fetch_array($result1);
			
			$date_start=$r1[rang_start];
			$date_end=$r1[rang_end];
			
			$result2=mysql_query("select * from ".TABLE37." where id_func=".$row[id_func]." AND  ",$this->connection);*/
			
		}
		
		$this->disconnect();
		return true;
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
		echo "$this->db_host"."<br />";
		echo "$this->db_user"."<br />";
		echo "$this->db_password"."<br />";
		
		$this->connection = mysql_connect("$this->db_host:3306", "$this->db_user", "$this->db_password") 
														or die("Unable to connect to MySQL fuck you ");
	

		mysql_select_db($this->db_name, $this->connection) or die("Unable to select DB!");
		
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

}

?>