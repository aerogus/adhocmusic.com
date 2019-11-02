<?php declare(strict_types=1);

/**
 * Classe de gestion des styles musicaux
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Style extends ObjectModel
{
    /**
     * @var object
     */
    protected static $_instance = null;

    /**
     * @var string
     */
    protected static $_pk = 'id_style';

    /**
     * @var string
     */
    protected static $_table = 'adhoc_style';

    /**
     * @var int
     */
    protected $_id_style = 0;

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
        'name' => 'string',
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
     * @param string $name nom du style
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
     * Retourne les infos sur un style
     *
     * @return bool
     * @throws Exception
     */
    function _loadFromDb(): bool
    {
        if (!parent::_loadFromDb()) {
            throw new Exception('Style introuvable');
        }

        return true;
    }
}
