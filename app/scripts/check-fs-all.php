#!/usr/bin/php
<?php

/**
 * Cohérence contenus
 *
 * Vérifie si un content du file system pas obsolète (ressource bdd effacée)
 */

require_once __DIR__ . '/../config.php';

$db = DataBase::getInstance();

echo "1 - Cohérence Avatars Membre\n";

// liste des contacts
$sql = "SELECT `id_contact` FROM `adhoc_contact` ORDER BY `id_contact` ASC";
$contacts = $db->queryWithFetchFirstFields($sql);
$nb_contacts = count($contacts);

// liste des membres
$sql = "SELECT `id_contact` FROM `adhoc_membre` ORDER BY `id_contact` ASC";
$membres = $db->queryWithFetchFirstFields($sql);
$nb_membres = count($membres);

// on parcourt le répertoire des images à la recherche des obsolètes
$path = MEDIA_PATH . "/membre/";
$cpt_files = 0;
foreach (glob($path . "*.jpg") as $filename) {
    $cpt_files++;
    $filename = str_replace($path, "", $filename);
    $id = (int) str_replace(".jpg", "", $filename);
    if (!in_array($id, $contacts)) {
        echo "Avatar inutile (compte effacé) : " . $id . "\n";
        // purge ?
        //unlink($path . $id . ".jpg");
    }
}
$nb_files = $cpt_files;

echo "nb_contacts: " . $nb_contacts . " | nb_membres: " . $nb_membres . " | nb_avatars: " . $nb_files . "\n";


echo "2 - Cohérence Avatars Membres internes\n";

// liste des membres
$sql = "SELECT `id_contact` FROM `adhoc_membre_adhoc` ORDER BY `id_contact` ASC";
$membres = $db->queryWithFetchFirstFields($sql);
$nb_membres = count($membres);

// on parcourt le répertoire des images à la recherche des obsolètes
$path = MEDIA_PATH . "/membre/ca/";
$cpt_files = 0;
foreach (glob($path . "*.jpg") as $filename) {
    $cpt_files++;
    $filename = str_replace($path, "", $filename);
    $id = (int) str_replace(".jpg", "", $filename);
    if (!in_array($id, $membres)) {
        echo "Avatar interne inutile (compte effacé) : " . $id . "\n";
        // purge ?
        //unlink($path . $id . ".jpg");
    }
}
$nb_files = $cpt_files;

echo "nb_membres_internes: " . $nb_membres . " | nb_avatars: " . $nb_files . "\n";

echo "3 - Cohérence images groupes\n";

// liste des groupes
$sql = "SELECT `id_groupe` FROM `adhoc_groupe` ORDER BY `id_groupe` ASC";
$groupes = $db->queryWithFetchFirstFields($sql);

// on parcourt le répertoire des images à la recherche des obsolètes
$path = MEDIA_PATH . "/groupe/";

$prefix = ["b", "l", "m", "p"];

foreach ($prefix as $pre) {
    foreach (glob($path . $pre ."*") as $filename) {
        $fullpath = $filename;
        $filename = str_replace($pre, "", basename($filename));
        $res = preg_split('/\./', $filename);
        if (!in_array((int) $res[0], $groupes)) {
            echo "images " . $pre . " groupes obsolètes pour id " . $res[0] . " (".$res[1]." trouvé)\n";
            //echo "rm " . $fullpath . "\n";
        }
    }
}

echo "4 - Cohérence audios / mp3\n";

// liste des audios
$sql = "SELECT `id_audio` FROM `adhoc_audio` ORDER BY `id_audio` ASC";
$audios = $db->queryWithFetchFirstFields($sql);

// on parcourt le répertoire des mp3 à la recherche des obsolètes
$path = MEDIA_PATH . "/audio/";

foreach (glob($path . "*") as $filename) {
    $fullpath = $filename;
    $filename = basename($filename);
    $res = preg_split('/\./', $filename);
    if (!in_array((int) $res[0], $audios)) {
        echo "mp3 obsolète pour id " . $res[0] . "\n";
        //echo "rm " . $fullpath . "\n";
    }
}

echo "5 - Cohérence vignette videos\n";

// liste des vidéos
$sql = "SELECT `id_video` FROM `adhoc_video` ORDER BY `id_video` ASC";
$videos = $db->queryWithFetchFirstFields($sql);

// on parcourt le répertoire des vignettes videos à la recherche des obsolètes
$path = MEDIA_PATH . "/video/";

foreach (glob($path . "*.jpg") as $filename) {
    $filename = basename($filename);
    $res = preg_split('/\./', $filename);
    if (!in_array((int) $res[0], $videos)) {
        echo "vignette vidéo obsolète pour id " . $res[0] . "\n";
    }
}

echo "6 - Cohérence flyer événements\n";

// liste des événements
$sql = "SELECT `id_event` FROM `adhoc_event` ORDER BY `id_event` ASC";
$events = $db->queryWithFetchFirstFields($sql);

// on parcourt le répertoire des flyers événements à la recherche des obsolètes
$path = MEDIA_PATH . "/event/";

foreach (glob($path . "*.jpg") as $filename) {
    $filename = basename($filename);
    $res = preg_split('/\./', $filename);
    if (!in_array((int) $res[0], $events)) {
        echo "flyer événement obsolète pour id " . $res[0] . "\n";
    }
}

