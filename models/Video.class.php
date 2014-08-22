<?php

/**
 * @package adhoc
 */

/**
 * 1 - YouTube
 */
define('MEDIA_YOUTUBE_URL_PATTERN',
    '~^http://([A-Za-z]{2,3}\.)?youtube\.com/watch[/]?\?v=([A-Za-z0-9_-]{1,32})~');

define('__MEDIA_YOUTUBE_DIRECT_VIDEO_URL_PARTIAL_PATTERN',
    'http://([A-Za-z]{2,3}\.)?youtube\.com/v/([A-Za-z0-9_-]{1,32})');

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
    'http://([a-zA-Z0-9.]*\.)?dailymotion.com/(swf|video)/([0-9A-Za-z-]{1,32}).*');

define('MEDIA_DAILYMOTION_DIRECT_VIDEO_URL_PATTERN',
    '~^' . __MEDIA_DAILYMOTION_DIRECT_VIDEO_URL_PARTIAL_PATTERN . '$~');

define('MEDIA_DAILYMOTION_EMBED_PATTERN',
    '~<embed src=["\']' . __MEDIA_DAILYMOTION_DIRECT_VIDEO_URL_PARTIAL_PATTERN . '["\'] .*></embed>~');

/**
 * 3 - MySpace
 */
define('MEDIA_MYSPACE_URL_PATTERN',
    '~^http://(vids\.myspace\.com|myspacetv\.com)/index\.cfm\?fuseaction=vids\.individual&(videoid|VideoID)=([0-9]{1,10})~');

define('__MEDIA_MYSPACE_DIRECT_VIDEO_URL_PARTIAL_PATTERN',
    'http://(vids\.myspace\.com|myspacetv\.com)/index\.cfm\?fuseaction=vids\.individual&(videoid|VideoID)=([0-9]{1,10})');

define('__MEDIA_MYSPACE_EMBED_PARTIAL_PATTERN',
    'http://mediaservices.myspace.com/services/media/embed.aspx/m=([0-9]{1,10}),t=1,mt=video,searchID=,primarycolor=,secondarycolor=');

define('MEDIA_MYSPACE_DIRECT_VIDEO_URL_PATTERN',
    '~^' . __MEDIA_MYSPACE_DIRECT_VIDEO_URL_PARTIAL_PATTERN . '$~');

define('MEDIA_MYSPACE_EMBED_PATTERN',
       '~<a href="' . __MEDIA_MYSPACE_DIRECT_VIDEO_URL_PARTIAL_PATTERN . '">'.
       '([0-9A-Za-z-: ]{1,50})</a><br />' .
       '<object width="[0-9]{2,3}px" height="[0-9]{2,3}px" >' .
       '<param name="allowFullScreen" value="true"/>' .
       '<param name="wmode" value="transparent"/>' .
       '<param name="movie" value="' . __MEDIA_MYSPACE_EMBED_PARTIAL_PATTERN . '"/>' .
       '<embed src="' . __MEDIA_MYSPACE_EMBED_PARTIAL_PATTERN . '" width="[0-9]{2,3}" height="[0-9]{2,3}" allowFullScreen="true" type="application/x-shockwave-flash" wmode="transparent"/>' .
       '</object>~');

/**
 * 4 - Wat
 */
define('MEDIA_WAT_EMBED_PATTERN',
       '~^<param name="movie" value="http:\/\/www\.wat\.tv\/swf2\/([0-9a-zA-Z]{1,32}\/?[0-9]*)"/>~');

define('MEDIA_WAT_DIRECT_PLAYER_PATTERN',
       '');

/**
 * 5 - Google Video
 */
define('MEDIA_GOOGLEVIDEO_URL_PATTERN',
    '~^http://video\.google.*/videoplay.*docid=([-]?[0-9]{1,32})~'); // pas de $, il peut il y avoir une tonne de params derriere :(

define('__MEDIA_GOOGLEVIDEO_DIRECT_VIDEO_URL_PARTIAL_PATTERN',
    'http://video.google\..*/googleplayer\.swf.*docId=([-]?[0-9]{1,32}).*');

define('MEDIA_GOOGLEVIDEO_DIRECT_VIDEO_URL_PATTERN',
    '~^' . __MEDIA_GOOGLEVIDEO_DIRECT_VIDEO_URL_PARTIAL_PATTERN.'$~i');

// ça, c'est pas gérable, leur code d'embed est shuffled tous les trois mois
/*
define('MEDIA_GOOGLEVIDEO_EMBED_PATTERN',
    '~<embed style=".*" id="VideoPlayback" '.
    'type="application/x-shockwave-flash" src="'.
    __MEDIA_GOOGLEVIDEO_DIRECT_VIDEO_URL_PARTIAL_PATTERN.
    '"> </embed>~');
*/

define('MEDIA_GOOGLEVIDEO_EMBED_PATTERN',
    '~'.__MEDIA_GOOGLEVIDEO_DIRECT_VIDEO_URL_PARTIAL_PATTERN.'~i');

/**
 * 6 - Facebook
 */
define('MEDIA_FACEBOOK_URL_PATTERN',
       '~^http://www.facebook.com/v/([0-9]{1,16})~');

define('MEDIA_FACEBOOK_URL_PATTERN2',
       '~^https://www.facebook.com/video/video.php?v=([0-9]{1,16})~');

