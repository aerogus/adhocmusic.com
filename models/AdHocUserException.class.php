<?php

/**
 * @package adhoc
 */

/**
 * Classe AdHocUserException
 *
 * @package adhoc
 * @author Guillaume Seznec <guillaume.seznec@gmail.com>
 */
class AdHocUserException extends AdHocException
{
    /**
     *
     */
    public function __construct($message, $code = EXCEPTION_USER_DEFAULT)
    {
        parent::__construct($message, $code);
    }
}