<?php

/**
 * @package adhoc
 */

/**
 * Classe de statistiques
 *
 * @package adhoc
 * @author Guillaume Seznec <guillaume.seznec@gmail.com>
 */
class Stats extends ObjectModel
{
    /* base de référence des dates */
    const DATDEB = '2002-01-01';

    /* */
    const LIEU_URL   = '/lieux/{ID}';
    const GROUP_URL  = '/groupes/{ID}';
    const PROFIL_URL = '/membres/{ID}';
    const EVENT_URL  = '/events/{ID}';

    /* */
    const BARGRAPH_MAX_WIDTH = 650;

    /**
     * retourne le nombre d'inscriptions membres, par jour, depuis le début
     *
     * @todo par mois et année
     * @return array
     */
    static function getNbInscriptionMembreByMonth()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(`id_contact`) AS `nb`, DATE_FORMAT(`created_on`, '%Y-%m') AS `date`, UNIX_TIMESTAMP(`created_on`) * 1000 AS `ts` "
             . "FROM `".self::$_db_table_membre."` "
             . "GROUP BY DATE_FORMAT(`created_on`, '%Y-%m') "
             . "ORDER BY `created_on` ASC";

        $res  = $db->queryWithFetch($sql);
        list($total, $max) = self::getTotalAndMax($res, 'nb');

        $cpt = 0;
        foreach($res as $_res) {
            $res[$cpt]['bargraph'] = self::getBarGraph($_res['nb'], $max);
            $cpt++;
        }

        $out  = array(
            'data'  => $res,
            'cols'  => array('Date', 'Nb', 'Graphe'),
            'keys'  => array('date', 'nb', 'bargraph'),
            'total' => $total,
            'max'   => $max
        );

