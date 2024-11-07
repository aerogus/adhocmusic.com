<?php

declare(strict_types=1);

namespace Adhoc\Utils;

/**
 * @abstract
 *
 * @author Guillaume Seznec <guillaume@seznec.frr>
 */
abstract class ObjectModel
{
    /**
     * @var array<mixed>
     */
    protected static array $instances = [];

    /**
     * @var ?int
     */
    protected static ?int $found_rows = null;

    /**
     * Champ clé primaire (simple ou multiple) de l'objet fils
     *
     * @var array<string>
     */
    protected static array $pk = [];

    /**
     * Table de la bdd utilisée par l'objet
     *
     * @var string
     */
    protected static string $table = '';

    /**
     * La table associée est-elle répartie horizontalement ?
     *
     * @var bool
     */
    protected static bool $sharded = false;

    /**
     * Cache de l'existence d'une table
     *
     * @var array<string,bool>
     */
    protected static array $has_table = [];

    /**
     * L'objet peut-il être mis en cache ?
     *
     * @var bool
     */
    protected static bool $cachable = false;

    /**
     * Identifiant unique d'objet
     *
     * @var string
     */
    protected string $object_id = '';

    /**
     * Liste des attributs de l'objet
     *
     * Ce tableau doit être redéfini dans les classes filles
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [];

    /**
     * Tableau des attributs modifiés depuis la dernière sauvegarde.
     *
     * Pour chaque attribut modifié, on a un élément de la forme 'attribut => true'.
     *
     * @var array<string,bool>
     */
    protected array $modified_fields = [];

    /**
     * L'instance a-t-elle été trouvée en base et bien chargé ?
     * ou bien a-t-elle été bien sauvée en base une première fois
     *
     * @var bool
     */
    protected bool $loaded = false;

    /**
     * Retourne le tableau de tous les champs
     *
     * @return array<string,string>
     */
    protected function getAllFields(): array
    {
        return static::$all_fields;
    }

    /**
     * Construction de l'objet
     *
     * La clé primaire $id peut être soit simple (et on donne directement sa valeur),
     * soit multiple et on donne un tableau ['pkName1' => pkValue1, 'pkName2' => pkValue2 ]
     *
     * "final" pour éviter un warning avec le new static()
     *
     * @param mixed $id id
     */
    final public function __construct($id = null)
    {
        if (!is_null($id)) {
            if (!is_array($id)) {
                // si on passe une clé primaire simple, on la met quand même dans un tableau
                if (count(static::getDbPk()) === 1) {
                    $formated_id = [
                        static::getDbPk()[0] => $id,
                    ];
                } else {
                    throw new \Exception('multi pk object and scalar value provided');
                }
            } else {
                $formated_id = $id;
            }
            foreach (static::getDbPk() as $pk) {
                if (static::$all_fields[$pk] === 'string') {
                    $this->$pk = strval($formated_id[$pk]);
                } elseif (static::$all_fields[$pk] === 'int') {
                    $this->$pk = intval($formated_id[$pk]);
                } else {
                    throw new \Exception('unimplemented pk type : ' . static::$all_fields[$pk]);
                }
            }

            $this->setObjectId(static::calcObjectId($this->getId()));

            if (static::isCachable() && ($this->loaded = $this->loadFromCache())) {
                // chargement ok du cache
                //Log::debug('loadFromCache OK');
            } elseif ($this->loaded = $this->loadFromDb()) {
                //Log::debug('loadFromDb OK: ' . $this->getObjectId());
                // chargement ok de la bdd
                if (static::isCachable()) {
                    // alimentation du cache
                    ObjectCacheMC::set($this->getObjectId(), serialize($this->objectToArray()));
                }
            } else {
                // erreur au chargement
            }

            static::$instances[$this->getObjectId()] = $this;
        }
    }

    /**
     * @return static
     */
    public static function init(): static
    {
        return new static();
    }

    /**
     * Retourne le nom de la table associée à cette classe
     *
     * @param string $db_table_suffix
     *
     * @return string
     */
    public static function getDbTable(string $db_table_suffix = ''): string
    {
        $db_table = static::$table;

        if (strlen($db_table_suffix) > 0) {
            $db_table .= '_' . $db_table_suffix;
        }

        return $db_table;
    }

