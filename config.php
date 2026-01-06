<?php
unset($CFG);
global $CFG;
$CFG = new stdClass();

$mysqlUrl = getenv('DATABASE_URL') ?: getenv('MYSQL_URL');

if ($mysqlUrl) {
    $parts = parse_url($mysqlUrl);
    $CFG->dbhost = $parts['host'] ?? 'localhost';
    $CFG->dbname = ltrim($parts['path'] ?? '/railway', '/');
    $CFG->dbuser = $parts['user'] ?? 'root';
    $CFG->dbpass = $parts['pass'] ?? '';
    $port = $parts['port'] ?? 3306;
} else {
    die('ERROR: No DATABASE_URL found');
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