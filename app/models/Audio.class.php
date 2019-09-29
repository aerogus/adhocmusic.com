<?php declare(strict_types=1);

/**
 * Classe Audio
 *
 * Classe de gestion des audios du site
 * Appel des conversions etc ...
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Audio extends Media
{
    /**
     * @var object
     */
    protected static $_instance = null;

    /**
     * @var string
     */
    protected static $_pk = 'id_audio';

    /**
     * @var string
     */
    protected static $_table = 'adhoc_audio';

    /**
     * @var int
     */
    protected $_id_audio = 0;

    /**
     * @var string
     */
    protected $_mime = '';

    /**
     * Liste des attributs de l'objet
     * on précise si en base c'est de type :
     * - numérique/integer/float/bool (= int)
     * - datetime/text (= str)
     * ceci est utile pour la formation de la requête
     *
     * @var array
     */
    protected static $_all_fields = [
        'id_contact'   => 'num',
        'id_groupe'    => 'num',
        'id_lieu'      => 'num',
        'id_event'     => 'num',
        'id_structure' => 'num',
        'name'         => 'str',
        'created_on'   => 'date',
        'modified_on'  => 'date',
        'online'       => 'bool',
        'mime'         => 'str',
    ];

    /**
     * Tableau des attributs modifiés depuis la dernière sauvegarde.
     *
     * Pour chaque attribut modifié, on a un élément de la forme 'attribut => true'.
     *
     * @var array
     */
    protected $_modified_fields = [];

    /* début getters */

    /**
     * @return string
     */
    static function getBaseUrl(): string
    {
        return MEDIA_URL . '/audio';
    }

    /**
     * @return string
     */
    static function getBasePath(): string
    {
        return MEDIA_PATH . '/audio';
    }

    /**
     * @return string
     */
    function getMime(): string
    {
        return $this->_mime;
    }

    /**
     * @return string
     */
    function getUrl(): string
    {
        return self::getUrlById($this->getId());
    }

    /**
     * @param int $id id_audio
     *
     * @return string
     */
    static function getUrlById(int $id): string
    {
        return HOME_URL . '/audios/' . $id;
    }

    /**
     * @return string
     */
    function getDirectUrl(): string
    {
        return self::getBaseUrl() . '/' . $this->getId() . '.mp3';
    }

    /* fin getters */

    /* début setters */

    /**
     * @param string $val typemime
     *
     * @return object
     */
    function setMime(string $val): object
    {
        if ($this->_mime !== $val) {
            $this->_mime = $val;
            $this->_modified_fields['mime'] = true;
        }

        return $this;
    }

    /* fin setters */

    /**
     * Recherche des audios en fonction de critères donnés
     *
     * @param array $params ['groupe']    => "5"
     *                      ['structure'] => "1,3"
     *                      ['lieu']      => "1"
     *                      ['event']     => "1"
     *                      ['contact']   => "1"
     *                      ['sort']      => "id_audio|date|random"
     *                      ['sens']      => "ASC"
     *                      ['debut']     => 0
     *                      ['limit']     => 10
     *
     * @return array
     */
    static function getAudios(array $params = [])
    {
        $debut = 0;
        if (isset($params['debut'])) {
            $debut = (int) $params['debut'];
        }

        $limit = 10;
        if (isset($params['limit'])) {
            $limit = (int) $params['limit'];
        }

        $sens = "ASC";
        if (isset($params['sens']) && $params['sens'] == "DESC") {
            $sens = "DESC";
        }

        $sort = "id_audio";
        if (isset($params['sort'])
            && ($params['sort'] == "date" || $params['sort'] == "random")
        ) {
            $sort = $params['sort'];
        }

        $tab_groupe    = [];
        $tab_structure = [];
        $tab_lieu      = [];
        $tab_event     = [];
        $tab_id        = [];
        $tab_contact   = [];

        if (array_key_exists('groupe', $params)) {
            $tab_groupe = explode(',', (string) $params['groupe']);
        }
        if (array_key_exists('structure', $params)) {
            $tab_structure = explode(',', (string) $params['structure']);
        }
        if (array_key_exists('lieu', $params)) {
            $tab_lieu = explode(',', (string) $params['lieu']);
        }
        if (array_key_exists('event', $params)) {
            $tab_event = explode(',', (string) $params['event']);
        }
        if (array_key_exists('id', $params)) {
            $tab_id = explode(',', (string) $params['id']);
        }
        if (array_key_exists('contact', $params)) {
            $tab_contact = explode(',', (string) $params['contact']);
        }

        $db = DataBase::getInstance();

        $sql = "SELECT `a`.`id_audio` AS `id`, `a`.`name`, 'audio' AS `type`, "
             . "`a`.`online`, `a`.`created_on`, `a`.`modified_on`, "
             . "`g`.`id_groupe` AS `groupe_id`, `g`.`name` AS `groupe_name`, `g`.`alias` AS `groupe_alias`, "
             . "CONCAT('http://www.adhocmusic.com/', `g`.`alias`) AS `groupe_url`, "
             . "`s`.`id_structure` AS `structure_id`, `s`.`name` AS `structure_name`, "
             . "`e`.`id_event` AS `event_id`, `e`.`name` AS `event_name`, `e`.`date` AS `event_date`, "
             . "`l`.`id_lieu` AS `lieu_id`, `l`.`name` AS `lieu_name`, "
             . "CONCAT('https://www.adhocmusic.com/media/groupe/m', `g`.`id_groupe`, '.jpg') AS `thumb_80_80`, "
             . "CONCAT('https://www.adhocmusic.com/media/audio/', `a`.`id_audio`, '.mp3') AS `direct_url` "
             . "FROM (`" . Audio::getDbTable() . "` `a`) "
             . "LEFT JOIN `" . Groupe::getDbTable() . "` `g` ON (`a`.`id_groupe` = `g`.`id_groupe`) "
             . "LEFT JOIN `" . Structure::getDbTable() . "` `s` ON (`a`.`id_structure` = `s`.`id_structure`) "
             . "LEFT JOIN `" . Lieu::getDbTable() . "` `l` ON (`a`.`id_lieu` = `l`.`id_lieu`) "
             . "LEFT JOIN `" . Event::getDbTable() . "` `e` ON (`a`.`id_event` = `e`.`id_event`) "
             . "WHERE 1 ";

        if (array_key_exists('online', $params)) {
            if ($params['online']) {
                $online = 'TRUE';
            } else {
                $online = 'FALSE';
            }
            $sql .= "AND `a`.`online` = " . $online . " ";
        }

        if (count($tab_groupe) && ($tab_groupe[0] != 0)) {
            $sql .= "AND `a`.`id_groupe` IN (" . implode(',', $tab_groupe) . ") ";
        }

        if (count($tab_structure) && ($tab_structure[0] != 0)) {
            $sql .= "AND `a`.`id_structure` IN (" . implode(',', $tab_structure) . ") ";
        }

        if (count($tab_lieu) && ($tab_lieu[0] != 0)) {
            $sql .= "AND `a`.`id_lieu` IN (" . implode(',', $tab_lieu) . ") ";
        }

        if (count($tab_event) && ($tab_event[0] != 0)) {
            $sql .= "AND `a`.`id_event` IN (" . implode(',', $tab_event) . ") ";
        }

        if (count($tab_id) && ($tab_id[0] != 0)) {
            $sql .= "AND `a`.`id_audio` IN (" . implode(',', $tab_id) . ") ";
        }

        if (count($tab_contact) && ($tab_contact[0] != 0)) {
            $sql .= "AND `a`.`id_contact` IN (" . implode(',', $tab_contact) . ") ";
        }

        $sql .= "ORDER BY ";
        if ($sort === "random") {
            $sql .= "RAND(" . time() . ") ";
        } else {
            $sql .= "`a`.`" . $sort . "` " . $sens . " ";
        }
        $sql .= "LIMIT " . $debut . ", " . $limit;

        $res = $db->queryWithFetch($sql);

        foreach ($res as $idx => $_res) {
            $res[$idx]['url'] = self::getUrlById((int) $_res['id']);
        }

        if ($limit == 1) {
            $res = array_pop($res);
        }

        return $res;
    }

    /**
     * Efface un enregistrement de la table audio
     * + gestion de l'effacement du fichier
     *
     * @return bool
     */
    function delete(): bool
    {
        if (parent::delete()) {
            $file = self::getBasePath() . '/' . $this->getId() . '.mp3';
            if (file_exists($file)) {
                unlink($file);
            }
            return true;
        }
        return false;
    }

    /**
     * @return bool
     * @throws Exception
     */
    protected function _loadFromDb(): bool
    {
        if (!parent::_loadFromDb()) {
            throw new Exception('Audio introuvable');
        }
    }

    /**
     * Retourne les derniers audios postés
     *
     * @param int $limit limite
     *
     * @return array
     */
    static function getLastAudios(int $limit = 5)
    {
        return self::getAudios(
            [
                'limit' => $limit,
                'sort'  => 'date',
                'sens'  => 'DESC',
            ]
        );
    }

    /**
     * Retourne le player audio
     *
     * @param int $id_audio ou array de int $id_audio
     * @param string $type
     * @return string
     * @todo les paramètres du dewplayer ont du changer avec la nouvelle version
     * @see http://www.alsacreations.fr/dewplayer
     * @deprecated
     * @see Smarty::function_audio_player()
     */
    static function getPlayer($id_audio, $type = 'dewplayer-mini')
    {
        $bgcolor = '666666';

        if ($type == 'player_mp3_multi') {
            $id_groupe = $id_audio;
        } elseif ($type == 'webradio') {
            $chemin = $id_audio;
            $type = 'dewplayer';
        } else {
            $chemin = '';
            if (is_numeric($id_audio)) {
                $chemin .= self::getBaseUrl() . '/' . $id_audio . '.mp3';
            } elseif (is_array($id_audio)) {
                $first  = true;
                foreach ($id_audio as $id) {
                    if (!$first) {
                        $chemin .= '|';
                    }
                    $chemin .= self::getBaseUrl() . '/' . $id . '.mp3';
                    $first = false;
                }
            } else {
                return false;
            }
        }

        switch ($type)
        {
            case 'dewplayer-mini':
                return '<object type="application/x-shockwave-flash" data="/swf/dewplayer-mini.swf?mp3='.urlencode($chemin).'&amp;bgcolor='.$bgcolor.'&amp;showtime=1" width="160" height="20">'."\n"
                     . '<param name="wmode" value="transparent" />'."\n"
                     . '<param name="movie" value="/swf/dewplayer-mini.swf?mp3='.urlencode($chemin).'&amp;bgcolor='.$bgcolor.'&amp;showtime=1" />'."\n"
                     . '</object>'."\n";
                break;

            case 'dewplayer':
                return '<object type="application/x-shockwave-flash" data="/swf/dewplayer.swf?mp3='.urlencode($chemin).'&amp;bgcolor='.$bgcolor.'&amp;showtime=1" width="200" height="20">'."\n"
                     . '<param name="wmode" value="transparent" />'."\n"
                     . '<param name="movie" value="/swf/dewplayer.swf?mp3='.urlencode($chemin).'&amp;bgcolor='.$bgcolor.'&amp;showtime=1" />'."\n"
                     . '</object>'."\n";
                break;

            case 'dewplayer-multi':
                return '<object type="application/x-shockwave-flash" data="/swf/dewplayer-mini.swf?mp3='.urlencode($chemin).'&amp;bgcolor='.$bgcolor.'&amp;showtime=1" width="240" height="20">'."\n"
                     . '<param name="wmode" value="transparent" />'."\n"
                     . '<param name="movie" value="/swf/dewplayer-multi.swf?mp3='.urlencode($chemin).'.mp3&amp;bgcolor='.$bgcolor.'&amp;showtime=1" />'."\n"
                     . '</object>'."\n";
                break;

            case 'player_mp3_multi':
                return '<object type="application/x-shockwave-flash" data="/swf/player_mp3_multi.swf" width="250" height="150">'."\n"
                     . '<param name="movie" value="/swf/player_mp3_multi.swf" />'."\n"
                     . '<param name="wmode" value="transparent" />'."\n"
                     . '<param name="FlashVars" value="configxml=/swf/player_mp3_multi.php/'.$id_groupe.'" />'."\n"
                     . '</object>'."\n";
                break;

            case 'player_mp3_nano':
                return '<object type="application/x-shockwave-flash" data="/swf/player_mp3_maxi.swf" width="25" height="20">'."\n"
                     . '<param name="movie" value="/swf/player_mp3_maxi.swf" />'."\n"
                     . '<param name="FlashVars" value="mp3='.urlencode($chemin).'&amp;bgcolor=2f2f2f&amp;showslider=0&amp;width=25" />'."\n"
                     . '</object>'."\n";
                break;
        }

        return false;
    }

    /**
     * Retourne le nombre total d'audios d'un visiteur loggué
     */
    static function getMyAudiosCount()
    {
        if (empty($_SESSION['membre'])) {
            throw new Exception('non identifié');
        }

        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(*) "
             . "FROM `" . Audio::getDbTable() . "` "
             . "WHERE `id_contact` = " . (int) $_SESSION['membre']->getId();

        return $db->queryWithFetchFirstField($sql);
    }

    /**
     * Retourne le nombre total d'audios
     *
     * @return int
     */
    static function getAudiosCount()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(*) "
             . "FROM `" . Audio::getDbTable() . "`";

        return $db->queryWithFetchFirstField($sql);
    }
}
