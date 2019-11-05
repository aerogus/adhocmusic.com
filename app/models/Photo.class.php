<?php declare(strict_types=1);

/**
 * Classe Photo
 *
 * Classe de gestion des photos du site
 * Upload, Appel conversion etc ...
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Photo extends Media
{
    /**
     * @var object
     */
    protected static $_instance = null;

    /**
     * @var string
     */
    protected static $_pk = 'id_photo';

    /**
     * @var string
     */
    protected static $_table = 'adhoc_photo';

    /**
     * @var int
     */
    protected $_id_photo = 0;

    /**
     * @var string
     */
    protected $_pseudo = '';

    /**
     * @var string
     */
    protected $_credits = '';

    /**
     * Liste des attributs de l'objet
     * on précise si en base c'est de type :
     * - numérique/integer/float/bool (= num)
     * - datetime/text (= str)
     * ceci est utile pour la formation de la requête
     *
     * @var array
     */
    protected static $_all_fields = [
        'id_photo'     => 'int',
        'id_contact'   => 'int',
        'id_groupe'    => 'int',
        'id_lieu'      => 'int',
        'id_event'     => 'int',
        'id_structure' => 'int',
        'name'         => 'string',
        'created_on'   => 'date',
        'modified_on'  => 'date',
        'online'       => 'bool',
        'credits'      => 'string',
    ];

    /**
     * Tableau des attributs modifiés depuis la dernière sauvegarde.
     *
     * Pour chaque attribut modifié, on a un élément de la forme 'attribut => true'.
     *
     * @var array
     */
    protected $_modified_fields = [];

    /* debut getters */

    /**
     * @return string
     */
    static function getBaseUrl(): string
    {
        return MEDIA_URL . '/photo';
    }

    /**
     * @return string
     */
    static function getBasePath(): string
    {
        return MEDIA_PATH . '/photo';
    }

    /**
     * @return string
     */
    function getPseudo(): string
    {
        return $this->_pseudo;
    }

    /**
     * @return string
     */
    function getCredits(): string
    {
        return $this->_credits;
    }

    /**
     * @return string
     */
    function getUrl(): string
    {
        return self::getUrlById($this->getId());
    }

    /**
     * @param int $id_photo id_photo
     *
     * @return string
     */
    static function getUrlById(int $id_photo): string
    {
        return HOME_URL . '/photos/' . (string) $id_photo;
    }

    /* fin getters */

    /* debut setters */

    /**
     * @param string $credits credits
     *
     * @return object
     */
    function setCredits(string $credits): object
    {
        if ($this->_credits !== $credits) {
            $this->_credits = $credits;
            $this->_modified_fields['credits'] = true;
        }

        return $this;
    }

    /* fin setters */

    /**
     * Efface une photo de la table photo + le fichier .jpg
     *
     * @return bool
     */
    function delete(): bool
    {
        if (parent::delete()) {
            self::invalidatePhotoInCache($this->getId(),  80,  80, '000000', false,  true);
            self::invalidatePhotoInCache($this->getId(), 130, 130, '000000', false, false);
            self::invalidatePhotoInCache($this->getId(), 400, 300, '000000', false, false);
            self::invalidatePhotoInCache($this->getId(), 680, 600, '000000', false, false);

            $file = self::getBasePath() . '/' . $this->getId() . '.jpg';
            if (file_exists($file)) {
                unlink($file);
            }
            return true;
        }
        return false;
    }

    /**
     * Recherche des photos en fonction de critères donnés
     *
     * @param array $params ['groupe']    => "5"
     *                      ['structure'] => "1,3"
     *                      ['lieu']      => "1"
     *                      ['event']     => "1"
     *                      ['id']        => "3"
     *                      ['contact']   => "1"
     *                      ['sort']      => "id_photo|date|random"
     *                      ['sens']      => "ASC"
     *                      ['debut']     => 0
     *                      ['limit']     => 10
     *
     * @return array
     */
    static function getPhotos(array $params = []): array
    {
        $debut = 0;
        if (isset($params['debut'])) {
            $debut = (int) $params['debut'];
        }

        $limit = 10;
        if (isset($params['limit'])) {
            $limit = (int) $params['limit'];
        }

        $sens = 'ASC';
        if (isset($params['sens']) && $params['sens'] === 'DESC') {
            $sens = 'DESC';
        }

        $sort = 'id_photo';
        if (isset($params['sort'])
            && ($params['sort'] === 'created_on' || $params['sort'] === 'random')
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

        $sql = "SELECT `p`.`id_photo` AS `id`, `p`.`name`, `p`.`credits`, `p`.`online`, `p`.`created_on`, 'photo' AS `type`, "
             . "`g`.`id_groupe` AS `groupe_id`, `g`.`name` AS `groupe_name`, `g`.`alias` AS `groupe_alias`, "
             . "`s`.`id_structure` AS `structure_id`, `s`.`name` AS `structure_name`, "
             . "`l`.`id_lieu` AS `lieu_id`, `l`.`id_departement` AS `departement_id`, `l`.`name` AS `lieu_name`, `l`.`city`, "
             . "`e`.`id_event` AS `event_id`, `e`.`name` AS `event_name`, `e`.`date` AS `event_date`, "
             . "`m`.`id_contact` AS `contact_id`, `m`.`pseudo` "
             . "FROM (`" . Photo::getDbTable() . "` `p`) "
             . "LEFT JOIN `" . Groupe::getDbTable() . "` `g` ON (`p`.`id_groupe` = `g`.`id_groupe`) "
             . "LEFT JOIN `" . Structure::getDbTable() . "` `s` ON (`p`.`id_structure` = `s`.`id_structure`) "
             . "LEFT JOIN `" . Lieu::getDbTable() . "` `l` ON (`p`.`id_lieu` = `l`.`id_lieu`) "
             . "LEFT JOIN `" . Event::getDbTable() . "` `e` ON (`p`.`id_event` = `e`.`id_event`) "
             . "LEFT JOIN `" . Membre::getDbTable() . "` `m` ON (`p`.`id_contact` = `m`.`id_contact`) "
             . "WHERE 1 ";

        if (array_key_exists('online', $params)) {
            if ($params['online']) {
                $online = 'TRUE';
            } else {
                $online = 'FALSE';
            }
            $sql .= "AND `p`.`online` = " . $online . " ";
        }

        if (count($tab_groupe) && $tab_groupe[0] != 0) {
            $sql .= "AND `p`.`id_groupe` IN (" . implode(',', $tab_groupe) . ") ";
        }

        if (count($tab_structure) && $tab_structure[0] != 0) {
            $sql .= "AND `p`.`id_structure` IN (" . implode(',', $tab_structure) . ") ";
        }

        if (count($tab_lieu) && $tab_lieu[0] != 0) {
            $sql .= "AND `p`.`id_lieu` IN (" . implode(',', $tab_lieu) . ") ";
        }

        if (count($tab_event) && $tab_event[0] != 0) {
            $sql .= "AND `p`.`id_event` IN (" . implode(',', $tab_event) . ") ";
        }

        if (count($tab_id) && ($tab_id[0] != 0)) {
            $sql .= "AND `p`.`id_photo` IN (" . implode(',', $tab_id) . ") ";
        }

        if (count($tab_contact) && ($tab_contact[0] != 0)) {
            $sql .= "AND `p`.`id_contact` IN (" . implode(',', $tab_contact) . ") ";
        }

        $sql .= "ORDER BY ";
        if ($sort === "random") {
            $sql .= "RAND(" . time() . ") ";
        } else {
            $sql .= "`p`.`" . $sort . "` " . $sens . " ";
        }
        $sql .= "LIMIT " . $debut . ", " . $limit;

        $tab = [];

        $cpt = 0;
        if ($res = $db->queryWithFetch($sql)) {
            foreach ($res as $_res) {
                $tab[$cpt] = $_res;
                $tab[$cpt]['url'] = Photo::getUrlById((int) $_res['id']);
                // @TODO /!\ getPhotoUrl génère la miniature si non existante, très lourd! à optimiser
                $tab[$cpt]['thumb_80_80']   = Photo::getPhotoUrl((int) $_res['id'],   80,  80, '000000', false,  true);
                $tab[$cpt]['thumb_320']     = Photo::getPhotoUrl((int) $_res['id'],  320,   0, '000000', false, false);
                $tab[$cpt]['thumb_680_600'] = Photo::getPhotoUrl((int) $_res['id'],  680, 600, '000000', false, false);
                $tab[$cpt]['thumb_1000']    = Photo::getPhotoUrl((int) $_res['id'], 1000,   0, '000000', false, false);
                $cpt++;
            }
        }

        return $tab;
    }

    /**
     * @return bool
     * @throws Exception
     */
    protected function _loadFromDb(): bool
    {
        // new 2019
        if (!parent::_loadFromDb()) {
            throw new Exception('Photo introuvable');
        }

        $db = DataBase::getInstance();

        $sql = "SELECT `p`.`name`, `p`.`created_on`, `p`.`modified_on`, "
             . "`p`.`credits`, `p`.`online`, `m`.`pseudo`, "
             . "`p`.`id_groupe`, `p`.`id_structure`, "
             . "`p`.`id_lieu`, `p`.`id_event`, `p`.`id_contact` "
             . "FROM `" . Photo::getDbTable() . "` `p` "
             . "LEFT JOIN `" . Groupe::getDbTable() . "` `g` ON (`p`.`id_groupe` = `g`.`id_groupe`) "
             . "LEFT JOIN `" . Structure::getDbTable() . "` `s` ON (`p`.`id_structure` = `s`.`id_structure`) "
             . "LEFT JOIN `" . Lieu::getDbTable() . "` `l` ON (`p`.`id_lieu` = `l`.`id_lieu`) "
             . "LEFT JOIN `" . Event::getDbTable() . "` `e` ON (`p`.`id_event` = `e`.`id_event`) "
             . "LEFT JOIN `" . Membre::getDbTable() . "` `m` ON (`p`.`id_contact` = `m`.`id_contact`) "
             . "WHERE `p`.`id_photo` = " . (int) $this->_id_photo;

        if ($res = $db->queryWithFetchFirstRow($sql)) {
            $this->_arrayToObject($res);
            $this->_pseudo = $res['pseudo'];
            return true;
        }

        throw new Exception('Photo introuvable');
    }

    /**
     * @return string
     */
    function getThumb80Url(): string
    {
        return self::getPhotoUrl($this->getId(), 80, 80, '000000', false, true);
    }

    /**
     * @return string
     */
    function getThumb320Url(): string
    {
        return self::getPhotoUrl($this->getId(), 320, 0, '000000', false, false);
    }

    /**
     * @return string
     */
    function getThumb680Url(): string
    {
        return self::getPhotoUrl($this->getId(), 680, 600, '000000', false, false);
    }

    /**
     * @return bool
     */
    static function invalidatePhotoInCache(int $id, int $width = 80, int $height = 80, string $bgcolor = '000000', bool $border = false, bool $zoom = false): bool
    {
        $uid = 'photo/' . $id . '/' . $width . '/' . $height . '/' . $bgcolor . '/' . $border . '/' . $zoom . '.jpg';
        $cache = Image::getLocalCachePath($uid);

        if (file_exists($cache)) {
            unlink($cache);
            return true;
        }

        return false;
    }

    /**
     * Retourne l'url de la photo
     * gestion de la mise en cache
     *
     * @return string
     */
    static function getPhotoUrl(int $id, int $width = 80, int $height = 80, string $bgcolor = '000000', bool $border = false, bool $zoom = false): string
    {
        $uid = 'photo/' . $id . '/' . $width . '/' . $height . '/' . $bgcolor . '/' . $border . '/' . $zoom . '.jpg';
        $cache = Image::getLocalCachePath($uid);

        if (!file_exists($cache)) {
            $source = self::getBasePath() . '/' . $id . '.jpg';
            if (file_exists($source)) {
                $img = new Image($source);
                $img->setType(IMAGETYPE_JPEG);
                $img->setMaxWidth($width);
                $img->setMaxHeight($height);
                $img->setBorder($border);
                $img->setKeepRatio(true);
                if ($zoom) {
                    $img->setZoom();
                }
                $img->setHexColor($bgcolor);
                Image::writeCache($uid, $img->get());
            } else {
                $img = (new Image())
                    ->init(16, 16, '000000');
                Image::writeCache($uid, $img->get());
                Log::write('photo', 'photo ' . $id . ' introuvable | uid : ' . $uid);
            }
        }

        return Image::getHttpCachePath($uid);
    }
}
