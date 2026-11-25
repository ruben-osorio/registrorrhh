<?php
/**
 * compat.php
 *
 * Capa de compatibilidad PHP 5 -> PHP 8.x para SSRP.
 * Se carga automáticamente en cada petición mediante `auto_prepend_file`
 * (ver .htaccess para WAMP y docker/php.ini para Railway).
 *
 * - Reimplementa la extensión `mysql_*` (eliminada en PHP 7) sobre mysqli.
 * - Reimplementa funciones eliminadas: each, create_function, ereg*, split,
 *   get_magic_quotes_*.
 * - Centraliza la configuración de base de datos en variables de entorno
 *   (Railway expone MYSQLHOST, MYSQLPORT, MYSQLUSER, MYSQLPASSWORD, MYSQLDATABASE).
 */

if (defined('SSRP_COMPAT_LOADED')) {
    return;
}
define('SSRP_COMPAT_LOADED', true);

// PHP 8.1+ lanza excepciones en mysqli por defecto; el código legado espera `false`.
mysqli_report(MYSQLI_REPORT_OFF);

/* -------------------------------------------------------------------------
 * Configuración de base de datos por entorno
 * ---------------------------------------------------------------------- */

/**
 * Lee una variable de entorno probando varios nombres en orden.
 */
function ssrp_env(array $names, $default = null)
{
    foreach ($names as $name) {
        $value = getenv($name);
        if ($value !== false && $value !== '') {
            return $value;
        }
        if (isset($_SERVER[$name]) && $_SERVER[$name] !== '') {
            return $_SERVER[$name];
        }
    }
    return $default;
}

/**
 * Configuración efectiva de la base de datos.
 * Valores por defecto = entorno local WAMP.
 */
function ssrp_db_config()
{
    static $config = null;
    if ($config === null) {
        $config = array(
            'host'     => ssrp_env(array('DB_HOST', 'MYSQLHOST'), 'localhost'),
            'port'     => (int) ssrp_env(array('DB_PORT', 'MYSQLPORT'), 3306),
            'user'     => ssrp_env(array('DB_USER', 'MYSQLUSER'), 'root'),
            'pass'     => ssrp_env(array('DB_PASS', 'DB_PASSWORD', 'MYSQLPASSWORD'), ''),
            'name'     => ssrp_env(array('DB_DATABASE', 'DB_NAME', 'MYSQLDATABASE'), 'rrhh'),
            'charset'  => ssrp_env(array('DB_CHARSET'), 'utf8mb4'),
            'sql_mode' => ssrp_env(array('DB_SQL_MODE'), 'NO_ENGINE_SUBSTITUTION'),
            // Bases históricas que hoy están consolidadas en la base principal.
            'aliases'  => array_filter(array_map('trim', explode(',', ssrp_env(
                array('DB_ALIASES'),
                'registrorrhh,ssrp,ssrp-dev,ssrp-per'
            )))),
        );
    }
    return $config;
}

/**
 * Traduce un nombre de base histórico a la base principal.
 */
function ssrp_db_name($name)
{
    $config = ssrp_db_config();
    $aliases = array_map('strtolower', $config['aliases']);
    if ($name === null || $name === '' || in_array(strtolower($name), $aliases, true)) {
        return $config['name'];
    }
    return $name;
}

/**
 * Conexión mysqli con la configuración central (reemplaza credenciales fijas en el código).
 */
function ssrp_mysqli_connect()
{
    $config = ssrp_db_config();
    $link = @mysqli_connect($config['host'], $config['user'], $config['pass'], $config['name'], $config['port']);
    if ($link) {
        mysqli_set_charset($link, $config['charset']);
        if ($config['sql_mode'] !== '') {
            mysqli_query($link, "SET SESSION sql_mode = '" . mysqli_real_escape_string($link, $config['sql_mode']) . "'");
        }
    }
    return $link;
}

/* -------------------------------------------------------------------------
 * Extensión mysql_* sobre mysqli
 * ---------------------------------------------------------------------- */

