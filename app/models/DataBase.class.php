<?php

/**
 * @package adhoc
 */

/**
 * constantes utiles pour la classe DataBase
 */

// base par défaut
if(!defined('DB_ADHOC_DEFAULT')) {
    define('DB_ADHOC_DEFAULT', 1);
}

define('DB_MYSQL_CONNECT_RETRIES', 2);
define('DB_DUMMY_SEPARATOR', "\O"); /* à garder entre double quotes. */

ini_set('mysql.connect_timeout', 2);

/**
 * classe de gestion de la base MySQL
 *
 * @author Guillaume Seznec <guillaume.seznec@gmail.com>
 * @package adhoc
 */
class DataBase
{
    /**
     *
     */
    protected static $_connections_params = array(
           DB_ADHOC_DEFAULT => array(
            'hasMaintenance' => false,
            'db_host'        => _DB_HOST_,
            'db_login'       => _DB_USER_,
            'db_pass'        => _DB_PASSWORD_,
            'db_database'    => _DB_DATABASE_,
           ),
    );

    /**
     * conteneur de l'instance courante
     */
    protected static $_instance = null;

    /**
     * tableau des connexions ouvertes
     */
    protected $_current_conn = array();

    /**
     * compteur du nb de requete par instance de l'objet
     */
    protected $_nbreq = 0;

    /**
     * compteur du nb total de temps utilisé par instance de l'objet
     *
     * @var int
     */
    protected $_nbtps = 0;

    /**
     * @var array
     */
    protected $_debug_log = array();

    /**
     * type de fetch
     */
    protected $_fetchMode = MYSQLI_ASSOC;

    /**
     * charser à utiliser pour la connexion
     */
    protected $_charset = 'UTF8';

    /**
     *
     */
    protected function connect($conn_name = DB_ADHOC_DEFAULT)
    {
        if (true === self::$_connections_params[$conn_name]['hasMaintenance']) {
            throw new Exception('Serveur MySQL en maintenance');
        }

        $conn_key = self::generateConnectionKey($conn_name);

        if (isset($this->_current_conn[$conn_key])) {
            return $this->_current_conn[$conn_key];
        }

        $params = array();

        array_unshift($params, self::$_connections_params[$conn_name]['db_pass']);
        array_unshift($params, self::$_connections_params[$conn_name]['db_login']);
        array_unshift($params, self::$_connections_params[$conn_name]['db_host']);

        $retries = DB_MYSQL_CONNECT_RETRIES;
        while(empty($this->_current_conn[$conn_key]) && $retries > 0) {
            $retries--;
            $this->_current_conn[$conn_key] = @call_user_func_array('mysqli_connect', $params);
        }

        if (!$this->_current_conn[$conn_key]) {
            throw new Exception($this->_current_conn[$conn_key], 'Erreur connexion serveur MySQL');
        }

        $select_db = @mysqli_select_db(
            $this->_current_conn[$conn_key],
            self::$_connections_params[$conn_name]['db_database']
        );

        if (!$select_db) {
            throw new Exception($this->_current_conn[$conn_key], 'Erreur connexion base MySQL');
        }

        // on précise l'encodage à utiliser pour la connexion
        //$this->query("SET NAMES " . $this->_charset);
        //$this->query("SET CHARACTER SET " . $this->_charset);

        return $this->_current_conn[$conn_key];
    }

