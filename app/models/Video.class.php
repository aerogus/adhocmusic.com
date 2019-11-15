<?php declare(strict_types=1);

/**
 * 1 - YouTube
 */
define('MEDIA_YOUTUBE_URL_PATTERN',
    '~^https://([A-Za-z]{2,3}\.)?youtube\.com/watch[/]?\?v=([A-Za-z0-9_-]{1,32})~');

define('__MEDIA_YOUTUBE_DIRECT_VIDEO_URL_PARTIAL_PATTERN',
    'https://([A-Za-z]{2,3}\.)?youtube\.com/v/([A-Za-z0-9_-]{1,32})');

define('MEDIA_YOUTUBE_DIRECT_VIDEO_URL_PATTERN',
    '~^' . __MEDIA_YOUTUBE_DIRECT_VIDEO_URL_PARTIAL_PATTERN . '$~');

define('MEDIA_YOUTUBE_EMBED_PATTERN',
    '~<object width="[0-9]{1,4}" height="[0-9]{1,4}">'.
    '<param name="movie" value="'.
    __MEDIA_YOUTUBE_DIRECT_VIDEO_URL_PARTIAL_PATTERN.
    '(&[^"]*)?"></param>'.
    '(<param name="allowFullScreen" value="true"></param>)?'.
    '(<param name="allowscriptaccess" value="always"></param>)?'.
    '<embed src="'.
    __MEDIA_YOUTUBE_DIRECT_VIDEO_URL_PARTIAL_PATTERN.
    '(&[^"]*)?" type="application/x-shockwave-flash" (allowscriptaccess="always" )?(allowfullscreen="true" )?'.
    'width="[0-9]{1,4}" height="[0-9]{1,4}">'.
    '</embed></object>~');

/**
 * 2 - DailyMotion
 *
 * @see http://www.dailymotion.com/oembed/video/x5kyog_weezer-pork-and-beans_music?format=xml
 */
define('__MEDIA_DAILYMOTION_DIRECT_VIDEO_URL_PARTIAL_PATTERN',
    'https://([a-zA-Z0-9.]*\.)?dailymotion.com/(swf|video)/([0-9A-Za-z-]{1,32}).*');

define('MEDIA_DAILYMOTION_DIRECT_VIDEO_URL_PATTERN',
    '~^' . __MEDIA_DAILYMOTION_DIRECT_VIDEO_URL_PARTIAL_PATTERN . '$~');

define('MEDIA_DAILYMOTION_EMBED_PATTERN',
    '~<embed src=["\']' . __MEDIA_DAILYMOTION_DIRECT_VIDEO_URL_PARTIAL_PATTERN . '["\'] .*></embed>~');

/**
 * 6 - Facebook
 */
define('MEDIA_FACEBOOK_URL_PATTERN', '~^https://www\.facebook\.com/watch/\?v=([0-9]{1,16})~');
define('MEDIA_FACEBOOK_DIRECT_VIDEO_URL_PATTERN', '');

/**
 * 8 - Vimeo
 */

define('MEDIA_VIMEO_URL_PATTERN',
       '~^https://(?:www\.)?vimeo.com/([0-9]{1,16})~');

define('MEDIA_VIMEO_DIRECT_VIDEO_URL_PATTERN',
       '~^https://(?:www\.)?vimeo.com/([0-9]{1,16})~');

/**
 * 9 - AD'HOC Tube
 */

define('MEDIA_ADHOCTUBE_HOST', 'videos.adhocmusic.com');
define('MEDIA_ADHOCTUBE_URL_PATTERN', '~^https://' . MEDIA_ADHOCTUBE_HOST . '/videos/watch/([a-f0-9-]{36})~');

