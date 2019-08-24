<?php

/**
 * @package adhoc
 */

/**
 * Classe Style
 *
 * Classe de gestion des styles musicaux
 *
 * @package adhoc
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class Style
{
    /**
     * Codes style
     */
    const ROC =  1;
    const REG =  2;
    const TEC =  3;
    const MET =  4;
    const WOR =  5;
    const CHA =  6;
    const HIP =  7;
    const RNB =  8;
    const JAZ =  9;
    const FUN = 10;
    const DIS = 11;
    const CLA = 12;
    const POP = 13;
    const PRO = 14;
    const PUN = 15;
    const SKA = 16;
    const TRI = 17;
    const FUS = 18;
    const DUB = 19;
    const HEA = 20;
    const DRU = 21;
    const CEL = 22;
    const HOU = 23;
    const ELE = 24;
    const SOU = 25;
    const BLU = 26;
    const FES = 27;
    const RAI = 28;
    const FOL = 29;
    const LAT = 30;
    const COU = 31;

    /**
     * Tableau des Styles
     *
     * @var array
     */
    protected static $_liste = [
        self::ROC => "Rock",
        self::REG => "Reggae",
        self::TEC => "Techno",
        self::MET => "Métal",
        self::WOR => "World",
        self::CHA => "Chanson",
        self::HIP => "Hip Hop",
        self::RNB => "R'n'B",
        self::JAZ => "Jazz",
        self::FUN => "Funk",
        self::DIS => "Disco",
        self::CLA => "Classique",
        self::POP => "Pop",
        self::PRO => "Progressif",
        self::PUN => "Punk",
        self::SKA => "Ska",
        self::TRI => "Trip Hop",
        self::FUS => "Fusion",
        self::DUB => "Dub",
        self::HEA => "Heavy",
        self::DRU => "Drum 'n Bass",
        self::CEL => "Celtique",
        self::HOU => "House",
        self::ELE => "Electro",
        self::SOU => "Soul",
        self::BLU => "Blues",
        self::FES => "Festif",
        self::RAI => "Raï",
        self::FOL => "Folk",
        self::LAT => "Latino",
        self::COU => "Country",
    ];

    /**
     * Retourne le tableau de la liste
     *
     * @return array
     */
    static function getHashTable(): array
    {
        asort(self::$_liste);
        return self::$_liste;
    }

    /**
     * Retourne le libellé d'une clé de la liste
     *
     * @param int
     *
     * @return string
     */
    static function getName(int $cle): string
    {
        return self::$_liste[$cle];
    }

    /**
     *
     */
    static function isStyleOk(int $id_style): bool
    {
        if (array_key_exists($id_style, self::$_liste)) {
            return true;
        }
        return false;
    }
}
