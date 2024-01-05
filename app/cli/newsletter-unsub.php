#!/usr/bin/env php
<?php

declare(strict_types=1);

use Adhoc\Model\Contact;
use Adhoc\Model\Membre;
use Adhoc\Utils\Email;

require_once __DIR__ . '/../bootstrap.php';

/**
 * Désabonne des emails de la newsletter
 *
 * @param string $argv[] email(s) à désinscrire séparés par une espace
 */

if ($argc < 2) {
    echo "Usage: newsletter-unsub.php email1 email2 email3 ...\n";
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
                $membre->setMailing(false)
                    ->save();
                echo "désinscription OK";
            } else {
                echo "déja désinscrit";
            }
        } else {
            echo "membre ? non - ";
            Contact::getInstance($id_contact)
                ->delete();
            echo "delete du contact OK";
        }
    } else {
        echo "contact ? non - donc pas inscrit";
    }
    echo "\n";
}
