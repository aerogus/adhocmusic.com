#!/usr/bin/php
<?php

require_once 'common-cli.inc.php';

/**
 * insertion en base des logs de commit svn
 */

//$rev = (int) $_SERVER['argv'][1];
//$repo = 'file:///home/adhocmus/svn/adhoc';
$repo = 'svn+ssh://adhocmus@ssh.cluster014.ovh.net/adhoc';

//en prod
//$start_rev = $rev;
//$end_rev = $rev;

//import initial
$start_rev = 6435;
$end_rev = 6438;

$db = DataBase::getInstance();

for($current_rev = $start_rev ; $current_rev <= $end_rev ; $current_rev++)
{
    $cmd = "svn log --xml --revision " . $current_rev . " --verbose " . $repo;
    echo $cmd;

    $out = null;
    exec($cmd, $out);
    $str = implode("\n", $out);
    $xml = simplexml_load_string($str);
    var_dump($xml);

    $data = array();
    $data['revision'] = (int) $xml->logentry['revision'];
    $data['author'] = (string) $xml->logentry->author;
    $data['datetime'] = (string) $xml->logentry->date;
    $data['log'] = (string) $xml->logentry->msg;
    $data['file'] = '';
    foreach($xml->logentry->paths->path as $path) {
        $data['file'] .= $path['action'] . ' ' . $path . "\n";
    }

    var_dump($data);

    $sql = "INSERT INTO `adhoc_svn` "
         . "(`revision`, `author`, "
         . "`datetime`, `log`, "
         . "`file`) "
         . "VALUES(". (int) $data['revision'] . ", '" . $db->escape($data['author']) . "', "
         . "'" . $db->escape($data['datetime']) . "', '" . $db->escape($data['log']) . "', "
         . "'" . $db->escape($data['file']) . "')";

    $db->query($sql);
}

