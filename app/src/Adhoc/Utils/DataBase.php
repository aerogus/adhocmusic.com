<?php

declare(strict_types=1);

namespace Adhoc\Utils;

/**
 * Classe d'accès à la base de données
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class DataBase
{
    /**
     * Conteneur de l'instance courante
     *
     * @var ?self
     */
    protected static ?self $instance = null;

    /**
     * Objet PDO
     *
     * @var ?\PDO
     */
    public ?\PDO $pdo = null;

    /**
     * Nom de la bdd
     *
     * @var ?string
     */
    public ?string $name = null;

    /**
     * Constructeur de la classe
     */
    public function __construct()
    {
        $this->open();

        self::$instance = $this;
    }

    /**
     * Renvoie une instance de l'objet, en re-utilisant une
     * existante si possible. Attention: appeler le constructeur soit même
     * sans passer par cette fonction écrasera toute instance stockée
     *
     * @return object
     */
    public static function getInstance(): object
    {
        if (is_null(self::$instance)) {
            return new DataBase();
        }
        return self::$instance;
    }

    /**
     * Ouvre explicitement la connexion PDO
     *
     * @return bool
     */
    public function open(): bool
    {
        if (is_a($this->pdo, 'PDO')) {
            return false;
        }

        $dsn = sprintf('mysql:host=%s;port=%d;dbname=%s', $_ENV['DB_HOST'], $_ENV['DB_PORT'], $_ENV['DB_NAME']);
        $this->pdo = new \PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS']);
        $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        $this->name = $_ENV['DB_NAME'];

        // optionnel si déjà indiqué dans le my.cnf
        $this->pdo->query('SET NAMES utf8mb4');

        return true;
    }

    /**
     * Ferme explicitement la connexion PDO
     *
     * @return bool
     */
    public function close(): bool
    {
        if (is_a($this->pdo, 'PDO')) {
            $this->pdo = null;
            $this->name = null;
            return true;
        }

        return false;
    }

    /**
     * Initialisation de la base de données MariaDB si elle n'existe pas
     * (structure + données initiales)
     *
     * @return bool
     */
    public static function init(): bool
    {
        $db = self::getInstance();

        $sql_scripts = [];
        // on suppose que la base et le user existent déjà
        $sql_scripts[] = dirname(__DIR__) . '/db/01-schema.sql';
        if ($_ENV['ENV'] === 'dev') {
            $sql_scripts[] = dirname(__DIR__) . '/db/02-ref-dev.sql';
        } elseif ($_ENV['ENV'] === 'prod') {
            $sql_scripts[] = dirname(__DIR__) . '/db/02-ref-prod.sql';
        }

        foreach ($sql_scripts as $sql_script) {
            if (is_file($sql_script)) {
                $cmd = 'mysql -u ' . $_ENV['DB_USER'] . ' -p' . $_ENV['DB_PASS'] . ' ' . $_ENV['DB_NAME'] . ' < ' . $sql_script;
                Log::debug($cmd);
                exec($cmd, $output, $return_var);
            }
        }

        return true;
    }

    /**
     * Retourne une chaîne de caractère avec la requête préparée
     * Utilisation juste pour les logs, ne pas injecter directement en base !
     *
     * @param string $sql
     * @param array<string,mixed> $data
     *
     * @return string
     */
    public static function preparedQuery(string $sql, array $data): string
    {
        // on trie les clés par longueur décroissante pour éviter un bug un une clé est un sous-motif d'une autre clé
        $keys = array_map('strlen', array_keys($data));
        array_multisort($keys, SORT_DESC, $data);

        foreach ($data as $key => $val) {
            $sql = str_replace(':' . $key, '"' . $val . '"', $sql);
        }

        return $sql;
    }
}
