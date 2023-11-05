<?php

declare(strict_types=1);

namespace Adhoc\Model;

/**
 * Cache Objet
 *
 * Utilise le système de fichier
 * qui peut lui même être monté en mémoire pour + de performance
 *
 * pas de notion d'expiration
 *
 * le nom de la clé est de la forme "ClassName:pkValue" ou "ClassName:pk1Value:pk2Value"
 *
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class ObjectCache
{
    /**
     * Retourne le chemin du cache objet
     *
     * @return string
     */
    public static function getBasePath(): string
    {
        return OBJECT_CACHE_PATH;
    }

    /**
     * Retourne la valeur d'une clé
     *
     * @param string $key clé
     *
     * @return ?string
     */
    public static function get(string $key): ?string
    {
        if (file_exists(self::getBasePath() . '/' . $key)) {
            return file_get_contents(self::getBasePath() . '/' . $key);
        }
        return null;
    }

    /**
     * Set une clé
     * la créé si n'existe pas, la modifie si déjà existante
     *
     * @param string $key   clé
     * @param string $value valeur
     *
     * @return bool
     */
    public static function set(string $key, string $value): bool
    {
        if (file_put_contents(self::getBasePath() . '/' . $key, $value) !== false) {
            return true;
        }
        return false;
    }

    /**
     * Efface une clé
     *
     * @param string $key clé
     *
     * @return bool
     */
    public static function unset(string $key): bool
    {
        if (file_exists(self::getBasePath() . '/' . $key)) {
            if (unlink(self::getBasePath() . '/' . $key)) {
                return true;
            }
        }
        return false;
    }
}
