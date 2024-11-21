<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Utils\ObjectModel;

/**
 * Classe EventStyle
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class EventStyle extends ObjectModel
{
    /**
     * @var array<string>
     */
    protected static array $pk = [
        'id_event',
        'id_style',
    ];

    /**
     * @var string
     */
    protected static string $table = 'adhoc_event_style';

    /**
     * @var ?int
     */
    protected ?int $id_event = null;

    /**
     * @var ?int
     */
    protected ?int $id_style = null;

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
    public function getIdStyle(): ?int
    {
        return $this->id_style;
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
     * @param int $id_style
     *
     * @return static
     */
    public function setIdStyle(int $id_style): static
    {
        if ($this->id_style !== $id_style) {
            $this->id_style = $id_style;
            $this->modified_fields['id_style'] = true;
        }

        return $this;
    }
}
