<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Utils\ObjectModel;

/**
 * Classe EventGroupe
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class EventGroupe extends ObjectModel
{
    /**
     * @var array<string>
     */
    protected static array $pk = [
        'id_event',
        'id_groupe',
    ];

    /**
     * @var string
     */
    protected static string $table = 'adhoc_event_groupe'; // ex adhoc_participe_a
}