        return $out;
    }

    /**
     * retourne le nombre d'inscriptions groupes, par jour, depuis le début
     *
     * @todo par mois et année
     * @return array
     */
    static function getNbInscriptionGroupeByMonth()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(`id_groupe`) AS `nb`, DATE_FORMAT(`created_on`, '%Y-%m') AS `date`, UNIX_TIMESTAMP(`created_on`) * 1000 AS `ts` "
             . "FROM `".self::$_db_table_groupe."` "
             . "GROUP BY DATE_FORMAT(`created_on`, '%Y-%m') "
             . "ORDER BY `created_on` ASC";

        $res  = $db->queryWithFetch($sql);
        list($total, $max) = self::getTotalAndMax($res, 'nb');

        $cpt = 0;
        foreach($res as $_res) {
            $res[$cpt]['bargraph'] = self::getBarGraph($_res['nb'], $max);
            $cpt++;
        }

        $out  = array(
            'data'  => $res,
            'cols'  => array('Date', 'Nb', 'Graphe'),
            'keys'  => array('date', 'nb', 'bargraph'),
            'total' => $total,
            'max'   => $max
        );

        return $out;
    }

    /**
     * @return array
     */
    static function getTopMembresInSpinoly()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `".self::$_db_table_membre."`.`id_contact` AS `contact_id`, `".self::$_db_table_membre."`.`name` AS `membre_name`, `".self::$_db_table_membre."`.`first_name` AS `membre_first_name`, "
             . "`".self::$_db_table_groupe."`.`id_groupe` AS `groupe_id`, `".self::$_db_table_groupe."`.`name` AS `groupe_name`, "
             . "`".self::$_db_table_event."`.`id_event` AS `event_id`, `".self::$_db_table_event."`.`date` AS `event_date`, `".self::$_db_table_event."`.`name` AS `event_name` "
             . "FROM `".self::$_db_table_membre."`, `".self::$_db_table_appartient_a."`, `".self::$_db_table_event."`, `".self::$_db_table_participe_a."`, `".self::$_db_table_groupe."`, `".self::$_db_table_organise_par."` "
             . "WHERE `".self::$_db_table_event."`.`id_event` = `".self::$_db_table_organise_par."`.`id_event` "
             . "AND `".self::$_db_table_participe_a."`.`id_event` = `".self::$_db_table_event."`.`id_event` "
             . "AND `".self::$_db_table_membre."`.`id_contact` = `".self::$_db_table_apprtient_a."`.`id_contact` "
             . "AND `".self::$_db_table_apprtient_a."`.`id_groupe` = `".self::$_db_table_groupe."`.`id_groupe` "
             . "AND `".self::$_db_table_participe_a."`.`id_groupe` = `".self::$_db_table_groupe."`.`id_groupe` "
             . "AND `".self::$_db_table_organise_par."`.`id_structure` = 1 "
             . "AND `".self::$_db_table_event."`.`id_lieu` IN(1, 383, 404, 507) "
             . "ORDER BY `".self::$_db_table_event."`.`date` DESC ";

        return $db->queryWithFetch($sql);
    }

    /**
     * @return array
     */
    static function getTopGroupesInSpinoly()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `".self::$_db_table_groupe."`.`id_groupe` AS `groupe_id`, `".self::$_db_table_groupe."`.`name` AS `groupe_name`, "
             . "`".self::$_db_table_event."`.`id_event` AS `event_id`, `".self::$_db_table_event."`.`name` AS `event_name`, `".self::$_db_table_event."`.`date` AS `event_date` "
             . "FROM `".self::$_db_table_event."`, `".self::$_db_table_participe_a."`, `".self::$_db_table_groupe."`, `".self::$_db_table_organise_par."` "
             . "WHERE `".self::$_db_table_event."`.`id_event` = `".self::$_db_table_organise_par."`.`id_event` "
             . "AND `".self::$_db_table_participe_a."`.`id_event` = `".self::$_db_table_event."`.`id_event` "
             . "AND `".self::$_db_table_participe_a."`.`id_groupe` = `".self::$_db_table_groupe."`.`id_groupe` "
             . "AND `".self::$_db_table_organise_par."`.`id_structure` = 1 "
             . "AND `".self::$_db_table_event."`.`id_lieu` IN(1, 383, 404, 507) "
             . "ORDER BY `".self::$_db_table_event."`.`date` DESC ";

        return $db->queryWithFetch($sql);
    }

    /**
     * récupère la liste des membres ayant posté le plus de dates
     *
     * @return array
     */
    static function getTopEventsSenders()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `".self::$_db_table_membre."`.`pseudo`, `".self::$_db_table_event."`.`id_contact`, COUNT(`".self::$_db_table_event."`.`id_event`) AS `nb` "
             . "FROM (`".self::$_db_table_event."`) "
             . "LEFT JOIN `".self::$_db_table_membre."` ON (`".self::$_db_table_event."`.`id_contact` = `".self::$_db_table_membre."`.`id_contact`) "
             . "GROUP BY `".self::$_db_table_event."`.`id_contact` "
             . "ORDER BY `nb` DESC "
             . "LIMIT 0, 500";

        $res  = $db->queryWithFetch($sql);
        list($total, $max) = self::getTotalAndMax($res, 'nb');

        $cpt = 0;
        foreach($res as $_res) {
            $res[$cpt]['bargraph'] = self::getBarGraph($_res['nb'], $max);
            $res[$cpt]['profil'] = "<a href=\"/membres/".$_res['id_contact']."\">".$_res['pseudo']."</a>";
            $cpt++;
        }

        $out  = array(
            'data'  => $res,
            'cols'  => array('Membre', 'Nb', 'Graphe'),
            'keys'  => array('profil', 'nb', 'bargraph'),
            'total' => $total,
            'max'   => $max
        );

        return $out;
    }

    /**
     * récupère la liste des membres ayant posté le plus de lieux
     *
     * @return array
     */
    static function getTopLieuxSenders()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `".self::$_db_table_membre."`.`pseudo`, `".self::$_db_table_lieu."`.`id_contact`, COUNT(`".self::$_db_table_lieu."`.`id_lieu`) AS `nb` "
             . "FROM `".self::$_db_table_lieu."` "
             . "LEFT JOIN `".self::$_db_table_membre."` ON (`".self::$_db_table_lieu."`.`id_contact` = `".self::$_db_table_membre."`.`id_contact`) "
             . "GROUP BY `".self::$_db_table_lieu."`.`id_contact` "
             . "ORDER BY `nb` DESC "
             . "LIMIT 0, 500";

        $res  = $db->queryWithFetch($sql);
        list($total, $max) = self::getTotalAndMax($res, 'nb');

        $cpt = 0;
        foreach($res as $_res) {
            $res[$cpt]['bargraph'] = self::getBarGraph($_res['nb'], $max);
            $cpt++;
        }

        $out  = array(
            'data'  => $res,
            'cols'  => array('Pseudo', 'Nb', 'Graphe'),
            'keys'  => array('pseudo', 'nb', 'bargraph'),
            'total' => $total,
            'max'   => $max,
        );

        return $out;
    }

    /**
     * récupère la liste des lieux avec le plus d'événements liés
     *
     * @return array
     */
    static function getTopLieux()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `".self::$_db_table_lieu."`.`id_lieu`, COUNT(`".self::$_db_table_event."`.`id_lieu`) AS `nb`, `".self::$_db_table_lieu."`.`name` AS `nom_lieu` "
             . "FROM `".self::$_db_table_event."`, `".self::$_db_table_lieu."` "
             . "WHERE `".self::$_db_table_event."`.`id_lieu` = `".self::$_db_table_lieu."`.`id_lieu` "
             . "GROUP BY `".self::$_db_table_event."`.`id_lieu` "
             . "ORDER BY `nb` DESC "
             . "LIMIT 0, 500";

        $res  = $db->queryWithFetch($sql);
        list($total, $max) = self::getTotalAndMax($res, 'nb');

        $cpt = 0;
        foreach($res as $_res) {
            $res[$cpt]['bargraph'] = self::getBarGraph($_res['nb'], $max);
            $cpt++;
        }

        $out  = array(
            'data'  => $res,
            'cols'  => array('Lieu', 'Nb', 'Graphe'),
            'keys'  => array('nom_lieu', 'nb', 'bargraph'),
            'total' => $total,
            'max'   => $max,
        );

        return $out;
    }

    /**
     * récupère le nombre de lieux référencés par département
     *
     * @return array
     */
    static function getNbLieuxByDepartement()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_departement`, COUNT(`id_lieu`) AS `nb` "
             . "FROM `" . self::$_db_table_lieu . "` "
             . "GROUP BY `id_departement` "
             . "ORDER BY `nb` DESC";

        $rows = $db->queryWithFetch($sql);

        list($total, $max) = self::getTotalAndMax($rows, 'nb');

        $cpt = 0;
        $data = array();

        foreach($rows as $row) {
            $data[$cpt] = $row;
            $data[$cpt]['bargraph'] = self::getBarGraph($row['nb'], $max);
            $data[$cpt]['nom_departement'] = Departement::getName($row['id_departement']);
            $cpt++;
        }

        $out = array(
            'data'  => $data,
            'cols'  => array('Département', 'Nb', 'Graphe'),
            'keys'  => array('nom_departement', 'nb', 'bargraph'),
            'total' => $total,
            'max'   => $max,
        );

        return $out;
    }

    /**
     * récupère le nombre de lieux référencés par région
     *
     * @return array
     */
    static function getNbLieuxByRegion()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_departement`, COUNT(`id_lieu`) AS `nb` "
             . "FROM `".self::$_db_table_lieu."` "
             . "GROUP BY `id_departement` "
             . "ORDER BY `nb` DESC";

        $rows = $db->queryWithFetch($sql);

        $data = array();

        foreach($rows as $row) {
            if($reg = Departement::getRegion($row['id_departement'])) {
                if(array_key_exists($reg, $data)) {
                    $data[$reg]['nb'] += $row['nb'];
                } else {
                    $data[$reg] = array(
                        'id_region' => $reg,
                        'nom_region' => WorldRegion::getName('FR', $reg),
                        'nb' => $row['nb'],
                    );
                }
            }
        }

        list($total, $max) = self::getTotalAndMax($data, 'nb');

        foreach($data as $_reg => $_data) {
            $data[$_reg]['bargraph'] = self::getBarGraph($_data['nb'], $max);
        }

        $out = array(
            'data'  => $data,
            'cols'  => array('Région', 'Nb', 'Graphe'),
            'keys'  => array('nom_region', 'nb', 'bargraph'),
            'total' => $total,
            'max'   => $max,
        );

        return $out;
    }

    /**
     * retourne le nombre d'événements annoncés dans l'agenda, par mois
     *
     * @return array
     */
    static function getNbEventsByMonth()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT DATE_FORMAT(`date`, '%Y-%m') AS `date`, COUNT(`id_event`) AS `nb` "
             . "FROM `".self::$_db_table_event."` "
             . "GROUP BY DATE_FORMAT(`date`, '%Y-%m') "
             . "ORDER BY DATE_FORMAT(`date`, '%Y-%m') ASC";

        $res  = $db->queryWithFetch($sql);
        list($total, $max) = self::getTotalAndMax($res, 'nb');

        $cpt = 0;
        foreach($res as $_res) {
            $res[$cpt]['bargraph'] = self::getBarGraph($_res['nb'], $max);
            $cpt++;
        }

        $out  = array(
            'data'  => $res,
            'cols'  => array('Mois', 'Nb', 'Graphe'),
            'keys'  => array('date', 'nb', 'bargraph'),
            'total' => $total,
            'max'   => $max,
        );

        return $out;
    }

    /**
     * récupère la liste des membres ayant posté le plus de messages
     * dans les forums
     *
     * @return array
     */
    static function getTopMessagesForumsSenders()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `".self::$_db_table_membre."`.`pseudo`, `".self::$_db_table_forums."`.`created_by`, COUNT(`".self::$_db_table_forums."`.`id_message`) AS `nb` "
             . "FROM `".self::$_db_table_forums."` "
             . "LEFT JOIN `".self::$_db_table_membre."` ON (`".self::$_db_table_forums."`.`created_by` = `".self::$_db_table_membre."`.`id_contact`) "
             . "GROUP BY `".self::$_db_table_forums."`.`created_by` "
             . "ORDER BY `nb` DESC "
             . "LIMIT 0, 500";

        $res  = $db->queryWithFetch($sql);
        list($total, $max) = self::getTotalAndMax($res, 'nb');

        $cpt = 0;
        foreach($res as $_res) {
            $res[$cpt]['bargraph'] = self::getBarGraph($_res['nb'], $max);
            $cpt++;
        }

        $out  = array(
            'data'  => $res,
            'cols'  => array('Pseudo', 'Nb', 'Graphe'),
            'keys'  => array('pseudo', 'nb', 'bargraph'),
            'total' => $total,
            'max'   => $max,
        );

        return $out;
    }

    /**
     * récupère la liste des membres ayant posté le plus d'audios
     *
     * @return array
     */
    static function getTopAudiosSenders()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `".self::$_db_table_membre."`.`pseudo`, `".self::$_db_table_audio."`.`id_contact`, COUNT(`".self::$_db_table_audio."`.`id_audio`) AS `nb` "
             . "FROM `".self::$_db_table_audio."` "
             . "LEFT JOIN `".self::$_db_table_membre."` ON (`".self::$_db_table_audio."`.`id_contact` = `".self::$_db_table_membre."`.`id_contact`) "
             . "GROUP BY `".self::$_db_table_audio."`.`id_contact` "
             . "ORDER BY `nb` DESC "
             . "LIMIT 0, 500";

        $res  = $db->queryWithFetch($sql);
        list($total, $max) = self::getTotalAndMax($res, 'nb');

        $cpt = 0;
        foreach($res as $_res) {
            $res[$cpt]['bargraph'] = self::getBarGraph($_res['nb'], $max);
            $cpt++;
        }

        $out  = array(
            'data'  => $res,
            'cols'  => array('Pseudo', 'Nb', 'Graphe'),
            'keys'  => array('pseudo', 'nb', 'bargraph'),
            'total' => $total,
            'max'   => $max,
        );

        return $out;
    }

    /**
     * récupère la liste des membres ayant posté le plus de vidéos
     *
     * @return array
     */
    static function getTopVideosSenders()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `".self::$_db_table_membre."`.`pseudo`, `".self::$_db_table_video."`.`id_contact`, COUNT(`".self::$_db_table_video."`.`id_video`) AS `nb` "
             . "FROM `".self::$_db_table_video."` "
             . "LEFT JOIN `".self::$_db_table_membre."` ON (`".self::$_db_table_video."`.`id_contact` = `".self::$_db_table_membre."`.`id_contact`) "
             . "GROUP BY `".self::$_db_table_video."`.`id_contact` "
             . "ORDER BY `nb` DESC "
             . "LIMIT 0, 500";

        $res  = $db->queryWithFetch($sql);
        list($total, $max) = self::getTotalAndMax($res, 'nb');

        $cpt = 0;
        foreach($res as $_res) {
            $res[$cpt]['bargraph'] = self::getBarGraph($_res['nb'], $max);
            $cpt++;
        }

        $out  = array(
            'data'  => $res,
            'cols'  => array('Pseudo', 'Nb', 'Graphe'),
            'keys'  => array('pseudo', 'nb', 'bargraph'),
            'total' => $total,
            'max'   => $max,
        );

        return $out;
    }

    /**
     * récupère la liste des membres ayant posté le plus de photos
     *
     * @return array
     */
    static function getTopPhotosSenders()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `".self::$_db_table_membre."`.`pseudo`, `".self::$_db_table_photo."`.`id_contact`, COUNT(`".self::$_db_table_photo."`.`id_photo`) AS `nb` "
             . "FROM `".self::$_db_table_photo."` "
             . "LEFT JOIN `".self::$_db_table_membre."` ON (`".self::$_db_table_photo."`.`id_contact` = `".self::$_db_table_membre."`.`id_contact`) "
             . "GROUP BY `".self::$_db_table_photo."`.`id_contact` "
             . "ORDER BY `nb` DESC "
             . "LIMIT 0, 500";

        $res  = $db->queryWithFetch($sql);
        list($total, $max) = self::getTotalAndMax($res, 'nb');

        $cpt = 0;
        foreach($res as $_res) {
            $res[$cpt]['bargraph'] = self::getBarGraph($_res['nb'], $max);
            $cpt++;
        }

        $out  = array(
            'data'  => $res,
            'cols'  => array('Pseudo', 'Nb', 'Graphe'),
            'keys'  => array('pseudo', 'nb', 'bargraph'),
            'total' => $total,
            'max'   => $max,
        );

        return $out;
    }

    /**
     * récupère la liste des groupes les plus visités
     *
     * @return array
     */
    static function getTopVisitesGroupes()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_groupe`, `name` AS `nom_groupe`, `visite` AS `nb` "
             . "FROM `".self::$_db_table_groupe."` "
             . "ORDER BY `visite` DESC";

        $res  = $db->queryWithFetch($sql);
        list($total, $max) = self::getTotalAndMax($res, 'nb');

        $cpt = 0;
        foreach($res as $_res) {
            $res[$cpt]['bargraph'] = self::getBarGraph($_res['nb'], $max);
            $cpt++;
        }

        $out  = array(
            'data'  => $res,
            'cols'  => array('Groupe', 'Nb', 'Graphe'),
            'keys'  => array('nom_groupe', 'nb', 'bargraph'),
            'total' => $total,
            'max'   => $max,
        );

        return $out;
    }

    /**
     * récupère les derniers membres loggués sur le site
     *
     * @param int $limit
     * @return array
     */
    static function getLastConnexions($limit = 10)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_contact`, `pseudo`, DATE_FORMAT(`visited_on`, '%d/%m/%Y %H:%i:%s') AS `datetime` "
             . "FROM `".self::$_db_table_membre."` "
             . "ORDER BY `visited_on` DESC "
             . "LIMIT 0, ".(int) $limit;

        $res  = $db->queryWithFetch($sql);

        $out  = array(
            'data'  => $res,
            'cols'  => array('Pseudo', 'Date'),
            'keys'  => array('pseudo', 'datetime'),
            'total' => 0,
            'max'   => 0,
        );

        return $out;
    }

    /**
     * récupère la liste des membres ayant été les plus taggés
     *
     * @param int $limit
     * @return array
     */
    static function getTopTagges($limit = 10)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `".self::$_db_table_membre."`.`pseudo`, `".self::$_db_table_membre."`.`id_contact`, COUNT(*) AS `nb` "
             . "FROM `".self::$_db_table_membre."`, `".self::$_db_table_est_marque_sur."` "
             . "WHERE `".self::$_db_table_membre."`.`id_contact` = `".self::$_db_table_membre."`.`id_contact` "
             . "AND `".self::$_db_table_est_marque_sur."`.`id_contact` = `".self::$_db_table_membre."`.`id_contact` "
             . "GROUP BY `".self::$_db_table_est_marque_sur."`.`id_contact` "
             . "ORDER BY `nb` DESC "
             . "LIMIT 0, ".(int) $limit;

        $res  = $db->queryWithFetch($sql);
        list($total, $max) = self::getTotalAndMax($res, 'nb');

        $cpt = 0;
        foreach($res as $_res) {
            $res[$cpt]['bargraph'] = self::getBarGraph($_res['nb'], $max);
            $cpt++;
        }

        $out  = array(
            'data'  => $res,
            'cols'  => array('Pseudo', 'Nb', 'Graphe'),
            'keys'  => array('pseudo', 'nb', 'bargraph'),
            'total' => $total,
            'max'   => $max,
        );

        return $out;
    }

    /**
     * récupère la liste des membres ayant taggé le plus de photos
     *
     * @param int $limit
     * @return array
     */
    static function getTopTaggeurs($limit = 10)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `".self::$_db_table_membre."`.`pseudo`, `".self::$_db_table_membre."`.`id_contact`, COUNT(*) AS `nb` "
             . "FROM `".self::$_db_table_membre."`, `".self::$_db_table_est_marque_sur."` "
             . "WHERE `".self::$_db_table_est_marque_sur."`.`tagge_par` = `".self::$_db_table_membre."`.`id_contact` "
             . "GROUP BY `".self::$_db_table_est_marque_sur."`.`tagge_par` "
             . "ORDER BY `nb` DESC "
             . "LIMIT 0, ".(int) $limit;

        $res  = $db->queryWithFetch($sql);
        list($total, $max) = self::getTotalAndMax($res, 'nb');

        $cpt = 0;
        foreach($res as $_res) {
            $res[$cpt]['bargraph'] = self::getBarGraph($_res['nb'], $max);
            $cpt++;
        }

        $out  = array(
            'data'  => $res,
            'cols'  => array('Pseudo', 'Nb', 'Graphe'),
            'keys'  => array('pseudo', 'nb', 'bargraph'),
            'total' => $total,
            'max'   => $max,
        );

        return $out;
    }

    /**
     * récupère la liste des lieux ayant le + de photos
     *
     * @param int $limit
     * @return array
     */
    static function getTopPhotosLieux()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `l`.`id_lieu`, `l`.`name`, COUNT(*) AS `nb` "
             . "FROM `" . self::$_db_table_lieu . "` `l`, `" . self::$_db_table_photo . "` `p` "
             . "WHERE `l`.`id_lieu` = `p`.`id_lieu` "
             . "GROUP BY `p`.`id_lieu` "
             . "ORDER BY `nb` DESC";

        $res  = $db->queryWithFetch($sql);
        list($total, $max) = self::getTotalAndMax($res, 'nb');

        $cpt = 0;
        foreach($res as $_res) {
            $res[$cpt]['bargraph'] = self::getBarGraph($_res['nb'], $max);
            $cpt++;
        }

        $out  = array(
            'data'  => $res,
            'cols'  => array('Lieu', 'Nb', 'Graphe'),
            'keys'  => array('name', 'nb', 'bargraph'),
            'total' => $total,
            'max'   => $max,
        );

        return $out;
    }

    /**
     * retourne les comptes pour un nom de domaine d'email donné
     *
     * @param string $domaine
     * @return array
     */
    static function getEmailsForDomaine($domaine)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_contact`, `email`, `lastnl` "
             . "FROM `" . self::$_db_table_contact . "` "
             . "WHERE `email` LIKE '%" . $db->escape($domaine) . "'";

        $res  = $db->queryWithFetch($sql);

        $out  = array(
            'data'  => $res,
            'cols'  => array('id_contact', 'Email', 'Ouverture Newsletter'),
            'keys'  => array('id_contact', 'email', 'lastnl'),
            'total' => 0,
            'max'   => 0,
        );

        return $out;
    }

    /**
     * retourne les différents domaines présents dans la table contact
     *
     * @return array
     */
    static function getEmailsDomaines()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT SUBSTRING(`email`, INSTR(`email`,'@') + 1) AS `domaine`, COUNT(*) AS `nb` "
             . "FROM `".self::$_db_table_contact."` "
             . "GROUP BY `domaine` "
             . "ORDER BY `nb` DESC";

        $res  = $db->queryWithFetch($sql);
        list($total, $max) = self::getTotalAndMax($res, 'nb');

        $cpt = 0;
        foreach($res as $_res) {
            $res[$cpt]['bargraph'] = self::getBarGraph($_res['nb'], $max);
            $cpt++;
        }

        $out  = array(
            'data'  => $res,
            'cols'  => array('Domaine', 'Nb', 'Graphe'),
            'keys'  => array('domaine', 'nb', 'bargraph'),
            'total' => $total,
            'max'   => $max,
        );

        return $out;
    }

    /**
     * retourne la répartition des vidéos de la base par hébergeur
     *
     * @return array
     */
    static function getRepartitionVideos()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(`id_video`) AS `nb`, `id_host` AS `host_id`"
             . "FROM `".self::$_db_table_video."` "
             . "GROUP BY `id_host` "
             . "ORDER BY COUNT(`id_video`) DESC";

        $res  = $db->queryWithFetch($sql);
        list($total, $max) = self::getTotalAndMax($res, 'nb');

        $cpt = 0;
        foreach($res as $_res) {
            $res[$cpt]['nom_hebergeur'] = Video::getHostNameByHostId($_res['host_id']);
            $res[$cpt]['bargraph']      = self::getBarGraph($_res['nb'], $max);
            $cpt++;
        }

        $out  = array(
            'data'  => $res,
            'cols'  => array('Hébergeur', 'Nb', 'Graphe'),
            'keys'  => array('nom_hebergeur', 'nb', 'bargraph'),
            'total' => $total,
            'max'   => $max,
        );

        return $out;
    }

    /**
     * retourne l'image du bargraph
     *
     * @param int valeur courant
     * @param int valeur maximum
     * @return string
     */
    static function getBarGraph($value, $max)
    {
        if(($value > 0) && ($max > 0)) {
            $width = ceil(($value / $max) * self::BARGRAPH_MAX_WIDTH);
            return "<div style=\"width: " . $width . "px; height: 10px; background: #bb0000; background-image: -moz-linear-gradient(top, #ff0000, #660000); background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #ff0000), color-stop(1, #660000));\"><div>";
        }
        return '';
    }

    /**
     * calcul du total et du max d'un tableau
     *
     * @param array $tab
     * @param strin $champ
     * @return array('total', 'max')
     */
    static function getTotalAndMax($tab, $champ)
    {
        $total = 0;
        $max = 0;

        foreach($tab as $_tab) {
            $nb = (int) $_tab[$champ];
            $total += $nb;
            if($max < $nb) {
                $max = $nb;
            }
        }

        return array($total, $max);
    }
}
