<?php declare(strict_types=1);

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
    protected static $_instance = null;

    /**
     * @var string
     */
    protected static string $_pk = 'id_video_host';

    /**
     * @var string
     */
    protected static string $_table = 'adhoc_video_host';

    /**
     * @var int
     */
    protected int $_id_video_host = 0;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static $_all_fields = [
        'id_video_host' => 'int', // pk
        'name'          => 'string',
    ];
}