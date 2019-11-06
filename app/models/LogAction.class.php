<?php declare(strict_types=1);

/**
 * Actions de log
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class LogAction extends Reference
{
    /**
     * @var object
     */
    protected static $_instance = null;

    /**
     * @var string
     */
    protected static $_pk = 'id_log_action';

    /**
     * @var string
     */
    protected static $_table = 'adhoc_log_action';

    /**
     * @var int
     */
    protected $_id_log_action = 0;
}