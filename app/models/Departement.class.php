<?php declare(strict_types=1);

/**
 * Classe Departement
 * /!\ dépend de la classe Region
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Departement extends Reference
{
    /**
     * Instance de l'objet
     *
     * @var mixed
     */
    protected static $_instance = null;

    /**
     * @var string
     */
    protected static $_pk = 'id_departement';

    /**
     * @var string
     */
    protected static $_table = 'geo_fr_departement';

    /**
     * @var int
     */
    protected $_id_departement = null;
}
