<?php
unset($CFG);
global $CFG;
$CFG = new stdClass();

// Parse MySQL URL from Railway
$mysqlUrl = getenv('MYSQL_URL') ?: getenv('DATABASE_URL') ?: 'mysql://root@localhost/moodle';
$parts = parse_url($mysqlUrl);

$CFG->dbtype    = 'mariadb';
$CFG->dblibrary = 'native';
$CFG->dbhost    = ($parts['host'] ?? 'localhost') . ':' . ($parts['port'] ?? 3306);
$CFG->dbname    = ltrim($parts['path'] ?? '/moodle', '/');
$CFG->dbuser    = $parts['user'] ?? 'root';
$CFG->dbpass    = $parts['pass'] ?? '';
$CFG->prefix    = 'mdl_';
$CFG->dboptions = array(
    'dbpersist' => 0,
    'dbport' => $parts['port'] ?? 3306,
    'dbsocket' => '',
    'dbcollation' => 'utf8mb4_unicode_ci',
);

$domain = getenv('RAILWAY_PUBLIC_DOMAIN');
$CFG->wwwroot = $domain ? 'https://' . $domain : 'http://localhost:8080';
$CFG->dataroot = '/app/moodledata';
$CFG->admin = 'admin';
$CFG->directorypermissions = 0777;

require_once(__DIR__ . '/lib/setup.php');