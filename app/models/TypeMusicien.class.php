<?php declare(strict_types=1);

/**
 * Classe de gestion des types de musiciens
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class TypeMusicien extends ObjectModel
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
     * @param string $val val
     *
     * @return object
     */
    function setName(string $val): object
    {
        if ($this->_name !== $val) {
            $this->_name = $val;
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
            throw new Exception('Type de musicien introuvable');
        }

        return true;
    }
}
