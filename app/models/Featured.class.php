<?php

/**
 * @package adhoc
 */

/**
 * Classe Featured
 *
 * Classe de gestion du module sélection du mois
 *
 * @package adhoc
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class Featured extends ObjectModel
{
    /**
     * @var object
     */
    protected static $_instance = null;

    /**
     * @var string
     */
    protected static $_pk = 'id_featured';

    /**
     * @var string
     */
    protected static $_table = 'adhoc_featured';

    /**
     * @var int
     */
    protected $_id_featured = 0;

    /**
     * @var string
     */
    protected $_datdeb = '';

    /**
     * @var string
     */
    protected $_datfin = '';

    /**
     * @var string
     */
    protected $_title = '';

    /**
     * @var string
     */
    protected $_description = '';

    /**
     * @var string
     */
    protected $_link = '';

    /**
     * @var int
     */
    protected $_slot = 0;

    /**
     * @var int
     */
    protected $_online = 0;

    /**
     * @var int
     */
    protected static $_width = 1000;

    /**
     * @var int
     */
    protected static $_height = 375;

    /**
     * Liste des attributs de l'objet
     * on précise si en base c'est de type :
     * - numérique/integer/float/bool (= num)
     * - datetime/text (= str)
     * ceci est utile pour la formation de la requête
     * @var array
     */
    protected static $_all_fields = [
        'datdeb'      => 'str',
        'datfin'      => 'str',
        'title'       => 'str',
        'description' => 'str',
        'link'        => 'str',
        'slot'        => 'num',
        'online'      => 'bool',
    ];

    /* début getters */

    /**
     * @return string
     */
    static function getBaseUrl()
    {
        return MEDIA_URL . '/featured';
    }

    /**
     * @return string
     */
    static function getBasePath()
    {
        return MEDIA_PATH . '/featured';
    }

    /**
     * @param string $mode
     * @return string
     */
    function getDatDeb($mode = false)
    {
        if (!Date::isDateTimeOk($this->_datdeb)) {
            return false;
        }

        preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})$/", $this->_datdeb, $regs);
        if ($mode === 'year') {
            return $regs[1];
        } elseif ($mode === 'month') {
            return $regs[2];
        } elseif ($mode === 'day') {
            return $regs[3];
        } elseif ($mode === 'hour') {
            return $regs[4];
        } elseif ($mode === 'minute') {
            return $regs[5];
        }
        return $this->_datdeb;
    }

    /**
     * @param string $mode
     * @return string
     */
    function getDatFin($mode = false)
    {
        if (!Date::isDateTimeOk($this->_datfin)) {
            return false;
        }

        preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})$/", $this->_datfin, $regs);
        if ($mode === 'year') {
            return $regs[1];
        } elseif ($mode === 'month') {
            return $regs[2];
        } elseif ($mode === 'day') {
            return $regs[3];
        } elseif ($mode === 'hour') {
            return $regs[4];
        } elseif ($mode === 'minute') {
            return $regs[5];
        }
        return $this->_datfin;
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
    function getDescription()
    {
        return (string) $this->_description;
    }

    /**
     * @return string
     */
    function getLink()
    {
        return (string) $this->_link;
    }

    /**
     * @return string
     */
    function getImage()
    {
        return self::getImageById((int) $this->getId());
    }

    /**
     * @param int
     * @return string
     */
    static function getImageById($id)
    {
        return self::getBaseUrl() . '/' . (int) $id . '.jpg';
    }

    /**
     * @return bool
     */
    function getOnline()
    {
        return (bool) $this->_online;
    }

    /* fin getters */

    /* début setters */

    /**
     * @param string YYYY-MM-DD HH:II:SS
     */
    function setDatDeb($val)
    {
        if (!Date::isDateTimeOk($val)) {
            throw new Exception('datdeb invalide');
        }

        if ($this->_datdeb !== $val)
        {
            $this->_datdeb = (string) $val;
            $this->_modified_fields['datdeb'] = true;
        }
    }

    /**
     * @param string YYYY-MM-DD HH:II:SS
     */
    function setDatFin($val)
    {
        if (!Date::isDateTimeOk($val)) {
            throw new Exception('datfin invalide');
        }

        if ($this->_datfin !== $val)
        {
            $this->_datfin = (string) $val;
            $this->_modified_fields['datfin'] = true;
        }
    }

    /**
     * @param string
     */
    function setTitle($val)
    {
        $val = trim((string) $val);
        if ($this->_title !== $val)
        {
            $this->_title = (string) $val;
            $this->_modified_fields['title'] = true;
        }
    }

    /**
     * @param string
     */
    function setDescription($val)
    {
        $val = trim((string) $val);
        if ($this->_description !== $val)
        {
            $this->_description = (string) $val;
            $this->_modified_fields['description'] = true;
        }
    }

    /**
     * @param string
     */
    function setLink($val)
    {
        $val = trim((string) $val);
        if ($this->_link !== $val)
        {
            $this->_link = (string) $val;
            $this->_modified_fields['link'] = true;
        }
    }

    /**
     * @param bool
     */
    function setOnline($val)
    {
        $val = (bool) $val;
        if ($this->_online !== $val)
        {
            $this->_online = (bool) $val;
            $this->_modified_fields['online'] = true;
        }
    }

    /* fin setters */

    /**
     * @return array
     */
    static function getFeaturedHomepage()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_featured` AS `id`, `title`, `description`, `link`
                FROM `" . self::$_db_table_featured . "`
                WHERE `datdeb` < DATE(NOW())
                AND `datfin` > DATE(NOW())
                AND `online`";

        $res = $db->queryWithFetch($sql);

        foreach ($res as $cpt => $_res) {
            $res[$cpt]['image'] = self::getImageById($_res['id']);
        }

        return $res;
    }

    /**
     * retourne les à l'affiche
     *
     * @return array
     */
    static function getFeaturedAdmin()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_featured` AS `id`, `title`, `description`, `link`, `datdeb`, `datfin`, `slot`, `online` "
             . "FROM `" . self::$_db_table_featured . "` "
             . "ORDER BY `online` DESC, `id_featured` DESC";

        $res = $db->queryWithFetch($sql);

        $tab = [];
        if (is_array($res))
        {
            $cpt = 0;
            $now = date('Y-m-d H:i:s');
            foreach ($res as $cpt => $_res)
            {
                $tab[$cpt] = $_res;
                $tab[$cpt]['image'] = self::getImageById($_res['id']);
                if (($now > $_res['datdeb']) && ($now < $_res['datfin'])) {
                    $tab[$cpt]['class'] = 'enligne';
                } elseif ($now < $_res['datdeb']) {
                    $tab[$cpt]['class'] = "programme";
                } elseif ($now > $_res['datfin']) {
                    $tab[$cpt]['class'] = "archive";
                }

                //$cpt++;
            }
        }

        return $tab;
    }

    /**
     *
     */
    protected function _loadFromDb()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_featured`, `title`, `description`, `link`, `datdeb`, `datfin`, `online` "
             . "FROM `" . self::$_table . "` "
             . "WHERE `id_featured` = " . (int) $this->_id_featured;

        if ($res = $db->queryWithFetchFirstRow($sql)) {
            $this->_dbToObject($res);
            return true;
        }

        throw new Exception('Featured introuvable');
    }

    /**
     * efface un featured en db + le fichier .jpg
     *
     * @return true
     */
    function delete()
    {
        if (parent::delete())
        {
            $file = self::getBasePath() . '/' . $this->getId() . '.jpg';
            if (file_exists($file)) {
                unlink($file);
            }
            return true;
        }
        return false;
    }
}
