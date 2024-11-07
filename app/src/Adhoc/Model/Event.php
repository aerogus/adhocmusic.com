<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Model\Reference\Style;
use Adhoc\Utils\Conf;
use Adhoc\Utils\Date;
use Adhoc\Utils\DataBase;
use Adhoc\Utils\Image;
use Adhoc\Utils\ObjectModel;

/**
 * Classe Event
 *
 * Gestion des événements et des liaisons directes (avec groupe, structure et lieu)
 * gestion de l'intégrité référentielle
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class Event extends ObjectModel
{
    /**
     * @var array<string>
     */
    protected static array $pk = [
        'id_event',
    ];

    /**
     * @var string
     */
    protected static string $table = 'adhoc_event';

    /**
     * @var ?int
     */
    protected ?int $id_event = null;

    /**
     * @var ?string
     */
    protected ?string $name = null;

    /**
     * @var ?string
     */
    protected ?string $date = null;

    /**
     * @var ?string
     */
    protected ?string $text = null;

    /**
     * @var ?string
     */
    protected ?string $price = null;

    /**
     * @var ?bool
     */
    protected ?bool $online = null;

    /**
     * @var ?int
     */
    protected ?int $id_lieu = null;

    /**
     * @var ?int
     */
    protected ?int $id_contact = null;

    /**
     * @var ?string
     */
    protected ?string $facebook_event_id = null;

    /**
     * @var ?string
     */
    protected ?string $created_at = null;

    /**
     * @var ?string
     */
    protected ?string $modified_at = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
        'id_event' => 'int', // pk
        'created_at' => 'date',
        'modified_at' => 'date',
        'name' => 'string',
        'date' => 'date',
        'text' => 'string',
        'price' => 'string',
        'online' => 'bool',
        'id_lieu' => 'int',
        'id_contact' => 'int',
        'facebook_event_id' => 'string',
    ];

    /* début getters */

    /**
     * @return string
     */
    public static function getBaseUrl(): string
    {
        return MEDIA_URL . '/event';
    }

    /**
     * @return string
     */
    public static function getBasePath(): string
    {
        return MEDIA_PATH . '/event';
    }

    /**
     * @return ?int
     */
    public function getIdEvent(): ?int
    {
        return $this->id_event;
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
     * @return ?string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return ?string yyyy-mm-dd hh:ii:ss
     */
    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * @return int
     */
    public function getDay(): int
    {
        return (int) date('d', strtotime($this->date));
    }

    /**
     * @return int
     */
    public function getMonth(): int
    {
        return (int) date('m', strtotime($this->date));
    }

    /**
     * @return int
     */
    public function getYear(): int
    {
        return (int) date('Y', strtotime($this->date));
    }

    /**
     * @return int
     */
    public function getHour(): int
    {
        return (int) date('H', strtotime($this->date));
    }

    /**
     * @return int
     */
    public function getMinute(): int
    {
        return (int) date('i', strtotime($this->date));
    }

    /**
     * @return ?string
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @return ?string
     */
    public function getPrice(): ?string
    {
        return $this->price;
    }

    /**
     * @return ?bool
     */
    public function getOnline(): ?bool
    {
        return $this->online;
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
    public function getFacebookEventId(): ?string
    {
        return $this->facebook_event_id;
    }

    /**
     * @return string
     */
    public function getFacebookEventUrl(): string
    {
        return "https://www.facebook.com/events/{$this->facebook_event_id}";
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
            return Lieu::getInstance($this->getIdLieu());
        }
        return null;
    }

    /**
     * Retourne l'url de la fiche événement
     *
     * @return string
     */
    public function getUrl(): string
    {
        return HOME_URL . '/events/' . $this->getIdEvent();
    }

    /**
     * @return array<Groupe>
     */
    public function getGroupes(): array
    {
        return Groupe::find(
            [
                'id_event' => $this->getIdEvent(),
                'order_by' => 'name',
                'sort' => 'ASC',
            ]
        );
    }

    /* fin getters */

    /* début setters */

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
     * @param string $modified_at modified_at
     *
     * @return static
     */
    public function setModifiedAt(string $modified_at): static
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
     * @param string $name name
     *
     * @return static
     */
    public function setName(string $name): static
    {
        if ($this->name !== $name) {
            $this->name = $name;
            $this->modified_fields['name'] = true;
        }

        return $this;
    }

    /**
     * @param string $facebook_event_id facebook_event_id
     *
     * @return static
     */
    public function setFacebookEventId(string $facebook_event_id): static
    {
        // pour les boulets qui copient/collent toute l'url
        if (preg_match('#^https?://w{0,3}\.facebook.com/events/([0-9]{1,24})/{0,1}$#', $facebook_event_id, $matches)) {
            $facebook_event_id = $matches[1];
        }
        $facebook_event_id = str_replace('/', '', trim($facebook_event_id));

        if ($this->facebook_event_id !== $facebook_event_id) {
            $this->facebook_event_id = $facebook_event_id;
            $this->modified_fields['facebook_event_id'] = true;
        }

        return $this;
    }

    /**
     * @param string $date date
     *
     * @return static
     */
    public function setDate(string $date): static
    {
        if ($this->date !== $date) {
            $this->date = $date;
            $this->modified_fields['date'] = true;
        }

        return $this;
    }

    /**
     * @param string $text text
     *
     * @return static
     */
    public function setText(string $text): static
    {
        if ($this->text !== $text) {
            $this->text = $text;
            $this->modified_fields['text'] = true;
        }

        return $this;
    }

    /**
     * @param string $price price
     *
     * @return static
     */
    public function setPrice(string $price): static
    {
        if ($this->price !== $price) {
            $this->price = $price;
            $this->modified_fields['price'] = true;
        }

        return $this;
    }

    /**
     * @param bool $online online
     *
     * @return static
     */
    public function setOnline(bool $online): static
    {
        if ($this->online !== $online) {
            $this->online = $online;
            $this->modified_fields['online'] = true;
        }

        return $this;
    }

    /**
     * @param int $id_lieu id_lieu
     *
     * @return static
     */
    public function setIdLieu(int $id_lieu): static
    {
        if ($this->id_lieu !== $id_lieu) {
            $this->id_lieu = $id_lieu;
            $this->modified_fields['id_lieu'] = true;
        }

        return $this;
    }

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

    /* fin setters */

    /**
     * Retourne une collection d'objets "Event" répondant au(x) critère(s) donné(s)
     *
     * @param array<string,mixed> $params [
     *                                'id_contact' => int,
     *                                'id_groupe' => int,
     *                                'id_lieu' => int,
     *                                'id_structure' => int,
     *                                'datdeb' => string,
     *                                'datfin' => string,
     *                                'online' => bool,
     *                                '' => bool,
     *                                'with_photo' => bool,
     *                                'with_video' => bool,
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

        if (isset($params['id_groupe'])) {
            $subSql = "SELECT `id_event` FROM `adhoc_participe_a` WHERE `id_groupe` = " . (int) $params['id_groupe'] . " ";
            if ($ids_event = $db->pdo->query($subSql)->fetchAll(\PDO::FETCH_COLUMN)) {
                $sql .= "AND `id_event` IN (" . implode(',', (array) $ids_event) . ") ";
            } else {
                return $objs;
            }
        }

        if (isset($params['id_structure'])) {
            $subSql = "SELECT `id_event` FROM `adhoc_organise_par` WHERE `id_structure` = " . (int) $params['id_structure'] . " ";
            if ($ids_event = $db->pdo->query($subSql)->fetchAll(\PDO::FETCH_COLUMN)) {
                $sql .= "AND `id_event` IN (" . implode(',', (array) $ids_event) . ") ";
            } else {
                return $objs;
            }
        }

        if (isset($params['id_lieu'])) {
            $sql .= "AND `id_lieu` = " . (int) $params['id_lieu'] . " ";
        }

        if (isset($params['datdeb'])) {
            $sql .= "AND `date` >= '" . $params['datdeb'] . "' "; // à échapper
        }

        if (isset($params['datfin'])) {
            $sql .= "AND `date` <= '" . $params['datfin'] . "' "; // à échapper
        }

        if (isset($params['online'])) {
            $sql .= "AND `online` = ";
            $sql .= boolval($params['online']) ? "TRUE" : "FALSE";
            $sql .= " ";
        }

        if ((isset($params['order_by']) && (in_array($params['order_by'], array_keys(static::$all_fields), true)))) {
            $sql .= "ORDER BY `" . $params['order_by'] . "` ";
        } else {
            $sql .= "ORDER BY `" . static::$pk . "` ";
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
     * @return bool
     * @throws \Exception
     */
    protected function loadFromDb(): bool
    {
        if (!parent::loadFromDb()) {
            throw new \Exception('id_event introuvable');
        }

        return true;
    }

    /**
     * @return bool
     */
    public function deleteFlyer(): bool
    {
        $p = self::getBasePath() . '/' . $this->getIdEvent() . '.jpg';
        if (file_exists($p)) {
            unlink($p);
        }

        // delete des caches images
        $confEvent = Conf::getInstance()->get('event');
        foreach ($confEvent['thumb_width'] as $maxWidth) {
            $this->clearThumb($maxWidth);
        }

        return true;
    }

    /**
     * Retourne l'url d'une miniature d'event (sans vérifier l'existence du fichier)
     *
     * @param int  $maxWidth     largeur maxi
     * @param bool $genIfMissing force la génération de la miniature si manquante
     *
     * @return ?string
     */
    public function getThumbUrl(int $maxWidth = 0, bool $genIfMissing = false): ?string
    {
        $sourcePath = self::getBasePath() . '/' . $this->getIdEvent() . '.jpg';
        if (!file_exists($sourcePath)) {
            return null;
        }

        if ($maxWidth === 0) {
            return self::getBaseUrl() . '/' . $this->getIdEvent() . '.jpg';
        } else {
            $uid = 'event/' . $this->getIdEvent() . '/' . $maxWidth;
            $cachePath = Image::getCachePath($uid);
            if (!file_exists($cachePath)) {
                if ($genIfMissing) {
                    $this->genThumb($maxWidth);
                } else {
                    // @TODO ajouter à une file de calcul
                }
            }
            return Image::getCacheUrl($uid);
        }
    }

    /**
     * Efface la miniature d'une affiche d'événement
     *
     * @param int $maxWidth maxWidth
     *
     * @return bool
     */
    public function clearThumb(int $maxWidth = 0): bool
    {
        $uid = 'event/' . $this->getIdEvent() . '/' . $maxWidth;
        $cache = Image::getCachePath($uid);

        if (file_exists($cache)) {
            unlink($cache);
            return true;
        }

        return false;
    }

    /**
     * Génère la miniature d'une affiche d'événement
     *
     * @param int $maxWidth maxWidth
     *
     * @return bool
     */
    public function genThumb(int $maxWidth = 0): bool
    {
        if ($maxWidth === 0) {
            return false;
        }

        $uid = 'event/' . $this->getIdEvent() . '/' . $maxWidth;
        $cache = Image::getCachePath($uid);

        if (file_exists($cache)) {
            unlink($cache);
        }

        $source = self::getBasePath() . '/' . $this->getIdEvent() . '.jpg';
        if (!file_exists($source)) {
            return false;
        }

        $img = (new Image($source))
            ->setType(IMAGETYPE_JPEG)
            ->setMaxWidth($maxWidth);

        Image::writeCache($uid, $img->get());

        return true;
    }

    /**
     * Suppression d'un événement
     *
     * @return bool
     */
    public function delete(): bool
    {
        /* délie les tables référentes */
        $this->unlinkStyles();
        $this->unlinkStructures();
        $this->unlinkGroupes();
        $this->deleteFlyer();

        if (parent::delete()) {
            return true;
        }
        return false;
    }

    /**
     * Ajoute un style pour un événement
     *
     * @param int $id_style id_style
     *
     * @return bool
     */
    public function linkStyle(int $id_style): bool
    {
        $db = DataBase::getInstance();

        $sql = "INSERT INTO `" . self::$db_table_event_style . "` "
             . "(`id_event`, `id_style`) "
             . "VALUES (" . $this->getIdEvent() . ", " . $id_style . ")";

        try {
            $stmt = $db->pdo->query($sql);
            return (bool) $stmt->rowCount();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Efface un style pour un événement
     *
     * @param int $id_style id_style
     *
     * @return bool
     */
    public function unlinkStyle(int $id_style): bool
    {
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . self::$db_table_event_style . "` "
             . "WHERE `id_event` = " . $this->getIdEvent() . " "
             . "AND `id_style` = " . $id_style;

        $stmt = $db->pdo->query($sql);

        return (bool) $stmt->rowCount();
    }

    /**
     * Retourne le tableau des styles pour un événement
     *
     * @return array<Style>
     */
    public function getStyles(): array
    {
        return Style::find([
            'id_event' => $this->getIdEvent(),
            'sort' => 'name',
        ]);
    }

    /**
     * Efface tous les styles d'un événement
     *
     * @return bool
     */
    public function unlinkStyles(): bool
    {
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . self::$db_table_event_style . "` "
             . "WHERE `id_event` = " . $this->getIdEvent();

        $stmt = $db->pdo->query($sql);

        return (bool) $stmt->rowCount();
    }

    /**
     * Ajoute un groupe à un événement
     *
     * @param int $id_groupe id_groupe
     *
     * @return bool
     */
    public function linkGroupe(int $id_groupe): bool
    {
        $db = DataBase::getInstance();

        $sql = "INSERT INTO `" . self::$db_table_participe_a . "` "
             . "(`id_event`, `id_groupe`) "
             . "VALUES (" . $this->getIdEvent() . ", " . $id_groupe . ")";

        try {
            $stmt = $db->pdo->query($sql);
            return (bool) $stmt->rowCount();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Efface un groupe d'un événement
     *
     * @param int $id_groupe id_groupe
     *
     * @return bool
     */
    public function unlinkGroupe(int $id_groupe): bool
    {
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . self::$db_table_participe_a . "` "
             . "WHERE `id_event` = " . $this->getIdEvent() . " "
             . "AND `id_groupe` = " . $id_groupe;

        $stmt = $db->pdo->query($sql);

        return (bool) $stmt->rowCount();
    }

    /**
     * Délie tous les groupes d'un événement
     *
     * @return bool
     */
    public function unlinkGroupes(): bool
    {
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . self::$db_table_participe_a . "` "
             . "WHERE `id_event` = " . $this->getIdEvent();

        $stmt = $db->pdo->query($sql);

        return (bool) $stmt->rowCount();
    }

    /**
     * Ajoute une structure à un événement
     *
     * @param int $id_structure id_structure
     *
     * @return bool
     */
    public function linkStructure(int $id_structure): bool
    {
        $db = DataBase::getInstance();

        $sql = "INSERT INTO `" . self::$db_table_organise_par . "` "
             . " (`id_event`, `id_structure`) "
             . "VALUES (" . $this->getIdEvent() . ", " . $id_structure . ")";

        try {
            $stmt = $db->pdo->query($sql);
            return (bool) $stmt->rowCount();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Efface une structure d'un événement
     *
     * @param int $id_structure id_structure
     *
     * @return bool
     */
    public function unlinkStructure(int $id_structure): bool
    {
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . self::$db_table_organise_par . "` "
             . "WHERE `id_event` = " . $this->getIdEvent() . " "
             . "AND `id_structure` = " . $id_structure;

        $stmt = $db->pdo->query($sql);

        return (bool) $stmt->rowCount();
    }

    /**
     * Retourne le tableau des structures pour un événement
     *
     * @return array<Structure>
     */
    public function getStructures(): array
    {
        return Structure::find([
            'id_event' => $this->getIdEvent(),
            'order_by' => 'name',
        ]);
    }

    /**
     * Efface toutes les structures d'un événement
     *
     * @return bool
     */
    public function unlinkStructures(): bool
    {
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . self::$db_table_organise_par . "` "
             . "WHERE `id_event` = " . $this->getIdEvent();

        $stmt = $db->pdo->query($sql);

        return (bool) $stmt->rowCount();
    }

    /**
     * Retourne un tableau avec le nombre d'événements par jour
     * utile pour le calendrier
     *
     * @param int $year  année
     * @param int $month mois
     *
     * @return array<string,int>
     */
    public static function getEventsForAMonth(int $year, int $month)
    {
        $db = DataBase::getInstance();

        $sql = 'SELECT DATE(`date`) AS `date`, COUNT(`id_event`) AS `nb_events` '
             . 'FROM `adhoc_event` '
             . 'WHERE 1 '
             . 'AND YEAR(`date`) = :year '
             . 'AND MONTH(`date`) = :month '
             . 'GROUP BY DATE(`date`)';

        $data = [
            'year' => $year,
            'month' => $month,
        ];

        $stm = $db->pdo->prepare($sql);
        $stm->execute($data);
        $rows = $stm->fetchAll();

        $tab = [];
        foreach ($rows as $row) {
            $tab[$row['date']] = (int) $row['nb_events'];
        }

        return $tab;
    }

    /**
     * Retourne les photos associées à cet événement
     *
     * @return array<Photo>
     */
    public function getPhotos(): array
    {
        return Photo::find(
            [
                'id_event'  => $this->getIdEvent(),
                'online' => true,
            ]
        );
    }

    /**
     * Retourne les vidéos associées à cet événement
     *
     * @return array<Video>
     */
    public function getVideos(): array
    {
        return Video::find(
            [
                'id_event' => $this->getIdEvent(),
                'online' => true,
            ]
        );
    }

    /**
     * Retourne les audios associés à cet événement
     *
     * @return array<Audio>
     */
    public function getAudios(): array
    {
        return Audio::find(
            [
                'id_event' => $this->getIdEvent(),
                'online' => true,
            ]
        );
    }

    /**
     * Retourne les concerts ad'hoc par saison (juillet Y -> aout Y+1)
     *
     * @return array<string,array<Event>>
     */
    public static function getAdHocEventsBySeason(): array
    {
        $events = self::find(
            [
                'id_structure' => 1, // AD'HOC
                'order_by' => 'date',
                'sort' => 'ASC',
            ]
        );

        $tab = [];
        foreach ($events as $event) {
            if ($event->getMonth() > 7) {
                $season = (string) $event->getYear() . ' / ' . (string) ($event->getYear() + 1);
            } else {
                $season = (string) ($event->getYear() - 1) . ' / ' . (string) $event->getYear();
            }
            if (!array_key_exists($season, $tab)) {
                $tab[$season] = [];
            }
            $tab[$season][] = $event;
        }

        return $tab;
    }
}
