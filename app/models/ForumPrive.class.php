<?php declare(strict_types=1);

/**
 *
 */
class ForumPrive extends Forum
{
    /**
     * @var string
     */
    protected static $_db_table_forum_info    = 'adhoc_forum_prive_info';

    /**
     * @var string
     */
    protected static $_db_table_forum_thread  = 'adhoc_forum_prive_thread';

    /**
     * @var string
     */
    protected static $_db_table_forum_message = 'adhoc_forum_prive_message';

    /**
     * Retourne le listing des threads d'un forum donné avec le contenu du 1er message
     *
     * @param string $id_forum id_forum
     * @param int    $page     page
     *
     * @return array
     */
    static function getThreads(string $id_forum, int $page = 0): array
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `t`.`id_thread`, `t`.`created_on`, `t`.`modified_on`, "
             . "`t`.`created_by`, `t`.`modified_by`, "
             . "`t`.`nb_messages`, (`t`.`nb_messages` - 1) AS `nb_replies`, `t`.`nb_views`, `t`.`subject`, "
             . "`m`.`text` "
             . "FROM `" . static::$_db_table_forum_info . "` `f`, `" . static::$_db_table_forum_thread . "` `t`, `" . static::$_db_table_forum_message . "` `m` "
             . "WHERE 1 "
             . "AND `f`.`id_forum` = '" . $db->escape($id_forum) . "' "
             . "AND `f`.`id_forum` = `t`.`id_forum` "
             . "AND `t`.`id_thread` = `m`.`id_thread` "
             . "AND `m`.`id_message` = (SELECT (MIN(`id_message`)) FROM `" . static::$_db_table_forum_message . "` `sm` WHERE `sm`.`id_thread` = `t`.`id_thread`) "
             . "ORDER BY  `t`.`modified_on` DESC, `m`.`id_thread` DESC , `m`.`id_message` DESC "
             . "LIMIT " . ((int) $page * FORUM_NB_THREADS_PER_PAGE) ."," . FORUM_NB_THREADS_PER_PAGE;

        return $db->queryWithFetch($sql);
    }

    /**
     * Retourne la page des messages d'un thread donné
     * (l'id_forum est implicite)
     *
     * @param int $id_thread id_thread
     * @param int $page      page
     *
     * @return array
     */
    static function getMessages(int $id_thread, int $page = 0): array
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_forum`, `id_thread`, `created_on`, `modified_on`, "
             . "`created_by`, `modified_by`, "
             . "`nb_messages`, (`nb_messages` - 1) AS `nb_replies`, `nb_views`, `subject` "
             . "FROM `" . static::$_db_table_forum_thread . "` "
             . "WHERE `id_thread` = " . (int) $id_thread;
        $thread = $db->queryWithFetchFirstRow($sql);

        $sql = "SELECT `id_message`, `id_thread`, `created_on`, `modified_on`, "
             . "`created_by`, `modified_by`, `text` "
             . "FROM `" . static::$_db_table_forum_message . "` "
             . "WHERE `id_thread` = " . (int) $id_thread . " "
             . "ORDER BY `id_message` ASC "
             . "LIMIT " . ((int) $page * FORUM_NB_MESSAGES_PER_PAGE) ."," . FORUM_NB_MESSAGES_PER_PAGE;
        $messages = $db->queryWithFetch($sql);

        foreach ($messages as $key => $message) {
            $wiki_parsing = false;
            if ($message['created_on'] > '2011-04-16 00:00:00' && $message['created_on'] < '2011-09-26 10:45:00') {
                $wiki_parsing = true;
            }
            $messages[$key]['parsed_text'] = self::parseMessage($message['text'], $wiki_parsing);
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
    static function delAllSubscriptions(int $id_contact): bool
    {
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `adhoc_forum_prive_subscriber` "
             . "WHERE `id_contact` = " . (int) $db->escape($id_contact);

        $db->query($sql);

        return true;
        //return $db->affectedRows();
    }

    /**
     * Retire un abonnement forum à un membre interne
     *
     * @param int    $id_contact id_contact
     * @param string $id_forum   id_forum
     *
     * @return bool
     */
    static function delSubscriberToForum(int $id_contact, string $id_forum): bool
    {
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `adhoc_forum_prive_subscriber` "
             . "WHERE `id_contact` = " . (int) $id_contact . " "
             . "AND `id_forum` = '". $db->escape($id_forum) . "'";

        $db->query($sql);

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
    static function addSubscriberToForum(int $id_contact, string $id_forum): bool
    {
        $db = DataBase::getInstance();

        $sql = "INSERT INTO `adhoc_forum_prive_subscriber` "
             . "(`id_contact`, `id_forum`) "
             . "VALUES(" . (int) $id_contact . ", '" . $db->escape($id_forum) . "')";

        $db->query($sql);

        return true;
    }

    /**
     * Retourne la liste des forums auxquels est abonné l'id_contact
     *
     * @param int $id_contact id_contact
     *
     * @return array
     */
    static function getSubscribedForums(int $id_contact): array
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_forum` "
             . "FROM `adhoc_forum_prive_subscriber` "
             . "WHERE `id_contact` = " . (int) $id_contact;

        $forums = $db->queryWithFetchFirstFields($sql);

        return [
            'a' => (bool) in_array('a', $forums),
            'b' => (bool) in_array('b', $forums),
            'e' => (bool) in_array('e', $forums),
            's' => (bool) in_array('s', $forums),
            't' => (bool) in_array('t', $forums),
        ];
    }

    /**
     * @param int   $id_contact id_contact
     * @param array $ids_forum  ids_forum
     *
     * @see addSubscriberToForum / delSubscriberToForum
     */
    static function setSubscribedForums(int $id_contact, array $ids_forum)
    {
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `adhoc_forum_prive_subscriber` "
             . "WHERE `id_contact` = " . (int) $db->escape($id_contact);

        $db->query($sql);

        foreach ($ids_forum as $id_forum) {
            $sql = "INSERT INTO `adhoc_forum_prive_subscriber` "
                 . "(`id_contact`, `id_forum`) "
                 . "VALUES(" . (int) $id_contact . ", '" . $db->escape($id_forum) . "')";

            $db->query($sql);
        }

        return true;
    }

    /**
     * Retourne la liste des inscrits à un forum privé donné
     *
     * @param string $id_forum id_forum
     *
     * @return array
     */
    static function getSubscribers(string $id_forum)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `m`.`pseudo`, `m`.`port`, `c`.`email`, `c`.`id_contact` "
             . "FROM `adhoc_contact` `c`, `adhoc_membre` `m`, `adhoc_forum_prive_subscriber` `s` "
             . "WHERE `c`.`id_contact` = `m`.`id_contact` "
             . "AND `m`.`id_contact` = `s`.`id_contact` "
             . "AND `s`.`id_forum` = '" . $db->escape($id_forum) . "'";

        $subs = $db->queryWithFetch($sql);

        if (!is_array($subs)) {
            foreach ($subs as $idx => $sub) {
                $subs[$idx]['url'] = HOME_URL . '/membres/' . $sub['id_contact'];
                $subs[$idx]['avatar'] = MEDIA_URL . '/membres/ca/' . $sub['id_contact'] . '.jpg';
            }
        }

        return $subs;
    }
}
