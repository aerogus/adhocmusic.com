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

    /**
     * Liste des attributs de l'objet
     * on précise si en base c'est de type :
     * - numérique/integer/float/bool (= int)
     * - datetime/text (= str)
     * ceci est utile pour la formation de la requête
     *
     * @var array
     */
    protected static $_all_fields = [
        'id_city'        => 'int', // pk
        'id_departement' => 'string',
        'cp'             => 'int',
    ];

    /**
     * Tableau des attributs modifiés depuis la dernière sauvegarde.
     *
     * Pour chaque attribut modifié, on a un élément de la forme 'attribut => true'.
     *
     * @var array
     */
    protected $_modified_fields = [];

    /* début getter */

    /**
     * @return string
     */
    function getIdCity()
    {
        return $this->_id_city;
    }

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
