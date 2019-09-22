<?php declare(strict_types=1);

/**
 * Gestion du fil d'Ariane / Trail / BreadCrumbs
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Trail
{
    /**
     * @var mixed
     */
    protected static $_instance = null;

    /**
     * Conteneur des données
     *
     * @var array
     */
    protected $_path = [];

    /**
     * @return object
     */
    static function getInstance(): object
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
     * @param string $title titre
     * @param string $link  lien (optionnel)
     * 
     * @return mixed
     */
    function addStep(string $title, string $link = '')
    {
        $this->_path[] = [
            'title' => $title,
            'link' => $link,
        ];
        return $this;
    }

    /**
     * Retourne le fil d'ariane
     *
     * @return array
     */
    function getPath(): array
    {
        return $this->_path;
    }
}
