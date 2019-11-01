<?php declare(strict_types=1);

/**
 * Classe de gestion des types de musiciens
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class TypeMusicien extends Reference
{
    /**
     * @var object
     */
    protected static $_instance = null;

    /**
     * @var string
     */
    protected static $_pk = 'id_type_musicien';

    /**
     * @var string
     */
    protected static $_table = 'adhoc_type_musicien';

    /**
     * @var int
     */
    protected $_id_type_musicien = 0;
}
