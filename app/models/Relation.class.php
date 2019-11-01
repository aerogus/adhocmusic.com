<?php declare(strict_types=1);

/**
 * Classe de gestion des tables de relations
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
abstract class Relation extends ObjectModel
{
    /**
     * @var object
     */
    protected static $_instance = null;

    /**
     * @var string
     */
    protected static $_pk = '';

    /**
     * @var string
     */
    protected static $_table = '';
}