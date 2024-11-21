<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Utils\ObjectModel;

/**
 * Classe VideoHost
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class VideoHost extends ObjectModel
{
    /**
     * @var array<string>
     */
    protected static array $pk = [
        'id_video_host',
    ];

    /**
     * @var string
     */
    protected static string $table = 'adhoc_video_host';

    /**
     * @var ?int
     */
    protected ?int $id_video_host = null;

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
        'id_video_host' => 'int', // pk
        'name' => 'string',
    ];

    /**
     * @return ?int
     */
    public function getIdVideoHost(): ?int
    {
        return $this->id_video_host;
    }

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
