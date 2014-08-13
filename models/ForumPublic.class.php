<?php

class ForumPublic extends Forum
{
    protected static $_db_table_forum_info    = 'adhoc_forum_public_info';
    protected static $_db_table_forum_thread  = 'adhoc_forum_public_thread';
    protected static $_db_table_forum_message = 'adhoc_forum_public_message';
    protected static $_db_table_membre        = 'adhoc_membre';

    /**
     * retourne le listing des threads d'un forum donné avec le contenu du 1er message
     *
     * @param int $page
     * @return array
     */
    public static function getThreads($id_forum, $page = 0)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `t`.`id_thread`, `t`.`created_on`, `t`.`modified_on`, "
             . "`t`.`created_by`, `t`.`modified_by`, "
             . "`t`.`created_by_name`, `t`.`modified_by_name`, "
             . "`t`.`created_by_email`, `t`.`modified_by_email`, "
             . "`t`.`nb_messages`, (`t`.`nb_messages` - 1) AS `nb_replies`, `t`.`nb_views`, `t`.`subject`, "
             . "`m`.`text` "
             . "FROM `" . static::$_db_table_forum_info . "` `f`, `" . static::$_db_table_forum_thread . "` `t`, `" . static::$_db_table_forum_message . "` `m` "
             . "WHERE 1 "
             . "AND `f`.`id_forum` = '" . $db->escape($id_forum) . "' "
             . "AND `f`.`id_forum` = `t`.`id_forum` "
             . "AND `t`.`id_thread` = `m`.`id_thread` "
             . "AND `m`.`id_message` = (SELECT (MIN(`id_message`)) FROM `" . static::$_db_table_forum_message . "` `sm` WHERE `sm`.`id_thread` = `t`.`id_thread`) "
             . "ORDER BY `t`.`modified_on` DESC, `m`.`id_thread` DESC , `m`.`id_message` DESC "
             . "LIMIT " . ((int) $page * FORUM_NB_THREADS_PER_PAGE) ."," . FORUM_NB_THREADS_PER_PAGE;

        $threads = $db->queryWithFetch($sql);

        return $threads;
    }

    /**
     * retourne la page des messages d'un thread donné
     * (l'id_forum est implicite)
     *
     * @param int $id_thread
     * @param int $page
     */
    public static function getMessages($id_thread, $page = 0)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_forum`, `id_thread`, `created_on`, `modified_on`, "
             . "`created_by`, `modified_by`, "
             . "`created_by_name`, `modified_by_name`, "
             . "`created_by_email`, `modified_by_email`, "
             . "`nb_messages`, (`nb_messages` - 1) AS `nb_replies`, `nb_views`, `subject` "
             . "FROM `" . static::$_db_table_forum_thread . "` "
             . "WHERE `id_thread` = " . (int) $id_thread;
        $thread = $db->queryWithFetchFirstRow($sql);

        $sql = "SELECT `id_message`, `id_thread`, `created_on`, `modified_on`, "
             . "`created_by`, `modified_by`, "
             . "`created_by_name`, `modified_by_name`, "
             . "`created_by_email`, `modified_by_email`, "
             . "`text` "
             . "FROM `" . static::$_db_table_forum_message . "` "
             . "WHERE `id_thread` = " . (int) $id_thread . " "
             . "ORDER BY `id_message` ASC "
             . "LIMIT " . ((int) $page * FORUM_NB_MESSAGES_PER_PAGE) ."," . FORUM_NB_MESSAGES_PER_PAGE;
        $messages = $db->queryWithFetch($sql);

        foreach($messages as $key => $message) {
            $messages[$key]['parsed_text'] = self::parseMessage($message['text']);
        }

        return array(
            'thread' => $thread,
            'messages' => $messages,
        );
    }

    /**
     * retourne la liste des inscrits à un thread donné
     *
     * @param int $id_thread
     * @return array
     */
    public static function getSubscribers($id_forum)
    {
        return false;
    }
}