if (!function_exists('mysql_connect')) {

    define('MYSQL_ASSOC', MYSQLI_ASSOC);
    define('MYSQL_NUM', MYSQLI_NUM);
    define('MYSQL_BOTH', MYSQLI_BOTH);

    $GLOBALS['__ssrp_mysql_link'] = null;
    $GLOBALS['__ssrp_mysql_connect_error'] = '';
    $GLOBALS['__ssrp_mysql_connect_errno'] = 0;

    function __ssrp_mysql_link($link = null)
    {
        if ($link instanceof mysqli) {
            return $link;
        }
        if ($GLOBALS['__ssrp_mysql_link'] instanceof mysqli) {
            return $GLOBALS['__ssrp_mysql_link'];
        }
        // Igual que ext/mysql: conexión implícita con los valores por defecto.
        return mysql_connect();
    }

    /**
     * Las credenciales recibidas se ignoran a propósito: el código legado tiene
     * servidores y usuarios distintos escritos en varios archivos. Toda conexión
     * usa la configuración central (variables de entorno / ssrp_db_config()).
     */
    function mysql_connect($server = null, $username = null, $password = null, $new_link = false, $client_flags = 0)
    {
        $config = ssrp_db_config();
        $host = $config['host'];
        $port = $config['port'];

        $link = @mysqli_connect($host, $config['user'], $config['pass'], $config['name'], $port);
        if (!$link) {
            $GLOBALS['__ssrp_mysql_connect_error'] = mysqli_connect_error();
            $GLOBALS['__ssrp_mysql_connect_errno'] = mysqli_connect_errno();
            error_log('SSRP: no se pudo conectar a MySQL (' . $host . ':' . $port . '): ' . mysqli_connect_error());
            return false;
        }

        mysqli_set_charset($link, $config['charset']);
        if ($config['sql_mode'] !== '') {
            // MySQL 8 activa modos estrictos que rompen las consultas legadas.
            mysqli_query($link, "SET SESSION sql_mode = '" . mysqli_real_escape_string($link, $config['sql_mode']) . "'");
        }

        $GLOBALS['__ssrp_mysql_link'] = $link;
        return $link;
    }

    function mysql_pconnect($server = null, $username = null, $password = null, $client_flags = 0)
    {
        return mysql_connect($server, $username, $password);
    }

    function mysql_select_db($database_name, $link = null)
    {
        $link = __ssrp_mysql_link($link);
        return $link ? mysqli_select_db($link, ssrp_db_name($database_name)) : false;
    }

    function mysql_query($query, $link = null)
    {
        $link = __ssrp_mysql_link($link);
        return $link ? mysqli_query($link, $query) : false;
    }

    function mysql_unbuffered_query($query, $link = null)
    {
        return mysql_query($query, $link);
    }

    function mysql_db_query($database, $query, $link = null)
    {
        mysql_select_db($database, $link);
        return mysql_query($query, $link);
    }

    function mysql_fetch_array($result, $result_type = MYSQL_BOTH)
    {
        if (!($result instanceof mysqli_result)) {
            return false;
        }
        $row = mysqli_fetch_array($result, $result_type);
        return $row === null ? false : $row;
    }

    function mysql_fetch_assoc($result)
    {
        return mysql_fetch_array($result, MYSQL_ASSOC);
    }

    function mysql_fetch_row($result)
    {
        return mysql_fetch_array($result, MYSQL_NUM);
    }

    function mysql_fetch_object($result, $class_name = 'stdClass', $params = array())
    {
        if (!($result instanceof mysqli_result)) {
            return false;
        }
        $obj = $params ? mysqli_fetch_object($result, $class_name, $params) : mysqli_fetch_object($result, $class_name);
        return $obj === null ? false : $obj;
    }

    function mysql_result($result, $row, $field = 0)
    {
        if (!($result instanceof mysqli_result) || !mysqli_data_seek($result, $row)) {
            return false;
        }
        $data = mysqli_fetch_array($result, MYSQLI_BOTH);
        if (!$data) {
            return false;
        }
        if (is_string($field) && strpos($field, '.') !== false) {
            $field = substr($field, strrpos($field, '.') + 1);
        }
        return isset($data[$field]) ? $data[$field] : false;
    }

    function mysql_num_rows($result)
    {
        return $result instanceof mysqli_result ? mysqli_num_rows($result) : false;
    }

    function mysql_num_fields($result)
    {
        return $result instanceof mysqli_result ? mysqli_num_fields($result) : false;
    }

    function mysql_affected_rows($link = null)
    {
        $link = __ssrp_mysql_link($link);
        return $link ? mysqli_affected_rows($link) : -1;
    }

    function mysql_insert_id($link = null)
    {
        $link = __ssrp_mysql_link($link);
        return $link ? mysqli_insert_id($link) : false;
    }

    function mysql_data_seek($result, $row_number)
    {
        return $result instanceof mysqli_result ? mysqli_data_seek($result, $row_number) : false;
    }

    function mysql_free_result($result)
    {
        if ($result instanceof mysqli_result) {
            mysqli_free_result($result);
            return true;
        }
        return false;
    }

    function mysql_close($link = null)
    {
        $target = $link instanceof mysqli ? $link : $GLOBALS['__ssrp_mysql_link'];
        if (!($target instanceof mysqli)) {
            return false;
        }
        if ($target === $GLOBALS['__ssrp_mysql_link']) {
            $GLOBALS['__ssrp_mysql_link'] = null;
        }
        return mysqli_close($target);
    }

    function mysql_error($link = null)
    {
        $target = $link instanceof mysqli ? $link : $GLOBALS['__ssrp_mysql_link'];
        if ($target instanceof mysqli) {
            return mysqli_error($target);
        }
        return $GLOBALS['__ssrp_mysql_connect_error'];
    }

    function mysql_errno($link = null)
    {
        $target = $link instanceof mysqli ? $link : $GLOBALS['__ssrp_mysql_link'];
        if ($target instanceof mysqli) {
            return mysqli_errno($target);
        }
        return $GLOBALS['__ssrp_mysql_connect_errno'];
    }

    function mysql_real_escape_string($string, $link = null)
    {
        $link = __ssrp_mysql_link($link);
        if ($link) {
            return mysqli_real_escape_string($link, (string) $string);
        }
        return addslashes((string) $string);
    }

    function mysql_escape_string($string)
    {
        return mysql_real_escape_string($string);
    }

    function mysql_get_server_info($link = null)
    {
        $link = __ssrp_mysql_link($link);
        return $link ? mysqli_get_server_info($link) : false;
    }

    function mysql_set_charset($charset, $link = null)
    {
        $link = __ssrp_mysql_link($link);
        return $link ? mysqli_set_charset($link, $charset) : false;
    }

    function mysql_list_fields($database_name, $table_name, $link = null)
    {
        $link = __ssrp_mysql_link($link);
        if (!$link) {
            return false;
        }
        $db = mysqli_real_escape_string($link, ssrp_db_name($database_name));
        $table = mysqli_real_escape_string($link, $table_name);
        return mysqli_query($link, "SELECT * FROM `$db`.`$table` LIMIT 0");
    }

    function __ssrp_mysql_field($result, $offset)
    {
        if (!($result instanceof mysqli_result)) {
            return false;
        }
        return mysqli_fetch_field_direct($result, $offset);
    }

    function mysql_field_name($result, $field_offset)
    {
        $f = __ssrp_mysql_field($result, $field_offset);
        return $f ? $f->name : false;
    }

    function mysql_field_table($result, $field_offset)
    {
        $f = __ssrp_mysql_field($result, $field_offset);
        return $f ? $f->table : false;
    }

    function mysql_field_len($result, $field_offset)
    {
        $f = __ssrp_mysql_field($result, $field_offset);
        return $f ? $f->length : false;
    }

    function mysql_field_type($result, $field_offset)
    {
        $f = __ssrp_mysql_field($result, $field_offset);
        if (!$f) {
            return false;
        }
        static $map = array(
            MYSQLI_TYPE_DECIMAL => 'real', MYSQLI_TYPE_NEWDECIMAL => 'real',
            MYSQLI_TYPE_FLOAT => 'real', MYSQLI_TYPE_DOUBLE => 'real',
            MYSQLI_TYPE_TINY => 'int', MYSQLI_TYPE_SHORT => 'int', MYSQLI_TYPE_LONG => 'int',
            MYSQLI_TYPE_LONGLONG => 'int', MYSQLI_TYPE_INT24 => 'int', MYSQLI_TYPE_YEAR => 'year',
            MYSQLI_TYPE_TIMESTAMP => 'timestamp', MYSQLI_TYPE_DATE => 'date', MYSQLI_TYPE_NEWDATE => 'date',
            MYSQLI_TYPE_TIME => 'time', MYSQLI_TYPE_DATETIME => 'datetime',
            MYSQLI_TYPE_TINY_BLOB => 'blob', MYSQLI_TYPE_MEDIUM_BLOB => 'blob',
            MYSQLI_TYPE_LONG_BLOB => 'blob', MYSQLI_TYPE_BLOB => 'blob',
            MYSQLI_TYPE_VAR_STRING => 'string', MYSQLI_TYPE_STRING => 'string',
            MYSQLI_TYPE_ENUM => 'string', MYSQLI_TYPE_SET => 'string',
            MYSQLI_TYPE_NULL => 'null', MYSQLI_TYPE_GEOMETRY => 'geometry',
        );
        return isset($map[$f->type]) ? $map[$f->type] : 'unknown';
    }

    function mysql_field_flags($result, $field_offset)
    {
        $f = __ssrp_mysql_field($result, $field_offset);
        if (!$f) {
            return false;
        }
        $flags = array();
        static $names = array(
            MYSQLI_NOT_NULL_FLAG => 'not_null', MYSQLI_PRI_KEY_FLAG => 'primary_key',
            MYSQLI_UNIQUE_KEY_FLAG => 'unique_key', MYSQLI_MULTIPLE_KEY_FLAG => 'multiple_key',
            MYSQLI_BLOB_FLAG => 'blob', MYSQLI_UNSIGNED_FLAG => 'unsigned',
            MYSQLI_ZEROFILL_FLAG => 'zerofill', MYSQLI_BINARY_FLAG => 'binary',
            MYSQLI_ENUM_FLAG => 'enum', MYSQLI_AUTO_INCREMENT_FLAG => 'auto_increment',
            MYSQLI_TIMESTAMP_FLAG => 'timestamp', MYSQLI_SET_FLAG => 'set',
        );
        foreach ($names as $bit => $name) {
            if ($f->flags & $bit) {
                $flags[] = $name;
            }
        }
        return implode(' ', $flags);
    }
}

