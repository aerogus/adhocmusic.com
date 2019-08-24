#!/usr/bin/php
<?php

require_once __DIR__ . '/../config.php';

/**
 * Désabonne des emails de la newsletter
 *
 * @param string $argv[1] email(s) à désinscrire séparés par une virgule
 */

if (empty($argv[1])) {
    echo "Usage: newsletter-unsub.php email1,email2,email3,...\n";
    exit;
}

$data = explode(',', $argv[1]);

foreach ($data as $email) {
    if (!$email = trim((string) $email)) {
        continue;
    }
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

