<?php

class Controller
{
    /**
     * retourne le tableau code region / nom region
     * pour un pays donné, au format json
     *
     * @param string $_GET['c']
     * @return array
     */
    static function getregion()
    {
        $tab = array();

        if(!empty($_GET['c'])) {
            $c = strtoupper(substr($_GET['c'], 0, 2));
            $db = DataBase::getInstance();
            $sql = "SELECT `id_region`, `name` "
                 . "FROM `geo_world_region` "
                 . "WHERE `id_country` = '" . $db->escape($c) . "' "
                 . "ORDER BY `name` ASC";
            $res = $db->queryWithFetch($sql);
            foreach($res as $_res) {
                $tab[$_res['id_region']] = $_res['name'];
            }
        }

        return $tab;
    }

    /**
     * retourne le tableau code departement / nom departement
     * pour une région donnée, au format json
     * (France uniquement)
     *
     * @param string $_GET['r']
     */
    static function getdepartement()
    {
        $tab = array();

        if(!empty($_GET['r'])) {
            $r = substr($_GET['r'], 0, 2);
            $db = DataBase::getInstance();
            $sql = "SELECT `id_departement`, `name` "
                 . "FROM `geo_fr_departement` "
                 . "WHERE `id_world_region` = '".$db->escape($r)."' "
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
     * pour un departement donné, au format json
     * (France uniquement)
     *
     * @param string $_GET['d']
     */
    static function getcity()
    {
        $tab = array();

        if(!empty($_GET['d'])) {
            $d = substr($_GET['d'], 0, 3);
            $db = DataBase::getInstance();
            $sql = "SELECT `id_city`, `name`, `cp` "
                 . "FROM `geo_fr_city` "
                 . "WHERE `id_departement` = '".$db->escape($d)."' "
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
     * au format json
     * (France uniquement)
     *
     * @param string $_GET['v']
     */
    static function getlieu()
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
