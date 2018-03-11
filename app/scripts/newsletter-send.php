#!/usr/bin/php
<?php

// envoi d'une newsletter

// n° de newsletter à traiter
define('ID_NEWSLETTER', 80);

require_once dirname(__FILE__) . '/../config.php';

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

    $html = str_replace(
        [
            '%25%25email%25%25',
	        '%25%25url%25%25'
	    ],
        [
	        $sub['email'],
	        $newsletter->getUrl()
		],
        $newsletter->getHtml()
    );

    Email::send(
        $sub['email'],
        $newsletter->getTitle(),
        'newsletter',
        [
            /*
            'id'            => $newsletter->getId(),
            'id_newsletter' => $newsletter->getId(),
            'id_contact'    => $sub['id_contact'],
            'title'         => $newsletter->getTitle(),
            'url'           => $newsletter->getUrl(),
            'unsub_url'     => 'https://www.adhocmusic.com/newsletters/subscriptions?action=unsub&email=' . $sub['email'],
            'email'         => $sub['email'],
            'pseudo'        => $sub['pseudo'],
            */
            'html' => $newsletter->getHtml(),
        ]
    );

    $n++;
}

