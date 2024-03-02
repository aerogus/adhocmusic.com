<?php

declare(strict_types=1);

namespace Adhoc\Utils;

/**
 * Classe abstraite à étendre
 *
 * On regroupe ici les méthodes communes à tous les gros objets AD'HOC
 * qui ont comme caractéristiques principales:
 * - des méthodes d'accès/écriture des données
 *
 * @abstract
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
abstract class ObjectModel
{
    /**
     * @var ?array<static>
     */
    protected static ?array $instances = null;

    /**
     * Champ clé primaire (simple ou multiple) de l'objet fils
     *
     * @var string|array<string>
     */
    protected static string|array $pk = '';

    /**
     * Table de la bdd utilisée par l'objet
     *
     * @var string
     */
    protected static string $table = '';

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
     * (ou un tableau de tableau avec le nom de la db_table comme clé du 1er tableau)
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

    /* db adhoc */
    /* todo retirer tous ces trucs en dur... */
    protected static string $db_table_appartient_a   = 'adhoc_appartient_a';
    protected static string $db_table_event_style    = 'adhoc_event_style';
    protected static string $db_table_forums         = 'adhoc_forum_public_message';
    protected static string $db_table_groupe_style   = 'adhoc_groupe_style';
    protected static string $db_table_organise_par   = 'adhoc_organise_par';
    protected static string $db_table_participe_a    = 'adhoc_participe_a';
    protected static string $db_table_video_groupe   = 'adhoc_video_groupe';

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
            if (is_array($id)) {
                // clé primaire multiple
                foreach (static::$pk as $field) {
                    $pk = $field;
                    $this->$pk = $id[$field];
                }
            } else {
                // clé primaire simple
                $pk = static::$pk;
                $this->$pk = $id;
            }

            $this->loadObjectId();

            if (static::isCachable() && ($this->loaded = $this->loadFromCache())) {
                // chargement ok du cache
                LogNG::debug('loadFromCache OK');
            } elseif ($this->loaded = $this->loadFromDb()) {
                LogNG::debug('loadFromDb OK');
                // chargement ok de la bdd
                if (static::isCachable()) {
                    // alimentation du cache
                    ObjectCache::set($this->getObjectId(), serialize($this->objectToArray()));
                }
            } else {
                // erreur au chargement
            }

            $key = get_called_class() . '__';
            if (is_array($id)) {
                $key .= implode(':', array_values($id));
            } else {
                $key .= $id;
            }

            static::$instances[$key] = $this;
        }
    }

    /**
     * Retourne le nom de la table associée à cet objet
     *
     * @return string
     */
    public static function getDbTable(): string
    {
        return static::$table;
    }

    /**
     * Retourne le nom du/des champ(s) de la clé primaire
     *
     * @return string|array<string>
     */
    public static function getDbPk(): string|array
    {
        return static::$pk;
    }

    /**
     * @param mixed $id int|string|array<mixed>
     *
     * @return static
     */
    public static function getInstance($id): self
    {
        if (is_null(static::$instances)) {
            // pas du tout d'instances: on en crée une, le constructeur ira s'enregistrer
            // dans le tableau statique $instances.
            return new static($id);
        } elseif (is_array(static::$pk)) {
            $arr_pk = [];
            foreach (static::$pk as $pk) {
                $arr_pk[] = $id[$pk];
            }
            $key = get_called_class() . '__' . implode(':', $arr_pk);
            if (!array_key_exists($key, static::$instances)) {
                // l'instance n'est pas chargée
                new static($id);
            }
        } else {
            $key = get_called_class() . '__' . $id;
            if (!array_key_exists($key, static::$instances)) {
                // l'instance n'est pas chargée
                new static($id);
            }
        }

        return static::$instances[$key];
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
     * Retourne la valeur de la clé primaire
     *
     * - Soit directement la valeur si la clé primaire est simple
     * - Soit un tableau ['pkName1' => pkValue1, 'pkName2' => pkValue2]
     *   si la clé primaire est multiple
     *
     * @return mixed|array<mixed>
     */
    public function getId(): mixed
    {
        if (is_array(static::$pk)) {
            $pks = [];
            foreach (static::$pk as $pk) {
                $pks[$pk] = $this->$pk;
            }
            return $pks;
        } else {
            $pk = static::$pk;
            return $this->$pk;
        }
    }

    /**
     * Set la valeur de la clé primaire
     * Todo gérer si pk simple ou multiple, le typage, si nom du champ est bien une pk
     *
     * @param mixed $id id
     *
     * @return static
     */
    public function setId($id): static
    {
        if ($this->isLoaded()) {
            throw new \Exception('can not override pk');
        }

        if (is_array($id)) {
            foreach ($id as $pk => $val) {
                if ($this->$pk !== $val) {
                    $this->$pk = $val;
                    $this->modified_fields[$pk] = true;
                }
            }
        } else {
            if ($this->{static::getDbPk()} !== $id) {
                $this->{static::getDbPk()} = $id;
                $this->modified_fields[static::getDbPk()] = true;
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
        if (is_array(static::getDbPk()) && !is_array($pk)) {
            throw new \Exception('pk composée, le paramètre doit être un tableau');
        }

        $db = DataBase::getInstance();
        $data = [];

        $sql  = 'SELECT ';
        if (is_array(static::getDbPk())) {
            $pks = array_map(
                function ($item) {
                    return '`' . $item . '`';
                },
                static::getDbPk()
            );
            $sql .= implode(', ', $pks) . ' ';
        } else {
            $sql .= '`' . static::getDbPk() . '` ';
        }
        $sql .= 'FROM `' . static::getDbTable() . '` ';
        $sql .= 'WHERE 1 ';

        if (is_array(static::getDbPk())) {
            foreach (static::getDbPk() as $idx => $_pk) {
                $sql .= 'AND `' . $_pk . '` = :' . $_pk . ' ';
                $data[$_pk] = $pk[$_pk];
            }
        } else {
            $sql .= 'AND `' . static::getDbPk() . '` = :' . static::getDbPk();
            $data[static::getDbPk()] = $pk;
        }

        $stm = $db->pdo->prepare($sql);
        try {
            $res = $stm->execute($data);
            return (bool) $stm->rowCount();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Sauve l'objet en base
     *
     * @return bool true si la sauvegarde est ok, false sinon
     */
    public function save(): bool
    {
        $db = DataBase::getInstance();
        $data = [];

        $reqUpdate = $this->isLoaded();

        if ($reqUpdate === false) { // INSERT
            $sql = 'INSERT INTO `' . static::getDbTable() . '` (';

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
                    LogNG::error(DataBase::preparedQuery($sql, $data));
                    return false;
                } else {
                    //LogNG::success(DataBase::preparedQuery($sql, $data));
                    if (is_string(static::getDbPk()) && (static::$all_fields[static::getDbPk()] === 'int')) {
                        // cas d'une clé primaire simple avec autoincrément
                        $this->setId((int) $db->pdo->lastInsertId());
                        $this->modified_fields = [];
                    }
                    $this->loaded = true; // le prochain save() fera un UPDATE

                    $this->loadObjectId();
                    // /!\ pas de mise en cache directe car le champ created_at est géré par la bdd

                    return (bool) $stm->rowCount();
                }
            } catch (\PDOException $e) {
                LogNG::error(DataBase::preparedQuery($sql, $data));
                LogNG::error($e->getMessage());
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

            $sql = 'UPDATE `' . static::getDbTable() . '` '
                 . 'SET ' . $fields_to_save . ' ';

            if (!is_array(static::getDbPk())) {
                $sql .= 'WHERE `' . static::getDbPk() . '` = :' . static::getDbPk();
                $data[static::getDbPk()] = $this->getId();
            } else {
                $sql .= 'WHERE 1 ';
                foreach (static::getDbPk() as $pk) {
                    $sql .= 'AND `' . $pk . '` = :' . $pk . ' ';
                    $data[$pk] = $this->$pk;
                }
            }

            $this->modified_fields = [];

            $stm = $db->pdo->prepare($sql);
            try {
                $res = $stm->execute($data);
                if (!$res) {
                    LogNG::error(DataBase::preparedQuery($sql, $data));
                    return false;
                } else {
                    LogNG::success(DataBase::preparedQuery($sql, $data));

                    // /!\ clear du cache mais pas de mise en cache directe car le champ updated_at est géré par la bdd
                    if (static::isCachable()) {
                        ObjectCache::unset($this->getObjectId());
                    }

                    return (bool) $stm->rowCount();
                }
            } catch (\PDOException $e) {
                LogNG::error(DataBase::preparedQuery($sql, $data));
                LogNG::error($e->getMessage());
                return false;
            }
        }
    }

    /**
     * @return int|false
     */
    public function getLastInsertId(): int|false
    {
        if (is_string(static::getDbPk()) && (static::$all_fields[static::getDbPk()] === 'int')) {
            $db = DataBase::getInstance();
            return (int) $db->pdo->lastInsertId();
        }
        return false;
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
     *                            ]
     *
     * @return array<static>
     */
    public static function find(array $params): array
    {
        $db = DataBase::getInstance();
        $objs = [];

        $sql = 'SELECT ';
        if (is_array(static::getDbPk())) {
            $pks = array_map(
                function ($item) {
                    return '`' . $item . '`';
                },
                static::getDbPk()
            );
            $sql .= implode(', ', $pks) . ' ';
        } else {
            $sql .= '`' . static::getDbPk() . '` ';
        }
        $sql .= 'FROM `' . static::getDbTable() . '` ';
        $sql .= 'WHERE 1 ';

        if ((isset($params['order_by']) && (in_array($params['order_by'], array_keys(static::$all_fields), true)))) {
            $sql .= 'ORDER BY `' . $params['order_by'] . '` ';
        } else {
            if (is_array(static::getDbPk())) {
                $pks = array_map(
                    function ($item) {
                        return '`' . $item . '`';
                    },
                    static::getDbPk()
                );
                $sql .= 'ORDER BY ' . implode(', ', $pks) . ' ';
            } else {
                $sql .= 'ORDER BY `' . static::getDbPk() . '` ';
            }
        }

        if ((isset($params['sort']) && (in_array($params['sort'], ['ASC', 'DESC'], true)))) {
            $sql .= $params['sort'] . ' ';
        } else {
            // /!\ en cas de pk multiple, le sort n'est que sur la dernière key
            $sql .= 'ASC ';
        }

        if (!isset($params['start'])) {
            $params['start'] = 0;
        }

        if (isset($params['limit'])) {
            $sql .= 'LIMIT ' . (int) $params['start'] . ', ' . (int) $params['limit'];
        }

        $stm = $db->pdo->query($sql);
        $stm->execute();
        $rows = $stm->fetchAll();
        foreach ($rows as $row) {
            if (is_array(static::getDbPk())) {
                $pks = [];
                foreach (static::getDbPk() as $pk) {
                    $pks[$pk] = $row[$pk];
                }
                $objs[] = static::getInstance($pks);
            } else {
                $objs[] = static::getInstance($row[static::getDbPk()]);
            }
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
        return static::find([
            'order_by' => static::getDbPk(),
            'sort' => 'ASC',
        ]);
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
     * @return void
     */
    public function loadObjectId(): void
    {
        if (is_array($this->getId())) {
            $this->object_id = get_called_class() . '__' . implode(':', array_values($this->getId()));
        } else {
            $this->object_id = get_called_class() . '__' . $this->getId();
        }
    }

    /**
     * @return void
     */
    public static function resetAutoIncrement(): void
    {
        DataBase::getInstance()
            ->query("ALTER TABLE `" . static::getDbTable() . "` AUTO_INCREMENT = 1");
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
        $out .= 'object_id : ' . $this->getObjectId() . "\n";
        $out .= 'id        : ' . print_r($this->getId(), true) . "\n";
        $out .= 'table     : ' . static::getDbTable() . "\n";
        $out .= 'pk        : ' . print_r(static::getDbPk(), true) . "\n";

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
        if (is_array(static::getDbPk())) {
            foreach (static::getDbPk() as $pk) {
                if (is_null($this->$pk)) {
                    LogNG::error("pk $pk not set, unable to delete");
                    return false;
                }
            }
        } else {
            if (is_null($this->{static::getDbPk()})) {
                LogNG::error("pk " . static::getDbPk() . " not set, unable to delete");
                return false;
            }
        }

        if (static::isCachable()) {
            ObjectCache::unset($this->getObjectId());
        }

        $db = DataBase::getInstance();
        $data = [];

        $sql  = 'DELETE FROM `' . static::getDbTable() . '` ';

        if (!is_array(static::getDbPk())) {
            // clé primaire simple
            $sql .= 'WHERE `' . static::getDbPk() . '` = :' . static::getDbPk();
            $data[static::getDbPk()] = $this->{static::getDbPk()};
        } else {
            // clé primaire multiple
            $sql .= 'WHERE 1 ';
            foreach (static::getDbPk() as $pk) {
                $sql .= 'AND `' . $pk . '` = :' . $pk . ' ';
                $data[$pk] = $this->$pk;
            }
        }

        $stm = $db->pdo->prepare($sql);
        try {
            $res = $stm->execute($data);
            if (!$res) {
                LogNG::error(DataBase::preparedQuery($sql, $data));
                return false;
            } else {
                //LogNG::success(DataBase::preparedQuery($sql, $data));
                return (bool) $stm->rowCount();
            }
        } catch (\PDOException $e) {
            LogNG::error(DataBase::preparedQuery($sql, $data));
            LogNG::error($e->getMessage());
            return false;
        }
    }

    /**
     * Retourne le nombre d'entités référencées
     *
     * @return int
     */
    public static function count(): int
    {
        return count(static::findAll());
    }

    /**
     * Compte le nombre d'entités liées au user loggué
     * (ne marche pas pour toutes les tables)
     *
     * @return int
     * @throws \Exception
     */
    public static function countMy(): int
    {
        if (empty($_SESSION['membre'])) {
            throw new \Exception('non identifié');
        }

        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(*) "
             . "FROM `" . static::getDbTable() . "` "
             . "WHERE `id_contact` = " . (int) $_SESSION['membre']->getId();

        return (int) $db->pdo->query($sql)->fetchColumn();
    }

    /**
     * Charge toutes les infos d'une entité à partir du cache
     *
     * @return bool
     */
    protected function loadFromCache(): bool
    {
        if (($cachedData = ObjectCache::get($this->getObjectId())) !== null) {
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

        $sql  = 'SELECT * ';
        $sql .= 'FROM `' . static::getDbTable() . '` ';

        if (!is_array(static::getDbPk())) {
            // clé primaire simple
            $sql .= 'WHERE `' . static::getDbPk() . '` = :' . static::getDbPk();
            $data[static::getDbPk()] = $this->{static::getDbPk()};
        } else {
            // clé primaire multiple
            $sql .= 'WHERE 1 ';
            foreach (static::getDbPk() as $pk) {
                $sql .= 'AND `' . $pk . '` = :' . $pk . ' ';
                $data[$pk] = $this->$pk;
            }
        }

        $stm = $db->pdo->prepare($sql);
        try {
            $res = $stm->execute($data);
            if (!$res) {
                LogNG::error(DataBase::preparedQuery($sql, $data));
                return false;
            } elseif (($row = $stm->fetch()) !== false) {
                //LogNG::success(DataBase::preparedQuery($sql, $data));
                $this->arrayToObject($row);
                return true;
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            LogNG::error(DataBase::preparedQuery($sql, $data));
            LogNG::error($e->getMessage());
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
    protected function arrayToObject(array $data): bool
    {
        $all_fields = static::getAllFields();
        foreach ($data as $k => $v) {
            if (array_key_exists($k, $all_fields)) {
                $att = $k;
                if (is_null($v)) {
                    // TODO: si champ vide et propriété string, faire chaîne vide ou valeur null ?
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
}
