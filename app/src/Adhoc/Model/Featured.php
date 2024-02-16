<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Utils\Date;
use Adhoc\Utils\DataBase;
use Adhoc\Utils\ObjectModel;

/**
 * Classe Featured
 *
 * Classe de gestion du module sélection du mois
 *
 * @template TObjectModel as Featured
 * @extends ObjectModel<TObjectModel>
 *
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Featured extends ObjectModel
{
    public const WIDTH = 1000;
    public const HEIGHT = 375;

    /**
     * Instance de l'objet
     *
     * @var ?TObjectModel
     */
    protected static ?ObjectModel $instance = null;

    /**
     * @var string|array<string>
     */
    protected static string|array $pk = 'id_featured';

    /**
     * @var string
     */
    protected static string $table = 'adhoc_featured';

    /**
     * @var int
     */
    protected int $id_featured = 0;

    /**
     * @var string
     */
    protected string $datdeb = '';

    /**
     * @var string
     */
    protected string $datfin = '';

    /**
     * @var string
     */
    protected string $title = '';

    /**
     * @var string
     */
    protected string $description = '';

    /**
     * @var string
     */
    protected string $url = '';

    /**
     * @var bool
     */
    protected bool $online = false;

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
        'id_featured' => 'int', // pk
        'datdeb'      => 'date',
        'datfin'      => 'date',
        'title'       => 'string',
        'description' => 'string',
        'url'         => 'string',
        'online'      => 'bool',
        'created_at'  => 'date',
        'modified_at' => 'date',
    ];

    /* début getters */

    /**
     * @return string
     */
    public static function getBaseUrl(): string
    {
        return MEDIA_URL . '/featured';
    }

    /**
     * @return string
     */
    public static function getBasePath(): string
    {
        return MEDIA_PATH . '/featured';
    }

    /**
     * @return string
     */
    public function getDatDeb(): string
    {
        return $this->datdeb;
    }

    /**
     * @return string
     */
    public function getDatFin(): string
    {
        return $this->datfin;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return self::getBaseUrl() . '/' . (string) $this->getId() . '.jpg';
    }

    /**
     * @return bool
     */
    public function getOnline(): bool
    {
        return $this->online;
    }

    /**
     * @return ?string
     */
    public function getCreatedAt(): ?string
    {
        if (Date::isDateTimeOk($this->created_at)) {
            return $this->created_at;
        }
        return null;
    }

    /**
     * @return ?int
     */
    public function getCreatedAtTs(): ?int
    {
        if (Date::isDateTimeOk($this->created_at)) {
            return strtotime($this->created_at);
        }
        return null;
    }

    /**
     * @return ?string
     */
    public function getModifiedAt(): ?string
    {
        if (Date::isDateTimeOk($this->modified_at)) {
            return $this->modified_at;
        }
        return null;
    }

    /**
     * @return ?int
     */
    public function getModifiedAtTs(): ?int
    {
        if (Date::isDateTimeOk($this->modified_at)) {
            return strtotime($this->modified_at);
        }
        return null;
    }

    /* fin getters */

    /* début setters */

    /**
     * @param string $datdeb date format YYYY-MM-DD HH:II:SS
     *
     * @return object
     */
    public function setDatDeb(string $datdeb): object
    {
        if (!Date::isDateTimeOk($datdeb)) {
            throw new \Exception('datdeb invalide');
        }

        if ($this->datdeb !== $datdeb) {
            $this->datdeb = $datdeb;
            $this->modified_fields['datdeb'] = true;
        }

        return $this;
    }

    /**
     * @param string $datfin YYYY-MM-DD HH:II:SS
     *
     * @return object
     */
    public function setDatFin(string $datfin): object
    {
        if (!Date::isDateTimeOk($datfin)) {
            throw new \Exception('datfin invalide');
        }

        if ($this->datfin !== $datfin) {
            $this->datfin = $datfin;
            $this->modified_fields['datfin'] = true;
        }

        return $this;
    }

    /**
     * @param string $title titre
     *
     * @return object
     */
    public function setTitle(string $title): object
    {
        $title = trim($title);

        if ($this->title !== $title) {
            $this->title = $title;
            $this->modified_fields['title'] = true;
        }

        return $this;
    }

    /**
     * @param string $description description
     *
     * @return object
     */
    public function setDescription(string $description): object
    {
        $description = trim($description);

        if ($this->description !== $description) {
            $this->description = $description;
            $this->modified_fields['description'] = true;
        }

        return $this;
    }

    /**
     * @param string $url lien
     *
     * @return object
     */
    public function setUrl(string $url): object
    {
        $url = trim($url);

        if ($this->url !== $url) {
            $this->url = $url;
            $this->modified_fields['url'] = true;
        }

        return $this;
    }

    /**
     * @param bool $online online
     *
     * @return object
     */
    public function setOnline(bool $online): object
    {
        if ($this->online !== $online) {
            $this->online = $online;
            $this->modified_fields['online'] = true;
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
        if ($this->created_at !== $created_at) {
            $this->created_at = $created_at;
            $this->modified_fields['created_at'] = true;
        }

        return $this;
    }

    /**
     * @return object
     */
    public function setCreatedNow(): object
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
     * @return object
     */
    public function setModifiedAt(string $modified_at): object
    {
        if ($this->modified_at !== $modified_at) {
            $this->modified_at = $modified_at;
            $this->modified_fields['modified_at'] = true;
        }

        return $this;
    }

    /**
     * @return object
     */
    public function setModifiedNow(): object
    {
        $now = date('Y-m-d H:i:s');

        if ($this->modified_at !== $now) {
            $this->modified_at = $now;
            $this->modified_fields['modified_at'] = true;
        }

        return $this;
    }

    /* fin setters */

    /**
     * Efface un featured en db + le fichier .jpg
     *
     * @return bool
     */
    public function delete(): bool
    {
        if (parent::delete()) {
            $file = self::getBasePath() . '/' . $this->getId() . '.jpg';
            if (file_exists($file)) {
                unlink($file);
            }
            return true;
        }
        return false;
    }

    /**
     * Retourne une collection d'objets "Featured" répondant au(x) critère(s) donné(s)
     *
     * À surcharger dans les classes filles
     *
     * @param array<string,mixed> $params [
     *                                        'online' => bool,
     *                                        'current' => bool,
     *                                        'order_by' => string,
     *                                        'sort' => string,
     *                                        'start' => int,
     *                                        'limit' => int,
     *                                    ]
     *
     * @return array<object>
     */
    public static function find(array $params): array
    {
        $db = DataBase::getInstance();
        $objs = [];

        $sql = "SELECT `" . static::getDbPk() . "` FROM `" . static::getDbTable() . "` WHERE 1 ";

        if (isset($params['online'])) {
            $sql .= "AND `online` = ";
            $sql .= $params['online'] ? "TRUE" : "FALSE";
            $sql .= " ";
        }

        if (isset($params['current'])) {
            $sql .= "AND `datdeb` <= CURRENT_DATE AND `datfin` >= CURRENT_DATE ";
        }

        if ((isset($params['order_by']) && (in_array($params['order_by'], array_keys(static::$all_fields))))) {
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