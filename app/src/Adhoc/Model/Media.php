<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Utils\DataBase;
use Adhoc\Utils\Date;
use Adhoc\Utils\ObjectModel;

/**
 * Classe Media
 * parente de Audio, Video et Photo
 *
 * @abstract
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
abstract class Media extends ObjectModel
{
    /**
     * @var ?int
     */
    protected ?int $id_contact = null;

    /**
     * @var ?int
     */
    protected ?int $id_groupe = null;

    /**
     * @var ?int
     */
    protected ?int $id_lieu = null;

    /**
     * @var ?int
     */
    protected ?int $id_event = null;

    /**
     * @var string
     */
    protected string $name = '';

    /**
     * @var ?string
     */
    protected ?string $created_at = null;

    /**
     * @var ?string
     */
    protected ?string $modified_at = null;

    /**
     * @var bool
     */
    protected bool $online = false;

    /* début getters communs */

    /**
     * @return ?int
     */
    public function getIdContact(): ?int
    {
        return $this->id_contact;
    }

    /**
     * @return ?Contact
     */
    public function getContact(): ?Contact
    {
        if (is_null($this->getIdContact())) {
            return null;
        }

        try {
            return Contact::getInstance($this->getIdContact());
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @return ?Membre
     */
    public function getMembre(): ?Membre
    {
        if (is_null($this->getIdContact())) {
            return null;
        }

        try {
            return Membre::getInstance($this->getIdContact());
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @return ?int
     */
    public function getIdGroupe(): ?int
    {
        return $this->id_groupe;
    }

    /**
     * @return ?Groupe
     */
    public function getGroupe(): ?Groupe
    {
        if (is_null($this->getIdGroupe())) {
            return null;
        }

        try {
            return Groupe::getInstance($this->getIdGroupe());
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @return ?int
     */
    public function getIdLieu(): ?int
    {
        return $this->id_lieu;
    }

    /**
     * @return ?Lieu
     */
    public function getLieu(): ?Lieu
    {
        if (!is_null($this->getIdLieu())) {
            try {
                return Lieu::getInstance($this->getIdLieu());
            } catch (\Exception $e) {
                return null;
            }
        }
        return null;
    }

    /**
     * @return ?int
     */
    public function getIdEvent(): ?int
    {
        return $this->id_event;
    }

    /**
     * @return ?Event
     */
    public function getEvent(): ?Event
    {
        if (!is_null($this->getIdEvent())) {
            try {
                return Event::getInstance($this->getIdEvent());
            } catch (\Exception $e) {
                return null;
            }
        }
        return null;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return ?string
     */
    public function getCreatedAt()
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
     * @return ?string
     */
    public function getModifiedAt(): ?string
    {
        if (!is_null($this->modified_at) && Date::isDateTimeOk($this->modified_at)) {
            return $this->modified_at;
        }
        return null;
    }

    /**
     * @return ?int
     */
    public function getModifiedAtTs(): ?int
    {
        if (!is_null($this->modified_at) && Date::isDateTimeOk($this->modified_at)) {
            return strtotime($this->modified_at);
        }
        return null;
    }

    /**
     * @return bool
     */
    public function getOnline(): bool
    {
        return $this->online;
    }

    /* fin getters communs */

    /* début setters communs */

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
     * @param ?int $id_groupe id_groupe
     *
     * @return static
     */
    public function setIdGroupe(?int $id_groupe): static
    {
        if ($this->id_groupe !== $id_groupe) {
            $this->id_groupe = $id_groupe;
            $this->modified_fields['id_groupe'] = true;
        }

        return $this;
    }

    /**
     * @param ?int $id_lieu id_lieu
     *
     * @return static
     */
    public function setIdLieu(?int $id_lieu): static
    {
        if ($this->id_lieu !== $id_lieu) {
            $this->id_lieu = $id_lieu;
            $this->modified_fields['id_lieu'] = true;
        }

        return $this;
    }

    /**
     * @param ?int $id_event id_event
     *
     * @return static
     */
    public function setIdEvent(?int $id_event): static
    {
        if ($this->id_event !== $id_event) {
            $this->id_event = $id_event;
            $this->modified_fields['id_event'] = true;
        }

        return $this;
    }

    /**
     * @param ?string $name name
     *
     * @return static
     */
    public function setName(?string $name): static
    {
        if ($this->name !== $name) {
            $this->name = $name;
            $this->modified_fields['name'] = true;
        }

        return $this;
    }

    /**
     * @param ?string $created_at created_at
     *
     * @return static
     */
    public function setCreatedAt(?string $created_at): static
    {
        if ($this->created_at !== $created_at) {
            $this->created_at = $created_at;
            $this->modified_fields['created_at'] = true;
        }

        return $this;
    }

    /**
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
     * @param ?string $modified_at modified_at
     *
     * @return static
     */
    public function setModifiedAt(?string $modified_at): static
    {
        if ($this->modified_at !== $modified_at) {
            $this->modified_at = $modified_at;
            $this->modified_fields['modified_at'] = true;
        }

        return $this;
    }

    /**
     * @return static
     */
    public function setModifiedNow(): static
    {
        $now = date('Y-m-d H:i:s');

        if ($this->modified_at !== $now) {
            $this->modified_at = $now;
            $this->modified_fields['modified_at'] = true;
        }

        return $this;
    }

    /**
     * @param ?bool $online online
     *
     * @return static
     */
    public function setOnline(?bool $online): static
    {
        if ($this->online !== $online) {
            $this->online = $online;
            $this->modified_fields['online'] = true;
        }

        return $this;
    }

    /* fin setters communs */

    /**
     * Retourne une collection d'objets "Media" (Audio|Photo|Video) répondant au(x) critère(s) donné(s)
     *
     * @param array<string,mixed> $params [
     *                                'id__in' => array de int,
     *                                'id__not_in' => array de int,
     *                                'id_contact' => int,
     *                                'has_groupe' => bool,
     *                                'id_groupe' => int,
     *                                'id_event' => int,
     *                                'id_lieu' => int,
     *                                'online' => bool,
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

        $sql = 'SELECT ';

        $pks = array_map(
            function ($item) {
                return '`' . $item . '`';
            },
            static::getDbPk()
        );
        $sql .= implode(', ', $pks) . ' ';

        $sql .= 'FROM `' . static::getDbTable() . '` ';
        $sql .= 'WHERE 1 ';

        if (isset($params['id__in'])) {
            $sql .= "AND `" . static::getDbPk()[0] . "` IN (" . implode(',', $params['id__in']) . ") ";
        }

        if (isset($params['id__not_in'])) {
            $sql .= "AND `" . static::getDbPk()[0] . "` NOT IN (" . implode(',', $params['id__not_in']) . ") ";
        }

        if (isset($params['id_contact'])) {
            $sql .= "AND `id_contact` = " . (int) $params['id_contact'] . " ";
        }

        if (isset($params['has_groupe'])) {
            if ($params['has_groupe'] === true) {
                if (get_called_class() === 'Adhoc\\Model\\Video') {
                    $subSql  = "SELECT `id_video` ";
                    $subSql .= "FROM `adhoc_video_groupe`";
                    if ($ids_video = $db->pdo->query($subSql)->fetchAll(\PDO::FETCH_COLUMN)) {
                        $sql .= "AND `id_video` IN (" . implode(',', (array) $ids_video) . ") ";
                    } else {
                        return $objs;
                    }
                } else {
                    $sql .= "AND `id_groupe` IS NOT NULL ";
                }
            }
        }

        if (isset($params['id_groupe'])) {
            if (get_called_class() === 'Adhoc\\Model\\Video') {
                $subSql  = "SELECT `id_video` ";
                $subSql .= "FROM `adhoc_video_groupe` ";
                $subSql .= "WHERE `id_groupe` = " . (int) $params['id_groupe'] . " ";
                if ($ids_video = $db->pdo->query($subSql)->fetchAll(\PDO::FETCH_COLUMN)) {
                    $sql .= "AND `id_video` IN (" . implode(',', (array) $ids_video) . ") ";
                } else {
                    return $objs;
                }
            } else {
                $sql .= "AND `id_groupe` = " . (int) $params['id_groupe'] . " ";
            }
        }

        if (isset($params['id_event'])) {
            $sql .= "AND `id_event` = " . (int) $params['id_event'] . " ";
        }

        if (isset($params['id_lieu'])) {
            $sql .= "AND `id_lieu` = " . (int) $params['id_lieu'] . " ";
        }

        if (isset($params['online'])) {
            $sql .= "AND `online` = ";
            $sql .= boolval($params['online']) ? "TRUE" : "FALSE";
            $sql .= " ";
        }

        if ((isset($params['order_by']) && (in_array($params['order_by'], array_keys(static::$all_fields), true)))) {
            $sql .= "ORDER BY `" . $params['order_by'] . "` ";
        } elseif ((isset($params['order_by']) && $params['order_by'] === 'random')) {
            $sql .= "ORDER BY RAND() ";
        } else {
            $sql .= "ORDER BY `" . static::getDbPk()[0] . "` ";
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

    /**
     * Recherche des média en fonction de critères donnés
     *
     * @param array<string,mixed> $params[
     *                                'groupe' => "5"
     *                                'lieu' => "1"
     *                                'event' => "1"
     *                                'type' => "photo,audio,video"
     *                                'sort' => "date|random"
     *                                'sens' => "ASC"
     *                                'debut' => 0
     *                                'limit' => 10
     *                                'split' => false
     *                            ]
     *
     * @return array<mixed>
     */
    public static function getMedia(array $params = [])
    {
        $tab_type = [];
        if (array_key_exists('type', $params)) {
            $tab_type = explode(",", $params['type']);
        }

        if (!array_key_exists('split', $params)) {
            $params['split'] = false;
        }

        $tab = [];
        $split = [];

        foreach ($tab_type as $type) {
            if ($type === 'audio') {
                $audios = Audio::find($params);
                $split['audio'] = $audios;
                $tab = array_merge($tab, $audios);
            }
            if ($type === 'photo') {
                $photos = Photo::find($params);
                $split['photo'] = $photos;
                $tab = array_merge($tab, $photos);
            }
            if ($type === 'video') {
                $videos = Video::find($params);
                $split['video'] = $videos;
                $tab = array_merge($tab, $videos);
            }
        }

        if (boolval($params['split'])) {
            return $split;
        }

        $date = [];
        foreach ($tab as $key => $row) {
            $date[$key] = $row['created_at'];
        }
        array_multisort($date, SORT_DESC, $tab);

        $tab = array_slice($tab, 0, $params['limit']);

        return $tab;
    }

    /**
     * @return ?string
     */
    public function getEmbedUrl(): ?string
    {
        return '';
    }
}
