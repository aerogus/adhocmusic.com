<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Utils\ObjectModel;

/**
 * Gestion des partenaires
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class Partner extends ObjectModel
{
    /**
     * @var string|array<string>
     */
    protected static string|array $pk = 'id_partner';

    /**
     * @var string
     */
    protected static string $table = 'adhoc_partner';

    /**
     * @var int
     */
    protected int $id_partner = 0;

    /**
     * @var string
     */
    protected string $title = '';

    /**
     * @var string
     */
    protected string $description = '';

    /**
     * @var string
     */
    protected string $url = '';

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
        'id_partner' => 'int', // pk
        'title' => 'string',
        'description' => 'string',
        'url' => 'string',
    ];

    /* début getters */

    /**
     * @return string
     */
    public static function getBaseUrl(): string
    {
        return MEDIA_URL . '/partner';
    }

    /**
     * @return string
     */
    public static function getBasePath(): string
    {
        return MEDIA_PATH . '/partner';
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return ?string
     */
    public function getIconUrl(): ?string
    {
        if (file_exists(self::getBasePath() . '/' . $this->getId() . '.png')) {
            return self::getBaseUrl() . '/' . $this->getId() . '.png';
        }
        return null;
    }

    /* fin getters */

    /* début setters */

    /**
     * @param string $title titre
     *
     * @return static
     */
    public function setTitle(string $title): static
    {
        if ($this->title !== $title) {
            $this->title = $title;
            $this->modified_fields['title'] = true;
        }

        return $this;
    }

    /**
     * @param string $description description
     *
     * @return static
     */
    public function setDescription(string $description): static
    {
        if ($this->description !== $description) {
            $this->description = $description;
            $this->modified_fields['description'] = true;
        }

        return $this;
    }

    /**
     * @param string $url url
     *
     * @return static
     */
    public function setUrl(string $url): static
    {
        if ($this->url !== $url) {
            $this->url = $url;
            $this->modified_fields['url'] = true;
        }

        return $this;
    }

    /* fin setters */
}
