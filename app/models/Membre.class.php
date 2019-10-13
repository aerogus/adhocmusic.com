<?php declare(strict_types=1);

/**
 * Classe Membre
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Membre extends Contact
{
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
     * @var mixed
     */
    protected static $_instance = null;

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
    protected $_country = null;

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
    protected $_created_on = null;

    /**
     * @var string
     */
    protected $_modified_on = null;

    /**
     * @var string
     */
    protected $_visited_on = null;

    /**
     * @var array
     */
    protected $_types = [];

    /**
     * @var array
     */
    protected $_groupes = false;

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
        'pseudo'         => 'str',
        'password'       => 'pwd',
        'last_name'      => 'str',
        'first_name'     => 'str',
        'address'        => 'str',
        'cp'             => 'str',
        'city'           => 'str',
        'country'        => 'str',
        'id_city'        => 'num',
        'id_departement' => 'str',
        'id_region'      => 'str',
        'id_country'     => 'str',
        'tel'            => 'str',
        'port'           => 'str',
        'site'           => 'str',
        'text'           => 'str',
        'mailing'        => 'bool',
        'level'          => 'num',
        'created_on'     => 'date',
        'modified_on'    => 'date',
        'visited_on'     => 'date',
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
     * @return string|null
     */
    function getCp(): ?string
    {
        return $this->_cp;
    }

    /**
     * @return string|null
     */
    function getCity(): ?string
    {
        return $this->_city;
    }

    /**
     * @return string|null
     */
    function getCountry(): ?string
    {
        return $this->_country;
    }

    /**
     * @return int|null
     */
    function getIdCity(): ?int
    {
        return $this->_id_city;
    }

    /**
     * @return string|null
     */
    function getIdDepartement(): ?string
    {
        return $this->_id_departement;
    }

    /**
     * @return string|null
     */
    function getIdRegion(): ?string
    {
        return $this->_id_region;
    }

    /**
     * @return string|null
     */
    function getIdCountry(): ?string
    {
        return $this->_id_country;
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
    function getCreatedOn(): ?string
    {
        if (!is_null($this->_created_on) && Date::isDateTimeOk($this->_created_on)) {
            return $this->_created_on;
        }
        return null;
    }

    /**
     * @return int|null
     */
    function getCreatedOnTs(): ?int
    {
        if (!is_null($this->_created_on) && Date::isDateTimeOk($this->_created_on)) {
            return strtotime($this->_created_on);
        }
        return null;
    }

    /**
     * @return string|null
     */
    function getModifiedOn(): ?string
    {
        if (!is_null($this->_modified_on) && Date::isDateTimeOk($this->_modified_on)) {
            return $this->_modified_on;
        }
        return null;
    }

    /**
     * @return int|null
     */
    function getModifiedOnTs(): ?int
    {
        if (!is_null($this->_modified_on) && Date::isDateTimeOk($this->_modified_on)) {
             return strtotime($this->_modified_on);
        }
        return null;
    }

    /**
     * @return string|null
     */
    function getVisitedOn(): ?string
    {
        if (!is_null($this->_visited_on) && Date::isDateTimeOk($this->_visited_on)) {
            return $this->_visited_on;
        }
        return null;
    }

    /**
     * @return int|null
     */
    function getVisitedOnTs(): ?int
    {
        if (!is_null($this->_visited_on) && Date::isDateTimeOk($this->_visited_on)) {
             return strtotime($this->_visited_on);
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
        return self::getUrlById($this->getId());
    }

    /**
     * Retourne l'url de la fiche d'un membre AD'HOC
     *
     * @param int $id_contact id_contact
     *
     * @return string
     */
    static function getUrlById(int $id_contact): string
    {
        return HOME_URL . '/membres/' . (string) $id_contact;
    }

    /**
     * @return array
     */
    function getGroupes(): array
    {
        if ($this->_groupes === false) {
            $db   = DataBase::getInstance();

            $sql  = "SELECT `g`.`alias`, `g`.`id_groupe`, `g`.`name`, `a`.`id_type_musicien` "
                  . "FROM `" . self::$_db_table_appartient_a . "` `a`, "
                  . "`" . Groupe::getDbTable() . "` `g` "
                  . "WHERE `a`.`id_groupe` = `g`.`id_groupe` "
                  . "AND `a`.`id_contact` = " . (int) $this->getId(). " "
                  . "ORDER BY `g`.`name` ASC";

            $this->_groupes = $db->queryWithFetch($sql);

            foreach ($this->_groupes as $key => $groupe) {
                try {
                    $this->_groupes[$key]['type_musicien_name'] = TypeMusicien::getInstance((int) $groupe['id_type_musicien'])->getName();
                } catch (Exception $e) {
                    $this->_groupes[$key]['type_musicien_name'] = 'non défini';
                }
                $this->_groupes[$key]['url'] = Groupe::getUrlFiche($groupe['alias']);
            }
        }

        return $this->_groupes;
    }

    /**
     * @return string|null
     */
    function getAvatar(): ?string
    {
        if (file_exists(self::getBasePath() . '/' . $this->getId() . '.jpg')) {
            return self::getBaseUrl() . '/' . $this->getId() . '.jpg?ts=' . $this->getModifiedOnTs();
        }
        return null;
    }

    /**
     * @return string|null
     * @todo uniquement dans MembreAdhoc ?
     */
    function getAvatarInterne(): ?string
    {
        if (file_exists(self::getBasePath() . '/ca/' . $this->getId() . '.jpg')) {
            return self::getBaseUrl() . '/ca/' . $this->getId() . '.jpg?ts=' . $this->getModifiedOnTs();
        }
        return null;
    }

    /* fin getters */

    /* début setters */

    /**
     * @param string|null $val val
     *
     * @return object
     */
    function setPseudo(?string $val): object
    {
        if ($this->_pseudo !== $val) {
            $this->_pseudo = $val;
            $this->_modified_fields['membre']['pseudo'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $val val
     * /!\ le donner sous forme cryptée mysql ?
     *
     * @return object
     */
    function setPassword(?string $val): object
    {
        if ($this->_password !== $val) {
            $this->_password = $val;
            $this->_modified_fields['membre']['password'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $val val
     *
     * @return object
     */
    function setLastName(?string $val): object
    {
        if ($this->_last_name !== $val) {
            $this->_last_name = $val;
            $this->_modified_fields['membre']['last_name'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $val val
     *
     * @return object
     */
    function setFirstName(?string $val): object
    {
        if ($this->_first_name !== $val) {
            $this->_first_name = $val;
            $this->_modified_fields['membre']['first_name'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $val val
     *
     * @return object
     */
    function setAddress(?string $val): object
    {
        if ($this->_address !== $val) {
            $this->_address = $val;
            $this->_modified_fields['membre']['address'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $val val
     *
     * @return object
     */
    function setCp(?string $val): object
    {
        if ($this->_cp !== $val) {
            $this->_cp = $val;
            $this->_modified_fields['membre']['cp'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $val val
     *
     * @return object
     */
    function setCity(?string $val): object
    {
        if ($this->_city !== $val) {
            $this->_city = $val;
            $this->_modified_fields['membre']['city'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $val val
     *
     * @return object
     */
    function setCountry(?string $val): object
    {
        if ($this->_country !== $val) {
            $this->_country = $val;
            $this->_modified_fields['membre']['country'] = true;
        }

        return $this;
    }

    /**
     * @param int|null $val val
     *
     * @return object
     */
    function setIdCity(?int $val): object
    {
        if ($this->_id_city !== $val) {
            $this->_id_city = $val;
            $this->_modified_fields['membre']['id_city'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $val val
     *
     * @return object
     */
    function setIdDepartement(?string $val): object
    {
        if ($this->_id_departement !== $val) {
            $this->_id_departement = $val;
            $this->_modified_fields['membre']['id_departement'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $val val
     * 
     * @return object
     */
    function setIdRegion(?string $val): object
    {
        if ($this->_id_region !== $val) {
            $this->_id_region = $val;
            $this->_modified_fields['membre']['id_region'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $val val
     *
     * @return object
     */
    function setIdCountry(?string $val): object
    {
        if ($this->_id_country !== $val) {
            $this->_id_country = $val;
            $this->_modified_fields['membre']['id_country'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $val val
     *
     * @return object
     */
    function setTel(?string $val): object
    {
        if ($this->_tel !== $val) {
            $this->_tel = $val;
            $this->_modified_fields['membre']['tel'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $val val
     *
     * @return object
     */
    function setPort(?string $val): object
    {
        if ($this->_port !== $val) {
            $this->_port = $val;
            $this->_modified_fields['membre']['port'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $val val
     *
     * @return object
     */
    function setSite(?string $val): object
    {
        if ($this->_site !== $val) {
            $this->_site = $val;
            $this->_modified_fields['membre']['site'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $val val
     *
     * @return object
     */
    function setText(?string $val): object
    {
        if ($this->_text !== $val) {
            $this->_text = $val;
            $this->_modified_fields['membre']['text'] = true;
        }

        return $this;
    }

    /**
     * @param bool $val val
     *
     * @return object
     */
    function setMailing(bool $val): object
    {
        if ($this->_mailing !== $val) {
            $this->_mailing = $val;
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
     * @param string $created_on date de création "YYYY-MM-DD HH:II:SS"
     *
     * @return object
     */
    function setCreatedOn(string $created_on): object
    {
        if ($this->_created_on !== $created_on) {
            $this->_created_on = $created_on;
            $this->_modified_fields['membre']['created_on'] = true;
        }

        return $this;
    }

    /**
     * @return object
     */
    function setCreatedNow(): object
    {
        $now = date('Y-m-d H:i:s');
        if ($this->_created_on !== $now) {
            $this->_created_on = $now;
            $this->_modified_fields['membre']['created_on'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $modified_on date de modification "YYYY-MM-DD HH:II:SS"
     *
     * @return object
     */
    function setModifiedOn(?string $modified_on): object
    {
        if ($this->_modified_on !== $modified_on) {
            $this->_modified_on = $modified_on;
            $this->_modified_fields['membre']['modified_on'] = true;
        }

        return $this;
    }

    /**
     * @return object
     */
    function setModifiedNow(): object
    {
        $now = date('Y-m-d H:i:s');
        if ($this->_modified_on !== $now) {
            $this->_modified_on = $now;
            $this->_modified_fields['membre']['modified_on'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $visited_on date de dernière connexion "YYYY-MM-DD HH:II:SS"
     *
     * @return object
     */
    function setVisitedOn(?string $visited_on): object
    {
        if ($this->_visited_on !== $visited_on) {
            $this->_visited_on = $visited_on;
            $this->_modified_fields['membre']['visited_on'] = true;
        }

        return $this;
    }

    /**
     * @return object
     */
    function setVisitedNow(): object
    {
        $now = date('Y-m-d H:i:s');
        if ($this->_visited_on !== $now) {
            $this->_visited_on = $now;
            $this->_modified_fields['membre']['visited_on'] = true;
        }

        return $this;
    }

    /* fin setters */

    /**
     * Retourne les id de membres appartenant à au moins un groupe
     * qu'on peut optionnellement spécifier et/ou un type de musicien
     *
     * @param int $id_groupe        id_groupe
     * @param int $id_type_musicien id_type_musicien
     *
     * @return array
     */
    static function getIdsMembresByGroupeAndTypeMusicien(int $id_groupe = 0, int $id_type_musicien = 0)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `m`.`id_contact`, `a`.`id_groupe`, `a`.`id_type_musicien`, `g`.`name` "
             . "FROM `adhoc_membre` `m`, `adhoc_appartient_a` `a`, `adhoc_groupe` `g` "
             . "WHERE `m`.`id_contact` = `a`.`id_contact` "
             . "AND `a`.`id_groupe` = `g`.`id_groupe`";

        if ($id_type_musicien) {
            $sql .= "AND `a`.`id_type_musicien` = " . (int) $id_type_musicien . " ";
        }

        if ($id_groupe) {
            $sql .= "AND `g`.`id_groupe` = " . (int) $id_groupe;
        }

        $res = $db->queryWithFetch($sql);
        $tab = [];
        foreach ($res as $_res) {
            $tab[$_res['id_contact']][] = [
                'id_groupe' => $_res['id_groupe'],
                'id_type_musicien' => $_res['id_type_musicien'],
                'type_musicien' => TypeMusicien::getInstance((int) $_res['id_type_musicien'])->getName(),
                'name' => $_res['name'],
            ];
        }
        return $tab;
    }

    /**
     * Recherche des membres en fonction de critères donnés
     *
     * @param array ['id']            => "3"
     *              ['pseudo']        => "aerog%"
     *              ['last_name']     => "sez%"
     *              ['first_name']    => "gui%"
     *              ['email']         => "email%"
     *              ['sort']          => "id_contact|last_name|first_name|random|email|created_on|modified_on"
     *                                   "visited_on|pseudo|lastnl"
     *              ['sens']          => "ASC|DESC"
     *              ['debut']         => 0
     *              ['limit']         => 10
     *
     * @return array
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
         || $params['sort'] === 'email' || $params['sort'] === 'created_on'
         || $params['sort'] === 'modified_on' || $params['sort'] === 'visited_on'
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
             . "`m`.`created_on`, `m`.`modified_on`, `m`.`visited_on`, "
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
        // on vérifie les clés étrangères

        if ($this->hasGroupe()) {
            // on efface dans appartient_a
        }

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
        if (!$this->getId() || ($this->getId() && !Membre::getPseudoById($this->getId()))) { // INSERT

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
                                case 'num':
                                case 'float':
                                    $sql .= $db->escape((string) $this->$att) . ',';
                                    break;
                                case 'str':
                                    $sql .= "'" . $db->escape($this->$att) . "',";
                                    break;
                                case 'bool':
                                    $sql .= ((bool) $this->$att ? 'TRUE' : 'FALSE') . ",";
                                    break;
                                case 'pwd':
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

        if (!Membre::getPseudoById($this->getId())) { // INSERT

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
                            case 'num':
                            case 'float':
                                $sql .= $db->escape((string) $this->$att) . ",";
                                break;
                            case 'str':
                                $sql .= "'" . $db->escape($this->$att) . "',";
                                break;
                            case 'bool':
                                $sql .= ((bool) $this->$att ? 'TRUE' : 'FALSE') . ",";
                                break;
                            case 'pwd':
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
                    switch ($fields['contact'][$field]) {
                        case 'num':
                        case 'float':
                            $fields_to_save .= " `" . $field . "` = " . $db->escape($this->$att) . ",";
                            break;
                        case 'str':
                            $fields_to_save .= " `" . $field . "` = '" . $db->escape($this->$att) . "',";
                            break;
                        case 'bool':
                            $fields_to_save .= " `" . $field . "` = " . (((bool) $this->$att) ? 'TRUE' : 'FALSE') . ",";
                            break;
                        case 'pwd':
                            $fields_to_save .= " `" . $field . "` = PASSWORD('" . $db->escape($this->$att) . "'),";
                            break;
                        case 'phpser':
                            $fields_to_save .= " `" . $field . "` = '" . $db->escape(serialize($this->$att)) . "',";
                            break;
                        case 'date':
                            $fields_to_save .= "`" . $field . "` = " . (is_null($this->$att) ? 'NULL' : "'" . $db->escape($this->$att) . "'") . ",";
                            break;
                        default:
                            throw new Exception('invalid field type : ' . $fields['contact'][$field]);
                            break;
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
                    switch ($fields['membre'][$field]) {
                        case 'num':
                        case 'float':
                            $fields_to_save .= " `" . $field . "` = " . $db->escape($this->$att) . ",";
                            break;
                        case 'str':
                            $fields_to_save .= " `" . $field . "` = '" . $db->escape($this->$att) . "',";
                            break;
                        case 'bool':
                            $fields_to_save .= " `" . $field . "` = " . (((bool) $this->$att) ? 'TRUE' : 'FALSE') . ",";
                            break;
                        case 'pwd':
                            $fields_to_save .= " `" . $field . "` = PASSWORD('" . $db->escape($this->$att) . "'),";
                            break;
                        case 'phpser':
                            $fields_to_save .= " `" . $field . "` = '" . $db->escape(serialize($this->$att)) . "',";
                            break;
                        case 'date':
                            $fields_to_save .= "`" . $field . "` = " . (is_null($this->$att) ? 'NULL' : "'" . $db->escape($this->$att) . "'") . ",";
                            break;
                        default:
                            throw new Exception('invalid field type : ' . $fields['membre'][$field]);
                            break;
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

        $sql  = "SELECT *
                 FROM `" . Membre::getDbTable() . "`, `". Contact::getDbTable() . "`
                 WHERE `" . Membre::getDbTable() . "`.`" . Membre::getDbPk() . "` = `" . Contact::getDbTable() . "`.`" . Contact::getDbPk() . "`
                 AND `" . Membre::getDbTable() . "`.`" . Membre::getDbPk() . "` = " . (int) $this->{'_' . Membre::getDbPk()};

        if ($res = $db->queryWithFetchFirstRow($sql)) {
            $this->_dbToObject($res);
            return true;
        }
        return false;
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
    function isStandard()
    {
        return (bool) ($this->_level & self::TYPE_STANDARD);
    }

    /**
     * Le membre appartient-t-il au groupe "Rédacteur" ?
     *
     * @return bool
     */
    function isRedacteur()
    {
        return (bool) ($this->_level & self::TYPE_REDACTEUR);
    }

    /**
     * Le membre appartient-t-il au groupe "Membre Interne" ?
     *
     * @return bool
     */
    function isInterne()
    {
        return (bool) ($this->_level & self::TYPE_INTERNE);
    }

    /**
     * Le membre appartient-t-il au groupe "Bonus" ?
     *
     * @return bool
     */
    function isBonus()
    {
        return (bool) ($this->_level & self::TYPE_BONUS);
    }

    /**
     * Le membre appartient-t-il au groupe "Admin Système" ?
     *
     * @return bool
     */
    function isAdmin()
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
     * Retourne le nombre total de membres
     *
     * @return int
     */
    static function getMembresCount(): int
    {
        $db = DataBase::getInstance();

        $sql = 'SELECT COUNT(*) FROM `' . Membre::getDbTable() . '`';

        return (int) $db->queryWithFetchFirstField($sql);
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
     * Retourne les pauvres vieux pas connectés depuis fort jadis
     *
     * @return array
     */
    static function getOneYearUnactivesMembers(): array
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `m`.`id_contact`, `m`.`pseudo`, `c`.`email`, `m`.`visited_on`, `m`.`created_on` "
             . "FROM `adhoc_membre` `m`, `adhoc_contact` `c` "
             . "WHERE `m`.`id_contact` = `c`.`id_contact` "
             . "AND `m`.`visited_on` < DATE_SUB(CURDATE(), INTERVAL 1 YEAR) "
             . "ORDER BY `m`.`visited_on` DESC";

        return $db->queryWithFetch($sql);
    }
}