/* -------------------------------------------------------------------------
 * Funciones eliminadas del núcleo de PHP
 * ---------------------------------------------------------------------- */

if (!function_exists('get_magic_quotes_gpc')) {
    function get_magic_quotes_gpc()
    {
        return false;
    }
}

if (!function_exists('get_magic_quotes_runtime')) {
    function get_magic_quotes_runtime()
    {
        return false;
    }
}

if (!function_exists('set_magic_quotes_runtime')) {
    function set_magic_quotes_runtime($new_setting)
    {
        return false;
    }
}

if (!function_exists('each')) {
    function each(&$array)
    {
        if (!is_array($array) && !is_object($array)) {
            return false;
        }
        $key = key($array);
        if ($key === null) {
            return false;
        }
        $value = current($array);
        next($array);
        return array(1 => $value, 'value' => $value, 0 => $key, 'key' => $key);
    }
}

if (!function_exists('create_function')) {
    function create_function($args, $code)
    {
        return eval('return function(' . $args . ') {' . $code . '};');
    }
}

/**
 * Convierte una expresión POSIX (ereg) en PCRE.
 */
function __ssrp_posix_to_pcre($pattern, $insensitive = false)
{
    return '/' . str_replace('/', '\/', (string) $pattern) . '/' . ($insensitive ? 'i' : '');
}

