<?php

declare(strict_types=1);

namespace Adhoc\Model\Reference;

use Adhoc\Model\Reference;
use Adhoc\Utils\ObjectModel;

/**
 * Classe de gestion des types de lieux
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class LieuType extends Reference
{
    /**
     * @var string|array<string>
     */
    protected static string|array $pk = 'id_lieu_type';

    /**
     * @var string
     */
    protected static string $table = 'adhoc_lieu_type';

    /**
     * @var int
     */
    protected int $id_lieu_type = 0;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
        'id_lieu_type' => 'int', // pk
        'name'         => 'string',
    ];
}
