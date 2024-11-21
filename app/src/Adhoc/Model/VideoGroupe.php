<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Utils\ObjectModel;

/**
 * Classe VideoGroupe
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class VideoGroupe extends ObjectModel
{
    /**
     * @var array<string>
     */
    protected static array $pk = [
        'id_video',
        'id_groupe',
    ];

    /**
     * @var string
     */
    protected static string $table = 'adhoc_video_groupe';
}
