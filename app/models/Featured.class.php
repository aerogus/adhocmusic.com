<?php declare(strict_types=1);

/**
 * Classe Featured
 *
 * Classe de gestion du module sélection du mois
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
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
     *
     * @var array
     */
    protected static $_all_fields = [
        'id_featured' => 'int',
        'datdeb'      => 'string',
        'datfin'      => 'string',
        'title'       => 'string',
        'description' => 'string',
        'link'        => 'string',
        'slot'        => 'int',
        'online'      => 'bool',
    ];

    /* début getters */

    /**
     * @return string
     */
    static function getBaseUrl(): string
    {
        return MEDIA_URL . '/featured';
    }

    /**
     * @return string
     */
    static function getBasePath(): string
    {
        return MEDIA_PATH . '/featured';
    }

    /**
     * @param string $mode mode
     *
     * @return string
     */
    function getDatDeb(string $mode = null)
    {
        if (!Date::isDateTimeOk($this->_datdeb)) {
            return false;
        }

        preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})$/", $this->_datdeb, $regs);
        switch ($mode) {
            case 'year':
                return $regs[1];
            case 'month':
                return $regs[2];
            case 'day':
                return $regs[3];
            case 'hour':
                return $regs[4];
            case 'minute':
                return $regs[5];
            default:
                return $this->_datdeb;
        }
    }

    /**
     * @param string $mode mode
     *
     * @return string
     */
    function getDatFin(string $mode = null)
    {
        if (!Date::isDateTimeOk($this->_datfin)) {
            return false;
        }

        preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})$/", $this->_datfin, $regs);
        switch ($mode) {
            case 'year':
                return $regs[1];
            case 'month':
                return $regs[2];
            case 'day':
                return $regs[3];
            case 'hour':
                return $regs[4];
            case 'minute':
                return $regs[5];
            default:
                return $this->_datfin;
        }
    }

    /**
     * @return string
     */
    function getTitle(): string
    {
        return $this->_title;
    }

    /**
     * @return string
     */
    function getDescription(): string
    {
        return $this->_description;
    }

    /**
     * @return string
     */
    function getLink(): string
    {
        return $this->_link;
    }

    /**
     * @return string
     */
    function getImage(): string
    {
        return self::getImageById((int) $this->getId());
    }

    /**
     * @param int $id id
     *
     * @return string
     */
    static function getImageById(int $id): string
    {
        return self::getBaseUrl() . '/' . (string) $id . '.jpg';
    }

    /**
     * @return bool
     */
    function getOnline(): bool
    {
        return $this->_online;
    }

    /* fin getters */

    /* début setters */

    /**
     * @param string $datdeb date format YYYY-MM-DD HH:II:SS
     *
     * @return object
     */
    function setDatDeb(string $datdeb): object
    {
        if (!Date::isDateTimeOk($datdeb)) {
            throw new Exception('datdeb invalide');
        }

        if ($this->_datdeb !== $datdeb) {
            $this->_datdeb = $datdeb;
            $this->_modified_fields['datdeb'] = true;
        }

        return $this;
    }

    /**
     * @param string $datfin YYYY-MM-DD HH:II:SS
     *
     * @return object
     */
    function setDatFin(string $datfin): object
    {
        if (!Date::isDateTimeOk($datfin)) {
            throw new Exception('datfin invalide');
        }

        if ($this->_datfin !== $datfin) {
            $this->_datfin = $datfin;
            $this->_modified_fields['datfin'] = true;
        }

        return $this;
    }

    /**
     * @param string $title titre
     *
     * @return object
     */
    function setTitle(string $title): object
    {
        $title = trim($title);

        if ($this->_title !== $title) {
            $this->_title = $title;
            $this->_modified_fields['title'] = true;
        }

        return $this;
    }

    /**
     * @param string $description description
     *
     * @return object
     */
    function setDescription(string $description): object
    {
        $description = trim($description);

        if ($this->_description !== $description) {
            $this->_description = $description;
            $this->_modified_fields['description'] = true;
        }

        return $this;
    }

    /**
     * @param string $link lien
     *
     * @return object
     */
    function setLink(string $link): object
    {
        $link = trim($link);

        if ($this->_link !== $link) {
            $this->_link = $link;
            $this->_modified_fields['link'] = true;
        }

        return $this;
    }

    /**
     * @param bool $online online
     *
     * @return bool
     */
    function setOnline(bool $online): object
    {
        if ($this->_online !== $online) {
            $this->_online = $online;
            $this->_modified_fields['online'] = true;
        }

        return $this;
    }

    /* fin setters */

    /**
     * @return array
     */
    static function getFeaturedHomepage(): array
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_featured` AS `id`, `title`, `description`, `link`
                FROM `" . self::getDbTable() . "`
                WHERE `datdeb` < DATE(NOW())
                AND `datfin` > DATE(NOW())
                AND `online`";

        $res = $db->queryWithFetch($sql);

        foreach ($res as $cpt => $_res) {
            $res[$cpt]['image'] = self::getImageById((int) $_res['id']);
        }

        return $res;
    }

    /**
     * Retourne les à l'affiche
     *
     * @return array
     */
    static function getFeaturedAdmin(): array
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_featured` AS `id`, `title`, `description`, `link`, `datdeb`, `datfin`, `slot`, `online` "
             . "FROM `" . self::getDbTable() . "` "
             . "ORDER BY `online` DESC, `id_featured` DESC";

        $res = $db->queryWithFetch($sql);

        $tab = [];
        if (is_array($res)) {
            $now = date('Y-m-d H:i:s');
            foreach ($res as $cpt => $_res) {
                $tab[$cpt] = $_res;
                $tab[$cpt]['image'] = self::getImageById((int) $_res['id']);
                if (($now > $_res['datdeb']) && ($now < $_res['datfin'])) {
                    $tab[$cpt]['class'] = 'enligne';
                } elseif ($now < $_res['datdeb']) {
                    $tab[$cpt]['class'] = "programme";
                } elseif ($now > $_res['datfin']) {
                    $tab[$cpt]['class'] = "archive";
                }
            }
        }

        return $tab;
    }

    /**
     * Efface un featured en db + le fichier .jpg
     *
     * @return bool
     */
    function delete(): bool
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
}
