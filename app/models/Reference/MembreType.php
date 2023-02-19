<?php declare(strict_types=1);

namespace Reference;

/**
 * Classe MembreType
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class MembreType extends \Reference
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
    protected static $_pk = 'id_membre_type';

    /**
     * @var string
     */
    protected static $_table = 'adhoc_membre_type';

    /**
     * @var int
     */
    protected $_id_membre_type = 0;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static $_all_fields = [
        'id_membre_type' => 'int', // pk
        'name'           => 'string',
    ];
}
