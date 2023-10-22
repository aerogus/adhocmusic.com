<?php

declare(strict_types=1);

namespace Reference;

use Reference;

/**
 * Classe VideoHost
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class VideoHost extends Reference
{
    /**
     * Instance de l'objet
     *
     * @var object
     */
    protected static $instance = null;

    /**
     * @var string
     */
    protected static string $pk = 'id_video_host';

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
