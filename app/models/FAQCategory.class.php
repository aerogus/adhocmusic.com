<?php declare(strict_types=1);

/**
 * Classe de gestion des catégories de FAQ
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class FAQCategory extends Reference
{
    /**
     * @var object
     */
    protected static $_instance = null;

    /**
     * @var string
     */
    protected static $_pk = 'id_faq_category';

    /**
     * @var string
     */
    protected static $_table = 'adhoc_faq_category';

    /**
     * @var int
     */
    protected $_id_faq_category = 0;

    /**
     * Liste des attributs de l'objet
     *
     * @var array
     */
    protected static $_all_fields = [
        'id_faq_category' => 'int', // pk
        'name'            => 'string',
    ];
}