    /**
     * Pour les table shardées, le suffixe, sinon chaîne vide
     *
     * à réimplémenter dans les classes filles des tables shardées
     */
    public function getDbTableSuffix(): string
    {
        if (static::$sharded) {
            // le suffixe doit se baser sur un sous ensemble de la clé primaire
            return ''; // ex: CCC_YYYY
        }

        return '';
    }

    /**
     * Vérifie si la table dynamique existe
     *
     * @param string $db_table_suffix
     *
     * @return bool
     */
    public static function hasTable(string $db_table_suffix = ''): bool
    {
        $db = DataBase::getInstance();
        $table = static::getDbTable($db_table_suffix);

        if (array_key_exists($table, static::$has_table)) {
            return static::$has_table[$table];
        }

        $sql = 'SHOW TABLES WHERE Tables_in_' . $db->name . ' = "' . $table . '"';
        Log::debug($sql);
        $stm = $db->pdo->query($sql);
        $bool = boolval($stm->fetch());
        static::$has_table[$table] = $bool;
        return $bool;
    }

    /**
     * Retourne le nom du/des champ(s) de la clé primaire
     *
     * @return array<string>
     */
    public static function getDbPk(): array
    {
        return static::$pk;
    }

    /**
     * la méthode statique find($params) va setter static::$found_rows
     * si le paramètre $params['found_rows'] === true
     * (ou le remettre à null sinon)
     * Utile pour faire de la pagination
     *
     * @return ?int
     */
    public static function getFoundRows(): ?int
    {
        return static::$found_rows;
    }

    /**
     * @param mixed $id int|string|array<mixed>
     *
     * @return static
     */
    public static function getInstance($id): self
    {
        if (count(static::$instances) === 0) {
            // pas du tout d'instances: on en crée une, le constructeur ira s'enregistrer
            // dans le tableau statique $instances.
            return new static($id);
        } else {
            if (!is_array($id)) {
                if (count(static::getDbPk()) === 1) {
                    $formated_id = [
                        static::getDbPk()[0] => $id,
                    ];
                } else {
                    throw new \Exception('multi pk object and scalar value provided');
                }
            } elseif (($expected = count(static::getDbPk())) !== ($provided = count(array_keys($id)))) {
                throw new \Exception('multi pk not fully provided (provided ' . $provided . ' !== expected ' . $expected . ')');
            } else {
                $formated_id = $id;
            }

            $object_id = static::calcObjectId($formated_id);
            if (!array_key_exists($object_id, static::$instances)) {
                // l'instance n'est pas chargée
                new static($formated_id);
            }

            return static::$instances[$object_id];
        }
    }

    /**
     * @return bool
     */
    public static function isCachable(): bool
    {
        return static::$cachable;
    }

    /**
     * @return string
     */
    public function getObjectId(): string
    {
        return $this->object_id;
    }

    /**
     * @param string $object_id
     *
     * @return static
     */
    protected function setObjectId(string $object_id): static
    {
        $this->object_id = $object_id;

        return $this;
    }

    /**
     * Retourne la valeur de la clé primaire (simple ou multiple) dans un tableau
     * ['pkName1' => pkValue1, 'pkName2' => pkValue2]
     *
     * @return array<string,mixed>
     */
    public function getId(): array
    {
        $pks = [];
        foreach (static::getDbPk() as $pk) {
            $pks[$pk] = $this->$pk;
        }
        return $pks;
    }

