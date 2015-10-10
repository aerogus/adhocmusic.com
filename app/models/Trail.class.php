<?php

/**
 * Gestion du fil d'Ariane / Trail / BreadCrumbs
 */
class Trail
{
    /**
     *
     */
    protected $_path = array();

    /**
     *
     */
    protected static $_instance = null;

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
    static function deleteInstance()
    {
        if (isset(self::$_instance)) {
            self::$_instance = null;
            return true;
        }
        return false;
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
        if (mb_strlen($link) == 0) {
            $link = $_SERVER['REQUEST_URI'];
        }
        $this->_path[] = array(
            'title' => $title,
            'link'  => $link,
        );
    }

    /**
     *
     */
    function init()
    {
        $this->_path = array();
    }

    /**
     * @return array
     */
    function getPath()
    {
        return $this->_path;
    }
}