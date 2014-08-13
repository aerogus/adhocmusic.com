<?php

define('ONERROR_MAIL',           true);
define('ONERROR_MAIL_SENDER',    'www-data@api.adhocmusic.com');
define('ONERROR_MAIL_RECIPIENT', 'debug@adhocmusic.com');
define('ONERROR_MAIL_SUBJECT',   'Bogue dans ' . $_SERVER['HTTP_HOST']);

$debug_ips = array();
$debug_ips[] = '82.229.140.10'; // gus home

if(in_array($_SERVER['REMOTE_ADDR'], $debug_ips)) {
    define('DEBUG_MODE_BY_IP', true);
} else {
    define('DEBUG_MODE_BY_IP', false);
}

if(DEBUG_MODE_BY_IP === true) {
    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
//    set_error_handler('ErrorHandler');
//    set_exception_handler('ExceptionHandler');
    define('ONERROR_SHOW', true);
} else {
    ini_set('display_startup_errors', 0);
    ini_set('display_errors', 0);
    set_error_handler('ErrorHandler');
    set_exception_handler('ExceptionHandler');
    define('ONERROR_SHOW', false);
}
ini_set('log_errors',              1);
ini_set('error_log',               ADHOC_LOG_PATH . '/api.adhocmusic.com.err');
ini_set('arg_separator.output',   '&amp;');
ini_set('session.use_trans_sid',  '0');

/**
 * Remplace le gestionnaire d'erreur natif PHP5.
 * Il permet de lever une exception capturable dans un bloc catch
 * pour les fonctions/méthodes ne levant pas d'exception.
 *
 * @param int $level Niveau de l'erreur PHP
 * @param string $string Description de l'erreur
 * @param string $file Chemin d'accès au fichier dans lequel l'erreur s'est produite
 * @param int $line Ligne de $file où l'erreur s'est produite
 * @param array $context Contexte d'exécution
 */
function ErrorHandler($error_level, $string, $file, $line, $context)
{
    # Only handle the errors specified by the error_reporting directive or function
    # Ensure that we should be displaying and/or logging errors
    if ( ! ($error_level & error_reporting ()) || ! (ini_get ('display_errors') || ini_get ('log_errors')))
        return;

    require_once ADHOC_LIB_PATH . '/AdHocException.class.php';
    require_once ADHOC_LIB_PATH . '/AdHocPhpException.class.php';
    throw new AdHocPhpException($error_level, $string, $file, $line, $context);
}

/**
 * Gestionnaire d'exception custom
 * @param object $e
 */
function ExceptionHandler($e)
{
    $server_dump = print_r($_SERVER, true);
    $session_dump = '';
    if(isset($_SESSION)) {
        $session_dump = print_r($_SESSION, true);
    }
    $message = print_r($e, true) . "\n\n" . $server_dump . "\n\n" . $session_dump;
    if (ONERROR_MAIL) {
        mail(ONERROR_MAIL_RECIPIENT, ONERROR_MAIL_SUBJECT . ' [' . $e->getMessage() . ']', $message, 'From: <' . ONERROR_MAIL_SENDER . '>');
    }
    if (ONERROR_SHOW) {
        echo "<h3>" . $e->getMessage() . "</h3>\n\n";
        echo "<pre>" . print_r($e, true) . "</pre>";
        die();
    }
}
