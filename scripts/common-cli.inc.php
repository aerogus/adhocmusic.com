<?php

/**
 * header commun des scripts en php-cli
 */

setlocale(LC_ALL, 'fr_FR.UTF8');
ini_set('date.timezone', 'Europe/Paris');
ini_set("default_charset", "UTF-8");

error_reporting(-1); // taquet

define('_DB_HOST_',             'localhost');
define('_DB_USER_',             'adhocmusic');
define('_DB_PASSWORD_',         'kK2972Wd');
define('_DB_DATABASE_',         'adhocmusic');

define('SERVER_ROOT_PATH',          '/home/www');
define('ADHOC_ROOT_PATH',           SERVER_ROOT_PATH . '/adhocmusic.com');
define('COMMON_LIB_PATH',           ADHOC_ROOT_PATH . '/lib');
define('COMMON_LIB_PHP_PATH',       COMMON_LIB_PATH . '/php');
define('COMMON_LIB_PHPMAILER_PATH', COMMON_LIB_PATH . '/phpmailer');
define('COMMON_LIB_SMARTY_PATH',    COMMON_LIB_PATH . '/smarty');
define('COMMON_LIB_FACEBOOK_PATH',  COMMON_LIB_PATH . '/facebook');
define('ADHOC_LIB_PATH',            ADHOC_ROOT_PATH . '/models');
define('ADHOC_LOG_PATH',            ADHOC_ROOT_PATH . '/log');
define('DB_ADHOC_DEFAULT',          1);

define('SMARTY_TEMPLATE_PATH',   ADHOC_ROOT_PATH . '/www/views');
define('SMARTY_TEMPLATE_C_PATH', ADHOC_ROOT_PATH . '/cache/smarty');

define('STATIC_URL', 'http://static.adhocmusic.com');
define('CACHE_URL',  'http://static.adhocmusic.com');

// App AD'HOC Music
define('FB_APP_ID', '50959607741');
define('FB_API_KEY', '9bff9746d384c2b4dd0c4fa130bcaecd');
define('FB_SECRET_KEY', 'c2ea0c274c21507404f21688f71f98c1');

require_once COMMON_LIB_SMARTY_PATH . '/Smarty.class.php';

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
