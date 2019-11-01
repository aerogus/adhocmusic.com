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

    /**
     * @var string
     */
    protected $_name = '';

    /**
     * Liste des attributs de l'objet
     * on précise si en base c'est de type :
     * - numérique/integer/float/bool (= int)
     * - datetime/text (= str)
     * ceci est utile pour la formation de la requête
     *
     * @var array
     */
    protected static $_all_fields = [
        'name' => 'str',
    ];

    /**
     * Tableau des attributs modifiés depuis la dernière sauvegarde.
     *
     * Pour chaque attribut modifié, on a un élément de la forme 'attribut => true'.
     *
     * @var array
     */
    protected $_modified_fields = [];

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
    function _loadFromDb(): bool
    {
        if (!parent::_loadFromDb()) {
            throw new Exception('Référence introuvable');
        }

        return true;
    }
}