define('MEDIA_FACEBOOK_DIRECT_VIDEO_URL_PATTERN',
       '');

define('MEDIA_FACEBOOK_EMBED_PATTERN',
       '');

/**
 * 7 - AD'HOC
 */

define('MEDIA_ADHOC_URL_PATTERN',
       '~^http://static.adhocmusic.com/media/video/([a-zA-Z0-9]{1,32})\.([a-z]{3})~');

define('MEDIA_ADHOC_DIRECT_VIDEO_URL_PATTERN',
       '~^http://static.adhocmusic.com/media/video/([a-zA-Z0-9]{1,32})\.([a-z]{3})~');

define('MEDIA_ADHOC_EMBED_PATTERN',
       '');

/**
 * 8 - Vimeo
 */

define('MEDIA_VIMEO_URL_PATTERN',
       '~^http://(www\.)?vimeo.com/([0-9]{1,16})~');

define('MEDIA_VIMEO_DIRECT_VIDEO_URL_PATTERN',
       '~^http://(www\.)?vimeo.com/([0-9]{1,16})~');

define('MEDIA_VIMEO_EMBED_PATTERN',
       '');

/**
 * Classe Vidéo
 *
 * Classe de gestion des vidéos du site
 * Appel conversion, upload etc ...
 *
 * @package adhoc
 * @author Guillaume Seznec <guillaume.seznec@gmail.com>
 */
class Video extends Media
{
    /**
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

    const DEFAULT_THUMBNAIL = 'http://static.adhocmusic.com/img/videothumb.jpg';

    const HOST_YOUTUBE     = 1;
    const HOST_DAILYMOTION = 2;
    const HOST_MYSPACE     = 3;
    const HOST_WAT         = 4;
    const HOST_GOOGLE      = 5;
    const HOST_FACEBOOK    = 6;
    const HOST_ADHOC       = 7;
    const HOST_VIMEO       = 8;

    protected static $_tab_hosts = array(
        self::HOST_YOUTUBE     => "YouTube",
        self::HOST_DAILYMOTION => "DailyMotion",
        self::HOST_MYSPACE     => "MySpace",
        self::HOST_WAT         => "Wat",
        self::HOST_GOOGLE      => "Google",
        self::HOST_FACEBOOK    => "Facebook",
        self::HOST_ADHOC       => "AD'HOC",
        self::HOST_VIMEO       => "Vimeo",
    );

    /**
     * dimensions du player
     */
    const WIDTH  = 640;
    const HEIGHT = 480;

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
     * on précise si en base c'est de type :
     * - numérique/integer/float/bool (= int)
     * - datetime/text (= str)
     * ceci est utile pour la formation de la requête
     * @var array
     */
    protected static $_all_fields = array(
        'id_contact'   => 'num',
        'id_host'      => 'num',
        'reference'    => 'str',
        'id_groupe'    => 'num',
        'id_lieu'      => 'num',
        'id_event'     => 'num',
        'id_structure' => 'num',
        'name'         => 'str',
        'created_on'   => 'str',
        'modified_on'  => 'str',
        'online'       => 'bool',
        'width'        => 'num',
        'height'       => 'num',
    );

    /**
     * Tableau des attributs modifiés depuis la dernière sauvegarde.
     *
     * Pour chaque attribut modifié, on a un élément de la forme 'attribut => true'.
     * @var array
     */
    protected $_modified_fields = array();

    /* début getters */

    /**
     * @return string
     */
    protected static function _getWwwPath()
    {
        return STATIC_URL . '/media/video';
    }

    /**
     * @return string
     */
    protected static function _getLocalPath()
    {
        return ADHOC_ROOT_PATH . '/static/media/video';
    }

    /**
     * @return int
     */
    public function getIdHost()
    {
        return (int) $this->_id_host;
    }

    /**
     * retourne le libellé d'un hébergeur
     *
     * @return string
     */
    public function getHostName()
    {
        return (string) self::$_tab_hosts[$this->_id_host];
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return (string) $this->_reference;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        if($this->_width) {
            return (int) $this->_width;
        }
        return self::WIDTH;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        if($this->_height) {
            return (int) $this->_height;
        }
        return self::HEIGHT;
    }

    /**
     * @return string
     */
    public function getUrl($type = null)
    {
        return self::getUrlById($this->getId(), $type);
    }

    /**
     * @param int
     * @return string
     */
    public static function getUrlById($id, $type = null)
    {
        if($type == 'www') {
            return 'http://www.adhocmusic.com/videos/show/' . $id;
        }
        return DYN_URL . '/videos/show/' . $id;
    }

    /**
     * @return string
     */
    public function getDirectUrl()
    {
        return self::getFlashUrl($this->getIdHost(), $this->getReference());
    }

    /* fin getters */

    /* début setters */

    /**
     * @param int
     */
    public function setIdHost($val)
    {
        if ($this->_id_host != $val)
        {
            $this->_id_host = (int) $val;
            $this->_modified_fields['id_host'] = true;
        }
    }

    /**
     * @param string
     */
    public function setReference($val)
    {
        if ($this->_reference != $val)
        {
            $this->_reference = (string) $val;
            $this->_modified_fields['reference'] = true;
        }
    }

