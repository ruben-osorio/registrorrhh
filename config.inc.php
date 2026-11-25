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
// Conexión secundaria usada por los módulos de registro (CAS); misma base consolidada
if (!defined('DB_SERVERC'))   define('DB_SERVERC', DB_SERVER);
if (!defined('DB_USERC'))     define('DB_USERC', DB_USER);
if (!defined('DB_PASSC'))     define('DB_PASSC', DB_PASS);
if (!defined('DB_DATABASEC')) define('DB_DATABASEC', DB_DATABASE);
unset($__ssrp_db);
//tablas-bd
//define('TABLE1', "");
/*------------------------------------*/
define("TABLE1", "dat_aca");
define('TABLE2', "funcionario");
define('TABLE3', "vacaciones");
define("TABLE4", "user");	
define("TABLE5", "permisos");	
define("TABLE6", "prestamos");	
define("TABLE7", " ");
define("TABLE8", "dat_fam");
define("TABLE10", "dat_ed");
define("TABLE11", "lang_func");
define("TABLE12", "ot_con");
define("TABLE13", "doc_uni");
define("TABLE14", "exp_lab");
define("TABLE15", "fin_per");
define("TABLE16", "cat_per");
define("TABLE17", "fin_con");
define("TABLE18", "cat_con");//definida 1
define("TABLE19", "old_mov");//antiguos func
define("TABLE20", "eval_per");
define("TABLE21", "capacitacion");
define("TABLE22", "permanente");	
define("TABLE23", "soc_secu");
define("TABLE24", "old_cas");
define("TABLE25", "cta_banc");
define("TABLE26", "permanente_docs");
define("TABLE27", "ult_decl");
define("TABLE28", "char_per");
define("TABLE29", "eval_per");
define("TABLE30", "contrato");	
define("TABLE31", "char_con");	
define("TABLE32", "consultor_docs");
define("TABLE33", "eval_con");
define("TABLE34", "old_movc");//antiguos func
define("TABLE35", "baja");
define("TABLE36", "baja_con");
define("TABLE37", "des_hab_temp");
define("TABLE38", "logs_access");
/**/
define('TABLEX', "funcionario_2");
define("TABLE_TEMP", "canasta");
define("TABLE_TEMP_2", "canastav2");
/*------------------------------------*/

?>
