<?php

/**
 * @package adhoc
 */

/**
 * Classe Membre
 *
 * @package adhoc
 * @author Guillaume Seznec <guillaume.seznec@gmail.com>
 */
class Membre extends Contact
{
    /**
     * gestion des droits utilisateurs
     * par masque binaire
     */
    const TYPE_STANDARD  = 0x01; // 00001
    const TYPE_REDACTEUR = 0x02; // 00010
    const TYPE_INTERNE   = 0x04; // 00100
    const TYPE_BONUS     = 0x08; // 01000
    const TYPE_ADMIN     = 0x10; // 10000

    /**
     * liste des types musiciens
     */
    const TYPE_MUSICIEN_NON =  1;
    const TYPE_MUSICIEN_BAT =  2;
    const TYPE_MUSICIEN_GTR =  3;
    const TYPE_MUSICIEN_BAS =  4;
    const TYPE_MUSICIEN_CHA =  5;
    const TYPE_MUSICIEN_CHO =  6;
    const TYPE_MUSICIEN_SAX =  7;
    const TYPE_MUSICIEN_FLU =  8;
    const TYPE_MUSICIEN_TRP =  9;
    const TYPE_MUSICIEN_TRB = 10;
    const TYPE_MUSICIEN_PRC = 11;
    const TYPE_MUSICIEN_ORG = 12;
    const TYPE_MUSICIEN_CLA = 13;
    const TYPE_MUSICIEN_SAM = 14;
    const TYPE_MUSICIEN_PIA = 15;
    const TYPE_MUSICIEN_MAN = 16;
    const TYPE_MUSICIEN_DJ  = 17;
    const TYPE_MUSICIEN_VJ  = 18;
    const TYPE_MUSICIEN_SON = 19;
    const TYPE_MUSICIEN_LUM = 20;
    const TYPE_MUSICIEN_VLN = 21;
    const TYPE_MUSICIEN_VLC = 22;

    /**
     * Tableau des types de membre
     *
     * @var array
     */
    protected static $_types_membre = array(
        self::TYPE_STANDARD  => "Standard",
        self::TYPE_REDACTEUR => "Rédacteur",
        self::TYPE_INTERNE   => "Interne",
        self::TYPE_BONUS     => "Bonus",
        self::TYPE_ADMIN     => "Administrateur",
    );

    /**
     * Tableau des types de musicien
     *
     * @var array
     */
    protected static $_types_musicien = array(
        self::TYPE_MUSICIEN_NON => " Non précisé",
        self::TYPE_MUSICIEN_BAT => "Batteur",
        self::TYPE_MUSICIEN_GTR => "Guitariste",
        self::TYPE_MUSICIEN_BAS => "Bassiste",
        self::TYPE_MUSICIEN_CHA => "Chanteur",
        self::TYPE_MUSICIEN_CHO => "Choriste",
        self::TYPE_MUSICIEN_SAX => "Saxophoniste",
        self::TYPE_MUSICIEN_FLU => "Flûtiste",
        self::TYPE_MUSICIEN_TRP => "Trompettiste",
        self::TYPE_MUSICIEN_TRB => "Tromboniste",
        self::TYPE_MUSICIEN_PRC => "Percussioniste",
        self::TYPE_MUSICIEN_ORG => "Organiste",
        self::TYPE_MUSICIEN_CLA => "Clavieriste",
        self::TYPE_MUSICIEN_SAM => "Sampliste",
        self::TYPE_MUSICIEN_PIA => "Pianiste",
        self::TYPE_MUSICIEN_MAN => "Manager",
        self::TYPE_MUSICIEN_DJ  => "DJ",
        self::TYPE_MUSICIEN_VJ  => "VJ",
        self::TYPE_MUSICIEN_SON => "Ingénieur son",
        self::TYPE_MUSICIEN_LUM => "Ingénieur lumière",
        self::TYPE_MUSICIEN_VLN => "Violoniste",
        self::TYPE_MUSICIEN_VLC => "Violoncelliste",
    );

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
    protected $_pseudo = '';

    /**
     * @var string
     */
    protected $_password = '';

    /**
     * @var string
     */
    protected $_last_name = '';

    /**
     * @var string
     */
    protected $_first_name = '';

    /**
     * @var string
     */
    protected $_address = '';

    /**
     * @var string
     */
    protected $_cp = '';

    /**
     * @var string
     */
    protected $_city = '';

    /**
     * @var string
     */
    protected $_country = '';

    /**
     * @var int
     */
    protected $_id_city = 0;

    /**
     * @var string
     */
    protected $_id_departement = '';

    /**
     * @var string
     */
    protected $_id_region = '';

    /**
     * @var string
     */
    protected $_id_country = '';

    /**
     * @var string
     */
    protected $_tel = '';

    /**
     * @var string
     */
    protected $_port = '';

    /**
     * @var string
     */
    protected $_site = '';

