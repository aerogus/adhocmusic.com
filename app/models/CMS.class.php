<?php declare(strict_types=1);

/**
 * Classe Content Management System
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class CMS extends ObjectModel
{
    /**
     * @var object
     */
    protected static $_instance = null;

    /**
     * @var string
     */
    protected static $_pk = 'id_cms';

    /**
     * @var string
     */
    protected static $_table = 'adhoc_cms';

    /**
     * @var int
     */
    protected $_id_cms = 0;

    /**
     * @var string
     */
    protected $_alias = '';

    /**
     * @var string
     */
    protected $_title = '';

    /**
     * @var string
     */
    protected $_created_on = null;

    /**
     * @var string
     */
    protected $_modified_on = null;

    /**
     * @var string
     */
    protected $_menuselected = '';

    /**
     * @var array
     */
    protected $_breadcrumb = [];

    /**
     * @var string
     */
    protected $_content = '';

    /**
     * @var string
     */
    protected $_online = '';

    /**
     * @var int
     */
    protected $_auth = 0;

    /**
     * Liste des attributs de l'objet
     * on précise si en base c'est de type :
     * - numérique/integer/float/bool (= num)
     * - datetime/text (= str)
     * ceci est utile pour la formation de la requête
     *
     * @var array
     */
    protected static $_all_fields = [
        'alias'        => 'str',
        'title'        => 'str',
        'created_on'   => 'date',
        'modified_on'  => 'date',
        'menuselected' => 'str',
        'breadbcrumb'  => 'phpser',
        'content'      => 'str',
        'online'       => 'bool',
        'auth'         => 'int',
    ];

    /* début getters */

    /**
     * @return string
     */
    function getAlias(): string
    {
        return $this->_alias;
    }

    /**
     * @return string
     */
    function getTitle(): string
    {
        return $this->_title;
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
     * @return string|null
     */
    function getModifiedOn(): ?string
    {
        if (!is_null($this->_modified_on) && Date::isDateTimeOk($this->_modified_on)) {
            return $this->_modified_on;
        }
        return null;
    }

    /**
     * @return int|null
     */
    function getModifiedOnTs(): ?int
    {
        if (!is_null($this->_modified_on) && Date::isDateTimeOk($this->_modified_on)) {
            return strtotime($this->_modified_on);
        }
        return null;
    }

    /**
     * @return string
     */
    function getMenuselected(): string
    {
        return $this->_menuselected;
    }

    /**
     * @return array
     */
    function getBreadcrumb(): array
    {
        return $this->_breadcrumb;
    }

    /**
     * @return string
     */
    function getContent(): string
    {
        return $this->_content;
    }

    /**
     * @return bool
     */
    function getOnline(): bool
    {
        return $this->_online;
    }

    /**
     * @return int
     */
    function getAuth(): int
    {
        return $this->_auth;
    }

    /* fin getters */

    /* début setters */

    /**
     * @param string $val val
     *
     * @return object
     */
    function setAlias(string $val): object
    {
        $val = trim($val);
        if ($this->_alias !== $val) {
            $this->_alias = $val;
            $this->_modified_fields['alias'] = true;
        }

        return $this;
    }

    /**
     * @param string $val val
     *
     * @return object
     */
    function setTitle(string $val): object
    {
        $val = trim($val);
        if ($this->_title !== $val) {
            $this->_title = $val;
            $this->_modified_fields['title'] = true;
        }

        return $this;
    }

    /**
     * @param string $val val
     *
     * @return object
     */
    function setCreatedOn(string $val): object
    {
        if ($this->_created_on !== $val) {
            $this->_created_on = $val;
            $this->_modified_fields['created_on'] = true;
        }

        return $this;
    }

    /**
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
     * @param string $val val
     *
     * @return object
     */
    function setModifiedOn(string $val): object
    {
        if ($this->_modified_on !== $val) {
            $this->_modified_on = $val;
            $this->_modified_fields['modified_on'] = true;
        }

        return $this;
    }

    /**
     * @return object
     */
    function setModifiedNow(): object
    {
        $now = date('Y-m-d H:i:s');
        if ($this->_modified_on !== $now) {
            $this->_modified_on = $now;
            $this->_modified_fields['modified_on'] = true;
        }

        return $this;
    }

    /**
     * @param string $val val
     *
     * @return object
     */
    function setMenuselected(string $val): object
    {
        $val = trim($val);
        if ($this->_menuselected !== $val) {
            $this->_menuselected = $val;
            $this->_modified_fields['menuselected'] = true;
        }

        return $this;
    }

    /**
     * @param array $val val
     *
     * @return object
     */
    function setBreadcrumb(array $val): object
    {
        if ($this->_breadcrumb !== $val) {
            $this->_breadcrumb = $val;
            $this->_modified_fields['breadcrumb'] = true;
        }

        return $this;
    }

    /**
     * @param string $val val
     *
     * @return object
     */
    function setContent(string $val): object
    {
        $val = trim($val);
        if ($this->_content !== $val) {
            $this->_content = $val;
            $this->_modified_fields['content'] = true;
        }

        return $this;
    }

    /**
     * @param bool $val val
     *
     * @return object
     */
    function setOnline(bool $val): object
    {
        if ($this->_online !== $val) {
            $this->_online = $val;
            $this->_modified_fields['online'] = true;
        }

        return $this;
    }

    /**
     * @param int $val val
     *
     * @return object
     */
    function setAuth(int $val): object
    {
        if ($this->_auth !== $val) {
            $this->_auth = $val;
            $this->_modified_fields['auth'] = true;
        }

        return $this;
    }

    /* fin setters */

    /**
     * @param string $alias alias
     *
     * @return int ou false
     */
    static function getIdByAlias(string $alias)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `" . self::$_pk . "` "
             . "FROM `" . self::$_table . "` "
             . "WHERE `alias` = '" . $db->escape($alias) . "' AND `online`";

        return $db->queryWithFetchFirstField($sql);
    }

    /**
     * @return array
     */
    static function getCMSs(): array
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_cms` AS `id`, `alias`, `menuselected`, `breadcrumb`, `created_on`, `modified_on`, "
             . "`title`, `content`, `online`, `auth` "
             . "FROM `" . self::$_table . "` "
             . "ORDER BY `alias` ASC";

        return $db->queryWithFetch($sql);
    }
}
