#!/usr/bin/php
<?php

// script d'envoi d'un mail au contact d'un groupe
// dernier lancement: 07/12/2011

die('désactivé');

require_once 'common-cli.inc.php';


$grps = Groupe::getGroupes();

$cpt = 1;
foreach($grps as $grp)
{
    if(Email::validate($grp['email'])) {

        if($grp['email'] == 'guillaume.seznec@gmail.com') {
    
        Email::send(
            $grp['email'],
            "Votre fiche groupe sur AD'HOC",
            'you-have-a-group',
            array(
               'email' => $grp['email'],
               'id' => $grp['id'],
               'mini_text' => $grp['mini_text'],
               'created_on' => $grp['created_on'],
               'name' => $grp['name'],
               'alias' => $grp['alias'],
            )
        );
    
        echo $cpt . " - " . $grp['email'] . "\n";
        Log::write('relance-groupe', $grp['email']);
        $cpt++;

        }

    } else {

        echo $grp['email'] . " : invalide\n";

    }
}

