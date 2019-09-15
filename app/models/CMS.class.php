<?php

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
    protected $_created_on = NULL;

    /**
     * @var string
     */
    protected $_modified_on = NULL;

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
    function getAlias()
    {
        return (string) $this->_alias;
    }

    /**
     * @return string
     */
    function getTitle()
    {
        return (string) $this->_title;
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
     * @return string
     */
    function getModifiedOn()
    {
        if (Date::isDateTimeOk($this->_modified_on)) {
            return (string) $this->_modified_on;
        }
        return false;
    }

    /**
     * @return int
     */
    function getModifiedOnTs()
    {
        if (Date::isDateTimeOk($this->_modified_on)) {
            return (int) strtotime($this->_modified_on);
        }
        return false;
    }

    /**
     * @return string
     */
    function getMenuselected()
    {
        return (string) $this->_menuselected;
    }

    /**
     * @return array
     */
    function getBreadcrumb()
    {
        return $this->_breadcrumb;
    }

    /**
     * @return string
     */
    function getContent()
    {
        return (string) $this->_content;
    }

    /**
     * @return bool
     */
    function getOnline()
    {
        return (bool) $this->_online;
    }

    /**
     * @return int
     */
    function getAuth()
    {
        return (int) $this->_auth;
    }

    /* fin getters */

    /* début setters */

    /**
     * @param string
     */
    function setAlias(string $val)
    {
        $val = trim($val);
        if ($this->_alias !== $val) {
            $this->_alias = $val;
            $this->_modified_fields['alias'] = true;
        }
    }

    /**
     * @param string
     */
    function setTitle(string $val)
    {
        $val = trim($val);
        if ($this->_title !== $val) {
            $this->_title = $val;
            $this->_modified_fields['title'] = true;
        }
    }

    /**
     * @param string
     */
    function setCreatedOn(string $val)
    {
        if ($this->_created_on !== $val) {
            $this->_created_on = $val;
            $this->_modified_fields['created_on'] = true;
        }
    }

    /**
     * @param string
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
     * @param string
     */
    function setModifiedOn(string $val)
    {
        if ($this->_modified_on !== $val) {
            $this->_modified_on = $val;
            $this->_modified_fields['modified_on'] = true;
        }
    }

    /**
     *
     */
    function setModifiedNow()
    {
        $now = date('Y-m-d H:i:s');
        if ($this->_modified_on !== $now) {
            $this->_modified_on = $now;
            $this->_modified_fields['modified_on'] = true;
        }
    }

    /**
     * @param string $val
     */
    function setMenuselected(string $val)
    {
        $val = trim($val);
        if ($this->_menuselected !== $val) {
            $this->_menuselected = $val;
            $this->_modified_fields['menuselected'] = true;
        }
    }

    /**
     * @param array
     */
    function setBreadcrumb(array $val)
    {
        if ($this->_breadcrumb !== $val) {
            $this->_breadcrumb = $val;
            $this->_modified_fields['breadcrumb'] = true;
        }
    }

    /**
     * @param string $val
     */
    function setContent(string $val)
    {
        $val = trim($val);
        if ($this->_content !== $val) {
            $this->_content = $val;
            $this->_modified_fields['content'] = true;
        }
    }

    /**
     * @param bool $val
     */
    function setOnline(bool $val)
    {
        if ($this->_online !== $val) {
            $this->_online = $val;
            $this->_modified_fields['online'] = true;
        }
    }

    /**
     * @param int $val
     */
    function setAuth(int $val)
    {
        if ($this->_auth !== $val) {
            $this->_auth = $val;
            $this->_modified_fields['auth'] = true;
        }
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
     *
     */
    protected function _loadFromDb()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_cms` AS `id`, `alias`, `menuselected`, `title`, `content`, `online`, `auth` "
             . "FROM `" . self::$_table . "` "
             . "WHERE `" . self::$_pk . "` = " . (int) $this->getId();

        if ($res = $db->queryWithFetchFirstRow($sql)) {
            $this->_dbToObject($res);
            return true;
        }

        throw new Exception('id_cms introuvable');
    }

    /**
     *
     */
    static function getCMSs()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_cms` AS `id`, `alias`, `menuselected`, `breadcrumb`, `created_on`, `modified_on`, "
             . "`title`, `content`, `online`, `auth` "
             . "FROM `" . self::$_table . "` "
             . "ORDER BY `alias` ASC";

        return $db->queryWithFetch($sql);
    }
}
