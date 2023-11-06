<?php

declare(strict_types=1);

namespace Adhoc\Model;

/**
 * Classe MembreAdhoc
 *
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class MembreAdhoc extends Membre
{
    /**
     * Instance de l'objet
     *
     * @var object
     */
    protected static $instance = null;

    /**
     * @var string|array<string>
     */
    protected static string|array $pk = 'id_contact';

    /**
     * @var string
     */
    protected static string $table = 'adhoc_membre_adhoc';

    /**
     * @var string
     */
    protected string $function = '';

    /**
     * @var string
     */
    protected string $birth_date = '';

    /**
     * @var bool
     */
    protected bool $active = false;

    /**
     * @var int
     */
    protected int $rank = 0;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
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
     * @var array<string<array<string,string>
     */
    protected $modified_fields = [
        'contact' => [],
        'membre' => [],
        'membre_adhoc' => [],
    ];

    /**
     * @return string
     */
    public static function getBaseUrl(): string
    {
        return MEDIA_URL . '/membre/ca';
    }

    /**
     * @return string
     */
    public static function getBasePath(): string
    {
        return MEDIA_PATH . '/membre/ca';
    }

    /**
     * @param bool $fusion fusion
     *
     * @return array
     */
    protected function getAllFields(bool $fusion = true): array
    {
        if ($fusion) {
            return array_merge(
                Contact::$all_fields,
                Membre::$all_fields,
                MembreAdhoc::$all_fields
            );
        } else {
            return array_merge(
                [
                    'contact' => Contact::$all_fields,
                    'membre' => Membre::$all_fields,
                    'membre_adhoc' => MembreAdhoc::$all_fields,
                ]
            );
        }
    }

    /* début getters */

    /**
     * @return string
     */
    public function getFunction(): string
    {
        return $this->function;
    }

    /**
     * @return string
     */
    public function getBirthDate(): string
    {
        return $this->birth_date;
    }

    /**
     * @return bool
     */
    public function getActive(): bool
    {
        return $this->active;
    }

    /**
     * @return int
     */
    public function getRank(): int
    {
        return $this->rank;
    }

    /* fin getters */

    /* début setters */

    /**
     * @param string $function function
     *
     * @return object
     */
    public function setFunction(string $function): object
    {
        if ($this->function !== $function) {
            $this->function = $function;
            $this->modified_fields['membre_adhoc']['function'] = true;
        }

        return $this;
    }

    /**
     * @param string $birth_date birth_date
     *
     * @return object
     */
    public function setBirthDate(string $birth_date): object
    {
        if ($this->birth_date !== $birth_date) {
            $this->birth_date = $birth_date;
            $this->modified_fields['membre_adhoc']['function'] = true;
        }

        return $this;
    }

    /**
     * @param bool $active active
     *
     * @return object
     */
    public function setActive(bool $active): object
    {
        if ($this->active !== $active) {
            $this->active = $active;
            $this->modified_fields['membre_adhoc']['active'] = true;
        }

        return $this;
    }

    /**
     * @param int $rank rang
     *
     * @return object
     */
    public function setRank(int $rank): object
    {
        if ($this->rank !== $rank) {
            $this->rank = $rank;
            $this->modified_fields['membre_adhoc']['rank'] = true;
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
    public static function getStaff(bool $active = true): array
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `m`.`id_contact` AS `id`, "
             . "`m`.`first_name`, `m`.`last_name`, `m`.`text`, "
             . "UNIX_TIMESTAMP(`m`.`modified_at`) AS `modified_at_ts`, "
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
                $mbrs[$idx]['avatar_interne'] = self::getBaseUrl() . '/' . $mbr['id'] . '.jpg?ts=' . $mbr['modified_at_ts'];
            }
            $mbrs[$idx]['url'] = HOME_URL . '/membres/' . $mbr['id'];
        }

        return $mbrs;
    }

    /**
     * Charge toutes les infos d'un membre adhoc/interne
     *
     * @todo récup champs spécifiques à membre_adhoc !
     *
     * @return bool
     * @throws \Exception
     */
    protected function loadFromDb(): bool
    {
        $db = DataBase::getInstance();

        $sql = "SELECT * "
             . "FROM `" . MembreAdhoc::getDbTable() . "`, `" . Membre::getDbTable() . "`, `" . Contact::getDbTable() . "` "
             . "WHERE `" . MembreAdhoc::getDbTable() . "`.`" . MembreAdhoc::getDbPk() . "` = `" . Membre::getDbTable() . "`.`" . Membre::getDbPk() . "` "
             . "AND `" . Membre::getDbTable() . "`.`" . Membre::getDbPk() . "` = `" . Contact::getDbTable() . "`.`" . Contact::getDbPk() . "` "
             . "AND `" . MembreAdhoc::getDbTable() . "`.`" . MembreAdhoc::getDbPk() . "` = " . (int) $this->getId();

        if ($res = $db->queryWithFetchFirstRow($sql)) {
            $this->arrayToObject($res);
            return true;
        }

        throw new \Exception('Membre Adhoc introuvable');
    }

    /**
     * Sauve en DB tables contact, membre et membre_adhoc
     */
    public function save()
    {
        $db = DataBase::getInstance();

        $fields = self::getAllFields(false);

        if (!$this->getId()) { // INSERT
            /* table contact */
            if ($id_contact = Contact::getIdByEmail($email)) { // BUG: D'OU SORT CE $email ???
                $this->setId($id_contact);
            } else {
                $sql = "INSERT INTO `" . Contact::getDbTable() . "` (";
                if (count($this->modified_fields['contact']) > 0) {
                    foreach ($fields['contact'] as $field => $type) {
                        $sql .= "`" . $field . "`,";
                    }
                    $sql = substr($sql, 0, -1);
                }
                $sql .= ") VALUES (";

                if (count($this->modified_fields['contact']) > 0) {
                    foreach ($fields['contact'] as $field => $type) {
                        $att = $field;
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
                                throw new \Exception('invalid field type : ' . $type);
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
                        throw new \Exception('invalid field type : ' . $type);
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
                        throw new \Exception('invalid field type : ' . $type);
                }
            }
            $sql = substr($sql, 0, -1);
            $sql .= ")";

            $db->query($sql);

            return $this->getId();
        } else { // UPDATE
            if (
                (count($this->modified_fields['contact']) === 0)
                && (count($this->modified_fields['membre']) === 0)
                && (count($this->modified_fields['membre_adhoc']) === 0)
            ) {
                return true; // pas de changement
            }

            /* table contact */

            if (count($this->modified_fields['contact']) > 0) {
                $fields_to_save = '';
                foreach ($this->modified_fields['contact'] as $field => $value) {
                    if ($value === true) {
                        $att = '_' . $field;
                        switch ($fields['contact'][$field]) {
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
                                throw new \Exception('invalid field type : ' . $fields['contact'][$field]);
                        }
                    }
                }
                $fields_to_save = substr($fields_to_save, 0, -1);

                $sql = "UPDATE `" . Contact::getDbTable() . "` "
                     . "SET " . $fields_to_save . " "
                     . "WHERE `id_contact` = " . (int) $this->contact;

                $this->modified_fields['contact'] = [];

                $db->query($sql);
            }

            /* table membre */

            if (count($this->modified_fields['membre']) > 0) {
                $fields_to_save = '';
                foreach ($this->modified_fields['membre'] as $field => $value) {
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
                                throw new \Exception('invalid field type : ' . $fields['membre'][$field]);
                        }
                    }
                }
                $fields_to_save = substr($fields_to_save, 0, -1);

                $sql = "UPDATE `" . Membre::getDbTable() . "` "
                     . "SET " . $fields_to_save . " "
                     . "WHERE `id_contact` = " . (int) $this->contact;

                $this->modified_fields['membre'] = [];

                $db->query($sql);
            }

            /* table membre_adhoc */

            if (count($this->modified_fields['membre_adhoc']) > 0) {
                $fields_to_save = '';
                foreach ($this->modified_fields['membre_adhoc'] as $field => $value) {
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
                                throw new \Exception('invalid field type : ' . $fields['membre_adhoc'][$field]);
                        }
                    }
                }
                $fields_to_save = substr($fields_to_save, 0, -1);

                $sql = "UPDATE `" . MembreAdhoc::getDbTable() . "` "
                     . "SET " . $fields_to_save . " "
                     . "WHERE `id_contact` = " . (int) $this->contact;

                $this->modified_fields['membre_adhoc'] = [];

                $db->query($sql);
            }

            return true;
        }
    }
}
