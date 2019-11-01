<?php declare(strict_types=1);

define('DYNIMG_CACHE_PATH', ADHOC_ROOT_PATH . '/public/img/cache');
define('DYNIMG_CACHE_ENABLED', true);

final class Controller
{
    /**
     *
     */
    static function mailing_banner()
    {
        return self::trackable_image(ADHOC_ROOT_PATH . '/public/img/bandeau-mailing.jpg');
    }

    /**
     *
     */
    static function logo_adhoc()
    {
        return self::trackable_image(ADHOC_ROOT_PATH . '/public/img/logo_adhoc.jpg');
    }

    /**
     *
     */
    static function trackable_image(string $image) : void
    {
        $hash = (string) Route::params('hash');
        list($id_newsletter, $id_contact) = explode('-', $hash);

        $ip = false;
        if (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $host = gethostbyaddr($ip);
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $useragent = $_SERVER['HTTP_USER_AGENT'];
        }

        try {

            Contact::getInstance((int) $id_contact)
                ->setLastnlNow()
                ->save();

        } catch (Exception $e) {
            // rien
        }

        header("Content-type: image/jpeg");
        $im = imagecreatefromjpeg($image);
        imagejpeg($im);
        die();
    }

    /**
     *
     */
    static function photo(): string
    {
        $id = (int) Route::params('id');
        $width = (int) Route::params('width');
        $height = (int) Route::params('height');
        $bgcolor = (string) Route::params('bgcolor');
        $border = (bool) Route::params('border');
        $zoom = (bool) Route::params('zoom');

        $uid = 'photo/'.$id.'/'.$width.'/'.$height.'/'.$bgcolor.'/'.$border.'/'.$zoom.'.'.self::_getOutputFormat();

        if (!empty($_GET['d'])) {
            die(Image::getHttpCachePath($uid));
        }

        $cache = Image::getLocalCachePath($uid);
        if (file_exists($cache) && DYNIMG_CACHE_ENABLED) {
            return file_get_contents($cache);
        }

        $source = ADHOC_ROOT_PATH . '/media/photo/' . $id . '.jpg';

        if (file_exists($source)) {
            $img = (new Image($source))
                ->setType(self::_getOutputFormat())
                ->setMaxWidth($width)
                ->setMaxHeight($height)
                ->setBorder($border)
                ->setKeepRatio(true)
                ->setZoom($zoom)
                ->setHexColor($bgcolor);
            $content = $img->get();
            Image::writeCache($uid, $content);
            return $content;
        } else {
            return self::_fallback();
        }
    }

    static function video(): string
    {
        $id = (int) Route::params('id');
        $width = (int) Route::params('width');
        $height = (int) Route::params('height');
        $bgcolor = (string) Route::params('bgcolor');
        $border = (bool) Route::params('border');
        $zoom = (bool) Route::params('zoom');

        $uid = 'video/'.$id.'/'.$width.'/'.$height.'/'.$bgcolor.'/'.$border.'/'.$zoom.'.'.self::_getOutputFormat();

        if (!empty($_GET['d'])) {
            die(Image::getHttpCachePath($uid));
        }

        $cache = Image::getLocalCachePath($uid);
        if (file_exists($cache) && DYNIMG_CACHE_ENABLED) {
            return file_get_contents($cache);
        }

        $source = ADHOC_ROOT_PATH . '/media/video/' . $id . '.jpg';

        if (file_exists($source)) {
            $img = (new Image($source))
                ->setType(self::_getOutputFormat())
                ->setMaxWidth($width)
                ->setMaxHeight($height)
                ->setBorder($border)
                ->setKeepRatio(true)
                ->setHexColor($bgcolor)
                ->setZoom($zoom);
            $content = $img->get();
            Image::writeCache($uid, $content);
            return $content;
        } else {
            return self::_fallback();
        }
    }

    static function event(): string
    {
        $id = (int) Route::params('id');
        $width = (int) Route::params('width');
        $height = (int) Route::params('height');
        $bgcolor = (string) Route::params('bgcolor');
        $border = (bool) Route::params('border');
        $zoom = (bool) Route::params('zoom');

        $uid = 'event/'.$id.'/'.$width.'/'.$height.'/'.$bgcolor.'/'.$border.'/'.$zoom.'.'.self::_getOutputFormat();

        if (!empty($_GET['d'])) {
            die(Image::getHttpCachePath($uid));
        }

        $cache = Image::getLocalCachePath($uid);
        if (file_exists($cache) && DYNIMG_CACHE_ENABLED) {
            return file_get_contents($cache);
        }

        $source = ADHOC_ROOT_PATH . '/media/event/' . $id . '.jpg';

        if (file_exists($source)) {
            $img = (new Image($source))
                ->setType(self::_getOutputFormat())
                ->setMaxWidth($width)
                ->setMaxHeight($height)
                ->setBorder($border)
                ->setKeepRatio(true)
                ->setHexColor($bgcolor)
                ->setZoom($zoom);
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
    static function pixel(): string
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

    static function featured(): string
    {
        $id = (int) Route::params('id');
        $width = (int) Route::params('width');
        $height = (int) Route::params('height');
        $bgcolor = (string) Route::params('bgcolor');
        $border = (bool) Route::params('border');
        $zoom = (bool) Route::params('zoom');

        $uid = 'featured/'.$id.'/'.$width.'/'.$height.'/'.$bgcolor.'/'.$border.'/'.$zoom.'.'.self::_getOutputFormat();

        if (!empty($_GET['d'])) {
            die(Image::getHttpCachePath($uid));
        }

        $cache = Image::getLocalCachePath($uid);
        if (file_exists($cache) && DYNIMG_CACHE_ENABLED) {
            return file_get_contents($cache);
        }

        $source = ADHOC_ROOT_PATH . '/media/featured/' . $id . '.jpg';

        if (file_exists($source)) {
            $img = (new Image($source))
                ->setType(self::_getOutputFormat())
                ->setMaxWidth($width)
                ->setMaxHeight($height)
                ->setBorder($border)
                ->setKeepRatio(true)
                ->setHexColor($bgcolor)
                ->setZoom($zoom);
            $content = $img->get();
            Image::writeCache($uid, $content);
            return $content;
        } else {
           return self::_fallback();
        }
    }

    static function tool(): string
    {
        $smarty = new AdHocSmarty();

        Trail::getInstance()
            ->addStep("Privé", "/adm/")
            ->addStep("Cache Image");

        $type    = (string) Route::params('type');
        $id      = (int)    Route::params('id');
        $width   = (int)    Route::params('width');
        $height  = (int)    Route::params('height');
        $bgcolor = (string) Route::params('bgcolor');
        $border  = (bool)   Route::params('border');
        $zoom    = (bool)   Route::params('zoom');
        
        if (!$width) $width = 80;
        if (!$height) $height = 80;
        if (!$bgcolor) $bgcolor = '000000';

        switch ($type)
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

    /**
     * @return string
     */
    private static function _fallback(): string
    {
        $img = (new Image())
            ->init(2, 2, 'ffffff')
            ->setType(self::_getOutputFormat());
        return $img->get();
    }

    /**
     * @return int
     */
    private static function _getOutputFormat(): int
    {
        $format = Route::$response_format;
        switch ($format)
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

