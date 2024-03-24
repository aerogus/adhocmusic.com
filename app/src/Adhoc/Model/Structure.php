<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Utils\DataBase;
use Adhoc\Utils\ObjectModel;

/**
 * Gestion des Structures / associations
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class Structure extends ObjectModel
{
    /**
     * @var string|array<string>
     */
    protected static string|array $pk = 'id_structure';

    /**
     * @var string
     */
    protected static string $table = 'adhoc_structure';

    /**
     * @var ?int
     */
    protected ?int $id_structure = null;

    /**
     * @var ?string
     */
    protected ?string $name = null;

    /**
     * @var ?string
     */
    protected ?string $address = null;

    /**
     * @var ?string
     */
    protected ?string $cp = null;

    /**
     * @var ?string
     */
    protected ?string $city = null;

    /**
     * @var ?string
     */
    protected ?string $tel = null;

    /**
     * @var ?string
     */
    protected ?string $id_country = null;

    /**
     * @var ?string
     */
    protected ?string $id_departement = null;

    /**
     * @var ?string
     */
    protected ?string $text = null;

    /**
     * @var ?string
     */
    protected ?string $site = null;

    /**
     * @var ?string
     */
    protected ?string $email = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
        'id_structure' => 'int', // pk
        'name' => 'string',
        'address' => 'string',
        'cp' => 'string',
        'city' => 'string',
        'tel' => 'string',
        'id_departement' => 'string',
        'text' => 'string',
        'site' => 'string',
        'email' => 'string',
        'id_country' => 'string',
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
     * @return ?int
     */
    public function getIdStructure(): ?int
    {
        return $this->id_structure;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getCp(): string
    {
        return $this->cp;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return ?string
     */
    public function getTel(): ?string
    {
        return $this->tel;
    }

    /**
     * @return string
     */
    public function getIdDepartement(): string
    {
        return $this->id_departement;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getSite(): string
    {
        return $this->site;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getIdCountry(): string
    {
        return $this->id_country;
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
     * @return static
     */
    public function setName(string $name): static
    {
        if ($this->name !== $name) {
            $this->name = $name;
            $this->modified_fields['name'] = true;
        }

        return $this;
    }

    /**
     * @param string $address adresse
     *
     * @return static
     */
    public function setAddress(string $address): static
    {
        if ($this->address !== $address) {
            $this->address = $address;
            $this->modified_fields['address'] = true;
        }

        return $this;
    }

    /**
     * @param string $cp code postal
     *
     * @return static
     */
    public function setCp(string $cp): static
    {
        if ($this->cp !== $cp) {
            $this->cp = $cp;
            $this->modified_fields['cp'] = true;
        }

        return $this;
    }

    /**
     * @param string $city city
     *
     * @return static
     */
    public function setCity(string $city): static
    {
        if ($this->city !== $city) {
            $this->city = $city;
            $this->modified_fields['city'] = true;
        }

        return $this;
    }

    /**
     * @param string $tel téléphone
     *
     * @return static
     */
    public function setTel(string $tel): static
    {
        if ($this->tel !== $tel) {
            $this->tel = $tel;
            $this->modified_fields['tel'] = true;
        }

        return $this;
    }

    /**
     * @param string $id_departement id_departement
     *
     * @return static
     */
    public function setIdDepartement(string $id_departement): static
    {
        if ($this->id_departement !== $id_departement) {
            $this->id_departement = $id_departement;
            $this->modified_fields['id_departement'] = true;
        }

        return $this;
    }

    /**
     * @param string $text texte
     *
     * @return static
     */
    public function setText(string $text): static
    {
        if ($this->text !== $text) {
            $this->text = $text;
            $this->modified_fields['text'] = true;
        }

        return $this;
    }

    /**
     * @param string $site site
     *
     * @return static
     */
    public function setSite(string $site): static
    {
        if ($this->site !== $site) {
            $this->site = $site;
            $this->modified_fields['site'] = true;
        }

        return $this;
    }

    /**
     * @param string $email email
     *
     * @return static
     */
    public function setEmail(string $email): static
    {
        if ($this->email !== $email) {
            $this->email = $email;
            $this->modified_fields['email'] = true;
        }

        return $this;
    }

    /**
     * @param string $id_country id_country
     *
     * @return static
     */
    public function setIdCountry(string $id_country): static
    {
        if ($this->id_country !== $id_country) {
            $this->id_country = $id_country;
            $this->modified_fields['id_country'] = true;
        }

        return $this;
    }

    /* fin setters */

    /**
     * Suppression d'une structure
     *
     * @return bool
     * @throws \Exception
     */
    public function delete(): bool
    {
        if (parent::delete()) {
            $pngFile = self::getBasePath() . '/' . $this->id_structure . '.png';
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
     *                                'id_event' => int,
     *                                'order_by' => string,
     *                                'sort' => string,
     *                                'start' => int,
     *                                'limit' => int,
     *                            ]
     *
     * @return array<static>
     */
    public static function find(array $params): array
    {
        $db = DataBase::getInstance();
        $objs = [];

        $sql  = "SELECT `" . static::getDbPk() . "` ";
        $sql .= "FROM `" . static::getDbTable() . "` ";
        $sql .= "WHERE 1 ";

        if (isset($params['id_event'])) {
            $subSql = "SELECT `id_structure` FROM `adhoc_organise_par` WHERE `id_event` = " . (int) $params['id_event'] . " ";
            if ($ids_structure = $db->pdo->query($subSql)->fetchAll(\PDO::FETCH_COLUMN)) {
                $sql .= "AND `id_structure` IN (" . implode(',', (array) $ids_structure) . ") ";
            } else {
                return $objs;
            }
        }

        if ((isset($params['order_by']) && (in_array($params['order_by'], array_keys(static::$all_fields), true)))) {
            $sql .= "ORDER BY `" . $params['order_by'] . "` ";
        } else {
            $sql .= "ORDER BY `" . static::getDbPk() . "` ";
        }

        if ((isset($params['sort']) && (in_array($params['sort'], ['ASC', 'DESC'], true)))) {
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

        $ids = $db->pdo->query($sql)->fetchAll(\PDO::FETCH_COLUMN);
        foreach ($ids as $id) {
            $objs[] = static::getInstance((int) $id);
        }

        return $objs;
    }
}
