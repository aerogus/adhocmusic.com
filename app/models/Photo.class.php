<?php

/**
 * @package adhoc
 */

/**
 * Classe Photo
 *
 * Classe de gestion des photos du site
 * Upload, Appel conversion etc ...
 *
 * @package adhoc
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class Photo extends Media
{
    /**
     * @var object
     */
    protected static $_instance = null;

    /**
     * @var string
     */
    protected static $_pk = 'id_photo';

    /**
     * @var string
     */
    protected static $_table = 'adhoc_photo';

    /**
     * @var int
     */
    protected $_id_photo = 0;

    /**
     * @var string
     */
    protected $_pseudo = '';

    /**
     * @var int
     */
    protected $_height = 0;

    /**
     * @var int
     */
    protected $_width = 0;

    /**
     * @var string
     */
    protected $_credits = '';

    /**
     * Liste des attributs de l'objet
     * on précise si en base c'est de type :
     * - numérique/integer/float/bool (= num)
     * - datetime/text (= str)
     * ceci est utile pour la formation de la requête
     * @var array
     */
    protected static $_all_fields = [
        'id_contact'   => 'num',
        'id_groupe'    => 'num',
        'id_lieu'      => 'num',
        'id_event'     => 'num',
        'id_structure' => 'num',
        'name'         => 'str',
        'created_on'   => 'date',
        'modified_on'  => 'date',
        'online'       => 'bool',
        'credits'      => 'str',
    ];

    /**
     * Tableau des attributs modifiés depuis la dernière sauvegarde.
     *
     * Pour chaque attribut modifié, on a un élément de la forme 'attribut => true'.
     * @var array
     */
    protected $_modified_fields = [];

    /* debut getters */

    /**
     * @return string
     */
    static function getBaseUrl()
    {
        return MEDIA_URL . '/photo';
    }

    /**
     * @return string
     */
    static function getBasePath()
    {
        return MEDIA_PATH . '/photo';
    }

    /**
     * @return string
     */
    function getPseudo()
    {
        return (string) $this->_pseudo;
    }


    /**
     * @return int
     */
    function getHeight()
    {
        return (int) $this->_height;
    }

    /**
     * @return int
     */
    function getWidth()
    {
        return (int) $this->_width;
    }



    /**
     * @return string
     */
    function getCredits()
    {
        return (string) $this->_credits;
    }

    /**
     * @return string
     */
    function getUrl($type = null)
    {
        return self::getUrlById($this->getId(), $type);
    }

    /**
     * @param int $id
     * @return string
     */
    static function getUrlById($id, $type = null)
    {
        return HOME_URL . '/photos/' . (int) $id;
    }

    /* fin getters */

    /* debut setters */


    /**
     * @param string
     */
    function setCredits($val)
    {
        if ($this->_credits != $val)
        {
            $this->_credits = (string) $val;
            $this->_modified_fields['credits'] = true;
        }
    }

    /* fin setters */

    /**
     * efface une photo de la table photo + le fichier .jpg
     *
     * @return true
     */
    function delete()
    {
        if (parent::delete())
        {
            self::invalidatePhotoInCache($this->getId(),  80,  80, '000000', false,  true);
            self::invalidatePhotoInCache($this->getId(), 130, 130, '000000', false, false);
            self::invalidatePhotoInCache($this->getId(), 400, 300, '000000', false, false);
            self::invalidatePhotoInCache($this->getId(), 680, 600, '000000', false, false);

            $file = self::getBasePath() . '/' . $this->getId() . '.jpg';
            if (file_exists($file)) {
                unlink($file);
            }
            return true;
        }
        return false;
    }

    /**
     * retourne le nombre total de photos du visiteur loggué
     *
     * @return int
     */
    static function getMyPhotosCount()
    {
        if (empty($_SESSION['membre'])) {
            throw new Exception('non identifié');
        }

        if (isset($_SESSION['my_counters']['nb_photos'])) {
            return $_SESSION['my_counters']['nb_photos'];
        }

        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(*) "
             . "FROM `".self::$_db_table_photo."` "
             . "WHERE `id_contact` = " . (int) $_SESSION['membre']->getId();

        $nb_photos = $db->queryWithFetchFirstField($sql);

        $_SESSION['my_counters']['nb_photos'] = $nb_photos;

        return $_SESSION['my_counters']['nb_photos'];
    }

    /**
     * retourne le nombre total de photos
     *
     * @return int
     */
    static function getPhotosCount()
    {
        if (isset($_SESSION['global_counters']['nb_photos'])) {
            return $_SESSION['global_counters']['nb_photos'];
        }

        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(*) "
             . "FROM `" . self::$_db_table_photo . "`";

        $nb_photos = $db->queryWithFetchFirstField($sql);

        $_SESSION['global_counters']['nb_photos'] = $nb_photos;

        return $_SESSION['global_counters']['nb_photos'];
    }

    /**
     * recherche des photos en fonction de critères donnés
     *
     * @param array ['groupe']    => "5"
     *              ['structure'] => "1,3"
     *              ['lieu']      => "1"
     *              ['event']     => "1"
     *              ['id']        => "3"
     *              ['contact']   => "1"
     *              ['sort']      => "id_photo|date|random"
     *              ['sens']      => "ASC"
     *              ['debut']     => 0
     *              ['limit']     => 10
     *              ['fetchtags'] => false
     * @return array
     */
    static function getPhotos($params = [])
    {
        $debut = 0;
        if (isset($params['debut'])) {
            $debut = (int) $params['debut'];
        }

        $limit = 10;
        if (isset($params['limit'])) {
            $limit = (int) $params['limit'];
        }

        $sens = 'ASC';
        if (isset($params['sens']) && $params['sens'] == 'DESC') {
            $sens = 'DESC';
        }

        $sort = 'id_photo';
        if (isset($params['sort'])
           && ($params['sort'] == 'created_on' || $params['sort'] == 'random')) {
            $sort = $params['sort'];
        }

        $fetchtags = false;
        if (isset($params['fetchtags'])) {
            $fetchtags = (bool) $params['fetchtags'];
        }

        $tab_groupe    = [];
        $tab_structure = [];
        $tab_lieu      = [];
        $tab_event     = [];
        $tab_id        = [];
        $tab_contact   = [];

        if (array_key_exists('groupe', $params))    { $tab_groupe    = explode(",", $params['groupe']); }
        if (array_key_exists('structure', $params)) { $tab_structure = explode(",", $params['structure']); }
        if (array_key_exists('lieu', $params))      { $tab_lieu      = explode(",", $params['lieu']); }
        if (array_key_exists('event', $params))     { $tab_event     = explode(",", $params['event']); }
        if (array_key_exists('id', $params))        { $tab_id        = explode(",", $params['id']); }
        if (array_key_exists('contact', $params))   { $tab_contact   = explode(",", $params['contact']); }

        $db = DataBase::getInstance();

        $sql = "SELECT `p`.`id_photo` AS `id`, `p`.`name`, `p`.`credits`, `p`.`online`, `p`.`created_on`, 'photo' AS `type`, "
             . "`g`.`id_groupe` AS `groupe_id`, `g`.`name` AS `groupe_name`, `g`.`alias` AS `groupe_alias`, "
             . "`s`.`id_structure` AS `structure_id`, `s`.`name` AS `structure_name`, "
             . "`l`.`id_lieu` AS `lieu_id`, `l`.`id_departement` AS `departement_id`, `l`.`name` AS `lieu_name`, `l`.`city`, "
             . "`e`.`id_event` AS `event_id`, `e`.`name` AS `event_name`, `e`.`date` AS `event_date`, "
             . "`m`.`id_contact` AS `contact_id`, `m`.`pseudo` "
             . "FROM (`" . self::$_db_table_photo . "` `p`) "
             . "LEFT JOIN `" . self::$_db_table_groupe . "` `g` ON (`p`.`id_groupe` = `g`.`id_groupe`) "
             . "LEFT JOIN `" . self::$_db_table_structure . "` `s` ON (`p`.`id_structure` = `s`.`id_structure`) "
             . "LEFT JOIN `" . self::$_db_table_lieu . "` `l` ON (`p`.`id_lieu` = `l`.`id_lieu`) "
             . "LEFT JOIN `" . self::$_db_table_event . "` `e` ON (`p`.`id_event` = `e`.`id_event`) "
             . "LEFT JOIN `" . self::$_db_table_membre . "` `m` ON (`p`.`id_contact` = `m`.`id_contact`) "
             . "WHERE 1 ";

        if (array_key_exists('online', $params)) {
            if ($params['online']) {
                $online = 'TRUE';
            } else {
                $online = 'FALSE';
            }
            $sql .= "AND `p`.`online` = ".$online." ";
        }

        if (count($tab_groupe) && $tab_groupe[0] != 0) {
            $sql .= "AND `p`.`id_groupe` IN (" . implode(',', $tab_groupe) . ") ";
        }

        if (count($tab_structure) && $tab_structure[0] != 0) {
            $sql .= "AND `p`.`id_structure` IN (" . implode(',', $tab_structure) . ") ";
        }

        if (count($tab_lieu) && $tab_lieu[0] != 0) {
            $sql .= "AND `p`.`id_lieu` IN (" . implode(',', $tab_lieu) . ") ";
        }

        if (count($tab_event) && $tab_event[0] != 0) {
            $sql .= "AND `p`.`id_event` IN (" . implode(',', $tab_event) . ") ";
        }

        if (count($tab_id) && ($tab_id[0] != 0)) {
            $sql .= "AND `p`.`id_photo` IN (" . implode(',', $tab_id) . ") ";
        }

        if (count($tab_contact) && ($tab_contact[0] != 0)) {
            $sql .= "AND `p`.`id_contact` IN (" . implode(',', $tab_contact) . ") ";
        }

        $sql .= "ORDER BY ";
        if ($sort == "random") {
            $sql .= "RAND(" . time() . ") ";
        } else {
            $sql .= "`p`.`" . $sort . "` " . $sens . " ";
        }
        $sql .= "LIMIT " . $debut . ", " . $limit;

        $tab = [];

        $cpt = 0;
        if ($res = $db->queryWithFetch($sql)) {
            foreach ($res as $_res) {
                $tab[$cpt] = $_res;
                $tab[$cpt]['url'] = Photo::getUrlById($_res['id']);
                $tab[$cpt]['thumb_80_80']   = Photo::getPhotoUrl($_res['id'],  80,  80, '000000', false,  true);
                $tab[$cpt]['thumb_130_130'] = Photo::getPhotoUrl($_res['id'], 130, 130, '000000', false, false);
                $tab[$cpt]['thumb_400_300'] = Photo::getPhotoUrl($_res['id'], 400, 300, '000000', false, false);
                $tab[$cpt]['thumb_680_600'] = Photo::getPhotoUrl($_res['id'], 680, 600, '000000', false, false);
                $cpt++;
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

        $sql = "SELECT `p`.`name`, `p`.`created_on`, `p`.`modified_on`, "
             . "`p`.`credits`, `p`.`online`, `m`.`pseudo`, "
             . "`p`.`id_groupe`, `p`.`id_structure`, "
             . "`p`.`id_lieu`, `p`.`id_event`, `p`.`id_contact` "
             . "FROM `" . self::$_db_table_photo . "` `p` "
             . "LEFT JOIN `" . self::$_db_table_groupe . "` `g` ON (`p`.`id_groupe` = `g`.`id_groupe`) "
             . "LEFT JOIN `" . self::$_db_table_structure . "` `s` ON (`p`.`id_structure` = `s`.`id_structure`) "
             . "LEFT JOIN `" . self::$_db_table_lieu . "` `l` ON (`p`.`id_lieu` = `l`.`id_lieu`) "
             . "LEFT JOIN `" . self::$_db_table_event . "` `e` ON (`p`.`id_event` = `e`.`id_event`) "
             . "LEFT JOIN `" . self::$_db_table_membre . "` `m` ON (`p`.`id_contact` = `m`.`id_contact`) "
             . "WHERE `p`.`id_photo` = " . (int) $this->_id_photo;

        if ($res = $db->queryWithFetchFirstRow($sql)) {
            $this->_dbToObject($res);
            $this->_pseudo = $res['pseudo'];
            return true;
        }

        throw new Exception('Photo introuvable');
    }

    function getThumb80Url()
    {
        return self::getPhotoUrl($this->getId(), 80, 80, '000000', false, true);
    }

    function getThumb130Url()
    {
        return self::getPhotoUrl($this->getId(), 130, 130, '000000', false, false);
    }

    function getThumb400Url()
    {
        return self::getPhotoUrl($this->getId(), 400, 300, '000000', false, false);
    }

    function getThumb680Url()
    {
        return self::getPhotoUrl($this->getId(), 680, 600, '000000', false, false);
    }

    static function invalidatePhotoInCache($id, $width = 80, $height = 80, $bgcolor = '000000', $border = 0, $zoom = 0)
    {
        $uid = 'photo/' . $id . '/' . $width . '/' . $height . '/' . $bgcolor . '/' . $border . '/' . $zoom . '.jpg';
        $cache = Image::getLocalCachePath($uid);

        if (file_exists($cache)) {
            unlink($cache);
            return true;
        }

        return false;
    }

    /**
     * retourne l'url de la photo
     * gestion de la mise en cache
     *
     * @return string
     */
    static function getPhotoUrl($id, $width = 80, $height = 80, $bgcolor = '000000', $border = 0, $zoom = 0)
    {
        $uid = 'photo/' . $id . '/' . $width . '/' . $height . '/' . $bgcolor . '/' . $border . '/' . $zoom . '.jpg';
        $cache = Image::getLocalCachePath($uid);

        if (!file_exists($cache)) {
            $source = self::getBasePath() . '/' . $id . '.jpg';
            if (file_exists($source)) {
                $img = new Image($source);
                $img->setType(IMAGETYPE_JPEG);
                $img->setMaxWidth($width);
                $img->setMaxHeight($height);
                $img->setBorder($border);
                $img->setKeepRatio(true);
                if ($zoom) {
                    $img->setZoom();
                }
                $img->setHexColor($bgcolor);
                Image::writeCache($uid, $img->get());
            } else {
                $img = new Image();
                $img->init(16, 16, '000000');
                Image::writeCache($uid, $img->get());
                Log::write('photo', 'photo ' . $id . ' introuvable | uid : ' . $uid);
            }
        }

        return Image::getHttpCachePath($uid);
    }
}
