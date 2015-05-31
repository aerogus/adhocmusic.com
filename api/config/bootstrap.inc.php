<?php

setlocale(LC_ALL, 'fr_FR.UTF8');
ini_set('date.timezone', 'Europe/Paris');
ini_set("default_charset", "UTF-8");

error_reporting(E_ALL | E_STRICT);

define('SERVER_ROOT_PATH',          '/home/www');
define('ADHOC_ROOT_PATH',           SERVER_ROOT_PATH . '/adhocmusic.com');
define('COMMON_LIB_PATH',           SERVER_ROOT_PATH . '/lib');
define('ADHOC_LIB_PATH',            ADHOC_ROOT_PATH . '/models');
define('ADHOC_LOG_PATH',            ADHOC_ROOT_PATH . '/log');
define('COMMON_LIB_PHP_PATH',       COMMON_LIB_PATH . '/php');
define('COMMON_LIB_SMARTY_PATH',    COMMON_LIB_PATH . '/smarty');
define('COMMON_LIB_PHPMAILER_PATH', COMMON_LIB_PATH . '/phpmailer');
define('DEFAULT_CONTROLLERS_PATH',  ADHOC_ROOT_PATH . '/api/controllers/');
define('STATIC_URL',               'http://static.adhocmusic.com');
define('CACHE_URL',                'http://static.adhocmusic.com');
define('DYN_URL',                  'http://api.adhocmusic.com');

define('_DB_HOST_',                'localhost');
define('_DB_USER_',                'adhocmusic');
define('_DB_PASSWORD_',            'kK2972Wd');
define('_DB_DATABASE_',            'adhocmusic');

define('SMARTY_TEMPLATE_PATH',      ADHOC_ROOT_PATH . '/api/views');
define('SMARTY_TEMPLATE_C_PATH',    ADHOC_ROOT_PATH . '/cache/smarty');

require_once 'autoload.inc.php';
require_once 'errors.inc.php';
