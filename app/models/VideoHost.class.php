<?php declare(strict_types=1);

class VideoHost extends Reference
{
    /**
     * @var object
     */
    protected static $_instance = null;

    /**
     * @var string
     */
    protected static $_pk = 'id_video_host';

    /**
     * @var string
     */
    protected static $_table = 'adhoc_video_host';

    /**
     * @var int
     */
    protected $_id_video_host = 0;

    /**
     * Liste des attributs de l'objet
     *
     * @var array
     */
    protected static $_all_fields = [
        'id_video_host' => 'int', // pk
        'name'          => 'string',
    ];
}