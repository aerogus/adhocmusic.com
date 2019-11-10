<?php declare(strict_types=1);

namespace Reference;

/**
 * Classe City
 * (villes de France uniquement)
 * pk = code insee
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class City extends \Reference
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
    protected static $_pk = 'id_city';

    /**
     * @var string
     */
    protected static $_table = 'geo_fr_city';

    /**
     * @var int
     */
    protected $_id_city = null;

    /**
     * @var string
     */
    protected $_id_departement = null;

    /**
     * @var string
     */
    protected $_cp = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array
     */
    protected static $_all_fields = [
        'id_city'        => 'int', // pk
        'id_departement' => 'string',
        'cp'             => 'string',
        'name'           => 'string',
    ];

    /* début getter */

    /**
     * @return string|null
     */
    function getIdCity(): ?string
    {
        return $this->_id_city;
    }

    /**
     * @return string|null
     */
    function getIdDepartement(): ?string
    {
        return $this->_id_department;
    }

    /**
     * @return string|null
     */
    function getCp(): ?string
    {
        return $this->_cp;
    }

    /* fin getters */

    /* début setters */

    // à implémenter

    /* fin setters */
}
