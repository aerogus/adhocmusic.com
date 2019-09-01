<?php

/**
 * Classe Alerting
 *
 * Classe des alertes mails groupes/lieux
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Alerting extends ObjectModel
{
    /**
     * @var object
     */
    protected static $_instance = null;

    /**
     * @var string
     */
    protected static $_pk = 'id_alerting';

    /**
     * @var string
     */
    protected static $_table = 'adhoc_alerting';

    /**
     * @var int
     */
    protected $_id_alerting = 0;

    /**
     * Identifiant membre
     *
     * @var int
     */
    protected $_id_contact = 0;

    /**
     * Date de création
     *
     * @var string
     */
    protected $_created_on = NULL;

    /**
     * actif ?
     *
     * @var bool
     */
    protected $_active = false;

    /**
     * Type (g: groupe / l:lieu)
     *
     * @var string
     */
    protected $_type = '';

    /**
     * id_groupe ou id_lieu
     *
     * @var int
     */
    protected $_id_content = 0;

    /**
     * Liste des attributs de l'objet
     * on précise si en base c'est de type :
     * - numérique/integer/float/bool (= num)
     * - datetime/text (= str)
     * - booléen (= bool)
     * ceci est utile pour la formation de la requête
     * @var array
     */
    protected static $_all_fields = [
        'id_contact'  => 'num',
        'created_on'  => 'date',
        'active'      => 'bool',
        'type'        => 'str',
        'id_content'  => 'num',
    ];

    /**
     * Tableau des attributs modifiés depuis la dernière sauvegarde.
     *
     * Pour chaque attribut modifié, on a un élément de la forme 'attribut => true'.
     * @var array
     */
    protected $_modified_fields = [];

    /* début getters */

    /**
     * @return int
     */
    function getIdContact()
    {
        return (int) $this->_id_contact;
    }

    /**
     * @return string
     */
    function getCreatedOn()
    {
        if (Date::isDateTimeOk($this->_created_on)) {
            return (string) $this->_created_on;
        }
        return false;
    }

    /**
     * @return int
     */
    function getCreatedOnTs()
    {
        if (Date::isDateTimeOk($this->_created_on)) {
            return (int) strtotime($this->_created_on);
        }
        return false;
    }

    /**
     * @return bool
     */
    function getActive()
    {
        return (int) $this->_active;
    }

    /**
     * @return string
     */
    function getType()
    {
        return (string) $this->_type;
    }

    /**
     * @return int
     */
    function getIdContent()
    {
        return (int) $this->_id_content;
    }

    /* fin getters */

    /* début setters */

    /**
     * @param int $val
     */
    function setIdContact(int $val)
    {
        if ($this->_id_contact !== $val) {
            $this->_id_contact = $val;
            $this->_modified_fields['id_contact'] = true;
        }
    }

    /**
     * @param string $val
     */
    function setCreatedOn(string $val)
    {
        if ($this->_created_on !== $val) {
            $this->_created_on = $val;
            $this->_modified_fields['created_on'] = true;
        }
    }

    /**
     * @param bool
     */
    function setActive(bool $val)
    {
        if ($this->_active !== $val) {
            $this->_active = $val;
            $this->_modified_fields['active'] = true;
        }
    }

    /**
     * @param string
     */
    function setType(string $val)
    {
        if ($this->_type !== $val) {
            $this->_type = $val;
            $this->_modified_fields['type'] = true;
        }
    }

    /**
     * @param int
     */
    function setIdContent(int $val)
    {
        if ($this->_id_content !== $val) {
            $this->_id_content = $val;
            $this->_modified_fields['id_content'] = true;
        }
    }

    /* fin setters */

    /**
     * Défini la date de modification
     */
    function setCreatedNow()
    {
        $now = date('Y-m-d H:i:s');

        if ($this->_created_on !== $now) {
            $this->_created_on = $now;
            $this->_modified_fields['created_on'] = true;
        }
    }

    /**
     *
     */
    static function addSubscriber(int $id_contact, string $type, int $id_content)
    {
        if (self::getIdByIds($id_contact, $type, $id_content)) {
            return false;
        }

        $a = Alerting::init();
        $a->setIdContact($id_contact);
        $a->setCreatedNow();
        $a->setType($type);
        $a->setActive(true);
        $a->setIdContent($id_content);

        if ($a->save()) {
             return true;
        }

        return false;
    }

    static function delSubscriber(int $id_contact, string $type, int $id_content)
    {
        if (!self::getIdByIds($id_contact, $type, $id_content)) {
            return false;
        }

        if ($id_alerting = Alerting::getIdByIds($id_contact, $type, $id_content)) {
            $a = Alerting::getInstance($id_alerting);
            if ($a->delete()) {
                return true;
            }
        }

        return false;
    }

    static function getIdByIds(int $id_contact, string $type, int $id_content)
    {
         $db = DataBase::getInstance();

        $sql = "SELECT `id_alerting` "
             . "FROM `adhoc_alerting` "
             . "WHERE `id_contact` = " . (int) $id_contact . " "
             . "AND `type` = '" . $db->escape($type) . "' "
             . "AND `id_content` = " . (int) $id_content;

        return (int) $db->queryWithFetchFirstField($sql);
    }

    static function getLieuxAlertingByIdContact(int $id_contact)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `a`.*, `l`.`id_lieu`, `l`.`name` "
             . "FROM `adhoc_alerting` `a`, `adhoc_lieu` `l` "
             . "WHERE `a`.`id_contact` = " . (int) $id_contact . " "
             . "AND `a`.`id_content` = `l`.`id_lieu` "
             . "AND `a`.`type` = 'l'";

        return $db->queryWithFetch($sql);
    }

    static function getIdsContactByLieu($id_lieu)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `a`.*, `l`.`id_lieu`, `l`.`name` "
             . "FROM `adhoc_alerting` `a`, `adhoc_lieu` `l` "
             . "WHERE `a`.`id_content` = " . (int) $id_lieu . " "
             . "AND `a`.`id_content` = `l`.`id_lieu` "
             . "AND `a`.`type` = 'l'";

        return $db->queryWithFetch($sql);
    }

    static function getGroupesAlertingByIdContact($id_contact)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `a`.*, `g`.`id_groupe`, `g`.`name` "
             . "FROM `adhoc_alerting` `a`, `adhoc_groupe` `g` "
             . "WHERE `a`.`id_contact` = " . (int) $id_contact . " "
             . "AND `a`.`id_content` = `g`.`id_groupe` "
             . "AND `a`.`type` = 'g'";

        return $db->queryWithFetch($sql);
    }

    static function getIdsContactByGroupe($id_groupe)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `a`.*, `g`.`id_groupe`, `g`.`name` "
             . "FROM `adhoc_alerting` `a`, `adhoc_groupe` `g` "
             . "WHERE `a`.`id_content` = " . (int) $id_groupe . " "
             . "AND `a`.`id_content` = `g`.`id_groupe` "
             . "AND `a`.`type` = 'g'";

        return $db->queryWithFetch($sql);
    }

    static function getEventsAlertingByIdContact($id_contact)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `a`.*, `e`.`id_event`, `e`.`name` "
             . "FROM `adhoc_alerting` `a`, `adhoc_event` `e` "
             . "WHERE `a`.`id_contact` = " . (int) $id_contact . " "
             . "AND `a`.`id_content` = `e`.`id_event` "
             . "AND `a`.`type` = 'e'";

        return $db->queryWithFetch($sql);
    }

    static function getIdsContactByEvent($id_event)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `a`.*, `e`.`id_event`, `e`.`name` "
             . "FROM `adhoc_alerting` `a`, `adhoc_event` `e` "
             . "WHERE `a`.`id_content` = " . (int) $id_event . " "
             . "AND `a`.`id_content` = `e`.`id_event` "
             . "AND `a`.`type` = 'e'";

        return $db->queryWithFetch($sql);
    }

    /**
     * Charge une alerte
     */
    protected function _loadFromDb()
    {
        $db  = DataBase::getInstance();

        $sql = "SELECT * "
             . "FROM `" . self::$_table . "` "
             . "WHERE `id_alerting` = " . (int) $this->getId();

        if ($res = $db->queryWithFetchFirstRow($sql)) {
            $this->_dbToObject($res);
            return true;
        }

        throw new Exception('Alerting introuvable');
    }
}
