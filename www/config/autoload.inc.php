<?php

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
    } elseif(file_exists(ADHOC_LIB_PATH . '/' . $class_name . '.class.php')) {
        include_once ADHOC_LIB_PATH . '/' . $class_name . '.class.php';
    }
}
spl_autoload_register('autoload');

