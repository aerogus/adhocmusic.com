<?php

/**
 * Gestion du fil d'Ariane / Trail / BreadCrumbs
 */
class Trail
{
    /**
     * @var mixed
     */
    protected static $_instance = null;

    /**
     * @var array
     */
    protected $_path = [];

    /**
     *
     */
    static function getInstance()
    {
        if (is_null(self::$_instance)) {
            return new Trail();
        }
        return self::$_instance;
    }

    /**
     *
     */
    function __construct()
    {
        $this->addStep('Accueil', '/');
        self::$_instance = $this;
    }

    /**
     * Ajoute un élément au fil d'ariane
     *
     * @param string $title
     * @param string $link (opt.)
     */
    function addStep($title, $link = '')
    {
        $this->_path[] = [
            'title' => $title,
            'link' => $link,
        ];
    }

    /**
     * Retourne le fil d'ariane
     *
     * @return array
     */
    function getPath()
    {
        return $this->_path;
    }
}
