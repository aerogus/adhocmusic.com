<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Utils\DataBase;
use Adhoc\Utils\ObjectModel;

/**
 * Classe de gestion de l'appli messages privés
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class Message extends ObjectModel
{
    /**
     * @var string|array<string>
     */
    protected static string|array $pk = 'id_message'; // ex id_pm

    /**
     * @var string
     */
    protected static string $table = 'adhoc_messagerie';

    /**
     * @var ?int
     */
    protected ?int $id_message = null;

    /**
     * @var ?int
     */
    protected ?int $id_from = null;

    /**
     * @var ?int
     */
    protected ?int $id_to = null;

    /**
     * @var ?string
     */
    protected ?string $text = null;

    /**
     * @var ?string
     */
    protected ?string $date = null;

    /**
     * @var ?bool
     */
    protected ?bool $read_to = null;

    /**
     * @var ?bool
     */
    protected ?bool $del_from = null;

    /**
     * @var ?bool
     */
    protected ?bool $del_to = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
        'id_message' => 'int', // pk (ex id_pm)
        'id_from'    => 'int',
        'id_to'      => 'int',
        'text'       => 'string',
        'date'       => 'date',
        'read_to'    => 'bool',
        'del_from'   => 'bool',
        'del_to'     => 'bool',
    ];

    /**
     * @return ?int
     */
    public function getIdMessage(): ?int
    {
        return $this->id_message; // ex id_pm
    }

    /**
     * @return ?int
     */
    public function getIdFrom(): ?int
    {
        return $this->id_from;
    }

    /**
     * @return ?int
     */
    public function getIdTo(): ?int
    {
        return $this->id_to;
    }

    /**
     * @return ?string
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @return ?string
     */
    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * @return ?bool
     */
    public function getReadTo(): ?bool
    {
        return $this->read_to;
    }

    /**
     * @return ?bool
     */
    public function getDelFrom(): ?bool
    {
        return $this->del_from;
    }

    /**
     * @return ?bool
     */
    public function getDelTo(): ?bool
    {
        return $this->del_to;
    }

    /**
     * @param int $id_message id_message
     *
     * @return static
     */
    public function setIdMessage(int $id_message): static
    {
        if ($this->id_message !== $id_message) {
            $this->id_message = $id_message;
            $this->modified_fields['id_message'] = true;
        }

        return $this;
    }

    /**
     * @param int $id_from id_from
     *
     * @return static
     */
    public function setIdFrom(int $id_from): static
    {
        if ($this->id_from !== $id_from) {
            $this->id_from = $id_from;
            $this->modified_fields['id_from'] = true;
        }

        return $this;
    }

    /**
     * @param int $id_to id_to
     *
     * @return static
     */
    public function setIdTo(int $id_to): static
    {
        if ($this->id_to !== $id_to) {
            $this->id_to = $id_to;
            $this->modified_fields['id_to'] = true;
        }

        return $this;
    }

    /**
     * @param string $text texte
     *
     * @return static
     */
    public function setText(string $text): static
    {
        if ($this->text !== $text) {
            $this->text = $text;
            $this->modified_fields['text'] = true;
        }

        return $this;
    }

    /**
     * @param string $date date
     *
     * @return static
     */
    public function setDate(string $date): static
    {
        if ($this->date !== $date) {
            $this->date = $date;
            $this->modified_fields['date'] = true;
        }

        return $this;
    }

    /**
     * @param bool $read_to
     *
     * @return static
     */
    public function setReadTo(bool $read_to): static
    {
        if ($this->read_to !== $read_to) {
            $this->read_to = $read_to;
            $this->modified_fields['read_to'] = true;
        }

        return $this;
    }

    /**
     * @param bool $del_from
     *
     * @return static
     */
    public function setDelFrom(bool $del_from): static
    {
        if ($this->del_from !== $del_from) {
            $this->del_from = $del_from;
            $this->modified_fields['del_from'] = true;
        }

        return $this;
    }

    /**
     * @param bool $del_to
     *
     * @return static
     */
    public function setDelTo(bool $del_to): static
    {
        if ($this->del_to !== $del_to) {
            $this->del_to = $del_to;
            $this->modified_fields['del_to'] = true;
        }

        return $this;
    }
}
