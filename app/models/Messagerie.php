<?php declare(strict_types=1);

/**
 * Classe de gestion de l'appli messages privés
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Messagerie extends ObjectModel
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
    protected static string $_pk = 'id_messagerie';

    /**
     * @var string
     */
    protected static string $_table = 'adhoc_messagerie';

    /**
     * Clé Contact
     *
     * @var int
     */
    private int $_id_contact;

    /**
     * Constructeur de la Classe
     *
     * @param int $id_contact id_contact
     *
     * @return void
     */
    public function __construct($id_contact)
    {
        $this->_id_contact = (int) $id_contact;
        self::$_instance = $this;
    }

    /**
     * @return object
     */
    public static function getInstance($id_contact): object
    {
        if (is_null(self::$_instance)) {
            return new Messagerie($id_contact);
        }
        return self::$_instance;
    }

    /**
     * @return bool
     */
    public static function deleteInstance(): bool
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
     * @param int    $id_to id_contact du destinataire
     * @param string $text  message
     *
     * @return false ou int
     */
    public function sendMessage(int $id_to, string $text): int
    {
        $db = DataBase::getInstance();

        $sql = "INSERT INTO `" . Messagerie::getDbTable() . "` "
             . "(`id_from`, `id_to`, `text`, `date`) "
             . "VALUES(" . (int) $this->_id_contact . ", " . (int) $id_to . ", '" . $db->escape($text) . "', NOW())";

        $db->query($sql);

        return $db->insertId();
    }

    /**
     * Retourne les infos sur un message en particulier
     *
     * @param int $id_pm id_pm
     *
     * @return array
     */
    public function getMessage(int $id_pm): array
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_pm`, `id_from`, `id_to`, `text`, `date`, `read`, `del_from`, `del_to` "
             . "FROM `" . Messagerie::getDbTable() . "` "
             . "WHERE `id_pm` = " . (int) $id_pm;

        return $db->queryWithFetchFirstRow($sql);
    }

    /**
     * Compte le nombre de messages non lus par la personne loguée
     *
     * @todo différente avec la méthode suivante ?
     *
     * @return int
     */
    public function getUnreadMessagesCount(): int
    {
        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(`id_pm`) "
             . "FROM `" . Messagerie::getDbTable() . "` "
             . "WHERE `id_to` = " . (int) $this->_id_contact . " "
             . "AND `read_to` = FALSE";

        return (int) $db->queryWithFetchFirstField($sql);
    }

    /**
     * Compte le nombre de messages non lus par la personne loguée
     *
     * @todo différente avec la méthode précédente ?
     *
     * @return int
     */
    public static function getMyUnreadMessagesCount(): int
    {
        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(`id_pm`) "
             . "FROM `" . Messagerie::getDbTable() . "` "
             . "WHERE `id_to` = " . (int) $_SESSION['membre']->getId() . " "
             . "AND `read_to` = FALSE "
             . "AND `del_to` = FALSE";

        return (int) $db->queryWithFetchFirstField($sql);
    }

    /**
     * Compte le nombre de messages envoyés par la personne loguée
     *
     * @return int
     */
    public function getSentMessagesCount(): int
    {
        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(`id_pm`) "
             . "FROM `" . Messagerie::getDbTable() . "` "
             . "WHERE `id_from` = " . (int) $this->_id_contact . " "
             . "AND `del_from` = FALSE";

        return (int) $db->queryWithFetchFirstField($sql);
    }

    /**
     * Compte le nombre de messages reçus par la personne loguée
     *
     * @todo à implémenter
     */
    public function getMessagesCount(): int
    {
        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(`id_pm`) "
             . "FROM `" . Messagerie::getDbTable() . "` "
             . "WHERE `id_to` = " . (int) $this->_id_contact . " "
             . "AND `del_to` = FALSE";

        return (int) $db->queryWithFetchFirstField($sql);
    }

    /**
     * Compte le nombre de messages reçus par la personne loguée
     *
     * @return int
     */
    public static function getMyMessagesCount(): int
    {
        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(`id_pm`) "
             . "FROM `" . Messagerie::getDbTable() . "` "
             . "WHERE `id_to` = " . (int) $_SESSION['membre']->getId() . " "
             . "AND `del_to` = FALSE";

        return (int) $db->queryWithFetchFirstField($sql);
    }

    /**
     * Récupération d'un ensemble de messages
     *
     * @param string mode :
     *               admin (tous les messages)
     *               recus (tous les messages reçus d'un gars)
     *               sent  (tous les messages envoyés d'un gars)
     *
     * @return array
     */
    public function getListing(string $mode): array
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_pm`, `id_from`, `id_to`, `text`, `date`, `read_to`, `del_from`, `del_to` "
             . "FROM `" . Messagerie::getDbTable() . "` "
             . "WHERE 1 ";

        switch ($mode) {
            case 'admin':
                $sql .= "AND 1 ";
                break;

            case 'recus':
                $sql .= "AND `id_to` = " . (int) $this->_id_contact . " AND `del_to` = FALSE ";
                break;

            case 'sent':
                $sql .= "AND `id_from` = " . (int) $this->_id_contact . " AND `del_from` = FALSE ";
                break;

            default:
                return false;
                break;
        }

        $sql .= "ORDER BY `id_pm` = DESC";

        return $db->queryWithFetch($sql);
    }

    /**
     * Marque le message comme lu par le destinataire
     *
     * @param int $id_pm id_pm
     *
     * @return bool
     */
    public function setRead(int $id_pm): bool
    {
        $db = DataBase::getInstance();

        $sql = "UPDATE `" . Messagerie::getDbTable() . "` "
             . "SET `read_to` = TRUE "
             . "WHERE `id_pm` = " . (int) $id_pm;

        $db->query($sql);

        return (bool) $db->affectedRows();
    }

    /**
     * Efface virtuellement un message
     *
     * @param int    $id_pm id_pm
     * @param string $who   from|to
     */
    public function setDeleted(int $id_pm, string $who)
    {
        $db = DataBase::getInstance();

        $sql  = "UPDATE `" . Messagerie::getDbTable() . "` ";
        switch ($who) {
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
