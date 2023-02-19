<?php declare(strict_types=1);

/**
 * Classe abstraite à étendre
 *
 * On regroupe ici les méthodes communes à tous les gros objets AD'HOC
 * qui ont comme caractéristiques principales:
 * - des méthodes d'accès/écriture des données
 *
 * @abstract
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
abstract class ObjectModel
{
    /**
     * @var object
     */
    protected static $_instance = null;

    /**
     * Champ clé primaire (simple ou multiple) de l'objet fils
     *
     * @var string|array
     */
    protected static $_pk = '';

    /**
     * Table de la bdd utilisée par l'objet
     *
     * @var string
     */
    protected static $_table = '';

    /**
     * L'objet peut-il être mis en cache ?
     *
     * @var bool
     */
    protected static $_cachable = true;

    /**
     * Identifiant unique d'objet
     *
     * @var string
     */
    protected $_object_id = '';

    /**
     * Liste des attributs de l'objet
     *
     * Ce tableau doit être redéfini dans les classes filles
     *
     * @var array<string,string>
     */
    protected static $_all_fields = [];

    /**
     * Tableau des attributs modifiés depuis la dernière sauvegarde.
     *
     * Pour chaque attribut modifié, on a un élément de la forme 'attribut => true'.
     * (ou un tableau de tableau avec le nom de la db_table comme clé du 1er tableau)
     *
     * @var array
     */
    protected $_modified_fields = [];

    /* db adhoc */
    /* todo retirer tous ces trucs en dur... */
    protected static $_db_table_appartient_a   = 'adhoc_appartient_a';
    protected static $_db_table_event_style    = 'adhoc_event_style';
    protected static $_db_table_forums         = 'adhoc_forum_public_message';
    protected static $_db_table_groupe_style   = 'adhoc_groupe_style';
    protected static $_db_table_organise_par   = 'adhoc_organise_par';
    protected static $_db_table_participe_a    = 'adhoc_participe_a';
    protected static $_db_table_video_groupe   = 'adhoc_video_groupe';

    /**
     * @param bool $fusion fusion
     *
     * @return array
     */
    protected function _getAllFields(bool $fusion = true): array
    {
        return static::$_all_fields;
    }

    /**
     * Construction de l'objet
     *
     * La clé primaire $id peut être soit simple (et on donne directement sa valeur),
     * soit mutiple et on donne un tableau ['pkName1' => pkValue1, 'pkName2' => pkValue2 ]
     *
     * @param mixed $id id
     */
    function __construct($id = null)
    {
        if (!is_null($id)) {
            if (is_array($id)) {
                // clé primaire multiple
                foreach (static::$_pk as $field) {
                    $pk = '_' . $field;
                    $this->$pk = $id[$field];
                }
                $this->loadObjectId();
            } else {
                // clé primaire simple
                $pk = '_' . static::$_pk;
                $this->$pk = $id;
                $this->loadObjectId();
            }

            if (static::isCachable() && $this->_loadFromCache()) {
                // chargement ok du cache
            } elseif ($this->_loadFromDb()) {
                // chargement ok de la bdd
                if (static::isCachable()) {
                    // alimentation du cache
                    ObjectCache::set($this->getObjectId(), serialize($this->_objectToArray()));
                }
            } else {
                // erreur au chargement
            }
            static::$_instance = $this;
        }
    }

    /**
     * Retourne le nom de la table associée à cet objet
     *
     * @return string
     */
    static function getDbTable(): string
    {
        return static::$_table;
    }

    /**
     * Retourne le nom du/des champ(s) de la clé primaire
     *
     * @return string|array
     */
    static function getDbPk()
    {
        return static::$_pk;
    }

    /**
     * @param mixed $id int|string|array
     *
     * @todo à optimiser le chargement et la gestion du cache
     *
     * @return object
     */
    static function getInstance($id): object
    {
        if (is_null(static::$_instance)) {
            // pas du tout d'instance: on en crée une, le constructeur ira s'enregistrer
            // dans la variable statique.
            return new static($id);
        } elseif (is_array(static::$_pk)) {
            foreach (static::$_pk as $pk) {
                $propName = '_' . $pk;
                if (static::$_instance->$propName !== $id[$pk]) {
                    // on a deja une instance, mais ce n'est pas le bon id
                    static::deleteInstance();
                    new static($id);
                }
            }
        } else {
            $pk = '_' . static::$_pk;
            if (static::$_instance->$pk !== $id) {
                // on a deja une instance, mais ce n'est pas le bon id
                static::deleteInstance();
                new static($id);
            } else {
                // tout est ok
            }
        }
        return static::$_instance;
    }

    /**
     * @return bool
     */
    static function deleteInstance(): bool
    {
        if (isset(static::$_instance)) {
            static::$_instance = null;
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    static function isCachable(): bool
    {
        return static::$_cachable;
    }

    /**
     * @return string
     */
    function getObjectId(): string
    {
        return $this->_object_id;
    }

    /**
     * Retourne la valeur de la clé primaire
     * - Soit la valeur si clé primaire simple
     * - Soit un tableau ['pkName1' => pkValue1, 'pkName2' => pkValue2] si clé primaire multiple
     *
     * @return int ou string ou array si clé primaire multiple
     */
    function getId()
    {
        if (is_array(static::$_pk)) {
            $pks = [];
            foreach (static::$_pk as $_pk) {
                $pk = '_' . $_pk;
                $pks[$_pk] = $this->$pk;
            }
            return $pks;
        } else {
            $pk = '_' . static::$_pk;
            return $this->$pk;
        }
    }

    /**
     * Set la valeur de la clé primaire
     * Todo gérer si pk simple ou multiple, le typage, si nom du champ est bien une pk
     *
     * @var mixed $id id
     *
     * @return object
     */
    function setId($id)
    {
        if (is_array($id)) {
            foreach ($val as $key => $val) {
                $pk = '_' . $key;
                $this->$pk = $val;
            }
        } else {
            $pk = '_' . static::$_pk;
            $this->$pk = $id;
        }

        return $this;
    }

    /**
     *
     */
    function save()
    {
        $db = DataBase::getInstance();

        if (!$this->getId()) { // INSERT

            $sql = 'INSERT INTO `' . $this->getDbTable() . '` (';

            if (count($this->_modified_fields) > 0) {
                foreach ($this->_modified_fields as $field => $value) {
                    if ($value === true) {
                        $sql .= '`' . $field . '`,';
                    }
                }
                $sql = substr($sql, 0, -1);
            }
            $sql .= ') VALUES (';

            if (count($this->_modified_fields) > 0) {
                foreach ($this->_modified_fields as $field => $value) {
                    if ($value !== true) {
                        continue;
                    }
                    $att = '_' . $field;
                    if (is_null($this->$att)) {
                        $sql .= 'NULL,';
                    } else {
                        switch (static::$_all_fields[$field]) {
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
                                throw new Exception('invalid field type: ' . $type);
                                break;
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

            if (count($this->_modified_fields) === 0) {
                return true;
            }

            $fields_to_save = '';
            foreach ($this->_modified_fields as $field => $value) {
                if ($value !== true) {
                    continue;
                }
                $att = '_'.$field;
                if (is_null($this->$att)) {
                    $fields_to_save .= " `" . $field . "` = NULL,";
                } else {
                    switch (static::$_all_fields[$field]) {
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
                            throw new Exception('invalid field type');
                            break;
                    }
                }
            }
            $fields_to_save = substr($fields_to_save, 0, -1);

            $sql = 'UPDATE `' . $this->getDbTable() . '` '
                 . 'SET ' . $fields_to_save . ' '
                 . 'WHERE `' . $this->getDbPk() . '` = ' . (int) $this->getId();

            $this->_modified_fields = [];

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
     * @param array $params [
     *                      'order_by' => string,
     *                      'sort' => string,
     *                      'start' => int,
     *                      'limit' => int,
     *                      ]
     *
     * @return array
     */
    static function find(array $params): array
    {
        $db = DataBase::getInstance();
        $objs = [];

        $sql = "SELECT `" . static::getDbPk() . "` FROM `" . static::getDbTable() . "` WHERE 1 ";

        if ((isset($params['order_by']) && (in_array($params['order_by'], array_keys(static::$_all_fields))))) {
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
     * @return array
     * @throws Exception
     */
    static function findAll(): array
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
                $objs[] = static::getInstance($row);
            }

        } else {

            $sql = 'SELECT `' . static::getDbPk() . '` FROM `' . static::getDbTable() . '` ORDER BY `' . static::getDbPk() . '` ASC';
            if ($ids = $db->queryWithFetchFirstFields($sql)) {
                foreach ($ids as $id) {
                    $objs[] = static::getInstance($id);
                }
            }

        }

        return $objs;
    }

    /**
     *
     */
    function loadObjectId()
    {
        if (is_array(static::$_pk)) {
            $this->_object_id = get_called_class() . ':' . implode(':', array_values($this->getId())); // ex: WorldRegion:FR:96
        } else {
            $this->_object_id = get_called_class() . ':' . $this->getId(); // ex: Membre:1234
        }
    }

    /**
     *
     */
    static function resetAutoIncrement()
    {
        DataBase::getInstance()
            ->query("ALTER TABLE `" . static::getDbTable() . "` AUTO_INCREMENT = 1");
    }

    /**
     * Affichage d'info de debug sur l'objet
     *
     * @return string
     */
    function __toString(): string
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
    function delete()
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
    static function count(): int
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
     * @throws Exception
     */
    static function countMy(): int
    {
        if (empty($_SESSION['membre'])) {
            throw new Exception('non identifié');
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
    protected function _loadFromCache(): bool
    {
        if (($cachedData = ObjectCache::get($this->getObjectId())) !== null) {
            $this->_arrayToObject(unserialize($cachedData));
            return true;
        }
        return false;
    }

    /**
     * Charge toutes les infos d'une entité à partir de la base de données
     *
     * @return bool
     * @throws Exception
     */
    protected function _loadFromDb(): bool
    {
        $db = DataBase::getInstance();

        $sql = "SELECT * FROM `" . static::$_table . "` ";

        if (!is_array(static::$_pk)) {
            // clé primaire simple
            if (static::$_all_fields[static::$_pk] === 'int') {
                $sql .= "WHERE `" . static::$_pk . "` = " . (int) $this->{'_' . static::$_pk};
            } elseif (static::$_all_fields[static::$_pk] === 'string') {
                $sql .= "WHERE `" . static::$_pk . "` = '" . $this->{'_' . static::$_pk} . "'";
            }
        } else {
            // clé primaire multiple
            $sql .= "WHERE 1 ";
            foreach (static::$_pk as $pk) {
                if (static::$_all_fields[$pk] === 'int') {
                    $sql .= "AND `" . $pk . "` = " . (int) $this->{'_' . $pk} . " ";
                } elseif (static::$_all_fields[$pk] === 'string') {
                    $sql .= "AND `" . $pk . "` = '" . $this->{'_' . $pk} . "' ";
                }
            }
        }

        if ($res = $db->queryWithFetchFirstRow($sql)) {
            $this->_arrayToObject($res);
            return true;
        }
        return false;
    }

    /**
     * Conversion des champs issus de la db en propriétés typées de l'objet
     *
     * @param array $data data
     *
     * @return bool
     */
    protected function _arrayToObject(array $data)
    {
        $all_fields = static::_getAllFields(true);
        foreach ($data as $k => $v) {
            if (array_key_exists($k, $all_fields)) {
                $att = '_' . $k;
                if (is_null($v)) {
                    $this->$att = NULL;
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
     * @return array
     */
    protected function _objectToArray(): array
    {
        $arr = [];
        $all_fields = static::_getAllFields(true);

        foreach ($all_fields as $field => $type) {
            $att = '_' . $field;
            if (property_exists($this, $att)) {
                $arr[$field] = $this->$att;
            }
        }

        return $arr;
    }
}
