<?
session_start();
require('LoginSystem.class.php');
$loginSys = new LoginSystem();
if(!$loginSys->isLoggedIn())
{
	header("Location: login.php");
	exit;
}
?>