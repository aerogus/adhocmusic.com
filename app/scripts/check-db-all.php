#!/usr/bin/env php
<?php declare(strict_types=1);

require_once __DIR__ . '/../config.php';

/**
 * Vérification des incohérences dans la base de données AD'HOC
 * car les tables sont en MyISAM et n'ont pas l'intégrité référentielle
 * une fois les incohérences éradiquées on pourra songer à passer
 * les tables importantes en InnoDB.
 */

$db = DataBase::getInstance();

$sql = "SELECT `id_contact` FROM `adhoc_membre` WHERE `id_contact` NOT IN (SELECT `id_contact` FROM `adhoc_contact`)";
echo "\n1 - membre lié à contact introuvable\n";
$tbl = new Console_Table();
$tbl->setHeaders(['id_contact']);
$res = $db->queryWithFetch($sql);
foreach ($res as $_res) {
    $tbl->addRow([$_res['id_contact']]);
    // on supprime le membre invalide ?
}
echo count($res) ? $tbl->getTable() : "OK\n";
unset($tbl);

$sql = "SELECT `id_contact`, `id_groupe` FROM `adhoc_appartient_a` WHERE `id_contact` NOT IN (SELECT `id_contact` FROM `adhoc_membre`)";
echo "\n2 - appartient_a lié à membre introuvable\n";
$tbl = new Console_Table();
$tbl->setHeaders(['id_contact', 'id_groupe']);
$res = $db->queryWithFetch($sql);
foreach ($res as $_res) {
    $tbl->addRow([$_res['id_contact'], $_res['id_groupe']]);
    // on supprime les liaisons groupes avec les membres introuvables
    //$db->query('DELETE FROM adhoc_appartient_a WHERE id_contact = ' . (int) $_res['id_contact']);
}
echo count($res) ? $tbl->getTable() : "OK\n";
unset($tbl);

$sql = "SELECT `id_groupe`, `id_contact` FROM `adhoc_appartient_a` WHERE `id_groupe` NOT IN (SELECT `id_groupe` FROM `adhoc_groupe`)";
echo "\n3 - appartient_a lié à groupe introuvable\n";
$tbl = new Console_Table();
$tbl->setHeaders(['id_groupe', 'id_contact']);
$res = $db->queryWithFetch($sql);
foreach ($res as $_res) {
    $tbl->addRow([$_res['id_groupe'], $_res['id_contact']]);
    // on supprime les liaisons groupes avec les groupes introuvables
    //$db->query('DELETE FROM adhoc_appartient_a WHERE id_groupe = ' . (int) $_res['id_groupe']);
}
echo count($res) ? $tbl->getTable() : "OK\n";
unset($tbl);

$sql = "SELECT `id_audio`, `id_groupe` FROM `adhoc_audio` WHERE `id_groupe` <> 0 AND `id_groupe` NOT IN (SELECT `id_groupe` FROM `adhoc_groupe`)";
echo "\n4 - audio lié à groupe introuvable\n";
$tbl = new Console_Table();
$tbl->setHeaders(['id_audio', 'id_groupe']);
$res = $db->queryWithFetch($sql);
foreach ($res as $_res) {
    $tbl->addRow([$_res['id_audio'], $_res['id_groupe']]);
}
echo count($res) ? $tbl->getTable() : "OK\n";
unset($tbl);

$sql = "SELECT `id_audio`, `id_contact` FROM `adhoc_audio` WHERE `id_contact` NOT IN (SELECT `id_contact` FROM `adhoc_membre`)";
echo "\n5 - audio lié à membre introuvable\n";
$tbl = new Console_Table();
$tbl->setHeaders(['id_audio', 'id_contact']);
$res = $db->queryWithFetch($sql);
foreach ($res as $_res) {
    $tbl->addRow([$_res['id_audio'], $_res['id_contact']]);
}
echo count($res) ? $tbl->getTable() : "OK\n";
unset($tbl);

