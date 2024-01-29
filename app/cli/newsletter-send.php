#!/usr/bin/env php
<?php

/**
 * Envoi d'une newsletter à l'ensemble des membres inscrits
 *
 * @param int    $argv[1] id_newsletter
 * @param string $argv[2] email (à implémenter)
 *
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */

declare(strict_types=1);

use Adhoc\Model\Newsletter;
use Adhoc\Utils\Log;
use Adhoc\Utils\Email;

// on temporise l'envoi des mails.
// 2sec = 30 mails/minute = 1800 mails/heure
define('MAIL_SEND_DELAY', 1);

// pour la gestion de reprise après plantage
define('MIN_ID_CONTACT', 0);

require_once __DIR__ . '/../bootstrap.php';

// n° de newsletter a traiter
if (empty($argv[1])) {
    echo "Usage: ./newsletter-send.php id_newsletter\n";
    exit;
}
$id_newsletter = (int) $argv[1];

$newsletter = Newsletter::getInstance($id_newsletter);

// base de test
$subs = [
    ['id_contact' => 1, 'email' => 'guillaume@seznec.fr', 'pseudo' => 'gus', 'lastnl' => ''],
];

// base de prod
//$subs = Newsletter::getSubscribers();

echo "Trouvé : " . count($subs) . " emails\n";

// boucle des emails - expédition effective

$n = 1;

foreach ($subs as $sub) {
    // suite après plantage
    if (intval($sub['id_contact']) < MIN_ID_CONTACT) {
        continue;
    }

    $log = $id_newsletter . "\t" . $n . "\t" . $sub['id_contact'] . " \t\t" . $sub['lastnl'] . "\t\t" . $sub['email'] . "\t\t" . $sub['pseudo'];
    echo $log . "\n";

    Log::write('nl-send', $log);

    $newsletter_id_newsletter = $id_newsletter;
    $newsletter_id_contact = (int) $sub['id_contact'];

    $newsletter->setIdContact((int) $sub['id_contact'])
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
