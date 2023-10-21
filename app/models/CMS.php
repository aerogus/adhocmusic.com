<?php

declare(strict_types=1);

namespace Adhoc\Model;

/**
 * Classe Content Management System
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class CMS extends ObjectModel
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
    protected static string $_pk = 'id_cms';

    /**
     * @var string
     */
    protected static string $_table = 'adhoc_cms';

    /**
     * @var int
     */
    protected int $_id_cms = 0;

    /**
     * @var string
     */
    protected string $_alias = '';

    /**
     * @var string
     */
    protected string $_title = '';

    /**
     * @var ?string
     */
    protected ?string $_created_at = null;

    /**
     * @var ?string
     */
    protected ?string $_modified_at = null;

    /**
     * @var array
     */
    protected array $_breadcrumb = [];

    /**
     * @var string
     */
    protected string $_content = '';

    /**
     * @var bool
     */
    protected bool $_online = false;

    /**
     * @var int
     */
    protected int $_auth = 0;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static $_all_fields = [
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
     * @return int
     */
    public function getIdCMS(): int
    {
        return $this->_id_cms;
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return $this->_alias;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->_title;
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
     * @return string|null
     */
    public function getModifiedAt(): ?string
    {
        if (!is_null($this->_modified_at) && Date::isDateTimeOk($this->_modified_at)) {
            return $this->_modified_at;
        }
        return null;
    }

    /**
     * @return int|null
     */
    public function getModifiedAtTs(): ?int
    {
        if (!is_null($this->_modified_at) && Date::isDateTimeOk($this->_modified_at)) {
            return strtotime($this->_modified_at);
        }
        return null;
    }

    /**
     * @return array
     */
    public function getBreadcrumb(): array
    {
        return $this->_breadcrumb;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->_content;
    }

    /**
     * @return bool
     */
    public function getOnline(): bool
    {
        return $this->_online;
    }

    /**
     * @return int
     */
    public function getAuth(): int
    {
        return $this->_auth;
    }

    /* fin getters */

    /* début setters */

    /**
     * @param string $alias alias
     *
     * @return object
     */
    public function setAlias(string $alias): object
    {
        $alias = trim($alias);
        if ($this->_alias !== $alias) {
            $this->_alias = $alias;
            $this->_modified_fields['alias'] = true;
        }

        return $this;
    }

    /**
     * @param string $title title
     *
     * @return object
     */
    public function setTitle(string $title): object
    {
        $title = trim($title);
        if ($this->_title !== $title) {
            $this->_title = $title;
            $this->_modified_fields['title'] = true;
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
     * @param string $modified_at modified_at
     *
     * @return object
     */
    public function setModifiedAt(string $modified_at): object
    {
        if ($this->_modified_at !== $modified_at) {
            $this->_modified_at = $modified_at;
            $this->_modified_fields['modified_at'] = true;
        }

        return $this;
    }

    /**
     * @return object
     */
    public function setModifiedNow(): object
    {
        $now = date('Y-m-d H:i:s');

        if ($this->_modified_at !== $now) {
            $this->_modified_at = $now;
            $this->_modified_fields['modified_at'] = true;
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
        if ($this->_breadcrumb !== $breadcrumb) {
            $this->_breadcrumb = print_r($breadcrumb, true);
            $this->_modified_fields['breadcrumb'] = true;
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
        $content = trim($content);
        if ($this->_content !== $content) {
            $this->_content = $content;
            $this->_modified_fields['content'] = true;
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
        if ($this->_online !== $online) {
            $this->_online = $online;
            $this->_modified_fields['online'] = true;
        }

        return $this;
    }

    /**
     * @param int $auth auth
     *
     * @return object
     */
    public function setAuth(int $auth): object
    {
        if ($this->_auth !== $auth) {
            $this->_auth = $auth;
            $this->_modified_fields['auth'] = true;
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

    /**
     * Récupère l'id_cms à partir de l'alias
     *
     * @param string $alias alias
     *
     * @return int|null
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
            return $cmss[0]->getIdCMS();
        }
        return null;
    }
}
