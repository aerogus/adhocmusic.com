<?php

declare(strict_types=1);

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
    protected static $instance = null;

    /**
     * @var string|array<string>
     */
    protected static string|array $pk = 'id_photo_type';

    /**
     * @var string
     */
    protected static string $table = 'adhoc_photo_type';

    /**
     * @var int
     */
    protected int $id_photo_type = 0;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
        'id_photo_type' => 'int', // pk
        'name'          => 'string',
    ];
}
