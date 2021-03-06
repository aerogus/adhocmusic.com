<?php declare(strict_types=1);

namespace Reference;

/**
 * Classe WorldCountry
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 *
 * @see http://en.wikipedia.org/wiki/ISO_3166-1_alpha-2
 */
class WorldCountry extends \Reference
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
    protected static $_pk = 'id_country';

    /**
     * @var string
     */
    protected static $_table = 'geo_world_country';

    /**
     * @var string
     */
    protected $_id_country = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array
     */
    protected static $_all_fields = [
        'id_country' => 'string',
        'name'       => 'string',
    ];

    /* début getters */

    /**
     * @return string
     */
    function getIdCountry(): string
    {
        return $this->_id_country;
    }

    /**
     * Retourne l'url de l'image du drapeau pays
     *
     * @return string
     */
    function getFlagUrl(): string
    {
        return MEDIA_URL . '/country/' . strtolower($this->_id_country) . '.png';
    }

    /* fin getters */

    /* début setters */

    /* fin setters */

    /**
     * Retourne une collection d'objets "WorldCountry" répondant au(x) critère(s)
     *
     * @param array $params [
     *                      'order_by' => string,
     *                      'sort' => string
     *                      'start' => int,
     *                      'limit' => int,
     *                      ]
     *
     * @return array
     */
    static function find(array $params): array
    {
        $db = DataBase::getInstance();
        $objs = [];

        $sql = "SELECT `" . static::getDbPk() . "` FROM `" . static::getDbTable() . "` WHERE 1 ";

        if ((isset($params['order_by']) && (in_array($params['order_by'], array_keys(static::$_all_fields))))) {
            $sql .= "ORDER BY `" . $params['order_by'] . "` ";
        } else {
            $sql .= "ORDER BY `" . static::$_pk . "` ";
        }

        if ((isset($params['sort']) && (in_array($params['sort'], ['ASC', 'DESC'])))) {
            $sql .= $params['sort'] . " ";
        } else {
            $sql .= "ASC ";
        }

        if (!isset($params['start'])) {
            $params['start'] = 0;
        }

        if (isset($params['start']) && isset($params['limit'])) {
            $sql .= "LIMIT " . (int) $params['start'] . ", " . (int) $params['limit'];
        }

        $ids = $db->queryWithFetchFirstFields($sql);
        foreach ($ids as $id) {
            $objs[] = static::getInstance((int) $id);
        }

        return $objs;
    }
}
