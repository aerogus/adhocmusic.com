<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Utils\ObjectModel;

/**
 * Classe MembreType
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class MembreType extends ObjectModel
{
    /**
     * @var array<string>
     */
    protected static array $pk = [
        'id_membre_type',
    ];

    /**
     * @var string
     */
    protected static string $table = 'adhoc_membre_type';

    /**
     * @var ?int
     */
    protected ?int $id_membre_type = null;

    /**
     * @var ?string
     */
    protected ?string $name = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
        'id_membre_type' => 'int', // pk
        'name' => 'string',
    ];

    /**
     * @return ?string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param ?string $name nom
     *
     * @return static
     */
    public function setName(?string $name): static
    {
        if ($this->name !== $name) {
            $this->name = $name;
            $this->modified_fields['name'] = true;
        }

        return $this;
    }
}
