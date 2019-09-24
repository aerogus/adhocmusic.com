<?php declare(strict_types=1);

/**
 * Classe de statistiques
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
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
     * Retourne le nombre d'inscriptions membres, par jour, depuis le début
     *
     * @todo par mois et année
     *
     * @return array
     */
    static function getNbInscriptionMembreByMonth()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(`id_contact`) AS `nb`, DATE_FORMAT(`created_on`, '%Y-%m') AS `date`, UNIX_TIMESTAMP(`created_on`) * 1000 AS `ts` "
             . "FROM `".Membre::getDbTable()."` "
             . "GROUP BY DATE_FORMAT(`created_on`, '%Y-%m') "
             . "ORDER BY `created_on` ASC";

        $res  = $db->queryWithFetch($sql);
        list($total, $max) = self::getTotalAndMax($res, 'nb');

        $cpt = 0;
        foreach ($res as $_res) {
            $res[$cpt]['bargraph'] = self::getBarGraph($_res['nb'], $max);
            $cpt++;
        }

        $out  = [
            'data'  => $res,
            'cols'  => ['Date', 'Nb', 'Graphe'],
            'keys'  => ['date', 'nb', 'bargraph'],
            'total' => $total,
            'max'   => $max
        ];

        return $out;
    }

    /**
     * Retourne le nombre d'inscriptions groupes, par jour, depuis le début
     *
     * @todo par mois et année
     *
     * @return array
     */
    static function getNbInscriptionGroupeByMonth()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(`id_groupe`) AS `nb`, DATE_FORMAT(`created_on`, '%Y-%m') AS `date`, UNIX_TIMESTAMP(`created_on`) * 1000 AS `ts` "
             . "FROM `".Groupe::getDbTable()."` "
             . "GROUP BY DATE_FORMAT(`created_on`, '%Y-%m') "
             . "ORDER BY `created_on` ASC";

        $res  = $db->queryWithFetch($sql);
        list($total, $max) = self::getTotalAndMax($res, 'nb');

        $cpt = 0;
        foreach ($res as $_res) {
            $res[$cpt]['bargraph'] = self::getBarGraph($_res['nb'], $max);
            $cpt++;
        }

        $out  = [
            'data'  => $res,
            'cols'  => ['Date', 'Nb', 'Graphe'],
            'keys'  => ['date', 'nb', 'bargraph'],
            'total' => $total,
            'max'   => $max
        ];

        return $out;
    }

    /**
     * @return array
     */
    static function getTopMembresInSpinoly()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `".Membre::getDbTable()."`.`id_contact` AS `contact_id`, `".Membre::getDbTable()."`.`name` AS `membre_name`, `".Membre::getDbTable()."`.`first_name` AS `membre_first_name`, "
             . "`".Groupe::getDbTable()."`.`id_groupe` AS `groupe_id`, `".Groupe::getDbTable()."`.`name` AS `groupe_name`, "
             . "`".Event::getDbTable()."`.`id_event` AS `event_id`, `".Event::getDbTable()."`.`date` AS `event_date`, `".Event::getDbTable()."`.`name` AS `event_name` "
             . "FROM `".Membre::getDbTable()."`, `".self::$_db_table_appartient_a."`, `".Event::getDbTable()."`, `".self::$_db_table_participe_a."`, `".Groupe::getDbTable()."`, `".self::$_db_table_organise_par."` "
             . "WHERE `".Event::getDbTable()."`.`id_event` = `".self::$_db_table_organise_par."`.`id_event` "
             . "AND `".self::$_db_table_participe_a."`.`id_event` = `".Event::getDbTable()."`.`id_event` "
             . "AND `".Membre::getDbTable()."`.`id_contact` = `".self::$_db_table_apprtient_a."`.`id_contact` "
             . "AND `".self::$_db_table_apprtient_a."`.`id_groupe` = `".Groupe::getDbTable()."`.`id_groupe` "
             . "AND `".self::$_db_table_participe_a."`.`id_groupe` = `".Groupe::getDbTable()."`.`id_groupe` "
             . "AND `".self::$_db_table_organise_par."`.`id_structure` = 1 "
             . "AND `".Event::getDbTable()."`.`id_lieu` IN(1, 383, 404, 507) "
             . "ORDER BY `".Event::getDbTable()."`.`date` DESC ";

        return $db->queryWithFetch($sql);
    }

    /**
     * @return array
     */
    static function getTopGroupesInSpinoly()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `".Groupe::getDbTable()."`.`id_groupe` AS `groupe_id`, `".Groupe::getDbTable()."`.`name` AS `groupe_name`, "
             . "`".Event::getDbTable()."`.`id_event` AS `event_id`, `".Event::getDbTable()."`.`name` AS `event_name`, `".Event::getDbTable()."`.`date` AS `event_date` "
             . "FROM `".Event::getDbTable()."`, `".self::$_db_table_participe_a."`, `".Groupe::getDbTable()."`, `".self::$_db_table_organise_par."` "
             . "WHERE `".Event::getDbTable()."`.`id_event` = `".self::$_db_table_organise_par."`.`id_event` "
             . "AND `".self::$_db_table_participe_a."`.`id_event` = `".Event::getDbTable()."`.`id_event` "
             . "AND `".self::$_db_table_participe_a."`.`id_groupe` = `".Groupe::getDbTable()."`.`id_groupe` "
             . "AND `".self::$_db_table_organise_par."`.`id_structure` = 1 "
             . "AND `".Event::getDbTable()."`.`id_lieu` IN(1, 383, 404, 507) "
             . "ORDER BY `".Event::getDbTable()."`.`date` DESC ";

        return $db->queryWithFetch($sql);
    }

    /**
     * Récupère la liste des membres ayant posté le plus de dates
     *
     * @return array
     */
    static function getTopEventsSenders()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `".Membre::getDbTable()."`.`pseudo`, `".Event::getDbTable()."`.`id_contact`, COUNT(`".Event::getDbTable()."`.`id_event`) AS `nb` "
             . "FROM (`".Event::getDbTable()."`) "
             . "LEFT JOIN `".Membre::getDbTable()."` ON (`".Event::getDbTable()."`.`id_contact` = `".Membre::getDbTable()."`.`id_contact`) "
             . "GROUP BY `".Event::getDbTable()."`.`id_contact` "
             . "ORDER BY `nb` DESC "
             . "LIMIT 0, 500";

        $res  = $db->queryWithFetch($sql);
        list($total, $max) = self::getTotalAndMax($res, 'nb');

        $cpt = 0;
        foreach ($res as $_res) {
            $res[$cpt]['bargraph'] = self::getBarGraph($_res['nb'], $max);
            $res[$cpt]['profil'] = "<a href=\"/membres/".$_res['id_contact']."\">".$_res['pseudo']."</a>";
            $cpt++;
        }

        $out  = [
            'data'  => $res,
            'cols'  => ['Membre', 'Nb', 'Graphe'],
            'keys'  => ['profil', 'nb', 'bargraph'],
            'total' => $total,
            'max'   => $max
        ];

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

        $sql = "SELECT `".Membre::getDbTable()."`.`pseudo`, `".Lieu::getDbTable()."`.`id_contact`, COUNT(`".Lieu::getDbTable()."`.`id_lieu`) AS `nb` "
             . "FROM `".Lieu::getDbTable()."` "
             . "LEFT JOIN `".Membre::getDbTable()."` ON (`".Lieu::getDbTable()."`.`id_contact` = `".Membre::getDbTable()."`.`id_contact`) "
             . "GROUP BY `".Lieu::getDbTable()."`.`id_contact` "
             . "ORDER BY `nb` DESC "
             . "LIMIT 0, 500";

        $res  = $db->queryWithFetch($sql);
        list($total, $max) = self::getTotalAndMax($res, 'nb');

        $cpt = 0;
        foreach ($res as $_res) {
            $res[$cpt]['bargraph'] = self::getBarGraph($_res['nb'], $max);
            $cpt++;
        }

        $out  = [
            'data'  => $res,
            'cols'  => ['Pseudo', 'Nb', 'Graphe'],
            'keys'  => ['pseudo', 'nb', 'bargraph'],
            'total' => $total,
            'max'   => $max,
        ];

        return $out;
    }

    /**
     * Récupère la liste des lieux avec le plus d'événements liés
     *
     * @return array
     */
    static function getTopLieux()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `".Lieu::getDbTable()."`.`id_lieu`, COUNT(`".Event::getDbTable()."`.`id_lieu`) AS `nb`, `".Lieu::getDbTable()."`.`name` AS `nom_lieu` "
             . "FROM `".Event::getDbTable()."`, `".Lieu::getDbTable()."` "
             . "WHERE `".Event::getDbTable()."`.`id_lieu` = `".Lieu::getDbTable()."`.`id_lieu` "
             . "GROUP BY `".Event::getDbTable()."`.`id_lieu` "
             . "ORDER BY `nb` DESC "
             . "LIMIT 0, 500";

        $res  = $db->queryWithFetch($sql);
        list($total, $max) = self::getTotalAndMax($res, 'nb');

        $cpt = 0;
        foreach ($res as $_res) {
            $res[$cpt]['bargraph'] = self::getBarGraph($_res['nb'], $max);
            $cpt++;
        }

        $out  = [
            'data'  => $res,
            'cols'  => ['Lieu', 'Nb', 'Graphe'],
            'keys'  => ['nom_lieu', 'nb', 'bargraph'],
            'total' => $total,
            'max'   => $max,
        ];

        return $out;
    }

    /**
     * Récupère le nombre de lieux référencés par département
     *
     * @return array
     */
    static function getNbLieuxByDepartement()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_departement`, COUNT(`id_lieu`) AS `nb` "
             . "FROM `" . Lieu::getDbTable() . "` "
             . "GROUP BY `id_departement` "
             . "ORDER BY `nb` DESC";

        $rows = $db->queryWithFetch($sql);

        list($total, $max) = self::getTotalAndMax($rows, 'nb');

        $cpt = 0;
        $data = [];

        foreach ($rows as $row) {
            $data[$cpt] = $row;
            $data[$cpt]['bargraph'] = self::getBarGraph($row['nb'], $max);
            $data[$cpt]['nom_departement'] = Departement::getName($row['id_departement']);
            $cpt++;
        }

        $out = [
            'data'  => $data,
            'cols'  => ['Département', 'Nb', 'Graphe'],
            'keys'  => ['nom_departement', 'nb', 'bargraph'],
            'total' => $total,
            'max'   => $max,
        ];

        return $out;
    }

    /**
     * Récupère le nombre de lieux référencés par région
     *
     * @return array
     */
    static function getNbLieuxByRegion()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_departement`, COUNT(`id_lieu`) AS `nb` "
             . "FROM `".Lieu::getDbTable()."` "
             . "GROUP BY `id_departement` "
             . "ORDER BY `nb` DESC";

        $rows = $db->queryWithFetch($sql);

        $data = [];

        foreach ($rows as $row) {
            if ($reg = Departement::getRegion($row['id_departement'])) {
                if (array_key_exists($reg, $data)) {
                    $data[$reg]['nb'] += $row['nb'];
                } else {
                    $data[$reg] = [
                        'id_region' => $reg,
                        'nom_region' => WorldRegion::getName('FR', $reg),
                        'nb' => $row['nb'],
                    ];
                }
            }
        }

        list($total, $max) = self::getTotalAndMax($data, 'nb');

        foreach ($data as $_reg => $_data) {
            $data[$_reg]['bargraph'] = self::getBarGraph($_data['nb'], $max);
        }

        $out = [
            'data'  => $data,
            'cols'  => ['Région', 'Nb', 'Graphe'],
            'keys'  => ['nom_region', 'nb', 'bargraph'],
            'total' => $total,
            'max'   => $max,
        ];

        return $out;
    }

    /**
     * Retourne le nombre d'événements annoncés dans l'agenda, par mois
     *
     * @return array
     */
    static function getNbEventsByMonth()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT DATE_FORMAT(`date`, '%Y-%m') AS `date`, COUNT(`id_event`) AS `nb` "
             . "FROM `".Event::getDbTable()."` "
             . "GROUP BY DATE_FORMAT(`date`, '%Y-%m') "
             . "ORDER BY DATE_FORMAT(`date`, '%Y-%m') ASC";

        $res  = $db->queryWithFetch($sql);
        list($total, $max) = self::getTotalAndMax($res, 'nb');

        $cpt = 0;
        foreach ($res as $_res) {
            $res[$cpt]['bargraph'] = self::getBarGraph($_res['nb'], $max);
            $cpt++;
        }

        $out  = [
            'data'  => $res,
            'cols'  => ['Mois', 'Nb', 'Graphe'],
            'keys'  => ['date', 'nb', 'bargraph'],
            'total' => $total,
            'max'   => $max,
            ];

        return $out;
    }

    /**
     * Récupère la liste des membres ayant posté le plus de messages
     * dans les forums
     *
     * @return array
     */
    static function getTopMessagesForumsSenders()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `".Membre::getDbTable()."`.`pseudo`, `".self::$_db_table_forums."`.`created_by`, COUNT(`".self::$_db_table_forums."`.`id_message`) AS `nb` "
             . "FROM `".self::$_db_table_forums."` "
             . "LEFT JOIN `".Membre::getDbTable()."` ON (`".self::$_db_table_forums."`.`created_by` = `".Membre::getDbTable()."`.`id_contact`) "
             . "GROUP BY `".self::$_db_table_forums."`.`created_by` "
             . "ORDER BY `nb` DESC "
             . "LIMIT 0, 500";

        $res  = $db->queryWithFetch($sql);
        list($total, $max) = self::getTotalAndMax($res, 'nb');

        $cpt = 0;
        foreach ($res as $_res) {
            $res[$cpt]['bargraph'] = self::getBarGraph($_res['nb'], $max);
            $cpt++;
        }

        $out  = [
            'data'  => $res,
            'cols'  => ['Pseudo', 'Nb', 'Graphe'],
            'keys'  => ['pseudo', 'nb', 'bargraph'],
            'total' => $total,
            'max'   => $max,
        ];

        return $out;
    }

    /**
     * Récupère la liste des membres ayant posté le plus d'audios
     *
     * @return array
     */
    static function getTopAudiosSenders()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `".Membre::getDbTable()."`.`pseudo`, `".Audio::getDbTable()."`.`id_contact`, COUNT(`".Audio::getDbTable()."`.`id_audio`) AS `nb` "
             . "FROM `".Audio::getDbTable()."` "
             . "LEFT JOIN `".Membre::getDbTable()."` ON (`".Audio::getDbTable()."`.`id_contact` = `".Membre::getDbTable()."`.`id_contact`) "
             . "GROUP BY `".Audio::getDbTable()."`.`id_contact` "
             . "ORDER BY `nb` DESC "
             . "LIMIT 0, 500";

        $res  = $db->queryWithFetch($sql);
        list($total, $max) = self::getTotalAndMax($res, 'nb');

        $cpt = 0;
        foreach ($res as $_res) {
            $res[$cpt]['bargraph'] = self::getBarGraph($_res['nb'], $max);
            $cpt++;
        }

        $out  = [
            'data'  => $res,
            'cols'  => ['Pseudo', 'Nb', 'Graphe'],
            'keys'  => ['pseudo', 'nb', 'bargraph'],
            'total' => $total,
            'max'   => $max,
        ];

        return $out;
    }

    /**
     * Récupère la liste des membres ayant posté le plus de vidéos
     *
     * @return array
     */
    static function getTopVideosSenders()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `".Membre::getDbTable()."`.`pseudo`, `".Video::getDbTable()."`.`id_contact`, COUNT(`".Video::getDbTable()."`.`id_video`) AS `nb` "
             . "FROM `" . Video::getDbTable() . "` "
             . "LEFT JOIN `".Membre::getDbTable()."` ON (`".Video::getDbTable()."`.`id_contact` = `".Membre::getDbTable()."`.`id_contact`) "
             . "GROUP BY `".Video::getDbTable()."`.`id_contact` "
             . "ORDER BY `nb` DESC "
             . "LIMIT 0, 500";

        $res  = $db->queryWithFetch($sql);
        list($total, $max) = self::getTotalAndMax($res, 'nb');

        $cpt = 0;
        foreach ($res as $_res) {
            $res[$cpt]['bargraph'] = self::getBarGraph($_res['nb'], $max);
            $cpt++;
        }

        $out  = [
            'data'  => $res,
            'cols'  => ['Pseudo', 'Nb', 'Graphe'],
            'keys'  => ['pseudo', 'nb', 'bargraph'],
            'total' => $total,
            'max'   => $max,
        ];

        return $out;
    }

    /**
     * Récupère la liste des membres ayant posté le plus de photos
     *
     * @return array
     */
    static function getTopPhotosSenders()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `".Membre::getDbTable()."`.`pseudo`, `".Photo::getDbTable()."`.`id_contact`, COUNT(`".Photo::getDbTable()."`.`id_photo`) AS `nb` "
             . "FROM `".Photo::getDbTable()."` "
             . "LEFT JOIN `".Membre::getDbTable()."` ON (`".Photo::getDbTable()."`.`id_contact` = `".Membre::getDbTable()."`.`id_contact`) "
             . "GROUP BY `".Photo::getDbTable()."`.`id_contact` "
             . "ORDER BY `nb` DESC "
             . "LIMIT 0, 500";

        $res  = $db->queryWithFetch($sql);
        list($total, $max) = self::getTotalAndMax($res, 'nb');

        $cpt = 0;
        foreach ($res as $_res) {
            $res[$cpt]['bargraph'] = self::getBarGraph($_res['nb'], $max);
            $cpt++;
        }

        $out  = [
            'data'  => $res,
            'cols'  => ['Pseudo', 'Nb', 'Graphe'],
            'keys'  => ['pseudo', 'nb', 'bargraph'],
            'total' => $total,
            'max'   => $max,
        ];

        return $out;
    }

    /**
     * Récupère la liste des groupes les plus visités
     *
     * @return array
     */
    static function getTopVisitesGroupes()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_groupe`, `name` AS `nom_groupe`, `visite` AS `nb` "
             . "FROM `".Groupe::getDbTable()."` "
             . "ORDER BY `visite` DESC";

        $res  = $db->queryWithFetch($sql);
        list($total, $max) = self::getTotalAndMax($res, 'nb');

        $cpt = 0;
        foreach ($res as $_res) {
            $res[$cpt]['bargraph'] = self::getBarGraph($_res['nb'], $max);
            $cpt++;
        }

        $out  = [
            'data'  => $res,
            'cols'  => ['Groupe', 'Nb', 'Graphe'],
            'keys'  => ['nom_groupe', 'nb', 'bargraph'],
            'total' => $total,
            'max'   => $max,
        ];

        return $out;
    }

    /**
     * Récupère les derniers membres loggués sur le site
     *
     * @param int $limit
     *
     * @return array
     */
    static function getLastConnexions($limit = 10)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_contact`, `pseudo`, DATE_FORMAT(`visited_on`, '%d/%m/%Y %H:%i:%s') AS `datetime` "
             . "FROM `".Membre::getDbTable()."` "
             . "ORDER BY `visited_on` DESC "
             . "LIMIT 0, ".(int) $limit;

        $res  = $db->queryWithFetch($sql);

        $out  = [
            'data'  => $res,
            'cols'  => ['Pseudo', 'Date'],
            'keys'  => ['pseudo', 'datetime'],
            'total' => 0,
            'max'   => 0,
        ];

        return $out;
    }

    /**
     * Récupère la liste des lieux ayant le + de photos
     *
     * @param int $limit
     *
     * @return array
     */
    static function getTopPhotosLieux()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `l`.`id_lieu`, `l`.`name`, COUNT(*) AS `nb` "
             . "FROM `" . Lieu::getDbTable() . "` `l`, `" . Photo::getDbTable() . "` `p` "
             . "WHERE `l`.`id_lieu` = `p`.`id_lieu` "
             . "GROUP BY `p`.`id_lieu` "
             . "ORDER BY `nb` DESC";

        $res  = $db->queryWithFetch($sql);
        list($total, $max) = self::getTotalAndMax($res, 'nb');

        $cpt = 0;
        foreach ($res as $_res) {
            $res[$cpt]['bargraph'] = self::getBarGraph($_res['nb'], $max);
            $cpt++;
        }

        $out  = [
            'data'  => $res,
            'cols'  => ['Lieu', 'Nb', 'Graphe'],
            'keys'  => ['name', 'nb', 'bargraph'],
            'total' => $total,
            'max'   => $max,
        ];

        return $out;
    }

    /**
     * Retourne les comptes pour un nom de domaine d'email donné
     *
     * @param string $domaine
     *
     * @return array
     */
    static function getEmailsForDomaine($domaine)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_contact`, `email`, `lastnl` "
             . "FROM `" . Contact::getDbTable() . "` "
             . "WHERE `email` LIKE '%" . $db->escape($domaine) . "'";

        $res  = $db->queryWithFetch($sql);

        $out  = [
            'data'  => $res,
            'cols'  => ['id_contact', 'Email', 'Ouverture Newsletter'],
            'keys'  => ['id_contact', 'email', 'lastnl'],
            'total' => 0,
            'max'   => 0,
        ];

        return $out;
    }

    /**
     * Retourne les différents domaines présents dans la table contact
     *
     * @return array
     */
    static function getEmailsDomaines()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT SUBSTRING(`email`, INSTR(`email`,'@') + 1) AS `domaine`, COUNT(*) AS `nb` "
             . "FROM `".Contact::getDbTable()."` "
             . "GROUP BY `domaine` "
             . "ORDER BY `nb` DESC";

        $res  = $db->queryWithFetch($sql);
        list($total, $max) = self::getTotalAndMax($res, 'nb');

        $cpt = 0;
        foreach ($res as $_res) {
            $res[$cpt]['bargraph'] = self::getBarGraph($_res['nb'], $max);
            $cpt++;
        }

        $out  = [
            'data'  => $res,
            'cols'  => ['Domaine', 'Nb', 'Graphe'],
            'keys'  => ['domaine', 'nb', 'bargraph'],
            'total' => $total,
            'max'   => $max,
        ];

        return $out;
    }

    /**
     * Retourne la répartition des vidéos de la base par hébergeur
     *
     * @return array
     */
    static function getRepartitionVideos()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(`id_video`) AS `nb`, `id_host` AS `host_id`"
             . "FROM `".Video::getDbTable()."` "
             . "GROUP BY `id_host` "
             . "ORDER BY COUNT(`id_video`) DESC";

        $res  = $db->queryWithFetch($sql);
        list($total, $max) = self::getTotalAndMax($res, 'nb');

        $cpt = 0;
        foreach ($res as $_res) {
            $res[$cpt]['nom_hebergeur'] = Video::getHostNameByHostId($_res['host_id']);
            $res[$cpt]['bargraph']      = self::getBarGraph($_res['nb'], $max);
            $cpt++;
        }

        $out  = [
            'data'  => $res,
            'cols'  => ['Hébergeur', 'Nb', 'Graphe'],
            'keys'  => ['nom_hebergeur', 'nb', 'bargraph'],
            'total' => $total,
            'max'   => $max,
        ];

        return $out;
    }

    /**
     * Retourne l'image du bargraph
     *
     * @param int valeur courant
     * @param int valeur maximum
     *
     * @return string
     */
    static function getBarGraph($value, $max)
    {
        if (($value > 0) && ($max > 0)) {
            $width = ceil(($value / $max) * self::BARGRAPH_MAX_WIDTH);
            return "<div style=\"width: " . $width . "px; height: 10px; background: #bb0000; background-image: -moz-linear-gradient(top, #ff0000, #660000); background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #ff0000), color-stop(1, #660000));\"><div>";
        }
        return '';
    }

    /**
     * Calcul du total et du max d'un tableau
     *
     * @param array $tab
     * @param string $champ
     *
     * @return array ['total', 'max']
     */
    static function getTotalAndMax(array $tab, string $champ)
    {
        $total = 0;
        $max = 0;

        foreach ($tab as $_tab) {
            $nb = (int) $_tab[$champ];
            $total += $nb;
            if ($max < $nb) {
                $max = $nb;
            }
        }

        return [$total, $max];
    }
}
