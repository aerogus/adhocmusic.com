<?php declare(strict_types=1);

namespace Reference;

use Reference;

/**
 * Classe de gestion des types de photos
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class PhotoType extends Reference
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
    protected static string $_pk = 'id_photo_type';

    /**
     * @var string
     */
    protected static string $_table = 'adhoc_photo_type';

    /**
     * @var int
     */
    protected int $_id_photo_type = 0;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static $_all_fields = [
        'id_photo_type' => 'int', // pk
        'name'          => 'string',
    ];
}
