<?php

declare(strict_types=1);

namespace Reference;

use Reference;

/**
 * Classe MembreType
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class MembreType extends Reference
{
    /**
     * Instance de l'objet
     *
     * @var object
     */
    protected static $instance = null;

    /**
     * @var string|array<string>
     */
    protected static string|array $pk = 'id_membre_type';

    /**
     * @var string
     */
    protected static string $table = 'adhoc_membre_type';

    /**
     * @var int
     */
    protected int $id_membre_type = 0;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
        'id_membre_type' => 'int', // pk
        'name'           => 'string',
    ];
}
