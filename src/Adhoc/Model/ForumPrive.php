<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Utils\DataBase;

/**
 *
 */
class ForumPrive extends Forum
{
    /**
     * @var string
     */
    protected static string $db_table_forum_info = 'adhoc_forum_prive_info';

    /**
     * @var string
     */
    protected static string $db_table_forum_thread = 'adhoc_forum_prive_thread';

    /**
     * @var string
     */
    protected static string $db_table_forum_message = 'adhoc_forum_prive_message';

    /**
     * Retourne le listing des threads d'un forum donné avec le contenu du 1er message
     *
     * @param string $id_forum id_forum
     * @param int    $page     page
     *
     * @return array<mixed>
     */
    public static function getThreads(string $id_forum, int $page = 0): array
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `t`.`id_thread`, `t`.`created_at`, `t`.`modified_at`, "
             . "`t`.`created_by`, `t`.`modified_by`, "
             . "`t`.`nb_messages`, (`t`.`nb_messages` - 1) AS `nb_replies`, `t`.`nb_views`, `t`.`subject`, "
             . "`m`.`text` "
             . "FROM `" . static::$db_table_forum_info . "` `f`, `" . static::$db_table_forum_thread . "` `t`, `" . static::$db_table_forum_message . "` `m` "
             . "WHERE 1 "
             . "AND `f`.`id_forum` = '" . $id_forum . "' "
             . "AND `f`.`id_forum` = `t`.`id_forum` "
             . "AND `t`.`id_thread` = `m`.`id_thread` "
             . "AND `m`.`id_message` = (SELECT (MIN(`id_message`)) FROM `" . static::$db_table_forum_message . "` `sm` WHERE `sm`.`id_thread` = `t`.`id_thread`) "
             . "ORDER BY  `t`.`modified_at` DESC, `m`.`id_thread` DESC , `m`.`id_message` DESC "
             . "LIMIT " . ($page * FORUM_NB_THREADS_PER_PAGE) . "," . FORUM_NB_THREADS_PER_PAGE;

        $threads = $db->pdo->query($sql)->fetchAll();

        if (is_array($threads)) {
            foreach ($threads as $idx => $thread) {
                $threads[$idx]['url'] = HOME_URL . '/adm/forums/thread/' . $thread['id_thread'];
                $threads[$idx]['created_by_url'] = HOME_URL . '/membres/' . $thread['created_by'];
                $threads[$idx]['created_by_avatar'] = MEDIA_URL . '/membre/ca/' . $thread['created_by'] . '.jpg';
            }
        }

