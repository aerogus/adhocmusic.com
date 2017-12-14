<?php

require_once dirname(__FILE__) . '/../app/config.php';

/* PATH_INFO est l'info sur laquelle on se base */
if (!array_key_exists('PATH_INFO', $_SERVER)) {
    $_SERVER['PATH_INFO'] = $_SERVER['REQUEST_URI'];
}

if (preg_match('@^[a-zA-Z0-9-_]{1,50}$@', substr((string) $_SERVER['PATH_INFO'], 1), $matches)) {
    if ($id_groupe = Groupe::getIdByAlias((string) $matches[0])) {
        $_SERVER['PATH_INFO'] = '/groupes/' . (int) $id_groupe;
    } elseif ($id_cms = CMS::getIdByAlias('/' . (string) $matches[0])) {
        $_SERVER['PATH_INFO'] = '/cms/' . (int) $id_cms;
    }
}

Route::load(ADHOC_ROUTES_FILE);
Route::run();
