<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Utils\ObjectModel;

/**
 * Classe EventGroupe
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class EventGroupe extends ObjectModel
{
    /**
     * @var array<string>
     */
    protected static array $pk = [
        'id_event',
        'id_groupe',
    ];

    /**
     * @var string
     */
    protected static string $table = 'adhoc_event_groupe';

    /**
     * @var ?int
     */
    protected ?int $id_event = null;

    /**
     * @var ?int
     */
    protected ?int $id_groupe = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
        'id_event' => 'int', // pk
        'id_groupe' => 'int', // pk
    ];

    /**
     * @return ?int
     */
    public function getIdEvent(): ?int
    {
        return $this->id_event;
    }

    /**
     * @return ?int
     */
    public function getIdGroupe(): ?int
    {
        return $this->id_groupe;
    }

    /**
     * @param int $id_event
     *
     * @return static
     */
    public function setIdEvent(int $id_event): static
    {
        if ($this->id_event !== $id_event) {
            $this->id_event = $id_event;
            $this->modified_fields['id_event'] = true;
        }

        return $this;
    }

    /**
     * @param int $id_groupe
     *
     * @return static
     */
    public function setIdGroupe(int $id_groupe): static
    {
        if ($this->id_groupe !== $id_groupe) {
            $this->id_groupe = $id_groupe;
            $this->modified_fields['id_groupe'] = true;
        }

        return $this;
    }
}
