<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Utils\ObjectModel;

/**
 * Classe de gestion des types de lieux
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class LieuType extends ObjectModel
{
    /**
     * @var array<string>
     */
    protected static array $pk = [
        'id_lieu_type',
    ];

    /**
     * @var string
     */
    protected static string $table = 'adhoc_lieu_type';

    /**
     * @var ?int
     */
    protected ?int $id_lieu_type = null;

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
        'id_lieu_type' => 'int', // pk
        'name' => 'string',
    ];

    /**
     * @return ?int
     */
    public function getIdLieuType(): ?int
    {
        return $this->id_lieu_type;
    }

    /**
     * @return ?string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param int $id_lieu_type
     *
     * @return static
     */
    public function setIdLieuType(int $id_lieu_type): static
    {
        if ($this->id_lieu_type !== $id_lieu_type) {
            $this->id_lieu_type = $id_lieu_type;
            $this->modified_fields['id_lieu_type'] = true;
        }

        return $this;
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
