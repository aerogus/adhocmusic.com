<?php declare(strict_types=1);

/**
 * Gestion des partenaires
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Partner extends ObjectModel
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
    protected static $_pk = 'id_partner';

    /**
     * @var string
     */
    protected static $_table = 'adhoc_partner';

    /**
     * @var int
     */
    protected $_id_partner = 0;

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
     * Liste des attributs de l'objet
     *
     * @var array
     */
    protected static $_all_fields = [
        'id_partner'  => 'int', // pk
        'title'       => 'string',
        'description' => 'string',
        'url'         => 'string',
    ];

    /* début getters */

    /**
     * @return string
     */
    static function getBaseUrl(): string
    {
        return MEDIA_URL . '/partner';
    }

    /**
     * @return string
     */
    static function getBasePath(): string
    {
        return MEDIA_PATH . '/partner';
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
     * @return string|null
     */
    function getIconUrl(): ?string
    {
        if (file_exists(self::getBasePath() . '/' . $this->getId() . '.png')) {
            return self::getBaseUrl() . '/' . $this->getId() . '.png';
        }
        return null;
    }

    /* fin getters */

    /* début setters */

    /**
     * @param string $title titre
     *
     * @return object
     */
    function setTitle(string $title): object
    {
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
        if ($this->_description !== $description) {
            $this->_description = $description;
            $this->_modified_fields['description'] = true;
        }

        return $this;
    }

    /**
     * @param string $url url
     *
     * @return object
     */
    function setUrl(string $url): object
    {
        if ($this->_url !== $url) {
            $this->_url = $url;
            $this->_modified_fields['url'] = true;
        }

        return $this;
    }

    /* fin setters */
}