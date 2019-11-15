<?php declare(strict_types=1);

/**
 * Classe de gestion des tables de référence
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
abstract class Reference extends ObjectModel
{
    /**
     * Instance de l'objet
     *
     * @var mixed
     */
    protected static $_instance = null;

    /**
     * [à étendre dans l'objet fils]
     *
     * @var string
     */
    protected static $_pk = '';

    /**
     * [à étendre dans l'objet fils]
     *
     * @var string
     */
    protected static $_table = '';

    /**
     * @var string
     */
    protected $_name = '';

    /* début getters */

    /**
     * @return string
     */
    function getName(): string
    {
        return $this->_name;
    }

    /* fin getters */

    /* début setters */

    /**
     * @param string $name nom
     *
     * @return object
     */
    function setName(string $name): object
    {
        if ($this->_name !== $name) {
            $this->_name = $name;
            $this->_modified_fields['name'] = true;
        }

        return $this;
    }

    /* fin setters */

    /**
     * Charge la table de référence
     *
     * @return bool
     * @throws Exception
     */
    protected function _loadFromDb(): bool
    {
        if (!parent::_loadFromDb()) {
            throw new Exception('Référence introuvable dans ' . get_called_class());
        }

        return true;
    }
}
