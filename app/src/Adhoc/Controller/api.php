<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\Membre;
use Adhoc\Utils\Route;

final class Controller
{
    /**
     * @return array<mixed>
     */
    public static function membres(): array
    {
        $membres = Membre::findAll();

        $mbrs = [];
        foreach ($membres as $membre) {
            $mbr = [
                'id_contact' => $membre->getIdContact(),
                'last_name' => $membre->getLastName(),
                'first_name' => $membre->getFirstName(),
            ];
            $mbrs[] = $mbr;
        }

        return $mbrs;
    }
}
