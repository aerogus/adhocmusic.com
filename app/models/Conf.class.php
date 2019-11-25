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
     *
     */
    function __construct()
    {
        $confPath = self::getConfPath();
        if (!file_exists($confPath)) {
            throw new Exception('configuration introuvable');
        } elseif (!(self::$_data = parse_ini_file($confPath, true, INI_SCANNER_TYPED))) {
            throw new Exception('configuration illisible');
        }
        foreach (self::$_required as $section => $fields) {
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
        return dirname(__DIR__) . '/conf.ini';
    }

    /**
     * @param string $section nom de la section
     *
     * @return array|null
     */
    static function get(string $section = null): ?array
    {
        if (is_null($section)) {
            // toute la conf
            return self::$_data;
        } elseif (array_key_exists($section, self::$_data)) {
            // la conf d'une section uniquement
            return self::$_data[$section];
        } else {
            throw new Exception('section [' . $section . '] introuvable');
        }
    }
}