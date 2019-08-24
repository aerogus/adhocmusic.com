<?php

/**
 * Classe abstraite à étendre
 *
 * On regroupe ici les méthodes communes à tous les gros objets AD'HOC
 * qui ont comme caractéristiques principales:
 * - des méthodes d'accès/écriture des données
 *
 * @abstract
 *
 * @package adhoc
 * @author Guillaume Seznec <guillaume@seznec.fr>
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
    protected static $_db_table_featured       = 'adhoc_featured';
    protected static $_db_table_appartient_a   = 'adhoc_appartient_a';
    protected static $_db_table_article        = 'adhoc_article';
    protected static $_db_table_audio          = 'adhoc_audio';
    protected static $_db_table_contact        = 'adhoc_contact';
    protected static $_db_table_event          = 'adhoc_event';
    protected static $_db_table_event_style    = 'adhoc_event_style';
    protected static $_db_table_exposant       = 'adhoc_exposant';
    protected static $_db_table_faq            = 'adhoc_faq';
    protected static $_db_table_forums         = 'adhoc_forum_public_message';
    protected static $_db_table_groupe         = 'adhoc_groupe';
    protected static $_db_table_groupe_style   = 'adhoc_groupe_style';
    protected static $_db_table_lieu           = 'adhoc_lieu';
    protected static $_db_table_membre         = 'adhoc_membre';
    protected static $_db_table_membre_adhoc   = 'adhoc_membre_adhoc';
    protected static $_db_table_newsletter     = 'adhoc_newsletter';
    protected static $_db_table_organise_par   = 'adhoc_organise_par';
    protected static $_db_table_participe_a    = 'adhoc_participe_a';
    protected static $_db_table_messagerie     = 'adhoc_messagerie';
    protected static $_db_table_photo          = 'adhoc_photo';
    protected static $_db_table_statsnl        = 'adhoc_statsnl';
    protected static $_db_table_structure      = 'adhoc_structure';
    protected static $_db_table_video          = 'adhoc_video';

    /* db geo */
    protected static $_db_table_world_country  = 'geo_world_country';
    protected static $_db_table_world_region   = 'geo_world_region';
    protected static $_db_table_fr_departement = 'geo_fr_departement';
    protected static $_db_table_fr_city        = 'geo_fr_city';

    /**
     * codes type de médias
     */
    const TYPE_MEDIA_PHOTO = 0x01;
    const TYPE_MEDIA_AUDIO = 0x02;
    const TYPE_MEDIA_VIDEO = 0x11; // 0x04 ça serait mieux

    /**
     * @param bool
     *
     * @return array
     */
    protected function _getAllFields(bool $fusion = true)
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
     *
     */
    static function init()
    {
        return new static();
    }

    /**
     *
     */
    static function getInstance($id)
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
     *
     */
    static function deleteInstance()
    {
        if (isset(static::$_instance)) {
            static::$_instance = null;
            return true;
        }
        return false;
    }

    /**
     *
     */
    function getObjectId()
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
     */
    function setId($val)
    {
        $pk = '_' . static::$_pk;
        $this->$pk = $val;
    }

    /**
     *
     */
    function save()
    {
        $db = DataBase::getInstance();

        if (!$this->getId()) { // INSERT

            $sql = "INSERT INTO `" . static::$_table . "` (";
            foreach (static::$_all_fields as $field => $type) {
                $sql .= "`" . $field . "`,";
            }
            $sql = substr($sql, 0, -1);
            $sql .= ") VALUES (";

            foreach (static::$_all_fields as $field => $type) {
                $att = '_' . $field;
                switch ($type)
                {
                    case 'num':
                        $sql .= (int) $this->$att . ",";
                        break;
                    case 'float':
                        $sql .= number_format((float) $this->$att, 8, ".", "") . ",";
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
            $sql = substr($sql, 0, -1);
            $sql .= ")";

            $db->query($sql);

            $this->setId((int) $db->insertId());

            return $this->getId();

        } else { // UPDATE

            if (count($this->_modified_fields) == 0) {
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
     * @param array $data
     */
    protected function _dbToObject($data)
    {
        $all_fields = static::_getAllFields(true);
        foreach ($data as $k => $v) {
            if (array_key_exists($k, $all_fields)) {
                $att = '_' . $k;
                if ($all_fields[$k] === 'phpser') {
                    $this->$att = unserialize($v);
                } else {
                    $this->$att = $v;
                }
            }
        }
    }
}
