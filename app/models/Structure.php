<?php

declare(strict_types=1);

namespace Adhoc\Model;

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
    protected static string $_pk = 'id_structure';

    /**
     * @var string
     */
    protected static string $_table = 'adhoc_structure';

    /**
     * @var int
     */
    protected int $_id_structure = 0;

    /**
     * @var string
     */
    protected string $_name = '';

    /**
     * @var string
     */
    protected string $_address = '';

    /**
     * @var ?string
     */
    protected ?string $_cp = null;

    /**
     * @var ?string
     */
    protected ?string $_city = null;

    /**
     * @var string
     */
    protected string $_id_country = '';

    /**
     * @var string
     */
    protected string $_id_departement = '';

    /**
     * @var string
     */
    protected string $_text = '';

    /**
     * @var string
     */
    protected string $_site = '';

    /**
     * @var string
     */
    protected string $_email = '';

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
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
    public static function getBaseUrl(): string
    {
        return MEDIA_URL . '/structure';
    }

    /**
     * @return string
     */
    public static function getBasePath(): string
    {
        return MEDIA_PATH . '/structure';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->_name;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->_address;
    }

    /**
     * @return string
     */
    public function getCp(): string
    {
        return $this->_cp;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->_city;
    }

    /**
     * @return string
     */
    public function getIdDepartement(): string
    {
        return $this->_id_departement;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->_text;
    }

    /**
     * @return string
     */
    public function getSite(): string
    {
        return $this->_site;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->_email;
    }

    /**
     * @return string
     */
    public function getIdCountry(): string
    {
        return $this->_id_country;
    }

    /**
     * @return string
     */
    public function getPicto(): string
    {
        return self::getPictoById((int) $this->getId());
    }

    /**
     * @param int $id id
     *
     * @return string
     */
    public static function getPictoById(int $id): string
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
    public function setName(string $name): object
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
    public function setAddress(string $address): object
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
    public function setCp(string $cp): object
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
    public function setCity(string $city): object
    {
        if ($this->_city !== $city) {
            $this->_city = $city;
            $this->_modified_fields['city'] = true;
        }

        return $this;
    }

    /**
     * @param string $id_departement id_departement
     *
     * @return object
     */
    public function setIdDepartement(string $id_departement): object
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
    public function setText(string $text): object
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
    public function setSite(string $site): object
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
    public function setEmail(string $email): object
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
    public function setIdCountry(string $id_country): object
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
    public function delete()
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
    public function hasEvents(): bool
    {
        return (bool) $this->getEvents();
    }

    /**
     * Retourne les événements rattachés à cette structure
     *
     * @return array<Event>
     */
    public function getEvents(): array
    {
        return Event::find(
            [
                'id_structure' => $this->getId(),
            ]
        );
    }

    /**
     * Retourne une collection d'objets "Structure" répondant au(x) critère(s) donné(s)
     *
     * @param array<string,mixed> $params [
     *                      'id_event' => int,
     *                      'order_by' => string,
     *                      'sort' => string,
     *                      'start' => int,
     *                      'limit' => int,
     *                      ]
     *
     * @return array<Structure>
     */
    public static function find(array $params): array
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

        if (isset($params['limit'])) {
            $sql .= "LIMIT " . (int) $params['start'] . ", " . (int) $params['limit'];
        }

        $ids = $db->queryWithFetchFirstFields($sql);
        foreach ($ids as $id) {
            $objs[] = static::getInstance((int) $id);
        }

        return $objs;
    }
}
