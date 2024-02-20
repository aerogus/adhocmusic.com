<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Utils\DataBase;

define('FORUM_NB_THREADS_PER_PAGE', 100);
define('FORUM_NB_MESSAGES_PER_PAGE', 50);

/**
 * Classe de gestion des forums
 *
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
abstract class Forum
{
    /**
     * @var string
     */
    protected static string $db_table_forum_info = 'adhoc_forum_info';

    /**
     * @var string
     */
    protected static string $db_table_forum_thread = 'adhoc_forum_thread';

    /**
     * @var string
     */
    protected static string $db_table_forum_message = 'adhoc_forum_message';

    /**
     * Chemin des smileys
     *
     * @var string
     */
    protected static string $path_smileys = 'https://www.adhocmusic.com/img/smileys/';

    /**
     * Liste des smileys a parser
     *
     * @var array<array<string>>
     */
    protected static array $smileys = [
        [":afro:",   "afro.gif"],
        [":angry:",  "angry.gif"],
        [":beer:",   "beer.gif"],
        [":chin:",   "chinois.gif"],
        [":pleure:", "pleure.gif"],
        [":yes:",    "yaisse.gif"],
        [":metal:",  "metalleux.gif"],
        [":grr:",    "grr.gif"],
        [":-D",      "laugh.gif"],
        [":love:",   "love.gif"],
        [":non:",    "non.gif"],
        [":ouch:",   "ouch.gif"],
        [":-\\",     "embarasse.gif"],
        [";-)",      "wink.gif"],
        [";-(",      "triste.gif"],
        [";o)",      "ouf.gif"],
        [":prof:",   "prof.gif"],
        [":-)",      "smile.gif"],
        [":yeah:",   "yeah.gif"],
        [":devil:",  "devil.gif"],
        [":cool:",   "cool.gif"],
        [":flower:", "flower.gif"],
        [":music:",  "music.gif"],
    ];

    /**
     * Parse le message avec les différentes conventions des forums AD'HOC (smiley, pseudo html etc ...)
     *
     * @param string $texte texte
     * @param bool   $wiki  wiki
     *
     * @return string
     */
    public static function parseMessage(string $texte, bool $wiki = false): string
    {
        // 1 - gestion des frimousses
        foreach (self::$smileys as $smiley) {
            // [0] = code / [1] nom du fichier .gif
            $texte = str_replace($smiley[0], "<img src='" . self::$path_smileys . $smiley[1] . "' alt='' />", $texte);
        }

        // 2 - gestion du texte enrichi

        // les gens qui ne respectent pas la casse sont vraiment des tannards !!!
        $texte = str_replace("[B]", "<b>", $texte);
        $texte = str_replace("[/B]", "</b>", $texte);
        $texte = str_replace("[b]", "<b>", $texte);
        $texte = str_replace("[/b]", "</b>", $texte);
        $texte = str_replace("[I]", "<i>", $texte);
        $texte = str_replace("[/I]", "</i>", $texte);
        $texte = str_replace("[i]", "<i>", $texte);
        $texte = str_replace("[/i]", "</i>", $texte);
        $texte = str_replace("[U]", "<u>", $texte);
        $texte = str_replace("[/U]", "</u>", $texte);
        $texte = str_replace("[u]", "<u>", $texte);
        $texte = str_replace("[/u]", "</u>", $texte);
        $texte = str_replace("[H1]", "<h1>", $texte);
        $texte = str_replace("[/H1]", "</h1>", $texte);
        $texte = str_replace("[h1]", "<h1>", $texte);
        $texte = str_replace("[/h1]", "</h1>", $texte);
        $texte = str_replace("[H2]", "<h2>", $texte);
        $texte = str_replace("[/H2]", "</h2>", $texte);
        $texte = str_replace("[h2]", "<h2>", $texte);
        $texte = str_replace("[/h2]", "</h2>", $texte);
        $texte = str_replace("[H3]", "<h3>", $texte);
        $texte = str_replace("[/H3]", "</h3>", $texte);
        $texte = str_replace("[h3]", "<h3>", $texte);
        $texte = str_replace("[/h3]", "</h3>", $texte);
        $texte = str_replace("[H4]", "<h4>", $texte);
        $texte = str_replace("[/H4]", "</h4>", $texte);
        $texte = str_replace("[h4]", "<h4>", $texte);
        $texte = str_replace("[/h4]", "</h4>", $texte);
        $texte = str_replace("[H5]", "<h5>", $texte);
        $texte = str_replace("[/H5]", "</h5>", $texte);
        $texte = str_replace("[h5]", "<h5>", $texte);
        $texte = str_replace("[/h5]", "</h5>", $texte);
        $texte = str_replace("[H6]", "<h6>", $texte);
        $texte = str_replace("[/H6]", "</h6>", $texte);
        $texte = str_replace("[h6]", "<h6>", $texte);
        $texte = str_replace("[/h6]", "</h6>", $texte);

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
     * Retourne les infos d'un forum
     *
     * @param string $id_forum id_forum
     *
     * @return array<string,string>
     */
    public static function getForum(string $id_forum): array
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `f`.`id_forum`, `f`.`title`, `f`.`description`, "
             . "`f`.`nb_messages`, `f`.`nb_threads`, "
             . "`f`.`id_contact`, `m`.`pseudo`, `f`.`date` "
             . "FROM `" . static::$db_table_forum_info . "` `f`, `" . Membre::getDbTable() . "` `m` "
             . "WHERE `f`.`id_contact` = `m`.`id_contact` "
             . "AND `f`.`id_forum` = '" . $id_forum . "'";

        return $db->queryWithFetchFirstRow($sql);
    }

    /**
     * Retourne le listing des forums
     *
     * @return array<array<string,string>>
     */
    public static function getForums(): array
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `f`.`id_forum`, `f`.`title`, `f`.`description`, "
             . "`f`.`nb_messages`, `f`.`nb_threads`, "
             . "`f`.`id_contact`, `m`.`pseudo`, `f`.`date` "
             . "FROM `" . static::$db_table_forum_info . "` `f`, `" . Membre::getDbTable() . "` `m` "
             . "WHERE `f`.`id_contact` = `m`.`id_contact` "
             . "ORDER BY `f`.`id_forum` ASC";

        return $db->queryWithFetch($sql);
    }

    /**
     * Retourne l'id forum à partir de l'id thread
     *
     * @param int $id_thread id_thread
     *
     * @return string $id_forum
     */
    public static function getIdForumByIdThread(int $id_thread): string
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_forum` "
             . "FROM `" . static::$db_table_forum_thread . "` "
             . "WHERE `id_thread` = " . $id_thread;

        return $db->queryWithFetchFirstField($sql);
    }

    /**
     * Ajoute un message
     *
     * @param array<string,mixed> $params[
     *                                'id_contact' => int,
     *                                'text' => string,
     *                                'id_forum' => string,
     *                                'id_thread' => int, (opt.)
     *                                'subject' => string, (opt.)
     *                            ]
     *
     * @return array<string,int>
     */
    public static function addMessage(array $params)
    {
        $new_thread = true;
        if (array_key_exists('id_thread', $params)) {
            if (is_numeric($params['id_thread']) && $params['id_thread'] > 0) {
                $new_thread = false;
            }
        }

        if ($new_thread) {
            if (!array_key_exists('subject', $params)) {
                throw new \Exception('sujet manquant');
            }
            if (strlen($params['subject']) === 0) {
                throw new \Exception('sujet vide');
            }
            $params['id_thread'] = static::createThread(
                [
                    'id_forum'   => $params['id_forum'],
                    'subject'    => $params['subject'],
                    'id_contact' => $params['id_contact'],
                ]
            );
            static::updateForum(
                [
                    'id_forum'     => $params['id_forum'],
                    'id_contact'   => $params['id_contact'],
                    'msgaction'    => '',
                    'threadaction' => 'threadadd',
                ]
            );
        }

        $id_message = static::createMessage(
            [
                'id_thread'  => $params['id_thread'],
                'id_contact' => $params['id_contact'],
                'text'       => $params['text'],
            ]
        );

        static::updateThread(
            [
                'id_thread'  => $params['id_thread'],
                'id_contact' => $params['id_contact'],
                'action'     => 'msgadd',
            ]
        );

        static::updateForum(
            [
                'id_forum'     => $params['id_forum'],
                'id_contact'   => $params['id_contact'],
                'msgaction'    => 'msgadd',
                'threadaction' => '',
            ]
        );

        return [
            'id_message' => $id_message,
            'id_thread' => $params['id_thread'],
            'id_forum' => $params['id_forum'],
        ];
    }

    /**
     * Édite un message
     *
     * @param array<string,mixed> $params[
     *                                'id_message' => int,
     *                                'id_thread' => int,
     *                                'id_contact' => int,
     *                                'text' => string,
     *                                'id_forum' => string,
     *                            ]
     *
     * @return bool
     */
    public static function editMessage(array $params): bool
    {
        static::updateMessage(
            [
                'id_message' => $params['id_message'],
                'text'       => $params['text'],
            ]
        );

        static::updateThread(
            [
                'id_thread'  => $params['id_thread'],
                'id_contact' => $params['id_contact'],
                'action'     => 'msgedit',
            ]
        );

        static::updateForum(
            [
                'id_forum'     => $params['id_forum'],
                'id_contact'   => null,
                'msgaction'    => 'msgedit',
                'threadaction' => '',
            ]
        );

        return true;
    }

    /**
     * Efface un message
     *
     * @param array<string,mixed> $params[
     *                                'id_message' => int,
     *                                'id_thread' => int,
     *                                'id_contact' => int,
     *                                'id_forum' => string,
     *                            ]
     *
     * @return bool
     */
    public static function delMessage(array $params): bool
    {
        static::deleteMessage(
            [
                'id_message' => $params['id_message'],
            ]
        );

        static::updateThread(
            [
                'id_thread'  => $params['id_thread'],
                'id_contact' => $params['id_contact'],
                'action'     => 'msgdel',
            ]
        );

        static::updateForum(
            [
                'id_forum'     => $params['id_forum'],
                'id_contact'   => null,
                'msgaction'    => 'msgdel',
                'threadaction' => '',
            ]
        );

        return true;
    }

    /**
     * Augmente le compteur de visite d'un thread
     *
     * @param int $id_thread id_thread
     *
     * @return bool
     */
    public static function addView(int $id_thread): bool
    {
        $db = DataBase::getInstance();

        $sql = "UPDATE `" . static::$db_table_forum_thread . "` "
             . "SET `nb_views` = `nb_views` + 1 "
             . "WHERE `id_thread` = " . $id_thread;

        $db->query($sql);

        return true;
    }

    /**
     * Compte le nombre de threads par forum
     *
     * @param string $id_forum id_forum
     *
     * @return array<string,int>|int
     */
    public static function getThreadsCount(string $id_forum = null): array|int
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `f`.`id_forum` , COUNT( * ) AS `nb_threads` "
             . "FROM (`" . static::$db_table_forum_info . "` `f`) "
             . "LEFT JOIN `" . static::$db_table_forum_thread . "` `t` ON `f`.`id_forum` = `t`.`id_forum` "
             . "GROUP BY `f`.`id_forum` ASC";

        $res = $db->queryWithFetch($sql);

        $tab = [];
        foreach ($res as $_res) {
            $tab[$_res['id_forum']] = (int) $_res['nb_threads'];
        }

        if (!is_null($id_forum) && !empty($id_forum)) {
            return $tab[$id_forum];
        }
        return $tab;
    }

    /**
     * Compte le nombre de messages par forum
     *
     * @param string $id_forum id_forum
     *
     * @return array<string,int>|int
     */
    public static function getMessagesCount(string $id_forum = null): array|int
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_forum`, COUNT(*) AS `nb_messages` "
             . "FROM `" . static::$db_table_forum_message . "` `m`, `" . static::$db_table_forum_thread . "` `t` "
             . "WHERE `m`.`id_thread` = `t`.`id_thread` "
             . "GROUP BY `t`.`id_forum` ASC";

        $res = $db->queryWithFetch($sql);

        $tab = [];
        foreach ($res as $_res) {
            $tab[$_res['id_forum']] = (int) $_res['nb_messages'];
        }

        if (!is_null($id_forum)) {
            return $tab[$id_forum];
        }
        return $tab;
    }

    /**
     * @param array<string,mixed> $params[
     *                                'id_thread' => int,
     *                                'id_contact' => int,
     *                                'text' => string,
     *                            ]
     *
     * @return int $id_message
     */
    protected static function createMessage(array $params): int
    {
        $db = DataBase::getInstance();

        $sql = "INSERT INTO `" . static::$db_table_forum_message . "` "
             . "(`id_thread`, "
             . "`created_at`, `modified_at`, "
             . "`created_by`, `modified_by`, "
             . "`text`) "
             . "VALUE (" . (int) $params['id_thread'] . ", "
             . "NOW(), NOW(), "
             . (int) $params['id_contact'] . ", " . (int) $params['id_contact'] . ", "
             . "'" . $params['text'] . "')";

         $db->query($sql);

         return (int) $db->insertId();
    }

    /**
     * Met à jour la table message
     * après update d'un message ?
     *
     * @param array<string,mixed> $params[
     *                                'id_message' => int,
     *                                'id_contact' => int,
     *                                'text' => string,
     *                            ]
     *
     * @return bool
     */
    protected static function updateMessage(array $params): bool
    {
        $db = DataBase::getInstance();

        $sql = "UPDATE `" . static::$db_table_forum_message . "` "
             . "SET `text` = '" . $params['text'] . "', "
             . "`modified_at` = NOW(), "
             . "`modified_by` = " . (int) $params['id_contact'] . " "
             . "WHERE `id_message` = " . (int) $params['id_message'];

        $db->query($sql);

        return (bool) $db->affectedRows();
    }

    /**
     * Efface un message
     *
     * @param array<string,int> $params[
     *                              'id_message' => int,
     *                          ]
     *
     * @return bool
     */
    protected static function deleteMessage(array $params): bool
    {
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . static::$db_table_forum_message . "` "
             . "WHERE `id_message` = " . (int) $params['id_message'];

        $db->query($sql);

        return (bool) $db->affectedRows();
    }

    /**
     * Création d'un nouveau thread
     *
     * @param array<string,mixed> $params[
     *                                'id_forum' => string,
     *                                'id_contact' => int,
     *                                'subject' => string,
     *                            ]
     *
     * @return int
     */
    protected static function createThread(array $params): int
    {
        $db = DataBase::getInstance();

        $sql = "INSERT INTO `" . static::$db_table_forum_thread . "` "
             . "(`created_at`, `modified_at`, "
             . "`created_by`, `modified_by`, "
             . "`id_forum`, `nb_messages`, `nb_views`, `subject`) "
             . "VALUES (NOW(), NOW(), "
             . (int) $params['id_contact'] . ", " . (int) $params['id_contact'] . ", "
             . "'" . $params['id_forum'] . "', 0, 0, '" . $params['subject'] . "')";

        $db->query($sql);

        return (int) $db->insertId();
    }

    /**
     * Met à jour la table thread
     *
     * @param array<string,mixed> $params[
     *                                'action' => string, (msgadd|msgedit|msgdel)
     *                                'id_contact' => int,
     *                                'id_thread' => int,
     *                            ]
     *
     * @return bool
     */
    protected static function updateThread(array $params): bool
    {
        $db = DataBase::getInstance();

        $sql = "UPDATE `" . static::$db_table_forum_thread . "` SET ";
        if ($params['action'] === 'msgadd') {
             $sql .= "`nb_messages` = `nb_messages` + 1, ";
        } elseif ($params['action'] === 'msgdel') {
             $sql .= "`nb_messages` = `nb_messages` - 1, ";
        }

        $sql .= "`modified_at` = NOW(), "
             . "`modified_by` = " . (int) $params['id_contact'] . " "
             . "WHERE `id_thread` = " . (int) $params['id_thread'];

        $db->query($sql);

        return (bool) $db->affectedRows();
    }

    /**
     * Efface un thread
     *
     * @param array<string,int> $params[
     *                                'id_thread' => int,
     *                          ]
     *
     * @return bool
     */
    protected static function deleteThread(array $params): bool
    {
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . static::$db_table_forum_thread . "` "
             . "WHERE `id_thread` = " . (int) $params['id_thread'];

        $db->query($sql);

        return (bool) $db->affectedRows();
    }

    /**
     * Met à jour la table forum
     * après insertion d'un message
     *
     * @param array<string,mixed> $params[
     *                                'msgaction' => string, (msgadd|msgedit|msgdel)
     *                                'threadaction' => string, (threadadd|threadedit|threaddel)
     *                                'id_contact' => int,
     *                                'id_forum' => string,
     *                            ]
     *
     * @return bool
     */
    protected static function updateForum(array $params = []): bool
    {
        $db = DataBase::getInstance();

        $sql = "UPDATE `" . static::$db_table_forum_info . "` SET ";
        if ($params['msgaction'] === 'msgadd') {
            $sql .= "`nb_messages` = `nb_messages` + 1, ";
        } elseif ($params['msgaction'] === 'msgdel') {
            $sql .= "`nb_messages` = `nb_messages` - 1, ";
        }
        if ($params['threadaction'] === 'threadadd') {
            $sql .= "`nb_threads` = `nb_threads` + 1, ";
        } elseif ($params['threadaction'] === 'threaddel') {
            $sql .= "`nb_threads` = `nb_threads` - 1, ";
        }
        if ($params['id_contact']) {
            $sql .= "`id_contact` = " . (int) $params['id_contact'] . ", `date` = NOW() ";
        }
        $sql .= "WHERE `id_forum` = '" . $params['id_forum'] . "'";

        $db->query($sql);

        return (bool) $db->affectedRows();
    }
}
