<?php

/**
 * header commun des scripts en php-cli
 */

setlocale(LC_ALL, 'fr_FR.UTF8');
ini_set('date.timezone', 'Europe/Paris');
ini_set("default_charset", "UTF-8");

error_reporting(-1); // taquet

define('_DB_HOST_',      'localhost');
define('_DB_USER_',      'adhocmusic');
define('_DB_PASSWORD_',  'kK2972Wd');
define('_DB_DATABASE_',  'adhocmusic');

define('ADHOC_ROOT_PATH',   dirname(dirname(dirname(__FILE__))));
define('ADHOC_LIB_PATH',    ADHOC_ROOT_PATH . '/app/models');
define('ADHOC_LOG_PATH',    ADHOC_ROOT_PATH . '/log');
define('DB_ADHOC_DEFAULT',  1);

define('SMARTY_TEMPLATE_PATH',   ADHOC_ROOT_PATH . '/app/views');
define('SMARTY_TEMPLATE_C_PATH', ADHOC_ROOT_PATH . '/cache/smarty');

define('STATIC_URL', 'https://www.adhocmusic.com');
define('CACHE_URL',  'https://www.adhocmusic.com');

// App AD'HOC Music
define('FB_APP_ID', '50959607741');
define('FB_API_KEY', '9bff9746d384c2b4dd0c4fa130bcaecd');
define('FB_SECRET_KEY', 'c2ea0c274c21507404f21688f71f98c1');

/**
 * Chargement automatique des paquets gérés par composer
 */
require_once ADHOC_ROOT_PATH . '/vendor/autoload.php';

/**
 * chargement automatique des classes métiers AD'HOC
 * @param string Nom de la classe
 */
function autoload($class_name)
{
    if(file_exists(ADHOC_LIB_PATH . '/' . $class_name . '.class.php')) {
        include_once ADHOC_LIB_PATH . '/' . $class_name . '.class.php';
    }
}
spl_autoload_register('autoload');

ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log',  ADHOC_LOG_PATH . '/www.adhocmusic.com.err');

/**
 * mini fonction de debug
 * @var mixed
 * @return string
 */
function p($var)
{
    echo '<pre>' . print_r($var, true) . '</pre>';
}

/**
 * mini fonction de debug
 * @var mixed
 * @return string
 */
function d($var)
{
    die('<pre>' . print_r($var, true) . '</pre>');
}