        return $threads;
    }

    /**
     * Retourne la page des messages d'un thread donné
     * (l'id_forum est implicite)
     *
     * @param int $id_thread id_thread
     * @param int $page      page
     *
     * @return array<string,mixed>
     */
    public static function getMessages(int $id_thread, int $page = 0): array
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_forum`, `id_thread`, `created_at`, `modified_at`, "
             . "`created_by`, `modified_by`, "
             . "`nb_messages`, (`nb_messages` - 1) AS `nb_replies`, `nb_views`, `subject` "
             . "FROM `" . static::$db_table_forum_thread . "` "
             . "WHERE `id_thread` = " . $id_thread;
        $stmt = $db->pdo->query($sql);
        $thread = $stmt->fetch();

        if (array_key_exists('id_thread', $thread) && array_key_exists('created_by', $thread)) {
            $thread['url'] = HOME_URL . '/adm/forums/thread/' . $thread['id_thread'];
            $thread['created_by_url'] = HOME_URL . '/membres/' . $thread['created_by'];
            $thread['created_by_avatar'] = MEDIA_URL . '/membre/ca/' . $thread['created_by'] . '.jpg';
        }

        $sql = "SELECT `id_message`, `id_thread`, `created_at`, `modified_at`, "
             . "`created_by`, `modified_by`, `text` "
             . "FROM `" . static::$db_table_forum_message . "` "
             . "WHERE `id_thread` = " . $id_thread . " "
             . "ORDER BY `id_message` ASC "
             . "LIMIT " . ($page * FORUM_NB_MESSAGES_PER_PAGE) . "," . FORUM_NB_MESSAGES_PER_PAGE;
        $stmt = $db->pdo->query($sql);
        $messages = $stmt->fetchAll();

        foreach ($messages as $idx => $message) {
            $wiki_parsing = false;
            if ($message['created_at'] > '2011-04-16 00:00:00' && $message['created_at'] < '2011-09-26 10:45:00') {
                $wiki_parsing = true;
            }
            $messages[$idx]['parsed_text'] = self::parseMessage($message['text'], $wiki_parsing);
            $messages[$idx]['url'] = HOME_URL . '/adm/forums/thread/' . $message['id_thread'];
            $messages[$idx]['created_by_url'] = HOME_URL . '/membres/' . $message['created_by'];
            $messages[$idx]['created_by_avatar'] = MEDIA_URL . '/membre/ca/' . $message['created_by'] . '.jpg';
        }

        return [
            'thread' => $thread,
            'messages' => $messages,
        ];
    }

    /**
     * Retire tous les abonnements aux forums privés pour un membre interne
     *
     * @param int $id_contact id_contact
     *
     * @return bool
     */
    public static function delAllSubscriptions(int $id_contact): bool
    {
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `adhoc_forum_prive_subscriber` "
             . "WHERE `id_contact` = " . $id_contact;

        $db->pdo->query($sql);

        return true;
    }

    /**
     * Retire un abonnement forum à un membre interne
     *
     * @param int    $id_contact id_contact
     * @param string $id_forum   id_forum
     *
     * @return bool
     */
    public static function delSubscriberToForum(int $id_contact, string $id_forum): bool
    {
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `adhoc_forum_prive_subscriber` "
             . "WHERE `id_contact` = " . $id_contact . " "
             . "AND `id_forum` = '" . $id_forum . "'";

        $db->pdo->query($sql);

        return true;
    }

    /**
     * Ajoute un abonnement forum à un membre interne
     *
     * @param int    $id_contact id_contact
     * @param string $id_forum   id_forum
     *
     * @return bool
     */
    public static function addSubscriberToForum(int $id_contact, string $id_forum): bool
    {
        $db = DataBase::getInstance();

        $sql = "INSERT INTO `adhoc_forum_prive_subscriber` "
             . "(`id_contact`, `id_forum`) "
             . "VALUES(" . $id_contact . ", '" . $id_forum . "')";

        $db->pdo->query($sql);

        return true;
    }

    /**
     * Retourne la liste des forums auxquels est abonné l'id_contact
     *
     * @param int $id_contact id_contact
     *
     * @return array<string,bool>
     */
    public static function getSubscribedForums(int $id_contact): array
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_forum` "
             . "FROM `adhoc_forum_prive_subscriber` "
             . "WHERE `id_contact` = " . $id_contact;

        $forums = $db->pdo->query($sql)->fetchAll(\PDO::FETCH_COLUMN);

        return [
            'a' => in_array('a', $forums, true),
            'b' => in_array('b', $forums, true),
            'e' => in_array('e', $forums, true),
            's' => in_array('s', $forums, true),
            't' => in_array('t', $forums, true),
        ];
    }

    /**
     * @param int           $id_contact id_contact
     * @param array<string> $ids_forum  ids_forum
     *
     * @see addSubscriberToForum / delSubscriberToForum
     * @return true
     */
    public static function setSubscribedForums(int $id_contact, array $ids_forum): true
    {
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `adhoc_forum_prive_subscriber` "
             . "WHERE `id_contact` = " . $id_contact;

        $db->pdo->query($sql);

        foreach ($ids_forum as $id_forum) {
            $sql = "INSERT INTO `adhoc_forum_prive_subscriber` "
                 . "(`id_contact`, `id_forum`) "
                 . "VALUES(" . $id_contact . ", '" . $id_forum . "')";

            $db->pdo->query($sql);
        }

        return true;
    }

    /**
     * Retourne la liste des inscrits à un forum privé donné
     *
     * @param string $id_forum id_forum
     *
     * @return array<array<string,string>>
     */
    public static function getSubscribers(string $id_forum): array
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `m`.`pseudo`, `m`.`port`, `c`.`email`, `c`.`id_contact` "
             . "FROM `adhoc_contact` `c`, `adhoc_membre` `m`, `adhoc_forum_prive_subscriber` `s` "
             . "WHERE `c`.`id_contact` = `m`.`id_contact` "
             . "AND `m`.`id_contact` = `s`.`id_contact` "
             . "AND `s`.`id_forum` = '" . $id_forum . "'";

        $subs = $db->pdo->query($sql)->fetchAll();

        if (is_array($subs)) {
            foreach ($subs as $idx => $sub) {
                $subs[$idx]['url'] = HOME_URL . '/membres/' . $sub['id_contact'];
                $subs[$idx]['avatar'] = MEDIA_URL . '/membre/ca/' . $sub['id_contact'] . '.jpg';
            }
        }

        return $subs;
    }
}
