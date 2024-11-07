<?php

declare(strict_types=1);

namespace Adhoc\Utils;

/**
 * Classe d'accès au serveur memcached
 * l'extension php-memcached doit être activée
 *
 * - $_ENV['MEMCACHED_HOST']
 * - $_ENV['MEMCACHED_PORT']
 * - $_ENV['MEMCACHED_KEY_PREFIX']
 *
 * Usage:
 * $mc = MemCache::getInstance();
 * $mc->set('key', 'value')
 * $mc->get('key') // 'value'
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class MemCache
{
    /**
     * Conteneur de l'instance courante
     *
     * @var ?self
     */
    protected static ?self $instance = null;

    /**
     * Objet Mamcached
     *
     * @var ?\Memcached
     */
    protected ?\Memcached $mc = null;

    /**
     * Constructeur de la classe
     */
    public function __construct()
    {
        $this->open();

        self::$instance = $this;
    }

    /**
     * Renvoie une instance de l'objet, en re-utilisant une
     * existante si possible. Attention: appeler le constructeur soit même
     * sans passer par cette fonction écrasera toute instance stockée
     *
     * @return object
     */
    public static function getInstance(): object
    {
        if (is_null(self::$instance)) {
            return new self();
        }
        return self::$instance;
    }

    /**
     * Ouvre explicitement la connexion au serveur memcached
     *
     * @return bool
     */
    public function open(): bool
    {
        if (!isset($_ENV['MEMCACHED_HOST'])) {
            return false;
        } elseif (!isset($_ENV['MEMCACHED_PORT'])) {
            return false;
        } elseif (!isset($_ENV['MEMCACHED_KEY_PREFIX'])) {
            return false;
        } elseif (!extension_loaded('memcached')) {
            return false;
        } elseif (is_a($this->mc, '\\Memcached')) {
            return false;
        }

        $this->mc = new \Memcached();
        $this->mc->addServer($_ENV['MEMCACHED_HOST'], $_ENV['MEMCACHED_PORT']);

        return true;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param int $expiration (sec)
     *
     * @return bool
     */
    public function set(string $key, mixed $value, int $expiration = 60): bool
    {
        if (is_null($this->mc)) {
            return false;
        }

        $real_key = $_ENV['MEMCACHED_KEY_PREFIX'] . '_' . $key;

        return $this->mc->set($real_key, $value, $expiration);
    }

    /**
     * @param string $key
     */
    public function get(string $key): mixed
    {
        if (is_null($this->mc)) {
            return false;
        }

        $real_key = $_ENV['MEMCACHED_KEY_PREFIX'] . '_' . $key;

        return $this->mc->get($real_key);
    }

    /**
     * @param string $key
     */
    public function delete(string $key): mixed
    {
        if (is_null($this->mc)) {
            return false;
        }

        $real_key = $_ENV['MEMCACHED_KEY_PREFIX'] . '_' . $key;

        return $this->mc->delete($real_key);
    }

    /**
     * Ferme explicitement la connexion au serveur memcached
     *
     * @return bool
     */
    public function close(): bool
    {
        if (is_a($this->mc, '\\Memcached')) {
            $this->mc = null;
            return true;
        }

        return false;
    }

    /**
     *
     */
    public function getStats(): mixed
    {
        if (is_null($this->mc)) {
            return false;
        }

        return $this->mc->getStats();
    }

    /**
     *
     */
    public function getAllKeys(): mixed
    {
        if (is_null($this->mc)) {
            return false;
        }

        return $this->mc->getAllKeys();
    }
}
