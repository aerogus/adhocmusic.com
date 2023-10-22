<?php

declare(strict_types=1);

namespace Reference;

use Reference;

/**
 * Classe de gestion des états de groupes
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class GroupeStatus extends Reference
{
    /**
     * Instance de l'objet
     *
     * @var object
     */
    protected static $instance = null;

    /**
     * @var string
     */
    protected static string $pk = 'id_groupe_status';

    /**
     * @var string
     */
    protected static string $table = 'adhoc_groupe_status';

    /**
     * @var int
     */
    protected int $id_groupe_status = 0;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
        'id_groupe_status' => 'int', // pk
        'name'             => 'string',
    ];
}
