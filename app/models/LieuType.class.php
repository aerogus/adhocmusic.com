<?php declare(strict_types=1);

/**
 * Classe de gestion des types de lieux
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class LieuType extends Reference
{
    /**
     * @var object
     */
    protected static $_instance = null;

    /**
     * @var string
     */
    protected static $_pk = 'id_lieu_type';

    /**
     * @var string
     */
    protected static $_table = 'adhoc_lieu_type';

    /**
     * @var int
     */
    protected $_id_lieu_type = 0;
}
