<?php

define('FORUM_NB_THREADS_PER_PAGE',  100);
define('FORUM_NB_MESSAGES_PER_PAGE', 50);

/**
 * Classe de gestion des forums
 *
 * @package adhoc
 * @author Guillaume Seznec <guillaume.seznec@gmail.com>
 */
abstract class Forum
{
    /**
     * chemin des smileys
     *
     * @var string
     */
    protected static $path_smileys = 'http://static.adhocmusic.com/img/smileys/';

    /**
     * liste des smileys a parser
     *
     * @var array
     */
    protected static $smileys = array(
        array(":afro:",   "afro.gif"),
        array(":angry:",  "angry.gif"),
        array(":beer:",   "beer.gif"),
        array(":chin:",   "chinois.gif"),
        array(":pleure:", "pleure.gif"),
        array(":yes:",    "yaisse.gif"),
        array(":metal:",  "metalleux.gif"),
        array(":grr:",    "grr.gif"),
        array(":-D",      "laugh.gif"),
        array(":love:",   "love.gif"),
        array(":non:",    "non.gif"),
        array(":ouch:",   "ouch.gif"),
        array(":-\\",     "embarasse.gif"),
        array(";-)",      "wink.gif"),
        array(";-(",      "triste.gif"),
        array(";o)",      "ouf.gif"),
        array(":prof:",   "prof.gif"),
        array(":-)",      "smile.gif"),
        array(":yeah:",   "yeah.gif"),
        array(":devil:",  "devil.gif"),
        array(":cool:",   "cool.gif"),
        array(":flower:", "flower.gif"),
        array(":music:",  "music.gif"),
    );

    /**
     * Parse le message avec les différentes conventions des forums AD'HOC (smiley, pseudo html etc ...)
     *
     * @param string
     * @return string
     */
    public static function parseMessage($texte, $wiki = false)
    {
        // 1 - gestion des frimousses
        foreach(self::$smileys as $smiley) {
            // [0] = code / [1] nom du fichier .gif
            $texte = str_replace($smiley[0], "<img src='".self::$path_smileys.$smiley[1]."' alt='' />", $texte);
        }

        // 2 - gestion du texte enrichi

        // les gens qui ne respectent pas la casse sont vraiment des tannards !!!
        $texte = str_replace("[B]" , "<b>" , $texte); $texte = str_replace("[/B]" , "</b>" , $texte);
        $texte = str_replace("[b]" , "<b>" , $texte); $texte = str_replace("[/b]" , "</b>" , $texte);
        $texte = str_replace("[I]" , "<i>" , $texte); $texte = str_replace("[/I]" , "</i>" , $texte);
        $texte = str_replace("[i]" , "<i>" , $texte); $texte = str_replace("[/i]" , "</i>" , $texte);
        $texte = str_replace("[U]" , "<u>" , $texte); $texte = str_replace("[/U]" , "</u>" , $texte);
        $texte = str_replace("[u]" , "<u>" , $texte); $texte = str_replace("[/u]" , "</u>" , $texte);
        $texte = str_replace("[H1]", "<h1>", $texte); $texte = str_replace("[/H1]", "</h1>", $texte);
        $texte = str_replace("[h1]", "<h1>", $texte); $texte = str_replace("[/h1]", "</h1>", $texte);
        $texte = str_replace("[H2]", "<h2>", $texte); $texte = str_replace("[/H2]", "</h2>", $texte);
        $texte = str_replace("[h2]", "<h2>", $texte); $texte = str_replace("[/h2]", "</h2>", $texte);
        $texte = str_replace("[H3]", "<h3>", $texte); $texte = str_replace("[/H3]", "</h3>", $texte);
        $texte = str_replace("[h3]", "<h3>", $texte); $texte = str_replace("[/h3]", "</h3>", $texte);
        $texte = str_replace("[H4]", "<h4>", $texte); $texte = str_replace("[/H4]", "</h4>", $texte);
        $texte = str_replace("[h4]", "<h4>", $texte); $texte = str_replace("[/h4]", "</h4>", $texte);
        $texte = str_replace("[H5]", "<h5>", $texte); $texte = str_replace("[/H5]", "</h5>", $texte);
        $texte = str_replace("[h5]", "<h5>", $texte); $texte = str_replace("[/h5]", "</h5>", $texte);
        $texte = str_replace("[H6]", "<h6>", $texte); $texte = str_replace("[/H6]", "</h6>", $texte);
        $texte = str_replace("[h6]", "<h6>", $texte); $texte = str_replace("[/h6]", "</h6>", $texte);

        // insertion d image
        $texte = preg_replace('/(\[IMG\])(.*?)(\[\/IMG\])/', "<img src='\\2' />", $texte);
        $texte = preg_replace('/(\[img\])(.*?)(\[\/img\])/', "<img src='\\2' />", $texte);

        // URL clickable n°2
        $texte = preg_replace('/(\[URL\])(.*?)(\[\/URL\])/', "<a href='\\2'>\\2</a>", $texte);
        $texte = preg_replace('/(\[url\])(.*?)(\[\/url\])/', "<a href='\\2'>\\2</a>", $texte);

        $texte = preg_replace('/(\[URL=)([^\]]*)\](.*?)(\[\/URL\])/', "<a href='\\2'>\\3</a>", $texte);
        $texte = preg_replace('/(\[url=)([^\]]*)\](.*?)(\[\/url\])/', "<a href='\\2'>\\3</a>", $texte);

        // citation
        $texte = preg_replace('/(\[CITE\])(.*?)(\[\/CITE\])/', "<div class=\"citation\">\\2</div>", $texte);
        $texte = preg_replace('/(\[cite\])(.*?)(\[\/cite\])/', "<div class=\"citation\">\\2</div>", $texte);

        return $texte;
    }

