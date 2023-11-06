<?php

declare(strict_types=1);

namespace Adhoc\Model;

/**
 * Classe Contact
 *
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Contact extends ObjectModel
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
    protected static string $table = 'adhoc_contact';

    /**
     * @var ?int
     */
    protected ?int $id_contact = null;

    /**
     * @var ?string
     */
    protected ?string $email = null;

    /**
     * @var ?string
     */
    protected ?string $lastnl = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
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
    protected $modified_fields = [
        'contact' => [],
    ];

    /**
     * @param bool $fusion fusion
     *
     * @return array
     */
    protected function getAllFields(bool $fusion = true): array
    {
        if ($fusion) {
            return self::$all_fields;
        } else {
            return [
                'contact' => self::$all_fields,
            ];
        }
    }

    /* début getters */

    /**
     * @return ?int
     */
    public function getIdContact(): ?int
    {
        return $this->id_contact;
    }

    /**
     * @return ?string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Extraction de l'email à partir de l'id
     *
     * @param int $id_contact id_contact
     *
     * @return ?string
     */
    public static function getEmailById(int $id_contact)
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
     * @return ?string
     */
    public function getLastnl(): ?string
    {
        return $this->lastnl;
    }

    /**
     * Extraction de l'id_contact a partir de l'email (celui-ci étant unique)
     * sinon si email null, retourne un tableau des id_contact avec email null
     *
     * @param string $email email
     *
     * @return int
     * @throws \Exception
     */
    public static function getIdByEmail(string $email): int
    {
        if (!Email::validate($email)) {
            throw new \Exception('email syntaxiquement incorrect');
        }

        $db = DataBase::getInstance();

        $sql = "SELECT `id_contact` "
             . "FROM `" . Contact::getDbTable() . "` "
             . "WHERE `email` = '" . $db->escape($email) . "'";

        return (int) $db->queryWithFetchFirstField($sql);
    }

    /**
     * Email déjà présent ?
     * @todo pourquoi pas dans classe Contact ?
     * @param string $email
     * @return bool
     * @deprecated doublon avec getIdByEmail
     */
    public static function isEmailFound(string $email): bool
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
    public function setEmail(string $email): object
    {
        if ($this->email !== $email) {
            $this->email = $email;
            $this->modified_fields['contact']['email'] = true;
        }

        return $this;
    }

    /**
     * @param string $lastnl lastnl
     *
     * @return object
     */
    public function setLastnl(string $lastnl): object
    {
        if ($this->lastnl !== $lastnl) {
            $this->lastnl = $lastnl;
            $this->modified_fields['contact']['lastnl'] = true;
        }

        return $this;
    }

    /**
     * @return object
     */
    public function setLastnlNow(): object
    {
        $now = date('Y-m-d H:i:s');

        if ($this->lastnl !== $now) {
            $this->lastnl = $now;
            $this->modified_fields['contact']['lastnl'] = true;
        }

        return $this;
    }

    /* fin setters */

    /**
     * Charge toutes les infos d'une entité
     *
     * @return bool
     * @throws \Exception
     */
    protected function loadFromDb(): bool
    {
        $db = DataBase::getInstance();

        $sql  = "SELECT * "
              . "FROM `" . Contact::getDbTable() . "` "
              . "WHERE `" . Contact::getDbPk() . "` = " . (int) $this->getId();

        if ($res = $db->queryWithFetchFirstRow($sql)) {
            $this->arrayToObject($res);
            return true;
        }

        throw new \Exception('Contact introuvable');
    }

    /**
     * Suppression d'un contact
     *
     * @return int
     */
    public function delete(): int
    {
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . Contact::getDbTable() . "` "
             . "WHERE `id_contact` = " . (int) $this->id_contact;

        $db->query($sql);

        return $db->affectedRows();
    }

    /**
     * Sauve en DB table contact
     */
    public function save()
    {
        $db = DataBase::getInstance();

        $fields = self::getAllFields(false);

        if (!$this->getId()) { // INSERT
            /* table contact */
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
                                throw new \Exception('invalid field type : ' . $type);
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
            if (count($this->modified_fields['contact']) === 0) {
                return true; // pas de changement
            }

            /* table contact */

            $fields_to_save = '';
            foreach ($this->modified_fields['contact'] as $field => $value) {
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
                                throw new \Exception('invalid field type : ' . $fields['contact'][$field]);
                                break;
                        }
                    }
                }
            }
            $fields_to_save = substr($fields_to_save, 0, -1);

            $sql = "UPDATE `" . Contact::getDbTable() . "` "
                 . "SET " . $fields_to_save . " "
                 . "WHERE `id_contact` = " . (int) $this->id_contact;

            $this->modified_fields['contact'] = [];

            $db->query($sql);

            return true;
        }
    }
}
