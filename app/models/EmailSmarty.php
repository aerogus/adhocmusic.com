<?php declare(strict_types=1);

/**
 *
 */
class EmailSmarty extends Smarty
{
    /**
     *
     */
    function __construct()
    {
        parent::__construct();

        $this->setTemplateDir(SMARTY_TEMPLATE_PATH . '/emails');
        $this->setCompileDir(SMARTY_TEMPLATE_C_PATH);
        $this->setCacheDir(SMARTY_TEMPLATE_C_PATH);

        $this->registerPlugin('modifier', 'link', ['EmailSmarty', 'modifier_link']);
        $this->registerPlugin('function', 'image', ['EmailSmarty', 'function_image']);
    }

    /**
     *
     */
    static function modifier_link($url)
    {
        // oui je sais pour les global ...
        // @see Controller::email::newsletter
        global $newsletter_id_newsletter;
        global $newsletter_id_contact;
        $orig = $newsletter_id_newsletter . '|' . $newsletter_id_contact;
        //return $url; // en attendant que ça remarche
        return 'https://www.adhocmusic.com/r/' . Tools::base64_url_encode($url) . '||' . Tools::base64_url_encode($orig);
    }

    /**
     * Récupère l'url d'une image cachée (la cache si nécessaire)
     *
     * @param array ['type'] ['id'] ['width'] ['height'] ['bgcolor'] ['border'] ['zoom']
     */
    static function function_image($params)
    {
        $type    = (string) $params['type'];
        $id      = (int) $params['id'];
        $width   = (int) $params['width'];
        $height  = (int) $params['height'];
        $bgcolor = (string) $params['bgcolor'];
        $border  = (int) $params['border'];
        $zoom    = (int) $params['zoom'];

        $uid = $type . '/' . $id . '/' . $width . '/' . $height . '/' . $bgcolor . '/' . $border . '/' . $zoom . '.jpg';

        switch ($type)
        {
            case 'photo':  $source = ADHOC_ROOT_PATH . '/media/photo/' . $id . '.jpg'; break;
            case 'event':  $source = ADHOC_ROOT_PATH . '/media/event/' . $id . '.jpg'; break;
            case 'video':  $source = ADHOC_ROOT_PATH . '/media/video/' . $id . '.jpg'; break;
            default:       $source = ''; break;
        }

        $cache_local = Image::getCachePath($uid);
        $cache_url = Image::getCacheUrl($uid);

        if (file_exists($cache_local)) {
            return $cache_url;
        }

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
            return $cache_url;
        }

        return '---';
    }
}
