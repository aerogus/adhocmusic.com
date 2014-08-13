<?php

/**
 * Classe News
 *
 * gestion des news de la home
 *
 * @package adhoc
 * @author Guillaume Seznec <guillaume.seznec@gmail.com>
 */
class News extends ObjectModel
{
    /**
     * @var object
     */
    protected static $_instance = null;

    /**
     * @var string
     */
    protected static $_pk = 'id_news';

    /**
     * @var string
     */
    protected static $_table = 'adhoc_news';

    /**
     * @var int
     */
    protected $_id_news = 0;

    /**
     * titre de l'article
     * @var string
     */
    protected $_title = '';

    /**
     * introduction de la news
     * @var string
     */
    protected $_intro = '';

    /**
     * contenu de la news
     * @var string
     * @todo array pour pagination ?
     */
    protected $_text = '';

    /**
     * Date de création
     * @var string
     */
    protected $_created_on = '';

    /**
     * Date de modification
     * @var string
     */
    protected $_modified_on = '';

    /**
     * news en ligne ?
     * @var bool
     */
    protected $_online = false;

    /**
     * Liste des attributs de l'objet
     * on précise si en base c'est de type :
     * - numérique/integer/float/bool (= num)
     * - datetime/text (= str)
     * - booléen (= bool)
     * ceci est utile pour la formation de la requête
     * @var array
     */
    protected static $_all_fields = array(
        'title'       => 'str',
        'intro'       => 'str',
        'text'        => 'str',
        'created_on'  => 'str',
        'modified_on' => 'str',
        'online'      => 'bool',
    );

    /**
     * Tableau des attributs modifiés depuis la dernière sauvegarde.
     *
     * Pour chaque attribut modifié, on a un élément de la forme 'attribut => true'.
     * @var array
     */
    protected $_modified_fields = array();

    /* début getters */

    /**
     * @return string
     */
    public function getTitle()
    {
        return (string) $this->_title;
    }

    /**
     * @return string
     */
    public function getIntro()
    {
        return (string) $this->_intro;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return (string) $this->_text;
    }

    /**
     * @return string
     */
    public function getCreatedOn()
    {
        if(Date::isDateTimeOk($this->_created_on)) {
            return (string) $this->_created_on;
        }
        return false;
    }

    /**
     * @return int
     */
    public function getCreatedOnTs()
    {
        if(Date::isDateTimeOk($this->_created_on)) {
            return (int) strtotime($this->_created_on);
        }
        return false;
    }

    /**
     * @return string
     */
    public function getModifiedOn()
    {
        if(Date::isDateTimeOk($this->_modified_on)) {
            return (string) $this->_modified_on;
        }
        return false;
    }

    /**
     * @return int
     */
    public function getModifiedOnTs()
    {
        if(Date::isDateTimeOk($this->_modified_on)) {
            return (int) strtotime($this->_modified_on);
        }
        return false;
    }

    /**
     * @return bool
     */
    public function getOnline()
    {
        return (bool) $this->_online;
    }

    /* fin getters */

    /* début setters */

    /**
     * @param string
     */
    public function setTitle($val)
    {
        if ($this->_title != $val)
        {
            $this->_title = (string) $val;
            $this->_modified_fields['title'] = true;
        }
    }

    /**
     * @param string
     */
    public function setIntro($val)
    {
        if ($this->_intro != $val)
        {
            $this->_intro = (string) $val;
            $this->_modified_fields['intro'] = true;
        }
    }

    /**
     * @param string
     */
    public function setText($val)
    {
        if ($this->_text != $val)
        {
            $this->_text = (string) $val;
            $this->_modified_fields['text'] = true;
        }
    }

    /**
     * @param string
     */
    public function setCreatedOn($val)
    {
        if ($this->_created_on != $val)
        {
            $this->_created_on = (string) $val;
            $this->_modified_fields['created_on'] = true;
        }
    }

    /**
     *
     */
    public function setCreatedNow()
    {
        $now = date('Y-m-d H:i:s');
        if ($this->_created_on != $now)
        {
            $this->_created_on = (string) $now;
            $this->_modified_fields['created_on'] = true;
        }
    }

    /**
     * @param string
     */
    public function setModifiedOn($val)
    {
        if ($this->_modified_on != $val)
        {
            $this->_modified_on = (string) $val;
            $this->_modified_fields['modified_on'] = true;
        }
    }

    /**
     *
     */
    public function setModifiedNow()
    {
        $now = date('Y-m-d H:i:s');
        if ($this->_modified_on != $now)
        {
            $this->_modified_on = (string) $now;
            $this->_modified_fields['modified_on'] = true;
        }
    }

    /**
     * @param int
     */
    public function setOnline($val)
    {
        if ($this->_online != $val)
        {
            $this->_online = (int) $val;
            $this->_modified_fields['online'] = true;
        }
    }

    /* fin setters */

    /**
     * @param array
     * @return array
     */
    public static function getNewsList($params = array())
    {
        $debut = 0;
        if(isset($params['debut'])) {
            $debut = (int) $params['debut'];
        }

        $limit = 10;
        if(isset($params['limit'])) {
            $limit = (int) $params['limit'];
        }

        $sens = 'ASC';
        if(isset($params['sens']) && $params['sens'] == 'DESC') {
            $sens = 'DESC';
        }

        $sort = 'id_news';
        if(isset($params['sort'])
           && ($params['sort'] == 'created_on' || $params['sort'] == 'random')) {
            $sort = $params['sort'];
        }

        $db = DataBase::getInstance();

        $sql = "SELECT `id_news` AS `id`, `title`, `intro`, `text`, "
             . "`created_on`, `modified_on`, `online`, "
             . "CONCAT('http://www.adhocmusic.com/news/', `n`.`id_news`) AS `url` "
             . "FROM `" . self::$_table . "` `n` "
             . "WHERE 1 ";

        if(array_key_exists('online', $params)) {
            if($params['online']) {
                $online = 'TRUE';
            } else {
                $online = 'FALSE';
            }
            $sql .= "AND `n`.`online` = " . $online . " ";
        }

        $sql .= "ORDER BY ";
        if($sort == "random") {
            $sql .= "RAND(" . time() . ") ";
        } else {
            $sql .= "`n`.`" . $sort . "` " . $sens . " ";
        }
        if($limit) {
            $sql .= "LIMIT " . $debut . ", " . $limit;
        }

        if($limit == 1 && false) {
            return $db->queryWithFetchFirstRow($sql);
        } else {
            return $db->queryWithFetch($sql);
        }
    }

    /**
     * Retourne le nombre de news publiques
     *
     * @return int
     */
    public static function getNewsPublicCount()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(`id_news`) "
             . "FROM `" . self::$_table . "` "
             . "WHERE `online`";

        return (int) $db->queryWithFetchFirstField($sql);
    }

    /**
     *
     */
    protected function _loadFromDb()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_news`, `intro`, `title`, `text`, `created_on`, `modified_on`, `online` "
             . "FROM `" . self::$_table . "` "
             . "WHERE `" . self::$_pk ."` = " . (int) $this->_id_news;

        if($res = $db->queryWithFetchFirstRow($sql)) {
            $this->_dbToObject($res);
            return true;
        }

        throw new AdHocUserException('News introuvable', EXCEPTION_USER_UNKNOW_ID);
    }
}
