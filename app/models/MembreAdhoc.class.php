<?php

/**
 * @package adhoc
 */

/**
 * Classe MembreAdhoc
 *
 * @package adhoc
 * @author Guillaume Seznec <guillaume.seznec@gmail.com>
 */
class MembreAdhoc extends Membre
{
    /**
     * @var mixed
     */
    protected static $_instance = null;

    /**
     * @var string
     */
    protected static $_pk = 'id_contact';

    /**
     * @var string
     */
    protected static $_table = 'adhoc_membre_adhoc';

    /**
     * @var string
     */
    protected $_function = '';

    /**
     * @var string
     */
    protected $_birth_date = '';

    /**
     * @var bool
     */
    protected $_active = 0;

    /**
     * @var int
     */
    protected $_rank = 0;

    /**
     * @var string
     */
    protected $_official_pseudo = '';

    /**
     * @var string
     */
    protected $_description = '';

    /**
     * Liste des attributs de l'objet
     * on précise si en base c'est de type :
     * - numérique/integer/float/bool (= int)
     * - datetime/text (= str)
     * ceci est utile pour la formation de la requête
     * @var array
     */
    protected static $_all_fields = array(
        'function'        => 'str',
        'birth_date'      => 'date',
        'active'          => 'bool',
        'rank'            => 'num',
        'official_pseudo' => 'str',
        'description'     => 'str',
    );

    /**
     * Tableau des attributs modifiés depuis la dernière sauvegarde.
     *
     * Pour chaque attribut modifié, on a un élément de la forme 'attribut => true'.
     * @var array
     */
    protected $_modified_fields = array(
        'contact' => array(),
        'membre' => array(),
        'membre_adhoc' => array(),
    );

    /**
     * @return string
     */
    static function getBaseUrl()
    {
        return MEDIA_URL . '/membre/ca';
    }

    /**
     * @return string
     */
    static function getBasePath()
    {
        return MEDIA_PATH . '/membre/ca';
    }

    /**
     * @param bool
     * @return array
     */
    protected function _getAllFields($fusion = true)
    {
        if ($fusion) {
            return array_merge(
                Contact::$_all_fields,
                Membre::$_all_fields,
                MembreAdhoc::$_all_fields
            );
        } else {
            return array_merge(array(
                'contact' => Contact::$_all_fields,
                'membre' => Membre::$_all_fields,
                'membre_adhoc' => MembreAdhoc::$_all_fields,
            ));
        }
    }

    /* début getters */

    /**
     * @return string
     */
    function getFunction()
    {
        return (string) $this->_function;
    }

    /**
     * @return string
     */
    function getBirthDate()
    {
        return (string) $this->_birth_date;
    }

    /**
     * @return bool
     */
    function getActive()
    {
        return (bool) $this->_active;
    }

    /**
     * @return int
     */
    function getRank()
    {
        return (int) $this->_rank;
    }

    /**
     * @return string
     */
    function getOfficialPseudo()
    {
        return (string) $this->_official_pseudo;
    }

    /**
     * @return string
     */
    function getDescription()
    {
        return (string) $this->_description;
    }

    /* fin getters */

    /* début setters */

    /**
     * @param string
     */
    function setFunction($val)
    {
        if ($this->_function !== $val)
        {
            $this->_function = (string) $val;
            $this->_modified_fields['membre_adhoc']['function'] = true;
        }
    }

    /**
     * @param string
     */
    function setBirthDate($val)
    {
        if ($this->_birth_date !== $val)
        {
            $this->_birth_date = (string) $val;
            $this->_modified_fields['membre_adhoc']['function'] = true;
        }
    }

    /**
     * @param bool
     */
    function setActive($val)
    {
        if ($this->_active !== $val)
        {
            $this->_active = (bool) $val;
            $this->_modified_fields['membre_adhoc']['active'] = true;
        }
    }

    /**
     * @param int
     */
    function setRank($val)
    {
        if ($this->_rank !== $val)
        {
            $this->_rank = (int) $val;
            $this->_modified_fields['membre_adhoc']['rank'] = true;
        }
    }

    /**
     * @param string
     */
    function setOfficialPseudo($val)
    {
        if ($this->_official_pseudo !== $val)
        {
            $this->_official_pseudo = (string) $val;
            $this->_modified_fields['membre_adhoc']['official_pseudo'] = true;
        }
    }

    /**
     * @param string
     */
    function setDescription($val)
    {
        if ($this->_description !== $val)
        {
            $this->_description = (string) $val;
            $this->_modified_fields['membre_adhoc']['description'] = true;
        }
    }

    /* fin setters */

