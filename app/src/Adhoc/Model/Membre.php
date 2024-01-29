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
use Adhoc\Utils\ObjectModel;

/**
 * Classe Membre
 *
 * @template TObjectModel as Membre
 * @extends ObjectModel<TObjectModel>
 *
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Membre extends Contact
{
    /**
     * Instance de l'objet
     *
     * @var ?TObjectModel
     */
    protected static ?ObjectModel $instance = null;

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
     * @var array
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

    /**
     * @var array
     */
    protected array $types = [];

    // getters helpers avec mini mise en cache

    /**
     * @var ?array
     */
    protected ?array $groupes = null;

    /**
     * @var ?array
     */
    protected ?array $city = null;

    /**
     * @var ?array
     */
    protected ?array $departement = null;

    /**
     * @var ?array
     */
    protected ?array $region = null;

    /**
     * @var ?array
     */
    protected ?array $country = null;

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
     * Tableau des attributs modifiés depuis la dernière sauvegarde.
     *
     * Pour chaque attribut modifié, on a un élément de la forme 'attribut => true'.
     *
     * @var array<mixed>
     */
    protected array $modified_fields = [
        'contact' => [],
        'membre'  => [],
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
     * @param bool $fusion fusion
     *
     * @return array<string,string>|array<string,array<string,string>>
     */
    protected function getAllFields(bool $fusion = true): array
    {
        if ($fusion) {
            return array_merge(
                Contact::$all_fields,
                Membre::$all_fields
            );
        } else {
            return array_merge(
                [
                    'contact' => Contact::$all_fields,
                    'membre' => Membre::$all_fields,
                ]
            );
        }
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
     * @return object|null
     */
    public function getCity(): ?object
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
     * @return object|null
     */
    public function getDepartement(): ?object
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
     * @return object|null
     */
    public function getRegion(): ?object
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
     * @return object|null
     */
    public function getCountry(): ?object
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
     * @return array
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
     * @param string $pseudo pseudo
     *
     * @return object
     */
    public function setPseudo(string $pseudo): object
    {
        if ($this->pseudo !== $pseudo) {
            $this->pseudo = $pseudo;
            $this->modified_fields['membre']['pseudo'] = true;
        }

        return $this;
    }

    /**
     * @param string $password password
     *
     * @return object
     */
    public function setPassword(string $password): object
    {
        if ($this->password !== $password) {
            $this->password = $password;
            $this->modified_fields['membre']['password'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $last_name last_name
     *
     * @return object
     */
    public function setLastName(?string $last_name): object
    {
        if ($this->last_name !== $last_name) {
            $this->last_name = $last_name;
            $this->modified_fields['membre']['last_name'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $first_name first_name
     *
     * @return object
     */
    public function setFirstName(?string $first_name): object
    {
        if ($this->first_name !== $first_name) {
            $this->first_name = $first_name;
            $this->modified_fields['membre']['first_name'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $address adresse
     *
     * @return object
     */
    public function setAddress(?string $address): object
    {
        if ($this->address !== $address) {
            $this->address = $address;
            $this->modified_fields['membre']['address'] = true;
        }

        return $this;
    }

    /**
     * @param int|null $id_city id_city
     *
     * @return object
     */
    public function setIdCity(?int $id_city): object
    {
        if ($this->id_city !== $id_city) {
            $this->id_city = $id_city;
            $this->modified_fields['membre']['id_city'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $id_departement id_departement
     *
     * @return object
     */
    public function setIdDepartement(?string $id_departement): object
    {
        if ($this->id_departement !== $id_departement) {
            $this->id_departement = $id_departement;
            $this->modified_fields['membre']['id_departement'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $id_region id_region
     *
     * @return object
     */
    public function setIdRegion(?string $id_region): object
    {
        if ($this->id_region !== $id_region) {
            $this->id_region = $id_region;
            $this->modified_fields['membre']['id_region'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $id_country id_country
     *
     * @return object
     */
    public function setIdCountry(?string $id_country): object
    {
        if ($this->id_country !== $id_country) {
            $this->id_country = $id_country;
            $this->modified_fields['membre']['id_country'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $tel téléphone
     *
     * @return object
     */
    public function setTel(?string $tel): object
    {
        if ($this->tel !== $tel) {
            $this->tel = $tel;
            $this->modified_fields['membre']['tel'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $port port
     *
     * @return object
     */
    public function setPort(?string $port): object
    {
        if ($this->port !== $port) {
            $this->port = $port;
            $this->modified_fields['membre']['port'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $site site
     *
     * @return object
     */
    public function setSite(?string $site): object
    {
        if ($this->site !== $site) {
            $this->site = $site;
            $this->modified_fields['membre']['site'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $text texte
     *
     * @return object
     */
    public function setText(?string $text): object
    {
        if ($this->text !== $text) {
            $this->text = $text;
            $this->modified_fields['membre']['text'] = true;
        }

        return $this;
    }

    /**
     * @param bool $mailing mailing
     *
     * @return object
     */
    public function setMailing(bool $mailing): object
    {
        if ($this->mailing !== $mailing) {
            $this->mailing = $mailing;
            $this->modified_fields['membre']['mailing'] = true;
        }

        return $this;
    }

    /**
     * @param int $level level
     *
     * @return object
     */
    public function setLevel(int $level): object
    {
        if ($this->level !== $level) {
            $this->level = $level;
            $this->modified_fields['membre']['level'] = true;
        }

        return $this;
    }

    /**
     * @param string $created_at date de création "YYYY-MM-DD HH:II:SS"
     *
     * @return object
     */
    public function setCreatedAt(string $created_at): object
    {
        if ($this->created_at !== $created_at) {
            $this->created_at = $created_at;
            $this->modified_fields['membre']['created_at'] = true;
        }

        return $this;
    }

    /**
     * @return object
     */
    public function setCreatedNow(): object
    {
        $now = date('Y-m-d H:i:s');

        if ($this->created_at !== $now) {
            $this->created_at = $now;
            $this->modified_fields['membre']['created_at'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $modified_at date de modification "YYYY-MM-DD HH:II:SS"
     *
     * @return object
     */
    public function setModifiedAt(?string $modified_at): object
    {
        if ($this->modified_at !== $modified_at) {
            $this->modified_at = $modified_at;
            $this->modified_fields['membre']['modified_at'] = true;
        }

        return $this;
    }

    /**
     * @return object
     */
    public function setModifiedNow(): object
    {
        $now = date('Y-m-d H:i:s');

        if ($this->modified_at !== $now) {
            $this->modified_at = $now;
            $this->modified_fields['membre']['modified_at'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $visited_at date de dernière connexion "YYYY-MM-DD HH:II:SS"
     *
     * @return object
     */
    public function setVisitedAt(?string $visited_at): object
    {
        if ($this->visited_at !== $visited_at) {
            $this->visited_at = $visited_at;
            $this->modified_fields['membre']['visited_at'] = true;
        }

        return $this;
    }

    /**
     * @return object
     */
    public function setVisitedNow(): object
    {
        $now = date('Y-m-d H:i:s');

        if ($this->visited_at !== $now) {
            $this->visited_at = $now;
            $this->modified_fields['membre']['visited_at'] = true;
        }

        return $this;
    }

    /* fin setters */

    /**
     * Recherche des membres en fonction de critères donnés
     *
     * @param array ['id']            => "3"
     *              ['pseudo']        => "aerog%"
     *              ['last_name']     => "sez%"
     *              ['first_name']    => "gui%"
     *              ['email']         => "email%"
     *              ['sort']          => "id_contact|last_name|first_name|random|email|created_at|modified_at"
     *                                   "visited_at|pseudo|lastnl"
     *              ['sens']          => "ASC|DESC"
     *              ['debut']         => 0
     *              ['limit']         => 10
     *
     * @return array
     * @deprecated
     * @todo remplacer par Membre::find()
     */
    public static function getMembres(array $params = [])
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
            $sql .= "AND `m`.`pseudo` LIKE '" . $db->escape($pseudo) . "%' ";
        }

        if (!is_null($last_name)) {
            $sql .= "AND `m`.`last_name` LIKE '" . $db->escape($last_name) . "%' ";
        }

        if (!is_null($first_name)) {
            $sql .= "AND `m`.`first_name` LIKE '" . $db->escape($first_name) . "%' ";
        }

        if (!is_null($email)) {
            $sql .= "AND `c`.`email` LIKE '" . $db->escape($email) . "%' ";
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
     * Suppression d'un contact apres vérification des liaisons avec les tables
     *
     * @return bool
     */
    public function delete(): bool
    {
        $db = DataBase::getInstance();

        $sql  = "DELETE FROM `" . Membre::getDbTable() . "` "
              . "WHERE `id_contact` = " . (int) $this->id_contact;

        $db->query($sql);

        return (bool) $db->affectedRows();
    }

    /**
     * Sauve en db tables contact et membre
     *
     * @return int|bool
     */
    public function save(): int|bool
    {
        $db = DataBase::getInstance();

        // retourne les champs non fusionnés
        $fields = self::getAllFields(false);

        // si pas d'id ou id mais n'est pas membre, on insert membre
        if (!$this->getId() || ($this->getId() && !Membre::getPseudoById($this->getIdContact()))) { // INSERT
            /* table contact */
            // id retrouvé à partir de email ?
            if ($this->getEmail() && ($id_contact = Contact::getIdByEmail($this->getEmail()))) {
                // l'id_contact est retrouvé à partir de l'email, c'est donc déjà un Contact
                // on ne touche pas à la table, on charge juste l'id
                $this->setId($id_contact);
            } else {
                // l'id_contact n'a pas été trouvé à partir de l'email
                // on doit donc d'abord créer un Contact
                $sql = 'INSERT INTO `' . Contact::getDbTable() . '` (';
                if (count($this->modified_fields['contact']) > 0) {
                    foreach ($this->modified_fields['contact'] as $field => $value) {
                        if ($value === true) {
                            $sql .= '`' . $field . '`,';
                        }
                    }
                    $sql = substr($sql, 0, -1);
                }
                $sql .= ') VALUES (';

                if (count($this->modified_fields['contact']) > 0) {
                    foreach ($this->modified_fields['contact'] as $field => $value) {
                        if ($value !== true) {
                            continue;
                        }
                        $type = $fields['contact'][$field];
                        $att = $field;
                        if (is_null($this->$att)) {
                            $sql .= 'NULL,';
                        } else {
                            switch ($type) {
                                case 'int':
                                    $sql .= (int) $this->$att . ',';
                                    break;
                                case 'float':
                                    $sql .= number_format((float) $this->$att, 8, '.', '') . ',';
                                    break;
                                case 'string':
                                    $sql .= "'" . $db->escape($this->$att) . "',";
                                    break;
                                case 'bool':
                                    $sql .= ((bool) $this->$att ? 'TRUE' : 'FALSE') . ",";
                                    break;
                                case 'password':
                                    $sql .= "PASSWORD('" . $db->escape($this->$att) . "'),";
                                    break;
                                case 'phpser':
                                    $sql .= "'" . $db->escape(serialize($this->$att)) . "',";
                                    break;
                                case 'date':
                                    $sql .= (is_null($this->$att) ? 'NULL' : "'" . $db->escape($this->$att) . "'") . ",";
                                    break;
                                default:
                                    throw new \Exception('invalid field type : ' . $type);
                            }
                        }
                    }
                    $sql = substr($sql, 0, -1);
                }
                $sql .= ')';

                $db->query($sql);

                $this->setId((int) $db->insertId());
            }
        }

        // à ce stade le contact est créé, on ne sait pas encore si c'est un membre
        // on essaye de récupérer le pseudo à partir de l'id_contact

        if (!Membre::getPseudoById($this->getIdContact())) { // INSERT
            /* table membre */
            $sql = 'INSERT INTO `' . Membre::getDbTable() . '` (';
            $sql .= '`' . Membre::getDbPk() . '`,';
            if (count($this->modified_fields['membre']) > 0) {
                foreach ($this->modified_fields['membre'] as $field => $value) {
                    if ($value === true) {
                        $sql .= '`' . $field . '`,';
                    }
                }
                $sql = substr($sql, 0, -1);
            }
            $sql .= ') VALUES (';
            $sql .= (int) $this->getId() . ',';

            if (count($this->modified_fields['membre']) > 0) {
                foreach ($this->modified_fields['membre'] as $field => $value) {
                    if ($value !== true) {
                        continue;
                    }
                    $type = $fields['membre'][$field];
                    $att = $field;
                    if (is_null($this->$att)) {
                        $sql .= 'NULL,';
                    } else {
                        switch ($type) {
                            case 'int':
                                $sql .= (int) $this->$att . ',';
                                break;
                            case 'float':
                                $sql .= number_format((float) $this->$att, 8, '.', '') . ',';
                                break;
                            case 'string':
                            case 'date':
                                $sql .= "'" . $db->escape($this->$att) . "',";
                                break;
                            case 'bool':
                                $sql .= ((bool) $this->$att ? 'TRUE' : 'FALSE') . ",";
                                break;
                            case 'password':
                                $sql .= "PASSWORD('" . $db->escape($this->$att) . "'),";
                                break;
                            case 'phpser':
                                $sql .= "'" . $db->escape(serialize($this->$att)) . "',";
                                break;
                            default:
                                throw new \Exception('invalid field type : ' . $type);
                        }
                    }
                }
                $sql = substr($sql, 0, -1);
            }
            $sql .= ')';

            $db->query($sql);

            // nouveau membre bien créé !

            return $this->getId();
        } else { // UPDATE
            if (
                (count($this->modified_fields['contact']) === 0)
                &&
                (count($this->modified_fields['membre']) === 0)
            ) {
                return true; // pas de changement, ni dans Contact ni dans Membre
            }

            /* UPDATE contact */

            if (count($this->modified_fields['contact']) > 0) {
                $fields_to_save = '';
                foreach ($this->modified_fields['contact'] as $field => $value) {
                    if ($value !== true) {
                        continue;
                    }
                    $att = $field;
                    if (is_null($this->$att)) {
                        $fields_to_save .= " `" . $field . "` = NULL,";
                    } else {
                        switch ($fields['contact'][$field]) {
                            case 'int':
                                $fields_to_save .= " `" . $field . "` = " . (int) $this->$att . ",";
                                break;
                            case 'float':
                                $fields_to_save .= " `" . $field . "` = " . number_format((float) $this->$att, 8, ".", "") . ",";
                                break;
                            case 'string':
                            case 'date':
                                $fields_to_save .= " `" . $field . "` = '" . $db->escape($this->$att) . "',";
                                break;
                            case 'bool':
                                $fields_to_save .= " `" . $field . "` = " . (((bool) $this->$att) ? 'TRUE' : 'FALSE') . ",";
                                break;
                            case 'password':
                                $fields_to_save .= " `" . $field . "` = PASSWORD('" . $db->escape($this->$att) . "'),";
                                break;
                            case 'phpser':
                                $fields_to_save .= " `" . $field . "` = '" . $db->escape(serialize($this->$att)) . "',";
                                break;
                            default:
                                throw new \Exception('invalid field type : ' . $fields['contact'][$field]);
                        }
                    }
                }
                $fields_to_save = substr($fields_to_save, 0, -1);

                $sql  = 'UPDATE `' . Contact::getDbTable() . '` '
                      . 'SET ' . $fields_to_save . ' '
                      . 'WHERE `' . Contact::getDbPk() . '` = ' . (int) $this->getId();

                $this->modified_fields['contact'] = [];

                $db->query($sql);
            }

            /* UPDATE membre */

            if (count($this->modified_fields['membre']) > 0) {
                $fields_to_save = '';
                foreach ($this->modified_fields['membre'] as $field => $value) {
                    if ($value !== true) {
                        continue;
                    }
                    $att = $field;
                    if (is_null($this->$att)) {
                        $fields_to_save .= " `" . $field . "` = NULL,";
                    } else {
                        switch ($fields['membre'][$field]) {
                            case 'int':
                                $fields_to_save .= " `" . $field . "` = " . (int) $this->$att . ",";
                                break;
                            case 'float':
                                $fields_to_save .= " `" . $field . "` = " . number_format((float) $this->$att, 8, ".", "") . ",";
                                break;
                            case 'string':
                            case 'date':
                                $fields_to_save .= " `" . $field . "` = '" . $db->escape($this->$att) . "',";
                                break;
                            case 'bool':
                                $fields_to_save .= " `" . $field . "` = " . (((bool) $this->$att) ? 'TRUE' : 'FALSE') . ",";
                                break;
                            case 'password':
                                $fields_to_save .= " `" . $field . "` = PASSWORD('" . $db->escape($this->$att) . "'),";
                                break;
                            case 'phpser':
                                $fields_to_save .= " `" . $field . "` = '" . $db->escape(serialize($this->$att)) . "',";
                                break;
                            default:
                                throw new \Exception('invalid field type : ' . $fields['membre'][$field]);
                        }
                    }
                }
                $fields_to_save = substr($fields_to_save, 0, -1);

                $sql = 'UPDATE `' . Membre::getDbTable() . '` '
                     . 'SET ' . $fields_to_save . ' '
                     . 'WHERE `' . Membre::getDbPk() . '` = ' . (int) $this->getId();

                $this->modified_fields['membre'] = [];

                $db->query($sql);
            }

            return true;
        }
    }

    /**
     * Charge toutes les infos d'un membre
     *
     * @return bool
     * @throws \Exception
     */
    protected function loadFromDb(): bool
    {
        $db = DataBase::getInstance();

        $sql = "SELECT * "
             . "FROM `" . Membre::getDbTable() . "`, `" . Contact::getDbTable() . "` "
             . "WHERE `" . Membre::getDbTable() . "`.`" . Membre::getDbPk() . "` = `" . Contact::getDbTable() . "`.`" . Contact::getDbPk() . "` "
             . "AND `" . Membre::getDbTable() . "`.`" . Membre::getDbPk() . "` = " . (int) $this->getId();

        if ($res = $db->queryWithFetchFirstRow($sql)) {
            $this->arrayToObject($res);
            return true;
        }

        throw new \Exception('Membre introuvable');
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
        $db = DataBase::getInstance();

        $sql  = "SELECT `pseudo` "
              . "FROM `" . Membre::getDbTable() . "` "
              . "WHERE `" . self::$pk . "` = " . (int) $id_contact;

        return $db->queryWithFetchFirstField($sql);
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
        $db = DataBase::getInstance();

        $sql  = "SELECT `" . self::$pk . "` "
              . "FROM `" . Membre::getDbTable() . "` "
              . "WHERE `pseudo` = '" . $db->escape($pseudo) . "'";

        return (int) $db->queryWithFetchFirstField($sql);
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
        $db = DataBase::getInstance();

        $sql  = "SELECT `pseudo` "
              . "FROM `" . Membre::getDbTable() . "` "
              . "WHERE `pseudo` = '" . $db->escape($pseudo) . "' ";

        $pseudo = $db->queryWithFetchFirstField($sql);

        return !(bool) $pseudo;
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
             . "WHERE `pseudo` = '" . $db->escape($pseudo) . "' "
             . "AND `password` = PASSWORD('" . $db->escape($password) . "')";

        return (int) $db->queryWithFetchFirstField($sql);
    }

    /**
     * Retourne les types de membres
     *
     * @return array
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
        if (!Email::validate($email)) {
            throw new \Exception('email syntaxiquement incorrect');
        }

        $db = DataBase::getInstance();

        $sql = "SELECT `m`.`id_contact` "
              . "FROM `" . Contact::getDbTable() . "` `c`, `" . Membre::getDbTable() . "` `m` "
              . "WHERE `c`.`id_contact` = `m`.`id_contact` "
              . "AND `c`.`email` = '" . $db->escape($email) . "'";

        return (int) $db->queryWithFetchFirstField($sql);
    }

    /**
     * Retourne une collection d'objets "Membre" répondant au(x) critère(s) donné(s)
     *
     * @param array $params [
     *     'id_groupe' => int,
     *     'id_country' => string,
     *     'order_by' => string,
     *     'sort' => string,
     *     'start' => int,
     *     'limit' => int,
     * ]
     *
     * @return array
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
            $sql .= "AND `pseudo` LIKE '" . $db->escape($params['pseudo']) . "%' ";
        }

        if (!empty($params['last_name'])) {
            $sql .= "AND `last_name` LIKE '" . $db->escape($params['last_name']) . "%' ";
        }

        if (!empty($params['first_name'])) {
            $sql .= "AND `first_name` LIKE '" . $db->escape($params['first_name']) . "%' ";
        }

        /*
        // TODO jointure avec contact
        if (!empty($params['email'])) {
            $sql .= "AND `email` LIKE '" . $db->escape($params['email']) . "%' ";
        }
        */

        if (!empty($params['id_country'])) {
            $sql .= "AND `id_country` = '" . $db->escape($params['id_country']) . "' ";
        }

        if ((isset($params['order_by']) && (in_array($params['order_by'], array_keys(static::$all_fields))))) {
            $sql .= "ORDER BY `" . $params['order_by'] . "` ";
        } else {
            $sql .= "ORDER BY `" . static::$pk . "` ";
        }

        if ((isset($params['sort']) && (in_array($params['sort'], ['ASC', 'DESC'])))) {
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
