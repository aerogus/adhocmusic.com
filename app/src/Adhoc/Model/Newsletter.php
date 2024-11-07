<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Utils\DataBase;
use Adhoc\Utils\ObjectModel;

define('NEWSLETTER_SUB_KO_ALREADY_SUBSCRIBED_MEMBER', 0x11);
define('NEWSLETTER_SUB_OK_RESUBSCRIBED_MEMBER', 0x12);
define('NEWSLETTER_SUB_KO_ALREADY_CONTACT', 0x13);
define('NEWSLETTER_SUB_OK_CONTACT_CREATED', 0x14);
define('NEWSLETTER_UNSUB_OK_UNSUBSCRIBED_MEMBER', 0x21);
define('NEWSLETTER_UNSUB_KO_ALREADY_UNSUBSCRIBED_MEMBER', 0x22);
define('NEWSLETTER_UNSUB_OK_CONTACT_DELETED', 0x23);
define('NEWSLETTER_UNSUB_KO_UNKNOWN_CONTACT', 0x24);

define('NEWSLETTER_TEMPLATE_PATH', ADHOC_ROOT_PATH . '/app/views/emails');

/**
 * Classe de gestion de la newsletter AD'HOC
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class Newsletter extends ObjectModel
{
    /**
     * @var array<string>
     */
    protected static array $pk = [
        'id_newsletter',
    ];

    /**
     * @var string
     */
    protected static string $table = 'adhoc_newsletter';

    /**
     * @var ?int
     */
    protected ?int $id_newsletter;

    /**
     * @var ?string
     */
    protected ?string $title;

    /**
     * @var ?string
     */
    protected ?string $content;

    /**
     * @var ?string
     */
    protected ?string $html;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
        'id_newsletter' => 'int', // pk
        'title' => 'string',
        'content' => 'string',
        'html' => 'string',
    ];

    /**
     * @var int
     */
    protected int $id_contact = 0;

    /**
     * @var array<string,mixed>
     */
    protected array $tpl_vars = [];

    /**
     * @return string
     */
    public static function getBaseUrl(): string
    {
        return MEDIA_URL . '/newsletter';
    }

    /**
     * @return string
     */
    public static function getBasePath(): string
    {
        return MEDIA_PATH . '/newsletter';
    }

    /**
     * Retourne l'identifiant de la newsletter
     *
     * @return ?int
     */
    public function getIdNewsletter(): ?int
    {
        return $this->id_newsletter;
    }

    /**
     * @return string
     */
    public function getFileUrl(): string
    {
        return self::getBaseUrl() . '/' . (string) $this->getIdNewsletter();
    }

    /**
     * @return string
     */
    public function getFilePath(): string
    {
        return self::getBasePath() . '/' . (string) $this->getIdNewsletter();
    }

    /**
     * Retourne le contenu source MJML
     *
     * @return ?string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Retourne le contenu compilé en HTML
     *
     * @return string
     */
    public function getHtml(): ?string
    {
        return $this->html;
    }

    /**
     * Retourne le contenu après être passé à la moulinette
     * des variables de templates et des liens de tracking
     *
     * @return string
     */
    public function getProcessedHtml(): string
    {
        $html = $this->getHtml();

        // set des variables de templates
        $html = str_replace(
            array_keys($this->tpl_vars),
            array_values($this->tpl_vars),
            $html
        );

        // A DEBUGGUER

        /*
        // extraction des liens href
        $res = preg_match_all('/<a\shref="([^"]*)"/U', $html, $urls);

        // formation des liens de tracking
        $tracking_links = [];
        foreach ($urls[1] as $url) {
            $link  = 'https://www.adhocmusic.com/r/';
            $link .= Tools::base64_url_encode($url);
            $link .= '||';
            $link .= Tools::base64_url_encode($this->getIdNewsletter() . '|' . $this->getIdContact());
            $tracking_links[$url] = $link;
        }

        $html = str_replace(
            array_keys($tracking_links),
            array_values($tracking_links),
            $html
        );
        */

        return $html;
    }

    /**
     * Retourne l'id_contact courant
     *
     * @return int
     */
    public function getIdContact(): int
    {
        return $this->id_contact;
    }

    /**
     * Set l'id_contact courant
     *
     * @param int $id_contact id_contact
     *
     * @return static
     */
    public function setIdContact(int $id_contact): static
    {
        $this->id_contact = $id_contact;

        return $this;
    }

    /**
     * Set une variable de template
     *
     * @param string $key clé
     * @param string $val valeur
     *
     * @return static
     */
    public function setTplVar($key, $val): static
    {
        $this->tpl_vars[$key] = $val;

        return $this;
    }

    /**
     * Set le champ body, html (partie variable de la lettre)
     *
     * @param string $html HTML
     *
     * @return static
     */
    public function setHtml(string $html): static
    {
        if ($this->html !== $html) {
            $this->html = $html;
            $this->modified_fields['html'] = true;
        }

        return $this;
    }

    /**
     * Set le champ body, html (partie variable de la lettre)
     *
     * @param string $content contenu source MJML
     *
     * @return static
     */
    public function setContent(string $content): static
    {
        if ($this->content !== $content) {
            $this->content = $content;
            $this->modified_fields['content'] = true;
        }

        return $this;
    }

    /**
     * Retourne l'url de visualisation de la newsletter courante
     *
     * @return string
     */
    public function getUrl(): string
    {
        return HOME_URL . '/newsletters/' . $this->getIdNewsletter();
    }

    /**
     * Retourne le title de la lettre (= sujet du mail)
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set le title de la lettre (= sujet du mail)
     *
     * @param string $title title
     *
     * @return static
     */
    public function setTitle(string $title): static
    {
        if ($this->title !== $title) {
            $this->title = $title;
            $this->modified_fields['title'] = true;
        }

        return $this;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    protected function loadFromDb(): bool
    {
        if (!parent::loadFromDb()) {
            throw new \Exception('newsletter introuvable');
        }

        return true;
    }

    /**
     * Retourne une collection d'objets "Newsletter" répondant au(x) critère(s)
     *
     * @param array<string,mixed> $params ['order_by' => string, 'sort' => string]
     *
     * @return array<static>
     */
    public static function find(array $params): array
    {
        $db = DataBase::getInstance();
        $objs = [];

        $sql  = "SELECT ";

        $pks = array_map(
            function ($item) {
                return '`' . $item . '`';
            },
            static::getDbPk()
        );
        $sql .= implode(', ', $pks) . ' ';

        $sql .= "FROM `" . Newsletter::getDbTable() . "` ";
        $sql .= "WHERE 1 ";

        if ((isset($params['order_by']) && (in_array($params['order_by'], array_keys(static::$all_fields), true)))) {
            $sql .= "ORDER BY `" . $params['order_by'] . "` ";
        } else {
            $sql .= "ORDER BY `" . static::$pk . "` ";
        }

        if ((isset($params['sort']) && (in_array($params['sort'], ['ASC', 'DESC'], true)))) {
            $sql .= $params['sort'];
        } else {
            $sql .= "ASC";
        }

        $ids_newsletter = $db->pdo->query($sql)->fetchAll(\PDO::FETCH_COLUMN);
        foreach ($ids_newsletter as $id_newsletter) {
            $objs[] = static::getInstance((int) $id_newsletter);
        }

        return $objs;
    }

    /**
     * Retourne les abonnés actifs à la newsletter
     *
     * @param int $debut début
     * @param int $limit limite
     *
     * @return array<mixed>
     */
    public static function getSubscribers(int $debut = 0, int $limit = 10000): array
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `c`.`id_contact`, `c`.`email`, `m`.`mailing`, `m`.`pseudo` "
             . "FROM (`" . Contact::getDbTable() . "` `c`) "
             . "LEFT JOIN `" . Membre::getDbTable() . "` `m` ON (`m`.`id_contact` = `c`.`id_contact`) "
             . "WHERE ((`m`.`mailing` IS NULL) OR (`m`.`mailing` = 1)) "
             . "ORDER BY `c`.`id_contact` ASC "
             . "LIMIT " . $debut . ", " . $limit;

        return $db->pdo->query($sql)->fetchAll();
    }

    /**
     * Compte le nombre total d'abonnés actifs à la newsletter
     *
     * @return int
     */
    public static function getSubscribersCount()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(`c`.`id_contact`) "
             . "FROM (`" . Contact::getDbTable() . "` `c`) "
             . "LEFT JOIN `" . Membre::getDbTable() . "` `m` ON (`m`.`id_contact` = `c`.`id_contact`) "
             . "WHERE (`m`.`mailing` IS NULL) OR (`m`.`mailing` = 1) ";

        return (int) $db->pdo->query($sql)->fetchColumn();
    }

    /**
     * Ajout d'un email à la newsletter
     *
     * @param string $email email
     *
     * @todo doublon avec script subscribe-email ?
     *
     * @return int
     */
    public static function addEmail(string $email)
    {
        if (($id_contact = Contact::getIdByEmail($email)) !== false) {
            // contact ? oui
            if (($pseudo = Membre::getPseudoById($id_contact)) !== false) {
                // "membre ? oui
                $membre = Membre::getInstance($id_contact);
                if ($membre->getMailing()) {
                    // déjà inscrit
                    return NEWSLETTER_SUB_KO_ALREADY_SUBSCRIBED_MEMBER;
                } else {
                    $membre->setMailing(true)
                        ->save();
                    // réinscription OK
                    return NEWSLETTER_SUB_OK_RESUBSCRIBED_MEMBER;
                }
            } else {
                // membre ? non - donc déja inscrit
                return NEWSLETTER_SUB_KO_ALREADY_CONTACT;
            }
        } else {
            // contact ? non
            (new Contact())
                ->setEmail($email)
                ->save();
            // création du contact OK
            return NEWSLETTER_SUB_OK_CONTACT_CREATED;
        }
    }

    /**
     * Suppression d'un email de la newsletter
     *
     * @param string $email email
     *
     * @todo doublon avec script unsubscribe-email ?
     *
     * @return int
     */
    public static function removeEmail(string $email)
    {
        if (($id_contact = Contact::getIdByEmail($email)) !== false) {
            // contact ? oui
            if (($pseudo = Membre::getPseudoById($id_contact)) !== false) {
                // membre ? oui
                $membre = Membre::getInstance($id_contact);
                if ($membre->getMailing()) {
                    $membre->setMailing(false)
                        ->save();
                    // déinscription OK
                    return NEWSLETTER_UNSUB_OK_UNSUBSCRIBED_MEMBER;
                } else {
                    // déja désinscrit
                    return NEWSLETTER_UNSUB_KO_ALREADY_UNSUBSCRIBED_MEMBER;
                }
            } else {
                // membre ? non
                $contact = Contact::getInstance($id_contact)
                    ->delete();
                // delete du contact OK
                return NEWSLETTER_UNSUB_OK_CONTACT_DELETED;
            }
        } else {
            // contact ? non - donc pas inscrit
            return NEWSLETTER_UNSUB_KO_UNKNOWN_CONTACT;
        }
    }
}
