<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Utils\ObjectModel;

/**
 * Classe PhotoGroupe
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class PhotoGroupe extends ObjectModel
{
    /**
     * @var array<string>
     */
    protected static array $pk = [
        'id_photo',
        'id_groupe',
    ];

    /**
     * @var string
     */
    protected static string $table = 'adhoc_photo_groupe';
}
