<?php

/**
 * @package adhoc
 */

/**
 * Classe AdHocMySqlException
 *
 * @package adhoc
 * @author Guillaume Seznec <guillaume.seznec@gmail.com>
 */
class AdHocMySqlException extends AdHocException
{
    /**
     *
     */
    protected $serverinfo = false;

    /**
     *
     */
    protected $query = '';

    /**
     *
     */
    public function __construct($link_identifier, $message = '', $code = EXCEPTION_MYSQL_DEFAULT, Exception $previous = null)
    {
        if (!empty($link_identifier))
        {
            $message = 'MySQL Exception';
            $this->errno  = mysql_errno($link_identifier);
            $this->errstr = mysql_error($link_identifier);
        }
        else
        {
            $message = 'MySQL Exception (No link)';
            $this->errno = mysql_errno();
            $this->errstr = mysql_error();
        }
        parent::__construct($message, $code, $previous);
    }

    /**
     *
     */
    public function setQuery($sql)
    {
        $this->query = $sql;
    }

    /**
     *
     */
    public function getQuery($sql)
    {
        $this->query = $sql;
    }
}