    /**
     * retourne les infos d'un forum
     *
     * @return array
     */
    public static function getForum($id_forum)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `f`.`id_forum`, `f`.`title`, `f`.`description`, "
             . "`f`.`nb_messages`, `f`.`nb_threads`, "
             . "`f`.`id_contact`, `m`.`pseudo`, `f`.`date` "
             . "FROM `" . static::$_db_table_forum_info . "` `f`, `" . static::$_db_table_membre . "` `m` "
             . "WHERE `f`.`id_contact` = `m`.`id_contact` "
             . "AND `f`.`id_forum` = '" . $db->escape($id_forum) . "'";

        return $db->queryWithFetchFirstRow($sql);
    }

    /**
     * retourne le listing des forums
     *
     * @return array
     */
    public static function getForums()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `f`.`id_forum`, `f`.`title`, `f`.`description`, "
             . "`f`.`nb_messages`, `f`.`nb_threads`, "
             . "`f`.`id_contact`, `m`.`pseudo`, `f`.`date` "
             . "FROM `" . static::$_db_table_forum_info . "` `f`, `" . static::$_db_table_membre . "` `m` "
             . "WHERE `f`.`id_contact` = `m`.`id_contact` "
             . "ORDER BY `f`.`id_forum` ASC";

        return $db->queryWithFetch($sql);
    }

    /**
     * Retourne l'id forum à partir de l'id thread
     *
     * @param int $id_thread
     * @return string $id_forum
     */
    public static function getIdForumByIdThread($id_thread)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_forum` "
             . "FROM `" . static::$_db_table_forum_thread . "` "
             . "WHERE `id_thread` = " . (int) $id_thread;

        return $db->queryWithFetchFirstField($sql);
    }

    /**
     * ajoute un message
     *
     * @param array int ['id_contact']
     *              str ['text']
     *              str ['id_forum']
     *              int ['id_thread'] (opt.)
     *              str ['subject'] (opt.)
     * @return int $id_message
     */
    public static function addMessage($params)
    {
        $new_thread = true;
        if(array_key_exists('id_thread', $params)) {
            if(is_numeric($params['id_thread']) && $params['id_thread'] > 0) {
                $new_thread = false;
            }
        }

        if($new_thread) {
            if(!array_key_exists('subject', $params)) {
                throw new Exception('sujet manquant');
            }
            if(strlen($params['subject']) == 0) {
                throw new Exception('sujet vide');
            }
            $params['id_thread'] = static::_createThread(array(
                'id_forum'   => $params['id_forum'],
                'subject'    => $params['subject'],
                'id_contact' => $params['id_contact'],
            ));
            static::_updateForum(array(
                'id_forum'     => $params['id_forum'],
                'id_contact'   => $params['id_contact'],
                'msgaction'    => '',
                'threadaction' => 'threadadd',
            ));
        }

        $id_message = static::_createMessage(array(
            'id_thread'  => $params['id_thread'],
            'id_contact' => $params['id_contact'],
            'text'       => $params['text'],
        ));

        static::_updateThread(array(
            'id_thread'  => $params['id_thread'],
            'id_contact' => $params['id_contact'],
            'action'     => 'msgadd',
        ));

        static::_updateForum(array(
            'id_forum'     => $params['id_forum'],
            'id_contact'   => $params['id_contact'],
            'msgaction'    => 'msgadd',
            'threadaction' => '',
        ));

        return array(
            'id_message' => $id_message,
            'id_thread' => $params['id_thread'],
            'id_forum' => $params['id_forum'],
        );
    }

    /**
     * Edite un message
     *
     * @param array
     * @return bool
     *
     */
    public static function editMessage($params)
    {
        static::_updateMessage(array(
            'id_message' => $params['id_message'],
            'text'       => $params['text'],
        ));

        static::_updateThread(array(
            'id_thread'  => $params['id_thread'],
            'id_contact' => $params['id_contact'],
            'action'     => 'msgedit',
        ));

        static::_updateForum(array(
            'id_forum'     => $params['id_forum'],
            'id_contact'   => null,
            'msgaction'    => 'msgedit',
            'threadaction' => '',
        ));

        return true;
    }

    /**
     * Efface un message
     *
     * @param array
     * @return bool
     */
    public static function delMessage($params)
    {
        static::_deleteMessage(array(
            'id_message' => $params['id_message'],
        ));

        static::_updateThread(array(
            'id_thread'  => $params['id_thread'],
            'id_contact' => $params['id_contact'],
            'action'     => 'msgdel',
        ));

        static::_updateForum(array(
            'id_forum'     => $params['id_forum'],
            'id_contact'   => null,
            'msgaction'    => 'msgdel',
            'threadaction' => '',
        ));

        return true;
    }

    /**
     * augmente le compteur de visite d'un thread
     *
     * @param int $id_thread
     * @return bool
     */
    public static function addView($id_thread)
    {
        $db = DataBase::getInstance();

        $sql = "UPDATE `" . static::$_db_table_forum_thread . "` "
             . "SET `nb_views` = `nb_views` + 1 "
             . "WHERE `id_thread` = " . (int) $id_thread;

        $db->query($sql);
    }

    /**
     * compte le nombre de threads par forum
     *
     * @return array ou int
     */
    public static function getThreadsCount($id_forum = null)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `f`.`id_forum` , COUNT( * ) AS `nb_threads` "
             . "FROM (`" . static::$_db_table_forum_info . "` `f`) "
             . "LEFT JOIN `" . static::$_db_table_forum_thread . "` `t` ON `f`.`id_forum` = `t`.`id_forum` "
             . "GROUP BY `f`.`id_forum` ASC";

        $res = $db->queryWithFetch($sql);

        $tab = array();
        foreach($res as $_res) {
            $tab[$_res['id_forum']] = $_res['nb_threads'];
        }

        if(!is_null($id_forum) && !empty($id_forum)) {
            return (int) $tab[$id_forum];
        }
        return $tab;
    }

    /**
     * compte le nombre de messages par forum
     *
     * @return array ou int
     */
    public static function getMessagesCount($id_forum = null)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_forum`, COUNT(*) AS `nb_messages` "
             . "FROM `" . static::$_db_table_forum_message . "` `m`, `" . static::$_db_table_forum_thread . "` `t` "
             . "WHERE `m`.`id_thread` = `t`.`id_thread` "
             . "GROUP BY `t`.`id_forum` ASC";

        $res = $db->queryWithFetch($sql);

        $tab = array();
        foreach($res as $_res) {
            $tab[$_res['id_forum']] = $_res['nb_messages'];
        }

        if(!is_null($id_forum)) {
            return (int) $tab[$id_forum];
        }
        return $tab;
    }

    /**
     * @param array int ['id_thread']
     *              int ['id_contact']
     *              str ['text']
     * @return int $id_message
     */
    protected static function _createMessage($params)
    {
        $db = DataBase::getInstance();

        $sql = "INSERT INTO `" . static::$_db_table_forum_message . "` "
             . "(`id_thread`, "
             . "`created_on`, `modified_on`, "
             . "`created_by`, `modified_by`, "
             . "`text`) "
             . "VALUE (" . (int) $params['id_thread'] . ", "
             . "NOW(), FALSE, "
             . (int) $params['id_contact'] . ", 0, "
             . "'" . $db->escape($params['text']) . "')";

         $db->query($sql);

         return (int) $db->insertId();
    }

    /**
     * met à jour la table message
     * après update d'un message ?
     * @param array ['id_message']
     *              ['id_contact']
     *              ['text']
     * @return bool
     */
    protected static function _updateMessage($params)
    {
        $db = DataBase::getInstance();

        $sql = "UPDATE `" . static::$_db_table_forum_message . "` "
             . "SET `text` = '" . $db->escape($params['text']. "', "
             . "`modified_on` = NOW(), "
             . "`modified_by` = " . (int) $params['id_contact']) . " "
             . "WHERE `id_message` = " . (int) $params['id_message'];

        $db->query($sql);

        return (int) $db->affectedRows();
    }

    /**
     * Efface un message
     *
     * @param array ['id_message']
     * @return bool
     */
    protected static function _deleteMessage($params)
    {
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . static::$_db_table_forum_message . "` "
             . "WHERE `id_message` = " . (int) $params['id_message'];

        $db->query($sql);

        return (int) $db->affectedRows();
    }

    /**
     * création d'un nouveau thread
     * @param array ['id_forum']
     *              ['id_contact']
     *              ['subject']
     */
    protected static function _createThread($params)
    {
        $db = DataBase::getInstance();

        $sql = "INSERT INTO `" . static::$_db_table_forum_thread . "` "
             . "(`created_on`, `modified_on`, "
             . "`created_by`, `modified_by`, "
             . "`id_forum`, `nb_messages`, `nb_views`, `subject`) "
             . "VALUES ( NOW(), FALSE, "
             . (int) $params['id_contact'] . ", 0, "
             . "'" . $db->escape($params['id_forum']) ."', 0, 0, '" . $db->escape($params['subject']) . "')";

        $db->query($sql);

        return $db->insertId();
    }

    /**
     * met à jour la table thread
     *
     * @param array ['action'] msgadd|msgedit|msgdel
     *              ['id_contact']
     *              ['id_thread']
     * @return bool
     */
    protected static function _updateThread($params)
    {
        $db = DataBase::getInstance();

        $sql = "UPDATE `" . static::$_db_table_forum_thread . "` SET ";
        if($params['action'] == 'msgadd') {
             $sql .= "`nb_messages` = `nb_messages` + 1, ";
        } elseif($params['action'] == 'msgdel') {
             $sql .= "`nb_messages` = `nb_messages` - 1, ";
        }

        $sql .= "`modified_on` = NOW(), "
             .  "`modified_by` = " . (int) $params['id_contact'] . " "
             .  "WHERE `id_thread` = " . (int) $params['id_thread'];

        $db->query($sql);

        return $db->affectedRows();
    }

    /**
     * Efface un thread
     *
     * @param array
     * @return bool
     */
    protected static function _deleteThread($params)
    {
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . static::$_db_table_forum_thread . "` "
             . "WHERE `id_thread` = " . (int) $params['id_thread'];

        $db->query($sql);

        return $db->affectedRows();
    }

    /**
     * met à jour la table forum
     * après insertion d'un message
     *
     * @param array ['msgaction'] msgadd|msgedit|msgdel
     *              ['threadaction'] threadadd|threadedit|threaddel
     *              ['id_contact']
     *              ['id_forum']
     * @return bool
     */
    protected static function _updateForum($params = array())
    {
        $db = DataBase::getInstance();

        $sql = "UPDATE `" . static::$_db_table_forum_info . "` SET ";
        if($params['msgaction'] == 'msgadd') {
            $sql .= "`nb_messages` = `nb_messages` + 1, ";
        } elseif($params['msgaction'] == 'msgdel') {
            $sql .= "`nb_messages` = `nb_messages` - 1, ";
        }
        if($params['threadaction'] == 'threadadd') {
            $sql .= "`nb_threads` = `nb_threads` + 1, ";
        } elseif($params['threadaction'] == 'threaddel') {
            $sql .= "`nb_threads` = `nb_threads` - 1, ";
        }
        if($params['id_contact']) {
            $sql .= "`id_contact` = " . (int) $params['id_contact'] . ", `date` = NOW() ";
        }
        $sql .= "WHERE `id_forum` = '" . $db->escape($params['id_forum']) . "'";

        $db->query($sql);
    }
}
