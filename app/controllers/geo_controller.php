<?php

class Controller
{
    /**
     * Retourne la liste des pays du monde
     *
     * @return array
     */
    static function countries()
    {
        return WorldCountry::getHashTable())
    }

    /**
     * retourne le tableau code region / nom region
     * pour un pays donné
     *
     * @param string $_GET['c']
     * @return array
     */
    static function regions()
    {
        if(empty($_GET['c']) {
            return array();
        }
        $c = strtoupper(substr(trim((string) $_GET['c']), 0, 2));

        $regions = WorldRegion::getHashTable();

        if(array_key_exists($c, $regions)) {
            return $regions[$c];
        }

        return array();
    }

    /**
     * retourne le tableau code departement / nom departement
     * pour une région donnée
     * (France uniquement)
     *
     * @param string $_GET['r']
     * @return array
     */
    static function departements()
    {
        $tab = array();

        if(!empty($_GET['r'])) {
            $r = substr($_GET['r'], 0, 2);
            $db = DataBase::getInstance();
            $sql = "SELECT `id_departement`, `name` "
                 . "FROM `geo_fr_departement` "
                 . "WHERE `id_world_region` = '" . $db->escape($r) . "' "
                 . "ORDER BY `name` ASC";
            $res = $db->queryWithFetch($sql);
            foreach($res as $_res) {
                $tab[$_res['id_departement']] = $_res['name'];
            }
        }

        return $tab;
    }

    /**
     * retourne le tableau code ville / nom ville
     * pour un departement donné
     * (France uniquement)
     *
     * @param string $_GET['d']
     * @return array
     */
    static function cities()
    {
        $tab = array();

        if(!empty($_GET['d'])) {
            $d = substr($_GET['d'], 0, 3);
            $db = DataBase::getInstance();
            $sql = "SELECT `id_city`, `name`, `cp` "
                 . "FROM `geo_fr_city` "
                 . "WHERE `id_departement` = '" . $db->escape($d) . "' "
                 . "ORDER BY `name` ASC";
            $res = $db->queryWithFetch($sql);
            foreach($res as $_res) {
                $tab[$_res['id_city']] = $_res['cp'] . " - " . ucwords(strtolower($_res['name']));
            }
        }

        return $tab;
    }

    /**
     * retourne le tableau des lieux pour une ville donnée
     * (France uniquement)
     *
     * @param string $_GET['v']
     * @return array
     */
    static function lieux()
    {
        $tab = array();

        if(!empty($_GET['v'])) {
            $id_city = (int) $_GET['v'];
            $db = DataBase::getInstance();
            $sql = "SELECT `id_lieu`, `name` "
                 . "FROM `adhoc_lieu` "
                 . "WHERE `id_city` = " . (int) $id_city . " "
                 . "ORDER BY `name` ASC";
            $res = $db->queryWithFetch($sql);
            foreach($res as $_res) {
                $tab[$_res['id_lieu']] = ucwords(strtolower($_res['name']));
            }
        }

        return $tab;
    }
}
