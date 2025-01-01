<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Utils\ObjectModel;

/**
 * Classe GroupeMembre
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class GroupeMembre extends ObjectModel
{
    /**
     * @var array<string>
     */
    protected static array $pk = [
        'id_contact',
        'id_groupe',
        'id_type_musicien',
    ];

    /**
     * @var string
     */
    protected static string $table = 'adhoc_groupe_membre';

    /**
     * @var ?int
     */
    protected ?int $id_contact = null;

    /**
     * @var ?int
     */
    protected ?int $id_groupe = null;

    /**
     * @var ?int
     */
    protected ?int $id_type_musicien = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
        'id_contact' => 'int', // pk
        'id_groupe' => 'int', // pk
        'id_type_musicien' => 'int', // pk
    ];

    /**
     * Retourne l'id_contact
     *
     * @return ?int
     */
    public function getIdContact(): ?int
    {
        return $this->id_contact;
    }

    /**
     * Retourne l'id_groupe
     *
     * @return ?int
     */
    public function getIdGroupe(): ?int
    {
        return $this->id_groupe;
    }

    /**
     * Retourne l'id_groupe
     *
     * @return ?int
     */
    public function getIdTypeMusicien(): ?int
    {
        return $this->id_type_musicien;
    }

    /**
     * @param ?int $id_contact
     *
     * @return static
     */
    public function setIdContact(?int $id_contact): static
    {
        if ($this->id_contact !== $id_contact) {
            $this->id_contact = $id_contact;
            $this->modified_fields['id_contact'] = true;
        }

        return $this;
    }

    /**
     * @param ?int $id_groupe
     *
     * @return static
     */
    public function setIdGroupe(?int $id_groupe): static
    {
        if ($this->id_groupe !== $id_groupe) {
            $this->id_groupe = $id_groupe;
            $this->modified_fields['id_groupe'] = true;
        }

        return $this;
    }

    /**
     * @param ?int $id_type_musicien
     *
     * @return static
     */
    public function setIdTypeMusicien(?int $id_type_musicien): static
    {
        if ($this->id_type_musicien !== $id_type_musicien) {
            $this->id_type_musicien = $id_type_musicien;
            $this->modified_fields['id_type_musicien'] = true;
        }

        return $this;
    }
}
