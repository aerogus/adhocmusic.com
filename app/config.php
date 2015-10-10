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
 */
function adhoc_get_env()
{
    $host = php_uname('n');
    switch($host)
    {
        case 'ns1.adhocmusic.com':
        case 'ns2.adhocmusic.com':
            return 'PROD';
            break;

        case 'Mac-mini-Salon.local':
        case 'Mac-mini-Bureau.local':
            return 'DEV';
            break;

        default:
            die('Unknown environnement');
            break;
    }
}

if(ENV === 'PROD') {

    define('_DB_HOST_',        'localhost');
    define('_DB_USER_',        'adhocmusic');
    define('_DB_PASSWORD_',    'kK2972Wd');
    define('_DB_DATABASE_',    'adhocmusic');

    define('DYN_URL',          'http://www.adhocmusic.com');
    define('STATIC_URL',       'http://www.adhocmusic.com');
    define('CACHE_URL',        'http://www.adhocmusic.com');

    ini_set('display_startup_errors', 0);
    ini_set('display_errors', 0);
    define('ONERROR_SHOW', true);

} elseif(ENV === 'DEV') {

    define('_DB_HOST_',        '127.0.0.1');
    define('_DB_USER_',        'root');
    define('_DB_PASSWORD_',    'changeme');
    define('_DB_DATABASE_',    'adhoc');

    define('DYN_URL',          'http://www.adhocmusic.localhost');
    define('STATIC_URL',       'http://www.adhocmusic.localhost');
    define('CACHE_URL',        'http://www.adhocmusic.localhost');

    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    define('ONERROR_SHOW', true);
}

define('ADHOC_ROOT_PATH',           dirname(dirname(__FILE__)));
define('ADHOC_LIB_PATH',            ADHOC_ROOT_PATH . '/models');
define('ADHOC_ROUTES_FILE',         ADHOC_ROOT_PATH . '/app/routes');
define('ADHOC_SITE_PATH',           ADHOC_ROOT_PATH . '/app/models');
define('ADHOC_LOG_PATH',            ADHOC_ROOT_PATH . '/log');
define('DEFAULT_CONTROLLERS_PATH',  ADHOC_ROOT_PATH . '/app/controllers/');

define('DB_ADHOC_DEFAULT',          1);

define('TRAIL_ENABLED', true);
define('ADHOC_COUNTERS', true);

define('SMARTY_TEMPLATE_PATH',   ADHOC_ROOT_PATH . '/app/views');
define('SMARTY_TEMPLATE_C_PATH', ADHOC_ROOT_PATH . '/cache/smarty');

define('FB_FAN_PAGE_ID',        '161908907197840');
define('FB_ADHOCMUSIC_PAGE_ID', '161908907197840');
define('FB_ADHOCMUSIC_APP_ID',      '50959607741');

// App AD'HOC Music
define('FB_APP_ID', '50959607741');
define('FB_API_KEY', '9bff9746d384c2b4dd0c4fa130bcaecd');
define('FB_SECRET_KEY', 'c2ea0c274c21507404f21688f71f98c1');
define('FB_APP_ROOT_URL', 'https://apps.facebook.com/adhocmusic');
define('FB_APP_PAGE_URL', 'https://www.facebook.com/adhocmusic');
define('FB_APP_DEFAUT_AVATAR_GROUPE', STATIC_URL . '/img/note_adhoc_64.png');

error_reporting(-1); // taquet
ini_set('log_errors',             1);
ini_set('error_log',              ADHOC_LOG_PATH . '/www.adhocmusic.com.err');
ini_set('arg_separator.output',  '&amp;');
ini_set('session.use_trans_sid', '0');

/**
 * mini fonction de debug
 * @var mixed
 * @return string
 */
function p($var) {
    echo '<pre>' . print_r($var, true) . '</pre>';
}

/**
 * mini fonction de debug
 * @var mixed
 * @return string
 */
function d($var) {
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
function autoload($class_name)
{
    if(file_exists(ADHOC_SITE_PATH . '/' . $class_name . '.class.php')) {
        include_once ADHOC_SITE_PATH . '/' . $class_name . '.class.php';
    }
}
spl_autoload_register('autoload');

Tools::sessionInit();
