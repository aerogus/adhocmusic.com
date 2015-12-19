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
 * @author Guillaume Seznec <guillaume.seznec@gmail.com>
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
    protected static $_width = 427;

    /**
     * @var int
     */
    protected static $_height = 240;

    /**
     * Liste des attributs de l'objet
     * on précise si en base c'est de type :
     * - numérique/integer/float/bool (= num)
     * - datetime/text (= str)
     * ceci est utile pour la formation de la requête
     * @var array
     */
    protected static $_all_fields = array(
        'datdeb'      => 'str',
        'datfin'      => 'str',
        'title'       => 'str',
        'description' => 'str',
        'link'        => 'str',
        'slot'        => 'num',
        'online'      => 'bool',
    );

    /**
     * @return array
     */
    static function getSlots()
    {
        return array(
            1 => 'Live AD\'HOC',
            2 => 'Evénement',
            3 => 'Groupe AD\'HOC',
            4 => 'Article/Reportage',
        );
    }

    /**
     * @param int
     * @return string
     */
    static function getSlotNameBySlotId($id_slot)
    {
        $slots = self::getSlots();
        if(array_key_exists($id_slot, $slots)) {
            return $slots[$id_slot];
        }
        return false;
    }

    /* début getters */

    /**
     * @param string $mode
     * @return string
     */
    function getDatDeb($mode = false)
    {
        if(!Date::isDateTimeOk($this->_datdeb)) {
            return false;
        }

        preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})$/", $this->_datdeb, $regs);
        if($mode == 'year') {
            return $regs[1];
        } elseif($mode == 'month') {
            return $regs[2];
        } elseif($mode == 'day') {
            return $regs[3];
        } elseif($mode == 'hour') {
            return $regs[4];
        } elseif($mode == 'minute') {
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
        if(!Date::isDateTimeOk($this->_datfin)) {
            return false;
        }

        preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})$/", $this->_datfin, $regs);
        if($mode == 'year') {
            return $regs[1];
        } elseif($mode == 'month') {
            return $regs[2];
        } elseif($mode == 'day') {
            return $regs[3];
        } elseif($mode == 'hour') {
            return $regs[4];
        } elseif($mode == 'minute') {
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
        return STATIC_URL . '/media/featured/' . (int) $id . '.jpg';
    }

    /**
     * @return int
     */
    function getSlot()
    {
        return (int) $this->_slot;
    }

    /**
     * @return string
     */
    function getSlotName()
    {
        return (string) self::getSlotNameBySlotId((int) $this->getSlot());
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
        if(!Date::isDateTimeOk($val)) {
            throw new Exception('datdeb invalide', EXCEPTION_USER_BAD_PARAM);
        }

        if ($this->_datdeb != $val)
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
        if(!Date::isDateTimeOk($val)) {
            throw new Exception('datfin invalide', EXCEPTION_USER_BAD_PARAM);
        }

        if ($this->_datfin != $val)
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
        if ($this->_title != $val)
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
        if ($this->_description != $val)
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
        if ($this->_link != $val)
        {
            $this->_link = (string) $val;
            $this->_modified_fields['link'] = true;
        }
    }

    /**
     * @param int
     */
    function setSlot($val)
    {
        $val = (int) $val;
        if ($this->_slot != $val)
        {
            $this->_slot = (int) $val;
            $this->_modified_fields['slot'] = true;
        }
    }

    /**
     * @param bool
     */
    function setOnline($val)
    {
        $val = (bool) $val;
        if ($this->_online != $val)
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

        // sans tri par slot
        $sql = "SELECT `id_featured`AS `id`, `title`, `description`, `link`
                FROM `" . self::$_db_table_featured . "`
                WHERE `datdeb` < NOW()
                AND `datfin` > NOW()
                AND `online`
                ORDER BY RAND()
                LIMIT 0,4";

        // avec tri par slot
/*
        $sql = "SELECT `id_featured` AS `id`, `title`, `description`, `link`, `datdeb`, `datfin`, `slot` "
             . "FROM ( "
             . "  SELECT * FROM `" . self::$_db_table_featured . "` "
             . "  WHERE `datdeb` < NOW() AND `datfin` > NOW() "
             . "  AND `online` "
             . "  ORDER BY RAND() "
             . ") AS `a` "
             . "GROUP BY `slot` "
             . "ORDER BY `slot` ASC";
*/

        $res = $db->queryWithFetch($sql);

        foreach($res as $cpt => $_res) {
            $res[$cpt]['image'] = self::getImageById($_res['id']);
            $res[$cpt]['image_120_120'] = self::getImageUrl($_res['id'], 120, 120, '000000', false, true);
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

        $tab = array();
        if(is_array($res))
        {
            $cpt = 0;
            $now = date('Y-m-d H:i:s');
            foreach($res as $cpt => $_res)
            {
                $tab[$cpt] = $_res;
                $tab[$cpt]['slot_name'] = self::getSlotNameBySlotId($_res['slot']);
                $tab[$cpt]['image'] = self::getImageById($_res['id']);
                if(($now > $_res['datdeb']) && ($now < $_res['datfin'])) {
                    $tab[$cpt]['class'] = 'enligne';
                } elseif($now < $_res['datdeb']) {
                    $tab[$cpt]['class'] = "programme";
                } elseif($now > $_res['datfin']) {
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

        $sql = "SELECT `id_featured`, `title`, `description`, `link`, `datdeb`, `datfin`, `slot`, `online` "
             . "FROM `" . self::$_table . "` "
             . "WHERE `id_featured` = " . (int) $this->_id_featured;

        if($res = $db->queryWithFetchFirstRow($sql)) {
            $this->_dbToObject($res);
            return true;
        }

        throw new Exception('Featured introuvable', EXCEPTION_USER_UNKNOW_ID);
    }

    /**
     * efface un featured en db + le fichier .jpg
     *
     * @return true
     */
    function delete()
    {
        if(parent::delete())
        {
            self::invalidateImageInCache($this->getId(), 120, 120);
            if(file_exists(ADHOC_ROOT_PATH . '/media/featured/' . $this->getId() . '.jpg')) {
                unlink(ADHOC_ROOT_PATH . '/media/featured/' . $this->getId() . '.jpg');
            }
            return true;
        }
        return false;
    }

    static function invalidateImageInCache($id, $width = 120, $height = 120, $bgcolor = '000000', $border = 0, $zoom = 1)
    {
        $uid = 'featured/' . $id . '/' . $width . '/' . $height . '/' . $bgcolor . '/' . $border . '/' . $zoom . '.jpg';
        $cache = Image::getLocalCachePath($uid);

        if(file_exists($cache)) {
            unlink($cache);
            return true;
        }

        return false;
    }

    /**
     * retourne l'url de l'image redimensionée
     * gestion de la mise en cache
     *
     * @return string
     */
    static function getImageUrl($id, $width = 120, $height = 120, $bgcolor = '000000', $border = 0, $zoom = 1)
    {
        $uid = 'featured/' . $id . '/' . $width . '/' . $height . '/' . $bgcolor . '/' . $border . '/' . $zoom . '.jpg';
        $cache = Image::getLocalCachePath($uid);

        if(!file_exists($cache)) {
            $source = ADHOC_ROOT_PATH . '/media/featured/' . $id . '.jpg';
            if(file_exists($source)) {
                $img = new Image($source);
                $img->setType(IMAGETYPE_JPEG);
                $img->setMaxWidth($width);
                $img->setMaxHeight($height);
                $img->setBorder($border);
                $img->setKeepRatio(true);
                if($zoom) {
                    $img->setZoom();
                }
                $img->setHexColor($bgcolor);
                Image::writeCache($uid, $img->get());
            } else {
                $img = new Image();
                $img->init(16, 16, '000000');
                Image::writeCache($uid, $img->get());
                Log::write('featured', 'image ' . $id . ' introuvable | uid : ' . $uid);
            }
        }

        return Image::getHttpCachePath($uid);
    }
}
