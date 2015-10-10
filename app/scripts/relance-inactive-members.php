#!/usr/bin/php
<?php

// script d'envoi d'un mail aux membres qui ne se sont pas connectés depuis 1 an
// à lancer tous les ans :)
// dernier lancement: 06/12/2011

die('désactivé');

require_once 'common-cli.inc.php';

$mbrs = Membre::getOneYearUnactivesMembers();

$cpt = 1;
foreach($mbrs as $mbr)
{
    Email::send(
        $mbr['email'],
        'Nouveautés depuis votre dernière connexion',
        'one-year-unactive-member',
        array(
           'pseudo' => $mbr['pseudo'],
           'created_on' => $mbr['created_on'],
        )
    );
    echo $cpt . " - " . $mbr['email'] . "\n";
    Log::write('1y-unactive-mbr', $mbr['email']);
    $cpt++;
}

