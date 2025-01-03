<?php

/**
 * Classe de gestion des vidéos
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Model\Media;
use Adhoc\Model\VideoHost;
use Adhoc\Utils\Conf;
use Adhoc\Utils\DataBase;
use Adhoc\Utils\Image;

/**
 * 1 - YouTube
 */
define(
    'MEDIA_YOUTUBE_URL_PATTERN',
    '~^https://([A-Za-z]{2,3}\.)?youtube\.com/watch[/]?\?v=([A-Za-z0-9_-]{1,32})~'
);

define(
    '__MEDIA_YOUTUBE_DIRECT_VIDEO_URL_PARTIAL_PATTERN',
    'https://([A-Za-z]{2,3}\.)?youtube\.com/v/([A-Za-z0-9_-]{1,32})'
);

define(
    'MEDIA_YOUTUBE_DIRECT_VIDEO_URL_PATTERN',
    '~^' . __MEDIA_YOUTUBE_DIRECT_VIDEO_URL_PARTIAL_PATTERN . '$~'
);

define(
    'MEDIA_YOUTUBE_EMBED_PATTERN',
    '~<object width="[0-9]{1,4}" height="[0-9]{1,4}">' .
    '<param name="movie" value="' .
    __MEDIA_YOUTUBE_DIRECT_VIDEO_URL_PARTIAL_PATTERN .
    '(&[^"]*)?"></param>' .
    '(<param name="allowFullScreen" value="true"></param>)?' .
    '(<param name="allowscriptaccess" value="always"></param>)?' .
    '<embed src="' .
    __MEDIA_YOUTUBE_DIRECT_VIDEO_URL_PARTIAL_PATTERN .
    '(&[^"]*)?" type="application/x-shockwave-flash" (allowscriptaccess="always" )?(allowfullscreen="true" )?' .
    'width="[0-9]{1,4}" height="[0-9]{1,4}">' .
    '</embed></object>~'
);

/**
 * 2 - DailyMotion
 *
 * @see http://www.dailymotion.com/oembed/video/x5kyog_weezer-pork-and-beans_music?format=xml
 */
define(
    '__MEDIA_DAILYMOTION_DIRECT_VIDEO_URL_PARTIAL_PATTERN',
    'https://([a-zA-Z0-9.]*\.)?dailymotion.com/(swf|video)/([0-9A-Za-z-]{1,32}).*'
);

define(
    'MEDIA_DAILYMOTION_DIRECT_VIDEO_URL_PATTERN',
    '~^' . __MEDIA_DAILYMOTION_DIRECT_VIDEO_URL_PARTIAL_PATTERN . '$~'
);

define(
    'MEDIA_DAILYMOTION_EMBED_PATTERN',
    '~<embed src=["\']' . __MEDIA_DAILYMOTION_DIRECT_VIDEO_URL_PARTIAL_PATTERN . '["\'] .*></embed>~'
);

/**
 * 6 - Facebook
 */
define('MEDIA_FACEBOOK_URL_PATTERN', '~^https://www\.facebook\.com/watch/\?v=([0-9]{1,16})~');
define('MEDIA_FACEBOOK_URL_PATTERN2', '~^https://www\.facebook\.com/[a-zA-Z0-9]{1,32}/videos/([0-9]{1,16})/?$~');
define('MEDIA_FACEBOOK_DIRECT_VIDEO_URL_PATTERN', '');

/**
 * 8 - Vimeo
 */

define(
    'MEDIA_VIMEO_URL_PATTERN',
    '~^https://(?:www\.)?vimeo.com/([0-9]{1,16})~'
);

define(
    'MEDIA_VIMEO_DIRECT_VIDEO_URL_PATTERN',
    '~^https://(?:www\.)?vimeo.com/([0-9]{1,16})~'
);

/**
 * 9 - AD'HOC Tube
 */

define('MEDIA_ADHOCTUBE_HOST', 'videos.adhocmusic.com');
define('MEDIA_ADHOCTUBE_URL_PATTERN', '~^https://' . MEDIA_ADHOCTUBE_HOST . '/videos/watch/([a-f0-9-]{36})~');

