<?php

declare(strict_types=1);

namespace Adhoc\Model\Reference;

use Adhoc\Model\Reference;

/**
 * Classe de gestion des types de photos
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class PhotoType extends Reference
{
    /**
     * @var string|array<string>
     */
    protected static string|array $pk = 'id_photo_type';

    /**
     * @var string
     */
    protected static string $table = 'adhoc_photo_type';

    /**
     * @var int
     */
    protected int $id_photo_type = 0;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
        'id_photo_type' => 'int', // pk
        'name'          => 'string',
    ];
}
