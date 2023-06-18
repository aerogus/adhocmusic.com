<?php declare(strict_types=1);

namespace Reference;

/**
 * Classe de gestion des états de groupes
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class GroupeStatus extends \Reference
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
    protected static $_pk = 'id_groupe_status';

    /**
     * @var string
     */
    protected static $_table = 'adhoc_groupe_status';

    /**
     * @var int
     */
    protected $_id_groupe_status = 0;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static $_all_fields = [
        'id_groupe_status' => 'int', // pk
        'name'             => 'string',
    ];
}
