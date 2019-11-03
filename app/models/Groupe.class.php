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
     * @var string|null
     */
    protected $_site = null;

    /**
     * @var string
     */
    protected $_myspace = '';

    /**
     * @var string|null (int 64 en vérité)
     */
    protected $_facebook_page_id = null;

    /**
     * @var string|null
     */
    protected $_twitter_id = null;

    /**
     * @var string
     */
    protected $_id_departement = '';

    /**
     * @var bool
     */
    protected $_online = false;

    /**
     * @var string|null
     */
    protected $_created_on = null;

    /**
     * @var string|null
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
        'id_groupe'        => 'int',
        'alias'            => 'string',
        'name'             => 'string',
        'style'            => 'string',
        'influences'       => 'string',
        'lineup'           => 'string',
        'mini_text'        => 'string',
        'text'             => 'string',
        'site'             => 'string',
        'myspace'          => 'string',
        'facebook_page_id' => 'string',
        'twitter_id'       => 'string',
        'id_departement'   => 'string',
        'online'           => 'bool',
        'created_on'       => 'date',
        'modified_on'      => 'date',
        'datdeb'           => 'date',
        'datfin'           => 'date',
        'comment'          => 'string',
        'etat'             => 'int',
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
    static function getBaseUrl(): string
    {
        return MEDIA_URL . '/groupe';
    }

    /**
     * Retourne le chemin absolu des medias relatifs au groupe
     *
     * @return string
     */
    static function getBasePath(): string
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
     * @return string|null (int 64bits réellement)
     */
    function getFacebookPageId(): ?string
    {
        return $this->_facebook_page_id;
    }

    /**
     * Retourne l'url de la page "fans" Facebook
     *
     * @return string|null
     */
    function getFacebookPageUrl(): ?string
    {
        if ($this->getFacebookPageId()) {
            return 'https://www.facebook.com/pages/' . $this->_alias . '/' . $this->_facebook_page_id;
        }
        return null;
    }

    /**
     * Retourne l'identifiant twitter
     *
     * @return string|null
     */
    function getTwitterId(): ?string
    {
        return $this->_twitter_id;
    }

    /**
     * Retourne l'url du fil twitter
     *
     * @return string|null
     */
    function getTwitterUrl(): ?string
    {
        if ($this->getTwitterId()) {
            return 'https://www.twitter.com/' . $this->_twitter_id;
        }
        return null;
    }

    /**
     * Retourne l'url du site officiel
     *
     * @return string|null
     *
     * @todo check le http:// initial
     */
    function getSite(): ?string
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
        return $this->_online;
    }

    /**
     * Retourne la date d'inscription format YYYY-MM-DD HH:II:SS
     *
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
     * Retourne la date d'inscription sous forme de timestamp
     *
     * @return int|null
     */
    function getCreatedOnTs(): ?string
    {
        if (!is_null($this->created_on) && Date::isDateTimeOk($this->_created_on)) {
            return strtotime($this->_created_on);
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
     * @return string|null
     */
    function getDatdeb(): ?string
    {
        if (!is_null($this->_datdeb) && Date::isDateOk($this->_datdeb)) {
            return $this->_datdeb;
        }
        return null;
    }

    /**
     * Retourne la date de fin d'activité
     *
     * @return string|null
     */
    function getDatfin(): ?string
    {
        if (!is_null($this->_datfin) && Date::isDateOk($this->_datfin)) {
            return $this->_datfin;
        }
        return null;
    }

    /**
     * Retourne le "mot AD'HOC"
     *
     * @return string
     */
    function getComment(): string
    {
        return $this->_comment;
    }

    /**
     * Retourne l'état du groupe
     *
     * @return int
     */
    function getEtat(): int
    {
        return $this->_etat;
    }

    /**
     * Retourne le nom du groupe à partir de son id
     *
     * @param int $id_groupe id_groupe
     *
     * @return string|false
     */
    static function getNameById(int $id_groupe): string
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `name` "
             . "FROM `" . Groupe::getDbTable() . "` "
             . "WHERE `" . Groupe::getDbPk() . "` = " . (int) $id_groupe;

        return $db->queryWithFetchFirstField($sql);
    }

    /**
     * Retourne l'url de la photo principale
     *
     * @return string|null
     */
    function getPhoto(): ?string
    {
        if (file_exists(self::getBasePath() . '/p' . $this->getId() . '.jpg')) {
            return self::getBaseUrl() . '/p' . $this->getId() . '.jpg?ts=' . $this->getModifiedOnTs();
        }
        return null;
    }

    /**
     * Retourne l'url de la mini photo
     * (64x64)
     *
     * @return string
     */
    function getMiniPhoto(): string
    {
        if (file_exists(self::getBasePath() . '/m' . $this->getId() . '.jpg')) {
            return self::getBaseUrl() . '/m' . $this->getId() . '.jpg?ts=' . $this->getModifiedOnTs();
        } else {
            // todo mini photo par défaut, dans une méthode statique
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
        }
        return null;
    }

    /**
     * Retourne l'url d'une fiche groupe
     *
     * @return string
     */
    function getUrl(): string
    {
        return HOME_URL . '/' . $this->_alias;
    }

    /**
     * Retourne l'url d'une fiche groupe à partir de son alias ou son id
     *
     * @param string $ref ref
     *
     * @return string
     */
    static function getUrlFiche(string $ref): string
    {
        if (is_numeric($ref)) {
            $alias = Groupe::getAliasById((int) $ref);
        } else {
            $alias = trim($ref);
        }

        return HOME_URL . '/' . $alias;
    }

    /**
     * @todo à mettre dans Tools::getFacebookShareUrl(string $url)
     *
     * @return string
     */
    function getFacebookShareUrl(): string
    {
        return 'https://www.facebook.com/sharer.php?u=' . urlencode($this->getUrl());
    }

    /**
     * Retourne l'image de l'avatar d'un groupe
     *
     * @param int $id_groupe id_groupe
     *
     * @return string
     */
    static function getAvatarById(int $id_groupe): string
    {
        $avatar = HOME_URL . '/img/note_adhoc_64.png';
        if (file_exists(self::getBasePath() . '/m' . (string) $id_groupe . '.jpg')) {
            $avatar = self::getBaseUrl() . '/m' . (string) $id_groupe . '.jpg';
        }
        return $avatar;
    }

    /**
     * Retourne l'alias d'un groupe à partir de son id
     *
     * @param int $id_groupe id_groupe
     *
     * @return string|null
     */
    static function getAliasById(int $id_groupe): ?string
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `alias` "
             . "FROM `" . Groupe::getDbTable() . "` "
             . "WHERE `" . self::$_pk . "` = " . (int) $id_groupe;

        if ($alias = $db->queryWithFetchFirstField($sql)) {
            return $alias;
        }
        return null;
    }

    /* fin getters */

    /* début setters */

    /**
     * @param string $alias alias
     *
     * @return object
     */
    function setAlias(string $alias): object
    {
        if ($this->_alias !== $alias) {
            $this->_alias = $alias;
            $this->_modified_fields['alias'] = true;
        }

        return $this;
    }

    /**
     * @param string $name nom
     *
     * @return object
     */
    function setName(string $name): object
    {
        if ($this->_name !== $name) {
            $this->_name = $name;
            $this->_modified_fields['name'] = true;
            $this->setAlias(self::genAlias($name));
        }

        return $this;
    }

    /**
     * @param string $style style libre
     *
     * @return object
     */
    function setStyle(string $style): object
    {
        if ($this->_style !== $style) {
            $this->_style = $style;
            $this->_modified_fields['style'] = true;
        }

        return $this;
    }

    /**
     * @param string $influences influences
     * 
     * @return object
     */
    function setInfluences(string $influences): object
    {
        if ($this->_influences !== $influences) {
            $this->_influences = $influences;
            $this->_modified_fields['influences'] = true;
        }

        return $this;
    }

    /**
     * @param string $lineup lineup (formation)
     *
     * @return object
     */
    function setLineup(string $lineup): object
    {
        if ($this->_lineup !== $lineup) {
            $this->_lineup = $lineup;
            $this->_modified_fields['lineup'] = true;
        }

        return $this;
    }

    /**
     * @param string $mini_text mini texte
     *
     * @return object
     */
    function setMiniText(string $mini_text): object
    {
        if ($this->_mini_text !== $mini_text) {
            $this->_mini_text = $mini_text;
            $this->_modified_fields['mini_text'] = true;
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
     * @param string|null $site url du site
     *
     * @return object
     */
    function setSite(?string $site): object
    {
        if ($this->_site !== $site) {
            $this->_site = $site;
            $this->_modified_fields['site'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $myspaceId myspaceId
     *
     * @return object
     */
    function setMyspaceId(?string $myspaceId): object
    {
        $val = trim($val);
        $val = str_replace('http://', '', $val);
        $val = str_replace('www.myspace.com/', '', $val);

        if ($this->_myspace !== $myspaceId) {
            $this->_myspace = $myspaceId;
            $this->_modified_fields['myspace'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $val id de page facebook (int 64bits en fait)
     *
     * @return object
     */
    function setFacebookPageId(?string $val): object
    {
        if ($this->_facebook_page_id !== $val) {
            $this->_facebook_page_id = $val;
            $this->_modified_fields['facebook_page_id'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $val val
     *
     * @return object
     */
    function setTwitterId(?string $val): object
    {
        if ($this->_twitter_id !== $val) {
            $this->_twitter_id = $val;
            $this->_modified_fields['twitter_id'] = true;
        }

        return $this;
    }

    /**
     * @param string $val val
     *
     * @return object
     */
    function setIdDepartement(string $val): object
    {
        if ($this->_id_departement !== $val) {
            $this->_id_departement = $val;
            $this->_modified_fields['id_departement'] = true;
        }

        return $this;
    }

    /**
     * @param bool $val val
     *
     * @return object
     */
    function setOnline(bool $val): object
    {
        if ($this->_online !== $val) {
            $this->_online = $val;
            $this->_modified_fields['online'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $val val
     *
     * @return object
     */
    function setCreatedOn(?string $val): object
    {
        if ($this->_created_on !== $val) {
            $this->_created_on = $val;
            $this->_modified_fields['created_on'] = true;
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
            $this->_modified_fields['created_on'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $val val
     */
    function setModifiedOn(?string $val): object
    {
        if ($this->_modified_on !== $val) {
            $this->_modified_on = $val;
            $this->_modified_fields['modified_on'] = true;
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
            $this->_modified_fields['modified_on'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $val val
     *
     * @return object
     */
    function setDatdeb(?string $val): object
    {
        if ($this->_datdeb !== $val) {
            $this->_datdeb = $val;
            $this->_modified_fields['datdeb'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $val val
     *
     * @return object
     */
    function setDatfin(?string $val): object
    {
        if ($this->_datfin !== $val) {
            $this->_datfin = $val;
            $this->_modified_fields['datfin'] = true;
        }

        return $this;
    }

    /**
     * @param string $val val
     *
     * @return object
     */
    function setComment(string $val): object
    {
        if ($this->_comment !== $val) {
            $this->_comment = $val;
            $this->_modified_fields['comment'] = true;
        }

        return $this;
    }

    /**
     * @param int $etat etat
     *
     * @return object
     */
    function setEtat(int $etat): object
    {
        if ($this->_etat !== $etat) {
            $this->_etat = $etat;
            $this->_modified_fields['etat'] = true;
        }

        return $this;
    }

    /* fin setters */

    /**
     * Retourne le nombre de groupes actifs
     *
     * @param int $etat etat 0|1|2 ?
     *
     * @return int
     */
    static function getGroupesCount(?int $etat = null): int
    {
        $db = DataBase::getInstance();

        $sql = 'SELECT COUNT(*) FROM `' . Groupe::getDbTable() . '` ';
        if (!is_null($etat)) {
            $sql .= 'WHERE `etat` = ' . (int) $etat;
        }

        return (int) $db->queryWithFetchFirstField($sql);
    }

    /**
     * Retourne le nombre de mes groupes
     *
     * @return int
     */
    static function getMyGroupesCount(): int
    {
        if (empty($_SESSION['membre'])) {
            throw new Exception('non identifié');
        }

        $db = DataBase::getInstance();

        $sql = 'SELECT COUNT(*) '
             . 'FROM `' . self::$_db_table_appartient_a . '` '
             . 'WHERE `id_contact` = ' . (int) $_SESSION['membre']->getId();

        return (int) $db->queryWithFetchFirstField($sql);
    }

    /**
     * Efface un groupe de la base + la photo, mini photo, logo
     * + ses liaisons avec membres
     * + ses liaisons avec styles
     * + ses liaisons avec events
     * + ses liaisons avec photos,videos,audios
     *
     * @return bool
     */
    function delete(): bool
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
     * @return bool
     * @throws Exception
     */
    protected function _loadFromDb(): bool
    {
        if (!parent::_loadFromDb()) {
            throw new Exception('id_groupe introuvable');
        }

        return true;
    }

    /**
     * Lie un membre à un groupe
     *
     * @param int $id_contact       id_contact
     * @param int $id_type_musicien id_type_musicien
     *
     * @return bool
     */
    function linkMember(int $id_contact, int $id_type_musicien): bool
    {
        // on ne peut pas lier un groupe qui n'a pas d'id
        if (!$this->getId()) {
            return false;
        }
        // le groupe existe-t-il bien ?

        // l'id_contact est il valide ?
        if (($mbr = Membre::getInstance($id_contact)) === false) {
            throw new Exception('id_contact introuvable');
        }

        // la relation est elle deja présente ?

        // tout est ok, on insère dans appartient_a
        $db = DataBase::getInstance();

        $sql = 'INSERT INTO `' . self::$_db_table_appartient_a . '` '
             . '(`' . Groupe::getDbPk() . '`, `' . Membre::getDbPk() . '`, `' . TypeMusicien::getDbPk() . '`) '
             . 'VALUES(' . (int) $this->getId() . ', ' . (int) $id_contact . ', ' . (int) $id_type_musicien . ')';

        $db->query($sql);

        return (bool) $db->affectedRows();
    }

    /**
     * Met à jour la table de relation  membre/type_musicien/groupe
     *
     * @param int $id_contact       id_contact
     * @param int $id_type_musicien id_type_musicien
     *
     * @return bool
     */
    function updateMember(int $id_contact, int $id_type_musicien): bool
    {
        $db = DataBase::getInstance();

        $sql = 'UPDATE `' . self::$_db_table_appartient_a . '` '
             . 'SET `' . TypeMusicien::getDbPk() . '` = ' . (int) $id_type_musicien . ' '
             . 'WHERE `' . Groupe::getDbPk() . '` = ' . (int) $this->getId() . ' '
             . 'AND `' . Membre::getDbPk() . '` = ' . (int) $id_contact;

        $db->query($sql);

        return (bool) $db->affectedRows();
    }

    /**
     * Délie un membre d'un groupe
     *
     * @param int $id_contact id_contact
     *
     * @return bool
     */
    function unlinkMember(int $id_contact): bool
    {
        // le groupe existe-t-il bien ?

        // l'id_contact est il valide ?

        // la relation est elle bien présente ?

        // tout est ok, on delete dans groupe_membre

        $db = DataBase::getInstance();

        $sql = 'DELETE FROM `' . self::$_db_table_appartient_a . '` '
             . 'WHERE `' . Groupe::getDbPk() . '` = ' . (int) $this->getId() . ' '
             . 'AND `' . Membre::getDbPk() . '` = ' . (int) $id_contact;

        $db->query($sql);

        return (bool) $db->affectedRows();
    }

    /**
     * Délie tous les membres d'un groupe
     *
     * @return int
     */
    function unlinkMembers(): int
    {
        $db = DataBase::getInstance();

        $sql = 'DELETE FROM `' . self::$_db_table_appartient_a . '` '
             . 'WHERE `' . $this->getDbPk() . '` = ' . (int) $this->getId();

        $db->query($sql);

        return $db->affectedRows();
    }

    /**
     * Un membre appartient-il au groupe ?
     *
     * @param int $id_contact id_contact
     *
     * @return int|false id_type_musicien si appartient, false sinon
     */
    function isMember(int $id_contact)
    {
        if (is_null($this->_members)) {
            $this->_members = self::getMembersById($this->getId());
        }

        foreach ($this->_members as $member) {
            if ($member['id'] === $id_contact) {
                return $member['id_type_musicien'];
            }
        }
        return false;
    }

    /**
     * Retourne un tableau des membres liés à ce groupe
     *
     * @return array
     */
    function getMembers(): array
    {
        if (is_null($this->_members)) {
            $this->_members = self::getMembersById($this->getId());
        }

        return $this->_members;
    }

    /**
     * Retourne un tableau des membres liés à ce groupe
     *
     * @param int $id_groupe id_groupe
     *
     * @return array
     */
    static function getMembersById(int $id_groupe): array
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `m`.`id_contact` AS `id`, `c`.`email`, `m`.`last_name`, `m`.`first_name`, `m`.`pseudo`, "
             . "`c`.`email`, `m`.`created_on`, "
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
            $res[$cpt]['nom_type_musicien'] = TypeMusicien::getInstance((int) $_res['id_type_musicien'])->getName();
            $res[$cpt]['url'] = Membre::getUrlById((int) $_res['id']);
            $cpt++;
        }
        return $res;
    }

    /**
     * Le groupe est-il lié à des membres ?
     *
     * @return bool
     */
    function hasMembers(): bool
    {
        return (bool) $this->getMembers();
    }

    /**
     * Retourne un tableau de groupes en fonction de critères donnés
     *
     * @param array $params params
     *
     * @return array
     */
    static function getGroupes(array $params = []): array
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
        if (isset($params['sens']) && $params['sens'] === 'DESC') {
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

        $sql = "SELECT `g`.`id_groupe` AS `id`, `g`.`name`, `g`.`alias`, `g`.`mini_text`, `g`.`text`, `g`.`style`, `g`.`lineup`, "
             . "`g`.`etat`, `g`.`site`, `g`.`influences`, `g`.`created_on`, UNIX_TIMESTAMP(`g`.`created_on`) AS `created_on_ts`, "
             . " `g`.`modified_on`, UNIX_TIMESTAMP(`g`.`modified_on`) AS `modified_on_ts`, "
             . "`g`.`alias`, `g`.`myspace`, `g`.`comment` "
             . "FROM `" . Groupe::getDbTable() . "` `g` "
             . "WHERE 1 ";

        if (!is_null($online)) {
            $sql .= "AND `g`.`online` = " . $online . " ";
        }

        if (count($tab_id) && ($tab_id[0] !== 0)) {
            $sql .= "AND `g`.`id_groupe` IN (" . implode(',', $tab_id) . ") ";
        }

        $sql .= "ORDER BY ";
        if ($sort === "random") {
            $sql .= "RAND(" . time() . ") ";
        } else {
            $sql .= "`g`.`" . $sort . "` " . $sens . " ";
        }

        if (!is_null($limit)) {
            $sql .= "LIMIT " . $debut . ", " . $limit;
        }

        $res = $db->queryWithFetch($sql);

        foreach ($res as $idx => $grp) {
            $res[$idx]['url'] = HOME_URL . '/' . $res[$idx]['alias'];
            $res[$idx]['mini_photo'] = '/img/note_adhoc_64.png';
            if (file_exists(self::getBasePath() . '/m' . $res[$idx]['id'] . '.png')) {
                $res[$idx]['mini_photo'] = self::getBaseUrl() . '/m' . $res[$idx]['id'] . '.png?ts=' . $res[$idx]['modified_on_ts'];
            } elseif (file_exists(self::getBasePath() . '/m' . $res[$idx]['id'] . '.jpg')) {
                $res[$idx]['mini_photo'] = self::getBaseUrl() . '/m' . $res[$idx]['id'] . '.jpg?ts=' . $res[$idx]['modified_on_ts'];
            } elseif (file_exists(self::getBasePath() . '/m' . $res[$idx]['id'] . '.gif')) {
                $res[$idx]['mini_photo'] = self::getBaseUrl() . '/m' . $res[$idx]['id'] . '.gif?ts=' . $res[$idx]['modified_on_ts'];
            }
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
                $tab[$grp['id']]['nom_type_musicien'] = TypeMusicien::getInstance((int) $grp['id_type_musicien'])->getName();
            }
            return $tab;
        }
        return [];
    }

    /**
     * Retourne l'id d'un groupe à partir de son alias
     *
     * @param string $alias alias
     *
     * @return int|null
     */
    static function getIdByAlias(string $alias): ?int
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `" . self::$_pk . "` "
             . "FROM `" . Groupe::getDbTable() . "` "
             . "WHERE `alias` = '" . $db->escape($alias) . "'";

        if ($id_groupe = $db->queryWithFetchFirstField($sql)) {
            return (int) $id_groupe;
        }
        return null;
    }

    /**
     * Retourne l'id d'un groupe à partir d'id de sa page facebook
     *
     * @param int $fbpid fbpid
     *
     * @return int
     */
    static function getIdByFacebookPageId(int $fbpid): ?int
    {
        $db = DataBase::getInstance();

        // /!\ 64 bits
        if (!is_numeric($fbpid)) {
            return null;
        }

        $sql = "SELECT `id_groupe` "
             . "FROM `" . Groupe::getDbTable() . "` "
             . "WHERE `facebook_page_id` = " . $fbpid;

        if ($id_groupe = $db->queryWithFetchFirstField($sql)) {
            return (int) $id_groupe;
        }
        return null;
    }

    /**
     * Ajoute un style au groupe
     *
     * @param int $id_style id_style
     *
     * @return int
     */
    function linkStyle(int $id_style): int
    {
        // le groupe existe-t-il bien ?

        // le style existe-il bien ?
        $style = Style::getInstance($id_style);

        // le groupe n'a-t-il pas déjà ce style ?

        // c'est ok on ajoute le style
        $db = DataBase::getInstance();

        $sql = "INSERT INTO `" . self::$_db_table_groupe_style . "` "
             . "(`id_groupe`, `id_style`) "
             . "VALUES(" . (int) $this->getId() . ", " . (int) $style->getId() . ")";

        $db->query($sql);

        return $db->affectedRows();
    }

    /**
     * Retire un style du groupe
     *
     * @param int $id_style id_style
     *
     * @return bool
     */
    function unlinkStyle(int $id_style): bool
    {
        // les paramètres sont-ils corrects ?

        // le groupe existe-t-il bien ?

        // le style existe-il bien ?
        $style = Style::getInstance($id_style);

        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . self::$_db_table_groupe_style  ."` "
             . "WHERE `id_groupe` = " . (int) $this->getId() . " "
             . "AND `id_style` = " . (int) $style->getId();

        $db->query($sql);

        return $db->affectedRows();
    }

    /**
     * Purge tous les styles d'un groupe
     *
     * @return bool
     */
    function unlinkStyles(): bool
    {
        // les paramètres sont-ils corrects ?

        // le groupe existe-t-il bien ?

        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . self::$_db_table_groupe_style . "` "
             . "WHERE `id_groupe` = " . (int) $this->getId();

        $db->query($sql);

        return (bool) $db->affectedRows();
    }

    /**
     * Retourne les styles du groupe
     *
     * @return array
     */
    function getStyles(): array
    {
        return $this->_styles;
    }

    /**
     * Retourne les styles du groupe
     *
     * @param int $id_groupe id_groupe
     *
     * @return array
     */
    static function getStylesById(int $id_groupe): array
    {
        // le groupe existe-t-il ?

        $db = DataBase::getInstance();

        $sql = "SELECT `id_style` "
             . "FROM `" . self::$_db_table_groupe_style . "` "
             . "WHERE `id_groupe` = " . (int) $id_groupe;

        return $db->queryWithFetch($sql);
    }

    /**
     * Le groupe est-il lié à des photos ?
     *
     * @return bool
     */
    function hasPhotos(): bool
    {
        return (bool) $this->getPhotos();
    }

    /**
     * Retourne les photos associées à ce groupe
     *
     * @return array ou false
     */
    function getPhotos(): array
    {
        return $this->_photos;
    }

    /**
     * Délie les photos d'un groupe
     *
     * @return int
     */
    function unlinkPhotos()
    {
        $db = DataBase::getInstance();

        $sql = "UPDATE `" . Photo::getDbTable() . "` "
             . "SET `id_groupe` = NULL "
             . "WHERE `id_groupe` = " . (int) $this->getId();

        $db->query($sql);

        return $db->affectedRows();
    }

    /**
     * Le groupe est-il lié à des audios ?
     *
     * @return bool
     */
    function hasAudios(): bool
    {
        return (bool) $this->getAudios();
    }

    /**
     * Retourne les audios associés à ce groupe
     *
     * @return array
     */
    function getAudios(): array
    {
        return $this->_audios;
    }

    /**
     * Délie les audios d'un groupe
     *
     * @return int
     */
    function unlinkAudios(): int
    {
        $db = DataBase::getInstance();

        $sql = "UPDATE `" . Audio::getDbTable() . "` "
             . "SET `id_groupe` = NULL "
             . "WHERE `id_groupe` = " . (int) $this->getId();

        $db->query($sql);

        return $db->affectedRows();
    }

    /**
     * Le groupe est-il lié à des vidéos ?
     *
     * @return bool
     */
    function hasVideos(): bool
    {
        return (bool) $this->getVideos();
    }

    /**
     * Retourne les vidéos associées à ce groupe
     *
     * @return array
     */
    function getVideos(): array
    {
        return $this->_videos;
    }

    /**
     * Délie les vidéos d'un groupe
     *
     * @return int
     */
    function unlinkVideos()
    {
        $db = DataBase::getInstance();

        $sql = "UPDATE `" . Video::getDbTable() . "` "
             . "SET `id_groupe` = NULL "
             . "WHERE `id_groupe` = " . (int) $this->getId();

        $db->query($sql);

        return $db->affectedRows();
    }

    /**
     * Le groupe est-il lié à des événements ?
     *
     * @return bool
     */
    function hasEvents(): bool
    {
        return (bool) $this->getEvents();
    }

    /**
     * Retourne les événements futurs rattachés au groupe
     *
     * @param int    $limit limite
     * @param string $type  prev|next|all
     *
     * @return array
     */
    function getEvents(int $limit = 10, string $type = 'all'): array
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
     * Délie les événements d'un groupe
     *
     * @return int
     */
    function unlinkEvents(): int
    {
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . self::$_db_table_participe_a . "` "
             . "WHERE `id_groupe` = " . (int) $this->getId();

        $db->query($sql);

        return $db->affectedRows();
    }

    /**
     * @param string $name name
     *
     * @return bool
     */
    static function nameAvailable($name): bool
    {
        return true; // lol
    }

    /**
     * Retourne l'"alias" d'un nom de groupe à partir de son nom réel
     * (= filtre les caratères non url-compliant)
     *
     * @param string $name name
     *
     * @return string
     */
    static function genAlias(string $name): string
    {
        $alias = trim($name);
        $alias = mb_strtolower($alias);
        $alias = Tools::removeAccents($alias);

        $map_in  = ['/', '+', '|', '.', ' ', "'", '"', '&' , '(', ')', '!'];
        $map_out = ['' , '' , '' , '' , '' , '' , '' , 'et', '' , '' ,  ''];

        $alias = str_replace($map_in, $map_out, $alias);

        return $alias;
    }

    /**
     * Récupère les groupes ayant au moins un audio
     *
     * @return array
     */
    static function getGroupesWithAudio(): array
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
     * Récupère les groupes ayant au moins une vidéo
     *
     * @return array
     */
    static function getGroupesWithVideo(): array
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
     * Récupère les groupes ayant au moins une photo
     *
     * @return array
     */
    static function getGroupesWithPhoto(): array
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
     * Récupère les groupes ayant au moins un média (photo,audio,vidéo)
     *
     * @return array
     */
    static function getGroupesWithMedia(): array
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
     * @param string $alias alias
     *
     * @return bool
     */
    static function checkAliasAvailability(string $alias): bool
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `alias` "
             . "FROM `" . Groupe::getDbTable() . "` "
             . "WHERE `alias` = '" . $db->escape($alias) . "'";

        return $db->queryWithFetchFirstField($sql);
    }
}
