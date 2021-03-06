<?php declare(strict_types=1);

namespace Reference;

/**
 * Classe de gestion des types de musiciens
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class TypeMusicien extends \Reference
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
    protected static $_pk = 'id_type_musicien';

    /**
     * @var string
     */
    protected static $_table = 'adhoc_type_musicien';

    /**
     * @var int
     */
    protected $_id_type_musicien = 0;

    /**
     * Liste des attributs de l'objet
     *
     * @var array
     */
    protected static $_all_fields = [
        'id_type_musicien' => 'int', // pk
        'name'             => 'string',
    ];
}
