<?php declare(strict_types=1);

/**
 * Classe WorldRegion
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class WorldRegion extends Reference
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
    protected static $_pk = ['id_country', 'id_region'];

    /**
     * @var string
     */
    protected static $_table = 'geo_world_region';

    /**
     * @var string
     */
    protected $_id_country = null;

    /**
     * @var string
     */
    protected $_id_region = null;

    /**
     * @var string
     */
    protected $_name = null;

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
        'id_country' => 'string',
        'id_region'  => 'string',
        'name'       => 'string',
    ];

    /**
     * Tableau des attributs modifiés depuis la dernière sauvegarde.
     *
     * Pour chaque attribut modifié, on a un élément de la forme 'attribut => true'.
     *
     * @var array
     */
    protected $_modified_fields = [];

    /* début getters */

    /**
     * @return string
     */
    function getIdCountry(): string
    {
        return $this->_id_country;
    }

    /**
     * @return string
     */
    function getIdRegion(): string
    {
        return $this->_id_region;
    }

    /**
     * @return string
     */
    function getName(): string
    {
        return $this->_name;
    }

    /* fin getters */

    /* début setters */

    /* fin setters */

    /**
     * Charge toutes les infos d'une entité
     *
     * @return bool
     * @throws Exception
     */
    protected function _loadFromDb(): bool
    {
        $db = DataBase::getInstance();

        $sql = "SELECT * FROM `" . static::$_table . "` WHERE 1";
        foreach (static::$_pk as $fieldName) {
            $propName = '_' . $fieldName;
            $sql .= " AND `${fieldName}` = '" . $this->$propName . "'";
        }

        if ($res = $db->queryWithFetchFirstRow($sql)) {
            $this->_dbToObject($res);
            return true;
        }
        throw new Exception('WorldRegion introuvable');
    }
}
