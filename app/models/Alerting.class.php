<?php declare(strict_types=1);

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
     * Instance de l'objet
     *
     * @var mixed
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
    protected $_created_on = null;

    /**
     * Actif ?
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
     *
     * @var array
     */
    protected static $_all_fields = [
        'id_alerting' => 'int', // pk
        'id_contact'  => 'int',
        'created_on'  => 'date',
        'active'      => 'bool',
        'type'        => 'string',
        'id_content'  => 'int',
    ];

    /* début getters */

    /**
     * @return int
     */
    function getIdAlerting(): int
    {
        return $this->_id_alerting;
    }

    /**
     * @return int
     */
    function getIdContact(): int
    {
        return $this->_id_contact;
    }

    /**
     * @return string|null
     */
    function getCreatedOn(): ?string
    {
        if (!is_null($this->_created_on) && Date::isDateTimeOk($this->_created_on)) {
            return $this->_created_on;
        }
        return null;
    }

    /**
     * @return int|null
     */
    function getCreatedOnTs(): ?int
    {
        if (!is_null($this->_created_on) && Date::isDateTimeOk($this->_created_on)) {
            return strtotime($this->_created_on);
        }
        return null;
    }

    /**
     * @return bool
     */
    function getActive(): bool
    {
        return $this->_active;
    }

    /**
     * @return string
     */
    function getType(): string
    {
        return $this->_type;
    }

    /**
     * @return int
     */
    function getIdContent(): int
    {
        return $this->_id_content;
    }

    /* fin getters */

    /* début setters */

    /**
     * @param int $id_contact id_contact
     *
     * @return object
     */
    function setIdContact(int $id_contact): object
    {
        if ($this->_id_contact !== $id_contact) {
            $this->_id_contact = $id_contact;
            $this->_modified_fields['id_contact'] = true;
        }

        return $this;
    }

    /**
     * @param string $created_on created_on
     *
     * @return object
     */
    function setCreatedOn(string $created_on): object
    {
        if ($this->_created_on !== $created_on) {
            $this->_created_on = $created_on;
            $this->_modified_fields['created_on'] = true;
        }

        return $this;
    }

    /**
     * @param bool $active active
     *
     * @return object
     */
    function setActive(bool $active): object
    {
        if ($this->_active !== $active) {
            $this->_active = $active;
            $this->_modified_fields['active'] = true;
        }

        return $this;
    }

    /**
     * @param string $type type
     *
     * @return object
     */
    function setType(string $type): object
    {
        if ($this->_type !== $type) {
            $this->_type = $type;
            $this->_modified_fields['type'] = true;
        }

        return $this;
    }

    /**
     * @param int $id_content id_content
     *
     * @return object
     */
    function setIdContent(int $id_content): object
    {
        if ($this->_id_content !== $id_content) {
            $this->_id_content = $id_content;
            $this->_modified_fields['id_content'] = true;
        }

        return $this;
    }

    /* fin setters */

    /**
     * Défini la date de modification
     *
     * @return object
     */
    function setCreatedNow(): object
    {
        $now = date('Y-m-d H:i:s');

        if ($this->_created_on !== $now) {
            $this->_created_on = $now;
            $this->_modified_fields['created_on'] = true;
        }

        return $this;
    }

    /**
     * @param int    $id_contact id_contact
     * @param string $type       type
     * @param int    $id_content id_content
     *
     * @return bool
     */
    static function addSubscriber(int $id_contact, string $type, int $id_content): bool
    {
        if (self::getIdByIds($id_contact, $type, $id_content)) {
            return false;
        }

        $a = (new Alerting())
            ->setIdContact($id_contact)
            ->setCreatedNow()
            ->setType($type)
            ->setActive(true)
            ->setIdContent($id_content);

        if ($a->save()) {
             return true;
        }

        return false;
    }

    /**
     * @param int    $id_contact id_contact
     * @param string $type       type
     * @param int    $id_content id_content
     *
     * @return bool
     */
    static function delSubscriber(int $id_contact, string $type, int $id_content): bool
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

    /**
     * @param int    $id_contact id_contact
     * @param string $type       type
     * @param int    $id_content id_content
     *
     * @return int
     */
    static function getIdByIds(int $id_contact, string $type, int $id_content): int
    {
         $db = DataBase::getInstance();

        $sql = "SELECT `id_alerting` "
             . "FROM `adhoc_alerting` "
             . "WHERE `id_contact` = " . (int) $id_contact . " "
             . "AND `type` = '" . $db->escape($type) . "' "
             . "AND `id_content` = " . (int) $id_content;

        return (int) $db->queryWithFetchFirstField($sql);
    }

    /**
     * @param int $id_contact id_contact
     *
     * @return array
     */
    static function getLieuxAlertingByIdContact(int $id_contact): array
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `a`.*, `l`.`id_lieu`, `l`.`name` "
             . "FROM `adhoc_alerting` `a`, `adhoc_lieu` `l` "
             . "WHERE `a`.`id_contact` = " . (int) $id_contact . " "
             . "AND `a`.`id_content` = `l`.`id_lieu` "
             . "AND `a`.`type` = 'l'";

        return $db->queryWithFetch($sql);
    }

    /**
     * @param int $id_lieu id_lieu
     *
     * @return array
     */
    static function getIdsContactByLieu(int $id_lieu): array
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `a`.*, `l`.`id_lieu`, `l`.`name` "
             . "FROM `adhoc_alerting` `a`, `adhoc_lieu` `l` "
             . "WHERE `a`.`id_content` = " . (int) $id_lieu . " "
             . "AND `a`.`id_content` = `l`.`id_lieu` "
             . "AND `a`.`type` = 'l'";

        return $db->queryWithFetch($sql);
    }

    /**
     * @param int $id_contact id_contact
     *
     * @return array
     */
    static function getGroupesAlertingByIdContact(int $id_contact): array
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `a`.*, `g`.`id_groupe`, `g`.`name` "
             . "FROM `adhoc_alerting` `a`, `adhoc_groupe` `g` "
             . "WHERE `a`.`id_contact` = " . (int) $id_contact . " "
             . "AND `a`.`id_content` = `g`.`id_groupe` "
             . "AND `a`.`type` = 'g'";

        return $db->queryWithFetch($sql);
    }

    /**
     * @param int $id_groupe id_groupe
     *
     * @return array
     */
    static function getIdsContactByGroupe(int $id_groupe): array
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `a`.*, `g`.`id_groupe`, `g`.`name` "
             . "FROM `adhoc_alerting` `a`, `adhoc_groupe` `g` "
             . "WHERE `a`.`id_content` = " . (int) $id_groupe . " "
             . "AND `a`.`id_content` = `g`.`id_groupe` "
             . "AND `a`.`type` = 'g'";

        return $db->queryWithFetch($sql);
    }

    /**
     * @param int $id_contact id_contact
     *
     * @return array
     */
    static function getEventsAlertingByIdContact(int $id_contact): array
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `a`.*, `e`.`id_event`, `e`.`name` "
             . "FROM `adhoc_alerting` `a`, `adhoc_event` `e` "
             . "WHERE `a`.`id_contact` = " . (int) $id_contact . " "
             . "AND `a`.`id_content` = `e`.`id_event` "
             . "AND `a`.`type` = 'e'";

        return $db->queryWithFetch($sql);
    }

    /**
     * @param int $id_event id_event
     *
     * @return array
     */
    static function getIdsContactByEvent(int $id_event): array
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `a`.*, `e`.`id_event`, `e`.`name` "
             . "FROM `adhoc_alerting` `a`, `adhoc_event` `e` "
             . "WHERE `a`.`id_content` = " . (int) $id_event . " "
             . "AND `a`.`id_content` = `e`.`id_event` "
             . "AND `a`.`type` = 'e'";

        return $db->queryWithFetch($sql);
    }
}
