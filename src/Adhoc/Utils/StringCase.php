<?php

declare(strict_types=1);

namespace Adhoc\Utils;

/**
 * Utilitaire sur les casses de chaînes de caractères
 *
 * @see https://fr.wikipedia.org/wiki/Camel_case
 * @see https://fr.wikipedia.org/wiki/Snake_case
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */

class StringCase
{
    /**
     * @param string $str
     *
     * @return string
     */
    public static function upper(string $str): string
    {
        return strtoupper($str);
    }

    /**
     * @param string $str
     *
     * @return string
     */
    public static function lower(string $str): string
    {
        return strtolower($str);
    }

    /**
     * @param string $str
     *
     * @return string
     */
    public static function snakeToCamel(string $str): string
    {
        return self::snakeToLowerCamel($str);
    }

    /**
     * @param string $str
     *
     * @return string
     */
    public static function snakeToLowerCamel(string $str): string
    {
        $str = str_replace('-', '', $str);
        $str = str_replace('_', ' ', $str);
        $str = ucwords($str);
        $str = str_replace(' ', '', $str);
        $str = lcfirst($str);

        return $str;
    }

    /**
     * @param string $str
     *
     * @return string
     */
    public static function snakeToUpperCamel(string $str): string
    {
        $str = str_replace('-', '', $str);
        $str = str_replace('_', ' ', $str);
        $str = ucwords($str);
        $str = str_replace(' ', '', $str);
        $str = ucfirst($str);

        return $str;
    }

    /**
     * @param string $str
     *
     * @return string
     */
    public static function camelToLowerSnake(string $str): string
    {
        $str = str_replace('-', '', $str);
        $out = '';

        for ($i = 0; $i < mb_strlen($str); $i++) {
            $char = $str[$i];
            if (ctype_upper($char)) {
                $out .= '_' . strtolower($char);
            } else {
                $out .= $char;
            }
        }

        return ltrim($out, '_');
    }

    /**
     * @param string $str
     *
     * @return string
     */
    public static function camelToUpperSnake(string $str): string
    {
        $str = str_replace('-', '', $str);
        $out = '';

        for ($i = 0; $i < mb_strlen($str); $i++) {
            $char = $str[$i];
            if (ctype_upper($char)) {
                $out .= '_' . $char;
            } else {
                $out .= strtoupper($char);
            }
        }

        return ltrim($out, '_');
    }
}
