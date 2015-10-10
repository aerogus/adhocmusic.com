<?php

/**
 * @package adhoc
 */

define('EXCEPTION_DEFAULT', 0);
define('EXCEPTION_MYSQL_DEFAULT', 10);
define('EXCEPTION_PHP_DEFAULT', 20);
define('EXCEPTION_USER_DEFAULT', 30);
define('EXCEPTION_USER_UNKNOW_ID', 31);
define('EXCEPTION_USER_BAD_PARAM', 32);
define('EXCEPTION_USER_UNAVAILABLE', 33);
define('EXCEPTION_USER_NOT_PRESENT', 34);
define('EXCEPTION_USER_ALREADY_PRESENT', 35);

/**
 * Classe AdHocException
 *
 * @package adhoc
 * @author Guillaume Seznec <guillaume.seznec@gmail.com>
 *
 * La classe d'Exception standard PHP5 défini:
 * protected $message = 'Unknown exception';  // exception message
 * protected $code = 0;                       // user defined exception code
 * protected $file;                           // source filename of exception
 * protected $line;
 *
 * les classes filles specialisent l'exception :
 * - AdHocMySqlException
 * - AdHocPhpException
 * - AdHocUserException
 */
class AdHocException extends Exception
{
    /**
     *
     */
    protected $errno  = -1;

    /**
     *
     */
    protected $errstr = '';

    /**
     *
     */
    protected $stuff = null;

    /**
     *
     */
    function setCode($value)
    {
        $this->code = $value;
    }

    /**
     *
     */
    function setMessage($value)
    {
        $this->message = $value;
    }

    /**
     *
     */
    function getErrNo()
    {
        return $this->errno;
    }

    /**
     *
     */
    function setErrNo($value)
    {
        $this->errno = (int) $value;
    }

    /**
     *
     */
    function getErrStr()
    {
        return $this->errstr;
    }

    /**
     *
     */
    function setErrStr($value)
    {
        $this->errstr = (string) $value;
    }

    /**
     *
     */
    function __construct($message, $code = EXCEPTION_DEFAULT, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     *
     */
    function __toString()
    {
        $str = 'Erreur [' . $this->getErrNo() . '] : ' . $this->getMessage();
        if ($this->getErrStr()) {
            $str .= '(' . $this->getErrStr() . ')';
        }
        $str .= "\n" . $this->getTraceAsString() . "\n";
        return $str;
    }

    /**
     *
     */
    function addSomethingForDebug($o)
    {
        if (is_null($this->stuff)) {
            $this->stuff = array();
        }
        $this->stuff[] = $o;
    }

    /**
     *
     */
    function getAdditionalDebugInfo()
    {
        if (empty($this->stuff)) {
            return false;
        }
        return $this->stuff;
    }
}