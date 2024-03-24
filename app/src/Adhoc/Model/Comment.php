<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Utils\Date;
use Adhoc\Utils\DataBase;
use Adhoc\Utils\Email;
use Adhoc\Utils\ObjectModel;

/**
 * Classe Comment
 *
 * Permet de générer un commentaire générique sur n'importe quelle entité
 * Video, Audio, Photo, Lieu, Event, Groupe, Membre
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class Comment extends ObjectModel
{
    /**
     * @var string|array<string>
     */
    protected static string|array $pk = 'id_comment';

    /**
     * @var string
     */
    protected static string $table = 'adhoc_comment';

    /**
     * @var ?int
     */
    protected ?int $id_comment = null;

    /**
     * @var ?string
     */
    protected ?string $type = null;

    /**
     * @var ?int
     */
    protected ?int $id_content = null;

    /**
     * @var ?string
     */
    protected ?string $created_at = null;

    /**
     * @var ?string
     */
    protected ?string $modified_at = null;

    /**
     * @var ?bool
     */
    protected ?bool $online = null;

    /**
     * @var ?int
     */
    protected ?int $id_contact = null;

    /**
     * @var ?string
     */
    protected ?string $text = null;

    /**
     * @var ?string
     */
    protected ?string $pseudo = null;

    /**
     * @var ?string
     */
    protected ?string $pseudo_mbr = null;

    /**
     * @var ?string
     */
    protected ?string $email = null;

    /**
     * @var ?string
     */
    protected ?string $email_mbr = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
        'id_comment' => 'int', // pk
        'type' => 'string',
        'id_content' => 'int',
        'created_at' => 'date',
        'modified_at' => 'date',
        'online' => 'bool',
        'id_contact' => 'int',
        'pseudo' => 'string',
        'email' => 'string',
        'text' => 'string',
    ];

    /**
     * @var array<string,string>
     */
    protected static array $types = [
        'l' => 'lieux',
        'p' => 'photos',
        'v' => 'videos',
        's' => 'audios',
        'e' => 'events',
        'g' => 'groupes',
    ];

    /* début getters */

    /**
     * @return ?int
     */
    public function getIdComment(): ?int
    {
        return $this->id_comment;
    }

    /**
     * @return ?string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return ?string
     */
    public function getFullType(): ?string
    {
        if (is_null($this->getType())) {
            return null;
        } elseif (!array_key_exists($this->getType(), self::$types)) {
            return null;
        }
        return self::$types[$this->type];
    }

    /**
     * @return ?int
     */
    public function getIdContent(): ?int
    {
        return $this->id_content;
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
     * @return ?bool
     */
    public function getOnline(): ?bool
    {
        return $this->online;
    }

    /**
     * @return ?int
     */
    public function getIdContact(): ?int
    {
        return $this->id_contact;
    }

    /**
     * @return ?string
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @return ?string
     */
    public function getPseudoMbr(): ?string
    {
        return $this->pseudo_mbr;
    }

    /**
     * @return string
     */
    public function getPseudo(): string
    {
        return $this->getPseudoMbr() ? $this->getPseudoMbr() : $this->pseudo;
    }

    /**
     * @return ?string
     */
    public function getEmailMbr(): ?string
    {
        return $this->email_mbr;
    }

    /**
     * @return ?string
     */
    public function getEmail(): ?string
    {
        return $this->getEmailMbr() ? $this->getEmailMbr() : $this->email;
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
     * @param int $id_comment id_comment
     *
     * @return static
     */
    public function setIdComment(int $id_comment): static
    {
        if ($this->id_comment !== $id_comment) {
            $this->id_comment = $id_comment;
            $this->modified_fields['id_comment'] = true;
        }

        return $this;
    }

    /**
     * @param string $type type
     *
     * @return static
     */
    public function setType(string $type): static
    {
        if ($this->type !== $type) {
            $this->type = $type;
            $this->modified_fields['type'] = true;
        }

        return $this;
    }

    /**
     * @param int $id_content id_content
     *
     * @return static
     */
    public function setIdContent(int $id_content): static
    {
        if ($this->id_content !== $id_content) {
            $this->id_content = $id_content;
            $this->modified_fields['id_content'] = true;
        }

        return $this;
    }

    /**
     * @param string $created_at created_at
     *
     * @return static
     */
    public function setCreatedAt(string $created_at): static
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
     * @param string $modified_at modified_at
     *
     * @return static
     */
    public function setModifiedAt(string $modified_at): static
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
     * @param ?int $id_contact id_contact
     *
     * @return static
     */
    public function setIdContact(?int $id_contact): static
    {
        if ($this->id_contact !== $id_contact) {
            $this->id_contact = $id_contact;
            $this->modified_fields['id_contact'] = true;
        }

        return $this;
    }

    /**
     * @param string $pseudo pseudo
     *
     * @return static
     */
    public function setPseudo(string $pseudo): static
    {
        $pseudo = trim($pseudo);

        if ($this->pseudo !== $pseudo) {
            $this->pseudo = $pseudo;
            $this->modified_fields['pseudo'] = true;
        }

        return $this;
    }

    /**
     * @param ?string $email email
     *
     * @return static
     */
    public function setEmail(?string $email): static
    {
        $email = is_string($email) ? trim($email) : $email;

        if ($this->email !== $email) {
            $this->email = $email;
            $this->modified_fields['email'] = true;
        }

        return $this;
    }

    /**
     * @param string $text text
     *
     * @return static
     */
    public function setText(string $text): static
    {
        $text = trim($text);

        if ($this->text !== $text) {
            $this->text = $text;
            $this->modified_fields['text'] = true;
        }

        return $this;
    }

    /* fin setters */

    /**
     * @return bool
     * @throws \Exception
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
             . "WHERE `" . self::$pk . "` = " . (int) $this->getId();

        $stmt = $db->pdo->query($sql);
        if ($res = $stmt->fetch()) {
            $this->arrayToObject($res);
            $this->pseudo_mbr = $res['pseudo_mbr'];
            $this->email_mbr  = $res['email_mbr'];
            return true;
        }

        throw new \Exception('id_comment introuvable');
    }

    /**
     * Envoie les notifications par mail aux personnes liées au contenu commenté
     *
     * @return void
     */
    public function sendNotifs(): void
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
                $emails[] = $membre->getContact()->getEmail();

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
                $emails[] = $membre->getContact()->getEmail();

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
                    $emails[] = $membre->getContact()->getEmail();
                }
                */
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
                        $emails[] = $membre->getContact()->getEmail();
                    }
                    */
                }

                // -> uploadeur de la photo
                $membre = Membre::getInstance($photo->getIdContact());
                $emails[] = $membre->getContact()->getEmail();

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
                    $emails[] = $membre->getContact()->getEmail();
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
                $emails[] = $membre->getContact()->getEmail();
                break;
        }

        $comments = Comment::find([
            'type'       => $this->getType(),
            'id_content' => $this->getIdContent(),
            'online'     => true,
            'order_by'   => 'created_at',
            'sort'       => 'ASC',
        ]);

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
