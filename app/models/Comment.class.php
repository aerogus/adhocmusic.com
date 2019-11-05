<?php declare(strict_types=1);

/**
 * Classe Comment
 *
 * Permet de générer un commentaire générique sur n'importe quelle entité
 * Video, Audio, Photo, Lieu, Event, Groupe, Membre
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Comment extends ObjectModel
{
    /**
     * @var object
     */
    protected static $_instance = null;

    /**
     * @var string
     */
    protected static $_pk = 'id_comment';

    /**
     * @var string
     */
    protected static $_table = 'adhoc_comment';

    /**
     * @var int
     */
    protected $_id_comment = 0;

    /**
     * @var string
     */
    protected $_type = '';

    /**
     * @var int
     */
    protected $_id_content = 0;

    /**
     * @var string
     */
    protected $_created_on = null;

    /**
     * @var string
     */
    protected $_modified_on = null;

    /**
     * @var bool
     */
    protected $_online = false;

    /**
     * @var int
     */
    protected $_id_contact = 0;

    /**
     * @var string
     */
    protected $_text = '';

    /**
     * @var string
     */
    protected $_pseudo = '';

    /**
     * @var string
     */
    protected $_pseudo_mbr = '';

    /**
     * @var string
     */
    protected $_email = '';

    /**
     * @var string
     */
    protected $_email_mbr = '';

    /**
     * Liste des attributs de l'objet
     * on précise si en base c'est de type :
     * - numérique/integer/float/bool (= num)
     * - datetime/text (= str)
     * ceci est utile pour la formation de la requête
     *
     * @var array
     */
    protected static $_all_fields = [
        'type'        => 'string',
        'id_content'  => 'int',
        'created_on'  => 'date',
        'modified_on' => 'date',
        'online'      => 'bool',
        'id_contact'  => 'int',
        'pseudo'      => 'string',
        'email'       => 'string',
        'text'        => 'string',
    ];

    protected static $_types = [
        'l' => 'lieux',
        'p' => 'photos',
        'v' => 'videos',
        's' => 'audios',
        'e' => 'events',
        'g' => 'groupes',
    ];

    /* début getters */

    /**
     * @return string
     */
    function getType(): string
    {
        return $this->_type;
    }

    /**
     * @return string
     */
    function getFullType(): string
    {
        return self::$_types[$this->_type];
    }

    /**
     * @return int
     */
    function getIdContent(): int
    {
        return $this->_id_content;
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
     * @return int
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
     * @return int
     */
    function getModifiedOnTs(): ?int
    {
        if (!is_null($this->_modified_on) && Date::isDateTimeOk($this->_modified_on)) {
            return strtotime($this->_modified_on);
        }
        return null;
    }

    /**
     * @return bool
     */
    function getOnline(): bool
    {
        return $this->_online;
    }

    /**
     * @return int
     */
    function getIdContact(): int
    {
        return $this->_id_contact;
    }

    /**
     * @return string
     */
    function getText(): string
    {
        return $this->_text;
    }

    /**
     * @return string
     */
    function getPseudoMbr(): string
    {
        return $this->_pseudo_mbr;
    }

    /**
     * @return string
     */
    function getPseudo(): string
    {
        return $this->getPseudoMbr() ? $this->getPseudoMbr() : $this->_pseudo;
    }

    /**
     * @return string
     */
    function getEmailMbr(): string
    {
        return $this->_email_mbr;
    }

    /**
     * @return string
     */
    function getEmail(): string
    {
        return $this->getEmailMbr() ? $this->getEmailMbr() : $this->_email;
    }

    /**
     * @return string
     */
    function getUrl(): string
    {
        return self::getUrlById($this->getId());
    }

    /**
     * @param int $id_comment id_comment
     *
     * @return string
     */
    static function getUrlById(int $id_comment): string
    {
        return HOME_URL . '/comments/' . (string) $id_comment;
    }

    /* fin getters */

    /* début setters */

    /**
     * @param string $type type
     *
     * @return object
     */
    function setType(string $type): object
    {
        $type = trim($type);

        if ($this->_type !== $type) {
            $this->_type = $type;
            $this->_modified_fields['type'] = true;
        }

        return $this;
    }

    /**
     * @param int $id_content id_content
     *
     * @return object
     */
    function setIdContent(int $id_content): object
    {
        if ($this->_id_content !== $id_content) {
            $this->_id_content = $id_content;
            $this->_modified_fields['id_content'] = true;
        }

        return $this;
    }

    /**
     * @param string $created_on created_on
     *
     * @return object
     */
    function setCreatedOn(string $created_on): object
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
     * @param string $modified_on modified_on
     *
     * @return object
     */
    function setModifiedOn(string $modified_on): object
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
     * @param int $id_contact id_contact
     *
     * @return object
     */
    function setIdContact(int $id_contact): object
    {
        if ($this->_id_contact !== $id_contact) {
            $this->_id_contact = $id_contact;
            $this->_modified_fields['id_contact'] = true;
        }

        return $this;
    }

    /**
     * @param string $pseudo pseudo
     *
     * @return object
     */
    function setPseudo(string $pseudo): object
    {
        $pseudo = trim($pseudo);

        if ($this->_pseudo !== $pseudo) {
            $this->_pseudo = $pseudo;
            $this->_modified_fields['pseudo'] = true;
        }

        return $this;
    }

    /**
     * @param string $email email
     *
     * @return object
     */
    function setEmail(string $email): object
    {
        $email = trim($email);

        if ($this->_email !== $email) {
            $this->_email = $email;
            $this->_modified_fields['email'] = true;
        }

        return $this;
    }

    /**
     * @param string $text text
     *
     * @return object
     */
    function setText(string $text): object
    {
        $text = trim($text);

        if ($this->_text !== $text) {
            $this->_text = $text;
            $this->_modified_fields['text'] = true;
        }

        return $this;
    }

    /* fin setters */

    /**
     * @return bool
     * @throws Exception
     */
    protected function _loadFromDb(): bool
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `com`.`type`, `com`.`id_content`, `com`.`created_on`, `com`.`modified_on`, "
             . "`com`.`online`, `com`.`id_contact`, `com`.`pseudo`, `com`.`text`, `mbr`.`pseudo` AS `pseudo_mbr`, "
             . "`com`.`email`, `cnt`.`email` AS `email_mbr` "
             . "FROM `" . Comment::getDbTable() . "` `com` "
             . "LEFT JOIN `" . Membre::getDbTable() . "` `mbr` ON (`com`.`id_contact` = `mbr`.`id_contact`) "
             . "LEFT JOIN `" . Contact::getDbTable() . "` `cnt` ON (`mbr`.`id_contact` = `cnt`.`id_contact`) "
             . "WHERE `" . self::$_pk . "` = " . (int) $this->getId();

        if ($res = $db->queryWithFetchFirstRow($sql)) {
            $this->_arrayToObject($res);
            $this->_pseudo_mbr = $res['pseudo_mbr'];
            $this->_email_mbr  = $res['email_mbr'];
            return true;
        }

        throw new Exception('id_comment introuvable');
    }

    /**
     * @param array $params params
     *
     * @return array
     */
    static function getComments(array $params = [])
    {
        $debut = 0;
        if (isset($params['debut'])) {
            $debut = (int) $params['debut'];
        }

        $limit = null;
        if (isset($params['limit'])) {
            $limit = (int) $params['limit'];
        }

        $tab_type = [];
        if (array_key_exists('type', $params)) {
            $tab_type = explode(",", $params['type']);
        }

        $sens = 'ASC';
        if (isset($params['sens']) && $params['sens'] === 'DESC') {
            $sens = 'DESC';
        }

        $sort = 'id_comment';
        if (isset($params['sort'])
            && ($params['sort'] === 'created_on' || $params['sort'] === 'online')
        ) {
            $sort = $params['sort'];
        }

        $db = DataBase::getInstance();

        $sql = "SELECT `com`.`id_comment` AS `id`, `com`.`type`, `com`.`id_content`, `com`.`created_on`, `com`.`modified_on`, `com`.`online`, "
             . "`com`.`id_contact`, `mbr`.`pseudo` AS `pseudo_mbr`, `com`.`pseudo`, `com`.`email`, `com`.`text`, `cnt`.`email` AS `email_mbr` "
             . "FROM `" . Comment::getDbTable() . "` `com` "
             . "LEFT JOIN `" . Membre::getDbTable() . "` `mbr` ON (`com`.`id_contact` = `mbr`.`id_contact`) "
             . "LEFT JOIN `" . Contact::getDbTable() . "` `cnt` ON (`mbr`.`id_contact` = `cnt`.`id_contact`) "
             . "WHERE 1 ";

        if (count($tab_type) && ($tab_type[0] != '')) {
            $sql .= "AND `com`.`type` IN ('" . implode("','", $tab_type) . "') ";
        }

        if (array_key_exists('id_contact', $params)) {
            $sql .= "AND `com`.`id_contact` = " . (int) $params['id_contact'] . " ";
        }
        if (array_key_exists('id_content', $params)) {
            $sql .= "AND `com`.`id_content` = " . (int) $params['id_content'] . " ";
        }
        if (array_key_exists('online', $params)) {
            if ($params['online']) {
                $online = 'TRUE';
            } else {
                $online = 'FALSE';
            }
            $sql .= "AND `com`.`online` = " . $online . " ";
        }

        $sql .= "ORDER BY ";
        if ($sort === "random") {
            $sql .= "RAND(" . time() . ") ";
        } else {
            $sql .= "`com`.`" . $sort . "` " . $sens . " ";
        }

        if (!is_null($limit)) {
            $sql .= "LIMIT " . $debut . ", " . $limit;
        }

        $res = $db->queryWithFetch($sql);

        foreach ($res as $idx => $row) {
            $res[$idx]['url'] = self::getUrlById((int) $row['id']);
            $res[$idx]['type_full'] = self::$_types[$row['type']];
        }

        if ($limit === 1) {
            $res = array_pop($res);
        }

        return $res;
    }

    /**
     * Envoie les notifications par mail aux personnes liées au contenu commenté
     */
    function sendNotifs()
    {
        $emails  = [];
        $subject = "Un nouveau commentaire a été posté ";
        $title   = '';
        $url     = 'https://www.adhocmusic.com';

        switch ($this->getType())
        {
            case 's': // audio
                // -> uploadeur de l'audio
                $audio = Audio::getInstance($this->getIdContent());
                $subject .= " sur la chanson " . $audio->getName();
                $title = $audio->getName();
                $url = $audio->getUrl();
                $membre = Membre::getInstance($audio->getIdContact());
                $emails[] = $membre->getEmail();

                // -> si lien avec groupe, contacts des groupes
                if ($audio->getIdGroupe()) {
                    $groupe = Groupe::getInstance($audio->getIdGroupe());
                    $membres = $groupe->getMembers();
                    foreach ($membres as $membre) {
                        $emails[] = $membre['email'];
                    }
                }
                break;

            case 'v': // vidéo
                // -> uploadeur de la vidéo
                $video = Video::getInstance($this->getIdContent());
                $subject .= " sur la vidéo " . $video->getName();
                $title = $video->getName();
                $url = $video->getUrl();
                $membre = Membre::getInstance($video->getIdContact());
                $emails[] = $membre->getEmail();

                // -> si lien avec groupe, contacts des groupes
                if ($video->getIdGroupe()) {
                    $groupe = Groupe::getInstance($video->getIdGroupe());
                    $membres = $groupe->getMembers();
                    foreach ($membres as $membre) {
                        $emails[] = $membre['email'];
                    }
                }
                break;

            case 'l': // lieu
                $lieu = Lieu::getInstance($this->getIdContent());
                $subject .= " sur le lieu " . $lieu->getName();
                $title = $lieu->getName();
                $url = $lieu->getUrl();

                // -> gens abonnés au lieu
                $ids_contact = Alerting::getIdsContactByLieu($lieu->getId());
                foreach ($ids_contact as $id_contact) {
                    $membre = Membre::getInstance($id_contact);
                    $emails[] = $membre->getEmail();
                }

                // -> email contact du lieu
                if ($lieu->getEmail()) {
                    $emails[] = $lieu->getEmail();
                }
                break;

            case 'p': // photo
                $photo = Photo::getInstance($this->getIdContent());
                $subject .= " sur la photo " . $photo->getName();
                $title = $photo->getName();
                $url = $photo->getUrl();

                // -> si lien avec événement, gens ayant dans leur agenda perso cette date
                if ($photo->getIdEvent()) {
                    $subs = Alerting::getIdsContactByEvent($photo->getIdEvent());
                    foreach ($subs as $sub) {
                        $membre = Membre::getInstance($sub['id_contact']);
                        $emails[] = $membre->getEmail();
                    }
                }

                // -> uploadeur de la photo
                $membre = Membre::getInstance($photo->getIdContact());
                $emails[] = $membre->getEmail();

                // -> si lien avec groupe, contacts des groupes
                if ($photo->getIdGroupe()) {
                    $groupe = Groupe::getInstance($photo->getIdGroupe());
                    $membres = $groupe->getMembers();
                    foreach ($membres as $membre) {
                        $emails[] = $membre['email'];
                    }
                }
                break;

            case 'e': // event
                $event = Event::getInstance($this->getIdContent());
                $subject .= " sur l'événement " . $event->getName();
                $title = $event->getName();
                $url = $event->getUrl();

                // -> personnes abonnés à l'événement
                $ids_contact = Alerting::getIdsContactByEvent($event->getId());
                foreach ($ids_contact as $id_contact) {
                    $membre = Membre::getInstance($id_contact);
                    $emails[] = $membre->getEmail();
                }

                // -> si lien avec groupes, contacts des groupes
                $grps = $event->getGroupes();
                if (is_array($grps)) {
                    foreach ($grps as $grp) {
                        $groupe = Groupe::getInstance($grp['id']);
                        $membres = $groupe->getMembers();
                        foreach ($membres as $membre) {
                            $emails[] = $membre['email'];
                        }
                    }
                }

                // -> créateur de l'événement
                $membre = Membre::getInstance($event->getIdContact());
                $emails[] = $membre->getEmail();

                // -> email contact du lieu
                $lieu = Lieu::getInstance($event->getIdLieu());
                if ($lieu->getEmail()) {
                    $emails[] = $lieu->getEmail();
                }
                break;
        }

        $comments = Comment::getComments(
            [
                'type'       => $this->getType(),
                'id_content' => $this->getIdContent(),
                'sort'       => 'created_on',
                'sens'       => 'ASC',
                'online'     => true,
            ]
        );

        // -> gens ayant déjà posté sur ce contenu
        foreach ($comments as $comment) {
            if ($comment['id_contact']) {
                $emails[] = $comment['email_mbr'];
            } elseif ($comment['email']) {
                $emails[] = $comment['email'];
            }
        }

        $emails = array_unique($emails);

        foreach ($emails as $email) {
            if ($email === 'guillaume@seznec.fr') {
                if (Email::validate($email)) {
                    Email::send(
                        $email,
                        $subject,
                        'new-commentaire',
                        [
                           'subject' => $subject,
                           'title'   => $title,
                           'pseudo'  => $this->getPseudo(),
                           'date'    => date('Y-m-d H:i:s'),
                           'url'     => $url,
                           'text'    => $this->getText(),
                        ]
                    );
                }
            }
        }
    }
}
