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
        'id_structure'   => 'int',
        'name'           => 'string',
        'address'        => 'string',
        'cp'             => 'string',
        'city'           => 'string',
        'tel'            => 'string',
        'id_departement' => 'string',
        'text'           => 'string',
        'site'           => 'string',
        'email'          => 'string',
        'id_country'     => 'string',
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
    static function getPictoById(int $id): string
    {
        return self::getBaseUrl() . '/' . (string) $id . '.png';
    }

    /* fin getters */

    /* début setters */

    /**
     * @param string $name name
     *
     * @return object
     */
    function setName(string $name): object
    {
        if ($this->_name !== $name) {
            $this->_name = $name;
            $this->_modified_fields['name'] = true;
        }

        return $this;
    }

    /**
     * @param string $address adresse
     *
     * @return object
     */
    function setAddress(string $address): object
    {
        if ($this->_address !== $address) {
            $this->_address = $address;
            $this->_modified_fields['address'] = true;
        }

        return $this;
    }

    /**
     * @param string $cp code postal
     *
     * @return object
     */
    function setCp(string $cp): object
    {
        if ($this->_cp !== $cp) {
            $this->_cp = $cp;
            $this->_modified_fields['cp'] = true;
        }

        return $this;
    }

    /**
     * @param string $city city
     *
     * @return object
     */
    function setCity(string $city): object
    {
        if ($this->_city !== $city) {
            $this->_city = $city;
            $this->_modified_fields['city'] = true;
        }

        return $this;
    }

    /**
     * @param string $tel téléphone
     *
     * @return object
     */
    function setTel(string $tel): object
    {
        if ($this->_tel !== $tel) {
            $this->_tel = $tel;
            $this->_modified_fields['tel'] = true;
        }

        return $this;
    }

    /**
     * @param string $id_departement id_departement
     *
     * @return object
     */
    function setIdDepartement(string $id_departement): object
    {
        if ($this->_id_departement !== $id_departement) {
            $this->_id_departement = $id_departement;
            $this->_modified_fields['id_departement'] = true;
        }

        return $this;
    }

    /**
     * @param string $text texte
     *
     * @return object
     */
    function setText(string $text): object
    {
        if ($this->_text !== $text) {
            $this->_text = $text;
            $this->_modified_fields['text'] = true;
        }

        return $this;
    }

    /**
     * @param string $site site
     *
     * @return object
     */
    function setSite(string $site): object
    {
        if ($this->_site !== $site) {
            $this->_site = $site;
            $this->_modified_fields['site'] = true;
        }

        return $this;
    }

    /**
     * @param string $email email
     *
     * @return object
     */
    function setEmail(string $email): object
    {
        if ($this->_email !== $email) {
            $this->_email = $email;
            $this->_modified_fields['email'] = true;
        }

        return $this;
    }

    /**
     * @param string $id_country id_country
     *
     * @return object
     */
    function setIdCountry(string $id_country): object
    {
        if ($this->_id_country !== $id_country) {
            $this->_id_country = $id_country;
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
        if (parent::delete()) {
            $file = self::getBasePath() . '/' . $this->_id_structure . '.png';
            if (file_exists($file)) {
                unlink($file);
            }
            return true;
        }
        return false;
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
