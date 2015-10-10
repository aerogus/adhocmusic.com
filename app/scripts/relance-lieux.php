#!/usr/bin/php
<?php

// script d'envoi d'un mail au contact d'un lieu
// dernier lancement: 07/12/2011

require_once 'common-cli.inc.php';

die('désactivé');

$lieux = Lieu::getLieux();

$cpt = 1;
foreach($lieux as $lieu)
{
    if(Email::validate($lieu['email'])) {

        if($lieu['email'] == 'guillaume.seznec@gmail.com') {
    
        Email::send(
            $lieu['email'],
            "Votre fiche lieu sur AD'HOC",
            'you-have-a-lieu',
            array(
               'email' => $lieu['email'],
               'id' => $lieu['id'],
               'name' => $lieu['name'],
               'address' => $lieu['address'],
               'cp2' => $lieu['cp2'],
               'city2' => $lieu['city2'],
            )
        );
    
        echo $cpt . " - " . $lieu['email'] . "\n";
        Log::write('relance-lieu', $lieu['email']);
        $cpt++;

        }

    } else {

        echo $lieu['email'] . " : invalide\n";

    }
}


