<?php

/**
 * @package adhoc
 */

/**
 * Classe Departement
 * /!\ dépend de la classe Region
 *
 * @package adhoc
 * @author Guillaume Seznec <guillaume.seznec@gmail.com>
 */
class Departement
{
    /**
     * indices du tableau $tab_dep
     */
    const CLEREG = 0;
    const LIBDEP = 1;

    /**
     * codes régions FR
     * @see http://www.maxmind.com/app/fips_include
     */
    const ALS = 'C1';
    const AQU = '97';
    const AUV = '98';
    const BNO = '99';
    const BOU = 'A1';
    const BRE = 'A2';
    const CEN = 'A3';
    const CHA = 'A4';
    const COR = 'A5';
    const FRA = 'A6';
    const HNO = 'A7';
    const IDF = 'A8';
    const LAN = 'A9';
    const LIM = 'B1';
    const LOR = 'B2';
    const MID = 'B3';
    const NOR = 'B4';
    const PDL = 'B5';
    const PIC = 'B6';
    const POI = 'B7';
    const PAC = 'B8';
    const RHO = 'B9';

    /**
     * Tableau des Départements
     * array(code_department => array(code_region, libelle_departement)
     *
     * @var array
     * @todo vérifier les code regions
     */
    public static $_liste = array(
        '01' => array(self::RHO, "Ain"),
        '02' => array(self::PIC, "Aisne"),
        '03' => array(self::AUV, "Allier"),
        '04' => array(self::PAC, "Alpes de Haute Provence"),
        '05' => array(self::PAC, "Hautes Alpes"),
        '06' => array(self::PAC, "Alpes Maritimes"),
        '07' => array(self::RHO, "Ardèche"),
        '08' => array(self::CHA, "Ardennes"),
        '09' => array(self::MID, "Ariège"),
        '10' => array(self::CHA, "Aube"),
        '11' => array(self::LAN, "Aude"),
        '12' => array(self::MID, "Aveyron"),
        '13' => array(self::PAC, "Bouches du Rhône"),
        '14' => array(self::BNO, "Calvados"),
        '15' => array(self::AUV, "Cantal"),
        '16' => array(self::POI, "Charente"),
        '17' => array(self::POI, "Charente Maritime"),
        '18' => array(self::CEN, "Cher"),
        '19' => array(self::LIM, "Corrèze"),
        '2A' => array(self::COR, "Corse du Sud"),
        '2B' => array(self::COR, "Haute Corse"),
        '21' => array(self::BOU, "Côte d'or"),
        '22' => array(self::BRE, "Côtes d'Armor"),
        '23' => array(self::LIM, "Creuse"),
        '24' => array(self::AQU, "Dordogne"),
        '25' => array(self::FRA, "Doubs"),
        '26' => array(self::RHO, "Drôme"),
        '27' => array(self::HNO, "Eure"),
        '28' => array(self::CEN, "Eure et Loir"),
        '29' => array(self::BRE, "Finistère"),
        '30' => array(self::LAN, "Gard"),
        '31' => array(self::MID, "Haute Garonne"),
        '32' => array(self::MID, "Gers"),
        '33' => array(self::AQU, "Gironde"),
        '34' => array(self::LAN, "Hérault"),
        '35' => array(self::BRE, "Ille et Vilaine"),
        '36' => array(self::CEN, "Indre"),
        '37' => array(self::CEN, "Indre et Loire"),
        '38' => array(self::RHO, "Isère"),
        '39' => array(self::FRA, "Jura"),
        '40' => array(self::AQU, "Landes"),
        '41' => array(self::CEN, "Loir et Cher"),
        '42' => array(self::RHO, "Loire"),
        '43' => array(self::AUV, "Haute Loire"),
        '44' => array(self::PDL, "Loire Atlantique"),
        '45' => array(self::CEN, "Loiret"),
        '46' => array(self::MID, "Lot"),
        '47' => array(self::AQU, "Lot et Garonne"),
        '48' => array(self::LAN, "Lozère"),
        '49' => array(self::PDL, "Maine et Loire"),
        '50' => array(self::BNO, "Manche"),
        '51' => array(self::CHA, "Marne"),
        '52' => array(self::CHA, "Haute Marne"),
        '53' => array(self::PDL, "Mayenne"),
        '54' => array(self::LOR, "Meurthe et Moselle"),
        '55' => array(self::LOR, "Meuse"),
        '56' => array(self::BRE, "Morbihan"),
        '57' => array(self::LOR, "Moselle"),
        '58' => array(self::BOU, "Nièvre"),
        '59' => array(self::NOR, "Nord"),
        '60' => array(self::PIC, "Oise"),
        '61' => array(self::BNO, "Orne"),
        '62' => array(self::NOR, "Pas de Calais"),
        '63' => array(self::AUV, "Puy de dôme"),
        '64' => array(self::AQU, "Pyrénées-Atlantiques"),
        '65' => array(self::MID, "Hautes Pyrénées"),
        '66' => array(self::LAN, "Pyrénées Orientales"),
        '67' => array(self::ALS, "Bas Rhin"),
        '68' => array(self::ALS, "Haut Rhin"),
        '69' => array(self::RHO, "Rhône"),
        '70' => array(self::FRA, "Haute Saône"),
        '71' => array(self::BOU, "Saône et Loire"),
        '72' => array(self::PDL, "Sarthe"),
        '73' => array(self::RHO, "Savoie"),
        '74' => array(self::RHO, "Haute Savoie"),
        '75' => array(self::IDF, "Paris"),
        '76' => array(self::HNO, "Seine Maritime"),
        '77' => array(self::IDF, "Seine et Marne"),
        '78' => array(self::IDF, "Yvelines"),
        '79' => array(self::POI, "Deux-Sèvres"),
        '80' => array(self::PIC, "Somme"),
        '81' => array(self::MID, "Tarn"),
        '82' => array(self::MID, "Tarn et Garonne"),
        '83' => array(self::PAC, "Var"),
        '84' => array(self::PAC, "Vaucluse"),
        '85' => array(self::PDL, "Vendée"),
        '86' => array(self::POI, "Vienne"),
        '87' => array(self::LIM, "Haute-Vienne"),
        '88' => array(self::LOR, "Vosges"),
        '89' => array(self::BOU, "Yonne"),
        '90' => array(self::FRA, "Territoire de Belfort"),
        '91' => array(self::IDF, "Essonne"),
        '92' => array(self::IDF, "Hauts de Seine"),
        '93' => array(self::IDF, "Seine Saint Denis"),
        '94' => array(self::IDF, "Val de Marne"),
        '95' => array(self::IDF, "Val d'Oise"),
    );

