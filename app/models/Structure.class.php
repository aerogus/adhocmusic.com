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
     * Instance de l'objet
     *
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
     *
     * @var array
     */
    protected static $_all_fields = [
        'id_structure'   => 'int', // pk
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
            $pngFile = self::getBasePath() . '/' . $this->_id_structure . '.png';
            if (file_exists($pngFile)) {
                unlink($pngFile);
            }
            return true;
        }
        return false;
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
        return Photo::find(
            [
                'id_structure' => $this->getIdStructure(),
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
        return Video::find(
            [
                'id_structure' => $this->getIdStructure(),
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
        return Audio::find(
            [
                'id_structure' => $this->getIdStructure(),
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
        return Event::find(
            [
                'id_structure' => $this->getIdStructure(),
            ]
        );
    }

    /**
     * Retourne une collection d'objets "Structure" répondant au(x) critère(s) donné(s)
     *
     * @param array $params [
     *                      'id_event' => int,
     *                      'order_by' => string,
     *                      'sort' => string,
     *                      'start' => int,
     *                      'limit' => int,
     *                      ]
     *
     * @return array
     */
    static function find(array $params): array
    {
        $db = DataBase::getInstance();
        $objs = [];

        $sql = "SELECT `" . static::getDbPk() . "` FROM `" . static::getDbTable() . "` WHERE 1 ";

        if (isset($params['id_event'])) {
            $subSql = "SELECT `id_structure` FROM `adhoc_organise_par` WHERE `id_event` = " . (int) $params['id_event'] . " ";
            if ($ids_structure = $db->queryWithFetchFirstFields($subSql)) {
                $sql .= "AND `id_structure` IN (" . implode(',', (array) $ids_structure) . ") ";
            } else {
                return $objs;
            }
        }

        if ((isset($params['order_by']) && (in_array($params['order_by'], array_keys(static::$_all_fields))))) {
            $sql .= "ORDER BY `" . $params['order_by'] . "` ";
        } else {
            $sql .= "ORDER BY `" . static::getDbPk() . "` ";
        }

        if ((isset($params['sort']) && (in_array($params['sort'], ['ASC', 'DESC'])))) {
            $sql .= $params['sort'];
        } else {
            $sql .= "ASC";
        }

        if (!isset($params['start'])) {
            $params['start'] = 0;
        }

        if (isset($params['start']) && isset($params['limit'])) {
            $sql .= "LIMIT " . (int) $params['start'] . ", " . (int) $params['limit'];
        }

        $ids = $db->queryWithFetchFirstFields($sql);
        foreach ($ids as $id) {
            $objs[] = static::getInstance((int) $id);
        }

        return $objs;
    }
}