    /**
     * retourne les données des membres internes
     *
     * @return array
     */
    static function getStaff($active = true)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `m`.`id_contact` AS `id`, `ma`.`official_pseudo`, "
             . "`m`.`first_name`, `m`.`last_name`, `m`.`text`, "
             . "UNIX_TIMESTAMP(`m`.`modified_on`) AS `modified_on_ts`, "
             . "`ma`.`function`, `ma`.`description`, `ma`.`datdeb`, `ma`.`datfin`, "
             . "(YEAR(CURRENT_DATE) - YEAR(`ma`.`birth_date`)) - (RIGHT(CURRENT_DATE,5) < RIGHT(`ma`.`birth_date`, 5)) AS `age` "
             . "FROM `" . self::$_db_table_membre . "` `m`, `" . self::$_db_table_membre_adhoc . "` `ma` "
             . "WHERE `m`.`id_contact` = `ma`.`id_contact` ";
        if ($active) {
             $sql .= "AND `ma`.`active` = TRUE ";
        } else {
             $sql .= "AND `ma`.`active` = FALSE ";
        }
        $sql .= "ORDER BY `ma`.`rank` ASC, `ma`.`datfin` DESC";

        $mbrs = $db->queryWithFetch($sql);

        foreach ($mbrs as $idx => $mbr)
        {
            $mbrs[$idx]['avatar_interne'] = false;
            if (file_exists(self::getBasePath() . '/' . $mbr['id'] . '.jpg')) {
                $mbrs[$idx]['avatar_interne'] = self::getBaseUrl() . '/' . $mbr['id'] . '.jpg?ts=' . $mbr['modified_on_ts'];
            }
            $mbrs[$idx]['url'] = self::getUrlById($mbr['id']);
        }

