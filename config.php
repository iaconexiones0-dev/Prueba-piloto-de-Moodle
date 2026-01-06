<?php  // Moodle configuration file

unset($CFG);
global $CFG;
$CFG = new stdClass();

// Configuración de Base de Datos PostgreSQL desde Railway
$databaseUrl = getenv('DATABASE_URL') ?: 'postgresql://localhost:5432/moodle';
$parsedUrl = parse_url($databaseUrl);

$CFG->dbtype    = 'pgsql';
$CFG->dblibrary = 'native';
$CFG->dbhost    = $parsedUrl['host'] ?? 'localhost';
$CFG->dbname    = ltrim($parsedUrl['path'] ?? '/moodle', '/');
$CFG->dbuser    = $parsedUrl['user'] ?? 'postgres';
$CFG->dbpass    = $parsedUrl['pass'] ?? '';
$CFG->prefix    = 'mdl_';
$CFG->dboptions = array (
  'dbpersist' => 0,
  'dbport' => $parsedUrl['port'] ?? 5432,
  'dbsocket' => '',
);

// WWW Root - Railway proporciona RAILWAY_PUBLIC_DOMAIN
$domain = getenv('RAILWAY_PUBLIC_DOMAIN');
if ($domain) {
    $CFG->wwwroot = 'https://' . $domain;
} else {
    // Fallback para desarrollo local
    $CFG->wwwroot = 'http://localhost:8080';
}

// Directorio de datos - en Railway debe estar dentro del proyecto
$CFG->dataroot  = __DIR__ . '/moodledata';
$CFG->admin     = 'admin';

$CFG->directorypermissions = 0777;

// Configuraciones adicionales recomendadas para Railway
$CFG->session_handler_class = '\core\session\database';
$CFG->session_database_acquire_lock_timeout = 120;

require_once(__DIR__ . '/lib/setup.php');

// There is no php closing tag in this file,
// it is intentional because it prevents trailing whitespace problems!