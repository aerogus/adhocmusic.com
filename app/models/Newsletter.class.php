<?php

/**
 * @package adhoc
 */

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
 * @package adhoc
 * @author Guillaume Seznec <guillaume.seznec@gmail.com>
 */
class Newsletter extends ObjectModel
{
    /**
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
     * @var array
     */
    protected static $_all_fields = array(
        'title' => 'str',
        'content' => 'str',
    );

    /**
     * @var array
     */
    protected $_modified_fields = array();

    /**
     * @return string
     */
    static function getBaseUrl()
    {
        return MEDIA_URL . '/newsletter';
    }

    /**
     * @return string
     */
    static function getBasePath()
    {
        return MEDIA_PATH . '/newsletter';
    }

    /**
     * @return string
     */
    function getFileUrl()
    {
        return self::getBaseUrl() . '/' . $this->getId();
    }

    /**
     * @return string
     */
    function getFilePath()
    {
        return self::getBasePath() . '/' . $this->getId();
    }

    /**
     * @return string
     */
    function getContent()
    {
        return (string) $this->_content;
    }

    /**
     * retourne le contenu
     *
     * @return string
     */
    static function getContentRendered()
    {
        return (string) $this->_content;
    }

    /**
     * set le champ body, html (partie variable de la lettre)
     *
     * @param string
     */
    function setContent($val)
    {
        if ($this->_content !== $val)
        {
            $this->_content = (string) $val;
            $this->_modified_fields['content'] = true;
        }
    }

    /**
     * retourne l'url de visualisation de la newsletter courante
     *
     * @return string
     */
    function getUrl()
    {
        return HOME_URL . '/newsletters/' . $this->getId();
    }

    /**
     * retourne le title de la lettre (= sujet du mail)
     * @return string
     */
    function getTitle()
    {
        return (string) $this->_title;
    }

    /**
     * set le title de la lettre (= sujet du mail)
     *
     * @param string
     */
    function setTitle($val)
    {
        if ($this->_title !== $val)
        {
            $this->_title = (string) $val;
            $this->_modified_fields['title'] = true;
        }
    }

    /**
     * retourne l'identifiant de la lettre
     *
     * @return int
     */
    function getId()
    {
        return (int) $this->_id_newsletter;
    }

    /**
     * recherche des newsletters en fonction de critères donnés
     * @param array ['id']      => "3"
     *              ['contact'] => "1"
     *              ['sort']    => "id_newsletter"
     *              ['sens']    => "ASC"
     *              ['debut']   => 0
     *              ['limit']   => 10
     * @return array
     */
    static function getNewsletters($params = array())
    {
        $debut = 0;
        if(isset($params['debut'])) {
            $debut = (int) $params['debut'];
        }

        $limit = 10;
        if(isset($params['limit'])) {
            $limit = (int) $params['limit'];
        }

        $sens = "ASC";
        if(isset($params['sens']) && $params['sens'] === "DESC") {
            $sens = "DESC";
        }

        $tab_id = array();
        if(array_key_exists('id', $params)) {
            $tab_id = explode(",", $params['id']);
        }

        $db = DataBase::getInstance();

        $sql = "SELECT `id_newsletter` AS `id`, `title` "
             . "FROM `" . self::$_db_table_newsletter . "` "
             . "WHERE 1 ";

        if(count($tab_id) && ($tab_id[0] !== 0)) {
            $sql .= "AND `id_newsletter` IN (" . implode(',', $tab_id) . ") ";
        }

        $sql .= "ORDER BY `id_newsletter` " . $sens . " ";
        $sql .= "LIMIT " . $debut . ", " . $limit;

        return $db->queryWithFetch($sql);
    }

    /**
     * stats d'affichage de l'image de tracking
     *
     * @param array['id_contact']
     *             ['ip']
     *             ['host']
     *             ['useragent']
     * @return bool
     */
    static function addStats($params)
    {
        $db = DataBase::getInstance();

        $sql = "INSERT INTO `" . self::$_db_table_statsnl . "` "
             . "(`id_contact`, `date`, `ip`, `host`, `useragent`) "
             . "VALUES(".(int) $params['id_contact'].", NOW(), '".$db->escape($params['ip'])."', '".$db->escape($params['host'])."', '".$db->escape($params['useragent'])."')";

        return $db->query($sql);
    }

    /**
     * retourne les abonnés actifs à la newsletter
     *
     * @param int $debut
     * @param int $limit
     * @return array
     */
    static function getSubscribers($debut = 0, $limit = 10000)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `c`.`id_contact`, `c`.`email`, `c`.`lastnl`, `m`.`mailing`, `m`.`pseudo` "
             . "FROM (`" . self::$_db_table_contact . "` `c`) "
             . "LEFT JOIN `" . self::$_db_table_membre . "` `m` ON (`m`.`id_contact` = `c`.`id_contact`) "
             . "WHERE (`m`.`mailing` IS NULL) OR (`m`.`mailing` = 1) "
             . "ORDER BY `c`.`id_contact` ASC "
             . "LIMIT " . (int) $debut . ", " . (int) $limit;

