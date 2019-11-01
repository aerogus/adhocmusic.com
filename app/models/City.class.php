<?php declare(strict_types=1);

/**
 * Classe City
 * (villes de France uniquement)
 * pk = code insee
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class City extends Reference
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

    /* début getter */

    /**
     * @return string
     */
    function getIdDepartement()
    {
        return $this->_id_department;
    }

    /**
     * @return string
     */
    function getCp()
    {
        return $this->_cp;
    }

    /* fin getters */

    /* début setters */

    /* fin setters */
}