    /**
     * @param int
     */
    public function setWidth($val)
    {
        if ($this->_width != $val)
        {
            $this->_width = (int) $val;
            $this->_modified_fields['width'] = true;
        }
    }

    /**
     * @param bool
     */
    public function setHeight($val)
    {
        if ($this->_height != $val)
        {
            $this->_height = (int) $val;
            $this->_modified_fields['height'] = true;
        }
    }

    /* fin setters */

    /**
     * retourne le listing des hébergeurs supportés
     *
     * @return array
     */
    public static function getHosts()
    {
        return self::$_tab_hosts;
    }

    /**
     * retourne le listing des hébergeurs supportés
     *
     * @return array
     */
    public static function getVideoHosts()
    {
        $tab = array();
        foreach(self::$_tab_hosts as $host_id => $host_name) {
            $tab[] = array(
                'id'   => $host_id,
                'name' => $host_name,
            );
        }
        return $tab;
    }

    /**
     * @param int $host_id
     * @return string
     */
    public static function getHostNameByHostId($host_id)
    {
        return self::$_tab_hosts[$host_id];
    }

    /**
     * recherche des vidéos en fonction de critères donnés
     *
     * @param array ['groupe']    => "5"
     *              ['structure'] => "1,3"
     *              ['lieu']      => "1"
     *              ['event']     => "1"
     *              ['id']        => "3"
     *              ['sort']      => "id_video|date|random"
     *              ['sens']      => "ASC"
     *              ['debut']     => 0
     *              ['limit']     => 10
     * @return array
     */
    public static function getVideos($params = array())
    {
        $debut = 0;
        if(isset($params['debut'])) {
            $debut = (int) $params['debut'];
        }

        $limit = 10;
        if(isset($params['limit'])) {
            $limit = (int) $params['limit'];
        }

        $sens = 'ASC';
        if(isset($params['sens']) && $params['sens'] == 'DESC') {
            $sens = 'DESC';
        }

        $sort = 'id_video';
        if(isset($params['sort'])
            && ($params['sort'] == 'date' || $params['sort'] == 'random')) {
            $sort = $params['sort'];
        }

        $tab_groupe    = array();
        $tab_structure = array();
        $tab_lieu      = array();
        $tab_event     = array();
        $tab_id        = array();
        $tab_contact   = array();

        if(array_key_exists('groupe', $params))    { $tab_groupe    = explode(",", $params['groupe']); }
        if(array_key_exists('structure', $params)) { $tab_structure = explode(",", $params['structure']); }
        if(array_key_exists('lieu', $params))      { $tab_lieu      = explode(",", $params['lieu']); }
        if(array_key_exists('event', $params))     { $tab_event     = explode(",", $params['event']); }
        if(array_key_exists('id', $params))        { $tab_id        = explode(",", $params['id']); }
        if(array_key_exists('contact', $params))   { $tab_contact   = explode(",", $params['contact']); }

        $db = DataBase::getInstance();

        $sql = "SELECT `v`.`id_video` AS `id`, `v`.`name`, `v`.`online`, `v`.`id_host` AS `host_id`, `v`.`reference`, 'video' AS `type`, "
             . "`v`.`width`, `v`.`height`, `v`.`created_on`, `v`.`modified_on`, "
             . "`g`.`id_groupe` AS `groupe_id`, `g`.`name` AS `groupe_name`, `g`.`alias` AS `groupe_alias`, "
             . "`s`.`id_structure` AS `structure_id`, `s`.`name` AS `structure_name`, "
             . "`l`.`id_lieu` AS `lieu_id`, `l`.`name` AS `lieu_name`, `l`.`city`, `l`.`id_departement` AS `departement_id`, "
             . "`e`.`id_event` AS `event_id`, `e`.`name` AS `event_name`, `e`.`date` AS `event_date`, "
             . "`m`.`id_contact` AS `contact_id`, `m`.`pseudo` "
             . "FROM (`" . self::$_db_table_video . "` `v`) "
             . "LEFT JOIN `" . self::$_db_table_groupe . "` `g` ON (`v`.`id_groupe` = `g`.`id_groupe`) "
             . "LEFT JOIN `" . self::$_db_table_structure . "` `s` ON (`v`.`id_structure` = `s`.`id_structure`) "
             . "LEFT JOIN `" . self::$_db_table_lieu . "` `l` ON (`v`.`id_lieu` = `l`.`id_lieu`) "
             . "LEFT JOIN `" . self::$_db_table_event . "` `e` ON (`v`.`id_event` = `e`.`id_event`) "
             . "LEFT JOIN `" . self::$_db_table_membre . "` `m` ON (`v`.`id_contact` = `m`.`id_contact`) "
             . "WHERE 1 ";

        if(array_key_exists('online', $params)) {
            if($params['online']) {
                $online = 'TRUE';
            } else {
                $online = 'FALSE';
            }
            $sql .= "AND `v`.`online` = " . $online . " ";
        }

        if(count($tab_groupe) && ($tab_groupe[0] != 0)) {
            $sql .= "AND `v`.`id_groupe` IN (" . implode(',', $tab_groupe) . ") ";
        }

        if(count($tab_structure) && ($tab_structure[0] != 0)) {
            $sql .= "AND `v`.`id_structure` IN (" . implode(',', $tab_structure) . ") ";
        }

        if(count($tab_lieu) && ($tab_lieu[0] != 0)) {
            $sql .= "AND `v`.`id_lieu` IN (" . implode(',', $tab_lieu) . ") ";
        }

        if(count($tab_event) && ($tab_event[0] != 0)) {
            $sql .= "AND `v`.`id_event` IN (" . implode(',', $tab_event) . ") ";
        }

        if(count($tab_id) && ($tab_id[0] != 0)) {
            $sql .= "AND `v`.`id_video` IN (" . implode(',', $tab_id) . ") ";
        }

        if(count($tab_contact) && ($tab_contact[0] != 0)) {
            $sql .= "AND `v`.`id_contact` IN (" . implode(',', $tab_contact) . ") ";
        }

        $sql .= "ORDER BY ";
        if($sort == "random") {
            $sql .= "RAND(".time().") ";
        } else {
            $sql .= "`v`.`" . $sort . "` " . $sens . " ";
        }
        $sql .= "LIMIT " . $debut . ", " . $limit;

        $res_tmp = $db->queryWithFetch($sql);
        $res = array();
        foreach($res_tmp as $idx => $_res) {
            $res[$idx] = $_res;
            $res[$idx]['url'] = self::getUrlById($_res['id']);
            $res[$idx]['swf'] = self::getFlashUrl($_res['host_id'], $_res['reference']);
            $res[$idx]['thumb_80_80'] = self::getVideoThumbUrl($_res['id'], 80, 80, '000000', false, true);
        }

        return $res;
    }

