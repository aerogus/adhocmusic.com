<?php

class Controller
{
    static function search()
    {
        return self::index();
    }

    static function index()
    {
        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'home');

        $q = trim((string) Route::params('q'));

        $smarty->assign('title', "♫ Résultat de la recherche : " . stripslashes($q));
        $smarty->assign('description', "Association oeuvrant pour le développement de la vie musicale en Essonne depuis 1996. Promotion d'artistes, Pédagogie musicale, Agenda concerts, Communauté de musiciens ...");

        $smarty->assign('menuselected', 'search');

        $trail = Trail::getInstance();
        $trail->addStep("Recherche");

        $smarty->assign('show_form', true);
        $smarty->assign('show_results', true);
        $smarty->assign('q', $q);
        return $smarty->fetch('search/index.tpl');
    }

    static function autocomplete()
    {
        $type = (string) Route::params('type');
        $query = (string) Route::params('query');

        if(mb_strlen($query) < 2) {
            return array();
        }

        if(empty($type)) {
            $type = 'groupes';
        }

        $q = substr(preg_replace('/[^a-z0-9-]/', '', strtolower(trim($query))), 0, 24);

        $db = DataBase::getInstance();

        switch($type)
        {
            case 'membres':
                $sql = 'SELECT `pseudo` AS `name` '
                     . 'FROM `adhoc_membre` '
                     . 'WHERE `pseudo` LIKE "' . $db->escape($q) . '%" '
                     . 'ORDER BY `pseudo` ASC '
                     . 'LIMIT 0, 15';
                break;
            case 'groupes':
                $sql = 'SELECT `alias` AS `name` '
                     . 'FROM `adhoc_groupe` '
                     . 'WHERE `alias` LIKE "' . $db->escape($q) . '%" '
                     . 'ORDER BY `alias` ASC '
                     . 'LIMIT 0, 15';
                break;
            case 'lieux':
                $sql = 'SELECT `name` AS `name` '
                     . 'FROM `adhoc_lieu` '
                     . 'WHERE `name` LIKE "' . $db->escape($q) . '%" '
                     . 'ORDER BY `name` ASC '
                     . 'LIMIT 0, 15';
                break;
        }

        $words  = array();

        if ($res = $db->queryWithFetch($sql)) {
            foreach($res as $_res) {
                $words[] = $_res['name'];
            }
        }

        $db->close();

        return array($req, $words);
    }
}