$sql = "SELECT `id_audio`, `id_lieu` FROM `adhoc_audio` WHERE `id_lieu` <> 0 AND `id_lieu` NOT IN (SELECT `id_lieu` FROM `adhoc_lieu`)";
echo "\n6 - audio lié à lieu introuvable\n";
$tbl = new Console_Table();
$tbl->setHeaders(['id_audio', 'id_groupe']);
$res = $db->queryWithFetch($sql);
foreach ($res as $_res) {
    $tbl->addRow([$_res['id_audio'], $_res['id_lieu']]);
}
echo count($res) ? $tbl->getTable() : "OK\n";
unset($tbl);

$sql = "SELECT `id_audio`, `id_event` FROM `adhoc_audio` WHERE `id_event` <> 0 AND `id_event` NOT IN (SELECT `id_event` FROM `adhoc_event`)";
echo "\n7 - audio lié à event introuvable\n";
$tbl = new Console_Table();
$tbl->setHeaders(['id_audio', 'id_event']);
$res = $db->queryWithFetch($sql);
foreach ($res as $_res) {
    $tbl->addRow([$_res['id_audio'], $_res['id_event']]);
}
echo count($res) ? $tbl->getTable() : "OK\n";
unset($tbl);

$sql = "SELECT `id_audio`, `id_structure` FROM `adhoc_audio` WHERE `id_structure` <> 0 AND `id_structure` NOT IN (SELECT `id_structure` FROM `adhoc_structure`)";
echo "\n8 - audio lié à structure introuvable\n";
$tbl = new Console_Table();
$tbl->setHeaders(['id_audio', 'id_structure']);
$res = $db->queryWithFetch($sql);
foreach ($res as $_res) {
    $tbl->addRow([$_res['id_audio'], $_res['id_structure']]);
}
echo count($res) ? $tbl->getTable() : "OK\n";
unset($tbl);

$sql = "SELECT `id_event`, `id_contact` FROM `adhoc_event` WHERE `id_contact` NOT IN (SELECT `id_contact` FROM `adhoc_membre`)";
echo "\n12 - event lié à membre introuvable\n";
$tbl = new Console_Table();
$tbl->setHeaders(['id_event', 'id_contact']);
$res = $db->queryWithFetch($sql);
foreach ($res as $_res) {
    $tbl->addRow([$_res['id_event'], $_res['id_contact']]);
    // on reaffecte à id_contact = 1 tous les events orphelins
    //$db->query("UPDATE adhoc_event SET id_contact = 1 WHERE id_event = " . (int) $_res['id_event']);
}
echo count($res) ? $tbl->getTable() : "OK\n";
unset($tbl);

$sql = "SELECT `id_event`, `id_lieu` FROM `adhoc_event` WHERE `id_lieu` NOT IN (SELECT `id_lieu` FROM `adhoc_lieu`)";
echo "\n13 - event lié à lieu introuvable\n";
$tbl = new Console_Table();
$tbl->setHeaders(['id_event', 'id_lieu']);
$res = $db->queryWithFetch($sql);
foreach ($res as $_res) {
    $tbl->addRow([$_res['id_event'], $_res['id_lieu']]);
}
echo count($res) ? $tbl->getTable() : "OK\n";
unset($tbl);

$sql = "SELECT `id_groupe`, `id_event` FROM `adhoc_participe_a` WHERE `id_event` NOT IN (SELECT `id_event` FROM `adhoc_event`)";
echo "\n14 - groupe lié à event introuvable\n";
$tbl = new Console_Table();
$tbl->setHeaders(['id_groupe', 'id_event']);
$res = $db->queryWithFetch($sql);
foreach ($res as $_res) {
    $tbl->addRow([$_res['id_groupe'], $_res['id_event']]);
}
echo count($res) ? $tbl->getTable() : "OK\n";
unset($tbl);

$sql = "SELECT `id_event`, `id_groupe` FROM `adhoc_participe_a` WHERE `id_groupe` NOT IN (SELECT `id_groupe` FROM `adhoc_groupe`)";
echo "\n15 - event lié à groupe introuvable\n";
$tbl = new Console_Table();
$tbl->setHeaders(['id_event', 'id_groupe']);
$res = $db->queryWithFetch($sql);
foreach ($res as $_res) {
    $tbl->addRow([$_res['id_event'], $_res['id_groupe']]);
}
echo count($res) ? $tbl->getTable() : "OK\n";
unset($tbl);

