<?php

declare(strict_types=1);

namespace Reference;

use Reference;

/**
 * Classe de gestion des types de musiciens
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class TypeMusicien extends Reference
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
    protected static string $pk = 'id_type_musicien';

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
        'name'             => 'string',
    ];
}
