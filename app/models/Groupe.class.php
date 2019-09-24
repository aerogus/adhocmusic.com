<?php declare(strict_types=1);

/**
 * Classe Groupe
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Groupe extends ObjectModel
{
    /**
     * États des groupes
     */
    const ETAT_ACTIF   = 1;
    const ETAT_NONEWS  = 2;
    const ETAT_INACTIF = 3;

    /**
     * Tableau des états groupe
     *
     * @var array
     */
    protected static $_etats = [
        self::ETAT_ACTIF   => "Actif",
        self::ETAT_NONEWS  => "Pas de nouvelles",
        self::ETAT_INACTIF => "Inactif / Séparé",
    ];

    /**
     * @var object
     */
    protected static $_instance = null;

    /**
     * @var int
     */
    protected static $_pk = 'id_groupe';

    /**
     * @var string
     */
    protected static $_table = 'adhoc_groupe';

    /**
     * @var int
     */
    protected $_id_groupe = 0;

    /**
     * @var string
     */
    protected $_alias = '';

    /**
     * @var string
     */
    protected $_name = '';

    /**
     * @var string
     */
    protected $_style = '';

    /**
     * @var string
     */
    protected $_influences = '';

    /**
     * @var string
     */
    protected $_lineup = '';

    /**
     * @var string
     */
    protected $_mini_text = '';

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
    protected $_myspace = '';

    /**
     * @var string (int 64 en vérité)
     */
    protected $_facebook_page_id = '';

    /**
     * @var string
     */
    protected $_twitter_id = '';

    /**
     * @var str
     */
    protected $_id_departement = '';

    /**
     * @var bool
     */
    protected $_online = false;

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
    protected $_datdeb = null;

    /**
     * @var string
     */
    protected $_datfin = null;

    /**
     * @var string
     */
    protected $_comment = '';

    /**
     * @var int
     */
    protected $_etat = 0;

    /**
     * @var array
     */
    protected static $_all_fields = [
        'alias'            => 'str',
        'name'             => 'str',
        'style'            => 'str',
        'influences'       => 'str',
        'lineup'           => 'str',
        'mini_text'        => 'str',
        'text'             => 'str',
        'site'             => 'str',
        'myspace'          => 'str',
        'facebook_page_id' => 'str',
        'twitter_id'       => 'str',
        'id_departement'   => 'str',
        'online'           => 'bool',
        'created_on'       => 'date',
        'modified_on'      => 'date',
        'datdeb'           => 'date',
        'datfin'           => 'date',
        'comment'          => 'str',
        'etat'             => 'num',
    ];

    /**
     * @var array
     */
    protected $_modified_fields = [];

    /**
     * @var array
     */
    protected $_styles = [];

    /**
     * Membres liés au groupe
     *
     * @var array
     */
    protected $_members = null;

    /**
     * @var array
     */
    protected $_audios = [];

    /**
     * @var array
     */
    protected $_photos = [];

    /**
     * @var array
     */
    protected $_videos = [];

    /* début getters */

    /**
     * Retourne l'url de base des medias relatifs au groupe
     *
     * @return string
     */
    static function getBaseUrl()
    {
        return MEDIA_URL . '/groupe';
    }

    /**
     * Retourne le chemin absolu des medias relatifs au groupe
     *
     * @return string
     */
    static function getBasePath()
    {
        return MEDIA_PATH . '/groupe';
    }

    /**
     * Retourne l'alias
     *
     * @return string
     */
    function getAlias(): string
    {
        return $this->_alias;
    }

    /**
     * Retourne le nom du groupe
     *
     * @return string
     */
    function getName(): string
    {
        return $this->_name;
    }

    /**
     * Retourne le style du groupe (champ libre)
     *
     * @return string
     */
    function getStyle(): string
    {
        return $this->_style;
    }

    /**
     * Retourne les influences du groupe
     *
     * @return string
     */
    function getInfluences(): string
    {
        return $this->_influences;
    }

    /**
     * Retourne le lineup du groupe
     *
     * @return string
     */
    function getLineup(): string
    {
        return $this->_lineup;
    }

    /**
     * Retourne le mini texte de présentation
     *
     * @return string
     */
    function getMiniText(): string
    {
        return $this->_mini_text;
    }

    /**
     * Retourne le texte de présentation
     *
     * @return string
     */
    function getText(): string
    {
        return $this->_text;
    }

    /**
     * Retourne l'identificant de la page fan Facebook
     *
     * @return string (int 64bits réellement)
     */
    function getFacebookPageId(): ?string
    {
        return $this->_facebook_page_id;
    }

    /**
     * Retourne l'url de la page "fans" Facebook
     *
     * @return string
     */
    function getFacebookPageUrl()
    {
        if ($this->_facebook_page_id) {
            return 'https://www.facebook.com/pages/' . $this->_alias . '/' . $this->_facebook_page_id;
        }
        return false;
    }

    /**
     * Retourne l'identifiant twitter
     *
     * @return string
     */
    function getTwitterId(): string
    {
        return $this->_twitter_id;
    }

    /**
     * Retourne l'url du fil twitter
     *
     * @return string
     */
    function getTwitterUrl(): string
    {
        return 'https://www.twitter.com/' . $this->_twitter_id;
    }

    /**
     * Retourne l'url du site officiel
     *
     * @return string
     *
     * @todo check le http:// initial
     */
    function getSite(): string
    {
        return $this->_site;
    }

    /**
     * Retourne le département
     *
     * @return string
     */
    function getIdDepartement()
    {
        return (string) $this->_id_departement;
    }

    /**
     * Retourne si un groupe doit être affiché
     *
     * @return bool
     */
    function getOnline(): bool
    {
        return (bool) $this->_online;
    }

    /**
     * Retourne la date d'inscription format YYYY-MM-DD HH:II:SS
     *
     * @return string|false
     */
    function getCreatedOn(): ?string
    {
        if (!is_null($this->_created_on) && Date::isDateTimeOk($this->_created_on)) {
            return $this->_created_on;
        }
        return null;
    }

    /**
     * Retourne la date d'inscription sous forme de timestamp
     *
     * @return int
     */
    function getCreatedOnTs(): ?string
    {
        if (!is_null($this->created_on) && Date::isDateTimeOk($this->_created_on)) {
            return (int) strtotime($this->_created_on);
        }
        return null;
     }

    /**
     * Retourne la date de modification de la fiche
     *
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
     * Retourne la date de modification de la fiche sous forme de timestamp
     *
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
     * Retourne la date de début d'activité
     *
     * @return string
     */
    function getDatdeb()
    {
        if (Date::isDateOk($this->_datdeb)) {
            return (string) $this->_datdeb;
        }
        return false;
    }

    /**
     * Retourne la date de fin d'activité
     *
     * @return string
     */
    function getDatfin()
    {
        if (Date::isDateOk($this->_datfin)) {
            return (string) $this->_datfin;
        }
        return false;
    }

    /**
     * Retourne le "mot AD'HOC"
     *
     * @return string
     */
    function getComment()
    {
        return (string) $this->_comment;
    }

    /**
     * Retourne l'état du groupe
     *
     * @return int
     */
    function getEtat()
    {
        return (int) $this->_etat;
    }

    /**
     * Retourne le nom du groupe à partir de son id
     *
     * @param string $id_groupe
     *
     * @return string ou false
     */
    static function getNameById(int $id_groupe)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `name` "
             . "FROM `" . self::$_table . "` "
             . "WHERE `" . self::$_pk . "` = " . (int) $id_groupe;

        return $db->queryWithFetchFirstField($sql);
    }

    /**
     * Retourne l'url de la photo principale
     *
     * @return string
     */
    function getPhoto()
    {
        if (file_exists(self::getBasePath() . '/p' . $this->getId() . '.jpg')) {
            return self::getBaseUrl() . '/p' . $this->getId() . '.jpg?ts=' . $this->getModifiedOnTs();
        }
        return false;
    }

    /**
     * Retourne l'url de la mini photo
     * (64x64)
     *
     * @return string
     */
    function getMiniPhoto()
    {
        if (file_exists(self::getBasePath() . '/m' . $this->getId() . '.jpg')) {
            return self::getBaseUrl() . '/m' . $this->getId() . '.jpg?ts=' . $this->getModifiedOnTs();
        } else {
            return HOME_URL . '/img/note_adhoc_64.png';
        }
    }

    /**
     * Retourne l'url du logo
     * priorité png > gif > jpg
     *
     * @return string|null
     */
    function getLogo(): ?string
    {
        if (file_exists(self::getBasePath() . '/l' . $this->getId() . '.png')) {
            return self::getBaseUrl() . '/l' . $this->getId() . '.png?ts=' . $this->getModifiedOnTs();
        } else if (file_exists(self::getBasePath() . '/l' . $this->getId() . '.gif')) {
            return self::getBaseUrl() . '/l' . $this->getId() . '.gif?ts=' . $this->getModifiedOnTs();
        } else if (file_exists(self::getBasePath() . '/l' . $this->getId() . '.jpg')) {
            return self::getBaseUrl() . '/l' . $this->getId() . '.jpg?ts=' . $this->getModifiedOnTs();
        } else {
            return null;
        }
    }

    /**
     * @return string
     */
    function getUrl()
    {
        return HOME_URL . '/' . $this->_alias;
    }

    /**
     * Retourne l'url d'une fiche groupe à partir de son alias ou son id
     *
     * @param string $alias ou int $id_groupe
     *
     * @return string
     */
    static function getUrlFiche($ref, $type = 2)
    {
        if (is_numeric($ref)) {
            $alias = Groupe::getAliasById($ref);
        } else {
            $alias = $ref;
        }

        return HOME_URL . '/' . $alias;
    }

    /**
     *
     */
    function getFacebookShareUrl()
    {
        return 'https://www.facebook.com/sharer.php?u=' . urlencode($this->getUrl());
    }

    /**
     * Retourne l'image de l'avatar d'un groupe
     *
     * @param int id_groupe
     *
     * @return string
     */
    static function getAvatarById($id_groupe)
    {
        $avatar = HOME_URL . '/img/note_adhoc_64.png';
        if (file_exists(self::getBasePath() . '/m' . $id_groupe . '.jpg')) {
            $avatar = self::getBaseUrl() . '/m' . $id_groupe . '.jpg';
        }
        return $avatar;
    }

    /**
     * Retourne l'alias d'un groupe à partir de son id
     *
     * @param int $id_groupe
     *
     * @return string
     */
    static function getAliasById(int $id_groupe)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `alias` "
             . "FROM `" . self::$_table . "` "
             . "WHERE `" . self::$_pk . "` = " . (int) $id_groupe;

        if ($alias = $db->queryWithFetchFirstField($sql)) {
            return $alias;
        }
        return false;
    }

    /* fin getters */

    /* début setters */

    /**
     * @param string $val alias
     *
     * @return mixed
     */
    function setAlias(string $val)
    {
        if ($this->_alias !== $val) {
            $this->_alias = $val;
            $this->_modified_fields['alias'] = true;
        }
        return $this;
    }

    /**
     * @param string $val nom
     */
    function setName(string $val)
    {
        if ($this->_name !== $val) {
            $this->_name = $val;
            $this->_modified_fields['name'] = true;
        }
    }

    /**
     * @param string $val style
     */
    function setStyle(string $val)
    {
        if ($this->_style !== $val) {
            $this->_style = $val;
            $this->_modified_fields['style'] = true;
        }
    }

    /**
     * @param string $val influences
     */
    function setInfluences(string $val)
    {
        if ($this->_influences !== $val) {
            $this->_influences = $val;
            $this->_modified_fields['influences'] = true;
        }
    }

    /**
     * @param string $val lineup
     */
    function setLineup(string $val)
    {
        if ($this->_lineup !== $val) {
            $this->_lineup = $val;
            $this->_modified_fields['lineup'] = true;
        }
    }

    /**
     * @param string $val val
     */
    function setMiniText(string $val)
    {
        if ($this->_mini_text !== $val) {
            $this->_mini_text = $val;
            $this->_modified_fields['mini_text'] = true;
        }
    }
    /**
     * @param string $val val
     */
    function setText(string $val)
    {
        if ($this->_text !== $val) {
            $this->_text = $val;
            $this->_modified_fields['text'] = true;
        }
    }

    /**
     * @param string $val val
     */
    function setSite(string $val)
    {
        if ($this->_site !== $val) {
            $this->_site = $val;
            $this->_modified_fields['site'] = true;
        }
    }

    /**
     * @param string
     */
    function setMyspaceId(string $val)
    {
        $val = trim($val);
        $val = str_replace('http://', '', $val);
        $val = str_replace('www.myspace.com/', '', $val);

        if ($this->_myspace !== $val) {
            $this->_myspace = $val;
            $this->_modified_fields['myspace'] = true;
        }
    }

    /**
     * @param string $val id de page facebook (int 64bits en fait)
     */
    function setFacebookPageId(string $val)
    {
        if ($this->_facebook_page_id !== $val) {
            $this->_facebook_page_id = $val;
            $this->_modified_fields['facebook_page_id'] = true;
        }
    }

    /**
     * @param string $val val
     */
    function setTwitterId(string $val)
    {
        if ($this->_twitter_id !== $val) {
            $this->_twitter_id = $val;
            $this->_modified_fields['twitter_id'] = true;
        }
    }

    /**
     * @param string $val val
     */
    function setIdDepartement(string $val)
    {
        if ($this->_id_departement !== $val) {
            $this->_id_departement = $val;
            $this->_modified_fields['id_departement'] = true;
        }
    }

    /**
     * @param bool
     */
    function setOnline(bool $val)
    {
        if ($this->_online !== $val) {
            $this->_online = $val;
            $this->_modified_fields['online'] = true;
        }
    }

    /**
     * @param string
     */
    function setCreatedOn(string $val)
    {
        if ($this->_created_on !== $val) {
            $this->_created_on = $val;
            $this->_modified_fields['created_on'] = true;
        }
    }

    /**
     *
     */
    function setCreatedNow()
    {
        $now = date('Y-m-d H:i:s');
        if ($this->_created_on !== $now) {
            $this->_created_on = $now;
            $this->_modified_fields['created_on'] = true;
        }
    }

    /**
     * @param string $val
     */
    function setModifiedOn(string $val)
    {
        if ($this->_modified_on !== $val) {
            $this->_modified_on = $val;
            $this->_modified_fields['modified_on'] = true;
        }
    }

    /**
     *
     */
    function setModifiedNow()
    {
        $now = date('Y-m-d H:i:s');
        if ($this->_modified_on !== $now) {
            $this->_modified_on = $now;
            $this->_modified_fields['modified_on'] = true;
        }
    }

    /**
     * @param string
     */
    function setDatdeb(string $val)
    {
        if ($this->_datdeb !== $val) {
            $this->_datdeb = $val;
            $this->_modified_fields['datdeb'] = true;
        }
    }

    /**
     * @param string
     */
    function setDatfin(string $val)
    {
        if ($this->_datfin !== $val) {
            $this->_datfin = $val;
            $this->_modified_fields['datfin'] = true;
        }
    }

    /**
     * @param string
     */
    function setComment(string $val)
    {
        if ($this->_comment !== $val) {
            $this->_comment = $val;
            $this->_modified_fields['comment'] = true;
        }
    }

    /**
     * @param int
     */
    function setEtat(int $val)
    {
        if ($this->_etat !== $val) {
            $this->_etat = $val;
            $this->_modified_fields['etat'] = true;
        }
    }

    /* fin setters */

    /**
     * Retourne le nombre de groupes actifs
     *
     * @return int
     */
    static function getGroupesCount($etat = null, $force = false)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(*) "
             . "FROM `" . Groupe::getDbTable() . "` ";
        if (!is_null($etat)) {
            $sql .= "WHERE `etat` = " . (int) $etat;
        }

        return $db->queryWithFetchFirstField($sql);
    }

    /**
     * @return int
     */
    static function getMyGroupesCount()
    {
        if (empty($_SESSION['membre'])) {
            throw new Exception('non identifié');
        }

        if (isset($_SESSION['my_counters']['nb_groupes'])) {
            return $_SESSION['my_counters']['nb_groupes'];
        }

        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(*) "
             . "FROM `" . self::$_db_table_appartient_a . "` "
             . "WHERE `id_contact` = " . (int) $_SESSION['membre']->getId();

        $nb_groupes = $db->queryWithFetchFirstField($sql);

        $_SESSION['my_counters']['nb_groupes'] = $nb_groupes;

        return $_SESSION['my_counters']['nb_groupes'];
    }

    /**
     * Efface un groupe de la base + la photo, mini photo, logo
     * + ses liaisons avec membres
     * + ses liaisons avec styles
     * + ses liaisons avec events
     * + ses liaisons avec photos,videos,audios
     * @return bool
     */
    function delete()
    {
        $this->unlinkMembers();
        $this->unlinkStyles();
        $this->unlinkEvents();
        $this->unlinkPhotos();
        $this->unlinkVideos();
        $this->unlinkAudios();

        parent::delete();

        $p = self::getBasePath() . '/p' . $this->getId() . '.jpg';
        if (file_exists($p)) {
            unlink($p);
        }

        $m = self::getBasePath() . '/m' . $this->getId() . '.jpg';
        if (file_exists($m)) {
            unlink($m);
        }

        $l = self::getBasePath() . '/l' . $this->getId() . '.jpg';
        if (file_exists($l)) {
            unlink($l);
        }

        return true;
    }

    /**
     *
     */
    protected function _loadFromDb()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `name`, `mini_text`, `text`, `style`, `lineup`, `etat`, "
             . "`site`, `online`, `influences`, `created_on`, `modified_on`, `alias`, "
             . "`myspace`, `facebook_page_id`, `twitter_id`, `comment` "
             . "FROM `" . self::$_table . "` "
             . "WHERE `" . self::$_pk . "` = " . (int) $this->getId();

        if (($res = $db->queryWithFetchFirstRow($sql))) {
            $this->_dbToObject($res);
            return true;
        }

        throw new Exception('id_groupe introuvable');
    }

    /**
     * lie un membre à un groupe
     *
     * @param id_contact
     * @param id_type_musicien
     * @return bool
     */
    function linkMember($id_contact, $id_type_musicien = 0)
    {
        // le groupe existe-t-il bien ?

        // l'id_contact est il valide ?
        if (($mbr = Membre::getInstance($id_contact)) === false) {
            throw new Exception('id_contact introuvable');
        }

        // la relation est elle deja présente ?

        // tout est ok, on insère dans appartient_a
        $db = DataBase::getInstance();

        $sql = "INSERT INTO `" . self::$_db_table_appartient_a . "` "
             . "(`id_groupe`, `id_contact`, `id_type_musicien`) "
             . "VALUES(" . (int) $this->getId() . ", " . (int) $id_contact . ", " . (int) $id_type_musicien . ")";

        $db->query($sql);

        return $db->affectedRows();
    }

    function updateMember($id_contact, $id_type_musicien = 0)
    {
        $db = DataBase::getInstance();

        $sql = "UPDATE `" . self::$_db_table_appartient_a . "` "
             . "SET `id_type_musicien` = " . (int) $id_type_musicien . " "
             . "WHERE `id_groupe` = " . (int) $this->getId() . " "
             . "AND `id_contact` = " . (int) $id_contact;

        $db->query($sql);

        return $db->affectedRows();
    }

    /**
     * délie un membre d'un groupe
     *
     * @param int $id_contact
     * @return int
     */
    function unlinkMember($id_contact)
    {
        // le groupe existe-t-il bien ?

        // l'id_contact est il valide ?

        // la relation est elle bien présente ?

        // tout est ok, on delete dans groupe_membre

        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . self::$_db_table_appartient_a . "` "
             . "WHERE `id_groupe` = " . (int) $this->getId() . " "
             . "AND `id_contact` = " . (int) $id_contact;

        $db->query($sql);

        return $db->affectedRows();
    }

    /**
     * purge les membres d'un groupe
     * (= efface les relations des membres avec ce groupe)
     *
     * @return bool
     */
    function unlinkMembers()
    {
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . self::$_db_table_appartient_a . "` "
             . "WHERE `id_groupe` = " . (int) $this->getId();

        $db->query($sql);

        return $db->affectedRows();
    }

    /**
     * un membre appartient-il au groupe ?
     *
     * @param int $id_contact
     * @return bool
     */
    function isMember($id_contact)
    {
        if (is_null($this->_members)) {
            $this->_members = self::getMembersById($this->getId());
        }

        foreach ($this->_members as $member) {
            if ($member['id'] === $id_contact) {
                return true;
            }
        }
        return false;
    }

    /**
     * retourne un tableau des membres liés à ce groupe
     *
     * @return array
     */
    function getMembers()
    {
        if (is_null($this->_members)) {
            $this->_members = self::getMembersById($this->getId());
        }

        return $this->_members;
    }

    /**
     * retourne un tableau des membres liés à ce groupe
     *
     * @param int id_groupe
     * @return array
     */
    static function getMembersById($id_groupe)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `m`.`id_contact` AS `id`, `c`.`email`, `m`.`last_name`, `m`.`first_name`, `m`.`pseudo`, "
             . "`m`.`facebook_profile_id`, `c`.`email`, `m`.`created_on`, "
             . "`m`.`modified_on`, `m`.`visited_on`, `m`.`text`, `m`.`site`, "
             . "`a`.`id_groupe`, `a`.`id_type_musicien` "
             . "FROM `" . Membre::getDbTable() . "` `m`, `" . Contact::getDbTable() . "` `c`, `" . self::$_db_table_appartient_a . "` `a` "
             . "WHERE `m`.`id_contact` = `a`.`id_contact` "
             . "AND `m`.`id_contact` = `c`.`id_contact` "
             . "AND `a`.`id_groupe` = " . (int) $id_groupe;

        $res = $db->queryWithFetch($sql);
        $cpt = 0;
        foreach ($res as $_res) {
            $res[$cpt]['id'] = intval($_res['id']);
            $res[$cpt]['nom_type_musicien'] = Membre::getTypeMusicienName($_res['id_type_musicien']);
            $res[$cpt]['url'] = Membre::getUrlById($_res['id']);
            $cpt++;
        }
        return $res;
    }

    /**
     * le groupe est-il lié à des membres adhoc ?
     *
     * @return bool
     */
    function hasMembers()
    {
        return (bool) $this->getMembers();
    }

    /**
     * retourne un tableau de groupes en fonction de critères donnés
     *
     * @param array
     * @return array
     */
    static function getGroupes($params = [])
    {
        $debut = 0;
        if (isset($params['debut'])) {
            $debut = (int) $params['debut'];
        }

        $limit = null;
        if (isset($params['limit'])) {
            $limit = (int) $params['limit'];
        }

        $online = null;
        if (isset($params['online'])) {
            $online = (bool) $params['online'] ? 'TRUE' : 'FALSE';
        }

        $sens = 'ASC';
        if (isset($params['sens']) && $params['sens'] == 'DESC') {
            $sens = 'DESC';
        }

        $sort = 'id_groupe';
        if (isset($params['sort'])
            && ($params['sort'] === 'name'
            || $params['sort'] === 'random'
            || $params['sort'] === 'created_on'
            || $params['sort'] === 'modified_on')
        ) {
            $sort = $params['sort'];
        }

        $tab_style   = [];
        $tab_id      = [];
        $tab_contact = [];

        if (array_key_exists('style', $params)) {
            $tab_style = explode(",", $params['style']);
        }
        if (array_key_exists('id', $params)) {
            $tab_id = explode(",", $params['id']);
        }
        if (array_key_exists('contact', $params)) {
            $tab_contact = explode(",", $params['contact']);
        }

        $db = DataBase::getInstance();

        $sql = "SELECT `g`.`id_groupe` AS `id`, `g`.`name`, `g`.`mini_text`, `g`.`text`, `g`.`style`, `g`.`lineup`, "
             . "`g`.`etat`, `g`.`site`, `g`.`influences`, `g`.`created_on`, `g`.`modified_on`, "
             . "`g`.`alias`, `g`.`myspace`, `g`.`comment` "
             . "FROM `" . self::$_table . "` `g` "
             . "WHERE 1 ";

        if (!is_null($online)) {
            $sql .= "AND `g`.`online` = " . $online . " ";
        }

        if (count($tab_id) && ($tab_id[0] !== 0)) {
            $sql .= "AND `g`.`id_groupe` IN (" . implode(',', $tab_id) . ") ";
        }

        $sql .= "ORDER BY ";
        if ($sort == "random") {
            $sql .= "RAND(" . time() . ") ";
        } else {
            $sql .= "`g`.`" . $sort . "` " . $sens . " ";
        }

        if (!is_null($limit)) {
            $sql .= "LIMIT " . $debut . ", " . $limit;
        }

        $res = $db->queryWithFetch($sql);

        if ($limit === 1) {
            $res = array_pop($res);
        }

        return $res;
    }

    /**
     * Retourne le listing de ses propres groupes
     * dont on est administrateur
     *
     * @return array
     */
    static function getMyGroupes(): array
    {
        if (empty($_SESSION['membre'])) {
            throw new Exception('non identifié');
        }

        $db = DataBase::getInstance();

        $sql = "SELECT `g`.`id_groupe` AS `id`, `g`.`alias`, "
             . "`g`.`created_on`, UNIX_TIMESTAMP(`g`.`created_on`) AS `created_on_ts`, "
             . "`g`.`modified_on`, UNIX_TIMESTAMP(`g`.`modified_on`) AS `modified_on_ts`, "
             . "`g`.`name`, `a`.`id_type_musicien` "
             . "FROM `" . Groupe::getDbTable() . "` `g`, `" . self::$_db_table_appartient_a . "` `a` "
             . "WHERE `g`.`id_groupe` = `a`.`id_groupe` "
             . "AND `a`.`id_contact` = " . (int) $_SESSION['membre']->getId();

        $res = $db->queryWithFetch($sql);

        if ($res) {
            $tab = [];
            foreach ($res as $grp) {
                $tab[$grp['id']] = $grp;
                $mini_photo = '/img/note_adhoc_64.png';
                if (file_exists(self::getBasePath() . '/m' . $grp['id'] . '.jpg')) {
                    $mini_photo = self::getBaseUrl() . '/m' . $grp['id'] . '.jpg?ts=' . $grp['modified_on_ts'];
                }
                $tab[$grp['id']]['mini_photo'] = $mini_photo;
                $tab[$grp['id']]['nom_type_musicien'] = Membre::getTypeMusicienName($grp['id_type_musicien']);
            }
            return $tab;
        }
        return [];
    }

    /**
     * Retourne le listing de tous les groupes affichables
     *
     * Tri par ordre alphabétique
     *
     * @return array
     */
    static function getGroupesByName()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_groupe` AS `id`, `name`, UPPER(SUBSTRING(`name`, 1, 1)) AS `lettre`, "
             . "`mini_text`, `style`, `alias`, `modified_on`, UNIX_TIMESTAMP(`modified_on`) AS `modified_on_ts`, `etat`, "
             . "CONCAT('http://www.adhocmusic.com/', `alias`) AS `url` "
             . "FROM `" . self::$_table . "` "
             . "WHERE `online` "
             . "ORDER BY `etat` ASC, `name` ASC";

        $res  = $db->queryWithFetch($sql);

        $tab = [];
        $cpt = 0;
        foreach ($res as $grp) {
            $tab[$grp['lettre']][$cpt] = $grp;
            $tab[$grp['lettre']][$cpt]['mini_photo'] = '/img/note_adhoc_64.png';
            $tab[$grp['lettre']][$cpt]['class'] = 'grpinactif';
            if (file_exists(self::getBasePath() . '/m' . $grp['id'] . '.png')) {
                $tab[$grp['lettre']][$cpt]['mini_photo'] = self::getBaseUrl() . '/m' . $grp['id'] . '.png?ts=' . $grp['modified_on_ts'];
            } elseif (file_exists(self::getBasePath() . '/m' . $grp['id'] . '.jpg')) {
                $tab[$grp['lettre']][$cpt]['mini_photo'] = self::getBaseUrl() . '/m' . $grp['id'] . '.jpg?ts=' . $grp['modified_on_ts'];
            } elseif (file_exists(self::getBasePath() . '/m' . $grp['id'] . '.gif')) {
                $tab[$grp['lettre']][$cpt]['mini_photo'] = self::getBaseUrl() . '/m' . $grp['id'] . '.gif?ts=' . $grp['modified_on_ts'];
            }

            if ($grp['etat'] === self::ETAT_ACTIF) {
                $tab[$grp['lettre']][$cpt]['class'] = 'grpactif';
            }
            $cpt++;
        }
        return $tab;
    }

    /**
     * Retourne l'id d'un groupe à partir de son alias
     *
     * @param string $alias
     *
     * @return int ou false
     */
    static function getIdByAlias($alias)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `" . self::$_pk . "` "
             . "FROM `" . self::$_table . "` "
             . "WHERE `alias` = '" . $db->escape($alias) . "'";

        if ($id_groupe = $db->queryWithFetchFirstField($sql)) {
            return (int) $id_groupe;
        }
        return false;
    }

    /**
     * Retourne l'id d'un groupe à partir d'id de sa page facebook
     *
     * @param int $fbpid
     *
     * @return int
     */
    static function getIdByFacebookPageId($fbpid)
    {
        $db = DataBase::getInstance();

        // /!\ 64 bits
        if (!is_numeric($fbpid)) {
            return false;
        }

        $sql = "SELECT `id_groupe` "
             . "FROM `" . self::$_table . "` "
             . "WHERE `facebook_page_id` = " . $fbpid;

        if ($id_groupe = $db->queryWithFetchFirstField($sql)) {
            return (int) $id_groupe;
        }
        return false;
    }

    /**
     * Ajoute un style au groupe
     *
     * @param int $id_style
     * @param int $ordre
     */
    function linkStyle($id_style, $ordre = 1)
    {
        // le groupe existe-t-il bien ?

        // le style existe-il bien ?
        if (!Style::isStyleOk($id_style)) {
            throw new Exception('id_style introuvable');
        }

        // le groupe n'a-t-il pas déjà ce style ?

        // c'est ok on ajoute le style
        $db = DataBase::getInstance();

        $sql = "INSERT INTO `" . self::$_db_table_groupe_style . "` "
             . "(`id_groupe`, `id_style`, `ordre`) "
             . "VALUES(" . (int) $this->getId() . ", " . (int) $id_style . ", " . (int) $ordre . ")";

        $db->query($sql);

        return $db->affectedRows();
    }

    /**
     * Retire un style du groupe
     *
     * @param int $id_style
     * @return bool
     */
    function unlinkStyle($id_style)
    {
        // les paramètres sont-ils corrects ?

        // le groupe existe-t-il bien ?

        // le style existe-il bien ?
        if (!Style::isStyleOk($id_style)) {
            throw new Exception('id_style introuvable');
        }

        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . self::$_db_table_groupe_style  ."` "
             . "WHERE `id_groupe` = " . (int) $this->getId() . " "
             . "AND `id_style` = " . (int) $id_style;

        $db->query($sql);

        return $db->affectedRows();
    }

    /**
     * purge tous les styles d'un groupe
     *
     * @return bool
     */
    function unlinkStyles()
    {
        // les paramètres sont-ils corrects ?

        // le groupe existe-t-il bien ?

        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . self::$_db_table_groupe_style . "` "
             . "WHERE `id_groupe` = " . (int) $this->getId();

        $db->query($sql);

        return $db->affectedRows();
    }

    /**
     * retourne les styles du groupe
     *
     * @return array
     */
    function getStyles()
    {
        return $this->_styles;
    }

    /**
     * retourne les styles du groupe
     *
     * @param int $id_groupe
     * @return array
     */
    static function getStylesById($id_groupe)
    {
        // le groupe existe-t-il ?

        $db = DataBase::getInstance();

        $sql = "SELECT `id_style` AS `id` "
             . "FROM `" . self::$_db_table_groupe_style . "` "
             . "WHERE `id_groupe` = " . (int) $id_groupe . " "
             . "ORDER BY `ordre` ASC";

        return $db->queryWithFetch($sql);
    }

    /**
     * le groupe est-il lié à des photos ?
     *
     * @return bool
     */
    function hasPhotos()
    {
        return (bool) $this->getPhotos();
    }

    /**
     * retourne les photos associées à ce groupe
     *
     * @return array ou false
     */
    function getPhotos()
    {
        return $this->_photos;
    }

    /**
     * délie les photos d'un groupe
     *
     * @return int
     */
    function unlinkPhotos()
    {
        $db = DataBase::getInstance();

        $sql = "UPDATE `" . Photo::getDbTable() . "` "
             . "SET `id_groupe` = 0 "
             . "WHERE `id_groupe` = " . (int) $this->getId();

        $db->query($sql);

        return $db->affectedRows();
    }

    /**
     * le groupe est-il lié à des audios ?
     *
     * @return bool
     */
    function hasAudios()
    {
        return (bool) $this->getAudios();
    }

    /**
     * retourne les audios associés à ce groupe
     *
     * @return array
     */
    function getAudios()
    {
        return $this->_audios;
    }

    /**
     * délie les audios d'un groupe
     *
     * @return int
     */
    function unlinkAudios()
    {
        $db = DataBase::getInstance();

        $sql = "UPDATE `" . Audio::getDbTable() . "` "
             . "SET `id_groupe` = 0 "
             . "WHERE `id_groupe` = " . (int) $this->getId();

        $db->query($sql);

        return $db->affectedRows();
    }

    /**
     * le groupe est-il lié à des vidéos ?
     *
     * @return bool
     */
    function hasVideos()
    {
        return (bool) $this->getVideos();
    }

    /**
     * retourne les vidéos associées à ce groupe
     *
     * @return array
     */
    function getVideos()
    {
        return $this->_videos;
    }

    /**
     * délie les vidéos d'un groupe
     *
     * @return int
     */
    function unlinkVideos()
    {
        $db = DataBase::getInstance();

        $sql = "UPDATE `" . Video::getDbTable() . "` "
             . "SET `id_groupe` = 0 "
             . "WHERE `id_groupe` = " . (int) $this->getId();

        $db->query($sql);

        return $db->affectedRows();
    }

    /**
     * le groupe est-il lié à des événements ?
     *
     * @return bool
     */
    function hasEvents()
    {
        return (bool) $this->getEvents();
    }

    /**
     * retourne les événements futurs rattachés au groupe
     *
     * @param string "prev"/"next/"all"
     * @return array
     */
    function getEvents($limit = 10, $type = 'all')
    {
        // le groupe existe-t-il bien ?

        //@todo Event::getEvents(['groupe' => $id_groupe, 'type' => 'all|prev|next'])
        // on extrait les événements associés au groupe

        $db = DataBase::getInstance();

        $sql = "SELECT `e`.`id_event`, `e`.`name` AS `nom_event`, `e`.`date`, "
             . "`l`.`id_lieu`, `l`.`name` AS `nom_lieu` "
             . "FROM `" . Event::getDbTable() . "` `e`, `" . self::$_db_table_participe_a . "` `p`, "
             . "`" . Groupe::getDbTable() . "` `g`, `" . Lieu::getDbTable() . "` `l` "
             . "WHERE `p`.`id_groupe` = `g`.`id_groupe` "
             . "AND `p`.`id_event` = `e`.`id_event` "
             . "AND `e`.`id_lieu` = `l`.`id_lieu` "
             . "AND `g`.`id_groupe` = " . (int) $this->_id_groupe." ";
        switch ($type) {
            case 'all':
                break;
            case 'prev':
                $sql .= "AND `e`.`date` < NOW() ";
                break;
            case 'next':
                $sql .= "AND `e`.`date` > NOW() ";
                break;
        }
        $sql .= "ORDER BY `e`.`date` ASC "
              . "LIMIT 0," . (int) $limit;

        return $db->queryWithFetch($sql);
    }

    /**
     * délie les événements d'un groupe
     *
     * @return int
     */
    function unlinkEvents()
    {
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . self::$_db_table_participe_a . "` "
             . "WHERE `id_groupe` = " . (int) $this->getId();

        $db->query($sql);

        return $db->affectedRows();
    }

    /**
     * @param string
     * @return bool
     */
    static function nameAvailable($name)
    {
        return true;
    }

    /**
     * retourne l'"alias" d'un nom de groupe à partir de son nom réel
     * (= filtre les caratères non url-compliant)
     *
     * @param string $name
     * @return string
     */
    static function genAlias(string $name): string
    {
        $alias = trim($name);
        $alias = strtolower($alias);
        $alias = Tools::removeAccents($alias);

        $map_in  = ['/', '+', '|', '.', ' ', "'", '"', '&' , '(', ')', '!'];
        $map_out = ['' , '' , '' , '' , '' , '' , '' , 'et', '' , '' ,  ''];

        $alias = str_replace($map_in, $map_out, $alias);

        return $alias;
    }

    /**
     * ajoute une visite à la fiche
     * @todo getInstance / setVisite = getVisite + 1 / save
     * @param int $id_groupe
     * @return bool
     */
    function addVisite()
    {
        $db = DataBase::getInstance();

        $sql = "UPDATE `" . self::$_table . "` "
             . "SET `visite` = `visite` + 1 "
             . "WHERE `id_groupe` = " . (int) $this->getId();

        $res = $db->query($sql);

        return $db->affectedRows($res);
    }

    /**
     * récupère les groupes ayant au moins un audio
     * @return array
     */
    static function getGroupesWithAudio()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT DISTINCT `g`.`id_groupe` AS `id`, `g`.`name` "
             . "FROM `" . Groupe::getDbTable() . "` `g`, `" . Audio::getDbTable() . "` `a` "
             . "WHERE `g`.`id_groupe` = `a`.`id_groupe` "
             . "AND `g`.`online` AND `a`.`online` "
             . "ORDER BY `g`.`name` ASC";

        return $db->queryWithFetch($sql);
    }

    /**
     * récupère les groupes ayant au moins une vidéo
     * @return array
     */
    static function getGroupesWithVideo()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT DISTINCT `g`.`id_groupe` AS `id`, `g`.`name` "
             . "FROM `" . Groupe::getDbTable() . "` `g`, `" . Video::getDbTable() . "` `v` "
             . "WHERE `g`.`id_groupe` = `v`.`id_groupe` "
             . "AND `g`.`online` AND `v`.`online` "
             . "ORDER BY `g`.`name` ASC";

        return $db->queryWithFetch($sql);
    }

    /**
     * récupère les groupes ayant au moins une photo
     * @return array
     */
    static function getGroupesWithPhoto()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT DISTINCT `g`.`id_groupe` AS `id`, `g`.`name` "
             . "FROM `" . Groupe::getDbTable() . "` `g`, `" . Photo::getDbTable() . "` `p` "
             . "WHERE `g`.`id_groupe` = `p`.`id_groupe` "
             . "AND `g`.`online` AND `p`.`online` "
             . "ORDER BY `g`.`name` ASC";

        return $db->queryWithFetch($sql);
    }

    /**
     * récupère les groupes ayant au moins un média (photo,audio,vidéo)
     * @return array
     */
    static function getGroupesWithMedia()
    {
        $db = DataBase::getInstance();

        $sql = "(SELECT DISTINCT `g`.`id_groupe` AS `id`, `g`.`name` "
             . "FROM `adhoc_groupe` `g`, `adhoc_video` `v` "
             . "WHERE `g`.`id_groupe` = `v`.`id_groupe` "
             . "AND `g`.`online` AND `v`.`online`)"/*
             . " UNION "
             . "(SELECT DISTINCT `g`.`id_groupe` AS `id`, `g`.`name` "
             . "FROM `adhoc_groupe` `g`, `adhoc_audio` `a` "
             . "WHERE `g`.`id_groupe` = `a`.`id_groupe` "
             . "AND `g`.`online` AND `a`.`online`)"
             . " UNION "
             . "(SELECT DISTINCT `g`.`id_groupe` AS `id`, `g`.`name` "
             . "FROM `adhoc_groupe` `g`, `adhoc_photo` `p` "
             . "WHERE `g`.`id_groupe` = `p`.`id_groupe` "
             . "AND `g`.`online` AND `p`.`online`)"*/
             . " ORDER BY `name` ASC";

        return $db->queryWithFetch($sql);
    }

    /**
     * Retourne si un alias de groupe est disponible
     *
     * @param string $alias
     *
     * @return bool
     */
    static function checkAliasAvailability(string $alias): bool
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `alias` "
             . "FROM `" . self::$_table . "` "
             . "WHERE `alias` = '" . $db->escape($alias) . "'";

        return $db->queryWithFetchFirstField($sql);
    }
}
