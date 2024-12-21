#!/usr/bin/env php
<?php

/**
 * Envoi d'une newsletter à l'ensemble des membres inscrits
 *
 * @param int $argv[1] id_newsletter
 * @param int $argv[2] min_id_contact
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */

declare(strict_types=1);

use Adhoc\Model\Newsletter;
use Adhoc\Utils\Log;
use Adhoc\Utils\Email;

// on temporise l'envoi des mails.
// 2sec = 30 mails/minute = 1800 mails/heure
define('MAIL_SEND_DELAY', 1);

require_once __DIR__ . '/../bootstrap.php';

// n° de newsletter a traiter
if (!isset($argv[1])) {
    echo "Usage: ./newsletter-send.php id_newsletter\n";
    exit;
}
$id_newsletter = (int) $argv[1];

// pour la gestion de reprise après plantage
$min_id_contact = isset($argv[2]) ? (int) $argv[2] : 0;

// base de test
$subs = [
    ['id_contact' => 1, 'email' => 'guillaume@seznec.fr', 'pseudo' => 'gus'],
];

// base de prod
//$subs = Newsletter::getSubscribers();

Log::info("Trouvé : " . count($subs) . " email(s)");

try {
    Log::info('id_newsletter: ' . $id_newsletter);
    $newsletter = Newsletter::getInstance($id_newsletter);
} catch (\Exception $e) {
    Log::error($e->getMessage());
    die;
}

// boucle des emails - expédition effective

$n = 1;

foreach ($subs as $sub) {
    // suite après plantage
    if (intval($sub['id_contact']) < $min_id_contact) {
        continue;
    }

    Log::info($id_newsletter . "\t" . $n . "\t" . $sub['id_contact'] . " \t\t" . $sub['email'] . "\t\t" . $sub['pseudo']);

    $newsletter_id_newsletter = $id_newsletter;
    $newsletter_id_contact = $sub['id_contact'];

    $newsletter->setIdContact($sub['id_contact'])
        ->setTplVar('%%email%%', $sub['email'])
        ->setTplVar('%%pseudo%%', $sub['pseudo'])
        ->setTplVar('%%url%%', $newsletter->getUrl());

    Email::send(
        $sub['email'],
        $newsletter->getTitle(),
        'newsletter',
        ['html' => $newsletter->getProcessedHtml()]
    );

    sleep(MAIL_SEND_DELAY);

    $n++;
}