        return $db->queryWithFetch($sql);
    }

    /**
     * compte le nombre total d'abonnés actifs à la newsletter
     *
     * @return int
     */
    static function getSubscribersCount()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(`c`.`id_contact`) "
             . "FROM (`" . self::$_db_table_contact . "` `c`) "
             . "LEFT JOIN `" . self::$_db_table_membre . "` `m` ON (`m`.`id_contact` = `c`.`id_contact`) "
             . "WHERE (`m`.`mailing` IS NULL) OR (`m`.`mailing` = 1) ";

        return $db->queryWithFetchFirstField($sql);
    }

    /**
     * ajout d'un email à la newsletter
     * @todo doublon avec script subscribe-email ?
     * @param string $email
     * @return int
     */
    static function addEmail($email)
    {
        if($id_contact = Contact::getIdByEmail($email)) {
            // contact ? oui
            if($pseudo = Membre::getPseudoById($id_contact)) {
                // "membre ? oui
                $membre = Membre::getInstance($id_contact);
                if($membre->getMailing()) {
                    // déjà inscrit
                    return NEWSLETTER_SUB_KO_ALREADY_SUBSCRIBED_MEMBER;
                } else {
                    $membre->setMailing(true);
                    $membre->save();
                    // réinscription OK
                    return NEWSLETTER_SUB_OK_RESUBSCRIBED_MEMBER;
                }
            } else {
                // membre ? non - donc déja inscrit
                return NEWSLETTER_SUB_KO_ALREADY_CONTACT;
            }
        } else {
            // contact ? non
            $contact = Contact::init();
            $contact->setEmail($email);
            $contact->save();
            // création du contact OK
            return NEWSLETTER_SUB_OK_CONTACT_CREATED;
        }
    }

    /**
     * suppression d'un email de la newsletter
     * @todo doublon avec script unsubscribe-email ?
     * @param string $email
     * @return int
     */
    static function removeEmail($email)
    {
        if($id_contact = Contact::getIdByEmail($email)) {
            // contact ? oui
            if($pseudo = Membre::getPseudoById($id_contact)) {
                // membre ? oui
                $membre = Membre::getInstance($id_contact);
                if($membre->getMailing()) {
                    $membre->setMailing(false);
                    $membre->save();
                    // déinscription OK
                    return NEWSLETTER_UNSUB_OK_UNSUBSCRIBED_MEMBER;
                } else {
                    // déja désinscrit
                    return NEWSLETTER_UNSUB_KO_ALREADY_UNSUBSCRIBED_MEMBER;
                }
            } else {
                // membre ? non
                $contact = Contact::getInstance($id_contact);
                $contact->delete();
                // delete du contact OK
                return NEWSLETTER_UNSUB_OK_CONTACT_DELETED;
            }
        } else {
            // contact ? non - donc pas inscrit
            return NEWSLETTER_UNSUB_KO_UNKNOWN_CONTACT;
        }
    }

    /**
     *
     */
    protected function _loadFromDb()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `title`, `content` "
             . "FROM `" . self::$_table . "` "
             . "WHERE `" . self::$_pk . "` = " . (int) $this->_id_newsletter;

        if($res = $db->queryWithFetchFirstRow($sql)) {
            $this->_dbToObject($res);
            return true;
        }

        throw new Exception('id_newsletter introuvable');
    }

    /**
     * stats vite fait ...
     */
    static function addHit($id_newsletter, $id_contact, $url)
    {
        file_put_contents(ADHOC_ROOT_PATH . '/log/newsletters-hits.txt', date('Y-m-d H:i:s') . "\tnl" . $id_newsletter . "\tid" . $id_contact . "\turl" . $url ."\n", FILE_APPEND | LOCK_EX);

        $ip = false;
        if(isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $host = gethostbyaddr($ip);
        if(isset($_SERVER['HTTP_USER_AGENT'])) {
            $useragent = $_SERVER['HTTP_USER_AGENT'];
        }

        try {

            $contact = Contact::getInstance((int) $id_contact);
            $contact->setLastnlNow();
            $contact->save();

            $db = DataBase::getInstance();

            $sql = "INSERT INTO `adhoc_newsletter_hit` "
                 . "(`date`, `id_newsletter`, `id_contact`, `url`, `ip`, `host`, `useragent`) "
                 . "VALUES(NOW(), " . (int) $id_newsletter . ", " . (int) $id_contact .", '" . $db->escape($url) . "', '" . $db->escape($ip) . "', '" . $db->escape($host) . "', '" . $db->escape($useragent) . "    ')";
            $res = $db->query($sql);

        } catch(Exception $e) {
            // rien
        }
    }
}
