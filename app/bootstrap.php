<?php declare(strict_types=1);

/**
 * Configuration générale
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */

setlocale(LC_ALL, 'fr_FR.UTF8');
ini_set('date.timezone', 'Europe/Paris');
ini_set('default_charset', 'UTF-8');

define('ENV', (php_uname('n') === 'rbx.aerogus.net') ? 'PROD' : 'DEV');

/**
 * Chargement automatique des classes métiers AD'HOC
 *
 * @param string $className Nom de la classe
 *
 * @return void
 */
function autoload(string $className)
{
    $className = str_replace('\\', '/', $className);
    $classPath = __DIR__ . '/models/' . $className . '.class.php';
    if (file_exists($classPath)) {
        include $classPath;
    }
}
spl_autoload_register('autoload');

if (ENV === 'PROD') {

    define('_DB_HOST_',     'localhost');
    define('_DB_USER_',     'adhocmusic');
    define('_DB_PASSWORD_', 'kK2972Wd');
    define('_DB_DATABASE_', 'adhocmusic');

    define('HOME_URL',  'https://www.adhocmusic.com');
    define('CACHE_URL', 'https://static.adhocmusic.com/cache');
    define('MEDIA_URL', 'https://static.adhocmusic.com/media');

    ini_set('display_startup_errors', '0');
    ini_set('display_errors', '0');
    define('ONERROR_SHOW', false);
    define('DEBUG_MODE', false);

} elseif (ENV === 'DEV') {

    define('_DB_HOST_',     'mariadb.adhocmusic.test');
    define('_DB_USER_',     'adhocmusic');
    define('_DB_PASSWORD_', 'changeme');
    define('_DB_DATABASE_', 'adhocmusic');

    define('HOME_URL',  'https://www.adhocmusic.test');
    define('CACHE_URL', 'https://static.adhocmusic.test/cache');
    define('MEDIA_URL', 'https://static.adhocmusic.test/media');

    ini_set('display_startup_errors', '1');
    ini_set('display_errors', '1');
    define('ONERROR_SHOW', true);
    define('DEBUG_MODE', true);

}

define('DEBUG_EMAIL', 'guillaume@seznec.fr');

define('ADHOC_ROOT_PATH',          dirname(__DIR__));
define('ADHOC_LIB_PATH',           ADHOC_ROOT_PATH . '/models');
define('ADHOC_ROUTES_FILE',        ADHOC_ROOT_PATH . '/app/routes');
define('ADHOC_LOG_PATH',           ADHOC_ROOT_PATH . '/log');
define('DEFAULT_CONTROLLERS_PATH', ADHOC_ROOT_PATH . '/app/controllers/');
define('MEDIA_PATH',               ADHOC_ROOT_PATH . '/static/media');

define('OBJECT_CACHE_PATH',        ADHOC_ROOT_PATH . '/tmpfs/objects');
if (!is_dir(OBJECT_CACHE_PATH)) {
    mkdir(OBJECT_CACHE_PATH, 0755, true);
}

// chemin local
define('IMG_CACHE_PATH', ADHOC_ROOT_PATH . '/static/cache');

// chemin http
define('IMG_CACHE_URL', CACHE_URL);

define('SMARTY_TEMPLATE_PATH',   ADHOC_ROOT_PATH . '/app/views');
define('SMARTY_TEMPLATE_C_PATH', ADHOC_ROOT_PATH . '/tmpfs/smarty');
if (!is_dir(SMARTY_TEMPLATE_C_PATH)) {
    mkdir(SMARTY_TEMPLATE_C_PATH, 0755, true);
}

define('GOOGLE_MAPS_API_KEY', 'AIzaSyBVsz6lTrtPcGaGy8-pNNLdmhDIg7Cng24');

define('FB_PAGE_ID', '161908907197840');
define('FB_APP_PAGE_URL', 'https://www.facebook.com/adhocmusic');
define('FB_APP_DEFAUT_AVATAR_GROUPE', HOME_URL . '/img/note_adhoc_64.png');

error_reporting(-1); // taquet
ini_set('log_errors',             '1');
ini_set('error_log',              ADHOC_LOG_PATH . '/www.adhocmusic.com.err');
ini_set('arg_separator.output',  '&amp;');
ini_set('session.use_trans_sid', '0');

/**
 * Chargement automatique des paquets gérés par composer
 */
require_once ADHOC_ROOT_PATH . '/vendor/autoload.php'; // prend bien 60ms

Tools::sessionInit();
