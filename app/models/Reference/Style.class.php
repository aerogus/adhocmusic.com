<?php declare(strict_types=1);

namespace Reference;

/**
 * Classe de gestion des styles musicaux
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Style extends \Reference
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
    protected static $_pk = 'id_style';

    /**
     * @var string
     */
    protected static $_table = 'adhoc_style';

    /**
     * @var int
     */
    protected $_id_style = 0;

    /**
     * Liste des attributs de l'objet
     *
     * @var array
     */
    protected static $_all_fields = [
        'id_style' => 'int', // pk
        'name'     => 'string',
    ];
}
