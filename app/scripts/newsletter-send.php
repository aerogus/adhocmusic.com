#!/usr/bin/php
<?php

// envoi d'une newsletter

// n° de newsletter à traiter
define('ID_NEWSLETTER', 82);

require_once __DIR__ . '/../config.php';

// on temporise l'envoi des mails.
// 2sec = 30 mails/minute = 1800 mails/heure
define('MAIL_SEND_DELAY', 2);

$newsletter = Newsletter::getInstance(ID_NEWSLETTER);

// base de test
$subs = [
    ['id_contact' => 1, 'email' => 'guillaume@seznec.fr', 'pseudo' => 'gus', 'lastnl' => ''],
//    ['id_contact' => 1, 'email' => 'gilles.taddei@gmail.com', 'pseudo' => 'gillex', 'lastnl' => ''],
//    ['id_contact' => 7018, 'email' => 'lara.etcheverry@gmail.com', 'pseudo' => 'lara', 'lastnl' => ''],
//    ['id_contact' => 2, 'email' => 'truc.invalide@oiuofdsg.com', 'pseudo' => 'rien', 'lastnl' => ''],
//    ['id_contact' => 3, 'email' => 'newsletter@adhocmusic.com', 'pseudo' => 'test', 'lastnl' => ''],
];

// base de prod
//$subs = Newsletter::getSubscribers();

echo "Trouvé : " . count($subs) . " emails\n";
//die();
// boucle des emails - expédition effective

$n = 1;

foreach ($subs as $sub)
{
    $log = ID_NEWSLETTER . "\t" . $n . "\t" . $sub['id_contact'] . " \t\t" . $sub['lastnl'] . "\t\t" . $sub['email'] . "\t\t" . $sub['pseudo'];
    echo $log . "\n";

    Log::write('nl-send', $log);

    $newsletter_id_newsletter = ID_NEWSLETTER;
    $newsletter_id_contact = $sub['id_contact'];

    $newsletter->setIdContact($sub['id_contact']);
    $newsletter->setTplVar('%%email%%', $sub['email']);
    $newsletter->setTplVar('%%pseudo%%', $sub['pseudo']);
    $newsletter->setTplVar('%%url%%', $newsletter->getUrl());

    Email::send(
        $sub['email'],
        $newsletter->getTitle(),
        'newsletter',
        ['html' => $newsletter->getProcessedHtml()]
    );

    sleep(MAIL_SEND_DELAY);

    $n++;
}

