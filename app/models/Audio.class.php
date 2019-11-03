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
     * Liste des attributs de l'objet
     * on précise si en base c'est de type :
     * - numérique/integer/float/bool (= int)
     * - datetime/text (= str)
     * ceci est utile pour la formation de la requête
     *
     * @var array
     */
    protected static $_all_fields = [
        'id_audio'     => 'int', // pk
        'id_contact'   => 'int',
        'id_groupe'    => 'int',
        'id_lieu'      => 'int',
        'id_event'     => 'int',
        'id_structure' => 'int',
        'name'         => 'string',
        'created_on'   => 'date',
        'modified_on'  => 'date',
        'online'       => 'bool',
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
    function getUrl(): string
    {
        return self::getUrlById($this->getId());
    }

    /**
     * @param int $id_audio id_audio
     *
     * @return string
     */
    static function getUrlById(int $id_audio): string
    {
        return HOME_URL . '/audios/' . (string) $id_audio;
    }

    /**
     * @return string
     */
    function getDirectMp3Url(): ?string
    {
        if (file_exists(self::getBasePath() . '/' . $this->getId() . '.mp3')) {
            return self::getBaseUrl() . '/' . $this->getId() . '.mp3';
        }
        return null;
    }

    /**
     * @return string|null
     */
    function getDirectAacUrl(): ?string
    {
        if (file_exists(self::getBasePath() . '/' . $this->getId() . '.m4a')) {
            return self::getBaseUrl() . '/' . $this->getId() . '.m4a';
        }
        return null;
    }

    /* fin getters */

    /* début setters */

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
        if (isset($params['sens']) && $params['sens'] === "DESC") {
            $sens = "DESC";
        }

        $sort = "id_audio";
        if (isset($params['sort'])
            && ($params['sort'] === "date" || $params['sort'] === "random")
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

        // @TODO retirer ces références à adhocmusic.com en dur !!!

        $sql = "SELECT `a`.`id_audio` AS `id`, `a`.`name`, 'audio' AS `type`, "
             . "`a`.`online`, `a`.`created_on`, `a`.`modified_on`, "
             . "`g`.`id_groupe` AS `groupe_id`, `g`.`name` AS `groupe_name`, `g`.`alias` AS `groupe_alias`, "
             . "CONCAT('https://www.adhocmusic.com/', `g`.`alias`) AS `groupe_url`, "
             . "`s`.`id_structure` AS `structure_id`, `s`.`name` AS `structure_name`, "
             . "`e`.`id_event` AS `event_id`, `e`.`name` AS `event_name`, `e`.`date` AS `event_date`, "
             . "`l`.`id_lieu` AS `lieu_id`, `l`.`name` AS `lieu_name`, "
             . "CONCAT('https://static.adhocmusic.com/media/groupe/m', `g`.`id_groupe`, '.jpg') AS `thumb_80_80`, "
             . "CONCAT('https://static.adhocmusic.com/media/audio/', `a`.`id_audio`, '.mp3') AS `direct_url` "
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

        if ($limit === 1) {
            $res = array_pop($res);
        }

        return $res;
    }

    /**
     * Efface un enregistrement de la table audio
     * + gestion de l'effacement du/des fichier(s)
     *
     * @return bool
     */
    function delete(): bool
    {
        if (parent::delete()) {
            $mp3File = self::getBasePath() . '/' . $this->getId() . '.mp3';
            if (file_exists($mp3File)) {
                unlink($mp3File);
            }
            $aacFile = self::getBasePath() . '/' . $this->getId() . '.m4a';
            if (file_exists($aacFile)) {
                unlink($aacFile);
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
        return true;
    }
}