    /**
     * efface une vidéo de la table vidéo
     * + purge du fichier miniature
     *
     * @param int $id_video
     * @param string $reference
     * @return bool
     */
    public function delete()
    {
        if(parent::delete())
        {
            $this->deleteThumbnail();
            self::invalidateVideoThumbInCache($this->getId(), 80, 80, '000000', false, true);
            return true;
        }
        return false;
    }

    /**
     * retourne le code du player vidéo embarqué
     *
     * @see http://www.alsacreations.fr/dewtube
     * @see http://www.clubic.com/telecharger-fiche21739-riva-flv-encoder.html
     * @param bool $autoplay
     * @return string
     */
    public function getPlayer($autoplay = false, $iframe = true)
    {
        switch($this->_id_host)
        {
            case self::HOST_YOUTUBE:
                $autoplay ? $strautoplay = '1' : $strautoplay = '';
                if($iframe) {
                    return '<iframe title="'.htmlspecialchars($this->getName()).'" width="'.$this->getWidth().'" height="'.$this->getHeight().'" src="http://www.youtube.com/embed/'.$this->_reference.'?rel=0" frameborder="0" allowfullscreen></iframe>' . "\n";
                } else {
                    return '<object width="'.$this->getWidth().'" height="'.$this->getHeight().'">' . "\n"
                     . '<param name="movie" value="http://www.youtube.com/v/'.$this->_reference.'&amp;autoplay='.$strautoplay.'"></param>' . "\n"
                     . '<param name="wmode" value="transparent"></param>' . "\n"
                     . '<embed src="http://www.youtube.com/v/'.$this->_reference.'&amp;autoplay='.$strautoplay.'" type="application/x-shockwave-flash" wmode="transparent" width="'.$this->getWidth().'" height="'.$this->getHeight().'"></embed>' . "\n"
                     . '</object>' . "\n";
                }

            case self::HOST_DAILYMOTION:
                $autoplay ? $strautoplay = '1' : $strautoplay = '0';
                // taille par défaut : l330 / h267
                if($iframe) {
                    return '<iframe frameborder="0" width="'.self::WIDTH.'" height="'.self::HEIGHT.'" src="http://www.dailymotion.com/embed/video/'.$this->_reference.'?theme=none&foreground=%23FFFFFF&highlight=%23CC0000&background=%23000000&autoPlay='.$strautoplay.'&wmode=transparent"></iframe>' . "\n";
                } else {
                    return '<object width="'.self::WIDTH.'" height="'.self::HEIGHT.'">' . "\n"
                         . '<param name="movie" value="http://www.dailymotion.com/swf/'.$this->_reference.'&amp;autoplay='.$strautoplay.'"></param>' . "\n"
                         . '<param name="wmode" value="transparent"></param>' . "\n"
                         . '<param name="allowfullscreen" value="true"></param>' . "\n"
                         . '<embed src="http://www.dailymotion.com/swf/'.$this->_reference.'&amp;autoplay='.$strautoplay.'" type="application/x-shockwave-flash" width="'.self::WIDTH.'" height="'.self::HEIGHT.'" allowfullscreen="true" wmode="transparent"></embed>' . "\n"
                         . '</object>' . "\n";
                }

            case self::HOST_MYSPACE:
                $autoplay ? $strautoplay = '1' : $strautoplay = '0';
                return '<object enableJSURL="false" enableHREF="false" saveEmbedTags="true" allowScriptAccess="never" allownetworking="internal" type="application/x-shockwave-flash" data="http://lads.myspace.com/videos/vplayer.swf" width="'.self::WIDTH.'" height="'.self::HEIGHT.'" autostart="'.$strautoplay.'" wmode="transparent">' . "\n"
                     . '<param name="movie" value="http://lads.myspace.com/videos/vplayer.swf" />' . "\n"
                     . '<param name="wmode" value="transparent"></param>' . "\n"
                     . '<param name="allowScriptAccess" value="never" />' . "\n"
                     . '<param name="enableJSURL" value="false" />' . "\n"
                     . '<param name="enableHREF" value="false" />' . "\n"
                     . '<param name="saveEmbedTags" value="true" />' . "\n"
                     . '<param name="AutoStart" value="'.$strautoplay.'" />' . "\n"
                     . '<param name="flashvars" value="m='.$this->_reference.'&amp;type=video&amp;a='.$strautoplay.'" />' . "\n"
                     . '</object>' . "\n";

            case self::HOST_WAT:
                $autoplay ? $strautoplay = 'true' : $strautoplay = 'false';
                // taille par défaut : l320 / h256
                // todo passer swf en swf2 ?
                return '<object width="'.self::WIDTH.'" height="'.self::HEIGHT.'">'. "\n"
                     . '<param name="movie" value="http://www.wat.tv/swf/'.$this->_reference.'"></param>'. "\n"
                     . '<param name="wmode" value="transparent"></param>' . "\n"
                     . '<param name="allowFullScreen" value="true"></param>' . "\n"
                     . '<param name="allowScriptAccess" value="always"></param>' . "\n"
                     . '<param name="autoplay" value="'.$strautoplay.'"></param>'. "\n"
                     . '<embed src="http://www.wat.tv/swf/'.$this->_reference.'" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="'.self::WIDTH.'" height="'.self::HEIGHT.'"></embed>'. "\n"
                     . '</object>' . "\n";

            case self::HOST_GOOGLE:
                // todo : autostart
                // taille par défaut : l400 / h325
                return '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="'.self::WIDTH.'" height="'.self::HEIGHT.'">' . "\n"
                     . '<param name="movie" value="http://video.google.com/googleplayer.swf?docId='.$this->_reference.'&amp;hl=fr" />' . "\n"
                     . '<param name="wmode" value="transparent"></param>' . "\n"
                     . '<param name="quality" value="high" />' . "\n"
                     . '<param name="lang" value="fr" /><param name="dir_racine" value="" /><param name="id" value="610" />' . "\n"
                     . '<!--[if !IE]> <-->' . "\n"
                     . '<object data="http://video.google.com/googleplayer.swf?docId='.$this->_reference.'&amp;hl=fr" width="'.self::WIDTH.'" height="'.self::HEIGHT.'" type="application/x-shockwave-flash">' . "\n"
                     . '<param name="quality" value="high" />' . "\n"
                     . '<param name="lang" value="fr" />' . "\n"
                     . '<param name="dir_racine" value="" />' . "\n"
                     . '<param name="id" value="610" />' . "\n"
                     . '<param name="pluginurl" value="http://www.macromedia.com/go/getflashplayer" />' . "\n"
                     . '</object>' . "\n"
                     . '<!--> <![endif]-->' . "\n"
                     . '</object>' . "\n";

            case self::HOST_FACEBOOK:
                return '<object width="'.self::WIDTH.'" height="'.self::HEIGHT.'" >' . "\n"
                     . '<param name="allowfullscreen" value="true" />' . "\n"
                     . '<param name="allowscriptaccess" value="always" />' . "\n"
                     . '<param name="movie" value="http://www.facebook.com/v/'.$this->_reference.'" />' . "\n"
                     . '<embed src="http://www.facebook.com/v/'.$this->_reference.'" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="'.self::WIDTH.'" height="'.self::HEIGHT.'">' . "\n"
                     . '</embed>' . "\n"
                     . '</object>' . "\n";

            case self::HOST_ADHOC:
                $autoplay ? $strautoplay = 'true' : $strautoplay = 'false';
                if(IS_MOBILE) {
                    $width  = '320';
                    $height = '180';
                    return '<video id="mediaspace" poster="' . STATIC_URL . '/media/video/' . $this->getId() . '.jpg" width="320" height="180" controls>' . "\n"
                         . '<source src="' . STATIC_URL . '/media/video/' . $this->getId() . '.mp4" type="video/mp4">' . "\n"
                         . '</video>' . "\n";
                } else {
                    $width  = $this->getWidth();
                    $height = $this->getHeight();
                }
                return ''
                     . '<script src="' . STATIC_URL . '/jwplayer/jwplayer.js"></script>' . "\n"
                     . '<div style="margin: 0; padding: 0" id="mediaspace"></div>'
                     //. '<video id="mediaspace" poster="' . STATIC_URL . '/media/video/' . $this->getId() . '.jpg" width="640" height="360" controls>' . "\n"
                     //. '<source src="' . $this->getDirectUrl() . '" type="video/mp4">' . "\n"
                     //. '</video>' . "\n"
                     . '<script>' . "\n"
                     . 'jwplayer("mediaspace").setup({' .  "\n"
                     . '  "flashplayer": "' . STATIC_URL . '/jwplayer/player.swf",' .  "\n"
                     . '  "file": "' . STATIC_URL . '/media/video/' . $this->getReference() . '",' .  "\n"
                     . '  "image": "' . STATIC_URL . '/media/video/' . $this->getId() . '.jpg",' .  "\n"
                     . '  "backcolor": "cc0000",' .  "\n"
                     . '  "frontcolor": "ffffff",' .  "\n"
                     . '  "screencolor": "000000",' .  "\n"
                     . '  "controlbar": "over",' .  "\n"
                     . '  "autostart": "' . $strautoplay . '",' . "\n"
                     . '  "width": "' . $width . '",' .  "\n"
                     . '  "height": "' . $height . '"' .  "\n"
                     . '});' .  "\n"
                     . '</script>' .  "\n";

            case self::HOST_VIMEO:
                $autoplay ? $strautoplay = '1' : $strautoplay = '0';
                if($iframe) {
                    return '<iframe src="http://player.vimeo.com/video/'.$this->_reference.'?title=0&amp;byline=0&amp;portrait=0&amp;autoplay='.$strautoplay.'" width="'.self::WIDTH.'" height="'.self::HEIGHT.'" frameborder="0"></iframe>' . "\n";
                } else {
                    return '<object width="'.self::WIDTH.'" height="'.self::HEIGHT.'">' . "\n"
                         . '<param name="allowfullscreen" value="true" />' . "\n"
                         . '<param name="allowscriptaccess" value="always" />' . "\n"
                         . '<param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id='.$this->_reference.'&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=00adef&amp;fullscreen=1&amp;autoplay='.$strautoplay.'&amp;loop=0" />' . "\n"
                         . '<embed src="http://vimeo.com/moogaloop.swf?clip_id='.$this->_reference.'&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=00adef&amp;fullscreen=1&amp;autoplay='.$strautoplay.'&amp;loop=0" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="'.self::WIDTH.'" height="'.self::HEIGHT.'"></embed>' . "\n"
                         . '</object>' . "\n";
                }
            default:
                return false;
        }
    }