    /**
     * retourne le tableau des départements français
     * on peut limiter à une région particulière
     * c'est trié par n° de département
     *
     * @return array[cleReg] = libelle
     */
    static function getHashTable($cleReg = null)
    {
        $out = [];
        foreach(self::$_liste as $cle => $info)
        {
            if(!is_null($cleReg)) {
                if($info[self::CLEREG] == $cleReg) {
                    $out[$cle] = $info[self::LIBDEP];
                }
            } else {
                $out[$cle] = $info[self::LIBDEP];
            }
        }
        return $out;
    }

    /**
     * retourne le nom d'un département
     *
     * @param int $cleDep
     * @return string
     */
    static function getName($cleDep)
    {
        $cleDep = str_pad($cleDep, 2, '0', STR_PAD_LEFT);
        if(self::isCleOk($cleDep)) {
            return self::$_liste[$cleDep][self::LIBDEP];
        }
        return false;
    }

    /**
     * retourne le code region d'un département
     *
     * @param int $cleDep
     * @return int
     */
    static function getRegion($cleDep)
    {
        $cleDep = str_pad($cleDep, 2, '0', STR_PAD_LEFT);
        if(self::isCleOk($cleDep)) {
            return self::$_liste[$cleDep][self::CLEREG];
        }
        return false;
    }

    /**
     * clé ok ?
     *
     * @param string
     * @return bool
     */
    static function isCleOk($cle)
    {
        $cle = str_pad($cle, 2, '0', STR_PAD_LEFT);
        if(array_key_exists($cle, self::getHashTable())) {
            return true;
        }
        return false;
    }
}
