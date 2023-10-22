#!/usr/bin/env php
<?php

/**
 * Tentative de récupération d'info d'une vidéo ...
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */

declare(strict_types=1);

use Adhoc\Model\Conf;

require_once __DIR__ . '/../bootstrap.php';

define('FB_OBJECT_ID', 211031683481100);

$conf = Conf::getInstance();

$fb = new Facebook\Facebook([
    'app_id' => $conf->get('facebook')['app_id'],
    'app_secret' => $conf->get('facebook')['app_secret'],
    'default_graph_version' => $conf->get('facebook')['default_graph_version'],
]);

$accessToken = $fb->getApp()->getAccessToken()->getValue();
$resp = $fb->get('/' . FB_OBJECT_ID, $accessToken);
$graphNode = $resp->getGraphNode();
var_dump($graphNode);
