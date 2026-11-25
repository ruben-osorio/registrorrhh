<?php
// Configuración de base de datos: variables de entorno (Railway) o valores
// locales por defecto. Ver ssrp_db_config() en compat.php.
if (!function_exists('ssrp_db_config')) {
	require_once __DIR__ . '/compat.php';
}
$__ssrp_db = ssrp_db_config();
if (!defined('DB_SERVER'))   define('DB_SERVER', $__ssrp_db['host']);
if (!defined('DB_PORT'))     define('DB_PORT', $__ssrp_db['port']);
if (!defined('DB_USER'))     define('DB_USER', $__ssrp_db['user']);
if (!defined('DB_PASS'))     define('DB_PASS', $__ssrp_db['pass']);
if (!defined('DB_DATABASE')) define('DB_DATABASE', $__ssrp_db['name']); // BASE DE DATOS CONSOLIDADA
unset($__ssrp_db);
//tablas-bd
//define('TABLE1', "");
/*------------------------------------*/
define("TABLE1p", "dat_aca");
define('TABLE2p', "funcionario");
define('TABLE3p', "vacaciones");
define("TABLE4p", "user");	
define("TABLE5p", "permisos");	
define("TABLE6p", "prestamos");	
define("TABLE7p", " ");
define("TABLE8p", "dat_fam");
define("TABLE10p", "dat_ed");
define("TABLE11p", "lang_func");
define("TABLE12p", "ot_con");
define("TABLE13p", "doc_uni");
define("TABLE14p", "exp_lab");
define("TABLE15p", "fin_per");
define("TABLE16p", "cat_per");
define("TABLE17p", "fin_con");
define("TABLE18p", "cat_con");//definida 1
define("TABLE19p", "old_mov");//antiguos func
define("TABLE20p", "eval_per");
define("TABLE21p", "capacitacion");
define("TABLE22p", "permanente");	
define("TABLE23p", "soc_secu");
define("TABLE24p", "old_cas");
define("TABLE25p", "cta_banc");
define("TABLE26p", "permanente_docs");
define("TABLE27p", "ult_decl");
define("TABLE28p", "char_per");
define("TABLE29p", "eval_per");
define("TABLE30p", "contrato");	
define("TABLE31p", "char_con");	
define("TABLE32p", "consultor_docs");
define("TABLE33p", "eval_con");
define("TABLE34p", "old_movc");//antiguos func
define("TABLE35p", "baja");
define("TABLE36p", "baja_con");
define("TABLE37p", "des_hab_temp");
define("TABLE38p", "logs_access");
/**/
define('TABLEXp', "funcionario_2");
define("TABLE_TEMPp", "canasta");
define("TABLE_TEMP_2p", "canastav2");
/*------------------------------------*/

?>
