<?php

declare(strict_types=1);

namespace Adhoc\Model\Reference;

use Adhoc\Model\Reference;

/**
 * Classe de gestion des types de musiciens
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class TypeMusicien extends Reference
{
    /**
     * @var string|array<string>
     */
    protected static string|array $pk = 'id_type_musicien';

    /**
     * @var string
     */
    protected static string $table = 'adhoc_type_musicien';

    /**
     * @var int
     */
    protected int $id_type_musicien = 0;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
        'id_type_musicien' => 'int', // pk
        'name' => 'string',
    ];
}
