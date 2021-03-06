<?php declare(strict_types=1);

/**
 * Constantes utiles pour la classe DataBase
 */

define('DB_MYSQL_CONNECT_RETRIES', 2);
define('DB_DUMMY_SEPARATOR', "\O"); /* à garder entre double quotes. */

ini_set('mysql.connect_timeout', '2');

/**
 * Gestion de la base MySQL
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class DataBase
{
    /**
     * @var array
     */
    protected static $_connections_params = [
        0 => [
            'hasMaintenance' => false,
            'db_host'        => _DB_HOST_,
            'db_login'       => _DB_USER_,
            'db_pass'        => _DB_PASSWORD_,
            'db_database'    => _DB_DATABASE_,
        ],
    ];

    /**
     * Conteneur de l'instance courante
     */
    protected static $_instance = null;

    /**
     * Tableau des connexions ouvertes
     */
    protected $_current_conn = [];

    /**
     * Type de fetch
     */
    protected $_fetchMode = MYSQLI_ASSOC;

    /**
     * Charset à utiliser pour la connexion
     */
    protected $_charset = 'utf8mb4';

    /**
     * @param int $conn_name identifiant de connexion
     *
     * @throws Exception
     */
    protected function connect($conn_name = 0)
    {
        if (true === self::$_connections_params[$conn_name]['hasMaintenance']) {
            throw new Exception('Serveur MySQL en maintenance');
        }

        $conn_key = self::generateConnectionKey($conn_name);

        if (isset($this->_current_conn[$conn_key])) {
            return $this->_current_conn[$conn_key];
        }

        $params = [];

        array_unshift($params, self::$_connections_params[$conn_name]['db_pass']);
        array_unshift($params, self::$_connections_params[$conn_name]['db_login']);
        array_unshift($params, self::$_connections_params[$conn_name]['db_host']);

        $retries = DB_MYSQL_CONNECT_RETRIES;
        while (empty($this->_current_conn[$conn_key]) && $retries > 0) {
            $retries--;
            $this->_current_conn[$conn_key] = @call_user_func_array('mysqli_connect', $params);
        }

        if (!$this->_current_conn[$conn_key]) {
            throw new Exception('Erreur connexion serveur MySQL');
        }

        $select_db = @mysqli_select_db(
            $this->_current_conn[$conn_key],
            self::$_connections_params[$conn_name]['db_database']
        );

        if (!$select_db) {
            throw new Exception('Erreur connexion base MySQL');
        }

        return $this->_current_conn[$conn_key];
    }

    /**
     * @param int $conn_name identifiant de connexion
     */
    function close(int $conn_name = 0)
    {
        $conn_key = self::generateConnectionKey($conn_name);

        if (isset($this->_current_conn[$conn_key])) {
            @mysqli_close($this->_current_conn[$conn_key]);
            unset($this->_current_conn[$conn_key]);
        }
        return true;
    }

    /**
     *
     */
    function closeAllConnections()
    {
        $connection_keys = array_keys($this->_current_conn);
        foreach ($connection_keys as $conn_key) {
            @mysqli_close($this->_current_conn[$conn_key]);
            unset($this->_current_conn[$conn_key]);
        }
        return true;
    }

    /**
     * Génère la clé qui servira à retrouver le lien vers le serveur qu'on veut
     * dans le tableau de connections. Il est nécessaire d'inclure l'utilisateur
     * et le password pour être cohérent avec les infos dont php se sert pour la
     * re-utilisation d'un lien existant lors d'un mysqli_connect.
     *
     * @param int $conn_name identifiant de connexion
     *
     * @return string
     */
    protected static function generateConnectionKey(int $conn_name): string
    {
        $conn_key = self::$_connections_params[$conn_name]['db_host'] .
                    DB_DUMMY_SEPARATOR .
                    self::$_connections_params[$conn_name]['db_login'] .
                    DB_DUMMY_SEPARATOR .
                    self::$_connections_params[$conn_name]['db_pass'];
        return md5($conn_key);
    }

    /**
     * @param int $conn_name identifiant de connexion
     */
    static function isServerInMaintenance(int $conn_name = 0)
    {
        return self::$_connections_params[$conn_name]['hasMaintenance'];
    }

    /**
     * Constructeur de la classe
     */
    function __construct()
    {
        $this->connect();
        self::$_instance = $this;
    }

    /**
     * Renvoie une instance de l'objet, en re-utilisant une
     * existante si possible. Attention: appeler le constructeur soit même
     * sans passer par cette fonction écrasera toute instance stockée
     *
     * @return object
     */
    static function getInstance(): object
    {
        if (is_null(self::$_instance)) {
            return new DataBase();
        }
        return self::$_instance;
    }

    /**
     * Détruit une instance d'un objet. Attention: appeller unset()
     * soit meme sur une instance obtenue avec new ou la methode
     * getInstance n'est pas suffisant, car ca ne fait que detruire
     * la reference. Il faut appeller cette methode *et* faire
     * un unset sur chacune des references.
     * Ce n'est necessaire que si vous voulez faire le menage avant
     * la fin du script, bien sur.
     *
     * @return bool
     */
    static function deleteInstance(): bool
    {
        if (!is_null(self::$_instance)) {
            self::$_instance = null;
            self::$_connections_params = [];
            return true;
        }
        return false;
    }

    /**
     * Modifie le fetchMode uniquement pour la prochaine requête
     *
     * @param int $fetchMode fetchMode
     */
    function setFetchMode(int $fetchMode = MYSQLI_BOTH)
    {
        if (in_array($fetchMode, [MYSQLI_BOTH, MYSQLI_ASSOC, MYSQLI_NUM])) {
            $this->_fetchMode = $fetchMode;
        }
    }

    /**
     * @param string $sql       requête SQL
     * @param int    $conn_name identifiant de connexion
     *
     * @return array
     * @throws Exception
     */
    function queryWithFetchAndClose(string $sql, int $conn_name = 0)
    {
        try {
            $res = $this->queryWithFetch($sql, $conn_name);
        } catch (Exception $e) {
            $error = $e;
        }

        $this->close($conn_name);
        if (isset($error)) {
            throw $error;
        }
        return $res;
    }

    /**
     * @param string $sql       requête SQL
     * @param int    $conn_name identifiant de connexion
     *
     * @return array
     */
    function queryWithFetchFirstRow(string $sql, int $conn_name = 0)
    {
        $res = false;
        $rc = $this->query($sql, $conn_name);
        if (true === $rc) {
            /* La requête s'est bien passée, ce n'était pas une requête du type
             * SELECT, SHOW, DESCRIBE ou EXPLAIN */
            $res = true;
        } elseif (true == $rc) {
            /* La requête s'est bien passée, c'était une requête du type
             * SELECT, SHOW, DESCRIBE ou EXPLAIN */
            $res = mysqli_fetch_array($rc, $this->_fetchMode);
            $this->_fetchMode = MYSQLI_ASSOC;
        }
        return $res;
    }

    /**
     * @param string $sql       requête SQL
     * @param int    $conn_name identifiant de connexion
     *
     * @return array
     */
    function queryWithFetchFirstField(string $sql, int $conn_name = 0)
    {
        $res = false;
        $rc = $this->query($sql, $conn_name);
        if (true === $rc) {
            /* La requête s'est bien passée, ce n'était pas une requete du type
             * SELECT, SHOW, DESCRIBE ou EXPLAIN */
            $res = true;
        } elseif (true == $rc) {
            /* La requête s'est bien passée, c'était une requete du type
             * SELECT, SHOW, DESCRIBE ou EXPLAIN */
            $res = mysqli_fetch_array($rc, MYSQLI_NUM); // MYSQLI_NUM : ici on ne peut pas respecter $this->_fetchMode
            $this->_fetchMode = MYSQLI_ASSOC;
            if (is_array($res)) {
                $res = $res[0];
            }
        }
        return $res;
    }

    /**
     * Retourne dans un tableau à une dimension le premier champ
     * des lignes retournées
     *
     * @param string $sql       requête SQL
     * @param int    $conn_name identifiant de connexion
     *
     * @return array
     */
    function queryWithFetchFirstFields(string $sql, int $conn_name = 0)
    {
        $res = false;
        $rc = $this->query($sql, $conn_name);
        if (true === $rc) {
            /* La requête s'est bien passée, ce n'était pas une requete du type
             * SELECT, SHOW, DESCRIBE ou EXPLAIN */
            $res = true;
        } elseif (true == $rc) {
            /* La requête s'est bien passée, c'était une requete du type
             * SELECT, SHOW, DESCRIBE ou EXPLAIN */
            $res = [];
            while ($row = mysqli_fetch_array($rc, MYSQLI_NUM)) {
                if (is_array($row)) {
                    array_push($res, $row[0]);
                }
            }
        }
        return $res;
    }

    /**
     * @param string $sql       sql
     * @param int    $conn_name identifiant de connexion
     *
     * @return array
     */
    function queryWithFetch(string $sql, int $conn_name = 0)
    {
        $rc = $this->query($sql, $conn_name);
        if (true === $rc) {
            /* La requête s'est bien passée, ce n'était pas une requete du type
             * SELECT, SHOW, DESCRIBE ou EXPLAIN */
            $res = true;
        } elseif (true == $rc) {
            /* La requête s'est bien passée, c'était une requete du type
             * SELECT, SHOW, DESCRIBE ou EXPLAIN */
            $res = [];
            while (($row = mysqli_fetch_array($rc, $this->_fetchMode)) !== null) {
                $res[] = $row;
            }
            $this->_fetchMode = MYSQLI_ASSOC;
        }
        return $res;
    }

    /**
     * @param string $sql       requête SQL
     * @param int    $conn_name identifiant de connexion
     *
     * @return array
     * @throws Exception
     */
    function query(string $sql, int $conn_name = 0)
    {
        $conn = $this->connect($conn_name);

        if (LOG_SQL) {
            file_put_contents(ini_get('error_log'), date('Y-m-d H:i:s') . ' SQL: ' . $sql . "\n", FILE_APPEND);
        }

        $rc = mysqli_query($conn, $sql);

        if (false === $rc) {
            throw new Exception(mysqli_error($conn));
        }
        return $rc;
    }

    /**
     * OK
     */
    function freeResult($result)
    {
        return mysqli_free_result($result);
    }

    /**
     *
     */
    function numRows($result)
    {
        return mysqli_num_rows($result);
    }

    /**
     *
     */
    function fetchRow($result)
    {
        return mysqli_fetch_row($result);
    }

    /**
     *
     */
    function fetchFirstField($result)
    {
        $res = mysqli_fetch_array($result, MYSQLI_NUM);
        if (is_array($res)) {
            return $res[0];
        }
        return false;
    }

    /**
     *
     */
    function fetchObject($result)
    {
        return mysqli_fetch_object($result);
    }

    /**
     * Execute mysqli_fetch_assoc sur un resultset, ne touche pas à la valeur de
     * {@see self::$fetchMode}.
     *
     * @param resource $result
     *
     * @return array|bool
     */
    function fetchAssoc($result)
    {
        return mysqli_fetch_assoc($result);
    }

    /**
     * Fabrique une requete INSERT.
     *
     * $dbAndTable devrait être entre `...` sinon ça pourrait faire des trucs étranges.
     * $fieldsAndValues est un tableau ('fieldname' => $value), $value peut être
     * un tableau pour certaines fonction spéciales (NOW(), ...).
     *
     * @param string $dbAndTableName  dbAndTableName
     * @param array  $fieldsAndValues fieldsAndValues
     * @param int    $conn_name       identifiant de connexion
     *
     * @return string
     * @throws Exception
     */
    function getInsertQuery(string $dbAndTableName, array $fieldsAndValues, int $conn_name = 0)
    {
        $dbAndTableName = trim((string) $dbAndTableName);
        if (empty($dbAndTableName)) {
            throw new Exception('Bad $dbAndTableName in '.__FUNCTION__);
        }
        if ('`' !== $dbAndTableName[0]) {
            $dbAndTableName = '`'.$dbAndTableName.'`';
        }

        $fields = '';
        $values = '';
        foreach ($fieldsAndValues as $field => $value) {
            $fields .= ', `'.(string) $field.'`';
            if ((is_array($value)) && (!empty($value['special']))) {
                $values .= ', '.$value['special'];
            } else {
                $values .= ", '".$this->escape((string) $value, $conn_name)."'";
            }
        }
        if ('' === $values) {
            throw new Exception('No values to insert');
        } else {
            /* On écrase la virgule en trop au début. */
            $fields[0] = ' ';
            $values[0] = ' ';
        }
        return ('INSERT INTO '.$dbAndTableName.' ('.$fields.') VALUES ('.$values.')');
    }

    /**
     * @param int $conn_name identifiant de connexion
     *
     * @return int
     * @throws Exception
     */
    function affectedRows(int $conn_name = 0)
    {
        if (true === self::$_connections_params[$conn_name]['hasMaintenance']) {
            throw new Exception('Serveur MySQL en maintenance');
        }

        $conn_key = self::generateConnectionKey($conn_name);

        if (isset($this->_current_conn[$conn_key])) {
            return mysqli_affected_rows($this->_current_conn[$conn_key]);
        }
        return -1;
    }

    /**
     * @param int $conn_name identifiant de connexion
     *
     * @return int
     * @throws Exception
     */
    function insertId(int $conn_name = 0): int
    {
        if (true === self::$_connections_params[$conn_name]['hasMaintenance']) {
            throw new Exception('Serveur MySQL en maintenance');
        }

        $conn_key = self::generateConnectionKey($conn_name);
        if (isset($this->_current_conn[$conn_key])) {
            return mysqli_insert_id($this->_current_conn[$conn_key]);
        }
        return -1;
    }

    /**
     * Échappe proprement les chaines
     *
     * @param string $string    string
     * @param int    $conn_name identifiant de connexion
     *
     * @return string
     * @throws Exception
     */
    function escape(string $string, int $conn_name = 0)
    {
        if (true === self::$_connections_params[$conn_name]['hasMaintenance']) {
            throw new Exception('Serveur MySQL en maintenance');
        }

        $conn_key = self::generateConnectionKey($conn_name);

        if (isset($this->_current_conn[$conn_key])) {
            return mysqli_real_escape_string($this->_current_conn[$conn_key], (string) $string);
        } else {
            // throw Exception plutot
            mail(DEBUG_EMAIL, 'debug', 'NO LINK ???' . print_r($_SERVER, true));
        }

        return mysqli_escape_string($this->_current_conn[$conn_key], $string);
    }

    /**
     * Retourne le n° de l'erreur sql
     *
     * @param int $conn_name identifiant de connexion
     */
    function errno(int $conn_name)
    {
        $conn_key = self::generateConnectionKey($conn_name);
        return mysqli_errno($this->_current_conn[$conn_key]);
    }
}
