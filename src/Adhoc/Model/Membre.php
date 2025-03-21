<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Model\City;
use Adhoc\Model\Departement;
use Adhoc\Model\TypeMusicien;
use Adhoc\Model\WorldCountry;
use Adhoc\Model\WorldRegion;
use Adhoc\Utils\Date;
use Adhoc\Utils\DataBase;
use Adhoc\Utils\Email;
use Adhoc\Utils\NotFoundException;
use Adhoc\Utils\ObjectModel;

/**
 * Classe Membre
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class Membre extends ObjectModel
{
    /**
     * Gestion des droits utilisateurs
     * par masque binaire
     */
    public const TYPE_STANDARD = 0x01; // 00001
    public const TYPE_REDACTEUR = 0x02; // 00010
    public const TYPE_INTERNE = 0x04; // 00100
    public const TYPE_BONUS = 0x08; // 01000
    public const TYPE_ADMIN = 0x10; // 10000

    /**
     * Tableau des types de membre
     *
     * @var array<int,string>
     */
    protected static $types_membre = [
        self::TYPE_STANDARD => "Standard",
        self::TYPE_REDACTEUR => "Rédacteur",
        self::TYPE_INTERNE => "Interne",
        self::TYPE_BONUS => "Bonus",
        self::TYPE_ADMIN => "Administrateur",
    ];

    /**
     * @var array<string>
     */
    protected static array $pk = [
        'id_contact',
    ];

    /**
     * @var string
     */
    protected static string $table = 'adhoc_membre';

    /**
     * @var ?int
     */
    protected ?int $id_contact = null;

    /**
     * @var ?string
     */
    protected ?string $pseudo = null;

    /**
     * @var ?string
     */
    protected ?string $password = null;

    /**
     * @var ?string
     */
    protected ?string $last_name = null;

    /**
     * @var ?string
     */
    protected ?string $first_name = null;

    /**
     * @var ?string
     */
    protected ?string $address = null;

    /**
     * @var ?int
     */
    protected ?int $id_city = null;

    /**
     * @var ?string
     */
    protected ?string $id_departement = null;

    /**
     * @var ?string
     */
    protected ?string $id_region = null;

    /**
     * @var ?string
     */
    protected ?string $id_country = null;

    /**
     * @var ?string
     */
    protected ?string $tel = null;

    /**
     * @var ?string
     */
    protected ?string $port = null;

    /**
     * @var ?string
     */
    protected ?string $site = null;

    /**
     * @var ?string
     */
    protected ?string $text = null;

    /**
     * @var bool
     */
    protected bool $mailing = false;

    /**
     * @var int
     */
    protected int $level = 0;

    /**
     * @var ?string
     */
    protected ?string $created_at = null;

    /**
     * @var ?string
     */
    protected ?string $modified_at = null;

    /**
     * @var ?string
     */
    protected ?string $visited_at = null;

    // getters helpers avec mini mise en cache

    /**
     * @var ?array<Groupe>
     */
    protected ?array $groupes = null;

    /**
     * @var ?Contact
     */
    protected ?Contact $contact = null;

    /**
     * @var ?City
     */
    protected ?City $city = null;

    /**
     * @var ?Departement
     */
    protected ?Departement $departement = null;

    /**
     * @var ?WorldRegion
     */
    protected ?WorldRegion $region = null;

    /**
     * @var ?WorldCountry
     */
    protected ?WorldCountry $country = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
        'id_contact' => 'int', // pk
        'pseudo' => 'string',
        'password' => 'string', // hashé
        'last_name' => 'string',
        'first_name' => 'string',
        'address' => 'string',
        'id_city' => 'int',
        'id_departement' => 'string',
        'id_region' => 'string',
        'id_country' => 'string',
        'tel' => 'string',
        'port' => 'string',
        'site' => 'string',
        'text' => 'string',
        'mailing' => 'bool',
        'level' => 'int',
        'created_at' => 'date',
        'modified_at' => 'date',
        'visited_at' => 'date',
    ];

    /**
     * @return string
     */
    public static function getBaseUrl(): string
    {
        return MEDIA_URL . '/membre';
    }

    /**
     * @return string
     */
    public static function getBasePath(): string
    {
        return MEDIA_PATH . '/membre';
    }

    /**
     * @return ?int
     */
    public function getIdContact(): ?int
    {
        return $this->id_contact;
    }

    /**
     * @return ?string
     */
    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    /**
     * Retourne le password (version hashée)
     *
     * @return ?string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @return ?string
     */
    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    /**
     * @return ?string
     */
    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    /**
     * @return ?string
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @return ?int
     */
    public function getIdCity(): ?int
    {
        return $this->id_city;
    }

    /**
     * @return ?City
     */
    public function getCity(): ?City
    {
        if (is_null($this->getIdCity())) {
            return null;
        }

        if (is_null($this->city)) {
            $this->city = City::getInstance($this->getIdCity());
        }

        return $this->city;
    }

    /**
     * @return ?string
     */
    public function getIdDepartement(): ?string
    {
        return $this->id_departement;
    }

    /**
     * @return ?Departement
     */
    public function getDepartement(): ?Departement
    {
        if (is_null($this->getIdDepartement())) {
            return null;
        }

        if (is_null($this->departement)) {
            $this->departement = Departement::getInstance($this->getIdDepartement());
        }

        return $this->departement;
    }

    /**
     * @return ?string
     */
    public function getIdRegion(): ?string
    {
        return $this->id_region;
    }

    /**
     * @return ?WorldRegion
     */
    public function getRegion(): ?WorldRegion
    {
        if (is_null($this->getIdRegion())) {
            return null;
        }

        if (is_null($this->region)) {
            $this->region = WorldRegion::getInstance($this->getIdRegion());
        }

        return $this->region;
    }

    /**
     * @return ?string
     */
    public function getIdCountry(): ?string
    {
        return $this->id_country;
    }

    /**
     * @return ?WorldCountry
     */
    public function getCountry(): ?WorldCountry
    {
        if (is_null($this->getIdCountry())) {
            return null;
        }

        if (is_null($this->country)) {
            $this->country = WorldCountry::getInstance($this->getIdCountry());
        }

        return $this->country;
    }

    /**
     * @return ?string
     */
    public function getTel(): ?string
    {
        return $this->tel;
    }

    /**
     * @return ?string
     */
    public function getPort(): ?string
    {
        return $this->port;
    }

    /**
     * @return ?string
     */
    public function getSite(): ?string
    {
        return $this->site;
    }

    /**
     * @return ?string
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @return bool
     */
    public function getMailing(): bool
    {
        return $this->mailing;
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * @return ?string
     */
    public function getCreatedAt(): ?string
    {
        if (!is_null($this->created_at) && Date::isDateTimeOk($this->created_at)) {
            return $this->created_at;
        }
        return null;
    }

    /**
     * @return ?int
     */
    public function getCreatedAtTs(): ?int
    {
        if (!is_null($this->created_at) && Date::isDateTimeOk($this->created_at)) {
            return strtotime($this->created_at);
        }
        return null;
    }

    /**
     * @return ?string
     */
    public function getModifiedAt(): ?string
    {
        if (!is_null($this->modified_at) && Date::isDateTimeOk($this->modified_at)) {
            return $this->modified_at;
        }
        return null;
    }

    /**
     * @return ?int
     */
    public function getModifiedAtTs(): ?int
    {
        if (!is_null($this->modified_at) && Date::isDateTimeOk($this->modified_at)) {
             return strtotime($this->modified_at);
        }
        return null;
    }

    /**
     * @return ?string
     */
    public function getVisitedAt(): ?string
    {
        if (!is_null($this->visited_at) && Date::isDateTimeOk($this->visited_at)) {
            return $this->visited_at;
        }
        return null;
    }

    /**
     * @return ?int
     */
    public function getVisitedAtTs(): ?int
    {
        if (!is_null($this->visited_at) && Date::isDateTimeOk($this->visited_at)) {
             return strtotime($this->visited_at);
        }
        return null;
    }

    /**
     * Retourne l'url de la fiche d'un membre AD'HOC
     *
     * @return string
     */
    public function getUrl(): string
    {
        return HOME_URL . '/membres/' . $this->getIdContact();
    }

    /**
     * @return ?Contact
     */
    public function getContact(): ?Contact
    {
        if (is_null($this->contact)) {
            $this->contact = Contact::getInstance($this->getIdContact());
        }
        return $this->contact;
    }

    /**
     * @return ?string
     */
    public function getEmail(): ?string
    {
        return $this->getContact()->getEmail();
    }

    /**
     * @return array<Groupe>
     */
    public function getGroupes(): array
    {
        if (is_null($this->groupes)) {
            $this->groupes = Groupe::find(
                [
                    'id_contact' => $this->getIdContact(),
                    'online' => true,
                    'order_by' => 'alias',
                    'sort' => 'ASC',
                ]
            );
        }

        return $this->groupes;
    }

    /**
     * Retourne l'url de la photo du membre
     *
     * @return ?string
     */
    public function getAvatarUrl(): ?string
    {
        if (file_exists(self::getBasePath() . '/' . $this->getIdContact() . '.jpg')) {
            return self::getBaseUrl() . '/' . $this->getIdContact() . '.jpg?ts=' . $this->getModifiedAtTs();
        }
        return null;
    }

    /**
     * Retourne l'url de la photo du membre AD'HOC
     *
     * @return ?string
     * @todo uniquement dans MembreAdhoc ?
     */
    public function getAvatarInterneUrl(): ?string
    {
        if (file_exists(self::getBasePath() . '/ca/' . $this->getIdContact() . '.jpg')) {
            return self::getBaseUrl() . '/ca/' . $this->getIdContact() . '.jpg?ts=' . $this->getModifiedAtTs();
        }
        return null;
    }

    /**
     * @param int $id_contact id_contact
     *
     * @return static
     */
    public function setIdContact(int $id_contact): static
    {
        if ($this->id_contact !== $id_contact) {
            $this->id_contact = $id_contact;
            $this->modified_fields['id_contact'] = true;
        }

        return $this;
    }

    /**
     * @param string $pseudo pseudo
     *
     * @return static
     */
    public function setPseudo(string $pseudo): static
    {
        if ($this->pseudo !== $pseudo) {
            $this->pseudo = $pseudo;
            $this->modified_fields['pseudo'] = true;
        }

        return $this;
    }

    /**
     * modifie le mot de passe de l'utilisateur
     *
     * @param string $password (en clair)
     *
     * @return static
     */
    public function setPassword(string $password): static
    {
        $password = password_hash($password, PASSWORD_BCRYPT);

        if ($this->password !== $password) {
            $this->password = $password;
            $this->modified_fields['password'] = true;
        }

        return $this;
    }

    /**
     * @param ?string $last_name last_name
     *
     * @return static
     */
    public function setLastName(?string $last_name): static
    {
        if ($this->last_name !== $last_name) {
            $this->last_name = $last_name;
            $this->modified_fields['last_name'] = true;
        }

        return $this;
    }

    /**
     * @param ?string $first_name first_name
     *
     * @return static
     */
    public function setFirstName(?string $first_name): static
    {
        if ($this->first_name !== $first_name) {
            $this->first_name = $first_name;
            $this->modified_fields['first_name'] = true;
        }

        return $this;
    }

    /**
     * @param ?string $address adresse
     *
     * @return static
     */
    public function setAddress(?string $address): static
    {
        if ($this->address !== $address) {
            $this->address = $address;
            $this->modified_fields['address'] = true;
        }

        return $this;
    }

    /**
     * @param ?int $id_city id_city
     *
     * @return static
     */
    public function setIdCity(?int $id_city): static
    {
        if ($this->id_city !== $id_city) {
            $this->id_city = $id_city;
            $this->modified_fields['id_city'] = true;
        }

        return $this;
    }

    /**
     * @param ?string $id_departement id_departement
     *
     * @return static
     */
    public function setIdDepartement(?string $id_departement): static
    {
        if ($this->id_departement !== $id_departement) {
            $this->id_departement = $id_departement;
            $this->modified_fields['id_departement'] = true;
        }

        return $this;
    }

    /**
     * @param ?string $id_region id_region
     *
     * @return static
     */
    public function setIdRegion(?string $id_region): static
    {
        if ($this->id_region !== $id_region) {
            $this->id_region = $id_region;
            $this->modified_fields['id_region'] = true;
        }

        return $this;
    }

    /**
     * @param ?string $id_country id_country
     *
     * @return static
     */
    public function setIdCountry(?string $id_country): static
    {
        if ($this->id_country !== $id_country) {
            $this->id_country = $id_country;
            $this->modified_fields['id_country'] = true;
        }

        return $this;
    }

    /**
     * @param ?string $tel téléphone
     *
     * @return static
     */
    public function setTel(?string $tel): static
    {
        if ($this->tel !== $tel) {
            $this->tel = $tel;
            $this->modified_fields['tel'] = true;
        }

        return $this;
    }

    /**
     * @param ?string $port port
     *
     * @return static
     */
    public function setPort(?string $port): static
    {
        if ($this->port !== $port) {
            $this->port = $port;
            $this->modified_fields['port'] = true;
        }

        return $this;
    }

    /**
     * @param ?string $site site
     *
     * @return static
     */
    public function setSite(?string $site): static
    {
        if ($this->site !== $site) {
            $this->site = $site;
            $this->modified_fields['site'] = true;
        }

        return $this;
    }

    /**
     * @param ?string $text texte
     *
     * @return static
     */
    public function setText(?string $text): static
    {
        if ($this->text !== $text) {
            $this->text = $text;
            $this->modified_fields['text'] = true;
        }

        return $this;
    }

    /**
     * @param ?bool $mailing mailing
     *
     * @return static
     */
    public function setMailing(?bool $mailing): static
    {
        if ($this->mailing !== $mailing) {
            $this->mailing = $mailing;
            $this->modified_fields['mailing'] = true;
        }

        return $this;
    }

    /**
     * @param ?int $level level
     *
     * @return static
     */
    public function setLevel(?int $level): static
    {
        if ($this->level !== $level) {
            $this->level = $level;
            $this->modified_fields['level'] = true;
        }

        return $this;
    }

    /**
     * @param string $created_at date de création "YYYY-MM-DD HH:II:SS"
     *
     * @return static
     */
    public function setCreatedAt(string $created_at): static
    {
        if ($this->created_at !== $created_at) {
            $this->created_at = $created_at;
            $this->modified_fields['created_at'] = true;
        }

        return $this;
    }

    /**
     * @return static
     */
    public function setCreatedNow(): static
    {
        $now = date('Y-m-d H:i:s');

        if ($this->created_at !== $now) {
            $this->created_at = $now;
            $this->modified_fields['created_at'] = true;
        }

        return $this;
    }

    /**
     * @param ?string $modified_at date de modification "YYYY-MM-DD HH:II:SS"
     *
     * @return static
     */
    public function setModifiedAt(?string $modified_at): static
    {
        if ($this->modified_at !== $modified_at) {
            $this->modified_at = $modified_at;
            $this->modified_fields['modified_at'] = true;
        }

        return $this;
    }

    /**
     * @return static
     */
    public function setModifiedNow(): static
    {
        $now = date('Y-m-d H:i:s');

        if ($this->modified_at !== $now) {
            $this->modified_at = $now;
            $this->modified_fields['modified_at'] = true;
        }

        return $this;
    }

    /**
     * @param ?string $visited_at date de dernière connexion "YYYY-MM-DD HH:II:SS"
     *
     * @return static
     */
    public function setVisitedAt(?string $visited_at): static
    {
        if ($this->visited_at !== $visited_at) {
            $this->visited_at = $visited_at;
            $this->modified_fields['visited_at'] = true;
        }

        return $this;
    }

    /**
     * @return static
     */
    public function setVisitedNow(): static
    {
        $now = date('Y-m-d H:i:s');

        if ($this->visited_at !== $now) {
            $this->visited_at = $now;
            $this->modified_fields['visited_at'] = true;
        }

        return $this;
    }

    /**
     * Retourne si un membre est rattaché à au moins un groupe
     *
     * @return bool
     */
    public function hasGroupe(): bool
    {
        return (count($this->getGroupes()) > 0);
    }

    /**
     * Le membre appartient-t-il au groupe "Membre Standard" ?
     *
     * @return bool
     */
    public function isStandard(): bool
    {
        return (bool) ($this->getLevel() & self::TYPE_STANDARD);
    }

    /**
     * Le membre appartient-t-il au groupe "Rédacteur" ?
     *
     * @return bool
     */
    public function isRedacteur(): bool
    {
        return (bool) ($this->getLevel() & self::TYPE_REDACTEUR);
    }

    /**
     * Le membre appartient-t-il au groupe "Membre Interne" ?
     *
     * @return bool
     */
    public function isInterne(): bool
    {
        return (bool) ($this->getLevel() & self::TYPE_INTERNE);
    }

    /**
     * Le membre appartient-t-il au groupe "Bonus" ?
     *
     * @return bool
     */
    public function isBonus(): bool
    {
        return (bool) ($this->getLevel() & self::TYPE_BONUS);
    }

    /**
     * Le membre appartient-t-il au groupe "Admin Système" ?
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return (bool) ($this->getLevel() & self::TYPE_ADMIN);
    }

    /**
     * Retourne le pseudo du compte, méthode statique
     *
     * @param int $id_contact id_contact
     *
     * @return string|false
     */
    public static function getPseudoById(int $id_contact): string|false
    {
        try {
            $m = Membre::getInstance($id_contact);
            return $m->getPseudo();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Retourne l'id du compte, false ni non trouvé
     *
     * @param string $pseudo pseudo
     *
     * @return int|false
     */
    public static function getIdByPseudo($pseudo): int|false
    {
        $membres = Membre::find([
            'pseudo' => $pseudo,
        ]);
        if (count($membres) === 1) {
            return $membres[0]->getIdContact();
        }
        return false;
    }

    /**
     * Retourne si le password est correct
     *
     * @param string $password (en clair)
     *
     * @return bool
     */
    public function checkPassword(string $password): bool
    {
        if (is_null($this->getPassword())) {
            return false;
        }

        return password_verify($password, $this->getPassword());
    }

    /**
     * Retourne si le pseudo est disponible
     *
     * @param string $pseudo pseudo
     *
     * @return bool
     */
    public static function isPseudoAvailable(string $pseudo): bool
    {
        $ms = Membre::find([
            'pseudo' => $pseudo,
        ]);
        return (count($ms) === 0);
    }

    /**
     * Retourne les types de membres
     *
     * @return array<int,string>
     */
    public static function getTypesMembre(): array
    {
        return self::$types_membre;
    }

    /**
     * Retourne le libellé d'une clé de la liste
     *
     * @param int $cle clé
     *
     * @return ?string
     */
    public static function getTypeMembreName(int $cle): ?string
    {
        if (array_key_exists($cle, self::$types_membre)) {
            return self::$types_membre[$cle];
        }
        return null;
    }

    /**
     * Extraction de l'id_contact a partir de l'email
     * et vérification implicite que celui ci est bien membre
     *
     * @param string $email email
     *
     * @return ?int
     */
    public static function getIdByEmail(string $email): ?int
    {
        $cs = Contact::find([
            'email' => $email,
        ]);
        if (count($cs) === 0) {
            return null; // contact introuvable
        }

        try {
            $m = Membre::getInstance($cs[0]->getIdContact());
            return $m->getIdContact();
        } catch (\Exception $e) {
            return null; // membre introuvable
        }
    }

    /**
     * Retourne une collection d'objets "Membre" répondant au(x) critère(s) donné(s)
     *
     * @param array<string,mixed> $params [
     *                                'id_groupe' => int,
     *                                'pseudo' => string,
     *                                'last_name' => string,
     *                                'first_name' => string,
     *                                'id_country' => string,
     *                                'mailing' => bool,
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

        $sql  = "SELECT ";

        $pks = array_map(
            function ($item) {
                return '`' . $item . '`';
            },
            static::getDbPk()
        );
        $sql .= implode(', ', $pks) . ' ';

        $sql .= "FROM `" . static::getDbTable() . "` ";
        $sql .= "WHERE 1 ";

        if (isset($params['id_groupe'])) {
            $subSql = "SELECT `id_contact` FROM `adhoc_groupe_membre` WHERE `id_groupe` = " . (int) $params['id_groupe'] . " ";
            if ($ids_contact = $db->pdo->query($subSql)->fetchAll(\PDO::FETCH_COLUMN)) {
                $sql .= "AND `id_contact` IN (" . implode(',', $ids_contact) . ") ";
            } else {
                return $objs;
            }
        }
        if (isset($params['pseudo']) && (strlen($params['pseudo']) > 0)) {
            $sql .= "AND `pseudo` = '" . $params['pseudo'] . "' ";
        }
        if (isset($params['last_name']) && (strlen($params['last_name']) > 0)) {
            $sql .= "AND `last_name` LIKE '" . $params['last_name'] . "%' ";
        }
        if (isset($params['first_name']) && (strlen($params['first_name']) > 0)) {
            $sql .= "AND `first_name` LIKE '" . $params['first_name'] . "%' ";
        }

        /*
        // TODO jointure avec contact
        if (!empty($params['email'])) {
            $sql .= "AND `email` LIKE '" . $params['email'] . "%' ";
        }
        */

        if (isset($params['id_country']) && (strlen($params['id_country']) === 2)) {
            $sql .= "AND `id_country` = '" . $params['id_country'] . "' ";
        }

        if (isset($params['mailing'])) {
            $sql .= "AND `mailing` = " . (int) $params['mailing'] . " ";
        }

        if ((isset($params['order_by']) && (in_array($params['order_by'], array_keys(static::$all_fields), true)))) {
            $sql .= "ORDER BY `" . $params['order_by'] . "` ";
        } else {
            $pks = array_map(function ($item) {
                return '`' . $item . '`';
            }, static::getDbPk());
            $sql .= 'ORDER BY ' . implode(', ', $pks) . ' ';
        }

        if ((isset($params['sort']) && (in_array($params['sort'], ['ASC', 'DESC'], true)))) {
            $sql .= $params['sort'] . " ";
        } else {
            $sql .= "ASC ";
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
