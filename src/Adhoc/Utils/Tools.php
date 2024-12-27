<?php

declare(strict_types=1);

namespace Adhoc\Utils;

/**
 * Méthodes pratiques communes à tout le site AD'HOC
 *
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Tools
{
    /**
     * @param string $string string
     *
     * @see http://w3.org/International/questions/qa-forms-utf-8.html
     *
     * @return bool
     */
    public static function isUTF8(string $string): bool
    {
        return (bool) preg_match(
            '%^(?:
            [\x09\x0A\x0D\x20-\x7E]
            | [\xC2-\xDF][\x80-\xBF]
            | \xE0[\xA0-\xBF][\x80-\xBF]
            | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}
            | \xED[\x80-\x9F][\x80-\xBF]
            | \xF0[\x90-\xBF][\x80-\xBF]{2}
            | [\xF1-\xF3][\x80-\xBF]{3}
            | \xF4[\x80-\x8F][\x80-\xBF]{2}
            )*$%xs',
            $string
        );
    }

    /**
     * Conversion de l'encodage de caractères
     *
     * @param string $str  chaine input
     * @param string $mode codage de sortie ISO|UTF8
     *
     * @return string
     *
     * @todo prendre un array en entrée/sortie
     */
    public static function charSet(string $str, string $mode = 'UTF8'): string
    {
        switch ($mode) {
            case 'ISO':
                if (self::isUTF8($str)) {
                    $str = utf8_decode($str);
                }
                break;

            case 'UTF8':
                if (!self::isUTF8($str)) {
                    $str = utf8_encode($str);
                }
                break;
        }

        return $str;
    }

    /**
     * Retire les accents
     * /!\ ne fonctionne pas en utf8 donc bidouille
     *
     * @param string $str chaîne
     *
     * @return string
     */
    public static function removeAccents(string $str): string
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
     * @param string $string chaîne
     *
     * @return string
     */
    public static function replaceWordEntities(string $string): string
    {
        return str_replace(
            ["\r", '&#8216;', '&#8217;', '&#8230;'],
            [''  , "'"      , "'"      , '...'    ],
            $string
        );
    }

    /**
     * Tronque une chaine et ajoute ...
     *
     * @param string $str       chaîne
     * @param int    $maxLength longueur maxi
     *
     * @return string
     */
    public static function tronc(string $str, int $maxLength): string
    {
        $str = trim($str);
        if ((mb_strlen($str) > $maxLength) && ($maxLength > 1)) {
            return mb_substr($str, 0, $maxLength - 4, 'UTF-8') . '…';
        }
        return $str;
    }

    /**
     * Set en session un jeton à usage unique
     *
     * @return string
     */
    public static function getCSRFToken(): string
    {
        $_SESSION['CSRFToken'] = substr(md5((string) time()), 0, 16);
        return $_SESSION['CSRFToken'];
    }

    /**
     * @param string $CSRFToken CSRFToken
     *
     * @return bool
     */
    public static function checkCSRFToken(string $CSRFToken): bool
    {
        return (isset($_SESSION['CSRFToken']) && ($_SESSION['CSRFToken'] === $CSRFToken));
    }

    /**
     * Retourne si un formulaire a été envoyé
     *
     * @param string $formName formName
     * @param string $method   method
     *
     * @return bool
     */
    public static function isSubmit(string $formName, string $method = 'POST'): bool
    {
        if ($method === 'POST') {
            return isset($_POST[$formName . '-submit']);
        } elseif ($method === 'GET') {
            return isset($_GET[$formName . '-submit']);
        } else {
            return (bool) Route::params($formName . '-submit');
        }
    }

    /**
     * @param string $input input
     *
     * @return string
     */
    public static function base64UrlEncode(string $input): string
    {
        return strtr(base64_encode($input), '+/=', '-_,');
    }

    /**
     * @param string $input input
     *
     * @return string
     */
    public static function base64UrlDecode(string $input): string
    {
        return base64_decode(strtr($input, '-_,', '+/='), true);
    }

    /**
     * Redirection HTTP
     *
     * @param string $url      url
     * @param bool   $forceSsl forceSsl
     *
     * @return void
     */
    public static function redirect(string $url, bool $forceSsl = false)
    {
        if ((strpos($url, 'http://') === false) && (strpos($url, 'https://') === false)) {
            $url = HOME_URL . $url;
        }

        if ($forceSsl) {
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
     * Retourne si un internaute est identifié
     *
     * @return bool
     */
    public static function isAuth(): bool
    {
        if (!isset($_SESSION['membre'])) {
            return false;
        }
        if ((int) $_SESSION['membre']->getId() > 0) {
            return true;
        }
        return false;
    }

    /**
     * Vérifie que l'internaute :
     * - est loggué
     * - a bien les droits d'accès à la page
     *
     * @param int $type type
     *
     * @return true
     */
    public static function auth(int $type): true
    {
        // non identifié
        if (!isset($_SESSION['membre'])) {
            $_SESSION['redirect_after_auth'] = $_SERVER['REQUEST_URI'];
            Tools::redirect('/auth/auth', true);
            exit();
        }

        // vérification des droits
        // "&" pour la comparaison binaire
        if (($_SESSION['membre']->getLevel() & $type) === 0) {
            // identifié mais pas assez de droits
            $_SESSION['redirect_after_auth'] = $_SERVER['REQUEST_URI'];
            Tools::redirect('/auth/auth');
            exit();
        }

        // identifié, droits ok
        return true;
    }

    /**
     * Initialisation d'une session PHP native
     *
     * @return void
     */
    public static function sessionInit()
    {
        ini_set('session.gc_maxlifetime', '7200'); // 2 heures

        session_name('ADHOCMUSIC');
        session_start();

        if (isset($_SERVER['REMOTE_ADDR'])) {
            $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
        }
    }

    /**
     * Html -> txt
     *
     * @param string $str chaîne
     *
     * @return string
     */
    public static function htmlToText(string $str): string
    {
        $str = strip_tags($str);
        $str = wordwrap($str, 80, "\n");
        $str = preg_replace('/(\n){3,}/', "\n", $str);
        return $str;
    }

    /**
     * Tri de tableau
     *
     * @param array<mixed> $array array
     * @param mixed        $on    ?
     * @param int          $order order
     *
     * @return array<mixed>
     */
    public static function arraySort(array $array, mixed $on, int $order = SORT_ASC): array
    {
        $new_array = [];
        $sortable_array = [];

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 === $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
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
     * Initialisateur de la graine
     *
     * @return int
     */
    public static function makeSeed(): int
    {
        list($usec, $sec) = explode(' ', microtime());
        $number = (int) $sec * 1000000 + ((int) $usec * 1000000);
        return $number;
    }

    /**
     * Génération d'un mot de passe de n caractères
     *
     * @param int $length longueur
     *
     * @return string
     */
    public static function generatePassword(int $length = 16): string
    {
        $lettres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        mt_srand(self::makeSeed());
        $password = '';
        $max = mb_strlen($lettres) - 1;
        for ($cpt = 0; $cpt < $length; $cpt++) {
            $password .= $lettres[rand(0, $max)];
        }
        return $password;
    }

    /**
     * Retourne l'"alias" d'un nom de groupe ou d'un titre d'article à partir de son nom réel
     * (= filtre les caratères non url-compliant)
     *
     * @param string $name name
     *
     * @return string
     */
    public static function genAlias(string $name): string
    {
        $alias = trim($name);
        $alias = mb_strtolower($alias);
        $alias = Tools::removeAccents($alias);

        return str_replace(
            ['/', '+', '|', '.', ' ', "'", '"',  '&', '(', ')', '!', '°'],
            [ '',  '',  '',  '',  '',  '',  '', 'et',  '',  '',  '',  ''],
            $alias
        );
    }
}
