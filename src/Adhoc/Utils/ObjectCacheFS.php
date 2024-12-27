<?php

declare(strict_types=1);

namespace Adhoc\Utils;

/**
 * Cache Objet via le système de fichier
 * (qui peut lui même être monté en mémoire pour + de performance)
 *
 * pas de notion d'expiration
 *
 * le nom de la clé est de la forme "ClassName__pk1Value:pk2Value"
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class ObjectCacheFS implements ObjectCache
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
        $path = self::getCachePath($key);
        Log::debug(__METHOD__ . ' ' . $key . ': ' . $path);

        if (file_exists($path)) {
            return file_get_contents($path);
        }
        return false;
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
        $path = self::getCachePath($key);
        Log::debug(__METHOD__ . ' ' . $key . ': ' . $path);

        if (!is_dir(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }

        if (file_put_contents($path, $value) !== false) {
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
    public static function delete(string $key): bool
    {
        $path = self::getCachePath($key);
        Log::debug(__METHOD__ . ' ' . $key . ': ' . $path);

        if (file_exists($path)) {
            if (unlink($path)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Retourne le chemin absolu du fichier de cache
     *
     * @param string $key
     *
     * @return string
     */
    protected static function getCachePath(string $key): string
    {
        $hash = md5(trim($key));

        $d0 = static::getBasePath();
        $d1 = substr($hash, 0, 1);
        $d2 = substr($hash, 1, 1);
        $d3 = substr($hash, 2, 1);

        return $d0 . '/' . $d1 . '/' . $d2 . '/' . $d3 . '/' . $hash . '.cache';
    }

    /**
     * Retourne le chemin racine du cache objet
     *
     * @return string
     */
    protected static function getBasePath(): string
    {
        if (!isset($_ENV['OBJECT_CACHE_PATH'])) {
            throw new \Exception('OBJECT_CACHE_PATH environment variable not set');
        }
        if (!is_dir($_ENV['OBJECT_CACHE_PATH'])) {
            throw new \Exception('OBJECT_CACHE_PATH not a directory');
        }
        return $_ENV['OBJECT_CACHE_PATH'];
    }
}
