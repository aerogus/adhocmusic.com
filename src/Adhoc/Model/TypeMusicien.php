<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Utils\ObjectModel;

/**
 * Classe de gestion des types de musiciens
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class TypeMusicien extends ObjectModel
{
    /**
     * @var array<string>
     */
    protected static array $pk = [
        'id_type_musicien',
    ];

    /**
     * @var string
     */
    protected static string $table = 'adhoc_type_musicien';

    /**
     * @var int
     */
    protected int $id_type_musicien = 0;

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
        'id_type_musicien' => 'int', // pk
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
