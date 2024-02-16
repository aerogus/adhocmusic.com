<?php

declare(strict_types=1);

namespace Adhoc\Model\Reference;

use Adhoc\Model\Reference;
use Adhoc\Utils\ObjectModel;

/**
 * Classe de gestion des états de groupes
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class GroupeStatus extends Reference
{
    /**
     * @var string|array<string>
     */
    protected static string|array $pk = 'id_groupe_status';

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
