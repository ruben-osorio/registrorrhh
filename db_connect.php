<?php
/* Conexión a base de datos (mysqli) usando la configuración central de compat.php */
if (!function_exists('ssrp_db_config')) {
    require_once __DIR__ . '/compat.php';
}
$__db = ssrp_db_config();
$conn = mysqli_connect($__db['host'], $__db['user'], $__db['pass'], $__db['name'], $__db['port'])
    or die("Connection failed: " . mysqli_connect_error());
mysqli_set_charset($conn, $__db['charset']);
unset($__db);
?>