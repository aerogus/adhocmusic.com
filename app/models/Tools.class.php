<?php

/**
 * @package adhoc
 */

/**
 * classe de méthodes pratiques communes à tout le site AD'HOC
 *
 * @package adhoc
 * @author Guillaume Seznec <guillaume.seznec@gmail.com>
 */
class Tools
{
    /**
     * @see http://w3.org/International/questions/qa-forms-utf-8.html
     */
    static function isUTF8($string)
    {
        return preg_match('%^(?:
                [\x09\x0A\x0D\x20-\x7E]
                | [\xC2-\xDF][\x80-\xBF]
                | \xE0[\xA0-\xBF][\x80-\xBF]
                | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}
                | \xED[\x80-\x9F][\x80-\xBF]
                | \xF0[\x90-\xBF][\x80-\xBF]{2}
                | [\xF1-\xF3][\x80-\xBF]{3}
                | \xF4[\x80-\x8F][\x80-\xBF]{2}
        )*$%xs', $string);
    }

    /**
     * conversion de l'encodage de caractères
     * @todo prendre un array en entrée/sortie
     * @param string chaine input
     * @param string codage de sortie ISO|UTF8
     * @return string
     */
    static function charSet($str, $mode = 'UTF8')
    {
        switch($mode)
        {
            case 'ISO':
                if(self::isUTF8($str)) {
                    $str = utf8_decode($str);
                }
                break;

            case 'UTF8':
                if(!self::isUTF8($str)) {
                    $str = utf8_encode($str);
                }
                break;
        }

        return $str;
    }

    /**
     * retire les accents
     * /!\ ne fonctionne pas en utf8 donc bidouille
     * @param string
     * @return string
     */
    static function removeAccents($str)
    {
        $str = self::charSet($str, 'ISO');
        $str = strtr(
            $str,
            utf8_decode("ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ"),
            utf8_decode("aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn")
        );
        $str = self::charSet($str, 'UTF8');
        return $str;
    }

    /**
     * Verification d'une url
     *
     * Retourne FALSE si l'url n'est pas conforme. (HTTP(S) uniquement!)
     * @return bool
     */
    static function isUrlValid($url)
    {
        if (preg_match('`^(http(s?)://){1}((\w+\.)+)\w{2,}(:\d+)?(/'.
            '[\w\-\'"~#:.?!+=&%@/(\)\xA0-\xFF]'. /* <-- lache tes caractères !!!!! */
            '*)?$`iD', $url))
        {
            return true;
        }
        return false;
    }

    /**
     *
     */
    static function stripBBCode($string)
    {
        return preg_replace('!\\[((\\w+(=[^\\]]+)?)|(/\\w+))\\]!', '', $string);
    }

    /**
     *
     */
    static function replaceWordEntities($string)
    {
        return str_replace(array("\r",'&#8216;','&#8217;','&#8230;'), array('',"'","'",'...'), $string);
    }

    /**
     *
     */
    static function getContentType($extension)
    {
        $mt['jpg']  = 'image/jpeg';
        $mt['jpeg'] = 'image/jpeg';
        $mt['gif']  = 'image/gif';
        $mt['png']  = 'image/png';
        $mt['wbmp'] = 'image/vnd.wap.wbmp';
        if (isset($mt[$extension])) {
            return $mt[$extension];
        }
        return false;
    }

    /**
     * Transforme une couleur de la forme "rgb(55,55,55)" ou #FA4 en #FFAA44
     * @param string $rgbval
     * @return string
     */
    static function rgb2hex($rgbval)
    {
        if (preg_match_all('/rgb\((\d+),\s*(\d+),\s*(\d+)\)/', $rgbval, $matches)){
            list($red, $green, $blue) = array($matches[1][0], $matches[2][0], $matches[3][0]);
            return sprintf('#%02X%02X%02X', $red, $green, $blue);
        } elseif (preg_match_all('/^#([0-9a-f])([0-9a-f])([0-9a-f])$/', $rgbval, $matches)) {
            list($red, $green, $blue) = array($matches[1][0], $matches[2][0], $matches[3][0]);
            return '#'.$red.$red.$green.$green.$blue.$blue;
        }
        return $rgbval;
    }

    /**
     * tronque une chaine et ajoute ...
     *
     * @param string $string
     * @param int $length
     * @return string
     */
    static function tronc($chaine, $maxlength)
    {
        $chaine = trim($chaine);
        if((mb_strlen($chaine) > $maxlength) && ($maxlength > 4)) {
            return mb_substr($chaine, 0, $maxlength - 4, 'UTF-8')." ...";
        }
        return $chaine;
    }

    /**
     * nettoie une chaine de caractères
     * utilisé sur les titres, texte blog, description, commentaires ...
     * @param string $texte
     * @return string
     */
    static function filtreTexte($texte)
    {
        $texte = self::replaceWordEntities($texte);
        $texte = preg_replace('/&#\d+;/', '', html_entity_decode(strip_tags($texte, '<br>'))); // vire les tags html, sauf br
        $texte = str_replace('<br />', '<br /> ', $texte); // important: laisser l'espace après le <br /> pour les eventuels decoupages du texte
        $texte = preg_replace('`(.)(\1{3,})`s', '$1', $texte); // supprimer les redondances de plus de 3 caractères
        $texte = preg_replace('/(<br\/> ){3,}/', '<br />', $texte); // on limite les sauts de lignes répétés <br />
        $texte = preg_replace("/(\n){2,}/", "\n", $texte); // on limite les sauts de lignes répétés \n
        return $texte;
    }

    /**
     * retourne la révision SVN courante
     */
    static function getHeadRevision()
    {
        if (!file_exists($file = $_SERVER['DOCUMENT_ROOT'].'/.svn/entries')) {
            return date('Ymd');
        }
        $svn = file($file);
        return isset($svn[3]) ? (int) $svn[3] : date('Ymd');
    }

    /**
     * @return string
     */
    static function getCSRFToken()
    {
        $_SESSION['CSRFToken'] = substr(md5(time()), 0, 16);
        return $_SESSION['CSRFToken'];
    }

    /**
     * @param string
     * @return bool
     */
    static function checkCSRFToken($CSRFToken)
    {
        if (isset($_SESSION['CSRFToken']) && mb_strlen($_SESSION['CSRFToken']) && $_SESSION['CSRFToken'] === $CSRFToken)
        {
            return true;
        }
        return false;
    }

    /**
     * retourne si un formulaire a été envoyé
     *
     * @param string $formName
     * @return bool
     */
    static function isSubmit($formName, $method = 'POST')
    {
        if($method == 'POST') {
            return (bool) !empty($_POST[$formName . '-submit']);
        } elseif($method == 'GET') {
            return (bool) !empty($_GET[$formName . '-submit']);
        } else {
            return (bool) Route::params($formName . '-submit');
        }
    }

    /**
     * @param string
     * @return string
     */
    static function base64_url_encode($input)
    {
        return strtr(base64_encode($input), '+/=', '-_,');
    }

    /**
     * @param string
     * @return string
     */
    static function base64_url_decode($input)
    {
        return base64_decode(strtr($input, '-_,', '+/='));
    }

    /**
     * redirection HTTP
     *
     * @param string url
     * @param bool $force_ssl
     */
    static function redirect($url, $force_ssl = false)
    {
        if((strpos($url, 'http://') === false) && (strpos($url, 'https://') === false)) {
            $url = HOME_URL . $url;
        }

        if($force_ssl) {
            $url = str_replace('http:', 'https:', $url);
        }

        if (!headers_sent()) {
            header('Status: 301');
            header('Location: ' . $url);
            header('Connection: close');
            exit();
        }

        echo '<script>' . "\n" .
             '// <![CDATA[' . "\n" .
             'window.location.href = "' . addslashes($url) . '";' . "\n" .
             '// ]]>' . "\n" .
             '</script>' . "\n";
        exit();
    }

    /**
     * retourne si un internaute est identifié
     *
     * @return bool
     */
    static function isAuth()
    {
        if(empty($_SESSION['membre'])) {
            return false;
        }
        if((int) $_SESSION['membre']->getId() > 0) {
            return true;
        }
        return false;
    }

    /**
     * Vérifie que l'internaute :
     * - est loggué
     * - a bien les droits d'accès à la page
     *
     * @param int $type
     * @return void
     */
    static function auth($type)
    {
        // non identifié
        if(empty($_SESSION['membre'])) {
            $_SESSION['redirect_after_auth'] = $_SERVER['REQUEST_URI'];
            Tools::redirect('/auth/login', true);
            exit();
        }

        // vérification des droits
        if($_SESSION['membre']->getLevel() & $type) {
            return true;
        }

        // identifié mais pas assez de droits
        $_SESSION['redirect_after_auth'] = $_SERVER['REQUEST_URI'];
        Tools::redirect('/auth/login');
        exit();
    }

    /**
     * Vérifie que l'internaute :
     * - est loggué
     * - appartient bien au groupe en paramètre
     *
     * @param int $id_groupe
     * @return void
     */
    static function authGroupe($id_groupe)
    {
        // non identifié
        if(empty($_SESSION['membre'])) {
            $_SESSION['redirect_after_auth'] = $_SERVER['REQUEST_URI'];
            Tools::redirect('/auth/login');
            exit();
        }

        // droits sur le groupe ?

        $db = DataBase::getInstance();

        $sql = "SELECT `id_contact` "
             . "FROM `adhoc_appartient_a` "
             . "WHERE `id_contact` = " . (int) $_SESSION['membre']->getId() . " "
             . "AND `id_groupe` = " . (int) $id_groupe;

        if($id_contact = $db->queryWithFetchFirstField($sql)) {
            return true;
        }

        // pas les droits
        $_SESSION['redirect_after_auth'] = $_SERVER['REQUEST_URI'];
        Tools::redirect('/auth/login');
        exit();
    }

    /**
     * initialisation d'une session PHP native
     */
    static function sessionInit()
    {
        session_name('ADHOCMUSIC');
        session_start();

        $_SESSION['lastaccess'] = date('Y-m-d H:i:s');
        if(!empty($_SESSION['hits'])) {
            $_SESSION['hits']++;
        } else {
            $_SESSION['hits'] = 1;
        }
        if(!empty($_SERVER['REQUEST_METHOD'])) {
            $_SESSION['httpmethod'] = $_SERVER['REQUEST_METHOD'];
        }
        if(!empty($_SERVER['HTTP_HOST']) && !empty($_SERVER['REQUEST_URI'])) {
            $_SESSION['url'] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        }
        if(!empty($_SERVER['HTTP_USER_AGENT'])) {
            $_SESSION['ua'] = $_SERVER['HTTP_USER_AGENT'];
        }
        if(!empty($_SERVER['REMOTE_ADDR'])) {
            $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
        }
        if(!empty($_SESSION['ip']) && empty($_SESSION['host'])) {
            //$_SESSION['host'] = gethostbyaddr($_SESSION['ip']);
            $_SESSION['host'] = $_SERVER['REMOTE_ADDR'];
        }
        $_SESSION['geoloc'] = '';
        $_SESSION['lat'] = '';
        $_SESSION['lng'] = '';
        if(!empty($_SERVER['GEOIP_COUNTRY_CODE'])) {
            $_SESSION['geoloc'] .= $_SERVER['GEOIP_COUNTRY_CODE'];
        }
        $_SESSION['geoloc'] .= '|';
        if(!empty($_SERVER['GEOIP_REGION'])) {
            $_SESSION['geoloc'] .= $_SERVER['GEOIP_REGION'];
        }
        $_SESSION['geoloc'] .= '|';
        if(!empty($_SERVER['GEOIP_CITY'])) {
            $_SESSION['geoloc'] .= $_SERVER['GEOIP_CITY'];
        }
        $_SESSION['geoloc'] .= '|';
        if(!empty($_SERVER['GEOIP_LATITUDE'])) {
            $_SESSION['geoloc'] .= $_SERVER['GEOIP_LATITUDE'];
            $_SESSION['lat'] = $_SERVER['GEOIP_LATITUDE'];
        }
        $_SESSION['geoloc'] .= '|';
        if(!empty($_SERVER['GEOIP_LONGITUDE'])) {
            $_SESSION['geoloc'] .= $_SERVER['GEOIP_LONGITUDE'];
            $_SESSION['lng'] = $_SERVER['GEOIP_LONGITUDE'];
        }
    }

    /**
     * @param string $str
     * @return string
     */
    static function htmlToText($str)
    {
        $str = strip_tags($str);
        $str = wordwrap($str, 80, "\n");
        $str = preg_replace('/(\n){3,}/', "\n", $str);
        return $str;
    }

    static function array_sort($array, $on, $order=SORT_ASC)
    {
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0)
        {
            foreach ($array as $k => $v)
            {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order)
            {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }

        return $new_array;
    }

    /**
     * @param string
     * @return string
     * @see http://www.commentcamarche.net/contents/courrier-electronique/mime.php3
     */
    static function getTypeMimeByExtension($ext)
    {
        $mimes = array(
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif'  => 'image/gif',
            'png'  => 'image/png',
            'wbmp' => 'image/vnd.wap.wbmp',
            'txt'  => 'text/plain',
            'zip'  => 'multipart/x-zip',
            'pdf'  => 'application/pdf',
        );

        if(array_key_exists($ext, $mimes)) {
            return $mimes[$ext];
        }
        return false;
    }

    /**
     * @param string
     * @return string
     */
    static function getIconByExtension($ext)
    {
        $icons_url = '/img/icones/';
        $default_icon = 'file.png';

        // à finir
        $icons = array(
            'jpg'  => 'image.png',
            'jpeg' => 'image.png',
            'gif'  => 'image.png',
            'png'  => 'image.png',
            'wbmp' => 'image.png',
            'txt'  => 'text.png',
            'zip'  => 'archive.png',
            'pdf'  => 'pdf.png',
        );

        if(array_key_exists($ext, $icons)) {
            return $icons_url . $icons[$ext];
        }
        return $icons_url . $default_icon;
    }
}
