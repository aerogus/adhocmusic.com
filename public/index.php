<?php declare(strict_types=1);

/**
 * Point d'entrée
 *
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */

use Adhoc\Model\CMS;
use Adhoc\Model\Groupe;
use Adhoc\Model\Route;

if (file_exists(__DIR__ . '/../../app/bootstrap.php')) {
    include __DIR__ . '/../../app/bootstrap.php'; // ./tmpfs/www -> ./app : "../.."
} elseif (file_exists(__DIR__ . '/../app/bootstrap.php')) {
    include __DIR__ . '/../app/bootstrap.php'; // ./public    -> ./app : "../"
} else {
    die('bootstrap inrouvable');
}

// PATH_INFO est l'info sur laquelle on se base pour calculer les routes
if (!array_key_exists('PATH_INFO', $_SERVER)) {
    $_SERVER['PATH_INFO'] = $_SERVER['REQUEST_URI'];
}

$_SERVER['PATH_INFO'] = explode('?fbclid', $_SERVER['PATH_INFO'])[0];

// friendly urls pour les groupes et les articles du CMS
if (preg_match('@^[a-zA-Z0-9-_]{1,50}$@', substr((string) $_SERVER['PATH_INFO'], 1), $matches)) {
    if ($id_groupe = Groupe::getIdByAlias((string) $matches[0])) {
        $_SERVER['PATH_INFO'] = '/groupes/' . (string) $id_groupe;
    } elseif ($id_cms = CMS::getIdByAlias('/' . (string) $matches[0])) {
        $_SERVER['PATH_INFO'] = '/cms/' . (string) $id_cms;
    }
}

// chargement des routes
Route::load(ADHOC_ROUTES_FILE);

// fouzy
Route::run();