/**
 * Classe Vidéo
 *
 * Classe de gestion des vidéos du site
 * Appel conversion, upload etc ...
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Video extends Media
{
    /**
     * Instance de l'objet
     *
     * @var mixed
     */
    protected static $_instance = null;

    /**
     * @var string
     */
    protected static $_pk = 'id_video';

    /**
     * @var string
     */
    protected static $_table = 'adhoc_video';

    const DEFAULT_THUMBNAIL = 'https://www.adhocmusic.com/img/videothumb.jpg';

    const HOST_YOUTUBE     = 1;
    const HOST_DAILYMOTION = 2;
    const HOST_FACEBOOK    = 6;
    const HOST_VIMEO       = 8;
    const HOST_ADHOCTUBE   = 9;

    protected static $_tab_hosts = [
        self::HOST_YOUTUBE     => "YouTube",
        self::HOST_DAILYMOTION => "DailyMotion",
        self::HOST_FACEBOOK    => "Facebook",
        self::HOST_VIMEO       => "Vimeo",
        self::HOST_ADHOCTUBE   => "AD'HOC Tube",
    ];

    /**
     * Dimensions du player
     */
    const DEFAULT_WIDTH  = 1000;
    const DEFAULT_HEIGHT = 562;

    /**
     * @var int
     */
    protected $_id_video = 0;

    /**
     * @var int
     */
    protected $_id_host = 0;

    /**
     * @var string
     */
    protected $_reference = '';

    /**
     * @var int
     */
    protected $_width = 0;

    /**
     * @var int
     */
    protected $_height = 0;

    /**
     * Liste des attributs de l'objet
     *
     * @var array
     */
    protected static $_all_fields = [
        'id_video'     => 'int', // pk
        'id_contact'   => 'int',
        'id_host'      => 'int',
        'reference'    => 'string',
        'id_groupe'    => 'int',
        'id_lieu'      => 'int',
        'id_event'     => 'int',
        'id_structure' => 'int',
        'name'         => 'string',
        'created_on'   => 'date',
        'modified_on'  => 'date',
        'online'       => 'bool',
        'width'        => 'int',
        'height'       => 'int',
    ];

    /* début getters */

    /**
     * @return string
     */
    static function getBaseUrl(): string
    {
        return MEDIA_URL . '/video';
    }

    /**
     * @return string
     */
    static function getBasePath(): string
    {
        return MEDIA_PATH . '/video';
    }

    /**
     * @return int
     */
    function getIdHost(): int
    {
        return $this->_id_host;
    }

    /**
     * Retourne le libellé d'un hébergeur
     *
     * @return string
     */
    function getHostName(): string
    {
        return self::$_tab_hosts[$this->_id_host];
    }

    /**
     * @return string
     */
    function getReference(): string
    {
        return $this->_reference;
    }

    /**
     * Retourne la largeur de la vidéo
     *
     * @return int
     */
    function getWidth(): int
    {
        if ($this->_width) {
            return $this->_width;
        }
        return self::DEFAULT_WIDTH;
    }

    /**
     * Retourne la hauteur de la vidéo
     *
     * @return int
     */
    function getHeight(): int
    {
        if ($this->_height) {
            return $this->_height;
        }
        return self::DEFAULT_HEIGHT;
    }

    /**
     * Retourne l'url de la page de la vidéo
     *
     * @return string
     */
    function getUrl(): ?string
    {
        return self::getUrlById($this->getId());
    }

    /**
     * @param int $id_video id_video
     *
     * @return string
     */
    static function getUrlById(int $id_video): string
    {
        return HOME_URL . '/videos/' . (string) $id_video;
    }

    /**
     * Retourne l'url directe d'un média .mp4
     *
     * @return string
     */
    function getDirectMp4Url(): ?string
    {
        switch ($this->_id_host) {
            case self::HOST_ADHOCTUBE:
                $meta_url = 'https://' . MEDIA_ADHOCTUBE_HOST . '/api/v1/videos/' . $this->_reference;
                $meta_info = json_decode(file_get_contents($meta_url));
                return $meta_info->files[0]->fileUrl;
                break;
            case self::HOST_YOUTUBE:
            case self::HOST_DAILYMOTION:
            case self::HOST_FACEBOOK:
            case self::HOST_VIMEO:
            default:
                return null;
        }
    }

    /**
     * @return string|null
     */
    function getThumbnailUrl(): ?string
    {
        if (file_exists(self::getBasePath() .'/' . $this->getId() . '.jpg')) {
            return self::getBaseUrl() . '/' . $this->getId() . '.jpg';
        }
        return null;
    }

    /* fin getters */

    /* début setters */

    /**
     * Set l'id_host
     *
     * @param int $id_host identifiant hébergeur
     *
     * @return object
     */
    function setIdHost(int $id_host): object
    {
        if ($this->_id_host !== $id_host) {
            $this->_id_host = $id_host;
            $this->_modified_fields['id_host'] = true;
        }

        return $this;
    }

    /**
     * @param string $reference reference
     *
     * @return object
     */
    function setReference(string $reference): object
    {
        if ($this->_reference !== $reference) {
            $this->_reference = $reference;
            $this->_modified_fields['reference'] = true;
        }

        return $this;
    }

    /**
     * @param int $width width
     * 
     * @return object
     */
    function setWidth(int $width): object
    {
        if ($this->_width !== $width) {
            $this->_width = $width;
            $this->_modified_fields['width'] = true;
        }

        return $this;
    }

    /**
     * @param int $height height
     *
     * @return object
     */
    function setHeight(int $height): object
    {
        if ($this->_height !== $height) {
            $this->_height = $height;
            $this->_modified_fields['height'] = true;
        }

        return $this;
    }

    /* fin setters */

    /**
     * Retourne le listing des hébergeurs supportés
     *
     * @return array
     */
    static function getHosts(): array
    {
        return self::$_tab_hosts;
    }

    /**
     * Retourne le listing des hébergeurs supportés
     *
     * @return array
     */
    static function getVideoHosts(): array
    {
        $tab = [];
        foreach (self::$_tab_hosts as $id => $name) {
            $tab[] = [
                'id' => $id,
                'name' => $name,
            ];
        }
        return $tab;
    }

    /**
     * @param int $host_id identifiant hébergeur
     *
     * @return string
     */
    static function getHostNameByHostId(int $host_id): string
    {
        return self::$_tab_hosts[$host_id];
    }

    /**
     * Retourne une collection d'objets "Video" répondant au(x) critère(s)
     *
     * @param array $params param
     *
     * @return array
     */
    static function find(array $params): array
    {
        // @TODO à implémenter
        return [];
    }

    /**
     * Recherche des vidéos en fonction de critères donnés
     *
     * @param array $params ['groupe']    => "5"
     *                      ['structure'] => "1,3"
     *                      ['lieu']      => "1"
     *                      ['event']     => "1"
     *                      ['id']        => "3"
     *                      ['sort']      => "id_video|date|random"
     *                      ['sens']      => "ASC"
     *                      ['debut']     => 0
     *                      ['limit']     => 10
     *
     * @return array
     */
    static function getVideos(array $params = []): array
    {
        $debut = 0;
        if (isset($params['debut'])) {
            $debut = (int) $params['debut'];
        }

        $limit = 10;
        if (!empty($params['limit'])) {
            $limit = (int) $params['limit'];
        }

        $sens = 'ASC';
        if (isset($params['sens']) && $params['sens'] === 'DESC') {
            $sens = 'DESC';
        }

        $sort = 'id_video';
        if (isset($params['sort'])
            && ($params['sort'] === 'date' || $params['sort'] === 'random')
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

        $sql = "SELECT `v`.`id_video` AS `id`, `v`.`name`, `v`.`online`, `v`.`id_host` AS `host_id`, `v`.`reference`, 'video' AS `type`, "
             . "`v`.`width`, `v`.`height`, `v`.`created_on`, `v`.`modified_on`, "
             . "`g`.`id_groupe` AS `groupe_id`, `g`.`name` AS `groupe_name`, `g`.`alias` AS `groupe_alias`, "
             . "`s`.`id_structure` AS `structure_id`, `s`.`name` AS `structure_name`, "
             . "`l`.`id_lieu` AS `lieu_id`, `l`.`name` AS `lieu_name`, `l`.`city`, `l`.`id_departement` AS `departement_id`, "
             . "`e`.`id_event` AS `event_id`, `e`.`name` AS `event_name`, `e`.`date` AS `event_date`, "
             . "`m`.`id_contact` AS `contact_id`, `m`.`pseudo` "
             . "FROM (`" . Video::getDbTable() . "` `v`) "
             . "LEFT JOIN `" . Groupe::getDbTable() . "` `g` ON (`v`.`id_groupe` = `g`.`id_groupe`) "
             . "LEFT JOIN `" . Structure::getDbTable() . "` `s` ON (`v`.`id_structure` = `s`.`id_structure`) "
             . "LEFT JOIN `" . Lieu::getDbTable() . "` `l` ON (`v`.`id_lieu` = `l`.`id_lieu`) "
             . "LEFT JOIN `" . Event::getDbTable() . "` `e` ON (`v`.`id_event` = `e`.`id_event`) "
             . "LEFT JOIN `" . Membre::getDbTable() . "` `m` ON (`v`.`id_contact` = `m`.`id_contact`) "
             . "WHERE 1 ";

        if (array_key_exists('online', $params)) {
            if ($params['online']) {
                $online = 'TRUE';
            } else {
                $online = 'FALSE';
            }
            $sql .= "AND `v`.`online` = " . $online . " ";
        }

        if (count($tab_groupe) && ($tab_groupe[0])) {
            $sql .= "AND `v`.`id_groupe` IN (" . implode(',', $tab_groupe) . ") ";
        }

        if (count($tab_structure) && ($tab_structure[0])) {
            $sql .= "AND `v`.`id_structure` IN (" . implode(',', $tab_structure) . ") ";
        }

        if (count($tab_lieu) && ($tab_lieu[0])) {
            $sql .= "AND `v`.`id_lieu` IN (" . implode(',', $tab_lieu) . ") ";
        }

        if (count($tab_event) && ($tab_event[0])) {
            $sql .= "AND `v`.`id_event` IN (" . implode(',', $tab_event) . ") ";
        }

        if (count($tab_id) && ($tab_id[0])) {
            $sql .= "AND `v`.`id_video` IN (" . implode(',', $tab_id) . ") ";
        }

        if (count($tab_contact) && ($tab_contact[0])) {
            $sql .= "AND `v`.`id_contact` IN (" . implode(',', $tab_contact) . ") ";
        }

        $sql .= "ORDER BY ";
        if ($sort === "random") {
            $sql .= "RAND(".time().") ";
        } else {
            $sql .= "`v`.`" . $sort . "` " . $sens . " ";
        }
        $sql .= "LIMIT " . $debut . ", " . $limit;

        $res_tmp = $db->queryWithFetch($sql);
        $res = [];
        foreach ($res_tmp as $idx => $_res) {
            $res[$idx] = $_res;
            $res[$idx]['url'] = self::getUrlById((int) $_res['id']);
            $res[$idx]['thumb_80_80'] = self::getVideoThumbUrl((int) $_res['id'], 80, 80, '000000', false, true);
            $res[$idx]['thumb_100'] = self::getVideoThumbUrl((int) $_res['id'], 100, 100, '000000', false, true);
            $res[$idx]['thumb_320'] = self::getVideoThumbUrl((int) $_res['id'], 320, 0);
        }

        return $res;
    }

    /**
     * Efface une vidéo de la table vidéo
     * + purge du fichier miniature
     *
     * @return bool
     */
    function delete(): bool
    {
        if (parent::delete()) {
            $this->deleteThumbnail();
            self::invalidateVideoThumbInCache((int) $this->getId(), 80, 80, '000000', false, true);
            self::invalidateVideoThumbInCache((int) $this->getId(), 100, 100, '000000', false, true);
            return true;
        }
        return false;
    }

    /**
     * Retourne le code du player vidéo embarqué
     *
     * @param bool $autoplay autoplay
     * @param bool $iframe   iframe
     *
     * @return string|null
     *
     * @see http://www.alsacreations.fr/dewtube
     * @see http://www.clubic.com/telecharger-fiche21739-riva-flv-encoder.html
     */
    function getPlayer(bool $autoplay = false, bool $iframe = true): ?string
    {
        switch ($this->_id_host) {
            case self::HOST_YOUTUBE:
                return '<iframe title="'.htmlspecialchars($this->getName()).'" src="https://www.youtube.com/embed/'.$this->getReference().'?rel=0" allowfullscreen></iframe>' . "\n";

            case self::HOST_DAILYMOTION:
                return '<iframe src="https://www.dailymotion.com/embed/video/'.$this->getReference().'?theme=none&foreground=%23FFFFFF&highlight=%23CC0000&background=%23000000&wmode=transparent"></iframe>' . "\n";

            case self::HOST_FACEBOOK:
                return '<iframe src="https://www.facebook.com/video/embed?video_id=' . $this->getReference() . '" allowfullscreen></iframe>' . "\n";

            case self::HOST_VIMEO:
                return '<iframe src="https://player.vimeo.com/video/'.$this->getReference().'?title=0&amp;byline=0&amp;portrait=0" allowfullscreen></iframe>' . "\n";

            case self::HOST_ADHOCTUBE:
                return '<iframe sandbox="allow-same-origin allow-scripts" src="https://'.MEDIA_ADHOCTUBE_HOST.'/videos/embed/'.$this->getReference().'?title=0&amp;warningTitle=0" allowfullscreen></iframe>' . "\n";

            default:
                return null;
        }
    }

    /**
     * Cherche une url de video dans une chaine, et en ressort un tableau avec
     * un id pour le "fournisseur" de la video et l'id de la video chez ledit
     * fournisseur, ou bien FALSE.
     *
     * @param string $code code
     *
     * @return array ou false
     */
    static function parseStringForVideoUrl(string $str)
    {
        $str = trim($str);

        // attention, l'ordre des tests est très important, plusieurs media différents
        // pouvant partager le même type d'urls.

        // 1 - on essaye d'abord toutes les formes d'embed qu'on connait

        // YouTube
        if (preg_match(MEDIA_YOUTUBE_EMBED_PATTERN, $str, $matches)) {
            if (!empty($matches[2])) {
                return ['id_host' => self::HOST_YOUTUBE, 'reference' => $matches[2]];
            }
        }

        // DailyMotion
        if (preg_match(MEDIA_DAILYMOTION_EMBED_PATTERN, $str, $matches)) {
            if (!empty($matches[3])) {
                return ['id_host' => self::HOST_DAILYMOTION, 'reference' => $matches[3]];
            }
        }

        // avant de commencer les urls, si jamais ya pas de http:// devant, on le rajoute
        if (strpos($str, 'http://') === false && strpos($str, 'https://') === false) {
            $str = 'https://' . $str;
        }

        // 2 - on teste les urls, d'abord celle des pages contenant les videos, et ensuite
        // celles des videos elles memes.

        // YouTube
        if (preg_match(MEDIA_YOUTUBE_URL_PATTERN, $str, $matches)) {
            if (!empty($matches[2])) {
                return ['id_host' => self::HOST_YOUTUBE, 'reference' => $matches[2]];
            }
        }

        // YouTube
        if (preg_match(MEDIA_YOUTUBE_DIRECT_VIDEO_URL_PATTERN, $str, $matches)) {
            if (!empty($matches[2])) {
                return ['id_host' => self::HOST_YOUTUBE, 'reference' => $matches[2]];
            }
        }

        // DailyMotion
        if (preg_match(MEDIA_DAILYMOTION_DIRECT_VIDEO_URL_PATTERN, $str, $matches)) {
            if (!empty($matches[3])) {
                return ['id_host' => self::HOST_DAILYMOTION, 'reference' => $matches[3]];
            }
        }

        // Facebook
        if (preg_match(MEDIA_FACEBOOK_URL_PATTERN, $str, $matches)) {
            if (!empty($matches[1])) {
                return ['id_host' => self::HOST_FACEBOOK, 'reference' => $matches[1]];
            }
        }

        // Vimeo
        if (preg_match(MEDIA_VIMEO_URL_PATTERN, $str, $matches)) {
            if (!empty($matches[1])) {
                return ['id_host' => self::HOST_VIMEO, 'reference' => $matches[1]];
            }
        }

        // AD'HOC Tube
        if (preg_match(MEDIA_ADHOCTUBE_URL_PATTERN, $str, $matches)) {
            if (!empty($matches[1])) {
                return ['id_host' => self::HOST_ADHOCTUBE, 'reference' => $matches[1]];
            }
        }

        return false;
    }

    /**
     * @todo comme Photo et Audio, requete plus complete ?
     *
     * @return bool
     * @throws Exception
     */
    protected function _loadFromDb(): bool
    {
        if (!parent::_loadFromDb()) {
            throw new Exception('Vidéo introuvable');
        }
        return true;
    }

    /**
     * Récupère l'url de la vignette de la vidéo
     *
     * @param int    $id_host   id_host
     * @param string $reference reference
     * @param bool   $multi     (retourne plusieurs vignettes si dispo)
     *
     * @return string ou array de string
     */
    static function getRemoteThumbnail(int $id_host, string $reference, bool $multi = false)
    {
        switch ($id_host)
        {
            case self::HOST_YOUTUBE:
                if ($multi) {
                    $url   = [];
                    $url[] = "https://img.youtube.com/vi/{$reference}/1.jpg"; // 130*97
                    $url[] = "https://img.youtube.com/vi/{$reference}/2.jpg"; // 130*97
                    $url[] = "https://img.youtube.com/vi/{$reference}/3.jpg"; // 130*97
                    $url[] = "https://img.youtube.com/vi/{$reference}/default.jpg"; // 130*97, = 1.jpg
                    $url[] = "https://img.youtube.com/vi/{$reference}/0.jpg"; // 320*240, = 2.jpg
                } else {
                    $url = "https://img.youtube.com/vi/{$reference}/0.jpg";
                }
                return $url;

            case self::HOST_DAILYMOTION:
                $headers = get_headers('https://www.dailymotion.com/thumbnail/video/' . $reference, 1);
                if (is_array($headers['Location'])) {
                    $url = $headers['Location'][0];
                } else {
                    $url = $headers['Location'];
                }
                return $url;

            case self::HOST_VIMEO:
                $meta_url = 'https://vimeo.com/api/v2/video/' . $reference . '.json';
                $meta_info = json_decode(file_get_contents($meta_url));
                return $meta_info[0]->thumbnail_large;

            case self::HOST_FACEBOOK:
                return self::DEFAULT_THUMBNAIL;

            case self::HOST_ADHOCTUBE:
                $meta_url = 'https://' . MEDIA_ADHOCTUBE_HOST . '/api/v1/videos/' . $reference;
                $meta_info = json_decode(file_get_contents($meta_url));
                return 'https://' . MEDIA_ADHOCTUBE_HOST . $meta_info->thumbnailPath;

            default:
                return false;
        }
    }

    /**
     * Récupère le title distant de la vidéo
     *
     * @param int    $id_host   identifiant hébergeur
     * @param string $reference code référence
     *
     * @return string
     */
    static function getRemoteTitle(int $id_host, string $reference): ?string
    {
        switch ($id_host)
        {
            case self::HOST_VIMEO:
                $meta_url = 'https://vimeo.com/api/v2/video/' . $reference . '.json';
                $meta_info = json_decode(file_get_contents($meta_url));
                return $meta_info[0]->title;

            case self::HOST_ADHOCTUBE:
                $meta_url = 'https://' . MEDIA_ADHOCTUBE_HOST . '/api/v1/videos/' . $reference;
                $meta_info = json_decode(file_get_contents($meta_url));
                return $meta_info->name;

            case self::HOST_YOUTUBE:
            case self::HOST_DAILYMOTION:
            case self::HOST_FACEBOOK:
            default:
                return null;
        }
    }

    /**
     * Efface une vignette locale
     *
     * @return bool
     */
    function deleteThumbnail(): bool
    {
        $file = self::getBasePath() . '/' . $this->getId() . '.jpg';
        if (file_exists($file)) {
            unlink($file);
            return true;
        }
        return false;
    }

    /**
     * Écrit une vignette
     *
     * @param string $remote_url remote_url
     *
     * @return bool
     */
    function storeThumbnail(string $remote_url)
    {
        $tmp = self::getBasePath() . '/' . $this->_id_video . '.jpg.tmp';
        $jpg = self::getBasePath() . '/' . $this->_id_video . '.jpg';

        file_put_contents($tmp, file_get_contents($remote_url));
        (new Image($tmp))
            ->setType(IMAGETYPE_JPEG)
            ->setMaxWidth(320)
            ->setMaxHeight(240)
            ->setDestFile($jpg)
            ->write();
        unlink($tmp);

        return true;
    }

    /**
     * @return bool
     */
    static function invalidateVideoThumbInCache(int $id, int $width = 80, int $height = 80, string $bgcolor = '000000', bool $border = false, bool $zoom = true): bool
    {
        $uid = 'video/' . $id . '/' . $width . '/' . $height . '/' . $bgcolor . '/' . (int) $border . '/' . (int) $zoom . '.jpg';
        $cache = Image::getLocalCachePath($uid);

        if (file_exists($cache)) {
            unlink($cache);
            return true;
        }

        return false;
    }

    /**
     * Retourne l'url de la vignette vidéo
     * gestion de la mise en cache
     *
     * @return string
     */
    static function getVideoThumbUrl(int $id, int $width = 80, int $height = 80, string $bgcolor = '000000', bool $border = false, bool $zoom = true): string
    {
        $uid = 'video/' . $id . '/' . $width . '/' . $height . '/' . $bgcolor . '/' . (int) $border . '/' . (int) $zoom . '.jpg';
        $cache = Image::getLocalCachePath($uid);

        if (!file_exists($cache)) {
            $source = self::getBasePath() . '/' . $id . '.jpg';
            if (file_exists($source)) {
                $img = (new Image($source))
                    ->setType(IMAGETYPE_JPEG)
                    ->setMaxWidth($width)
                    ->setMaxHeight($height)
                    ->setBorder($border)
                    ->setKeepRatio(true)
                    ->setZoom($zoom)
                    ->setHexColor($bgcolor);
                Image::writeCache($uid, $img->get());
            } else {
                $img = (new Image())
                    ->init(16, 16, '000000');
                Image::writeCache($uid, $img->get());
                Log::write('video', 'vignette vidéo ' . $id . ' introuvable | uid : ' . $uid);
            }
        }

        return Image::getHttpCachePath($uid);
    }
}
