#!/usr/bin/env php
<?php declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

/**
 * Abonne des emails à la newsletter
 *
 * @param string $argv[1] email(s) à inscrire séparés par une virgule
 */

if (empty($argv[1])) {
    echo "Usage: newsletter-sub.php email1,email2,email3,...\n";
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
        $id = Contact::init()
            ->setEmail($email)
            ->save();
        echo "création du contact OK (" . $id . ")";
    }
    echo "\n";
}

