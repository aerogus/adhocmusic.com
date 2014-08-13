<?php

require_once '../config/bootstrap.inc.php';

/* PATH_INFO est l'info sur laquelle on se base */

if(!array_key_exists('PATH_INFO', $_SERVER)) {
    $_SERVER['PATH_INFO'] = $_SERVER['REQUEST_URI'];
}

Route::map_connect(array('controller' => 'api',
                         'path'       => '/get-lieux',
                         'method'     => 'GET',
                         'action'     => 'get_lieux'));

Route::map_connect(array('controller' => 'api',
                         'path'       => '/get-videos',
                         'method'     => 'GET',
                         'action'     => 'get_videos'));

Route::map_connect(array('controller' => 'api',
                         'path'       => '/get-audios',
                         'method'     => 'GET',
                         'action'     => 'get_audios'));

Route::map_connect(array('controller' => 'api',
                         'path'       => '/get-photos',
                         'method'     => 'GET',
                         'action'     => 'get_photos'));

Route::map_connect(array('controller' => 'api',
                         'path'       => '/get-events',
                         'method'     => 'GET',
                         'action'     => 'get_events'));

Route::map_connect(array('controller' => 'api',
                         'path'       => '/doc',
                         'method'     => 'GET',
                         'action'     => 'doc'));

Route::map_connect(array('controller' => 'api',
                         'path'       => '/console',
                         'method'     => 'GET',
                         'action'     => 'console'));

Route::map_connect(array('controller' => 'api',
                         'path'       => '/console',
                         'method'     => 'POST',
                         'action'     => 'console'));

Route::run();
