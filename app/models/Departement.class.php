<?php

/**
 * @package adhoc
 */

/**
 * Classe Departement
 * /!\ dépend de la classe Region
 *
 * @package adhoc
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class Departement
{
    /**
     * Indices du tableau $tab_dep
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
     * [code_department => [code_region, libelle_departement]
     *
     * @var array
     * @todo vérifier les code regions
     */
    public static $_liste = [
        '01' => [self::RHO, "Ain"],
        '02' => [self::PIC, "Aisne"],
        '03' => [self::AUV, "Allier"],
        '04' => [self::PAC, "Alpes de Haute Provence"],
        '05' => [self::PAC, "Hautes Alpes"],
        '06' => [self::PAC, "Alpes Maritimes"],
        '07' => [self::RHO, "Ardèche"],
        '08' => [self::CHA, "Ardennes"],
        '09' => [self::MID, "Ariège"],
        '10' => [self::CHA, "Aube"],
        '11' => [self::LAN, "Aude"],
        '12' => [self::MID, "Aveyron"],
        '13' => [self::PAC, "Bouches du Rhône"],
        '14' => [self::BNO, "Calvados"],
        '15' => [self::AUV, "Cantal"],
        '16' => [self::POI, "Charente"],
        '17' => [self::POI, "Charente Maritime"],
        '18' => [self::CEN, "Cher"],
        '19' => [self::LIM, "Corrèze"],
        '2A' => [self::COR, "Corse du Sud"],
        '2B' => [self::COR, "Haute Corse"],
        '21' => [self::BOU, "Côte d'or"],
        '22' => [self::BRE, "Côtes d'Armor"],
        '23' => [self::LIM, "Creuse"],
        '24' => [self::AQU, "Dordogne"],
        '25' => [self::FRA, "Doubs"],
        '26' => [self::RHO, "Drôme"],
        '27' => [self::HNO, "Eure"],
        '28' => [self::CEN, "Eure et Loir"],
        '29' => [self::BRE, "Finistère"],
        '30' => [self::LAN, "Gard"],
        '31' => [self::MID, "Haute Garonne"],
        '32' => [self::MID, "Gers"],
        '33' => [self::AQU, "Gironde"],
        '34' => [self::LAN, "Hérault"],
        '35' => [self::BRE, "Ille et Vilaine"],
        '36' => [self::CEN, "Indre"],
        '37' => [self::CEN, "Indre et Loire"],
        '38' => [self::RHO, "Isère"],
        '39' => [self::FRA, "Jura"],
        '40' => [self::AQU, "Landes"],
        '41' => [self::CEN, "Loir et Cher"],
        '42' => [self::RHO, "Loire"],
        '43' => [self::AUV, "Haute Loire"],
        '44' => [self::PDL, "Loire Atlantique"],
        '45' => [self::CEN, "Loiret"],
        '46' => [self::MID, "Lot"],
        '47' => [self::AQU, "Lot et Garonne"],
        '48' => [self::LAN, "Lozère"],
        '49' => [self::PDL, "Maine et Loire"],
        '50' => [self::BNO, "Manche"],
        '51' => [self::CHA, "Marne"],
        '52' => [self::CHA, "Haute Marne"],
        '53' => [self::PDL, "Mayenne"],
        '54' => [self::LOR, "Meurthe et Moselle"],
        '55' => [self::LOR, "Meuse"],
        '56' => [self::BRE, "Morbihan"],
        '57' => [self::LOR, "Moselle"],
        '58' => [self::BOU, "Nièvre"],
        '59' => [self::NOR, "Nord"],
        '60' => [self::PIC, "Oise"],
        '61' => [self::BNO, "Orne"],
        '62' => [self::NOR, "Pas de Calais"],
        '63' => [self::AUV, "Puy de dôme"],
        '64' => [self::AQU, "Pyrénées-Atlantiques"],
        '65' => [self::MID, "Hautes Pyrénées"],
        '66' => [self::LAN, "Pyrénées Orientales"],
        '67' => [self::ALS, "Bas Rhin"],
        '68' => [self::ALS, "Haut Rhin"],
        '69' => [self::RHO, "Rhône"],
        '70' => [self::FRA, "Haute Saône"],
        '71' => [self::BOU, "Saône et Loire"],
        '72' => [self::PDL, "Sarthe"],
        '73' => [self::RHO, "Savoie"],
        '74' => [self::RHO, "Haute Savoie"],
        '75' => [self::IDF, "Paris"],
        '76' => [self::HNO, "Seine Maritime"],
        '77' => [self::IDF, "Seine et Marne"],
        '78' => [self::IDF, "Yvelines"],
        '79' => [self::POI, "Deux-Sèvres"],
        '80' => [self::PIC, "Somme"],
        '81' => [self::MID, "Tarn"],
        '82' => [self::MID, "Tarn et Garonne"],
        '83' => [self::PAC, "Var"],
        '84' => [self::PAC, "Vaucluse"],
        '85' => [self::PDL, "Vendée"],
        '86' => [self::POI, "Vienne"],
        '87' => [self::LIM, "Haute-Vienne"],
        '88' => [self::LOR, "Vosges"],
        '89' => [self::BOU, "Yonne"],
        '90' => [self::FRA, "Territoire de Belfort"],
        '91' => [self::IDF, "Essonne"],
        '92' => [self::IDF, "Hauts de Seine"],
        '93' => [self::IDF, "Seine Saint Denis"],
        '94' => [self::IDF, "Val de Marne"],
        '95' => [self::IDF, "Val d'Oise"],
    ];

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
        foreach (self::$_liste as $cle => $info)
        {
            if (!is_null($cleReg)) {
                if ($info[self::CLEREG] == $cleReg) {
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
        if (self::isCleOk($cleDep)) {
            return self::$_liste[$cleDep][self::LIBDEP];
        }
        return false;
    }

    /**
     * Retourne le code region d'un département
     *
     * @param int $cleDep
     *
     * @return int
     */
    static function getRegion($cleDep)
    {
        $cleDep = str_pad($cleDep, 2, '0', STR_PAD_LEFT);
        if (self::isCleOk($cleDep)) {
            return self::$_liste[$cleDep][self::CLEREG];
        }
        return false;
    }

    /**
     * Clé ok ?
     *
     * @param string
     * @return bool
     */
    static function isCleOk($cle)
    {
        $cle = str_pad($cle, 2, '0', STR_PAD_LEFT);
        if (array_key_exists($cle, self::getHashTable())) {
            return true;
        }
        return false;
    }
}
