<?php

/**
 * @package adhoc
 */

/**
 * Classe de gestion de l'appli messages privés
 *
 * @package adhoc
 * @author Guillaume Seznec <guillaume.seznec@gmail.com>
 */
class Messagerie extends ObjectModel
{
    /**
     *
     */
    protected static $_instance = null;

    /**
     *
     */
    protected static $_pk = 'id_messagerie';

    /**
     *
     */
    protected static $_table = 'adhoc_messagerie';

    /**
     * Clé Contact
     *
     * @var int
     */
    private $_id_contact;

    /**
     * Constructeur de la Classe
     *
     * @param int $id_contact
     * @return void
     */
    public function __construct($id_contact)
    {
        $this->_id_contact = (int) $id_contact;
        self::$_instance = $this;
    }

    /**
     *
     */
    public static function getInstance($id_contact)
    {
        if (is_null(self::$_instance)) {
            return new Messagerie($id_contact);
        }
        return self::$_instance;
    }

    /**
     *
     */
    public static function deleteInstance()
    {
        if (isset(self::$_instance)) {
            self::$_instance = null;
            return true;
        }
        return false;
    }

    /**
     * Envoi un message privé
     *
     * @param int id_contact destinataire
     * @param string message
     * @return false ou int
     */
    public function sendMessage($to, $text)
    {
        $db = DataBase::getInstance();

        $sql = "INSERT INTO `" . self::$_db_table_messagerie . "` "
             . "(`from`, `to`, `text`, `date`) "
             . "VALUES(" . (int) $this->_id_contact . ", " . (int) $to . ", '" . $db->escape($text) . "', NOW())";

        $db->query($sql);

        return $db->insertId();
    }

    /**
     * retourne les infos sur un message en particulier
     *
     * @param int id_pm
     * @return bool
     */
    public function getMessage($id_pm)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_pm`, `from`, `to`, `text`, `date`, `read`, `del_from`, `del_to` "
             . "FROM `" . self::$_db_table_messagerie . "` "
             . "WHERE `id_pm` = " . (int) $id_pm;

        return $db->queryWithFetchFirstRow($sql);
    }

    /**
     * compte le nombre de messages non lus par la personne loguée
     *
     * @todo à implémenter
     */
    public function getUnreadMessagesCount()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(`id_pm`) "
             . "FROM `" . self::$_db_table_messagerie . "` "
             . "WHERE `to` = " . (int) $this->_id_contact . " "
             . "AND `read` = FALSE";

        return (int) $db->queryWithFetchFirstField($sql);
    }

    /**
     * compte le nombre de messages non lus par la personne loguée
     *
     * @return int
     */
    public static function getMyUnreadMessagesCount()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(`id_pm`) "
             . "FROM `" . self::$_db_table_messagerie . "` "
             . "WHERE `to` = " . (int) $_SESSION['membre']->getId() . " "
             . "AND `read` = FALSE "
             . "AND `del_to` = FALSE";

        return (int) $db->queryWithFetchFirstField($sql);
    }

    /**
     * compte le nombre de messages envoyés par la personne loguée
     *
     * @todo à implémenter
     */
    public function getSentMessagesCount()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(`id_pm`) "
             . "FROM `" . self::$_db_table_messagerie . "` "
             . "WHERE `from` = " . (int) $this->_id_contact . " "
             . "AND `del_from` = FALSE";

        return (int) $db->queryWithFetchFirstField($sql);
    }

    /**
     * compte le nombre de messages reçus par la personne loguée
     *
     * @todo à implémenter
     */
    public function getMessagesCount()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(`id_pm`) "
             . "FROM `" . self::$_db_table_messagerie . "` "
             . "WHERE `to` = " . (int) $this->_id_contact . " "
             . "AND `del_to` = FALSE";

        return (int) $db->queryWithFetchFirstField($sql);
    }

    /**
     * compte le nombre de messages reçus par la personne loguée
     *
     * @return int
     */
    public static function getMyMessagesCount()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(`id_pm`) "
             . "FROM `" . self::$_db_table_messagerie . "` "
             . "WHERE `to` = " . (int) $_SESSION['membre']->getId() . " "
             . "AND `del_to` = FALSE";

        return (int) $db->queryWithFetchFirstField($sql);
    }

    /**
     * Recupération d'un ensemble de messages
     * @param string mode :
     *               admin (tous les messages)
     *               recus (tous les messages reçus d'un gars)
     *               sent  (tous les messages envoyés d'un gars)
     */
    public function getListing($mode)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_pm`, `from`, `to`, `text`, `date`, `read`, `del_from`, `del_to` "
             . "FROM `" . self::$_db_table_messagerie . "` "
             . "WHERE 1 ";

        switch($mode)
        {
            case 'admin':
                $sql .= "AND 1 ";
                break;

            case 'recus':
                $sql .= "AND `to` = " . (int) $this->_id_contact . " AND `del_to` = FALSE ";
                break;

            case 'sent':
                $sql .= "AND `from` = " . (int) $this->_id_contact . " AND `del_from` = FALSE ";
                break;

            default:
                return false;
                break;
        }

        $sql .= "ORDER BY `id_pm` = DESC";

        return $db->queryWithFetch($sql);
    }

    /**
     * marque le message comme lu par le destinataire
     *
     * @return bool
     */
    public function setRead($id_pm)
    {
        $db = DataBase::getInstance();

        $sql = "UPDATE `" . self::$_db_table_messagerie . "` "
             . "SET `read` = TRUE "
             . "WHERE `id_pm` = " . (int) $id_pm;

        $db->query($sql);

        return $db->affectedRows();
    }

    /**
     * Efface virtuellement un message
     *
     * @param int $id_pm
     * @param string $who ('from'|'to')
     */
    public function setDeleted($id_pm, $who)
    {
        $db = DataBase::getInstance();

        $sql  = "UPDATE `" . self::$_db_table_messagerie . "` ";
        switch($who) {
            case 'from':
                $sql .= 'SET `del_from` = TRUE ';
                break;
            case 'to':
                $sql .= 'SET `del_to` = TRUE ';
                break;
            default:
                return false;
                break;
        }
        $sql .= "WHERE `id_pm` = " . (int) $id_pm;

        $db->query(sql);

        return $db->affectedRows();
    }
}
