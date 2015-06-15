<?php

class EmailSmarty extends Smarty
{
    function __construct()
    {
        parent::__construct();

        $this->setTemplateDir(SMARTY_TEMPLATE_PATH . '/emails');
        $this->setCompileDir(SMARTY_TEMPLATE_C_PATH);
        $this->setCacheDir(SMARTY_TEMPLATE_C_PATH);

        $this->registerPlugin('modifier', 'link', array('EmailSmarty', 'modifier_link'));
        $this->registerPlugin('function', 'image', array('EmailSmarty', 'function_image'));
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
        return 'http://www.adhocmusic.com/r/' . Tools::base64_url_encode($url) . '||' . Tools::base64_url_encode($orig);
    }

    /**
     * récupère l'url d'une image cachée (la cache si nécessaire)
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

        switch($type)
        {
            case 'photo':  $source = ADHOC_ROOT_PATH . '/static/media/photo/' . $id . '.jpg'; break;
            case 'event':  $source = ADHOC_ROOT_PATH . '/static/media/event/' . $id . '.jpg'; break;
            case 'video':  $source = ADHOC_ROOT_PATH . '/static/media/video/' . $id . '.jpg'; break;
            default:       $source = ''; break;
        }

        $cache_local = Image::getLocalCachePath($uid);
        $cache_url = Image::getHttpCachePath($uid);

        if(file_exists($cache_local)) {
            return $cache_url;
        }

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
            return $cache_url;
        }

        return '---';
    }
}