    /**
     * @param int $id_host
     * @param string $reference
     * @return string
     */
    public static function getFlashUrl($id_host, $reference)
    {
        switch($id_host)
        {
            case self::HOST_YOUTUBE:
                return 'http://youtube.com/v/' . $reference . '&hl=fr';

            case self::HOST_DAILYMOTION:
                return 'http://www.dailymotion.com/swf/' . $reference . '&autoplay=1';

            case self::HOST_MYSPACE:
                return 'http://lads.myspace.com/videos/vplayer.swf?m=' . $reference . '&type=video&a=1';

            case self::HOST_WAT:
                return 'http://www.wat.tv/swf/' . $reference;

            case self::HOST_GOOGLE:
                return 'http://video.google.com/googleplayer.swf?docId=' . $reference . '&hl=fr&playerMode=mini';

            case self::HOST_FACEBOOK:
                return 'http://b.static.ak.fbcdn.net/swf/mvp.swf?v=' . $reference;

            case self::HOST_ADHOC:
                return 'http://static.adhocmusic.com/jwplayer/player.swf'
                     . '?file=http://static.adhocmusic.com/media/video/' . $reference
                     . '&backcolor=990000'
                     . '&frontcolor=FFFFFF'
                     . '&screencolor=000000'
                     . '&autostart=true'
                     . '&controbar=over';

            case self::HOST_VIMEO:
                return 'http://vimeo.com/' . $reference;

            default:
                return false;
        }
    }

