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
    const WIDTH = 1000;
    const HEIGHT = 375;

    /**
     * Instance de l'objet
     *
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
    protected $_url = '';

    /**
     * @var bool
     */
    protected $_online = false;

    /**
     * Liste des attributs de l'objet
     *
     * @var array
     */
    protected static $_all_fields = [
        'id_featured' => 'int', // pk
        'datdeb'      => 'date',
        'datfin'      => 'date',
        'title'       => 'string',
        'description' => 'string',
        'url'         => 'string',
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
     * @return string
     */
    function getDatDeb(): string
    {
        return $this->_datdeb;
    }

    /**
     * @return string
     */
    function getDatFin(): string
    {
        return $this->_datfin;
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
    function getUrl(): string
    {
        return $this->_url;
    }

    /**
     * @return string
     */
    function getImage(): string
    {
        return self::getBaseUrl() . '/' . (string) $this->getId() . '.jpg';
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
     * @param string $url lien
     *
     * @return object
     */
    function setUrl(string $url): object
    {
        $url = trim($url);

        if ($this->_url !== $url) {
            $this->_url = $url;
            $this->_modified_fields['url'] = true;
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
