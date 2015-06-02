<?php

/**
 * @package adhoc
 */

/**
 * Classe Contact
 *
 * @package adhoc
 * @author Guillaume Seznec <guillaume.seznec@gmail.com>
 */
class Contact extends ObjectModel
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
    protected static $_table = 'adhoc_contact';

    /**
     * @var int
     */
    protected $_id_contact = 0;

    /**
     * @var string
     */
    protected $_email = '';

    /**
     * @var string
     */
    protected $_lastnl = '';

    /**
     * Liste des attributs de l'objet
     * on précise si en base c'est de type :
     * - numérique/integer/float/bool (= int)
     * - datetime/text (= str)
     * ceci est utile pour la formation de la requête
     * @var array
     */
    protected static $_all_fields = array(
        'email'  => 'str',
        'lastnl' => 'str',
    );

    /**
     * Tableau des attributs modifiés depuis la dernière sauvegarde.
     *
     * Pour chaque attribut modifié, on a un élément de la forme 'attribut => true'.
     * @var array
     */
    protected $_modified_fields = array(
        'contact' => array(),
    );

    /**
     * @param bool
     * @return array
     */
    protected function _getAllFields($fusion = true)
    {
        if($fusion) {
            return self::$_all_fields;
        } else {
            return array(
                'contact' => self::$_all_fields,
            );
        }
    }

    /* début getters */

    /**
     * @return string
     */
    function getEmail()
    {
        return (string) $this->_email;
    }

    /**
     * Extraction de l'email
     */
    static function getEmailById($id_contact)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `email` "
             . "FROM `" . self::$_db_table_contact . "` "
             . "WHERE `id_contact` = " . (int) $id_contact;

        return $db->queryWithFetchFirstField($sql);
    }

    /**
     * @return string
     */
    function getLastnl()
    {
        return (string) $this->_lastnl;
    }

    /**
     * Extraction de l'id_contact a partir de l'email (celui-ci étant unique)
     * sinon si email null, retourne un tableau des id_contact avec email null
     *
     * @param string $email
     * @return int
     */
    static function getIdByEmail($email)
    {
        if(!Email::validate($email)) {
            throw new AdHocUserException('email syntaxiquement incorrect', EXCEPTION_USER_BAD_PARAM);
        }

        $db = DataBase::getInstance();

        $sql = "SELECT `id_contact` "
             . "FROM `" . self::$_db_table_contact . "` "
             ." WHERE `email` = '".$db->escape($email)."'";

        return $db->queryWithFetchFirstField($sql);
    }

    /**
     * Email déjà présent ?
     * @todo pourquoi pas dans classe Contact ?
     * @param string $email
     * @return bool
     * @deprecated doublon avec getIdByEmail
     */
     static function isEmailFound($email)
     {
         $db   = DataBase::getInstance();
 
         $sql  = "SELECT `id_contact` "
               . "FROM `" . self::$_db_table_contact . "` "
               . "WHERE `email` = '" . $db->escape($email) . "'";
 
         $res  = $db->query($sql);
 
         return $db->numRows($res);
    }

    /* fin getters */

    /* début setters*/

    /**
     * @param string
     */
    function setEmail($val)
    {
        if ($this->_email != $val)
        {
            $this->_email = (string) $val;
            $this->_modified_fields['contact']['email'] = true;
        }
    }

    /**
     * @param string
     */
    function setLastnl($val)
    {
        if ($this->_lastnl != $val)
        {
            $this->_lastnl = (string) $val;
            $this->_modified_fields['contact']['lastnl'] = true;
        }
    }

    /**
     *
     */
    function setLastnlNow()
    {
        $now = date('Y-m-d H:i:s');
        if ($this->_lastnl != $now)
        {
            $this->_lastnl = (string) $now;
            $this->_modified_fields['contact']['lastnl'] = true;
        }
    }

    /* fin setters */

    /**
     * Suppression d'un contact
     * @todo vérification des liaisons avec table membre
     *
     * @return int
     */
    function delete()
    {
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `" . self::$_db_table_contact . "` "
             . "WHERE `id_contact` = " . (int) $this->_id_contact;

        $db->query($sql);

        return $db->affectedRows();
    }

    /**
     * sauve en DB table contact
     */
    function save()
    {
        $db = DataBase::getInstance();

        $fields = self::_getAllFields(false);

        if(!$this->getId()) // INSERT
        {
            /* table contact */

            $sql = "INSERT INTO `" . static::$_db_table_contact . "` (";
            foreach($fields['contact'] as $field => $type) {
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
                        throw new Exception('invalid field type');
                        break;
                }
            }
            $sql = substr($sql, 0, -1);
            $sql .= ")";

            $db->query($sql);

            $this->setId((int) $db->insertId());

            return $this->getId();
        }
        else // UPDATE
        {
            if (count($this->_modified_fields['contact']) === 0) {
                return true; // pas de changement
            }

            /* table contact */

            $fields_to_save = '';
            foreach($this->_modified_fields['contact'] as $field => $value) {
                if($value === true) {
                    $att = '_' . $field;
                    switch($fields['contact'][$field])
                    {
                        case 'num':
                            $fields_to_save .= " `" . $field . "` = " . $db->escape($this->$att) . ", ";
                            break;
                        case 'str':
                            $fields_to_save .= " `" . $field . "` = '" . $db->escape($this->$att) . "', ";
                            break;
                        case 'bool':
                            $fields_to_save .= " `" . $field . "` = " . (((bool) $this->$att) ? 'TRUE' : 'FALSE') . ", ";
                            break;
                        case 'bool':
                            $fields_to_save .= " `" . $field . "` = PASSWORD('" . $db->escape($this->$att) . "'), ";
                            break;
                        case 'phpser':
                            $fields_to_save .= " `" . $field . "` = '" . $db->escape(serialize($this->$att)) . "', ";
                            break;
                        default:
                            throw new Exception('invalid field type');
                            break;
                    }
                }
            }
            $fields_to_save = substr($fields_to_save, 0, -2);

            $sql = "UPDATE `" . self::$_db_table_contact . "` "
                 . "SET " . $fields_to_save . " "
                 . "WHERE `id_contact` = " . (int) $this->_id_contact;

            $this->_modified_fields['contact'] = array();

            $db->query($sql);

            $this->_clearFromCache();

            return true;
        }
    }

    /**
     * charge toutes les infos d'un contact
     *
     * @return bool
     */
    protected function _loadFromDb()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `email`, `lastnl` "
             . "FROM `" . self::$_db_table_contact . "` "
             . "WHERE `id_contact` = " . (int) $this->_id_contact;

        if($res = $db->queryWithFetchFirstRow($sql)) {
            $this->_dbToObject($res);
            return true;
        }

        throw new AdHocUserException('Contact introuvable', EXCEPTION_USER_UNKNOW_ID);
    }
}
