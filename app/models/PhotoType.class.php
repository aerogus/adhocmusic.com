<?php declare(strict_types=1);

/**
 * Classe de gestion des types de photos
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class PhotoType extends Reference
{
    /**
     * @var object
     */
    protected static $_instance = null;

    /**
     * @var string
     */
    protected static $_pk = 'id_photo_type';

    /**
     * @var string
     */
    protected static $_table = 'adhoc_photo_type';

    /**
     * @var int
     */
    protected $_id_photo_type = 0;

    /**
     * Liste des attributs de l'objet
     *
     * @var array
     */
    protected static $_all_fields = [
        'id_photo_type' => 'int', // pk
        'name'          => 'string',
    ];
}
