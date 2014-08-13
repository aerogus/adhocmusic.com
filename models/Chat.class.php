<?php

/**
 * @package adhoc
 */

/**
 *
 */
class Chat
{
    /**
     * retourne les derniers messages du chat
     * @return array
     */
    public static function getLastMessages($nb = 10)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `ts`, `pseudo`, `message` "
             . "FROM `adhoc_chat_message` "
             . "ORDER BY `id` DESC "
             . "LIMIT 0, " . (int) $nb;

        $messages = $db->queryWithFetch($sql);
        $messages = array_reverse($messages);

        return $messages;
    }

    /**
     * récupère la liste des connectés
     * et reset le idle time de la personne
     *
     * @param array
     * @return array
     */
    public static function getOnline($params)
    {
        $db = DataBase::getInstance();

        $sql = "INSERT INTO `adhoc_chat_online` "
             . "(`id_contact`, `pseudo`, "
             . "`ts`, `ip`, `host`) "
             . "VALUES(" . (int) $params['id_contact'] . ", '" . $db->escape($params['pseudo']) . "', "
             . (int) time() . ", '" . $db->escape($params['ip']) . "', '" . $db->escape($params['host']) . "') "
             . "ON DUPLICATE KEY UPDATE `ts` = " . (int) time();

        $db->query($sql);

        $sql = "SELECT `id_contact`, `pseudo` "
             . "FROM `adhoc_chat_online` "
             . "WHERE `ts` > (" . time() . " - 60 * 5)";

        $members = $db->queryWithFetch($sql);

        return $members;
    }

    /**
     * ajoute un message
     *
     * @param int $id_contact
     * @param string $pseudo
     * @param string $message
     * @return string
     */
    public static function sendMessage($id_contact, $pseudo, $message)
    {
        $db = DataBase::getInstance();

        $sql = "INSERT INTO `adhoc_chat_message` "
             . "(`ts`, `message`, "
             . "`id_contact`, `pseudo`) "
             . "VALUES(" . (int) time() . ", '" . $db->escape($message) . "', "
             . (int) $id_contact . ", '" . $db->escape($pseudo) . "')";

        $db->query($sql);

        return 'OK';
    }
}
