<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Utils\ObjectModel;

/**
 * Classe EventStructure
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class EventStructure extends ObjectModel
{
    /**
     * @var array<string>
     */
    protected static array $pk = [
        'id_event',
        'id_structure',
    ];

    /**
     * @var string
     */
    protected static string $table = 'adhoc_event_structure'; // ex adhoc_organise_par
}
