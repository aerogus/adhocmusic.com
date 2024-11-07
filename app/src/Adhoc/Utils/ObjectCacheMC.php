<?php

declare(strict_types=1);

namespace Adhoc\Utils;

/**
 * Cache Objet via MemCache
 *
 * pas de notion d'expiration
 *
 * le nom de la clé est de la forme "ClassName__pk1Value:pk2Value"
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class ObjectCacheMC implements ObjectCache
{
    /**
     * Retourne la valeur d'une clé
     *
     * @param string $key clé
     *
     * @return string|false
     */
    public static function get(string $key): string|false
    {
        Log::debug(__METHOD__ . ' ' . $key);

        return MemCache::getInstance()->get($key);
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
        Log::debug(__METHOD__ . ' ' . $key);

        return MemCache::getInstance()->set($key, $value);
    }

    /**
     * Efface une clé
     *
     * @param string $key clé
     *
     * @return bool
     */
    public static function delete(string $key): bool
    {
        Log::debug(__METHOD__ . ' ' . $key);

        return MemCache::getInstance()->delete($key);
    }
}