    /**
     * Set la valeur de la clé primaire
     * Todo gérer si pk simple ou multiple, le typage, si nom du champ est bien une pk
     *
     * @param mixed $pk clé primaire
     *
     * @return static
     */
    public function setId($pk): static
    {
        if ($this->isLoaded()) {
            throw new \Exception('can not override pk');
        }

        if (!is_array($pk)) {
            $formated_pk = [];
            if (count(static::$pk) === 1) {
                $formated_pk[static::$pk[0]] = $pk;
            } else {
                throw new \Exception('multi pk object and scalar value provided');
            }
        } else {
            $formated_pk = $pk;
        }

        foreach ($formated_pk as $key => $value) {
            $getter = 'get' . StringCase::snakeToUpperCamel($key);
            $setter = 'set' . StringCase::snakeToUpperCamel($key);
            if ($this->$getter() !== $value) {
                $this->$setter($value);
            }
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isLoaded(): bool
    {
        return $this->loaded;
    }

    /**
     * @param array<string,string>|array<string,int>|string|int $pk
     *
     * @return bool
     */
    public static function isFound(array|string|int $pk): bool
    {
        if (!is_array($pk)) {
            $formated_pk = [];
            if (count(static::$pk) === 1) {
                $formated_pk[static::$pk[0]] = $pk;
            } else {
                throw new \Exception('multi pk object and scalar value provided');
            }
        } else {
            $formated_pk = $pk;
        }

        try {
            static::getInstance($formated_pk);
            return true;
        } catch (NotFoundException) {
            return false;
        }
    }

    /**
     * Converti les propriétés natives de l'objet en tableau
     * (alias public de objectToArray)
     *
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return static::objectToArray();
    }

    /**
     * Sauve l'objet en base
     *
     * @return bool true si la sauvegarde est ok, false sinon
     *
     * @throws \Exception
     */
    public function save(): bool
    {
        $db = DataBase::getInstance();
        $data = [];

        $reqUpdate = $this->isLoaded();

        $db_table_suffix = $this->getDbTableSuffix();

        if ($reqUpdate === false) { // INSERT
            if (strlen($db_table_suffix) > 0) {
                // création éventuelle de la table dynamique (sharding)
                if (!static::hasTable($db_table_suffix)) {
                    if (!static::createTable($db_table_suffix)) {
                        throw new \Exception('impossible de créer la table ' . static::getDbTable($db_table_suffix));
                    }
                }
            }

            $sql = 'INSERT INTO `' . static::getDbTable($db_table_suffix) . '` (';

            if (count($this->modified_fields) > 0) {
                foreach ($this->modified_fields as $field => $value) {
                    if ($value === true) {
                        $sql .= '`' . $field . '`,';
                    }
                }
                $sql = substr($sql, 0, -1);
            }

            $sql .= ') VALUES (';

            if (count($this->modified_fields) > 0) {
                foreach ($this->modified_fields as $field => $value) {
                    if ($value !== true) {
                        continue;
                    }
                    $sql .= ':' . $field . ',';
                    $att = $field;
                    if (is_null($this->$att)) {
                        $data[$field] = null;
                    } else {
                        switch (static::$all_fields[$field]) {
                            case 'int':
                                $data[$field] = (int) $this->$att;
                                break;
                            case 'float':
                                $data[$field] = (float) $this->$att;
                                break;
                            case 'string':
                            case 'date':
                                $data[$field] = $this->$att;
                                break;
                            case 'bool':
                                // pas de vrai type BOOL avec MariaDB, c'est un INTEGER
                                $data[$field] = (int) (bool) $this->$att;
                                break;
                            default:
                                throw new \Exception('invalid field type: ' . static::$all_fields[$field]);
                        }
                    }
                }
                $sql = substr($sql, 0, -1);
            }

            $sql .= ')';

            $this->modified_fields = [];

            $stm = $db->pdo->prepare($sql);
            try {
                $res = $stm->execute($data);
                if (!$res) {
                    Log::error(DataBase::preparedQuery($sql, $data));
                    return false;
                } else {
                    //Log::success(DataBase::preparedQuery($sql, $data));
                    if ((count(static::getDbPk()) === 1) && (static::$all_fields[static::getDbPk()[0]] === 'int')) {
                        // cas d'une clé primaire simple avec autoincrément
                        $this->setId((int) $db->pdo->lastInsertId());
                        $this->modified_fields = [];
                    }
                    $this->loaded = true; // le prochain save() fera un UPDATE

                    $this->setObjectId(static::calcObjectId($this->getId()));
                    // /!\ pas de mise en cache directe car le champ created_at est géré par la bdd

                    return (bool) $stm->rowCount();
                }
            } catch (\PDOException $e) {
                Log::error(DataBase::preparedQuery($sql, $data));
                Log::error($e->getMessage());
                return false;
            }
        } else { // UPDATE
            if (count($this->modified_fields) === 0) {
                return true;
            }

            $fields_to_save = '';
            foreach ($this->modified_fields as $field => $value) {
                if ($value !== true) {
                    continue;
                }
                $att = $field;
                $fields_to_save .= '`' . $field . '` = :' . $field . ',';
                if (is_null($this->$att)) {
                    $data[$field] = null;
                } else {
                    switch (static::$all_fields[$field]) {
                        case 'int':
                            $data[$field] = (int) $this->$att;
                            break;
                        case 'float':
                            $data[$field] = (float) $this->$att;
                            break;
                        case 'string':
                        case 'date':
                            $data[$field] = $this->$att;
                            break;
                        case 'bool':
                            // pas de vrai type BOOL avec MariaDB, c'est un INTEGER
                            $data[$field] = (int) (bool) $this->$att;
                            break;
                        default:
                            throw new \Exception('invalid field type');
                    }
                }
            }
            $fields_to_save = substr($fields_to_save, 0, -1);

            $sql = 'UPDATE `' . static::getDbTable($db_table_suffix) . '` '
                 . 'SET ' . $fields_to_save . ' '
                 . 'WHERE 1 ';

            // @TODO verif de sécu que getDbPk pas vide ?
            foreach (static::getDbPk() as $pk) {
                $sql .= 'AND `' . $pk . '` = :' . $pk . ' ';
                $data[$pk] = $this->$pk;
            }

            $this->modified_fields = [];

            $stm = $db->pdo->prepare($sql);
            try {
                $res = $stm->execute($data);
                if (!$res) {
                    Log::error(DataBase::preparedQuery($sql, $data));
                    return false;
                } else {
                    //Log::success(DataBase::preparedQuery($sql, $data));

                    // synchro statique
                    static::$instances[$this->getObjectId()] = $this;

                    // /!\ clear du cache mais pas de mise en cache directe car le champ updated_at est géré par la bdd
                    if (static::isCachable()) {
                        ObjectCacheMC::delete($this->getObjectId());
                    }

                    return (bool) $stm->rowCount();
                }
            } catch (\PDOException $e) {
                Log::error(DataBase::preparedQuery($sql, $data));
                Log::error($e->getMessage());
                return false;
            }
        }
    }

    /**
     * Retourne une collection d'objets "ObjectModel" répondant au(x) critère(s) donné(s)
     *
     * À surcharger dans les classes filles
     *
     * @param array<string,mixed> $params [
     *                                'order_by' => string,
     *                                'sort' => string,
     *                                'start' => int,
     *                                'limit' => int,
     *                                'found_rows' => bool,
     *                            ]
     *
     * @return array<static>
     */
    public static function find(array $params): array
    {
        $db = DataBase::getInstance();
        $objs = [];

        $sql = 'SELECT ';
        if (isset($params['found_rows']) && boolval($params['found_rows'])) {
            $sql .= 'SQL_CALC_FOUND_ROWS ';
        }

        $pks = array_map(
            function ($item) {
                return '`' . $item . '`';
            },
            static::getDbPk()
        );
        $sql .= implode(', ', $pks) . ' ';

        $sql .= 'FROM `' . static::getDbTable() . '` ';
        $sql .= 'WHERE 1 ';

        if ((isset($params['order_by']) && (in_array($params['order_by'], array_keys(static::$all_fields), true)))) {
            $sql .= 'ORDER BY `' . $params['order_by'] . '` ';
        } else {
            $pks = array_map(
                function ($item) {
                    return '`' . $item . '`';
                },
                static::getDbPk()
            );
            $sql .= 'ORDER BY ' . implode(', ', $pks) . ' ';
        }

        if ((isset($params['sort']) && (in_array(strtoupper($params['sort']), ['ASC', 'DESC'], true)))) {
            $sql .= strtoupper($params['sort']) . ' ';
        } else {
            // /!\ en cas de pk multiple, le sort n'est que sur la dernière key
            $sql .= 'ASC ';
        }

        if (!isset($params['start'])) {
            $params['start'] = 0;
        }

        if (isset($params['limit']) && ($params['limit'] > 0)) {
            $sql .= 'LIMIT ' . (int) $params['start'] . ', ' . (int) $params['limit'];
        }

        $stm = $db->pdo->query($sql);
        $stm->execute();
        $rows = $stm->fetchAll();

        if (isset($params['found_rows']) && boolval($params['found_rows'])) {
            $fr_sql = 'SELECT FOUND_ROWS()';
            $fr_stm = $db->pdo->query($fr_sql);
            static::$found_rows = intval($fr_stm->fetchColumn());
        } else {
            static::$found_rows = null;
        }

        foreach ($rows as $row) {
            $pks = [];
            foreach (static::getDbPk() as $pk) {
                $pks[$pk] = $row[$pk];
            }
            $objs[] = static::getInstance($pks);
        }

        return $objs;
    }

    /**
     * Retourne une collection d'instances
     *
     * @return array<static>
     */
    public static function findAll(): array
    {
        return static::find([]);
    }

    /**
     * Retourne une instance de l'objet si trouvé, false sinon
     *
     * @param mixed|array<string,mixed> $pk
     *
     * @return static|false
     */
    public static function findOne(mixed $pk): static|false
    {
        try {
            $obj = static::getInstance($pk);
            if ($obj->isLoaded()) {
                return $obj;
            }
        } catch (NotFoundException $e) {
        }

        return false;
    }

    /**
     * @param array<string,mixed> $pk
     *
     * @return string
     * @throws \Exception
     */
    public static function calcObjectId(array $pk): string
    {
        // on trie les clés dans l'ordre de définition de la classe
        $ordered_pk = [];
        foreach (static::$pk as $key) {
            if (!array_key_exists($key, $pk)) {
                throw new \Exception('pk key not fully provided');
            }
            $ordered_pk[$key] = $pk[$key];
        }

        return get_called_class() . '__' . implode(':', array_values($ordered_pk));
    }

    /**
     * Affichage d'info de debug sur l'objet
     *
     * @return string
     */
    public function __toString(): string
    {
        $out  = '';
        $out .= 'class     : ' . __CLASS__ . "\n";
        $out .= 'className : ' . static::class . "\n";
        $out .= 'table     : ' . static::getDbTable() . "\n";
        $out .= 'pk        : ' . print_r(static::getDbPk(), true) . "\n";
        $out .= 'id        : ' . print_r($this->getId(), true) . "\n";
        $out .= 'object_id : ' . $this->getObjectId() . "\n";
        $out .= "\n";
        foreach (array_keys($this->getAllFields()) as $field) {
            $out .= '- ' . $field . ' : ' . print_r($this->$field, true) . "\n";
        }
        $out .= "\n";

        return $out;
    }

    /**
     * Efface l’enregistrement dans la table relative à l'objet
     *
     * @return bool
     */
    public function delete()
    {
        // on n'efface rien si la pk n'est pas (complétement) settée !
        foreach (static::getDbPk() as $pk) {
            if (is_null($this->$pk)) {
                Log::error("pk $pk not set, unable to delete");
                return false;
            }
        }

        if (static::isCachable()) {
            ObjectCacheMC::delete($this->getObjectId());
        }

        $db_table_suffix = $this->getDbTableSuffix();

        $db = DataBase::getInstance();
        $data = [];

        $sql  = 'DELETE FROM `' . static::getDbTable($db_table_suffix) . '` ';
        $sql .= 'WHERE 1 ';
        // @TODO verif de sécu que getDbPk pas vide ?
        foreach (static::getDbPk() as $pk) {
            $sql .= 'AND `' . $pk . '` = :' . $pk . ' ';
            $data[$pk] = $this->$pk;
        }

        $stm = $db->pdo->prepare($sql);
        try {
            $res = $stm->execute($data);
            if (!$res) {
                Log::error(DataBase::preparedQuery($sql, $data));
                return false;
            } else {
                //Log::success(DataBase::preparedQuery($sql, $data));

                // on la référence aussi statiquement
                if (array_key_exists($this->getObjectId(), static::$instances)) {
                    unset(static::$instances[$this->getObjectId()]);
                }

                return (bool) $stm->rowCount();
            }
        } catch (\PDOException $e) {
            Log::error(DataBase::preparedQuery($sql, $data));
            Log::error($e->getMessage());
            return false;
        }
    }

    /**
     * Retourne le nombre d'entités référencées
     * Note: privilégier getFoundRows() si utilisé juste après un find()
     *
     * @return int
     */
    public static function count(): int
    {
        $db = DataBase::getInstance();

        $sql  = 'SELECT COUNT(*) FROM `' . static::getDbTable() . '`';
        $count = $db->pdo->query($sql)->fetchColumn();

        return (int) $count;
    }

    /**
     * Charge toutes les infos d'une entité à partir du cache
     *
     * @return bool
     */
    protected function loadFromCache(): bool
    {
        if (($cachedData = ObjectCacheMC::get($this->getObjectId())) !== false) {
            $this->arrayToObject(unserialize($cachedData));
            return true;
        }
        return false;
    }

    /**
     * Charge toutes les infos d'une entité à partir de la base de données
     *
     * @return bool
     * @throws \Exception
     */
    protected function loadFromDb(): bool
    {
        $db = DataBase::getInstance();
        $data = [];

        $db_table_suffix = $this->getDbTableSuffix();

        $sql  = 'SELECT * ';
        $sql .= 'FROM `' . static::getDbTable($db_table_suffix) . '` ';
        $sql .= 'WHERE 1 ';

        // @TODO verif de sécu que getDbPk pas vide ?
        foreach (static::getDbPk() as $pk) {
            $sql .= 'AND `' . $pk . '` = :' . $pk . ' ';
            $data[$pk] = $this->$pk;
        }

        $stm = $db->pdo->prepare($sql);
        try {
            $res = $stm->execute($data);
            if (!$res) {
                Log::error(DataBase::preparedQuery($sql, $data));
                return false;
            } elseif (($row = $stm->fetch()) !== false) {
                //Log::success(DataBase::preparedQuery($sql, $data));
                $this->arrayToObject($row);
                return true;
            } else {
                throw new NotFoundException(sprintf('instance de %s non trouvée', get_called_class()));
            }
        } catch (\PDOException $e) {
            // cf. https://mariadb.com/kb/en/mariadb-error-code-reference/
            if ($e->getCode() === '42S02') {
                // table shardée non trouvée
                throw new NotFoundException(sprintf('instance de %s non trouvée', get_called_class()));
            }

            Log::error(DataBase::preparedQuery($sql, $data));
            Log::error($e->getMessage());
            return false;
        }
    }

    /**
     * Conversion des champs issus de la db en propriétés typées de l'objet
     *
     * @param array<string,mixed> $data data
     *
     * @return bool
     */
    protected function arrayToObject(array $data)
    {
        $all_fields = static::getAllFields();
        foreach ($data as $k => $v) {
            if (array_key_exists($k, $all_fields)) {
                $att = $k;
                if (is_null($v)) {
                    $this->$att = null;
                } else {
                    switch ($all_fields[$k]) {
                        case 'phpser':
                            $this->$att = unserialize($v);
                            break;
                        case 'int':
                            $this->$att = (int) $v;
                            break;
                        case 'float':
                            $this->$att = (float) $v;
                            break;
                        case 'bool':
                            $this->$att = (bool) $v;
                            break;
                        case 'string':
                        case 'date':
                            $this->$att = (string) $v;
                            break;
                        default:
                            $this->$att = $v;
                    }
                }
            }
        }

        return true;
    }

    /**
     * Retourne les propriétés de l'objet sous forme de tableau
     *
     * @return array<string,mixed>
     */
    protected function objectToArray(): array
    {
        $arr = [];
        $all_fields = static::getAllFields();

        foreach ($all_fields as $field => $type) {
            $att = $field;
            if (property_exists($this, $att)) {
                $arr[$field] = $this->$att;
            }
        }

        return $arr;
    }

    /**
     * Crée une table shardée
     *
     * @param string $db_table_suffix CCC_YYYY
     *
     * @return bool
     */
    public static function createTable(string $db_table_suffix = ''): bool
    {
        // à implémenter dans les classes filles dont on veut une table shardée
        // mettre à jour éventuellement static::$has_table[$table]
        return false;
    }
}
