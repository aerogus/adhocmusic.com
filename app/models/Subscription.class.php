<?php declare(strict_types=1);

/**
 * Gestion des Cotisations
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Subscription extends ObjectModel
{
    /**
     * @var object
     */
    protected static $_instance = null;

    /**
     * @var string
     */
    protected static $_pk = 'id_subscription';

    /**
     * @var string
     */
    protected static $_table = 'adhoc_subscription';

    /**
     * @var int
     */
    protected $_id_subscription = 0;

    /**
     * @var string
     */
    protected $_first_name = '';

    /**
     * @var string
     */
    protected $_last_name = '';

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
        'first_name' => 'str',
        'last_name'  => 'str',
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
    function getFirstName(): string
    {
        return $this->_first_name;
    }

    /**
     * @return string
     */
    function getLastName(): string
    {
        return $this->_last_name;
    }

    /* fin getters */

    /* début setters */

    /**
     * @param string $val val
     *
     * @return mixed
     */
    function setFirstName(string $val)
    {
        if ($this->_first_name !== $val) {
            $this->_first_name = $val;
            $this->_modified_fields['first_name'] = true;
        }

        return $this;
    }

    /**
     * @param string $val val
     *
     * @return mixed
     */
    function setLastName(string $val)
    {
        if ($this->_last_name !== $val) {
            $this->_last_name = $val;
            $this->_modified_fields['last_name'] = true;
        }

        return $this;
    }

    /* fin setters */

    /**
     * Retourne les infos sur une structure
     *
     * @return array
     */
    function _loadFromDb()
    {
        $db = DataBase::getInstance();

        $sql  = "SELECT `first_name`, `last_name` "
              . "FROM `" . self::$_db_table_subscription . "` "
              . "WHERE `id_subscription` = " . (int) $this->_id_subscription;

        if ($res = $db->queryWithFetchFirstRow($sql)) {
            $this->_dbToObject($res);
            return true;
        }
        return false; // todo exception
    }

}
