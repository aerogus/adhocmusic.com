<?php

declare(strict_types=1);

namespace Adhoc\Utils;

/**
 * Gestion du fil d'Ariane / Trail / BreadCrumbs
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class Trail
{
    /**
     * Instance de l'objet
     *
     * @var ?object
     */
    protected static ?object $instance = null;

    /**
     * Conteneur des données
     *
     * @var array<int,array<string,string>>
     */
    protected array $path = [];

    /**
     * @return object
     */
    public static function getInstance(): object
    {
        if (self::$instance instanceof Trail) {
            return self::$instance;
        }
        return new Trail();
    }

    /**
     *
     */
    public function __construct()
    {
        $this->addStep('Accueil', '/', "Retour à l'accueil");
        self::$instance = $this;
    }

    /**
     * Ajoute un élément au fil d'ariane
     *
     * @param string $title       titre
     * @param string $link        lien (optionnel)
     * @param string $description description (optionnel)
     *
     * @return Trail
     */
    public function addStep(string $title, string $link = '', string $description = ''): Trail
    {
        $this->path[] = [
            'title' => $title,
            'link' => $link,
            'description' => $description,
        ];
        return $this;
    }

    /**
     * Retourne le fil d'ariane
     *
     * @return array<int,array<string,string>>
     */
    public function getPath(): array
    {
        return $this->path;
    }
}