$sql = "SELECT `id_photo`, `id_contact` FROM `adhoc_photo` WHERE `id_contact` NOT IN (SELECT `id_contact` FROM `adhoc_membre`)";
echo "\n16 - photo liée à contact introuvable\n";
$tbl = new Console_Table();
$tbl->setHeaders(['id_photo', 'id_contact']);
$res = $db->queryWithFetch($sql);
foreach ($res as $_res) {
    $tbl->addRow([$_res['id_photo'], $_res['id_contact']]);
    // on reaffecte à id_contact = 1 toutes les photos orphelines
    //$db->query('UPDATE adhoc_photo SET id_contact = 1 WHERE id_photo = ' . (int) $_res['id_photo']);
}
echo count($res) ? $tbl->getTable() : "OK\n";
unset($tbl);

$sql = "SELECT `id_photo`, `id_groupe` FROM `adhoc_photo` WHERE `id_groupe` <> 0 AND `id_groupe` NOT IN (SELECT `id_groupe` FROM `adhoc_groupe`)";
echo "\n17 - photo liée à groupe introuvable\n";
$tbl = new Console_Table();
$tbl->setHeaders(['id_photo', 'id_groupe']);
$res = $db->queryWithFetch($sql);
foreach ($res as $_res) {
    $tbl->addRow([$_res['id_photo'], $_res['id_groupe']]);
    // on délie le groupe s'il est introuvable
    //$db->query('UPDATE adhoc_photo SET id_groupe = 0 WHERE id_photo = ' . (int) $_res['id_photo']);
}
echo count($res) ? $tbl->getTable() : "OK\n";
unset($tbl);

$sql = "SELECT `id_photo`, `id_lieu` FROM `adhoc_photo` WHERE `id_lieu` <> 0 AND `id_lieu` NOT IN (SELECT `id_lieu` FROM `adhoc_lieu`)";
echo "\n18 - photo liée à lieu introuvable\n";
$tbl = new Console_Table();
$tbl->setHeaders(['id_photo', 'id_lieu']);
$res = $db->queryWithFetch($sql);
foreach ($res as $_res) {
    $tbl->addRow([$_res['id_photo'], $_res['id_lieu']]);
    // on délie le lieu s'il est introuvable
    //$db->query('UPDATE adhoc_photo SET id_lieu = 0 WHERE id_photo = ' . (int) $_res['id_photo']);
}
echo count($res) ? $tbl->getTable() : "OK\n";
unset($tbl);

$sql = "SELECT `id_photo`, `id_event` FROM `adhoc_photo` WHERE `id_event` <> 0 AND `id_event` NOT IN (SELECT `id_event` FROM `adhoc_event`)";
echo "\n19 - photo liée à event introuvable\n";
$tbl = new Console_Table();
$tbl->setHeaders(['id_photo', 'id_event']);
$res = $db->queryWithFetch($sql);
foreach ($res as $_res) {
    $tbl->addRow([$_res['id_photo'], $_res['id_event']]);
    // on délie l'event s'il est introuvable
    //$db->query('UPDATE adhoc_photo SET id_event = 0 WHERE id_photo = ' . (int) $_res['id_photo']);
}
echo count($res) ? $tbl->getTable() : "OK\n";
unset($tbl);

$sql = "SELECT `id_photo`, `id_structure` FROM `adhoc_photo` WHERE `id_structure` <> 0 AND `id_structure` NOT IN (SELECT `id_structure` FROM `adhoc_structure`)";
echo "\n20 - photo liée à structure introuvable\n";
$tbl = new Console_Table();
$tbl->setHeaders(['id_photo', 'id_structure']);
$res = $db->queryWithFetch($sql);
foreach ($res as $_res) {
    $tbl->addRow([$_res['id_photo'], $_res['id_structure']]);
    // on délie la structure si elle est introuvable
    //$db->query('UPDATE adhoc_photo SET id_structure = 0 WHERE id_photo = ' . (int) $_res['id_photo']);
}
echo count($res) ? $tbl->getTable() : "OK\n";
unset($tbl);

