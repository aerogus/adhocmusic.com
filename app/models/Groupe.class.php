<?php declare(strict_types=1);

use \Reference\Style;
use \Reference\TypeMusicien;
use \Reference\GroupeStatus;

/**
 * Classe Groupe
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Groupe extends ObjectModel
{
    /**
     * Instance de l'objet
     *
     * @var object
     */
    protected static $_instance = null;

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
     * Liste des attributs de l'objet
     *
     * @var array
     */
    protected static $_all_fields = [
        'id_groupe'        => 'int', // pk
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
     * Retourne l'id_groupe
     *
     * @return string
     */
    function getIdGroupe(): int
    {
        return $this->_id_groupe;
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
    function getIdDepartement(): string
    {
        return $this->_id_departement;
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
        return Groupe::getInstance($id_groupe)->getName();
    }

    /**
     * Retourne l'url de la photo principale
     *
     * @return string|null
     */
    function getPhoto(): ?string
    {
        if (file_exists(self::getBasePath() . '/p' . $this->getIdGroupe() . '.jpg')) {
            return self::getBaseUrl() . '/p' . $this->getIdGroupe() . '.jpg?ts=' . $this->getModifiedOnTs();
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
        return HOME_URL . '/' . $this->getAlias();
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
            $this->setAlias(Tools::genAlias($name));
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
     * @param string|null $facebook_page_id page facebook (int 64bits en fait)
     *
     * @return object
     */
    function setFacebookPageId(?string $facebook_page_id): object
    {
        if ($this->_facebook_page_id !== $facebook_page_id) {
            $this->_facebook_page_id = $facebook_page_id;
            $this->_modified_fields['facebook_page_id'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $twitter_id twitter_id
     *
     * @return object
     */
    function setTwitterId(?string $twitter_id): object
    {
        if ($this->_twitter_id !== $twitter_id) {
            $this->_twitter_id = $twitter_id;
            $this->_modified_fields['twitter_id'] = true;
        }

        return $this;
    }

    /**
     * @param string $id_departement id_departement
     *
     * @return object
     */
    function setIdDepartement(string $id_departement): object
    {
        if ($this->_id_departement !== $id_departement) {
            $this->_id_departement = $id_departement;
            $this->_modified_fields['id_departement'] = true;
        }

        return $this;
    }

    /**
     * @param bool $online online
     *
     * @return object
     */
    function setOnline(bool $online): object
    {
        if ($this->_online !== $online) {
            $this->_online = $online;
            $this->_modified_fields['online'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $created_on created_on
     *
     * @return object
     */
    function setCreatedOn(?string $created_on): object
    {
        if ($this->_created_on !== $created_on) {
            $this->_created_on = $created_on;
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
     * @param string|null $modified_on modified_on
     */
    function setModifiedOn(?string $modified_on): object
    {
        if ($this->_modified_on !== $modified_on) {
            $this->_modified_on = $modified_on;
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
     * @param string|null $datdeb date début
     *
     * @return object
     */
    function setDatdeb(?string $datdeb): object
    {
        if ($this->_datdeb !== $datdeb) {
            $this->_datdeb = $datdeb;
            $this->_modified_fields['datdeb'] = true;
        }

        return $this;
    }

    /**
     * @param string|null $datfin date fin
     *
     * @return object
     */
    function setDatfin(?string $datfin): object
    {
        if ($this->_datfin !== $datfin) {
            $this->_datfin = $datfin;
            $this->_modified_fields['datfin'] = true;
        }

        return $this;
    }

    /**
     * @param string $comment comment
     *
     * @return object
     */
    function setComment(string $comment): object
    {
        if ($this->_comment !== $comment) {
            $this->_comment = $comment;
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
     * Retourne le nombre de mes groupes
     *
     * @return int
     */
    static function countMy(): int
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
        $db = DataBase::getInstance();

        $sql = 'INSERT INTO `' . self::$_db_table_appartient_a . '` '
             . '(`' . Groupe::getDbPk() . '`, `' . Membre::getDbPk() . '`, `' . TypeMusicien::getDbPk() . '`) '
             . 'VALUES(' . (int) $this->getIdGroupe() . ', ' . (int) $id_contact . ', ' . (int) $id_type_musicien . ')';

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
             . 'WHERE `' . Groupe::getDbPk() . '` = ' . (int) $this->getIdGroupe() . ' '
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
        $db = DataBase::getInstance();

        $sql = 'DELETE FROM `' . self::$_db_table_appartient_a . '` '
             . 'WHERE `' . Groupe::getDbPk() . '` = ' . (int) $this->getIdGroupe() . ' '
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
             . 'WHERE `' . $this->getDbPk() . '` = ' . (int) $this->getIdGroupe();

        $db->query($sql);

        return $db->affectedRows();
    }

    /**
     * Un membre appartient-il au groupe ?
     *
     * @param int $id_contact id_contact
     *
     * @return bool true si appartient, false sinon
     */
    function isMember(int $id_contact): bool
    {
        $membres = $this->getMembers();
        foreach ($membres as $membre) {
            if ($membre->getIdContact() === $id_contact) {
                return true;
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
        return Membre::find(
            [
                'id_groupe' => $this->getIdGroupe()
            ]
        );
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
     * Retourne une collection d'objets "Groupe" répondant au(x) critère(s) donné(s)
     *
     * @param array $params [
     *                      'id_contact' => int,
     *                      'id_event' => int,
     *                      'alias' => string,
     *                      'facebook_page_id' => string,
     *                      'online' => bool,
     *                      'order_by' => string,
     *                      'sort' => string,
     *                      'start' => int,
     *                      'limit' => int,
     *                      ]
     *
     * @return array
     */
    static function find(array $params): array
    {
        $db = DataBase::getInstance();
        $objs = [];

        $sql = "SELECT `" . static::getDbPk() . "` FROM `" . static::getDbTable() . "` WHERE 1 ";

        if (isset($params['id_contact'])) {
            $subSql = "SELECT `id_groupe` FROM `adhoc_appartient_a` WHERE `id_contact` = " . (int) $params['id_contact'] . " ";
            if ($ids_groupe = $db->queryWithFetchFirstFields($subSql)) {
                $sql .= "AND `id_groupe` IN (" . implode(',', (array) $ids_groupe) . ") ";
            } else {
                return $objs;
            }
        }

        if (isset($params['id_event'])) {
            $subSql = "SELECT `id_groupe` FROM `adhoc_participe_a` WHERE `id_event` = " . (int) $params['id_event'] . " ";
            if ($ids_groupe = $db->queryWithFetchFirstFields($subSql)) {
                $sql .= "AND `id_groupe` IN (" . implode(',', (array) $ids_groupe) . ") ";
            } else {
                return $objs;
            }
        }

        if (isset($params['alias'])) {
            $sql .= "AND `alias` = '" . $db->escape($params['alias']) . "' ";
        }

        if (isset($params['facebook_page_id'])) {
            $sql .= "AND `facebook_page_id` = " . (int) $params['facebook_page_id'] . " ";
        }

        if (isset($params['online'])) {
            $sql .= "AND `online` = ";
            $sql .= $params['online'] ? "TRUE" : "FALSE";
            $sql .= " ";
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

    /**
     * Retourne l'id d'un groupe à partir de son alias
     *
     * @param string $alias alias
     *
     * @return int|null
     */
    static function getIdByAlias(string $alias): ?int
    {
        if ($groupes = self::find(['alias' => $alias])) {
            return $groupes[0]->getIdGroupe();
        }
        return null;
    }

    /**
     * Retourne l'id d'un groupe à partir d'id de sa page facebook
     *
     * @param int $facebook_page_id facebook_page_id
     *
     * @return int|null
     */
    static function getIdByFacebookPageId(int $facebook_page_id): ?int
    {
        if ($groupes = self::find(['facebook_page_id' => $facebook_page_id])) {
            return $groupes[0]->getIdGroupe();
        }
        return null;
    }

    /**
     * Ajoute un style au groupe
     *
     * @param int $id_style id_style
     *
     * @return bool
     */
    function linkStyle(int $id_style): bool
    {
        $db = DataBase::getInstance();

        $sql = "INSERT INTO `" . self::$_db_table_groupe_style . "` "
             . "(`id_groupe`, `id_style`) "
             . "VALUES(" . (int) $this->getIdGroupe() . ", " . (int) $id_style . ")";

        $db->query($sql);

        return (bool) $db->affectedRows();
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
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . self::$_db_table_groupe_style  ."` "
             . "WHERE `id_groupe` = " . (int) $this->getIdGroupe() . " "
             . "AND `id_style` = " . (int) $id_style;

        $db->query($sql);

        return (bool) $db->affectedRows();
    }

    /**
     * Purge tous les styles d'un groupe
     *
     * @return bool
     */
    function unlinkStyles(): bool
    {
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . self::$_db_table_groupe_style . "` "
             . "WHERE `id_groupe` = " . (int) $this->getIdGroupe();

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
        return Style::find(['id_groupe' => $this->getIdGroupe()]);
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
        return Photo::find(['id_groupe' => $this->getIdGroupe()]);
    }

    /**
     * Délie toutes les photos d'un groupe
     *
     * @return int
     */
    function unlinkPhotos()
    {
        $photos = Photo::find(['id_groupe' => $this->getIdGroupe()]);
        foreach ($photos as $photo) {
            $photo->setIdGroupe(null)->save();
        }

        return count($photos);
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
        return Audio::find(['id_groupe' => $this->getIdGroupe()]);
    }

    /**
     * Délie les audios d'un groupe
     *
     * @return int
     */
    function unlinkAudios(): int
    {
        $audios = Audio::find(['id_groupe' => $this->getIdGroupe()]);
        foreach ($audios as $audio) {
            $audio->setIdGroupe(null)->save();
        }

        return count($audios);
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
        return Video::find(['id_groupe' => $this->getIdGroupe()]);
    }

    /**
     * Délie les vidéos d'un groupe
     *
     * @return int
     */
    function unlinkVideos()
    {
        $videos = Video::find(['id_groupe' => $this->getIdGroupe()]);
        foreach ($videos as $video) {
            $video->setIdGroupe(null)->save();
        }

        return count($videos);
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
     * Retourne les events associées à ce groupe
     *
     * @return array
     */
    function getEvents(): array
    {
        return Event::find(['id_groupe' => $this->getIdGroupe()]);
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
             . "WHERE `id_groupe` = " . (int) $this->getIdGroupe();

        $db->query($sql);

        return $db->affectedRows();
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
             . "AND `g`.`online` AND `v`.`online`)"
             . " UNION "
             . "(SELECT DISTINCT `g`.`id_groupe` AS `id`, `g`.`name` "
             . "FROM `adhoc_groupe` `g`, `adhoc_audio` `a` "
             . "WHERE `g`.`id_groupe` = `a`.`id_groupe` "
             . "AND `g`.`online` AND `a`.`online`)"
             . " UNION "
             . "(SELECT DISTINCT `g`.`id_groupe` AS `id`, `g`.`name` "
             . "FROM `adhoc_groupe` `g`, `adhoc_photo` `p` "
             . "WHERE `g`.`id_groupe` = `p`.`id_groupe` "
             . "AND `g`.`online` AND `p`.`online`)"
             . " ORDER BY `name` ASC";

        return $db->queryWithFetch($sql);
    }
}