    /**
     * @var string
     */
    protected $_text = '';

    /**
     * @var bool
     */
    protected $_mailing = true;

    /**
     * @var int
     */
    protected $_level = 0;

    /**
     * @var int
     */
    protected $_facebook_profile_id = 0;

    /**
     * @string
     */
    protected $_facebook_auto_login = false;

    /**
     * @var string
     */
    protected $_created_on = '';

    /**
     * @var string
     */
    protected $_modified_on = '';

    /**
     * @var string
     */
    protected $_visited_on = '';

    /**
     * @var array
     */
    protected $_types = array();

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
     * @var array
     */
    protected static $_all_fields = array(
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
        'facebook_profile_id' => 'num',
        'facebook_auto_login' => 'bool',
        'created_on'     => 'str',
        'modified_on'    => 'str',
        'visited_on'     => 'str',
    );

    /**
     * Tableau des attributs modifiés depuis la dernière sauvegarde.
     *
     * Pour chaque attribut modifié, on a un élément de la forme 'attribut => true'.
     * @var array
     */
    protected $_modified_fields = array(
        'contact' => array(),
        'membre'  => array(),
    );

    /**
     * @return string
     */
    static function getBaseUrl()
    {
        return MEDIA_URL . '/membre';
    }

    /**
     * @return string
     */
    static function getBasePath()
    {
        return MEDIA_PATH . '/membre';
    }

    /**
     * @param bool
     * @return array
     */
    protected function _getAllFields($fusion = true)
    {
        if($fusion) {
            return array_merge(
                Contact::$_all_fields,
                Membre::$_all_fields
            );
        } else {
            return array_merge(array(
                'contact' => Contact::$_all_fields,
                'membre' => Membre::$_all_fields,
            ));
        }
    }

    /**
     * @return string
     */
    function getPseudo()
    {
        return (string) $this->_pseudo;
    }

    /**
     * @return string
     * /!\ sous forme cryptée mysql
     */
    function getPassword()
    {
        return (string) $this->_password;
    }

    /**
     * @return string
     */
    function getLastName()
    {
        return (string) $this->_last_name;
    }

    /**
     * Extraction du nom
     *
     * @param int
     * @return string
     */
    static function getLastNameById($id_contact)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `last_name` "
             . "FROM `" . self::$_db_table_membre . "` "
             . "WHERE `id_contact` = " . (int) $id_contact;