if (!function_exists('ereg')) {
    function ereg($pattern, $string, &$regs = null)
    {
        $found = preg_match(__ssrp_posix_to_pcre($pattern), (string) $string, $regs);
        return $found ? max(1, strlen($regs[0])) : false;
    }
}

if (!function_exists('eregi')) {
    function eregi($pattern, $string, &$regs = null)
    {
        $found = preg_match(__ssrp_posix_to_pcre($pattern, true), (string) $string, $regs);
        return $found ? max(1, strlen($regs[0])) : false;
    }
}

if (!function_exists('ereg_replace')) {
    function ereg_replace($pattern, $replacement, $string)
    {
        return preg_replace(__ssrp_posix_to_pcre($pattern), $replacement, (string) $string);
    }
}

if (!function_exists('eregi_replace')) {
    function eregi_replace($pattern, $replacement, $string)
    {
        return preg_replace(__ssrp_posix_to_pcre($pattern, true), $replacement, (string) $string);
    }
}

if (!function_exists('split')) {
    function split($pattern, $string, $limit = -1)
    {
        return preg_split(__ssrp_posix_to_pcre($pattern), (string) $string, $limit);
    }
}

if (!function_exists('spliti')) {
    function spliti($pattern, $string, $limit = -1)
    {
        return preg_split(__ssrp_posix_to_pcre($pattern, true), (string) $string, $limit);
    }
}
