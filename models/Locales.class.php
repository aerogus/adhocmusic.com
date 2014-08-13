<?php

/**
* test traductions / utilisation de gettext
* il faut que les locales soient installées sur la machine
*
* pour compiler :
* msgfmt -o domaine.mo domaine.po
* attention, msggmt n'est pas accessible des serveurs mutu ovh
*
* domaine.po est le fichier texte source
* domaine.mo est le fichier compilé
*
* arbo :
* locales/fr_FR.UTF8/LC_MESSAGES/domaine.po
* locales/fr_FR.UTF8/LC_MESSAGES/domaine.mo
* locales/en_US.UTF8/LC_MESSAGES/domaine.po
* locales/en_US.UTF8/LC_MESSAGES/domaine.mo
*/
class Locales
{
    protected static $_user_country;
    protected static $_user_region;
    protected static $_user_city;

    /**
     * retourne les langues disponibles avec leur locale associée
     */
    public static function getAvailableLocales()
    {
        return array(
            'de' => 'de_DE',
            'en' => 'en_US',
            'es' => 'es_ES',
            'fi' => 'fi_FI',
               'fr' => 'fr_FR.UTF8',
            'it' => 'it_IT',
        );
    }

    /**
     * domaines au sens gettext du terme
     */
    public static function getAvailableDomains()
    {
        return array(
            'adhoc',
            /*'mobile',*/
        );
    }

    public static function init()
    {
        setlocale(LC_ALL, self::getId());
        putenv("LANG=" . self::getId());
        putenv("LANGUAGE=" . self::getId());
        setlocale(LC_MESSAGES, self::getId());
        bindtextdomain(self::getDomain(), self::getPath());
        textdomain(self::getDomain());
        bind_textdomain_codeset(self::getDomain(), self::getCharset());
        ini_set('date.timezone', self::getTimeZone());
        ini_set("default_charset", self::getCharset());
    }

    public static function getTimeZone()
    {
        return 'Europe/Paris';
    }

    public static function getCharset()
    {
        return 'UTF-8';
    }

    public static function getId()
    {
        return 'fr_FR.UTF8'; // à variabiliser
    }

    public static function getDomain()
    {
        return 'adhoc'; // = nom des .mo/.po
    }

    public static function getPath()
    {
        return SERVER_ROOT_PATH . '/locales';
    }

    /**
     * retourne les langages supportés par le navigateur
     *
     * @return unknown|string
     */
    public static function getAcceptCharset()
    {
        if(array_key_exists('HTTP_ACCEPT_CHARSET', $_SERVER)) {
            return $_SERVER['HTTP_ACCEPT_CHARSET'];
        }
        return 'fr-fr';
    }

    /**
     * Tente de détecter la langue préférée de l'utilisateur via HTTP_ACCEPT_LANGUAGE
     * Utilise l'arbre de priorité q=...
     * Sinon renvoie false
     * 
     * ex:  Accept-Language: fr,fr-fr;q=0.8,en-us;q=0.5,en;q=0.3
     */
    public static function detectLocaleByHttpAcceptLanguage()
    {
        if (empty($_SERVER['HTTP_ACCEPT_LANGUAGE']))
            return false;

        $http_lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        $http_langs = explode(',', $http_lang);

        $langs = array();

        // On établit la liste des langues par priorité
        $qr = 100;
        foreach ($http_langs as $lng)
        {
            if (preg_match('!;q=(.*)!', $lng, $pat))
            {
                $q = intval($pat[1] * 100);
                $lang = str_replace($pat[0], '', $lng);
            }
            else
            {
                $q = $qr--;
                $lang = $lng;
            }
            $lang = trim($lang);
            $langs[$q] = $lang;
        }

        krsort($langs);

        $available_locales = self::getAvailableLocales();

        // On teste si on a chaque langue, par priorité décroissante
        foreach($langs as $priority => $lang)
        {
            // Peut-être que la locale donnée par le navigateur est bonne, du type xx_XX
            if (isset($lang[4]))
            {
                $lang = substr($lang, 0, 2).'_'.strtoupper(substr($lang, 3, 2));
                if (array_key_exists($lang, $available_locales))
                    return $available_locales[$lang];
            }

            // Sinon il donne peut être juste xx
            $lang = substr($lang, 0, 2);
            if (array_key_exists($lang, $available_locales))
                return $available_locales[$lang];
        }

        return false;
    }

    /**
     * retourne le pays de l'utilisateur
     */
    public static function getUserCountry()
    {
        if(!self::$_user_country)
        {
            if (!function_exists('apache_note'))
            {
                throw new Exception('install mod_geoip');
            }
            self::$_user_country = apache_note('GEOIP_COUNTRY_CODE');
        }

        return self::$_user_country;
    }

    public static function getUserRegion()
    {
        if(!self::$_user_region)
        {
            if (!function_exists('apache_note'))
            {
                throw new Exception('install mod_geoip');
            }
            self::$_user_region = apache_note('GEOIP_REGION');
        }
        return self::$_user_region;
    }

    public static function getUserCity()
    {
        if(!self::$_user_city)
        {
            if (!function_exists('apache_note'))
            {
                throw new Exception('install mod_geoip');
            }
            self::$_user_city = apache_note('GEOIP_CITY');
        }
        return self::$_user_city;
    }

    /**
     * retourne la langue de l'utilisateur
     */
    public static function getLanguage()
    {
        return 'fr';
    }

    /**
     *
     */
    public static function getLanguageByCountry($id_country)
    {
        $c = array('FR' => 'fr');
        return $c[$id_country];
    }

    /**
     * compile les .po en .mo
     */
    public static function compile()
    {
        $path    = self::getPath();
        $langs   = self::getAvailableLanguages();
        $domains = self::getAvailableDomains();

        foreach($langs as $lang)
        {
            foreach($domains as $domain)
            {
                $cmd = 'msgfmt -o '
                     . $path . '/' . $lang . '/LC_MESSAGES/' . $domain . '.mo'
                     . $path . '/' . $lang . '/LC_MESSAGES/' . $domain . '.po';
                //exec($cmd);
            }
        }
    }

    /* extraction des chaines à traduire (faire un hook post commit) */

    public static function extractStringsFromTemplates()
    {
        return false;
    }
    
    public static function extractStringsFromSources()
    {
        return false;
    }

    public static function extractStringsFromDb()
    {
        return false;
    }
}