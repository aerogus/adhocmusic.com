<?php declare(strict_types=1);

/**
 * Usages:
 *
 * $conf = Conf::getInstance();
 * echo $conf->get('global')['env'];
 *
 * echo Conf::getInstance()->get('global')['env'];
 */
class Conf
{
    /**
     * Instance de l'objet
     *
     * @var object
     */
    protected static $_instance = null;

    /**
     * @var array
     */
    protected static $_data = [];

    /**
     * @var array
     */
    protected static $_required = [
        'global' => ['env', 'locale', 'charset', 'timezone'],
        'database' => ['host', 'user', 'pass', 'name'],
        'url' => ['home', 'cache', 'media'],
        'debug' => ['show_errors', 'log_errors', 'log_sql', 'log_file', 'email'],
        'contact_form' => ['to', 'log_file'],
        'facebook' => ['page_id', 'page_url'],
        'photo' => ['max_width', 'max_height', 'thumb_width'],
        'video' => ['max_width', 'max_height', 'thumb_width'],
        'event' => ['max_width', 'max_height', 'thumb_width'],
    ];

    /**
     * @return object
     */
    static function getInstance(): object
    {
        if (is_null(self::$_instance)) {
            return new Conf();
        }
        return self::$_instance;
    }

    /**
     * @throws Exception
     */
    function __construct()
    {
        $confPath = self::getConfPath();
        if (!file_exists($confPath)) {
            throw new Exception('configuration introuvable');
        }
        if (!(self::$_data = parse_ini_file($confPath, true, INI_SCANNER_TYPED))) {
            throw new Exception('configuration illisible');
        }
        foreach (self::$_required as $section => $fields) {
            if (!array_key_exists($section, self::$_data)) {
                throw new Exception('section [' . $section . '] manquante');
            }
            foreach ($fields as $field) {
                if (!array_key_exists($field, self::$_data[$section])) {
                    throw new Exception('champ ' . $field . ' manquant dans section [' . $section . ']');
                }
            }
        }
        self::$_instance = $this;
    }

    /**
     * Retourne le chemin du fichier de configuration
     *
     * @return string
     */
    static function getConfPath(): string
    {
        return dirname(dirname(__DIR__)) . '/conf/conf.ini';
    }

    /**
     * Retourne l'ensemble des sections ou une section seulement
     *
     * @param string $section nom de la section
     *
     * @return array|null
     */
    function get(string $section = null): ?array
    {
        if (is_null($section)) {
            return self::$_data; // toute la conf
        }
        if (array_key_exists($section, self::$_data)) {
            return self::$_data[$section]; // la conf d'une section uniquement
        }
        throw new Exception('section [' . $section . '] introuvable');
    }
}
