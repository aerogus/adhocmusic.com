<?php declare(strict_types=1);

use \Reference\City;
use \Reference\Country;
use \Reference\Departement;
use \Reference\Region;
use \Reference\TypeMusicien;

/**
 * Classe Membre
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Membre extends Contact
{
    /**
     * Instance de l'objet
     *
     * @var object
     */
    protected static $_instance = null;

    /**
     * Gestion des droits utilisateurs
     * par masque binaire
     */
    const TYPE_STANDARD  = 0x01; // 00001
    const TYPE_REDACTEUR = 0x02; // 00010
    const TYPE_INTERNE   = 0x04; // 00100
    const TYPE_BONUS     = 0x08; // 01000
    const TYPE_ADMIN     = 0x10; // 10000

    /**
     * Tableau des types de membre
     *
     * @var array
     */
    protected static $_types_membre = [
        self::TYPE_STANDARD  => "Standard",
        self::TYPE_REDACTEUR => "Rédacteur",
        self::TYPE_INTERNE   => "Interne",
        self::TYPE_BONUS     => "Bonus",
        self::TYPE_ADMIN     => "Administrateur",
    ];

    /**
     * @var string
     */
    protected static $_pk = 'id_contact';

    /**
     * @var string
     */
    protected static $_table = 'adhoc_membre';

    /**
     * @var string
     */
    protected $_pseudo = null;

    /**
     * @var string
     */
    protected $_password = null;

    /**
     * @var string
     */
    protected $_last_name = null;

    /**
     * @var string
     */
    protected $_first_name = null;

    /**
     * @var string
     */
    protected $_address = null;

    /**
     * @var int
     */
    protected $_id_city = null;

    /**
     * @var string
     */
    protected $_id_departement = null;

    /**
     * @var string
     */
    protected $_id_region = null;

    /**
     * @var string
     */
    protected $_id_country = null;

    /**
     * @var string
     */
    protected $_tel = null;

    /**
     * @var string
     */
    protected $_port = null;

    /**
     * @var string
     */
    protected $_site = null;

    /**
     * @var string
     */
    protected $_text = null;

    /**
     * @var bool
     */
    protected $_mailing = false;

    /**
     * @var int
     */
    protected $_level = 0;

    /**
     * @var string
     */
    protected $_created_at = null;

    /**
     * @var string
     */
    protected $_modified_at = null;

    /**
     * @var string
     */
    protected $_visited_at = null;

    /**
     * @var array
     */
    protected $_types = [];

    // getters helpers avec mini mise en cache

    /**
     * @var array|null
     */
    protected $_groupes = null;

    /**
     * @var array|null
     */
    protected $_city = null;

    /**
     * @var array|null
     */
    protected $_departement = null;

    /**
     * @var array|null
     */
    protected $_region = null;

    /**
     * @var array|null
     */
    protected $_country = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array
     */
    protected static $_all_fields = [
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
     * @var array
     */
    protected $_modified_fields = [
        'contact' => [],
        'membre'  => [],
    ];

    /**
     * @return string
     */
    static function getBaseUrl(): string
    {
        return MEDIA_URL . '/membre';
    }

    /**
     * @return string
     */
    static function getBasePath(): string
    {
        return MEDIA_PATH . '/membre';
    }

    /**
     * @param bool $fusion fusion
     *
     * @return array
     */
    protected function _getAllFields(bool $fusion = true): array
    {
        if ($fusion) {
            return array_merge(
                Contact::$_all_fields,
                Membre::$_all_fields
            );
        } else {
            return array_merge(
                [
                    'contact' => Contact::$_all_fields,
                    'membre' => Membre::$_all_fields,
                ]
            );
        }
    }

    /**
     * @return string|null
     */
    function getPseudo(): ?string
    {
        return $this->_pseudo;
    }

    /**
     * @return string|null
     * /!\ sous forme cryptée mysql
     */
    function getPassword(): ?string
    {
        return $this->_password;
    }

    /**
     * @return string|null
     */
    function getLastName(): ?string
    {
        return $this->_last_name;
    }

    /**
     * @return string|null
     */
    function getFirstName(): ?string
    {
        return $this->_first_name;
    }

    /**
     * @return string|null
     */
    function getAddress(): ?string
    {
        return $this->_address;
    }

    /**
     * @return int|null
     */
    function getIdCity(): ?int
    {
        return $this->_id_city;
    }

    /**
     * @return object|null
     */
    function getCity(): ?object
    {
        if (is_null($this->getIdCity())) {
            return null;
        }

        if (is_null($this->_city)) {
            $this->_city = City::getInstance($this->getIdCity());
        }

        return $this->_city;
    }

    /**
     * @return string|null
     */
    function getIdDepartement(): ?string
    {
        return $this->_id_departement;
    }

    /**
     * @return object|null
     */
    function getDepartement(): ?object
    {
        if (is_null($this->getIdDepartement())) {
            return null;
        }

        if (is_null($this->_departement)) {
            $this->_departement = Departement::getInstance($this->getIdDepartement());
        }

        return $this->_departement;
    }

    /**
     * @return string|null
     */
    function getIdRegion(): ?string
    {
        return $this->_id_region;
    }

    /**
     * @return object|null
     */
    function getRegion(): ?object
    {
        if (is_null($this->getIdRegion())) {
            return null;
        }

        if (is_null($this->_region)) {
            $this->_region = Region::getInstance($this->getIdRegion());
        }

        return $this->_region;
    }

    /**
     * @return string|null
     */
    function getIdCountry(): ?string
    {
        return $this->_id_country;
    }

    /**
     * @return object|null
     */
    function getCountry(): ?object
    {
        if (is_null($this->getIdCountry())) {
            return null;
        }

        if (is_null($this->_country)) {
            $this->_country = Country::getInstance($this->getIdCountry());
        }

        return $this->_country;
    }

    /**
     * @return string|null
     */
    function getTel(): ?string
    {
        return $this->_tel;
    }

    /**
     * @return string|null
     */
    function getPort(): ?string
    {
        return $this->_port;
    }

    /**
     * @return string|null
     */
    function getSite(): ?string
    {
        return $this->_site;
    }

    /**
     * @return string|null
     */
    function getText(): ?string
    {
        return $this->_text;
    }

    /**
     * @return bool
     */
    function getMailing(): bool
    {
        return $this->_mailing;
    }

    /**
     * @return int
     */
    function getLevel(): int
    {
        return $this->_level;
    }

    /**
     * @return string|null
     */
    function getCreatedAt(): ?string
    {
        if (!is_null($this->_created_at) && Date::isDateTimeOk($this->_created_at)) {
            return $this->_created_at;
        }
        return null;
    }

    /**
     * @return int|null
     */
    function getCreatedAtTs(): ?int
    {
        if (!is_null($this->_created_at) && Date::isDateTimeOk($this->_created_at)) {
            return strtotime($this->_created_at);
        }
        return null;
    }

    /**
     * @return string|null
     */
    function getModifiedAt(): ?string
    {
        if (!is_null($this->_modified_at) && Date::isDateTimeOk($this->_modified_at)) {
            return $this->_modified_at;
        }
        return null;
    }

    /**
     * @return int|null
     */
    function getModifiedAtTs(): ?int
    {
        if (!is_null($this->_modified_at) && Date::isDateTimeOk($this->_modified_at)) {
             return strtotime($this->_modified_at);
        }
        return null;
    }

    /**
     * @return string|null
     */
    function getVisitedAt(): ?string
    {
        if (!is_null($this->_visited_at) && Date::isDateTimeOk($this->_visited_at)) {
            return $this->_visited_at;
        }
        return null;
    }

    /**
     * @return int|null
     */
    function getVisitedAtTs(): ?int
    {
        if (!is_null($this->_visited_at) && Date::isDateTimeOk($this->_visited_at)) {
             return strtotime($this->_visited_at);
        }
        return null;
    }

    /**
     * Retourne l'url de la fiche d'un membre AD'HOC
     *
     * @return string
     */
    function getUrl(): string
    {
        return HOME_URL . '/membres/' . $this->getIdContact();
    }

    /**
     * @return array
     */
    function getGroupes(): array
    {
        if (is_null($this->_groupes)) {
            $this->_groupes = Groupe::find(
                [
                    'id_contact' => $this->getIdContact(),
                    'online' => true,
                    'order_by' => 'alias',
                    'sort' => 'ASC',
                ]
            );
        }

        return $this->_groupes;
    }

    /**
     * Retourne l'url de la photo du membre
     *
     * @return string|null
     */
    function getAvatarUrl(): ?string
    {
        if (file_exists(self::getBasePath() . '/' . $this->getId() . '.jpg')) {
            return self::getBaseUrl() . '/' . $this->getId() . '.jpg?ts=' . $this->getModifiedAtTs();
        }
        return null;
    }

    /**
     * Retourne l'url de la photo du membre AD'HOC
     *
     * @return string|null
     * @todo uniquement dans MembreAdhoc ?
     */
    function getAvatarInterneUrl(): ?string
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
    function setPseudo(string $pseudo): object
    {
        if ($this->_pseudo !== $pseudo) {
            $this->_pseudo = $pseudo;
            $this->_modified_fields['membre']['pseudo'] = true;
        }

        return $this;
    }

    /**
     * @param string $password password
     *
     * @return object
     */
    function setPassword(string $password): object
    {
        if ($this->_password !== $password) {
            $this->_password = $password;
            $this->_modified_fields['membre']['password'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $last_name last_name
     *
     * @return object
     */
    function setLastName(?string $last_name): object
    {
        if ($this->_last_name !== $last_name) {
            $this->_last_name = $last_name;
            $this->_modified_fields['membre']['last_name'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $first_name first_name
     *
     * @return object
     */
    function setFirstName(?string $first_name): object
    {
        if ($this->_first_name !== $first_name) {
            $this->_first_name = $first_name;
            $this->_modified_fields['membre']['first_name'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $address adresse
     *
     * @return object
     */
    function setAddress(?string $address): object
    {
        if ($this->_address !== $address) {
            $this->_address = $address;
            $this->_modified_fields['membre']['address'] = true;
        }

        return $this;
    }

    /**
     * @param int|null $id_city id_city
     *
     * @return object
     */
    function setIdCity(?int $id_city): object
    {
        if ($this->_id_city !== $id_city) {
            $this->_id_city = $id_city;
            $this->_modified_fields['membre']['id_city'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $id_departement id_departement
     *
     * @return object
     */
    function setIdDepartement(?string $id_departement): object
    {
        if ($this->_id_departement !== $id_departement) {
            $this->_id_departement = $id_departement;
            $this->_modified_fields['membre']['id_departement'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $id_region id_region
     * 
     * @return object
     */
    function setIdRegion(?string $id_region): object
    {
        if ($this->_id_region !== $id_region) {
            $this->_id_region = $id_region;
            $this->_modified_fields['membre']['id_region'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $id_country id_country
     *
     * @return object
     */
    function setIdCountry(?string $id_country): object
    {
        if ($this->_id_country !== $id_country) {
            $this->_id_country = $id_country;
            $this->_modified_fields['membre']['id_country'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $tel téléphone
     *
     * @return object
     */
    function setTel(?string $tel): object
    {
        if ($this->_tel !== $tel) {
            $this->_tel = $tel;
            $this->_modified_fields['membre']['tel'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $port port
     *
     * @return object
     */
    function setPort(?string $port): object
    {
        if ($this->_port !== $port) {
            $this->_port = $port;
            $this->_modified_fields['membre']['port'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $site site
     *
     * @return object
     */
    function setSite(?string $site): object
    {
        if ($this->_site !== $site) {
            $this->_site = $site;
            $this->_modified_fields['membre']['site'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $text texte
     *
     * @return object
     */
    function setText(?string $text): object
    {
        if ($this->_text !== $text) {
            $this->_text = $text;
            $this->_modified_fields['membre']['text'] = true;
        }

        return $this;
    }

    /**
     * @param bool $mailing mailing
     *
     * @return object
     */
    function setMailing(bool $mailing): object
    {
        if ($this->_mailing !== $mailing) {
            $this->_mailing = $mailing;
            $this->_modified_fields['membre']['mailing'] = true;
        }

        return $this;
    }

    /**
     * @param int $level level
     *
     * @return object
     */
    function setLevel(int $level): object
    {
        if ($this->_level !== $level) {
            $this->_level = $level;
            $this->_modified_fields['membre']['level'] = true;
        }

        return $this;
    }

    /**
     * @param string $created_at date de création "YYYY-MM-DD HH:II:SS"
     *
     * @return object
     */
    function setCreatedAt(string $created_at): object
    {
        if ($this->_created_at !== $created_at) {
            $this->_created_at = $created_at;
            $this->_modified_fields['membre']['created_at'] = true;
        }

        return $this;
    }

    /**
     * @return object
     */
    function setCreatedNow(): object
    {
        $now = date('Y-m-d H:i:s');

        if ($this->_created_at !== $now) {
            $this->_created_at = $now;
            $this->_modified_fields['membre']['created_at'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $modified_at date de modification "YYYY-MM-DD HH:II:SS"
     *
     * @return object
     */
    function setModifiedAt(?string $modified_at): object
    {
        if ($this->_modified_at !== $modified_at) {
            $this->_modified_at = $modified_at;
            $this->_modified_fields['membre']['modified_at'] = true;
        }

        return $this;
    }

    /**
     * @return object
     */
    function setModifiedNow(): object
    {
        $now = date('Y-m-d H:i:s');

        if ($this->_modified_at !== $now) {
            $this->_modified_at = $now;
            $this->_modified_fields['membre']['modified_at'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $visited_at date de dernière connexion "YYYY-MM-DD HH:II:SS"
     *
     * @return object
     */
    function setVisitedAt(?string $visited_at): object
    {
        if ($this->_visited_at !== $visited_at) {
            $this->_visited_at = $visited_at;
            $this->_modified_fields['membre']['visited_at'] = true;
        }

        return $this;
    }

    /**
     * @return object
     */
    function setVisitedNow(): object
    {
        $now = date('Y-m-d H:i:s');

        if ($this->_visited_at !== $now) {
            $this->_visited_at = $now;
            $this->_modified_fields['membre']['visited_at'] = true;
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
    static function getMembres(array $params = [])
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
        if (isset($params['sort']) && (
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
            $sql .= "RAND(".time().") ";
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
     * @return int
     */
    function delete(): int
    {
        $db = DataBase::getInstance();

        $sql  = "DELETE FROM `" . Membre::getDbTable() . "` "
              . "WHERE `id_contact` = " . (int) $this->_id_contact;

        $db->query($sql);

        return $db->affectedRows();
    }

    /**
     * Sauve en db tables contact et membre
     */
    function save()
    {
        $db = DataBase::getInstance();

        // retourne les champs non fusionnés
        $fields = self::_getAllFields(false);

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
                if (count($this->_modified_fields['contact']) > 0) {
                    foreach ($this->_modified_fields['contact'] as $field => $value) {
                        if ($value === true) {
                            $sql .= '`' . $field . '`,';
                        }
                    }
                    $sql = substr($sql, 0, -1);
                }
                $sql .= ') VALUES (';

                if (count($this->_modified_fields['contact']) > 0) {
                    foreach ($this->_modified_fields['contact'] as $field => $value) {
                        if ($value !== true) {
                            continue;
                        }
                        $type = $fields['contact'][$field];
                        $att = '_' . $field;
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
                                    throw new Exception('invalid field type : ' . $type);
                                    break;
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
            if (count($this->_modified_fields['membre']) > 0) {
                foreach ($this->_modified_fields['membre'] as $field => $value) {
                    if ($value === true) {
                        $sql .= '`' . $field . '`,';
                    }
                }
                $sql = substr($sql, 0, -1);
            }
            $sql .= ') VALUES (';
            $sql .= (int) $this->getId() . ',';

            if (count($this->_modified_fields['membre']) > 0) {
                foreach ($this->_modified_fields['membre'] as $field => $value) {
                    if ($value !== true) {
                        continue;
                    }
                    $type = $fields['membre'][$field];
                    $att = '_' . $field;
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
                                throw new Exception('invalid field type : ' . $type);
                                break;
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

            if ((count($this->_modified_fields['contact']) === 0)
                && (count($this->_modified_fields['membre']) === 0)
            ) {
                return true; // pas de changement, ni dans Contact ni dans Membre
            }

            /* UPDATE contact */

            if (count($this->_modified_fields['contact']) > 0) {

                $fields_to_save = '';
                foreach ($this->_modified_fields['contact'] as $field => $value) {
                    if ($value !== true) {
                        continue;
                    }
                    $att = '_' . $field;
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
                                throw new Exception('invalid field type : ' . $fields['contact'][$field]);
                                break;
                        }
                    }
                }
                $fields_to_save = substr($fields_to_save, 0, -1);

                $sql  = 'UPDATE `' . Contact::getDbTable() . '` '
                      . 'SET ' . $fields_to_save . ' '
                      . 'WHERE `' . Contact::getDbPk() . '` = ' . (int) $this->getId();

                $this->_modified_fields['contact'] = [];

                $db->query($sql);

            }

            /* UPDATE membre */

            if (count($this->_modified_fields['membre']) > 0) {

                $fields_to_save = '';
                foreach ($this->_modified_fields['membre'] as $field => $value) {
                    if ($value !== true) {
                        continue;
                    }
                    $att = '_' . $field;
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
                                throw new Exception('invalid field type : ' . $fields['membre'][$field]);
                                break;
                        }
                    }
                }
                $fields_to_save = substr($fields_to_save, 0, -1);

                $sql = 'UPDATE `' . Membre::getDbTable() . '` '
                     . 'SET ' . $fields_to_save . ' '
                     . 'WHERE `' . Membre::getDbPk() . '` = ' . (int) $this->getId();

                $this->_modified_fields['membre'] = [];

                $db->query($sql);

            }

            return true;
        }
    }

    /**
     * Charge toutes les infos d'un membre
     *
     * @return bool
     * @throws Exception
     */
    protected function _loadFromDb(): bool
    {
        $db = DataBase::getInstance();

        $sql = "SELECT * "
             . "FROM `" . Membre::getDbTable() . "`, `". Contact::getDbTable() . "` "
             . "WHERE `" . Membre::getDbTable() . "`.`" . Membre::getDbPk() . "` = `" . Contact::getDbTable() . "`.`" . Contact::getDbPk() . "` "
             . "AND `" . Membre::getDbTable() . "`.`" . Membre::getDbPk() . "` = " . (int) $this->{'_' . Membre::getDbPk()};

        if ($res = $db->queryWithFetchFirstRow($sql)) {
            $this->_arrayToObject($res);
            return true;
        }

        throw new Exception('Membre introuvable');
    }

    /**
     * Vérifie l'appartenance d'une personne à un groupe
     *
     * @param int $id_groupe id_groupe
     *
     * @return bool
     * @throws Exception
     */
    function belongsTo(int $id_groupe): bool
    {
        if (!$this->_id_contact) {
            throw new Exception('id_contact manquant');
        }

        $db = DataBase::getInstance();

        $sql  = "SELECT `id_contact` "
              . "FROM `" . self::$_db_table_appartient_a . "` "
              . "WHERE `id_groupe` = " . (int) $id_groupe." "
              . "AND `id_contact` = " . (int) $this->_id_contact;

        $res  = $db->query($sql);

        return (bool) $db->numRows($res);
    }

    /**
     * Retourne si un membre est rattaché à au moins un groupe
     *
     * @return bool
     */
    function hasGroupe(): bool
    {
        return (count($this->getGroupes()) > 0);
    }

    /**
     * Le membre appartient-t-il au groupe "Membre Standard" ?
     *
     * @return bool
     */
    function isStandard(): bool
    {
        return (bool) ($this->_level & self::TYPE_STANDARD);
    }

    /**
     * Le membre appartient-t-il au groupe "Rédacteur" ?
     *
     * @return bool
     */
    function isRedacteur(): bool
    {
        return (bool) ($this->_level & self::TYPE_REDACTEUR);
    }

    /**
     * Le membre appartient-t-il au groupe "Membre Interne" ?
     *
     * @return bool
     */
    function isInterne(): bool
    {
        return (bool) ($this->_level & self::TYPE_INTERNE);
    }

    /**
     * Le membre appartient-t-il au groupe "Bonus" ?
     *
     * @return bool
     */
    function isBonus(): bool
    {
        return (bool) ($this->_level & self::TYPE_BONUS);
    }

    /**
     * Le membre appartient-t-il au groupe "Admin Système" ?
     *
     * @return bool
     */
    function isAdmin(): bool
    {
        return (bool) ($this->_level & self::TYPE_ADMIN);
    }

    /**
     * Retourne le pseudo du compte, méthode statique
     *
     * @param int $id_contact id_contact
     *
     * @return string
     */
    static function getPseudoById(int $id_contact)
    {
        $db = DataBase::getInstance();

        $sql  = "SELECT `pseudo` "
              . "FROM `" . Membre::getDbTable() . "` "
              . "WHERE `" . self::$_pk . "` = " . (int) $id_contact;

        return $db->queryWithFetchFirstField($sql);
    }

    /**
     * Retourne l'id du compte, méthode statique
     *
     * @param string $pseudo pseudo
     *
     * @return int
     */
    static function getIdByPseudo($pseudo): int
    {
        $db = DataBase::getInstance();

        $sql  = "SELECT `" . self::$_pk . "` "
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
    function checkPassword(string $password)
    {
        return self::checkPseudoPassword($this->_pseudo, $password);
    }

    /**
     * Retourne si le pseudo est disponible
     *
     * @param string $pseudo pseudo
     *
     * @return bool
     */
    static function isPseudoAvailable(string $pseudo): bool
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
    static function checkPseudoPassword(string $pseudo, string $password): int
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
    static function getTypesMembre(): array
    {
        return self::$_types_membre;
    }

    /**
     * Retourne le libellé d'une clé de la liste
     *
     * @param int $cle clé
     *
     * @return string|null
     */
    static function getTypeMembreName(int $cle): ?string
    {
        if (array_key_exists($cle, self::$_types_membre)) {
            return self::$_types_membre[$cle];
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
    static function getIdByEmail(string $email): int
    {
        if (!Email::validate($email)) {
            throw new Exception('email syntaxiquement incorrect');
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
    static function find(array $params): array
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

        if ((isset($params['order_by']) && (in_array($params['order_by'], array_keys(static::$_all_fields))))) {
            $sql .= "ORDER BY `" . $params['order_by'] . "` ";
        } else {
            $sql .= "ORDER BY `" . static::$_pk . "` ";
        }

        if ((isset($params['sort']) && (in_array($params['sort'], ['ASC', 'DESC'])))) {
            $sql .= $params['sort'] . " ";
        } else {
            $sql .= "ASC ";
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
