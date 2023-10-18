<?php declare(strict_types=1);

/**
 * Gestion des logs debug/action
 *
 * @todo extends ObjectModel
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Log
{
    // liste des actions utilisateur à logguer
    // @todo migrer dans LogAction
    const ACTION_MEMBER_CREATE         =  1;
    const ACTION_MEMBER_EDIT           =  2;
    const ACTION_MEMBER_DELETE         =  3;
    const ACTION_GROUP_CREATE          =  4;
    const ACTION_GROUP_EDIT            =  5;
    const ACTION_GROUP_DELETE          =  6;
    const ACTION_EVENT_CREATE          =  7;
    const ACTION_EVENT_EDIT            =  8;
    const ACTION_EVENT_DELETE          =  9;
    const ACTION_LIEU_CREATE           = 10;
    const ACTION_LIEU_EDIT             = 11;
    const ACTION_LIEU_DELETE           = 12;
    const ACTION_PHOTO_CREATE          = 13;
    const ACTION_PHOTO_EDIT            = 14;
    const ACTION_PHOTO_DELETE          = 15;
    const ACTION_AUDIO_CREATE          = 16;
    const ACTION_AUDIO_EDIT            = 17;
    const ACTION_AUDIO_DELETE          = 18;
    const ACTION_VIDEO_CREATE          = 19;
    const ACTION_VIDEO_EDIT            = 20;
    const ACTION_VIDEO_DELETE          = 21;
    const ACTION_ARTICLE_CREATE        = 22;
    const ACTION_ARTICLE_EDIT          = 23;
    const ACTION_ARTICLE_DELETE        = 24;
    const ACTION_FORUM_CREATE          = 25;
    const ACTION_FORUM_EDIT            = 26;
    const ACTION_FORUM_DELETE          = 27;
    const ACTION_LOGIN                 = 28;
    const ACTION_LOGIN_FACEBOOK        = 29;
    const ACTION_LOGIN_FAILED          = 30;
    const ACTION_LOGOUT                = 31;
    const ACTION_SEARCH                = 32;
    const ACTION_CONTACT               = 33;
    const ACTION_MESSAGE               = 34;
    const ACTION_PASSWORD_CHANGED      = 35;
    const ACTION_PASSWORD_REQUESTED    = 36;
    const ACTION_WATCH_BROADCAST       = 37;
    const ACTION_ALERTING_GROUPE_SUB   = 38;
    const ACTION_ALERTING_GROUPE_UNSUB = 39;
    const ACTION_ALERTING_LIEU_SUB     = 40;
    const ACTION_ALERTING_LIEU_UNSUB   = 41;
    const ACTION_ALERTING_EVENT_SUB    = 42;
    const ACTION_ALERTING_EVENT_UNSUB  = 43;
    const ACTION_COMMENT_CREATE        = 44;
    const ACTION_COMMENT_EDIT          = 45;
    const ACTION_COMMENT_DELETE        = 46;
    const ACTION_NEWSLETTER_SUB        = 47;
    const ACTION_NEWSLETTER_UNSUB      = 48;

    /**
     * @var array<int,string>
     * @todo migrer dans LogAction
     */
    protected static array $_actions = [
        self::ACTION_MEMBER_CREATE         => "Création d'un compte membre",
        self::ACTION_MEMBER_EDIT           => "Edition d'un compte membre",
        self::ACTION_MEMBER_DELETE         => "Suppression d'un compte membre",
        self::ACTION_GROUP_CREATE          => "Inscription d'un groupe",
        self::ACTION_GROUP_EDIT            => "Edition d'un groupe",
        self::ACTION_GROUP_DELETE          => "Suppression d'un groupe",
        self::ACTION_EVENT_CREATE          => "Ajout d'un événement",
        self::ACTION_EVENT_EDIT            => "Edition d'un événement",
        self::ACTION_EVENT_DELETE          => "Suppression d'un événement",
        self::ACTION_LIEU_CREATE           => "Ajout d'un lieu",
        self::ACTION_LIEU_EDIT             => "Edition d'un lieu",
        self::ACTION_LIEU_DELETE           => "Suppression d'un lieu",
        self::ACTION_PHOTO_CREATE          => "Ajout d'une photo",
        self::ACTION_PHOTO_EDIT            => "Edition d'une photo",
        self::ACTION_PHOTO_DELETE          => "Suppression d'une photo",
        self::ACTION_AUDIO_CREATE          => "Ajout d'un son",
        self::ACTION_AUDIO_EDIT            => "Edition d'un son",
        self::ACTION_AUDIO_DELETE          => "Suppression d'un son",
        self::ACTION_VIDEO_CREATE          => "Ajout d'une vidéo",
        self::ACTION_VIDEO_EDIT            => "Edition d'une vidéo",
        self::ACTION_VIDEO_DELETE          => "Suppression d'une vidéo",
        self::ACTION_ARTICLE_CREATE        => "Création d'un article",
        self::ACTION_ARTICLE_EDIT          => "Edition d'un article",
        self::ACTION_ARTICLE_DELETE        => "Suppression d'un article",
        self::ACTION_FORUM_CREATE          => "Ajout d'un message à un forum",
        self::ACTION_FORUM_EDIT            => "Edition d'un message d'un forum",
        self::ACTION_FORUM_DELETE          => "Suppression d'un message d'un forum",
        self::ACTION_LOGIN                 => "Identification OK",
        self::ACTION_LOGIN_FACEBOOK        => "Identification via Facebook",
        self::ACTION_LOGIN_FAILED          => "Identification KO",
        self::ACTION_LOGOUT                => "Déconnexion",
        self::ACTION_SEARCH                => "Requête de recherche",
        self::ACTION_CONTACT               => "Envoi d'un message via formulaire de contact",
        self::ACTION_MESSAGE               => "Envoi d'un message privé",
        self::ACTION_PASSWORD_CHANGED      => "Password modifié",
        self::ACTION_PASSWORD_REQUESTED    => "Envoi d'un nouveau password",
        self::ACTION_WATCH_BROADCAST       => "Regarde le concert live",
        self::ACTION_ALERTING_GROUPE_SUB   => "Abonnement alerte groupe",
        self::ACTION_ALERTING_GROUPE_UNSUB => "Désabonnement alerte groupe",
        self::ACTION_ALERTING_LIEU_SUB     => "Abonnement alerte lieu",
        self::ACTION_ALERTING_LIEU_UNSUB   => "Désabonnement alerte lieu",
        self::ACTION_ALERTING_EVENT_SUB    => "Abonnement alerte événement",
        self::ACTION_ALERTING_EVENT_UNSUB  => "Désabonnement alerte événement",
        self::ACTION_COMMENT_CREATE        => "Création d'un commentaire",
        self::ACTION_COMMENT_EDIT          => "Edition d'un commentaire",
        self::ACTION_COMMENT_DELETE        => "Suppression d'un commentaire",
        self::ACTION_NEWSLETTER_SUB        => "Inscription à la newsletter",
        self::ACTION_NEWSLETTER_UNSUB      => "Désinscription de la newsletter",
    ];

    /**
     * @var string
     */
    protected static $_log_file = null;

    /**
     * @var string
     */
    protected static $_log = '';

    /**
     * @param string $file file
     * @param string $log  log
     * @param bool   $save save
     */
    static function write(string $file, string $log, bool $save = false)
    {
        return self::_write($file, $log, $save);
    }

    /**
     *
     */
    static function action(int $action, $extra = null)
    {
        $db = DataBase::getInstance();

        $id_contact = 'NULL';
        $pseudo = '';
        if (!empty($_SESSION['membre'])) {
            $id_contact = (int) $_SESSION['membre']->getId();
            $pseudo = (string) $_SESSION['membre']->getPseudo();
        }

        $ip = '';
        if (!empty($_SESSION['ip'])) {
            $ip = $_SESSION['ip'];
        }

        $host = '';
        if (!empty($_SESSION['host'])) {
            $host = $_SESSION['host'];
        }

        $extra = (string) $extra;

        self::_write('action', 'membre=' . $pseudo . ' (' . $id_contact . ') - action=' . self::$_actions[$action] . ' -  extra=' . $extra);

        Email::send(
            DEBUG_EMAIL,
            '[log-action] ' . $pseudo . ' ' . self::$_actions[$action],
            'log-action',
            [
                'pseudo' => $pseudo,
                'action' => self::$_actions[$action],
                'extra'  => $extra,
            ]
        );

        $sql = "INSERT INTO `adhoc_log_action` "
             . "(`datetime`, `action`, "
             . "`id_contact`, `extra`, "
             . "`ip`, `host`) "
             . "VALUES(NOW(), " . (int) $action . ", "
             . $id_contact . ", '".$db->escape($extra)."', "
             . "'" . $db->escape($ip) . "', '" . $db->escape($host) . "')";

        return $db->query($sql);
    }

    /**
     * Écriture dans le fichier
     *
     * @param string $type type
     * @param string $text message
     * @param bool   $save sauver ?
     *
     * @return bool
     */
    protected static function _write(string $type, string $text, bool $save = false)
    {
        self::$_log_file = ADHOC_ROOT_PATH . '/log/' . strtolower(substr($type, 0, 12)) . '.log';

        if (!file_exists(self::$_log_file)) {
            touch(self::$_log_file);
        }

        $line = date('Y-m-d H:i:s') . ' - ' . $text;

        if ($save) {
            self::$_log .= $line . "\n";
        }

        $out = false;
        if (is_writable(self::$_log_file)) {
            if ($fp = fopen(self::$_log_file, "a+")) {
                if (fwrite($fp, $line . "\n") !== false) {
                    $out = true;
                }
                fclose($fp);
            }
        }
        return $out;
    }

    /**
     * Récupère les logs action
     *
     * @param int $action filtrer un type d'événement
     *
     * @return array
     */
    static function getLogsAction(int $action)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `l`.`datetime`, `l`.`action`, `l`.`id_contact`, "
             . "`m`.`pseudo`, `l`.`ip`, `l`.`host`, `l`.`extra` "
             . "FROM (`adhoc_log_action` `l`) "
             . "LEFT JOIN `adhoc_membre` `m` ON (`m`.`id_contact` = `l`.`id_contact`) ";
        if ($action > 0) {
            $sql .= "WHERE `l`.`action` = " . (int) $action . " ";
        }
        $sql .= "ORDER BY `l`.`datetime` DESC";

        $logs = $db->queryWithFetch($sql);

        foreach ($logs as $key => $log) {
            $logs[$key]['actionlib'] = self::$_actions[$log['action']];
        }

        return $logs;
    }

    /**
     * @return string
     */
    static function getLog(): string
    {
        return self::$_log;
    }

    /**
     * @return array
     */
    static function getActions(): array
    {
        return self::$_actions;
    }
}
