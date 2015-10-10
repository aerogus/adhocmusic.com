<?php

/**
 * @package adhoc
 */

/**
 * Classe AdHocPhpException
 *
 * @package adhoc
 * @author Guillaume Seznec <guillaume.seznec@gmail.com>
 */
class AdHocPhpException extends AdHocException
{
    /**
     *
     */
    function __construct($errno, $errstr, $errfile, $errline, $errcontext = false)
    {
        $this->errno  = $errno;
        $this->errstr = $errstr;
        $this->line   = $errline;
        $this->file   = $errfile;

        parent::__construct('Erreur PHP: ' . $errstr, EXCEPTION_PHP_DEFAULT, null);
    }
}