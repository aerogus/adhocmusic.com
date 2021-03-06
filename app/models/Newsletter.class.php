<?php declare(strict_types=1);

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
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Newsletter extends ObjectModel
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
    protected static $_pk = 'id_newsletter';

    /**
     * @var string
     */
    protected static $_table = 'adhoc_newsletter';

    /**
     * @var int
     */
    protected $_id_newsletter = 0;

    /**
     * @var string
     */
    protected $_title = '';

    /**
     * @var string
     */
    protected $_content = '';

    /**
     * @var string
     */
    protected $_html = '';

    /**
     * Liste des attributs de l'objet
     *
     * @var array
     */
    protected static $_all_fields = [
        'id_newsletter' => 'int', // pk
        'title'         => 'string',
        'content'       => 'string',
        'html'          => 'string',
    ];

    /**
     * @var int
     */
    protected $_id_contact = 0;

    /**
     * @var array
     */
    protected $_tpl_vars = [];

    /**
     * @return string
     */
    static function getBaseUrl(): string
    {
        return MEDIA_URL . '/newsletter';
    }

    /**
     * @return string
     */
    static function getBasePath(): string
    {
        return MEDIA_PATH . '/newsletter';
    }

    /**
     * Retourne l'identifiant de la newsletter
     *
     * @return string
     */
    function getIdNewsletter(): int
    {
        return $this->_id_newsletter;
    }

    /**
     * @return string
     */
    function getFileUrl(): string
    {
        return self::getBaseUrl() . '/' . (string) $this->getId();
    }

    /**
     * @return string
     */
    function getFilePath(): string
    {
        return self::getBasePath() . '/' . (string) $this->getId();
    }

    /**
     * Retourne le contenu source MJML
     *
     * @return string
     */
    function getContent(): string
    {
        return $this->_content;
    }

    /**
     * Retourne le contenu compilé en HTML
     *
     * @return string
     */
    function getHtml(): string
    {
        return $this->_html;
    }

    /**
     * Retourne le contenu après être passé à la moulinette
     * des variables de templates et des liens de tracking
     */
    function getProcessedHtml()
    {
        $html = $this->getHtml();

        // set des variables de templates
        $html = str_replace(
            array_keys($this->_tpl_vars),
            array_values($this->_tpl_vars),
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
            $link .= Tools::base64_url_encode($this->getId() . '|' . $this->getIdContact());
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
    function getIdContact(): int
    {
        return $this->_id_contact;
    }

    /**
     * Set l'id_contact courant
     *
     * @param int $id_contact id_contact
     *
     * @return object
     */
    function setIdContact(int $id_contact): object
    {
        $this->_id_contact = $id_contact;

        return $this;
    }

    /**
     * Set une variable de template
     * 
     * @param string $key clé
     * @param string $val valeur
     *
     * @return object
     */
    function setTplVar($key, $val): object
    {
        $this->_tpl_vars[$key] = $val;

        return $this;
    }

    /**
     * Set le champ body, html (partie variable de la lettre)
     *
     * @param string $html HTML
     *
     * @return object
     */
    function setHtml(string $html): object
    {
        if ($this->_html !== $html) {
            $this->_html = $html;
            $this->_modified_fields['html'] = true;
        }

        return $this;
    }

    /**
     * Set le champ body, html (partie variable de la lettre)
     *
     * @param string $content contenu source MJML
     *
     * @return object
     */
    function setContent(string $content): object
    {
        if ($this->_content !== $content) {
            $this->_content = $content;
            $this->_modified_fields['content'] = true;
        }

        return $this;
    }

    /**
     * Retourne l'url de visualisation de la newsletter courante
     *
     * @return string
     */
    function getUrl(): string
    {
        return HOME_URL . '/newsletters/' . $this->getId();
    }

    /**
     * Retourne le title de la lettre (= sujet du mail)
     *
     * @return string
     */
    function getTitle(): string
    {
        return $this->_title;
    }

    /**
     * Set le title de la lettre (= sujet du mail)
     *
     * @param string $title title
     *
     * @return object
     */
    function setTitle(string $title): object
    {
        if ($this->_title !== $title) {
            $this->_title = $title;
            $this->_modified_fields['title'] = true;
        }

        return $this;
    }

    /**
     * Retourne l'identifiant de la lettre
     *
     * @return int
     */
    function getId(): int
    {
        return $this->_id_newsletter;
    }

    /**
     * @return bool
     * @throws Exception
     */
    protected function _loadFromDb(): bool
    {
        if (!parent::_loadFromDb()) {
            throw new Exception('id_newsletter introuvable');
        }

        return true;
    }

    /**
     * Retourne une collection d'objets "Newsletter" répondant au(x) critère(s)
     *
     * @param array $params params ['order_by' => string, 'sort => string]
     *
     * @return array
     */
    static function find(array $params): array
    {
        $db = DataBase::getInstance();
        $objs = [];

        $sql = "SELECT `id_newsletter` FROM `" . Newsletter::getDbTable() . "` WHERE 1 ";

        if ((isset($params['order_by']) && (in_array($params['order_by'], array_keys(static::$_all_fields))))) {
            $sql .= "ORDER BY `" . $params['order_by'] . "` ";
        } else {
            $sql .= "ORDER BY `" . static::$_pk . "` ";
        }

        if ((isset($params['sort']) && (in_array($params['sort'], ['ASC', 'DESC'])))) {
            $sql .= $params['sort'];
        } else {
            $sql .= "ASC";
        }

        $ids_newsletter = $db->queryWithFetchFirstFields($sql);
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
     * @return array
     */
    static function getSubscribers(int $debut = 0, int $limit = 10000): array
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `c`.`id_contact`, `c`.`email`, `c`.`lastnl`, `m`.`mailing`, `m`.`pseudo` "
             . "FROM (`" . Contact::getDbTable() . "` `c`) "
             . "LEFT JOIN `" . Membre::getDbTable() . "` `m` ON (`m`.`id_contact` = `c`.`id_contact`) "
             . "WHERE ((`m`.`mailing` IS NULL) OR (`m`.`mailing` = 1)) "
             . "ORDER BY `c`.`id_contact` ASC "
             . "LIMIT " . (int) $debut . ", " . (int) $limit;

        return $db->queryWithFetch($sql);
    }

    /**
     * Compte le nombre total d'abonnés actifs à la newsletter
     *
     * @return int
     */
    static function getSubscribersCount()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(`c`.`id_contact`) "
             . "FROM (`" . Contact::getDbTable() . "` `c`) "
             . "LEFT JOIN `" . Membre::getDbTable() . "` `m` ON (`m`.`id_contact` = `c`.`id_contact`) "
             . "WHERE (`m`.`mailing` IS NULL) OR (`m`.`mailing` = 1) ";

        return $db->queryWithFetchFirstField($sql);
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
    static function addEmail(string $email)
    {
        if ($id_contact = Contact::getIdByEmail($email)) {
            // contact ? oui
            if ($pseudo = Membre::getPseudoById($id_contact)) {
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
    static function removeEmail(string $email)
    {
        if ($id_contact = Contact::getIdByEmail($email)) {
            // contact ? oui
            if ($pseudo = Membre::getPseudoById($id_contact)) {
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

    /**
     * Stats vite fait ...
     * 
     * @param int    $id_newsletter id_newsletter
     * @param int    $id_contact    id_contact
     * @param string $url           url
     */
    static function addHit(int $id_newsletter, int $id_contact, string $url)
    {
        file_put_contents(ADHOC_ROOT_PATH . '/log/newsletters-hits.txt', date('Y-m-d H:i:s') . "\tnl" . $id_newsletter . "\tid" . $id_contact . "\turl" . $url ."\n", FILE_APPEND | LOCK_EX);

        $ip = false;
        if (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $host = gethostbyaddr($ip);
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $useragent = $_SERVER['HTTP_USER_AGENT'];
        }

        try {

            $contact = Contact::getInstance($id_contact)
                ->setLastnlNow()
                ->save();

            $db = DataBase::getInstance();

            $sql = "INSERT INTO `adhoc_newsletter_hit` "
                 . "(`date`, `id_newsletter`, `id_contact`, `url`, `ip`, `host`, `useragent`) "
                 . "VALUES(NOW(), " . (int) $id_newsletter . ", " . (int) $id_contact .", '" . $db->escape($url) . "', '" . $db->escape($ip) . "', '" . $db->escape($host) . "', '" . $db->escape($useragent) . "    ')";
            $res = $db->query($sql);

        } catch (Exception $e) {
            // rien
        }
    }
}