        return $db->queryWithFetchFirstField($sql);
    }

    /**
     * @return string
     */
    function getFirstName()
    {
        return (string) $this->_first_name;
    }

    /**
     * Extraction du prénom
     *
     * @param int
     * @return string
     */
    static function getFirstNameById($id_contact)
    {
        $db   = DataBase::getInstance();

        $sql  = "SELECT `first_name` "
              . "FROM `" . self::$_db_table_membre . "` "
              . "WHERE `id_contact` = " . (int) $id_contact;

        return $db->queryWithFetchFirstField($sql);
    }

    /**
     * @return string
     */
    function getAddress()
    {
        return (string) $this->_address;
    }

    /**
     * @return string
     */
    function getCp()
    {
        return (string) $this->_cp;
    }

    /**
     * @return string
     */
    function getCity()
    {
        return (string) $this->_city;
    }

    /**
     * @return string
     */
    function getCountry()
    {
        return (string) $this->_country;
    }

    /**
     * @return int
     */
    function getIdCity()
    {
        return (int) $this->_id_city;
    }

    /**
     * @return string
     */
    function getIdDepartement()
    {
        return (string) $this->_id_departement;
    }

    /**
     * @return string
     */
    function getIdRegion()
    {
        return (string) $this->_id_region;
    }

    /**
     * @return string
     */
    function getIdCountry()
    {
        return (string) $this->_id_country;
    }

    /**
     * @return string
     */
    function getTel()
    {
        return (string) $this->_tel;
    }

    /**
     * @return string
     */
    function getPort()
    {
        return (string) $this->_port;
    }

    /**
     * @return string
     */
    function getSite()
    {
        return (string) $this->_site;
    }

    /**
     * @return string
     */
    function getText()
    {
        return (string) $this->_text;
    }

    /**
     * @return bool
     */
    function getMailing()
    {
        return (bool) $this->_mailing;
    }

    /**
     * @return int
     */
    function getLevel()
    {
        return (int) $this->_level;
    }

    /**
     * @return int
     */
    function getFacebookProfileId()
    {
        return (string) $this->_facebook_profile_id;
    }

    /**
     * @return string
     */
    function getFacebookProfileUrl()
    {
        return 'http://www.facebook.com/profile.php?id=' . (string) $this->_facebook_profile_id;
    }

    /**
     * @return bool
     */
    function getFacebookAutoLogin()
    {
        return $this->_facebook_auto_login;
    }

    /**
     * @return string
     */
    function getCreatedOn()
    {
        if(Date::isDateTimeOk($this->_created_on)) {
            return (string) $this->_created_on;
        }
        return false;
    }

    /**
     * @return int
     */
    function getCreatedOnTs()
    {
        if(Date::isDateTimeOk($this->_created_on)) {
            return (int) strtotime($this->_created_on);
        }
        return false;
    }

    /**
     * @return string
     */
    function getModifiedOn()
    {
        if(Date::isDateTimeOk($this->_modified_on)) {
            return (string) $this->_modified_on;
        }
        return false;
    }

    /**
     * @return int
     */
    function getModifiedOnTs()
    {
        if(Date::isDateTimeOk($this->_modified_on)) {
             return (int) strtotime($this->_modified_on);
        }
        return false;
    }

    /**
     * @return string
     */
    function getVisitedOn()
    {
        if(Date::isDateTimeOk($this->_visited_on)) {
            return (string) $this->_visited_on;
        }
        return false;
    }

    /**
     * @return int
     */
    function getVisitedOnTs()
    {
        if(Date::isDateTimeOk($this->_visited_on)) {
             return (int) strtotime($this->_visited_on);
        }
        return false;
    }

    /**
     * Retourne l'url de la fiche d'un membre AD'HOC
     *
     * @param bool
     * @return string
     */
    function getUrl()
    {
        return self::getUrlById($this->getId());
    }

    /**
     * Retourne l'url de la fiche d'un membre AD'HOC
     *
     * @param int $id_contact
     * @return string
     */
    static function getUrlById($id_contact)
    {
        return '/membres/' . (int) $id_contact;
    }

    /**
     * @return array
     */
    function getGroupes()
    {
        if($this->_groupes === false)
        {
            $db   = DataBase::getInstance();

            $sql  = "SELECT `g`.`alias`, `g`.`id_groupe`, `g`.`name`, `a`.`id_type_musicien` "
                  . "FROM `" . self::$_db_table_appartient_a . "` `a`, "
                  . "`" . self::$_db_table_groupe . "` `g` "
                  . "WHERE `a`.`id_groupe` = `g`.`id_groupe` "
                  . "AND `a`.`id_contact` = " . (int) $this->getId(). " "
                  . "ORDER BY `g`.`name` ASC";

            $this->_groupes = $db->queryWithFetch($sql);

            foreach($this->_groupes as $key => $groupe)
            {
                $this->_groupes[$key]['type_musicien_name'] = self::getTypeMusicienName($groupe['id_type_musicien']);
                $this->_groupes[$key]['url'] = Groupe::getUrlFiche($groupe['alias']);
            }
        }

        return $this->_groupes;
    }

    /**
     * @return string
     * @todo uniquement dans MembreAdhoc ?
     */
    function getAvatarInterne()
    {
        if (file_exists(self::getBasePath() . '/ca/' . $this->getId() . '.jpg')) {
            return self::getBaseUrl() . '/ca/' . $this->getId() . '.jpg?ts=' . $this->getModifiedOnTs();
        }
        return false;
    }

    /**
     * @return string
     */
    function getAvatar()
    {
        if (file_exists(self::getBasePath() . '/' . $this->getId() . '.jpg')) {
            return self::getBaseUrl() . '/' . $this->getId() . '.jpg?ts=' . $this->getModifiedOnTs();
        }
        return false;
    }

    /* fin getters */

    /* début setters */

    /**
     * @param string
     */
    function setPseudo($val)
    {
        if ($this->_pseudo !== $val)
        {
            $this->_pseudo = (string) $val;
            $this->_modified_fields['membre']['pseudo'] = true;
        }
    }

    /**
     * @param string
     * /!\ le donner sous forme cryptée mysql ?
     */
    function setPassword($val)
    {
        if ($this->_password !== $val)
        {
            $this->_password = (string) $val;
            $this->_modified_fields['membre']['password'] = true;
        }
    }

    /**
     * @param string
     */
    function setLastName($val)
    {
        if ($this->_last_name !== $val)
        {
            $this->_last_name = (string) $val;
            $this->_modified_fields['membre']['last_name'] = true;
        }
    }

    /**
     * @param string
     */
    function setFirstName($val)
    {
        if ($this->_first_name !== $val)
        {
            $this->_first_name = (string) $val;
            $this->_modified_fields['membre']['first_name'] = true;
        }
    }

    /**
     * @param string
     */
    function setAddress($val)
    {
        if ($this->_address !== $val)
        {
            $this->_address = (string) $val;
            $this->_modified_fields['membre']['address'] = true;
        }
    }

    /**
     * @param string
     */
    function setCp($val)
    {
        if ($this->_cp !== $val)
        {
            $this->_cp = (string) $val;
            $this->_modified_fields['membre']['cp'] = true;
        }
    }

    /**
     * @param string
     */
    function setCity($val)
    {
        if ($this->_city !== $val)
        {
            $this->_city = (string) $val;
            $this->_modified_fields['membre']['city'] = true;
        }
    }

    /**
     * @param string
     */
    function setCountry($val)
    {
        if ($this->_country !== $val)
        {
            $this->_country = (string) $val;
            $this->_modified_fields['membre']['country'] = true;
        }
    }

    /**
     * @param int
     */
    function setIdCity($val)
    {
        if ($this->_id_city !== $val)
        {
            $this->_id_city = (int) $val;
            $this->_modified_fields['membre']['id_city'] = true;
        }
    }

    /**
     * @param string
     */
    function setIdDepartement($val)
    {
        if ($this->_id_departement !== $val)
        {
            $this->_id_departement = (string) $val;
            $this->_modified_fields['membre']['id_departement'] = true;
        }
    }

    /**
     * @param string
     */
    function setIdRegion($val)
    {
        if ($this->_id_region !== $val)
        {
            $this->_id_region = (string) $val;
            $this->_modified_fields['membre']['id_region'] = true;
        }
    }

    /**
     * @param string
     */
    function setIdCountry($val)
    {
        if ($this->_id_country !== $val)
        {
            $this->_id_country = (string) $val;
            $this->_modified_fields['membre']['id_country'] = true;
        }
    }

    /**
     * @param string
     */
    function setTel($val)
    {
        if ($this->_tel !== $val)
        {
            $this->_tel = (string) $val;
            $this->_modified_fields['membre']['tel'] = true;
        }
    }

    /**
     * @param string
     */
    function setPort($val)
    {
        if ($this->_port !== $val)
        {
            $this->_port = (string) $val;
            $this->_modified_fields['membre']['port'] = true;
        }
    }

    /**
     * @param string
     */
    function setSite($val)
    {
        if ($this->_site !== $val)
        {
            $this->_site = (string) $val;
            $this->_modified_fields['membre']['site'] = true;
        }
    }

    /**
     * @param string
     */
    function setText($val)
    {
        if ($this->_text !== $val)
        {
            $this->_text = (string) $val;
            $this->_modified_fields['membre']['text'] = true;
        }
    }

    /**
     * @param bool
     */
    function setMailing($val)
    {
        if ($this->_mailing !== $val)
        {
            $this->_mailing = (bool) $val;
            $this->_modified_fields['membre']['mailing'] = true;
        }
    }

    /**
     * @param int
     */
    function setLevel($val)
    {
        if ($this->_level !== $val)
        {
            $this->_level = (int) $val;
            $this->_modified_fields['membre']['level'] = true;
        }
    }

    /**
     * @param int
     */
    function setFacebookProfileId($val)
    {
        if ($this->_facebook_profile_id !== $val)
        {
            $this->_facebook_profile_id = (int) $val;
            $this->_modified_fields['membre']['facebook_profile_id'] = true;
        }
    }

    /**
     * @param int
     */
    function setFacebookAutoLogin($val)
    {
        if ($this->_facebook_auto_login !== $val)
        {
            $this->_facebook_auto_login = (bool) $val;
            $this->_modified_fields['membre']['facebook_auto_login'] = true;
        }
    }

    /**
     * @param string
     */
    function setCreatedOn($val)
    {
        if ($this->_created_on !== $val)
        {
            $this->_created_on = (string) $val;
            $this->_modified_fields['membre']['created_on'] = true;
        }
    }

    /**
     * @param string
     */
    function setCreatedNow()
    {
        $now = date('Y-m-d H:i:s');
        if ($this->_created_on !== $now)
        {
            $this->_created_on = (string) $now;
            $this->_modified_fields['membre']['created_on'] = true;
        }
    }

    /**
     * @param string
     */
    function setModifiedOn($val)
    {
        if ($this->_modified_on !== $val)
        {
            $this->_modified_on = (string) $val;
            $this->_modified_fields['membre']['modified_on'] = true;
        }
    }

    /**
     *
     */
    function setModifiedNow()
    {
        $now = date('Y-m-d H:i:s');
        if ($this->_modified_on !== $now)
        {
            $this->_modified_on = (string) $now;
            $this->_modified_fields['membre']['modified_on'] = true;
        }
    }

    /**
     * @param string
     */
    function setVisitedOn($val)
    {
        if ($this->_visited_on !== $val)
        {
            $this->_visited_on = (string) $val;
            $this->_modified_fields['membre']['visited_on'] = true;
        }
    }

    /**
     * @param string
     */
    function setVisitedNow()
    {
        $now = date('Y-m-d H:i:s');
        if ($this->_visited_on !== $now)
        {
            $this->_visited_on = (string) $now;
            $this->_modified_fields['membre']['visited_on'] = true;
        }
    }

    /* fin setters */

    /**
     * retourne les id de membres appartenant à au moins un groupe
     * qu'on peut optionnellement spécifier et/ou un type de musicien
     * @param int $id_groupe
     * @param int $id_type_musicien
     * @return array
     */
    static function getIdsMembresByGroupeAndTypeMusicien($id_groupe = 0, $id_type_musicien = 0)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `m`.`id_contact`, `a`.`id_groupe`, `a`.`id_type_musicien`, `g`.`name` "
             . "FROM `adhoc_membre` `m`, `adhoc_appartient_a` `a`, `adhoc_groupe` `g` "
             . "WHERE `m`.`id_contact` = `a`.`id_contact` "
             . "AND `a`.`id_groupe` = `g`.`id_groupe`";

        if($id_type_musicien) {
            $sql .= "AND `a`.`id_type_musicien` = " . (int) $id_type_musicien . " ";
        }

        if($id_groupe) {
            $sql .= "AND `g`.`id_groupe` = " . (int) $id_groupe;
        }


        $res = $db->queryWithFetch($sql);
        $tab = array();
        foreach($res as $_res)
        {
            $tab[$_res['id_contact']][] = array(
                'id_groupe' => $_res['id_groupe'],
                'id_type_musicien' => $_res['id_type_musicien'],
                'type_musicien' => self::getTypeMusicienName($_res['id_type_musicien']),
                'name' => $_res['name'],
            );
        }
        return $tab;
    }

    /**
     * recherche des membres en fonction de critères donnés
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
     * @return array

     */
    static function getMembres($params = array())
    {
        $pseudo = null;
        if(isset($params['pseudo'])) {
            $pseudo = (string) $params['pseudo'];
        }

        $last_name = null;
        if(isset($params['last_name'])) {
            $last_name = (string) $params['last_name'];
        }

        $first_name = null;
        if(isset($params['first_name'])) {
            $first_name = (string) $params['first_name'];
        }

        $email = null;
        if(isset($params['email'])) {
            $email = (string) $params['email'];
        }

        $debut = 0;
        if(isset($params['debut'])) {
            $debut = (int) $params['debut'];
        }

        $limit = 10;
        if(isset($params['limit'])) {
            $limit = (int) $params['limit'];
        }

        $sens = "ASC";
        if(isset($params['sens']) && $params['sens'] == "DESC") {
            $sens = "DESC";
        }

        $sort = "id_contact";
        if(isset($params['sort']) && (
            $params['sort'] == 'random' || $params['sort'] == 'id_contact'
         || $params['sort'] == 'last_name' || $params['sort'] == 'first_name'
         || $params['sort'] == 'email' || $params['sort'] == 'created_on'
         || $params['sort'] == 'modified_on' || $params['sort'] == 'visited_on'
         || $params['sort'] == 'pseudo' || $params['sort'] == 'lastnl')) {
            $sort = $params['sort'];
        }

        $tab_id = array();
        if(array_key_exists('id', $params)) {
            $tab_id = explode(",", $params['id']);
        }

        $db = DataBase::getInstance();

        $sql = "SELECT `m`.`id_contact` AS `id`, `m`.`last_name`, `m`.`first_name`, `m`.`pseudo`, "
             . "`m`.`facebook_profile_id`, `c`.`email`, `c`.`lastnl`, "
             . "`m`.`created_on`, `m`.`modified_on`, `m`.`visited_on`, "
             . "`m`.`text`, `m`.`site`, "
             . "`m`.`city`, `m`.`cp`, "
             . "`m`.`id_city`, `m`.`id_departement`, `m`.`id_region`, `m`.`id_country` "
             . "FROM `" . self::$_db_table_membre . "` `m` "
             . "JOIN `" . self::$_db_table_contact . "` `c` ON (`m`.`id_contact` = `c`.`id_contact`) "
             . "WHERE 1 ";

        if(count($tab_id) && ($tab_id[0] != 0)) {
            $sql .= "AND `m`.`id_contact` IN (" . implode(',', $tab_id) . ") ";
        }

        if(!is_null($pseudo)) {
            $sql .= "AND `m`.`pseudo` LIKE '" . $db->escape($pseudo) . "%' ";
        }

        if(!is_null($last_name)) {
            $sql .= "AND `m`.`last_name` LIKE '" . $db->escape($last_name) . "%' ";
        }

        if(!is_null($first_name)) {
            $sql .= "AND `m`.`first_name` LIKE '" . $db->escape($first_name) . "%' ";
        }

        if(!is_null($email)) {
            $sql .= "AND `c`.`email` LIKE '" . $db->escape($email) . "%' ";
        }

        $sql .= "ORDER BY ";
        if($sort == "random") {
            $sql .= "RAND(".time().") ";
        } else {
            if($sort == 'email' || $sort == 'lastnl') {
                $t = 'c';
            } else {
                $t = 'm';
            }
            $sql .= "`" . $t . "`.`" . $sort . "` " . $sens . " ";
        }
        $sql .= "LIMIT " . $debut . ", " . $limit;

        if($limit === 1) {
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
    function delete()
    {
        // on vérifie les clés étrangères

        if($this->hasGroupe()) {
            // on efface dans appartient_a
        }

        $db = DataBase::getInstance();

        $sql  = "DELETE FROM `" . self::$_db_table_membre . "` "
              . "WHERE `id_contact` = " . (int) $this->_id_contact;

        $db->query($sql);

        return $db->affectedRows();
    }

    /**
     * sauve en db tables contact et membre
     */
    function save()
    {
        $db = DataBase::getInstance();

        $fields = self::_getAllFields(false);

        if(!$this->getId()) // INSERT
        {
            /* table contact */

            if($id_contact = Contact::getIdByEmail($this->getEmail())) {

                $this->setId($id_contact);

            } else {

            $sql = "INSERT INTO `" . static::$_db_table_contact . "` (";
            foreach($fields['contact'] as $field => $type) {
                $sql .= "`" . $field . "`,";
            }
            $sql = substr($sql, 0, -1);
            $sql .= ") VALUES (";

            foreach($fields['contact'] as $field => $type) {
                $att = '_' . $field;
                switch($type)
                {
                    case 'num':
                        $sql .= $db->escape($this->$att) . ",";
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
                    default:
                        throw new Exception('invalid field type');
                        break;
                }
            }
            $sql = substr($sql, 0, -1);
            $sql .= ")";

            $db->query($sql);

            $this->setId((int) $db->insertId());

            }

            /* table membre */

            $sql = "INSERT INTO `" . static::$_db_table_membre . "` (";
            $sql .= "`id_contact`,";
            foreach($fields['membre'] as $field => $type) {
                $sql .= "`" . $field . "`,";
            }
            $sql = substr($sql, 0, -1);
            $sql .= ") VALUES (";
            $sql .= (int) $this->getId() . ",";

            foreach($fields['membre'] as $field => $type) {
                $att = '_' . $field;
                switch($type)
                {
                    case 'num':
                        $sql .= $db->escape($this->$att) . ",";
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
                    default:
                        throw new Exception('invalid field type');
                        break;
                }
            }
            $sql = substr($sql, 0, -1);
            $sql .= ")";

            $db->query($sql);

            return $this->getId();

        }
        else // UPDATE
        {
            if ((count($this->_modified_fields['contact']) === 0)
             && (count($this->_modified_fields['membre']) === 0)) {
                return true; // pas de changement
            }

            /* table contact */

            if (count($this->_modified_fields['contact']) > 0) {

                $fields_to_save = '';
                foreach ($this->_modified_fields['contact'] as $field => $value) {
                    if($value === true) {
                        $att = '_' . $field;
                        switch($fields['contact'][$field])
                        {
                            case 'num':
                                $fields_to_save .= " `" . $field . "` = ".$db->escape($this->$att).", ";
                                break;
                            case 'str':
                                $fields_to_save .= " `" . $field . "` = '".$db->escape($this->$att)."', ";
                                break;
                            case 'bool':
                                $fields_to_save .= " `" . $field . "` = ".(((bool) $this->$att) ? 'TRUE' : 'FALSE').", ";
                                break;
                            case 'pwd':
                                $fields_to_save .= " `" . $field . "` = PASSWORD('".$db->escape($this->$att)."'), ";
                                break;
                            case 'phpser':
                                $fields_to_save .= " `" . $field . "` = '" . $db->escape(serialize($this->$att)) . "', ";
                                break;
                            default:
                                throw new Exception('invalid field type');
                                break;
                        }
                    }
                }
                $fields_to_save = substr($fields_to_save, 0, -2);

                $sql  = "UPDATE `" . self::$_db_table_contact . "` "
                      . "SET " . $fields_to_save . " "
                      . "WHERE `id_contact` = " . (int) $this->_id_contact;

                $this->_modified_fields['contact'] = array();

                $db->query($sql);

            }

            /* table membre */

            if (count($this->_modified_fields['membre']) > 0) {

                $fields_to_save = '';
                foreach ($this->_modified_fields['membre'] as $field => $value) {
                    if($value === true) {
                        $att = '_' . $field;
                        switch($fields['membre'][$field])
                        {
                            case 'num':
                                $fields_to_save .= " `" . $field . "` = ".$db->escape($this->$att).", ";
                                break;
                            case 'str':
                                $fields_to_save .= " `" . $field . "` = '".$db->escape($this->$att)."', ";
                                break;
                            case 'bool':
                                $fields_to_save .= " `" . $field . "` = " . (((bool) $this->$att) ? 'TRUE' : 'FALSE') . ", ";
                                break;
                            case 'pwd':
                                $fields_to_save .= " `" . $field . "` = PASSWORD('" . $db->escape($this->$att) . "'), ";
                                break;
                            case 'phpser':
                                $fields_to_save .= " `" . $field . "` = '" . $db->escape(serialize($this->$att)) . "', ";
                                break;
                            default:
                                throw new Exception('invalid field type');
                                break;
                        }
                    }
                }
                $fields_to_save = substr($fields_to_save, 0, -2);

                $sql  = "UPDATE `" . self::$_db_table_membre . "` "
                      . "SET " . $fields_to_save . " "
                      . "WHERE `id_contact` = " . (int) $this->_id_contact;

                $this->_modified_fields['membre'] = array();

                $db->query($sql);

            }

            $this->_clearFromCache();

            return true;
        }
    }

    /**
     * charge toutes les infos d'un membre
     *
     * @return bool
     */
    protected function _loadFromDb()
    {
        $db = DataBase::getInstance();

        $sql  = "SELECT `c`.`email`, `c`.`lastnl`, `m`.`pseudo`, "
              . "`m`.`password`, `m`.`last_name`, `m`.`first_name`, "
              . "`m`.`address`, `m`.`cp`, `m`.`city`, "
              . "`m`.`country`, `m`.`tel`, `m`.`port`, "
              . "`m`.`id_city`, `m`.`id_departement`, `m`.`id_region`, `m`.`id_country`, "
              . "`m`.`site`, `m`.`text`, "
              . "`m`.`mailing`, `m`.`level`, `m`.`facebook_profile_id`, "
              . "`m`.`created_on`, `m`.`modified_on`, `m`.`visited_on` "
              . "FROM `" . self::$_db_table_contact . "` `c`, `" . self::$_db_table_membre . "` `m` "
              . "WHERE `m`.`id_contact` = `c`.`id_contact` "
              . "AND `m`.`id_contact` = " . (int) $this->_id_contact;

        if($res = $db->queryWithFetchFirstRow($sql)) {
            $this->_dbToObject($res);
            return true;
        }

        throw new Exception('Membre introuvable');
    }

    /**
     * vérifie l'appartenance d'une personne à un groupe
     *
     * @param int $id_groupe
     * @return bool
     */
    function belongsTo($id_groupe)
    {
        if(!$this->_id_contact) {
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
    function hasGroupe()
    {
        return (bool) count($this->getGroupes());
    }

    /**
     * retourne les photos associées à un membre
     *
     * @return string
     */
    static function getTaggedPhotos($id_contact)
    {
        $db = DataBase::getInstance();

        $sql  = "SELECT `id_contact`, `id_media` AS `id_photo` "
              . "FROM `" . self::$_db_table_est_marque_sur . "` "
              . "WHERE `id_contact` = " . (int) $id_contact." "
              . "AND `id_type_media` = " . (int) self::TYPE_MEDIA_PHOTO;

        $res = $db->queryWithFetch($sql);

        $str = array();
        foreach($res as $_res) {
            $str[] = $_res['id_photo'];
        }

        return implode(',', $str);
    }

    /**
     * le membre appartient-t-il au groupe "Membre Standard" ?
     *
     * @return bool
     */
    function isStandard()
    {
        return (bool) ($this->_level & self::TYPE_STANDARD);
    }

    /**
     * le membre appartient-t-il au groupe "Rédacteur" ?
     *
     * @return bool
     */
    function isRedacteur()
    {
        return (bool) ($this->_level & self::TYPE_REDACTEUR);
    }

    /**
     * le membre appartient-t-il au groupe "Membre Interne" ?
     *
     * @return bool
     */
    function isInterne()
    {
        return (bool) ($this->_level & self::TYPE_INTERNE);
    }

    /**
     * le membre appartient-t-il au groupe "Bonus" ?
     *
     * @return bool
     */
    function isBonus()
    {
        return (bool) ($this->_level & self::TYPE_BONUS);
    }

    /**
     * le membre appartient-t-il au groupe "Admin Système" ?
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
     * @param int $id_contact
     * @return string
     */
    static function getPseudoById($id_contact)
    {
        $db = DataBase::getInstance();

        $sql  = "SELECT `pseudo` "
              . "FROM `" . self::$_table . "` "
              . "WHERE `" . self::$_pk . "` = " . (int) $id_contact;

        return $db->queryWithFetchFirstField($sql);
    }

    /**
     * Retourne l'id du compte, méthode statique
     *
     * @param string $pseudo
     * @return id
     */
    static function getIdByPseudo($pseudo)
    {
        $db = DataBase::getInstance();

        $sql  = "SELECT `" . self::$_pk . "` "
              . "FROM `" . self::$_table . "` "
              . "WHERE `pseudo` = '" . $db->escape($pseudo) . "'";

        return $db->queryWithFetchFirstField($sql);
    }

    /**
     * vérifie le password d'un membre
     *
     * @param string $password
     * @return int id_contact ou false
     */
    function checkPassword($password)
    {
        return self::checkPseudoPassword($this->_pseudo, $password);
    }

    /**
     * retourne si le pseudo est disponible
     *
     * @param string $pseudo
     * @return bool
     */
    static function isPseudoAvailable($pseudo)
    {
        $db = DataBase::getInstance();

        $sql  = "SELECT `pseudo` "
              . "FROM `" . self::$_table . "` "
              . "WHERE `pseudo` = '" . $db->escape($pseudo) . "' ";

        $pseudo = $db->queryWithFetchFirstField($sql);

        return !(bool) $pseudo;
    }

    /**
     * retourne si un membre facebook a un compte adhoc
     *
     * @param int $id Facebook Profile Id
     * @return int $id_contact
     */
    static function getIdContactByFacebookProfileId($id)
    {
        $db = DataBase::getInstance();

        if(!is_numeric($id)) {
            return false;
        }

        $sql  = "SELECT `" . self::$_pk . "` "
              . "FROM `" . self::$_table . "` "
              . "WHERE `facebook_profile_id` = " . $id;

        return (int) $db->queryWithFetchFirstField($sql);
    }

    /**
     * @return array
     */
    static function getAdHocAccountsLinkedWithFacebookAccounts()
    {
        $db = DataBase::getInstance();

        $sql  = "SELECT `id_contact`, `pseudo`, `facebook_profile_id` "
              . "FROM `" . self::$_table . "` "
              . "WHERE `facebook_profile_id` IS NOT NULL";

        $rows = $db->queryWithFetch($sql);

        $out = array();
        foreach($rows as $row) {
            $out[$row['facebook_profile_id']] = array(
                'pseudo' => $row['pseudo'],
                'id_contact' => $row['id_contact'],
            );
        }
        return $out;
    }

    /**
     * Generation d un mot de passe de n caractères
     * (les caractères iI lL oO 0 sont interdits)
     * nouveau : que des minuscules et des chiffres
     */
    static function generatePassword($length = 8)
    {
        srand((double) microtime() * date('YmdGis'));
        $lettres = 'abcdefghjkmnpqrstuvwxyz23456789';
        $str = '';
        $max = mb_strlen($lettres) - 1;
        for($cpt = 0 ; $cpt < $length ; $cpt++) {
            $str .= $lettres[rand(0, $max)];
        }
        return $str;
    }

    /**
     * Vérifie le couple pseudo/password
     *
     * @param string $pseudo
     * @param string $password
     * @return int id_contact ou false
     */
    static function checkPseudoPassword($pseudo, $password)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_contact` "
             . "FROM `" . self::$_table . "` "
             . "WHERE `pseudo` = '" . $db->escape($pseudo) . "' "
             . "AND `password` = PASSWORD('" . $db->escape($password) . "')";

        return (int) $db->queryWithFetchFirstField($sql);
    }

    /**
     * retourne les types de musiciens
     *
     * @return array
     */
    static function getTypesMusicien()
    {
        return self::$_types_musicien;
    }

    /**
     * retourne les types de membres
     *
     * @return array
     */
    static function getTypesMembre()
    {
        return self::$_types_membre;
    }

    /**
     * retourne le libellé d'une clé de la liste
     *
     * @param int
     * @return string
     */
    static function getTypeMusicienName($cle)
    {
        if(array_key_exists($cle, self::$_types_musicien)) {
            return self::$_types_musicien[$cle];
        }
        return false;
    }

    /**
     * retourne le libellé d'une clé de la liste
     *
     * @param int
     * @return string
     */
    static function getTypeMembreName($cle)
    {
        if(array_key_exists($cle, self::$_types_membre)) {
            return self::$_types_membre[$cle];
        }
        return false;
    }

    /**
     * retourne le nombre total de membres
     *
     * @return int
     */
    static function getMembresCount()
    {
        if(isset($_SESSION['global_counters']['nb_membres'])) {
            return $_SESSION['global_counters']['nb_membres'];
        }

        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(*) "
             . "FROM `" . self::$_db_table_membre . "`";

        $nb_membres = $db->queryWithFetchFirstField($sql);

        $_SESSION['global_counters']['nb_membres'] = $nb_membres;

        return $_SESSION['global_counters']['nb_membres'];
    }

    /**
     * Extraction de l'id_contact a partir de l'email
     * et vérification implicite que celui ci est bien membre
     *
     * @param string $email
     * @return int
     */
    static function getIdByEmail($email = null)
    {
        if($email == null) {
            return 0;
        }

        if(!Email::validate($email)) {
            throw new Exception('email syntaxiquement incorrect');
        }

        $db = DataBase::getInstance();

        $sql = "SELECT `m`.`id_contact` "
              . "FROM `" . self::$_db_table_contact . "` `c`, `" . self::$_db_table_membre . "` `m` "
              . "WHERE `c`.`id_contact` = `m`.`id_contact` "
              . "AND `c`.`email` = '" . $db->escape($email) . "'";

        return (int) $db->queryWithFetchFirstField($sql);
    }

    static function getOneYearUnactivesMembers()
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
