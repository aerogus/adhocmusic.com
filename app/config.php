<?php

/**
 * AD'HOC
 * Configuration générale
 */

setlocale(LC_ALL, 'fr_FR.UTF8');
ini_set('date.timezone', 'Europe/Paris');
ini_set("default_charset", "UTF-8");

define('ENV', adhoc_get_env());

/**
 * Retourne le type d'environnement
 * Se base sur le host du serveur
 *
 * @return string
 */
function adhoc_get_env() : string
{
    $host = php_uname('n');
    switch ($host)
    {
        case 'rbx.aerogus.net':
            return 'PROD';
            break;

        default:
            return 'DEV';
            break;
    }
}

/**
 * @return bool
 */
function is_ssl() : bool
{
    return (bool) (
        !empty($_SERVER['HTTPS'])
     || !empty($_SERVER['REDIRECT_HTTPS'])
     || (!empty($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] === 'https')
    );
}

if (ENV === 'PROD') {

    define('_DB_HOST_',     'localhost');
    define('_DB_USER_',     'adhocmusic');
    define('_DB_PASSWORD_', 'kK2972Wd');
    define('_DB_DATABASE_', 'adhocmusic');

    if (is_ssl()) {
        define('HOME_URL',  'https://www.adhocmusic.com');
        define('CACHE_URL', 'https://static.adhocmusic.com/cache');
        define('MEDIA_URL', 'https://static.adhocmusic.com/media');
    } else {
        define('HOME_URL',  'http://www.adhocmusic.com');
        define('CACHE_URL', 'http://static.adhocmusic.com/cache');
        define('MEDIA_URL', 'http://static.adhocmusic.com/media');
    }

    ini_set('display_startup_errors', 0);
    ini_set('display_errors', 1);
    define('ONERROR_SHOW', true);

} elseif (ENV === 'DEV') {

    define('_DB_HOST_',     'mysql.adhocmusic.test');
    define('_DB_USER_',     'adhocmusic');
    define('_DB_PASSWORD_', 'changeme');
    define('_DB_DATABASE_', 'adhocmusic');

    if (is_ssl()) {
        define('HOME_URL',  'https://www.adhocmusic.test');
        define('CACHE_URL', 'https://static.adhocmusic.test/cache');
        define('MEDIA_URL', 'https://static.adhocmusic.test/media');
    } else {
        define('HOME_URL',  'http://www.adhocmusic.test');
        define('CACHE_URL', 'http://static.adhocmusic.test/cache');
        define('MEDIA_URL', 'http://static.adhocmusic.test/media');
    }

    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    define('ONERROR_SHOW', true);

}

define('DEBUG_EMAIL', 'guillaume@seznec.fr');

define('ADHOC_ROOT_PATH',           dirname(__DIR__));
define('ADHOC_LIB_PATH',            ADHOC_ROOT_PATH . '/models');
define('ADHOC_ROUTES_FILE',         ADHOC_ROOT_PATH . '/app/routes');
define('ADHOC_SITE_PATH',           ADHOC_ROOT_PATH . '/app/models');
define('ADHOC_LOG_PATH',            ADHOC_ROOT_PATH . '/log');
define('DEFAULT_CONTROLLERS_PATH',  ADHOC_ROOT_PATH . '/app/controllers/');
define('MEDIA_PATH',                ADHOC_ROOT_PATH . '/media');

// chemin local
define('IMG_CACHE_PATH', ADHOC_ROOT_PATH . '/static/cache');

// chemin http
define('IMG_CACHE_URL', CACHE_URL);

define('DB_ADHOC_DEFAULT',          1);

define('TRAIL_ENABLED', true);
define('ADHOC_COUNTERS', true);

define('SMARTY_TEMPLATE_PATH',   ADHOC_ROOT_PATH . '/app/views');
define('SMARTY_TEMPLATE_C_PATH', ADHOC_ROOT_PATH . '/smarty');

define('GOOGLE_MAPS_API_KEY', 'AIzaSyBVsz6lTrtPcGaGy8-pNNLdmhDIg7Cng24');

define('FB_APP_ID', '50959607741');
define('FB_PAGE_ID', '161908907197840');
define('FB_APP_SECRET', 'c2ea0c274c21507404f21688f71f98c1');
define('FB_APP_ROOT_URL', 'https://apps.facebook.com/adhocmusic');
define('FB_APP_PAGE_URL', 'https://www.facebook.com/adhocmusic');
define('FB_APP_DEFAUT_AVATAR_GROUPE', HOME_URL . '/img/note_adhoc_64.png');

error_reporting(-1); // taquet
ini_set('log_errors',             1);
ini_set('error_log',              ADHOC_LOG_PATH . '/www.adhocmusic.com.err');
ini_set('arg_separator.output',  '&amp;');
ini_set('session.use_trans_sid', '0');

/**
 * mini fonction de debug
 *
 * @var mixed
 */
function p(mixed $var)
{
    echo '<pre>' . print_r($var, true) . '</pre>';
}

/**
 * mini fonction de debug
 * @var mixed
 * @return string
 */
function d(mixed $var)
{
    die('<pre>' . print_r($var, true) . '</pre>');
}

/**
 * Chargement automatique des paquets gérés par composer
 */
require_once ADHOC_ROOT_PATH . '/vendor/autoload.php';

/**
 * Chargement automatique des classes métiers AD'HOC
 * @param string Nom de la classe
 */
function autoload(string $class_name)
{
    if (file_exists(ADHOC_SITE_PATH . '/' . $class_name . '.class.php')) {
        include_once ADHOC_SITE_PATH . '/' . $class_name . '.class.php';
    }
}
spl_autoload_register('autoload');

Tools::sessionInit();

// initialisation App AD'HOC Facebook avec autorisation 'email'

$GLOBALS['fb'] = new Facebook\Facebook([
    'app_id' => FB_APP_ID,
    'app_secret' => FB_APP_SECRET,
    'default_graph_version' => 'v2.12',
]);

$GLOBALS['fb_login_url'] = $fb->getRedirectLoginHelper()->getLoginUrl(HOME_URL . '/auth/facebook-login-callback', ['email']);

