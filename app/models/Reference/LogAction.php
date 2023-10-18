<?php declare(strict_types=1);

namespace Reference;

use Reference;

/**
 * Actions de log
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class LogAction extends Reference
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
    protected static string $_pk = 'id_log_action';

    /**
     * @var string
     */
    protected static string $_table = 'adhoc_log_action';

    /**
     * @var int
     */
    protected $_id_log_action = 0;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static $_all_fields = [
        'id_log_action' => 'int', // pk
        'name'          => 'string',
    ];
}