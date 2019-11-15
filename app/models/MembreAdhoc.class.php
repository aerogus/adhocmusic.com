<?php declare(strict_types=1);

/**
 * Classe MembreAdhoc
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class MembreAdhoc extends Membre
{
    /**
     * Instance de l'objet
     *
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
    protected $_active = false;

    /**
     * @var int
     */
    protected $_rank = 0;

    /**
     * Liste des attributs de l'objet
     *
     * @var array
     */
    protected static $_all_fields = [
        'id_contact' => 'int', // pk
        'function'   => 'string',
        'birth_date' => 'date',
        'active'     => 'bool',
        'rank'       => 'int',
    ];

    /**
     * Tableau des attributs modifiés depuis la dernière sauvegarde.
     *
     * Pour chaque attribut modifié, on a un élément de la forme 'attribut => true'.
     *
     * @var array
     */
    protected $_modified_fields = [
        'contact' => [],
        'membre' => [],
        'membre_adhoc' => [],
    ];

    /**
     * @return string
     */
    static function getBaseUrl(): string
    {
        return MEDIA_URL . '/membre/ca';
    }

    /**
     * @return string
     */
    static function getBasePath(): string
    {
        return MEDIA_PATH . '/membre/ca';
    }

    /**
     * @param bool $fusion fusion
     *
     * @return array
     */
    protected function _getAllFields(bool $fusion = true): array
    {
        if ($fusion) {
            return array_merge(
                Contact::$_all_fields,
                Membre::$_all_fields,
                MembreAdhoc::$_all_fields
            );
        } else {
            return array_merge(
                [
                    'contact' => Contact::$_all_fields,
                    'membre' => Membre::$_all_fields,
                    'membre_adhoc' => MembreAdhoc::$_all_fields,
                ]
            );
        }
    }

    /* début getters */

    /**
     * @return string
     */
    function getFunction(): string
    {
        return $this->_function;
    }

    /**
     * @return string
     */
    function getBirthDate(): string
    {
        return $this->_birth_date;
    }

    /**
     * @return bool
     */
    function getActive(): bool
    {
        return $this->_active;
    }

    /**
     * @return int
     */
    function getRank(): int
    {
        return $this->_rank;
    }

    /* fin getters */

    /* début setters */

    /**
     * @param string $function function
     *
     * @return object
     */
    function setFunction(string $function): object
    {
        if ($this->_function !== $function) {
            $this->_function = $function;
            $this->_modified_fields['membre_adhoc']['function'] = true;
        }

        return $this;
    }

    /**
     * @param string $birth_date birth_date
     *
     * @return object
     */
    function setBirthDate(string $birth_date): object
    {
        if ($this->_birth_date !== $birth_date) {
            $this->_birth_date = $birth_date;
            $this->_modified_fields['membre_adhoc']['function'] = true;
        }

        return $this;
    }

    /**
     * @param bool $active active
     *
     * @return object
     */
    function setActive(bool $active): object
    {
        if ($this->_active !== $active) {
            $this->_active = $active;
            $this->_modified_fields['membre_adhoc']['active'] = true;
        }

        return $this;
    }

    /**
     * @param int $rank rang
     *
     * @return object
     */
    function setRank(int $rank): object
    {
        if ($this->_rank !== $rank) {
            $this->_rank = $rank;
            $this->_modified_fields['membre_adhoc']['rank'] = true;
        }

        return $this;
    }

    /* fin setters */

    /**
     * Retourne les données des membres internes
     *
     * @param bool $active membre actif ?
     *
     * @return array
     */
    static function getStaff(bool $active = true): array
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `m`.`id_contact` AS `id`, "
             . "`m`.`first_name`, `m`.`last_name`, `m`.`text`, "
             . "UNIX_TIMESTAMP(`m`.`modified_on`) AS `modified_on_ts`, "
             . "`ma`.`function`, `ma`.`datdeb`, `ma`.`datfin`, "
             . "(YEAR(CURRENT_DATE) - YEAR(`ma`.`birth_date`)) - (RIGHT(CURRENT_DATE,5) < RIGHT(`ma`.`birth_date`, 5)) AS `age` "
             . "FROM `" . Membre::getDbTable() . "` `m`, `" . MembreAdhoc::getDbTable() . "` `ma` "
             . "WHERE `m`.`id_contact` = `ma`.`id_contact` ";
        if ($active) {
             $sql .= "AND `ma`.`active` = TRUE ";
        } else {
             $sql .= "AND `ma`.`active` = FALSE ";
        }
        $sql .= "ORDER BY `ma`.`rank` ASC, `ma`.`datfin` DESC";

        $mbrs = $db->queryWithFetch($sql);

        foreach ($mbrs as $idx => $mbr) {
            $mbrs[$idx]['avatar_interne'] = false;
            if (file_exists(self::getBasePath() . '/' . $mbr['id'] . '.jpg')) {
                $mbrs[$idx]['avatar_interne'] = self::getBaseUrl() . '/' . $mbr['id'] . '.jpg?ts=' . $mbr['modified_on_ts'];
            }
            $mbrs[$idx]['url'] = self::getUrlById((int) $mbr['id']);
        }

        return $mbrs;
    }

    /**
     * Charge toutes les infos d'un membre adhoc/interne
     *
     * @todo récup champs spécifiques à membre_adhoc !
     *
     * @return bool
     * @throws Exception
     */
    protected function _loadFromDb(): bool
    {
        $db = DataBase::getInstance();

        $sql = "SELECT * "
             . "FROM `" . MembreAdhoc::getDbTable() . "`, `" . Membre::getDbTable() . "`, `". Contact::getDbTable() . "` "
             . "WHERE `" . MembreAdhoc::getDbTable() . "`.`" . MembreAdhoc::getDbPk() . "` = `" . Membre::getDbTable() . "`.`" . Membre::getDbPk() . "` "
             . "AND `" . Membre::getDbTable() . "`.`" . Membre::getDbPk() . "` = `" . Contact::getDbTable() . "`.`" . Contact::getDbPk() . "` "
             . "AND `" . MembreAdhoc::getDbTable() . "`.`" . MembreAdhoc::getDbPk() . "` = " . (int) $this->{'_' . MembreAdhoc::getDbPk()};

        if ($res = $db->queryWithFetchFirstRow($sql)) {
            $this->_arrayToObject($res);
            return true;
        }

        throw new Exception('Membre Adhoc introuvable');
    }

    /**
     * Sauve en DB tables contact, membre et membre_adhoc
     */
    function save()
    {
        $db = DataBase::getInstance();

        $fields = self::_getAllFields(false);

        if (!$this->getId()) { // INSERT

            /* table contact */

            if ($id_contact = Contact::getIdByEmail($email)) {

                $this->setId($id_contact);

            } else {

                $sql = "INSERT INTO `" . Contact::getDbTable() . "` (";
                if (count($this->_modified_fields['contact']) > 0) {
                    foreach ($fields['contact'] as $field => $type) {
                        $sql .= "`" . $field . "`,";
                    }
                    $sql = substr($sql, 0, -1);
                }
                $sql .= ") VALUES (";

                if (count($this->_modified_fields['contact']) > 0) {
                    foreach ($fields['contact'] as $field => $type) {
                        $att = '_' . $field;
                        switch ($type) {
                            case 'int':
                            case 'float':
                                $sql .= $db->escape($this->$att) . ",";
                                break;
                            case 'string':
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
                                throw new Exception('invalid field type : ' . $type);
                                break;
                        }
                    }
                    $sql = substr($sql, 0, -1);
                }
                $sql .= ")";

                $db->query($sql);

                $this->setId((int) $db->insertId());

            }

            /* table membre */

            $sql = "INSERT INTO `" . Membre::getDbTable() . "` (";
            $sql .= "`id_contact`,";
            foreach ($fields['membre'] as $field => $type) {
                $sql .= "`" . $field . "`,";
            }
            $sql = substr($sql, 0, -1);
            $sql .= ") VALUES (";
            $sql .= (int) $this->getId() . ",";

            foreach ($fields['membre'] as $field => $type) {
                $att = '_' . $field;
                switch ($type) {
                    case 'int':
                    case 'float':
                        $sql .= $db->escape($this->$att) . ",";
                        break;
                    case 'string':
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
                        throw new Exception('invalid field type : ' . $type);
                        break;
                }
            }
            $sql = substr($sql, 0, -1);
            $sql .= ")";

            $db->query($sql);

            /* table membre_adhoc */

            $sql = "INSERT INTO `" . MembreAdhoc::getDbTable() . "` (";
            $sql .= "`id_contact`,";
            foreach ($fields['membre_adhoc'] as $field => $type) {
                $sql .= "`" . $field . "`,";
            }
            $sql = substr($sql, 0, -1);
            $sql .= ") VALUES (";
            $sql .= (int) $this->getId() . ",";

            foreach ($fields['membre_adhoc'] as $field => $type) {
                $att = '_' . $field;
                switch ($type) {
                    case 'int':
                    case 'float':
                        $sql .= $db->escape($this->$att) . ",";
                        break;
                    case 'string':
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
                        throw new Exception('invalid field type : ' . $type);
                        break;
                }
            }
            $sql = substr($sql, 0, -1);
            $sql .= ")";

            $db->query($sql);

            return $this->getId();

        } else { // UPDATE

            if ((count($this->_modified_fields['contact']) === 0)
                && (count($this->_modified_fields['membre']) === 0)
                && (count($this->_modified_fields['membre_adhoc']) === 0)
            ) {
                return true; // pas de changement
            }

            /* table contact */

            if (count($this->_modified_fields['contact']) > 0) {

                $fields_to_save = '';
                foreach ($this->_modified_fields['contact'] as $field => $value) {
                    if ($value === true) {
                        $att = '_' . $field;
                        switch ($fields['contact'][$field]) {
                            case 'int':
                            case 'float':
                                $fields_to_save .= " `" . $field."` = " . $db->escape($this->$att) . ",";
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
                                throw new Exception('invalid field type : ' . $fields['contact'][$field]);
                                break;
                        }
                    }
                }
                $fields_to_save = substr($fields_to_save, 0, -1);

                $sql = "UPDATE `" . Contact::getDbTable() . "` "
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
                        switch ($fields['membre'][$field]) {
                            case 'int':
                            case 'float':
                                $fields_to_save .= " `" . $field . "` = " . $db->escape($this->$att) . ",";
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
                                throw new Exception('invalid field type : ' . $fields['membre'][$field]);
                                break;
                        }
                    }
                }
                $fields_to_save = substr($fields_to_save, 0, -1);

                $sql = "UPDATE `".Membre::getDbTable()."` "
                     . "SET " . $fields_to_save . " "
                     . "WHERE `id_contact` = " . (int) $this->_id_contact;

                $this->_modified_fields['membre'] = [];

                $db->query($sql);

            }

            /* table membre_adhoc */

            if (count($this->_modified_fields['membre_adhoc']) > 0) {

                $fields_to_save = '';
                foreach ($this->_modified_fields['membre_adhoc'] as $field => $value) {
                    if ($value === true) {
                        $att = '_' . $field;
                        switch ($fields['membre_adhoc'][$field]) {
                            case 'int':
                            case 'float':
                                $fields_to_save .= " `" . $field . "` = " . $db->escape($this->$att) . ",";
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
                                throw new Exception('invalid field type : ' . $fields['membre_adhoc'][$field]);
                                break;
                        }
                    }
                }
                $fields_to_save = substr($fields_to_save, 0, -1);

                $sql = "UPDATE `" . MembreAdhoc::getDbTable() . "` "
                     . "SET " . $fields_to_save . " "
                     . "WHERE `id_contact` = " . (int) $this->_id_contact;

                $this->_modified_fields['membre_adhoc'] = [];

                $db->query($sql);

            }

            return true;
        }
    }
}
