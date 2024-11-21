<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Utils\ObjectModel;

/**
 * Classe GroupeMembre
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class GroupeMembre extends ObjectModel
{
    /**
     * @var array<string>
     */
    protected static array $pk = [
        'id_contact',
        'id_groupe',
        'id_type_musicien',
    ];

    /**
     * @var string
     */
    protected static string $table = 'adhoc_groupe_membre'; // ex adhoc_appartient_a
}
