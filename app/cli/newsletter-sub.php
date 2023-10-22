#!/usr/bin/env php
<?php

declare(strict_types=1);

use Adhoc\Model\Email;
use Adhoc\Model\Contact;
use Adhoc\Model\Membre;

require_once __DIR__ . '/../bootstrap.php';

/**
 * Abonne des emails à la newsletter
 *
 * @param string $argv[] email(s) à inscrire séparés par une espace
 */

if ($argc < 2) {
    echo "Usage: newsletter-sub.php email1 email2 email3 ...\n";
    exit;
}

for ($idx = 1; $idx < $argc; $idx++) {
    $email = trim((string) $argv[$idx]);
    if (!Email::validate($email)) {
        echo "[ERR] email " . $email . " invalide\n";
        continue;
    }

    echo $email . " : ";
    if ($id_contact = Contact::getIdByEmail($email)) {
        echo "contact ? oui (" . $id_contact . ") - ";
        if ($pseudo = Membre::getPseudoById($id_contact)) {
            echo "membre ? oui (" . $pseudo . ") - ";
            $membre = Membre::getInstance($id_contact);
            if ($membre->getMailing()) {
                echo "déjà inscrit";
            } else {
                $membre->setMailing(true)
                    ->save();
                echo "réinscription OK";
            }
        } else {
            echo "membre ? non - donc déja inscrit";
        }
    } else {
        echo "contact ? non - ";
        $id = (new Contact())
            ->setEmail($email)
            ->save();
        echo "création du contact OK (" . $id . ")";
    }
    echo "\n";
}
