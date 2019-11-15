<?php declare(strict_types=1);

/**
 * Classe Contact
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Contact extends ObjectModel
{
    /**
     * Instance de l'objet
     *
     * @var object
     */
    protected static $_instance = null;

    /**
     * @var string
     */
    protected static $_pk = 'id_contact';

    /**
     * @var string
     */
    protected static $_table = 'adhoc_contact';

    /**
     * @var int
     */
    protected $_id_contact = null;

    /**
     * @var string
     */
    protected $_email = null;

    /**
     * @var string
     */
    protected $_lastnl = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array
     */
    protected static $_all_fields = [
        'id_contact' => 'int', // pk
        'email'      => 'string',
        'lastnl'     => 'date',
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
    ];

    /**
     * @param bool $fusion fusion
     *
     * @return array
     */
    protected function _getAllFields(bool $fusion = true): array
    {
        if ($fusion) {
            return self::$_all_fields;
        } else {
            return [
                'contact' => self::$_all_fields,
            ];
        }
    }

    /* début getters */

    /**
     * @return int|null
     */
    function getIdContact(): ?int
    {
        return $this->_id_contact;
    }

    /**
     * @return string|null
     */
    function getEmail(): ?string
    {
        return $this->_email;
    }

    /**
     * Extraction de l'email à partir de l'id
     *
     * @param int $id_contact id_contact
     *
     * @return string|null
     */
    static function getEmailById(int $id_contact)
    {
        $db = DataBase::getInstance();

        $sql = sprintf(
            'SELECT `email` FROM `%s` WHERE `id_contact` = %d',
            Contact::getDbTable(),
            $id_contact
        );

        return $db->queryWithFetchFirstField($sql);
    }

    /**
     * Retourne la date de la dernière consultation d'une newsletter
     * (si tracker activé)
     *
     * @return string|null
     */
    function getLastnl(): ?string
    {
        return $this->_lastnl;
    }

    /**
     * Extraction de l'id_contact a partir de l'email (celui-ci étant unique)
     * sinon si email null, retourne un tableau des id_contact avec email null
     *
     * @param string $email email
     *
     * @return int
     * @throws Exception
     */
    static function getIdByEmail(string $email): int
    {
        if (!Email::validate($email)) {
            throw new Exception('email syntaxiquement incorrect');
        }

        $db = DataBase::getInstance();

        $sql = "SELECT `id_contact` "
             . "FROM `" . Contact::getDbTable() . "` "
             ." WHERE `email` = '" . $db->escape($email) . "'";

        return (int) $db->queryWithFetchFirstField($sql);
    }

    /**
     * Email déjà présent ?
     * @todo pourquoi pas dans classe Contact ?
     * @param string $email
     * @return bool
     * @deprecated doublon avec getIdByEmail
     */
     static function isEmailFound(string $email): bool
     {
         $db = DataBase::getInstance();

         $sql = "SELECT `id_contact` "
              . "FROM `" . Contact::getDbTable() . "` "
              . "WHERE `email` = '" . $db->escape($email) . "'";

         $res = $db->query($sql);

         return (bool) $db->numRows($res);
    }

    /* fin getters */

    /* début setters*/

    /**
     * @param string $email email
     *
     * @return object
     */
    function setEmail(string $email): object
    {
        if ($this->_email !== $email) {
            $this->_email = $email;
            $this->_modified_fields['contact']['email'] = true;
        }

        return $this;
    }

    /**
     * @param string $lastnl lastnl
     *
     * @return object
     */
    function setLastnl(string $lastnl): object
    {
        if ($this->_lastnl !== $lastnl) {
            $this->_lastnl = $lastnl;
            $this->_modified_fields['contact']['lastnl'] = true;
        }

        return $this;
    }

    /**
     * @return object
     */
    function setLastnlNow(): object
    {
        $now = date('Y-m-d H:i:s');

        if ($this->_lastnl !== $now) {
            $this->_lastnl = $now;
            $this->_modified_fields['contact']['lastnl'] = true;
        }

        return $this;
    }

    /* fin setters */

    /**
     * Cherche une collection d'instance de l'objet répondant à certains critères
     * champs communs: order_by => fieldName, sort => ASC|DESC, limit => int
     *
     * À implémenter dans les classes filles
     *
     * @param array $params params
     *
     * @return object
     * @throws Exception
     */
    static function find(array $params): array
    {
        // @TODO à implémenter
        return [];
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

        $sql  = "SELECT * "
              . "FROM `" . Contact::getDbTable() . "` "
              . "WHERE `" . Contact::getDbPk() . "` = " . (int) $this->{'_' . Contact::getDbPk()};

        if ($res = $db->queryWithFetchFirstRow($sql)) {
            $this->_arrayToObject($res);
            return true;
        }

        throw new Exception('Contact introuvable');
    }

    /**
     * Suppression d'un contact
     *
     * @return int
     */
    function delete(): int
    {
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . Contact::getDbTable() . "` "
             . "WHERE `id_contact` = " . (int) $this->_id_contact;

        $db->query($sql);

        return $db->affectedRows();
    }

    /**
     * Sauve en DB table contact
     */
    function save()
    {
        $db = DataBase::getInstance();

        $fields = self::_getAllFields(false);

        if (!$this->getId()) { // INSERT

            /* table contact */

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
                    if (is_null($this->$att)) {
                        $sql .= 'NULL,';
                    } else {
                        switch ($type) {
                            case 'int':
                            case 'float':
                                $sql .= $db->escape($this->$att) . ",";
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
                                throw new Exception('invalid field type : ' . $type);
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

            if (count($this->_modified_fields['contact']) === 0) {
                return true; // pas de changement
            }

            /* table contact */

            $fields_to_save = '';
            foreach ($this->_modified_fields['contact'] as $field => $value) {
                if ($value === true) {
                    $att = '_' . $field;
                    if (is_null($this->$att)) {
                        $sql .= " `" . $field . "` = NULL,";
                    } else {
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
                                throw new Exception('invalid field type : ' . $fields['contact'][$field]);
                                break;
                        }
                    }
                }
            }
            $fields_to_save = substr($fields_to_save, 0, -1);

            $sql = "UPDATE `" . Contact::getDbTable() . "` "
                 . "SET " . $fields_to_save . " "
                 . "WHERE `id_contact` = " . (int) $this->_id_contact;

            $this->_modified_fields['contact'] = [];

            $db->query($sql);

            return true;
        }
    }
}
