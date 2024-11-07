<?php

declare(strict_types=1);

namespace Adhoc\Utils;

/**
 * Gestion des logs
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class Log
{
    public const DATE_FORMAT = 'c'; // ISO 8601

    // séquences d'échappement ansi
    public const COLOR_RED     = "\x1b[31m";
    public const COLOR_GREEN   = "\x1b[32m";
    public const COLOR_YELLOW  = "\x1b[33m";
    public const COLOR_CYAN    = "\x1b[36m";
    public const COLOR_WHITE   = "\x1b[37m";
    public const RESET         = "\x1b[0m";

    /**
     * @var ?string
     */
    public static ?string $PATH = null;

    /**
     * @param string $app
     *
     * @return string
     */
    public static function getLogFile(string $app): string
    {
        return $app . '-' . date('Ymd') . '.log';
    }

    /**
     * @return mixed
     */
    protected static function getOutput(): mixed
    {
        $sapi = php_sapi_name();

        if ($sapi === 'cli') {
            return STDOUT;
        } else {
            if (!is_null(self::$PATH)) {
                return fopen(self::$PATH . '/' . self::getLogFile($sapi), 'a');
            }
            return fopen(dirname(dirname(dirname(__DIR__))) . '/log/' . self::getLogFile($sapi), 'a');
        }
    }

    /**
     *
     */
    protected static function log(string $severity, string $msg): bool
    {
        $date = date(self::DATE_FORMAT);

        switch ($severity) {
            case 'DEBUG':
                $prefix = self::COLOR_CYAN . "  DEBUG" . self::RESET;
                break;
            case 'INFO':
                $prefix = self::COLOR_WHITE . "   INFO" . self::RESET;
                break;
            case 'WARNING':
                $prefix = self::COLOR_YELLOW . "WARNING" . self::RESET;
                break;
            case 'ERROR':
                $prefix = self::COLOR_RED . "  ERROR" . self::RESET;
                break;
            case 'SUCCESS':
                $prefix = self::COLOR_GREEN . "SUCCESS" . self::RESET;
                break;
            default:
                $prefix = '';
        }

        $fh = self::getOutput();
        $res = fwrite($fh, sprintf("%s %s %s\n", $date, $prefix, $msg));

        // on ne doit pas fermer STDOUT
        if (php_sapi_name() !== 'cli') {
            fclose($fh);
        }

        return (bool) $res;
    }

    /**
     * Affichage horodaté d'un message de DEBUG (mode debug uniquement)
     *
     * @param string $msg ligne de log
     *
     * @return bool
     */
    public static function debug(string $msg): bool
    {
        if (isset($_ENV['DEBUG_MODE']) && boolval($_ENV['DEBUG_MODE'])) {
            return self::log('DEBUG', $msg);
        }
        return false;
    }

    /**
     * Affichage horodaté d'un message d'INFO
     *
     * @param string $msg ligne de log
     *
     * @return bool
     */
    public static function info(string $msg): bool
    {
        return self::log('INFO', $msg);
    }

    /**
     * Affichage horodaté d'un message de WARNING
     *
     * @param string $msg ligne de log
     *
     * @return bool
     */
    public static function warning(string $msg): bool
    {
        return self::log('WARNING', $msg);
    }

    /**
     * Affichage horodaté d'un message d'ERREUR
     *
     * @param string $msg ligne de log
     *
     * @return bool
     */
    public static function error(string $msg): bool
    {
        return self::log('ERROR', $msg);
    }

    /**
     * Affichage horodaté d'un message de SUCCESS
     *
     * @param string $msg ligne de log
     *
     * @return bool
     */
    public static function success(string $msg): bool
    {
        return self::log('SUCCESS', $msg);
    }

    /**
     * Retourne le tableau des sévérités de logs
     *
     * @return array<string>
     */
    public static function getSeverities(): array
    {
        return [
            'DEBUG',
            'INFO',
            'WARNING',
            'ERROR',
            'SUCCESS',
        ];
    }
}
