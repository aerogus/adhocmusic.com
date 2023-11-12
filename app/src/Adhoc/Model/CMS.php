<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Utils\Date;
use Adhoc\Utils\ObjectModel;

/**
 * Classe Content Management System
 *
 * @template TObjectModel as CMS
 * @extends ObjectModel<TObjectModel>
 *
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class CMS extends ObjectModel
{
    /**
     * Instance de l'objet
     *
     * @var ?TObjectModel
     */
    protected static ?ObjectModel $instance = null;

    /**
     * @var string|array<string>
     */
    protected static string|array $pk = 'id_cms';

    /**
     * @var string
     */
    protected static string $table = 'adhoc_cms';

    /**
     * @var int
     */
    protected int $id_cms = 0;

    /**
     * @var ?string
     */
    protected ?string $alias = null;

    /**
     * @var ?string
     */
    protected ?string $title = null;

    /**
     * @var ?string
     */
    protected ?string $created_at = null;

    /**
     * @var ?string
     */
    protected ?string $modified_at = null;

    /**
     * @var ?string
     */
    protected ?string $breadcrumb = null;

    /**
     * @var ?string
     */
    protected ?string $content = null;

    /**
     * @var ?bool
     */
    protected ?bool $online = null;

    /**
     * @var ?int
     */
    protected ?int $auth = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
        'id_cms'      => 'int', // pk
        'alias'       => 'string',
        'title'       => 'string',
        'created_at'  => 'date',
        'modified_at' => 'date',
        'breadcrumb'  => 'string',
        'content'     => 'string',
        'online'      => 'bool',
        'auth'        => 'int',
    ];

    /* début getters */

    /**
     * @return ?int
     */
    public function getIdCms(): ?int
    {
        return $this->id_cms;
    }

    /**
     * @return ?string
     */
    public function getAlias(): ?string
    {
        return $this->alias;
    }

    /**
     * @return ?string
     */
    public function getTitle(): ?string
    {
        return $this->title;
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
    public function getBreadcrumb(): ?string
    {
        return $this->breadcrumb;
    }

    /**
     * @return ?string
     */
    public function getContent(): ?string
    {
        return $this->content;
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
    public function getAuth(): ?int
    {
        return $this->auth;
    }

    /* fin getters */

    /* début setters */

    /**
     * @param ?string $alias alias
     *
     * @return object
     */
    public function setAlias(?string $alias): object
    {
        $alias = is_string($alias) ? trim($alias) : $alias;

        if ($this->alias !== $alias) {
            $this->alias = $alias;
            $this->modified_fields['alias'] = true;
        }

        return $this;
    }

    /**
     * @param ?string $title title
     *
     * @return object
     */
    public function setTitle(?string $title): object
    {
        $title = is_string($title) ? trim($title) : $title;

        if ($this->title !== $title) {
            $this->title = $title;
            $this->modified_fields['title'] = true;
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

    /**
     * @param array $breadcrumb breadcrumb [{title:'', link: '', description: ''},{...}]
     *
     * @return object
     */
    public function setBreadcrumb(array $breadcrumb): object
    {
        // TODO: à convertir en chaine
        if ($this->breadcrumb !== $breadcrumb) {
            $this->breadcrumb = print_r($breadcrumb, true);
            $this->modified_fields['breadcrumb'] = true;
        }

        return $this;
    }

    /**
     * @param string $content content
     *
     * @return object
     */
    public function setContent(string $content): object
    {
        $content = is_string($content) ? trim($content) : $content;

        if ($this->content !== $content) {
            $this->content = $content;
            $this->modified_fields['content'] = true;
        }

        return $this;
    }

    /**
     * @param ?bool $online online
     *
     * @return object
     */
    public function setOnline(?bool $online): object
    {
        if ($this->online !== $online) {
            $this->online = $online;
            $this->modified_fields['online'] = true;
        }

        return $this;
    }

    /**
     * @param ?int $auth auth
     *
     * @return object
     */
    public function setAuth(?int $auth): object
    {
        if ($this->auth !== $auth) {
            $this->auth = $auth;
            $this->modified_fields['auth'] = true;
        }

        return $this;
    }

    /* fin setters */

    /**
     * Retourne une collection d'objets "ObjectModel" répondant au(x) critère(s) donné(s)
     *
     * À surcharger dans les classes filles
     *
     * @param array $params [
     *                      'alias' => string,
     *                      'online' => bool,
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

        if (isset($params['alias'])) {
            $sql .= "AND `alias` = '" . $db->escape($params['alias']) . "' ";
        }

        if (isset($params['online'])) {
            $sql .= "AND `online` = ";
            $sql .= $params['online'] ? "TRUE" : "FALSE";
            $sql .= " ";
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

    /**
     * Récupère l'id_cms à partir de l'alias
     *
     * @param string $alias alias
     *
     * @return ?int
     */
    public static function getIdByAlias(string $alias): ?int
    {
        if (
            $cmss = self::find(
                [
                    'alias' => $alias,
                    'online' => true,
                ]
            )
        ) {
            return $cmss[0]->getIdCms();
        }
        return null;
    }
}
