<?php

declare(strict_types=1);

namespace Adhoc\Utils;

/**
 * Interface du Cache Objet
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
interface ObjectCache
{
    /**
     * Retourne la valeur d'une clé
     *
     * @param string $key clé
     *
     * @return string|false
     */
    public static function get(string $key): string|false;

    /**
     * Set une clé
     * la créé si n'existe pas, la modifie si déjà existante
     *
     * @param string $key   clé
     * @param string $value valeur
     *
     * @return bool
     */
    public static function set(string $key, string $value): bool;

    /**
     * Efface une clé
     *
     * @param string $key clé
     *
     * @return bool
     */
    public static function delete(string $key): bool;
}
