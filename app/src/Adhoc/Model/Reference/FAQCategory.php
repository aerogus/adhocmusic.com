<?php

declare(strict_types=1);

namespace Adhoc\Model\Reference;

use Adhoc\Model\Reference;

/**
 * Classe de gestion des catégories de FAQ
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class FAQCategory extends Reference
{
    /**
     * @var array<string>
     */
    protected static array $pk = [
        'id_faq_category',
    ];

    /**
     * @var string
     */
    protected static string $table = 'adhoc_faq_category';

    /**
     * @var int
     */
    protected int $id_faq_category = 0;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
        'id_faq_category' => 'int', // pk
        'name' => 'string',
    ];
}
