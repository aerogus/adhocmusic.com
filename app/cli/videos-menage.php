#!/usr/bin/env php
<?php declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

$db = DataBase::getInstance();

$videos = file('a-del.txt');
echo "Vidéos YouTube invalides à supprimer\n";
foreach ($videos as $video) {
    $reference = trim($video);
    //echo $reference . "\n";
    $v = $db->queryWithFetch("SELECT * FROM adhoc_video WHERE id_host = 1 AND reference = '" . $reference . "'");
    if (!empty($v)) {
        echo 'https://www.adhocmusic.com/videos/delete/' . $v[0]['id_video'] . ' : ' . $v[0]['name'] . "\n";
    }
}

exit;

$video = $db->queryWithFetch("SELECT * FROM adhoc_video WHERE id_host = 1");

foreach ($videos as $video) {
    echo $video['reference'] . "\n";
    //echo $video['id_video'] . ' ' . $video['name'] . " : " . $video['reference'] . "\n";
}
echo "Total: " . count($videos) . "\n\n";
exit;
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
    echo $video['id_video'] . ' ' . $video['name'] . " : https://www.adhocmusic.com/videos/" . $video['id_video'] . "\n";
}
echo "Total: " . count($videos) . "\n\n";

