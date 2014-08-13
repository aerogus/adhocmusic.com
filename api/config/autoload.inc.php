<?php

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
