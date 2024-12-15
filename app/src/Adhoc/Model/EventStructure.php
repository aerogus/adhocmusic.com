<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Utils\ObjectModel;

/**
 * Classe EventStructure
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class EventStructure extends ObjectModel
{
    /**
     * @var array<string>
     */
    protected static array $pk = [
        'id_event',
        'id_structure',
    ];

    /**
     * @var string
     */
    protected static string $table = 'adhoc_event_structure'; // ex adhoc_organise_par

    /**
     * @var ?int
     */
    protected ?int $id_event = null;

    /**
     * @var ?int
     */
    protected ?int $id_structure = null;

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
    public function getIdStructure(): ?int
    {
        return $this->id_structure;
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
     * @param int $id_structure
     *
     * @return static
     */
    public function setIdStructure(int $id_structure): static
    {
        if ($this->id_structure !== $id_structure) {
            $this->id_structure = $id_structure;
            $this->modified_fields['id_structure'] = true;
        }

        return $this;
    }
}