class Video extends Media
{
    /**
     * @var array<string>
     */
    protected static array $pk = [
        'id_video',
    ];

    /**
     * @var string
     */
    protected static string $table = 'adhoc_video';

    public const HOST_YOUTUBE = 1;
    public const HOST_DAILYMOTION = 2;
    public const HOST_FACEBOOK = 6;
    public const HOST_VIMEO = 8;
    public const HOST_ADHOCTUBE = 9;

    /**
     * @var array<int,string>
     */
    protected static $tab_hosts = [
        self::HOST_YOUTUBE => "YouTube",
        self::HOST_DAILYMOTION => "DailyMotion",
        self::HOST_FACEBOOK => "Facebook",
        self::HOST_VIMEO => "Vimeo",
        self::HOST_ADHOCTUBE => "AD'HOC Tube",
    ];

    /**
     * @var int
     */
    protected $id_video = 0;

    /**
     * @var int
     */
    protected $id_host = 0;

    /**
     * @var string
     */
    protected $reference;

    /**
     * @var float
     */
    protected $ratio;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
        'id_video' => 'int', // pk
        'id_contact' => 'int',
        'id_host' => 'int',
        'reference' => 'string',
        'ratio' => 'float',
        'id_groupe' => 'int', // deprecated ?
        'id_lieu' => 'int',
        'id_event' => 'int',
        'name' => 'string',
        'created_at' => 'date',
        'modified_at' => 'date',
        'online' => 'bool',
    ];

    /**
     * @return string
     */
    public static function getBaseUrl(): string
    {
        return MEDIA_URL . '/video';
    }

    /**
     * @return string
     */
    public static function getBasePath(): string
    {
        return MEDIA_PATH . '/video';
    }

    /**
     * @return int
     */
    public function getIdVideo(): int
    {
        return $this->id_video;
    }

    /**
     * @return int
     */
    public function getIdMedia(): int
    {
        return $this->getIdVideo();
    }

    /**
     * @return int
     */
    public function getIdHost(): int
    {
        return $this->id_host;
    }

    /**
     * Retourne l'objet VideoHost
     *
     * @return VideoHost
     */
    public function getHost(): VideoHost
    {
        return VideoHost::getInstance($this->getIdHost());
    }

    /**
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }

    /**
     * @return float
     */
    public function getRatio(): float
    {
        return $this->ratio;
    }

    /**
     * Retourne l'url de la page de la vidéo
     *
     * @return string
     */
    public function getUrl(): ?string
    {
        return HOME_URL . '/videos/' . $this->getIdVideo();
    }

    /**
     * Retourne l'url de la page d'édition de la vidéo
     *
     * @return string
     */
    public function getEditUrl(): ?string
    {
        return HOME_URL . '/videos/edit/' . $this->getIdVideo();
    }

    /**
     * Retourne l'url de la page de suppresion de la vidéo
     *
     * @return string
     */
    public function getDeleteUrl(): ?string
    {
        return HOME_URL . '/videos/delete/' . $this->getIdVideo();
    }

    /**
     * Retourne l'url directe d'un média .mp4
     * Utilisé pour og_video
     *
     * @deprecated
     * @return string
     */
    public function getDirectMp4Url(): ?string
    {
        return null;
    }

    /**
     * Retourne le chemin de l'imagette par défaut
     *
     * @return string
     */
    public static function getDefaultThumbPath(): string
    {
        return ADHOC_ROOT_PATH . '/assets/img/default-video-thumb.jpg';
    }

    /**
     * Retourne le chemin de l'imagette par défaut
     *
     * @return string
     */
    public static function getDefaultThumbUrl(): string
    {
        return HOME_URL . '/img/default-video-thumb.jpg';
    }

    /**
     * Retourne l'url d'une miniature de vidéo (sans vérifier l'existence du fichier)
     *
     * @param int  $maxWidth     largeur maxi
     * @param bool $genIfMissing force la génération de la miniature si manquante
     *
     * @return ?string
     */
    public function getThumbUrl(int $maxWidth = 0, bool $genIfMissing = false): ?string
    {
        $sourcePath = self::getBasePath() . '/' . $this->getIdVideo() . '.jpg';
        if (!file_exists($sourcePath)) {
            $sourcePath = self::getDefaultThumbPath();
        }

        if ($maxWidth === 0) {
            return self::getBaseUrl() . '/' . $this->getIdVideo() . '.jpg';
        } else {
            $uid = 'video/' . $this->getIdVideo() . '/' . $maxWidth;
            $cachePath = Image::getCachePath($uid);
            if (!file_exists($cachePath)) {
                if ($genIfMissing) {
                    $this->genThumb($maxWidth);
                } else {
                    // @TODO ajouter à une file de calcul
                }
            }
            return Image::getCacheUrl($uid);
        }
    }

    /**
     * @param int $id_video
     *
     * @return static
     */
    public function setIdVideo(int $id_video): static
    {
        if ($this->id_video !== $id_video) {
            $this->id_video = $id_video;
            $this->modified_fields['id_video'] = true;
        }

        return $this;
    }

    /**
     * Set l'id_host
     *
     * @param int $id_host identifiant hébergeur
     *
     * @return static
     */
    public function setIdHost(int $id_host): static
    {
        if ($this->id_host !== $id_host) {
            $this->id_host = $id_host;
            $this->modified_fields['id_host'] = true;
        }

        return $this;
    }

    /**
     * @param string $reference reference
     *
     * @return static
     */
    public function setReference(string $reference): static
    {
        if ($this->reference !== $reference) {
            $this->reference = $reference;
            $this->modified_fields['reference'] = true;
        }

        return $this;
    }

    /**
     * @param float $ratio ratio
     *
     * @return static
     */
    public function setRatio(float $ratio): static
    {
        if ($this->ratio !== $ratio) {
            $this->ratio = $ratio;
            $this->modified_fields['ratio'] = true;
        }

        return $this;
    }

    /**
     * Efface une vidéo de la table vidéo
     * + purge de l'imagette source
     * + ses déclinaisons de différentes largeurs
     *
     * @return bool
     */
    public function delete(): bool
    {
        $this->unlinkGroupes();

        if (parent::delete()) {
            $this->deleteThumbnail();
            $thumbWidths = Conf::getInstance()->get('video')['thumb_width'];
            foreach ($thumbWidths as $maxWidth) {
                $this->clearThumb($maxWidth);
            }
            return true;
        }
        return false;
    }

    /**
     * Retourne un tableau des groupes liés à cette vidéo
     *
     * @return array<Groupe>
     */
    public function getGroupes(): array
    {
        $groupes = Groupe::find([
            'id_video' => $this->getIdVideo(),
        ]);
        return $groupes;
    }

    /**
     * @return ?Groupe
     */
    public function getGroupe(): ?Groupe
    {
        $groupes = $this->getGroupes();
        if (count($groupes) >= 1) {
            return array_shift($groupes);
        }
        return null;
    }

    /**
     * Retire un groupe d'une vidéo
     *
     * @param int $id_groupe id_groupe
     *
     * @return bool
     */
    public function unlinkGroupe(int $id_groupe): bool
    {
        return VideoGroupe::getInstance([
            'id_video' => $this->getIdVideo(),
            'id_groupe' => $id_groupe,
        ])->delete();
    }

    /**
     * Ajoute un groupe à une vidéo
     *
     * @param int $id_groupe id_groupe
     *
     * @return bool
     */
    public function linkGroupe(int $id_groupe): bool
    {
        return VideoGroupe::init()
            ->setIdVideo($this->getIdVideo())
            ->setIdGroupe($id_groupe)
            ->save();
    }

    /**
     * Délie tous les groupes de cette vidéo
     *
     * @return bool
     */
    public function unlinkGroupes(): bool
    {
        foreach ($this->getGroupes() as $groupe) {
            $this->unlinkGroupe($groupe->getIdGroupe());
        }
        return true;
    }

    /**
     * Retourne le code du player vidéo embarqué
     *
     * @return ?string
     *
     * @see http://www.alsacreations.fr/dewtube
     * @see http://www.clubic.com/telecharger-fiche21739-riva-flv-encoder.html
     */
    public function getPlayer(): ?string
    {
        switch ($this->getIdHost()) {
            case self::HOST_YOUTUBE:
            case self::HOST_DAILYMOTION:
            case self::HOST_FACEBOOK:
            case self::HOST_VIMEO:
                return '<iframe src="' . $this->getEmbedUrl() . '" allowfullscreen></iframe>' . "\n";

            case self::HOST_ADHOCTUBE:
                return '<iframe src="' . $this->getEmbedUrl() . '" allowfullscreen sandbox="allow-same-origin allow-scripts"></iframe>' . "\n";

            default:
                return null;
        }
    }

    /**
     * Retourne la classe CSS à appliquer au player fluide
     *
     * @return string
     */
    public function getPlayerRatio(): string
    {
        if ($this->getRatio() < 1.5) {
            // certaines anciennes en 4/3
            return 'ratio-4-3'; // 1.333
        }
        // par défaut 16/9
        return 'ratio-16-9'; // 1.778
    }

    /**
     * Retourne l'url de l'iframe embed
     *
     * @return ?string
     */
    public function getEmbedUrl(): ?string
    {
        switch ($this->getIdHost()) {
            case self::HOST_YOUTUBE:
                return "https://www.youtube-nocookie.com/embed/" . $this->getReference() . "?rel=0";

            case self::HOST_DAILYMOTION:
                return "https://www.dailymotion.com/embed/video/" . $this->getReference() . "?theme=none&foreground=%23FFFFFF&highlight=%23CC0000&background=%23000000&wmode=transparent";

            case self::HOST_FACEBOOK:
                return "https://www.facebook.com/video/embed?video_id=" . $this->getReference();

            case self::HOST_VIMEO:
                return "https://player.vimeo.com/video/" . $this->getReference() . "?title=0&amp;byline=0&amp;portrait=0";

            case self::HOST_ADHOCTUBE:
                return "https://" . MEDIA_ADHOCTUBE_HOST . "/videos/embed/" . $this->getReference() . "?title=0&amp;warningTitle=0&amp;controls=1";

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
     * @return array<string,mixed>|false
     */
    public static function parseStringForVideoUrl(string $code): array|false
    {
        $str = trim($code);

        // attention, l'ordre des tests est très important, plusieurs media différents
        // pouvant partager le même type d'urls.

        // 1 - on essaye d'abord toutes les formes d'embed qu'on connait

        // YouTube
        if (preg_match(MEDIA_YOUTUBE_EMBED_PATTERN, $str, $matches) === 1) {
            return [
                'id_host' => self::HOST_YOUTUBE,
                'reference' => $matches[2],
            ];
        }

        // DailyMotion
        if (preg_match(MEDIA_DAILYMOTION_EMBED_PATTERN, $str, $matches) === 1) {
            return [
                'id_host' => self::HOST_DAILYMOTION,
                'reference' => $matches[3],
            ];
        }

        // avant de commencer les urls, si jamais ya pas de http:// devant, on le rajoute
        if ((strpos($str, 'http://') === false) && (strpos($str, 'https://') === false)) {
            $str = 'https://' . $str;
        }

        // 2 - on teste les urls, d'abord celle des pages contenant les videos, et ensuite
        // celles des videos elles memes.

        // YouTube
        if (preg_match(MEDIA_YOUTUBE_URL_PATTERN, $str, $matches) === 1) {
            return [
                'id_host' => self::HOST_YOUTUBE,
                'reference' => $matches[2],
            ];
        }

        // YouTube
        if (preg_match(MEDIA_YOUTUBE_DIRECT_VIDEO_URL_PATTERN, $str, $matches) === 1) {
            return [
                'id_host' => self::HOST_YOUTUBE,
                'reference' => $matches[2],
            ];
        }

        // DailyMotion
        if (preg_match(MEDIA_DAILYMOTION_DIRECT_VIDEO_URL_PATTERN, $str, $matches) === 1) {
            return [
                'id_host' => self::HOST_DAILYMOTION,
                'reference' => $matches[3],
            ];
        }

        // Facebook
        if (preg_match(MEDIA_FACEBOOK_URL_PATTERN, $str, $matches) === 1) {
            return [
                'id_host' => self::HOST_FACEBOOK,
                'reference' => $matches[1],
            ];
        }

        // Facebook
        if (preg_match(MEDIA_FACEBOOK_URL_PATTERN2, $str, $matches) === 1) {
            return [
                'id_host' => self::HOST_FACEBOOK,
                'reference' => $matches[1],
            ];
        }

        // Vimeo
        if (preg_match(MEDIA_VIMEO_URL_PATTERN, $str, $matches) === 1) {
            return [
                'id_host' => self::HOST_VIMEO,
                'reference' => $matches[1],
            ];
        }

        // AD'HOC Tube
        if (preg_match(MEDIA_ADHOCTUBE_URL_PATTERN, $str, $matches) === 1) {
            return [
                'id_host' => self::HOST_ADHOCTUBE,
                'reference' => $matches[1],
            ];
        }

        return false;
    }

    /**
     * Récupère l'url de la vignette de la vidéo
     *
     * @param int    $id_host   id_host
     * @param string $reference reference
     *
     * @return string|false
     */
    public static function getRemoteThumbnail(int $id_host, string $reference): string|false
    {
        switch ($id_host) {
            case self::HOST_YOUTUBE:
                $maxResUrl = "https://img.youtube.com/vi/{$reference}/maxresdefault.jpg"; // 1280*720 (pas tjrs là)
                $hqResUrl = "https://img.youtube.com/vi/{$reference}/hqdefault.jpg"; // 480*360
                return $hqResUrl; // retourne direct l'url hd plutôt que max
                /*
                $headers = get_headers($maxResUrl);
                if (substr($headers[0], 9, 3) === '200') {
                    return $maxResUrl;
                }
                return $hqResUrl;
                */

            case self::HOST_DAILYMOTION:
                $headers = get_headers('https://www.dailymotion.com/thumbnail/video/' . $reference, true);
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
                return ''; // à debug
                /*
                $headers = get_headers('https://graph.facebook.com/' . $reference . '/picture', 1);
                // Location pas toujours défini
                if (is_array($headers['Location'])) {
                    $url = $headers['Location'][0];
                } else {
                    $url = $headers['Location'];
                }
                return $url;
                */

            case self::HOST_ADHOCTUBE:
                $meta_url = 'https://' . MEDIA_ADHOCTUBE_HOST . '/api/v1/videos/' . $reference;
                if ($json = file_get_contents($meta_url)) {
                    $meta_info = json_decode($json);
                    return 'https://' . MEDIA_ADHOCTUBE_HOST . $meta_info->previewPath; // 560x315
                    //return 'https://' . MEDIA_ADHOCTUBE_HOST . $meta_info->thumbnailPath; // 200x110
                } else {
                    return false;
                }

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
    public static function getRemoteTitle(int $id_host, string $reference): ?string
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
                $doc = new \DOMDocument();
                $doc->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
                $title = str_replace(' - YouTube', '', $doc->getElementsByTagName('title')[0]->nodeValue);
                return $title;

            case self::HOST_DAILYMOTION:
                // @TODO à étudier/implémenter
                return null;

            case self::HOST_FACEBOOK:
                // @TODO à implémenter
                // difficile car par de balise <title> à parser
                return null;

            default:
                throw new \Exception('unknown video_host');
        }
    }

    /**
     * Efface une vignette locale
     *
     * @return bool
     */
    public function deleteThumbnail(): bool
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
    public function storeThumbnail(string $remote_url)
    {
        $tmp = self::getBasePath() . '/' . $this->id_video . '.jpg.tmp';
        $jpg = self::getBasePath() . '/' . $this->id_video . '.jpg';

        $confVideo = Conf::getInstance()->get('video');
        file_put_contents($tmp, file_get_contents($remote_url));
        (new Image($tmp))
            ->setType(IMAGETYPE_JPEG)
            ->setMaxWidth($confVideo['max_width'])
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
    public function clearThumb(int $maxWidth = 0): bool
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
     * Génère la miniature d'une vidéo (écrase la précédente)
     *
     * @param int $maxWidth maxWidth
     *
     * @return bool
     */
    public function genThumb(int $maxWidth = 0): bool
    {
        if ($maxWidth === 0) {
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
