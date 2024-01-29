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
 * @template TObjectModel as ObjectModel
 *
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
abstract class ObjectModel
{
    /**
     * @var ?TObjectModel
     */
    protected static ?ObjectModel $instance = null;

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
    protected static bool $cachable = true;

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
     * @var array<mixed>
     */
    protected array $modified_fields = [];

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
     * @param bool $fusion fusion
     *
     * @return array<string,string>|array<string,array<string,string>>
     */
    protected function getAllFields(bool $fusion = true): array
    {
        return static::$all_fields;
    }

    /**
     * Construction de l'objet
     *
     * La clé primaire $id peut être soit simple (et on donne directement sa valeur),
     * soit mutiple et on donne un tableau ['pkName1' => pkValue1, 'pkName2' => pkValue2 ]
     *
     * @param mixed $id id
     */
    final public function __construct(mixed $id = null)
    {
        if (!is_null($id)) {
            if (is_array($id)) {
                // clé primaire multiple
                foreach (static::$pk as $field) {
                    $pk = $field;
                    $this->$pk = $id[$field];
                }
                $this->loadObjectId();
            } else {
                // clé primaire simple
                $pk = static::$pk;
                switch (static::$all_fields[$pk]) {
                    case 'string':
                        $this->$pk = (string) $id;
                        break;
                    case 'int':
                        $this->$pk = (int) $id;
                        break;
                }
                $this->loadObjectId();
            }

            if (static::isCachable() && $this->loadFromCache()) {
                // chargement ok du cache
            } elseif ($this->loadFromDb()) {
                // chargement ok de la bdd
                if (static::isCachable()) {
                    // alimentation du cache
                    ObjectCache::set($this->getObjectId(), serialize($this->objectToArray()));
                }
            } else {
                // erreur au chargement
            }
            static::$instance = $this;
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
     * @param mixed $id int|string|array
     *
     * @todo à optimiser le chargement et la gestion du cache
     *
     * @return object
     */
    public static function getInstance(mixed $id): object
    {
        if (is_null(static::$instance)) {
            // pas du tout d'instance: on en crée une, le constructeur ira s'enregistrer
            // dans la variable statique.
            return new static($id);
        } elseif (is_array(static::$pk)) {
            foreach (static::$pk as $pk) {
                $propName = $pk;
                if (static::$instance->$propName !== $id[$pk]) {
                    // on a deja une instance, mais ce n'est pas le bon id
                    static::deleteInstance();
                    new static($id);
                }
            }
        } else {
            $pk = static::$pk;
            if (static::$instance->$pk !== $id) {
                // on a deja une instance, mais ce n'est pas le bon id
                static::deleteInstance();
                new static($id);
            } else {
                // tout est ok
            }
        }
        return static::$instance;
    }

    /**
     * @return bool
     */
    public static function deleteInstance(): bool
    {
        if (isset(static::$instance)) {
            static::$instance = null;
            return true;
        }
        return false;
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
     * - Soit la valeur si clé primaire simple
     * - Soit un tableau ['pkName1' => pkValue1, 'pkName2' => pkValue2] si clé primaire multiple
     *
     * @return int|string|array<mixed>
     */
    public function getId(): int|string|array
    {
        if (is_array(static::$pk)) {
            $pks = [];
            foreach (static::$pk as $pk) {
                $pk = $pk;
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
     * @param int|string|array<string,mixed> $id id
     *
     * @return object
     */
    public function setId(mixed $id)
    {
        if (is_array($id)) {
            foreach ($id as $key => $val) {
                $pk = $key;
                $this->$pk = $val;
            }
        } else {
            $pk = static::$pk;
            $this->$pk = $id;
        }

        return $this;
    }

    /**
     * @return int|bool
     */
    public function save(): int|bool
    {
        $db = DataBase::getInstance();

        if (!$this->getId()) { // INSERT
            $sql = 'INSERT INTO `' . $this->getDbTable() . '` (';

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
                    $att = $field;
                    if (is_null($this->$att)) {
                        $sql .= 'NULL,';
                    } else {
                        switch (static::$all_fields[$field]) {
                            case 'int':
                                $sql .= (int) $this->$att . ',';
                                break;
                            case 'float':
                                $sql .= number_format((float) $this->$att, 8, '.', '') . ',';
                                break;
                            case 'string':
                            case 'date':
                                $sql .= "'" . $db->escape($this->$att) . "',";
                                break;
                            case 'bool':
                                $sql .= ((bool) $this->$att ? 'TRUE' : 'FALSE') . ",";
                                break;
                            case 'password':
                                $sql .= "PASSWORD('" . $db->escape($this->$att) . "'),";
                                break;
                            case 'phpser':
                                $sql .= "'" . $db->escape(serialize($this->$att)) . "',";
                                break;
                            default:
                                throw new \Exception('invalid field type: ' . static::$all_fields[$field]);
                        }
                    }
                }
                $sql = substr($sql, 0, -1);
            }

            $sql .= ')';

            $db->query($sql);

            $this->setId((int) $db->insertId());
            $this->loadObjectId();

            // /!\ pas de mise en cache directe car le champ created_at est géré par la bdd

            return $this->getId();
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
                if (is_null($this->$att)) {
                    $fields_to_save .= " `" . $field . "` = NULL,";
                } else {
                    switch (static::$all_fields[$field]) {
                        case 'int':
                            $fields_to_save .= " `" . $field . "` = " . (int) $this->$att . ",";
                            break;
                        case 'float':
                            $fields_to_save .= " `" . $field . "` = " . number_format((float) $this->$att, 8, ".", "") . ",";
                            break;
                        case 'string':
                        case 'date':
                            $fields_to_save .= " `" . $field . "` = '" . $db->escape($this->$att) . "',";
                            break;
                        case 'bool':
                            $fields_to_save .= " `" . $field . "` = " . (((bool) $this->$att) ? 'TRUE' : 'FALSE') . ",";
                            break;
                        case 'password':
                            $fields_to_save .= " `" . $field . "` = PASSWORD('" . $db->escape($this->$att) . "'),";
                            break;
                        case 'phpser':
                            $fields_to_save .= " `" . $field . "` = '" . $db->escape(serialize($this->$att)) . "',";
                            break;
                        default:
                            throw new \Exception('invalid field type');
                    }
                }
            }
            $fields_to_save = substr($fields_to_save, 0, -1);

            $sql = 'UPDATE `' . $this->getDbTable() . '` '
                 . 'SET ' . $fields_to_save . ' '
                 . 'WHERE `' . $this->getDbPk() . '` = ' . (int) $this->getId();

            $this->modified_fields = [];

            $db->query($sql);

            // /!\ clear du cache mais pas de mise en cache directe car le champ updated_at est géré par la bdd

            if (static::isCachable()) {
                ObjectCache::unset($this->getObjectId());
            }

            return true;
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
     *                            ]
     *
     * @return array<TObjectModel>
     */
    public static function find(array $params): array
    {
        $db = DataBase::getInstance();
        $objs = [];

        $sql = "SELECT `" . static::getDbPk() . "` FROM `" . static::getDbTable() . "` WHERE 1 ";

        if ((isset($params['order_by']) && (in_array($params['order_by'], array_keys(static::$all_fields))))) {
            $sql .= "ORDER BY `" . $params['order_by'] . "` ";
        } else {
            $sql .= "ORDER BY `" . static::getDbPk() . "` ";
        }

        if ((isset($params['sort']) && (in_array($params['sort'], ['ASC', 'DESC'])))) {
            $sql .= $params['sort'] . " ";
        } else {
            $sql .= "ASC ";
        }

        if (!isset($params['start'])) {
            $params['start'] = 0;
        }

        if (isset($params['limit'])) {
            $sql .= "LIMIT " . (int) $params['start'] . ", " . (int) $params['limit'];
        }

        $ids = $db->queryWithFetchFirstFields($sql);
        foreach ($ids as $id) {
            $objs[] = static::getInstance((int) $id);
        }

        return $objs;
    }

    /**
     * Retourne une collection d'instances
     *
     * @return array<TObjectModel>
     * @throws \Exception
     */
    public static function findAll(): array
    {
        // version factorisée
        /*
        return static::find([
            'order_by' => static::getDbPk(),
            'sort' => 'ASC',
        ]);
        */

        $db = DataBase::getInstance();
        $objs = [];

        if (is_array(static::getDbPk())) {
            $sql = 'SELECT `' . implode('`,`', static::getDbPk()) . '` FROM `' . static::getDbTable() . '` ORDER BY';
            foreach (static::getDbPk() as $pk) {
                $sql .= ' `' . $pk . '` ASC,';
            }
            $sql = substr($sql, 0, -1); // retrait de la dernière virgule

            $rows = $db->queryWithFetch($sql);
            foreach ($rows as $row) {
                // todo transtypage éventuel
                $objs[] = static::getInstance($row);
            }
        } else {
            $sql  = 'SELECT `' . static::getDbPk() . '` ';
            $sql .= 'FROM `' . static::getDbTable() . '` ';
            $sql .= 'ORDER BY `' . static::getDbPk() . '` ASC';
            if ($ids = $db->queryWithFetchFirstFields($sql)) {
                foreach ($ids as $id) {
                    switch (static::$all_fields[static::getDbPk()]) {
                        case 'string':
                            $id = (string) $id;
                            break;
                        case 'int':
                            $id = (int) $id;
                            break;
                    }
                    $objs[] = static::getInstance($id);
                }
            }
        }

        return $objs;
    }

    /**
     * @return void
     */
    public function loadObjectId(): void
    {
        if (is_array($this->getId())) {
            $this->object_id = get_called_class() . ':' . implode(':', array_values($this->getId())); // ex: WorldRegion:FR:96
        } else {
            $this->object_id = get_called_class() . ':' . $this->getId(); // ex: Membre:1234
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
        $out .= 'table     : ' . $this->getDbTable() . "\n";
        $out .= 'pk        : ' . print_r($this->getDbPk(), true) . "\n";

        return $out;
    }

    /**
     * Efface l'enregistrement dans la table relative à l'objet
     *
     * @return bool
     */
    public function delete(): bool
    {
        $db = DataBase::getInstance();

        if (static::isCachable()) {
            ObjectCache::unset($this->getObjectId());
        }

        // @todo cas pk array, pk non int
        $sql = sprintf('DELETE FROM `%s` WHERE `%s` = %d', $this->getDbTable(), $this->getDbPk(), $this->getId());
        $db->query($sql);

        if ($db->affectedRows()) {
            return true;
        }
        return false;
    }

    /**
     * Retourne le nombre d'entités référencées
     *
     * @return int
     */
    public static function count(): int
    {
        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(*) "
             . "FROM `" . static::getDbTable() . "`";

        return (int) $db->queryWithFetchFirstField($sql);
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

        return (int) $db->queryWithFetchFirstField($sql);
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

        $sql = "SELECT * FROM `" . static::$table . "` ";

        if (!is_array(static::$pk)) {
            // clé primaire simple
            if (static::$all_fields[static::$pk] === 'int') {
                $sql .= "WHERE `" . static::$pk . "` = " . (int) $this->{static::$pk};
            } elseif (static::$all_fields[static::$pk] === 'string') {
                $sql .= "WHERE `" . static::$pk . "` = '" . $this->{static::$pk} . "'";
            }
        } else {
            // clé primaire multiple
            $sql .= "WHERE 1 ";
            foreach (static::$pk as $pk) {
                if (static::$all_fields[$pk] === 'int') {
                    $sql .= "AND `" . $pk . "` = " . (int) $this->{$pk} . " ";
                } elseif (static::$all_fields[$pk] === 'string') {
                    $sql .= "AND `" . $pk . "` = '" . $this->{$pk} . "' ";
                }
            }
        }

        if ($res = $db->queryWithFetchFirstRow($sql)) {
            $this->arrayToObject($res);
            return true;
        }
        return false;
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
        $all_fields = static::getAllFields(true);
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
     * @return array<string,mixed>
     */
    protected function objectToArray(): array
    {
        $arr = [];
        $all_fields = static::getAllFields(true);

        foreach ($all_fields as $field => $type) {
            $att = $field;
            if (property_exists($this, $att)) {
                $arr[$field] = $this->$att;
            }
        }

        return $arr;
    }
}
