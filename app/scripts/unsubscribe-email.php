#!/usr/bin/php
<?php

require_once dirname(__FILE__) . '/../config.php';

/**
 * désabonne un email de la newsletter
 */

// tableau d'emails
$data = [];

// fichier un email par ligne
$data = file("emails.txt");

foreach ($data as $email) {
    $email = trim((string) $email);
    echo $email . " : ";
    if ($id_contact = Contact::getIdByEmail($email)) {
        echo "contact ? oui (" . $id_contact . ") - ";
        if ($pseudo = Membre::getPseudoById($id_contact)) {
            echo "membre ? oui (" . $pseudo . ") - ";
            $membre = Membre::getInstance($id_contact);
            if ($membre->getMailing()) {
                $membre->setMailing(false);
                $membre->save();
                echo "désinscription OK";
            } else {
                echo "déja désinscrit";
            }
        } else {
            echo "membre ? non - ";
            $contact = Contact::getInstance($id_contact);
            $contact->delete();
            echo "delete du contact OK";
        }
    } else {
        echo "contact ? non - donc pas inscrit";
    }
    echo "\n";
}

