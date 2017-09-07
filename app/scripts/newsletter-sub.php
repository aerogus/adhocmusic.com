#!/usr/bin/php
<?php

require_once dirname(__FILE__) . '/../config.php';

/**
 * abonne des emails à la newsletter
 */

const EMAILS = 'newsletter-sub.csv';

if (!empty($argv[1])) {
    $data = [trim($argv[1])];
} else {
    if (!file_exists(EMAILS)) die(EMAILS . ' introuvable');
    if (!($data = file(EMAILS))) die(EMAILS . ' vide');
}

foreach ($data as $email) {
    $email = trim((string) $email);
    echo $email . " : ";
    if ($id_contact = Contact::getIdByEmail($email)) {
        echo "contact ? oui (" . $id_contact . ") - ";
        if ($pseudo = Membre::getPseudoById($id_contact)) {
            echo "membre ? oui (" . $pseudo . ") - ";
            $membre = Membre::getInstance($id_contact);
            if ($membre->getMailing()) {
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

