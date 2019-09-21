#!/usr/bin/env php
<?php declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

/**
 * Vérifie si les vidéos AD'HOC Tube on bien été effacées de AD'HOC Legacy
 */

// extraire videos avec host_id = 9 (adhoctube)
// pour l'id donné, checker existence du .mp4 local media/video/id.mp4
// le .jpg reste

$db = DataBase::getInstance();

// stats par fournisseurs
/*
$d = $db->queryWithFetch("SELECT DISTINCT (id_host), COUNT(*) FROM adhoc_video GROUP BY id_host");
var_dump($d); die();
*/

/*
$videos = $db->queryWithFetch("SELECT * FROM adhoc_video WHERE id_host = 1");

echo "Vidéos YouTube\n";

foreach ($videos as $video) {
    echo $video['reference'] . "\n";
//    echo $video['id_video'] . ' ' . $video['name'] . " : " . $video['reference'] . "\n";
}
echo "Total: " . count($videos) . "\n\n";
*/

$videos = $db->queryWithFetch("SELECT * FROM adhoc_video WHERE id_host = 9");

echo "##\n";
echo "# Vidéos migrées de AD'HOC Legacy vers AD'HOC Tube, reste-il le mp4 localement ?\n";
echo "##\n\n";

foreach ($videos as $video) {
    echo $video['id_video'] . ' ' . $video['name'] . " : ";
    $f = '/var/www/adhocmusic.com/media/video/'.$video['id_video'].'.mp4';
    if (file_exists($f)) {
        echo $f . ' tjrs là' . "\n";
    } else {
        echo "[OK]";
    }
    echo "\n";
}
echo "Total: " . count($videos) . "\n\n";

$videos = $db->queryWithFetch("SELECT * FROM adhoc_video WHERE id_host = 7");

echo "##\n";
echo "# Vidéos AD'HOC Legacy à migrer vers AD'HOC Tube\n";
echo "##\n\n";

foreach ($videos as $video) {
    //echo $video['id_video'] . ' ' . $video['name'] . " : https://www.adhocmusic.com/videos/" . $video['id_video'] . "\n";
    echo $video['name'] . ';' . $video['id_video'] . '.mp4;' . "\n";  
    //echo "https://static.adhocmusic.com/media/video/" . $video['id_video'] . ".mp4\n";
}
echo "Total: " . count($videos) . "\n\n";