        return $mbrs;
    }

    /**
     * charge toutes les infos d'un membre adhoc/interne
     * @todo récup champs spécifiques à membre_adhoc !
     * @return bool
     */
    protected function _loadFromDb()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `c`.`email`, `m`.`pseudo`, "
             . "`m`.`password`, `m`.`last_name`, `m`.`first_name`, "
             . "`m`.`site`, `m`.`text`, `m`.`created_on`, "
             . "`m`.`modified_on`, `m`.`visited_on`, "
             . "`m`.`address`, `m`.`cp`, `m`.`city`, "
             . "`m`.`country`, `m`.`facebook_uid`, "
             . "`m`.`tel`, `m`.`port`, "
             . "`m`.`mailing`, `c`.`lastnl` "
             . "FROM `" . self::$_db_table_contact . "` `c`, `" . self::$_db_table_membre . "` `m` "
             . "WHERE `m`.`id_contact` = `c`.`id_contact` "
             . "AND `m`.`id_contact` = " . (int) $this->_id_contact;

        if ($res = $db->queryWithFetchFirstRow($sql)) {
            $this->_dbToObject($res);
            return true;
        }

        throw new Exception('Membre Adhoc introuvable');
    }

    /**
     * sauve en DB tables contact, membre et membre_adhoc
     */
    function save()
    {
        $db = DataBase::getInstance();

        $fields = self::_getAllFields(false);

        if (!$this->getId()) // INSERT
        {
            /* table contact */

            if ($id_contact = Contact::getIdByEmail($email)) {

                $this->setId($id_contact);

            } else {

            $sql = "INSERT INTO `" . static::$_db_table_contact . "` (";
            foreach ($fields['contact'] as $field => $type) {
                $sql .= "`" . $field . "`,";
            }
            $sql = substr($sql, 0, -1);
            $sql .= ") VALUES (";

            foreach($fields['contact'] as $field => $type) {
                $att = '_' . $field;
                switch($type)
                {
                    case 'num':
                        $sql .= $db->escape($this->$att) . ",";
                        break;
                    case 'str':
                        $sql .= "'" . $db->escape($this->$att) . "',";
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
                        throw new Exception('invalid field type : ' . $type);
                        break;
                }
            }
            $sql = substr($sql, 0, -1);
            $sql .= ")";

            $db->query($sql);

            $this->setId((int) $db->insertId());

            }

            /* table membre */

            $sql = "INSERT INTO `" . static::$_db_table_membre . "` (";
            $sql .= "`id_contact`,";
            foreach($fields['membre'] as $field => $type) {
                $sql .= "`" . $field . "`,";
            }
            $sql = substr($sql, 0, -1);
            $sql .= ") VALUES (";
            $sql .= (int) $this->getId() . ",";

            foreach($fields['membre'] as $field => $type) {
                $att = '_' . $field;
                switch($type)
                {
                    case 'num':
                        $sql .= $db->escape($this->$att) . ",";
                        break;
                    case 'str':
                        $sql .= "'" . $db->escape($this->$att) . "',";
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
                        throw new Exception('invalid field type : ' . $type);
                        break;
                }
            }
            $sql = substr($sql, 0, -1);
            $sql .= ")";

            $db->query($sql);

            /* table membre_adhoc */

            $sql = "INSERT INTO `" . static::$_db_table_membre_adhoc . "` (";
            $sql .= "`id_contact`,";
            foreach($fields['membre_adhoc'] as $field => $type) {
                $sql .= "`" . $field . "`,";
            }
            $sql = substr($sql, 0, -1);
            $sql .= ") VALUES (";
            $sql .= (int) $this->getId() . ",";

            foreach($fields['membre_adhoc'] as $field => $type) {
                $att = '_' . $field;
                switch($type)
                {
                    case 'num':
                        $sql .= $db->escape($this->$att) . ",";
                        break;
                    case 'str':
                        $sql .= "'" . $db->escape($this->$att) . "',";
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
                        throw new Exception('invalid field type : ' . $type);
                        break;
                }
            }
            $sql = substr($sql, 0, -1);
            $sql .= ")";

            $db->query($sql);

            return $this->getId();
        }
        else // UPDATE
        {
            if ((count($this->_modified_fields['contact']) === 0)
             && (count($this->_modified_fields['membre']) === 0)
             && (count($this->_modified_fields['membre_adhoc']) === 0)) {
                return true; // pas de changement
            }

            /* table contact */

            if (count($this->_modified_fields['contact']) > 0) {

                $fields_to_save = '';
                foreach ($this->_modified_fields['contact'] as $field => $value) {
                    if ($value === true) {
                        $att = '_' . $field;
                        switch ($fields['contact'][$field])
                        {
                            case 'num':
                                $fields_to_save .= " `" . $field."` = " . $db->escape($this->$att) . ",";
                                break;
                            case 'str':
                                $fields_to_save .= " `" . $field . "` = '" . $db->escape($this->$att) . "',";
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
                            case 'date':
                                $fields_to_save .= "`" . $field . "` = " . (is_null($this->$att) ? 'NULL' : "'" . $db->escape($this->$att) . "'") . ",";
                                break;
                            default:
                                throw new Exception('invalid field type : ' . $fields['contact'][$field]);
                                break;
                        }
                    }
                }
                $fields_to_save = substr($fields_to_save, 0, -1);

                $sql = "UPDATE `" . self::$_db_table_contact . "` "
                     . "SET " . $fields_to_save . " "
                     . "WHERE `id_contact` = " . (int) $this->_id_contact;

                $this->_modified_fields['contact'] = [];

                $db->query($sql);

            }

            /* table membre */

            if (count($this->_modified_fields['membre']) > 0) {

                $fields_to_save = '';
                foreach ($this->_modified_fields['membre'] as $field => $value) {
                    if ($value === true) {
                        $att = '_' . $field;
                        switch ($fields['membre'][$field])
                        {
                            case 'num':
                                $fields_to_save .= " `" . $field . "` = " . $db->escape($this->$att) . ",";
                                break;
                            case 'str':
                                $fields_to_save .= " `" . $field . "` = '" . $db->escape($this->$att) . "',";
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
                            case 'date':
                                $fields_to_save .= "`" . $field . "` = " . (is_null($this->$att) ? 'NULL' : "'" . $db->escape($this->$att) . "'") . ",";
                                break;
                            default:
                                throw new Exception('invalid field type : ' . $fields['membre'][$field]);
                                break;
                        }
                    }
                }
                $fields_to_save = substr($fields_to_save, 0, -1);

                $sql = "UPDATE `".self::$_db_table_membre."` "
                     . "SET " . $fields_to_save . " "
                     . "WHERE `id_contact` = " . (int) $this->_id_contact;

                $this->_modified_fields['membre'] = array();

                $db->query($sql);

            }

            /* table membre_adhoc */

            if (count($this->_modified_fields['membre_adhoc']) > 0) {

                $fields_to_save = '';
                foreach ($this->_modified_fields['membre_adhoc'] as $field => $value) {
                    if ($value === true) {
                        $att = '_' . $field;
                        switch ($fields['membre_adhoc'][$field])
                        {
                            case 'num':
                                $fields_to_save .= " `" . $field . "` = " . $db->escape($this->$att) . ",";
                                break;
                            case 'str':
                                $fields_to_save .= " `" . $field . "` = '" . $db->escape($this->$att) . "',";
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
                            case 'date':
                                $fields_to_save .= "`" . $field . "` = " . (is_null($this->$att) ? 'NULL' : "'" . $db->escape($this->$att) . "'") . ",";
                                break;
                            default:
                                throw new Exception('invalid field type : ' . $fields['membre_adhoc'][$field]);
                                break;
                        }
                    }
                }
                $fields_to_save = substr($fields_to_save, 0, -1);

                $sql = "UPDATE `" . self::$_db_table_membre_adhoc . "` "
                     . "SET " . $fields_to_save . " "
                     . "WHERE `id_contact` = " . (int) $this->_id_contact;

                $this->_modified_fields['membre_adhoc'] = [];

                $db->query($sql);

            }

            return true;
        }
    }
}
