<?php

/**
 * @package AdHoc
 */

/**
 * Différentes méthodes et données relatives aux dates
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 * @package AdHoc
 * @deprecated bientôt
 */
class Date
{
    /**
     *
     */
    public static $jours = ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"];
    public static $jours_courts = ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"];

    /**
     *
     */
    public static $mois = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
    public static $mois_courts = ["Jan", "Fév", "Mar", "Avr", "Mai", "Jui", "Jul", "Aoû", "Sep", "Oct", "Nov", "Déc"];

    // expressions regulières perl
    // [0-9] = \d
    public static $regexp_date = "/^(\d{4})-(\d{2})-(\d{2})$/";
    public static $regexp_time = "/^(\d{2}):(\d{2}):(\d{2})$/";
    public static $regexp_datetime = "/^(\d{4})-(\d{2})-(\d{2})\s+(\d{2}):(\d{2}):(\d{2})$/";

    /**
     * Fonction modulable de formatage de date MySQL
     *
     * @param string $datetime
     * @param string $format
     *
     * @return string
     */
    static function mysql_datetime($datetime, $format = "d/m/Y à H:i")
    {
        if (preg_match(self::$regexp_datetime, $datetime, $dt) && checkdate($dt[2], $dt[3], $dt[1])) {
            return date($format, mktime($dt[4], $dt[5], $dt[6], $dt[2], $dt[3], $dt[ 1]));
        }
        return false;
    }

    /**
     * Conversion Date MySQL en Timestamp
     * @param string $datetime
     * @return int
     */
    function mysql_to_timestamp($date)
    {
        if (!preg_match(self::$regexp_date, $date, $r)) {
            return false;
        }
        return mktime($r[4], $r[5], $r[6], $r[2], $r[3], $r[1]);
    }

    /**
     * C'est sensé faire la meme chose à peu près que mysql_datetime ...
     *
     * @param string|int (format mysql ou timestamp)
     * @return string
     */
    static function formatDate($time)
    {
        $time = is_numeric($time) ? $time : strtotime($time);
        return date('d/m/Y à H:i', $time);
    }

    /**
     * retourne si une date est valide
     *
     * @param string $date
     * @return bool
     */
    static function isDateOk($date)
    {
        if (preg_match(self::$regexp_date, $date, $regs)) {
            if (checkdate($regs[2], $regs[3], $regs[1])) {
                return true;
            }
        }
        return false;
    }

    /**
     * Retourne si une datetime mysql est valide
     *
     * @param string $date
     *
     * @return bool
     */
    static function isDateTimeOk($datetime)
    {
        if (preg_match(self::$regexp_datetime, $datetime, $regs)) {
            if (checkdate($regs[2], $regs[3], $regs[1])) {
                return true;
            }
        }
        return false;
    }
}