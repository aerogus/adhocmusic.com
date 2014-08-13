<?php

define('DYNIMG_CACHE_PATH', ADHOC_ROOT_PATH . '/cache/img');
define('DYNIMG_CACHE_ENABLED', true);

class Controller
{
    public static function mailing_banner()
    {
        return self::trackable_image(ADHOC_ROOT_PATH . '/static/img/bandeau-mailing.jpg');
    }

    public static function logo_adhoc()
    {
        return self::trackable_image(ADHOC_ROOT_PATH . '/static/img/logo_adhoc.jpg');
    }

    public static function trackable_image($image)
    {
        $hash = (string) Route::params('hash');
        list($id_newsletter, $id_contact) = explode('-', $hash);

        $ip = false;
        if(isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $host = gethostbyaddr($ip);
        if(isset($_SERVER['HTTP_USER_AGENT'])) {
            $useragent = $_SERVER['HTTP_USER_AGENT'];
        }

        try {

            $contact = Contact::getInstance((int) $id_contact);
            $contact->setLastnlNow();
            $contact->save();

            $db = DataBase::getInstance();

            $sql = "INSERT INTO `adhoc_statsnl` "
                 . "(`id_newsletter`, `id_contact`, `date`, `ip`, `host`, `useragent`) "
                 . "VALUES(" . (int) $id_newsletter . ", " . (int) $id_contact .", NOW(), '" . $db->escape($ip) . "', '" . $db->escape($host) . "', '" . $db->escape($useragent) . "')";
            $res = $db->query($sql);

        } catch(Exception $e) {
            // rien
        }

        header("Content-type: image/jpeg");
        $im = imagecreatefromjpeg($image);
        imagejpeg($im);
        die();
    }

    public static function photo()
    {
        $id = (int) Route::params('id');
        $width = (int) Route::params('width');
        $height = (int) Route::params('height');
        $bgcolor = (string) Route::params('bgcolor');
        $border = (bool) Route::params('border');
        $zoom = (bool) Route::params('zoom');

        $uid = 'photo/'.$id.'/'.$width.'/'.$height.'/'.$bgcolor.'/'.$border.'/'.$zoom.'.'.self::_getOutputFormat();

        if(!empty($_GET['d'])) {
            die(Image::getHttpCachePath($uid));
        }

        $cache = Image::getLocalCachePath($uid);
        if(file_exists($cache) && DYNIMG_CACHE_ENABLED) {
            return file_get_contents($cache);
        }

        $source = ADHOC_ROOT_PATH . '/static/media/photo/' . $id . '.jpg';

        if(file_exists($source)) {
            $img = new Image($source);
            $img->setType(self::_getOutputFormat());
            $img->setMaxWidth($width);
            $img->setMaxHeight($height);
            $img->setBorder($border);
            $img->setKeepRatio(true);
            if($zoom) {
                $img->setZoom();
            }
            $img->setHexColor($bgcolor);
            $content = $img->get();
            Image::writeCache($uid, $content);
            return $content;
        } else {
            return self::_fallback();
        }
    }

    public static function video()
    {
        $id = (int) Route::params('id');
        $width = (int) Route::params('width');
        $height = (int) Route::params('height');
        $bgcolor = (string) Route::params('bgcolor');
        $border = (bool) Route::params('border');
        $zoom = (bool) Route::params('zoom');

        $uid = 'video/'.$id.'/'.$width.'/'.$height.'/'.$bgcolor.'/'.$border.'/'.$zoom.'.'.self::_getOutputFormat();

        if(!empty($_GET['d'])) {
            die(Image::getHttpCachePath($uid));
        }

        $cache = Image::getLocalCachePath($uid);
        if(file_exists($cache) && DYNIMG_CACHE_ENABLED) {
            return file_get_contents($cache);
        }

        $source = ADHOC_ROOT_PATH . '/static/media/video/' . $id . '.jpg';

        if(file_exists($source)) {
            $img = new Image($source);
            $img->setType(self::_getOutputFormat());
            $img->setMaxWidth($width);
            $img->setMaxHeight($height);
            $img->setBorder($border);
            $img->setKeepRatio(true);
            $img->setHexColor($bgcolor);
            if($zoom) {
                $img->setZoom();
            }
            $content = $img->get();
            Image::writeCache($uid, $content);
            return $content;
        } else {
            return self::_fallback();
        }
    }

    public static function event()
    {
        $id = (int) Route::params('id');
        $width = (int) Route::params('width');
        $height = (int) Route::params('height');
        $bgcolor = (string) Route::params('bgcolor');
        $border = (bool) Route::params('border');
        $zoom = (bool) Route::params('zoom');

        $uid = 'event/'.$id.'/'.$width.'/'.$height.'/'.$bgcolor.'/'.$border.'/'.$zoom.'.'.self::_getOutputFormat();

        if(!empty($_GET['d'])) {
            die(Image::getHttpCachePath($uid));
        }

        $cache = Image::getLocalCachePath($uid);
        if(file_exists($cache) && DYNIMG_CACHE_ENABLED) {
            return file_get_contents($cache);
        }

        $source = ADHOC_ROOT_PATH . '/static/media/event/' . $id . '.jpg';

        if(file_exists($source)) {
            $img = new Image($source);
            $img->setType(self::_getOutputFormat());
            $img->setMaxWidth($width);
            $img->setMaxHeight($height);
            $img->setBorder($border);
            $img->setKeepRatio(true);
            $img->setHexColor($bgcolor);
            if($zoom) {
                $img->setZoom();
            }
            $content = $img->get();
            Image::writeCache($uid, $content);
            return $content;
        } else {
           return self::_fallback();
        }
    }

    /**
     * Générateur de png 1x1 pixel
     * avec une couleur donnée (r,g,b)
     * avec une transparence donnée (a)
     *
     * @param 'r' '00' -> 'ff' (0 a 255)
     * @param 'g' '00' -> 'ff' (0 a 255)
     * @param 'b' '00' -> 'ff' (0 a 255)
     * @param 'a' '00' -> '7f' (0 a 127)
     *
     * ex : /dynimg/pixel/ffffff30
     *                    r g b a
     */
    public static function pixel()
    {
        $tmp = '/tmp/adhocmusic-img-' . md5(time() . rand());

        $color = (string) Route::params('color');

        $r = substr($color, 0, 2);
        $g = substr($color, 2, 2);
        $b = substr($color, 4, 2);
        $a = substr($color, 6, 2);

        $img = imagecreatetruecolor(1, 1);
        imagealphablending($img, false);
        imagesavealpha($img, true);
        $color = imagecolorallocatealpha($img, hexdec($r), hexdec($g), hexdec($b), hexdec($a));
        imagefill($img, 0, 0, $color);
        imagepng($img, $tmp);
        imagedestroy($img);

        $bin = file_get_contents($tmp);
        unlink($tmp);
        return $bin;
    }

    public static function featured()
    {
        $id = (int) Route::params('id');
        $width = (int) Route::params('width');
        $height = (int) Route::params('height');
        $bgcolor = (string) Route::params('bgcolor');
        $border = (bool) Route::params('border');
        $zoom = (bool) Route::params('zoom');

        $uid = 'featured/'.$id.'/'.$width.'/'.$height.'/'.$bgcolor.'/'.$border.'/'.$zoom.'.'.self::_getOutputFormat();

        if(!empty($_GET['d'])) {
            die(Image::getHttpCachePath($uid));
        }

        $cache = Image::getLocalCachePath($uid);
        if(file_exists($cache) && DYNIMG_CACHE_ENABLED) {
            return file_get_contents($cache);
        }

        $source = ADHOC_ROOT_PATH . '/static/media/featured/' . $id . '.jpg';

        if(file_exists($source)) {
            $img = new Image($source);
            $img->setType(self::_getOutputFormat());
            $img->setMaxWidth($width);
            $img->setMaxHeight($height);
            $img->setBorder($border);
            $img->setKeepRatio(true);
            $img->setHexColor($bgcolor);
            if($zoom) {
                $img->setZoom();
            }
            $content = $img->get();
            Image::writeCache($uid, $content);
            return $content;
        } else {
           return self::_fallback();
        }
    }

    public static function tool()
    {
        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Cache Image");

        $type    = (string) Route::params('type');
        $id      = (int)    Route::params('id');
        $width   = (int)    Route::params('width');
        $height  = (int)    Route::params('height');
        $bgcolor = (string) Route::params('bgcolor');
        $border  = (bool)   Route::params('border');
        $zoom    = (bool)   Route::params('zoom');
        
        if(!$width) $width = 80;
        if(!$height) $height = 80;
        if(!$bgcolor) $bgcolor = '000000';

        switch($type)
        {
            case 'photo':
                $url = Photo::getPhotoUrl($id, $width, $height, $bgcolor, $border, $zoom);
                break;
            case 'video':
                $url = Video::getVideoThumbUrl($id, $width, $height, $bgcolor, $border, $zoom);
                break;
            case 'event':
                $url = Event::getFlyerUrl($id, $width, $height, $bgcolor, $border, $zoom);
                break;
            default:
                $url = '';
                break;
        }
        $smarty->assign('type', $type);
        $smarty->assign('id', $id);
        $smarty->assign('width', $width);
        $smarty->assign('height', $height);
        $smarty->assign('bgcolor', $bgcolor);
        $smarty->assign('border', $border);
        $smarty->assign('zoom', $zoom);
        $smarty->assign('url', $url);
        return $smarty->fetch('dynimg/tool.tpl');
    }

    protected static function _fallback()
    {
        $img = new Image();
        $img->init(2, 2, 'ffffff');
        $img->setType(self::_getOutputFormat());
        return $img->get();
    }

    private static function _getOutputFormat()
    {
        $format = Route::$response_format;
        switch($format)
        {
            case 'jpeg':
            case 'jpg':
            default:
                return IMAGETYPE_JPEG;
                break;

            case 'png':
                return IMAGETYPE_PNG;
                break;

            case 'gif':
                return IMAGETYPE_GIF;
                break;
        }
    }
}
