<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Model\Reference\City;
use Adhoc\Model\Reference\Departement;
use Adhoc\Model\Reference\TypeMusicien;
use Adhoc\Model\Reference\WorldCountry;
use Adhoc\Model\Reference\WorldRegion;
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
    public const TYPE_STANDARD  = 0x01; // 00001
    public const TYPE_REDACTEUR = 0x02; // 00010
    public const TYPE_INTERNE   = 0x04; // 00100
    public const TYPE_BONUS     = 0x08; // 01000
    public const TYPE_ADMIN     = 0x10; // 10000

    /**
     * Tableau des types de membre
     *
     * @var array<int,string>
     */
    protected static $types_membre = [
        self::TYPE_STANDARD  => "Standard",
        self::TYPE_REDACTEUR => "Rédacteur",
        self::TYPE_INTERNE   => "Interne",
        self::TYPE_BONUS     => "Bonus",
        self::TYPE_ADMIN     => "Administrateur",
    ];

    /**
     * @var string|array<string>
     */
    protected static string|array $pk = 'id_contact';

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
    protected $contact = null;

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
        'id_contact'     => 'int', // pk
        'pseudo'         => 'string',
        'password'       => 'password',
        'last_name'      => 'string',
        'first_name'     => 'string',
        'address'        => 'string',
        'id_city'        => 'int',
        'id_departement' => 'string',
        'id_region'      => 'string',
        'id_country'     => 'string',
        'tel'            => 'string',
        'port'           => 'string',
        'site'           => 'string',
        'text'           => 'string',
        'mailing'        => 'bool',
        'level'          => 'int',
        'created_at'     => 'date',
        'modified_at'    => 'date',
        'visited_at'     => 'date',
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
     * @return ?string
     * /!\ sous forme cryptée mysql
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
        if (file_exists(self::getBasePath() . '/' . $this->getId() . '.jpg')) {
            return self::getBaseUrl() . '/' . $this->getId() . '.jpg?ts=' . $this->getModifiedAtTs();
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
        if (file_exists(self::getBasePath() . '/ca/' . $this->getId() . '.jpg')) {
            return self::getBaseUrl() . '/ca/' . $this->getId() . '.jpg?ts=' . $this->getModifiedAtTs();
        }
        return null;
    }

    /* fin getters */

    /* début setters */

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
     * @param string $password password
     *
     * @return static
     */
    public function setPassword(string $password): static
    {
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

    /* fin setters */

    /**
     * Recherche des membres en fonction de critères donnés
     *
     * @param array<string,mixed> $params[
     *                                'id' => "3",
     *                                'pseudo' => "aerog%",
     *                                'last_name' => "sez%",
     *                                'first_name' => "gui%",
     *                                'email' => "email%",
     *                                'sort' => "id_contact|last_name|first_name|random|email|created_at|modified_at|visited_at|pseudo|lastnl",
     *                                'sens' => "ASC|DESC",
     *                                'debut' => 0,
     *                                'limit' => 10,
     *                            ]
     *
     * @return array<string,mixed>|array<array<string,mixed>>
     * @deprecated
     * @todo remplacer par Membre::find()
     */
    public static function getMembres(array $params = []): array
    {
        $pseudo = null;
        if (isset($params['pseudo'])) {
            $pseudo = (string) $params['pseudo'];
        }

        $last_name = null;
        if (isset($params['last_name'])) {
            $last_name = (string) $params['last_name'];
        }

        $first_name = null;
        if (isset($params['first_name'])) {
            $first_name = (string) $params['first_name'];
        }

        $email = null;
        if (isset($params['email'])) {
            $email = (string) $params['email'];
        }

        $debut = 0;
        if (isset($params['debut'])) {
            $debut = (int) $params['debut'];
        }

        $limit = 10;
        if (isset($params['limit'])) {
            $limit = (int) $params['limit'];
        }

        $sens = "ASC";
        if (isset($params['sens']) && $params['sens'] === "DESC") {
            $sens = "DESC";
        }

        $sort = "id_contact";
        if (
            isset($params['sort']) && (
            $params['sort'] === 'random' || $params['sort'] === 'id_contact'
            || $params['sort'] === 'last_name' || $params['sort'] === 'first_name'
            || $params['sort'] === 'email' || $params['sort'] === 'created_at'
            || $params['sort'] === 'modified_at' || $params['sort'] === 'visited_at'
            || $params['sort'] === 'pseudo' || $params['sort'] === 'lastnl')
        ) {
            $sort = $params['sort'];
        }

        $tab_id = [];
        if (array_key_exists('id', $params)) {
            $tab_id = explode(",", $params['id']);
        }

        $db = DataBase::getInstance();

        $sql = "SELECT `m`.`id_contact` AS `id`, `m`.`last_name`, `m`.`first_name`, `m`.`pseudo`, "
             . "`c`.`email`, `c`.`lastnl`, "
             . "`m`.`created_at`, `m`.`modified_at`, `m`.`visited_at`, "
             . "`m`.`text`, `m`.`site`, "
             . "`m`.`city`, `m`.`cp`, "
             . "`m`.`id_city`, `m`.`id_departement`, `m`.`id_region`, `m`.`id_country` "
             . "FROM `" . Membre::getDbTable() . "` `m` "
             . "JOIN `" . Contact::getDbTable() . "` `c` ON (`m`.`id_contact` = `c`.`id_contact`) "
             . "WHERE 1 ";

        if (count($tab_id) && ($tab_id[0] != 0)) {
            $sql .= "AND `m`.`id_contact` IN (" . implode(',', $tab_id) . ") ";
        }

        if (!is_null($pseudo)) {
            $sql .= "AND `m`.`pseudo` LIKE '" . $pseudo . "%' ";
        }

        if (!is_null($last_name)) {
            $sql .= "AND `m`.`last_name` LIKE '" . $last_name . "%' ";
        }

        if (!is_null($first_name)) {
            $sql .= "AND `m`.`first_name` LIKE '" . $first_name . "%' ";
        }

        if (!is_null($email)) {
            $sql .= "AND `c`.`email` LIKE '" . $email . "%' ";
        }

        $sql .= "ORDER BY ";
        if ($sort === "random") {
            $sql .= "RAND(" . time() . ") ";
        } else {
            if ($sort === 'email' || $sort === 'lastnl') {
                $t = 'c';
            } else {
                $t = 'm';
            }
            $sql .= "`" . $t . "`.`" . $sort . "` " . $sens . " ";
        }
        $sql .= "LIMIT " . $debut . ", " . $limit;

        if ($limit === 1) {
            $res = $db->queryWithFetchFirstRow($sql);
        } else {
            $res = $db->queryWithFetch($sql);
        }

        return $res;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    protected function loadFromDb(): bool
    {
        if (!parent::loadFromDb()) {
            throw new NotFoundException('membre inconnu');
        }

        return true;
    }

    /**
     * Vérifie l'appartenance d'une personne à un groupe
     *
     * @param int $id_groupe id_groupe
     *
     * @return bool
     * @throws \Exception
     */
    public function belongsTo(int $id_groupe): bool
    {
        if (!$this->contact) {
            throw new \Exception('id_contact manquant');
        }

        $db = DataBase::getInstance();

        $sql  = "SELECT `id_contact` "
              . "FROM `" . self::$db_table_appartient_a . "` "
              . "WHERE `id_groupe` = " . (int) $id_groupe . " "
              . "AND `id_contact` = " . (int) $this->id_contact;

        $res  = $db->query($sql);

        return (bool) $db->numRows($res);
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
        return (bool) ($this->level & self::TYPE_STANDARD);
    }

    /**
     * Le membre appartient-t-il au groupe "Rédacteur" ?
     *
     * @return bool
     */
    public function isRedacteur(): bool
    {
        return (bool) ($this->level & self::TYPE_REDACTEUR);
    }

    /**
     * Le membre appartient-t-il au groupe "Membre Interne" ?
     *
     * @return bool
     */
    public function isInterne(): bool
    {
        return (bool) ($this->level & self::TYPE_INTERNE);
    }

    /**
     * Le membre appartient-t-il au groupe "Bonus" ?
     *
     * @return bool
     */
    public function isBonus(): bool
    {
        return (bool) ($this->level & self::TYPE_BONUS);
    }

    /**
     * Le membre appartient-t-il au groupe "Admin Système" ?
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return (bool) ($this->level & self::TYPE_ADMIN);
    }

    /**
     * Retourne le pseudo du compte, méthode statique
     *
     * @param int $id_contact id_contact
     *
     * @return string
     */
    public static function getPseudoById(int $id_contact)
    {
        try {
            $m = Membre::getInstance($id_contact);
            return $m->getPseudo();
        } catch (\Exception $e) {
            return '';
        }
    }

    /**
     * Retourne l'id du compte, méthode statique
     *
     * @param string $pseudo pseudo
     *
     * @return int
     */
    public static function getIdByPseudo($pseudo): int
    {
        $ms = Membre::find([
            'pseudo' => $pseudo,
        ]);
        if (count($ms) === 1) {
            return $ms[0]->getIdContact();
        }
        return 0;
    }

    /**
     * Vérifie le password d'un membre
     *
     * @param string $password password
     *
     * @return int id_contact ou false
     */
    public function checkPassword(string $password)
    {
        return self::checkPseudoPassword($this->pseudo, $password);
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
     * Vérifie le couple pseudo/password et retourne l'id_contact
     *
     * @param string $pseudo   pseudo
     * @param string $password password
     *
     * @return int id_contact ou false
     */
    public static function checkPseudoPassword(string $pseudo, string $password): int
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_contact` "
             . "FROM `" . Membre::getDbTable() . "` "
             . "WHERE `pseudo` = '" . $pseudo . "' "
             . "AND `password` = PASSWORD('" . $password . "')";

        return (int) $db->queryWithFetchFirstField($sql);
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
     * @return int
     */
    public static function getIdByEmail(string $email): int
    {
        $cs = Contact::find([
            'email' => $email,
        ]);
        if (count($cs) === 0) {
            return 0; // contact introuvable
        }

        try {
            $m = Membre::getInstance($cs[0]->getIdContact());
            return $m->getIdContact();
        } catch (\Exception $e) {
            return 0; // membre introuvable
        }
    }

    /**
     * Retourne une collection d'objets "Membre" répondant au(x) critère(s) donné(s)
     *
     * @param array<string,mixed> $params [
     *                                'id_groupe' => int,
     *                                'id_country' => string,
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

        $sql = "SELECT `" . static::getDbPk() . "` FROM `" . static::getDbTable() . "` WHERE 1 ";

        if (isset($params['id_groupe'])) {
            $subSql = "SELECT `id_contact` FROM `adhoc_appartient_a` WHERE `id_groupe` = " . (int) $params['id_groupe'] . " ";
            if ($ids_contact = $db->queryWithFetchFirstFields($subSql)) {
                $sql .= "AND `id_contact` IN (" . implode(',', (array) $ids_contact) . ") ";
            } else {
                return $objs;
            }
        }

        if (!empty($params['pseudo'])) {
            $sql .= "AND `pseudo` LIKE '" . $params['pseudo'] . "%' ";
        }

        if (!empty($params['last_name'])) {
            $sql .= "AND `last_name` LIKE '" . $params['last_name'] . "%' ";
        }

        if (!empty($params['first_name'])) {
            $sql .= "AND `first_name` LIKE '" . $params['first_name'] . "%' ";
        }

        /*
        // TODO jointure avec contact
        if (!empty($params['email'])) {
            $sql .= "AND `email` LIKE '" . $params['email'] . "%' ";
        }
        */

        if (!empty($params['id_country'])) {
            $sql .= "AND `id_country` = '" . $params['id_country'] . "' ";
        }

        if ((isset($params['order_by']) && (in_array($params['order_by'], array_keys(static::$all_fields), true)))) {
            $sql .= "ORDER BY `" . $params['order_by'] . "` ";
        } else {
            $sql .= "ORDER BY `" . static::$pk . "` ";
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

        $ids = $db->queryWithFetchFirstFields($sql);
        foreach ($ids as $id) {
            $objs[] = static::getInstance((int) $id);
        }

        return $objs;
    }
}
