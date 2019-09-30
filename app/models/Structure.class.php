<?php declare(strict_types=1);

/**
 * Gestion des Structures / associations
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Structure extends ObjectModel
{
    /**
     * @var object
     */
    protected static $_instance = null;

    /**
     * @var string
     */
    protected static $_pk = 'id_structure';

    /**
     * @var string
     */
    protected static $_table = 'adhoc_structure';

    /**
     * @var int
     */
    protected $_id_structure = 0;

    /**
     * @var string
     */
    protected $_name = '';

    /**
     * @var string
     */
    protected $_address = '';

    /**
     * @var string
     */
    protected $_cp = null;

    /**
     * @var string
     */
    protected $_city = null;

    /**
     * @var string
     */
    protected $_id_country = '';

    /**
     * @var string
     */
    protected $_fax = '';

    /**
     * @var string
     */
    protected $_id_departement = '';

    /**
     * @var string
     */
    protected $_text = '';

    /**
     * @var string
     */
    protected $_site = '';

    /**
     * @var string
     */
    protected $_email = '';

    /**
     * Liste des attributs de l'objet
     * on précise si en base c'est de type :
     * - numérique/integer/float/bool (= int)
     * - datetime/text (= str)
     * ceci est utile pour la formation de la requête
     *
     * @var array
     */
    protected static $_all_fields = [
        'name'           => 'str',
        'address'        => 'str',
        'cp'             => 'str',
        'city'           => 'str',
        'tel'            => 'str',
        'fax'            => 'str',
        'id_departement' => 'str',
        'text'           => 'str',
        'site'           => 'str',
        'email'          => 'str',
        'id_country'     => 'str',
    ];

    /**
     * Tableau des attributs modifiés depuis la dernière sauvegarde.
     *
     * Pour chaque attribut modifié, on a un élément de la forme 'attribut => true'.
     *
     * @var array
     */
    protected $_modified_fields = [];

    /* début getters */

    /**
     * @return string
     */
    static function getBaseUrl(): string
    {
        return MEDIA_URL . '/structure';
    }

    /**
     * @return string
     */
    static function getBasePath(): string
    {
        return MEDIA_PATH . '/structure';
    }

    /**
     * @return string
     */
    function getName(): string
    {
        return $this->_name;
    }

    /**
     * @return string
     */
    function getAddress(): string
    {
        return $this->_address;
    }

    /**
     * @return string
     */
    function getCp(): string
    {
        return $this->_cp;
    }

    /**
     * @return string
     */
    function getCity(): string
    {
        return $this->_city;
    }

    /**
     * @return string
     */
    function getTel(): string
    {
        return $this->_tel;
    }

    /**
     * @return string
     */
    function getFax(): string
    {
        return $this->_fax;
    }

    /**
     * @return string
     */
    function getIdDepartement(): string
    {
        return $this->_id_departement;
    }

    /**
     * @return string
     */
    function getText(): string
    {
        return $this->_text;
    }

    /**
     * @return string
     */
    function getSite(): string
    {
        return $this->_site;
    }

    /**
     * @return string
     */
    function getEmail(): string
    {
        return $this->_email;
    }

    /**
     * @return string
     */
    function getIdCountry(): string
    {
        return $this->_id_country;
    }

    /**
     * @return string
     */
    function getPicto(): string
    {
        return self::getPictoById((int) $this->getId());
    }

    /**
     * @param int $id id
     *
     * @return string
     */
    static function getPictoById($id): string
    {
        return self::getBaseUrl() . '/' . (int) $id . '.png';
    }

    /* fin getters */

    /* début setters */

    /**
     * @param string $val val
     *
     * @return object
     */
    function setName(string $val): object
    {
        if ($this->_name !== $val) {
            $this->_name = $val;
            $this->_modified_fields['name'] = true;
        }

        return $this;
    }

    /**
     * @param string $val val
     *
     * @return object
     */
    function setAddress(string $val): object
    {
        if ($this->_address !== $val) {
            $this->_address = $val;
            $this->_modified_fields['address'] = true;
        }

        return $this;
    }

    /**
     * @param string $val val
     *
     * @return object
     */
    function setCp(string $val): object
    {
        if ($this->_cp !== $val) {
            $this->_cp = $val;
            $this->_modified_fields['cp'] = true;
        }

        return $this;
    }

    /**
     * @param string $val val
     *
     * @return object
     */
    function setCity(string $val): object
    {
        if ($this->_city !== $val) {
            $this->_city = $val;
            $this->_modified_fields['city'] = true;
        }

        return $this;
    }

    /**
     * @param string $val val
     *
     * @return object
     */
    function setTel(string $val): object
    {
        if ($this->_tel !== $val) {
            $this->_tel = $val;
            $this->_modified_fields['tel'] = true;
        }

        return $this;
    }

    /**
     * @param string $val val
     *
     * @return object
     */
    function setFax(string $val): object
    {
        if ($this->_fax !== $val) {
            $this->_fax = $val;
            $this->_modified_fields['fax'] = true;
        }

        return $this;
    }

    /**
     * @param string $val val
     *
     * @return object
     */
    function setIdDepartement(string $val): object
    {
        if ($this->_id_departement !== $val) {
            $this->_id_departement = $val;
            $this->_modified_fields['id_departement'] = true;
        }

        return $this;
    }

    /**
     * @param string $val val
     *
     * @return object
     */
    function setText(string $val): object
    {
        if ($this->_text !== $val) {
            $this->_text = $val;
            $this->_modified_fields['text'] = true;
        }

        return $this;
    }

    /**
     * @param string $val val
     *
     * @return object
     */
    function setSite(string $val): object
    {
        if ($this->_site !== $val) {
            $this->_site = $val;
            $this->_modified_fields['site'] = true;
        }

        return $this;
    }

    /**
     * @param string $val val
     *
     * @return object
     */
    function setEmail(string $val): object
    {
        if ($this->_email !== $val) {
            $this->_email = $val;
            $this->_modified_fields['email'] = true;
        }

        return $this;
    }

    /**
     * @param string $val val
     *
     * @return object
     */
    function setIdCountry(string $val): object
    {
        if ($this->_id_country !== $val) {
            $this->_id_country = $val;
            $this->_modified_fields['id_country'] = true;
        }

        return $this;
    }

    /* fin setters */

    /**
     * Suppression d'une structure
     *
     * @return bool
     * @throws Exception
     */
    function delete()
    {
        // check de la table evenement
        if ($this->hasEvents()) {
            throw new Exception('delete impossible, la structure est liée à des événements');
        }

        // check de la table audio
        if ($this->hasAudios()) {
            throw new Exception('delete impossible, la structure est liée à des audios');
        }

        // check de la table photo
        if ($this->hasPhotos()) {
            throw new Exception('delete impossible, la structure est liée à des photos');
        }

        // check de la table video
        if ($this->hasVideos()) {
            throw new Exception('delete impossible, la structure est liée à des vidéos');
        }

        // tout est ok on delete
        $sql = "DELETE FROM `" . Structure::getDbTable() . "` "
             . "WHERE `id_structure` = " . (int) $this->_id_structure;

        $db = DataBase::getInstance();
        $res  = $db->query($sql);
        if ($db->affectedRows()) {
            $file = self::getBasePath() . '/' . $this->_id_structure . '.png';
            if (file_exists($file)) {
                unlink($file);
            }
            return true;
        }
        return false;
    }

    /**
     * Retourne le tableau de toutes les structures dans un tableau associatif
     *
     * @return array
     */
    static function getStructures(): array
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_structure` AS `id`, `name`, `address`, `cp`, "
             . "`city`, `tel`, `fax`, `id_departement`, "
             . "`text`, `site`, `email`, `id_country` "
             . "FROM `" . Structure::getDbTable() . "` "
             . "ORDER BY `id_country` ASC, `id_departement` ASC, `city` ASC";

        $tab = [];
        if ($res = $db->queryWithFetch($sql)) {
            foreach ($res as $struct) {
                $tab[$struct['id']] = $struct;
                $tab[$struct['id']]['picto'] = self::getPictoById($struct['id']);
            }
        }
        return $tab;
    }

    /**
     * Retourne les infos sur une structure
     *
     * @return bool
     * @throws Exception
     */
    function _loadFromDb(): bool
    {
        if (!parent::_loadFromDb()) {
            throw new Exception('Structure introuvable');
        }

        if (file_exists(self::getBasePath() . '/' . (string) $this->_id_structure . '.png')) {
            $this->_photo = self::getBaseUrl() . '/' . (string) $this->_id_structure . '.png';
        }
        return true;
    }

    /**
     * @return bool
     */
    function hasPhotos(): bool
    {
        return (bool) $this->getPhotos();
    }

    /**
     * Retourne les photos associées à cette structure
     *
     * @return array
     */
    function getPhotos(): array
    {
        return Photo::getPhotos(
            [
                'structure' => $this->_id_structure,
            ]
        );
    }

    /**
     * @return bool
     */
    function hasVideos(): bool
    {
        return (bool) $this->getVideos();
    }

    /**
     * Retourne les vidéos associées à cette structure
     *
     * @return array
     */
    function getVideos(): array
    {
        return Video::getVideos(
            [
                'structure' => $this->_id_structure,
            ]
        );
    }

    /**
     * @return bool
     */
    function hasAudios(): bool
    {
        return (bool) $this->getAudios();
    }

    /**
     * Retourne les audios associés à cette structure
     *
     * @return array
     */
    function getAudios(): array
    {
        return Audio::getAudios(
            [
                'structure' => $this->_id_structure,
            ]
        );
    }

    /**
     * @return bool
     */
    function hasEvents(): bool
    {
        return (bool) $this->getEvents();
    }

    /**
     * Retourne les événements rattachés à cette structure
     *
     * @return array
     */
    function getEvents(): array
    {
        return Event::getEvents(
            [
                'structure' => $this->_id_structure,
            ]
        );
    }
}
