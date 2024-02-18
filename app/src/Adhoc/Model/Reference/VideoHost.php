<?php

declare(strict_types=1);

namespace Adhoc\Model\Reference;

use Adhoc\Model\Reference;

/**
 * Classe VideoHost
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class VideoHost extends Reference
{
    /**
     * @var string|array<string>
     */
    protected static string|array $pk = 'id_video_host';

    /**
     * @var string
     */
    protected static string $table = 'adhoc_video_host';

    /**
     * @var int
     */
    protected int $id_video_host = 0;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
        'id_video_host' => 'int', // pk
        'name' => 'string',
    ];
}
