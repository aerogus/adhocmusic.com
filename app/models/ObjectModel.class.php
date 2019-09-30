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
     * Champ clé primaire de l'objet fils
     * @var string
     */
    protected static $_pk = '';

    /**
     * table de la bdd utilisée par l'objet
     * @var string
     */
    protected static $_table = '';

    /**
     * Identifiant unique d'objet
     * @var string
     */
    protected $_object_id = '';

    /**
     * Liste des attributs de l'objet
     * on précise si en base c'est de type :
     * - numérique/integer/float/bool (= int)
     * - datetime/text (= str)
     * ceci est utile pour la formation de la requête
     * le tableau est défini dans les classes filles
     * @var array
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
    protected static $_db_table_statsnl        = 'adhoc_statsnl';

    /* db geo */
    protected static $_db_table_world_country  = 'geo_world_country';
    protected static $_db_table_world_region   = 'geo_world_region';
    protected static $_db_table_fr_departement = 'geo_fr_departement';
    protected static $_db_table_fr_city        = 'geo_fr_city';

    /**
     * Codes type de médias
     */
    const TYPE_MEDIA_PHOTO = 0x01;
    const TYPE_MEDIA_AUDIO = 0x02;
    const TYPE_MEDIA_VIDEO = 0x11; // 0x04 ça serait mieux

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
     *
     */
    function __construct($id = null)
    {
        if (!is_null($id)) {
            $this->_object_id = md5(get_called_class() . '|' . $id);
            $pk = '_' . static::$_pk;
            $this->$pk = $id;
            $this->_loadFromDb();
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
     * @return object
     */
    static function init(): object
    {
        return new static();
    }

    /**
     * @return object
     */
    static function getInstance($id): object
    {
        if (is_null(static::$_instance)) {
            // pas du tout d'instance: on en crée une, le constructeur ira s'enregistrer
            // dans la variable statique.
            return new static($id);
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
     * @return string
     */
    function getObjectId(): string
    {
        return $this->_object_id;
    }

    /**
     * @return int ou string
     */
    function getId()
    {
        $pk = '_' . static::$_pk;
        return $this->$pk;
    }

    /**
     * @var mixed
     *
     * @return object
     */
    function setId($val)
    {
        $pk = '_' . static::$_pk;
        $this->$pk = $val;

        return $this;
    }

    /**
     *
     */
    function save()
    {
        $db = DataBase::getInstance();

        if (!$this->getId()) { // INSERT

            $sql = "INSERT INTO `" . static::$_table . "` (";

            if (count($this->_modified_fields) > 0) {
                foreach ($this->_modified_fields as $field => $value) {
                    if ($value === true) {
                        $sql .= "`" . $field . "`,";
                    }
                }
                $sql = substr($sql, 0, -1);
            }
            $sql .= ") VALUES (";

            if (count($this->_modified_fields) > 0) {
                foreach ($this->_modified_fields as $field => $value) {
                    if ($value === true) {
                        $att = '_' . $field;
                        switch (static::$_all_fields[$field]) {
                            case 'num':
                                $sql .= (int) $this->$att . ',';
                                break;
                            case 'float':
                                $sql .= number_format((float) $this->$att, 8, '.', '') . ',';
                                break;
                            case 'str':
                                $sql .= "'" . $db->escape($this->$att) . "',";
                                break;
                            case 'date':
                                $sql .= (is_null($this->$att) ? 'NULL' : "'" . $db->escape($this->$att) . "'") . ",";
                                break;
                            case 'bool':
                                $sql .= ((bool) $this->$att ? 'TRUE' : 'FALSE') . ",";
                                break;
                            case 'pwd':
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

            $sql .= ")";

            $db->query($sql);

            $this->setId((int) $db->insertId());

            return $this->getId();

        } else { // UPDATE

            if (count($this->_modified_fields) === 0) {
                return true;
            }

            $fields_to_save = '';
            foreach ($this->_modified_fields as $field => $value) {
                if ($value === true) {
                    $att = '_'.$field;
                    switch (static::$_all_fields[$field])
                    {
                        case 'num':
                            $fields_to_save .= " `" . $field . "` = " . (int) $this->$att . ",";
                            break;
                        case 'float':
                            $fields_to_save .= " `" . $field . "` = " . number_format((float) $this->$att, 8, ".", "") . ",";
                            break;
                        case 'str':
                            $fields_to_save .= " `" . $field . "` = '" . $db->escape($this->$att) . "',";
                            break;
                        case 'date':
                            $fields_to_save .= "`" . $field . "` = " . (is_null($this->$att) ? 'NULL' : "'" . $db->escape($this->$att) . "'") . ",";
                            break;
                        case 'bool':
                            $fields_to_save .= " `" . $field . "` = " . (((bool) $this->$att) ? 'TRUE' : 'FALSE') . ",";
                            break;
                        case 'pwd':
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

            $sql = "UPDATE `" . static::$_table . "` "
                 . "SET " . $fields_to_save . " "
                 . "WHERE `" . static::$_pk . "` = " . (int) $this->getId();

            $this->_modified_fields = [];

            $db->query($sql);

            return true;
        }
    }

    /**
     * Retourne une collection d'instances
     *
     * @return array
     */
    static function findAll(): array
    {
        $db = DataBase::getInstance();
        $sql = "SELECT `" . static::$_pk . "` FROM `" . static::$_table . "`";

        $objs = [];
        if ($ids = $db->queryWithFetchFirstFields($sql)) {
            foreach ($ids as $id) {
                $objs[] = static::getInstance($id);
            }
        }

        return $objs;
    }

    /**
     * Efface l'enregistrement dans la table relative à l'objet
     *
     * @return bool
     */
    function delete()
    {
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . static::$_table . "` "
             . "WHERE `" . static::$_pk . "` = " . (int) $this->getId();

        $db->query($sql);

        if ($db->affectedRows()) {
            return true;
        }
        return false;
    }

    /**
     * Charge toutes les infos d'une entité
     *
     * @return bool
     * @throws Exception
     */
    protected function _loadFromDb(): bool
    {
        $db = DataBase::getInstance();

        $sql  = "SELECT * FROM `" . static::$_table . "` WHERE `" . static::$_pk . "` = " . (int) $this->{'_' . static::$_pk};

        if ($res = $db->queryWithFetchFirstRow($sql)) {
            $this->_dbToObject($res);
            return true;
        }
        return false;
    }

    /**
     * @param array $data data
     */
    protected function _dbToObject(array $data)
    {
        $all_fields = static::_getAllFields(true);
        foreach ($data as $k => $v) {
            if (array_key_exists($k, $all_fields)) {
                $att = '_' . $k;
                switch ($all_fields[$k]) {
                    case 'phpser':
                        $this->$att = unserialize($v);
                        break;
                    case 'num':
                        $this->$att = (int) $v;
                        break;
                    case 'float':
                        $this->$att = (float) $v;
                        break;
                    case 'bool':
                        $this->$att = (bool) $v;
                        break;
                    case 'str':
                        $this->$att = (string) $v;
                        break;
                    case 'date':
                    default:
                        $this->$att = $v;
                }
            }
        }
    }
}
