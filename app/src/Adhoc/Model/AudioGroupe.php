<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Utils\ObjectModel;

/**
 * Classe AudioGroupe
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class AudioGroupe extends ObjectModel
{
    /**
     * @var array<string>
     */
    protected static array $pk = [
        'id_audio',
        'id_groupe',
    ];

    /**
     * @var string
     */
    protected static string $table = 'adhoc_audio_groupe';
}
