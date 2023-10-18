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
     * @var object
     */
    protected static $_instance = null;

    /**
     * @var string
     */
    protected static string $_pk = 'id_alerting';

    /**
     * @var string
     */
    protected static string $_table = 'adhoc_alerting';

    /**
     * @var int
     */
    protected int $_id_alerting = 0;

    /**
     * Identifiant membre
     *
     * @var int
     */
    protected int $_id_contact = 0;

    /**
     * Date de création
     *
     * @var ?string
     */
    protected ?string $_created_at = null;

    /**
     * Actif ?
     *
     * @var bool
     */
    protected bool $_active = false;

    /**
     * @var int|null
     */
    protected ?int $_id_lieu = null;

    /**
     * @var int|null
     */
    protected ?int $_id_groupe = null;

    /**
     * @var int|null
     */
    protected ?int $_id_event = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static $_all_fields = [
        'id_alerting' => 'int', // pk
        'id_contact'  => 'int',
        'created_at'  => 'date',
        'active'      => 'bool',
        'id_lieu'     => 'int',
        'id_groupe'   => 'int',
        'id_event'    => 'int',
    ];

    /* début getters */

    /**
     * @return int
     */
    public function getIdAlerting(): int
    {
        return $this->_id_alerting;
    }

    /**
     * @return int
     */
    public function getIdContact(): int
    {
        return $this->_id_contact;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        if (!is_null($this->_created_at) && Date::isDateTimeOk($this->_created_at)) {
            return $this->_created_at;
        }
        return null;
    }

    /**
     * @return int|null
     */
    public function getCreatedAtTs(): ?int
    {
        if (!is_null($this->_created_at) && Date::isDateTimeOk($this->_created_at)) {
            return strtotime($this->_created_at);
        }
        return null;
    }

    /**
     * @return bool
     */
    public function getActive(): bool
    {
        return $this->_active;
    }

    /**
     * @return int|null
     */
    public function getIdLieu(): ?int
    {
        return $this->_id_lieu;
    }

    /**
     * @return int|null
     */
    public function getIdGroupe(): ?int
    {
        return $this->_id_groupe;
    }

    /**
     * @return int|null
     */
    public function getIdEvent(): ?int
    {
        return $this->_id_event;
    }

    /* fin getters */

    /* début setters */

    /**
     * @param int $id_contact id_contact
     *
     * @return object
     */
    public function setIdContact(int $id_contact): object
    {
        if ($this->_id_contact !== $id_contact) {
            $this->_id_contact = $id_contact;
            $this->_modified_fields['id_contact'] = true;
        }

        return $this;
    }

    /**
     * @param string $created_at created_at
     *
     * @return object
     */
    public function setCreatedAt(string $created_at): object
    {
        if ($this->_created_at !== $created_at) {
            $this->_created_at = $created_at;
            $this->_modified_fields['created_at'] = true;
        }

        return $this;
    }

    /**
     * @param bool $active active
     *
     * @return object
     */
    public function setActive(bool $active): object
    {
        if ($this->_active !== $active) {
            $this->_active = $active;
            $this->_modified_fields['active'] = true;
        }

        return $this;
    }

    /**
     * @param int $id_lieu id_lieu
     *
     * @return object
     */
    public function setIdLieu(int $id_lieu = null): object
    {
        if ($this->_id_lieu !== $id_lieu) {
            $this->_id_lieu = $id_lieu;
            $this->_modified_fields['id_lieu'] = true;
        }

        return $this;
    }

    /**
     * @param int $id_groupe id_groupe
     *
     * @return object
     */
    public function setIdGroupe(int $id_groupe = null): object
    {
        if ($this->_id_groupe !== $id_groupe) {
            $this->_id_groupe = $id_groupe;
            $this->_modified_fields['id_groupe'] = true;
        }

        return $this;
    }

    /**
     * @param int $id_event id_event
     *
     * @return object
     */
    public function setIdEvent(int $id_event = null): object
    {
        if ($this->_id_event !== $id_event) {
            $this->_id_event = $id_event;
            $this->_modified_fields['id_event'] = true;
        }

        return $this;
    }

    /* fin setters */

    /**
     * Défini la date de modification
     *
     * @return object
     */
    public function setCreatedNow(): object
    {
        $now = date('Y-m-d H:i:s');

        if ($this->_created_at !== $now) {
            $this->_created_at = $now;
            $this->_modified_fields['created_at'] = true;
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
    public static function addSubscriber(int $id_contact, string $type, int $id_content): bool
    {
        return false;
    }

    /**
     * @param int    $id_contact id_contact
     * @param string $type       type
     * @param int    $id_content id_content
     *
     * @return bool
     */
    public static function delSubscriber(int $id_contact, string $type, int $id_content): bool
    {
        return false;
    }

    /**
     * @param array $params [
     *                      'id_contact' => int,
     *                      'id_lieu' => int,
     *                      'id_groupe' => int,
     *                      'id_event' => int,
     *                      'order_by' => string,
     *                      'sort' => string,
     *                      'start' => int,
     *                      'limit' => int,
     *                      ]
     *
     * @return array
     */
    public static function find(array $params): array
    {
        $db = DataBase::getInstance();
        $objs = [];

        $sql = "SELECT `" . static::getDbPk() . "` FROM `" . static::getDbTable() . "` WHERE 1 ";

        if (isset($params['id_contact'])) {
            $sql .= "AND `id_contact` = " . (int) $params['id_contact'] . " ";
        }

        if (isset($params['id_lieu'])) {
            $sql .= "AND `id_lieu` = " . (int) $params['id_lieu'] . " ";
        }

        if (isset($params['id_groupe'])) {
            $sql .= "AND `id_groupe` = " . (int) $params['id_groupe'] . " ";
        }

        if (isset($params['id_event'])) {
            $sql .= "AND `id_event` = " . (int) $params['id_event'] . " ";
        }

        if ((isset($params['order_by']) && (in_array($params['order_by'], array_keys(static::$_all_fields))))) {
            $sql .= "ORDER BY `" . $params['order_by'] . "` ";
        } else {
            $sql .= "ORDER BY `" . static::getDbPk() . "` ";
        }

        if ((isset($params['sort']) && (in_array($params['sort'], ['ASC', 'DESC'])))) {
            $sql .= $params['sort'] . " ";
        } else {
            $sql .= "ASC ";
        }

        if (!isset($params['start'])) {
            $params['start'] = 0;
        }

        if (isset($params['limit'])) {
            $sql .= "LIMIT " . (int) $params['start'] . ", " . (int) $params['limit'];
        }

        $ids = $db->queryWithFetchFirstFields($sql);
        foreach ($ids as $id) {
            $objs[] = static::getInstance((int) $id);
        }

        return $objs;
    }
}
