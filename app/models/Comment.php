<?php

declare(strict_types=1);

namespace Adhoc\Model;

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
     * Instance de l'objet
     *
     * @var object
     */
    protected static $_instance = null;

    /**
     * @var string
     */
    protected static string $_pk = 'id_comment';

    /**
     * @var string
     */
    protected static string $_table = 'adhoc_comment';

    /**
     * @var int
     */
    protected int $_id_comment = 0;

    /**
     * @var string
     */
    protected string $_type = '';

    /**
     * @var int
     */
    protected int $_id_content = 0;

    /**
     * @var ?string
     */
    protected ?string $_created_at = null;

    /**
     * @var ?string
     */
    protected ?string $_modified_at = null;

    /**
     * @var bool
     */
    protected bool $_online = false;

    /**
     * @var int
     */
    protected int $_id_contact = 0;

    /**
     * @var string
     */
    protected string $_text = '';

    /**
     * @var string
     */
    protected string $_pseudo = '';

    /**
     * @var string
     */
    protected string $_pseudo_mbr = '';

    /**
     * @var string
     */
    protected string $_email = '';

    /**
     * @var string
     */
    protected string $_email_mbr = '';

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static $_all_fields = [
        'id_comment'  => 'int', // pk
        'type'        => 'string',
        'id_content'  => 'int',
        'created_at'  => 'date',
        'modified_at' => 'date',
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
    public function getType(): string
    {
        return $this->_type;
    }

    /**
     * @return string
     */
    public function getFullType(): string
    {
        return self::$_types[$this->_type];
    }

    /**
     * @return int
     */
    public function getIdContent(): int
    {
        return $this->_id_content;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        if (!is_null($this->_created_at) && Date::isDateTimeOk($this->_created_at)) {
            return $this->_created_at;
        }
        return null;
    }

    /**
     * @return int
     */
    public function getCreatedAtTs(): ?int
    {
        if (!is_null($this->_created_at) && Date::isDateTimeOk($this->_created_at)) {
            return strtotime($this->_created_at);
        }
        return null;
    }

    /**
     * @return string|null
     */
    public function getModifiedAt(): ?string
    {
        if (!is_null($this->_modified_at) && Date::isDateTimeOk($this->_modified_at)) {
            return $this->_modified_at;
        }
        return null;
    }

    /**
     * @return int
     */
    public function getModifiedAtTs(): ?int
    {
        if (!is_null($this->_modified_at) && Date::isDateTimeOk($this->_modified_at)) {
            return strtotime($this->_modified_at);
        }
        return null;
    }

    /**
     * @return bool
     */
    public function getOnline(): bool
    {
        return $this->_online;
    }

    /**
     * @return int
     */
    public function getIdContact(): int
    {
        return $this->_id_contact;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->_text;
    }

    /**
     * @return string
     */
    public function getPseudoMbr(): string
    {
        return $this->_pseudo_mbr;
    }

    /**
     * @return string
     */
    public function getPseudo(): string
    {
        return $this->getPseudoMbr() ? $this->getPseudoMbr() : $this->_pseudo;
    }

    /**
     * @return string
     */
    public function getEmailMbr(): string
    {
        return $this->_email_mbr;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->getEmailMbr() ? $this->getEmailMbr() : $this->_email;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return HOME_URL . '/comments/' . $this->getId();
    }

    /* fin getters */

    /* début setters */

    /**
     * @param string $type type
     *
     * @return object
     */
    public function setType(string $type): object
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
    public function setIdContent(int $id_content): object
    {
        if ($this->_id_content !== $id_content) {
            $this->_id_content = $id_content;
            $this->_modified_fields['id_content'] = true;
        }

        return $this;
    }

    /**
     * @param string $created_at created_at
     *
     * @return object
     */
    public function setCreatedAt(string $created_at): object
    {
        if ($this->_created_at !== $created_at) {
            $this->_created_at = $created_at;
            $this->_modified_fields['created_at'] = true;
        }

        return $this;
    }

    /**
     * @return object
     */
    public function setCreatedNow(): object
    {
        $now = date('Y-m-d H:i:s');

        if ($this->_created_at !== $now) {
            $this->_created_at = $now;
            $this->_modified_fields['created_at'] = true;
        }

        return $this;
    }

    /**
     * @param string $modified_at modified_at
     *
     * @return object
     */
    public function setModifiedAt(string $modified_at): object
    {
        if ($this->_modified_at !== $modified_at) {
            $this->_modified_at = $modified_at;
            $this->_modified_fields['modified_at'] = true;
        }

        return $this;
    }

    /**
     * @return object
     */
    public function setModifiedNow(): object
    {
        $now = date('Y-m-d H:i:s');

        if ($this->_modified_at !== $now) {
            $this->_modified_at = $now;
            $this->_modified_fields['modified_at'] = true;
        }

        return $this;
    }

    /**
     * @param bool $online online
     *
     * @return object
     */
    public function setOnline(bool $online): object
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
    public function setIdContact(int $id_contact): object
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
    public function setPseudo(string $pseudo): object
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
    public function setEmail(string $email): object
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
    public function setText(string $text): object
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
    protected function loadFromDb(): bool
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `com`.`type`, `com`.`id_content`, `com`.`created_at`, `com`.`modified_at`, "
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
     * Envoie les notifications par mail aux personnes liées au contenu commenté
     */
    public function sendNotifs()
    {
        $emails  = [];
        $subject = "Un nouveau commentaire a été posté ";
        $title   = '';
        $url     = 'https://www.adhocmusic.com';

        switch ($this->getType()) {
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
                /*
                $ids_contact = Alerting::getIdsContactByLieu($lieu->getId());
                foreach ($ids_contact as $id_contact) {
                    $membre = Membre::getInstance($id_contact);
                    $emails[] = $membre->getEmail();
                }
                */

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
                    /*
                    $subs = Alerting::getIdsContactByEvent($photo->getIdEvent());
                    foreach ($subs as $sub) {
                        $membre = Membre::getInstance($sub['id_contact']);
                        $emails[] = $membre->getEmail();
                    }
                    */
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
                /*
                $ids_contact = Alerting::getIdsContactByEvent($event->getId());
                foreach ($ids_contact as $id_contact) {
                    $membre = Membre::getInstance($id_contact);
                    $emails[] = $membre->getEmail();
                }
                */

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

        $comments = Comment::getComments( // TODO: utiliser self::find() ?? l'implémenter ??
            [
                'type'       => $this->getType(),
                'id_content' => $this->getIdContent(),
                'sort'       => 'created_at',
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
