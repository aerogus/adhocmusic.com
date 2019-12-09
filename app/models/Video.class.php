<?php declare(strict_types=1);

use \Reference\VideoHost;

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
 * Classe de gestion des vidéos
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Video extends Media
{
    /**
     * Instance de l'objet
     *
     * @var object
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
        'created_at'   => 'date',
        'modified_at'  => 'date',
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
    function getIdVideo(): int
    {
        return $this->_id_video;
    }

    /**
     * @return int
     */
    function getIdHost(): int
    {
        return $this->_id_host;
    }

    /**
     * Retourne l'objet VideoHost
     *
     * @return object
     */
    function getHost(): object
    {
        return VideoHost::getInstance($this->getIdHost());
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
        return HOME_URL . '/videos/' . $this->getIdVideo();
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
     * Retourne le chemin de l'imagette par défaut
     *
     * @return string
     */
    static function getDefaultThumbPath(): string
    {
        return ADHOC_ROOT_PATH . '/assets/img/default-video-thumb.jpg';
    }

    /**
     * Retourne le chemin de l'imagette par défaut
     *
     * @return string
     */
    static function getDefaultThumbUrl(): string
    {
        return HOME_URL . '/img/default-video-thumb.jpg';
    }

    /**
     * Retourne l'url d'une minuature de photo (sans vérifier son existence)
     *
     * @param int $maxWidth maxWidth
     *
     * @return string|null
     */
    function getThumbUrl(int $maxWidth = 0): ?string
    {
        $sourcePath = self::getBasePath() . '/' . $this->getIdVideo() . '.jpg';
        if (!file_exists($sourcePath)) {
            $sourcePath = self::getDefaultThumbPath();
        }

        if (!$maxWidth) {
            return self::getBaseUrl() . '/' . $this->getIdVideo() . '.jpg';
        } else {
            $uid = 'video/' . $this->getIdVideo() . '/' . $maxWidth;
            $cachePath = Image::getCachePath($uid);
            if (!file_exists($cachePath)) {
                // @TODO ajouter à une file de calcul
            }
            return Image::getCacheUrl($uid);
        }
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
     * Efface une vidéo de la table vidéo
     * + purge du fichier miniature
     *
     * @return bool
     */
    function delete(): bool
    {
        if (parent::delete()) {
            $this->deleteThumbnail();
            foreach ([80, 320] as $maxWidth) {
                $this->clearThumb($maxWidth);
            }
            return true;
        }
        return false;
    }

    /**
     * Retourne le code du player vidéo embarqué
     *
     * @return string|null
     *
     * @see http://www.alsacreations.fr/dewtube
     * @see http://www.clubic.com/telecharger-fiche21739-riva-flv-encoder.html
     */
    function getPlayer(): ?string
    {
        switch ($this->getIdHost()) {
            case self::HOST_YOUTUBE:
                return '<iframe src="https://www.youtube.com/embed/' . $this->getReference() . '?rel=0" allowfullscreen></iframe>' . "\n";

            case self::HOST_DAILYMOTION:
                return '<iframe src="https://www.dailymotion.com/embed/video/' . $this->getReference() . '?theme=none&foreground=%23FFFFFF&highlight=%23CC0000&background=%23000000&wmode=transparent" allowfullscreen></iframe>' . "\n";

            case self::HOST_FACEBOOK:
                return '<iframe src="https://www.facebook.com/video/embed?video_id=' . $this->getReference() . '" allowfullscreen></iframe>' . "\n";

            case self::HOST_VIMEO:
                return '<iframe src="https://player.vimeo.com/video/' . $this->getReference() . '?title=0&amp;byline=0&amp;portrait=0" allowfullscreen></iframe>' . "\n";

            case self::HOST_ADHOCTUBE:
                return '<iframe src="https://' . MEDIA_ADHOCTUBE_HOST . '/videos/embed/' . $this->getReference() . '?title=0&amp;warningTitle=0" sandbox="allow-same-origin allow-scripts" allowfullscreen></iframe>' . "\n";

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
    static function parseStringForVideoUrl(string $code)
    {
        $str = trim($code);

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
     *
     * @return string|null
     */
    static function getRemoteThumbnail(int $id_host, string $reference): ?string
    {
        switch ($id_host) {
            case self::HOST_YOUTUBE:
                $maxResUrl = "https://img.youtube.com/vi/{$reference}/maxresdefault.jpg"; // 1280*720 (pas tjrs là)
                $hqResUrl = "https://img.youtube.com/vi/{$reference}/hqdefault.jpg"; // 480*360
                return $hqResUrl; // retourne direct l'url hd plutôt que max
                $headers = get_headers($maxResUrl);
                if (substr($headers[0], 9, 3) === '200') {
                    return $maxResUrl;
                }
                return $hqResUrl;

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
                $headers = get_headers('https://graph.facebook.com/' . $reference . '/picture', 1);
                if (is_array($headers['Location'])) {
                    $url = $headers['Location'][0];
                } else {
                    $url = $headers['Location'];
                }
                return $url;

            case self::HOST_ADHOCTUBE:
                $meta_url = 'https://' . MEDIA_ADHOCTUBE_HOST . '/api/v1/videos/' . $reference;
                if ($json = file_get_contents($meta_url)) {
                    $meta_info = json_decode($json);
                    return 'https://' . MEDIA_ADHOCTUBE_HOST . $meta_info->thumbnailPath;
                } else {
                    return null;
                }

            default:
                return null;
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
        switch ($id_host) {
            case self::HOST_VIMEO:
                $meta_url = 'https://vimeo.com/api/v2/video/' . $reference . '.json';
                $meta_info = json_decode(file_get_contents($meta_url));
                return $meta_info[0]->title;

            case self::HOST_ADHOCTUBE:
                $meta_url = 'https://' . MEDIA_ADHOCTUBE_HOST . '/api/v1/videos/' . $reference;
                $meta_info = json_decode(file_get_contents($meta_url));
                return $meta_info->name;

            case self::HOST_YOUTUBE:
                $meta_url = 'https://www.youtube.com/watch?v=' . $reference;
                $html = file_get_contents($meta_url);
                $doc = new DOMDocument();
                $doc->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
                $title = str_replace(' - YouTube', '', $doc->getElementsByTagName('title')[0]->nodeValue);
                return $title;

            case self::HOST_DAILYMOTION:
            case self::HOST_FACEBOOK:
                // @TODO à implémenter
                return null;

            default:
                throw new Exception('unknown video_host');
        }
    }

    /**
     * Efface une vignette locale
     *
     * @return bool
     */
    function deleteThumbnail(): bool
    {
        $file = self::getBasePath() . '/' . $this->getIdVideo() . '.jpg';
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
            ->setDestFile($jpg)
            ->write();
        unlink($tmp);

        return true;
    }

    /**
     * Efface une miniature donnée
     *
     * @param int $maxWidth maxWidth
     *
     * @return bool
     */
    function clearThumb(int $maxWidth = 0): bool
    {
        $uid = 'video/' . $this->getIdVideo() . '/' . $maxWidth;
        $cache = Image::getCachePath($uid);

        if (file_exists($cache)) {
            unlink($cache);
            return true;
        }

        return false;
    }

    /**
     * Génère la miniature d'une vidéo
     *
     * @param int $maxWidth maxWidth
     *
     * @return bool
     */
    function genThumb(int $maxWidth = 0): bool
    {
        if (!$maxWidth) {
            return false;
        }

        $uid = 'video/' . $this->getIdVideo() . '/' . $maxWidth;
        $cache = Image::getCachePath($uid);

        if (file_exists($cache)) {
            unlink($cache);
        }

        $source = self::getBasePath() . '/' . $this->getIdVideo() . '.jpg';
        if (!file_exists($source)) {
            return false;
        }

        $img = (new Image($source))
            ->setType(IMAGETYPE_JPEG)
            ->setMaxWidth($maxWidth);
        Image::writeCache($uid, $img->get());

        return true;
    }
}
