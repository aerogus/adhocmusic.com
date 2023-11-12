<?php

declare(strict_types=1);

namespace Adhoc\Model\Reference;

use Adhoc\Model\Reference;
use Adhoc\Utils\ObjectModel;

/**
 * Actions de log
 *
 * @template TObjectModel as LogAction
 * @extends Reference<TObjectModel>
 *
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class LogAction extends Reference
{
    /**
     * Instance de l'objet
     *
     * @var ?TObjectModel
     */
    protected static ?ObjectModel $instance = null;

    /**
     * @var string|array<string>
     */
    protected static string|array $pk = 'id_log_action';

    /**
     * @var string
     */
    protected static string $table = 'adhoc_log_action';

    /**
     * @var int
     */
    protected $id_log_action = 0;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
        'id_log_action' => 'int', // pk
        'name' => 'string',
    ];
}
