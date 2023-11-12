<?php

declare(strict_types=1);

namespace Adhoc\Utils;

/**
 * Différentes méthodes et données relatives aux dates
 *
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 *
 * @deprecated bientôt. ah ?
 */
class Date
{
    /**
     * @var array<string>
     */
    public static $jours = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];

    /**
     * @var array<string>
     */
    public static $jours_courts = ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'];

    /**
     * @var array<string>
     */
    public static $mois = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];

    /**
     * @var array<string>
     */
    public static $mois_courts = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jui', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'];

    // expressions regulières perl
    // [0-9] = \d

    /**
     * @var string
     */
    public static string $regexp_date = "/^(\d{4})-(\d{2})-(\d{2})$/";

    /**
     * @var string
     */
    public static string $regexp_time = "/^(\d{2}):(\d{2}):(\d{2})$/";

    /**
     * @var string
     */
    public static string $regexp_datetime = "/^(\d{4})-(\d{2})-(\d{2})\s+(\d{2}):(\d{2}):(\d{2})$/";

    /**
     * Fonction modulable de formatage de date MySQL
     *
     * @param string $datetime datetime
     * @param string $format   format
     *
     * @return string|false
     */
    public static function mysqlDatetime(string $datetime, string $format = "d/m/Y à H:i"): string|false
    {
        if (preg_match(self::$regexp_datetime, $datetime, $dt) && checkdate((int) $dt[2], (int) $dt[3], (int) $dt[1])) {
            return date($format, mktime((int) $dt[4], (int) $dt[5], (int) $dt[6], (int) $dt[2], (int) $dt[3], (int) $dt[ 1]));
        }
        return false;
    }

    /**
     * Retourne si une date est valide
     *
     * @param string $date date format YYYY-MM-DD ?
     *
     * @return bool
     */
    public static function isDateOk(string $date)
    {
        if (preg_match(self::$regexp_date, $date, $regs)) {
            if (checkdate((int) $regs[2], (int) $regs[3], (int) $regs[1])) {
                return true;
            }
        }
        return false;
    }

    /**
     * Retourne si une datetime mysql est valide
     *
     * @param string $datetime datetime
     *
     * @return bool
     */
    public static function isDateTimeOk(string $datetime)
    {
        if (preg_match(self::$regexp_datetime, $datetime, $regs)) {
            if (checkdate((int) $regs[2], (int) $regs[3], (int) $regs[1])) {
                return true;
            }
        }
        return false;
    }
}
