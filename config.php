<?php
unset($CFG);
global $CFG;
$CFG = new stdClass();

// Railway provee múltiples variables de MySQL
$mysqlUrl = getenv('MYSQL_URL');
$mysqlHost = getenv('MYSQLHOST');
$mysqlDatabase = getenv('MYSQLDATABASE');
$mysqlUser = getenv('MYSQLUSER');
$mysqlPassword = getenv('MYSQLPASSWORD');
$mysqlPort = getenv('MYSQLPORT');

// Si existe MYSQL_URL, parsearla
if ($mysqlUrl) {
    $parts = parse_url($mysqlUrl);
    $CFG->dbhost = $parts['host'] ?? $mysqlHost ?? 'localhost';
    $CFG->dbname = ltrim($parts['path'] ?? '/', '/') ?: $mysqlDatabase ?: 'railway';
    $CFG->dbuser = $parts['user'] ?? $mysqlUser ?? 'root';
    $CFG->dbpass = $parts['pass'] ?? $mysqlPassword ?? '';
    $port = $parts['port'] ?? $mysqlPort ?? 3306;
} else {
    // Usar variables individuales
    $CFG->dbhost = $mysqlHost ?: 'localhost';
    $CFG->dbname = $mysqlDatabase ?: 'railway';
    $CFG->dbuser = $mysqlUser ?: 'root';
    $CFG->dbpass = $mysqlPassword ?: '';
    $port = $mysqlPort ?: 3306;
}

$CFG->dbtype    = 'mariadb';
$CFG->dblibrary = 'native';
$CFG->prefix    = 'mdl_';
$CFG->dboptions = array(
    'dbpersist' => 0,
    'dbport' => (int)$port,
    'dbsocket' => '',
    'dbcollation' => 'utf8mb4_unicode_ci',
);

$domain = getenv('RAILWAY_PUBLIC_DOMAIN');
$CFG->wwwroot = $domain ? 'https://' . $domain : 'http://localhost';
$CFG->dataroot = '/app/moodledata';
$CFG->admin = 'admin';
$CFG->directorypermissions = 0777;

require_once(__DIR__ . '/lib/setup.php');