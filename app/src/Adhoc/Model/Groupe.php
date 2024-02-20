<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Model\Reference\Style;
use Adhoc\Model\Reference\TypeMusicien;
use Adhoc\Model\Reference\GroupeStatus;
use Adhoc\Utils\Date;
use Adhoc\Utils\DataBase;
use Adhoc\Utils\ObjectModel;
use Adhoc\Utils\Tools;

/**
 * Classe Groupe
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class Groupe extends ObjectModel
{
    /**
     * États des groupes
     */
    public const ETAT_ACTIF   = 1;
    public const ETAT_NONEWS  = 2;
    public const ETAT_INACTIF = 3;

    /**
     * Tableau des états groupe
     *
     * @var array<int,string>
     */
    protected static $etats = [
        self::ETAT_ACTIF   => "Actif",
        self::ETAT_NONEWS  => "Pas de nouvelles",
        self::ETAT_INACTIF => "Inactif / Séparé",
    ];

    /**
     * @var string|array<string>
     */
    protected static string|array $pk = 'id_groupe';

    /**
     * @var string
     */
    protected static string $table = 'adhoc_groupe';

    /**
     * @var ?int
     */
    protected ?int $id_groupe = null;

    /**
     * @var ?string
     */
    protected ?string $alias = null;

    /**
     * @var ?string
     */
    protected ?string $name = null;

    /**
     * @var ?string
     */
    protected ?string $style = null;

    /**
     * @var ?string
     */
    protected ?string $influences = null;

    /**
     * @var ?string
     */
    protected ?string $lineup = null;

    /**
     * @var ?string
     */
    protected ?string $mini_text = null;

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
    protected ?string $myspace = null;

    /**
     * @var ?string (int 64 en vérité)
     */
    protected ?string $facebook_page_id = null;

    /**
     * @var ?string
     */
    protected ?string $twitter_id = null;

    /**
     * @var ?string
     */
    protected ?string $id_departement = null;

    /**
     * @var ?bool
     */
    protected ?bool $online = null;

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
    protected ?string $datdeb = null;

    /**
     * @var ?string
     */
    protected ?string $datfin = null;

    /**
     * @var ?string
     */
    protected ?string $comment = null;

    /**
     * @var ?int
     */
    protected ?int $etat = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
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
        'created_at'       => 'date',
        'modified_at'      => 'date',
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
    public static function getBaseUrl(): string
    {
        return MEDIA_URL . '/groupe';
    }

    /**
     * Retourne le chemin absolu des medias relatifs au groupe
     *
     * @return string
     */
    public static function getBasePath(): string
    {
        return MEDIA_PATH . '/groupe';
    }

    /**
     * Retourne l'id_groupe
     *
     * @return ?int
     */
    public function getIdGroupe(): ?int
    {
        return $this->id_groupe;
    }

    /**
     * Retourne l'alias
     *
     * @return ?string
     */
    public function getAlias(): ?string
    {
        return $this->alias;
    }

    /**
     * Retourne le nom du groupe
     *
     * @return ?string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Retourne le style du groupe (champ libre)
     *
     * @return ?string
     */
    public function getStyle(): ?string
    {
        return $this->style;
    }

    /**
     * Retourne les influences du groupe
     *
     * @return ?string
     */
    public function getInfluences(): ?string
    {
        return $this->influences;
    }

    /**
     * Retourne le lineup du groupe
     *
     * @return ?string
     */
    public function getLineup(): ?string
    {
        return $this->lineup;
    }

    /**
     * Retourne le mini texte de présentation
     *
     * @return ?string
     */
    public function getMiniText(): ?string
    {
        return $this->mini_text;
    }

    /**
     * Retourne le texte de présentation
     *
     * @return ?string
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * Retourne l'identificant de la page fan Facebook
     *
     * @return ?string (int 64bits réellement)
     */
    public function getFacebookPageId(): ?string
    {
        return $this->facebook_page_id;
    }

    /**
     * Retourne l'url de la page "fans" Facebook
     *
     * @return ?string
     */
    public function getFacebookPageUrl(): ?string
    {
        if ($this->getFacebookPageId()) {
            return 'https://www.facebook.com/pages/' . $this->alias . '/' . $this->facebook_page_id;
        }
        return null;
    }

    /**
     * Retourne l'identifiant twitter
     *
     * @return ?string
     */
    public function getTwitterId(): ?string
    {
        return $this->twitter_id;
    }

    /**
     * Retourne l'url du fil twitter
     *
     * @return ?string
     */
    public function getTwitterUrl(): ?string
    {
        if ($this->getTwitterId()) {
            return 'https://www.twitter.com/' . $this->twitter_id;
        }
        return null;
    }

    /**
     * Retourne l'url du site officiel
     *
     * @return ?string
     */
    public function getSite(): ?string
    {
        return $this->site;
    }

    /**
     * Retourne le département
     *
     * @return ?string
     */
    public function getIdDepartement(): ?string
    {
        return $this->id_departement;
    }

    /**
     * Retourne si un groupe doit être affiché
     *
     * @return ?bool
     */
    public function getOnline(): ?bool
    {
        return $this->online;
    }

    /**
     * Retourne la date d'inscription format YYYY-MM-DD HH:II:SS
     *
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
     * Retourne la date d'inscription sous forme de timestamp
     *
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
     * Retourne la date de modification de la fiche
     *
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
     * Retourne la date de modification de la fiche sous forme de timestamp
     *
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
     * Retourne la date de début d'activité
     *
     * @return ?string
     */
    public function getDatdeb(): ?string
    {
        if (!is_null($this->datdeb) && Date::isDateOk($this->datdeb)) {
            return $this->datdeb;
        }
        return null;
    }

    /**
     * Retourne la date de fin d'activité
     *
     * @return ?string
     */
    public function getDatfin(): ?string
    {
        if (!is_null($this->datfin) && Date::isDateOk($this->datfin)) {
            return $this->datfin;
        }
        return null;
    }

    /**
     * Retourne le "mot AD'HOC"
     *
     * @return ?string
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * Retourne l'état du groupe
     *
     * @return ?int
     */
    public function getEtat(): ?int
    {
        return $this->etat;
    }

    /**
     * Retourne le nom du groupe à partir de son id
     *
     * @param int $id_groupe id_groupe
     *
     * @return string
     */
    public static function getNameById(int $id_groupe): string
    {
        return Groupe::getInstance($id_groupe)->getName();
    }

    /**
     * Retourne l'url de la photo principale
     *
     * @return ?string
     */
    public function getPhoto(): ?string
    {
        if (file_exists(self::getBasePath() . '/p' . $this->getIdGroupe() . '.jpg')) {
            return self::getBaseUrl() . '/p' . $this->getIdGroupe() . '.jpg?ts=' . $this->getModifiedAtTs();
        }
        return null;
    }

    /**
     * Retourne l'url de la mini photo
     * (64x64)
     *
     * @return string
     */
    public function getMiniPhoto(): string
    {
        if (file_exists(self::getBasePath() . '/m' . $this->getId() . '.jpg')) {
            return self::getBaseUrl() . '/m' . $this->getId() . '.jpg?ts=' . $this->getModifiedAtTs();
        } else {
            // todo mini photo par défaut, dans une méthode statique
            return HOME_URL . '/img/note_adhoc_64.png';
        }
    }

    /**
     * Retourne l'url du logo
     * priorité png > gif > jpg
     *
     * @return ?string
     */
    public function getLogo(): ?string
    {
        if (file_exists(self::getBasePath() . '/l' . $this->getId() . '.png')) {
            return self::getBaseUrl() . '/l' . $this->getId() . '.png?ts=' . $this->getModifiedAtTs();
        } elseif (file_exists(self::getBasePath() . '/l' . $this->getId() . '.gif')) {
            return self::getBaseUrl() . '/l' . $this->getId() . '.gif?ts=' . $this->getModifiedAtTs();
        } elseif (file_exists(self::getBasePath() . '/l' . $this->getId() . '.jpg')) {
            return self::getBaseUrl() . '/l' . $this->getId() . '.jpg?ts=' . $this->getModifiedAtTs();
        }
        return null;
    }

    /**
     * Retourne l'url d'une fiche groupe
     *
     * @return string
     */
    public function getUrl(): string
    {
        return HOME_URL . '/' . $this->getAlias();
    }

    /**
     * @todo à mettre dans Tools::getFacebookShareUrl(string $url)
     *
     * @return string
     */
    public function getFacebookShareUrl(): string
    {
        return 'https://www.facebook.com/sharer.php?u=' . urlencode($this->getUrl());
    }

    /* fin getters */

    /* début setters */

    /**
     * @param string $alias alias
     *
     * @return static
     */
    public function setAlias(string $alias): static
    {
        if ($this->alias !== $alias) {
            $this->alias = $alias;
            $this->modified_fields['alias'] = true;
        }

        return $this;
    }

    /**
     * @param string $name nom
     *
     * @return static
     */
    public function setName(string $name): static
    {
        if ($this->name !== $name) {
            $this->name = $name;
            $this->modified_fields['name'] = true;
            $this->setAlias(Tools::genAlias($name));
        }

        return $this;
    }

    /**
     * @param string $style style libre
     *
     * @return static
     */
    public function setStyle(string $style): static
    {
        if ($this->style !== $style) {
            $this->style = $style;
            $this->modified_fields['style'] = true;
        }

        return $this;
    }

    /**
     * @param string $influences influences
     *
     * @return static
     */
    public function setInfluences(string $influences): static
    {
        if ($this->influences !== $influences) {
            $this->influences = $influences;
            $this->modified_fields['influences'] = true;
        }

        return $this;
    }

    /**
     * @param string $lineup lineup (formation)
     *
     * @return static
     */
    public function setLineup(string $lineup): static
    {
        if ($this->lineup !== $lineup) {
            $this->lineup = $lineup;
            $this->modified_fields['lineup'] = true;
        }

        return $this;
    }

    /**
     * @param string $mini_text mini texte
     *
     * @return static
     */
    public function setMiniText(string $mini_text): static
    {
        if ($this->mini_text !== $mini_text) {
            $this->mini_text = $mini_text;
            $this->modified_fields['mini_text'] = true;
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
     * @param ?string $site url du site
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
     * @param ?string $myspaceId myspaceId
     *
     * @return static
     */
    public function setMyspaceId(?string $myspaceId): static
    {
        $val = trim($myspaceId);
        $val = str_replace('http://', '', $val);
        $val = str_replace('www.myspace.com/', '', $val);

        if ($this->myspace !== $myspaceId) {
            $this->myspace = $myspaceId;
            $this->modified_fields['myspace'] = true;
        }

        return $this;
    }

    /**
     * @param ?string $facebook_page_id page facebook (int 64bits en fait)
     *
     * @return static
     */
    public function setFacebookPageId(?string $facebook_page_id): static
    {
        if ($this->facebook_page_id !== $facebook_page_id) {
            $this->facebook_page_id = $facebook_page_id;
            $this->modified_fields['facebook_page_id'] = true;
        }

        return $this;
    }

    /**
     * @param ?string $twitter_id twitter_id
     *
     * @return static
     */
    public function setTwitterId(?string $twitter_id): static
    {
        if ($this->twitter_id !== $twitter_id) {
            $this->twitter_id = $twitter_id;
            $this->modified_fields['twitter_id'] = true;
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
     * @param bool $online online
     *
     * @return static
     */
    public function setOnline(bool $online): static
    {
        if ($this->online !== $online) {
            $this->online = $online;
            $this->modified_fields['online'] = true;
        }

        return $this;
    }

    /**
     * @param ?string $created_at created_at
     *
     * @return static
     */
    public function setCreatedAt(?string $created_at): static
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
     * @param ?string $modified_at modified_at
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
     * @param ?string $datdeb date début
     *
     * @return static
     */
    public function setDatdeb(?string $datdeb): static
    {
        if ($this->datdeb !== $datdeb) {
            $this->datdeb = $datdeb;
            $this->modified_fields['datdeb'] = true;
        }

        return $this;
    }

    /**
     * @param ?string $datfin date fin
     *
     * @return static
     */
    public function setDatfin(?string $datfin): static
    {
        if ($this->datfin !== $datfin) {
            $this->datfin = $datfin;
            $this->modified_fields['datfin'] = true;
        }

        return $this;
    }

    /**
     * @param string $comment comment
     *
     * @return static
     */
    public function setComment(string $comment): static
    {
        if ($this->comment !== $comment) {
            $this->comment = $comment;
            $this->modified_fields['comment'] = true;
        }

        return $this;
    }

    /**
     * @param int $etat etat
     *
     * @return static
     */
    public function setEtat(int $etat): static
    {
        if ($this->etat !== $etat) {
            $this->etat = $etat;
            $this->modified_fields['etat'] = true;
        }

        return $this;
    }

    /* fin setters */

    /**
     * Retourne le nombre de mes groupes
     *
     * @return int
     */
    public static function countMy(): int
    {
        if (empty($_SESSION['membre'])) {
            throw new \Exception('non identifié');
        }

        $db = DataBase::getInstance();

        $sql = 'SELECT COUNT(*) '
             . 'FROM `' . self::$db_table_appartient_a . '` '
             . 'WHERE `id_contact` = ' . (int) $_SESSION['membre']->getId();

        return (int) $db->pdo->query($sql)->fetchColumn();
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
    public function delete(): bool
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
     * @throws \Exception
     */
    protected function loadFromDb(): bool
    {
        if (!parent::loadFromDb()) {
            throw new \Exception('id_groupe introuvable');
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
    public function linkMember(int $id_contact, int $id_type_musicien): bool
    {
        $db = DataBase::getInstance();

        $sql = 'INSERT INTO `' . self::$db_table_appartient_a . '` '
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
    public function updateMember(int $id_contact, int $id_type_musicien): bool
    {
        $db = DataBase::getInstance();

        $sql = 'UPDATE `' . self::$db_table_appartient_a . '` '
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
    public function unlinkMember(int $id_contact): bool
    {
        $db = DataBase::getInstance();

        $sql = 'DELETE FROM `' . self::$db_table_appartient_a . '` '
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
    public function unlinkMembers(): int
    {
        $db = DataBase::getInstance();

        $sql = 'DELETE FROM `' . self::$db_table_appartient_a . '` '
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
    public function isMember(int $id_contact): bool
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
     * @return array<Membre>
     */
    public function getMembers(): array
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
    public function hasMembers(): bool
    {
        return (bool) $this->getMembers();
    }

    /**
     * Retourne une collection d'objets "Groupe" répondant au(x) critère(s) donné(s)
     *
     * @param array<string,mixed> $params [
     *                                'id_contact' => int,
     *                                'id_event' => int,
     *                                'alias' => string,
     *                                'facebook_page_id' => string,
     *                                'online' => bool,
     *                                'order_by' => string,
     *                                'sort' => string,
     *                                'start' => int,
     *                                'limit' => int,
     *                            ]
     *
     * @return array<Groupe>
     */
    public static function find(array $params): array
    {
        $db = DataBase::getInstance();
        $objs = [];

        $sql = "SELECT `" . static::getDbPk() . "` FROM `" . static::getDbTable() . "` WHERE 1 ";

        if (isset($params['id_contact'])) {
            $subSql = "SELECT `id_groupe` FROM `adhoc_appartient_a` WHERE `id_contact` = " . (int) $params['id_contact'] . " ";
            if ($ids_groupe = $db->pdo->query($subSql)->fetchAll(\PDO::FETCH_COLUMN)) {
                $sql .= "AND `id_groupe` IN (" . implode(',', (array) $ids_groupe) . ") ";
            } else {
                return $objs;
            }
        }

        if (isset($params['id_event'])) {
            $subSql = "SELECT `id_groupe` FROM `adhoc_participe_a` WHERE `id_event` = " . (int) $params['id_event'] . " ";
            if ($ids_groupe = $db->pdo->query($subSql)->fetchAll(\PDO::FETCH_COLUMN)) {
                $sql .= "AND `id_groupe` IN (" . implode(',', (array) $ids_groupe) . ") ";
            } else {
                return $objs;
            }
        }

        if (isset($params['id_video'])) {
            $subSql = "SELECT `id_groupe` FROM `adhoc_video_groupe` WHERE `id_video` = " . (int) $params['id_video'] . " ";
            if ($ids_groupe = $db->pdo->query($subSql)->fetchAll(\PDO::FETCH_COLUMN)) {
                $sql .= "AND `id_groupe` IN (" . implode(',', (array) $ids_groupe) . ") ";
            } else {
                return $objs;
            }
        }

        if (isset($params['alias'])) {
            $sql .= "AND `alias` = '" . $params['alias'] . "' ";
        }

        if (!empty($params['search_name'])) {
            $sql .= "AND `name` LIKE '%" . $params['search_name'] . "%' ";
        }

        if (isset($params['facebook_page_id'])) {
            $sql .= "AND `facebook_page_id` = " . (int) $params['facebook_page_id'] . " ";
        }

        if (isset($params['online'])) {
            $sql .= "AND `online` = ";
            $sql .= $params['online'] ? "TRUE" : "FALSE";
            $sql .= " ";
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

        $ids= $db->pdo->query($sql)->fetchAll(\PDO::FETCH_COLUMN);
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
     * @return ?int
     */
    public static function getIdByAlias(string $alias): ?int
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
     * @return ?int
     */
    public static function getIdByFacebookPageId(int $facebook_page_id): ?int
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
    public function linkStyle(int $id_style): bool
    {
        $db = DataBase::getInstance();

        $sql = "INSERT INTO `" . self::$db_table_groupe_style . "` "
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
    public function unlinkStyle(int $id_style): bool
    {
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . self::$db_table_groupe_style . "` "
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
    public function unlinkStyles(): bool
    {
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . self::$db_table_groupe_style . "` "
             . "WHERE `id_groupe` = " . (int) $this->getIdGroupe();

        $db->query($sql);

        return (bool) $db->affectedRows();
    }

    /**
     * Retourne les styles du groupe
     *
     * @return array<Style>
     */
    public function getStyles(): array
    {
        return Style::find([
            'id_groupe' => $this->getIdGroupe(),
        ]);
    }

    /**
     * Le groupe est-il lié à des photos ?
     *
     * @return bool
     */
    public function hasPhotos(): bool
    {
        return (bool) $this->getPhotos();
    }

    /**
     * Retourne les photos associées à ce groupe
     *
     * @return array<Photo> ou false
     */
    public function getPhotos(): array
    {
        return Photo::find([
            'id_groupe' => $this->getIdGroupe(),
        ]);
    }

    /**
     * Délie toutes les photos d'un groupe
     *
     * @return int
     */
    public function unlinkPhotos()
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
    public function hasAudios(): bool
    {
        return (bool) $this->getAudios();
    }

    /**
     * Retourne les audios associés à ce groupe
     *
     * @return array<Audio>
     */
    public function getAudios(): array
    {
        return Audio::find([
            'id_groupe' => $this->getIdGroupe(),
        ]);
    }

    /**
     * Délie les audios d'un groupe
     *
     * @return int
     */
    public function unlinkAudios(): int
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
    public function hasVideos(): bool
    {
        return (bool) $this->getVideos();
    }

    /**
     * Retourne les vidéos associées à ce groupe
     *
     * @return array<Video>
     */
    public function getVideos(): array
    {
        return Video::find([
            'id_groupe' => $this->getIdGroupe(),
        ]);
    }

    /**
     * Délie les vidéos d'un groupe
     *
     * @return int
     */
    public function unlinkVideos()
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
    public function hasEvents(): bool
    {
        return (bool) $this->getEvents();
    }

    /**
     * Retourne les events associées à ce groupe
     *
     * @return array<Event>
     */
    public function getEvents(): array
    {
        return Event::find([
            'id_groupe' => $this->getIdGroupe(),
        ]);
    }

    /**
     * Délie les événements d'un groupe
     *
     * @return int
     */
    public function unlinkEvents(): int
    {
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . self::$db_table_participe_a . "` "
             . "WHERE `id_groupe` = " . (int) $this->getIdGroupe();

        $db->query($sql);

        return $db->affectedRows();
    }

    /**
     * Récupère les groupes ayant au moins un média (photo,audio,vidéo)
     *
     * @return array<mixed>
     */
    public static function getGroupesWithMedia(): array
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