$sql = "SELECT `id_video`, `id_contact` FROM `adhoc_video` WHERE `id_contact` NOT IN (SELECT `id_contact` FROM `adhoc_membre`)";
echo "\n21 - vidéo liée à contact introuvable\n";
$tbl = new Console_Table();
$tbl->setHeaders(['id_video', 'id_contact']);
$res = $db->queryWithFetch($sql);
foreach ($res as $_res) {
    $tbl->addRow([$_res['id_video'], $_res['id_contact']]);
    // on réaffecte à id_contact = 1 toutes les vidéos orphelines
    //$db->query('UPDATE adhoc_video SET id_contact = 1 WHERE id_video = ' . (int) $_res['id_video']);
}
echo count($res) ? $tbl->getTable() : "OK\n";
unset($tbl);

$sql = "SELECT `id_video`, `id_groupe` FROM `adhoc_video` WHERE `id_groupe` <> 0 AND `id_groupe` NOT IN (SELECT `id_groupe` FROM `adhoc_groupe`)";
echo "\n22 - vidéo liée à groupe introuvable\n";
$tbl = new Console_Table();
$tbl->setHeaders(['id_video', 'id_groupe']);
$res = $db->queryWithFetch($sql);
foreach ($res as $_res) {
    $tbl->addRow([$_res['id_video'], $_res['id_groupe']]);
    // on délie le groupe s'il est introuvable
    //$db->query('UPDATE adhoc_video SET id_groupe = 0 WHERE id_video = ' . (int) $_res['id_video']);
}
echo count($res) ? $tbl->getTable() : "OK\n";
unset($tbl);

$sql = "SELECT `id_video`, `id_lieu` FROM `adhoc_video` WHERE `id_lieu` <> 0 AND `id_lieu` NOT IN (SELECT `id_lieu` FROM `adhoc_lieu`)";
echo "\n23 - vidéo liée à lieu introuvable\n";
$tbl = new Console_Table();
$tbl->setHeaders(['id_video', 'id_lieu']);
$res = $db->queryWithFetch($sql);
foreach ($res as $_res) {
    $tbl->addRow([$_res['id_video'], $_res['id_lieu']]);
    // on délie le lieu s'il est introuvable
    //$db->query('UPDATE adhoc_video SET id_lieu = 0 WHERE id_video = ' . (int) $_res['id_video']);
}
echo count($res) ? $tbl->getTable() : "OK\n";
unset($tbl);

$sql = "SELECT `id_video`, `id_event` FROM `adhoc_video` WHERE `id_event` <> 0 AND `id_event` NOT IN (SELECT `id_event` FROM `adhoc_event`)";
echo "\n24 - vidéo liée à event introuvable\n";
$tbl = new Console_Table();
$tbl->setHeaders(['id_video', 'id_event']);
$res = $db->queryWithFetch($sql);
foreach ($res as $_res) {
    $tbl->addRow([$_res['id_video'], $_res['id_event']]);
    // on délie l'event s'il est introuvable
    //$db->query('UPDATE adhoc_video SET id_event = 0 WHERE id_video = ' . (int) $_res['id_video']);
}
echo count($res) ? $tbl->getTable() : "OK\n";
unset($tbl);

$sql = "SELECT `id_video`, `id_structure` FROM `adhoc_video` WHERE `id_structure` <> 0 AND `id_structure` NOT IN (SELECT `id_structure` FROM `adhoc_structure`)";
echo "\n25 - vidéo liée à structure introuvable\n";
$tbl = new Console_Table();
$tbl->setHeaders(['id_video', 'id_structure']);
$res = $db->queryWithFetch($sql);
foreach ($res as $_res) {
    $tbl->addRow([$_res['id_video'], $_res['id_structure']]);
    // on délie la structure si elle est introuvable
    //$db->query('UPDATE adhoc_video SET id_structure = 0 WHERE id_video = ' . (int) $_res['id_video']);
}
echo count($res) ? $tbl->getTable() : "OK\n";
unset($tbl);

