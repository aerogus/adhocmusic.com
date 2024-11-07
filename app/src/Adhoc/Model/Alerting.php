<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Utils\DataBase;
use Adhoc\Utils\Date;
use Adhoc\Utils\ObjectModel;

/**
 * Classe Alerting
 *
 * Classe des alertes mails groupes/lieux
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class Alerting extends ObjectModel
{
    /**
     * @var array<string>
     */
    protected static array $pk = [
        'id_alerting',
    ];

    /**
     * @var string
     */
    protected static string $table = 'adhoc_alerting';

    /**
     * @var ?int
     */
    protected ?int $id_alerting = null;

    /**
     * Identifiant membre
     *
     * @var ?int
     */
    protected ?int $id_contact = null;

    /**
     * Date de création
     *
     * @var ?string
     */
    protected ?string $created_at = null;

    /**
     * Actif ?
     *
     * @var ?bool
     */
    protected ?bool $active = null;

    /**
     * @var ?int
     */
    protected ?int $id_lieu = null;

    /**
     * @var ?int
     */
    protected ?int $id_groupe = null;

    /**
     * @var ?int
     */
    protected ?int $id_event = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
        'id_alerting' => 'int', // pk
        'id_contact' => 'int',
        'created_at' => 'date',
        'active' => 'bool',
        'id_lieu' => 'int',
        'id_groupe' => 'int',
        'id_event' => 'int',
    ];

    /* début getters */

    /**
     * @return ?int
     */
    public function getIdAlerting(): ?int
    {
        return $this->id_alerting;
    }

    /**
     * @return ?int
     */
    public function getIdContact(): ?int
    {
        return $this->id_contact;
    }

    /**
     * @return ?string
     */
    public function getCreatedAt(): ?string
    {
        if (!is_null($this->created_at) && Date::isDateTimeOk($this->created_at)) {
            return $this->created_at;
        }
        return null;
    }

    /**
     * @return ?int
     */
    public function getCreatedAtTs(): ?int
    {
        if (!is_null($this->created_at) && Date::isDateTimeOk($this->created_at)) {
            return strtotime($this->created_at);
        }
        return null;
    }

    /**
     * @return ?bool
     */
    public function getActive(): ?bool
    {
        return $this->active;
    }

    /**
     * @return ?int
     */
    public function getIdLieu(): ?int
    {
        return $this->id_lieu;
    }

    /**
     * @return ?int
     */
    public function getIdGroupe(): ?int
    {
        return $this->id_groupe;
    }

    /**
     * @return ?int
     */
    public function getIdEvent(): ?int
    {
        return $this->id_event;
    }

    /* fin getters */

    /* début setters */

    /**
     * @param int $id_contact id_contact
     *
     * @return static
     */
    public function setIdContact(int $id_contact): static
    {
        if ($this->id_contact !== $id_contact) {
            $this->id_contact = $id_contact;
            $this->modified_fields['id_contact'] = true;
        }

        return $this;
    }

    /**
     * @param string $created_at created_at
     *
     * @return static
     */
    public function setCreatedAt(string $created_at): static
    {
        if ($this->created_at !== $created_at) {
            $this->created_at = $created_at;
            $this->modified_fields['created_at'] = true;
        }

        return $this;
    }

    /**
     * @param bool $active active
     *
     * @return static
     */
    public function setActive(bool $active): static
    {
        if ($this->active !== $active) {
            $this->active = $active;
            $this->modified_fields['active'] = true;
        }

        return $this;
    }

    /**
     * @param int $id_lieu id_lieu
     *
     * @return static
     */
    public function setIdLieu(int $id_lieu = null): static
    {
        if ($this->id_lieu !== $id_lieu) {
            $this->id_lieu = $id_lieu;
            $this->modified_fields['id_lieu'] = true;
        }

        return $this;
    }

    /**
     * @param int $id_groupe id_groupe
     *
     * @return static
     */
    public function setIdGroupe(int $id_groupe = null): static
    {
        if ($this->id_groupe !== $id_groupe) {
            $this->id_groupe = $id_groupe;
            $this->modified_fields['id_groupe'] = true;
        }

        return $this;
    }

    /**
     * @param int $id_event id_event
     *
     * @return static
     */
    public function setIdEvent(int $id_event = null): static
    {
        if ($this->id_event !== $id_event) {
            $this->id_event = $id_event;
            $this->modified_fields['id_event'] = true;
        }

        return $this;
    }

    /* fin setters */

    /**
     * Défini la date de modification
     *
     * @return static
     */
    public function setCreatedNow(): static
    {
        $now = date('Y-m-d H:i:s');

        if ($this->created_at !== $now) {
            $this->created_at = $now;
            $this->modified_fields['created_at'] = true;
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
     * @param array<string,mixed> $params [
     *                                'id_contact' => int,
     *                                'id_lieu' => int,
     *                                'id_groupe' => int,
     *                                'id_event' => int,
     *                                'order_by' => string,
     *                                'sort' => string,
     *                                'start' => int,
     *                                'limit' => int,
     *                            ]
     *
     * @return array<static>
     */
    public static function find(array $params): array
    {
        $db = DataBase::getInstance();
        $objs = [];

        $sql  = "SELECT ";

        $pks = array_map(
            function ($item) {
                return '`' . $item . '`';
            },
            static::getDbPk()
        );
        $sql .= implode(', ', $pks) . ' ';

        $sql .= "FROM `" . static::getDbTable() . "` ";
        $sql .= "WHERE 1 ";

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

        if ((isset($params['order_by']) && (in_array($params['order_by'], array_keys(static::$all_fields), true)))) {
            $sql .= "ORDER BY `" . $params['order_by'] . "` ";
        } else {
            $sql .= "ORDER BY `" . static::getDbPk() . "` ";
        }

        if ((isset($params['sort']) && (in_array($params['sort'], ['ASC', 'DESC'], true)))) {
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

        $ids = $db->pdo->query($sql)->fetchAll(\PDO::FETCH_COLUMN);
        foreach ($ids as $id) {
            $objs[] = static::getInstance((int) $id);
        }

        return $objs;
    }
}
