<?php

/**
 * Configuration générale
 *
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */

declare(strict_types=1);

use Adhoc\Utils\Conf;
use Adhoc\Utils\Tools;

define('ADHOC_ROOT_PATH', dirname(__DIR__));
define('ADHOC_LIB_PATH', ADHOC_ROOT_PATH . '/models');
define('ADHOC_ROUTES_FILE', ADHOC_ROOT_PATH . '/app/routes');
define('ADHOC_LOG_PATH', ADHOC_ROOT_PATH . '/log');
define('DEFAULT_CONTROLLERS_PATH', ADHOC_ROOT_PATH . '/app/src/Adhoc/Controller/');
define('MEDIA_PATH', ADHOC_ROOT_PATH . '/static/media');

define('OBJECT_CACHE_PATH', ADHOC_ROOT_PATH . '/tmpfs/objects');
if (!is_dir(OBJECT_CACHE_PATH)) {
    mkdir(OBJECT_CACHE_PATH, 0755, true);
}

define('SMARTY_TEMPLATE_PATH', ADHOC_ROOT_PATH . '/app/views');
define('SMARTY_TEMPLATE_C_PATH', ADHOC_ROOT_PATH . '/tmpfs/smarty');
if (!is_dir(SMARTY_TEMPLATE_C_PATH)) {
    mkdir(SMARTY_TEMPLATE_C_PATH, 0755, true);
}

/**
 * Chargement automatique des classes métiers AD'HOC
 *
 * @param string $className Nom de la classe
 *
 * @return void
 */
function autoload(string $className): void
{
    $className = str_replace('\\', '/', $className);
    $classPath = __DIR__ . '/src/' . $className . '.php';
    if (file_exists($classPath)) {
        include $classPath;
    }
}
spl_autoload_register('autoload');

/**
 * Chargement automatique des paquets gérés par composer
 */
if (file_exists(ADHOC_ROOT_PATH . '/vendor/autoload.php')) {
    require_once ADHOC_ROOT_PATH . '/vendor/autoload.php'; // prend bien 60ms
} else {
    die('dépendances composer non installées, faire "composer install"');
}

$conf = Conf::getInstance()->get();

// global
define('ENV', $conf['global']['env']);
setlocale(LC_ALL, $conf['global']['locale']);
ini_set('date.timezone', $conf['global']['timezone']);
ini_set('default_charset', $conf['global']['charset']);

// database
$_ENV['DB_HOST'] = $conf['database']['host'];
$_ENV['DB_PORT'] = 3306;
$_ENV['DB_USER'] = $conf['database']['user'];
$_ENV['DB_PASS'] = $conf['database']['pass'];
$_ENV['DB_NAME'] = $conf['database']['name'];

// urls
define('HOME_URL', $conf['url']['home']);
define('CACHE_URL', $conf['url']['cache']);
define('MEDIA_URL', $conf['url']['media']);

error_reporting(-1); // taquet

if ($conf['debug']['show_errors']) {
    ini_set('display_startup_errors', '1');
    ini_set('display_errors', '1');
} else {
    ini_set('display_startup_errors', '0');
    ini_set('display_errors', '0');
}

if ($conf['debug']['log_errors']) {
    ini_set('log_errors', '1');
    ini_set('error_log', ADHOC_LOG_PATH . '/' . $conf['debug']['log_file']);
} else {
    ini_set('log_errors', '0');
}
define('LOG_SQL', $conf['debug']['log_sql']);
define('DEBUG_EMAIL', $conf['debug']['email']);

define('CONTACT_FORM_TO', $conf['contact_form']['to']);

// chemin local des images en cache
define('IMG_CACHE_PATH', ADHOC_ROOT_PATH . '/static/cache');

// chemin http des images en cache
define('IMG_CACHE_URL', CACHE_URL);

define('FB_PAGE_ID', $conf['facebook']['page_id']);
define('FB_APP_PAGE_URL', $conf['facebook']['page_url']);

ini_set('arg_separator.output', '&amp;');
ini_set('session.use_trans_sid', '0');

Tools::sessionInit();
