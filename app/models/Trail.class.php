<?php

/**
 * Gestion du fil d'Ariane / Trail / BreadCrumbs
 */
class Trail
{
    /**
     *
     */
    protected static $_instance = null;

    /**
     *
     */
    protected $_path = array();

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
     * @param string $title
     * @param string $link
     */
    function addStep($title, $link = '')
    {
        $this->_path[] = array(
            'title' => $title,
            'link' => $link,
        );
    }

    /**
     * @return array
     */
    function getPath()
    {
        return $this->_path;
    }
}