    /**
     * cherche une url de video dans une chaine, et en ressort un tableau avec
     * un id pour le "fournisseur" de la video et l'id de la video chez ledit
     * fournisseur, ou bien FALSE.
     *
     * @param string $code
     * @return array ou false
     */
    public static function parseStringForVideoUrl($str)
    {
        $str = trim($str);

        // attention, l'ordre des tests est très important, plusieurs media différents
        // pouvant partager le même type d'urls.

        // 1 - on essaye d'abord toutes les formes d'embed qu'on connait

        // YouTube
        if (preg_match(MEDIA_YOUTUBE_EMBED_PATTERN, $str, $matches)) {
            if (!empty($matches[2])) {
                return array('id_host' => self::HOST_YOUTUBE, 'reference' => $matches[2]);
            }
        }

        // GoogleVideo
        if (preg_match(MEDIA_GOOGLEVIDEO_EMBED_PATTERN, $str, $matches)) {
            if (!empty($matches[1])) {
                return array('id_host' => self::HOST_GOOGLE, 'reference' => $matches[1]);
            }
        }

        // DailyMotion
        if (preg_match(MEDIA_DAILYMOTION_EMBED_PATTERN, $str, $matches)) {
            if (!empty($matches[3])) {
                return array('id_host' => self::HOST_DAILYMOTION, 'reference' => $matches[3]);
            }
        }

        // MySpace
        if (preg_match(MEDIA_MYSPACE_EMBED_PATTERN, $str, $matches)) {
            if (!empty($matches[3])) {
                return array('id_host' => self::HOST_MYSPACE, 'reference' => $matches[3]);
            }
        }

        // avant de commencer les urls, si jamais ya pas de http:// devant, on le rajoute
        if (strpos($str, 'http://') === false) {
            $str = 'http://' . $str;
        }

        // 2 - on teste les urls, d'abord celle des pages contenant les videos, et ensuite
        // celles des videos elles memes.

        // YouTube
        if (preg_match(MEDIA_YOUTUBE_URL_PATTERN, $str, $matches)) {
            if (!empty($matches[2])) {
                return array('id_host' => self::HOST_YOUTUBE, 'reference' => $matches[2]);
            }
        }

        // YouTube
        if (preg_match(MEDIA_YOUTUBE_DIRECT_VIDEO_URL_PATTERN, $str, $matches)) {
            if (!empty($matches[2])) {
                return array('id_host' => self::HOST_YOUTUBE, 'reference' => $matches[2]);
            }
        }

        // Google ne veut pas qu'on choppe ses vidéos comme ca.
        /*
        if (preg_match(MEDIA_GOOGLEVIDEO_URL_PATTERN, $str, $matches)) {
            if (!empty($matches[1])) {
                return array('id_host' => self::HOST_GOOGLE, 'reference' => $matches[1]);
            }
        }*/

        // GoogleVideo
        if (preg_match(MEDIA_GOOGLEVIDEO_DIRECT_VIDEO_URL_PATTERN, $str, $matches)) {
            if (!empty($matches[1])) {
                return array('id_host' => self::HOST_GOOGLE, 'reference' => $matches[1]);
            }
        }

        // DailyMotion
        if (preg_match(MEDIA_DAILYMOTION_DIRECT_VIDEO_URL_PATTERN, $str, $matches)) {
            if (!empty($matches[3])) {
                return array('id_host' => self::HOST_DAILYMOTION, 'reference' => $matches[3]);
            }
        }

        // MySpace
        if (preg_match(MEDIA_MYSPACE_URL_PATTERN, $str, $matches)) {
            if (!empty($matches[3])) {
                return array('id_host' => self::HOST_MYSPACE, 'reference' => $matches[3]);
            }
        }

        // MySpace
        if (preg_match(MEDIA_MYSPACE_DIRECT_VIDEO_URL_PATTERN, $str, $matches)) {
            if (!empty($matches[3])) {
                return array('id_host' => self::HOST_MYSPACE, 'reference' => $matches[3]);
            }
        }

        // Facebook
        if (preg_match(MEDIA_FACEBOOK_URL_PATTERN, $str, $matches)) {
            if (!empty($matches[1])) {
                return array('id_host' => self::HOST_FACEBOOK, 'reference' => $matches[1]);
            }
        }

        // Facebook
        if (preg_match(MEDIA_FACEBOOK_URL_PATTERN, $str, $matches)) {
            if (!empty($matches[1])) {
                return array('id_host' => self::HOST_FACEBOOK, 'reference' => $matches[1]);
            }
        }

        // AD'HOC
        if (preg_match(MEDIA_ADHOC_URL_PATTERN, $str, $matches)) {
            if (!empty($matches[1])) {
                return array('id_host' => self::HOST_ADHOC, 'reference' => $matches[1]);
            }
        }

        // Vimeo
        if (preg_match(MEDIA_VIMEO_URL_PATTERN, $str, $matches)) {
            if (!empty($matches[2])) {
                return array('id_host' => self::HOST_VIMEO, 'reference' => $matches[2]);
            }
        }

        return false;
    }

