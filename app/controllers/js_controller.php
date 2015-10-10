<?php

class Controller
{
    static function adhoc()
    {
        $smarty = new AdHocSmarty();
        return self::_minify_js($smarty->fetch('js/index.tpl'));
    }

    /**
     * compression simpliste de javascripts
     *
     * @param string
     * @return string
     */
    protected static function _minify_js($js)
    {
        return trim($js);
    }
}