$sql = "SELECT `id_pm`, `from` FROM `adhoc_messagerie` WHERE `from` NOT IN (SELECT `id_contact` FROM `adhoc_membre`)";
echo "\n27 - message lié à membre expéditeur introuvable\n";
$tbl = new Console_Table();
$tbl->setHeaders(['id_pm', 'from']);
$res = $db->queryWithFetch($sql);
foreach ($res as $_res) {
    $tbl->addRow([$_res['id_pm'], $_res['from']]);
    // on efface les messages dont l'expéditeur est introuvable
    //$db->query("DELETE FROM adhoc_messagerie WHERE id_pm = " . (int) $_res['id_pm']);
}
echo count($res) ? $tbl->getTable() : "OK\n";
unset($tbl);

$sql = "SELECT `id_pm`, `to` FROM `adhoc_messagerie` WHERE `to` NOT IN (SELECT `id_contact` FROM `adhoc_membre`)";
echo "\n28 - message lié à membre destinataire introuvable\n";
$tbl = new Console_Table();
$tbl->setHeaders(['id_pm', 'to']);
$res = $db->queryWithFetch($sql);
foreach ($res as $_res) {
    $tbl->addRow([$_res['id_pm'], $_res['to']]);
    // on efface les messages dont le destinataire est introuvable
    //$db->query("DELETE FROM adhoc_messagerie WHERE id_pm = " . (int) $_res['id_pm']);
}
echo count($res) ? $tbl->getTable() : "OK\n";
unset($tbl);

$sql = "SELECT `id_photo`, `name` FROM `adhoc_photo` WHERE `id_groupe` = 0 AND `id_event` = 0 AND `id_lieu` = 0";
echo "\n30 - photo liée à aucun groupe/événement/lieu\n";
$tbl = new Console_Table();
$tbl->setHeaders(['id_photo', 'name']);
$res = $db->queryWithFetch($sql);
foreach ($res as $_res) {
    $tbl->addRow([$_res['id_photo'], $_res['name']]);
}
echo count($res) ? $tbl->getTable() : "OK\n";
unset($tbl);

$sql = "SELECT `id_audio`, `name` FROM `adhoc_audio` WHERE `id_groupe` = 0 AND `id_event` = 0 AND `id_lieu` = 0";
echo "\n31 - audio lié à aucun groupe/événement/lieu\n";
$tbl = new Console_Table();
$tbl->setHeaders(['id_audio', 'name']);
$res = $db->queryWithFetch($sql);
foreach ($res as $_res) {
    $tbl->addRow([$_res['id_audio'], $_res['name']]);
}
echo count($res) ? $tbl->getTable() : "OK\n";
unset($tbl);

$sql = "SELECT `id_video`, `name` FROM `adhoc_video` WHERE `id_groupe` = 0 AND `id_event` = 0 AND `id_lieu` = 0";
echo "\n32 - vidéo liée à aucun groupe/événement/lieu\n";
$tbl = new Console_Table();
$tbl->setHeaders(['id_video', 'name']);
$res = $db->queryWithFetch($sql);
foreach ($res as $_res) {
    $tbl->addRow([$_res['id_video'], $_res['name']]);
}
echo count($res) ? $tbl->getTable() : "OK\n";
unset($tbl);

$sql = "SELECT `id_lieu`, DATE(`date`) AS `date`, COUNT(*) AS `nb` FROM `adhoc_event` GROUP BY `id_lieu`, DATE(`date`) HAVING `nb` > 1";
echo "\n33 - événements en double (même lieu au même jour)\n";
$tbl = new Console_Table();
$tbl->setHeaders(['id_lieu', 'date', 'nb']);
$res = $db->queryWithFetch($sql);
foreach ($res as $_res) {
    $tbl->addRow([$_res['id_lieu'], $_res['date'], $_res['nb']]);
}
echo count($res) ? $tbl->getTable() : "OK\n";
unset($tbl);