    /**
     * @todo comme Photo et Audio, requete plus complete ?
     */
    protected function _loadFromDb()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `name`, `created_on`, `created_on` AS `modified_on`, "
             . "`online`, `id_host`, `reference`, `id_groupe`, `id_structure`, "
             . "`id_lieu`, `id_event`, `id_contact`, "
             . "`width`, `height` "
             . "FROM `" . self::$_db_table_video . "` "
             . "WHERE `id_video` = " . (int) $this->_id_video;

        if($res = $db->queryWithFetchFirstRow($sql)) {
            $this->_dbToObject($res);
            return true;
        }

        throw new AdHocUserException('Vidéo introuvable', EXCEPTION_USER_UNKNOW_ID);
    }

    /**
     * récupère l'url de la vignette de la vidéo
     *
     * @param int $id_host
     * @param string $reference
     * @param bool $multi (retourne plusieurs vignettes si dispo)
     * @return string ou array de string
     */
    public static function getRemoteThumbnail($id_host, $reference, $multi = false)
    {
        switch($id_host)
        {
            case self::HOST_YOUTUBE:
                if($multi) {
                    $url   = array();
                    $url[] = 'http://img.youtube.com/vi/' . $reference . '/1.jpg'; // 130*97
                    $url[] = 'http://img.youtube.com/vi/' . $reference . '/2.jpg'; // 130*97
                    $url[] = 'http://img.youtube.com/vi/' . $reference . '/3.jpg'; // 130*97
                    $url[] = 'http://img.youtube.com/vi/' . $reference . '/default.jpg'; // 130*97, = 1.jpg
                    $url[] = 'http://img.youtube.com/vi/' . $reference . '/0.jpg'; // 320*240, = 2.jpg
                } else {
                    $url = 'http://img.youtube.com/vi/' . $reference . '/0.jpg';
                }
                return $url;

            case self::HOST_DAILYMOTION:
                $headers = get_headers('http://www.dailymotion.com/thumbnail/video/' . $reference, 1);
                if(is_array($headers['Location'])) {
                    $url = $headers['Location'][0];
                } else {
                    $url = $headers['Location'];
                }
                return $url;

            case self::HOST_ADHOC:
                return 'http://static.adhocmusic.com/media/video/' . $reference . '.jpg';

            case self::HOST_VIMEO:
                $meta_url = 'http://vimeo.com/api/v2/video/' . $reference . '.json';
                $meta_info = json_decode(file_get_contents($meta_url));
                return $meta_info[0]->thumbnail_large;

            case self::HOST_MYSPACE:
            case self::HOST_WAT:
            case self::HOST_GOOGLE:
            case self::HOST_FACEBOOK:
                return self::DEFAULT_THUMBNAIL;

            default:
                return false;
        }
    }

    /**
     * récupère le title distant de la vidéo
     *
     * @param int $id_host
     * @param string $reference
     * @return string
     */
    public static function getRemoteTitle($id_host, $reference)
    {
        switch($id_host)
        {
            case self::HOST_YOUTUBE:
            case self::HOST_DAILYMOTION:
            case self::HOST_ADHOC:
            case self::HOST_MYSPACE:
            case self::HOST_WAT:
            case self::HOST_GOOGLE:
            case self::HOST_FACEBOOK:
            default:
                return '';

            case self::HOST_VIMEO:
                $meta_url = 'http://vimeo.com/api/v2/video/' . $reference . '.json';
                $meta_info = json_decode(file_get_contents($meta_url));
                return $meta_info[0]->title;
        }
    }

    /**
     * efface une vignette locale
     *
     * @param int $id_video
     * @return bool
     */
    public function deleteThumbnail()
    {
        if(file_exists(self::_getLocalPath() . '/' . $this->getId() . '.jpg')) {
            unlink(self::_getLocalPath() . '/' . $this->getId() . '.jpg');
            return true;
        }
        return false;
    }

    /**
     * ecrit une vignette
     *
     * @param int $id_video
     * @param string $remote_url
     * @return bool
     */
    public function storeThumbnail($remote_url)
    {
        $tmp = self::_getLocalPath() . '/' . $this->_id_video . '.jpg.tmp';
        $jpg = self::_getLocalPath() . '/' . $this->_id_video . '.jpg';

        file_put_contents($tmp, file_get_contents($remote_url));
        $objImg = new Image($tmp);
        $objImg->setType(IMAGETYPE_JPEG);
        $objImg->setMaxWidth(320);
        $objImg->setMaxHeight(240);
        $objImg->setDestFile($jpg);
        $objImg->write();
        unset($objImg);
        unlink($tmp);

        return true;
    }

    public static function invalidateVideoThumbInCache($id, $width = 80, $height = 80, $bgcolor = '000000', $border = 0, $zoom = 1)
    {
        $uid = 'video/' . $id . '/' . $width . '/' . $height . '/' . $bgcolor . '/' . $border . '/' . $zoom . '.jpg';
        $cache = Image::getLocalCachePath($uid);

        if(file_exists($cache)) {
            unlink($cache);
            return true;
        }

        return false;
    }

    /**
     * retourne l'url de la vignette vidéo
     * gestion de la mise en cache
     * @return string
     */
    public static function getVideoThumbUrl($id, $width = 80, $height = 80, $bgcolor = '000000', $border = 0, $zoom = 1)
    {
        $uid = 'video/' . $id . '/' . $width . '/' . $height . '/' . $bgcolor . '/' . $border . '/' . $zoom . '.jpg';
        $cache = Image::getLocalCachePath($uid);

        if(!file_exists($cache)) {
            $source = ADHOC_ROOT_PATH . '/static/media/video/' . $id . '.jpg';
            if(file_exists($source)) {
                $img = new Image($source);
                $img->setType(IMAGETYPE_JPEG);
                $img->setMaxWidth($width);
                $img->setMaxHeight($height);
                $img->setBorder($border);
                $img->setKeepRatio(true);
                if($zoom) {
                    $img->setZoom();
                }
                $img->setHexColor($bgcolor);
                Image::writeCache($uid, $img->get());
            } else {
                $img = new Image();
                $img->init(16, 16, '000000');
                Image::writeCache($uid, $img->get());
                Log::write('video', 'vignette vidéo ' . $id . ' introuvable | uid : ' . $uid);
            }
        }

        return Image::getHttpCachePath($uid);
    }

    /**
     * retourne le nombre total de vidéos du visiteur loggué
     *
     * @return int
     */
    public static function getMyVideosCount()
    {
        if(empty($_SESSION['membre'])) {
            throw new AdHocUserException('non identifié');
        }

        if(isset($_SESSION['my_counters']['nb_videos'])) {
            return $_SESSION['my_counters']['nb_videos'];
        }

        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(*) "
             . "FROM `" . self::$_db_table_video . "` "
             . "WHERE `id_contact` = " . (int) $_SESSION['membre']->getId();

        $nb_videos = $db->queryWithFetchFirstField($sql);

        $_SESSION['my_counters']['nb_videos'] = $nb_videos;

        return $_SESSION['my_counters']['nb_videos'];
    }

    /**
     * retourne le nombre total de vidéos
     *
     * @return int
     */
    public static function getVideosCount()
    {
        if(isset($_SESSION['global_counters']['nb_videos'])) {
            return $_SESSION['global_counters']['nb_videos'];
        }

        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(*) "
             . "FROM `" . self::$_db_table_video . "`";

        $nb_videos = $db->queryWithFetchFirstField($sql);

        $_SESSION['global_counters']['nb_videos'] = $nb_videos;

        return $_SESSION['global_counters']['nb_videos'];
    }
}