    /**
     *
     */
    function close($conn_name = DB_ADHOC_DEFAULT)
    {
        $conn_key = self::generateConnectionKey($conn_name);

        if (isset($this->_current_conn[$conn_key]))
        {
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
        foreach ($connection_keys as $conn_key)
        {
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
     */
    protected static function generateConnectionKey($conn_name)
    {
        $conn_key = self::$_connections_params[$conn_name]['db_host'] .
                    DB_DUMMY_SEPARATOR .
                    self::$_connections_params[$conn_name]['db_login'] .
                    DB_DUMMY_SEPARATOR .
                    self::$_connections_params[$conn_name]['db_pass'];
        return md5($conn_key);
    }

    /**
     *
     */
    static function isServerInMaintenance($conn_name = DB_ADHOC_DEFAULT)
    {
        return self::$_connections_params[$conn_name]['hasMaintenance'];
    }

    /**
     * constructeur de la classe
     */
    function __construct()
    {
        $this->connect();
        self::$_instance = $this;
    }

    /**
     *
     */
    function __destruct()
    {
    }

    /**
     * Renvoie une instance de l'objet, en re-utilisant une
     * existante si possible. Attention: appeller le constructeur soit meme
     * sans passer par cette fonction ecrasera toute instance stockee
     */
    static function getInstance()
    {
        if(is_null(self::$_instance)) {
            return new DataBase();
        }
        return self::$_instance;
    }

    /**
     * Detruit une instance d'un objet. Attention: appeller unset()
     * soit meme sur une instance obtenue avec new ou la methode
     * getInstance n'est pas suffisant, car ca ne fait que detruire
     * la reference. Il faut appeller cette methode *et* faire
     * un unset sur chacune des references.
     * Ce n'est necessaire que si vous voulez faire le menage avant
     * la fin du script, bien sur.
     */
    static function deleteInstance()
    {
        if(!is_null(self::$_instance))
        {
            self::$_instance = null;
            self::$_connections_params = array();
            return true;
        }
        return false;
    }

    /**
     * Modifie le fetchMode uniquement pour la prochaine requête
     */
    function setFetchMode($fetchMode = MYSQLI_BOTH)
    {
        if (in_array($fetchMode, array(MYSQLI_BOTH, MYSQLI_ASSOC, MYSQLI_NUM))) {
            $this->_fetchMode = $fetchMode;
        }
    }

    /**
     *
     */
    function queryWithFetchAndClose($sql, $conn_name = DB_ADHOC_DEFAULT)
    {
        try
        {
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
     *
     */
    function queryWithFetchFirstRow($sql, $conn_name = DB_ADHOC_DEFAULT)
    {
        $res = false;
        $rc = $this->query($sql, $conn_name);
        if (true === $rc)
        {
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
     *
     */
    function queryWithFetchFirstField($sql, $conn_name = DB_ADHOC_DEFAULT)
    {
        $res = false;
        $rc = $this->query($sql, $conn_name);
        if (true === $rc)
        {
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
     * retourne dans un tableau à une dimension le premier champ
     * des lignes retournées
     *
     * @return array
     */
    function queryWithFetchFirstFields($sql, $conn_name = DB_ADHOC_DEFAULT)
    {
        $res = false;
        $rc = $this->query($sql, $conn_name);
        if (true === $rc)
        {
            /* La requête s'est bien passée, ce n'était pas une requete du type
             * SELECT, SHOW, DESCRIBE ou EXPLAIN */
            $res = true;
        } elseif (true == $rc) {
            /* La requête s'est bien passée, c'était une requete du type
             * SELECT, SHOW, DESCRIBE ou EXPLAIN */
            $res = array();
            while($row = mysqli_fetch_array($rc, MYSQLI_NUM))
            {
                if(is_array($row)) {
                    array_push($res, $row[0]);
                }
            }
        }
        return $res;
    }

    /**
     *
     */
    function queryWithFetch($sql, $conn_name = DB_ADHOC_DEFAULT)
    {
        $rc = $this->query($sql, $conn_name);
        if (true === $rc)
        {
            /* La requête s'est bien passée, ce n'était pas une requete du type
             * SELECT, SHOW, DESCRIBE ou EXPLAIN */
            $res = true;
        } elseif (true == $rc) {
            /* La requête s'est bien passée, c'était une requete du type
             * SELECT, SHOW, DESCRIBE ou EXPLAIN */
             $res = array();
             while (($row = mysqli_fetch_array($rc, $this->_fetchMode)) !== NULL)
             {
                $res[] = $row;
             }
            $this->_fetchMode = MYSQLI_ASSOC;
        }
        return $res;
    }

    /**
     *
     */
    function query($sql, $conn_name = DB_ADHOC_DEFAULT, $closeConnectionOnError = true)
    {
        $conn = $this->connect($conn_name);

        $rc = @mysqli_query($conn, $sql);
        $this->_nbreq++;

        /* début debug log */

        $traces = debug_backtrace();
        $backtrace = '';
        if(is_array($traces))
        {
            foreach($traces as $key => $trace)
            {
                if(array_key_exists('class', $trace)) {
                    $backtrace .= $trace['class'];
                }
                if(array_key_exists('type', $trace)) {
                    $backtrace .= $trace['type'];
                }
                $backtrace .= $trace['function'].'() l.? <-- ';
            }
        }
        $backtrace .= '\O/';

        /* fin debug log */

        if (false === $rc)
        {
            //$error = new Exception($conn);
            //$error->setQuery($sql);
            if ($closeConnectionOnError) {
                $this->close($conn_name);
            }
            throw new Exception($sql);
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
     */
    function getInsertQuery($dbAndTableName, $fieldsAndValues, $conn_name = DB_ADHOC_DEFAULT)
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
        foreach($fieldsAndValues as $field => $value)
        {
            $fields .= ', `'.(string) $field.'`';
            if ((is_array($value)) && (!empty($value['special'])))
            {
                $values .= ', '.$value['special'];
            } else {
                $values .= ", '".$this->escape((string) $value, $conn_name)."'";
            }
        }
        if ('' == $values)
        {
            throw new Exception('No values to insert');
        } else {
            /* On écrase la virgule en trop au début. */
            $fields[0] = ' ';
            $values[0] = ' ';
        }
        return ('INSERT INTO '.$dbAndTableName.' ('.$fields.') VALUES ('.$values.')');
    }

    /**
     *
     */
    function affectedRows($conn_name = DB_ADHOC_DEFAULT)
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
     *
     */
    function insertId($conn_name = DB_ADHOC_DEFAULT)
    {
        if (true === self::$_connections_params[$conn_name]['hasMaintenance']) {
            throw new Exception('Serveur MySQL en maintenance');
        }

        $conn_key = self::generateConnectionKey($conn_name);
        if(isset($this->_current_conn[$conn_key])) {
            return mysqli_insert_id($this->_current_conn[$conn_key]);
        }
        return -1;
    }

    /**
     * échappe proprement les chaines
     */
    function escape($string, $conn_name = DB_ADHOC_DEFAULT)
    {
        if(true === self::$_connections_params[$conn_name]['hasMaintenance']) {
            throw new Exception('Serveur MySQL en maintenance');
        }

        $conn_key = self::generateConnectionKey($conn_name);

        if(isset($this->_current_conn[$conn_key])) {
            return mysqli_real_escape_string($this->_current_conn[$conn_key], $string);
        } else {
            // throw Exception plutot
            mail('gus@adhocmusic.com', 'debug', 'NO LINK ???' . print_r($_SERVER, true));
        }

        // deprecated !
        //return mysqli_escape_string($string);

        // moche !
        return addslashes($string);
    }

    /**
     * retourne le n° de l'erreur sql
     */
    function errno($conn_name)
    {
        $conn_key = self::generateConnectionKey($conn_name);
        return mysqli_errno($this->_current_conn[$conn_key]);
    }

    /**
     * retourne un log des requêtes exécutées dans l'instance courante
     *
     * @return array
     */
    function getDebugLog()
    {
        return $this->_debug_log;
    }
}
