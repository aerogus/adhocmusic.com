<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\Reference\City;
use Adhoc\Model\Reference\WorldCountry;
use Adhoc\Model\Reference\WorldRegion;
use Adhoc\Utils\AdHocTwig;
use Adhoc\Utils\DataBase;
use Adhoc\Utils\Route;

/**
 *
 */
final class Controller
{
    /**
     * Retourne la liste des pays du monde [id_country => name, ...]
     *
     * @return array<string,string>
     */
    public static function countries(): array
    {
        $arr = [];
        foreach (WorldCountry::findAll() as $wc) {
            $arr[$wc->getIdCountry()] = $wc->getName();
        }
        return $arr;
    }

    /**
     * Retourne le tableau code region / nom region
     * pour un pays donné
     *
     * @return array<string,string>
     */
    public static function regions(): array
    {
        $id_country = (string) Route::params('id_country');
        $id_country = strtoupper(substr(trim($id_country), 0, 2));

        $regions = WorldRegion::find([
            'id_country' => $id_country,
        ]);

        $arr = [];
        foreach ($regions as $region) {
            if ($region->getIdCountry() === $id_country) {
                $arr[$region->getIdRegion()] = $region->getName();
            }
        }
        return $arr;
    }

    /**
     * Retourne le tableau code departement / nom departement
     * pour une région donnée
     * (France uniquement)
     *
     * @return array<string,string>
     */
    public static function departements(): array
    {
        $id_region = (string) Route::params('id_region');
        $id_region = strtoupper(substr(trim($id_region), 0, 2));

        $tab = [];

        $db = DataBase::getInstance();
        $sql  = "SELECT `id_departement`, `name` ";
        $sql .= "FROM `geo_fr_departement` ";
        $sql .= "WHERE 1 ";
        if (!empty($id_region)) {
            $sql .= "AND `id_region` = '" . $id_region . "' ";
        }
        $sql .= "ORDER BY `name` ASC";
        $res = $db->pdo->query($sql)->fetchAll();
        foreach ($res as $_res) {
            $tab[$_res['id_departement']] = $_res['name'];
        }

        return $tab;
    }

    /**
     * Retourne le tableau code ville / nom ville
     * pour un departement donné
     * (France uniquement)
     *
     * @return array<int,string>
     */
    public static function cities(): array
    {
        $tab = [];

        if (!empty($_GET['d'])) {
            $d = substr($_GET['d'], 0, 3);
            $db = DataBase::getInstance();
            $sql = "SELECT `id_city`, `name`, `cp` "
                 . "FROM `" . City::getDbTable() . "` "
                 . "WHERE `id_departement` = '" . $d . "' "
                 . "ORDER BY `name` ASC";
            $res = $db->pdo->query($sql)->fetchAll();
            foreach ($res as $_res) {
                $tab[(int) $_res['id_city']] = $_res['cp'] . " - " . ucwords(strtolower($_res['name']));
            }
        }

        return $tab;
    }

    /**
     * Retourne le tableau des lieux pour une ville donnée
     * (France uniquement)
     *
     * @return array<int,string>
     */
    public static function lieux(): array
    {
        $tab = [];

        if (!empty($_GET['v'])) {
            $id_city = (int) $_GET['v'];
            $db = DataBase::getInstance();
            $sql = "SELECT `id_lieu`, `name` "
                 . "FROM `adhoc_lieu` "
                 . "WHERE `id_city` = " . $id_city . " "
                 . "ORDER BY `name` ASC";
            $res = $db->pdo->query($sql)->fetchAll();
            foreach ($res as $_res) {
                $tab[(int) $_res['id_lieu']] = ucwords(strtolower($_res['name']));
            }
        }

        return $tab;
    }
}
