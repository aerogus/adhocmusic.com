<?php declare(strict_types=1);

/**
 * Classe WorldCountry
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 *
 * @see http://en.wikipedia.org/wiki/ISO_3166-1_alpha-2
 */
class WorldCountry extends Reference
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
    protected static $_pk = 'id_country';

    /**
     * @var string
     */
    protected static $_table = 'geo_world_country';

    /**
     * @var string
     */
    protected $_id_country = null;
}
