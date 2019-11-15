<?php declare(strict_types=1);

namespace Reference;

/**
 * Classe Departement
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Departement extends \Reference
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
    protected static $_pk = 'id_departement';

    /**
     * @var string
     */
    protected static $_table = 'geo_fr_departement';

    /**
     * @var string
     */
    protected $_id_departement = null;

    /**
     * @var string
     */
    protected $_id_region = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array
     */
    protected static $_all_fields = [
        'id_departement' => 'string', // pk
        'id_region'      => 'string',
        'name'           => 'string',
    ];

    /* début getters */

    /**
     * @return string|null
     */
    function getIdDepartement(): ?string
    {
        return $this->_id_departement;
    }

    /**
     * @return string|null
     */
    function getIdRegion(): ?string
    {
        return $this->_id_region;
    }

    /* fin getters */

    /* début setters */

    // à implémenter

    /* fin setters */
}
