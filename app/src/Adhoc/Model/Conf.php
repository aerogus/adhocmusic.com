<?php

declare(strict_types=1);

namespace Adhoc\Model;

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
    protected static $instance = null;

    /**
     * @var array<mixed>
     */
    protected static array $data = [];

    /**
     * @var array<string,string>
     */
    protected static array $required = [
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
    public static function getInstance(): object
    {
        if (is_null(self::$instance)) {
            return new Conf();
        }
        return self::$instance;
    }

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $confPath = self::getConfPath();
        if (!file_exists($confPath)) {
            throw new \Exception('configuration introuvable');
        }
        if (!(self::$data = parse_ini_file($confPath, true, INI_SCANNER_TYPED))) {
            throw new \Exception('configuration illisible');
        }
        foreach (self::$required as $section => $fields) {
            if (!array_key_exists($section, self::$data)) {
                throw new \Exception('section [' . $section . '] manquante');
            }
            foreach ($fields as $field) {
                if (!array_key_exists($field, self::$data[$section])) {
                    throw new \Exception('champ ' . $field . ' manquant dans section [' . $section . ']');
                }
            }
        }
        self::$instance = $this;
    }

    /**
     * Retourne le chemin du fichier de configuration
     *
     * @return string
     */
    public static function getConfPath(): string
    {
        return __DIR__ . '/../../../../conf/conf.ini';
    }

    /**
     * Retourne l'ensemble des sections ou une section seulement
     *
     * @param string $section nom de la section
     *
     * @return array|null
     */
    public function get(string $section = null): ?array
    {
        if (is_null($section)) {
            return self::$data; // toute la conf
        }
        if (array_key_exists($section, self::$data)) {
            return self::$data[$section]; // la conf d'une section uniquement
        }
        throw new \Exception('section [' . $section . '] introuvable');
    }
}
