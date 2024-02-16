<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Utils\ObjectModel;

/**
 * Classe de gestion des tables de référence
 *
 * @template TObjectModel as Reference
 * @extends ObjectModel<TObjectModel>
 *
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
abstract class Reference extends ObjectModel
{
    /**
     * Instance de l'objet
     *
     * @var ?TObjectModel
     */
    protected static ?ObjectModel $instance = null;

    /**
     * [à étendre dans l'objet fils]
     *
     * @var string|array<string>
     */
    protected static string|array $pk = '';

    /**
     * [à étendre dans l'objet fils]
     *
     * @var string
     */
    protected static string $table = '';

    /**
     * @var ?string
     */
    protected ?string $name = null;

    /* début getters */

    /**
     * @return ?string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /* fin getters */

    /* début setters */

    /**
     * @param ?string $name nom
     *
     * @return object
     */
    public function setName(?string $name): object
    {
        $name = is_string($name) ? trim($name) : $name;

        if ($this->name !== $name) {
            $this->name = $name;
            $this->modified_fields['name'] = true;
        }

        return $this;
    }

    /* fin setters */

    /**
     * Charge la table de référence
     *
     * @return bool
     * @throws \Exception
     */
    protected function loadFromDb(): bool
    {
        if (!parent::loadFromDb()) {
            throw new \Exception('Référence ' . print_r($this->getId(), true) . ' introuvable dans ' . get_called_class());
        }

        return true;
    }
}