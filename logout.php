<?
session_start();
require('LoginSystem.class.php');
$loginSys = new LoginSystem();
$loginSys->logout();
header('location: login.php');
exit;
?>