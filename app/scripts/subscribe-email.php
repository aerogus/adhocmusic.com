#!/usr/bin/php
<?php

require_once dirname(__FILE__) . '/../config.php';

/**
 * abonne un email à la newsletter
 */

// en dur
$data = array(
    // emails
);

// ficher un email par ligne
$data = file("emails.txt");

foreach($data as $email)
{
    $email = trim((string) $email);
    echo $email . " : ";
    if($id_contact = Contact::getIdByEmail($email)) {
        echo "contact ? oui (" . $id_contact . ") - ";
        if($pseudo = Membre::getPseudoById($id_contact)) {
            echo "membre ? oui (" . $pseudo . ") - ";
            $membre = Membre::getInstance($id_contact);
            if($membre->getMailing()) {
                echo "déjà inscrit";
            } else {
                $membre->setMailing(true);
                $membre->save();
                echo "réinscription OK";
            }
        } else {
            echo "membre ? non - donc déja inscrit";
        }
    } else {
        echo "contact ? non - ";
        $contact = Contact::init();
        $contact->setEmail($email);
        $id = $contact->save();
        echo "création du contact OK (" . $id . ")";
    }
    echo "\n";
}

